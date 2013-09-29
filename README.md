jsphp
=====

**jsphp** is a *pseudo-implementation* of the **ECMA 262** standard (JavaScript 8.5.1) for *PHP 5.3+*, including JSBoolean, JSNumber, JSString, JSObject, JSArray, JSFunction, JSRegExp, JSDate, JSError and JSMath, aswell as prototype inheritence and chaining.

To use the package it's highly recommended to use a [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) compatible autoloader for the required classes.

You can find a fully compatible autoloader [here](https://github.com/SOLFENIX/php-autoload).

To use *JavaScript PHP* first include "js.php" in your file.

```php
require( 'path/to/js.php' );
```

As this is a *pseudo-implementation* of *JavaScript* in *PHP*, the syntax used differs slightly from that of a native implementation.

To access the raw value of an object you must use the ```valueOf()``` method, for example:

```php
$value = $variable->valueOf();
```

When concatenating with a string this is not necesary.

```php
print( 'value of $variable is: ' . $variable );
```

To iterate and access the properties of an *JavaScript* object you must do so using the ```toEnumerable()``` method, for example:

```php
foreach ( $object->toEnumerable() as $property => $value ) {
	print( $property . ' = ' . $value );
}
```

When defining methods on an object the internal pointer to the object is always passed as the first argument, for example:

```php
$object->method = function( $__this ) {
	print( 'my name is: ' . $__this->name );
};
```

When passing arguments to a method of a *JavaScript* object you may use either raw *PHP* values or *JavaScript* objects, for example:

```php
$string->split( ',' );

// the same as above
$separator = new JSString( ',' );
$string->split( $separator );
```

Requirements
------------

* PHP 5.3+

Documentation
-------------

As **jsphp** is a *pseudo-implementation* of a language which has already been implemented natively by others, the **Mozilla** documentation for *JavaScript* should be sufficient to use the classes included with the package, plus a dose of common sense to translate the code examples for the native implementation into *PHP* code.

JavaScript: https://developer.mozilla.org/docs/javascript

PHP: http://php.net/docs.php

The **Mozilla** organisation does not develope, contribute to, support or endorse **jsphp**.

Support
-------

For support, bugs and feature requests, please use the [issues](https://github.com/SOLFENIX/jsphp/issues) section of this repository.

Contributing
------------

If you'd like to contribute new features, enhancements or bug fixes to the code base just follow these steps:

* Create a [GitHub](https://github.com/signup/free) account, if you don't own one already
* Then, [fork](https://help.github.com/articles/fork-a-repo) the [jsphp](https://github.com/SOLFENIX/jsphp) repository to your account
* Create a new [branch](https://help.github.com/articles/creating-and-deleting-branches-within-your-repository) from the *develop* branch in your forked repository
* Modify the existing code, or add new code to your branch
* When ready, make a [pull request](http://help.github.com/send-pull-requests/) to the main repository

There may be some discussion reagrding your contribution to the repository before any code is merged in, so be prepared to provide feedback on your contribution if required.

A list of contributors to **jsphp** can be found [here](https://github.com/SOLFENIX/jsphp/contributors).

License
-------

Copyright 2010-2013 James Watts (SOLFENIX). All rights reserved.

Licensed under the GPL. Redistributions of the source code included in this repository must retain the copyright notice found in each file.

