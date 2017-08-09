<?php

require 'vendor/autoload.php';

/**
 * Implements a library web application main class
 */
class Library extends \atk4\ui\App {

    public $logged_librarian = null;
    public $logged_student = null;
    public $cdn = [
        'atk'             => 'https://cdn.rawgit.com/atk4/ui/1.1.10/public',
        'jquery'          => 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1',
        'serialize-object'=> 'https://cdnjs.cloudflare.com/ajax/libs/jquery-serialize-object/2.5.0',
        'semantic-ui'     => 'https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.10',
        'calendar'        => 'https://cdn.rawgit.com/mdehoog/Semantic-UI-Calendar/0.0.8/dist',
    ];

    function __construct() {
        parent::__construct('Library');

        if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
            $this->db = new \atk4\data\Persistence_SQL($_ENV['CLEARDB_DATABASE_URL']);
        } else {
            $this->db = new \atk4\data\Persistence_SQL('mysql:host=127.0.0.1;dbname=library;charset=utf8', 'root', 'root');
        }

        session_start();
        if (isset($_SESSION['logged_librarian_id'])) {
            $this->logged_librarian = new Librarian($this->db);
            $this->logged_librarian->load($_SESSION['logged_librarian_id']);
        }

        if (isset($_SESSION['logged_student_id'])) {
            $this->logged_student = new Librarian($this->db);
            $this->logged_student->load($_SESSION['logged_student_id']);
        }

    }


    function loginAsLibrarian($name, $password) {
        $m = new Librarian($this->db);
        $m->tryLoadBy('name', $name);

        // Incorrect password for this librarian
        if ($m['password'] != $password) {
            return false;
        }

        // Login successful. Let's store ID in session
        $this->logged_librarian = $m;
        $_SESSION['logged_librarian_id'] = $m->id;
        return true;
    }

    function logoutLibrarian() {
        unset($_SESSION['logged_librarian_id']);
    }

    function loginAsStudent($name, $password) {
        $m = new Student($this->db);
        $m->tryLoadBy('name', $name);

        // Incorrect password for this librarian
        if ($m['password'] != $password) {
            return false;
        }

        // Login successful. Let's store ID in session
        $this->logged_student = $m;
        $_SESSION['logged_student_id'] = $m->id;
    }

    function logoutSTudent() {
        unset($_SESSION['logged_student_id']);
    }
}

/**
 * Extend our basic application to include administrator interface
 */
class LibraryAdmin extends Library {
    function __construct() {
        parent::__construct();

        if (!$this->logged_librarian) {
            throw new Exception('Must be logged as librarian to use admin');
        }

        $this->initLayout('Admin');

        $this->layout->menuRight->addItem('Logged as librarian '.$this->logged_librarian['name']);
        $this->layout->menuRight->addItem('logout', ['logout']);

        // Admin system needs a menu
        $this->layout->leftMenu->addItem(['Dashboard','icon'=>'dashboard'],['index']);
        $this->layout->leftMenu->addItem(['Students','icon'=>'users'],['students']);
        $this->layout->leftMenu->addItem(['All Books','icon'=>'book'],['books']);
    }
}

/**
 * Describes school student who will be allowed to check out books from the library.
 */
class Student extends \atk4\data\Model {
    public $table = 'student';

    function init() {
        parent::init();

        // Declaration of basic fields
        $this->addField('name', ['required'=>true]);
        $this->addField('grade', ['required'=>true]);
        $this->addField('password', ['type'=>'password', 'required'=>true]);

        // Referencing all the check outs students have made
        $this->hasMany('CheckOut', new CheckOut());
    }
}

class Book extends \atk4\data\Model {
    public $table = 'book';

    function init() {
        parent::init();
        $this->addField('name', ['caption'=>'Book title', 'required'=>true]);
        $this->addField('author');
        $this->addField('year_published', ['type'=>'date']);

        // How many book copies this Library owns?
        $this->addField('total_quantity', ['required'=>true]);

        // Referencing all the check outs of this book
        $this->hasMany('CheckOut', new CheckOut())
            ->addField('checked_out', ['aggregate'=>'count', 'field'=>false]);

        $this->addExpression('available', '[total_quantity] - [checked_out]');
    }
}

class Librarian extends \atk4\data\Model {
    public $table = 'librarian';

    function init() {
        parent::init();
        $this->addField('name', ['required'=>true]);
        $this->addField('surname', ['required'=>true]);
        $this->addField('password', ['type'=>'password','required'=>true]);

        // Referencing all the check outs authorized by this librarian
        $this->hasMany('CheckOut', new CheckOut());
    }
}

class CheckOut extends \atk4\data\Model {
    public $table = 'checkout';

    function init() {
        parent::init();

        // Date when the book was checked out from the library
        $this->addField('date_checked_out', ['type'=>'date','required'=>true, 'default'=>new \DateTime()]);

        // Date when book is due to be returned
        $this->addField('date_return',['caption'=>'Return Due', 'type'=>'date','required'=>true, 'default'=>new \DateTime('+1 month')]);

        // Will be set to true, once the book is returned
        $this->addField('returned', ['type'=>'boolean', 'default'=>true]);

        $this->hasOne('book_id', new Book())
            ->addTitle();

        $this->hasOne('student_id', new Student())
            ->addTitle();

        $this->hasOne('librarian_id', new Librarian())
            ->addTitle();
    }

    function returnBook() {
        $this['returned'] = true;
        $this['date_return'] = new DateTime();   // set to today
        $this->save();
    }
}
