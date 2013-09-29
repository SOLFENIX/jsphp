<?php

/*
 *  JavaScript Error v1.0
 *  http://www.jsphp.org
 *
 *  Copyright (c) 2010-2013 James Watts (SOLFENIX)
 *  http://www.solfenix.com
 *
 *  This is FREE software, licensed under the GPL
 *  http://www.gnu.org/licenses/gpl.html
 */

namespace Solfenix\JSPHP;

use Exception;

use Solfenix\JSPHP\JSString;
use Solfenix\JSPHP\JSNumber;

/* JSError
 *
 * Class to create a new JavaScript error object
 *
 * @author James Watts
 * @version 1.0
 */

class JSError extends Exception {

	protected $__name = 'Error';

	public function __get( $name ) {
		if ( $name == 'name' )    return new JSString( $this->__name );
		if ( $name == 'message' ) return new JSString( $this->getMessage() );
		if ( $name == 'fileName' ) return new JSString( $this->getFile() );
		if ( $name == 'lineNumber' ) return new JSNumber( $this->getLine() );
	}
}

/* JSEvalError
 *
 * Class to create a new JavaScript eval error object
 *
 * @author James Watts
 * @version 1.0
 */

class JSEvalError extends JSError {

	protected $__name = 'EvalError';
}

/* JSRangeError
 *
 * Class to create a new JavaScript range error object
 *
 * @author James Watts
 * @version 1.0
 */

class JSRangeError extends JSError {

	protected $__name = 'RangeError';
}

/* JSReferenceError
 *
 * Class to create a new JavaScript reference error object
 *
 * @author James Watts
 * @version 1.0
 */

class JSReferenceError extends JSError {

	protected $__name = 'ReferenceError';
}

/* JSSyntaxError
 *
 * Class to create a new JavaScript syntax error object
 *
 * @author James Watts
 * @version 1.0
 */

class JSSyntaxError extends JSError {

	protected $__name = 'SyntaxError';
}

/* JSTypeError
 *
 * Class to create a new JavaScript type error object
 *
 * @author James Watts
 * @version 1.0
 */

class JSTypeError extends JSError {

	protected $__name = 'TypeError';
}

/* JSURIError
 *
 * Class to create a new JavaScript URI error object
 *
 * @author James Watts
 * @version 1.0
 */

class JSURIError extends JSError {

	protected $__name = 'URIError';
}

