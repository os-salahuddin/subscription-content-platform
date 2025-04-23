# Laravel Subscription-Based Content Platform

## Setup
```bash
git clone https://github.com/os-salahuddin/subscription-content-platform.git
composer install
cp .env.example .env and update database config 
php artisan key:generate
php artisan migrate
npm install
npm run dev
php artisan serve
