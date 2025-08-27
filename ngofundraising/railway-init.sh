#!/bin/bash
# Railway one-click deployment helper

echo "🔹 Starting Railway deployment for ngofundraising"

# 1️⃣ Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# 2️⃣ Generate app key
php artisan key:generate

# 3️⃣ Run migrations & seeders
php artisan migrate --seed --force

echo "✅ Setup complete. Ready to serve."
echo "🚀 Use 'php artisan serve --host=0.0.0.0 --port=$PORT' to start"