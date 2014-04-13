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

class Moderadores extends CI_Controller {

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
                    'field'   => 'nome', 
                    'label'   => 'Nome', 
               		'rules'   => 'required|min_length[5]|max_length[100]'
                ),
               	array(
                    'field'   => 'email', 
                    'label'   => 'Email', 
                    'rules'   => 'required|min_length[2]|max_length[255]|valid_email|is_unique[tbl_moderadores.email]'
                ),
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
		
		if ($this->form_validation->run()) {
			$this->load->model('Moderadores_model');
			
			$nome 	= $this->input->post('nome');
			$email 	= $this->input->post('email');
			$senha 	= $this->input->post('senha');
			
			$config = array(
				'protocol'	=> 'mail',
				'wordwrap'	=> false,
				'mailtype'	=> 'html'
			);
			
			$this->load->library('email', $config);
			
			$dados = array(
				'nome'	=> $nome,
				'email'	=> $email,
				'senha' => $senha
			);
			
			$this->Moderadores_model->add($nome, $email, $this->encrypt->sha1($senha));
			
			$this->email->from('cidadaoatento@cidadaoatento.com', 'Cidadão Atento');
			$this->email->to($p->email);
			$this->email->subject('Novo login');
			$this->email->message($this->load->view('/emails/novo_moderador', $dados, true));
			
			$this->email->send();
			
			montaPagina('/moderadores/sucesso_adicionar', $this->dados);
		} else {
			montaPagina('/moderadores/cadastrar', $this->dados);
		}		
	}

	public function editar($codigo) {
		if (is_null($codigo)) {
			show_404();
		} else {	
			$this->load->library('form_validation');
			
			$regras = array(
					array(
	                    'field'   => 'nome', 
	                    'label'   => 'Nome', 
	               		'rules'   => 'required|min_length[5]|max_length[100]'
	                ),
	               	array(
	                    'field'   => 'email', 
	                    'label'   => 'Email', 
	                    'rules'   => 'required|min_length[2]|max_length[255]|valid_email'
	                )
	        );
			
			$this->form_validation->set_rules($regras);
			
			$this->load->model('Moderadores_model');
			$this->dados['d'] = $this->Moderadores_model->get_by_codigo($codigo);
			
			if ($this->form_validation->run()) {
				$this->load->model('Moderadores_model');
				
				$dados = array(
					'nome'			=> $this->input->post('nome'),
					'email' 		=> $this->input->post('email'),
					'avisos'		=> ($this->input->post('avisos') == "sim" ? 'S' : 'N'),
					'relatorios'	=> ($this->input->post('relatorios') == "sim" ? 'S' : 'N')
				);
				
				$this->Moderadores_model->update($dados, $codigo);				
				montaPagina('/moderadores/sucesso_editar', $this->dados);
			} else {
				montaPagina('/moderadores/editar', $this->dados);
			}
		}
	}

	public function mudarsenha($codigo = null) {
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
			$this->dados['codigo_moderador'] = $codigo;
						
			if ($this->form_validation->run()) {
				$this->load->model('Moderadores_model');
				
				$senha = $this->input->post('senha');				
				$dados = $this->Moderadores_model->get_by_codigo($codigo);
				
				$config = array(
					'protocol'	=> 'mail',
					'wordwrap'	=> false,
					'mailtype'	=> 'html'
				);
				
				$this->load->library('email', $config);
			
				$conteudo = array(
					'nome'	=> $dados->nome,
					'email'	=> $dados->email,
					'senha' => $senha,
					'por'	=> strtoupper($this->dados['nome'])
				);
				
				$this->Moderadores_model->set_senha_by_codigo($this->encrypt->sha1($senha), $codigo);
				
				$this->email->from('cidadaoatento@cidadaoatento.com', 'Cidadão Atento');
				$this->email->to($dados->email);
				$this->email->subject('Nova senha');
				$this->email->message($this->load->view('/emails/senha_moderador', $conteudo, true));
				
				$this->email->send();		
						
				montaPagina('/moderadores/sucesso_senha', $this->dados);
			} else {
				montaPagina('/moderadores/senha', $this->dados);
			}
		}
	}
	
	public function listar($offset = null, $limit = 15) {
		$this->load->model('Moderadores_model');
		$this->load->library('pagination');
		
		$paginacao = array(
			'base_url'			=> 'http://interno.cidadaoatento.com/moderadores/listar',
			'total_rows'		=> $this->Moderadores_model->num_rows(),
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
		
		$this->dados['dados'] = $this->Moderadores_model->get($offset, $limit);
		$this->dados['pag']	  = $this->pagination->create_links();
		
		montaPagina('/moderadores/listar', $this->dados);
	}
	
	public function ver($codigo = null) {
		if (is_null($codigo))
			show_404();
		else {
			$this->load->model('Moderadores_model');
			
			$this->dados['d'] = $this->Moderadores_model->get_by_codigo($codigo);
				
			if (empty($this->dados['d']))
				montaPagina('/moderadores/nao_encontrado', $this->dados);
			else
				montaPagina('/moderadores/ver', $this->dados);
		}
	}
	
	public function desabilitar($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {
			$sim = $this->input->post('sim');
			$this->dados['codigo'] = $codigo;
			
			if (! empty($sim)) {
				$this->load->model('Moderadores_model');
				$this->Moderadores_model->set_desabilitar_by_codigo($codigo);
				montaPagina('/moderadores/sucesso_desabilitar', $this->dados);
			} else {
				montaPagina('/moderadores/desabilitar', $this->dados);
			}
		}
	}

	public function habilitar($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {
			$sim = $this->input->post('sim');
			$this->dados['codigo'] = $codigo;
			
			if (! empty($sim)) {
				$this->load->model('Moderadores_model');
				$this->Moderadores_model->set_habilitar_by_codigo($codigo);
				montaPagina('/moderadores/sucesso_habilitar', $this->dados);
			} else {
				montaPagina('/moderadores/habilitar', $this->dados);
			}
		}
	}
	
	public function index() {
		montaPagina('/moderadores/index', $this->dados);
	}
}

/* End of file moderadores.php */
/* Location: ./application/controllers/moderadores.php */