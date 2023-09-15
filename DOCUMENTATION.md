# API Documentation

This documentation provides an overview of the endpoints available for interfacing with the "Person" resource and their standard request and response formats. It also includes sample usage, known limitations, and instructions for setting up and deploying the API.

## Base URL

The base URL for all endpoints is `https://haiyrea.000webhostapp.com/api`.

## Endpoints

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

In case of an error, the API returns the following response:

```json
Status: Error Code
Content-Type: application/json

{
    "error": true, 
    "message": "Error Message"
}
```

## Sample Usage

Here are how you can use the API:

1. Adding a new person:
   - Send a `POST` request to `/` with the person's name in the request body.
   - The API will respond with the person's details, including the assigned ID.

2. Fetching details of a person:
   - Send a `GET` request to `/{id}` with the person's ID in the URL.
   - The API will respond with the person's details.

3. Updating details of a person:
   - Send a `PUT` request to `/{id}` with the person's ID in the URL and the updated name in the request body.
   - The API will respond with the updated person's details.

4. Deleting a person:
   - Send a `DELETE` request to `/{id}` with the person's ID in the URL.
   - The API will respond with no content if the deletion is successful.

## Limitations and Assumptions

Please note the following limitations and assumptions of the API:

- The API assumes that the ID provided in the URL for fetching, updating, or deleting a person exists in the database. If the ID is invalid, an error will be returned.
- The API does not support bulk operations for creating, updating, or deleting multiple persons at once.
- The API does not implement any authentication or authorization mechanisms. It assumes unrestricted access to the endpoints.

## Setup and Deployment

The API is deployed and can be assessed from `https://haiyrea.000webhostapp.com/api`

To set up and deploy the API locally, follow these instructions:

- Create a directory for the project, open the directory in the terminal and clone the repository into the directory:
    > git clone https://github.com/ruxy1212/miniature-train.git
- Navigate to the project folder and install the dependencies using `Composer`:
    > cd miniature-train && composer install

- Copy and create an environment file, and also generate a new application key by running the following command:
    > cp .env.example .env && php artisan key:generate

- Inside the `.env`, ensure only the database credential for `DB_CONNECTION` is set to `pgsql` and the other are appropriately set (`DB_HOST`, `DB_PORT`, etc)

- Migrate the database using the following command:
    > php artisan migrate

- Start the application server:
    > php artisan serve

- The API will be accessible at `http://127.0.0.1:800/api`, and can be tested using `Postman`.