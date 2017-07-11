<?php

require 'connecting.php';
require 'visual.php';

$grid = $layout->add('CRUD');
$grid->setModel(new book($db));
$grid->addQuickSearch(['name','author']);
