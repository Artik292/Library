<?php
require 'vendor/autoload.php';
session_start();

	if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
            $db = \atk4\data\Persistence::connect($_ENV['CLEARDB_DATABASE_URL']);
        } else {
            $db = new \atk4\data\Persistence_SQL('mysql:host=127.0.0.1;dbname=mydb;charset=utf8', 'root', '');
        }

class student extends \atk4\data\Model {
	public $table = 'student';
function init() {
	parent::init();
	$this->addField('name',['required'=>'true']);
	$this->addField('surname',['required'=>'true']);
	$this->addField('grade',['required'=>'true']);
  $this->addField('password',['type'=>'password','required'=>'true']);
}
}
class book extends \atk4\data\Model {
	public $table = 'book';
function init() {
	parent::init();
	$this->addField('name',['caption'=>'Book title','required'=>'true']);
	$this->addField('author');
	$this->addField('year_published',['type'=>'date']);
  $this->addField('total_quantity',['required'=>'true']);
}
}
class librarian extends \atk4\data\Model {
	public $table = 'librarian';
function init() {
	parent::init();
	$this->addField('name',['required'=>'true']);
	$this->addField('surname',['required'=>'true']);
  $this->addField('password',['type'=>'password','required'=>'true']);
}
}
  class borrow extends \atk4\data\Model {
  	public $table = 'checkout';
  function init() {
  	parent::init();
  	$this->addField('date_checked_out',['type'=>'date','required'=>'true']);
  	$this->addField('date_return',['type'=>'date','required'=>'true']);
  	$this->addField('returned', ['type'=>'boolean']);
    	$this->addField('quantity',['required'=>'true']);
   	$this->hasOne('book_id', new book())->addTitle();
    	$this->hasOne('student_id', new student())->addTitle();
  }
}
