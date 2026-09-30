# Task Manager API

A Laravel 12 API for creating and managing tasks. Tasks can be listed, created, viewed, updated, and deleted. The project uses a repository interface to access task data and a Laravel API resource to shape task responses.

## Requirements

- PHP 8.2 or later
- Composer
- SQLite (the default database configuration) or another database supported by Laravel

## Setup

Run these commands from the project directory in PowerShell:

```powershell
composer install
Copy-Item .env.example .env
New-Item database/database.sqlite -ItemType File -Force
php artisan key:generate
php artisan migrate
php artisan serve
```

The API is available at `http://localhost:8000`. The default `.env.example` uses SQLite. If you use a different database, update the `DB_*` values in `.env` before running migrations.

## Postman

Import [`postman/Task Manager API.postman_collection.json`](postman/Task%20Manager%20API.postman_collection.json) into Postman. The collection has a `base_url` variable set to `http://localhost:8000` and a blank `token` variable.

The `/api/user` route requires a Sanctum bearer token. This API does not define a login or token-issuing route, so set the collection's `token` variable yourself before calling that endpoint.

## API routes

All routes are prefixed with `/api`.

| Method | Endpoint | Description | Authentication |
| --- | --- | --- | --- |
| `GET` | `/api/tasks` | List tasks | None |
| `POST` | `/api/tasks` | Create a task | None |
| `GET` | `/api/tasks/{id}` | Get one task | None |
| `PUT` / `PATCH` | `/api/tasks/{id}` | Update a task | None |
| `DELETE` | `/api/tasks/{id}` | Delete a task | None |
| `GET` | `/api/user` | Get the authenticated user | Sanctum bearer token |

### Create a task

`title` is required and must be a string of at most 255 characters. `description` is optional and can be `null`.

```http
POST /api/tasks
Accept: application/json
Content-Type: application/json
```

```json
{
  "title": "Prepare project proposal",
  "description": "Draft the proposal and share it with the team."
}
```

### Update a task

All update fields are optional. When provided, `title` must be a string of at most 255 characters, `description` must be a string or `null`, and `is_completed` must be a boolean.

```http
PATCH /api/tasks/1
Accept: application/json
Content-Type: application/json
```

```json
{
  "is_completed": true
}
```

### Example task response

Task responses use the `TaskResource` fields inside the API response envelope:

```json
{
  "success": true,
  "message": "Task created successfully.",
  "code": 201,
  "data": {
    "id": 1,
    "title": "Prepare project proposal",
    "description": "Draft the proposal and share it with the team.",
    "is_completed": false
  }
}
```

Validation failures return HTTP `422` when the request asks for JSON. Missing tasks are reported as not found. Other task data errors use the API error response envelope.

## Project structure

- `routes/api.php` defines the API routes.
- `app/Http/Controllers/Api/TaskController.php` handles task requests.
- `app/Http/Requests/Api/Tasks/` contains create and update validation rules.
- `app/Http/Resources/TaskResource.php` formats task data.
- `app/Repositories/` contains the task repository and interface.
- `app/Exceptions/RecordNotFoundException.php` represents a task lookup failure.
- `database/migrations/` defines the tasks table.

## Tests

Run the Laravel test suite with:

```powershell
php artisan test
```
