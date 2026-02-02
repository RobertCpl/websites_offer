FROM node:20-alpine AS build

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . ./
RUN npm run build

FROM wordpress:latest

WORKDIR /var/www/html

COPY wp-content/themes/mypage /var/www/html/wp-content/themes/mypage
# Copy custom plugins if present in repo
COPY wp-content/plugins /var/www/html/wp-content/plugins
COPY wp-content/uploads /var/www/html/wp-content/uploads
# COPY assets/images /var/www/html/wp-content/themes/mypage/assets/images
COPY --from=build /app/dist /var/www/html/wp-content/themes/mypage/dist
