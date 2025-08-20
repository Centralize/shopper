-- Table for storing shopping lists
CREATE TABLE IF NOT EXISTS lists (
    list_id INTEGER PRIMARY KEY AUTOINCREMENT,
    list_name TEXT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Table for storing items within a shopping list
CREATE TABLE IF NOT EXISTS items (
    item_id INTEGER PRIMARY KEY AUTOINCREMENT,
    list_id INTEGER NOT NULL,
    item_name TEXT NOT NULL,
    is_checked INTEGER NOT NULL DEFAULT 0, -- 0 for false, 1 for true
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (list_id) REFERENCES lists (list_id) ON DELETE CASCADE
);

-- Indexes for performance
CREATE INDEX IF NOT EXISTS idx_items_list_id ON items (list_id);
