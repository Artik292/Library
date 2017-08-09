<?php

require 'vendor/autoload.php';

/**
 * Implements a library web application main class
 */
class Library extends \atk4\ui\App {
    public $title = 'Library';

    function init() {
        parent::init();

        session_start();
        if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
            $db = new \atk4\data\Persistence_SQL($_ENV['CLEARDB_DATABASE_URL']);
        } else {
            $db = new \atk4\data\Persistence_SQL('mysql:host=127.0.0.1;dbname=library;charset=utf8', 'root', 'root');
        }
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
        $this->hasMany('CheckOut', new CheckOut());
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
        $this->addField('date_checked_out', ['type'=>'date','required'=>true]);

        // Date when book is due to be returned
        $this->addField('date_return',['type'=>'date','required'=>'true']);

        // Will be set to true, once the book is returned
        $this->addField('returned', ['type'=>'boolean']);

        $this->hasOne('book_id', new Book())
            ->addTitle();

        $this->hasOne('student_id', new Student())
            ->addTitle();

        $this->hasOne('librarian_id', new Librarian())
            ->addTitle();
    }
}
