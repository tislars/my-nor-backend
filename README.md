<div style="text-align:center;max-width:640px;margin-inline:auto;">
<h1>My-NOR-backend</h1>

![NOR logo](https://netherlandsonlineracing.nl/wp-content/uploads/2023/10/logowebsite.png)

My-NOR-backend is a backend application designed for fetching race data, including drivers, race cars, leaderboards, and race logs. It supports features such as tracking fastest laps, driver statistics, and race performance analysis.
</div>

<hr/>

## Features

- **Race Data**: Manage and view race logs and race car information.
- **Leaderboards**: Track driver performance, including fastest laps and most cuts per track.
- **Driver & Car Management**: View  drivers and their respective cars for each race.

## Technology Stack

- **PHP 8.x**: Server-side scripting language.
- **Laravel 11.x**: Framework for backend logic, routing, and database interactions.
- **Blade**: Templating engine for frontend rendering.
- **MySQL**: Database for storing race logs, driver information, and other data.
- **Tailwind CSS**: Utility-first CSS framework for styling.
- **Laravel Eloquent ORM**: For database interactions and model relationships.

## Installation

Follow these steps to set up the project locally.

### Prerequisites

- PHP 8.x or higher
- Composer (for PHP dependency management)
- MySQL or another supported database

### Steps

1. Clone the repository:
    ```bash
    git clone https://github.com/tislars/my-nor-backend.git
    cd my-nor-backend
    ```

2. Install PHP dependencies:
    ```bash
    composer install
    ```

3. Set up your `.env` file:
    ```bash
    cp .env.example .env
    ```

    Update the `.env` file with your database and other environment configurations.

4. Generate the application key:
    ```bash
    php artisan key:generate
    ```

5. Run the migrations:
    ```bash
    php artisan migrate
    ```

6. Seed the database (optional, for sample data):
    ```bash
    php artisan db:seed
    ```

7. Serve the application:
    ```bash
    php artisan serve
    ```

    The application should now be accessible at `http://localhost:8000`.

## API Endpoints

### Leaderboards

- **Fastest Laps**:
    - **GET** `/leaderboard/fastest-laps/{track}`
    - Returns a list of the fastest laps on the specified track.

- **Most Cuts**:
    - **GET** `/leaderboard/most-cuts/{track}`
    - Returns a list of drivers who have made the most track cuts on the specified track.

### Race Cars

- **List of Race Cars**:
    - **GET** `/race-cars`
    - Returns a paginated list of all race cars, including their associated driver and race data.

## Database Schema

### RaceCars

- **id**: Unique identifier for the race car entry.
- **race_id**: The associated race identifier.
- **car_id**: The car identifier.
- **race_number**: The race number of the car.
- **car_model**: The model of the car.
- **driver_id**: The associated driver identifier.
- **team_name**: The team name of the car.

### Race Logs

- **id**: Unique identifier for the race log entry.
- **race_id**: The associated race identifier.
- **driver_id**: The associated driver identifier.
- **position**: Position of the driver in the race.
- **fastest_lap**: Fastest lap time of the driver.
- **incidents**: Number of incidents involving the driver.

## Usage

### Creating a Race

To generate a race and associated logs, use the following Artisan command:

```bash
php artisan generate:race
```
