<?php

require '../app.php';
$app = new LibraryAdmin();

$crud = $app->layout->add('CRUD');
$crud->setModel(new Book($app->db));
$crud->addQuickSearch(['name','author']);

$crud->addColumn('name', ['TableColumn/Link', 'page'=>'book', 'args'=>['book_id'=>'id']]);
