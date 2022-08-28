<?php

declare(strict_types=1);

/*
Sukurkite klasę OrderFormatter, kuri suformatuoti uzsakyma.
Apacioje matote, kaip sios klases objektai turetu buti naudojami.
*/

class OrderFormatter
{
    private array $orders = [];

    public function addItem(array $item): void
    {
        $this->orders[] = $item;
    }

    public function formatOrder(): void
    {
        $total = 0;
        echo 'Order items: ' . PHP_EOL;
        foreach ($this->orders as $order) {
            $itemTotal = $order['price'] * $order['quantity'];
            $total = $total + $itemTotal;
            echo $order['product_name'] . ', Total: ' . $itemTotal . PHP_EOL;
        }
        echo 'Grand Total: ' . $total . PHP_EOL;
    }
}

$orderFormatter = new OrderFormatter();

$item1 = [
    'product_name' => 'Yellow Sofa',
    'price' => 150,
    'quantity' => 2,
];
$orderFormatter->addItem($item1);

$item2 = [
    'product_name' => 'Green Chair',
    'price' => 75,
    'quantity' => 3,
];
$orderFormatter->addItem($item2);
$orderFormatter->formatOrder();
/*
 * Order items:
 * Name: Yellow Sofa, Total: 300
 * Name: Green Chair, Total: 225
 * Grand Total: 525
 */

