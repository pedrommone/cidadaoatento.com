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

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if (! $this->session->userdata('logado'))
			redirect('/login');
		
		$this->output->enable_profiler(FALSE);
		
		$this->load->model(array('Avisos_model', 'Tickets_model', 'Blog_model', 'Denuncias_model', 'Cidadaos_model', 'Apoios_model', 'Prefeituras_model', 'Reportes_model'));
		
		$this->dados = array(
			'nome'				=> $this->session->userdata('nome'),
			'codigo'			=> $this->session->userdata('moderador'),
			'avisos'			=> $this->Avisos_model->get_aviso(),
			'count_blog'		=> $this->Blog_model->num_rows(),
			'count_denuncias'	=> $this->Denuncias_model->num_rows(),
			'count_cidadaos'	=> $this->Cidadaos_model->num_rows(),
			'count_apoios'		=> $this->Apoios_model->num_rows(),
			'count_prefeituras'	=> $this->Prefeituras_model->num_rows(),
			'count_reportes'	=> $this->Reportes_model->num_rows(),
			'count_tickets'		=> $this->Tickets_model->num_rows()
		);
		
		$this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT"); 
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); 
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false); 
		$this->output->set_header("Pragma: no-cache");
	}
	
	public function index() {
		$this->dados['reportes'] 	= $this->Reportes_model->novos();
		$this->dados['tickets']	 	= $this->Tickets_model->novos();
		$this->dados['meusTickets']	= $this->Tickets_model->get_by_moderador($this->session->userdata('moderador'));
		montaPagina('dashboard/index', $this->dados);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */