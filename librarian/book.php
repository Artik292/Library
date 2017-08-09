<?php

require '../app.php';
$app = new LibraryAdmin();

$app->layout->add('View')->set('< Back to all books')->link(['books']);
$app->layout->add(['ui'=>'divider']);

$book = new Book($app->db);
$book->load($app->stickyGet('book_id'));

$columns = $app->add('Columns');

$col = $columns->addColumn(12);

// On a left side, we display list of all non-returned check-outs
$col_seg = $col->add(['ui'=>'segment']);
$col_seg->add(['Label', 'Who have checked out this book', 'gray top attached']);
$grid = $col_seg->add(['Table', 'very basic']);
$grid->setModel(
    $book->ref('CheckOut')->setOrder('date_return')->addCondition('returned', false), 
    ['student', 'date_checked_out', 'date_return', 'librarian']
);
$grid->addColumn('student', ['TableColumn/Link', 'page'=>'student', 'args'=>['student_id']]);


$col = $columns->addColumn(4)->add(['ui'=>'segment']);
$col->add(['Label', 'Student Details', 'gray top attached']);

$form = $col->add('Form');
$form->setModel($book);

