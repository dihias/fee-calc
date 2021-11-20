<?php

declare(strict_types=1);


class App implements AppInterface
{
  

    public function getConfigDir(): string
    {
        return __DIR__ . '/config/prod/';
    }
}