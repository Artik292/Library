<?php

require 'vendor/autoload.php';

/*session_start();
if ((!isset($_SESSION['user_id']))) {
  header('Location: logout.php');
} */

if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
    preg_match('|([a-z]+)://([^:]*)(:(.*))?@([A-Za-z0-9\.-]*)(/([0-9a-zA-Z_/\.]*))|',
        $_ENV['CLEARDB_DATABASE_URL'],$matches);
    $dsn=array(
        $matches[1].':host='.$matches[5].';dbname='.$matches[7],
        $matches[2],
        $matches[4]
    );
    $db = new \atk4\data\Persistence_SQL($dsn[0].';charset=utf8', $dsn[1], $dsn[2]);
} else {
    $db = new \atk4\data\Persistence_SQL('mysql:host=127.0.0.1;dbname=mydb;charset=utf8', 'root', '');
}

class student extends \atk4\data\Model {
	public $table = 'student';

  public $login_field = 'nickname';
  public $password_field = 'password';
  public $title_field = 'name';
function init() {
	parent::init();
	$this->addField('name',['required'=>'true']);
	$this->addField('surname',['required'=>'true']);
	$this->addField('grade',['required'=>'true']);
  $this->addField('nickname');
  $this->addField('password',['type'=>'password','required'=>'true']);
}
}
class book extends \atk4\data\Model {
	public $table = 'book';
  public $title_field = 'book_title';
  public $tible_name = 'book_title';
function init() {
	parent::init();
	$this->addField('book_title');
	$this->addField('author');
	$this->addField('year_published',['type'=>'date']);
  $this->addField('total_quantity');
}
}

  class borrow extends \atk4\data\Model {
  	public $table = 'borrow';
  function init() {
  	parent::init();
  	$this->addField('date_loan',['type'=>'date']);
  	$this->addField('date_return',['type'=>'date']);
    $this->addField('returned', ['type'=>'boolean']);
    $this->addField('quantity');
    $this->hasOne('book_id', new book())->addTitle();
    $this->hasOne('student_id', new student())->addTitle();
  }
}

$app = new \atk4\ui\App('Library');
$app->initLayout('Admin');

$layout = $app->layout;

$layout->leftMenu->addItem(['List of books','icon'=>'book'],['new_l_book']);
$layout->leftMenu->addItem(['List of students','icon'=>'users'],['new_l_student']);
$layout->leftMenu->addItem(['List of borrows','icon'=>'browser'],['new_l_borrow']);
$layout->leftMenu->addItem(['Rent book(s)','icon'=>'external'],['rent']);

$form = $app->layout->add('Form');
$form->setModel(new borrow($db));
$form->onSubmit(function($form) {
$form->model->save();
return new \atk4\ui\jsExpression('document.location = "main.php" ');
});
