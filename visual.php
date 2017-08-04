<?php

//require 'vendor/autoload.php';

if ((!isset($_SESSION['status']))) {
  header('Location: logout.php');
}

use \atk4\ui\Button;

$app = new \atk4\ui\App('Library');
$app->initLayout('Admin');

$layout = $app->layout;

$layout->leftMenu->addItem(['Main page','icon'=>'building'],['main']);

if ($_SESSION['status'] == 'librarian') {

  $layout->leftMenu->addItem(['Users','icon'=>'users'],['admin']);

  $layout->leftMenu->addItem(['Rent book(s)','icon'=>'book'],['rent']);

  $layout->leftMenu->addItem(['Borrowers','icon'=>'users'],['borrowers']);
} else {

  $layout->leftMenu->addItem(['My loans','icon'=>'book'],['new_s_main']);
}

  $layout->leftMenu->addItem(['Logout','icon'=>'external'],['logout']);
