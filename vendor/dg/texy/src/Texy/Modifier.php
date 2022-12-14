<?php

/**
 * This file is part of the Texy! (https://texy.info)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

namespace Texy;


/**
 * Modifier processor.
 *
 * Modifiers are texts like .(title)[class1 class2 #id]{color: red}>^
 *   .         starts with dot
 *   (...)     title or alt modifier
 *   [...]     classes or ID modifier
 *   {...}     inner style modifier
 *   < > <> =  horizontal align modifier
 *   ^ - _     vertical align modifier
 */
final class Modifier
{
	use Strict;

	/** @var string|null */
	public $id;

	/** @var array of classes (as keys) */
	public $classes = [];

	/** @var array of CSS styles */
	public $styles = [];

	/** @var array of HTML element attributes */
	public $attrs = [];

	/** @var string|null */
	public $hAlign;

	/** @var string|null */
	public $vAlign;

	/** @var string|null */
	public $title;

	/** @var string|null */
	public $cite;

	/** @var array  list of properties which are regarded as HTML element attributes */
	public static $elAttrs = [
		'abbr' => 1, 'accesskey' => 1, 'align' => 1, 'alt' => 1, 'archive' => 1, 'axis' => 1, 'bgcolor' => 1, 'cellpadding' => 1,
		'cellspacing' => 1, 'char' => 1, 'charoff' => 1, 'charset' => 1, 'cite' => 1, 'classid' => 1, 'codebase' => 1, 'codetype' => 1,
		'colspan' => 1, 'compact' => 1, 'coords' => 1, 'data' => 1, 'datetime' => 1, 'declare' => 1, 'dir' => 1, 'face' => 1, 'frame' => 1,
		'headers' => 1, 'href' => 1, 'hreflang' => 1, 'hspace' => 1, 'ismap' => 1, 'lang' => 1, 'longdesc' => 1, 'name' => 1,
		'noshade' => 1, 'nowrap' => 1, 'onblur' => 1, 'onclick' => 1, 'ondblclick' => 1, 'onkeydown' => 1, 'onkeypress' => 1,
		'onkeyup' => 1, 'onmousedown' => 1, 'onmousemove' => 1, 'onmouseout' => 1, 'onmouseover' => 1, 'onmouseup' => 1, 'rel' => 1,
		'rev' => 1, 'rowspan' => 1, 'rules' => 1, 'scope' => 1, 'shape' => 1, 'size' => 1, 'span' => 1, 'src' => 1, 'standby' => 1,
		'start' => 1, 'summary' => 1, 'tabindex' => 1, 'target' => 1, 'title' => 1, 'type' => 1, 'usemap' => 1, 'valign' => 1,
		'value' => 1, 'vspace' => 1,
	];


	/**
	 * @param  string modifier to parse
	 */
	public function __construct($mod = null)
	{
		$this->setProperties($mod);
	}


	public function setProperties($mod)
	{
		if (!$mod) {
			return;
		}

		$p = 0;
		$len = strlen($mod);

		while ($p < $len) {
			$ch = $mod[$p];

			if ($ch === '(') { // title
				preg_match('#(?:\\\\\)|[^)\n])++\)#', $mod, $m, 0, $p);
				$this->title = html_entity_decode(str_replace('\)', ')', trim(substr($m[0], 1, -1))), ENT_QUOTES, 'UTF-8');
				$p += strlen($m[0]);

			} elseif ($ch === '{') { // style & attributes
				$a = strpos($mod, '}', $p) + 1;
				foreach (explode(';', substr($mod, $p + 1, $a - $p - 2)) as $value) {
					$pair = explode(':', $value, 2);
					$prop = strtolower(trim($pair[0]));
					if ($prop === '' || !isset($pair[1])) {
						continue;
					}
					$value = trim($pair[1]);

					if (isset(self::$elAttrs[$prop]) || substr($prop, 0, 5) === 'data-') { // attribute
						$this->attrs[$prop] = $value;
					} elseif ($value !== '') { // style
						$this->styles[$prop] = $value;
					}
				}
				$p = $a;

			} elseif ($ch === '[') { // classes & ID
				$a = strpos($mod, ']', $p) + 1;
				$s = str_replace('#', ' #', substr($mod, $p + 1, $a - $p - 2));
				foreach (explode(' ', $s) as $value) {
					if ($value === '') {
						continue;
					} elseif ($value[0] === '#') {
						$this->id = substr($value, 1);
					} else {
						$this->classes[$value] = true;
					}
				}
				$p = $a;

			} elseif ($ch === '^') { // alignment
				$this->vAlign = 'top';
				$p++;
			} elseif ($ch === '-') {
				$this->vAlign = 'middle';
				$p++;
			} elseif ($ch === '_') {
				$this->vAlign = 'bottom';
				$p++;
			} elseif ($ch === '=') {
				$this->hAlign = 'justify';
				$p++;
			} elseif ($ch === '>') {
				$this->hAlign = 'right';
				$p++;
			} elseif (substr($mod, $p, 2) === '<>') {
				$this->hAlign = 'center';
				$p += 2;
			} elseif ($ch === '<') {
				$this->hAlign = 'left';
				$p++;
			} else {
				break;
			}
		}
	}


	/**
	 * Decorates HtmlElement element.
	 * @return void
	 */
	public function decorate(Texy $texy, HtmlElement $el)
	{
		$elAttrs = &$el->attrs;

		// tag & attibutes
		$tmp = $texy->allowedTags; // speed-up
		if (!$this->attrs) {
		} elseif ($tmp === $texy::ALL) {
			$elAttrs = $this->attrs;
			$el->validateAttrs($texy->dtd);

		} elseif (is_array($tmp) && isset($tmp[$el->getName()])) {
			$tmp = $tmp[$el->getName()];

			if ($tmp === $texy::ALL) {
				$elAttrs = $this->attrs;

			} elseif (is_array($tmp) && count($tmp)) {
				$tmp = array_flip($tmp);
				foreach ($this->attrs as $key => $value) {
					if (isset($tmp[$key])) {
						$el->attrs[$key] = $value;
					}
				}
			}
			$el->validateAttrs($texy->dtd);
		}

		// title
		if ($this->title !== null) {
			$elAttrs['title'] = $texy->typographyModule->postLine($this->title);
		}

		// classes & ID
		if ($this->classes || $this->id !== null) {
			$tmp = $texy->_classes; // speed-up
			if ($tmp === $texy::ALL) {
				foreach ($this->classes as $value => $foo) {
					$elAttrs['class'][] = $value;
				}
				$elAttrs['id'] = $this->id;
			} elseif (is_array($tmp)) {
				foreach ($this->classes as $value => $foo) {
					if (isset($tmp[$value])) {
						$elAttrs['class'][] = $value;
					}
				}

				if (isset($tmp['#' . $this->id])) {
					$elAttrs['id'] = $this->id;
				}
			}
		}

		// styles
		if ($this->styles) {
			$tmp = $texy->_styles; // speed-up
			if ($tmp === $texy::ALL) {
				foreach ($this->styles as $prop => $value) {
					$elAttrs['style'][$prop] = $value;
				}
			} elseif (is_array($tmp)) {
				foreach ($this->styles as $prop => $value) {
					if (isset($tmp[$prop])) {
						$elAttrs['style'][$prop] = $value;
					}
				}
			}
		}

		// horizontal align
		if ($this->hAlign) {
			if (empty($texy->alignClasses[$this->hAlign])) {
				$elAttrs['style']['text-align'] = $this->hAlign;
			} else {
				$elAttrs['class'][] = $texy->alignClasses[$this->hAlign];
			}
		}

		// vertical align
		if ($this->vAlign) {
			if (empty($texy->alignClasses[$this->vAlign])) {
				$elAttrs['style']['vertical-align'] = $this->vAlign;
			} else {
				$elAttrs['class'][] = $texy->alignClasses[$this->vAlign];
			}
		}

		return $el;
	}
}
