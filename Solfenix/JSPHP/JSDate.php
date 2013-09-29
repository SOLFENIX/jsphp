<?php

/*
 *  JavaScript Date v1.0
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
use Solfenix\JSPHP\JSNumber;
use Solfenix\JSPHP\JSString;

/* JSDate
 *
 * Class to create a new JavaScript date object
 *
 * @author James Watts
 * @version 1.0
 */

class JSDate extends JSObject {

	protected function __getDateValues() {
		return explode( '-', date( 'N-j-n-Y-G-i-s-u', $this->__valueOf ) ); // day,date,month,year,hours,minutes,seconds,milliseconds
	}

	protected function __getTimeValue( $values ) {
		return strtotime( $values[3] . '-' . ( ( (int) $values[2] < 10 ) ? '0' : '' ) . $values[2] . '-' . ( ( (int) $values[1] < 10 ) ? '0' : '' ) . $values[1] . ' ' . ( ( (int) $values[4] < 10 ) ? '0' : '' ) . $values[4] . ':' . ( ( (int) $values[5] < 10 ) ? '0' : '' ) . $values[5] . ':' . ( ( (int) $values[6] < 10 ) ? '0' : '' ) . $values[6] );
	}

	public function __construct() {
		$arguments = func_get_args();
		if ( !isset( $arguments[0] ) ) {
			$this->__valueOf = time();
		} elseif ( count( $arguments ) < 2 && ( is_int( $arguments[0] ) || $arguments[0] instanceof JSNumber ) ) {
			$this->__valueOf = JSDataType::__resolve( $arguments[0], JSDataType::TYPE_NUMBER );
		} elseif ( count( $arguments ) < 2 && ( is_string( $arguments[0] ) || $arguments[0] instanceof JSString ) ) {
			$this->__valueOf = JSDate::parse( $arguments[0] );
		} else {
			$this->__valueOf = time();
			$date            = $this->__getDateValues();
			$date[3]         = JSDataType::__resolve( $arguments[0], JSDataType::TYPE_NUMBER );
			if ( isset( $arguments[1] ) ) $date[2] = JSDataType::__resolve( $arguments[1], JSDataType::TYPE_NUMBER );
			if ( isset( $arguments[2] ) ) $date[1] = JSDataType::__resolve( $arguments[2], JSDataType::TYPE_NUMBER );
			if ( isset( $arguments[3] ) ) $date[4] = JSDataType::__resolve( $arguments[3], JSDataType::TYPE_NUMBER );
			if ( isset( $arguments[4] ) ) $date[5] = JSDataType::__resolve( $arguments[4], JSDataType::TYPE_NUMBER );
			if ( isset( $arguments[5] ) ) $date[6] = JSDataType::__resolve( $arguments[5], JSDataType::TYPE_NUMBER );
			if ( isset( $arguments[6] ) ) $date[7] = JSDataType::__resolve( $arguments[6], JSDataType::TYPE_NUMBER );
			$this->__valueOf = $this->__getTimeValue( $date );
		}
	}

	public function getDate() {
		return new JSNumber( (int) date( 'j', $this->__valueOf ) );
	}

	public function getDay() {
		return new JSNumber( ( (int) date( 'N', $this->__valueOf ) )-1 );
	}

	public function getFullYear() {
		return new JSNumber( (int) date( 'Y', $this->__valueOf ) );
	}

	public function getHours() {
		return new JSNumber( (int) date( 'G', $this->__valueOf ) );
	}

	public function getMilliseconds() {
		return new JSNumber( min( 999, (int) date( 'u', $this->__valueOf ) ) );
	}

	public function getMinutes() {
		return new JSNumber( (int) date( 'i', $this->__valueOf ) );
	}

	public function getMonth() {
		return new JSNumber( ( (int) date( 'n', $this->__valueOf ) )-1 );
	}

	public function getSeconds() {
		return new JSNumber( (int) date( 's', $this->__valueOf ) );
	}

	public function getUTCDate() {
		return $this->getDate();
	}

	public function getUTCDay() {
		return $this->getDay();
	}

	public function getUTCFullYear() {
		return $this->getFullYear();
	}

	public function getUTCHours() {
		return $this->getHours();
	}

	public function getUTCMilliseconds() {
		return $this->getMilliseconds();
	}

	public function getUTCMinutes() {
		return $this->getMinutes();
	}

	public function getUTCMonth() {
		return $this->getMonth();
	}

	public function getUTCSeconds() {
		return $this->getSeconds();
	}

	public function getTime() {
		return new JSNumber( $this->__valueOf*1000 );
	}

	public function getTimezoneOffset() {
		return new JSNumber( round( ( (int) date( 'Z', $this->__valueOf ) )/60 ) );
	}

	public function setDate( $day = null ) {
		$date = $this->__getDateValues();
		if ( isset( $day ) ) {
			$day     = JSDataType::__resolve( $day, JSDataType::TYPE_NUMBER );
			$date[1] = $day;
		}
		$this->__valueOf = $this->__getTimeValue( $date );
		return $this;
	}

	public function setFullYear( $year = null, $month = null, $day = null ) {
		$date = $this->__getDateValues();
		if ( isset( $year ) ) {
			$year    = JSDataType::__resolve( $year, JSDataType::TYPE_NUMBER );
			$date[3] = $year;
		}
		if ( isset( $month ) ) {
			$month   = JSDataType::__resolve( $month, JSDataType::TYPE_NUMBER );
			$date[2] = $month;
		}
		if ( isset( $day ) ) {
			$day     = JSDataType::__resolve( $day, JSDataType::TYPE_NUMBER );
			$date[1] = $day;
		}
		$this->__valueOf = $this->__getTimeValue( $date );
		return $this;
	}

	public function setHours( $hour = null, $minute = null, $second = null ) {
		$date = $this->__getDateValues();
		if ( isset( $hour ) ) {
			$hour    = JSDataType::__resolve( $hour, JSDataType::TYPE_NUMBER );
			$date[4] = $hour;
		}
		if ( isset( $minute ) ) {
			$minute  = JSDataType::__resolve( $minute, JSDataType::TYPE_NUMBER );
			$date[5] = $minute;
		}
		if ( isset( $second ) ) {
			$second  = JSDataType::__resolve( $second, JSDataType::TYPE_NUMBER );
			$date[6] = $second;
		}
		$this->__valueOf = $this->__getTimeValue( $date );
		return $this;
	}

	public function setMilliseconds( $millisecond = null ) {
		$date = $this->__getDateValues();
		if ( isset( $millisecond ) ) {
			$millisecond = JSDataType::__resolve( $millisecond, JSDataType::TYPE_NUMBER );
			$date[7]     = $millisecond;
		}
		$this->__valueOf = $this->__getTimeValue( $date );
		return $this;
	}

	public function setMinutes( $minute = null, $second = null, $millisecond = null ) {
		$date = $this->__getDateValues();
		if ( isset( $minute ) ) {
			$minute  = JSDataType::__resolve( $minute, JSDataType::TYPE_NUMBER );
			$date[5] = $minute;
		}
		if ( isset( $second ) ) {
			$second  = JSDataType::__resolve( $second, JSDataType::TYPE_NUMBER );
			$date[6] = $second;
		}
		if ( isset( $millisecond ) ) {
			$millisecond = JSDataType::__resolve( $millisecond, JSDataType::TYPE_NUMBER );
			$date[7]     = $millisecond;
		}
		$this->__valueOf = $this->__getTimeValue( $date );
		return $this;
	}

	public function setMonth( $month = null, $day = null ) {
		$date = $this->__getDateValues();
		if ( isset( $month ) ) {
			$month   = JSDataType::__resolve( $month, JSDataType::TYPE_NUMBER );
			$date[2] = $month;
		}
		if ( isset( $day ) ) {
			$day     = JSDataType::__resolve( $day, JSDataType::TYPE_NUMBER );
			$date[1] = $day;
		}
		$this->__valueOf = $this->__getTimeValue( $date );
		return $this;
	}

	public function setSeconds( $second = null, $millisecond = null ) {
		$date = $this->__getDateValues();
		if ( isset( $second ) ) {
			$second  = JSDataType::__resolve( $second, JSDataType::TYPE_NUMBER );
			$date[6] = $second;
		}
		if ( isset( $millisecond ) ) {
			$millisecond = JSDataType::__resolve( $millisecond, JSDataType::TYPE_NUMBER );
			$date[7]     = $millisecond;
		}
		$this->__valueOf = $this->__getTimeValue( $date );
		return $this;
	}

	public function setUTCDate( $day ) {
		return $this->setDate( $day );
	}

	public function setUTCFullYear( $year, $month, $day ) {
		return $this->setFullYear( $year, $month, $day );
	}

	public function setUTCHours( $hour, $minute, $second ) {
		return $this->setHours( $hour, $minute, $second );
	}

	public function setUTCMilliseconds( $millisecond ) {
		return $this->setMilliseconds( $millisecond );
	}

	public function setUTCMinutes( $minute, $second, $millisecond ) {
		return $this->setMinutes( $minute, $second, $millisecond );
	}

	public function setUTCMonth( $month, $day ) {
		return $this->setMonth( $month, $day );
	}

	public function setUTCSeconds( $second, $millisecond ) {
		return $this->setSeconds( $second, $millisecond );
	}

	public function setTime( $time = 0 ) {
		$this->__valueOf = JSDataType::__resolve( $time, JSDataType::TYPE_NUMBER );
		return $this;
	}

	public function toDateString() {
		return new JSString( date( 'D, j M Y', $this->__valueOf ) );
	}

	public function toLocaleDateString() {
		return new JSString( date( 'D, j M Y', $this->__valueOf ) );
	}

	public function toLocaleTimeString() {
		return new JSString( date( 'H:i:s', $this->__valueOf ) );
	}

	public function toTimeString() {
		return new JSString( date( 'H:i:s', $this->__valueOf ) );
	}

	public function toUTCString() {
		return new JSString( date( 'r', $this->__valueOf ) );
	}

	static function now() {
		return new JSNumber( time() );
	}

	static function parse( $date = '' ) {
		return strtotime( $date );
	}

	static function UTC( $year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $millisecond = null ) {
		$date = explode( '-', date( 'N-j-n-Y-G-i-s-u', time() ) );
		if ( isset( $arguments[0] ) ) $date[3] = JSDataType::__resolve( $arguments[0], JSDataType::TYPE_NUMBER );
		if ( isset( $arguments[1] ) ) $date[2] = JSDataType::__resolve( $arguments[1], JSDataType::TYPE_NUMBER );
		if ( isset( $arguments[2] ) ) $date[1] = JSDataType::__resolve( $arguments[2], JSDataType::TYPE_NUMBER );
		if ( isset( $arguments[3] ) ) $date[4] = JSDataType::__resolve( $arguments[3], JSDataType::TYPE_NUMBER );
		if ( isset( $arguments[4] ) ) $date[5] = JSDataType::__resolve( $arguments[4], JSDataType::TYPE_NUMBER );
		if ( isset( $arguments[5] ) ) $date[6] = JSDataType::__resolve( $arguments[5], JSDataType::TYPE_NUMBER );
		if ( isset( $arguments[6] ) ) $date[7] = JSDataType::__resolve( $arguments[6], JSDataType::TYPE_NUMBER );
		return strtotime( $date[3] . '-' . ( ( (int) $date[2] < 10 ) ? '0' : '' ) . $date[2] . '-' . ( ( (int) $date[1] < 10 ) ? '0' : '' ) . $date[1] . ' ' . ( ( (int) $date[4] < 10 ) ? '0' : '' ) . $date[4] . ':' . ( ( (int) $date[5] < 10 ) ? '0' : '' ) . $date[5] . ':' . ( ( (int) $date[6] < 10 ) ? '0' : '' ) . $date[6] );
	}
}

