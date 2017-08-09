<?php

require '../app.php';
$app = new LibraryAdmin();

$crud = $app->layout->add('CRUD');
$crud->setModel(new Student($app->db));
$crud->addQuickSearch(['name','surname','grade']);

$crud->addColumn('name', ['TableColumn/Link', 'page'=>'student', 'args'=>['student_id'=>'id']]);
