<?php

require 'connecting.php';
require 'visual.php';

$grid = $layout->add('CRUD');
$grid->setModel(new student($db));
$grid->addQuickSearch(['name','surname','grade']);
