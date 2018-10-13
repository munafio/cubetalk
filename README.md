# CubeTalk
Open source web application to send/receive anonymous feedback like (Sarahah/Sayat) built using Laravel PHP Framework.. Resposive on all devices, Simple and wonderfull design

#### Features
* Resposive on all devices.
* Multi-language (EN, AR available by deffault) and you can add more languages.
* RTL system.
* Send a feedback contains a text or text with photo.
* Comment on feedback.
* Notifications about the new received feedbacks.
* User verify system.
* Share profile URL.
* Delete post or comment.
* Feedback privacy (Public/Private)
* And login,register,reset password,settings, profile.... 

#### Things not completed yet
* Admin Dashboard
* Block, Report user

## Demo
You can see a simple demo about this project and how it looks and works, <a href="https://www.youtube.com/watch?v=VzWNTynEtZ8">Click here</a> to see a video on YouTube

## Installation
You can install the application as any other laravel projects, Easy to install on localhost or shared hosting :

#### 1. Install on (localhost)
Requirements :
* Composer
* PHP 5.6+

So after downloading the project, Copy it into your localhost folder `path/to/www/cubetalk` and then open your composer in the same directory.
Now, Run the following commands :
<br><br>
Install all required and used packages in the project using composer :
```
$ composer install
```
Create a copy of `.env` file :
```
$ php -r "file_exists('.env') || copy('.env.example', '.env');"
```
Generate a key for the project :
```
$ php artisan key:generate
```
Now we need to migrate the tables to the database :
```
$ php artisan migrate
```
last thing, we need to create s symlink for `storage` directory :
```
$ php artisan storage:link
```
That's it, Enjoy!

Notice : If you are using a linux or you are facing a permission error in the `storage` path, you can fix it as simply in the followong command :
```
$ chmod -R 777 storage
```

#### 2. Install on (Shared Hosting)
There is no diffrence about the installation on `localhost` or `shared hosting`, you can as simply install, prepare and develop the project on your `localhost` server and then deploy it on the `shared hosting`.
You can find a lot of tutorails about how to deploy a laravel project on shared hosting on YouTube.

## Important after installation
After installing the application you need to edit `AuthenticatesUsers.php` file, to make login with `username` instead of `email` .
#### How to do that?!
It's very simple, open your editor and edit `AuthenticatesUsers.php` file in this path :
`path/to/cubetalk/vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php`
and then search for `username()` function :
``` php
public function username()
{
    return 'email';
}
```
and change it with the following :
``` php
public function username()
{
    return 'username';
}
```
That's it :)

## Configurations
Now all what you need is to set the general configurations of the application, Open the `.env` file and change `only` the following :
```
.
.
.

DB_CONNECTION=mysql           // Database Driver (MySQL by default)
DB_HOST=127.0.0.1             // Host name
DB_PORT=3306                  // port (default)
DB_DATABASE=dbname            // Database name
DB_USERNAME=root              // Database username
DB_PASSWORD=root              // Database password

.
.
.
                              // here is the mail configuration
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
.
.
.

```
The `.env` file not contains only these above lines of configurations! no, but this is the important lines to set.
The Mail configuration, its important for sending [reset user password/activate emails], you need to set the email, username and password to allow the application sending emails under your email that you set.

## About the author
This simple project built by [Munaf Aqeel Mahdi](https://github.com/munafaqeelmahdi)

#### Contact me
[Instagram](https://instagram.com/munafio) <br>
[Facebook personal page](https://facebook.com/munafio) <br>
[Twitter](https://twitter.com/munaf_aqeel_m) <br>

or on email [munafaqeelmahdi@gmail.com]

## License
[MIT](https://choosealicense.com/licenses/mit/)
