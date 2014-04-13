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

class Prefeituras_model extends CI_Model {
	
	/**
	 * Registra uma prefeitura no banco de dados
	 */
	public function add($municipio, $uf, $senha = null) {
		$json = array();
		
		if (is_null($senha))
			$senha = $this->encrypt->sha1(time() . rand(11111, 99999));
		
		$dados = array(
					'municipio'		=> strtolower($municipio),
					'uf'			=> strtolower($uf),
					'senha'			=> $senha
		);
		
		$this->db->insert('tbl_prefeituras', $dados);
		
		if ($this->db->_error_message() == null) {
			$json['erro'] = 0;
			$json['html'] = $this->db->insert_id();
		} else {
			$json['erro'] = 1;
			$json['html'] = 'Erro Ajax: Erro com banco de dados';
		}
		
		return $json;
	}
	
	/**
	 * Verifica se a prefeitura já se encontra registrada no banco de dado, se não registra automaticamente e retorna código
	 */
	public function registrada($municipio, $uf) {
		$json = array();
		
		$q = $this->db->select('*')
					  ->from('tbl_prefeituras')
					  ->where(array('municipio' => $municipio, 'uf' => $uf))
					  ->get();
					  
		if ($this->db->_error_message() == null) {
			if ($q->num_rows() > 0) {
				$res = $q->result_array();
				
				$json['erro'] = 0;
				$json['html'] = $res[0]['codigo'];
			} else {
				$json['erro'] = 2;
				$json['html'] = 'Erro Ajax: Prefeitura não encontrada';
			}
		} else {
			$json['erro'] = 1;
			$json['html'] = 'Erro Ajax: Erro com banco de dados';
		}
		
		return $json;
	}
}