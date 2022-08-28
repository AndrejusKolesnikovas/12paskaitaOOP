<?php

declare(strict_types=1);

/*

Sukurkite klasę, kuri skaičiuotų keturkampio plotą, perimetrą ir įstrižainę.
Klasės pavadinimas: Rectangle
Į konstruktorių paduodama: int $length, int $width
Metodai:
- calculateArea()
- calculatePerimeter()
- calculateDiagonal()

Metodai turi grąžinti iki 2 skaitmenų po kablelio į viršų suapvalintą float tipo reikšmę. Pridėkite return tipą metodams.

*/

class Rectangle
{

    private int $width;
    private int $length;


    public function __construct(int $length, int $width)
        //public function __construct(private int $length, private int $width) (isvengiam priskirimo virsuje ir apacioje su this)
    {
        $this->width = $width;
        $this->length = $length;

    }

    public function calculateArea(): float
    {
        $result = $this->length * $this->width;
        return round($result, 2, PHP_ROUND_HALF_UP);
    }

    public function calculatePerimeter(): float
    {
        $result = 2 * ($this->length + $this->width);
        return round($result, 2, PHP_ROUND_HALF_UP);
    }

    public function calculateDiagonal(): float
    {
        $result = sqrt($this->length ** 2 + $this->width ** 2);
        return round($result, 2, PHP_ROUND_HALF_UP);
    }
}

$rectangle = new Rectangle(2, 4);
echo 'Plotas: ' . $rectangle->calculateArea() . PHP_EOL;
echo 'Perimetras: ' . $rectangle->calculatePerimeter() . PHP_EOL;
echo 'Istrizaine: ' . $rectangle->calculateDiagonal() . PHP_EOL;




