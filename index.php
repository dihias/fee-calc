<?php

use Feecalc\Fee\CalculateFeeF;


require_once('./vendor/autoload.php');


$env = isset($argv[1]) && $argv[1] === 'test' ? 'test' : 'prod';


if ($env === 'test') {
    $container=  new AppTest();
}

$container= new App();

$application = new CalculateFeeF();

$application->execute($argv[1]);
?>