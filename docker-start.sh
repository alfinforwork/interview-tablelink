#!/bin/bash

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}🚀 Starting Tablelink Application with Docker...${NC}"

# Copy environment file
if [ ! -f .env ]; then
    echo -e "${BLUE}📋 Setting up environment variables...${NC}"
    cp .env.docker .env

    # Generate APP_KEY
    echo -e "${BLUE}🔑 Generating APP_KEY...${NC}"
    docker-compose run --rm app php artisan key:generate
fi

# Build and start containers
echo -e "${BLUE}🐳 Building and starting containers...${NC}"
docker-compose up -d

# Wait for MySQL to be ready
echo -e "${BLUE}⏳ Waiting for MySQL to be ready...${NC}"
sleep 10

# Run migrations
echo -e "${BLUE}🗄️  Running database migrations...${NC}"
docker-compose exec -T app php artisan migrate --force

# Seed database (optional)
# echo -e "${BLUE}🌱 Seeding database...${NC}"
# docker-compose exec -T app php artisan db:seed

echo -e "${GREEN}✅ Tablelink Application is running!${NC}"
echo -e "${GREEN}🌐 Access the application at: http://localhost${NC}"
echo ""
echo -e "${BLUE}Useful commands:${NC}"
echo "  View logs:        docker-compose logs -f app"
echo "  Run artisan:      docker-compose exec app php artisan [command]"
echo "  Access database:  docker-compose exec mysql mysql -u tablelink -p tablelink"
echo "  Stop containers:  docker-compose down"
