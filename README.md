# Stock-market

## Table of contents
* [General info](#general-info)
* [Technologies](#technologies)
* [Setup](#setup)
* [Demonstration](#demonstration)

## General info

This project uses an API-Key from finnhub.io to get information about the stock-market. In this project it is possible to see 10 my selected stocks, search any existing stock and see it's price currently, previous close price and the percent change. You are able to withdraw & deposit money, buy & sell stocks (short & long), transfer them to a friend, follow along your profit in your transaction history.

## Technologies

Project is created with:
* PHP version: 7.4
* MySQL version: 8.0.31-0ubuntu0.20.04.2 for Linux on x86_64 ((Ubuntu))
* Composer version: 2.4.4

## Setup
1. Clone this repository: `git clone https://github.com/dauchinjs/stock-market.git`
2. Install all dependencies: `composer install`
3. Make an empty database schema
4. To import the database, follow these steps:
    * Right click on database schema you just made => `SQL Scripts` => `Run SQL Script...` => locate `schema.sql` file in cloned repository folder
5. Rename the `.env.example` file to `.env`
6. Add your credentials to the `.env` file
7. To run the project, locate `/public` folder and you can use command `php -S localhost:8000` to run the project in your browser

## Demonstration

### Home page
![home page](https://github.com/dauchinjs/stock-market/blob/main/demonstration/stock-market.png)

### Register and login
![register-login](https://github.com/dauchinjs/stock-market/blob/main/demonstration/regist-login.gif)

### Deposit withdraw funds
![deposit withdraw](https://github.com/dauchinjs/stock-market/blob/main/demonstration/deposit-withdraw.gif)

### Buy Sell stock and short sell
![buy sell](https://github.com/dauchinjs/stock-market/blob/main/demonstration/buy-sell.gif)

### Transfer stock to a friend by e-mail and transaction history
![transfer history](https://github.com/dauchinjs/stock-market/blob/main/demonstration/transfer-history.gif)
