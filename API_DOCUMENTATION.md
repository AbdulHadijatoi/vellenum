# Vellenum API Documentation

## Overview
This Laravel application provides a comprehensive marketplace API with support for multiple seller categories, role-based authentication, and product management.

## Features Implemented

### 1. Authentication System
- **Registration**: Support for Admin, Seller, and Buyer roles
- **Login**: JWT token-based authentication using Laravel Passport
- **OTP Verification**: Email verification with OTP (currently returned in response)
- **Password Reset**: Forgot password and reset functionality
- **Logout**: Token revocation

### 2. Role-Based Access Control
- **Admin**: Full access to all features
- **Seller**: Can manage their profile, products, and services
- **Buyer**: Can view and search products

### 3. Seller Categories
The system supports 14 different seller categories:
1. Restaurant
2. Apparel
3. Fleet
4. Automobile Sales Representative
5. Car Rental Marketplace
6. Car Wash
7. Insurance Marketplace
8. Digital Bookstore
9. Real Estate Broker
10. Black Clothing Lines & Accessories
11. LegalShield Marketplace
12. Barber Beauty Salon
13. Personal Injury Attorney
14. Mississippi Catfish Company

### 4. Database Structure
- **Users Table**: Common fields for all user types
- **Sellers Table**: Comprehensive fields for all seller categories
- **Products Table**: Flexible product/service management
- **Product Categories**: Organized product classification
- **Seller Categories**: Predefined seller types

## API Endpoints

### Public Endpoints
```
GET /api/home/seller-categories - Get all seller categories
GET /api/home/product-categories - Get all product categories
GET /api/home/featured-products - Get featured products from each category
GET /api/home/products/category/{id} - Get products by seller category
GET /api/home/products/search - Search products
GET /api/home/products/{id} - Get product details
```

### Authentication Endpoints
```
POST /api/auth/register - User registration
POST /api/auth/login - User login
POST /api/auth/send-otp - Send OTP for verification
POST /api/auth/verify-otp - Verify OTP
POST /api/auth/forgot-password - Send password reset OTP
POST /api/auth/reset-password - Reset password
POST /api/auth/logout - Logout (requires authentication)
```

### Seller Endpoints (Protected)
```
GET /api/seller/profile - Get seller profile
PUT /api/seller/profile - Update seller profile
GET /api/seller/products - Get seller's products
POST /api/seller/products - Create new product
PUT /api/seller/products/{id} - Update product
DELETE /api/seller/products/{id} - Delete product
```

## Key Features

### 1. Flexible Seller Registration
- Single registration API that handles all seller categories
- Dynamic field validation based on selected category
- Comprehensive field support for all business types

### 2. Product Management
- Support for both products and services
- Image upload capabilities
- Category-based organization
- Search and filtering

### 3. Security
- Laravel Passport for API authentication
- Spatie Laravel Permission for role management
- Input validation and sanitization
- CSRF protection

### 4. Scalability
- Modular design with separate controllers
- Flexible database schema
- JSON fields for dynamic data storage
- Pagination support

## Installation & Setup

1. **Install Dependencies**
   ```bash
   composer install
   ```

2. **Environment Setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed --class=RolePermissionSeeder
   php artisan db:seed --class=SellerCategorySeeder
   ```

4. **Passport Setup**
   ```bash
   php artisan passport:install
   ```

5. **Start Server**
   ```bash
   php artisan serve
   ```

## Testing the API

### Registration Example
```bash
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test Seller",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123",
    "business_name": "Test Restaurant",
    "business_email": "business@test.com",
    "business_phone": "1234567890",
    "business_address": "123 Test St",
    "country": "USA",
    "state": "CA",
    "city": "Los Angeles",
    "zip_code": "90210",
    "seller_category_id": 1,
    "role": "seller"
  }'
```

### Login Example
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password123"
  }'
```

## Notes

- OTP is currently returned in API responses as SMTP is not configured
- All seller category fields are optional to accommodate different business types
- The system is designed to be easily extensible for new seller categories
- File uploads are stored in the `storage/app/public` directory

## Next Steps

1. Configure SMTP for email functionality
2. Add admin dashboard endpoints
3. Implement order management system
4. Add payment integration
5. Create frontend application
6. Add API documentation with Swagger/OpenAPI
