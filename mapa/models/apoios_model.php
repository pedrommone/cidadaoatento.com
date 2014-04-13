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

class Apoios_model extends CI_Model {
	
	/*
	 * Adiciona um novo "apoio" e atualiza a quantidade total
	 */
	public function adicionar($codigo, $cpf) {
		$dados = array(
			'tbl_denuncias_codigo'	=> $codigo,
			'tbl_cidadaos_cpf'		=> $cpf,
			'data'					=> date('Y-m-d h:m:s', time())
		);
		
		$this->db->insert('tbl_apoios', $dados);
		
		if ($this->db->_error_message() == null) {
			$q = $this->db->where('tbl_denuncias_codigo', $codigo)
						  ->group_by('tbl_cidadaos_cpf')
						  ->get('tbl_apoios');

			$this->db->where('codigo', $codigo)
					 ->set('numero_apoios', $q->num_rows())
					 ->update('tbl_denuncias');
			
			$q = $this->db->where('tbl_cidadaos_cpf', $cpf)
						  ->get('tbl_apoios');
						  
			$this->db->where('cpf', $cpf)
					 ->set('num_apoios', $q->num_rows())
					 ->update('tbl_cidadaos');
					 
				 if ($this->db->_error_message() == null) {
				 	$json['erro'] = 2;
					$json['html'] = 'Erro Ajax: Erro com banco de dados';
				 } else {
				 	$json['erro'] = 0;
					$json['html'] = '';
				 }
		} else {
			$json['erro'] = 1;
			$json['html'] = 'Erro Ajax: Erro com banco de dados';
		}
		
		return $json;
	}
	
	/**
	 * Verifica de CPF pode apoiar denúncia
	 */
	public function podeApoiar($cpf, $denuncia) {
		$q = $this->db->where(array('tbl_denuncias_codigo' => $denuncia, 'tbl_cidadaos_cpf' => $cpf))
					  ->get('tbl_apoios');
					  
		return ($q->num_rows() == 0);
	}
}