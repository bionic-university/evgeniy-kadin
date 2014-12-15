<?php
use TestApp\Entity;
require __DIR__.'/../vendor/autoload.php';
$app = new Silex\Application();
$app['debug'] = true;

require('../src/registers.php');
$em = $app['db.orm.em'];
$books = $app['db.orm.em']->getRepository('BookApp\Entity\Book')->findAll();
$result = array();
foreach($books as $book){
    $result[] = $book->getIndexData();
}
file_put_contents('../src/data/index.json', json_encode($result, true));