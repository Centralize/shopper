# Documentation: Database Schema

The application uses a single SQLite3 database file named `shopping_list.sqlite` located in the application root directory.

## Tables

### 1. `lists`

This table stores the main shopping lists.

| Column | Type | Constraints | Description |
|---|---|---|---|
| `list_id` | INTEGER | PRIMARY KEY AUTOINCREMENT | Unique identifier for each list. |
| `list_name` | TEXT | NOT NULL | The user-defined name of the shopping list. |
| `created_at`| DATETIME | NOT NULL DEFAULT CURRENT_TIMESTAMP | Timestamp of when the list was created. |

### 2. `items`

This table stores the individual items belonging to each shopping list.

| Column | Type | Constraints | Description |
|---|---|---|---|
| `item_id` | INTEGER | PRIMARY KEY AUTOINCREMENT | Unique identifier for each item. |
| `list_id` | INTEGER | NOT NULL | Foreign key referencing `lists.list_id`. |
| `item_name` | TEXT | NOT NULL | The name of the item (e.g., "Milk", "Bread"). |
| `is_checked`| INTEGER | NOT NULL DEFAULT 0 | A boolean flag (0 = unchecked, 1 = checked). |
| `created_at`| DATETIME | NOT NULL DEFAULT CURRENT_TIMESTAMP | Timestamp of when the item was added. |

## Relationships

- A one-to-many relationship exists between `lists` and `items`.
- One list can have many items.
- The `FOREIGN KEY (list_id) REFERENCES lists (list_id) ON DELETE CASCADE` constraint ensures that when a list is deleted, all of its associated items are also automatically deleted.

## Indexes

- An index `idx_items_list_id` is created on the `items.list_id` column to improve the performance of fetching items for a specific list.

## SQL Schema Definition

```sql
CREATE TABLE IF NOT EXISTS lists (
    list_id INTEGER PRIMARY KEY AUTOINCREMENT,
    list_name TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS items (
    item_id INTEGER PRIMARY KEY AUTOINCREMENT,
    list_id INTEGER NOT NULL,
    item_name TEXT NOT NULL,
    is_checked INTEGER NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (list_id) REFERENCES lists (list_id) ON DELETE CASCADE
);

CREATE INDEX IF NOT EXISTS idx_items_list_id ON items (list_id);
