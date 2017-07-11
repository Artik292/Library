<?php

require 'vendor/autoload.php';
require 'connecting.php';

session_start();

$app = new \atk4\ui\App('Library');
$app->initLayout('Admin');

require 'visual.php';

$form = $app->layout->add('Form');
$form->setModel(new borrow($db));
$form->onSubmit(function($form) {
$form->model->save();
return new \atk4\ui\jsExpression('document.location = "main.php" ');
});
