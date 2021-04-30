<?php

namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class LoggerCompilerPass implements CompilerPassInterface{
    
    public function process(ContainerBuilder $container){
       // $definitions = $container->getDefinitions();
       $ids = $container->findTaggedServiceIds('with_logger');

       /*foreach ($definitions as $id=> $definition){
            if($id === 'texter.sms'|| $id ===  'mailer.gmail'){
                $definition->addMethodCall('setLogger', [new Reference('logger')]); 
            }
            
       }*/

       foreach ($ids as $id=> $data){
            $definition = $container->getDefinition($id);
            $definition->addMethodCall('setLogger', [new Reference('logger')]); 
        }
        // var_dump($definitions);
   }
       
  //  }
}