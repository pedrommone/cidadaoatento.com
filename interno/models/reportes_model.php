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

class Reportes_model extends CI_Model {
	
	/*
	 * Procura novos reportes
	 */
	public function novos() {
		$q = $this->db->select('*, DATE(tbl_reportes.data_add) AS data_add, DATE(tbl_reportes.data_solu) AS data_solu, tbl_denuncias_codigo AS codigo_denuncia, tbl_reportes.tbl_cidadaos_cpf AS cpf, tbl_reportes.codigo AS codigo')
					  ->join('tbl_denuncias', 'tbl_denuncias_codigo = tbl_denuncias.codigo')
					  ->from('tbl_reportes')
					  ->where(array('tbl_reportes.solucionado' => 'N', 'tbl_denuncias.verificada' => 'N'))
					  ->get();
				 
		return $q->result();
	}
	
	/**
	 * Pega reporte por codigo
	 */
	public function get_by_codigo($codigo) {
		$q = $this->db->select('*, DATE(data_add) AS data_add, DATE(data_solu) AS data_solu, tbl_denuncias_codigo AS codigo_denuncia, tbl_cidadaos_cpf AS cpf, tbl_reportes.codigo AS codigo')
					  ->from('tbl_reportes')
					  ->where(array('solucionado' => 'N', 'codigo' => $codigo))
					  ->get();
				 
		return $q->row();
	}
	
	/*
	 * Marca reporte como solucionado
	 */
	public function set_solucionado_by_codigo($codigo) {
		$this->db->set(array('solucionado' => 'S', 'data_solu' => date('Y-m-d h:m:s', time())))
			     ->where('codigo', $codigo)
				 ->update('tbl_reportes');
	}
	
	/**
	 * Conta o total de reportes
	 */
	public function num_rows() {
		$q = $this->db->get('tbl_reportes');
		
		return $q->num_rows();
	}
	
	/**
	 * Pega reporte por cpf
	 */
	public function get_by_cpf($cpf) {
		$q = $this->db->select('*, DATE(data_add) AS data_add, DATE(data_solu) AS data_solu, tbl_denuncias_codigo AS codigo_denuncia, tbl_cidadaos_cpf AS cpf, tbl_reportes.codigo AS codigo')
					  ->from('tbl_reportes')
					  ->where(array('solucionado' => 'N', 'tbl_cidadaos_cpf' => $cpf))
					  ->get();
				 
		return $q->result();
	}
	
}