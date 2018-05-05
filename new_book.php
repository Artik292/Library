<?php

require 'connecting.php';
require 'visual.php';

$book = new book($db);
$book->setOrder('name');
$grid = $layout->add('CRUD');
$grid->setModel($book);
$grid->addQuickSearch(['name','author']);
