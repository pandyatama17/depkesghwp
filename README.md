![banner](https://github.com/pandyatama17/depkesghwp/assets/12741952/84ea3488-6617-4e40-941f-3f298fca3ed2)

## About RegGakeslab

Registation + back office application for "Capacity Building For Medical Device Industries Back to Back Session with Global Harmonization Working Party (GHWP) TC Leaders Meeting In Coordination with The Ministry of Health of The Republic of Indonesia excellence In Medical Device Regulation And Innovation" by Gakeslab Indonesia. Developed with Laravel 

## About Laravel

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Getting Started

- Follow the instructions on the [Laravel documentation](https://laravel.com/docs/installation) to install Laravel.

## Prerequisites

- Install PHP, Composer, and other prerequisites as per [Laravel documentation](https://laravel.com/docs/installation#server-requirements).
- Install and enable Imagick on your machine/server.
- A DOKU account for integrating the DOKU payment gateway. If you don't have one, you can register for a DOKU account at [DOKU Registration Page](https://dashboard.doku.com/bo/register?utm_id=selfonboard).
  
## Environment Variables

Before running the application, make sure to set up the following environment variables in your `.env` file. Below is an example `.env.example` file that you can rename to `.env` and customize as needed:

````plaintext
APP_NAME=YourApp
APP_ENV=local
APP_KEY=base64:<your-random-key>
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_USERNAME=your_mail_username ## for registration mailing
MAIL_PASSWORD=your_mail_password ## Explain that this needs to be 'APP password'. You can generate it through Google Account settings: https://support.google.com/mail/answer/185833?hl=en

# DOKU Checkout Payment Gateway Configuration
DOKU_CLIENT_ID="MCH-0197-1687176144098"  ## Provide client ID obtained from DOKU
DOKU_CLIENT_SECRET="SK-gTcg6LWFLD8SnO0BNW9p"  ## Provide client secret obtained from DOKU
DOKU_API="https://api-sandbox.doku.com"  ## DOKU API endpoint for sandbox mode
DOKU_API_IPG="https://sandbox.doku.com"  ## DOKU IPG endpoint for sandbox mode

# Other environment variables...
````

## Payment Gateway Setup


**DOKU PHP Library: [DOKU PHP Library GitHub Repository](https://github.com/PTNUSASATUINTIARTHA-DOKU/jokul-php-library)**

To enable the [DOKU payment gateway](https://developers.doku.com/accept-payment/doku-checkout) for your application, you need to register for a DOKU account and obtain your credentials. Please follow these steps:

- Register for a DOKU account at [DOKU Registration Page](https://dashboard.doku.com/bo/register?utm_id=selfonboard) or log in if you already have an account at DOKU Login Page.
- Once registered, navigate to the [DOKU Developer Documentation at DOKU Developer Docs](https://developers.doku.com/) to understand the integration process and obtain your client ID and client secret for sandbox mode.
- After obtaining your credentials, replace the placeholders in the .env file with your actual DOKU credentials.
- For further assistance or inquiries, please contact the DOKU sales team for more information.

By following these steps, you can integrate the DOKU payment gateway into your application for testing purposes.


## Migration
- Run the following command to migrate the database:

```bash
php artisan migrate
````

## Other Dependencies

- "simplesoftwareio/simple-qrcode": "~4"
  for QR code generation


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
