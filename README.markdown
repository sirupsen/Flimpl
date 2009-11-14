Flimpl
======
Flimpl is an extremely simple open source VC-Framework (Viewer, Controller - No model). However, I don't like to call it a framework. I connect a Framework to a big, slow thing you develop things easily in without having to understand much (in PHP). You are not sure how everything works, or how you'd customize core things. Flimpl is trying more to be a common application design, which you can modify to your own needs. It also tries to become something which you can learn from, because in my experience, developing something like this is the best programming experience you can ever have.

The reason why no model is used is because, for me, it's one extra file where you just from time to time add only one line. This is also over-structured for me, and therefore I built my design without a model.

If you've used Flimpl, or have gotten inspiration from it - please tell me! I'd love to hear from you. :)

Author: Sirupsen

Website: http://sirupsen.dk/

Contact: sirup@sirupsen.dk

Readme coming someday.. after all, just look through the source to start learning ;)

Error Handling
==============

If you'd like to log errors when not in debug mode, execute this into your database and it is automatically handled:

CREATE TABLE IF NOT EXISTS `errors` ( `id` int(11), `no` varchar(255), `message` text, `file` varchar(255), `line` varchar(255), `created` timestamp, `time` int(11), PRIMARY KEY (`id`))

Public Folder
=============

The reason for having this folder, is to only make necessary files publicly available. But there's a few things to note here. You don't want to have your public folder inside a public_html folder on your server. Because public_html (or mainwebsite_html, or whatever it might be called on your server) is basically the same as our public folder. Everything is redirected to it. So if this is the case, basically just merge Flimpl's public folder with yours. :) Also note that if you have a folder called "meow" inside public, it's prioritized > a Flimpl controller! Also note that the application and library folders should still be in the root folder! They are fully accessible by the public from there. Should you not have a folder already, a .htaccess file to redirect anything to your own public folder is included in the main directory!
