<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
  .todo-list-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
    padding: 0.75rem 1.25rem;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
}

.todo-actions .btn {
    margin-left: 0.5rem;
}
</style>
<body>
    <div class="container mt-5">
        <h2 class="text-center">To-Do App</h2>

        <!-- Form to Add New To-Do -->
        <form id="todoForm">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea class="form-control" id="address" name="address" required></textarea>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add To-Do</button>
        </form>

        <!-- Update Form -->
        <form id="updateForm" style="display: none;">
            <input type="hidden" id="updateId">
            <div class="mb-3">
                <label for="updateName" class="form-label">Name</label>
                <input type="text" class="form-control" id="updateName" name="name" required>
            </div>
            <div class="mb-3">
                <label for="updateAddress" class="form-label">Address</label>
                <textarea class="form-control" id="updateAddress" name="address" required></textarea>
            </div>
            <div class="mb-3">
                <label for="updateMessage" class="form-label">Message</label>
                <textarea class="form-control" id="updateMessage" name="message" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update To-Do</button>
        </form>

        <!-- List of To-Dos -->
        <ul id="todoList" class="list-group mt-5"></ul>
    </div>

    <!-- jQuery Library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- AJAX Script -->
    <script>
        $(document).ready(function() {
            // Set up CSRF token for AJAX requests
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            // Fetch all todos on page load
            fetchTodos();

            // Handle form submission for adding a new todo
            $('#todoForm').submit(function(e) {
                e.preventDefault();

                const formData = {
                    name: $('#name').val(),
                    address: $('#address').val(),
                    message: $('#message').val()
                };

                $.ajax({
                    url: '/todos',
                    type: 'POST',
                    data: formData,
                    success: function(todo) {
                    $('#todoList').append(`
                      <li class="todo-list-item" data-id="${todo.id}">
                        <div>
                        <strong>${todo.name}</strong> - ${todo.address} - ${todo.message}
                        </div>
                        <div class="todo-actions">
                            <button class="btn btn-info btn-sm editBtn">Edit</button>
                            <button class="btn btn-danger btn-sm deleteBtn">Delete</button>
                        </div>
                      </li>
                `   );
                    $('#todoForm')[0].reset();
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });

            // Edit a todo
            $(document).on('click', '.editBtn', function() {
                const id = $(this).closest('li').data('id');

                $.get(`/todos/${id}`, function(todo) {
                    $('#updateId').val(todo.id);
                    $('#updateName').val(todo.name);
                    $('#updateAddress').val(todo.address);
                    $('#updateMessage').val(todo.message);
                    $('#todoForm').hide();
                    $('#updateForm').show();
                });
            });

            // Update a todo
            $('#updateForm').submit(function(e) {
                e.preventDefault();
                const id = $('#updateId').val();
                const formData = {
                    name: $('#updateName').val(),
                    address: $('#updateAddress').val(),
                    message: $('#updateMessage').val()
                };

                $.ajax({
                    url: `/todos/${id}`,
                    type: 'PUT',
                    data: formData,
                    success: function(todo) {
                    $(`li[data-id="${todo.id}"]`).html(`
                        <div>
                          <strong>${todo.name}</strong> - ${todo.address} - ${todo.message}
                        </div>
                        <div class="todo-actions">
                            <button class="btn btn-info btn-sm editBtn">Edit</button>
                            <button class="btn btn-danger btn-sm deleteBtn">Delete</button>
                        </div>
                      `);
                        $('#updateForm').hide();
                        $('#todoForm').show();
                        $('#updateForm')[0].reset();
                    }
                });
            });


            // Handle deleting a todo
            $(document).on('click', '.deleteBtn', function() {
                const id = $(this).closest('li').data('id');

                $.ajax({
                    url: `/todos/${id}`,
                    type: 'DELETE',
                    success: function() {
                        $(`li[data-id="${id}"]`).remove();
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });

            // Fetch all todos and display them
            function fetchTodos() {
                $.get('/todos', function(todos) {
                    todos.forEach(todo => {
                        $('#todoList').append(`
                            <li class="todo-list-item" data-id="${todo.id}">
                            <div>
                              <strong>${todo.name}</strong> - ${todo.address} - ${todo.message}
                            </div>
                            <div class="todo-actions">
                                <button class="btn btn-info btn-sm editBtn">Edit</button>
                                <button class="btn btn-danger btn-sm deleteBtn">Delete</button>
                            </div>
                            </li>
                        `);
                    });
                });
            }
        });
    </script>
</body>
</html>
