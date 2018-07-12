# SoWeSign

## Requirements
- PHP
- Composer
- NPM

## Installation

- clone repository
- go to project folder `cd SoWeSign`

### App 
- go to App folder `cd app`
- install back dependencies `composer install`
- copy `.env.example` to `.env` and set database credentials
- generate key `php artisan key:generate`
- run migrations `php artisan migrate`
- install front dependencies `npm install`
- build front assets `npm run dev`
- launch server `php artisan serve` and go to `http://localhost:8000`

### Node server
- go to Node server folder `cd node-server`
- install dependencies `npm install`
- build files and launch server `npm run start` then go to `http://localhost:2440`

## Usage

### Node server

Send a `POST` request to this route `http://localhost:2440/pdf` with the pdf file named `pdf` as data.

It will return a response with the coordinates of the `#SIGNxxx#` texts 