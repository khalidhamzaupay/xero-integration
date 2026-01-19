# XERO Integration App

---
## Prerequisites

Before you begin, ensure you have the following installed:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)
---


## Quick Start

### 1. Clone the Repository
   ```bash
    git clone https://github.com/khalidhamzaupay/xero-integration.git
   ```
   ```bash   
    cd xero-integration
   ```

### 2. Build and start the containers
   ```sh
   docker compose --env-file ./build/.env up -d --build
   ```

This command will build and start all required services: PHP (Laravel), MySQL, and Nginx.

### 3. Prepare the Laravel application
#### 3.1. Enter the PHP container to run Laravel and Composer commands:
   ```sh
   docker exec -it xero_integration sh 
   ```

#### 3.2. Once inside the container, run the following commands
   ```sh
   composer install
   ```
   ```sh
   cp .env.example .env
   ```
   ```sh
   php artisan key:generate
   ```


#### 3.3. Exit the container
   ```sh
    exit
   ```

### 4. Access the application
- **App URL:** [http://localhost:8080](http://localhost:8080)
---
