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

class Login extends CI_Controller {
		
	public function __construct() {
		parent::__construct();		
		$this->output->enable_profiler(FALSE);
	}

	public function index() {
		$this->load->library(array('encrypt', 'form_validation'));
		$this->load->model('Moderadores_model');
		
		$regras = array(
               array(
                     'field'   => 'email', 
                     'label'   => 'Email', 
                     'rules'   => 'required'
                  ),
               array(
                     'field'   => 'senha', 
                     'label'   => 'Senha', 
                     'rules'   => 'required'
                  )
            );

		$this->form_validation->set_rules($regras);
		
		if ($this->form_validation->run()) {		
			$email	= $this->input->post('email');
			$senha	= $this->encrypt->sha1($this->input->post('senha'));
			
			$rows = $this->Moderadores_model->valida($email, $senha);
			
			if ($rows > 0) {
				$usuario = $this->Moderadores_model->get_by_email($email);
				$this->Moderadores_model->set_ultimo_login_by_codigo($usuario->codigo);
				$this->Moderadores_model->set_ultimo_ip_by_codigo($usuario->codigo);
				
				$ses = array(
					'nome' 			=> $usuario->nome,
					'logado'		=> true,
					'moderador'		=> $usuario->codigo
				);
				
				$this->session->set_userdata($ses);
				redirect('/dashboard');
			} else {
				$dados['erro'] = 'Email ou senha inválidos.';
				$this->load->view('login/index', $dados);
			}
		} else 
			$this->load->view('login/index');
	}
	
	public function logout() {
		$this->session->sess_destroy();
		redirect('/login');
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */