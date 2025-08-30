# Symfony Student Management API

A Symfony 6.4 project with API Platform for managing student entities.

## Features

- Student entity with id, username, and phoneNumber properties
- RESTful API endpoints using API Platform
- Custom registration endpoint for students
- PostgreSQL database with Doctrine ORM
- Input validation and error handling

## Requirements

- PHP 8.1 or higher
- Composer
- PostgreSQL 12 or higher
- Symfony CLI (optional, for development server)

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd symfonyProject
```

2. Install dependencies:
```bash
composer install
```

3. Configure your database connection in `.env`:
```env
DATABASE_URL="postgresql://username:password@127.0.0.1:5432/database_name?serverVersion=16&charset=utf8"
```

4. Create the database:
```bash
# Start PostgreSQL service first
sudo systemctl start postgresql

# Create database (replace with your database name)
createdb student_management
```

5. Run migrations:
```bash
php bin/console doctrine:migrations:migrate
```

6. Start the development server:
```bash
# Using Symfony CLI
symfony server:start

# Or using PHP built-in server
php -S localhost:8000 -t public/
```

## API Endpoints

### Student Registration
- **URL**: `POST /api/students/register`
- **Content-Type**: `application/json`
- **Request Body**:
```json
{
    "username": "john_doe",
    "phoneNumber": "+1234567890"
}
```

- **Response** (Success - 201):
```json
{
    "message": "Student registered successfully",
    "student": {
        "id": 1,
        "username": "john_doe",
        "phoneNumber": "+1234567890"
    }
}
```

- **Response** (Validation Error - 400):
```json
{
    "error": "Validation failed",
    "details": {
        "username": "Username is required",
        "phoneNumber": "Please provide a valid phone number"
    }
}
```

### API Platform Endpoints
- **API Documentation**: `/api`
- **Student Collection**: `/api/students`
- **Individual Student**: `/api/students/{id}`

## Entity Structure

### Student Entity
- `id` (int, auto-generated): Primary key
- `username` (string, 255 chars): Student's username (required, 2-255 chars)
- `phoneNumber` (string, 20 chars): Student's phone number (required, international format)

## Validation Rules

- **Username**: Required, 2-255 characters
- **Phone Number**: Required, must match international phone number format

## Database Schema

The project includes a migration file that creates the following table:

```sql
CREATE TABLE student (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) DEFAULT NULL,
    phone_number VARCHAR(20) DEFAULT NULL
);
```

## Development

### Adding New Fields
To add new fields to the Student entity:

1. Modify `src/Entity/Student.php`
2. Add validation constraints if needed
3. Create a new migration: `php bin/console make:migration`
4. Run the migration: `php bin/console doctrine:migrations:migrate`

### Testing the API

You can test the API using tools like:
- **cURL**:
```bash
curl -X POST http://localhost:8000/api/students/register \
  -H "Content-Type: application/json" \
  -d '{"username": "test_user", "phoneNumber": "+1234567890"}'
```

- **Postman**: Import the endpoints and test with the provided examples
- **API Platform UI**: Visit `/api` in your browser for interactive documentation

## Troubleshooting

### Database Connection Issues
- Ensure PostgreSQL is running: `sudo systemctl status postgresql`
- Check your database credentials in `.env`
- Verify the database exists: `psql -l`

### Migration Issues
- If migrations fail, you can reset: `php bin/console doctrine:migrations:migrate first`
- Check migration status: `php bin/console doctrine:migrations:status`

## License

This project is open source and available under the [MIT License](LICENSE).
