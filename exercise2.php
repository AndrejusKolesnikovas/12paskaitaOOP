<?php

declare(strict_types=1);


class Rectangle1
{
    public function __construct(private int $length, private int $width)
    {
    }

    public function calculateArea(): float
    {
        $result = $this->length * $this->width;

        return $this->calculateRound($result);
    }

    public function calculatePerimeter(): float
    {
        $result = 2 * $this->length + 2 * $this->width;

        return $this->calculateRound($result);
    }

    public function calculateDiagonal(): float
    {
        $result = sqrt($this->length * $this->length + $this->width * $this->width);

        return $this->calculateRound($result);
    }

    private function calculateRound(int|float $result): float
    {

        return round($result, 2, PHP_ROUND_HALF_UP);
    }

}

$rectangle = new Rectangle1();
echo 'Plotas: ' . $rectangle->calculateArea() . PHP_EOL;
echo 'Perimetras: ' . $rectangle->calculatePerimeter() . PHP_EOL;
echo 'Istrizaine: ' . $rectangle->calculateDiagonal() . PHP_EOL;
