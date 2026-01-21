# MVC Invoice Manager.

A robust, custom-built PHP MVC application designed for managing Clients, Products (Articles), and Invoices. This project demonstrates a clean separation of concerns using the Model-View-Controller architecture, featuring secure data handling, PDF generation, and data export capabilities.

## Features

### 1. Client Management
*   **CRUD Operations**: Create, Read, Update, and Delete client records.
*   **Security**: Sensitive data like passwords are encrypted using AES-256-CBC.
*   **Exports**: Download client lists as CSV or JSON.
*   **Reporting**: Generate printable PDF client lists.
*   **Decryption**: Secure decryption of data for authorized view display.

### 2. Article (Product) Management
*   **Inventory Control**: Manage product details including Reference, Description, Price, and VAT type.
*   **Data Portability**: Export product catalogs to CSV and JSON formats.

### 3. Invoice System
*   **Invoice Lifecycle**: Create and manage invoices with unique IDs, Dates, and assigned Clients.
*   **Line Items**: dedicated management for invoice lines (`Lineas Facturas`), calculating totals tailored to specific invoices.
*   **Filtering**: View invoices by Client or Lines by Invoice.
*   **PDF Generation**: Generate official invoice documents using FPDF.

## Architecture

This application follows a strict MVC pattern without relying on heavy frameworks, making it lightweight and easy to understand.

*   **Model (`src/model/`)**: Handles all database interactions using PDO.
    *   `BD`: Base class managing the database connection.
    *   Entity classes (`ClientesModelo`, `FacturasModelo`, etc.) extend `BD` to perform specific SQL operations.
*   **View (`src/view/`)**: Responsible for the presentation layer.
    *   Uses HTML5 and Bootstrap 5 for responsive design.
    *   Separated into logical folders (layout, css, entity-specific views).
*   **Controller (`src/controller/`)**: Acts as the intermediary.
    *   Receives requests, processes logic (like encryption/decryption), talks to the Model, and chooses the View to render.
    *   Implements a custom routing strategy via query parameters (e.g., `?c=clientes&m=index`).

## Technical Stack

*   **Language**: PHP 8.1 recommended
*   **Database**: MySQL / MariaDB
*   **Frontend**: HTML, CSS, Bootstrap 5
*   **Libraries**:
    *   `FPDF`: For PDF generation.
    *   `JSON.php`: Custom helper for JSON handling.

## Installation & Setup

1.  **Database Configuration**
    Import the provided SQL schema (if available) into your MySQL database.
    
    Update the connection settings in `src/config.php`. You can either edit the file directly or use environment variables:
    ```php
    define("SERVIDOR", getenv('MYSQL_HOST') ?: "localhost");
    define("USUARIO", getenv('MYSQL_USER') ?: "root");
    define("CONTRASENA", getenv('MYSQL_PASSWORD') ?: "root");
    define("BASEDATOS", getenv('MYSQL_DATABASE') ?: "mvc");
    ```

3.  **Run the Application**
    You can use the built-in PHP server for testing:
    ```bash
    cd src
    php -S localhost:8080
    ```
    Access the app at `http://localhost:8080`.

## Project Structure

```text
mvc/
├── src/
│   ├── config.php          # Main configuration
│   ├── index.php           # Entry point and Router
│   ├── controller/         # Business Logic
│   │   ├── app.php         # Dashboard controller
│   │   ├── crypt.php       # Encryption utility
│   │   └── ...             # Entity controllers
│   ├── model/              # Database Access Layer
│   │   ├── bd.php          # Base DB wrapper
│   │   └── ...             # Entity models
│   ├── view/               # Templates (UI)
│   │   ├── layout/         # Header, Footer, Menu
│   │   ├── css/            # Custom Styles
│   │   └── ...             # Feature views
│   ├── pdfs/               # PDF Generation Logic
│   └── lib/                # Utilities (JSON, etc.)
└── README.md
```

## Security Note

This project implements **OpenSSL** encryption for handling sensitive fields. The encryption logic is centralized in `src/controller/crypt.php` using `AES-256-CBC`. Ensure that your PHP environment has the `openssl` extension enabled.
