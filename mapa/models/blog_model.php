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
	 * Pega notinicas recentes de acordo com os parametros
	 */	 
	public function recentes($limiter) {
		$q = $this->db->select('tbl_blog.codigo AS codigo, titulo, post, DATE(tbl_blog.data_add) AS data_post, nome')
					  ->from('tbl_blog')
			    	  ->join('tbl_moderadores', 'tbl_moderadores.codigo = tbl_moderadores_codigo')
				 	  ->order_by('codigo', 'DESC')
				 	  ->limit($limiter)
					  ->get();
				 
		return $q->result();
	}
}