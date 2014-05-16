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

/**
 * XML_SVG_Root
 *
 * This represents the root <svg> element.
 *
 * @package XML_SVG
 */
class XML_SVG_Root extends XML_SVG_Element
{
	protected static $tag = 'svg';
	private static $extra_attributes = array(
		'class',
		'style',
		'externalResourcesRequired',
		'x',
		'y',
		'width',
		'height',
		'viewBox',
		'preserveAspectRatio',
		'zoomAndPan',
		'version',
		'baseProfile',
		'contentScriptType',
		'contentStyleType',
	);

	public static $XMLNS_XMLNS = 'http://www.w3.org/2000/xmlns';
	public static $XMLNS = 'http://www.w3.org/2000/svg';        
	public static $XMLNS_XLINK = 'http://www.w3.org/1999/xlink';

	public static function getNew() {
		return parent::getNew('', self::$XMLNS);
	}

	public function initialize() {
		//$this->setAttribute("xmlns:xlink", self::$XMLNS_XLINK);
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
