[![Build Status](https://img.shields.io/travis/josegonzalez/cakephp-page-route/master.svg?style=flat-square)](https://travis-ci.org/josegonzalez/cakephp-page-route) 
[![Coverage Status](https://img.shields.io/coveralls/josegonzalez/cakephp-page-route.svg?style=flat-square)](https://coveralls.io/r/josegonzalez/cakephp-page-route?branch=master) 
[![Total Downloads](https://img.shields.io/packagist/dt/josegonzalez/cakephp-page-route.svg?style=flat-square)](https://packagist.org/packages/josegonzalez/cakephp-page-route) 
[![Latest Stable Version](https://img.shields.io/packagist/v/josegonzalez/cakephp-page-route.svg?style=flat-square)](https://packagist.org/packages/josegonzalez/cakephp-page-route) 
[![Documentation Status](https://readthedocs.org/projects/cakephp-page-route/badge/?version=latest&style=flat-square)](https://readthedocs.org/projects/cakephp-page-route/?badge=latest)
[![Gratipay](https://img.shields.io/gratipay/josegonzalez.svg?style=flat-square)](https://gratipay.com/~josegonzalez/)

# PageRoute Plugin

Forget about cluttering your `routes.php` with zillions of `/page`-style routes.

## Background

Someone in IRC was migrating tons of static pages into a fresh CakePHP install. In the webroot. I told him to move them into `app/View/Pages` and use routes to properly route everything. I also mentioned that rather than routing every static file one by one, it might be possible using a custom `CakeRoute` class, but didn't elaborate.

So a few minutes of hacking later, and here I am with this lovely `PageRoute`.

## Requirements

* PHP 5.2+
* CakePHP 2.x

## Installation

_[Using [Composer](http://getcomposer.org/)]_

Add the plugin to your project's `composer.json` - something like this:

	{
		"require": {
			"josegonzalez/cakephp-page-route": "1.0.0"
		}
	}

Because this plugin has the type `cakephp-plugin` set in it's own `composer.json`, composer knows to install it inside your `/Plugins` directory, rather than in the usual vendors file. It is recommended that you add `/Plugins/PageRoute` to your .gitignore file. (Why? [read this](http://getcomposer.org/doc/faqs/should-i-commit-the-dependencies-in-my-vendor-directory.md).)

_[Manual]_

* Download this: [https://github.com/josegonzalez/cakephp-page-route/zipball/master](https://github.com/josegonzalez/cakephp-page-route/zipball/master)
* Unzip that download.
* Copy the resulting folder to `app/Plugin`
* Rename the folder you just copied to `PageRoute`

_[GIT Submodule]_

In your app directory type:

	git submodule add git://github.com/josegonzalez/cakephp-page-route.git Plugin/PageRoute
	git submodule init
	git submodule update

_[GIT Clone]_

In your plugin directory type

	git clone git://github.com/josegonzalez/cakephp-page-route.git PageRoute

### Enable plugin

In 2.0 you need to enable the plugin your `app/Config/bootstrap.php` file:

		CakePlugin::load('PageRoute');

If you are already using `CakePlugin::loadAll();`, then this is not necessary.


## Usage

Way near the bottom of your `app/Config/routes.php` file, add the following:

```php
<?php
App::uses('PageRoute', 'PageRoute.Routing/Route');
Router::connect('/:page', array('controller' => 'pages', 'action' => 'display'),
	array('routeClass' => 'PageRoute')
);
```

And now you can remove all shortcuts to your `/pages/display/page-name` urls. Whenever you create a new `.ctp` file in `app/View/Pages`, this route will automatically detect it using a `file_exists()` call. Because of this, it is recommended to use this as one of the last, if not the last, route in your application, in order to minimize file-reads.

It is also possible to customize the controller/action used for this. For example, we might want to use the `StaticPagesController::index()` instead of `PagesController::display()`. In that case, our `routes.php` would look like the following:

```php
<?php
App::uses('PageRoute', 'PageRoute.Routing/Route');
Router::connect('/:page', array('controller' => 'static_pages', 'action' => 'index'),
	array('routeClass' => 'PageRoute', 'controller' => 'static_pages', 'action' => 'index')
);
```

In this way, we can easily rename the `PagesController` to something less useful, and reuse the `PagesController` for something else - such as dynamic content from the database.

Reverse routing will all work the same as it does without this route class. `array('controller' => 'pages', 'action' => 'display', 'about')` will be automatically converted to `array('controller' => 'pages', 'action' => 'display', 'page' =. 'about')` for backwards compatibility Please note that by default, the regex `[\/\w_-]+` is used to check the page validity, so you may need to update that regex in the Route options as follows:

```php
App::uses('PageRoute', 'PageRoute.Routing/Route');
Router::connect('/:page', array('controller' => 'static_pages', 'action' => 'index'),
	array('routeClass' => 'PageRoute', 'page' => '[a-zA-Z]+')
);
```

Note that the `.` character has been disallowed in the default regex to remove the possibility of traversing the directory tree for security reasons.

## Todo

* Unit Tests
* Allow usage of the `.` character in routes
* Add caching to file_exists calls
