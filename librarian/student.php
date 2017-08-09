<?php

require '../app.php';
$app = new LibraryAdmin();

$app->layout->add('View')->set('< Back to all students')->link(['students']);
$app->layout->add(['ui'=>'divider']);

$student = new Student($app->db);
$student->load($app->stickyGet('student_id'));

$columns = $app->add('Columns');

$col = $columns->addColumn(12);

// On a left side, we display list of all non-returned check-outs
$col_seg = $col->add(['ui'=>'segment']);
$col_seg->add(['Label', 'Currently has checked out books', 'gray top attached']);
$grid = $col_seg->add(['Table', 'very basic']);
$grid->setModel(
    $student->ref('CheckOut')->setOrder('date_return')->addCondition('returned', false), 
    ['book', 'date_checked_out', 'date_return', 'librarian']
);
$grid->addColumn('book', ['TableColumn/Link', 'page'=>['checkout', 'student_id'=>$student->id], 'args'=>['checkout_id'=>'id']]);


// On a left side, we also display previously returned books
$col_seg = $col->add(['ui'=>'segment']);
$col_seg->add(['Label', 'Returned Books', 'gray top attached']);
$grid = $col_seg->add(['Table', 'very basic']);
$grid->setModel(
    $student->ref('CheckOut')->setOrder('date_return')->addCondition('returned', true), 
    ['book', 'date_return', 'librarian']
);


$col = $columns->addColumn(4)->add(['ui'=>'segment']);
$col->add(['Label', 'Student Details', 'gray top attached']);

$form = $col->add('Form');
$form->setModel($student);

