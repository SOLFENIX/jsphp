<?php

/*
 *  JavaScript Null v1.0
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

/* JSNull
 *
 * Class to create a new JavaScript NULL object
 *
 * @author James Watts
 * @version 1.0
 */

class JSNull extends JSObject {

	public function __construct() {
		$this->__prototype = JSPrototype::__instance( get_class( $this ), $this );
	}

	public function __toString() {
		return '';
	}
}

