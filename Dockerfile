FROM node:20-alpine AS build

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . ./
RUN npm run build

FROM wordpress:latest

WORKDIR /var/www/html

COPY --chown=www-data:www-data wp-content/themes/mypage /var/www/html/wp-content/themes/mypage
# Copy custom plugins if present in repo
COPY --chown=www-data:www-data wp-content/plugins /var/www/html/wp-content/plugins
COPY --chown=www-data:www-data wp-content/uploads /var/www/html/wp-content/uploads
COPY --chown=www-data:www-data --from=build /app/dist /var/www/html/wp-content/themes/mypage/dist
