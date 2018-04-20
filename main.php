<?php

require 'connecting.php';
require 'visual.php';

//$layout = $app->layout;
$grid = $layout->add('Grid');
$grid->setModel(new Book($db));
$grid->addQuickSearch(['name','author']);
