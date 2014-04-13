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

class Tickets extends CI_Controller {

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
	
	public function meus() {
		$this->load->model('Tickets_model');
		$this->dados['tickets'] = $this->Tickets_model->get_by_moderador($this->session->userdata('moderador'));
		
		montaPagina('/tickets/listar_meus', $this->dados);
	}
	
	public function novos() {
		$this->load->model('Tickets_model');
		$this->dados['tickets'] = $this->Tickets_model->novos();
		
		montaPagina('/tickets/listar_novos', $this->dados);
	}
	
	public function listar() {
		$this->load->model('Tickets_model');
		$this->dados['tickets'] = $this->Tickets_model->get();
		
		montaPagina('/tickets/listar', $this->dados);
	}
	
	public function encerrar($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {
			$sim = $this->input->post('sim');
			$this->dados['codigo'] = $codigo;
			
			if (! empty($sim)) {
				$this->load->model('Tickets_model');
				$this->Tickets_model->set_encerrado_by_codigo($codigo);
				
				$moderador 	= $this->session->userdata('moderador');
				$data	   	= date('d/m/Y', time()) . ' as ' . date('H:i:s');
				$nomeModer	= $this->session->userdata('nome');
				$dados 		= $this->Tickets_model->get_by_codigo($codigo);
				
				$msg = "Olá $dados->nome!\n\n" .
					   "O seu ticket foi encerrado em $data por $nomeModer.\n" .
					   "Se sua dúvida ainda não foi sanada basta responder este email.\n\n\n" .
					   "--------------------------------------------------------\n" .
					   "Equipe cidadaoatento.com\n" .
					   "ticket@cidadaoatento.com";
			
				$this->load->library('email');
		
				$this->email->from('ticket@cidadaoatento.com', 'Cidadão Atento');
				$this->email->to($dados->email); 
				
				$this->email->subject('Ticket #' . $dados->codigo);
				$this->email->message($msg);	
				
				$this->email->send();
				
				montaPagina('/tickets/sucesso_encerrar', $this->dados);
			} else {
				montaPagina('/tickets/encerrar', $this->dados);
			}
		}
	}

	public function abrir($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {
			$sim = $this->input->post('sim');
			$this->dados['codigo'] = $codigo;
			
			if (! empty($sim)) {
				$this->load->model('Tickets_model');
				$this->Tickets_model->set_aberto_by_codigo($codigo);
				
				$moderador 	= $this->session->userdata('moderador');
				$data	   	= date('d/m/Y', time()) . ' as ' . date('H:i:s');
				$nomeModer	= $this->session->userdata('nome');
				$dados 		= $this->Tickets_model->get_by_codigo($codigo);
				
				$msg = "Olá $dados->nome!\n\n" .
					   "O seu ticket foi aberto em $data por $nomeModer.\n" .
					   "Aguarde o contato do mesmo.\n\n\n" .
					   "--------------------------------------------------------\n" .
					   "Equipe cidadaoatento.com\n" .
					   "ticket@cidadaoatento.com";
			
				$this->load->library('email');
		
				$this->email->from('ticket@cidadaoatento.com', 'Cidadão Atento');
				$this->email->to($dados->email); 
				
				$this->email->subject('Ticket #' . $dados->codigo);
				$this->email->message($msg);	
				
				$this->email->send();
				
				montaPagina('/tickets/sucesso_abrir', $this->dados);
			} else {
				montaPagina('/tickets/abrir', $this->dados);
			}
		}
	}

	public function ver($codigo = null) {
		if (is_null($codigo))
			show_404();
		else {
			$this->load->library('form_validation');		
		
			$regras = array(
               array(
                     'field'   => 'resposta', 
                     'label'   => 'Resposta', 
                     'rules'   => 'required|min_length[10]|max_length[500]'
                  )
            );
			
			$this->form_validation->set_rules($regras);
			$this->load->model('Tickets_model');
			
			if ($this->form_validation->run()) {
				$moderador 	= $this->session->userdata('moderador');
				$resposta  	= $this->input->post('resposta');
				$data	   	= date('d/m/Y', time()) . ' as ' . date('H:i:s');
				$nomeModer	= $this->session->userdata('nome');
				
				$this->Tickets_model->responder_ticket($codigo, $moderador, $resposta);
				$this->Tickets_model->set_moderador_by_codigo($codigo, $moderador);
				$dados = $this->Tickets_model->get_by_codigo($codigo);
				
				$msg = "Olá $dados->nome!\n\n" .
					   "Resposta referente ao ticket #$dados->codigo.\n" .
					   "--------------------------------------------------------\n" .
					   "$resposta\n" .
					   "--------------------------------------------------------\n" .
					   "Por $nomeModer, em $data\n" .
					   "Para responder o ticket basta responder este email.\n\n\n" .
					   "--------------------------------------------------------\n" .
					   "Equipe cidadaoatento.com\n" .
					   "ticket@cidadaoatento.com";
			
				$this->load->library('email');
		
				$this->email->from('ticket@cidadaoatento.com', 'Cidadão Atento');
				$this->email->to($dados->email); 
				
				$this->email->subject('Ticket #' . $dados->codigo);
				$this->email->message($msg);	
				
				$this->email->send();
				
				montaPagina('/tickets/sucesso_responder', $this->dados);
			} else {				
				$this->dados['ticket']	  = $this->Tickets_model->get_by_codigo($codigo);
				$this->dados['respostas'] = $this->Tickets_model->get_respostas_by_codigo($codigo);
					
				if (empty($this->dados['ticket']))
					montaPagina('/tickets/nao_encontrado', $this->dados);
				else
					montaPagina('/tickets/ver', $this->dados);
			}
		}
	}
	
	public function procurar() {		
		montaPagina('/tickets/procurar', $this->dados);
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
				montaPagina('/tickets/nao_encontrado', $this->dados);
			else
				redirect('/tickets/ver/' . $codigo);
		} else {
			montaPagina('/tickets/procurar_validadores', $this->dados);
		}
	}
	
	public function avancada() {
		$this->load->library('form_validation');
		
		$regras = array(
			array(
				'field' => 'nome',
				'label' => 'Nome',
				'rules' => 'min_lengh[1]'
			),
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'min_lengh[1]'
			)
		);
		
		$this->form_validation->set_rules($regras);
		
		$this->load->model('Tickets_model');
		
		$param = array();
		
		if ($this->form_validation->run()) {
			$nome 	= $this->input->post('nome');
			$email	= $this->input->post('email');
			
			if (! empty($nome))
				$param['nome'] = $nome;
			if (! empty($invalida))
				$param['email'] = $email;
			
			$this->dados['tickets'] = $this->Tickets_model->get_by_param($param);
			
			if (empty($this->dados['tickets']))
				montaPagina('/tickets/nao_encontrado', $this->dados);
			else
				montaPagina('/tickets/listar_pesquisa', $this->dados);
		} else {
			montaPagina('/tickets/procurar_validadores', $this->dados);
		}
	}
	
	public function index() {
		montaPagina('/tickets/index', $this->dados);
	}
}

/* End of file tickets.php */
/* Location: ./application/controllers/reportes.php */