# Docker Setup Guide for Furniture E-commerce

This guide explains how to run the Laravel Furniture E-commerce application using Docker.

## 🐳 Docker Setup

### Prerequisites
- Docker Engine 20.10+
- Docker Compose 2.0+
- 4GB+ RAM available for containers
- 10GB+ disk space

### Quick Start

1. **Clone and navigate to the project**
   ```bash
   git clone <repository-url>
   cd furniture-ecommerce
   ```

2. **Build and start the application**
   ```bash
   docker-compose up -d --build
   ```

3. **Wait for services to be ready**
   ```bash
   # Check container status
   docker-compose ps
   
   # Follow logs
   docker-compose logs -f app
   ```

4. **Access the application**
   - **Main Application**: http://localhost:8000
   - **Database Admin**: http://localhost:8080 (phpMyAdmin)
   - **Redis Admin**: http://localhost:8081 (Redis Commander)
   - **Email Testing**: http://localhost:8025 (Mailhog)

### 🛠 Docker Services

#### Application Stack
- **app**: Laravel application with PHP-FPM + Nginx
- **mysql**: MySQL 8.0 database
- **redis**: Redis for caching and sessions
- **nginx**: Load balancer (optional)

#### Development Tools
- **mailhog**: Email testing server
- **phpmyadmin**: Database management interface
- **redis-commander**: Redis management interface

### 📁 Docker Configuration Files

```
docker/
├── nginx/
│   ├── nginx.conf          # Nginx main configuration
│   └── ssl/               # SSL certificates (for HTTPS)
├── mysql/
│   └── init.sql           # MySQL initialization script
└── php/
    ├── php.ini            # PHP configuration
    └── php-fpm.conf       # PHP-FPM configuration
```

### 🔧 Environment Variables

Create a `.env` file or modify the existing one:

```env
# Application
APP_NAME="Furniture Store"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=furniture_ecommerce
DB_USERNAME=laravel_user
DB_PASSWORD=secure_password

# Redis
REDIS_HOST=redis
REDIS_PASSWORD=redis_password
REDIS_PORT=6379

# Cache & Sessions
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Email (using Mailhog for development)
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

### 🚀 Production Deployment

#### 1. Environment Setup
```bash
# Copy production environment
cp .env.example .env.production

# Edit production values
nano .env.production
```

#### 2. SSL Configuration
```bash
# Create SSL directory
mkdir -p docker/nginx/ssl

# Add your SSL certificates
cp your-cert.pem docker/nginx/ssl/cert.pem
cp your-key.pem docker/nginx/ssl/key.pem
```

#### 3. Production Build
```bash
# Build for production
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d --build

# Run migrations and seeding
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan db:seed --force
```

### 📊 Monitoring & Maintenance

#### Health Checks
```bash
# Check application health
curl http://localhost:8000/health.php

# Check all services
docker-compose ps
```

#### Logs
```bash
# Application logs
docker-compose logs -f app

# Database logs
docker-compose logs -f mysql

# All services
docker-compose logs -f
```

#### Database Backup
```bash
# Create backup
docker-compose exec mysql mysqldump -u laravel_user -psecure_password furniture_ecommerce > backup.sql

# Restore backup
docker-compose exec -T mysql mysql -u laravel_user -psecure_password furniture_ecommerce < backup.sql
```

#### Cache Management
```bash
# Clear application cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear

# Clear Redis cache
docker-compose exec redis redis-cli -a redis_password FLUSHALL
```

### 🔧 Development Commands

#### Access Containers
```bash
# Laravel container shell
docker-compose exec app bash

# MySQL shell
docker-compose exec mysql mysql -u laravel_user -psecure_password furniture_ecommerce

# Redis shell
docker-compose exec redis redis-cli -a redis_password
```

#### Laravel Commands
```bash
# Run migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed

# Create admin user
docker-compose exec app php artisan make:user-admin

# Queue worker status
docker-compose exec app php artisan queue:work --once
```

#### Frontend Assets
```bash
# Install dependencies
docker-compose exec app npm install

# Build assets
docker-compose exec app npm run production

# Watch for changes (development)
docker-compose exec app npm run watch
```

### 🔒 Security Considerations

#### Production Security
- Change default passwords in `.env`
- Use SSL certificates for HTTPS
- Configure firewall rules
- Enable fail2ban for brute force protection
- Regular security updates

#### Docker Security
- Run containers as non-root user
- Use specific image tags (not `latest`)
- Scan images for vulnerabilities
- Limit container resources
- Use secrets management

### 📈 Performance Tuning

#### Database Optimization
```sql
-- MySQL performance settings
SET GLOBAL innodb_buffer_pool_size = 512M;
SET GLOBAL max_connections = 300;
SET GLOBAL query_cache_size = 64M;
```

#### Redis Configuration
```bash
# Redis memory optimization
docker-compose exec redis redis-cli -a redis_password CONFIG SET maxmemory 256mb
docker-compose exec redis redis-cli -a redis_password CONFIG SET maxmemory-policy allkeys-lru
```

#### Application Scaling
```bash
# Scale application containers
docker-compose up -d --scale app=3

# Use nginx load balancer
docker-compose -f docker-compose.yml -f docker-compose.scale.yml up -d
```

### 🔍 Troubleshooting

#### Common Issues

1. **Port conflicts**
   ```bash
   # Change ports in docker-compose.yml
   ports:
     - "8001:80"  # Instead of 8000:80
   ```

2. **Permission issues**
   ```bash
   # Fix storage permissions
   docker-compose exec app chown -R www:www storage bootstrap/cache
   docker-compose exec app chmod -R 775 storage bootstrap/cache
   ```

3. **Database connection failed**
   ```bash
   # Check MySQL container
   docker-compose logs mysql
   
   # Test connection
   docker-compose exec app php artisan migrate:status
   ```

4. **Application not loading**
   ```bash
   # Check application logs
   docker-compose logs app
   
   # Check nginx configuration
   docker-compose exec app nginx -t
   ```

#### Performance Issues
```bash
# Check resource usage
docker stats

# Monitor container health
docker-compose exec app curl -f http://localhost/health.php
```

### 📝 Additional Notes

- Default admin credentials: `admin@furniturestore.com` / `password`
- Database is automatically seeded with sample data
- Queue workers are automatically started
- Laravel scheduler runs every minute
- File uploads are stored in persistent volumes
- Logs are automatically rotated

For more detailed configuration, refer to the individual service documentation in the `docker/` directory.
