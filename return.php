<?PHP
require 'connecting.php';
require 'visual.php';

$mag = $app->add(['Wizard']);
$mag->buttonNext->set('Дальше');

$mag->addStep('Кто возвращает', function ($app) use($db) {
    $app->add(['Message', 'Выбирете того, кто возвращает книгу']);
    $form = $app->add('Form');
    $form->addField('name', 'Имя', ['required'=>true])->placeholder = 'Иван';
    $form->addField('surname', 'Фамилия', ['required'=>true])->placeholder = 'Иванов';
    $form->onSubmit(function ($form) use ($app,$db) {
        $someone = new Student($db);
        $someone->tryLoadBy('name',$form->model['name']);
        if ($someone('surname') == $form->model['surname']) {
          $app->memorize('person', $someone->id);
          $someone-unload();
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
$mag->addStep(['Set DSN', 'icon'=>'configure', 'description'=>'Database Connection String'], function ($app) {
    $f = $app->add('Form');
    $f->addField('dsn', 'Connect DSN', ['required'=>true])->placeholder = 'mysql://user:pass@db-host.example.com/mydb';
    $f->onSubmit(function ($f) use ($app) {
        $app->memorize('dsn', $f->model['dsn']);
        return $app->jsNext();
    });
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
