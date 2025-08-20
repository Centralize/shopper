document.addEventListener('DOMContentLoaded', () => {
    // API endpoint
    const API_URL = 'backend/api.php';

    // --- Utility Functions ---
    const apiCall = async (endpoint, method = 'GET', body = null) => {
        const options = {
            method,
            headers: {
                'Content-Type': 'application/json'
            }
        };
        if (body) {
            options.body = JSON.stringify(body);
        }
        try {
            const response = await fetch(`${API_URL}${endpoint}`, options);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error('API Call Error:', error);
            // In a real app, show a user-friendly error message
            return { success: false, error: error.message };
        }
    };

    const showSpinner = (show = true) => {
        const spinner = document.getElementById('loading-spinner');
        if (spinner) {
            spinner.style.display = show ? 'block' : 'none';
        }
    };

    // --- Page-specific Logic ---
    const page = document.body.querySelector('main');
    if (page.id === 'shopping-lists-container' || document.getElementById('shopping-lists')) {
        initIndexPage();
    } else if (page.dataset.listId) {
        initListPage(page.dataset.listId);
    }

    // --- Index Page (List of Lists) ---
    function initIndexPage() {
        const listsContainer = document.getElementById('shopping-lists');
        const noListsMessage = document.getElementById('no-lists-message');
        const addListForm = document.getElementById('add-list-form');
        const newListNameInput = document.getElementById('new-list-name');

        const renderLists = (lists) => {
            listsContainer.innerHTML = '';
            if (lists.length === 0) {
                noListsMessage.classList.remove('d-none');
            } else {
                noListsMessage.classList.add('d-none');
                lists.forEach(list => {
                    const listElement = document.createElement('div');
                    listElement.className = 'list-group-item d-flex justify-content-between align-items-center';
                    listElement.innerHTML = `
                        <a href="list.php?id=${list.list_id}" class="text-decoration-none text-dark flex-grow-1 sl-list-link">${escapeHTML(list.list_name)}</a>
                        <button class="btn btn-outline-danger sl-delete-btn" data-list-id="${list.list_id}"><i class="bi bi-trash"></i></button>
                    `;
                    listsContainer.appendChild(listElement);
                });
            }
        };

        const loadLists = async () => {
            showSpinner(true);
            const response = await apiCall('?action=get_lists');
            if (response.success) {
                renderLists(response.data);
            }
            showSpinner(false);
        };

        addListForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const listName = newListNameInput.value.trim();
            if (listName) {
                const response = await apiCall('?action=add_list', 'POST', { name: listName });
                if (response.success) {
                    newListNameInput.value = '';
                    loadLists(); // Refresh the list
                }
            }
        });

        listsContainer.addEventListener('click', async (e) => {
            const deleteButton = e.target.closest('.sl-delete-btn');
            if (deleteButton) {
                const listId = deleteButton.dataset.listId;
                if (confirm('Are you sure you want to delete this list and all its items?')) {
                    const response = await apiCall(`?action=delete_list&id=${listId}`, 'DELETE');
                    if (response.success) {
                        loadLists();
                    }
                }
            }
        });
        
        loadLists();
    }

    // --- List Page (Items in a List) ---
    function initListPage(listId) {
        const itemListContainer = document.getElementById('item-list');
        const noItemsMessage = document.getElementById('no-items-message');
        const addItemForm = document.getElementById('add-item-form');
        const newItemNameInput = document.getElementById('new-item-name');

        const renderItems = (items) => {
            itemListContainer.innerHTML = '';
            if (items.length === 0) {
                noItemsMessage.classList.remove('d-none');
            } else {
                noItemsMessage.classList.add('d-none');
                items.forEach(item => {
                    const itemElement = document.createElement('li');
                    itemElement.className = `list-group-item sl-list-item ${item.is_checked ? 'checked' : ''}`;
                    itemElement.dataset.itemId = item.item_id;
                    itemElement.innerHTML = `
                        <div class="sl-checkbox">
                           <i class="bi ${item.is_checked ? 'bi-check-circle-fill' : 'bi-circle'}"></i>
                        </div>
                        <span class="sl-list-item-name">${escapeHTML(item.item_name)}</span>
                        <button class="btn btn-outline-danger btn-sm sl-delete-btn"><i class="bi bi-x-lg"></i></button>
                    `;
                    itemListContainer.appendChild(itemElement);
                });
            }
        };
        
        const loadItems = async () => {
            showSpinner(true);
            const response = await apiCall(`?action=get_items&list_id=${listId}`);
            if (response.success) {
                renderItems(response.data);
            }
            showSpinner(false);
        };
        
        addItemForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const itemName = newItemNameInput.value.trim();
            if(itemName){
                const response = await apiCall('?action=add_item', 'POST', { name: itemName, list_id: listId });
                if (response.success) {
                    newItemNameInput.value = '';
                    loadItems(); // Refresh items
                }
            }
        });
        
        itemListContainer.addEventListener('click', async (e) => {
            const listItem = e.target.closest('.sl-list-item');
            if (!listItem) return;

            const itemId = listItem.dataset.itemId;
            const deleteButton = e.target.closest('.sl-delete-btn');

            if (deleteButton) {
                // Delete item
                const response = await apiCall(`?action=delete_item&id=${itemId}`, 'DELETE');
                if(response.success){
                    listItem.remove();
                     if (itemListContainer.children.length === 0) {
                        noItemsMessage.classList.remove('d-none');
                    }
                }
            } else {
                // Toggle check
                const response = await apiCall(`?action=toggle_item&id=${itemId}`, 'PUT');
                if(response.success){
                    listItem.classList.toggle('checked');
                    const icon = listItem.querySelector('.sl-checkbox i');
                    icon.classList.toggle('bi-circle');
                    icon.classList.toggle('bi-check-circle-fill');
                }
            }
        });

        loadItems();
    }
    
    // --- Security Helper ---
    function escapeHTML(str) {
        const p = document.createElement('p');
        p.textContent = str;
        return p.innerHTML;
    }
});
