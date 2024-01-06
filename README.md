# Book Store WordPress Plugin

## Overview

The Book Store WordPress Plugin is a custom plugin designed to manage and display book information within a WordPress environment. It leverages the Laravel Eloquent ORM for database interactions and provides an administration interface for managing book-related data.

## Features

- Display a list of books in the WordPress admin panel.
- Manage book information, including post ID, ISBN, created at, and updated at.
- Responsive and user-friendly book listing table.

## Installation

1. Clone the repository to your WordPress plugins directory and navigate into the folder:

    ```bash
    git clone https://github.com/evokelektrique/veronalabs-book-store-wp-plugin.git wp-content/plugins/veronalabs-book-store-wp-plugin
    ```

2. Install the required PHP packages with `composer install`.
3. Activate the plugin through the WordPress admin panel.
4. Enjoy managing your book information through the WordPress admin interface.

## Usage

1. Navigate to the "Books Info" menu in the WordPress admin panel.
2. View and manage book information in the provided table.

## Requirements

- WordPress 5.0 or later.
- PHP 7.4 or later.
- MySQL
- Docker (For [development](#development))

## Development

### Docker

1. Navigate to the root project directory.
2. run `docker compose up -d` to run a WordPress instance with pdo_mysql extension installed.
3. Open the browser and navigate to this url `http://localhost:8080`.

### Assets

- Use `npm run dev` to watch and compile real time whenever anything changes.
- Use `npm run build` to compile and minify the assets

## Contributing

Contributions are welcome! If you find any issues or have suggestions for improvements, feel free to open an issue or submit a pull request.
