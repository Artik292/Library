<?php

require 'app.php';
$app = new Library();
$app->initLayout('Centered');

// Lets show our introduction page here


$app->add(['Header', 'Welcome to Library App', 'subHeader'=>'where we demonstrate how to create multi-user application in Agile Toolkit']);

$columns = $app->add('Columns');

// Create block for existing student log-in
$c_left = $columns->addColumn()->add(['ui'=>'segment']);
$c_left->add(['Label', 'Librarian Log-in', 'gray top attached']);

$form = $c_left->add('Form');
$form->setModel(new Librarian($app->db), ['name', 'password']);

// Normally we want user to type in username and password, but this is
// a demo-app, so we will prefill the form with librarian credentials.
$form->model->tryLoadAny();
$form->buttonSave->set('Login');
$form->onSubmit(function($form) {

    if ($form->app->loginAsLibrarian($form->model['name'], $form->model['password'])) {
        return new \atk4\ui\jsExpression('document.location="librarian/"');
    } else {
        return $form->error('name', 'Incorrect login');
    }

});



$columns->addColumn()->add(['Message', 'Infromation about this App', 'small yellow'])->text
    ->addParagraph('Librarians ar the administrators. They must log-in to gain access to book '.
    'management tools as well as interface where they can check-out book for any student.')
    ->addParagraph('You may have multiple librarian accounts in the system. Every time a book '.
    'is checked out, we also create a reference to librarian who authorized that action.')
    ->addParagraph('Another common task librarians will be performing is contacting students who '.
    'have overdue books that must be returned, so we will provide them with the list.')
    ->addParagraph('After you have added some books and checked them out to some students, you may '.
    'login as a student, to see which books you have checked out and when you must return them');


$app->add(['ui'=>'divider']);





$columns = $app->add('Columns');

$c_left = $columns->addColumn()->add(['ui'=>'segment']);
$c_left->add(['Label', 'Student Log-in', 'gray top attached']);

$form = $c_left->add(['Form']);
$form->setModel(new Student($app->db), false);
$form_group = $form->addGroup(['width'=>'two']);
$form_group->addField('name');
$form_group->addField('password');


$c_right = $columns->addColumn()->add(['ui'=>'segment']);
$c_right->add(['Label', 'Search for a book', 'gray top attached']);

$form = $c_right->add(['Form']);
$form->setModel(new Book($app->db), false);
$form_group = $form->addGroup(['width'=>'two']);
$form_group->addField('name');
$form_group->addField('copies', 'Number of copies');
$form->buttonSave->set('Check copies');


