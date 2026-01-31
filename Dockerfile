FROM php:8.4-fpm

# Arguments defined in docker-compose.yml
ARG user=www
ARG uid=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    supervisor \
    chromium \
    chromium-driver \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY --chown=$user:$user . /var/www

# Set permissions
RUN chown -R $user:$user /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Set Chrome/Chromium environment variables for Panther
ENV PANTHER_NO_SANDBOX=1
ENV PANTHER_CHROME_DRIVER_BINARY=/usr/bin/chromedriver
ENV PANTHER_CHROME_BINARY=/usr/bin/chromium

USER $user

# Expose port 9000 for PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
