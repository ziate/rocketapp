#!/usr/bin/env bash
set -euo pipefail

PROJECT_DIR=${1:-delivery-app}

if [ -d "$PROJECT_DIR" ]; then
  echo "Directory '$PROJECT_DIR' already exists."
  exit 1
fi

echo "Creating Laravel project in $PROJECT_DIR"
composer create-project laravel/laravel "$PROJECT_DIR"

echo "Copying scaffold files"
cp -R app database resources routes "$PROJECT_DIR"/

cd "$PROJECT_DIR"

if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate
fi

echo "Done. Update .env with database settings, then run: php artisan migrate"
