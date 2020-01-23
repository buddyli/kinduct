# Kinduct
This project is created with CodeIgniter - the framework with which we can create web site with PHP quickly.
The main controller is `$PROJECT/application/controller/AthletesRestController`. There are several REST APIs defined here, with which we can upload players info with JSON, vew player detail, view player list and delete player.

## Features
This project provides serval REST APIs, such as file uploading, add, update, delete and view player.
The main REST controller is `$PROJECT/application/controllers/AthletesRestController.php`, you can found all REST API definitions here.
The default model is `$PROJECT//application/models/Athletes_model.php`, this model provies functions to interact with database.

## PHP pre-requires
1. PHP 7.2+
1. CodeIgniter v3.1.11(don't need to install as it's included in the source code)
2. CodeIgniter rest-server, please install it via `composer` by following command
`composer require chriskacerguis/codeigniter-restserver`.

And don't forget to update PHP config file `$PROJECT/application/config/config.php` set `$config['COMPOSER_AUTOLOAD'] = TRUE`
3. (OPTIONAL) If need, you can udpate project base_url in '$PROJECT/application/config/config.php', the default configuration is `$config['base_url'] = 'http://localhost/kinduct'`


## MySQL
MhySQL version 8.0.18+
1. Please run below SQL to create table 'athlete' in target database.

`
    CREATE TABLE `athlete` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `age` int(3) NOT NULL,
    `city` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
    `province` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
    `country` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
`

2. Update DB connection parameters in `$PROJECT/application/config/database.php`, with your own database hostname, username, password and database name.

## Apache
We need Apache v2.4+ to run this programme, please make sure your Apache support PHP.

