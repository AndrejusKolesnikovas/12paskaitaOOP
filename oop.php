<?php

declare(strict_types=1);

class Animal
{
    public string $type;
    public array $capabilities = [];

    public function __construct()
    {
        echo 'Kuriamas objektas' . PHP_EOL;
    }

    public function move()
    {
        echo 'animal is moving';
    }

    public function printCapabilities(): void
    {
        foreach ($this->capabilities as $capability) {
            echo ucfirst($capability) . PHP_EOL;
        }
    }
}

$cat = new Animal();
$cat->type = 'land';
$capability1 = 'sleep';
$capability2 = 'eat';

$cat->capabilities[] = $capability1;
$cat->capabilities[] = $capability2;
//$cat->move();

//var_dump($cat->capabilities);

$fish = new Animal();
$fish->type = 'sea';

$fish->capabilities[] = 'swim';
$fish->capabilities[] = 'forget everything';
//$fish->printCapabilities();
//var_dump($fish->capabilities);
