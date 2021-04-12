import React from "react";
import ERD from './../../assets/img/readme/ERD.png';

// reactstrap components
import {
  Button,
  Card,
  CardHeader,
  CardBody,
  Image,
  Row,
  Col,
} from "reactstrap";

function Readme(props) {
  return (
    <>
      <div className="content">
        <Row>
          <Col md="12">
            <Card>
              <CardHeader>
                <h1 className="title">Documentation</h1>

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
                  npm audit fix (if needed)
                  npm start

                  The application will run on your default browser

              </CardHeader>
              <CardBody>
                </CardBody>
              </Card>
          </Col>
           </Row>
      </div>
    </>
  );
}

export default Readme;
