<?php

/*
 *  JavaScript Math v1.0
 *  http://www.jsphp.org
 *
 *  Copyright (c) 2010-2013 James Watts (SOLFENIX)
 *  http://www.solfenix.com
 *
 *  This is FREE software, licensed under the GPL
 *  http://www.gnu.org/licenses/gpl.html
 */

namespace Solfenix\JSPHP;

use Solfenix\JSPHP\JSNumber;
use Solfenix\JSPHP\JSDataType;

/* JSMath
 *
 * Class to create a new JavaScript math utility class
 *
 * @author James Watts
 * @version 1.0
 */

class JSMath {

	const E = 2.718;

	const LN10 = 2.302;

	const LN2 = 0.693;

	const LOG10E = 0.434;

	const LOG2E = 1.442;

	const PI = 3.14159;

	const SQRT1_2 = 0.707;

	const SQRT2 = 1.414;

	static function abs( $value = 0 ) {
		return new JSNumber( abs( JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) );
	}

	static function acos( $value = 0 ) {
		return new JSNumber( acos( JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) );
	}

	static function asin( $value = 0 ) {
		return new JSNumber( asin( JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) );
	}

	static function atan( $value = 0 ) {
		return new JSNumber( atan( JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) );
	}

	static function atan2( $x = 0, $y = 0 ) {
		return new JSNumber( atan2( JSDataType::__resolve( $x, JSDataType::TYPE_NUMBER ), JSDataType::__resolve( $y, JSDataType::TYPE_NUMBER ) ) );
	}

	static function ceil( $value = 0 ) {
		return new JSNumber( ceil( JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) );
	}

	static function cos( $value = 0 ) {
		return new JSNumber( cos( JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) );
	}

	static function exp( $value = 0 ) {
		return new JSNumber( exp( JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) );
	}

	static function floor( $value = 0 ) {
		return new JSNumber( floor( JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) );
	}

	static function log( $value = 0 ) {
		return new JSNumber( log( JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ), self::E ) );
	}

	static function max() {
		$arguments = func_get_args();
		for ( $i = 0; $i < count( $arguments ); $i++ ) {
			if ( !( $arguments[$i] instanceof JSDataType ) ) $arguments[$i] = JSDataType::__resolve( $arguments[$i], JSDataType::TYPE_NUMBER );
		}
		return new JSNumber( call_user_func_array( 'max', $arguments ) );
	}

	static function min() {
		$arguments = func_get_args();
		for ( $i = 0; $i < count( $arguments ); $i++ ) {
			if ( !( $arguments[$i] instanceof JSDataType ) ) $arguments[$i] = JSDataType::__resolve( $arguments[$i], JSDataType::TYPE_NUMBER );
		}
		return new JSNumber( call_user_func_array( 'min', $arguments ) );
	}

	static function pow( $x = 0, $y = 0 ) {
		return new JSNumber( pow( JSDataType::__resolve( $x, JSDataType::TYPE_NUMBER ), JSDataType::__resolve( $y, JSDataType::TYPE_NUMBER ) ) );
	}

	static function random() {
		return new JSNumber( (float) ( '0.' . rand() ) );
	}

	static function round( $value = 0 ) {
		return new JSNumber( round( JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) );
	}

	static function sin( $value = 0 ) {
		return new JSNumber( sin( JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) );
	}

	static function sqrt( $value = 0 ) {
		return new JSNumber( sqrt( JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) );
	}

	static function tan( $value = 0 ) {
		return new JSNumber( tan( JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) );
	}
}

