<?php

declare(strict_types=1);


class Animal
{
    protected bool $hasTail = false;
    private bool $hasEars = false;

    public function run(): void
    {
        $this->moveLegs();
        $this->moveTail();
    }

    protected function moveLegs(): void
    {
        echo 'Animal is moving legs' . PHP_EOL;
    }

    protected function moveTail(): void
    {
        if ($this->hasTail) {
            echo 'Animal is moving tail' . PHP_EOL;
        }
    }
}

class Cat extends Animal
{
    // perrasyti galime tik tuos propercius/metodus, kurie yra paveldimi is tevines klases t.y. kurie turi
    // protected arba public matomuma tevineje klaseje
    protected bool $hasTail = true;
    protected bool $hasEars = true;

    public function run(): void
    {
        $this->makeNoise();
        // kviecia tevines klases run metoda
        parent::run();
        $this->makeNoise();
    }

    private function makeNoise(): void
    {
        echo 'Cat is meowing' . PHP_EOL;
    }
}

$cat = new Cat();
$cat->run();
echo PHP_EOL;
$animal = new Animal();
$animal->run();

//$animal = new Animal();
//$animal->run();
//$animal->makeSound();