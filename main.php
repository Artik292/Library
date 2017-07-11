<?php

require 'connecting.php';
require 'visual.php';

if (isset($_SESSION['user_name'])) {
  $app->layout->add(['Message','List of books']);
}
//$layout = $app->layout;
$grid = $layout->add('Grid');
$grid->setModel(new book($db));
$grid->addQuickSearch(['name','author']);
