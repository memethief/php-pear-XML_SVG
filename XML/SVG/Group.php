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
 * XML_SVG_Group
 *
 * @package XML_SVG
 */
class XML_SVG_Group extends XML_SVG_Element 
{
	protected static $tag = "g";
	private static $extra_attributes = array(
		'class',
		'style',
		'externalResourcesRequired',
		'transform',
	);

	public static function getNew($x=false, $y=false, $marginx=0, $marginy=false) {
		$group = parent::getNew();
		$group->marginx = $marginx;
		$group->marginy = ($marginy === false) ? $marginx : $marginy;
		if (($x !== false) || ($y !== false)) {
			$group->{'right-of'} = $x;
			$group->{'below-of'} = $y;
			//$group->transform = "translate({$group->x}, {$group->y})";
		}
		return $group;
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

			/*
	public function __set($attribute, $value) {
		switch ($attribute) {
		case 'transform' :
			if ($value === true) {
				$this->dynamic['transform'] = true;
			} else {
				unset($this->transform);
			}
			break;
		default :
			parent::__set($attribute, $value);
			break;
		}
	}

	public function __unset($attribute) {
		switch ($attribute) {
		case 'transform' :
			unset($this->transform);
			break;
		default :
			parent::__unset($attribute);
			break;
		}
	}
			 */
}

