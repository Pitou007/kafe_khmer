# ---- Build frontend assets (Vite) ----
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
RUN npm run build

# ---- PHP + Nginx runtime ----
FROM richarvey/nginx-php-fpm:latest

# Web root
ENV WEBROOT /var/www/html/public
WORKDIR /var/www/html

# Copy app source
COPY . /var/www/html

# Copy built assets into public/build
COPY --from=frontend /app/public/build /var/www/html/public/build

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copy nginx config + start script
COPY nginx.conf /etc/nginx/conf.d/default.conf
COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]
