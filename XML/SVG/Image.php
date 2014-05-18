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
 * XML_SVG_Image
 *
 * @package XML_SVG
 */
class XML_SVG_Image extends XML_SVG_Element 
{
	protected static $tag = "image";
	private static $extra_attributes = array(
		'class',
		'style',
		'externalResourcesRequired',
		'preserveAspectRatio',
		'transform',
		'x',
		'y',
		'width',
		'height',
	);

	public static function getNew($href=false, $width=false, $height=false) {
		$image = parent::getNew();
		if (false !== $href) $image->{'xlink:href'} = $href;
		if (false !== $width) $image->width = $width;
		if (false !== $height) $image->height = $height;
		return $image;
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

	public function __set($attribute, $value) {
		switch ($attribute) {
		case 'href' :
			$this->setAttributeNS(XML_SVG_ROOT::$XMLNS_XLINK, 'xlink:href', $value);
			break;
		default :
			parent::__set($attribute, $value);
			break;
		}
	}

}
