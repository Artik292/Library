<?php

date_default_timezone_set("Europe/Riga");

$today = date('Y-m-d');

require 'vendor/autoload.php';
require 'connecting.php';
require 'visual.php';

$students = new student($db);
$students->hasMany('Borrow', [new borrow(), 'their_field'=>'student_id']);

$layout->add(['Header', 'List of books you mast return']);

$students->load(1); //$_SESSION('user_id'));
//$layout->add(['Header', 'Borrowings for '.$students['name']]);
$borrowings = $students->ref('Borrow');
$grid = $layout->add('Grid');
$grid->setModel($borrowings, ['book', 'quantity', 'returned','date_return']);
$grid->addQuickSearch(['book', 'quantity','date_return']);

/*$students->getRef('Borrow')->addField('total_borrowed', ['aggregate'=>'sum', 'field'=>'quantity']);
//$students->addCondition('nickname', '==', '');

$students->addCondition('total_borrowed', '>', 0);

$layout->add('Table')->setModel($students, ['book_title', 'total_borrowed']); */
