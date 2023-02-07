<?php
 namespace Pessoa;

 use Pessoa\Controller\PessoaController;
 use Pessoa\Model\Pessoa;
 use Pessoa\Model\PessoaTable;
 use Zend\Db\Adapter\AdapterInterface;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;

 class Module implements ConfigProviderInterface {
     public function getConfig(){
         return include __DIR__ ."/../config/module.config.php";
     }

     public function getServiceConfig(){
         return [
             'factories' => [
                Model\PessoaTable::class => function($container) {
                    $tableGateway = $container->get(Model\PessoaTableGateway::class);
                    return new PessoaTable($tableGateway);
                },
                Model\PessoaTableGateway::class => function($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Pessoa());
                    return new TableGateway('pessoa', $dbAdapter, null, $resultSetPrototype);
                }
             ]
         ];
     }

     public function getControllerConfig(){
         return [
             'factories' => [
                 PessoaController::class => function($container) {
                    $tableGateway = $container->get(PessoaTable::class);
                    return new PessoaController($tableGateway);
                 }
             ]
         ];
     }
 }