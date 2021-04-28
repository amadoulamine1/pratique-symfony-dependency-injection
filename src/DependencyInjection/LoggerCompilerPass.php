<?php

namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class LoggerCompilerPass implements CompilerPassInterface{
    public function process(ContainerBuilder $container){
        $definitions = $container->getDefinitions();
        var_dump($definitions);
    }
}