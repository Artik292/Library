<?php

require 'connecting.php';
require 'visual.php';

$layout->add(['Message', 'Showing how to do calculations, see file `romans.php` for comments']);


$layout->add(['Header', 'Calculating some totals']);

// Models allow us to create "actions" which is defined as operation across multiple records.
// The simplest example is simply counting how many different book titles we have in the
// library.


$unique_book_titles = (new book($db))
    ->action('count');

// Now that we have this count, we can execute it, which will retrieve value form the server:


$layout->add(['Label', 'Total unique books: ', 'detail'=>$unique_book_titles->getOne()]);

// We can also calculate different formulas, lets see what's the total exemplars of books 
// are in the library.

$total_copies_available = (new book($db))
    ->action('fx', ['sum', 'total_quantity']);


// It appears Agile UI has a bug where detail=0 is not displaying. I'll check it out,
//https://github.com/atk4/ui/issues/198

$layout->add(['Label', 'Books available to rent: ', 'detail'=>$total_copies_available->getOne()]);

// Next lets show students and how many books they have borrowed. 


$students = new student($db); 

// I can add some fields here, btw, but copy them into init() to make permanent.

// $students->hasMany('Borrow', new borrow());
//
// The above line didn't work, because of table name missmatch. Normally Agile Data
// assumes that if $students->table == 'students' then borrow's field will be
// called 'students_id', but you call it 'student_id'. A best practice is to always
// use "singular" - student, book, borrow if the record in database describes a
// single object. If your table is called 'students' that would mean that each record
// in the table describes group of students!

$students->hasMany('Borrow', [new borrow(), 'their_field'=>'student_id']);

// Now object $student has reference called 'Borrow'. The reference good for few things.
// First you can traverse it!

$students->load(24); // load any students
$layout->add(['Header', 'Borrowings for '.$students['name']]);
$borrowings = $students->ref('Borrow');
$layout->add('Table')->setModel($borrowings, ['book', 'quantity', 'returned']);

// We can access our "reference" by executing getRef. Reference has a method 'addField'
// which allows us to create aggregate fields

$students->getRef('Borrow')->addField('total_borrowed', ['aggregate'=>'sum', 'field'=>'quantity']);

// this actually affects $student object, so we can go back to it and list all students who have
// borrowings


$layout->add(['Header', 'Students who have borrowed something']);
$students->addCondition('total_borrowed', '>', 0);
$layout->add('Table')->setModel($students, ['name', 'total_borrowed']);

// Those numbers actually include returned books also. So how do we calculate books that are currently
// rented? First thing you must create is new relation! Because formulas always traverse relations
// to get values. 

// borrow which is NOT returned yet!
class rented extends borrow {
    function init() {
        parent::init();
        $this->addCondition('returned', false);
    }
}

// now class rented is a special type of borrow which wasn't returned. We can say that student
// is related to this entity also. 

$students->hasMany('OnHand', [new rented(), 'their_field'=>'student_id'])
    ->addField('not_returned', ['aggregate'=>'sum', 'field'=>'quantity']);


$layout->add(['Header', 'Same table but showing how much is still not retutrned']);
$students->addCondition('total_borrowed', '>', 0);
$layout->add('Table')->setModel($students, ['name', 'total_borrowed', 'not_returned']);
