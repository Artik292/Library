<?php

require '../app.php';
$app = new LibraryAdmin();

// Load data from database
$student = new Student($app->db);
$student->load($app->stickyGet('student_id'));
$checkout = $student->ref('CheckOut')->load($app->stickyGet('checkout_id'));


// Add back link
$return_url = $app->url(['student', 'student_id'=>$student->id]);

$app->layout->add('View')->set('< Back to Student '.$student['name'])->link($return_url);
$app->layout->add(['ui'=>'divider']);


if ($checkout['returned']) {
    $app->add(['Message', 'This book was already returned', 'error']);
    exit;
}


// Add ability to return book right away
$app->add(['Button', 'Return Book "'.$checkout['book'].'" Now', 'primary'])
    ->on('click', function($b) use ($checkout, $return_url) {

        $checkout->returnBook();

        return new \atk4\ui\jsExpression('document.location=[]', [$return_url]);
});

// Add ability to update return date
$app->layout->add(['ui'=>'divider']);

$form = $app->add('Form');
$form->setModel($checkout, ['date_return']);
$form->buttonSave->set('Update Return Date');
$form->onSubmit(function($form) { 
    $form->model->save();
    return $form->success('Updated');
});


