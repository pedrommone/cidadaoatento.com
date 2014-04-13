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

class Reportes_model extends CI_Model {
	
	/**
	 * Adiciona um reporte no banco de dados
	 */
	public function adicionar($codigo, $cpf) {
		$dados = array(
			'ip'						=> $this->input->ip_address(),
			'data_add'					=> date('Y-m-d h:i:s', time()),
			'tbl_cidadaos_cpf'			=> $cpf,
			'tbl_denuncias_codigo' 		=> $codigo
		);
		
		$this->db->insert('tbl_reportes', $dados);
		
		$q = $this->db->where('tbl_cidadaos_cpf', $cpf)
					  ->get('tbl_reportes');
					  
		$this->db->where('cpf', $cpf)
				 ->set('num_reportes', $q->num_rows())
				 ->update('tbl_cidadaos');
		
		if ($this->db->_error_message() == null) {
			$json['erro'] = 0;
			$json['html'] = 1;
		} else {
			$json['erro'] = 1;
			$json['html'] = 'Erro Ajax: Erro com banco de dados';
		}
		
		return $json;
	}
	
	/**
	 * Verifica de CPF pode reportar denúncia
	 */
	public function podeDenunciar($cpf, $denuncia) {
		$q = $this->db->where(array('tbl_denuncias_codigo' => $denuncia, 'tbl_cidadaos_cpf' => $cpf))
					  ->get('tbl_reportes');
					  
		return ($q->num_rows() == 0);
	}
}