<?php
session_start();
require 'vendor/autoload.php';//puxando o autoload do composer para ativar as bibliotecas
require 'Facebook/autoload.php';

require 'config.php';

spl_autoload_register(function ($class){
    if(file_exists('controllers/'.$class.'.php')) {
            require_once 'controllers/'.$class.'.php';
    } elseif(file_exists('models/'.$class.'.php')) {
            require_once 'models/'.$class.'.php';
    } elseif(file_exists('core/'.$class.'.php')) {
            require_once 'core/'.$class.'.php';
    }
});

$core = new core();
$core->run();