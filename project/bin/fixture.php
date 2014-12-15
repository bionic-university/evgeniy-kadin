<?php
use TestApp\Entity;
require __DIR__.'/../vendor/autoload.php';
$app = new Silex\Application();
$app['debug'] = true;

require('../src/registers.php');
$em = $app['db.orm.em'];
//1)Need truncate all tables
truncateTable("Category", $em);
truncateTable("Author", $em);
truncateTable("Book", $em);
truncateTable("BookIsbn", $em);
truncateRelatedTable("author_book", $em);
//2) Create parent
$parentCategory = new Entity\Category();
$parentCategory->setUdc('parent');
$parentCategory->setName('Parent Category');
$em->persist($parentCategory);
$em->flush();
//3) create child
$childCategory = new Entity\Category();
$childCategory->setName('Test');
$childCategory->setUdc('0001');
$childCategory->setParent($parentCategory);
$em->persist($childCategory);
$em->flush();

$childCategory = new Entity\Category();
$childCategory->setName('Test 2');
$childCategory->setUdc('0002');
$childCategory->setParent($parentCategory);
$em->persist($childCategory);
$em->flush();

// 4) Create Authors
createAuthors(100, $em);
createBooks(100, $em);
/*


//2) create category parent category
$category = new Entity\Category();
$category->


$faker = Faker\Factory::create();
$author = new \BookApp\Entity\Author();
$author->setName($faker->name);
$author->setBio($faker->text);


$book = new Entity\Book();
$book->setTitle($faker->sentence);
$em->persist($author);
$em->flush($author);
echo $faker->name;

*/
function truncateTable($entityName, $em)
{
    $cmd = $em->getClassMetadata('BookApp\Entity\\'.$entityName);
    truncate($cmd->getTableName(), $em);
}

function truncateRelatedTable($tableName, $em){
    truncate($tableName, $em);
}

function truncate($table, $em){
    $connection = $em->getConnection();
    $dbPlatform = $connection->getDatabasePlatform();
    $connection->beginTransaction();
    try {
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($table);
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');
        $connection->commit();
    }
    catch (\Exception $e) {
        $connection->rollback();
    }
}

function createAuthors($count, $em){
    $faker = Faker\Factory::create();
    for($i = 0; $i<$count; $i++){
        $author  = new Entity\Author();
        $author->setName($faker->name);
        $author->setBio($faker->text);
        $em->persist($author);
        $em->flush();
    }
}

function createBooks($count, $em){
    $fakerCategories = [
        'abstract',
        'city',
        'people',
        'transport',
        'animals',
        'food',
        'nature',
        'business',
        'nightlife',
        'sports',
        'cats',
        'fashion',
        'technics'
    ];
    $faker = Faker\Factory::create();
    for($i = 0; $i<$count; $i++){
        $book = new Entity\Book();
        $book->setTitle($faker->sentence);
        $category = $em->find('BookApp\Entity\Category', 2);
        $book->setCategory($category);
        $book->setPagesCount($faker->randomNumber(3));
        //get author
        $author = $em->find('BookApp\Entity\Author', 1);
        $book->addAuthor($author);
        $book->setAnnotation($faker->paragraph());
        $isbn = new Entity\BookIsbn();
        $isbn->setIsbn($faker->ean13);
        $book->addIsbn($isbn);
        $book->setCover($faker->imageUrl(640, 480, $fakerCategories[mt_rand(0, count($fakerCategories)-1)]));
        $em->persist($book);
        $em->flush();
        $em->persist($isbn);
        $em->flush();
    }
}