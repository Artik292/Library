<?PHP
require 'connecting.php';
require 'visual.php';

$form = $app->layout->add('Form');
$form->setModel(new Borrow($db),['book_id','quantity','student_id','date_checked_out','date_return']);
$form->buttonSave->set('Оформить');
$form->onSubmit(function($form) use($db) {
  if ($form->model['quantity'] <= 0) {
      $er = (new \atk4\ui\jsNotify('Книг должно быть положительное количество!'));
      $er->setColor('red');
      return $er;
  }
  $book = new Book($db);
  $book->load($form->model['book_id']);
  if ($form->model['quantity']>$book['total_quantity']) {
    $we_have = $book['total_quantity'];
    $book->unload();
    if ($we_have == '0') {
        $er = (new \atk4\ui\jsNotify('Таких книг в библиотеке нет.'));
    } elseif ($we_have == '1') {
        $er = (new \atk4\ui\jsNotify('Есть только 1 книга.'));
    } else {
        $er = (new \atk4\ui\jsNotify('Столько нет, есть только '.$we_have.' .'));
    }
    $er->setColor('red');
    return $er;
  }
    if ($form->model['quantity'] == $book['total_quantity']) {
      $book['total_quantity'] = 0;
    } else {
      $book['total_quantity'] = $book['total_quantity']-$form->model['quantity'];
    }
    $form->model['returned'] = FALSE;
    $form->model->save();
    $book->save();
    return new \atk4\ui\jsExpression('document.location="all_borrows.php"');

});
