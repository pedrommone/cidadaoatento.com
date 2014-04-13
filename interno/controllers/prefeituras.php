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

class Prefeituras extends CI_Controller {

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

	public function cadastrar() {
		$this->load->library(array('encrypt', 'form_validation'));
		
		$regras = array(
				array(
                    'field'   => 'municipio', 
                    'label'   => 'Município', 
               		'rules'   => 'required|min_length[5]|max_length[50]'
                ),
               	array(
                    'field'   => 'uf', 
                    'label'   => 'UF', 
                    'rules'   => 'required|min_length[2]|max_length[2]'
                ),
                array(
                    'field'   => 'senha', 
                    'label'   => 'Senha', 
                    'rules'   => 'required|max_length[50]'
                ),
				array(
                    'field'   => 'confirmar_senha', 
                    'label'   => 'Confirmar senha', 
                    'rules'   => 'required|max_length[50]|matches[senha]'
                ),
                array(
                    'field'   => 'email', 
                    'label'   => 'E-mail', 
                    'rules'   => 'valid_email'
                )
        );
		
		$this->form_validation->set_rules($regras);
		
		if ($this->form_validation->run()) {
			$this->load->model('Prefeituras_model');
			
			$municipio 	= $this->input->post('municipio');
			$uf 		= $this->input->post('uf');
			$senha 		= $this->encrypt->sha1($this->input->post('senha'));
			$email		= $this->input->post('email');
			
			$this->Prefeituras_model->add($municipio, $uf, $senha, $email);

			montaPagina('/prefeituras/sucesso', $this->dados);
		} else {
			montaPagina('/prefeituras/cadastrar', $this->dados);
		}		
	}
	
	public function listar($offset = null, $limit = 15) {
		$this->load->model('Prefeituras_model');
		$this->load->library('pagination');
		
		$paginacao = array(
			'base_url'			=> 'http://interno.cidadaoatento.com/prefeituras/listar',
			'total_rows'		=> $this->Prefeituras_model->num_rows(),
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
		
		$this->dados['dados'] = $this->Prefeituras_model->get($offset, $limit);
		$this->dados['pag']	  = $this->pagination->create_links();
		
		montaPagina('/prefeituras/listar', $this->dados);
	}

	public function editar($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {		
			$this->load->library('form_validation');
			
			$regras = array(
					array(
	                    'field'   => 'municipio', 
	                    'label'   => 'Município', 
	               		'rules'   => 'required|min_length[5]|max_length[50]'
	                ),
	               	array(
	                    'field'   => 'uf', 
	                    'label'   => 'UF', 
	                    'rules'   => 'required|min_length[2]|max_length[2]'
	                ),
	                array(
	                    'field'   => 'email', 
	                    'label'   => 'E-mail', 
	                    'rules'   => 'valid_email'
	                )
	        );
				
			$this->form_validation->set_rules($regras);
			$this->load->model('Prefeituras_model');
			$this->dados['d'] = $this->Prefeituras_model->get_by_codigo($codigo);
			
			if ($this->form_validation->run()) {
				$dados = array(
					'municipio' => $this->input->post('municipio'),
					'uf'		=> $this->input->post('uf'),
					'email'		=> $this->input->post('email')
				);
				
				$this->Prefeituras_model->update($dados, $codigo);			
				montaPagina('/prefeituras/sucesso_editar', $this->dados);	
			} else {				
				montaPagina('/prefeituras/editar', $this->dados);
			}
		}
	}

	public function senha($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {		
			$this->load->library(array('form_validation', 'encrypt'));
			
			$regras = array(
					array(
	                    'field'   => 'senha', 
	                    'label'   => 'Senha', 
	               		'rules'   => 'required|min_length[5]|max_length[50]'
	                ),
	               	array(
	                    'field'   => 'repita_senha', 
	                    'label'   => 'Repita a senha', 
	                    'rules'   => 'required|min_length[2]|max_length[50]|matches[senha]'
	                )
	        );
				
			$this->form_validation->set_rules($regras);
			$this->load->model('Prefeituras_model');
			$this->dados['d'] = $this->Prefeituras_model->get_by_codigo($codigo);
			
			if ($this->form_validation->run()) {
				$dados = array(
					'senha' => $this->encrypt->sha1($this->input->post('senha'))
				);
				
				$conteudo = array(
					'nome'	=> $this->dados['nome'],
					'login'	=> $this->dados['d']->codigo,
					'senha'	=> $this->input->post('senha')
				);
				
				$config = array(
					'protocol'	=> 'mail',
					'wordwrap'	=> false,
					'mailtype'	=> 'html'
				);
				
				$this->load->library('email', $config);
				
				$this->email->from('cidadaoatento@cidadaoatento.com', 'Cidadão Atento');
				$this->email->to($this->dados['d']->email);
				$this->email->subject('Senha alterada');
				$this->email->message($this->load->view('/emails/senha_sup', $conteudo, true));
				
				$this->email->send();
				
				$this->Prefeituras_model->update($dados, $codigo);
				
				montaPagina('/prefeituras/sucesso_senha', $this->dados);	
			} else {				
				montaPagina('/prefeituras/alterar_senha', $this->dados);
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
				$this->load->model('Prefeituras_model');
				$this->Prefeituras_model->delete($codigo);
				montaPagina('/prefeituras/sucesso_apagar', $this->dados);
			} else {
				montaPagina('/prefeituras/apagar', $this->dados);
			}
		}
	}
	
	public function ver($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {
			$this->load->model('Prefeituras_model');
			$this->dados['d'] = $this->Prefeituras_model->get_by_codigo($codigo);
			
			if (empty($this->dados['d']))
				montaPagina('/prefeituras/nao_encontrado', $this->dados);
			else
				montaPagina('/prefeituras/ver', $this->dados);
		}
	}

	public function procurar() {
		$this->load->library('form_validation');
		
		montaPagina('/prefeituras/procurar', $this->dados);
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
		
		$this->load->model('Prefeituras_model');
		
		if ($this->form_validation->run()) {
			$codigo = $this->input->post('codigo');
			$dados = $this->Prefeituras_model->get_by_codigo($codigo);
			
			if (empty($dados))
				montaPagina('/prefeituras/nao_encontrado', $this->dados);
			else
				redirect('/prefeituras/ver/' . $codigo);
		} else {
			montaPagina('/prefeituras/procurar', $this->dados);
		}		
	}
	
	public function avancada($offset = 0, $limit = 15) {
		$this->load->library('form_validation');
		
		$regras = array(
			array(
				'field' => 'municipio',
				'label' => 'Município',
				'rules' => 'min_length[1]'
			),
			array(
				'field' => 'uf',
				'label' => 'UF',
				'rules' => 'min_length[1]'
			)
		);
		
		$this->form_validation->set_rules($regras);
		
		$this->load->model('Prefeituras_model');
		
		$param = array();
		
		if ($this->form_validation->run()) {
			$municipio 	= $this->input->post('municipio');
			$uf		 	= $this->input->post('uf');
			
			if (! empty($municipio))
				$param['municipio'] = $municipio;
			if (! empty($uf))
				$param['uf'] = $uf;
			
			$this->dados['dados'] = $this->Prefeituras_model->get_by_param($param, $offset, $limit);
			
			if (empty($this->dados['dados']))
				montaPagina('/prefeituras/nao_encontrado', $this->dados);
			else {
				$this->load->library('pagination');
		
				$paginacao = array(
					'base_url'			=> 'http://interno.cidadaoatento.com/prefeituras/listar',
					'total_rows'		=> $this->Prefeituras_model->num_rows(),
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
		
				montaPagina('/prefeituras/listar', $this->dados);
			}
		} else {
			montaPagina('/prefeituras/procurar', $this->dados);
		}
	}

	public function index() {
		montaPagina('/prefeituras/index', $this->dados);
	}
}

/* End of file prefeituras.php */
/* Location: ./application/controllers/prefeituras.php */