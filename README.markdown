Flimpl
======
Flimpl is an extremely simple open source VC-Framework (Viewer, Controller - No model). However, I don't like to call it a framework. I connect a Framework to a big, slow thing you develop things easily in without having to understand much (in PHP). You are not sure how everything works, or how you'd customize core things. Flimpl is trying more to be a common application design, which you can modify to your own needs. It also tries to become something which you can learn from, because in my experience, developing something like this, is the best programming experience you can ever have.

Author: Sirupsen

Website: http://sirupsen.dk/

Contact: sirup@sirupsen.dk

Readme comming someday.. after all, just look through the source to start learning ;)

Error Handling
==============

If you'd like to log errors when not in debug mode, execute this into your database and this is automatically handled:

CREATE TABLE IF NOT EXISTS `errors` ( `id` int(11), `no` varchar(255), `message` text, `file` varchar(255), `line` varchar(255), `created` timestamp, `time` int(11), PRIMARY KEY (`id`))
