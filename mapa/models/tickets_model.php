<?php

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

class Tickets_model extends CI_Model {
	
	/*
	 * Adidiciona novo ticket ao banco de dados
	 */
	 
	public function cadastra($nome, $email, $texto, $assunto) {
		$dados = array(
			'email'		=> $email,
			'data_add'	=> date('Y-m-d h:i:s', time()),
			'texto'		=> $texto,
			'assunto'	=> $assunto,
			'nome'		=> $nome
		);
		
		$q = $this->db->insert('tbl_tickets', $dados);		
		
		if ( $this->db->_error_message() == null ) {
			$json['erro'] = 0;
			$json['html'] = $this->db->insert_id();
		} else {
			$json['erro'] = 1;
			$json['html'] = 'Erro Ajax: Erro com banco de dados';
		}
		
		return $json;
	}
}