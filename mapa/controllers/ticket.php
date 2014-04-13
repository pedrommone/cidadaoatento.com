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

class Ticket extends CI_Controller {
	public function novo() {
		$this->security->csrf_verify();
		
		$json = array();
		
		$nome 		= $this->input->post('nome');
		$email 		= $this->input->post('email');
		$assunto	= $this->input->post('assunto');
		$texto 		= $this->input->post('texto');
		
		if (empty($nome) || empty($email) || empty($assunto) || empty($texto))
			$json = array('erro' => 2, 'html' => 'Erro Ajax: Dados inválidos.');
		else {
			$this->load->model('Tickets_model');			
			$json = $this->Tickets_model->cadastra($nome, $email, $texto, $assunto);
			
			$msg = "Olá $nome!\n\n" .
			   "O seu ticket foi recebido com sucesso! Fique atento a este email, em breve iremos responder-lo.\n" .
			   "\n" .
			   "ATENÇÃO! NÃO ABRA UM NOVO TICKET ATÉ QUE ESTE TICKET SEJA RESOLVIDO!\n" .
			   "--------------------------------------------------------\n" .
			   "Equipe cidadaoatento.com\n" .
			   "ticket@cidadaoatento.com";
		
			$this->load->library('email');
	
			$this->email->from('ticket@cidadaoatento.com', 'Cidadão Atento');
			$this->email->to($email); 
			
			$this->email->subject('Ticket #' . $json['html']);
			$this->email->message($msg);	
			
			$this->email->send();
		}
		
		$this->output->set_content_type('application/json')
    				 ->set_output(json_encode($json));
	}
}

/* End of file ticket.php */
/* Location: ./application/controllers/ticket.php */