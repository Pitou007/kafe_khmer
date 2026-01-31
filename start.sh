#!/usr/bin/env bash
set -e

php artisan config:cache || true
php artisan route:cache  || true
php artisan view:cache   || true

# If you want auto-migrations on every deploy, uncomment:
# php artisan migrate --force || true

/start.sh.original
