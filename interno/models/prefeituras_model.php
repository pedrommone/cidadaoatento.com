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
	
	/*
	 * Retorna todos os orgãos
	 */
	public function get($offset = 0, $limit = 0) {
		$q = $this->db->select('*, DATE(ultimo_login) AS dia_ultimo_login, TIME(ultimo_login) AS hora_ultimo_login')
					  ->offset($offset)
					  ->limit($limit)
					  ->get('tbl_prefeituras');
		
		return $q->result();
	}
	
	/*
	 * Pega orgão por código
	 */
	public function get_by_codigo($codigo) {
		$q = $this->db->select('*, DATE(ultimo_login) AS dia_ultimo_login, TIME(ultimo_login) AS hora_ultimo_login')
					  ->where('codigo', $codigo)
					  ->get('tbl_prefeituras');
					 
		return $q->row();
	}
	
	/*
	 * Adiciona nova prefeitura
	 */
	public function add($municipio, $uf, $senha, $email) {
		$dados = array(
			'municipio'		=> $municipio,
			'uf'			=> $uf,
			'senha' 		=> $senha,
			'ultimo_login'	=> '0000-00-00 00:00:00',
			'ultimo_ip'		=> $this->input->ip_address(),
			'email'			=> $email
		);
		
		$this->db->insert('tbl_prefeituras', $dados);
	}
	
	/**
	 * Atualiza prefeitura
	 */
	public function update($dados, $codigo) {
		$this->db->where('codigo', $codigo)
				 ->update('tbl_prefeituras', $dados);
	}
	
	/**
	 * Deleta prefeitura
	 */
	public function delete($codigo) {
		$this->db->where('codigo', $codigo)
			     ->delete('tbl_prefeituras');
	}
	
	/**
	 * Conta o total de prefeituras
	 */
	public function num_rows() {
		$q = $this->db->get('tbl_prefeituras');
		
		return $q->num_rows();
	}
	
	/*
	 * Metodo para busca
	 */
	public function get_by_param($dados, $offset, $limit) {
		$q = $this->db->select('*, DATE(ultimo_login) AS dia_ultimo_login, TIME(ultimo_login) AS hora_ultimo_login')
					  ->or_like($dados)
					  ->offset($offset)
					  ->limit($limit)
					  ->get('tbl_prefeituras');
					  
		return $q->result();
	}

	/*
	 * Retorna todos os orgãos de acordo com as definicoes
	 */
	public function get_by_relatorios() {
		$q = $this->db->get_where('tbl_prefeituras', array('relatorios' => 'S', 'email !=' => 'n/a'));
		
		return $q->result();
	}
	
	/*
	 * Retorna todos os orgãos de acordo com as definicoes
	 */
	public function get_by_avisos() {
		$q = $this->db->get_where('tbl_prefeituras', array('avisos' => 'S', 'email !=' => 'n/a'));
		
		return $q->result();
	}
}