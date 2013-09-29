<?php

/*
 *  JavaScript Prototype v1.0
 *  http://www.jsphp.org
 *
 *  Copyright (c) 2010-2013 James Watts (SOLFENIX)
 *  http://www.solfenix.com
 *
 *  This is FREE software, licensed under the GPL
 *  http://www.gnu.org/licenses/gpl.html
 */

namespace Solfenix\JSPHP;

use Closure;

use Solfenix\JSPHP\JSDataType;
use Solfenix\JSPHP\JSReferenceError;
use Solfenix\JSPHP\JSFunction;

/* JSPrototype
 *
 * Class to create a new JavaScript prototype object
 *
 * @author James Watts
 * @version 1.0
 */

class JSPrototype extends JSDataType {

	static $__prototypes = array();

	public $__class = null;
	
	public $__instance = null;

	protected $__classes = array();

	protected $__properties = array();

	public function __construct( $name, $object ) {
		$this->__class     = $name;
		$this->__instance  = $object;
		$this->__classes[] = $object;
		self::$__prototypes[$name] = &$this;
	}

	public function __get( $name ) {
		if ( isset( $this->__properties[$name] ) ) {
			return $this->__properties[$name];
		} elseif ( isset( $this->__instance ) ) {
			return $this->__instance->prototype->$name;
		}
		throw new JSReferenceError();
	}

	public function __set( $name, $value ) {
		$this->__properties[$name] = ( $value instanceof Closure ) ? new JSFunction( $value, $this->__instance ) : $value;
	}

	public function __toString() {
		return '[object Prototype]';
	}

	public function __search( $class, $depth = 90 ) {
		if ( $depth < 1 ) {
			return false;
		} elseif ( $this->__class == $class ) {
			return true;
		}
		return $this->__instance->prototype->__search( $class, $depth-1 );
	}

	public function __inherit( $properties, $descriptors ) {
		$values = array();
		if ( is_object( $properties ) ) $values = array_merge( $this->__properties, (array) $properties );
		if ( is_object( $descriptors ) ) {
			foreach ( $descriptors as $name => $value ) {
				if ( $descriptors->$name->enumerable ) $values[$name] = $descriptors->$name->valueOf();
			}
		}
		return (object) $values;
	}

	public function __exists( $name, $depth = 90 ) {
		if ( $depth < 1 ) {
			return false;
		} elseif ( isset( $this->__properties[$name] ) ) {
			return true;
		} elseif ( isset( $this->__instance ) ) {
			return $this->__instance->prototype->__exists( $name, $depth-1 );
		}
		return false;
	}

	static function __instance( $name, $object ) {
		foreach ( self::$__prototypes as $class => $instance ) {
			if ( $class == $name ) {
				self::$__prototypes[$class]->__classes[] = $object;
				return $instance;
			}
		}
		return new static( $name, $object );
	}

	static function __delete( $name, $object ) {
		for ( $i = 0; $i < count( self::$__prototypes[$name]->__classes ); $i++ ) {
			if ( self::$__prototypes[$name]->__classes[$i] === $object ) return array_splice( self::$__prototypes[$name]->__classes, $i, 1 );
		}
		return false;
	}
}

