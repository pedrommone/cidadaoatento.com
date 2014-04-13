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

class Orgaos_model extends CI_Model {
	
	/*
	 * Retorna todos os orgãos
	 */
	public function get($offset = null, $limit = null) {
		$q = $this->db->offset($offset)
					  ->limit($limit)
					  ->get('tbl_orgaos');
		
		return $q->result();
	}
	
	/*
	 * Pega orgão por código
	 */
	public function get_by_codigo($codigo) {
		$q = $this->db->where('codigo', $codigo)
					  ->get('tbl_orgaos');
					 
		return $q->row();
	}
	
	/*
	 * Adiciona novo orgao ao blog
	 */
	public function add($nome, $sigla, $email, $minimo_apoios) {
		$dados = array(
			'nome'			=> $nome,
			'sigla'			=> $sigla,
			'email' 		=> $email,
			'minimo_apoios'	=> $minimo_apoios
		);
		
		$this->db->insert('tbl_orgaos', $dados);
	}
	
	/**
	 * Atualiza orgao
	 */
	public function update($dados, $codigo) {
		$this->db->where('codigo', $codigo)
				 ->update('tbl_orgaos', $dados);
	}
	
	/**
	 * Deleta orgao
	 */
	public function delete($codigo) {
		$this->db->where('codigo', $codigo)
			     ->delete('tbl_orgaos');
	}
	
	/**
	 * Conta o total de orgaos
	 */
	public function num_rows() {
		$q = $this->db->get('tbl_orgaos');
		
		return $q->num_rows();
	}
	
	/*
	 * Metodo para busca
	 */
	public function get_by_param($dados, $offset, $limit) {
		$q = $this->db->or_like($dados)
					  ->offset($offset)
					  ->limit($limit)
					  ->get('tbl_orgaos');
					  
		return $q->result();
	}
	
	/*
	 * Retorna todos os orgãos
	 */
	public function get_all() {
		$q = $this->db->get('tbl_orgaos');
		
		return $q->result();
	}

	/*
	 * Retorna todos os orgãos de acordo com as definicoes
	 */
	public function get_by_relatorios() {
		$q = $this->db->get_where('tbl_orgaos', array('relatorios' => 'S'));
		
		return $q->result();
	}
	
	/*
	 * Retorna todos os orgãos de acordo com as definicoes
	 */
	public function get_by_avisos() {
		$q = $this->db->get_where('tbl_orgaos', array('avisos' => 'S'));
		
		return $q->result();
	}
	
	/**
	 * Atualiza senha
	 */
	public function set_senha_by_codigo($senha, $codigo) {
		$this->db->where('codigo', $codigo)
				 ->set('senha', $senha)
				 ->update('tbl_orgaos');
	}
}