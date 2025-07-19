# Furniture E-commerce Website

A complete Laravel-based e-commerce website for furniture, inspired by Nilkamal Furniture, featuring modern design, comprehensive functionality, and mobile responsiveness.

## Features

### Customer Features
- **Product Catalog**: Browse furniture by categories, rooms, brands, and filters
- **Product Search**: Advanced search with filters by price, material, color, room type
- **User Authentication**: Registration, login, profile management
- **Shopping Cart**: Add/remove items, quantity management, persistent cart
- **Wishlist**: Save favorite products for later
- **Checkout Process**: Multiple address management, payment options
- **Order Management**: Order history, tracking, cancellation
- **Product Reviews**: Rate and review purchased products
- **Responsive Design**: Mobile-friendly interface

### Product Management
- **Categories**: Hierarchical category structure (main categories and subcategories)
- **Product Variants**: Multiple images, detailed descriptions, specifications
- **Inventory Management**: Stock tracking, availability status
- **Pricing**: Regular prices, sale prices, discount calculations
- **Product Attributes**: Material, color, dimensions, room type, style

### E-commerce Features
- **Cart Management**: Session-based and user-based carts
- **Multiple Payment Methods**: Cash on Delivery, Razorpay, Stripe integration
- **Order Processing**: Complete order lifecycle management
- **Address Management**: Multiple shipping/billing addresses
- **Tax Calculation**: GST calculation and display
- **Shipping**: Free shipping thresholds, shipping cost calculation

## Technology Stack

- **Backend**: Laravel 10 (PHP 8.1+)
- **Frontend**: Bootstrap 5, jQuery, Font Awesome
- **Database**: MySQL
- **Packages**: 
  - Spatie Laravel Permission (Role-based access)
  - Intervention Image (Image processing)
  - Laravel Sanctum (API authentication)
  - DomPDF (PDF generation)

## Installation

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL
- Node.js & NPM (for frontend assets)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd furniture-ecommerce
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure database**
   Update `.env` file with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=furniture_ecommerce
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations and seed data**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Install and compile frontend assets**
   ```bash
   npm install
   npm run build
   ```

7. **Create storage symlink**
   ```bash
   php artisan storage:link
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

The application will be available at `http://localhost:8000`

## Database Structure

### Core Tables
- **users**: Customer and admin user accounts
- **categories**: Product categories (hierarchical)
- **brands**: Furniture brands
- **products**: Product catalog with specifications
- **addresses**: Customer shipping/billing addresses
- **carts & cart_items**: Shopping cart management
- **orders & order_items**: Order processing and history
- **reviews**: Product reviews and ratings
- **wishlists**: Customer wishlist functionality

## Key Features Implementation

### Product Catalog
- Hierarchical categories (Living Room > Sofas > Recliners)
- Advanced filtering by price, brand, material, color, room type
- Product variants with multiple images
- Stock management and availability tracking

### Shopping Experience
- Guest and registered user shopping carts
- Wishlist functionality for registered users
- Quick product view and comparison
- Advanced search with autocomplete

### Checkout Process
- Multi-step checkout with address selection
- Multiple payment options integration
- Order confirmation and email notifications
- Invoice generation with PDF export

### User Account Features
- Order history and tracking
- Address book management
- Wishlist management
- Product review system

## Configuration

### Payment Gateways
Configure payment methods in `.env`:
```
STRIPE_KEY=your_stripe_publishable_key
STRIPE_SECRET=your_stripe_secret_key
RAZORPAY_KEY=your_razorpay_key
RAZORPAY_SECRET=your_razorpay_secret
```

### Email Configuration
Setup email for order confirmations:
```
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
```

## Admin Panel Features
- Product management (CRUD operations)
- Category and brand management
- Order management and status updates
- User management
- Review moderation
- Inventory tracking
- Sales reports and analytics

## API Endpoints
The application includes RESTful API endpoints for:
- Product catalog browsing
- Cart management
- User authentication
- Order processing
- Wishlist operations

## Security Features
- CSRF protection
- SQL injection prevention
- XSS protection
- Secure authentication
- Role-based access control
- Input validation and sanitization

## Performance Optimizations
- Database query optimization with eager loading
- Image optimization and lazy loading
- Caching for frequently accessed data
- CDN integration for static assets
- Pagination for large datasets

## Mobile Responsiveness
- Bootstrap 5 responsive grid system
- Mobile-optimized navigation
- Touch-friendly interface elements
- Progressive Web App capabilities

## SEO Features
- SEO-friendly URLs
- Meta tags optimization
- Open Graph tags
- Structured data markup
- Sitemap generation

## Contributing
1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## Support
For support and questions, please contact:
- Email: info@furniturestore.com
- Phone: +91 1800-123-4567

## License
This project is licensed under the MIT License - see the LICENSE file for details.

## Acknowledgments
- Design inspiration from Nilkamal Furniture website
- Laravel community for excellent documentation
- Bootstrap team for the responsive framework
- Contributors and testers who helped improve the application
