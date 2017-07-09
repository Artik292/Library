<?php

require 'vendor/autoload.php';
require 'connecting.php';

session_start();

$app = new \atk4\ui\App('Library');
$app->initLayout('admin');

require 'visual.php';

$app->layout->add(['Message','Hello ' . $_SESSION['user_name']]);

$app->layout->add(['Message','List of books']);

//$layout = $app->layout;
$grid = $layout->add('GRID');
$grid->setModel(new book($db));
$grid->addQuickSearch(['book_title','author']);
