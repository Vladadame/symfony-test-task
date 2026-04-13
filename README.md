# Symfony Test Task API

REST API for storing and retrieving user records.

## Features

* Create user records via JSON
* Asynchronous processing using Symfony Messenger
* Store data in PostgreSQL
* Save client IP address
* Resolve country via external API
* Sorting support for GET requests
* API Key authentication (via header)
* OpenAPI documentation (Swagger)
* Covered by tests (PHPUnit)

---

## Tech Stack

* PHP 8.4
* Symfony
* Doctrine ORM
* PostgreSQL
* Symfony Messenger
* NelmioApiDocBundle (Swagger)
* PHPUnit

---

## Endpoints

### POST /api/users

Creates a new user record (asynchronously).

**Request example:**

```json
{
  "firstName": "Yura",
  "lastName": "Test",
  "phoneNumbers": ["+380971234567"]
}
```

**Response:**

* `202 Accepted`

---

### GET /api/users

Returns stored user records.

**Query parameters:**

* `sort`: `firstName | lastName | country | createdAt`
* `order`: `asc | desc`

---

## Authentication

All `/api/*` endpoints require API key.

Add header to requests:

```
X-API-Key: super-secret-key
```

---

## How it works

### POST flow

Controller → DTO → MessageBus → Message → Handler → Resolver → Entity → DB

### Worker

* Consumes messages from queue
* Resolves country by IP
* Creates entities
* Saves data to database

### GET flow

Controller → DTO → Repository → DB → DTO → JSON response

---

## Setup & Run

### 1. Start PostgreSQL (Docker)

```bash
docker run --name test-task-postgres \
  -e POSTGRES_DB=test_task \
  -e POSTGRES_USER=postgres \
  -e POSTGRES_PASSWORD=postgres \
  -p 5433:5432 \
  -d postgres:16
```

---

### 2. Configure environment

Create `.env.local`:

```
DATABASE_URL="postgresql://postgres:postgres@127.0.0.1:5433/test_task?serverVersion=16&charset=utf8"
MESSENGER_TRANSPORT_DSN=doctrine://default
APP_API_KEY=super-secret-key
```

---

### 3. Run migrations

```bash
php bin/console doctrine:migrations:migrate
```

---

### 4. Setup messenger

```bash
php bin/console messenger:setup-transports
```

---

### 5. Start server

```bash
symfony server:start
```

---

### 6. Start worker

```bash
php bin/console messenger:consume async -vv
```

---

## API Documentation

Swagger UI available at:

```
http://127.0.0.1:8000/api/doc
```

Use the **Authorize** button and provide API key:

```
super-secret-key
```

---

## Run Tests

```bash
php bin/phpunit
```

---

## Notes

* Worker must be running for async processing
* API key is required for all endpoints
* Country resolution depends on external API availability
* Sorting supports one field at a time
* Local IP (127.0.0.1) may return null country

---

## Test Environment

Create `.env.test.local` and configure test database connection.

Then run:

```bash
php bin/console doctrine:migrations:migrate --env=test -n
php bin/console messenger:setup-transports --env=test
php bin/phpunit
```

