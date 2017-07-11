<?php

require 'connecting.php';
require 'vendor/autoload.php';
require 'LoginForm.php';

use \atk4\ui\Button;

$app = new \atk4\ui\App('Log-in');
$app->initLayout('Centered');

$app->layout->add(new LoginForm());
