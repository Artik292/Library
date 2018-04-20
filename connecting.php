<?php
require 'vendor/autoload.php';
session_start();

	if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
            $db = \atk4\data\Persistence::connect($_ENV['CLEARDB_DATABASE_URL']);
        } else {
            $db = new \atk4\data\Persistence_SQL('mysql:host=127.0.0.1;dbname=main;charset=utf8', 'root', '');
        }

class Student extends \atk4\data\Model {
	public $table = 'student';
function init() {
	parent::init();
	$this->addField('name',['caption'=>'Имя','required'=>'true']);
	$this->addField('surname',['caption'=>'Фамилия','required'=>'true']);
	$this->addField('grade',['caption'=>'Класс','required'=>'true']);
  $this->addField('password',['caption'=>'Пароль','type'=>'password','required'=>'true']);
	$this->hasMany('Borrow', new Borrow);
}
}
class Book extends \atk4\data\Model {
	public $table = 'book';
function init() {
	parent::init();
	$this->addField('name',['caption'=>'Название книги','required'=>'true']);
	$this->addField('author',['caption'=>'Автор']);
	$this->addField('year_published',['caption'=>'Год выпуска','type'=>'date']);
  $this->addField('total_quantity',['caption'=>'Количество']);
	$this->hasMany('Borrow', new Borrow);
}
}
class Librarian extends \atk4\data\Model {
	public $table = 'librarian';
function init() {
	parent::init();
	$this->addField('name',['caption'=>'Имя','required'=>'true']);
	$this->addField('surname',['caption'=>'Фамилия','required'=>'true']);
  $this->addField('password',['caption'=>'Пароль','type'=>'password','required'=>'true']);
}
}
  class Borrow extends \atk4\data\Model {
  	public $table = 'checkout';
  function init() {
  	parent::init();
  	$this->addField('date_checked_out',['caption'=>'Дата выдачи','type'=>'date','required'=>'true']);
  	$this->addField('date_return',['caption'=>'Дата возврата','type'=>'date','required'=>'true']);
  	$this->addField('returned', ['caption'=>'Возвращено','type'=>'boolean']);
	    $this->addField('quantity',['caption'=>'Количество','required'=>'true']);
   	$this->hasOne('book_id', new Book())->addTitle();
    $this->hasOne('student_id', new Student())->addTitle();
  }
}
