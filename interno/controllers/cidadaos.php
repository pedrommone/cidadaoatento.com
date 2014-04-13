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

class Cidadaos extends CI_Controller {

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
	
	public function listar($offset = null, $limit = 15) {
		$this->load->model('Cidadaos_model');
		$this->load->library('pagination');
		
		$paginacao = array(
			'base_url'			=> 'http://interno.cidadaoatento.com/cidadaos/listar',
			'total_rows'		=> $this->Cidadaos_model->num_rows(),
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
		
		$this->dados['pag']	  = $this->pagination->create_links();
		$this->dados['dados'] = $this->Cidadaos_model->get($offset, $limit);
		
		montaPagina('/cidadaos/listar', $this->dados);
	}
	
	public function ver($cpf = null) {
		if (is_null($cpf)) {
			show_404();
		} else {
			$this->load->model('Cidadaos_model');
			$this->dados['d'] =  $this->Cidadaos_model->get_by_cpf($cpf);
			
			if (empty($this->dados['d']))
				montaPagina('/cidadaos/nao_encontrado', $this->dados);
			else
				montaPagina('/cidadaos/ver', $this->dados);
		}
	}
	
	public function denuncias($cpf = null, $offset = 0, $limit = 15) {
		if (is_null($cpf)) {
			show_404();
		} else {
			$this->load->model('Denuncias_model');
			$this->load->library('pagination');
			
			$paginacao = array(
				'base_url'			=> 'http://interno.cidadaoatento.com/cidadaos/listar/' . $cpf . '/',
				'total_rows'		=> $this->Denuncias_model->num_rows_by_cpf($cpf),
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
		
			$this->dados['pag']	  = $this->pagination->create_links();
			$this->dados['dados'] = $this->Denuncias_model->get_by_cpf($cpf, $offset, $limit);
			
			montaPagina('/denuncias/listar', $this->dados);
		}
	}

	public function procurar() {
		$this->load->library('form_validation');
		
		montaPagina('/cidadaos/procurar', $this->dados);
	}
	
	public function avancada($offset = 0, $limit = 15) {
		$this->load->library('form_validation');
		
		$regras = array(
			array(
				'field' => 'cpf',
				'label' => 'CPF',
				'rules' => 'min_length[1]'
			),
			array(
				'field' => 'telefone',
				'label' => 'Telefone',
				'rules' => 'min_length[1]'
			)
		);
		
		$this->form_validation->set_rules($regras);
		
		$this->load->model('Cidadaos_model');
		
		$param = array();
		
		if ($this->form_validation->run()) {
			$nome 	= $this->input->post('nome');
			$sigla 	= $this->input->post('sigla');
			
			if (! empty($nome))
				$param['nome'] = $nome;
			if (! empty($sigla))
				$param['sigla'] = $sigla;
			
			$this->dados['dados'] = $this->Cidadaos_model->get_by_param($param, $offset, $limit);
			
			if (empty($this->dados['dados']))
				montaPagina('/orgaos/nao_encontrado', $this->dados);
			else
				montaPagina('/cidadaos/listar', $this->dados);
		} else {
			montaPagina('/cidadaos/procurar', $this->dados);
		}
	}

	public function apoios($cpf = null) {
		if (is_null($cpf))
			show_404();
		else {
			$this->load->model('Apoios_model');
			
			$this->load->model('Apoios_model');
			$this->dados['dados'] = $this->Apoios_model->get_by_cpf($cpf);
			montaPagina('/apoios/listar', $this->dados);
		}
	}
	
	public function reportes($cpf = null) {
		if (is_null($cpf))
			show_404();
		else {
			$this->load->model('Reportes_model');
			
			$this->load->model('Reportes_model');
			$this->dados['dados'] = $this->Reportes_model->get_by_cpf($cpf);
			montaPagina('/reportes/listar', $this->dados);
		}
	}
	
	public function bloquear($cpf = null) {
		if (is_null($cpf)) {
			show_404();
		} else {
			$sim = $this->input->post('sim');
			$this->dados['cpf'] = $cpf;
			
			if (! empty($sim)) {
				$this->load->model('Cidadaos_model');
				$this->Cidadaos_model->set_bloqueado_by_cpf($cpf);
				montaPagina('/cidadaos/sucesso_bloquear', $this->dados);
			} else {
				montaPagina('/cidadaos/bloquear', $this->dados);
			}
		}
	}
	
	public function desbloquear($cpf = null) {
		if (is_null($cpf)) {
			show_404();
		} else {
			$sim = $this->input->post('sim');
			$this->dados['cpf'] = $cpf;
			
			if (! empty($sim)) {
				$this->load->model('Cidadaos_model');
				$this->Cidadaos_model->set_desbloqueado_by_cpf($cpf);
				montaPagina('/cidadaos/sucesso_desbloquear', $this->dados);
			} else {
				montaPagina('/cidadaos/desbloquear', $this->dados);
			}
		}
	}

	public function index() {
		montaPagina('/cidadaos/index', $this->dados);
	}
}

/* End of file orgaos.php */
/* Location: ./application/controllers/orgaos.php */