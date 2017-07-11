<?php

 require 'connecting.php';
 require 'visual.php';

 $grid = $layout->add('Grid');
 $grid->setModel(new borrow($db));
 //$grid->addQuickSearch(['name','author']);
