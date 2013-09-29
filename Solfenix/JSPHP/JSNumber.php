<?php

/*
 *  JavaScript Number v1.0
 *  http://www.jsphp.org
 *
 *  Copyright (c) 2010-2013 James Watts (SOLFENIX)
 *  http://www.solfenix.com
 *
 *  This is FREE software, licensed under the GPL
 *  http://www.gnu.org/licenses/gpl.html
 */

namespace Solfenix\JSPHP;

use Solfenix\JSPHP\JSObject;
use Solfenix\JSPHP\JSDataType;
use Solfenix\JSPHP\JSPrototype;
use Solfenix\JSPHP\JSString;

/* JSNumber
 *
 * Class to create a new JavaScript numeric object
 *
 * @author James Watts
 * @version 1.0
 */

class JSNumber extends JSObject {

	const MAX_VALUE = 1.79E+308;

	const MIN_VALUE = 5E-324;

	const NaN = null;

	const NEGATIVE_INFINITY = -1;

	const POSITIVE_INFINITY = 1;

	public function __construct( $number = null ) {
		if ( isset( $number ) ) {
			if ( is_int( $number ) || is_float( $number ) ) {
				$this->__valueOf = $number;
			} else {
				$this->__valueOf = JSDataType::__resolve( $number, JSDataType::TYPE_NUMBER );
			}
		} else {
			$this->__valueOf = 0;
		}
		$this->__prototype = JSPrototype::__instance( get_class( $this ), $this );
	}

	public function __toString() {
		return ( is_nan( $this->__valueOf ) ) ? 'NaN' : (string) $this->__valueOf;
	}

	public function toString( $radix = 10 ) {
		return ( is_nan( $this->__valueOf ) ) ? 'NaN' : new JSString( (string) intval( $this->__valueOf, JSDataType::__resolve( $radix, JSDataType::TYPE_NUMBER ) ) );
	}

	public function toLocaleString() {
		return $this->toString();
	}

	public function valueOf() {
		return ( is_nan( $this->__valueOf ) ) ? self::NaN : $this->__valueOf;
	}

	public function toExponential( $value = null ) {
		return new JSString( (string) ( isset( $value ) ) ? number_format( exp( $this->__valueOf ), JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) : exp( $this->__valueOf ) );
	}

	public function toFixed( $value = 0 ) {
		return new JSString( (string) number_format( $this->__valueOf, JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) );
	}

	public function toPrecision( $value = null ) {
		return new JSString( ( isset( $value ) ) ? (string) round( $this->__valueOf, JSDataType::__resolve( $value, JSDataType::TYPE_NUMBER ) ) : $this->__toString() );
		
	}
}

