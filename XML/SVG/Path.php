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
 * XML_SVG_Path
 *
 * @package XML_SVG
 */
class XML_SVG_Path extends XML_SVG_Element 
{
	protected static $tag = 'path';
	private static $extra_attributes = array(
		'class',
		'style',
		'externalResourcesRequired',
		'transform',
		'd',
		'pathLength',
	);

	public static function getNew($d='') {
		$path = parent::getNew();
		$path->d = $d;
		return $path;
	}

    function setShape($d)
    {
		$this->setAttribute('d', $d);
		// $this->_d = $d;
    }

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
