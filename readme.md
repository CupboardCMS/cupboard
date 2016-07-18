## Cupboard

[![Latest Stable Version](https://poser.pugx.org/cupboard/core/v/stable)](https://packagist.org/packages/cupboard/core) [![Total Downloads](https://poser.pugx.org/cupboard/core/downloads)](https://packagist.org/packages/cupboard/core)

Cupboard is designed to be a very minimal blogging platform with the primary focus on writing. If you have any issues or ideas please report them.

### Libraries

![Marionette](http://marionettejs.com/images/marionette.svg)
![Backbone](http://backbonejs.org/docs/images/backbone.png)
![Dropzone](http://www.dropzonejs.com/images/new-logo.svg)   
![Selectize](http://selectize.github.io/selectize.js/images/logo@2x.png)

Requirements
---------------------------------------

Cupboard has a few system requirements:

- PHP >= 5.4.0
- MCrypt PHP Extension
- PDO compliant database (SQL, MySQL, PostgreSQL, SQLite)

Installing Cupboard
---------------------------------------

Installing Cupboard is now as simple as running `composer create-project cupboard/cupboard`.
After running this command, modify your `app/config/database.php` file with your database credentials and visit the site in your browser.

Alternatively, you can do

`git clone https://github.com/CupboardCMS/cupboard.git`

`cd cupboard`

`composer install`

Make sure the web server has write permissions to `app/storage/` and `app/config/packages/cupboard/core/`

Don't forget to update your DB settings in 
`app/config/database.php`

In the browser you will be directed to the guided install process which will:

* Create the DB tables for CupboardCMS
* Help you create your first user
* Help you set your site title, theme, and post display values

The Admin Area
---------------------------------------
Within the admin area, you can create and edit your posts. 

The admin area consists of an implementation of ![SimpleMDE](https://github.com/NextStepWebs/simplemde-markdown-editor), a Markdown editor with a ![CodeMirror](https://codemirror.net/) backend.
All Markdown features are displayed using ![PHP Markdown Lib](https://github.com/michelf/php-markdown) on the front-end.
However, markdown preview is displayed using jQuery or SimpleMDE, so some formatting available in preview, such as ~~strikethrough~~ is not displayed through the Cupboard theme, using PHP Markdown Lib.

You can insert images from your desktop by dragging and dropping the file into the editor. This uploads the image to the public/images folder and creates a link in the post body.

You can also insert image URLs using the image button.

In order to save your post, you need to enter a title.

Upgrading Cupboard
---------------------------------------

Run `composer update` then `php artisan cupboard:migrate` to migrate any db tables.

Theming Cupboard
---------------------------------------
By default, your theme files are located in `public/themes`.
You can modify these themes or create your own using the default themes as a guide.
The configuration for your themes is located in `app/config/packages/cupboard/core/cupboard.php` in the `theme` option.

Building and Extending
---------------------------------------

Cupboard is built using Marionette JS in coffee script files and CSS built using Less.
You can add functionality or update Cupboard by editing these files, located in vendor/cupboard/core/assets and rebuilding the js
and css files.

In order to compile the coffee script and less files into .js and .css you have to run

`sudo npm install`

in the vendor/cupboard/core directory

and then run 

`grunt`
