<?php

$products = [];
$products[] = [
    'name' => 'Monitor',
    'price' => 2500
];
$products[] = [
    'name' => 'Core i7',
    'price' => 3000
];

Co\run(function() use ($products)
{
    go(function() use ($products)
    {
        Co::sleep(1);
        $products[0]['price'] += 1000;
        echo $products[0]['name'].' is costing '.$products[0]['price'].PHP_EOL;
    });

    go(function() use ($products)
    {
        Co::sleep(0.3);
        $products[1]['price'] += 1000;
        echo $products[1]['name'].' is costing '.$products[1]['price'].PHP_EOL;
    });
});