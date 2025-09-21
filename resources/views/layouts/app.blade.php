<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Commerce') }} - @yield('title', 'Trang chủ')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/css/layouts/container-override.css', 'resources/js/app.js'])
    
    <!-- Custom Theme CSS -->
    <link rel="stylesheet" href="{{ asset('css/pages/trego.css') }}">
    <link rel="stylesheet" href="{{ asset('css/categories/category-common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages/products.css') }}">

    <!-- Custom CSS -->
    <style>
        .navbar-brand {
            font-weight: 600;
            color: #2563eb !important;
        }
        
        .brand-text-logo {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2563eb;
            text-decoration: none;
            letter-spacing: -0.02em;
            font-family: 'Arial', sans-serif;
            transition: all 0.3s ease;
        }
        
        .brand-text-logo:hover {
            transform: scale(1.05);
            color: #1d4ed8;
        }
        
        
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .product-card {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        
        /* Product Font Size Overrides - High Priority */
        .product-title,
        .product-name,
        .card-title,
        .product-card .product-title,
        .product-card .product-name,
        .product-card .card-title,
        .product-card-modern .product-title,
        .product-card-trego .product-name,
        .card-body .card-title,
        h5.card-title,
        .card-title h5 {
            font-size: 16px !important;
            line-height: 1.4 !important;
        }
        
        .product-price,
        .current-price,
        .original-price,
        .old-price,
        .product-category,
        .product-category small,
        .rating-count,
        .stock-status,
        .stock-status small,
        .price-info,
        .price-section,
        .product-details,
        .product-info .text-muted,
        .product-card .text-muted,
        .product-card small,
        .card-body .text-muted,
        .card-body small,
        .price-wrap,
        .price-wrap .current-price,
        .price-wrap .original-price {
            font-size: 14px !important;
        }
        
        .form-select {
            font-size: 14px !important;
        }
        
        /* Bootstrap Card Specific Overrides */
        .card .card-body h5,
        .card .card-body .h5,
        .card-body h5.card-title,
        .card-body .card-title {
            font-size: 16px !important;
            font-weight: 600 !important;
        }
        
        .card .card-body .text-danger,
        .card .card-body .price,
        .card-body .text-danger,
        .card-body .price {
            font-size: 14px !important;
        }
        
        .btn-primary {
            background-color: #2563eb;
            border-color: #2563eb;
        }
        
        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
        }
        
        /* Remove gray background */
        .category-page,
        body,
        html {
            background-color: transparent !important;
            background: transparent !important;
        }
        
        /* Fix container alignment */
        .category-header .container {
            width: 100% !important;
            min-width: 1280px !important;
            max-width: 1440px !important;
            padding-left: 24px !important;
            padding-right: 24px !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        
        /* Content container without padding */
        .category-page .container:not(.category-header .container) {
            width: 100% !important;
            min-width: 1280px !important;
            max-width: 1440px !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: auto !important;
            margin-right: auto !important;
        }
        
        /* Category header white theme */
        .category-header {
            background: white !important;
            color: #333 !important;
            border-bottom: 1px solid #e9ecef !important;
        }
        
        .category-title {
            font-size: 28px !important;
            color: #333 !important;
        }
        
        .category-description {
            font-size: 14px !important;
            color: #666 !important;
        }
        
        .stat-item {
            font-size: 14px !important;
            color: #666 !important;
        }
        
        .stat-item i {
            font-size: 14px !important;
            color: #007bff !important;
        }
        
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <!-- Include Trego Header -->
    @include('layouts.partials.header')

    <!-- Main Content -->
    <main class="py-4">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Include Trego Footer -->
    @include('layouts.partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Global JavaScript functions -->
    <script>
        // Add to cart function
        function addToCart(productId, quantity = 1) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post('{{ route("cart.add") }}', {
                product_id: productId,
                quantity: quantity
            }, function(data) {
                if (data.success) {
                    // Use the header's update function if available
                    if (typeof updateCartCount === 'function') {
                        updateCartCount();
                    }
                    showAlert('success', data.message);
                } else {
                    showAlert('error', data.message);
                }
            }).fail(function(xhr) {
                const response = xhr.responseJSON;
                showAlert('error', response.message || 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng');
            });
        }

        function showAlert(type, message) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `;
            
            // Insert alert at the top of main content
            $('main').prepend('<div class="container">' + alertHtml + '</div>');
            
            // Auto dismiss after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        }
    </script>

    @stack('scripts')
</body>
</html>
