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

class Outros extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if (! $this->session->userdata('logado'))
			redirect('/login');
		
		$this->output->enable_profiler(FALSE);
		
		$this->load->model('Avisos_model');
		
		$this->dados = array(
			'codigo'		=> $this->session->userdata('codigo'),
			'sigla'			=> $this->session->userdata('sigla'),
			'ultimo_login'	=> $this->session->userdata('ultimo_login'),
			'avisos'	=> $this->Avisos_model->get_aviso()
		);
	}
	
	public function opcoes() {
		$this->load->library('form_validation');
		$this->load->model('Orgaos_model');
		
		$regras = array(
        	array(
            	'field'	=> 'email', 
                'label'	=> 'E-mail', 
                'rules'	=> 'required|valid_email'
        	)
        );			
		
		$this->form_validation->set_rules($regras);
				
		if ($this->form_validation->run()) {
			$dados = array(
				'email' 		=> $this->input->post('email'),
				'avisos'		=> simNao($this->input->post('avisos') != null ? $this->input->post('avisos') : 'N'),
				'relatorios'	=> simNao($this->input->post('relatorios') != null ? $this->input->post('relatorios') : 'N')
			);
			
			$this->Orgaos_model->update($dados, $this->dados['codigo']);			
			montaPagina('/outros/opcoes_sucesso', $this->dados);
		} else {
			$this->dados['dados'] = $this->Orgaos_model->get_by_codigo($this->dados['codigo']);
			montaPagina('/outros/opcoes', $this->dados);
		}
	}
	
	public function feedback() {
		$this->load->library('form_validation');
		
		$regras = array(
			array(
				'field'	=> 'feedback',
				'label' => 'Feedback',
				'rules'	=> 'required|min_length[10]'
			)
		);
		
		$this->form_validation->set_rules($regras);
		
		if ($this->form_validation->run()) {
			$config = array(
				'protocol'	=> 'mail',
				'wordwrap'	=> false,
				'mailtype'	=> 'html'
			);
			
			$dados = array(
				'corpo'		=> $this->input->post('feedback'),
				'municipio'	=> $this->session->userdata('municipio'),
				'uf'		=> $this->session->userdata('uf')
			);
				
			$this->load->library('email', $config);
			
			$this->email->from('cidadaoatento@cidadaoatento.com', 'Cidadão Atento');
			$this->email->to('cidadaoatento@cidadaoatento.com');
			$this->email->subject('Feedback');
			$this->email->message($this->load->view('/emails/feedback', $dados, true));
			
			$this->email->send();
			
			montaPagina('/outros/feedback_sucesso', $this->dados);
		} else {
			montaPagina('/outros/feedback', $this->dados);
		}
	}

	public function sobre() {
		montaPagina('/outros/sobre', $this->dados);
	}



	public function senha() {
		$codigo = $this->session->userdata('codigo');
		
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
			$this->load->model('Orgaos_model');
			
			$senha = $this->input->post('senha');				
			$dados = $this->Orgaos_model->get_by_codigo($codigo);
			
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
				'login'	=> $codigo
			);
			
			$this->Orgaos_model->set_senha_by_codigo($this->encrypt->sha1($senha), $codigo);
			
			$this->email->from('cidadaoatento@cidadaoatento.com', 'Cidadão Atento');
			$this->email->to($dados->email);
			$this->email->subject('Nova senha');
			$this->email->message($this->load->view('/emails/senha', $conteudo, true));
			
			$this->email->send();		
					
			montaPagina('/outros/sucesso_senha', $this->dados);
		} else {
			montaPagina('/outros/senha', $this->dados);
		}
	}
}

/* End of file outros.php */
/* Location: ./application/controllers/outros.php */