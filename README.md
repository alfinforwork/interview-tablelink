
## 🚀 Quick Start with Docker

### 1. Setup

```bash
# Copy environment file
cp .env.docker .env

# Start all containers
docker-compose up -d

# Run database migrations
docker-compose exec app php artisan migrate
```

### 2. Access the Application

Open your browser to: **http://localhost**

### 3. Login with Dummy Users

<b>*you need to do seed first</b>

| Email | Password | Role |
|-------|----------|------|
| alfinforwork@gmail.com | 12345678 | Admin |

---

## 📋 Docker Commands

### Start & Stop

```bash
# Start all services
docker-compose up -d

# Stop all services
docker-compose down

# Stop and remove all data (volumes)
docker-compose down -v

# Restart services
docker-compose restart
```

### Logs & Debugging

```bash
# View application logs
docker-compose logs -f app

# View MySQL logs
docker-compose logs -f mysql

# View Nginx logs
docker-compose logs -f nginx

# Check container status
docker-compose ps
```

### Database

```bash
# Run migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed

# Access MySQL shell
docker-compose exec mysql mysql -u tablelink -p tablelink
```

### Artisan Commands

```bash
# Clear cache
docker-compose exec app php artisan cache:clear

# Clear config
docker-compose exec app php artisan config:clear

# Tinker shell
docker-compose exec app php artisan tinker

# Run tests
docker-compose exec app php artisan test
```


