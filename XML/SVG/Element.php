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
 * XML_SVG_Element
 *
 * This is the base class for the different SVG Element
 * Objects. Extend this class to create a new SVG Element.
 *
 * @package XML_SVG
 */
class XML_SVG_Element extends DOMElement
{
	protected static $tag = null;
	public static $ATTR_CONDITIONAL_PROCESSING = array(
		'requiredFeatures',
		'requiredExtensions',
		'systemLanguage',
	);
	public static $ATTR_CORE = array(
		'id',
		'xml:base',
		'xml:lang',
		'xml:space',
	);
	public static $ATTR_GRAPHICAL_EVENT = array(
		'onfocusin',
		'onfocusout',
		'onactivate',
		'onclick',
		'onmousedown',
		'onmouseup',
		'onmouseover',
		'onmousemove',
		'onmouseout',
		'onload',
	);
	public static $ATTR_PRESENTATION = array(
		'alignment-baseline',
		'baseline-shift',
		'clip',
		'clip-path',
		'clip-rule',
		'color',
		'color-interpolation',
		'color-interpolation-filters',
		'color-profile',
		'color-rendering',
		'cursor',
		'direction',
		'display',
		'dominant-baseline',
		'enable-background',
		'fill',
		'fill-opacity',
		'fill-rule',
		'filter',
		'flood-color',
		'flood-opacity',
		'font-family',
		'font-size',
		'font-size-adjust',
		'font-stretch',
		'font-style',
		'font-variant',
		'font-weight',
		'glyph-orientation-horizontal',
		'glyph-orientation-vertical',
		'image-rendering',
		'kerning',
		'letter-spacing',
		'lighting-color',
		'marker-end',
		'marker-mid',
		'marker-start',
		'mask',
		'opacity',
		'overflow',
		'pointer-events',
		'shape-rendering',
		'stop-color',
		'stop-opacity',
		'stroke',
		'stroke-dasharray',
		'stroke-dashoffset',
		'stroke-linecap',
		'stroke-linejoin',
		'stroke-miterlimit',
		'stroke-opacity',
		'stroke-width',
		'text-anchor',
		'text-decoration',
		'text-rendering',
		'unicode-bidi',
		'visibility',
		'word-spacing',
		'writing-mode',
	);
	public static $ATTR_XLINK = array(
		'xlink:href', 
		'xlink:show', 
		'xlink:actuate', 
		'xlink:type', 
		'xlink:role', 
		'xlink:arcrole', 
		'xlink:title',
	);

	protected $_attributes = array();

	protected $dynamic = array();
	public $properties = array();

	public function __get($attribute) {
		//error_log(get_class($this) . "__get($attribute)");
		$attribute = str_replace("_", "-", $attribute);
		switch ($attribute) {
		case 'right' : return $this->x + $this->width;
		case 'bottom' : return $this->y + $this->height;
		case 'x' :
			if ($this->isAttribute('x')) return $this->getAttribute('x');
			$left = 0;
			if (isset($this->properties['x'])) $left = $this->properties['x'];
			if (isset($this->{'right-of'})) $left = $this->{'right-of'};
			if ($left instanceof self) $left = $left->right;
			return $left; // + $this->marginx;
		case 'y' :
			if ($this->isAttribute('y')) return $this->getAttribute('y');
			$top = 0;
			if (isset($this->properties['y'])) $top = $this->properties['y'];
			if (isset($this->{'below-of'})) $top = $this->{'below-of'};
			if ($top instanceof self) $top = $top->bottom;
			return $top; // + $this->marginy;
		default: 
			if ($this->isAttribute($attribute)) {
				//error_log(get_class($this) . "__get: $attribute is an attr");
				return $this->getAttribute($attribute);
			} elseif (isset($this->properties[$attribute])) {
				//error_log(get_class($this) . "__get: $attribute is not an attr");
				return $this->properties[$attribute];
			} else {
				//error_log(get_class($this) . "__get: $attribute is not set");
			}
		}
	}

	public function __set($attribute, $value) {
		if (is_object($value)) {
			//error_log(get_class($this) . "__set($attribute, [" . get_class($value) . "])");
		} else {
			//error_log(get_class($this) . "__set($attribute, $value)");
		}
		$attribute = str_replace("_", "-", $attribute);
		switch ($attribute) {
		case 'right-of' :
			unset($this->x);
			$this->properties['right-of'] = $value;
			break;
		case 'below-of' : 
			unset($this->y);
			$this->properties['below-of'] = $value;
			break;
		case 'margin' :
			$this->marginy = $value;
			$this->marginx = $value;
			break;
		default :
			if ($this->isAttribute($attribute)) {
				//error_log(get_class($this) . ": $attribute is an attr");
				$this->setAttribute($attribute, $value);
			} else {
				//error_log(get_class($this) . "__set: $attribute is not an attr");
				$this->properties[$attribute] = $value;
				//error_log($this->properties[$attribute]);
			}
			break;
		}
	}

	public function __unset($attribute) {
		$attribute = str_replace("_", "-", $attribute);
		switch ($attribute) {
		case 'margin' :
			unset($this->marginy);
			unset($this->marginx);
			break;
		default :
			if (isset($this->properties[$attribute])) unset($this->properties[$attribute]);
			else $this->removeAttribute($attribute);
			break;
		}
	}

	public static function getNew($value='', $namespaceURI='') {
		$element = new static(static::$tag, $value, $namespaceURI);
		$argarray = func_get_args();
		call_user_func_array(array($element, 'initialize'), $argarray);
		XML_SVG_Document::getInstance()->appendChild($element);
		return $element;
	}

	/** Initialize the object with some starting values
	 */
	protected function initialize() {
	}

	protected function isAttribute($name) {
		if (empty($this->_attributes)) {
			$this->_attributes = static::getAttributes();
		}
		//error_log(var_export($this->_attributes, true));
		return in_array($name, $this->_attributes);
	}

	protected static function getAttributes() {
		return static::$ATTR_CORE;
	}

	public function appendChildren() {
		$children = func_get_args();
		$this->_appendChildren($children);
	}

	/**
	 * Helper function: given an array of XML_SVG_Element objects, append each 
	 * of them as a child.
	 */ 
	private function _appendChildren($children) {
		foreach ($children as $child) {
			if (is_array($child)) {
				$this->_appendChildren($child);
			} elseif ($child instanceof self) {
				$this->appendChild($child);
			} else {
				error_log(__METHOD__.':'.__LINE__.": bad argument");
			}
		}
	}

    // Print out the object for debugging.
    function debug()
    {
        echo '<pre>'; var_dump($this); echo '</pre>';
    }

}

