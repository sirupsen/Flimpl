Flimpl
======
Flimpl is a simple non-mvc framework I made – mostly to see if I could, and making a framework turns out to be the very best way to expand your knowledge in a language you thought you already mastered. It has some basic features, and is faily fast.

As this is an open source project, you are welcome to fork it and request me to pull your changes.

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

Database Class
--------------

The database class handles the connection to the database, as well as the queries sent to the database. And it automaticly escapes the input. As this is a very simple framework, you should be able to open the file yourself to check which functions are available, and how to work with them. By default it includes:

* Insert Method
* Select Method
* Select Template Method
* Delete Method
* Execute File Method

The titles should be somewhat self explaining, except maybe the "Select Template Method". This is used if you just need stuff rawly into your template file, and no maniplulation is needed. The usage of this is shown in the /index.php file.

I'm not going to create detailed documentation for this framework, if you need to learn how something works, or your going to work with some method included by default, it shouldn't be much trouble finding it and reading the comments to the method. The source is well commented, and is written in a language everyone should be able to understand.

However, I'll give a quick brief of the default included classes.

Registry Class
--------------

The registry class is used for handling all the instances of classes created through the application, it ensures that only one instance is made and that this instance is accessible from anywhere. To see how it's used in a normal file, see /index.php - to see how it's used within a class, see /class/sample.php

Template Class
--------------

The template class is to define variables inside templates, this is so that all the php is kept away from the actual template file. Except for the printing of the actual values, which uses the well known php markup. I felt there were no need to create a new markup for this part, I don't like smarty like engines they provide a totally different markup for the template system, and it's slower when it's such a big system. This class simply uses PHP as the template engine. For usage see the /index.php file.

Library Class
-------------

The library class is to provide the user with commonly used function, it's easy to define your own and they are then globally accessible from the registry inside all classes, and files.

Validation Class
----------------

A class to validate the users input, like an URL or an email.


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
* Go to the index.php file (f.e. http://sirupsen.dk/Flimpl/)
* If > 1 article, and a few links are shown - everything should be working correctly.

What now..?
-----------

To start developing your own stuff, I'd recommend you to look at the source code to see how everything works. It's commented very well, so it should be easy to understand what everything does. There's three sample files included in order to show you how stuff works:

* /index.php
* /class/sample.php
* /templates/index.php

I'd recommend you to at least read those files, to understand how the framework works.
