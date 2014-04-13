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

class Avisos_model extends CI_Model {
	
	/*
	 * Procura todos os avisos de acordo com a data
	 */
	public function get_aviso() {
		$q = $this->db->select('*, DATE(data_add) AS data_add, TIME(data_add) AS hora_add')
					  ->order_by('data_add')
					  ->where(array("NOW() BETWEEN data_add AND DATE_ADD(data_add, INTERVAL 1 DAY)" => null, 'interno' => 'S'), false)
					  ->get('tbl_avisos');
					  
		return $q->result();
	}
	
	/*
	 * Lista todos os avisos
	 */
	public function get_all($offset = 0, $limit = 0) {
		$q = $this->db->select('*, DATE(data_add) AS data_add, TIME(data_add) AS hora_add')
					  ->from('tbl_avisos')
					  ->offset($offset)
					  ->limit($limit)
					  ->get();
		
		return $q->result();
	}
	
	/*
	 * Pega aviso por código
	 */
	public function get_by_codigo($codigo) {
		$q = $this->db->select('*, tbl_avisos.codigo AS codigo, DATE(tbl_avisos.data_add) AS data_add, TIME(tbl_avisos.data_add) AS hora_add')
					  ->join('tbl_moderadores', 'tbl_moderadores_codigo = tbl_moderadores.codigo')
					  ->from('tbl_avisos')
					  ->where('tbl_avisos.codigo', $codigo)
					  ->get();
		
		return $q->row();
	}
	
	/**
	 * Conta o total de avisos
	 */
	public function num_rows() {
		$q = $this->db->get('tbl_avisos');
		
		return $q->num_rows();
	}
	
	/*
	 * Cadastra novo aviso
	 */
	public function add($aviso, $periodo, $tipo, $moderador, $interno, $sup, $suo) {
		$dados = array(
			'aviso'						=> $aviso,
			'periodo'					=> $periodo,
			'tbl_moderadores_codigo' 	=> $moderador,
			'data_add'					=> date('Y-m-d h:i:s', time()),
			'tipo'						=> $tipo, 
			'interno'					=> $interno,
			'sup'						=> $sup,
			'suo'						=> $suo
		);
		
		$this->db->insert('tbl_avisos', $dados);
	}

	/*
	 * Deleta aviso
	 */
	public function delete($codigo) {
		$this->db->where('codigo', $codigo)
				 ->delete('tbl_avisos');
	}

	/**
	 * Atualiza aviso
	 */
	public function update($dados, $codigo) {
		$this->db->where('codigo', $codigo)
				 ->update('tbl_avisos', $dados);
	}

	/**
	 * Todos os emails aptos a receberem avisos
	 */
	public function get_all_avisos() {
		$q = $this->db->query("SELECT email, avisos
								FROM (
									SELECT email, avisos
										FROM tbl_moderadores
									UNION 
									SELECT email, avisos
										FROM tbl_orgaos
									UNION 
									SELECT email, avisos
										FROM tbl_prefeituras
								) AS temp
							  where avisos = 'S' AND email != 'n/a'");
		return $q->result();
	}		
}