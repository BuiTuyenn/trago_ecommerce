<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Boot the application
$app->boot();

// Get products
$products = App\Models\ProductsSach::take(5)->get();

echo "Checking ProductsSach data:\n";
foreach($products as $product) {
    echo "ID: {$product->id}\n";
    echo "Title: {$product->title}\n";
    echo "Price: " . var_export($product->price, true) . " (type: " . gettype($product->price) . ")\n";
    echo "Sale Price: " . var_export($product->sale_price, true) . " (type: " . gettype($product->sale_price) . ")\n";
    echo "Images: " . var_export($product->images, true) . " (type: " . gettype($product->images) . ")\n";
    echo "---\n";
}
