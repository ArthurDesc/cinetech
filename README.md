# Cinetech - Movie and TV Series Application :rocket:

A web application that allows users to discover and search for movies and TV shows using the TMDB API. Users can create accounts, manage their favorites, and comment on content.

## Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js and NPM
- MySQL 5.7 or higher
- Git
- TMDB account and API key

## Technologies Used

- Laravel 10
- MySQL
- TMDB API
- Tailwind CSS 3.1
- Alpine.js 3.4
- Vite 5.0
- Embla Carousel 8.3
- Axios 1.6

## Installation

### 1. Clone the project
- `git clone https://github.com/ArthurDesc/cinetech.git`
- `cd cinetech`

### 2. Install dependencies
- `composer install`
- `npm install`

### 3. Configuration
- `cp .env.example .env`
- Configure your database in the `.env` file
- Add your TMDB API key in the `.env` file
- `php artisan key:generate`
- `php artisan migrate`

### 4. Run the project
- `php artisan serve & npm run dev`

## Version
- v1.0.0

## Links
- [Laravel Doc](https://laravel.com/docs/11.x)
- [TMDB API](https://developer.themoviedb.org/reference/intro/getting-started)
- [Download Composer](https://getcomposer.org/download/)
- [Download Node Js](https://nodejs.org/en/learn/getting-started/how-to-install-nodejs
