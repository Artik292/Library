<?php

require 'vendor/autoload.php';
require 'connecting.php';

use \atk4\ui\Button;

$app = new \atk4\ui\App('Registration');
$app->initLayout('Centered');

/* class student extends \atk4\data\Model {
	public $table = 'students';

function init() {
	parent::init();
	$this->addField('name');
  $this->addField('surname');
  $this->addField('grade');
  $this->addField('password', ['type'=>'password']);
}
}

$db = new \atk4\data\Persistence_SQL('mysql:host=127.0.0.1;dbname=mydb;charset=utf8', 'root', ''); */

/*$button = new Button();
$button->set('Log in');
$button->set(['primary'=>true]);
$button->set(['size big'=>true]);
$button->link('login.php');
$app->add($button); */

$form = $app->layout->add('Form');
$form->setModel(new student($db));
$form->onSubmit(function($form) {
  
$_SESSION['name'] = $form->model['name'];

if ($form->model['name'] == 'librarian') {
  $_SESSION['status'] = 'librarian';
} elseif ($form->model['name'] == 'admin') {
  $_SESSION['status'] = 'admin';
} else {
  $_SESSION['status'] = 'student';
}

$form->model->save();
return new \atk4\ui\jsExpression('document.location = "main.php" ');
});
