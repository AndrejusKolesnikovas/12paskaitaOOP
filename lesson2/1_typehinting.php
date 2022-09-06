<?php

declare(strict_types=1);

class Passenger
{
    public function __construct(private string $fullName, private DateTime $dateOfBirth)
    {
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getDateOfBirth(): DateTime
    {
        return $this->dateOfBirth;
    }
}

class Flight
{
    private array $passengers = [];

    public function addPassenger(Passenger $passenger): void
    {
        $this->passengers[] = $passenger;
    }

    public function printPassengerList(): void
    {
        foreach ($this->passengers as $passenger) {
            echo $passenger->getFullName() . PHP_EOL;
        }
    }

    public function getPassengerByFullName(string $fullName): ?Passenger
    {
        foreach($this->passengers as $passenger) {
            if ($fullName === $passenger->getFullName()) {
                return $passenger;
            }
        }
        return null;
    }
}

$flight = new Flight();

$passenger1 = new Passenger('Donatas C', new DateTime('1900-01-01'));
$passenger2 = new Passenger('John S', new DateTime('1900-01-01'));

$flight->addPassenger($passenger1);
$flight->addPassenger($passenger2);
// DEMESIO:
// $flight->addPassenger('Passenger: Tina M'); // string tipo reikme negali buti paduota i metoda addPassenger
/*
 Flight $passenger savybe tuomet atrodo stai taip:
[
    $passenger1, // Passenger objektas
    $passenger2, // Passenger objektas
    'Passenger: Tina M', // string
]
*/
$passenger = $flight->getPassengerByFullName('Donatas C');
var_dump($passenger);die;
