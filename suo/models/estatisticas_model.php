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

class Estatisticas_model extends CI_Model {
	public function municipios_com_mais_denuncias($max = 10, $ordem = 'desc') {
		$q = $this->db->select('tbl_prefeituras.municipio AS nome, COUNT(tbl_denuncias.codigo) AS total')
						 ->from('tbl_prefeituras')
						 ->join('tbl_denuncias', 'tbl_prefeituras_codigo = tbl_prefeituras.codigo')
						 ->where('tbl_denuncias.invalido', 'N')
						 ->order_by('total', $ordem)
						 ->group_by('tbl_prefeituras.codigo')
						 ->limit($max)
						 ->get();
		
		return $q->result();
	}
	
	public function problemas_mais_usados($max = 10, $ordem = 'desc') {
		$q = $this->db->select('tbl_tipo_problemas.descricao AS nome, COUNT(tbl_tipo_problemas.codigo) AS total')
						 ->from('tbl_tipo_problemas')
						 ->join('tbl_denuncias', 'tbl_tipo_problemas.codigo = tbl_tipo_problemas_codigo')
						 ->where('tbl_denuncias.invalido', 'N')
						 ->order_by('total', $ordem)
						 ->group_by('tbl_tipo_problemas.codigo')
						 ->get();
				 
		return $q->result();
	}
	
	public function municipios_com_mais_denuncias_abertas($max = 10, $ordem = 'desc') {
		$q = $this->db->select('tbl_prefeituras.municipio AS nome, COUNT(tbl_denuncias.codigo) AS total')
						 ->from('tbl_prefeituras')
						 ->join('tbl_denuncias', 'tbl_prefeituras_codigo = tbl_prefeituras.codigo')
						 ->where(array('tbl_denuncias.invalido' => 'N', 'tbl_denuncias.solucionado' => 'N'))
						 ->order_by('total', $ordem)
						 ->group_by('tbl_prefeituras.codigo')
						 ->limit($max)
						 ->get();
		
		return $q->result();
	}
	
	public function municipios_com_mais_denuncias_solucionadas($max = 10, $ordem = 'desc') {
		$q = $this->db->select('tbl_prefeituras.municipio AS nome, COUNT(tbl_denuncias.codigo) AS total')
						 ->from('tbl_prefeituras')
						 ->join('tbl_denuncias', 'tbl_prefeituras_codigo = tbl_prefeituras.codigo')
						 ->where(array('tbl_denuncias.invalido' => 'N', 'tbl_denuncias.solucionado' => 'S'))
						 ->order_by('total', $ordem)
						 ->group_by('tbl_prefeituras.codigo')
						 ->limit($max)
						 ->get();
		
		return $q->result();
	}
}