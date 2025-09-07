<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\SellerController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\InsuranceOfferingController;
use App\Http\Controllers\Api\SellerMenuController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Api\PropertyController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('send-otp', [AuthController::class, 'sendOtp']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});

// Public home routes
Route::get('get-sellers', [SellerController::class, 'getSellers']);
Route::prefix('home')->group(function () {
    Route::get('featured-products', [HomeController::class, 'getFeaturedProducts']);
    Route::get('seller-categories', [HomeController::class, 'getSellerCategories']);
    Route::get('product-categories', [HomeController::class, 'getProductCategories']);
    Route::get('products/category/{categoryId}', [HomeController::class, 'getProductsBySellerCategory']);
    Route::get('products/search', [HomeController::class, 'searchProducts']);
    Route::get('products/{id}', [HomeController::class, 'getProductDetails']);
});

// Protected routes
Route::middleware('auth:api')->group(function () {
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
    });

    // Seller routes
    Route::prefix('seller')->middleware('role:seller')->group(function () {
    Route::get('profile', [SellerController::class, 'getSellerProfile']);
    Route::put('profile', [SellerController::class, 'updateSellerProfile']);
        Route::get('products', [SellerController::class, 'getProducts']);
        Route::post('products', [SellerController::class, 'createProduct']);
        Route::put('products/{id}', [SellerController::class, 'updateProduct']);
        Route::delete('products/{id}', [SellerController::class, 'deleteProduct']);

        // Seller related resources (CRUD) - explicit route groups
        Route::group(['prefix' => 'books'], function () {
            Route::get('/', [BookController::class, 'index']);
            Route::post('store', [BookController::class, 'store']);
            Route::post('update/{id}', [BookController::class, 'update']);
            Route::get('{id}', [BookController::class, 'show']);
            Route::delete('{id}', [BookController::class, 'destroy']);
        });

        Route::group(['prefix' => 'services'], function () {
            Route::get('/', [ServiceController::class, 'index']);
            Route::post('store', [ServiceController::class, 'store']);
            Route::post('update/{id}', [ServiceController::class, 'update']);
            Route::get('{id}', [ServiceController::class, 'show']);
            Route::delete('{id}', [ServiceController::class, 'destroy']);
        });

        Route::group(['prefix' => 'insurance-offerings'], function () {
            Route::get('/', [InsuranceOfferingController::class, 'index']);
            Route::post('store', [InsuranceOfferingController::class, 'store']);
            Route::post('update/{id}', [InsuranceOfferingController::class, 'update']);
            Route::get('{id}', [InsuranceOfferingController::class, 'show']);
            Route::delete('{id}', [InsuranceOfferingController::class, 'destroy']);
        });

        Route::group(['prefix' => 'menus'], function () {
            Route::get('/', [SellerMenuController::class, 'index']);
            Route::post('store', [SellerMenuController::class, 'store']);
            Route::post('update/{id}', [SellerMenuController::class, 'update']);
            Route::get('{id}', [SellerMenuController::class, 'show']);
            Route::delete('{id}', [SellerMenuController::class, 'destroy']);
        });

        Route::group(['prefix' => 'vehicles'], function () {
            Route::get('/', [VehicleController::class, 'index']);
            Route::post('store', [VehicleController::class, 'store']);
            Route::post('update/{id}', [VehicleController::class, 'update']);
            Route::get('{id}', [VehicleController::class, 'show']);
            Route::delete('{id}', [VehicleController::class, 'destroy']);
        });

        Route::group(['prefix' => 'properties'], function () {
            Route::get('/', [PropertyController::class, 'index']);
            Route::post('store', [PropertyController::class, 'store']);
            Route::post('update/{id}', [PropertyController::class, 'update']);
            Route::get('{id}', [PropertyController::class, 'show']);
            Route::delete('{id}', [PropertyController::class, 'destroy']);
        });
    });

    // Admin routes
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        // Add admin-specific routes here
    });

    // Buyer routes
    Route::prefix('buyer')->middleware('role:buyer')->group(function () {
        // Add buyer-specific routes here
    });
});

// General seller category routes (accessible by all authenticated users)
Route::middleware('auth:api')->get('seller-categories', [SellerController::class, 'getSellerCategories']);

// File management routes
Route::middleware('auth:api')->group(function () {
    Route::prefix('files')->group(function () {
        Route::post('upload', [FileController::class, 'upload']);
        Route::post('bulk-upload', [FileController::class, 'bulkUpload']);
        Route::get('/', [FileController::class, 'index']);
        Route::get('category/{category}', [FileController::class, 'getByCategory']);
        Route::get('{id}', [FileController::class, 'show']);
        Route::get('{id}/download', [FileController::class, 'download']);
        Route::put('{id}', [FileController::class, 'update']);
        Route::delete('{id}', [FileController::class, 'destroy']);
    });
});
