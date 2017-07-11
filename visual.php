<?php

//require 'vendor/autoload.php';

use \atk4\ui\Button;

$app = new \atk4\ui\App('Library');
$app->initLayout('Admin');

$layout = $app->layout;

$layout->leftMenu->addItem(['Main page','icon'=>'building'],['main']);

if (isset($_SESSION['user_name']) and $_SESSION['user_name'] == 'admin') {
    $app->layout->add(['Message','WOOOOOORK']);
  $layout->leftMenu->addItem(['Users','icon'=>'users'],['admin']);
}

if (isset($_SESSION['user_name']) and $_SESSION['user_name'] == 'librarian') {
  $layout->leftMenu->addItem(['New book','icon'=>'add circle'],['new_book']);
}

$layout->leftMenu->addItem(['Rent book(s)','icon'=>'book'],['rent']);

$layout->leftMenu->addItem(['Borrowers','icon'=>'users'],['borrowers']);

$layout->leftMenu->addItem(['Logout','icon'=>'external'],['logout']);
