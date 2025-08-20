# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

A mobile-first shopping list web application built with PHP 8, SQLite3, and Bootstrap 5.3. The application allows users to create and manage multiple shopping lists with items that can be checked/unchecked and deleted.

## Technology Stack

- **Backend:** PHP 8.2+ with strict typing
- **Database:** SQLite3 (single file: `shopping_list.sqlite`)
- **Frontend:** HTML5, CSS3, vanilla JavaScript (ES6)
- **CSS Framework:** Bootstrap 5.3 (via CDN)
- **Icons:** Bootstrap Icons (via CDN)
- **Server:** Apache2 (Ubuntu deployment)

## Development Commands

This is a traditional PHP web application without build tools. No package managers (npm/composer) are used.

### Testing the Application

#### Local Development (PHP Built-in Server)
```bash
# Start local PHP development server
php -S localhost:8000
```

#### Docker Development
```bash
# Build and start the container
docker-compose up -d

# View logs
docker-compose logs -f

# Stop the container
docker-compose down

# Rebuild after changes
docker-compose up -d --build
```

#### Traditional Apache Deployment
```bash
# For Apache deployment, ensure proper permissions:
sudo chown -R www-data:www-data /var/www/html/shopper/
sudo chmod -R 755 /var/www/html/shopper/
```

#### Docker Production Deployment
```bash
# Build production image
docker build -t shopper-app .

# Run production container
docker run -d -p 8080:80 --name shopper-web shopper-app
```

### Database Management
- Database file: `shopping_list.sqlite` (auto-created on first run)
- Schema file: `database_schema.sql` (reference only)
- No migrations needed - tables are created automatically via `Database.php`

## Architecture

### Backend Architecture
- **Singleton Database Pattern:** `includes/Database.php` manages PDO connection
- **Single API Endpoint:** `backend/api.php` handles all CRUD operations via action parameter
- **Class-based Models:** 
  - `ShoppingList.php` - manages shopping lists
  - `ListItem.php` - manages list items
- **RESTful-style API:** Uses HTTP methods (GET/POST/PUT/DELETE) with JSON responses

### Frontend Architecture
- **Two-page Application:**
  - `index.php` - displays all shopping lists
  - `list.php` - displays items for a specific list
- **Single JavaScript File:** `js/app.js` handles all frontend logic
- **Page Detection:** JavaScript auto-detects page type and initializes appropriate functionality
- **API Communication:** Async/await fetch calls to single backend endpoint

### Database Schema
- **Two Tables:** `lists` and `items` with CASCADE delete
- **Foreign Key Constraints:** Enabled in SQLite for data integrity
- **Index:** `idx_items_list_id` for performance

## Key Files and Their Purpose

- `index.php` - Main page showing all shopping lists
- `list.php` - Individual list page showing items
- `backend/api.php` - Single API endpoint for all operations
- `includes/Database.php` - Singleton database connection class
- `includes/ShoppingList.php` - Shopping list model class
- `includes/ListItem.php` - List item model class
- `js/app.js` - Frontend JavaScript logic
- `css/style.css` - Custom styles (mobile-first)
- `shopping_list.sqlite` - SQLite database file (auto-created)
- `Dockerfile` - Docker container configuration
- `docker-compose.yml` - Docker Compose orchestration

## Development Guidelines

### PHP Coding Standards
- Use strict typing: `declare(strict_types=1);`
- Follow camelCase for variables and methods
- Use proper type hints for parameters and return types
- Sanitize user input with `htmlspecialchars()`
- Use prepared statements for all database queries

### Frontend Guidelines
- Mobile-first responsive design
- Use Bootstrap 5.3 classes for styling
- Vanilla JavaScript (no frameworks)
- camelCase for JavaScript variables and functions
- Async/await for API calls

### Security Practices
- Input validation and sanitization in PHP
- XSS prevention with `htmlspecialchars()`
- SQL injection prevention with prepared statements
- Foreign key constraints enabled in SQLite

## API Documentation

All API calls go to `backend/api.php` with an `action` parameter:

### Shopping Lists
- `GET ?action=get_lists` - Get all lists
- `POST ?action=add_list` - Create new list
- `DELETE ?action=delete_list&id={list_id}` - Delete list

### List Items  
- `GET ?action=get_items&list_id={list_id}` - Get items for list
- `POST ?action=add_item` - Add new item
- `PUT ?action=toggle_item&id={item_id}` - Toggle item check status
- `DELETE ?action=delete_item&id={item_id}` - Delete item

All responses are JSON with `{"success": true/false, "data": ..., "error": "..."}` format.

## Common Development Tasks

### Adding New Features
1. Modify appropriate model class in `includes/`
2. Add new action case in `backend/api.php`
3. Update frontend JavaScript in `js/app.js`
4. Test manually via browser (no automated tests)

### Database Changes
- Modify schema in `includes/Database.php` `createTables()` method
- Consider data migration for existing databases
- Update `database_schema.sql` for reference

### Styling Changes
- Add custom CSS to `css/style.css`
- Use Bootstrap 5.3 utility classes where possible
- Maintain mobile-first responsive design