<?php

require 'vendor/autoload.php';
require 'connecting.php';


$app = new \atk4\ui\App('Registration');
$app->initLayout('Centered');

$layout = $app->layout;
$grid = $layout->add('CRUD');
$grid->setModel(new book($db));
