#!/bin/bash

echo "Setting up Docker environment for Laravel..."

# Backup current .env
cp .env .env.backup

# Update .env for Docker
sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=mysql/' .env
sed -i 's/# DB_HOST=127.0.0.1/DB_HOST=db/' .env
sed -i 's/# DB_PORT=3306/DB_PORT=3306/' .env
sed -i 's/# DB_DATABASE=laravel/DB_DATABASE=laravel/' .env
sed -i 's/# DB_USERNAME=root/DB_USERNAME=laravel/' .env
sed -i 's/# DB_PASSWORD=/DB_PASSWORD=secret/' .env
sed -i 's/APP_URL=http:\/\/localhost/APP_URL=http:\/\/localhost:8000/' .env

echo "Environment configured for Docker!"
echo "You can restore the original .env with: cp .env.backup .env" 