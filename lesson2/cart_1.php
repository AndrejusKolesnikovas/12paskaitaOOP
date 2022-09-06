<?php

declare(strict_types=1);


/*
Sukurkite klasių hierarchiją, skirtą valdyti kliento prekių krepšelį.
Reikalingos klasės - Cart, CartItem, CartDiscount, Customer.

Customer metodai:
__construct(string $name, string $surname, string $level)
getFullName()
getLevel() - gali būti 'A', 'B' arba 'C'

CartItem metodai:
__construct(string $name, int $price, int $quantity)
getName() - prekės pavadinimas pvz.: 'Iphone 13'
getPrice() - prekė kaina pvz.: 1300 (naudokite int)
getQuantity() - prekės vienetų kiekis pvz.: 3 (naudokite int)

CartDiscount metodai:
__construct(int $percent, string $customerLevel)
getDiscountPercent() - nuolaidos procentas pvz.: 15
getCustomerLevel() - gali būti 'A', 'B' arba 'C'

Cart metodai:
__construct(Customer $customer)
addItem(CartItem $cartItem) - turi leisti pridėti CartItem objektą. Galite saugoti CartItem'us masyve.
addDiscount(CartDiscount $cartDiscount) - turi leisti pridėti CartDiscount objektus
getTotal() - turi grąžinti visą krepšelio sumą su pritaikytomis nuolaidomis.
    Suapvalinkite iki 2 skaičių po kablelio
    Skaičiuojant 'total' nuolaidos sumuojasi. Turi būti pritaikomos tik tos nuolaidos,
    kurių 'customerLevel' sutampa su krepšelio kliento leveliu.
    Pvz.: (6 * 25,90) *  (100 - (15 + 2)) / 100
printSummary - turi isspausdinti krepselio santrauka

Kaip turėtų būti kviečiamas kodas:
$customer = new Customer('John', 'Smith', 'A');
$cart = new Cart($customer);
$iphone = new CartItem('Iphone 13', 1300, 1);
$airpods = new CartItem('Airpods Pro', 200, 2);
$cart->addItem($iphone);
$cart->addItem($airpods);

$cartDiscount1 = new CartDiscount(15, 'A');
$cart->addDiscount($cartDiscount1);
$cartDiscount2 = new CartDiscount(2, 'A');
$cart->addDiscount($cartDiscount2);
$cartDiscount3 = new CartDiscount(20, 'B');
$cart->addDiscount($cartDiscount2);

$total = $cart->getTotal();
var_dump($total); // 1249.5
$cart->printSummary();
Customer: John Smith
Customer level: A
Items:
* Iphone 13 - 1300 x 2 = 2600 eur
* Airpods Pro - 200 x 1 = 200 eur
Discount: 17% - 476 eur
Total: 2324 eur


1 dalis:
Susikurkite CartItem, CartDiscount ir Customer klases

2 dalis:

*/

class Customer
{
    private string $level;

    public function __construct(private string $name, private string $surname, string $level)
    {
        if (!in_array($level, ['A', 'B', 'C'])) {
            die('Wrong customer level selected.');
        }
        $this->level = $level;
    }

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->surname;
    }

    public function getLevel(): string
    {
        return $this->level;
    }
}

$customer = new Customer('John', 'Smith', 'A');

//echo $customer ->getLevel();
class CartItem
{
    public function __construct(private string $name, private int $price, private int $quantity)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

}

class CartDiscount
{
    public function __construct(private int $percent, private string $customerLevel)
    {
    }

    public function getDiscountPercent(): int
    {
        return $this->percent;
    }

    public function getCustomerLevel(): string
    {
        return $this->customerLevel;
    }

}

/*
2 dalis:
Pasirasykite klase Cart. Pridekite jai metodus __contstruct, addItem ir addDiscount

__construct(Customer $customer)
addItem(CartItem $cartItem) - turi leisti pridėti CartItem objektą. Galite saugoti CartItem'us masyve.
addDiscount(CartDiscount $cartDiscount) - turi leisti pridėti CartDiscount objektus
getTotal() - turi grąžinti visą krepšelio sumą su pritaikytomis nuolaidomis.
    Suapvalinkite iki 2 skaičių po kablelio
    Skaičiuojant 'total' nuolaidos sumuojasi. Turi būti pritaikomos tik tos nuolaidos,
    kurių 'customerLevel' sutampa su krepšelio kliento leveliu.
    Pvz.: (6 * 25,90) *  (100 - (15 + 2)) / 100
printSummary - turi isspausdinti krepselio santrauka
*/

class Cart
{
    /**
     * @var CartItem[]
     */
    private array $items;
    /**
     * @var CartDiscount[]
     */
    private array $discounts;

    public function __construct(private Customer $customer)
    {
    }

    public function addItem(CartItem $cartItem): void
    {
        $this->items[] = $cartItem;
    }

    public function addDiscount(CartDiscount $cartDiscount): void
    {
        $this->discounts[] = $cartDiscount;
    }

    private function getDiscountPercent(): float|int
    {
        $discountPercent = 0;
        foreach ($this->discounts as $discount) {
            if ($this->customer->getLevel() === $discount->getCustomerLevel()) {
                $discountPercent += $discount->getDiscountPercent();
            }
        }
        return $discountPercent;
    }

    private function totalBeforeDiscount(): int|float
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getPrice() * $item->getQuantity();
        }
        return $total;
    }


    public function grandTotal(): float
    {


        return round($this->totalBeforeDiscount() * (100 - $this->getDiscountPercent()) / 100, 2);
    }

    /*
     $cart->printSummary();
Customer: John Smith
Customer level: A
Items:
* Iphone 13 - 1300 x 2 = 2600 eur
* Airpods Pro - 200 x 1 = 200 eur
Discount: 17% - 476 eur
Total: 2324 eur
*/
    public function printSummary(): void
    {
        echo 'Customer: ' . $this->customer->getFullName() . PHP_EOL .
            'Customer level: ' . $this->customer->getLevel() . PHP_EOL .
            'Items: ' . PHP_EOL;

        foreach ($this->items as $item) {
            echo '* ' . $item->getName() . ' ' . $item->getPrice() . ' x ' . $item->getQuantity() .
                ' = ' . $item->getPrice() * $item->getQuantity() . ' eur' . PHP_EOL;
        }

        echo 'Discount: ' . $this->getDiscountPercent() . '% - ' . $this->totalBeforeDiscount() - $this->grandTotal() . ' eur'
            . PHP_EOL . 'Total: ' . $this->grandTotal();
    }
}

$customer = new Customer('John', 'Smith', 'A');
$cart = new Cart($customer);

$iphone = new CartItem('Iphone 13', 1300, 2);
$cart->addItem($iphone);

$airpods = new CartItem('Airpods Pro', 200, 1);
$cart->addItem($airpods);


$cartDiscount1 = new CartDiscount(15, 'A');
$cart->addDiscount($cartDiscount1);

$cartDiscount2 = new CartDiscount(2, 'A');
$cart->addDiscount($cartDiscount2);

$cartDiscount3 = new CartDiscount(20, 'B');
$cart->addDiscount($cartDiscount3);

$total = $cart->grandTotal();
//echo $total;
$cart->printSummary();