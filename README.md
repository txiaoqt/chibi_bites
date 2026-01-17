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

Before you begin, ensure you have the following software installed on your system:

#### Required Software
- **PHP 8.2 or higher** - The backend language
  - Download from: https://www.php.net/downloads.php
  - Make sure to enable extensions: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`
- **Composer** - PHP dependency manager
  - Download from: https://getcomposer.org/download/
  - Verify installation: `composer --version`
- **Node.js & NPM** - JavaScript runtime and package manager
  - Download from: https://nodejs.org/ (LTS version recommended)
  - Verify installation: `node --version` and `npm --version`
- **Git** - Version control system
  - Download from: https://git-scm.com/downloads
  - Verify installation: `git --version`

#### Optional but Recommended
- **Visual Studio Code** - IDE with great Laravel/PHP support
- **Git Bash** (Windows) or Terminal (macOS/Linux) - Command line interface

### Local Development Setup

Follow these steps to set up the project locally:

#### 1. Clone the Repository
```bash
# Open your terminal/command prompt and navigate to your desired directory
cd /path/to/your/projects/folder

# Clone the repository
git clone https://github.com/txiaoqt/chibi_bites.git

# Navigate into the project directory
cd chibi_bites
```

#### 2. Install PHP Dependencies
```bash
# This installs all Laravel and PHP packages listed in composer.json
composer install

# This command may take a few minutes to complete
# You should see output showing package installations
```

#### 3. Install Node.js Dependencies
```bash
# This installs all frontend dependencies (Bootstrap, Vite, etc.)
npm install

# This may take a few minutes to download packages
```

#### 4. Build Frontend Assets
```bash
# Compile SCSS to CSS and bundle JavaScript
npm run build

# For development with hot reloading, use:
# npm run dev
```

#### 5. Environment Configuration
```bash
# Copy the example environment file
cp .env.example .env

# Generate a unique application key for Laravel
php artisan key:generate
```

#### 6. Database Setup with Supabase

**Option A: Using Supabase (Recommended)**

1. **Create a Supabase Account**
   - Go to https://supabase.com/
   - Sign up for a free account
   - Create a new project

2. **Set up Database**
   - In your Supabase dashboard, go to the SQL Editor
   - Copy the contents of `supabase-schema.sql`
   - Run the SQL to create all necessary tables

3. **Get Database Credentials**
   - Go to Settings > Database in your Supabase project
   - Copy the connection details

4. **Configure Environment Variables**
   - Open `.env` file
   - Update the database section:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=db.your-project-ref.supabase.co
   DB_PORT=5432
   DB_DATABASE=postgres
   DB_USERNAME=postgres
   DB_PASSWORD=your-database-password
   ```

**Option B: Using Local SQLite (For Quick Testing)**
```bash
# Create SQLite database file
touch database/database.sqlite

# Update .env file:
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/chibi_bites/database/database.sqlite
```

#### 7. Database Migration (Optional)
```bash
# Run database migrations (only if using MySQL/PostgreSQL locally)
php artisan migrate

# If you want to seed with sample data:
php artisan db:seed
```

#### 8. Start the Development Server
```bash
# Start Laravel's built-in development server
php artisan serve

# You should see output like:
# Laravel development server started: http://127.0.0.1:8000
```

#### 9. Access Your Application
- Open your web browser
- Navigate to: `http://127.0.0.1:8000`
- You should see the Chibi Bites homepage

### Development Workflow

#### Frontend Development
```bash
# For development with hot reloading (recommended)
npm run dev

# This will watch for changes and automatically rebuild assets
```

#### Database Changes
```bash
# Create a new migration
php artisan make:migration create_example_table

# Run migrations
php artisan migrate

# Create a seeder for sample data
php artisan make:seeder ProductSeeder
```

#### Cache Management
```bash
# Clear all Laravel caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## Hosting with Supabase

### Step-by-Step Supabase Setup

#### 1. Create Supabase Project
1. Go to https://supabase.com/
2. Sign up/Login to your account
3. Click "New Project"
4. Fill in project details:
   - **Name**: `chibi-bites` (or your preferred name)
   - **Database Password**: Choose a strong password
   - **Region**: Select closest to your users

#### 2. Database Configuration
1. Wait for project creation to complete (2-3 minutes)
2. Go to **SQL Editor** in your project dashboard
3. Copy the entire contents of `supabase-schema.sql`
4. Paste and run the SQL to create tables:
   - `users` - User accounts
   - `products` - Product catalog
   - `orders` - Customer orders
   - `order_items` - Order details
   - `cart_items` - Shopping cart

#### 3. Get Connection Details
1. Go to **Settings** > **Database** in your Supabase dashboard
2. Copy the following information:
   - **Host**: `db.your-project-ref.supabase.co`
   - **Database name**: `postgres`
   - **Port**: `5432`
   - **Username**: `postgres`
   - **Password**: Your database password

#### 4. Update Environment Variables
For local development, update your `.env` file:
```env
DB_CONNECTION=pgsql
DB_HOST=db.your-project-ref.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-database-password
```

#### 5. Test Connection
```bash
# Test database connection
php artisan migrate:status

# If successful, you'll see table statuses
```

### Supabase Features Used

- **PostgreSQL Database**: Primary data storage
- **Row Level Security (RLS)**: Automatic security policies
- **Real-time Subscriptions**: For live updates (future feature)
- **Supabase Auth**: User authentication (can be integrated)

### Production Deployment

The application is configured for Vercel deployment:

#### Environment Variables for Vercel
Copy the values from `.env.vercel` and add them to your Vercel project settings:

```env
APP_NAME="Chibi Bites"
APP_ENV=production
APP_KEY=your-generated-key
APP_DEBUG=false
APP_URL=https://your-vercel-domain.vercel.app

DB_CONNECTION=pgsql
DB_HOST=db.your-project-ref.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-database-password
```

#### Vercel Deployment Steps
1. Connect your GitHub repository to Vercel
2. Configure environment variables
3. Deploy automatically on git push

## Troubleshooting

### Common Issues

#### Composer Install Fails
```bash
# Clear composer cache
composer clear-cache

# Update composer
composer self-update

# Try install again
composer install
```

#### NPM Install Fails
```bash
# Clear npm cache
npm cache clean --force

# Delete node_modules and package-lock.json
rm -rf node_modules package-lock.json

# Reinstall
npm install
```

#### Database Connection Issues
```bash
# Test database connection
php artisan tinker

# In tinker console:
DB::connection()->getPdo();
exit;
```

#### Permission Issues
```bash
# Fix storage permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Or on Windows:
# Right-click folders > Properties > Security > Edit permissions
```

#### Build Errors
```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild assets
npm run build
```

## Project Structure

```
chibi_bites/
├── app/                    # Laravel application code
│   ├── Http/Controllers/   # Controllers
│   ├── Models/            # Eloquent models
│   └── Providers/         # Service providers
├── bootstrap/             # Laravel bootstrap files
├── config/                # Configuration files
├── database/              # Database migrations and seeders
├── public/                # Public assets (CSS, JS, images)
├── resources/             # Views and raw assets
│   ├── css/              # SCSS files
│   ├── js/               # JavaScript files
│   └── views/            # Blade templates
├── routes/                # Route definitions
├── storage/               # File storage
├── tests/                 # Test files
├── .env.example          # Environment template
├── composer.json         # PHP dependencies
├── package.json          # Node dependencies
├── vite.config.js        # Build configuration
└── supabase-schema.sql   # Database schema
```

## Support

If you encounter issues:
1. Check the troubleshooting section above
2. Review Laravel and Supabase documentation
3. Check GitHub issues for similar problems
4. Create a new issue with detailed error messages

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
