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


class Mapa extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if (! $this->session->userdata('logado'))
			redirect('/login');
		
		$this->output->enable_profiler(FALSE);
		
		$this->load->model('Avisos_model');
		
		$this->dados = array(
			'codigo'		=> $this->session->userdata('codigo'),
			'uf'			=> $this->session->userdata('uf'),
			'municipio'		=> $this->session->userdata('municipio'),
			'ultimo_login'	=> $this->session->userdata('ultimo_login'),
			'avisos'		=> $this->Avisos_model->get_aviso()
		);
	}
	
	public function geral() {
		montaPagina('/mapa/geral', $this->dados);
	}
}

/* End of file mapa.php */
/* Location: ./application/controllers/mapa.php */