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


class Denuncias_model extends CI_Model {
	
	/*
	 * Lista todas denúncias
	 */
	public function get() {
		$q = $this->db->select('verificada, tbl_tipo_problemas.codigo AS codigo_problema, tbl_denuncias.codigo AS codigo, tbl_denuncias.foto AS foto, DATE(tbl_denuncias.data_add) AS data_add, DATE(tbl_denuncias.data_solu) AS data_solu, invalido, solucionado, tbl_tipo_problemas.descricao AS nome_problema, municipio, uf, tbl_denuncias.descricao AS descricao, numero_apoios')
					  ->from('tbl_denuncias')
					  ->join('tbl_tipo_problemas', 'tbl_tipo_problemas_codigo = tbl_tipo_problemas.codigo')
					  ->join('tbl_prefeituras', 'tbl_prefeituras_codigo = tbl_prefeituras.codigo')
					  ->where('invalido', 'N')
					  ->get();
		
		return $q->result();
	}
	
	/*
	 * Procura por codigo
	 */
	public function get_by_codigo($codigo, $municipio) {
		$q = $this->db->select('endereco, verificada, tbl_tipo_problemas.codigo AS codigo_problema, tbl_denuncias.codigo AS codigo, tbl_denuncias.foto AS foto, DATE(tbl_denuncias.data_add) AS data_add, TIME(tbl_denuncias.data_add) AS hora_add, DATE(tbl_denuncias.data_solu) AS data_solu, TIME(tbl_denuncias.data_solu) AS hora_solu, invalido, solucionado, tbl_tipo_problemas.descricao AS nome_problema, municipio, uf, tbl_denuncias.descricao AS descricao, numero_apoios')
					  ->from('tbl_denuncias')
					  ->join('tbl_tipo_problemas', 'tbl_tipo_problemas_codigo = tbl_tipo_problemas.codigo')
					  ->join('tbl_prefeituras', 'tbl_prefeituras_codigo = tbl_prefeituras.codigo')
					  ->where(array('tbl_denuncias.codigo' => $codigo, 'tbl_prefeituras_codigo' => $municipio, 'invalido' => 'N'))
					  ->get();
		
		return $q->row();
	}

	/*
	 * Procura por municipio
	 */
	public function get_by_municipio($municipio, $offset = 0, $limit = 15) {
		$q = $this->db->select('endereco, verificada, tbl_tipo_problemas.codigo AS codigo_problema, tbl_denuncias.codigo AS codigo, tbl_denuncias.foto AS foto, DATE(tbl_denuncias.data_add) AS data_add, DATE(tbl_denuncias.data_solu) AS data_solu, invalido, solucionado, tbl_tipo_problemas.descricao AS nome_problema, municipio, uf, tbl_denuncias.descricao AS descricao, numero_apoios')
					  ->from('tbl_denuncias')
					  ->join('tbl_tipo_problemas', 'tbl_tipo_problemas_codigo = tbl_tipo_problemas.codigo')
					  ->join('tbl_prefeituras', 'tbl_prefeituras_codigo = tbl_prefeituras.codigo')
					  ->where(array('tbl_prefeituras_codigo' => $municipio, 'solucionado' => 'N', 'invalido' => 'N'))
					  ->offset($offset)
					  ->limit($limit)
					  ->order_by('tbl_denuncias.codigo')
					  ->get();
		
		return $q->result();
	}

	/*
	 * Procura por municipio
	 */
	public function get_all_by_municipio($municipio, $offset = 0, $limit = 15) {
		$q = $this->db->select('endereco, verificada, tbl_tipo_problemas.codigo AS codigo_problema, tbl_denuncias.codigo AS codigo, tbl_denuncias.foto AS foto, DATE(tbl_denuncias.data_add) AS data_add, DATE(tbl_denuncias.data_solu) AS data_solu, invalido, solucionado, tbl_tipo_problemas.descricao AS nome_problema, municipio, uf, tbl_denuncias.descricao AS descricao, numero_apoios')
					  ->from('tbl_denuncias')
					  ->join('tbl_tipo_problemas', 'tbl_tipo_problemas_codigo = tbl_tipo_problemas.codigo')
					  ->join('tbl_prefeituras', 'tbl_prefeituras_codigo = tbl_prefeituras.codigo')
					  ->where(array('tbl_prefeituras_codigo' => $municipio, 'invalido' => 'N'))
					  ->offset($offset)
					  ->limit($limit)
					  ->order_by('tbl_denuncias.codigo')
					  ->get();
		
		return $q->result();
	}

	/*
	 * Procura por código do municipio
	 */
	public function get_by_cidade($codigo) {
		$q = $this->db->select('lat, lng')
				      ->from('tbl_denuncias')
					  ->join('tbl_prefeituras', 'tbl_prefeituras_codigo = tbl_prefeituras.codigo')
					  ->where(array('tbl_prefeituras.codigo' => $codigo, 'invalido' => 'N', 'invalido' => 'N'))
					  ->get();
					  
		return $q->result_array();
	}

	/*
	 * Procura de acordo com os parametros
	 */
	public function get_by_param($arr, $municipio) {
		$q = $this->db->select('verificada, tbl_tipo_problemas.codigo AS codigo_problema, tbl_denuncias.codigo AS codigo, tbl_denuncias.foto AS foto, DATE(tbl_denuncias.data_add) AS data_add, DATE(tbl_denuncias.data_solu) AS data_solu, invalido, solucionado, tbl_tipo_problemas.descricao AS nome_problema, municipio, uf, tbl_denuncias.descricao AS descricao, numero_apoios')
					  ->from('tbl_denuncias')
					  ->join('tbl_tipo_problemas', 'tbl_tipo_problemas_codigo = tbl_tipo_problemas.codigo')
					  ->join('tbl_prefeituras', 'tbl_prefeituras_codigo = tbl_prefeituras.codigo')
					  ->like($arr)
					  ->where(array('invalido' => 'N', 'tbl_prefeituras_codigo' => $municipio))
					  ->get();
		
		return $q->result();
	}

	/*
	 * Define como solucionada de acordo com o codigo
	 */
	public function set_solucionada_by_codigo($codigo, $municipio) {
		$this->db->set('solucionado', 'S')
				 ->where(array('codigo' => $codigo, 'tbl_prefeituras_codigo' => $municipio, 'invalido' => 'N'))
				 ->update('tbl_denuncias');
	}
	
	/**
	 * Conta o total de denuncias
	 */
	public function num_rows_by_municipio($codigo) {
		$q = $this->db->select('numero_apoios')
					  ->from('tbl_denuncias')
					  ->where(array('tbl_prefeituras_codigo' => $codigo, 'invalido' => 'N', 'solucionado' => 'N'))
					  ->get();
		
		return $q->num_rows();
	}

	/**
	 * Conta o total de denuncias
	 */
	public function num_rows_all_by_municipio($codigo) {
		$q = $this->db->select('numero_apoios')
					  ->from('tbl_denuncias')
					  ->where(array('tbl_prefeituras_codigo' => $codigo, 'invalido' => 'N'))
					  ->get();
		
		return $q->num_rows();
	}

	/**
	 * Conta o total de denuncias solucionadas
	 */
	public function num_rows_solucionadas_by_municipio($codigo) {
		$q = $this->db->select('numero_apoios')
					  ->from('tbl_denuncias')
					  ->where(array('tbl_prefeituras_codigo' => $codigo, 'invalido' => 'N', 'solucionado' => 'S'))
					  ->get();
		
		return $q->num_rows();
	}
	
	/**
	 * Conta o total de denuncias não solucionadas
	 */
	public function num_rows_pendentes_by_municipio($codigo) {
		$q = $this->db->select('numero_apoios')
					  ->from('tbl_denuncias')
					  ->where(array('tbl_prefeituras_codigo' => $codigo, 'invalido' => 'N', 'solucionado' => 'N'))
					  ->get();
		
		return $q->num_rows();
	}

	/*
	 * Conta o total de apoios vindos de um municipio
	 */
	public function num_rows_apoios_by_municipio($codigo) {
		$q = $this->db->select_sum('numero_apoios')
					  ->from('tbl_denuncias')
					  ->where(array('tbl_prefeituras_codigo' => $codigo, 'invalido' => 'N'))
					  ->get();
		
		return $q->num_rows();
	}
	
	/**
	 * Conta o total de cidadãos de um municipio
	 */
	public function num_rows_cidadaos_by_municipio($codigo) {
		$q = $this->db->select('numero_apoios')
					  ->from('tbl_denuncias')
					  ->where(array('tbl_prefeituras_codigo' => $codigo, 'invalido' => 'N', 'solucionado' => 'N'))
					  ->group_by('tbl_cidadaos_cpf')
					  ->get();
		
		return $q->num_rows();
	}
	
	/**
	 * Conta o total de denuncias por municipio
	 */
	public function num_rows_by_cpf($municipio) {
		$q = $this->db->where(array('tbl_prefeituras_codigo' => $municipio, 'invalido' => 'N'))
					  ->get('tbl_denuncias');
		
		return $q->num_rows();
	}
	
}