FROM node:20-alpine AS build

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . ./
RUN npm run build

FROM wordpress:latest

WORKDIR /var/www/html
RUN mkdir -p /var/www/html/wp-content/themes/mypage

COPY style.css /var/www/html/wp-content/themes/mypage/style.css
COPY index.php /var/www/html/wp-content/themes/mypage/index.php
COPY functions.php /var/www/html/wp-content/themes/mypage/functions.php
COPY front-page.php /var/www/html/wp-content/themes/mypage/front-page.php
COPY templates_parts /var/www/html/wp-content/themes/mypage/templates_parts
# COPY assets/images /var/www/html/wp-content/themes/mypage/assets/images
COPY --from=build /app/dist /var/www/html/wp-content/themes/mypage/dist
