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
require_once 'XML/SVG/Element.php';

/**
 * XML_SVG_ClipPath
 *
 * @package XML_SVG
 */
class XML_SVG_ClipPath extends XML_SVG_Element 
{
	protected static $tag = 'clipPath';
	private static $extra_attributes = array(
		'class',
		'style',
		'externalResourcesRequired',
		'transform',
		'clipPathUnits',
	);

	protected static function getAttributes() {
		return array_merge(
			static::$ATTR_CONDITIONAL_PROCESSING,
			static::$ATTR_CORE,
			static::$ATTR_PRESENTATION,
			static::$extra_attributes
		);
	}

}
