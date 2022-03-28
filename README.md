<p align="center"><img src="public/images/app_logo.png" width="400"></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About this project

zCat is a master's graduate project created by Kshitij Saxena during Spring 2022 under Dr. Chao in the Computer Science department. It's purpose is to allow instructors to see which of their students are at risk of failing their class. Instructors are able to create a classroom and upload zyBooks and Canvas grade files to view graphs and statistics about those files.

This app is made using Laravel 8.45.1 and runs on BGSU's virtual machine.

## Running the app

- The standard commands that Laravel uses must be run, including:
  - ```composer install``` to install composer libraries
  - ```npm install``` to install NPM libraries
  - ```npm run prod``` (```npm run dev``` if developing locally) to compile JS and CSS
  - ```php artisan key:generate``` to generate Laravel's key
  - ```php artisan migrate``` to run and generate database migrations
  - ```php artisan config:clear && php artisan config:cache``` to fix and regenerate cached items


- Inside ```.env``` file, database and mailer connection information is required.
  - Do not commit ```.env``` to Git, nor store any keys or passwords which can be commited to Git.


## Project requirements

- App access must be locked behind a whitelist.txt file located on the VM.
- Instructor can create a classroom to have their own private space.
- Instructor can upload zyBooks and Canvas files to their classroom.
- Instructor can view statistics of each file to see which students are at risk.
- Instructor can modify the risk calculation variables outside of code.
- Instructor can add other whitelisted instructors to their classroom.
- Instructor can send email notifications to students about their risk in the class.


## Whitelist system

The 'whitelist.txt' file is to be located in the root of the app. In order to be able to register or use the app in any way, the user's email must be added to the whitelist in a new line.

If a user is deleted from the whitelist, their classrooms and files remain safe, but access to the app is revoked until they are added to the whitelist again.

## Classroom system

- Registering to the

## File system

## Risk analysis

## Sending emails through Gmail's SMTP

- To do
