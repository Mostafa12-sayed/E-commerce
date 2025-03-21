# E-Commerce Platform

A modern e-commerce platform built with Laravel, featuring social authentication, cart management, and integrated payment processing.

## Features

- **User Authentication**
  - Traditional email/password registration and login
  - Social authentication via Facebook and Google
  - Password recovery

- **Product Management**
  - Browse products by category
  - Search functionality
  - Product details with images, descriptions, and pricing

- **Shopping Cart**
  - Add/remove products
  - Update quantities
  - Persistent cart (saved between sessions)

- **Checkout Process**
  - Address information
  - Order summary
  - Multiple payment options

- **Payment Processing**
  - Integration with PayMob payment gateway
  - Secure payment processing
  - Order tracking

## Installation

### Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL database
- Node.js and npm

### Setup

1. Clone the repository
   ```bash
   git clone https://github.com/yourusername/ecommerce-platform.git
   cd ecommerce-platform
   ```

2. Install PHP dependencies
   ```bash
   composer install
   ```

3. Install JavaScript dependencies
   ```bash
   npm install && npm run dev
   ```

4. Create and configure environment file
   ```bash
   cp .env.example .env
   ```

5. Generate application key
   ```bash
   php artisan key:generate
   ```

6. Configure database in `.env` file
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password
   ```

7. Run migrations and seed data
   ```bash
   php artisan migrate --seed
   ```

8. Create storage link
   ```bash
   php artisan storage:link
   ```

9. Start the development server
   ```bash
   php artisan serve
   ```

## Social Authentication Setup

### Facebook Login

1. Create a Facebook App at [Facebook Developers](https://developers.facebook.com/)
2. Set up Facebook Login product
3. Configure your OAuth redirect URI as `https://your-domain.com/auth/facebook/callback`
4. Add your App ID and Secret to `.env`:
   ```
   FACEBOOK_CLIENT_ID=your_app_id
   FACEBOOK_CLIENT_SECRET=your_app_secret
   FACEBOOK_REDIRECT_URI=https://your-domain.com/auth/facebook/callback
   ```

### Google Login

1. Create a project in [Google Cloud Console](https://console.cloud.google.com/)
2. Enable the Google+ API and OAuth
3. Configure your authorized redirect URI as `https://your-domain.com/auth/google/callback`
4. Add your credentials to `.env`:
   ```
   GOOGLE_CLIENT_ID=your_client_id
   GOOGLE_CLIENT_SECRET=your_client_secret
   GOOGLE_REDIRECT_URI=https://your-domain.com/auth/google/callback
   ```

## Usage Guide

### User Registration and Login

1. Traditional Registration:
   - Navigate to `/register`
   - Fill out the form with name, email, password, and phone number
   - Click "Register"

2. Social Authentication:
   - On the login page, click "Login with Facebook" or "Login with Google"
   - Allow the requested permissions
   - You'll be automatically registered and logged in

### Product Management

1. Browse Products:
   - Visit the homepage to see featured products
   - Use category navigation to filter products
   - Use search functionality to find specific items

2. Add to Cart:
   - On product page, select quantity
   - Click "Add to Cart"
   - View cart summary in the navigation bar

### Cart Management

1. View Cart:
   - Click on cart icon in navigation bar
   - Review all items in your cart

2. Update Cart:
   - Adjust quantities using the quantity controls
   - Remove items by clicking the "Remove" button
   - Cart totals will update automatically

### Checkout Process

1. Initiate Checkout:
   - From the cart page, click "Proceed to Checkout"
   - Fill in or select delivery address

2. Choose Payment Method:
   - Select "Cash on Delivery" or "Pay Online"
   - For "Cash on Delivery", your order will be placed immediately
   - For "Pay Online", you'll proceed to payment

### Payment with PayMob

1. Online Payment:
   - After choosing "Pay Online" in checkout
   - You'll be redirected to the payment page
   - Enter your card details in the secure iframe
   - Complete the payment process

2. Payment Verification:
   - After payment, you'll be redirected back to the store
   - You'll see a confirmation page if payment succeeds
   - Your order status will be updated accordingly

## Payment Flow

Our application implements a secure payment flow with the PayMob gateway:

1. **Order Creation**
   - Order is created in the database with status "pending"
   - Order items are associated with the order

2. **Payment Initiation**
   - Payment details are registered with PayMob
   - User is presented with a secure payment iframe

3. **Payment Processing**
   - Payment is processed securely by PayMob
   - PayMob sends callback to our application with payment status

4. **Order Completion**
   - On successful payment, order status changes to "processing"
   - On failed payment, order remains "pending" for retry
   - Successful orders trigger the order fulfillment process

## Error Handling

The application handles various error scenarios:

- If a user closes the payment page before completing payment, the order remains in "pending" status
- If payment fails, users can retry payment without creating a new order
- Session timeout during payment is handled by re-authenticating the user when they return

## Technical Implementation

- Uses Laravel Socialite for social authentication
- Implements repository pattern for cart management
- Uses events and listeners for order processing
- Implements a robust payment flow with PayMob integration
- Handles session management during external payment flows

## License

[MIT License](LICENSE)
