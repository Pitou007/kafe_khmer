# ---- 1) Build frontend assets (Vite) ----
FROM node:20-alpine AS frontend
WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build

# ---- 2) PHP + Nginx runtime ----
FROM richarvey/nginx-php-fpm:latest

ENV WEBROOT /var/www/html/public
WORKDIR /var/www/html

# Copy app source
COPY . /var/www/html

# Copy Vite output (assets + manifest) into public/build
COPY --from=frontend /app/public/build /var/www/html/public/build

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Nginx config for Laravel
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Optional: cache config/routes/views on startup


COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
CMD ["/entrypoint.sh"]

