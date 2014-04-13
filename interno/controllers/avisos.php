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

class Avisos extends CI_Controller {

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

	public function novo() {
		$this->load->library('form_validation');		
		
		$regras = array(
	    		array(
                     'field'   => 'aviso', 
                     'label'   => 'Aviso', 
                     'rules'   => 'required|min_length[10]|max_length[255]'
	    		),
				array(
                     'field'   => 'periodo', 
                     'label'   => 'Periodo', 
                     'rules'   => 'required|min_length[1]|integer'
	            ),
				array(
                     'field'   => 'tipo', 
                     'label'   => 'Tipo', 
                     'rules'   => 'required'
                  )
            );
		
		$this->form_validation->set_rules($regras);
		
		if ($this->form_validation->run()) {
			$this->load->model('Avisos_model');
			
			$aviso	 	= $this->input->post('aviso');
			$periodo 	= $this->input->post('periodo');
			$tipo		= $this->input->post('tipo');
			$interno	= ($this->input->post('interno') == 'sim' ? 'S' : 'N');
			$sup		= ($this->input->post('sup') == 'sim' ? 'S' : 'N');
			$suo		= ($this->input->post('suo') == 'sim' ? 'S' : 'N');
			$moderador 	= $this->session->userdata('moderador');
			
			$this->Avisos_model->add($aviso, $periodo, $tipo, $moderador, $interno, $sup, $suo);
						
			$config = array(
				'protocol'	=> 'mail',
				'wordwrap'	=> false,
				'mailtype'	=> 'html'
			);
			
			$this->load->library('email', $config);
			
			$dados = array(
				'tipo'	=> $tipo,
				'aviso'	=> $aviso
			);
		
			if ($sup == 'S') {
				$this->load->model('Prefeituras_model');
				
				$prefeituras = $this->Prefeituras_model->get_by_avisos();
				
				foreach ($prefeituras as $p) {
					$this->email->from('cidadaoatento@cidadaoatento.com', 'Cidadão Atento');
					$this->email->to($p->email);
					$this->email->subject('Aviso');
					$this->email->message($this->load->view('/emails/aviso', $dados, true));
					
					$this->email->send();
				}
			}
			
			if ($suo == 'S') {
				$this->load->model('Orgaos_model');
				
				$orgaos = $this->Orgaos_model->get_by_avisos();
				
				foreach ($orgaos as $p) {
					$this->email->from('cidadaoatento@cidadaoatento.com', 'Cidadão Atento');
					$this->email->to($p->email);
					$this->email->subject('Aviso');
					$this->email->message($this->load->view('/emails/aviso', $dados, true));
					
					$this->email->send();
				}
			}

			if ($interno == 'S') {
				$this->load->model('Moderadores_model');
				
				$moderadores = $this->Moderadores_model->get_by_avisos();
				
				foreach ($moderadores as $p) {
					$this->email->from('cidadaoatento@cidadaoatento.com', 'Cidadão Atento');
					$this->email->to($p->email);
					$this->email->subject('Aviso');
					$this->email->message($this->load->view('/emails/aviso', $dados, true));
					
					$this->email->send();
				}
			}
			
			$this->dados['cod'] = $this->db->insert_id();
			montaPagina('/avisos/sucesso', $this->dados);
		} else {			
			montaPagina('/avisos/novo', $this->dados);
		}		
	}
	
	public function listar($offset = null, $limit = 15) {
		$this->load->model('Avisos_model');
		$this->load->library('pagination');
		
		$paginacao = array(
			'base_url'			=> 'http://interno.cidadaoatento.com/aviso/listar',
			'total_rows'		=> $this->Avisos_model->num_rows(),
			'per_page'			=> $limit,
			'num_links'			=> 10,
			'full_tag_open'		=> '<div class="pagination"><ul>',
			'full_tag_close'	=> '</ul></div>',
			'first_link'		=> 'Primeiro',
			'first_tag_open'	=> '<li>',
			'first_tag_close'	=> '</li>',
			'last_link'			=> 'Último',
			'last_tag_open'		=> '<li>',
			'last_tag_close'	=> '</li>',
			'next_tag_open'		=> '<li>',
			'next_tag_close'	=> '</li>',
			'prev_tag_open'		=> '<li>',
			'prev_tag_close'	=> '<li>',
			'cur_tag_open'		=> '<li class="active"><a href="#">',
			'cur_tag_close'		=> '</a><li/>',
			'num_tag_open'		=> '<li>',
			'num_tag_close'		=> '<li/>'
		);
		
		$this->dados['posts'] = $this->Avisos_model->get_all($offset, $limit);
		$this->dados['pag']	  = $this->pagination->create_links();
		
		montaPagina('/avisos/listar', $this->dados);
	}

	public function editar($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {		
			$this->load->library('form_validation');
			
			$regras = array(
	    		array(
                     'field'   => 'aviso', 
                     'label'   => 'Aviso', 
                     'rules'   => 'required|min_length[10]|max_length[255]'
	    		),
				array(
                     'field'   => 'periodo', 
                     'label'   => 'Periodo', 
                     'rules'   => 'required|min_length[1]|integer'
	            ),
				array(
                     'field'   => 'tipo', 
                     'label'   => 'Tipo', 
                     'rules'   => 'required'
                  )
            );
				
			$this->form_validation->set_rules($regras);
			$this->load->model('Avisos_model');
			$this->dados['post'] = $this->Avisos_model->get_by_codigo($codigo);
			
			if ($this->form_validation->run()) {
				$dados = array(
					'aviso'		=> $this->input->post('aviso'),
					'periodo' 	=> $this->input->post('periodo'),
					'tipo'		=> $this->input->post('tipo'),
					'interno'	=> ($this->input->post('interno') == 'sim' ? 'S' : 'N'),
					'sup'		=> ($this->input->post('sup') == 'sim' ? 'S' : 'N'),
					'suo'		=> ($this->input->post('suo') == 'sim' ? 'S' : 'N')
				);
				
				$this->Avisos_model->update($dados, $codigo);			
				montaPagina('/avisos/sucesso_editar', $this->dados);	
			} else {				
				montaPagina('/avisos/editar', $this->dados);
			}
		}
	}
	
	public function apagar($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {
			$sim = $this->input->post('sim');
			$this->dados['codigo'] = $codigo;
			
			if (! empty($sim)) {
				$this->load->model('Avisos_model');
				$this->Avisos_model->delete($codigo);
				montaPagina('/avisos/sucesso_apagar', $this->dados);
			} else {
				montaPagina('/avisos/apagar', $this->dados);
			}
		}
	}
	
	public function ver($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {
			$this->load->model('Avisos_model');
			$this->dados['p'] =  $this->Avisos_model->get_by_codigo($codigo);
			
			if (empty($this->dados['p']))
				montaPagina('/avisos/nao_encontrado', $this->dados);
			else
				montaPagina('/avisos/ver', $this->dados);
		}
	}

	public function index() {
		montaPagina('/avisos/index', $this->dados);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */