# Docker Containerization Guide

## Quick Start

### 1. Generate APP_KEY
First, generate a Laravel application key in your `.env` file:
```bash
php artisan key:generate
```

Or use the automated setup script:
```bash
chmod +x docker-start.sh
./docker-start.sh
```

### 2. Start the Application
```bash
docker-compose up -d
```

The application will be available at `http://localhost`

### 3. Run Database Migrations
```bash
docker-compose exec app php artisan migrate
```

### 4. Seed Database (Optional)
```bash
docker-compose exec app php artisan db:seed
```

## Services

### Nginx (Port 80)
- Web server handling HTTP requests
- Reverse proxy to PHP-FPM
- Static file serving with caching

### Laravel App (PHP 8.4-FPM)
- Application container running PHP-FPM
- Composer dependencies installed
- Node modules and assets compiled

### MySQL (Port 3306)
- Database server
- Persistent data volume (`mysql-data`)
- Health checks enabled

## Environment Variables

The `.env.docker` file contains default Docker configuration. Update these values:

```env
# Database
DB_PASSWORD=your_secure_password_here
MYSQL_ROOT_PASSWORD=root_secure_password_here
```

**Important**: Change these passwords before deploying to production!

## Common Commands

```bash
# View logs
docker-compose logs -f app

# Run Artisan commands
docker-compose exec app php artisan tinker
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear

# Access MySQL CLI
docker-compose exec mysql mysql -u tablelink -p tablelink

# Stop containers
docker-compose down

# Remove volumes and start fresh
docker-compose down -v
docker-compose up -d

# Rebuild containers after code changes
docker-compose up -d --build
```

## Accessing Services

- **Laravel Application**: http://localhost
- **MySQL Database**: localhost:3306
  - Username: `tablelink`
  - Password: (from `.env`)
  - Database: `tablelink`

## Production Considerations

Before deploying to production:

1. **Change All Passwords**: Update `DB_PASSWORD` and `MYSQL_ROOT_PASSWORD` in `.env`
2. **Set APP_DEBUG**: Set `APP_DEBUG=false` in `.env`
3. **Update APP_URL**: Set correct domain in `APP_URL`
4. **Use Strong Keys**: Ensure `APP_KEY` is securely generated
5. **Enable HTTPS**: Configure SSL certificates in Nginx
6. **Database Backups**: Set up automated backup strategy for MySQL volume
7. **Log Rotation**: Configure log rotation for application and Nginx logs

## Troubleshooting

### MySQL connection fails
```bash
docker-compose logs mysql
docker-compose exec mysql mysqladmin ping
```

### Application crashes on startup
```bash
docker-compose logs app
docker-compose exec app php artisan config:cache
```

### Port already in use
Change ports in `docker-compose.yml`:
```yaml
ports:
  - "8080:80"  # Access at http://localhost:8080
```

### Permissions issues
```bash
docker-compose exec app chown -R www-data:www-data /app
```
