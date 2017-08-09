<?php

require '../app.php';
$app = new LibraryAdmin();

$grid = $app->layout->add('CRUD');
$grid->setModel(new student($app->db));
$grid->addQuickSearch(['name','surname','grade']);
