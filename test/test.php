<?php

require '../vendor/autoload.php';


use BreezeEV\CSV\Reader;

$a = new Reader(Reader::FIRST_LINE_NULL);

$a->setFile('abc_abc_abc.txt', 'abc.txt');
$a->setRules([
    'name' => [
        0 => 'title',
        1 => 'content'
    ]
]);
$b = $a->getFileNameData();

print_r($b);