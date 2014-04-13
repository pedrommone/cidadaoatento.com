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
					  ->where(array("NOW() BETWEEN data_add AND DATE_ADD(data_add, INTERVAL 1 DAY)" => null, 'sup' => 'S'), false)
					  ->get('tbl_avisos');
					  
		return $q->result();
	}
}