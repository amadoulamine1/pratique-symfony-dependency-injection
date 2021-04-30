<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\DependencyInjection\LoggerCompilerPass;
use App\Logger;
use App\Mailer\GmailMailer;
use App\Mailer\SmtpMailer;
use App\Texter\SmsTexter;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Reference;

require __DIR__ . '/vendor/autoload.php';


$container = new ContainerBuilder();

$loader= new PhpFileLoader($container,new FileLocator([__DIR__ . '/config']));
$loader-> load('service.php');

$container->addCompilerPass(new LoggerCompilerPass); 
$container->compile();

var_dump("error");

$controller= $container->get(OrderController::class);

//$texter = $container->get(TexterInterface::class);

//var_dump($container->get('mailer.gmail'));
$httpMethod = $_SERVER['REQUEST_METHOD'];


if($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__. '/views/form.html.php';
