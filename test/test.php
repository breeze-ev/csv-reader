<?php

require '../vendor/autoload.php';


use BreezeEV\CSV\Reader;

$a = new Reader(Reader::type_with_head);
$a->setFile('12313', '123123');
$a->getContents();