# Brand-Connect Documentation

## Overview
**Brand-Connect** is a web application built using Laravel 11, PHP 8.2, and Node.js 20.

---

## Requirements
Before installing, ensure your environment meets these requirements:
- **PHP**: ^8.2
- **Composer**: ^2.5
- **Node.js**: ^20
- **NPM**: ^8.x
- **Database**: PostgreSQL

---

## Installation
Follow the steps below to set up the project:

1. **Clone the repository**:
   ```bash
   git clone https://github.com/IlhamShiddiq/brand-connect.git
   cd brand-connect
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**:
   ```bash
   npm install
   ```

4. **Set up the environment**:
   - Copy the `.env.example` file and rename it to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Configure the `.env` file with your database credentials and other environment settings.

5. **Run database migrations**:
   ```bash
   php artisan migrate
   ```

6. **Run database seeder**:
   ```bash
   php artisan db:seed
   ```

7. **Serve the application**:
   ```bash
   php artisan serve
   ```

8. **Run the development server for frontend assets**:
   ```bash
   npm run dev
   ```

---

## Running Tests
To ensure the application is working as expected, run the test suite:

```bash
php artisan test
```
