# Laravel API with DDD Architecture and Docker Integration

## Introduction

This project is a Laravel-based API built following Domain-Driven Design (DDD) principles. It utilizes Docker for seamless environment setup, and the API can be started by simply running `docker-compose up -d`. The system has been structured at the domain level, with entities such as `Customer`, `Discount`, and `Product`. The API contains various layers including Application, Domain, and Infrastructure.

## Features

- **Domain-Driven Design**: Structured around different domains like Customer, Discount, and Product.
- **Docker Support**: Easily set up and run the project using Docker.
- **Laravel**: Built using Laravel as the framework.
- **REST API**: Includes endpoints for managing business logic, such as applying discounts.

## Project Structure

The project follows the DDD pattern and has the following key components:

```bash
├── app/
│   ├── Customer/
│       └── Application
│           ├── Exceptions
│           └── Repositories
│       └── Domain
│           ├── Entities
│           └── Repositories
│   ├── Discount/
│       └── Application
│           ├── Discounts
│           ├── DTO
│           └── Services
│       └── Domain
│           ├── Discounts
│           ├── Entities
│           └── Services
│   ├── Product/
│       └── Application
│           └── Repositories
│       └── Domain
│           ├── Entities
│           └── Repositories
│   └── Common/
│       └── Infrastructure/
│           ├── Http/
│           │   └── Controllers/      # Laravel controllers
│           └── Providers/            # Laravel service providers
```
## Installation
1. Clone the repository
```
git clone https://github.com/gherca/problem1.git
```
2. Stat the application using Docker
```
docker-compose up -d
```
That’s it! The Docker environment is configured with an entrypoint that handles the following tasks automatically:
- Copies .env.example to .env.
- Runs composer install to install PHP dependencies.
- Starts the server using Nginx Unit.

## Usage
### API Endpoint
- **POST /api/v1/discounts**
- Request Body
```
{
  "id": "2",
  "customer-id": "2",
  "items": [
    {
      "product-id": "B102",
      "quantity": "5",
      "unit-price": "4.99",
      "total": "24.95"
    }
  ],
  "total": "24.95"
}
```
- Response  **200 OK**
```
{
    "id": 2,
    "items": [
        {
            "productId": "B102",
            "quantity": 6,
            "unitPrice": 4.99,
            "total": 24.95,
            "discount": {
                "amount": 0,
                "reason": "Buy 5 Switches get 1 free"
            }
        }
    ],
    "discounts": [
        {
            "amount": 2.5,
            "reason": "10% discount for customers who spent over €1000"
        }
    ],
    "total": 24.95,
    "totalWithDiscounts": 22.45
}
```
- Response **422 Unprocessable Entity**
```
{
    "message": "The id field is required.",
    "errors": {
        "id": [
            "The id field is required."
        ]
    }
}
```
- Response **404 Not Found**
```
{
    "message": "Customer id not found"
}
```

## Business Logic

The discount system in this project is structured with two levels of discounts:

1. **Item-Level Discounts**: Applied to specific items.
2. **General Discounts**: Applied to the entire order based on customer history.

### Discount Types

The system implements three types of discounts:

1. **Customer-Level Discount**:
    - **Condition**: A customer who has already spent over €1000 in previous purchases.
    - **Discount**: Gets a 10% discount on the whole order.

   Example: If a customer has spent more than €1000 in total before placing the current order, they will receive a 10% discount on their entire order.

2. **Category-Level Discount (Switches)**:
    - **Condition**: For every five products purchased from the category "Switches" (category ID: `2`).
    - **Discount**: The customer receives a sixth product for free.

   Example: If a customer adds six products from the "Switches" category to the cart, they will only pay for five of them.

3. **Category-Level Discount (Tools)**:
    - **Condition**: When purchasing two or more products from the category "Tools" (category ID: `1`).
    - **Discount**: A 20% discount is applied to the cheapest product.

   Example: If a customer buys two or more products from the "Tools" category, the cheapest item will have a 20% discount applied to it.

### Applying Discounts

The system checks the order and applies applicable discounts automatically. Discounts can be combined, and multiple rules can apply depending on the customer's order details and purchase history.
