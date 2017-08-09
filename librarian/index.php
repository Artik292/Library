<?php

require '../app.php';
$app = new LibraryAdmin();


$columns = $app->add('Columns');

$col = $columns->addColumn(6);

$col_seg = $col->add(['ui'=>'segment']);
$col_seg->add(['Label', 'Register new book checkout', 'gray top attached']);

$form = $col_seg->add('Form');
$form->setModel(new CheckOut($app->db), ['book_id', 'student_id', 'date_return']);
$form->buttonSave->set('Register Checkout');
$form->onSubmit(function($form) {
    $form->model['librarian_id'] = $form->app->logged_librarian->id;
    $form->model->save();

    return $form->success('Book have been checked out. There are '.$form->model->ref('book_id')['available'].' copies left');
});


$col = $columns->addColumn(10);

$col_seg = $col->add(['ui'=>'segment']);
$col_seg->add(['Label', 'Overdue books. Contact those students to remind', 'gray top attached']);

$overdue = new CheckOut($app->db);
$overdue->addCondition('date_return', '<', new \DateTime());

$grid = $col_seg->add('Table');
$grid->setModel($overdue, ['book', 'student', 'student_contact', 'date_return']);

$grid->addColumn('book', ['TableColumn/Link', 'page'=>'checkout', 'args'=>['checkout_id'=>'id', 'student_id']]);
$grid->addColumn('student', ['TableColumn/Link', 'page'=>'student', 'args'=>['student_id']]);

