# Hotel Booking API Example

Simple API for a Hotel Booking System to manage hotel rooms, bookings, booking payments, and customer interactions.

## Table of Contents

1. [Features](#Features)
3. [Installation](#installation)
4. [Usage](#usage)
5. [Endpoints](#endpoints)
6. [Built With](#built-with)
7. [Authors](#authors)
8. [License](#license)

## Features

#### Token-Based Authentication:  
The API utilizes bearer tokens for authentication, ensuring secure access to endpoints.

#### Authentication Endpoint (Login):
- **POST /api/login** Generate API Token to access secured endpoints 

#### Secured Endpoints:
- **GET /api/rooms**  Get a list of all rooms or based on different criterias
- **GET /api/rooms/<room_number>**  Get room details by <room_nymber>
- **GET /api/customers**  Get a list of all Customers or based on different criterias
- **GET /api/bookings**  Get a list of all Bookings or based on different criterias
- **GET /api/bookings/<booking_id>/payments**  Get a list of Booking Payments specified by <booking_id>
- **POST /api/rooms**  Create a new Room
- **POST /api/customers**  Create a new Customer
- **POST /api/bookings**  Create a new Booking
- **POST /api/bookings/<booking_id>/payments**  Create a new Payment for sertain Booking specified by <booking_id>
- **DELETE /api/bookings/<booking_id>**  Canced (delete) Booking specified by <booking_id>
- **POST /api/logout**  Remove API Token for Authenticated User


## Requirements
- Docker
>If you are using Windows, please make sure to install Docker Desktop.
Next, you should ensure that Windows Subsystem for Linux 2 (WSL2) is installed and enabled.

- [Postman](https://www.postman.com) or other HTTP client for testing the API.


## Installation

### 1. Clone the project
```bash
git clone https://github.com/tmjaga/booking-app.git
```
### 2. Navigate into the project folder using terminal
```bash
cd booking-app
```
### 3. Start booking-app docker container
In the project folder run:
```bash
./vendor/bin/sail up -d
```
### 4. Install the project dependencies
In the project folder run:
```bash
./vendor/bin/sail composer install
```
### 4. Create DB and import data
In the project folder run:
```bash
./vendor/bin/sail artisan migrate --seed
```
### 5. Create DB for Unit Tests and import data
In the project folder run:
```bash
./vendor/bin/sail artisan migrate --database=testing  --seed
```

After installation, Booking Api will be avaliable at http://localhost in Postman or other HTTP client for testing
<br>
To check email notifications you can use Mailpit email client avaliable at http://localhost:8025

## Usage

### 1. Login (Generate Token)
- URL: http://localhost/api/login
- Method: POST
- Request Body:
```json
{
    "email": "admin@mail.com",
    "password": "password"
}
```
- Response
```json
{
    "message": "Logged In",
    "api-token": "19|wMbuZAerqMOI3gVTrJmnsD9xw0OwDQEgw89YMVBx75a1544a"
}
```
Copy api-token value and 
add ``Authorization: Bearer <api_token>`` header to Secured Endpoints requests

>If you are using Posman HTTP client for testing, you can import Booking API Collection from
> ``Booking API.postman_collection.json`` file and configurate BOOKING-API Global Environment variable with copied api-token value. Don't forget to press Save button. 

### 2. Get Rooms List
- URL: http://localhost/api/rooms
- Method: GET
- Request Body Parameters (optional):
```
number - integer|must exists in rooms table,
room_type_id - integer|integer|must exists in room_types table,
status - free|busy
```
- Request Body example:
```json
{
    "number": 101,
    "room_type_id": 1,
    "status": "free"
}
```
- Response Example
```json
[
    {
        "id": 1,
        "number": 101,
        "room_type": "Deluxe Room",
        "price_per_night": 1855,
        "status": "free"
    }
]
```
### 3. Get Room Details
- URL: http://localhost/api/rooms/<room_number>
- Method: GET
- Parameter:
```
<room_number> - required|integer
```
- Response Example
```json
{
    "id": 1,
    "number": 101,
    "room_type": "Deluxe Room",
    "price_per_night": 1855,
    "created_by": 1,
    "status": "free",
    "booking": [
        {
            "id": 2,
            "check_in_date": "2024-05-31",
            "check_out_date": "2024-05-31",
            "total_price": 507
        }
    ]
}
```
If record can not be found, **404 Not Found** response status will be returned with body
```json
{
    "message": "Room not found"
}
```
