<?php

require 'vendor/autoload.php';

if (isset($_ENV['CLEARDB_DATABASE_URL'])) {
    preg_match('|([a-z]+)://([^:]*)(:(.*))?@([A-Za-z0-9\.-]*)(/([0-9a-zA-Z_/\.]*))|',
        $_ENV['CLEARDB_DATABASE_URL'],$matches);
    $dsn=array(
        $matches[1].':host='.$matches[5].';dbname='.$matches[7],
        $matches[2],
        $matches[4]
    );
    $db = new \atk4\data\Persistence_SQL($dsn[0].';charset=utf8', $dsn[1], $dsn[2]);
} else {
    $db = new \atk4\db\Persistence::connect('mysql://user:pass@localhost/main');
    //$db = new \atk4\data\Persistence_SQL('mysql:host=127.0.0.1;dbname=register;charset=utf8', 'root', '');
}

/* class user extends \atk4\data\Model {
	public $table = 'users';

function init() {
	parent::init();
	$this->addField('name');
	$this->addField('surname');
	$this->addField('phone_number');
  $this->addField('email');
  $this->addField('password', ['type'=>'password']);
  $this->addField('feedback',['enum'=>[1=>'answer',0=>"didn't answer"]]);
}
}

class place extends \atk4\data\Model {
	public $table = 'places';

function init() {
	parent::init();
	$this->addField('country');
	$this->addField('city');
	$this->addField('departure_date',['type'=>'date']);
  $this->addField('arrival_date',['type'=>'date']);
  $this->addField('cost', ['type'=>'money']);
  $this->addField('free_space',['enum'=>['yes','no']]);
}
} */
