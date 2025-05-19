## Overview
1. User Authentication and Role-Based Dashboard
2. RESTful API for a Blog System
3. Optimizing Database Queries for an Order Management System
4. File Upload System with Queued Processing

Ensure you have the following installed:
PHP >= 8.1
Laravel >= 10.x
MySQL

# Install dependencies
composer install

# Generate application key
php artisan key:generate

# Run database migrations and seeders
php artisan migrate --seed

# Generate JWT secret
php artisan jwt:secret

# Link storage
php artisan storage:link

# Start queue worker
php artisan queue:work

1. User Authentication & Role-Based Dashboard
#User Type -> 1 admin. 2 user

Test Credentials

# admin
email : admin@gmail.com
password: password

# user
email : user@gmail.com
password : password

2. RESTful API for a Blog System

# run
php artisan l5-swagger:generate

http://127.0.0.1:8000/api/documentation

3. Optimizing Database Queries for an Order Management System

## Optimization Technique
- **Eager Loading:** Eliminates N+1 problem by preloading related models.
- **Indexing:** Speeds up lookup on foreign key columns.

Before Optimization

After Optimization

# Tools
 Laravel Debugbar for monitoring query performance
 Microtime for manual time

4. File Upload System with Queued Processing

# Set queue connection to database in .env

QUEUE_CONNECTION=database

# Create queue tables
php artisan queue:table
php artisan migrate

# Start queue worker
php artisan queue:work