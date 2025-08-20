<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>My Shopping Lists</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header class="navbar navbar-dark bg-primary shadow-sm">
        <div class="container">
            <h1 class="navbar-brand m-0">Shopping Lists</h1>
        </div>
    </header>

    <main class="container my-4">
        <div id="loading-spinner" class="text-center mt-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>

        <div id="shopping-lists" class="list-group">
            </div>

        <div id="no-lists-message" class="text-center text-muted mt-5 d-none">
            <p class="fs-4">No lists yet.</p>
            <p>Create your first shopping list to get started!</p>
        </div>
    </main>

    <div class="container fixed-bottom p-3">
        <form id="add-list-form" class="d-flex gap-2">
            <input type="text" id="new-list-name" class="form-control form-control-lg" placeholder="New list name..." required>
            <button type="submit" class="btn btn-primary btn-lg flex-shrink-0">
                <i class="bi bi-plus-lg"></i> <span class="d-none d-sm-inline">Add List</span>
            </button>
        </form>
    </div>

    <script src="js/app.js"></script>
</body>
</html>
