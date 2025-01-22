# Brand-Connect Documentation

## Overview
**Brand-Connect** is a web application built using Laravel 11, PHP 8.2, and Node.js 20.

---

## Requirements
Before installing, ensure your environment meets these requirements:
- **PHP**: ^8.2
- **Composer**: ^2.8
- **Node.js**: ^22
- **NPM**: ^10.x
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

## Test Account
To log in and access the application, you can use the following test account credentials:

- **Email:** admin@example.com
- **Password:** Admin1234!

---

## Running Tests
To ensure the application is working as expected, follow these steps to run the test suite:

1. Ensure there is an environment file named `.env.testing`. This file should contain the testing-specific configurations for your application.
2. Clear the configuration cache by running the following command:

   ```bash
   php artisan config:clear
   ```

3. Run the test suite using:

   ```bash
   php artisan test
   ```

---

## API Endpoints

### /api/outlets/nearest
Retrieve the nearest outlets based on geographical coordinates. 

#### Method:
`GET`

#### Description:
This endpoint returns data about outlet located within a radius of 25 kilometers from the given coordinates.

#### Parameters:
| Name        | Type   | Description                         |
|-------------|--------|-------------------------------------|
| `latitude`  | float  | The latitude of the current location. |
| `longitude` | float  | The longitude of the current location.|

#### Response:
- **Success (200):**
  ```json
  {
  "status": 200,
  "message": "Outlet retrieved successfully",
  "data": {
    "id": "c58c6b1d-af38-46c1-90e0-c9835b6337d9",
    "brand_name": "MadeUpBrand",
    "name": "MadeUpOutlet",
    "phone_number": "123456",
    "description": "This is description",
    "address": "Indonesia",
    "latitude": "-6.9220926909433730000000",
    "longitude": "107.5588226737869800000000",
    "location_distance": "0.1 km"
  }
}

#### Notes:
- Ensure valid latitude and longitude values are provided.
- Only the nearest outlet within 25 km are included in the response.
