<?php

 require 'connecting.php';
 require 'visual.php';

 $grid = $layout->add('CRUD');
 $grid->setModel(new borrow($db));
 $grid->addQuickSearch(['student','book']);
