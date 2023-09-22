<h3 align="center"><img src="public/syslog_logo.png" width="150" alt="Syslogo"></h3>

## Getting Started
To get your Laravel project up and running after cloning it from a Git repository, follow these steps:

## Requirements
- Git Bash
- Composer
- NodeJS
- XAMPP or any other software that can host MySQL database

## 1. Clone the Git Repository

Before proceeding, ensure that Git is installed on your system. Then, open your terminal or command prompt and navigate to the directory where you intend to clone the project. To clone the repository, use the following command:

```bash
git clone <repository_url>
```

Replace `<repository_url>` with the actual URL of the Git repository.

## 2. Install Composer Dependencies

Ensure that Composer is installed on your system, as Laravel relies on it to manage its dependencies. Once you've cloned the repository, go to the project's main directory in your terminal and execute the following command:

```bash
composer install
```

This command will download and install all the required PHP dependencies specified in the `composer.json` file.

## 3. Create a .env File

In Laravel, configuration settings, including database credentials and the application key, are stored in a `.env` file. To create a new `.env` file, simply make a copy of the `.env.example` file.

```bash
cp .env.example .env
```

Then, open the `.env` file and configure it according to your environment.

<u>I configured it as such:</u>

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_logs
DB_USERNAME=root
DB_PASSWORD=
```

## 4. Generate an Application Key

Laravel requires an application key for encryption and security purposes. Generate a new key by running:

```bash
php artisan key:generate
```

## 5. Database Setup

Start by launching XAMPP, and then activate both the Apache and MySQL servers. Afterward, create a new database on your server using the integrated XAMPP Shell. You can do this by simply running a command like:

```bash
mysql -u root -p

create database laravel_logs;
```

Configure the database connection settings in the `.env` file. Then, run the migrations to create the database schema and the seeds:

```bash
php artisan migrate --seed
```

## 6. Start the Development Server

To run your Laravel application locally, use the following command:

```bash
php artisan serve
```

This will start a development server, and you'll see a URL where your Laravel application is accessible, usually [http://localhost:8000](http://localhost:8000).

## 7. Install NPM Dependencies (For Frontend Assets)

This projects frontend technologies such as JavaScript and CSS, so make sure you have NodeJS installed on your system. Then navigate to the project's root directory and run:

```bash
npm install
```

After installing the dependencies, you can compile assets using Laravel Mix:

```bash
npm run dev
```

## 8. Access Your Application

To view your running Laravel application, open your web browser and go to the URL where it's hosted, typically [http://localhost:8000](http://localhost:8000). Your Laravel application should be accessible at this address.

Please be aware that the specific steps may differ based on your project and its unique dependencies. Always refer to the project's documentation or README file for any additional instructions or specific configuration details.

You can access the Application Administrator account with the following credentials:

```bash
Email: admin@gmail.com
Password: 123123123
```
After logging in as the administrator, please create a new standard user account and then proceed to test the application using that newly created account.


## Special Thanks To

<a href="https://www.flaticon.com/free-icons/geometrical" title="geometrical icons">Logo Icon - created by Freepik - Flaticon</a>
<br>
<a href="https://startbootstrap.com/theme/sb-admin-2" title="sb_admin_2">SB Admin 2 Theme</a>
<p align="center"><img src="public/syslog_logo.png" width="100" alt="Syslogo"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo"></a></p>
