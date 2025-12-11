# Blog Application

A full-featured blog application built with CodeIgniter 4, featuring blog post management, commenting system, and an admin panel.

## Project Overview

This is a blog application that allows users to:
- **View blog posts** on the public homepage
- **Read individual blog posts** with detailed content
- **Add comments** to blog posts with name and email validation
- **Admin panel** for creating, editing, and deleting blog posts
- **Multiple post management interfaces** for different use cases

### Key Features

- 🔐 **Blog Post Management** - Full CRUD operations for blog posts
- 💬 **Commenting System** - Users can add comments to blog posts
- 👤 **Author Attribution** - Each blog post has an associated author
- 📝 **Content Validation** - Form validation for posts and comments
- 🎨 **Responsive Views** - Organized view structure for home and admin areas
- 🗄️ **Database Migrations** - Automated database schema management

### Technology Stack

- **Framework**: CodeIgniter 4
- **PHP Version**: 8.1 or higher
- **Database**: MySQL/MariaDB
- **Backend**: MVC architecture with Models, Controllers, and Views
- **Testing**: PHPUnit for unit testing

## Database Schema

The application uses two main tables:

1. **blog_posts**
   - id (Primary Key)
   - title (VARCHAR 255)
   - content (TEXT)
   - author (VARCHAR 100)
   - created_at (DATETIME)
   - updated_at (DATETIME)

2. **comments**
   - id (Primary Key)
   - post_id (Foreign Key → blog_posts.id)
   - name (VARCHAR 100)
   - email (VARCHAR 100)
   - comment (TEXT)
   - created_at (DATETIME)
   - updated_at (DATETIME)

## Setup Instructions

Follow these steps to set up the project locally:

### Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL or MariaDB
- Web server (Apache/Nginx) or PHP built-in server

**Required PHP Extensions:**
- intl
- mbstring
- json
- mysqlnd (for MySQL)
- libcurl

### Step 1: Clone the Repository

```bash
git clone <repository-url>
cd blogapplication
```

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Configure Environment

1. Copy the `env` file to `.env`:
   ```bash
   copy env .env
   ```
   (On Linux/Mac: `cp env .env`)

2. Edit `.env` file and configure the following:

   **Database Configuration:**
   ```ini
   database.default.hostname = localhost
   database.default.database = blogapp
   database.default.username = root
   database.default.password = your_password
   database.default.DBDriver = MySQLi
   database.default.port = 3306
   ```

   **Base URL:**
   ```ini
   app.baseURL = 'http://localhost:8080/'
   ```

   **Environment:**
   ```ini
   CI_ENVIRONMENT = development
   ```

### Step 4: Create Database

Create a MySQL database named `blogapp`:

```sql
CREATE DATABASE blogapp CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

### Step 5: Run Migrations

Run the database migrations to create the required tables:

```bash
php spark migrate
```

This will create the `blog_posts` and `comments` tables.

### Step 6: File Permissions (Linux/Mac)

Make the `writable` directory writable:

```bash
chmod -R 777 writable/
```

On Windows, ensure the `writable` folder has write permissions.

## Running the Project

### Option 1: Using PHP Built-in Server (Recommended for Development)

```bash
php spark serve
```

The application will be available at: `http://localhost:8080`

### Option 2: Using XAMPP/WAMP

1. Configure your virtual host to point to the `public` folder
2. Or access via: `http://localhost/blogapplication/public/`

### Option 3: Using Apache/Nginx

Configure your web server to point the document root to the `public` folder:

**Apache Virtual Host Example:**
```apache
<VirtualHost *:80>
    ServerName blogapp.local
    DocumentRoot "d:/GitHub/blogapplication/public"
    
    <Directory "d:/GitHub/blogapplication/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

**Nginx Configuration Example:**
```nginx
server {
    listen 80;
    server_name blogapp.local;
    root /path/to/blogapplication/public;
    
    index index.php index.html;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        include fastcgi_params;
    }
}
```

## Application Routes

### Public Routes
- `GET /` - Homepage (list all blog posts)
- `GET /post/{id}` - View single blog post with comments
- `POST /post/comment` - Add a comment to a blog post

### Post Management Routes
- `GET /posts` - List all posts
- `GET /posts/create` - Create new post form
- `POST /posts/store` - Store new post
- `GET /posts/edit/{id}` - Edit post form
- `POST /posts/update/{id}` - Update post
- `POST /posts/delete/{id}` - Delete post

### Admin Routes
- `GET /admin/blog-posts` - Admin blog posts list
- `GET /admin/blog-posts/create` - Create blog post form
- `POST /admin/blog-posts/store` - Store blog post
- `GET /admin/blog-posts/edit/{id}` - Edit blog post form
- `POST /admin/blog-posts/update/{id}` - Update blog post
- `POST /admin/blog-posts/delete/{id}` - Delete blog post

## Testing

Run the test suite using PHPUnit:

```bash
composer test
```

Or directly:

```bash
vendor\bin\phpunit
```

## Project Structure

```
blogapplication/
├── app/
│   ├── Controllers/
│   │   ├── BaseController.php
│   │   ├── HomeController.php      # Public blog views
│   │   ├── PostController.php      # Post management
│   │   └── Admin/
│   │       └── BlogPostController.php  # Admin blog management
│   ├── Models/
│   │   ├── BlogPostModel.php       # Blog posts model
│   │   ├── CommentModel.php        # Comments model
│   │   └── PostModel.php           # Alternative posts model
│   ├── Views/
│   │   ├── home/                   # Public views
│   │   │   ├── index.php           # Homepage
│   │   │   └── show.php            # Single post view
│   │   ├── posts/                  # Post management views
│   │   │   ├── index.php
│   │   │   ├── create.php
│   │   │   └── edit.php
│   │   └── admin/                  # Admin views
│   │       └── blog_posts/
│   ├── Database/
│   │   └── Migrations/             # Database migrations
│   └── Config/                     # Configuration files
├── public/                         # Public web root
│   └── index.php                   # Application entry point
├── writable/                       # Writable directories
│   ├── cache/
│   ├── logs/
│   └── uploads/
├── vendor/                         # Composer dependencies
└── composer.json
```

## Credits

Built with [CodeIgniter 4](https://codeigniter.com) - A PHP full-stack web framework that is light, fast, flexible and secure.
