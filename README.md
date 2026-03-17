<div align="center">

<img src="https://skillicons.dev/icons?i=nodejs,express,postgres,redis" />

<br/>

![GitHub last commit](https://img.shields.io/github/last-commit/Tristan-DW/nexus-api?style=for-the-badge&color=6e40c9)
![GitHub stars](https://img.shields.io/github/stars/Tristan-DW/nexus-api?style=for-the-badge&color=f0883e)
![Node.js](https://img.shields.io/badge/Node.js-43853D?style=for-the-badge&logo=node.js&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-316192?style=for-the-badge&logo=postgresql&logoColor=white)
![Redis](https://img.shields.io/badge/Redis-DC382D?style=for-the-badge&logo=redis&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-238636?style=for-the-badge)

# nexus-api

> **Production-grade REST API built with Node.js, Express, PostgreSQL, Redis, and JWT authentication.**

</div>

---

## Overview

**nexus-api** is a battle-tested RESTful API foundation covering the full production stack - structured routing, JWT-based auth with refresh tokens, PostgreSQL persistence, Redis caching, request validation, rate limiting, and centralized error handling.

---

## Features

| Feature | Description |
|---|---|
| **JWT Auth** | Access + refresh token flow with Redis token blacklisting |
| **PostgreSQL** | Schema migrations, connection pooling via `pg` |
| **Redis Caching** | Response caching with configurable TTL |
| **Rate Limiting** | Per-IP and per-user rate limiting via Redis |
| **Validation** | Request body/param validation with `joi` |
| **Error Handling** | Centralized error middleware with structured responses |
| **Logging** | Structured request logging with `morgan` + `winston` |
| **Docker** | Full `docker-compose` setup for local development |

---

## Quick Start

```bash
git clone https://github.com/Tristan-DW/nexus-api.git
cd nexus-api

cp .env.example .env
docker-compose up -d

npm install
npm run migrate
npm run dev
```

Server starts at `http://localhost:3000`

---

## API Reference

| Method | Endpoint | Description | Auth |
|---|---|---|---|
| `POST` | `/auth/register` | Register new user | No |
| `POST` | `/auth/login` | Login, receive tokens | No |
| `POST` | `/auth/refresh` | Refresh access token | No |
| `POST` | `/auth/logout` | Invalidate refresh token | Yes |
| `GET` | `/users/me` | Get current user profile | Yes |
| `PUT` | `/users/me` | Update current user | Yes |
| `GET` | `/health` | Service health check | No |

---

## Project Structure

```
nexus-api/
├── src/
│   ├── config/         # DB, Redis, env config
│   ├── controllers/    # Route handlers
│   ├── middleware/     # Auth, validation, error handling
│   ├── models/         # Database models
│   ├── routes/         # Express routers
│   ├── services/       # Business logic layer
│   ├── utils/          # Helpers and utilities
│   └── app.js          # Express app entry point
├── migrations/         # SQL migration files
├── tests/              # Jest test suite
├── docker-compose.yml
├── .env.example
└── package.json
```

---

## Environment Variables

```env
PORT=3000
NODE_ENV=development

DATABASE_URL=postgresql://user:password@localhost:5432/nexus
REDIS_URL=redis://localhost:6379

JWT_SECRET=your_jwt_secret
JWT_EXPIRES_IN=15m
JWT_REFRESH_SECRET=your_refresh_secret
JWT_REFRESH_EXPIRES_IN=7d
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
