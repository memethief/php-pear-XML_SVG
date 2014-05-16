<?php
/**
 * Package for building SVG graphics.
 *
 * Copyright 2002-2007 The Horde Project (http://www.horde.org/)
 *
 * @author  Chuck Hagenbuch <chuck@horde.org>
 * @package XML_SVG
 * @license http://www.fsf.org/copyleft/lgpl.html
 */
require_once 'XML/SVG/Textpath.php';

/**
 * XML_SVG_Text
 *
 * @package XML_SVG
 */
class XML_SVG_Text extends XML_SVG_Textpath 
{
	protected static $tag = 'text';
	private static $extra_attributes = array(
		'class',
		'style',
		'externalResourcesRequired',
		'transform',
		'lengthAdjust',
		'x',
		'y',
		'dx',
		'dy',
		'rotate',
		'textLength',
	);

	protected static function getAttributes() {
		return array_merge(
			static::$ATTR_CONDITIONAL_PROCESSING,
			static::$ATTR_CORE,
			static::$ATTR_GRAPHICAL_EVENT,
			static::$ATTR_PRESENTATION,
			static::$extra_attributes
		);
	}

}
