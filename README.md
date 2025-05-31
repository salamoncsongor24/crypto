# Welcome to CryptoGurus

This project aims to provide an easy and convenient way of tracking your crypto holdings. Here is the setup information for local development:

## Prerequisites

- I am using the [Herd](https://herd.laravel.com/windows) as development environment in this tutorial
- Recommended database version management tool: [dbngin](https://dbngin.com) 
- Recommended database management tool: [TablePlus](https://tableplus.com)
- A modern browser
- Your preferred code editor

## Project Setup

1. Navigate into your Herd folder, and clone the repo:

```bash
cd C:\Users\username\Herd
git@github.com:salamoncsongor24/crypto.git
```

2. Navigate into the app folder and copy the `.env.example` into `.env`:

```bash
cd crypto
cp .env.example .env
```

3. Create a database for the project, then modify the env file accordingly (`dbngin` config):

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crypto
DB_USERNAME=root
DB_PASSWORD=
```

4. Install `composer` dependencies:

```bash
composer install
```

5. Generate the applicaton key:

```bash
php artisan key:generate
```

6. Install `npm` dependencies:

```bash
npm install
```

7. build the application:

```bsah
npm run build
```

8. Run the migrations:

```bash
php artisan migrate
```

9. Run the seeders:

```bash
php artisan db:seed
```

10. Give permissions to your admin:

```bash
php artisan shield:super-admin --panel=admin
```

## Project Usage

Before you can start using the project, you need to open two terminal windows and run these commands:

```bash
php artisan queue:work
```

```bash
php artisan schedule:work
```

These will start the process of fetching coin prices from the API.

now you can enter the `admin panel (http://crypto.test/admin)` with these credentials:
`admin@example.com`
`password`

Now under the users tab, you will find your test user. Go to edit page and assign it the `Crypto Holder` role, so it can use the app. Under the coins tab, you may import new coins or delete/deactivate the existing ones.

You may access the `crypto panel (http://crypto.test/crypto)` with these credentials:
`test@example.com`
`password`

Under the portfolios tab you can see your holdings.
