#!/bin/bash

set -e

if [ ! -f /var/www/html/composer.json ]; then
    composer create-project laravel/laravel .

    cp .env .env.dev
    sed -i 's/APP_ENV=local/APP_ENV=dev/g' .env.dev

    cp .env .env.testing
    sed -i 's/APP_ENV=local/APP_ENV=testing/g' .env.testing

    cp .env .env.production
    sed -i 's/APP_ENV=local/APP_ENV=production/g' .env.production

    # remove resources
    rm -rf resources

    echo "Laravel application has been created."
fi

exec "$@"
