<?php

require 'connecting.php';
require 'visual.php';

//$layout = $app->layout;
$grid = $layout->add('CRUD');
$grid->setModel(new Librarian($db));
$grid->addQuickSearch(['name','surname']);
