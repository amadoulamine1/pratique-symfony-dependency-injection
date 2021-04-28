<?php

namespace App\Texter;

use App\Logger;

class SmsTexter implements TexterInterface
{
    protected $serviceDsn;
    protected $key;
    protected $logger;

    public function __construct(string $serviceDsn, string $key)
    {
        $this->serviceDsn = $serviceDsn;
        $this->key = $key;
    }

    public function send(Text $text)
    {
        var_dump("ENVOI DE SMS : ", $text);
    }

    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
        $this->logger->log("ca marche dans sms");
    }
}
