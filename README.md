# Loan Management API

This is a Loan Management API built with Laravel. It allows you to perform CRUD operations on loans and provides an easy-to-use API. 
In addition, it comes with user authentication features, including login, registration, password recovery, and profile management (to change password, email, etc.).

## Technologies Used

- **Laravel 11** - The backend framework for building the API and handling database operations.
- **PHP 8.3** - The version of PHP required to run the Laravel application.
- **Vue.js 3** - The JavaScript framework used for building the frontend user interface.


## Setup Instructions

1. Clone the Repository
   Clone the repository to your local machine

```
git clone https://github.com/xZeroMCPE/Loan-Management.git
cd Loan-Management
```
### 2. Create the Database

Create a MySQL database with the following name `loan`

### 3. Set Up the Environment
```
cp .env.example .env
php artisan key:generate
```

### 4. Migrate the Database
   Run the migration to set up the database schema:

`php artisan migrate:fresh`

### 5. Seed the Database (Optional)
   Seed the database with fake data for testing:

`php artisan db:seed`


### 7. Run the API Tests
   You can run the API tests to ensure everything is working:


`php artisan test --filter LoanApiTest`

Or run all tests:

`php artisan test`

### 7. Run the application
To install all the necessary Vue.js and frontend dependencies, run the following command:
``npm install``

\
To run both the Laravel backend and the Vue.js frontend, you need to start both servers. In separate terminal windows, run the following:
`php artisan serve`

And finally for the frontend development
`npm run dev`
