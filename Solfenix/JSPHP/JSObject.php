<?php

/*
 *  JavaScript Object v1.0
 *  http://www.jsphp.org
 *
 *  Copyright (c) 2010-2013 James Watts (SOLFENIX)
 *  http://www.solfenix.com
 *
 *  This is FREE software, licensed under the GPL
 *  http://www.gnu.org/licenses/gpl.html
 */

namespace Solfenix\JSPHP;

use stdClass;
use ReflectionClass;
use Closure;

use Solfenix\JSPHP\JSDataType;
use Solfenix\JSPHP\JSPrototype;
use Solfenix\JSPHP\JSReferenceError;
use Solfenix\JSPHP\JSTypeError;
use Solfenix\JSPHP\JSFunction;
use Solfenix\JSPHP\JSDescriptor;
use Solfenix\JSPHP\JSString;

/* JSObject
 *
 * Class to create a new JavaScript object
 *
 * @author James Watts
 * @version 1.0
 */

class JSObject extends JSDataType {

	public $__isObject = false;

	protected $__valueOf = null;

	protected $__properties = null;

	protected $__descriptors = null;

	protected $__prototype = null;

	protected $__extensible = true;

	protected $__frozen = false;

	protected $__sealed = false;

	public function __construct() {
		$this->__properties  = new stdClass();
		$this->__descriptors = new stdClass();
		$this->__valueOf     = &$this->__properties;
		$this->__prototype   = JSPrototype::__instance( get_class( $this ), $this );
		$this->__isObject    = true;
	}

	public function __has( $name ) {
		$name = JSDataType::__resolve( $name, JSDataType::TYPE_STRING );
		return ( isset( $this->__descriptors->$name ) || isset( $this->__properties->$name ) || $this->__prototype->__exists( $name ) );
	}

	public function __get( $name ) {
		if ( $name == 'constructor' ) return new ReflectionClass( get_class( $this ) );
		if ( $name == 'prototype' ) return $this->__prototype;
		if ( isset( $this->__descriptors->$name ) ) return $this->__descriptors->$name->valueOf();
		if ( isset( $this->__properties->$name ) ) return $this->__properties->$name;
		if ( $this->__prototype->__exists( $name ) ) return $this->__prototype->$name;
		throw new JSReferenceError();
	}

	public function __set( $name, $value ) {
		if ( !$this->__extensible ) throw new JSTypeError();
		if ( $name == 'prototype' ) {
			if ( is_object( $value ) && $value instanceof JSPrototype ) {
				JSPrototype::__delete( get_class( $this ), $this );
				return $this->__prototype = JSPrototype::__instance( $value->__class, $this );
			}
			if ( is_object( $value ) && $value instanceof JSDataType ) {
				JSPrototype::__delete( get_class( $this ), $this );
				return $this->__prototype = JSPrototype::__instance( get_class( $value ), $this );
			}
			throw new JSTypeError();
		} elseif ( isset( $this->__descriptors->$name ) ) {
			if ( $this->__descriptors->writable ) {
				$this->__descriptors->$name = JSDataType::__define( $value );
			} else {
				throw new JSTypeError();
			}
		} else {
			$this->__properties->$name = ( $value instanceof Closure ) ? new JSFunction( $value, $this ) : JSDataType::__define( $value );
		}
	}

	public function __call( $name, $arguments ) {
		array_unshift( $arguments, $this );
		if ( $this->__prototype->__exists( $name ) && is_callable( $this->__prototype->$name ) ) return call_user_func_array( $this->__prototype->$name, $arguments );
		if ( is_callable( $this->__properties->$name ) ) return call_user_func_array( $this->__properties->$name, $arguments );
		throw new JSReferenceError();
	}

	public function __toString() {
		return '[object Object]';
	}

	public function __defineProperty( $name, $config = null ) {
		$name = JSDataType::__resolve( $name, JSDataType::TYPE_STRING );
		$this->__descriptors->$name = new JSDescriptor( $config );
		return true;
	}

	public function __freeze() {
		foreach ( $this->__descriptors as $descriptor ) $descriptor->__freeze();
		$this->__extensible = false;
		$this->__frozen     = true;
	}

	public function __getOwnPropertyDescriptor( $name ) {
		$name = JSDataType::__resolve( $name, JSDataType::TYPE_STRING );
		if ( isset( $this->__descriptors->$name ) ) return $this->__descriptors->$name;
		if ( isset( $this->__properties->$name ) ) {
			$config               = new static();
			$config->value        = $this->__properties->$name;
			$config->writable     = true;
			$config->configurable = true;
			$config->enumerable   = true;
			return new JSDescriptor( $config );
		}
		throw new JSReferenceError();
	}

	public function __getOwnPropertyNames() {
		return array_keys( array_merge( (array) $this->__properties, (array) $this->__descriptors ) );
	}

	public function __preventExtensions() {
		$this->__extensible = false;
	}

	public function __isExtensible() {
		return $this->__extensible;
	}

	public function __isFrozen() {
		return $this->__frozen;
	}

	public function __isSealed() {
		return $this->__sealed;
	}

	public function __seal() {
		foreach ( $this->__descriptors as $descriptor ) $descriptor->configurable = false;
		$this->__extensible = false;
		$this->__sealed     = true;
	}

	public function hasOwnProperty( $name ) {
		$name = JSDataType::__resolve( $name, JSDataType::TYPE_STRING );
		if ( $this->__prototype->__exists( $name ) ) return false;
		if ( isset( $this->__properties->$name ) ) return true;
		return false;
	}

	public function isArray() {
		return false;
	}

	public function isPrototypeOf( $object ) {
		if ( !( $object instanceof JSDataType ) ) throw new JSTypeError();
		return $this->__prototype->__search( get_class( $object ) );
	}

	public function propertyIsEnumerable( $name ) {
		$name = JSDataType::__resolve( $name, JSDataType::TYPE_STRING );
		if ( $this->__prototype->__exists( $name ) ) return false;
		if ( isset( $this->__properties->$name ) && $name != 'prototype' ) return true;
		return false;
	}

	public function toEnumerable() {
		return $this->__prototype->__inherit( $this->__properties, $this->__descriptors );
	}

	public function toLocaleString() {
		return $this->toString();
	}

	public function toString() {
		return new JSString( $this->__toString() );
	}

	public function valueOf() {
		return $this->__valueOf;
	}

	static function create( $prototype = null, $properties = null ) {
		$object = new static();
		if ( isset( $prototype ) ) $object->prototype = $prototype;
		if ( is_object( $properties ) ) static::defineProperties( $object, $properties );
		return $object;
	}

	static function defineProperty( $object, $name, $config = null ) {
		if ( !( $object instanceof JSObject ) ) throw new JSTypeError();
		$name = JSDataType::__resolve( $name, JSDataType::TYPE_STRING );
		$object->__defineProperty( $name, $config );
	}

	static function defineProperties( $object, $properties = null ) {
		if ( !( $object instanceof static ) ) throw new JSTypeError();
		if ( is_object( $properties ) ) {
			foreach ( $properties as $name => $value ) static::defineProperty( $object, $name, $value );
		}
	}

	static function freeze() {
		if ( !( $object instanceof static ) ) throw new JSTypeError();
		$object->__freeze();
		return $object;
	}

	static function getOwnPropertyDescriptor( $object, $name ) {
		if ( !( $object instanceof static ) ) throw new JSTypeError();
		$name = JSDataType::__resolve( $name, JSDataType::TYPE_STRING );
		return $object->__getOwnPropertyDescriptor( $name );
	}

	static function getOwnPropertyNames( $object ) {
		if ( !( $object instanceof static ) ) throw new JSTypeError();
		return $object->__getOwnPropertyNames();
	}

	static function getPrototpeOf( $object ) {
		if ( !( $object instanceof static ) ) throw new JSTypeError();
		return $object->prototype;
	}

	static function keys( $object ) {
		if ( !( $object instanceof static ) ) throw new JSTypeError();
		$class = new ReflectionClass( 'JSArray' );
		return $class->newInstanceArgs( array_keys( (array) $object->toEnumerable() ) );
	}

	static function preventExtensions( $object ) {
		if ( !( $object instanceof static ) ) throw new JSTypeError();
		$object->__preventExtensions();
	}

	static function isExtensible( $object ) {
		if ( !( $object instanceof static ) ) throw new JSTypeError();
		return $object->__isExtensible();
	}

	static function isFrozen( $object ) {
		if ( !( $object instanceof static ) ) throw new JSTypeError();
		return $object->__isFrozen();
	}

	static function isSealed( $object ) {
		if ( !( $object instanceof static ) ) throw new JSTypeError();
		return $object->__isSealed();
	}

	static function seal( $object ) {
		if ( !( $object instanceof static ) ) throw new JSTypeError();
		$object->__seal();
		return $object;
	}
}

