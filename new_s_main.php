<?php

date_default_timezone_set("Europe/Riga");
$today = date('Y-m-d');

require 'vendor/autoload.php';
session_start();

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
$app->initLayout('centered');

$layout = $app->layout;

/*$grid = $layout->add('CRUD');
$grid->setModel(new borrow($db)); */

$students = new student($db);
$students->hasMany('Borrow', [new borrow(), 'their_field'=>'student_id']);
$students->load(1);     //$_SESSION('user_id'));

$layout->add(['Header', 'List of books you mast return']);

$students->getRef('Borrow')->addField('total_borrowed', ['aggregate'=>'sum', 'field'=>'quantity']);
//$students->addCondition('nickname', '==', '');

$students->addCondition('total_borrowed', '>', 0);

$layout->add('Table')->setModel($students, ['book_title', 'total_borrowed']);
