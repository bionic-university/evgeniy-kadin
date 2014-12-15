<?php
require_once('config.php');
use Silex\Provider\SerializerServiceProvider;
use Doctrine\Common\Cache\ApcCache;
use Doctrine\Common\Cache\ArrayCache;
use MWSimple\Silex\AdminCrudORMSilex\CrudController;

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => array(// Подробнее настройка DBAL тут: http://silex.sensiolabs.org/doc/providers/doctrine.html
        'driver'   => 'pdo_mysql',
        'dbname'   => DB_NAME,
        'host'     => DB_HOST,
        'user'     => DB_USER,
        'password' => DB_PASSWORD,
        'charset'  => 'utf8'
    )
));

$app->register(new Nutwerk\Provider\DoctrineORMServiceProvider(), array(
    'db.orm.proxies_dir'           => __DIR__.'/../cache/doctrine/proxy',
    'db.orm.proxies_namespace'     => 'DoctrineProxy',
    'db.orm.cache'                 =>
        !$app['debug'] && extension_loaded('apc') ? new ApcCache() : new ArrayCache(),
    'db.orm.auto_generate_proxies' => true,
    'db.orm.entities'              => array(array(
        'type'      => 'annotation',       // как определяем поля в Entity
        'path'      => __DIR__,   // Путь, где храним классы
        'namespace' => 'BookApp\Entity', // Пространство имен
    )),
));


$app->register(new SerializerServiceProvider());


$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));
