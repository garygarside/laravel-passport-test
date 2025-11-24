# Quilter API

This test project provides a simple API for managing user accounts and financial transactions. It includes user registration, token-based authentication, account creation, and transaction management with automatic balance updates.

## Setup Instructions

To get this project up and running on your local machine, follow these steps:

1. Clone the repository:

```bash
git clone git@github.com:garygarside/laravel-passport-test.git
cd laravel-passport-test
```

2. Copy environment File and update database credentials:

```bash
cp .env.example .env
```

3. Run the Composer setup script to install PHP dependencies, migrate your database, generate an application key. Be sure to accept the Laravel Passport migrations and personal token client creation in the process:

```bash
composer run-script setup
```

4. Run the application:

```bash
php artisan serve
```

## API Routes and Parameters

All API routes are prefixed with `/api` and require an `Accept: application/json` header. Authenticated routes require a `Bearer` token in the `Authorization` header.

Once the application is being served, you should be able to access an interactive API browser via [http://localhost:8000](http://localhost:8000).

### Authentication

* **`POST /api/register`** - Register a new user.
    * `email` (POST param, string, required): A valid, unique email address.
    * `password` (POST param, string, required, 10 chars, mixed symbols/numbers/letters): A strong password.

* **`POST /api/token`** - Get a fresh token for your user (Note, revokes previous tokens)
    * `email` (POST param, string, required): The user's email address.
    * `password` (POST param, string, required): The user's password.

### Account Management

The following endpoints require a valid `accessToken` passed via an Authorization Bearer header.

* **`GET /api/accounts`** - List all accounts for the authenticated user.

* **`POST /api/accounts`** - Create a new account for the authenticated user.

* **`GET /api/accounts/{account}`** - Retrieve a specific account for the authenticated user.
    * `{account}` (URL param, UUID): The ID of the account to retrieve.

### Transaction Management

The following endpoints require a valid `accessToken` passed via an Authorization Bearer header.

* **`GET /api/accounts/{account}/transactions`** - List transactions for a specific account, paginated to 10 per page.
    * `{account}` (URL param, UUID): The ID of the account whose transactions to retrieve.
    * `page` (POST param, optional): The page number for pagination.

* **`POST /api/accounts/{account}/transactions`** - Create a new transaction (deposit or withdrawal) for a specific account.
    * `{account}` (URL param, UUID): The ID of the account to make the transaction on.
    * `type` (POST param, required, `deposit`|`withdrawal`): The type of transaction.
    * `amount` (POST param, numeric, required): The transaction amount.

## Testing

The project includes both feature and unit tests written in Pest.

To run all tests, execute the following command:

```bash
php artisan test
```