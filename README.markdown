Flimpl
======
Flimpl is a simple non-mvc framework I made – mostly to see if I could, and making a framework turns out to be the very best way to expand your knowledge in a language you thought you already mastered. It has some basic features, and is faily fast.

As this is an open source project, you are welcome to participate in the development.

Author: Sirupsen

Website: http://sirupsen.dk/

Contact: sirup@sirupsen.dk

Introduction
============

Flimpl stands for Framework Simple, and that is what it is. An extremely simple lightweight framework which is not MVC based. It provides by default the user with:

* Database Class
* Registry Class
* Template Class
* Library Class
* Validate Class

I'm going to give you a quick brief of the classes included per default. I recommend you to go look at the actual code for yourself, to figure out how everything works - and how to work with it.

Database Class
--------------

The database class handles the connection to the database, as well as the queries sent. It automaticly escapes the input for extra security. 
As the purpose of this framework is learning, and expirementing, you should go to the the Database class yourself, to figure out how it works. I'll list functions made available to you though:

* Insert Method
* Select Method
* Select Template Method
* Delete Method
* Execute File Method

The titles should be somewhat self explanatory, except the "Select Template Method". This is a method made for the purpose of inserting data from your database, which requires no further manipulation.

Registry Class
--------------

The registry class is used for handling all the instances of classes, created throughout the application, it ensures that only one instance is made, and that this instance is accessible from anywhere.

Or, in other words: __Singleton Registry Pattern__

Template Class
--------------

The template class is to define variables inside templates, this is so that all the php is kept away from the actual template file, except for the printing of the actual values, which uses the well known php markup. I felt there were no need to create a new markup for this part, I don't like smarty like engines. They provide a totally different markup for the template system, and it's slower. So, it I basically just use PHP as the template engine.

Library Class
-------------

The library are basically just a bunch of methods you might commonly use, like time difference, gravatar and generation of a random string. They are all static, so they can be accessed from anywhere together with the autoload function easily.

Validation Class
----------------

A class to validate the users input, like an URL or an email.

Error Logging
-------------

Errors are automaticly logged to a database table called 'errors' when debug mode is not activated. This is usefull so we do not show fatal errors to the visitors, which could result in showing stuff we do not want them to see. 


Installation
============

It's very simple to install the Flimpl framework, to install it basically just throw it on your server, however if you'd like to work with some pre-made examples before you start your first project in the framework, follow these instructions:

Installation
------------

* Download the latest files from Github http://github.com/Sirupsen/Flimpl/tree/master
* Unzip/Tar the files
* Open /static/other/config.php
* Edit the options to fit your own environment
* Open your MySQL client (PHPMyAdmin, Sqlbuddy, HeidiSQL - or whatever you use)
* Execute the sql.sql file into the database your going to use
* Upload the files to your server
* Go to the index.php file to verify everything is working correctly!
[Oops. As per default the CSS is loaded from the compressor PHP file, which is hthacked to .CSS, it might not work because mod_rewrite is not enabled on your system!]

What now..?
-----------

To start developing, I strongly encourage you to read through the entire source to get a feeling of how everything works. Then it should be rather simple to get started!
