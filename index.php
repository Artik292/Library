<?php

require 'connecting.php';

use \atk4\ui\Button;

$app = new \atk4\ui\App('Библиотека имени Ленина');
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

/*
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
*/

$someone = new Student($db);
$form = $app->layout->add('Form');
$form->setModel(new Student($db));
$form->buttonSave->set('Вход');
$form->onSubmit(function($form) use ($someone) {
  //$form->model['nick_name']
  //$someone = $form->model->tryLoadBy('nick_name','fiqegqdj0[wqdw]');
  $someone->tryLoadBy('name',$form->model['name']);
  if ($someone['surname'] == $form->model['surname']){
    if ($someone['password'] == $form->model['password']) {
      $_SESSION['user_id'] = $someone->id;
      $_SESSION['status'] = 'student';
      return new \atk4\ui\jsExpression('document.location="main.php"');
    } else {
      $someone->unload();
      $er = (new \atk4\ui\jsNotify('No such user.'));
      $er->setColor('red');
      return $er;
    }
  } else {
    $someone->unload();
    $er = (new \atk4\ui\jsNotify('No such user.'));
    $er->setColor('red');
    return $er;
  }
});

$app->add(['ui'=>'divider']);

$app->add(['Button','Для библиотекарей','iconRight'=>'address card','inverted red'])->link(['lib_login']);
