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

class Blog_model extends CI_Model {
	
	/**
	 * Adiciona novo post ao blog
	 */
	public function add($titulo, $post, $moderador) {
		$dados = array(
			'titulo'					=> $titulo,
			'post'						=> $post,
			'tbl_moderadores_codigo' 	=> $moderador,
			'data_add'					=> date('Y-m-d h:i:s', time())
		);
		
		$this->db->insert('tbl_blog', $dados);
	}
	
	/*
	 * Lista todos os posts
	 */
	public function get_all($offset = 0, $limit = 0) {
		$q = $this->db->select('*, tbl_blog.codigo AS codigo, DATE(tbl_blog.data_add) AS data_add, TIME(tbl_blog.data_add) AS hora_add')
					  ->from('tbl_blog')
					  ->join('tbl_moderadores', 'tbl_moderadores.codigo = tbl_moderadores_codigo')
					  ->offset($offset)
					  ->limit($limit)
					  ->order_by('tbl_blog.codigo', 'DESC')
					  ->get();
		
		return $q->result();
	}
	
	/*
	 * Pega determinado post
	 */
	public function get($codigo) {
		$q = $this->db->select('*, tbl_blog.codigo AS codigo, DATE(tbl_blog.data_add) AS data_add, TIME(tbl_blog.data_add) AS hora_add')
					  ->from('tbl_blog')
					  ->join('tbl_moderadores', 'tbl_moderadores.codigo = tbl_moderadores_codigo')
					  ->where('tbl_blog.codigo', $codigo)
					  ->get();
		
		return $q->row();
	}
	
	/**
	 * Atualiza post
	 */
	public function update($dados, $codigo) {
		$this->db->where('codigo', $codigo)
				 ->update('tbl_blog', $dados);
	}
	
	/**
	 * Deleta post
	 */
	public function delete($codigo) {
		$this->db->where('codigo', $codigo)
			     ->delete('tbl_blog');
	}
	
	/**
	 * Conta o total de posts
	 */
	public function num_rows() {
		$q = $this->db->get('tbl_blog');
		
		return $q->num_rows();
	}
}