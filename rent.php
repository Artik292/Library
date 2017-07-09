<?php

require 'vendor/autoload.php';
require 'connecting.php';

session_start();

$app = new \atk4\ui\App('Library');
$app->initLayout('Admin');

require 'visual.php';

$form = $app->layout->add('Form');
$form->setModel(new book($db));
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
