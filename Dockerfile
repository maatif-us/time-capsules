FROM php:8.1-cli

# Install system dependencies
RUN apt-get update \
    && apt-get install -y \
        libzip-dev \
        unzip \
        git \
        curl \
    && docker-php-ext-install pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js and npm (ensure this step is correct and successful)
RUN curl -sL https://deb.nodesource.com/setup_14.x -o nodesource_setup.sh
RUN bash nodesource_setup.sh
RUN apt-get install nodejs -y
RUN apt-get install npm -y
RUN command -v node
RUN command -v npm

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copy composer and npm related files to the container
COPY composer.json composer.lock package.json package-lock.json ./

# Install Composer dependencies
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist

# Install npm dependencies
RUN npm install

# Copy the rest of the application files to the container
COPY . .

EXPOSE 8000 8081

RUN npm run dev &

RUN ["chmod", "+x", "entrypoint.sh"]
CMD ["sh", "./entrypoint.sh"]