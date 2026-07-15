#!/bin/sh
set -e

mkdir -p \
    storage/app/public/livewire-tmp \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    bootstrap/cache

chmod -R 775 storage bootstrap/cache

php artisan storage:link --force

php \
    -d upload_max_filesize=40M \
    -d post_max_size=45M \
    -d memory_limit=256M \
    -d max_execution_time=120 \
    -d max_input_time=120 \
    artisan serve --host=0.0.0.0 --port="${PORT:-8000}"
