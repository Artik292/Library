<?php
require '../app.php';

// No interface on this page, simply initialize the app, logout librarian and redirect to parent folder's index.php file.
$app = new Library();
$app->logoutLibrarian();

header('Location: ..');
