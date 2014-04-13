<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/*
 * Copyright (C) 2014 Pedro Maia (pedro@pedromm.com)
 *
 * This file is part of Cidadão Atento.
 * 
 * Cidadão Atento is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Cidadão Atento is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Cidadão Atento.  If not, see <http://www.gnu.org/licenses/>.
 */

class Csrf {
	protected $_csrf_hash			= '';
	protected $_csrf_expire			= 7200;
	protected $_csrf_token_name		= 'ci_csrf_token';
	protected $_csrf_cookie_name	= 'ci_csrf_token';
	 
	public function __construct()
	{
		foreach(array('csrf_expire', 'csrf_token_name', 'csrf_cookie_name') as $key)
		{
			if (FALSE !== ($val = config_item($key)))
			{
				$this->{'_'.$key} = $val;
			}
		}
		
		if (config_item('cookie_prefix'))
		{
			$this->_csrf_cookie_name = config_item('cookie_prefix').$this->_csrf_cookie_name;
		}

		$this->_csrf_set_hash();

		log_message('debug', "CSRF Library Initialized");
	}
	
	public function verifica()
	{
		if (count($_POST) == 0)
		{
			return $this->csrf_set_cookie();
		}

		if ( ! isset($_POST[$this->_csrf_token_name]) OR
			 ! isset($_COOKIE[$this->_csrf_cookie_name]))
		{
			$this->csrf_show_error();
		}

		if ($_POST[$this->_csrf_token_name] != $_COOKIE[$this->_csrf_cookie_name])
		{
			$this->csrf_show_error();
		}
		
		if ( ! isset(''))
		
		unset($_POST[$this->_csrf_token_name]);

		// Nothing should last forever
		unset($_COOKIE[$this->_csrf_cookie_name]);
		$this->_csrf_set_hash();
		$this->csrf_set_cookie();

		log_message('debug', "CSRF token verified ");

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Cross Site Request Forgery Protection Cookie
	 *
	 * @return	object
	 */
	public function csrf_set_cookie()
	{
		$expire = time() + $this->_csrf_expire;
		$secure_cookie = (config_item('cookie_secure') === TRUE) ? 1 : 0;

		if ($secure_cookie)
		{
			$req = isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : FALSE;

			if ( ! $req OR $req == 'off')
			{
				return FALSE;
			}
		}

		setcookie($this->_csrf_cookie_name, $this->_csrf_hash, $expire, config_item('cookie_path'), config_item('cookie_domain'), $secure_cookie);

		log_message('debug', "CRSF cookie Set");

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Show CSRF Error
	 *
	 * @return	void
	 */
	public function csrf_show_error()
	{
		show_error('The action you have requested is not allowed.');
	}

	// --------------------------------------------------------------------

	/**
	 * Get CSRF Hash
	 *
	 * Getter Method
	 *
	 * @return 	string 	self::_csrf_hash
	 */
	public function get_csrf_hash()
	{
		return $this->_csrf_hash;
	}

	// --------------------------------------------------------------------

	/**
	 * Get CSRF Token Name
	 *
	 * Getter Method
	 *
	 * @return 	string 	self::csrf_token_name
	 */
	public function get_csrf_token_name()
	{
		return $this->_csrf_token_name;
	}

	// --------------------------------------------------------------------

	/**
	 * Set Cross Site Request Forgery Protection Cookie
	 *
	 * @return	string
	 */
	protected function _csrf_set_hash()
	{
		if ($this->_csrf_hash == '')
		{
			// If the cookie exists we will use it's value.
			// We don't necessarily want to regenerate it with
			// each page load since a page could contain embedded
			// sub-pages causing this feature to fail
			if (isset($_COOKIE[$this->_csrf_cookie_name]) &&
				preg_match('#^[0-9a-f]{32}$#iS', $_COOKIE[$this->_csrf_cookie_name]) === 1)
			{
				return $this->_csrf_hash = $_COOKIE[$this->_csrf_cookie_name];
			}

			return $this->_csrf_hash = md5(uniqid(rand(), TRUE));
		}

		return $this->_csrf_hash;
	}

}