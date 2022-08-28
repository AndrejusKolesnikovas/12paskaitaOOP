<?php

declare(strict_types=1);

/*

Sukurkite klasę NumberCalculator, kuri leistų atlikti įvairius skaičiavimo veiksmus. Ši klasė neturės konstruktoriaus.
Metodai:
- addNumber - metodas priims "int" tipo argumentą, return tipas bus "void"
- calculateSum - metodas grąžins "int" tipo reikšmę, argumentų neturės
- calculateProduct - product liet. sandauga. Metodas grąžins "int" tipo reikšmę, argumentų neturės
- calculateAverage - suapvalinkite iki sveiko skaičiaus, į viršų. Metodas grąžins "int" tipo reikšmę, argumentų neturės

Nepamirškite sudėti argumentų bei return tipų.

Kodo kvietimo pavyzdys:

$numberCalculator = new NumberCalculator();
echo $numberCalculator->calculateSum(); // 0

$numberCalculator->addNumber(5);
$numberCalculator->addNumber(7);

echo $numberCalculator->calculateSum(); // 12

*/

class NumberCalculator
{
    private array $number = [];

    public function addNumber(int $num): void
    {
        $this->number[] = $num;
    }

    public function calculateSum(): int
    {
        return array_sum($this->number);
    }

    public function calculateProduct(): int
    {
        return array_product($this->number);
    }

    public function calculateAverage(): int
    {
        $sum = $this->calculateSum() / count($this->number);
//        $sum =  array_sum($this->number)/ count($this->number);

        return (int)round($sum, 0, PHP_ROUND_HALF_UP);
    }
}

$calculator = new NumberCalculator();

echo $calculator->calculateSum();

$calculator->addNumber(5);
$calculator->addNumber(3);
$calculator->addNumber(2);

echo $calculator->calculateSum();
//echo $calculator->calculateProduct();
//echo $calculator->calculateAverage();