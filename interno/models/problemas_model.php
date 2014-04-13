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

class Problemas_model extends CI_Model {
	
	/*
	 * Lista todos os problemas
	 */
	public function get($offset = 0, $limit = 0) {
		$q = $this->db->select('*, tbl_tipo_problemas.codigo AS codigo, tbl_orgaos.codigo AS codigo_orgao')
					  ->from('tbl_tipo_problemas')
					  ->join('tbl_orgaos', 'tbl_orgaos_codigo = tbl_orgaos.codigo')
					  ->offset($offset)
					  ->limit($limit)
					  ->get();
		
		return $q->result();
	}
	
	/*
	 * Lista todos os problemas
	 */
	public function get_all() {
		$q = $this->db->select('*, tbl_tipo_problemas.codigo AS codigo, tbl_orgaos.codigo AS codigo_orgao')
					  ->from('tbl_tipo_problemas')
					  ->join('tbl_orgaos', 'tbl_orgaos_codigo = tbl_orgaos.codigo')
					  ->get();
		
		return $q->result();
	}
	
	/*
	 * Procura por codigo
	 */
	public function get_by_codigo($codigo) {
		$q = $this->db->select('*, tbl_tipo_problemas.codigo AS codigo, tbl_orgaos.codigo AS codigo_orgao')
					  ->from('tbl_tipo_problemas')
					  ->join('tbl_orgaos', 'tbl_orgaos_codigo = tbl_orgaos.codigo')
					  ->where('tbl_tipo_problemas.codigo', $codigo)
					  ->get();
		
		return $q->row();
	}
	
	/*
	 * Cadastra problema
	 */
	public function add($descricao, $img, $orgao) {
		$dados = array(
			'descricao'			=> $descricao,
			'img'				=> $img,
			'tbl_orgaos_codigo'	=> $orgao
		);
		
		$this->db->insert('tbl_tipo_problemas', $dados);
	}
	
	/**
	 * Atualiza problema
	 */
	public function update($dados, $codigo) {
		$this->db->where('codigo', $codigo)
				 ->update('tbl_tipo_problemas', $dados);
	}

	/**
	 * Deleta problema
	 */
	public function delete($codigo) {
		$this->db->where('codigo', $codigo)
			     ->delete('tbl_tipo_problemas');
	}
	
	/**
	 * Conta o total de problemas
	 */
	public function num_rows() {
		$q = $this->db->get('tbl_tipo_problemas');
		
		return $q->num_rows();
	}
}