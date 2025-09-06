<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Seller;
use App\Models\SellerCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getFeaturedProducts()
    {
        // Get 4 products from each seller category
        $sellerCategories = SellerCategory::where('is_active', true)->get();
        $featuredProducts = [];

        foreach ($sellerCategories as $category) {
            $products = Product::whereHas('seller', function ($query) use ($category) {
                $query->where('seller_category_id', $category->id)
                      ->where('is_approved', true);
            })
            ->where('is_active', true)
            ->where('is_featured', true)
            ->with(['seller.user', 'productCategory', 'imageFile', 'images.file'])
            ->limit(4)
            ->get();

            if ($products->count() > 0) {
                $featuredProducts[] = [
                    'category' => $category,
                    'products' => $products
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => $featuredProducts
        ]);
    }

    public function getProductsBySellerCategory(Request $request, $categoryId)
    {
        $category = SellerCategory::find($categoryId);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Seller category not found'
            ], 404);
        }

        $query = Product::whereHas('seller', function ($query) use ($categoryId) {
            $query->where('seller_category_id', $categoryId)
                  ->where('is_approved', true);
        })
        ->where('is_active', true)
        ->with(['seller.user', 'productCategory', 'imageFile', 'images.file']);

        // Apply filters
        if ($request->has('product_category_id')) {
            $query->where('product_category_id', $request->product_category_id);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        if (in_array($sortBy, ['title', 'price', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->paginate(15);

        return response()->json([
            'success' => true,
            'data' => [
                'category' => $category,
                'products' => $products
            ]
        ]);
    }

    public function getProductCategories()
    {
        $categories = ProductCategory::where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function getSellerCategories()
    {
        $categories = SellerCategory::where('is_active', true)->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    public function getProductDetails($id)
    {
        $product = Product::with(['seller.user', 'seller.sellerCategory', 'productCategory', 'imageFile', 'images.file'])
            ->where('is_active', true)
            ->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // Get related products from the same seller
        $relatedProducts = Product::where('seller_id', $product->seller_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'product' => $product,
                'related_products' => $relatedProducts
            ]
        ]);
    }

    public function searchProducts(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with(['seller.user', 'seller.sellerCategory', 'productCategory', 'imageFile', 'images.file']);

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('seller_category_id')) {
            $query->whereHas('seller', function ($q) use ($request) {
                $q->where('seller_category_id', $request->seller_category_id);
            });
        }

        if ($request->has('product_category_id')) {
            $query->where('product_category_id', $request->product_category_id);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        if (in_array($sortBy, ['title', 'price', 'created_at'])) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }
}