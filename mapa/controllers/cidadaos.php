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
		
	public function validaSession() {
		$this->security->csrf_verify();
		
		$json = array(
			'erro' => 4,
			'html' => 'Erro Ajax: Sessão inválida'
		);
		
		if ( $this->session->userdata('logado') ) {			
			$this->load->model('Cidadaos_model');
			
			$json = $this->Cidadaos_model->validaToken ( $this->session->userdata('token'), $this->session->userdata('cpf'), 'in' );
			
			if ($json['erro'] == 3)
				$this->session->sess_destroy();
		} else {
			$this->session->sess_destroy();
		}
		
		echo json_encode($json);
	}
	
	public function login() {
		$this->security->csrf_verify();
		
		$this->load->model('Cidadaos_model');
		
		$json = array(
			'erro' => 4,
			'html' => 'Erro Ajax: Requisição inválida'
		);
		
		$ban = array('-', '.', '(', ')', ' ');
		
		$cpf = str_replace($ban, '', $this->input->post('cpf'));
		$tel = str_replace($ban, '', $this->input->post('telefone'));
		
		if (empty($cpf) || 
				empty($tel) || 
				is_null($cpf) || 
				is_null($tel) || 
				! validaCPF($cpf) || 
				! is_numeric($cpf) || 
				! is_numeric($tel) ||
				strlen($tel) < 10)
			
			$json = array(
				'erro' => 5,
				'html' => 'Erro Ajax: Dados inválidos'
			);
		else {
			$res = $this->Cidadaos_model->login($cpf, $tel);
			$json = $res['json'];
			
			$ses = array(
                   'logado'		=> 1,
                   'cpf'		=> $cpf,
                   'token'		=> $res['token']
            );

			$this->session->set_userdata($ses);
		}
		
		echo json_encode($json);
	}
	
	public function logout() {
		$this->session->sess_destroy();
		
		$json = array(
			'erro' => 0,
			'html' => ''
		);
			
		echo json_encode($json);
	}

	public function podeDenunciar() {
		$this->security->csrf_verify();
		
		$json = array(
			'erro' => 1,
			'html' => 'Erro Ajax: Requisição inválida'
		);
		
		$this->load->model('Denuncias_model');

		$json = $this->Denuncias_model->podeDenunciar($this->session->userdata('cpf'), $this->input->ip_address());
		
		echo json_encode($json);
	}
	
	public function primeiraVisita() {
		$this->load->helper('cookie');
		
		$cookie = array(
		    'name'   => 'CAMAPVISITA',
		    'value'  => 'nao',
		    'expire' => '-1',
		    'domain' => '.cidadaoatento.com',
		    'path'   => '/',
		    'prefix' => 'CA_',
		    'secure' => false
		);
				
		if (get_cookie('CA_CAMAPVISITA') != 'nao')
			$json = array('primeira' => true);
		else
			$json = array('primeira' => false);
		
		set_cookie($cookie);
		
		$this->output->set_content_type('application/json')
    				 ->set_output(json_encode($json));
	}
}

/* End of file cidadao.php */
/* Location: ./application/controllers/cidadao.php */