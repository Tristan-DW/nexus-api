<div align="center">

<img src="https://skillicons.dev/icons?i=php,laravel,mysql,redis,docker" />

<br/>

![GitHub last commit](https://img.shields.io/github/last-commit/Tristan-DW/nexus-api?style=for-the-badge&color=6e40c9)
![GitHub stars](https://img.shields.io/github/stars/Tristan-DW/nexus-api?style=for-the-badge&color=f0883e)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Redis](https://img.shields.io/badge/Redis-DC382D?style=for-the-badge&logo=redis&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-238636?style=for-the-badge)

# nexus-api

> **Production-grade REST API built with Laravel, MySQL, Redis, and Sanctum token authentication.**

</div>

---

## Overview

**nexus-api** is a battle-tested API foundation built on Laravel. It covers the full production stack: structured routing, Sanctum-based auth with token management, MySQL persistence, Redis caching, form request validation, rate limiting, and centralized error handling. Drop it in as the backend for any web or mobile application.

---

## Features

| Feature | Description |
|---|---|
| **Laravel Sanctum Auth** | API token issuance, revocation, and middleware-guarded routes |
| **MySQL** | Eloquent ORM, migrations, seeders, query optimization |
| **Redis Caching** | Response and query caching with configurable TTL via Laravel Cache |
| **Rate Limiting** | Per-user and per-IP throttle middleware |
| **Form Request Validation** | Dedicated request classes with structured error responses |
| **API Resources** | Consistent JSON response shaping via Laravel Resources |
| **Queue Workers** | Background jobs via Laravel Queues backed by Redis |
| **Docker** | Full `docker-compose` setup for local development |

---

## Quick Start

```bash
git clone https://github.com/Tristan-DW/nexus-api.git
cd nexus-api

cp .env.example .env
docker-compose up -d

composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

API runs at `http://localhost:8000`

---

## API Reference

| Method | Endpoint | Description | Auth |
|---|---|---|---|
| `POST` | `/api/auth/register` | Register new user | No |
| `POST` | `/api/auth/login` | Login, receive token | No |
| `POST` | `/api/auth/logout` | Revoke current token | Yes |
| `GET` | `/api/user` | Get authenticated user | Yes |
| `PUT` | `/api/user` | Update profile | Yes |
| `GET` | `/api/health` | Service health check | No |

---

## Project Structure

```
nexus-api/
├── app/
│   ├── Http/
│   │   ├── Controllers/    # Route handlers
│   │   ├── Requests/       # Form validation
│   │   └── Resources/      # JSON response shaping
│   ├── Models/             # Eloquent models
│   └── Services/           # Business logic
├── database/
│   ├── migrations/
│   └── seeders/
├── routes/
│   └── api.php
├── docker-compose.yml
├── .env.example
└── composer.json
```

---

## Environment Variables

```env
APP_NAME=nexus-api
APP_ENV=local
APP_KEY=

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=nexus
DB_USERNAME=nexus
DB_PASSWORD=secret

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
REDIS_HOST=redis
REDIS_PORT=6379
```

---

## Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/my-feature`)
3. Commit your changes (`git commit -m 'Add my feature'`)
4. Push to the branch (`git push origin feature/my-feature`)
5. Open a Pull Request

---

<div align="center">

<sub>Architected by <a href="https://github.com/Tristan-DW">Tristan</a> - Head Architect</sub>

</div>
