#!/bin/bash

# Database setup script for Symfony Student Management API
# This script helps set up PostgreSQL database for the project

echo "Setting up PostgreSQL database for Symfony Student Management API"
echo "================================================================"
echo ""

# Check if PostgreSQL is running
if ! systemctl is-active --quiet postgresql; then
    echo "PostgreSQL is not running. Starting PostgreSQL service..."
    sudo systemctl start postgresql
    if [ $? -eq 0 ]; then
        echo "PostgreSQL started successfully."
    else
        echo "Failed to start PostgreSQL. Please check your installation."
        exit 1
    fi
else
    echo "PostgreSQL is already running."
fi

echo ""
echo "Please provide the following information:"
echo ""

# Get database name
read -p "Database name [student_management]: " DB_NAME
DB_NAME=${DB_NAME:-student_management}

# Get database user
read -p "Database user [postgres]: " DB_USER
DB_USER=${DB_USER:-postgres}

# Get database password
read -s -p "Database password: " DB_PASSWORD
echo ""

# Get database host
read -p "Database host [127.0.0.1]: " DB_HOST
DB_HOST=${DB_HOST:-127.0.0.1}

# Get database port
read -p "Database port [5432]: " DB_PORT
DB_PORT=${DB_PORT:-5432}

echo ""
echo "Creating database '$DB_NAME'..."

# Create database
sudo -u postgres createdb "$DB_NAME" 2>/dev/null
if [ $? -eq 0 ]; then
    echo "Database '$DB_NAME' created successfully."
elif [ $? -eq 1 ]; then
    echo "Database '$DB_NAME' already exists."
else
    echo "Failed to create database. Please check your PostgreSQL installation."
    exit 1
fi

echo ""
echo "Updating .env file..."

# Update .env file with database configuration
ENV_FILE=".env"
if [ -f "$ENV_FILE" ]; then
    # Create backup
    cp "$ENV_FILE" "$ENV_FILE.backup"
    
    # Update DATABASE_URL
    sed -i "s|DATABASE_URL=.*|DATABASE_URL=\"postgresql://$DB_USER:$DB_PASSWORD@$DB_HOST:$DB_PORT/$DB_NAME?serverVersion=16&charset=utf8\"|" "$ENV_FILE"
    
    echo ".env file updated successfully."
    echo "Backup created as .env.backup"
else
    echo "Warning: .env file not found. Please create it manually with:"
    echo "DATABASE_URL=\"postgresql://$DB_USER:$DB_PASSWORD@$DB_HOST:$DB_PORT/$DB_NAME?serverVersion=16&charset=utf8\""
fi

echo ""
echo "Database setup completed!"
echo ""
echo "Next steps:"
echo "1. Run migrations: php bin/console doctrine:migrations:migrate"
echo "2. Start the server: php -S localhost:8000 -t public/"
echo "3. Test the API: php test_api.php"
echo ""
echo "API endpoints will be available at:"
echo "- Student registration: POST http://localhost:8000/api/students/register"
echo "- API documentation: http://localhost:8000/api"
