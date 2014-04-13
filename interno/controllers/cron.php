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

class Cron extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		$this->output->enable_profiler(FALSE);
	}	
	
	public function ticket() {
		$this->load->model('Tickets_model');
		
		$email = 'ticket@cidadaoatento.com';
		$senha = 'PU0Jlgf9';
		$inbox = @imap_open("{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX", $email, $senha);
		
		$emails = array();
		
		if(! $inbox)
			$foo = imap_errors();
		
		$total = imap_num_msg($inbox);
		if($total > 0) {
			for ($i = $total; $i >= 1; $i--) {
				$headers = @imap_header($inbox, $i);
				
				$emails[] = array(
					'headers' 		=> $headers,
					'message_body' 	=> @imap_fetchbody($inbox, $i, 1)
				);
			}
		}

		foreach($emails as $email) {
			if ($email['headers']->Unseen == "U") {
				$resposta 	= nl2br($this->replaceChars(imap_utf8($email['message_body'])));
				$remente	= $email['headers']->from[0]->mailbox . '@' . $email['headers']->from[0]->host;
				
				$ticket = $this->Tickets_model->get_by_email($remente);
				
				$this->Tickets_model->responder_ticket($ticket->codigo, null, $resposta);
			}
		}
		
		log_message('info', 'Tickets verificados e atualizados. ' . $total);
	}

	public function relatorios_orgaos() {
		$this->load->model(array('Denuncias_model', 'Orgaos_model'));
		
		$trg = $this->Orgaos_model->get_by_relatorios();
		
		foreach ($trg as $r) {
			$dados = array(
				'orgao' 	=> $r,
				'denuncias'	=> $this->Denuncias_model->get_by_apoios_and_orgao($r->minimo_apoios, $r->codigo)
			);
			
			if (count($dados['denuncias']) > 0) {
				$config = array(
					'protocol'	=> 'mail',
					'wordwrap'	=> false,
					'mailtype'	=> 'html'
				);
				
				$this->load->library('email', $config);
				
				$this->email->from('cidadaoatento@cidadaoatento.com', 'Cidadão Atento');
				$this->email->to($r->email);
				$this->email->subject('Relatório de denúncias');
				$this->email->message($this->load->view('/emails/cron/relatorios_orgaos', $dados, true));
				
				$this->email->send();
			}
			
			unset($dados);
		}
	}
	
	public function relatorios_municipios() {
		$this->load->model(array('Denuncias_model', 'Prefeituras_model'));
		
		$trg = $this->Prefeituras_model->get_by_relatorios();
		
		foreach ($trg as $r) {
			$dados = array(
				'municipio'	=> $r,
				'denuncias'	=> $this->Denuncias_model->get_by_prefeitura($r->codigo)
			);
			
			if (count($dados['denuncias']) > 0) {
				$config = array(
					'protocol'	=> 'mail',
					'wordwrap'	=> false,
					'mailtype'	=> 'html'
				);
				
				$this->load->library('email', $config);
				
				$this->email->from('cidadaoatento@cidadaoatento.com', 'Cidadão Atento');
				$this->email->to($r->email);
				$this->email->subject('Relatório de denúncias');
				$this->email->message($this->load->view('/emails/cron/relatorios_municipios', $dados, true));
				
				$this->email->send();
			}
			
			unset($dados);
		}
	}
	
	private function replaceChars($txt) {
		$carimap = array("=C3=A9", "=C3=A8", "=C3=AA", "=C3=AB", "=C3=A7", "=C3=A0", "=20", "=C3=80", "=C3=89", "=E3", "=E1", "=E9");
		$carhtml = array("é", "è", "ê", "ë", "ç", "à", "&nbsp;", "À", "É", "ã", "á", "é");
		return str_replace($carimap, $carhtml, $txt);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */