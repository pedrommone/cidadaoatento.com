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
	 * Procura novos tickets
	 */
	public function novos() {
		$q = $this->db->select('*')
					  ->where(array('aberto' => 'S', 'tbl_moderadores_codigo' => null))
					  ->order_by('data_add')
					  ->get('tbl_tickets');
				 
		return $q->result();
	}
	
	/*
	 * Procura todos os tickets
	 */
	public function get() {
		$q = $this->db->order_by('data_add')
					  ->get('tbl_tickets');
					  
		return $q->result();
	}
	
	/*
	 * Pega os tickets em aberto de acordo com o moderador
	 */
	public function get_by_moderador($codigo) {
		$q = $this->db->select('*')
					  ->where(array('aberto' => 'S', 'tbl_moderadores_codigo'  => $codigo))
					  ->order_by('data_add')
					  ->get('tbl_tickets');
		
		return $q->result();
	}
	
	/*
	 * Pega por código
	 */
	public function get_by_codigo($codigo) {
		$q = $this->db->select('*, DATE(data_add) AS dia_add, TIME(data_add) AS hora_add, DATE(data_solu) AS dia_solu, TIME(data_solu) AS hora_solu')
					  ->where('codigo', $codigo)
					  ->get('tbl_tickets');
					  
		return $q->row();
	}
	
	/*
	 * Pega por email
	 */
	public function get_by_email($email) {
		$q = $this->db->select('*, DATE(data_add) AS dia_add, TIME(data_add) AS hora_add, DATE(data_solu) AS dia_solu, TIME(data_solu) AS hora_solu')
					  ->where('email', $email)
					  ->get('tbl_tickets');
					  
		return $q->row();
	}
	
	/*
	 * Lista respostas
	 */
	public function get_respostas_by_codigo($codigo) {
		$q = $this->db->select('resposta, DATE(tbl_respostas.data_add) AS dia_add, TIME(tbl_respostas.data_add) AS hora_add, nome')
					  ->from('tbl_respostas')
					  ->join('tbl_moderadores', 'tbl_moderadores_codigo = tbl_moderadores.codigo', 'left')
					  ->where('tbl_tickets_codigo', $codigo)
					  ->get();
					  
		return $q->result();
	}
	
	/*
	 * Marca ticket como solucionado
	 */
	public function set_encerrado_by_codigo($codigo) {
		$this->db->set(array('aberto' => 'N', 'data_solu' => date('Y-m-d h:m:s', time())))
			     ->where('codigo', $codigo)
				 ->update('tbl_tickets');
	}
	
	/*
	 * Marca ticket como solucionado
	 */
	public function set_aberto_by_codigo($codigo) {
		$this->db->set('aberto', 'S')
			     ->where('codigo', $codigo)
				 ->update('tbl_tickets');
	}
	
	/*
	 * Responder ticket
	 */
	public function responder_ticket($codigo, $moderador, $resposta) {
		$dados = array(
			'resposta'				=> $resposta,
			'data_add'				=> date('Y-m-d h:m:s', time()),
			'tbl_tickets_codigo'	=> $codigo,
			'tbl_moderadores_codigo'=> $moderador
		);
		
		$this->db->insert('tbl_respostas', $dados);
	}
	
	/*
	 * Seta moderador
	 */
	public function set_moderador_by_codigo($codigo, $moderador) {
		$this->db->set('tbl_moderadores_codigo', $moderador)
			     ->where('codigo', $codigo)
				 ->update('tbl_tickets');
	}
	
	/**
	 * Conta o total de reportes
	 */
	public function num_rows() {
		$q = $this->db->get('tbl_tickets');
		
		return $q->num_rows();
	}
	
	/*
	 * Procura de acordo com os parametros
	 */
	public function get_by_param($arr) {
		$q = $this->db->select('*, DATE(data_add) AS dia_add, TIME(data_add) AS hora_add, DATE(data_solu) AS dia_solu, TIME(data_solu) AS hora_solu')
					  ->from('tbl_tickets')
					  ->like($arr)
					  ->get();
		
		return $q->result();
	}
}