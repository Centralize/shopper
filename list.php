<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/ShoppingList.php';

$listId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$listId) {
    header('Location: index.php');
    exit;
}

$shoppingListHandler = new ShoppingList();
$list = $shoppingListHandler->getById($listId);

if (!$list) {
    // Or display a "list not found" message
    header('Location: index.php');
    exit;
}

$listName = htmlspecialchars($list['list_name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title><?= $listName ?> - Shopping List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header class="navbar navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a href="index.php" class="btn btn-light me-2"><i class="bi bi-arrow-left"></i></a>
            <h1 class="navbar-brand m-0 text-truncate"><?= $listName ?></h1>
        </div>
    </header>

    <main class="container my-4" data-list-id="<?= $listId ?>">
        <div id="loading-spinner" class="text-center mt-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <ul id="item-list" class="list-group list-group-flush">
            </ul>
        
        <div id="no-items-message" class="text-center text-muted mt-5 d-none">
            <p class="fs-4">This list is empty.</p>
            <p>Add an item below to get started.</p>
        </div>
    </main>

    <div class="container fixed-bottom p-3">
        <form id="add-item-form" class="d-flex gap-2">
            <input type="text" id="new-item-name" class="form-control form-control-lg" placeholder="New item..." required>
            <button type="submit" class="btn btn-primary btn-lg flex-shrink-0">
                <i class="bi bi-plus-lg"></i> <span class="d-none d-sm-inline">Add Item</span>
            </button>
        </form>
    </div>

    <script src="js/app.js"></script>
</body>
</html>
