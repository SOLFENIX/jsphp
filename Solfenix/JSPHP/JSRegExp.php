<?php

/*
 *  JavaScript RegExp v1.0
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
use Solfenix\JSPHP\JSNull;
use Solfenix\JSPHP\JSBoolean;

/* JSRegExp
 *
 * Class to create a new JavaScript regular expression object
 *
 * @author James Watts
 * @version 1.0
 */

class JSRegExp extends JSObject {

	public $global = false;

	public $ignoreCase = false;

	public $multiline = false;

	public $lastIndex = 0;

	public $source = '';

	public function __construct( $pattern, $attributes ) {
		$this->__valueOf   = '/' . ( (string) $pattern ) . '/' . ( (string) $attributes );
		$this->__prototype = JSPrototype::__instance( get_class( $this ), $this );
		if ( strstr( (string) $attributes, 'g' ) ) $this->global = true;
		if ( strstr( (string) $attributes, 'i' ) ) $this->ignoreCase = true;
		if ( strstr( (string) $attributes, 'm' ) ) $this->multiline = true;
		$this->source = (string) $pattern;
	}

	public function exec( $value = '' ) {
		preg_match( $this->__valueOf, (string) $value, $matches, null, $this->lastIndex );
		if ( isset( $matches ) && count( $matches ) > 0 ) {
			$values = $matches;
			for ( $i = 0; $i < count( $values ); $i++ ) $values[$i] = JSDataType::__define( $values[$i] );
			$class           = new ReflectionClass( 'JSArray' );
			$result          = $class->newInstanceargs( $values );
			$result->input   = (string) $value;
			$result->index   = strpos( $this->__valueOf, $matches[0] );
			$this->lastIndex = $result->index+strlen( $matches[0] );
			return $result;
		}
		return new JSNull();
	}

	public function test( $value = '' ) {
		preg_match( $this->__valueOf, (string) $value, $matches, null, $this->lastIndex );
		if ( isset( $matches ) && count( $matches ) > 0 ) {
			$result          = new JSBoolean( true );
			$result->input   = (string) $value;
			$result->index   = strpos( $this->__valueOf, $matches[0] );
			$this->lastIndex = $result->index+strlen( $matches[0] );
			return $result;
		}
		return new JSBoolean( false );
	}
}

