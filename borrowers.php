<?php

 require 'connecting.php';
 require 'visual.php';

 $grid = $layout->add('Grid');
 $student = new Student($db);
 $student->load($_SESSION['user_id']);
 $my_borrow = $student->ref('Borrow');
 $grid->setModel($my_borrow);
 //$grid->addQuickSearch(['student_id']);
