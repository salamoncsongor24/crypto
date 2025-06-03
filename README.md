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

## About Project Decisions

The project was developed with scalability and future-proofing in mind. This is reflected in most of the architectural designs and overall functionality.

The project is divided into so called `domains`. These are basically logical groupings of business logic. For example everything connected to the User entity goes under the `User` domain, and so on. In a project of this size it is not particularly useful to do this, but it helps keeps things simple on the long run. The business logic is mostly kept in services that are implementing contracts. They are used trough dependency injection, so for example in case of the api methods towards the crypto site, these can be exchanged to new implementations, or in case somebody writes tests, they can use dummy implementations. This is further helped by the use of data objects in the crypto service, this gives a clear indication to what kind of data is required for the models, so the app works correctly. I avoided the use of model classes in this service. The database is configured in a way that other currencies can be used too. There was a small effort put into the possibility of using multiple currencies in the same time (hopefully in a later update). Also the project is using `Filament` as its primary UI. This was chosen as a shortcut to a nice, working UI due to limited timeframe. I implemented two panels, `admin` and `crypto`. The admin panel is there purely for futureproofing reasons, as role management and other possible applications are not yet required or too useful. All displayed text is prepared for translations, though there is no other language than english yet.

The chosen API is Coingecko, as it suits the app's needs perfectly. The free tier doesn't require authentication and it provides useful endpoints, so queries can be optimized. In the admin panel admins can search for coins and add them to the application. They can edit the description or select wether they want the users to be notified or not. Users can unsubscribe from notifications any time, or choose on register. Users can add any available coin to any of their portfolios. The graphs are only configured to show last 24 hours data.

I used softdelete in most cases so data is never truly lost.

The landing page is a placeholder created by small modifications to the standard Laravel welcome page.
