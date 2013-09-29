<?php

/*
 *  JavaScript Descriptor v1.0
 *  http://www.jsphp.org
 *
 *  Copyright (c) 2010-2013 James Watts (SOLFENIX)
 *  http://www.solfenix.com
 *
 *  This is FREE software, licensed under the GPL
 *  http://www.gnu.org/licenses/gpl.html
 */

namespace Solfenix\JSPHP;

use Solfenix\JSPHP\JSDataType;
use Solfenix\JSPHP\JSObject;
use Solfenix\JSPHP\JSFunction;
use Solfenix\JSPHP\JSTypeError;
use Solfenix\JSPHP\JSReferenceError;

/* JSDescriptor
 *
 * Class to create a new JavaScript descriptor object
 *
 * @author James Watts
 * @version 1.0
 */

class JSDescriptor extends JSDataType {

	const TYPE_DATA = 1;

	const TYPE_ACCESSOR = 2;

	protected $__valueOf = null;

	protected $__typeOf = null;

	protected $__writable = false;
    
	protected $__configurable = false;

	protected $__enumerable = false;

	protected $__getter = null;

	protected $__setter = null;

	protected $__frozen = false;

	public function __construct( $config = null ) {
		if ( !( $config instanceof JSObject ) ) {
			$object = new JSObject();
			foreach ( $config as $name => $value ) $object->$name = $value;
			$config = $object;
		}
		if ( $config->__has( 'value' ) ) {
			$this->__typeOf  = self::TYPE_DATA;
			$this->__valueOf = $config->value;
			if ( $config->__has( 'writable' ) ) $this->__writable = JSDataType::__resolve( $config->writable, JSDataType::TYPE_BOOLEAN );
			if ( $config->__has( 'configurable' ) ) $this->__configurable = JSDataType::__resolve( $config->configurable, JSDataType::TYPE_BOOLEAN );
			if ( $config->__has( 'enumerable' ) ) $this->__enumerable = JSDataType::__resolve( $config->enumerable, JSDataType::TYPE_BOOLEAN );
			if ( $config->__has( 'get' ) || $config->__has( 'set' ) ) throw new JSTypeError();
		} else {
			$this->__typeOf = self::TYPE_ACCESSOR;
			if ( $config->__has( 'getter' ) ) $this->__getter = ( $config->get instanceof JSFunction ) ? $config->get : new JSFunction( JSDataType::__resolve( $config->get, JSDataType::TYPE_FUNCTION ), $this );
			if ( $config->__has( 'setter' ) ) $this->__setter = ( $config->set instanceof JSFunction ) ? $config->set : new JSFunction( JSDataType::__resolve( $config->set, JSDataType::TYPE_FUNCTION ), $this );
			if ( $config->__has( 'configurable' ) ) $this->__configurable = JSDataType::__resolve( $config->configurable, JSDataType::TYPE_BOOLEAN );
			if ( $config->__has( 'enumerable' ) ) $this->__enumerable = JSDataType::__resolve( $config->enumerable, JSDataType::TYPE_BOOLEAN );
			if ( $config->__has( 'value' ) || $config->__has( 'writable' ) ) throw new JSTypeError();
		}
	}

	public function __toString() {
		switch ( $this->__typeOf ) {
			case self::TYPE_DATA:     return (string) $this->__valueOf;
			case self::TYPE_ACCESSOR: return (string) $this->__getter();
		}
		throw new JSReferenceError();
	}

	public function __get( $name ) {
		switch ( $this->__typeOf ) {
			case self::TYPE_DATA:
				switch ( $name ) {
					case 'value':        return $this->__valueOf;
					case 'writable':     return $this->__writable;
					case 'configurable': return $this->__configurable;
					case 'enumerable':   return $this->__enumerable;
				}
				break;
			case self::TYPE_ACCESSOR:
				switch ( $name ) {
					case 'get':          return $this->__getter;
					case 'set':          return $this->__setter;
					case 'configurable': return $this->__configurable;
					case 'enumerable':   return $this->__enumerable;
				}
				break;
		}
		throw new JSReferenceError();
	}

	public function __set( $name, $value ) {
		if ( $this->__frozen ) throw new JSTypeError();
		switch ( $this->__typeOf ) {
			case self::TYPE_DATA:
				switch ( $name ) {
					case 'value':
						$this->__valueOf = $value;
						return;
					case 'writable':
						$this->__writable = JSDataType::__resolve( $value, JSDataType::TYPE_BOOLEAN );
						return;
					case 'configurable':
						$this->__configurable = JSDataType::__resolve( $value, JSDataType::TYPE_BOOLEAN );
						return;
					case 'enumerable':
						$this->__enumerable = JSDataType::__resolve( $value, JSDataType::TYPE_BOOLEAN );
						return;
				}
				break;
			case self::TYPE_ACCESSOR:
				switch ( $name ) {
					case 'get':
						$this->__getter = ( $value instanceof JSFunction ) ? $value : new JSFunction( JSDataType::__resolve( $value, JSDataType::TYPE_FUNCTION ), $this );
						return;
					case 'set':
						$this->__setter = ( $value instanceof JSFunction ) ? $value : new JSFunction( JSDataType::__resolve( $value, JSDataType::TYPE_FUNCTION ), $this );
						return;
					case 'configurable':
						$this->__configurable = JSDataType::__resolve( $value, JSDataType::TYPE_BOOLEAN );
						return;
					case 'enumerable':
						$this->__enumerable = JSDataType::__resolve( $value, JSDataType::TYPE_BOOLEAN );
						return;
				}
				break;
		}
		throw new JSReferenceError();
	}

	public function __freeze() {
		$this->__frozen = true;
	}

	public function valueOf() {
		switch ( $this->__typeOf ) {
			case self::TYPE_DATA:     return $this->__valueOf;
			case self::TYPE_ACCESSOR: return $this->__getter();
		}
		throw new JSReferenceError();
	}
}

