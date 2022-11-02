### I-LAB

This project was developed with Laravel Framework 6.5.2. You should be familiar with the framework for better understanding and development.

### Documentaion URLs

https://laravel.com/docs/6.x

### Development Server Requirements

- `PHP` Version `^7.2`
- `MySQL ^5.7` or `MariaDB ^10.2`

### Installation Instructions

This project is dependent on the `composer` PHP package manager. Be sure the `composer` is available at your local development computer.

Resource: https://getcomposer.org/

Step 01: Clone the repository to your local development computer (Clone with HTTPS):

```
git clone git@gitlab.com:Nvisio/British-American-Tobacco/I-LAB.git
```

or you can pass the folder name of the project whatever you want.

```
git clone git@gitlab.com:Nvisio/British-American-Tobacco/I-LAB.git ilab-project-development
```

If you want Clone with HTTPS:

```
git clone https://gitlab.com/Nvisio/British-American-Tobacco/I-LAB.git
```

Step 02: Install composer dependencies

Run at the command line

`composer install`

For a check, if there are any package updates available:

`composer update`

By running this command, the composer will install the required packages to your local development PC.

Step 03: Replace `.env` file information as per requirements

Rename `.env.local` file to `.env` first which is located ROOT of the project.

- URL of the Project
- Database Information
- Mail Server Information (You can use MailTrap.io)

Step 04: If the composer installs all the required packages, the project is ready for the run.

Step 05: Migrate the database files and seed the information

The project is dependent on some `pre-exists database tables` and information. Therefore you need to `migrate` and` seed` first.

Run at Command Prompt:

`php artisan migrate:refresh --seed`

If you need to have login access for the test, Please edit the file and add your login credentials to Database Seeder. (ADD USER)

Database seed file location:

```
ROOT_FOLDER/database/seeds/RolesAndPermissionTableSeeder.php
```

Step 06: Link the storage folder

Run at the command line

`php artisan storage:link`

> This will link the storage folder to public folder.

### Optional Feature

If you are familiar with the database factory by using Laravel tinker, you can run dummy data to the database.

Run at the command prompt:
```
php artisan tinx
```

Generate fake users:

```
factory(App\User::class, 10)->create();
```

Generate fake ideas:

```
factory(App\Idea::class, 10)->create();
```

Exit the terminal:

```
re();
```

### Node.js / Yarn Package Manager

If want to update the assets, the project is dependent on Node.js or Yarn Package Manager. 

Run at the command prompt at the root of the project:

For NPM:
```
npm install
```

```
npm update
```

For Yarn:
```
yarn install
```

```
yarn update
```

#### After that

To compile the assets

For Development:

```
npm run dev
```

For Production

```
npm run prod
```

### Assets folders are located at:

For CSS Change:

```
resources/sass
```

For JavaScript Change:

```
resources/js
```

> Single JavaScript files are located at individual blade files.