<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\Mailer\GmailMailer;
use App\Texter\SmsTexter;
use App\Texter\TexterInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

require __DIR__ . '/vendor/autoload.php';
$container = new ContainerBuilder();
$container->setParameter('mailer.gmail_user','amadoulamine1@gmail.com');
$container->setParameter('mailer.gmail_password','123456');
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
    //    new Reference('database'),
    //    new Reference('mailer.gmail'),
    //    new Reference('texter.sms')
        new Reference(Database::class),
        new Reference(GmailMailer::class),
        new Reference(SmsTexter::class)
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
        "%mailer.gmail_user%'",
        "%mailer.gmail_password%"
    ]);

$container->setAlias('App\Controller\OrderController','order_controller')->setPublic(true);
$container->setAlias('App\Database\Database','database');
    
$container->setAlias('App\Mailer\GmailMailer','mailer.gmail');
$container->setAlias('App\Texter\SmtpMailer','mailer.smtp');
$container->setAlias('App\Texter\MailerInterface','mailer.gmail');

$container->setAlias('App\Texter\SmsTexter','texter.sms');
$container->setAlias('App\Texter\FaxTexter','texter.fax');
$container->setAlias('App\Texter\TexterInterface','texter.sms');

$container->compile();

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
