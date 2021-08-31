<?php
/**
 * Preču katalogs - List of products IR!
 * Pircējs - a simple object IR!
 * Iepirkšanās grozs - array containing products + int [$x => 1, $y => 3, $c => 10] IR!
 * Iepērkoties narvesenā pircējam jābūt iespējai ielikt 1 vai vairākas preces grozā IR!
 * grozā var ielikt preces tik daudz cik veikalā atrodas. IR!
 * Beigās iespēja veikt apmaksu par visu grozu. IR!
 */


function createProduct($name, $price, $quantity): stdClass
{
    $product = new stdClass();
    $product->name = $name;
    $product->price = $price;
    $product->quantity = $quantity;

    return $product;
}

$products = [
    createProduct("Bacon", 10, 15),
    createProduct("Eggs", 12, 10),
    createProduct("Sausages", 20, 16),
    createProduct("Cheese", 23, 7),
    createProduct("Cookies", 17, 13),
    createProduct("Milk", 18, 11),
    createProduct("Bread", 13, 15),
    createProduct("Whiskey", 40, 5),
];
$person = new stdClass();
$person->name = "Arturs";
$person->age = 19;
$person->money = 200;

echo "Available products, their quantity and price: " . PHP_EOL;

foreach ($products as $key => $product)
{
    $price = $product->price / 100;
    echo "Key to choose {$key} {$product->name}- Quantity: {$product->quantity}, Price: {$product->price}$" . PHP_EOL;
}
echo "Your balance: {$person->money}$" . PHP_EOL;


$selection= readline("Enter desired product: ");

$cart = [];
while (true)
{
    if (!isset($products[$selection]))
    {
        echo "Product not found!" . PHP_EOL;
    }
    if ($person->age < 21 && $selection == 7)
    {
        echo "You are underage!" . PHP_EOL;
        exit;
    }

    $quantity = readline("Enter amount: ");
    if ($quantity > $products[$selection]->quantity)
    {
        echo "Selected too much" . PHP_EOL;
        exit;

    }
    $selectedProduct = clone $products[$selection];
    $selectedProduct->quantity = $quantity;
    $cart[] = $selectedProduct;
    $total = 0;

    foreach ($cart as $product)
    {
        $total += $product->price * $product->quantity;
    }

    echo "Total cost of your purchase will be: " . $total . "$" . PHP_EOL;

    $products[$selection]->quantity -= $quantity;
    $input = readline("Do you want to pay for your purchase or buy something else? \"pay\" or \"buy\": ");

    $pay = $person->money - $total;
    switch ($input)
    {
        case $person->money < $total:
            echo "Insufficient funds!" . PHP_EOL;
            exit;
        case "pay":
            echo "You got {$pay}$ left! Goodbye!" . PHP_EOL;
            exit;

        case "buy":
            echo "What do you want to buy?" . PHP_EOL;
            $selection= readline("Enter desired product: ");
            break;
    }

}
