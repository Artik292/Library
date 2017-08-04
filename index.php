<?php

require 'connecting.php';
require 'vendor/autoload.php';
//require 'LoginForm.php';

use \atk4\ui\Button;

$app = new \atk4\ui\App('Log-in');
$app->initLayout('Centered');

//$app->layout->add(new LoginForm());

/*$app->auth = $app->add(new \atk4\login\Auth(new \atk4\login\student($app->db)));
$app->auth->setUp(); // just run once */




/*$form = $app->layout->add('Form');
$form->setModel(new student($db));
$form->onSubmit(function($form) {

        $form->student->tryLoadBy('name', $form->model['name']);
             if ($form->student['password'] == $form->model['password']) {
                 // Auth successful!
                 $_SESSION['user_id'] = $form->student->id;

                 return new \atk4\ui\jsExpression('document.location="dashboard.php"');
             } else {
                 $form->student->unload();
                 return $form->error('password', 'No such user');
             }

return new \atk4\ui\jsExpression('document.location = "main.php" ');
}); */

$form = $app->layout->add('Form');
$form->setModel(new student($db));
$form->onSubmit(function($form) {

  if ($form->model['name'] == 'librarian') {
    $_SESSION['status'] = 'librarian';
  } else {
    $_SESSION['status'] = 'student';
  }

return new \atk4\ui\jsExpression('document.location = "main.php" ');
});
