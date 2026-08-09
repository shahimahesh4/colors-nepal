# Production Deployment

## Required environment

- PHP 8.2 or newer with Laravel-required extensions
- MySQL/MariaDB or another configured production database
- Web root pointed to the public directory
- Node.js is only required during the asset build
- APP_ENV=production
- APP_DEBUG=false
- A unique APP_KEY generated with php artisan key:generate
- HTTPS APP_URL
- Production database, mail, queue, cache, and session settings
- MAIL_TO_ADDRESS set to the team inbox receiving leads

Never commit the production .env file or credentials.

## First deployment

1. Run composer install --no-dev --optimize-autoloader.
2. Run npm ci and npm run build in the build environment.
3. Run php artisan migrate --force.
4. Run php artisan storage:link.
5. Ensure storage and bootstrap/cache are writable by the web process.
6. Run php artisan optimize.
7. Start a queue worker when QUEUE_CONNECTION is not sync.
8. Configure the web server health check to GET /up.

## Release verification

- Open the homepage, contact form, quote form, login, and /stnapanel login.
- Confirm /robots.txt and /sitemap.xml use the production APP_URL.
- Submit a test lead and confirm delivery to MAIL_TO_ADDRESS.
- Confirm regular customers receive 403 from /stnapanel.
- Confirm APP_DEBUG is false and HTTPS cookies are configured by the hosting environment.
- Back up the database and uploaded storage before each migration release.

## Routine commands

php artisan migrate --force
php artisan optimize
php artisan queue:restart

Use php artisan optimize:clear before troubleshooting stale cached configuration.
