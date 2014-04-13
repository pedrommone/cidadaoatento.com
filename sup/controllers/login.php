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
		
		$this->dados = null;
	}

	public function index() {
		if ($this->session->userdata('logado'))
			redirect('/');
		
		$this->load->library(array('encrypt', 'form_validation'));
		$this->load->model('Prefeituras_model');
		
		$regras = array(
               array(
                     'field'   => 'codigo', 
                     'label'   => 'codigo', 
                     'rules'   => 'Código'
                  ),
               array(
                     'field'   => 'senha', 
                     'label'   => 'Senha', 
                     'rules'   => 'required'
                  )
            );

		$this->form_validation->set_rules($regras);
		
		if ($this->form_validation->run()) {		
			$codigo	= $this->input->post('codigo');
			$senha	= $this->encrypt->sha1($this->input->post('senha'));
			
			$rows = $this->Prefeituras_model->valida($codigo, $senha);
			
			if ($rows > 0) {
				$prefeitura = $this->Prefeituras_model->get_by_codigo($codigo);
				$this->Prefeituras_model->set_ultimo_login_by_codigo($prefeitura->codigo);
				$this->Prefeituras_model->set_ultimo_ip_by_codigo($prefeitura->codigo);
				
				$ses = array(
					'codigo'		=> $prefeitura->codigo,
					'uf' 			=> $prefeitura->uf,
					'municipio'		=> $prefeitura->municipio,
					'ultimo_login'	=> $prefeitura->ultimo_login,
					'logado'		=> true
				);
				
				$this->session->set_userdata($ses);
				redirect('/mapa/geral');
			} else {
				$dados['erro'] = 'Código ou senha inválidos.';
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