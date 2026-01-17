# Chibi Bites - Laravel E-commerce Site

A complete, responsive e-commerce application built with Laravel and deployed on Vercel with Supabase PostgreSQL database.

## Features

- **Responsive Design**: Optimized for all screen sizes (4/3/2 products per row on large/medium/small screens)
- **User Authentication**: Registration, login, and user management
- **Shopping Cart**: Add, update, and remove items from cart
- **Order Processing**: Complete order management system
- **Product Catalog**: Dynamic product display with images and descriptions
- **Supabase Integration**: PostgreSQL database with real-time capabilities
- **Vercel Deployment**: Serverless hosting with global CDN

## Tech Stack

- **Backend**: Laravel 11 (PHP)
- **Frontend**: Bootstrap 5 + SCSS
- **Database**: Supabase PostgreSQL
- **Deployment**: Vercel (Serverless)
- **Build Tool**: Vite
- **Authentication**: Laravel Sanctum

## Setup Instructions

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- Git

### Local Development

1. **Clone the repository**
   ```bash
   git clone https://github.com/txiaoqt/chibi_bites.git
   cd chibi_bites
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Build assets**
   ```bash
   npm run build
   ```

5. **Environment setup**
   - Copy `.env.example` to `.env`
   - Configure your database settings
   - Generate application key: `php artisan key:generate`

6. **Database setup**
   - Run Supabase schema from `supabase-schema.sql`
   - Update database credentials in `.env`

7. **Start development server**
   ```bash
   php artisan serve
   ```

## Deployment

This application is configured for Vercel deployment with the following setup:

- **Laravel app** restructured to root directory
- **Supabase connection pooler** for optimal performance
- **Serverless functions** for API routes
- **Static asset serving** optimized for Vercel

### Environment Variables

See `.env.vercel` for all required environment variables for Vercel deployment.

## Database Schema

The application uses the following database tables:
- `users` - User accounts
- `products` - Product catalog
- `orders` - Customer orders
- `order_items` - Order line items
- `cart_items` - Shopping cart items

Run the SQL in `supabase-schema.sql` to set up your Supabase database.

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## License

This project is open source and available under the [MIT License](LICENSE).
