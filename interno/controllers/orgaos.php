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

class Orgaos extends CI_Controller {

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
		$this->load->library('form_validation');		
		
		$regras = array(
				array(
                    'field'   => 'nome', 
                    'label'   => 'Nome', 
               		'rules'   => 'required|min_length[5]|max_length[45]'
                ),
               	array(
                    'field'   => 'sigla', 
                    'label'   => 'Sigla', 
                    'rules'   => 'required|min_length[2]|max_length[45]'
                ),
                array(
                    'field'   => 'email', 
                    'label'   => 'Email', 
                    'rules'   => 'required|min_length[10]|valid_email'
                ),
				array(
                    'field'   => 'minimo_apoios', 
                    'label'   => 'Minimo de apoios', 
                    'rules'   => 'required|integer'
                )
        );
		
		$this->form_validation->set_rules($regras);
		
		if ($this->form_validation->run()) {
			$this->load->model('Orgaos_model');
			
			$nome 			= $this->input->post('nome');
			$sigla 			= $this->input->post('sigla');
			$email 			= $this->input->post('email');
			$minimo_apoios 	= $this->input->post('minimo_apoios');
			
			$this->Orgaos_model->add($nome, $sigla, $email, $minimo_apoios);

			montaPagina('/orgaos/sucesso', $this->dados);
		} else {
			montaPagina('/orgaos/cadastrar', $this->dados);
		}
	}
	
	public function listar($offset = null, $limit = 15) {
		$this->load->model('Orgaos_model');
		$this->load->library('pagination');
		
		$paginacao = array(
			'base_url'			=> 'http://interno.cidadaoatento.com/orgaos/listar',
			'total_rows'		=> $this->Orgaos_model->num_rows(),
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
		
		$this->dados['dados'] = $this->Orgaos_model->get($offset, $limit);
		$this->dados['pag']	  = $this->pagination->create_links();
		
		montaPagina('/orgaos/listar', $this->dados);
	}

	public function editar($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {		
			$this->load->library('form_validation');
			
			$regras = array(
					array(
	                    'field'   => 'nome', 
	                    'label'   => 'Nome', 
	               		'rules'   => 'required|min_length[5]|max_length[45]'
	                ),
	               	array(
	                    'field'   => 'sigla', 
	                    'label'   => 'Sigla', 
	                    'rules'   => 'required|min_length[2]|max_length[45]'
	                ),
	                array(
	                    'field'   => 'email', 
	                    'label'   => 'Email', 
	                    'rules'   => 'required|min_length[10]|valid_email'
	                ),
					array(
	                    'field'   => 'minimo_apoios', 
	                    'label'   => 'Minimo de apoios', 
	                    'rules'   => 'required|integer'
	                )
	        );
				
			$this->form_validation->set_rules($regras);
			$this->load->model('Orgaos_model');
			$this->dados['d'] = $this->Orgaos_model->get_by_codigo($codigo);
			
			if ($this->form_validation->run()) {
				$dados = array(
					'nome' 			=> $this->input->post('nome'),
					'sigla'			=> $this->input->post('sigla'),
					'email'			=> $this->input->post('email'),
					'minimo_apoios'	=> $this->input->post('minimo_apoios')
				);
				
				$this->Orgaos_model->update($dados, $codigo);			
				montaPagina('/orgaos/sucesso_editar', $this->dados);	
			} else {				
				montaPagina('/orgaos/editar', $this->dados);
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
				$this->load->model('Orgaos_model');
				$this->Orgaos_model->delete($codigo);
				montaPagina('/orgaos/sucesso_apagar', $this->dados);
			} else {
				montaPagina('/orgaos/apagar', $this->dados);
			}
		}
	}
	
	public function ver($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {
			$this->load->model('Orgaos_model');
			$this->dados['d'] =  $this->Orgaos_model->get_by_codigo($codigo);
			
			if (empty($this->dados['d']))
				montaPagina('/orgaos/nao_encontrado', $this->dados);
			else
				montaPagina('/orgaos/ver', $this->dados);
		}
	}

	public function procurar() {
		$this->load->library('form_validation');
		
		montaPagina('/orgaos/procurar', $this->dados);
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
		
		$this->load->model('Orgaos_model');
		
		if ($this->form_validation->run()) {
			$codigo = $this->input->post('codigo');
			$dados = $this->Orgaos_model->get_by_codigo($codigo);
			
			if (empty($dados))
				montaPagina('/orgaos/nao_encontrado', $this->dados);
			else
				redirect('/orgaos/ver/' . $codigo);
		} else {
			montaPagina('/orgaos/procurar', $this->dados);
		}		
	}
	
	public function avancada($offset = 0, $limit = 15) {
		$this->load->library('form_validation');
		
		$regras = array(
			array(
				'field' => 'nome',
				'label' => 'Nome',
				'rules' => 'min_length[1]'
			),
			array(
				'field' => 'sigla',
				'label' => 'Sigla',
				'rules' => 'min_length[1]'
			)
		);
		
		$this->form_validation->set_rules($regras);
		
		$this->load->model('Orgaos_model');
		
		$param = array();
		
		if ($this->form_validation->run()) {
			$nome 	= $this->input->post('nome');
			$sigla 	= $this->input->post('sigla');
			
			if (! empty($nome))
				$param['nome'] = $nome;
			if (! empty($sigla))
				$param['sigla'] = $sigla;
			
			$this->dados['dados'] = $this->Orgaos_model->get_by_param($param, $offset, $limit);
			
			if (empty($this->dados['dados']))
				montaPagina('/orgaos/nao_encontrado', $this->dados);
			else {
				$this->load->library('pagination');
		
				$paginacao = array(
					'base_url'			=> 'http://interno.cidadaoatento.com/orgaos/listar',
					'total_rows'		=> $this->Orgaos_model->num_rows(),
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
				
				$this->dados['pag']	= $this->pagination->create_links();
		
				montaPagina('/orgaos/listar', $this->dados);
			}
		} else {
			montaPagina('/orgaos/procurar', $this->dados);
		}
	}

	public function senha($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {	
			$this->load->library(array('encrypt', 'form_validation'));
			
			$regras = array(
					array(
	                    'field'   => 'senha', 
	                    'label'   => 'Senha', 
	                    'rules'   => 'required|min_length[10]|max_length[100]'
	                ),
					array(
	                    'field'   => 'senha2', 
	                    'label'   => 'Repita a senha', 
	                    'rules'   => 'required|min_length[10]|max_length[100]|matches[senha]'
	                )
	        );
			
			$this->form_validation->set_rules($regras);
			
			$this->load->model('Orgaos_model');
			
			if ($this->form_validation->run()) {
				$this->load->model('Orgaos_model');
				
				$senha = $this->input->post('senha');				
				$dados = $this->Orgaos_model->get_by_codigo($codigo);
				$this->dados['codigo'] = $codigo;
				
				$conteudo = array(
					'nome'	=> $this->dados['nome'],
					'login'	=> $dados->codigo,
					'senha'	=> $senha
				);
				
				$config = array(
					'protocol'	=> 'mail',
					'wordwrap'	=> false,
					'mailtype'	=> 'html'
				);
				
				$this->load->library('email', $config);
				
				$this->email->from('cidadaoatento@cidadaoatento.com', 'Cidadão Atento');
				$this->email->to($dados->email);
				$this->email->subject('Senha alterada');
				$this->email->message($this->load->view('/emails/senha_suo', $conteudo, true));
				
				$this->email->send();
				
				$this->Orgaos_model->set_senha_by_codigo($this->encrypt->sha1($senha), $codigo);			
						
				montaPagina('/orgaos/sucesso_senha', $this->dados);
			} else {
				montaPagina('/orgaos/senha', $this->dados);
			}
		}
	}

	public function index() {
		montaPagina('/orgaos/index', $this->dados);
	}
}

/* End of file orgaos.php */
/* Location: ./application/controllers/orgaos.php */