# Laravel Multiple Role Blog System

This is a Laravel application designed to function as a multiple role blog system. It is built as an API only, and does not include any frontend components.

## Functionality

The application provides different levels of access for users with different roles:

- Normal users can create, read, update, and delete their own blog posts.
- Managers can create, read, update, and delete all blog posts.
- Admins can create, read, update, and delete all blog posts and user accounts.

## Installation

To install and run this application, follow these steps:

1. Clone the repository to your local machine using `git clone`.

2. Install the dependencies by running `composer install` in the project directory.

3. Copy the `.env.example` file to `.env` and configure your environment variables such as the database credentials.

4. Run the database migrations using `php artisan migrate`.

5. Optionally, you may seed the database with sample data by running `php artisan db:seed`.

6. Start the application by running `php artisan serve`.

## Endpoints

The following endpoints are available for use:

| Method | Endpoint                | Description                                         |
| ------ | -----------------------| --------------------------------------------------- |
| POST   | /api/token             | Get Token                                      |
| GET    | /api/posts             | Get a list of all posts                             |
| GET    | /api/posts/{id}        | Get a single post by ID                              |
| POST   | /api/posts             | Create a new post (for normal users)                 |
| PUT    | /api/posts/{id}        | Update a post by ID (for normal users)               |
| DELETE | /api/posts/{id}        | Delete a post by ID (for normal users)               |
| GET    | /api/users             | Get a list of all users (for admins only)            |
| GET    | /api/users/{id}        | Get a single user by ID (for admins only)            |
| POST   | /api/users             | Create a new user (for admins only)                  |
| PUT    | /api/users/{id}        | Update a user by ID (for admins only)                |
| DELETE | /api/users/{id}        | Delete a user by ID (for admins only)                |

## Authentication

This application uses token-based authentication using Laravel Sanctum. To use protected endpoints, you must first obtain an API token by logging in.

## License

This application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
