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

class Cidadaos_model extends CI_Model {
	
	/**
	 * Conta o total de cidadaos
	 */
	public function num_rows() {
		$q = $this->db->get('tbl_cidadaos');
		
		return $q->num_rows();
	}
	
	/*
	 * Pega todos os cidadaos cadastrados
	 */
	public function get($offset = 0, $limit = 0) {
		$q = $this->db->select('*, DATE(data_add) AS dia_add, TIME(data_add) AS hora_add, DATE(ultimo_login) AS dia_ultimo_login, TIME(ultimo_login) AS hora_ultimo_login')
					  ->offset($offset)
					  ->limit($limit)
					  ->get('tbl_cidadaos');
		
		return $q->result();
	}
	
	/*
	 * Pega orgão por cpf
	 */
	public function get_by_cpf($cpf) {
		$q = $this->db->select('*, DATE(data_add) AS dia_add, TIME(data_add) AS hora_add, DATE(ultimo_login) AS dia_ultimo_login, TIME(ultimo_login) AS hora_ultimo_login')
					  ->where('cpf', $cpf)
					  ->get('tbl_cidadaos');
					 
		return $q->row();
	}
	
	/*
	 * Procura de acordo com os parametros
	 */
	public function get_by_param($arr, $offset, $limit) {		
		$q = $this->db->select('*, DATE(data_add) AS dia_add, TIME(data_add) AS hora_add, DATE(ultimo_login) AS dia_ultimo_login, TIME(ultimo_login) AS hora_ultimo_login')
					  ->offset($offset)
					  ->limit($limit)
					  ->like($arr)
					  ->get('tbl_cidadaos');
		
		return $q->result();
	}

	/*
	 * Quantidade de rows de acordo com os parametros
	 */
	public function num_rows_by_param($arr) {		
		$q = $this->db->select('*, DATE(data_add) AS dia_add, TIME(data_add) AS hora_add, DATE(ultimo_login) AS dia_ultimo_login, TIME(ultimo_login) AS hora_ultimo_login')
					  ->like($arr)
					  ->get('tbl_cidadaos');
		
		return $q->num_rows();
	}

	/*
	 * Define o cidadao como bloqueado
	 */
	public function set_bloqueado_by_cpf($cpf) {
		$this->db->set('bloqueado', 'S')
				 ->where('cpf', $cpf)
				 ->update('tbl_cidadaos');
	}
	
	/*
	 * Define o cidadao como desbloqueado
	 */
	public function set_desbloqueado_by_cpf($cpf) {
		$this->db->set('bloqueado', 'N')
				 ->where('cpf', $cpf)
				 ->update('tbl_cidadaos');
	}
}