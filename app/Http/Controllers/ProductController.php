<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use App\Models\BrowseHistory;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Constructor - Apply middleware for admin methods
     */
    public function __construct()
    {
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::where('status', 'active')->with('category');
        
        // Search by name, description, SKU
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('short_description', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by price range (custom inputs)
        if ($request->has('min_price') && $request->min_price) {
            $minPrice = (float) $request->min_price;
            $query->where(function($q) use ($minPrice) {
                $q->where('sale_price', '>=', $minPrice)
                  ->orWhere(function($subQ) use ($minPrice) {
                      $subQ->whereNull('sale_price')
                           ->where('price', '>=', $minPrice);
                  });
            });
        }
        
        if ($request->has('max_price') && $request->max_price) {
            $maxPrice = (float) $request->max_price;
            $query->where(function($q) use ($maxPrice) {
                $q->where('sale_price', '<=', $maxPrice)
                  ->orWhere(function($subQ) use ($maxPrice) {
                      $subQ->whereNull('sale_price')
                           ->where('price', '<=', $maxPrice);
                  });
            });
        }
        
        // Filter by price range presets
        if ($request->has('price_range') && $request->price_range) {
            $priceRange = $request->price_range;
            switch ($priceRange) {
                case 'under_100k':
                    $query->where(function($q) {
                        $q->where('sale_price', '<', 100000)
                          ->orWhere(function($subQ) {
                              $subQ->whereNull('sale_price')->where('price', '<', 100000);
                          });
                    });
                    break;
                case '100k_500k':
                    $query->where(function($q) {
                        $q->whereBetween('sale_price', [100000, 500000])
                          ->orWhere(function($subQ) {
                              $subQ->whereNull('sale_price')->whereBetween('price', [100000, 500000]);
                          });
                    });
                    break;
                case '500k_1m':
                    $query->where(function($q) {
                        $q->whereBetween('sale_price', [500000, 1000000])
                          ->orWhere(function($subQ) {
                              $subQ->whereNull('sale_price')->whereBetween('price', [500000, 1000000]);
                          });
                    });
                    break;
                case '1m_5m':
                    $query->where(function($q) {
                        $q->whereBetween('sale_price', [1000000, 5000000])
                          ->orWhere(function($subQ) {
                              $subQ->whereNull('sale_price')->whereBetween('price', [1000000, 5000000]);
                          });
                    });
                    break;
                case '5m_10m':
                    $query->where(function($q) {
                        $q->whereBetween('sale_price', [5000000, 10000000])
                          ->orWhere(function($subQ) {
                              $subQ->whereNull('sale_price')->whereBetween('price', [5000000, 10000000]);
                          });
                    });
                    break;
                case 'over_10m':
                    $query->where(function($q) {
                        $q->where('sale_price', '>', 10000000)
                          ->orWhere(function($subQ) {
                              $subQ->whereNull('sale_price')->where('price', '>', 10000000);
                          });
                    });
                    break;
            }
        }
        
        // Filter by stock status
        if ($request->has('stock_status') && $request->stock_status) {
            $stockStatus = $request->stock_status;
            switch ($stockStatus) {
                case 'in_stock':
                    $query->where('stock_quantity', '>', 0);
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', '<=', 0);
                    break;
                case 'low_stock':
                    $query->whereBetween('stock_quantity', [1, 10]);
                    break;
            }
        }
        
        // Filter by product type
        if ($request->has('product_type') && $request->product_type) {
            $productType = $request->product_type;
            switch ($productType) {
                case 'featured':
                    $query->where('featured', true);
                    break;
                case 'new':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case 'sale':
                    $query->whereNotNull('sale_price');
                    break;
                case 'bestseller':
                    // Simulate bestseller logic - you might want to add a bestseller field or count orders
                    $query->where('featured', true)->where('stock_quantity', '>', 0);
                    break;
            }
        }
        
        // Filter by rating (simulate rating filter)
        if ($request->has('rating') && $request->rating) {
            $rating = (int) $request->rating;
            // For now, we'll use a simple simulation
            // In a real app, you'd join with reviews table and calculate average rating
            if ($rating >= 4) {
                $query->where('featured', true); // Assume featured products have high ratings
            }
        }
        
        // Sorting
        $sortBy = $request->get('sort', 'name');
        
        switch ($sortBy) {
            case 'price':
                $query->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_desc':
                $query->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'name':
                $query->orderBy('name', 'ASC');
                break;
            case 'name_desc':
                $query->orderBy('name', 'DESC');
                break;
            case 'created_at':
                $query->orderBy('created_at', 'DESC');
                break;
            case 'popular':
                $query->orderBy('featured', 'DESC')->orderBy('stock_quantity', 'DESC');
                break;
            case 'featured':
                $query->orderBy('featured', 'DESC')->orderBy('created_at', 'DESC');
                break;
            default:
                $query->orderBy('name', 'ASC');
        }
        
        // Pagination: 16 sản phẩm per page (4 sản phẩm x 4 hàng)
        $products = $query->paginate(16)->withQueryString();
        
        return view('products.index', compact('products'));
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $product = Product::active()
            ->with(['category', 'reviews' => function($query) {
                $query->approved()->with('user');
            }])
            ->where('slug', $slug)
            ->firstOrFail();
            
        // Record browse history
        BrowseHistory::recordView($product);
            
        $relatedProducts = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inStock()
            ->take(4)
            ->get();

        // Check if product is in user's wishlist
        $inWishlist = false;
        if (Auth::check()) {
            $inWishlist = Wishlist::isInWishlist(Auth::id(), $product->id);
        }
            
        return view('products.show', compact('product', 'relatedProducts', 'inWishlist'));
    }

    /**
     * Show products by category
     */
    public function byCategory($categorySlug)
    {
        $category = Category::active()->where('slug', $categorySlug)->firstOrFail();
        
        $products = Product::active()
            ->where('category_id', $category->id)
            ->inStock()
            ->with('category')
            ->paginate(12);
            
        return view('products.category', compact('products', 'category'));
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return redirect()->route('products.index');
        }
        
        $products = Product::active()
            ->where(function($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhere('sku', 'like', '%' . $query . '%');
            })
            ->inStock()
            ->with('category')
            ->paginate(12);
            
        return view('products.search', compact('products', 'query'));
    }

    // Admin methods (for backend management)
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products',
            'description' => 'required|string',
            'sku' => 'required|string|unique:products',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0'
        ]);

        Product::create($request->all());

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0'
        ]);

        $product->update($request->all());

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
