# User Management Web App
## 1. Overview

    This is a semi-personalia web-based application. 
    The purpose of this web app is to provide any department
    of the company for more intuitive and improved user management
    system with better user experience.
    This app consists of the frontend and the backend of
    the web-based application designed with the microservices
    atchitecture in mind and will be run on local server. 

## 2. Getting Started

    These instructions will get you a copy of the project up 
    and running on your local machine for development and testing purposes. 
    See deployment for notes on how to deploy the project on a live system.

<img src={ERD}></img>

## 3. Running The Backend

### Prerequisites

This project is developed on mac OS environment, 
with the following packages installed on your system:

- **PHP v7.3.22**
Using Homebrew: brew install php@7.3
Or refer to https://www.php.net/manual/en/install.php for other installation method.

- **PHP Composer v1.9.1**
Using Homebrew: brew install composer
Or refer to https://getcomposer.org/download/ for other installation method.

- **Laravel v8.9.0 (No installation required)**

- **PostgreSQL v12.4**

Using Homebrew:

Update and Upgrade homebrew
brew doctor
brew update

Install PostgreSQL
brew install postgresql

Or refer to https://www.postgresql.org/download/ for other installation method.

You can use User Management API.postman_collection.json to test the API
which is stored in the **Postman Folder**

### Installing

After all the pre-requisites are met, please run the following commands:

1.  Install required packages

        composer install
        composer dump-autoload

2.  Setup local environment

    Copy `.env.example` file, paste it to the same directory and rename it to `.env`.

    Or alternatively run the following command on a unix machine:

        cp .env.example .env

    Then set the config on the `.env` file according to config of your machine (including Database and Email settings).


3.  Database Migrations

    Setup your database, and set the `DB_DATABASE` config on `.env` file to match your database.

        DB_CONNECTION=pgsql
        DB_HOST=127.0.0.1
        DB_PORT=5432
        DB_DATABASE=database
        DB_USERNAME=postgres
        DB_PASSWORD=password

    Then run the following command:

        php artisan migrate:fresh

    This will run all migrations based on timestamps on ascending order.

4.  Database Seeding

    Populate the Database with default data from Seeders:

        php artisan module:seed

    This will run all seeders based on folder name on ascending order.

    To verify if installation is complete, please try running the server on your machine using the following command:

        cd to root
        php artisan serve

## 4. Running The Frontend
This project is developed on Node.js environment, 
with the following packages installed on your system:

### Prerequisites

- **Node.js (npm)**
Refer to https://www.npmjs.com/get-npm for installation method.
- **PHP Composer v1.9.1**

Using Homebrew: brew install composer
Or refer to https://getcomposer.org/download/ for other installation method.

- **Laravel v8.9.0 (No installation required)**

- **PostgreSQL v12.4**

### Installing

To run the app

    cd to root
    npm install
    npm audit fix

Before you start the app, you might want to install 
several dependencies to run the app

    "@fortawesome/fontawesome-free": "5.15.1",
    "@fortawesome/fontawesome-svg-core": "^1.2.35",
    "@fortawesome/free-solid-svg-icons": "^5.15.3",
    "@fortawesome/react-fontawesome": "^0.1.14",
    "axios": "^0.21.1",
    "bootstrap": "4.5.3",
    "chart.js": "2.9.4",
    "classnames": "2.2.6",
    "node-sass": "4.14.1",
    "node-sass-package-importer": "5.3.2",
    "perfect-scrollbar": "1.5.0",
    "prop-types": "15.7.2",
    "react": "17.0.1",
    "react-bootstrap": "^1.5.2",
    "react-chartjs-2": "2.11.1",
    "react-dom": "17.0.1",
    "react-notification-alert": "0.0.13",
    "react-redux": "^7.2.3",
    "react-router-dom": "5.2.0",
    "react-scripts": "4.0.1",
    "reactstrap": "^8.7.1",
    "redux": "^4.0.5"

**To start** you can run

    npm start

The application will run on your default browser
