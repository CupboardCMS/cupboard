## Cupboard

[![Latest Stable Version](https://poser.pugx.org/cupboard/cupboard/version.png)](https://packagist.org/packages/cupboard/cupboard) [![Total Downloads](https://poser.pugx.org/cupboard/cupboard/d/total.png)](https://packagist.org/packages/cupboard/cupboard)

Cupboard is designed to be a very minimal blogging platform with the primary focus on writing. Currently it is a work in progress but you are free to give it a try. (Just be warned this alpha/beta quality). If you have any issues or ideas please report them.

![Wardobe](http://cupboardcms.com/media/cupboard-air-large.png)


Requirements
---------------------------------------

Cupboard has a few system requirements:

- PHP >= 5.3.7
- MCrypt PHP Extension
- PDO compliant database (SQL, MySQL, PostgreSQL, SQLite)

Installing Cupboard
---------------------------------------

Installing Cupboard is now as simple as running `composer create-project cupboard/cupboard`.
After running this command, modify your `app/config/database.php` file with your database credentials and visit the site in your browser.

In the browser you will be directed to the guided install process which will:

* Prepare your database for CupboardCMS
* Help you create your first user
* Help you set your site title, theme, and page values

Upgrading Cupboard
---------------------------------------

Run `composer update` then `php artisan cupboard:migrate` to migrate any db tables.

Theming Cupboard
---------------------------------------
By default, your theme files are located in `public/themes`.
You can modify these themes or create your own using the default themes as a guide.
The configuration for your themes is located in `app/config/packages/cupboard/core/cupboard.php` in the `theme` option.
