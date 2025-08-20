<?php
declare(strict_types=1);

/**
 * Database connection class using the Singleton pattern.
 */
class Database
{
    private static ?PDO $instance = null;
    private static string $dbPath = __DIR__ . '/../shopping_list.sqlite';

    /**
     * The constructor is private to prevent direct creation of object.
     */
    private function __construct() {}

    /**
     * The clone method is private to prevent cloning of an instance.
     */
    private function __clone() {}

    /**
     * The wakeup method is private to prevent unserialization of an instance.
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    /**
     * Gets the single instance of the PDO database connection.
     *
     * @return PDO The PDO instance.
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            try {
                // Ensure foreign key constraints are enforced by SQLite
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                
                self::$instance = new PDO('sqlite:' . self::$dbPath, null, null, $options);
                self::$instance->exec('PRAGMA foreign_keys = ON;');

                // Create tables if they don't exist
                self::createTables();

            } catch (PDOException $e) {
                // In a real application, you'd log this error
                die("Database Connection Error: " . $e->getMessage());
            }
        }
        return self::$instance;
    }

    /**
     * Creates the necessary database tables if they do not already exist.
     */
    private static function createTables(): void
    {
        $schema = "
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
        ";

        self::$instance->exec($schema);
    }
}
