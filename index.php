<?php

require 'vendor/autoload.php';

use \atk4\ui\Button;

$app = new \atk4\ui\App('Registration');
$app->initLayout('Centered');

class user extends \atk4\data\Model {
	public $table = 'users';

function init() {
	parent::init();
	$this->addField('name');
  $this->addField('password', ['type'=>'password']);
}
}

$db = new \atk4\data\Persistence_SQL('mysql:host=127.0.0.1;dbname=register;charset=utf8', 'root', '');

$form = $app->layout->add('Form');
$form->setModel(new user($db));
$form->onSubmit(function($form) {
if ($form->model['name'] == '') {
  return $form->error('name',"This place can't be empty.");
};
if ($form->model['password'] == '') {
  return $form->error('password',"This place can't be empty.");
};
session_start();
$_SESSION['name'] = $form->model['name'];
return new \atk4\ui\jsExpression('document.location = "main.php" ');
});
