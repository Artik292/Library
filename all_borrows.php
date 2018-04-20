<?php

require 'connecting.php';
require 'visual.php';

$borrow = new Borrow($db);
$borrow->setOrder(['returned','date_return']);
$grid = $layout->add('CRUD');
$grid->setModel($borrow);
