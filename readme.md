# Templator

## Authors

[Mohamed Baig](https://github.com/mbbaig)

[Elsi Nushaj](https://github.com/elnushaj)

## Setup

### XAMPP

Get the latest version of XAMPP from the their website [XAMP](http://www.apachefriends.org/en/xampp.html) and install.

### Virtual host

Add the following virtual host to the **xampp root**/etc/extra/httpd.vhosts.conf file and restart Apache server.  Replace **user name** with your own user name.  Create public_html directory if it is missing.

```XML
	<VirtualHost *:80>
	    ServerAdmin webmaster@dummy-host.example.com
	    DocumentRoot "/Users/<user name>/public_html/templator/public"
	    <Directory "/Users/<user name>/public_html/templator/public">
	        AllowOverride All
	    </Directory>
	    ServerName templator.com
	    ServerAlias www.templator.com
	    ErrorLog "/Users/<user name>/public_html/templator/logs/templator.com-error_log"
	    CustomLog "/Users/<user name>/public_html/templator/logs/templator.com-access_log" common
	</VirtualHost>
```
If Apache does not restart then make to sure to have the following lines uncommented in the **xampp root**/etc/httpd.conf file

```PHP
	# User home directories
	Include etc/extra/httpd-userdir.conf

	# Virtual hosts
	Include etc/extra/httpd-vhosts.conf
```
If there are still problems with apache, reboot computer and try starting apache again.

And finally in your computers **hosts** file add the following line.

```
	127.0.0.1 templator.com
```

This is will allow you to enter templator.com in the browser and visit the page running locally.

### MySQL

Make sure to create the **templator** database in you MySQL server.  You add this through the command line of throught PHPMyAdmin if you have that setup.

## Laravel PHP Framework

[![Latest Stable Version](https://poser.pugx.org/laravel/framework/version.png)](https://packagist.org/packages/laravel/framework) [![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.png)](https://packagist.org/packages/laravel/framework) [![Build Status](https://travis-ci.org/laravel/framework.png)](https://travis-ci.org/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, and caching.

Laravel aims to make the development process a pleasing one for the developer without sacrificing application functionality. Happy developers make the best code. To this end, we've attempted to combine the very best of what we have seen in other web frameworks, including frameworks implemented in other languages, such as Ruby on Rails, ASP.NET MVC, and Sinatra.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the entire framework can be found on the [Laravel website](http://laravel.com/docs).

### Contributing To Laravel

**All issues and pull requests should be filed on the [laravel/framework](http://github.com/laravel/framework) repository.**

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
