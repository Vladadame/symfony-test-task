# Symfony Test Task API

REST API for storing and retrieving user records.

## Features

- Accepts user data via JSON
- Processes requests asynchronously using Symfony Messenger
- Stores user records in PostgreSQL
- Saves client IP address
- Resolves country via external API (iplocation)
- Supports sorting of results
- OpenAPI (Swagger) documentation included
- Covered by tests (PHPUnit)

---

## Tech Stack

- PHP 8.4
- Symfony
- Doctrine ORM
- PostgreSQL
- Symfony Messenger
- PHPUnit
- NelmioApiDocBundle (Swagger)

---

## How it works

### POST /api/users

- Accepts JSON payload
- Validates input
- Dispatches message to queue
- Returns `202 Accepted`

### Worker

- Consumes messages from queue
- Resolves country by IP
- Creates entities
- Saves data to database

### GET /api/users

- Returns stored records
- Supports sorting:
  - `sort=firstName|lastName|country|createdAt`
  - `order=asc|desc`

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

  Configure environment

Create .env.local:

DATABASE_URL="postgresql://postgres:postgres@127.0.0.1:5433/test_task?serverVersion=16&charset=utf8"
MESSENGER_TRANSPORT_DSN=doctrine://default
