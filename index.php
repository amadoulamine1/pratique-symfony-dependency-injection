<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\Mailer\GmailMailer;
use App\Texter\SmsTexter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

require __DIR__ . '/vendor/autoload.php';
$container = new ContainerBuilder();
/*
$databaseDefinition = new Definition(Database::class);


$controllerDefinition = new Definition(OrderController::class,[
    //$container->get('database'),
    //$container->get('mailer.gmail'),
    //$container->get('texter.sms')
    new Reference('database'),
    new Reference('mailer.gmail'),
    new Reference('texter.sms')
]);

    $controllerDefinition
        ->addMethodCall('sayHello',[
            'martin matin',
            9
        ])
        ->addMethodCall('secondaryMethodCall',[
            new Reference('mailer.gmail')
        ]);
//$container->set('database', new Database());
$container->setDefinition('database',$databaseDefinition);

$smsTexterDefinition=new Definition(SmsTexter::class);
$smsTexterDefinition->setArguments([
    "service.sms.com",
    "apikey123"
]);
$container->setDefinition('texter.sms',$smsTexterDefinition);
$mailerGmailDefinition=new Definition(GmailMailer::class);
$mailerGmailDefinition->setArguments([
    "amadoulamine1@gmail.com",
    "123456"
]);
$container->setDefinition('mailer.gmail',$mailerGmailDefinition);


$container->setDefinition('order_controller',$controllerDefinition);
//$database = $container->get('database');
//$database = new Database();
//$texter = new SmsTexter("service.sms.com", "apikey123");
//$texter = $container->get('texter.sms');
//$mailer = new GmailMailer("lior@gmail.com", "123456");
//$mailer = $container->get('mailer.gmail');
//$controller = new OrderController($database, $mailer, $texter);
*/

$container
    ->register('order_controller', OrderController::class)
    ->setArguments([
        new Reference('database'),
        new Reference('mailer.gmail'),
        new Reference('texter.sms')
    ])
    ->addMethodCall('sayHello',[
        'martin matin',
        9
    ])
    ->addMethodCall('setSecondaryMailer',[
        new Reference('mailer.gmail')
    ]);
$container->register('database', Database::class);

$container
    ->register('texter.sms', SmsTexter::class)
    ->setArguments([
        "service.sms.com",
        "apikey123"
    ]);

$container
    ->register('mailer.gmail', GmailMailer::class)
    ->setArguments([
        "amadoulamine1@gmail.com",
        "123456"
    ]);

$controller= $container->get('order_controller');

$httpMethod = $_SERVER['REQUEST_METHOD'];


if($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__. '/views/form.html.php';
