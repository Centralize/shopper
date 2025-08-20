<?php
declare(strict_types=1);

require_once __DIR__ . '/Database.php';

/**
 * Manages items within a shopping list.
 */
class ListItem
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Creates a new item in a specific list.
     *
     * @param int $listId The ID of the list.
     * @param string $name The name of the item.
     * @return int The ID of the newly created item.
     */
    public function create(int $listId, string $name): int
    {
        $stmt = $this->db->prepare("INSERT INTO items (list_id, item_name) VALUES (?, ?)");
        $stmt->execute([$listId, $name]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Retrieves all items for a given shopping list.
     *
     * @param int $listId The ID of the list.
     * @return array An array of items.
     */
    public function getByListId(int $listId): array
    {
        $stmt = $this->db->prepare("SELECT item_id, list_id, item_name, is_checked FROM items WHERE list_id = ? ORDER BY created_at ASC");
        $stmt->execute([$listId]);
        return $stmt->fetchAll();
    }

    /**
     * Toggles the checked state of an item.
     *
     * @param int $itemId The ID of the item.
     * @return bool True on success, false on failure.
     */
    public function toggleCheck(int $itemId): bool
    {
        // is_checked is either 0 or 1, so (1 - is_checked) toggles it.
        $stmt = $this->db->prepare("UPDATE items SET is_checked = 1 - is_checked WHERE item_id = ?");
        return $stmt->execute([$itemId]);
    }

    /**
     * Deletes an item from a list.
     *
     * @param int $itemId The ID of the item to delete.
     * @return bool True on success, false on failure.
     */
    public function delete(int $itemId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM items WHERE item_id = ?");
        return $stmt->execute([$itemId]);
    }
    
    /**
     * Retrieves a single item by its ID.
     *
     * @param int $itemId The ID of the item.
     * @return array|false The item data or false if not found.
     */
    public function getById(int $itemId): array|false
    {
        $stmt = $this->db->prepare("SELECT item_id, list_id, item_name, is_checked FROM items WHERE item_id = ?");
        $stmt->execute([$itemId]);
        return $stmt->fetch();
    }
}
