<?php
declare(strict_types=1);

header('Content-Type: application/json');

require_once __DIR__ . '/../includes/ShoppingList.php';
require_once __DIR__ . '/../includes/ListItem.php';

$shoppingList = new ShoppingList();
$listItem = new ListItem();

$action = $_GET['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

try {
    switch ($action) {
        // --- Shopping List Actions ---
        case 'get_lists':
            if ($method === 'GET') {
                echo json_encode(['success' => true, 'data' => $shoppingList->getAll()]);
            }
            break;
        
        case 'add_list':
            if ($method === 'POST' && !empty($input['name'])) {
                $listId = $shoppingList->create(htmlspecialchars($input['name']));
                echo json_encode(['success' => true, 'data' => ['list_id' => $listId, 'list_name' => $input['name']]]);
            }
            break;

        case 'delete_list':
            if ($method === 'DELETE' && isset($_GET['id'])) {
                $result = $shoppingList->delete((int)$_GET['id']);
                echo json_encode(['success' => $result]);
            }
            break;

        // --- List Item Actions ---
        case 'get_items':
            if ($method === 'GET' && isset($_GET['list_id'])) {
                echo json_encode(['success' => true, 'data' => $listItem->getByListId((int)$_GET['list_id'])]);
            }
            break;

        case 'add_item':
            if ($method === 'POST' && !empty($input['name']) && isset($input['list_id'])) {
                $itemId = $listItem->create((int)$input['list_id'], htmlspecialchars($input['name']));
                $item = $listItem->getById($itemId);
                echo json_encode(['success' => true, 'data' => $item]);
            }
            break;
            
        case 'toggle_item':
            if ($method === 'PUT' && isset($_GET['id'])) {
                $result = $listItem->toggleCheck((int)$_GET['id']);
                echo json_encode(['success' => $result]);
            }
            break;
            
        case 'delete_item':
            if ($method === 'DELETE' && isset($_GET['id'])) {
                $result = $listItem->delete((int)$_GET['id']);
                echo json_encode(['success' => $result]);
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Action not found']);
    }
} catch (Exception $e) {
    http_response_code(500);
    // In a real application, you'd log this error
    echo json_encode(['success' => false, 'error' => 'An internal server error occurred.']);
}

exit();
