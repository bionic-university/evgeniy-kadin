<?php
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

//find book by isbn
$app->get('/api/book/isbn/{isbn}', function (Silex\Application $app, $isbn){
    $em = $app['db.orm.em'];
    $isbn = $em->getRepository('BookApp\Entity\BookIsbn')->findOneBy(['isbn'=>$isbn]);
    if(!empty($isbn)){
        $book = $isbn->getBook();
        if(empty($book)){
           throw new Exception("book not found");
        }
        return new Response($app['serializer']->serialize($book->getData(), 'json'));
    }else{
        return new Response($app['serializer']->serialize(array('error'=>'requested book not found'), 'json'), 503);
    }
});

//find book by id
$app->get('/api/book/id/{id}', function (Silex\Application $app, $id){
        $em = $app['db.orm.em'];
        $book = $em->getRepository('BookApp\Entity\Book')->find($id);
        if(!empty($book)){
            return new Response($app['serializer']->serialize($book->getData(), 'json'));
        }else{
            return new Response($app['serializer']->serialize(array('error'=>'requested book not found'), 'json'), 503);
        }
    }
);

//get all categories
$app->get('/api/categories', function (Silex\Application $app){
    $em = $app['db.orm.em'];
    $categories = $em->getRepository('BookApp\Entity\Category')->findAll();
    $result = array();
    foreach($categories as $category){
        $result[] = $category->getData();
    }
    return new Response($app['serializer']->serialize($result, 'json'));
});


$app->get('/api/books/{ids}', function (Silex\Application $app, $ids){
    $em    = $app['db.orm.em'];
    $ids   = explode('-', $ids);
    $books = $em->getRepository('BookApp\Entity\Book')->findBy(['id'=>$ids]);
    $result = array();
    foreach($books as $book){
        $result[$book->getId()] = $book->getData();
    }
    return new Response($app['serializer']->serialize($result, 'json'));
});

$app->get('/api/book/index', function (Silex\Application $app){
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent(file_get_contents(__DIR__.'/data/index.json'));
        return $response;
    });

//"classic" actions
$app->get('/', function (Silex\Application $app){
    return $app['twig']->render('front.twig', array(
    ));
    ;
});
$app->get('/about', function (Silex\Application $app){
        return $app['twig']->render('about.twig', array(
            ));
        ;
    });


$app->get('/services', function (Silex\Application $app){
        return $app['twig']->render('services.twig', array(
            ));
        ;
    });
$app->get('/contact', function (Silex\Application $app){
        return $app['twig']->render('contact.twig', array(
            ));
        ;
    });
$app->get('/books', function (Silex\Application $app){
    $books = $app['db.orm.em']->getRepository('BookApp\Entity\Book')->findBy([], ['updated'=>'asc'], 20);
    $result = array();
    //I cannot find solution with serialization with circular links, so use this ugly method :(
    foreach($books as $book){
        $result[] = $book->getData();
    }
    return new Response($app['serializer']->serialize($result, 'json'));
});


