<?php

require 'connecting.php';
require 'visual.php';

//$layout = $app->layout;
$grid = $layout->add('Grid');
$grid->setModel(new book($db));
$grid->addQuickSearch(['name','author']);
