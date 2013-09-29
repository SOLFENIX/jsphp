<?php

/*
 *  JavaScript String v1.0
 *  http://www.jsphp.org
 *
 *  Copyright (c) 2010-2013 James Watts (SOLFENIX)
 *  http://www.solfenix.com
 *
 *  This is FREE software, licensed under the GPL
 *  http://www.gnu.org/licenses/gpl.html
 */

namespace Solfenix\JSPHP;

use ReflectionClass;

use Solfenix\JSPHP\JSObject;
use Solfenix\JSPHP\JSPrototype;
use Solfenix\JSPHP\JSDataType;
use Solfenix\JSPHP\JSNumber;
use Solfenix\JSPHP\JSNull;

/* JSString
 *
 * Class to create a new JavaScript string object
 *
 * @author James Watts
 * @version 1.0
 */

class JSString extends JSObject {

	public $length = 0;

	public function __construct( $string = null ) {
		$this->__valueOf   = ( isset( $string ) ) ? (string) $string : '';
		$this->__prototype = JSPrototype::__instance( get_class( $this ), $this );
		$this->length      = strlen( $this->__valueOf );
	}

	public function __toString() {
		return $this->__valueOf;
	}

	public function charAt( $index = 0 ) {
		$index = JSDataType::__resolve( $index, JSDataType::TYPE_NUMBER );
		return ( isset( $this->__valueOf{$index} ) ) ? new static( $this->__valueOf{$index} ) : new static( '' );
	}

	public function charCodeAt( $index ) {
		return new JSNumber( ord( $this->charAt( $index ) ) );
	}

	public function concat() {
		$this->__valueOf .= implode( '', func_get_args() );
		$this->length     = strlen( $this->__valueOf );
		return $this;
	}

	public function indexOf( $value = '', $start = 0 ) {
		return new JSNumber( strpos( &$this->__valueOf, (string) $value, JSDataType::__resolve( $start, JSDataType::TYPE_NUMBER ) ) );
	}

	public function lastIndexOf( $value = '', $start = 0 ) {
		return new JSNumber( strrpos( &$this->__valueOf, (string) $value, JSDataType::__resolve( $start, JSDataType::TYPE_NUMBER ) ) );
	}

	public function match( $regexp = '' ) {
		$match = preg_match_all( JSDataType::__resolve( $regexp, JSDataType::TYPE_REGEXP ), &$this->__valueOf, $matches );
		return ( !$match ) ? new JSNull() : new JSNumber( $match );
	}

	public function replace( $regexp = '', $value = '' ) {
		$this->__valueOf = preg_replace( JSDataType::__resolve( $regexp, JSDataType::TYPE_REGEXP ), (string) $value, &$this->__valueOf );
		$this->length = strlen( $this->__valueOf );
		return $this;
	}

	public function search( $regexp = '' ) {
		preg_match( JSDataType::__resolve( $regexp, JSDataType::TYPE_REGEXP ), &$this->__valueOf, $matches, PREG_OFFSET_CAPTURE );
		return ( !$matches ) ? new JSNumber( -1 ) : new JSNumber( $matches[0][1] );
	}

	public function slice( $start = 0, $end = -1 ) {
		return new static( substr( $this->__valueOf, JSDataType::__resolve( $start, JSDataType::TYPE_NUMBER ), JSDataType::__resolve( $end, JSDataType::TYPE_NUMBER ) ) );
	}

	public function split( $value = '', $limit = -1 ) {
		$class = new ReflectionClass( 'JSArray' );
		return $class->newInstanceargs( explode( (string) $value, $this->__valueOf, JSDataType::__resolve( $limit, JSDataType::TYPE_NUMBER ) ) );
	}

	public function substr( $start = 0, $length = null ) {
		$start   = JSDataType::__resolve( $start, JSDataType::TYPE_NUMBER );
		$length2 = JSDataType::__resolve( $length, JSDataType::TYPE_NUMBER );
		if ( $start >= strlen( $this->__valueOf ) ) return new static( '' );
		if ( is_null( $length ) ) return new static( substr( $this->__valueOf, $start ) );
		if ( $length2 <= 0 ) return new static( '' );
		if ( abs( $start ) >= strlen( $this->__valueOf ) ) $start = 0;
		return new static( substr( $this->__valueOf, $start, $length2 ) );
	}

	public function substring( $start = 0, $end = -1 ) {
		return new static( substr( $this->__valueOf, JSDataType::__resolve( $start, JSDataType::TYPE_NUMBER ), JSDataType::__resolve( $end, JSDataType::TYPE_NUMBER ) ) );
	}

	public function toLocaleLowerCase() {
		return $this->toLowerCase();
	}

	public function toLocaleUpperCase() {
		return $this->toUpperCase();
	}

	public function toLowerCase() {
		$this->__valueOf = strtolower( $this->__valueOf );
		return $this;
	}

	public function toUpperCase() {
		$this->__valueOf = strtoupper( $this->__valueOf );
		return $this;
	}

	public function trim() {
		return new static( trim( $this->__valueOf ) );
	}

	static function fromCharCode() {
		$arguments = func_get_args();
		for ( $i = 0; $i < count( $arguments ); $i++ ) {
			if ( $arguments[$i] instanceof JSDataType ) $arguments[$i] = $arguments[$i]->valueOf();
			$arguments[$i] = chr( $arguments[$i] );
		}
		return new static( implode( '', $arguments ) );
	}
}

