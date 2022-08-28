<?php

declare(strict_types=1);

class Animal
{
    public string $type;
    public array $capabilities = [];
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function printCapabilities(): void
    {
        echo $this->name . ' can:' . PHP_EOL;
        foreach ($this->capabilities as $capability) {
            echo ucfirst($capability) . PHP_EOL;
        }
    }
}

$cat = new Animal('Micius');
$cat->type = 'land';

$capability1 = 'catch a laser';
$capability2 = 'sleep';

$cat->capabilities[] = $capability1;
$cat->capabilities[] = $capability2;
//$cat->name = 'Micius';

$cat->printCapabilities();

/*
Prideti papildoma savybe 'name' klasei Animal.
Ta savybe metode 'printCapabilities'.

Micius can:
Catch a laser
Sleep
*/