<?php

/**
 * Gekosale, Open Source E-Commerce Solution
 * http://www.gekosale.pl
 *
 * Copyright (c) 2009-2011 Gekosale
 *
 * This program is free software; you can redistribute it and/or modify it under the terms 
 * of the GNU General Public License Version 3, 29 June 2007 as published by the Free Software
 * Foundation (http://opensource.org/licenses/gpl-3.0.html).
 * If you did not receive a copy of the license and are unable to obtain it through the 
 * world-wide-web, please send an email to license@verison.pl so we can send you a copy immediately.
 */
namespace SimpleForm\Conditions;

class Equals extends \SimpleForm\Condition
{

	public function Evaluate ($value)
	{
		if (is_array($this->_argument)){
			return in_array($value, $this->_argument);
		}
		return ($value == $this->_argument);
	}
}