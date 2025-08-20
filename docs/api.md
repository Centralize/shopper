# Documentation: API Endpoints

The application uses a single entry point for all backend operations: `/backend/api.php`. It is a RESTful-style API that uses HTTP methods (GET, POST, PUT, DELETE) and query parameters to determine the requested action. All responses are in JSON format.

## General Response Format

Successful responses will have the following structure:
```json
{
  "success": true,
  "data": [ ... ] or { ... }
}
Failed responses will have the following structure:

JSON

{
  "success": false,
  "error": "Error message describing the issue."
}
Shopping List Endpoints
Get All Lists
URL: /backend/api.php?action=get_lists

Method: GET

Description: Retrieves all existing shopping lists.

Success Response (200 OK):

JSON

{
  "success": true,
  "data": [
    {
      "list_id": 1,
      "list_name": "Groceries",
      "created_at": "2025-08-20 20:22:06"
    },
    {
      "list_id": 2,
      "list_name": "Hardware Store",
      "created_at": "2025-08-19 10:00:00"
    }
  ]
}
Add a New List
URL: /backend/api.php?action=add_list

Method: POST

Description: Creates a new shopping list.

Request Body:

JSON

{
  "name": "New List Name"
}
Success Response (200 OK):

JSON

{
  "success": true,
  "data": {
    "list_id": 3,
    "list_name": "New List Name"
  }
}
Delete a List
URL: /backend/api.php?action=delete_list&id={list_id}

Method: DELETE

Description: Deletes a specific list and all its items.

URL Parameters:

id (integer): The ID of the list to delete.

Success Response (200 OK):

JSON

{
  "success": true
}
List Item Endpoints
Get Items for a List
URL: /backend/api.php?action=get_items&list_id={list_id}

Method: GET

Description: Retrieves all items for a specific shopping list.

URL Parameters:

list_id (integer): The ID of the list whose items are to be fetched.

Success Response (200 OK):

JSON

{
  "success": true,
  "data": [
    {
      "item_id": 10,
      "list_id": 1,
      "item_name": "Milk",
      "is_checked": 0
    },
    {
      "item_id": 11,
      "list_id": 1,
      "item_name": "Bread",
      "is_checked": 1
    }
  ]
}
Add a New Item
URL: /backend/api.php?action=add_item

Method: POST

Description: Adds a new item to a specific list.

Request Body:

JSON

{
  "list_id": 1,
  "name": "Eggs"
}
Success Response (200 OK):

JSON

{
  "success": true,
  "data": {
    "item_id": 12,
    "list_id": 1,
    "item_name": "Eggs",
    "is_checked": 0
  }
}
Toggle Item Check State
URL: /backend/api.php?action=toggle_item&id={item_id}

Method: PUT

Description: Toggles the is_checked status of an item.

URL Parameters:

id (integer): The ID of the item to update.

Success Response (200 OK):

JSON

{
  "success": true
}
Delete an Item
URL: /backend/api.php?action=delete_item&id={item_id}

Method: DELETE

Description: Deletes a specific item.

URL Parameters:

id (integer): The ID of the item to delete.

Success Response (200 OK):

JSON

{
  "success": true
}

