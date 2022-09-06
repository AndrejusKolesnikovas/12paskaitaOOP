<?php

declare(strict_types=1);

class Product
{
    public int $price;
}

class ProductModifier
{
    // objektai yra passed by reference. Tai reiskia, kad i metoda yra paduodamas "originalas" ty. pats objektas
    public function modify(Product $product): void
    {
        $product->price = 100;
    }

    // int, float, string ir array yra passed by value. Tai reiskia, kad i metoda yra paduodama kopija, ne "originalas"
    public function modifyProductArray(array $product): void
    {
        $product['price'] = 100;
    }
}

$product = new Product();
$product->price = 99;
echo $product->price; // 99
$productArray = ['price' => 99];
print_r($product);
$productModifier = new ProductModifier();
$productModifier->modify($product);
var_dump($productModifier->modifyProductArray($productArray));
print_r($productArray);