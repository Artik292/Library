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

$form = $app->layout->add('Form');
$form->setModel(new student($db));
$form->onSubmit(function($form) {
if ($form->model['name'] == '') {
  return $form->error('name',"This place can't be empty.");
};
if ($form->model['password'] == '') {
  return $form->error('password',"This place can't be empty.");
};
session_start();
$_SESSION['name'] = $form->model['name'];
$form->model->save();
return new \atk4\ui\jsExpression('document.location = "main.php" ');
});
