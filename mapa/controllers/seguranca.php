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

class Seguranca extends CI_Controller {
	
	public function get_new() {
		$json = array('token' => $this->security->get_csrf_hash());
		
		$this->output->set_content_type('application/json')
    				 ->set_output(json_encode($json));	
	}
	
	public function test() {
		echo $this->security->get_csrf_token_name();
	}
}

/* End of file seguranca.php */
/* Location: ./application/controllers/seguranca.php */