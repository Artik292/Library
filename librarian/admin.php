<?php

require '../app.php';
$app = new LibraryAdmin();

$crud = $app->layout->add('CRUD');
$crud->setModel(new Librarian($app->db));
$crud->addQuickSearch(['name']);
