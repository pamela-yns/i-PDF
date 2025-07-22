# Docker Setup for Laravel Project

This project is now configured to run with Docker using the latest versions of Laravel, MySQL, and PHPMyAdmin.

## Services Included

- **Laravel App**: PHP 8.2 with FPM
- **Nginx**: Web server
- **MySQL 8.0**: Database server
- **PHPMyAdmin**: Database management interface

## Quick Start

1. **Setup Environment** (First time only):
   ```bash
   ./setup-docker.sh
   ```

2. **Build and Start Services**:
   ```bash
   docker-compose up -d --build
   ```

3. **Install Dependencies** (First time only):
   ```bash
   docker-compose exec app composer install
   docker-compose exec app npm install
   ```

4. **Run Migrations** (First time only):
   ```bash
   docker-compose exec app php artisan migrate
   ```

5. **Generate Application Key** (if needed):
   ```bash
   docker-compose exec app php artisan key:generate
   ```

## Access Points

- **Laravel Application**: http://localhost:8000
- **PHPMyAdmin**: http://localhost:8080
- **MySQL Workbench Connection**: localhost:3306

## MySQL Workbench Connection Details

- **Host**: localhost
- **Port**: 3306
- **Username**: root
- **Password**: root
- **Database**: laravel

## Useful Commands

### Start Services
```bash
docker-compose up -d
```

### Stop Services
```bash
docker-compose down
```

### View Logs
```bash
docker-compose logs -f
```

### Access Laravel Container
```bash
docker-compose exec app bash
```

### Run Artisan Commands
```bash
docker-compose exec app php artisan [command]
```

### Run Composer Commands
```bash
docker-compose exec app composer [command]
```

### Run NPM Commands
```bash
docker-compose exec app npm [command]
```

## Database Management

### Access PHPMyAdmin
- URL: http://localhost:8080
- Username: root
- Password: root

### Direct MySQL Access
```bash
docker-compose exec db mysql -u root -proot
```

## File Structure

```
docker/
├── nginx/
│   └── conf.d/
│       └── app.conf
├── php/
│   └── local.ini
└── mysql/
    └── my.cnf
```

## Troubleshooting

### If you can't access the application:
1. Check if containers are running: `docker-compose ps`
2. Check logs: `docker-compose logs`
3. Rebuild containers: `docker-compose up -d --build`

### If database connection fails:
1. Ensure MySQL container is running: `docker-compose ps db`
2. Check MySQL logs: `docker-compose logs db`
3. Verify .env configuration matches Docker settings

### Reset Everything:
```bash
docker-compose down -v
docker-compose up -d --build
```

## Environment Variables

The setup script automatically configures your `.env` file for Docker. Key changes:
- `DB_CONNECTION=mysql`
- `DB_HOST=db`
- `DB_USERNAME=laravel`
- `DB_PASSWORD=secret`
- `APP_URL=http://localhost:8000`

## Notes

- The MySQL data is persisted in a Docker volume
- PHPMyAdmin is accessible at port 8080
- MySQL is accessible at port 3306 for external tools like MySQL Workbench
- All Laravel files are mounted as volumes, so changes are reflected immediately 