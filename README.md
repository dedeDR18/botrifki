# Kiwari Bot Webhook Sample with PHP

## Requirements

* [PHP 7](https://www.php.net/)
* [Composer](https://getcomposer.org/)
* [ngrok](https://ngrok.com/)
* Bot Access Token (you can chat with Chatbot Builder in `Jelajah` menu)

## How to run

* Clone this repository and install dependencies `composer.json`

```bash
$ git clone https://gitlab.playcourt.id/iskandarsuhaimi/sample-bot-kiwari.git
$ cd sample-bot-kiwari
$ composer install
$ composer dump-autoload -o
```

* Go to `Jelajah` menu
* chat with `Chatbot Builder`
* Create bot and get `access_token`
* Copy and Paste to `Controller.php` class

* Run webhook server

```bash
$ php -S localhost:3000
```

* Tunneling your webhook server

```bash
$ ngrok http 3000
```

* Register your webhook url by copy your ngrok https url from CLI, then input it to `Chatbot Builder`

* Enjoy!