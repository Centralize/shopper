---

## File: /docs/backend.md

```markdown
# Documentation: Backend PHP Classes

The backend logic is encapsulated in PHP classes located in the `/includes/` directory. These classes provide a structured way to interact with the database.

## `Database.php`

This class handles the connection to the SQLite database.

- **Design Pattern:** Singleton. This ensures that only one instance of the database connection (PDO object) is created per request, which is efficient and prevents potential connection issues.
- **Connection:** It connects to the `shopping_list.sqlite` file in the root directory.
- **Initialization:** On the first connection, it automatically executes the SQL schema to create the `lists` and `items` tables if they do not exist.
- **Error Handling:** Uses `PDO::ERRMODE_EXCEPTION` for robust error handling.
- **Foreign Keys:** Explicitly enables `PRAGMA foreign_keys = ON;` to enforce relational integrity.

### Class `Database`

#### `public static function getInstance(): PDO`
Returns the single, static instance of the PDO connection object.

---

## `ShoppingList.php`

This class contains methods for Create, Read, and Delete (CRD) operations on the `lists` table.

### Class `ShoppingList`

#### `public function __construct()`
The constructor initializes the class by obtaining the database connection instance from the `Database` class.

#### `public function create(string $name): int`
Inserts a new shopping list into the database.
- **Parameters:**
  - `$name`: The name for the new list.
- **Returns:** The `list_id` of the newly created list.

#### `public function getAll(): array`
Retrieves all shopping lists from the database, ordered by creation date descending.
- **Returns:** An associative array of all lists.

#### `public function getById(int $listId): array|false`
Retrieves a single shopping list by its ID.
- **Parameters:**
  - `$listId`: The ID of the list to retrieve.
- **Returns:** An associative array of the list's data or `false` if not found.

#### `public function delete(int $listId): bool`
Deletes a shopping list from the database. Due to the `ON DELETE CASCADE` foreign key constraint, all associated items are also deleted.
- **Parameters:**
  - `$listId`: The ID of the list to delete.
- **Returns:** `true` on success, `false` on failure.

---

## `ListItem.php`

This class contains methods for CRD operations and state updates on the `items` table.

### Class `ListItem`

#### `public function __construct()`
The constructor initializes the class by obtaining the database connection instance.

#### `public function create(int $listId, string $name): int`
Inserts a new item into a specified list.
- **Parameters:**
  - `$listId`: The ID of the list to which the item belongs.
  - `$name`: The name of the new item.
- **Returns:** The `item_id` of the newly created item.

#### `public function getByListId(int $listId): array`
Retrieves all items for a specific list, ordered by creation date ascending.
- **Parameters:**
  - `$listId`: The ID of the parent list.
- **Returns:** An associative array of all items for that list.

#### `public function toggleCheck(int $itemId): bool`
Toggles the `is_checked` status of an item (from 0 to 1 or 1 to 0).
- **Parameters:**
  - `$itemId`: The ID of the item to update.
- **Returns:** `true` on success, `false` on failure.

#### `public function delete(int $itemId): bool`
Deletes a single item from the database.
- **Parameters:**
  - `$itemId`: The ID of the item to delete.
- **Returns:** `true` on success, `false` on failure.

#### `public function getById(int $itemId): array|false`
Retrieves a single item by its ID.
- **Parameters:**
  - `$itemId`: The ID of the item to retrieve.
- **Returns:** An associative array containing the item data, or `false` if not found.
