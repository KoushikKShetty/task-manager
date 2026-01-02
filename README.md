# Simple Task Management System

This is a Laravel 11 based Task Management System developed as part of the Intern Assessment for Techpath Learning Private Ltd.

## Project Description
A single-user application that allows users to create, view, update, and delete tasks. Each task includes a title, description, priority level, and completion status.

## Technology Stack
- **Framework:** Laravel 11
- **Language:** PHP 8.2+
- **Database:** SQLite (default for easy setup)
- **Frontend:** Blade Templates & Bootstrap (via CDN)

## Core Features
- **Task Listing:** View all tasks in a clean table format.
- **Add Task:** Create new tasks with title, description, and priority (Low/Medium/High).
- **Update Status:** Toggle tasks between 'Pending' and 'Completed' with a single click.
- **Delete Task:** Remove tasks from the system.
- **Validation:** Form validation to ensure required fields are met.

## Setup Instructions

Follow these steps to run the project locally:

1. **Extract the ZIP file** and navigate to the project directory:
   ```bash
   cd task-manager
    1.Install Dependencies:
        composer install
    2. Environment Configuration:
        Copy the example environment file:
        cp .env.example .env
        Generate the application key:
        php artisan key:generate
    3. Database Setup:
        The project is configured to use SQLite.
        Create the SQLite database file:
        Windows (PowerShell): New-Item -Path database/database.sqlite -ItemType File
        Linux/Mac/GitBash: touch database/database.sqlite
        Run the migrations to create the tables:
        php artisan migrate
    4. Run the Application:
        php artisan serve
        Access the application at: http://127.0.0.1:8000