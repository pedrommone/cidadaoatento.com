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

class Assets extends CI_Controller {
	public function css() {
		$this->load->driver('minify');
		
		$files = array(
			'/home/cidadaoatento/www/mapa/web-dir/css/resets.css',
			'/home/cidadaoatento/www/mapa/web-dir/css/jqueryUI-desktop.css.css',
			'/home/cidadaoatento/www/mapa/web-dir/css/desktop.css',
			'/home/cidadaoatento/www/mapa/web-dir/css/buttons.css',
			'/home/cidadaoatento/www/mapa/web-dir/css/rcarousel.css'
		);
		
		foreach ($files as $file)
			echo $this->minify->css->min($file, 'css');
	}
}

/* End of file assets.php */
/* Location: ./application/controllers/assets.php */