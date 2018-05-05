<?php

//require 'vendor/autoload.php';

if ((!isset($_SESSION['status']))) {
  header('Location: logout.php');
}

use \atk4\ui\Button;

$app = new \atk4\ui\App('Библиотека имени Ленина');
$app->initLayout('Admin');

$layout = $app->layout;

if ($_SESSION['status'] == 'admin') {
  $layout->leftMenu->addItem(['Главная страница','icon'=>'plus square'],['main_lib']);
  $layout->leftMenu->addItem(['Возврат книги','icon'=>'calendar alternate'],['return']);
  $layout->leftMenu->addItem(['Читатели','icon'=>'users'],['admin']);
  $layout->leftMenu->addItem(['Библиотекари','icon'=>'address card'],['list_lib']);
  $layout->leftMenu->addItem(['Книги','icon'=>'add circle'],['new_book']);
  $layout->leftMenu->addItem(['Взятые книги','icon'=>'book'],['all_borrows']);
} else {
  $layout->leftMenu->addItem(['Книги','icon'=>'building'],['main']);
  $layout->leftMenu->addItem(['Мои книги','icon'=>'users'],['borrowers']);
}


//$layout->leftMenu->addItem(['Rent book(s)','icon'=>'book'],['rent']);



$layout->leftMenu->addItem(['Выход','icon'=>'external'],['logout']);

//$layout->leftMenu->addItem(['test','icon'=>'external'],['time']);
