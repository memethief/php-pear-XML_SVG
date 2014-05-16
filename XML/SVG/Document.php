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
 * XML_SVG_Document
 *
 * This extends the DOMDocument class. It wraps the XML_SVG_Frament output
 * with a content header, xml definition and doctype.
 *
 * @package XML_SVG
 */
class XML_SVG_Document extends DOMDocument
{
	private static $singleton;

	private $_version  = '1.0';
	private $_encoding = 'iso-8859-1';

	public static function getInstance() {
		if (empty(self::$singleton)) {
			self::$singleton = new self();
		}
		return self::$singleton;
	}

	function __construct() {
		parent::__construct($this->_version, $this->_encoding);
		$this->formatOutput = true;
	}

}
