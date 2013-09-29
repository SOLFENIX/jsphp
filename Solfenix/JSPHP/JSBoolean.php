<?php

/*
 *  JavaScript Boolean v1.0
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
use Solfenix\JSPHP\JSPrototype;

/* JSBoolean
 *
 * Class to create a new JavaScript boolean object
 *
 * @author James Watts
 * @version 1.0
 */

class JSBoolean extends JSObject {

	public function __construct( $boolean = null ) {
		$this->__valueOf   = ( is_bool( $boolean ) ) ? $boolean : false;
		$this->__prototype = JSPrototype::__instance( get_class( $this ), $this );
	}

	public function __toString() {
		return (string) $this->__valueOf;
	}
}

