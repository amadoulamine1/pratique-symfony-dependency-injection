<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\Mailer\GmailMailer;
use App\Texter\SmsTexter;
use Symfony\Component\DependencyInjection\ContainerBuilder;

require __DIR__ . '/vendor/autoload.php';
$container = new ContainerBuilder();
$container->set('database', new Database());

$database = $container->get('database');
$texter = new SmsTexter("service.sms.com", "apikey123");
$mailer = new GmailMailer("lior@gmail.com", "123456");
$controller = new OrderController($database, $mailer, $texter);

$httpMethod = $_SERVER['REQUEST_METHOD'];


if($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__. '/views/form.html.php';
