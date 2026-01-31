#!/bin/bash

# Tablelink Docker Setup Script
# Usage: ./docker-setup.sh

set -e

echo "🐳 Tablelink Docker Setup"
echo "========================="

# Check if .env exists, if not copy from .env.docker
if [ ! -f .env ]; then
    echo "📝 Creating .env file from .env.docker..."
    cp .env.docker .env
fi

# Build and start containers
echo "🔨 Building Docker containers..."
docker-compose build

echo "🚀 Starting Docker containers..."
docker-compose up -d

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
sleep 10

# Install composer dependencies
echo "📦 Installing Composer dependencies..."
docker-compose exec -T app composer install --no-interaction --optimize-autoloader

# Generate application key if not set
echo "🔑 Generating application key..."
docker-compose exec -T app php artisan key:generate --force

# Run migrations
echo "🗃️ Running database migrations..."
docker-compose exec -T app php artisan migrate --force

# Seed database (optional)
echo "🌱 Seeding database..."
docker-compose exec -T app php artisan db:seed --force

# Clear and cache configs
echo "🧹 Optimizing application..."
docker-compose exec -T app php artisan config:clear
docker-compose exec -T app php artisan route:clear
docker-compose exec -T app php artisan view:clear

# Set permissions
echo "🔐 Setting permissions..."
docker-compose exec -T app chmod -R 775 /var/www/storage /var/www/bootstrap/cache

echo ""
echo "✅ Setup complete!"
echo ""
echo "🌐 Application URL: http://localhost:8080"
echo ""
echo "📋 Useful commands:"
echo "  - Start:   docker-compose up -d"
echo "  - Stop:    docker-compose down"
echo "  - Logs:    docker-compose logs -f"
echo "  - Shell:   docker-compose exec app bash"
echo "  - Artisan: docker-compose exec app php artisan <command>"
echo ""
