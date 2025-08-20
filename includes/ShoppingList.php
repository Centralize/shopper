<?php
declare(strict_types=1);

require_once __DIR__ . '/Database.php';

/**
 * Manages shopping lists in the database.
 */
class ShoppingList
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Creates a new shopping list.
     *
     * @param string $name The name of the list.
     * @return int The ID of the newly created list.
     */
    public function create(string $name): int
    {
        $stmt = $this->db->prepare("INSERT INTO lists (list_name) VALUES (?)");
        $stmt->execute([$name]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Retrieves all shopping lists.
     *
     * @return array An array of all shopping lists.
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT list_id, list_name, created_at FROM lists ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    
    /**
     * Retrieves a single shopping list by its ID.
     *
     * @param int $listId The ID of the list.
     * @return array|false The list data or false if not found.
     */
    public function getById(int $listId): array|false
    {
        $stmt = $this->db->prepare("SELECT list_id, list_name FROM lists WHERE list_id = ?");
        $stmt->execute([$listId]);
        return $stmt->fetch();
    }

    /**
     * Deletes a shopping list and all its associated items.
     *
     * @param int $listId The ID of the list to delete.
     * @return bool True on success, false on failure.
     */
    public function delete(int $listId): bool
    {
        $stmt = $this->db->prepare("DELETE FROM lists WHERE list_id = ?");
        return $stmt->execute([$listId]);
    }
}
