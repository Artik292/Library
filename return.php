<?PHP
require 'connecting.php';
require 'visual.php';

$mag = $app->add(['Wizard']);
$mag->buttonNext->set('Дальше');
//var_dump($mag);

$mag->addStep(['Кто возвращает','icon'=>'user'], function ($app) use($db) {
    $app->add(['Message', 'Выбирете того, кто возвращает книгу']);
    $form = $app->add('Form');
    $form->addField('name', 'Имя', ['required'=>true])->placeholder = 'Иван';
    $form->addField('surname', 'Фамилия', ['required'=>true])->placeholder = 'Иванов';
    $form->onSubmit(function ($form) use ($app,$db) {
        $someone = new Student($db);
        $someone->tryLoadBy('name',$form->model['name']);
        if ($someone['surname'] == $form->model['surname']) {
          $app->memorize('person', $someone->id);
          $someone->unload();
          $_SESSION['good'] = 'yes';
          return $app->jsNext();
        } else {
          $er = (new \atk4\ui\jsNotify('Нет такого читателя!'));
          $er->setColor('red');
          $_SESSION['good'] = 'no';
          return $er;
        }
    });
    If ($_SESSION['good'] = 'yes') {
        return $app->jsNext();
    } else {
      $er = (new \atk4\ui\jsNotify('Нет такого читателя!'));
      $er->setColor('red');
      return $er;
    }
});

// If you add a form on a step, then wizard will automatically submit that
// form on "Next" button click, performing validation and submission. You do not need
// to return any action from form's onSubmit callback. You may also use memorize()
// to store wizard-specific variables
$mag->addStep(['Что возращает', 'icon'=>'configure', 'description'=>'Database Connection String'], function ($app) use($mag,$db) {
  /*$mag->buttonPrev->set('Назад');
  $grid = $app->add('Grid');
  $someone = new Student($db);
  $someone->load($app->recall('person'));
  $bor = $someone->ref('Borrow');
  $bor->setOrder('returned');
  $grid->setModel($bor,['returned','book']); */

  $mag->buttonPrev->set('Назад');
  $col = $app->add('Columns');
  $col->addClass('stackable');
  $c1 = $col->addColumn();
  $c2 = $col->addColumn();
  $c3 = $col->addColumn();
  $c4 = $col->addColumn();
  $someone = new Student($db);
  $someone->load($app->recall('person'));
  $books = $someone->ref('Borrow');
  //$books = $book->ref('book_id');
  $books->setOrder('returned');
  $menu1 = $c1->add('Menu');
  $menu1->addClass('vertical');
  $menu2 = $c2->add('Menu');
  $menu2->addClass('vertical');
  $menu3 = $c3->add('Menu');
  $menu3->addClass('vertical');
  foreach ($books as $book_list) {
      If ($book_list['returned']) {
        $menu1->addItem('Возращена');
      } else {
        $menu1->addItem('Не возращена');
      }
      //$menu1->addItem($book_list['returned']);
      //$date = DateTime::createFromFormat('j-F-Y',($book_list['date_return']));
      //$date = date_create_from_format('j-F-Y', ($book_list['date_return']));
      //$date = strlen($book_list['date_return']);
      //$dates = new DateTime($book_list['date_return']);
      //$date = $dates->format('j-F-Y');
      echo $book_list['date_return'];
      //$menu2->addItem(strlen($book_list['date_return']));
      $menu2->addItem($date);
      $book = new Book($db);
      $book->load($book_list['book_id']);
      $menu3->addItem($book['name']);
  }
});


// Alternatvely, you may access buttonNext , buttonPrev properties of a wizard
// and set a custom js action or even set a different link. You can use recall()
// to access some values that were recorded on another steps.
/*$mag->addStep(['Select Model', 'description'=>'"Country" or "Stat"', 'icon'=>'table'], function ($app) {
    if (isset($_GET['name'])) {
        $app->memorize('model', $_GET['name']);
        header('Location: '.$app->urlNext());
        exit;
    }
    $c = $app->add('Columns');
    $mag = $c->addColumn()->add(['Grid', 'paginator'=>false, 'menu'=>false]);
    $c->addColumn()->add(['Message', 'Information', 'info'])->text
        ->addParagraph('Selecting which model you would like to import into your DSN. If corresponding table already exist, we might add extra fields into it. No tables, columns or rows will be deleted.');
    $mag->setSource(['Country', 'Stat']);
    // should work after url() fix
    $mag->addDecorator('name', ['Link', [], ['name']]);
    //$mag->addDecorator('name', ['Link', [$app->stepCallback->name=>$app->currentStep], ['name']]);
    $app->buttonNext->addClass('disabled');
});
// Steps may contain interractive elements. You can disable navigational buttons
// and enable them as you see fit. Use handy js method to trigger advancement to
// the next step.
$mag->addStep(['Migration', 'description'=>'Create or update table', 'icon'=>'database'], function ($app) {
    $c = $app->add('Console');
    $app->buttonFinish->addClass('disabled');
    $c->set(function ($c) use ($app) {
        $dsn = $app->recall('dsn');
        $model = $app->recall('model');
        $c->output('please wait');
        sleep(1);
        $c->output('connecting to "'.$dsn.'" (well not really, this is only a demo)');
        sleep(2);
        $c->output('initializing table for model "'.$model.'" (again - tricking you)');
        sleep(1);
        $c->output('DONE');
        $c->send($app->buttonFinish->js()->removeClass('disabled'));
    });
});
// calling addFinish adds a step, which will not appear in the list of steps, but
// will be displayed when you click the "Finish". Finish will not add any buttons
// because you shouldn't be able to navigate wizard back without restarting it.
// Only one finish can be added.
$mag->addFinish(function ($app) {
    $app->add(['Header', 'You are DONE', 'huge centered']);
});
 */
$mag->buttonFinish->set('Закончить');
