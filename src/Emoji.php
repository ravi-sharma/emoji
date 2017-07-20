<?php

# @author Ravi Sharma <me@rvish.com>

# Copyright (c) 2017 Ravi Sharma (http://www.rvish.com)

# Permission is hereby granted, free of charge, to any person obtaining a copy
# of this software and associated documentation files (the "Software"), to deal
# in the Software without restriction, including without limitation the rights
# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
# copies of the Software, and to permit persons to whom the Software is
# furnished to do so, subject to the following conditions:
# The above copyright notice and this permission notice shall be included in
# all copies or substantial portions of the Software.
# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
# FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
# THE SOFTWARE.

namespace Rvish\Emoji;

class Emoji
{
	/**
	 * @var array
	 */
	protected $unifiedToVariables = null;

	/**
	 * @var array
	 */
	protected $unifiedToHtml = null;

	/**
	 * @var array
	 */
	protected $variablesToUnified = null;

	/**
	 * @var array
	 */
	protected $variablesToHtml = null;

	/**
	 * Emoji encode to #1f601#
	 *
	 * @param  string $text
	 *
	 * @return string
	 */
	public function encode($text)
	{
		$unifiedToVariables = $this->getUnifiedToVariables();

		$text = preg_replace_callback("/(\\\\x..)/isU", function ($m) {
			if (ctype_xdigit($m[0])) {
				return chr(hexdec(substr($m[0], 2)));
			} else {
				return $m[0];
			}
		}, $text);

		return str_replace(array_keys($unifiedToVariables), $unifiedToVariables, $text);
	}

	/**
	 * Emoji decode to \xF0\x9F\x98\x81
	 *
	 * @param  string $text
	 *
	 * @return string
	 */
	public function decode($text)
	{
		$variablesToUnified = $this->getVariablesToUnified();

		return str_replace(array_keys($variablesToUnified), $variablesToUnified, $text);
	}

	/**
	 * Unified to html
	 * "\xF0\x9F\x98\x81" to "<span class="emoji emoji1f601"></span>"
	 *
	 * @param  string $text
	 *
	 * @return string
	 */
	public function unifiedToHtml($text)
	{
		$unifiedToHtml = $this->getUnifiedToHtml();

		return str_replace(array_keys($unifiedToHtml), $unifiedToHtml, $text);
	}

	/**
	 * Variables convert to html
	 * #1f601# to "<span class="emoji emoji1f601"></span>"
	 *
	 * @param  string $text
	 *
	 * @return string
	 */
	public function variablesToHtml($text)
	{
		$variablesToHtml = $this->getVariablesToHtml();

		return str_replace(array_keys($variablesToHtml), $variablesToHtml, $text);
	}

	/**
	 * Get unified to variables
	 *
	 * @return array
	 */
	public function getUnifiedToVariables()
	{
		if ($this->unifiedToVariables === null) {
			$this->setUnifiedToVariables(include 'map.php');
		}

		return $this->unifiedToVariables;
	}

	/**
	 * Set unified to variables
	 *
	 * @param  array $unifiedToVariables
	 *
	 * @return Emoji
	 */
	public function setUnifiedToVariables(array $unifiedToVariables)
	{
		$this->unifiedToVariables = $unifiedToVariables;

		return $this;
	}

	/**
	 * Get unified to html
	 *
	 * @return array|null
	 */
	public function getUnifiedToHtml()
	{
		if ($this->unifiedToHtml === null) {
			$unifiedToHtml = [];
			foreach ($this->getUnifiedToVariables() as $unified => $variable) {
				if ($html = $this->variableToHtml($variable)) {
					$unifiedToHtml[$unified] = $html;
				}
			}
			$this->setUnifiedToHtml($unifiedToHtml);
		}

		return $this->unifiedToHtml;
	}

	/**
	 * Set unified to html
	 *
	 * @param  array $unifiedToHtml
	 *
	 * @return Emoji
	 */
	public function setUnifiedToHtml(array $unifiedToHtml)
	{
		$this->unifiedToHtml = $unifiedToHtml;

		return $this;
	}

	/**
	 * Get variable to html
	 *
	 * @return array
	 */
	public function getVariablesToHtml()
	{
		if ($this->variablesToHtml === null) {
			$variablesToHtml = [];
			foreach ($this->getUnifiedToVariables() as $variable) {
				if ($html = $this->variableToHtml($variable)) {
					$variablesToHtml[$variable] = $html;
				}
			}
			$this->setVariablesToHtml($variablesToHtml);
		}

		return $this->variablesToHtml;
	}

	/**
	 * Set variables to html
	 *
	 * @param  array $variablesToHtml
	 *
	 * @return Emoji
	 */
	public function setVariablesToHtml(array $variablesToHtml)
	{
		$this->variablesToHtml = $variablesToHtml;

		return $this;
	}

	/**
	 * A variable to html
	 *
	 * @param  string $variable
	 *
	 * @return string|false
	 */
	protected function variableToHtml($variable)
	{
		if ($match = preg_match('/^#(.+?)#$/', $variable, $matches)) {
			return sprintf('<span class="emoji emoji%s"></span>', $matches[1]);
		}

		return false;
	}

	/**
	 * Get variables to unified
	 *
	 * @return array
	 */
	public function getVariablesToUnified()
	{
		if ($this->variablesToUnified === null) {
			$this->setVariablesToUnified(array_flip($this->getUnifiedToVariables()));
		}

		return $this->variablesToUnified;
	}

	/**
	 * Set variables to unified
	 *
	 * @param  array $variablesToUnified
	 *
	 * @return Emoji
	 */
	public function setVariablesToUnified(array $variablesToUnified)
	{
		$this->variablesToUnified = $variablesToUnified;

		return $this;
	}
}
