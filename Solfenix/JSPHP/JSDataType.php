<?php

/*
 *  JavaScript Data Type v1.0
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
use ReflectionClass;
use stdClass;
use Exception;

use Solfenix\JSPHP\JSFunction;
use Solfenix\JSPHP\JSNull;
use Solfenix\JSPHP\JSObject;
use Solfenix\JSPHP\JSBoolean;
use Solfenix\JSPHP\JSNumber;
use Solfenix\JSPHP\JSString;
use Solfenix\JSPHP\JSArray;
use Solfenix\JSPHP\JSRegExp;
use Solfenix\JSPHP\JSDate;

/* JSDataType
 *
 * Class to create a new JavaScript data type utility class
 *
 * @author James Watts
 * @version 1.0
 */

class JSDataType {

	const TYPE_NULL = 0;

	const TYPE_BOOLEAN = 1;

	const TYPE_NUMBER = 2;

	const TYPE_STRING = 3;

	const TYPE_OBJECT = 4;

	const TYPE_ARRAY = 5;

	const TYPE_FUNCTION = 6;

	const TYPE_REGEXP = 7;

	const TYPE_DATE = 8;

	const TYPE_ERROR = 9;

	static function __define( $value = null ) {
		if ( $value instanceof static ) return $value;
		if ( $value instanceof Closure ) return new JSFunction( $value );
		if ( $value === null ) return new JSNull();
		if ( is_object( $value ) ) return new JSObject( $value );
		if ( is_array( $value ) ) {
			$class = new ReflectionClass( 'JSArray' );
			return $class->newInstanceArgs( $value );
		}
		if ( is_bool( $value ) ) return new JSBoolean( $value );
		if ( is_int( $value ) || is_float( $value ) ) return new JSNumber( $value );
		if ( is_string( $value ) ) return new JSString( $value );
		return $value;
	}

	static function __resolve( $value = null, $type = self::TYPE_NULL ) {
		switch ( $type ) {
			case self::TYPE_BOOLEAN:
				if ( is_bool( $value ) ) return $value;
				if ( $value instanceof JSBoolean ) return $value->valueOf();
				return false;
			case self::TYPE_NUMBER:
				if ( is_int( $value ) || is_float( $value ) ) return $value;
				if ( $value instanceof JSNumber ) return $value->valueOf();
				return 0;
			case self::TYPE_STRING:
				if ( is_string( $value ) ) return $value;
				if ( $value instanceof JSString ) return $value->valueOf();
				return '';
			case self::TYPE_OBJECT:
				if ( is_object( $value ) && !( $value instanceof static ) ) return $value;
				if ( $value instanceof JSObject && $value->__isObject === true ) return $value->valueOf();
				return new stdClass();
			case self::TYPE_ARRAY:
				if ( is_array( $value ) ) return $value;
				if ( $value instanceof JSArray ) return $value->valueOf();
				return array();
			case self::TYPE_FUNCTION:
				if ( $value instanceof Closure ) return $value;
				if ( $value instanceof JSFunction ) return $value->valueOf();
				return function() { return; };
			case self::TYPE_REGEXP:
				if ( is_string( $value ) ) return $value;
				if ( $value instanceof JSRegExp ) return $value->valueOf();
				return '//';
			case self::TYPE_DATE:
				if ( is_int( $value ) ) return $value;
				if ( $value instanceof JSDate ) return $value->valueOf();
				return time();
			case self::TYPE_ERROR:
				if ( $value instanceof Exception ) return $value->getMessage();
				return new Exception();
			default:
				if ( $value === null ) return $value;
				if ( $value instanceof JSNull ) return $value->valueOf();
				return null;
		}
	}
}

