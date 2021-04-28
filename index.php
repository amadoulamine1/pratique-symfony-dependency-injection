<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\Mailer\GmailMailer;
use App\Mailer\SmtpMailer;
use App\Texter\SmsTexter;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

require __DIR__ . '/vendor/autoload.php';


$container = new ContainerBuilder();
$container->setParameter('mailer.gmail_user','amadoulamine1@gmail.com');
$container->setParameter('mailer.gmail_password','123456');

$container
    ->register('order_controller', OrderController::class)
    ->setPublic(true)
    ->setAutowired(true)
    ->addMethodCall('sayHello',[
        'martin matin',
        9
    ])
    ->addMethodCall('setSecondaryMailer',[
        new Reference('mailer.gmail')
    ]);
 $container->register('database', Database::class)
 ->setAutowired(true);

$container
    ->register('texter.sms', SmsTexter::class)
    ->setAutowired(true)
    ->setArguments(["service.sms.com","apikey123"]);

 $container
     ->register('mailer.gmail', GmailMailer::class)
     ->setAutowired(true)
     ->setArguments(["%mailer.gmail_user%'","%mailer.gmail_password%"]);

$container
    ->register('mailer.smtp', SmtpMailer::class)
    ->setAutowired(true)
    ->setArguments(['smtp://localhost','root','1234']);

    $container
    ->register('texter.fax', FaxTexter::class)
    ->setAutowired(true);



$container->setAlias('App\Controller\OrderController','order_controller')->setPublic(true);
$container->setAlias('App\Database\Database','database');
    
$container->setAlias('App\Mailer\GmailMailer','mailer.gmail');
$container->setAlias('App\Texter\SmtpMailer','mailer.smtp');
$container->setAlias('App\Mailer\MailerInterface','mailer.gmail');

$container->setAlias('App\Texter\SmsTexter','texter.sms');
$container->setAlias('App\Texter\FaxTexter','texter.fax');
$container->setAlias('App\Texter\TexterInterface','texter.sms');

$container->compile();

var_dump("error");

//$controller= $container->get('order_controller');
$controller= $container->get(OrderController::class);

//$texter = $container->get(TexterInterface::class);

//var_dump($container->get('mailer.gmail'));
$httpMethod = $_SERVER['REQUEST_METHOD'];


if($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__. '/views/form.html.php';
