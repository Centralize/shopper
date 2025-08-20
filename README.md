---

## File: /README.md

```markdown
# Shopping List Web Application

A simple, fast, and mobile-first shopping list web application built with PHP 8, SQLite3, and Bootstrap. It is designed for efficient use on smartphones and touch devices.

## Features

-   Create and manage multiple shopping lists.
-   Add items to any list.
-   Check and uncheck items with a single tap.
-   Delete lists and items.
-   Mobile-first, responsive, and touch-friendly interface.
-   Data is persisted in a local SQLite database on the server.

## Technology Stack

-   **Backend:** PHP 8.2+
-   **Database:** SQLite 3
-   **Frontend:** HTML5, CSS3, JavaScript (ES6)
-   **Frameworks:** Bootstrap 5.3 (CSS + JS via CDN)

## Directory Structure

/
├── backend/
│   └── api.php             # Single API endpoint for all actions
├── css/
│   └── style.css           # Custom styles for the application
├── docs/
│   ├── api.md              # API endpoint documentation
│   ├── backend.md          # PHP class documentation
│   └── database.md         # Database schema documentation
├── images/                 # For image assets
├── includes/
│   ├── Database.php        # Singleton PDO database connector
│   ├── ListItem.php        # Class for managing list items
│   └── ShoppingList.php    # Class for managing shopping lists
├── modules/                # For modular components
├── index.php               # Main page: displays all shopping lists
├── list.php                # Displays items for a single shopping list
├── js/
│   └── app.js              # Frontend JavaScript logic
└── README.md               # This file


## Setup and Installation on Ubuntu 24.04 with Apache

### 1. Prerequisites

Ensure you have a running Ubuntu 24.04 server with Apache2 and PHP 8 installed.

```bash
# Update package lists
sudo apt update

# Install Apache2, PHP, and the SQLite3 extension for PHP
sudo apt install apache2 php libapache2-mod-php php-sqlite3 -y
2. Deploy Application Files
Copy the entire application directory structure to your Apache web root, typically /var/www/html/. For this guide, we'll assume you place it in a subdirectory called shopping-list.

Bash

# Example: Copying files to /var/www/html/shopping-list/
sudo cp -R . /var/www/html/shopping-list/
3. Set Permissions
The web server needs permission to write to the application's root directory to create and modify the shopping_list.sqlite database file.

Bash

# Navigate to your web root
cd /var/www/html/

# Change ownership of the app directory to the web server user (www-data)
sudo chown -R www-data:www-data shopping-list/

# Set appropriate permissions for the directory
sudo chmod -R 755 shopping-list/
4. Configure Apache (Optional but Recommended)
For cleaner URLs and better security, it's good practice to configure a virtual host. However, the application will work out-of-the-box in a subdirectory.

Ensure Apache is running:

Bash

sudo systemctl start apache2
sudo systemctl enable apache2
5. Access the Application
The application is now ready. The database and tables will be created automatically on the first visit.

Open your web browser and navigate to: http://your_server_ip/shopping-list/

How to Use
Home Page (index.php):

You will see a list of your current shopping lists.

To create a new list, type a name in the input field at the bottom of the screen and press the "Add List" button.

To delete a list, tap the trash can icon next to its name. This will delete the list and all items within it permanently.

Tap on a list name to view its items.

List Page (list.php):

The name of the current list is displayed in the header.

To add a new item, type its name in the input field at the bottom and tap "Add Item".

To check or uncheck an item, tap anywhere on the item's row (except the delete button).

To delete an item, tap the 'X' button on the far right of its row.

Use the back arrow in the header to return to the main list of lists.
