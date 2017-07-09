<?php

require 'vendor/autoload.php';
require 'connecting.php';

session_start();

$app = new \atk4\ui\App('Library');
$app->initLayout('Admin');

require 'visual.php';
