# Product Recommendation Service

This service provides product recommendations based on the weather forecast for a given city in Lithuania. It integrates with the LHMT API to get the current weather forecast and suggests products based on the weather conditions for the next 3 days.

## Accessing the Host

You can reach the host using the following link:

[http://13.60.26.162/api/products/recommended/kaunas](http://13.60.26.162/api/products/recommended/kaunas)


## Technologies Used
- **PHP**: 7.x / 8.x
- **Symfony**: Framework for building the application
- **MySQL** (or equivalent database engine): To store product data
- **Doctrine**: ORM for database interaction
- **Faker**: Library to generate sample product data
- **Cache**: Used to cache API responses for 5 minutes


## Setup Instructions With Docker
Follow these steps to set up and run the application via docker:

1. Clone the repository: 
   ```bash 
   git clone git@github.com:eimantasmel/backend_task.git
   cd your-repository-name
   ```
2. Launch docker containers: Run the following command to launch docker containers:
   ```bash 
   docker compose up --build -d
   ```
3. Select backen app container:
   ```bash 
   docker exec -it backend_app sh
   ```
4. Install dependencies: Run the following command to install the required PHP dependencies:
   ```bash 
   composer install
   ```
5. Configure .env:
    - Update the .env file with your database credentials. Set the DATABASE_URL to match your MySQL connection settings:

6. Run the database migrations: Run the migrations to set up the database schema:
   ```bash 
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```
7. Load Fixtures (Optional)
   ```bash 
   php bin/console doctrine:fixtures:load
   ```
8. Access the API: 

   ![Presentation image](https://s3.amazonaws.com/i.snag.gy/qKT9zX.jpg)

## Setup Instructions Without Docker

### Prerequisites
- PHP 7.x or 8.x
- Composer
- MySQL (or equivalent database)
- Symfony CLI

Follow these steps to set up and run the application locally:

1. Clone the repository: 
   ```bash 
   git clone git@github.com:eimantasmel/backend_task.git
   cd your-repository-name
   ```
2. Install dependencies: Run the following command to install the required PHP dependencies:
   ```bash 
   composer install
   ```
3. Configure the database:

    - Create a new MySQL database for the project.
    - Update the .env file with your database credentials. Set the DATABASE_URL to match your MySQL connection settings:
   ```bash 
   DATABASE_URL="mysql://username:password@localhost:3306/database_name"
   ```
4. Run the database migrations: Run the migrations to set up the database schema:
   ```bash 
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```
5. Load Fixtures (Optional):
   ```bash 
   php bin/console doctrine:fixtures:load
   ```

6. Start the Symfony server: Run the following command to start the server:
    ```bash 
    symfony server:start --port=8000
    ```

7. Access the API: 

    ![Presentation image](https://s3.amazonaws.com/i.snag.gy/qKT9zX.jpg)
