<?php

require 'connecting.php';
require 'visual.php';

if ($_SESSION['status'] == 'student') {
    $grid = $layout->add('Grid');
} else {
    $grid = $layout->add('CRUD');
}
$grid->setModel(new book($db));
$grid->addQuickSearch(['name','author']);
