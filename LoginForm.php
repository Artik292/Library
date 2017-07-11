<?php
require 'vendor/autoload.php';
//require 'connecting.php';
/**
 * Component implementing our log-in form
 */

 class student extends \atk4\data\Model {
     public $table = 'student';
     //public $title_field = 'name';
     function init()
     {
         parent::init();
         $this->addField('name');
         $this->addField('surname');
       	 $this->addField('grade');
         $this->addField('password',['type'=>'password']);
     }
 }

class LoginForm extends \atk4\ui\Form
{
    function init() {
        parent::init();
        $this->setModel(clone $this->app->student, ['name', 'password']);
        $this->onSubmit(function($form) {
            $this->app->user->tryLoadBy('name', $form->model['name']);
            if ($this->app->user['password'] == $form->model['password']) {
                // Auth successful!
                $_SESSION['user_id'] = $this->app->user->id;

                return new \atk4\ui\jsExpression('document.location="main.php"');
            } else {
                $this->app->user->unload();
                return $form->error('password', 'No such user');
            }
        });
    }
}
