# Stock-market

## General info

This project uses an API-Key from finnhub.io to get information about the stock-market. In this project it is possible to see 10 my selected stocks, search any existing stock and see it's price currently, previous close price and the percent change. You are able to withdraw & deposit money, buy & sell stocks, transfer them to a friend, follow along your profit in your transaction history.

## Technologies

Project is created with:
* PHP version: 7.4
* MySQL version: 8.0.31-0ubuntu0.20.04.2 for Linux on x86_64 ((Ubuntu))
* Composer version: 2.4.4

## Setup
1. Clone this repository: `git clone https://github.com/dauchinjs/stock-market.git`
2. Install all dependencies: `composer install`
3. Import the database: `mysql -u root -p < schema.sql`
4. Rename the `.env.example` file to `.env`
5. Add your credentials to the `.env` file
6. To run the project, locate `/public` folder and you can use command `php -S localhost:8000` to run the project in your browser
