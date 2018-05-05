<?php

require 'connecting.php';
require 'visual.php';

$borrow = new Borrow($db);
$borrow->setOrder('date_return',TRUE);
$borrow->setOrder('returned');
$grid = $layout->add('CRUD');
$grid->setModel($borrow);
