<?php

use App\Logger;
use App\Texter\FaxTexter;
use App\Texter\SmsTexter;
use App\Database\Database;
use App\Mailer\SmtpMailer;
use App\Mailer\GmailMailer;
use App\Controller\OrderController;
use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;


return function (ContainerConfigurator $configurator){
   $parameters=  $configurator->parameters();
   $parameters
        ->set('mailer.gmail_user','amadoulamine1@gmail.com')
        ->set('mailer.gmail_password','123456');

    $services = $configurator->services();
    $services->defaults->autowire(true);
    $services
        ->set('order_controller', OrderController::class)
       //->autowire(true)
        ->public()
        ->call('sayHello',[
            'martin matin',
            9
        ])
        ->call('setSecondaryMailer',[ref('mailer.gmail')])

        ->set('database', Database::class)
        //->autowire(true)

        ->set('logger', Logger ::class)
        // ->autowire(true)
    
        ->set('texter.sms', SmsTexter::class)
        // ->autowire(true)
        ->args(["service.sms.com","apikey123"])
        ->tag('with_logger')

        ->set('texter.fax', FaxTexter::class)
        // ->autowire(true)

        ->set('mailer.gmail', GmailMailer::class)
        // ->autowire(true)
        ->args(["%mailer.gmail_user%'","%mailer.gmail_password%"])
        ->tag('with_logger')

        ->set('mailer.smtp', SmtpMailer::class)
        // ->autowire(true)
        ->args(['smtp://localhost','root','1234'])

        ->alias('App\Controller\OrderController','order_controller')
        ->public()
        ->alias('App\Database\Database','database')
    
        ->alias('App\Mailer\GmailMailer','mailer.gmail')
        ->alias('App\Texter\SmtpMailer','mailer.smtp')
        ->alias('App\Mailer\MailerInterface','mailer.gmail')

        ->alias('App\Texter\SmsTexter','texter.sms')
        ->alias('App\Texter\FaxTexter','texter.fax')
        ->alias('App\Texter\TexterInterface','texter.sms')
        ->alias('App\Logger','logger');
    
};
    // $container
    //     // ->register('order_controller', OrderController::class)
    //      ->autowire('order_controller', OrderController::class)
    //      ->setPublic(true)
    //      //->setAutowired(true)
    //      ->addMethodCall('sayHello',[
    //          'martin matin',
    //          9
    //      ])
    //      ->addMethodCall('setSecondaryMailer',[
    //          new Reference('mailer.gmail')
    //      ]);
    //   $container->autowire('database', Database::class);
    //  //  ->register('database', Database::class)
    //  //  ->setAutowired(true);
      
    //  $container->autowire('logger', Logger ::class);
    //  $container->autowire('texter.sms', SmsTexter::class)
    //      // ->register('texter.sms', SmsTexter::class)
    //      // ->setAutowired(true)
    //      ->setArguments(["service.sms.com","apikey123"]) 
    //      ->addTag("with_logger") 
    //      // ->addMethodCall('setLogger',[
    //      //     new Reference('logger')
    //      // ])
    //      ;
     
    //   $container->autowire('mailer.gmail', GmailMailer::class)
    //      //  ->register('mailer.gmail', GmailMailer::class)
    //      //  ->setAutowired(true)
    //       ->setArguments(["%mailer.gmail_user%'","%mailer.gmail_password%"])
    //       ->addTag("with_logger") 
    //      //  ->addMethodCall('setLogger',[
    //      //     new Reference('logger')
    //      // ])
    //      ;
     
    //  $container->autowire('mailer.smtp', SmtpMailer::class)
    //      // ->register('mailer.smtp', SmtpMailer::class)
    //      // ->setAutowired(true)
    //      ->setArguments(['smtp://localhost','root','1234']);

