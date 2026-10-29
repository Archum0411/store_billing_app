# Store Billing

Store Billing is a Laravel web application for managing store users, customers, and products, creating customer orders, and viewing sales and order history.

## Application flow

1. **Sign in:** A user submits their email and password on the login page. Laravel authenticates the user and starts an authenticated session. The dashboard and the application’s management and billing routes require authentication.
2. **Dashboard:** The dashboard summarizes today's sales and order count, product count, low-stock products, recent orders, and sales for that day.
3. **Maintain store data:** Admin can manage user accounts, customers, and products. Product records include a price, tax percentage, and stock-on-hand quantity.
4. **Create a order:** On the billing page, the products and quantities and enters a customer email. The app looks up the customer and can create a new customer when a name is supplied.
5. **Validate and save the order:** The application validates the request and available stock, calculates each line's subtotal and tax, and creates the order and order items inside a database transaction. It deducts stock as part of the same transaction, so an invalid order does not leave a partial update.
6. **Show and email the bill:** After saving, the app displays the bill and dispatches a queued order-confirmation job. The job emails the customer a confirmation with a PDF bill attached, when the customer has an email address and mail is configured. If the original mail configration is provided.
7. **Review order history:** The order-history screen looks up orders by customer email and returns each order with its item and total details. The order history are stored in log entry please check in this folder    storage\logs\laravel.log 

## Main components

| Area | Responsibility |
| --- | --- |
| `routes/web.php` | Maps login, dashboard, user, customer, product, billing, and order-history requests to controllers. |
| `app/Http/Controllers/` | Handles requests, validation, dashboard data, CRUD, and order processing. |
| `app/Models/` | Eloquent models for users, customers, products, orders, and order items, including their relationships. |
| `resources/views/` | Blade pages for authentication, dashboard, management screens, bills, order history, and email content. |
| `app/Jobs/` and `app/Mail/` | Sends order-confirmation emails asynchronously with a generated PDF attachment. |
| `database/migrations/` and `database/seeders/` | Database migrations and the initial user seeder. |
| `resources/js/`, `resources/css/`, and `vite.config.js` | Front-end assets built and served by Vite. |

An order belongs to a customer and contains order items. Each item references a product and stores the unit price and tax values used when the order was created, so the bill retains its original amounts if product pricing changes later.

## Setup

### Requirements

- PHP 8.2 or later and Composer
- Node.js and npm
- A supported database configured for this application

### Install and configure

1. Install PHP dependencies:

   ```sh
   composer install
   ```

2. Create `.env` from `.env.example` if it does not already exist, then set the application key, database connection, and mail settings:

   ```sh
   copy .env.example .env
   php artisan key:generate
   ```

   On macOS or Linux, use `cp .env.example .env` instead of `copy`.

3. Ensure the configured database contains the business tables used by the app: `customers`, `products`, `orders`, and `order_items`. The migrations currently in this repository do not create those tables; provision or import the project’s business database schema before using customer management or billing.
4. Apply available migrations and, if needed, seed the initial user accounts:

   ```sh
   php artisan migrate
   php artisan db:seed
   ```

5. Install front-end dependencies:

   ```sh
   npm install
   ```

## Run locally

Start the application, queue listener, log viewer, and Vite development server together:

```sh
composer run dev
```

Alternatively, run the pieces in separate terminals:

```sh
php artisan serve
php artisan queue:listen
npm run dev
```

Configure a working mail transport in `.env` for order-confirmation emails. If you use a queue connection other than `sync`, keep a queue worker running so dispatched confirmation jobs are processed.

## Useful commands

```sh
php artisan test
npm run build
```

## License

This project uses the Laravel framework and its dependencies. Refer to their respective licenses for licensing details.
