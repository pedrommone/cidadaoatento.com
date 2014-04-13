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

class Moderadores_model extends CI_Model {
	
	/**
	 * Verifica se usuário é válido
	 */
	public function valida($email, $senha) {
		$q = $this->db->select('*')
					  ->from('tbl_moderadores')
					  ->where(array('email' => $email, 'senha' => $senha, 'habilitado' => 'S'))
					  ->limit(1)
					  ->get();
					  
		return $q->num_rows();
	}
	
	/**
	 * Retorna os dados do moderador
	 */
	public function get_by_email($email) {
		$q = $this->db->select('*')
					  ->from('tbl_moderadores')
					  ->where('email', $email)
					  ->limit(1)
					  ->get();
		
		return $q->row();
	}
	
	/**
	 * Atualiza ultimo login por código
	 */
	public function set_ultimo_login_by_codigo($codigo) {
		$this->db->set('ultimo_login', date("Y-m-d h:i:s"))
				 ->where('codigo', $codigo)
				 ->update('tbl_moderadores');
	}
	
	/*
	 * Atualiza último ip por codigo
	 */
	public function set_ultimo_ip_by_codigo($codigo) {
		$this->db->set('ultimo_ip', $this->input->ip_address())
				 ->where('codigo', $codigo)
			     ->update('tbl_moderadores');
	}
	
	/*
	 * Lista todos os registros
	 */
	public function get($offset = 0, $limit = 0) {
		$q = $this->db->select('*, DATE(data_add) AS dia_add, TIME(data_add) AS hora_add, DATE(ultimo_login) AS dia_ultimo_login, TIME(ultimo_login) AS hora_ultimo_login')
					  ->offset($offset)
					  ->limit($limit)
					  ->get('tbl_moderadores');
		
		return $q->result();
	}
	
	/*
	 * Procura pro codigo
	 */
	public function get_by_codigo($codigo) {
		$q = $this->db->select('*, DATE(data_add) AS dia_add, TIME(data_add) AS hora_add, DATE(ultimo_login) AS dia_ultimo_login, TIME(ultimo_login) AS hora_ultimo_login')
					  ->where('codigo', $codigo)
					  ->get('tbl_moderadores');
		
		return $q->row();
	}
	
	/*
	 * Adiciona novo moderadores
	 */
	public function add($nome, $email, $senha) {
		$dados = array(
			'nome'		=> $nome, 
			'email'		=> $email,
			'senha'		=> $senha,
			'data_add'	=> date('Y-m-d h:i:s', time())
		);
		
		$this->db->insert('tbl_moderadores', $dados);
	}
	
	/**
	 * Deleta moderador
	 */
	public function delete($codigo) {
		$this->db->where('codigo', $codigo)
			     ->delete('tbl_moderadores');
	}
	
	/*
	 * Habilita moderador por código
	 */
	public function set_habilitar_by_codigo($codigo) {
		$this->db->set('habilitado', 'S')
				 ->where('codigo', $codigo)
			     ->update('tbl_moderadores');
	}
	
	/*
	 * Desabilita moderador por código
	 */
	public function set_desabilitar_by_codigo($codigo) {
		$this->db->set('habilitado', 'N')
				 ->where('codigo', $codigo)
			     ->update('tbl_moderadores');
	}

	/**
	 * Atualiza moderador
	 */
	public function update($dados, $codigo) {
		$this->db->where('codigo', $codigo)
				 ->update('tbl_moderadores', $dados);
	}
	
	/**
	 * Atualiza senha
	 */
	public function set_senha_by_codigo($senha, $codigo) {
		$this->db->where('codigo', $codigo)
				 ->set('senha', $senha)
				 ->update('tbl_moderadores');
	}
	
	/**
	 * Conta o total de moderadores
	 */
	public function num_rows() {
		$q = $this->db->get('tbl_moderadores');
		
		return $q->num_rows();
	}
	
	/*
	 * Retorna todos os moderadores de acordo com as definicoes
	 */
	public function get_by_relatorios() {
		$q = $this->db->get_where('tbl_moderadores', array('relatorios' => 'S'));
		
		return $q->result();
	}
	
	/*
	 * Retorna todos os moderadores de acordo com as definicoes
	 */
	public function get_by_avisos() {
		$q = $this->db->get_where('tbl_moderadores', array('avisos' => 'S'));
		
		return $q->result();
	}
}