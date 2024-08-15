# Laravel To-Do App with AJAX

This is a simple To-Do application built with Laravel and AJAX. The application allows users to create, update, and delete tasks using an interactive interface. The app utilizes AJAX for seamless interaction, preventing full-page reloads.

## Website Trailer

Check out the trailer for a quick overview of what the Laravel To-Do Application can do!

https://github.com/user-attachments/assets/4123c288-67c3-449e-98ae-8386ade26fa0

## Features

- **Create To-Do Items**: Add new tasks with a name, address, and message.
- **Update To-Do Items**: Edit existing tasks directly from the interface.
- **Delete To-Do Items**: Remove tasks with a single click.
- **AJAX Implementation**: All interactions (create, update, delete) happen asynchronously, ensuring a smooth user experience.

## Prerequisites

- [XAMPP](https://www.apachefriends.org/index.html) or any other PHP development environment
- [Composer](https://getcomposer.org/) (Dependency Manager for PHP)

## Installation

1. **Clone the Repository**:
    ```bash
    git clone https://github.com/SLoharkar/To-Do-APP-Laravel.git
    cd To-Do-APP-Laravel
    ```

2. **Install Dependencies**:
    ```bash
    composer install
    ```

3. **Set Up Environment**:
    - Copy `.env.example` to `.env`:
      ```bash
      cp .env.example .env
      ```
    - Generate an application key:
      ```bash
      php artisan key:generate
      ```
    - Configure your database in the `.env` file:
      ```
      DB_CONNECTION=mysql
      DB_HOST=127.0.0.1
      DB_PORT=3306
      DB_DATABASE=your_database_name
      DB_USERNAME=your_username
      DB_PASSWORD=your_password
      ```

4. **Run Migrations**:
    ```bash
    php artisan migrate
    ```

5. **Start the Development Server**:
    ```bash
    php artisan serve
    ```

6. **Access the Application**:
    Open your web browser and go to `http://localhost:8000`.

## Usage

1. **Adding a To-Do**:
   - Fill in the "Name", "Address", and "Message" fields in the form.
   - Click the "Add To-Do" button to save the task.

2. **Editing a To-Do**:
   - Click the "Edit" button next to a task.
   - Update the task details and click "Update To-Do".

3. **Deleting a To-Do**:
   - Click the "Delete" button next to a task to remove it.

## Code Structure

- **Routes**: Defined in `routes/web.php`.
- **Controllers**: Business logic is handled in `app/Http/Controllers/TodoController.php`.
- **Models**: Eloquent ORM model is in `app/Models/Todo.php`.
- **Views**: Frontend is in the Blade template `resources/views/todo.blade.php`.
