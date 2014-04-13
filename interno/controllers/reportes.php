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

class Reportes extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if (! $this->session->userdata('logado'))
			redirect('/login');
		
		$this->output->enable_profiler(FALSE);
		
		$this->load->model('Avisos_model');
		
		$this->dados = array(
			'avisos'	=> $this->Avisos_model->get_aviso(),
			'nome'		=> $this->session->userdata('nome'),
			'codigo'	=> $this->session->userdata('moderador')
		);
		
		$this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT"); 
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); 
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false); 
		$this->output->set_header("Pragma: no-cache");
	}
	
	public function novos() {
		$this->load->model('Reportes_model');
		$this->dados['dados'] = $this->Reportes_model->novos();
		
		montaPagina('/reportes/listar_novos', $this->dados);
	}
	
	public function solucionar($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {
			$sim = $this->input->post('sim');
			$this->dados['codigo'] = $codigo;
			
			if (! empty($sim)) {
				$this->load->model('Reportes_model');
				$this->Reportes_model->set_solucionado_by_codigo($codigo);
				montaPagina('/reportes/sucesso_solucionar', $this->dados);
			} else {
				montaPagina('/reportes/solucionar', $this->dados);
			}
		}
	}

	public function ver($codigo = null) {
		if (is_null($codigo))
			show_404();
		else {
			$this->load->model('Reportes_model');
			
			$this->dados['d'] = $this->Reportes_model->get_by_codigo($codigo);
				
			if (empty($this->dados['d']))
				montaPagina('/reportes/nao_encontrado', $this->dados);
			else
				montaPagina('/reportes/ver', $this->dados);
		}
	}
}

/* End of file reportes.php */
/* Location: ./application/controllers/reportes.php */