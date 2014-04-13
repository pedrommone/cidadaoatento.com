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

class Denuncias extends CI_Controller {

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
	
	public function procurar() {
		$this->load->model('Problemas_model');		
		$this->dados['problemas'] = $this->Problemas_model->get_all();
		
		montaPagina('/denuncias/procurar', $this->dados);
	}
	
	public function ver($codigo = null) {
		if (is_null($codigo))
			show_404();
		else {
			$this->load->model('Denuncias_model');
			
			$this->dados['d'] = $this->Denuncias_model->get_by_codigo($codigo);
				
			if (empty($this->dados['d']))
				montaPagina('/denuncias/nao_encontrado', $this->dados);
			else
				montaPagina('/denuncias/ver', $this->dados);
		}
	}
	
	public function simples() {
		$this->load->library('form_validation');
		
		$regras = array(
        	array(
            	'field'	=> 'codigo', 
                'label'	=> 'Codigo', 
                'rules'	=> 'required|integer'
        	)
        );			
		
		$this->form_validation->set_rules($regras);
		
		$this->load->model('Denuncias_model');
		
		if ($this->form_validation->run()) {
			$codigo = $this->input->post('codigo');
			$dados = $this->Denuncias_model->get_by_codigo($codigo);
			
			if (empty($dados))
				montaPagina('/denuncias/nao_encontrado', $this->dados);
			else
				redirect('/denuncias/ver/' . $codigo);
		} else {
			montaPagina('/denuncias/procurar_validadores', $this->dados);
		}
	}

	public function avancada() {
		$this->load->library('form_validation');
		
		$regras = array(
			array(
				'field' => 'solucionada',
				'label' => 'Solucionada',
				'rules' => 'required'
			),
			array(
				'field' => 'invalida',
				'label' => 'Inválida',
				'rules' => 'required'
			),
			array(
				'field' => 'problema',
				'label' => 'Tipo de problema',
				'rules' => 'required'
			)
		);
		
		$this->form_validation->set_rules($regras);
		
		$this->load->model('Denuncias_model');
		
		$param = array();
		
		if ($this->form_validation->run()) {
			$municipio 		= $this->input->post('cidade');
			$invalida  		= $this->input->post('invalida');
			$solucionada 	= $this->input->post('solucionada');
			$problema 		= $this->input->post('problema');
			
			if (! empty($municipio))
				$param['municipio'] = $municipio;
			if ($invalida != "T")
				$param['invalido'] = $invalida;
			if ($solucionada != "T")
				$param['solucionado'] = $solucionada;
			if ($problema != "T")
				$param['tbl_tipo_problemas.descricao'] = $problema;
			
			$this->dados['dados'] = $this->Denuncias_model->get_by_param($param);
			
			if (empty($this->dados['dados']))
				montaPagina('/denuncias/nao_encontrado', $this->dados);
			else
				montaPagina('/denuncias/listar', $this->dados);
		} else {
			montaPagina('/denuncias/procurar_validadores', $this->dados);
		}
	}

	public function verificar($codigo = null) {
		if (is_null($codigo)) {			
			$this->load->library('form_validation');
		
			$regras = array(
	        	array(
	            	'field'	=> 'codigo', 
	                'label'	=> 'Codigo', 
	                'rules'	=> 'required|integer'
	        	)
	        );
			
			$this->form_validation->set_rules($regras);
			
			$this->load->model('Denuncias_model');
			
			if ($this->form_validation->run()) {
				$codigo = $this->input->post('codigo');
				$dados = $this->Denuncias_model->get_by_codigo($codigo);
				
				if (empty($dados))
					montaPagina('/denuncias/nao_encontrado', $this->dados);
				else
					redirect('/denuncias/verificar/' . $codigo);
			} else {
				montaPagina('/denuncias/verificar_form', $this->dados);
			}
		} else {
			$sim = $this->input->post('sim');
			$this->dados['codigo'] = $codigo;
			
			if (! empty($sim)) {
				$this->load->model('Denuncias_model');
				$this->Denuncias_model->set_verificada_by_codigo($codigo);
				montaPagina('/denuncias/sucesso_verificar', $this->dados);
			} else {
				montaPagina('/denuncias/verificar', $this->dados);
			}
		}
	}

	public function naoverificar($codigo = null) {
		if (is_null($codigo)) {			
			$this->load->library('form_validation');
		
			$regras = array(
	        	array(
	            	'field'	=> 'codigo', 
	                'label'	=> 'Codigo', 
	                'rules'	=> 'required|integer'
	        	)
	        );
			
			$this->form_validation->set_rules($regras);
			
			$this->load->model('Denuncias_model');
			
			if ($this->form_validation->run()) {
				$codigo = $this->input->post('codigo');
				$dados = $this->Denuncias_model->get_by_codigo($codigo);
				
				if (empty($dados))
					montaPagina('/denuncias/nao_encontrado', $this->dados);
				else
					redirect('/denuncias/naoverificar/' . $codigo);
			} else {
				montaPagina('/denuncias/naoverificar_form', $this->dados);
			}
		} else {
			$sim = $this->input->post('sim');
			$this->dados['codigo'] = $codigo;
			
			if (! empty($sim)) {
				$this->load->model('Denuncias_model');
				$this->Denuncias_model->set_naoverificada_by_codigo($codigo);
				montaPagina('/denuncias/sucesso_naoverificar', $this->dados);
			} else {
				montaPagina('/denuncias/naoverificar', $this->dados);
			}
		}
	}

	public function invalidar($codigo = null) {
		if (is_null($codigo)) {			
			$this->load->library('form_validation');
		
			$regras = array(
	        	array(
	            	'field'	=> 'codigo', 
	                'label'	=> 'Codigo', 
	                'rules'	=> 'required|integer'
	        	)
	        );
			
			$this->form_validation->set_rules($regras);
			
			$this->load->model('Denuncias_model');
			
			if ($this->form_validation->run()) {
				$codigo = $this->input->post('codigo');
				$dados = $this->Denuncias_model->get_by_codigo($codigo);
				
				if (empty($dados))
					montaPagina('/denuncias/nao_encontrado', $this->dados);
				else
					redirect('/denuncias/invalidar/' . $codigo);
			} else {
				montaPagina('/denuncias/invalidar_form', $this->dados);
			}
		} else {
			$sim = $this->input->post('sim');
			$this->dados['codigo'] = $codigo;
			
			if (! empty($sim)) {
				$this->load->model('Denuncias_model');
				$this->Denuncias_model->set_invalida_by_codigo($codigo);
				$this->Denuncias_model->set_verificada_by_codigo($codigo);
				montaPagina('/denuncias/sucesso_invalidar', $this->dados);
			} else {
				montaPagina('/denuncias/invalidar', $this->dados);
			}
		}
	}

	public function validar($codigo = null) {
		if (is_null($codigo)) {			
			$this->load->library('form_validation');
		
			$regras = array(
	        	array(
	            	'field'	=> 'codigo', 
	                'label'	=> 'Codigo', 
	                'rules'	=> 'required|integer'
	        	)
	        );
			
			$this->form_validation->set_rules($regras);
			
			$this->load->model('Denuncias_model');
			
			if ($this->form_validation->run()) {
				$codigo = $this->input->post('codigo');
				$dados = $this->Denuncias_model->get_by_codigo($codigo);
				
				if (empty($dados))
					montaPagina('/denuncias/nao_encontrado', $this->dados);
				else
					redirect('/denuncias/validar/' . $codigo);
			} else {
				montaPagina('/denuncias/validar_form', $this->dados);
			}
		} else {
			$sim = $this->input->post('sim');
			$this->dados['codigo'] = $codigo;
			
			if (! empty($sim)) {
				$this->load->model('Denuncias_model');
				$this->Denuncias_model->set_valida_by_codigo($codigo);
				montaPagina('/denuncias/sucesso_validar', $this->dados);
			} else {
				montaPagina('/denuncias/validar', $this->dados);
			}
		}
	}
	
	public function listar($offset = null, $limit = 15) {
		$this->load->model('Denuncias_model');
		$this->load->library('pagination');
		
		$paginacao = array(
			'base_url'			=> 'http://interno.cidadaoatento.com/denuncias/listar',
			'total_rows'		=> $this->Denuncias_model->num_rows(),
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
		
		$this->pagination->initialize($paginacao); 
		
		$this->dados['dados'] = $this->Denuncias_model->get($offset, $limit);
		$this->dados['pag']	  = $this->pagination->create_links();
		
		montaPagina('/denuncias/listar', $this->dados);
	}

	public function index() {
		montaPagina('/denuncias/index', $this->dados);
	}
}

/* End of file denuncias.php */
/* Location: ./application/controllers/denuncias.php */