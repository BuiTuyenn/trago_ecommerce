<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::active()
            ->featured()
            ->inStock()
            ->with('category')
            ->take(8)
            ->get();
            
        $categories = Category::active()
            ->parent()
            ->orderBy('sort_order')
            ->take(6)
            ->get();
            
        $newProducts = Product::active()
            ->inStock()
            ->with('category')
            ->latest()
            ->take(8)
            ->get();
            
        return view('home', compact('featuredProducts', 'categories', 'newProducts'));
    }
}
