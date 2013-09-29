<?php

/*
 *  JavaScript PHP v1.0
 *  http://www.jsphp.org
 *
 *  Copyright (c) 2010-2013 James Watts (SOLFENIX)
 *  http://www.solfenix.com
 *
 *  This is FREE software, licensed under the GPL
 *  http://www.gnu.org/licenses/gpl.html
 */

/*
 * @author      James Watts <contact@jameswatts.info>
 * @copyright   2010-2013 James Watts (SOLFENIX)
 * @license     http://www.gnu.org/licenses/gpl.html
 * @link        http://www.solfenix.com
 * @version     1.0
 */

define( 'Infinity', 1 );
define( 'NaN', null );
define( 'undefined', -1 );

function decodeURI( $value ) {
	return rawurldecode( $value );
}

function decodeURIComponent( $value ) {
	return rawurldecode( $value );
}

function encodeURI( $value ) {
	return rawurlencode( $value );
}

function encodeURIComponent( $value ) {
	return rawurlencode( $value );
}

function inFinite( $value ) {
	return is_finite( $value );
}

function isNaN( $value ) {
	return is_nan( $value );
}

function parseFloat( $value ) {
	return ( is_object( $value ) ) ? (int) $value : (float) $value;
}

function parseInt( $value, $radix = 10 ) {
	return intval( $value, $radix );
}

function JSDate() {
	return str_replace( '?', 'GMT', date( 'D M j Y H:i:s ?O (e)' ) );
}

