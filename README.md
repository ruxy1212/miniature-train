<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# REST API with Basic CRUD Operation using PHP/Laravel

This application is a REST API with basic CRUD operation, built with Laravel 10, PHP 8.1.6 and SQLite Database, and can be used to create, read, update and delete a 'person' resource.

## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
- [Error Handling](#error-handling)
- [Testing](#testing)
- [UML Diagram](#uml-diagram)

## Installation
- Create a directory for the project, open the directory in the terminal and clone the repository into the directory:
    > git clone https://github.com/ruxy1212/miniature-train.git
- Navigate to the project folder and install the dependencies using `Composer`:
    > cd miniature-train && composer install

- Copy and create an environment file, and also generate a new application key by running the following command:
    > cp .env.example .env && php artisan key:generate

- Inside the `.env`, ensure only the database credential for `DB_CONNECTION` is set to `pgsql` and the other are set appropriately (`DB_HOST`, `DB_PORT`, etc)

- Migrate the database using the following command:
    > php artisan migrate

- Start the application server:
    > php artisan serve

## Usage
- URL: https://haiyrea.000webhostapp.com/api
- Detailed documentation of the API can be found here: [API Documentation](DOCUMENTATION.md)

### Add a new person.

**Request:**

```http
POST /
Content-Type: application/json

{
  "name": "Mark Essien"
}
```

**Response:**

```json
Status: 200 OK
Content-Type: application/json

{
    "error": false, 
    "message": "New person added successfully",
    "data": [
        {
            "id": 1,
            "name": "Mark Essien"
        }
    ]
}
```

### Fetching details of a person.

**Request:**

```http
GET /{id}
```

**Response:**

```json
Status: 200 OK
Content-Type: application/json

{
    "error": false, 
    "message": "Person fetched successfully",
    "data": [
        {
            "id": 1,
            "name": "Mark Essien"
        }
    ]
}
```

### Updating details of a person.

**Request:**

```http
PUT /{id} or PATCH /{id}
Content-Type: application/json

{
  "name": "Mark Naza Essien",
}
```

**Response:**

```json
Status: 200 OK
Content-Type: application/json

{
    "error": false, 
    "message": "Record updated successfully",
    "data": [
        {
            "id": 1,
            "name": "Mark Naza Essien"
        }
    ]
}
```

### Deleting a person.

**Request:**

```http
DELETE /{id}
```

**Response:**

```json
Status: 202 Accepted
Content-Type: application/json

{
    "error": false, 
    "message": "Record deleted successfully"
}
```

### Fetching details of all persons.

**Request:**

```http
GET /
```

**Response:**

```json
Status: 200 OK
Content-Type: application/json

{
    "error": false, 
    "message": "All records fetched successfully",
    "data": [
        {
            "id": 1,
            "name": "Mark Naza Essien"
        },
        {
            "id": 3,
            "name": "Russell PURE"
        }
    ]
}
```

Note: Replace `{id}` in the URLs with the actual ID of the user you want to retrieve, update, or delete.

## Error Handling
The API returns the following in case of an error:

```json
Status: Error Code
Content-Type: application/json

{
    "error": true, 
    "message": "Error Message"
}
```

## Testing
- Postman was used to test the API.
![ApiTest](https://github.com/ruxy1212/miniature-train/assets/85977511/15bac9fa-5ac5-4dbf-a4d4-a72b4581fd55)


## UML Diagram
![UML-Person](https://github.com/ruxy1212/miniature-train/assets/85977511/aee2bed5-6d7d-4295-8fcf-49c4baa81c49)

