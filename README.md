# College Student Management System

A web-based College Student Management System developed using PHP and the Laravel framework. The project focuses on student record management, login functionality, and role-based access for administrators and students.

The application uses Laravel Blade templates for its user interface and MySQL for database storage.

This project was developed as a practical learning project to understand Laravel routing, controllers, models, database migrations, validation, sessions, middleware, and CRUD operations.

## Table of Contents

- [Project Overview](#project-overview)
- [Technologies Used](#technologies-used)
- [Features](#features)
- [Project Structure](#project-structure)
- [Prerequisites](#prerequisites)
- [Installation and Setup](#installation-and-setup)
- [Database Configuration](#database-configuration)
- [Environment Configuration](#environment-configuration)
- [Running the Application](#running-the-application)
- [Administrator Setup](#administrator-setup)
- [Security Notes](#security-notes)
- [Future Improvements](#future-improvements)
- [Author](#author)

## Project Overview

The College Student Management System provides a web interface for managing student records.

Administrators can log in and perform student management operations. Students can log in to access the student-facing functionality implemented in the application.

The application uses Laravel's routing and controller structure to process requests, Blade templates to render pages, and MySQL to store student information.

## Technologies Used

### Backend
- PHP
- Laravel
- Laravel routing and controllers
- Laravel middleware
- Laravel validation
- Laravel sessions

### Frontend
- HTML5
- CSS3
- JavaScript, where implemented
- Laravel Blade templates

### Database
- MySQL

### Development Tools
- Visual Studio Code
- WAMP Server
- phpMyAdmin
- Composer
- Node.js and npm, for frontend asset dependencies where required
- Git and GitHub

## Features

### Administrator Module
- Administrator login
- View student records
- Add new student records
- Edit existing student records
- Delete student records
- Access control for administrative pages

### Student Module
- Student login
- Access to student-facing pages
- View student information or results, where implemented

### Laravel Features Used
- Routes defined in Laravel route files
- Controllers for handling application operations
- Blade templates for displaying pages
- Database migrations
- Session-based login functionality
- Middleware for protecting routes
- Form validation
- Password hashing, where implemented

## Project Structure

The project follows the Laravel application structure.

```text
college-student-management-system/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   └── Models/
│
├── bootstrap/
├── config/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│       └── DatabaseSeeder.php
│
├── public/
│
├── resources/
│   └── views/
│       ├── layouts/
│       ├── students/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       ├── home.blade.php
│       └── welcome.blade.php
│
├── routes/
│   ├── console.php
│   └── web.php
│
├── storage/
├── tests/
├── vendor/
│
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── package-lock.json
├── phpunit.xml
├── README.md
└── vite.config.js
```

This is a representative structure. Your current project may contain additional controllers, middleware, Blade files, migrations, and other Laravel files.

## Prerequisites

Install or configure the following software on Windows 10:

- PHP, with the extensions required by your Laravel version.
- Composer.
- MySQL, provided by WAMP or another compatible MySQL installation.
- Node.js and npm, if frontend assets need to be installed or built.
- Visual Studio Code.
- Git.

WAMP can provide PHP, Apache, MySQL, and phpMyAdmin. Ensure that the PHP version used by the command line is compatible with the Laravel version specified in `composer.json`.

Verify the installations in a new terminal:

```powershell
php --version
composer --version
node --version
npm --version
git --version
```

If a command is not recognized, configure the appropriate Windows PATH entry or open a new terminal after installing the software.

## Installation and Setup

### 1. Clone the Repository

Open PowerShell or the VS Code terminal in the directory where you want to store the project.

Run:

```powershell
git clone https://github.com/vatsal-modi-1112/college-student-management-system.git
```

Navigate into the project:

```powershell
cd college-student-management-system
```

Alternatively, download the repository ZIP from GitHub and extract it.

### 2. Install PHP Dependencies

From the project root directory, run:

```powershell
composer install
```

This installs the PHP dependencies specified in `composer.lock`.

If Composer reports missing PHP extensions, enable the required extensions for the PHP installation used by the command line.

### 3. Create the Environment File

Check whether `.env` exists in the project root.

If it does not exist, copy `.env.example` to `.env`:

```powershell
Copy-Item .env.example .env
```

Do not overwrite an existing `.env` file containing your local configuration.

### 4. Generate the Laravel Application Key

Run:

```powershell
php artisan key:generate
```

This generates the application encryption key and stores it in the local `.env` file.

Keep `.env` private and do not commit it to GitHub.

## Database Configuration

### 1. Start WAMP

Start WAMP Server and confirm that its services are running.

Open phpMyAdmin in your browser using the address provided by your WAMP installation. A common local address is:

```text
http://localhost/phpmyadmin
```

### 2. Create the Database

In phpMyAdmin:

1. Open the **Databases** tab.
2. Enter the database name:

   ```text
   college_student_management
   ```

3. Select a suitable collation, such as `utf8mb4_unicode_ci`, if available.
4. Click **Create**.

Use the same database name in your Laravel configuration.

### 3. Configure the Database Connection

Open the project's `.env` file and update the database settings to match your local MySQL installation.

Example:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=college_student_management
DB_USERNAME=root
DB_PASSWORD=
```

These values are examples for a typical local development setup. Your MySQL username, password, and port may be different. Use the actual settings configured in WAMP.

Save the `.env` file.

### 4. Run Database Migrations

From the project root, run:

```powershell
php artisan migrate
```

Laravel will create the database tables defined by the project's migration files.

If Laravel reports a database connection error, verify that MySQL is running and that the `.env` database settings are correct.

**Warning:** Do not run `php artisan migrate:fresh` against a database containing records you want to keep. That command can drop existing tables and data before recreating them.

## Environment Configuration

The `.env` file contains local settings, such as the database connection and application configuration.

For example, if your `DatabaseSeeder.php` uses environment variables for the administrator account, configure the corresponding values in your local `.env` file:

```env
ADMIN_EMAIL=your-admin-email@example.com
ADMIN_PASSWORD=replace-with-a-strong-local-password
```

Replace these example values with your own local administrator credentials.

Do not place real credentials in `.env.example`, source code, or the README.

After changing environment configuration, you may need to clear cached configuration:

```powershell
php artisan config:clear
```

## Administrator Setup

If your `DatabaseSeeder.php` is configured to create the administrator using `ADMIN_EMAIL` and `ADMIN_PASSWORD`, first review the seeder code to confirm how it creates the account.

Then run:

```powershell
php artisan db:seed
```

The seeder should create the administrator account using the local environment values, provided the required configuration is present.

Do not run the seeder blindly if it performs other operations you do not want. Review `database/seeders/DatabaseSeeder.php` first.

If your project uses a different administrator creation process, follow the implementation in your project.

## Running the Application

### 1. Install Frontend Dependencies

If the project has a `package.json` file and uses npm-managed frontend assets, run:

```powershell
npm install
```

Build the assets if required by the project:

```powershell
npm run build
```

If the project does not require a frontend build for its current configuration, these steps may not be necessary.

### 2. Start Laravel

From the project root, run:

```powershell
php artisan serve
```

Laravel will display the local development address in the terminal. The default is usually:

```text
http://127.0.0.1:8000
```

Open the displayed address in your browser.

Keep the terminal open while using the application.

### 3. Test the Application

Test the functionality implemented in your project:

1. Open the application in the browser.
2. Open the student login page.
3. Verify student login using a valid test account.
4. Open the student-facing page.
5. Log out and verify that the session is ended correctly.
6. Open the administrator login page.
7. Log in using the administrator account configured for your local database.
8. Test displaying student records.
9. Test adding a student record.
10. Test editing a student record.
11. Test deleting a test student record.
12. Verify that unauthorized users cannot access protected administrative pages.

Use test data when experimenting with deletion and update operations.

## Security Notes

- Never commit `.env` files or real credentials.
- Do not hardcode administrator passwords in seeders or application source code.
- Use Laravel's password hashing facilities for stored passwords.
- Validate user input on the server.
- Protect administrative routes using appropriate authentication and authorization checks.
- Regenerate session identifiers after login where appropriate.
- Ensure logout invalidates the session and regenerates the CSRF token as required by the application's implementation.
- Keep dependencies updated and review security advisories.
- Do not expose sensitive error details in a production environment.

## Future Improvements

Possible improvements include:

- More comprehensive student search and filtering.
- Pagination for large student lists.
- Improved form validation and error messages.
- Automated tests for login and student management.
- More detailed role and permission management.
- Deployment to a suitable hosting environment.

## Author

**Vatsal Modi**

BCA Student — Veer Narmad South Gujarat University (VNSGU)

GitHub: https://github.com/vatsal-modi-1112

## Disclaimer

This project was developed for educational and practical learning purposes. It demonstrates student record management and web application development using PHP, Laravel, MySQL, and Blade templates.