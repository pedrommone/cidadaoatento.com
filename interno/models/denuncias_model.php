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
	public function get($offset = 0, $limit = 0) {
		$q = $this->db->select('verificada, tbl_tipo_problemas.codigo AS codigo_problema, tbl_denuncias.codigo AS codigo, tbl_denuncias.foto AS foto, DATE(tbl_denuncias.data_add) AS data_add, DATE(tbl_denuncias.data_solu) AS data_solu, invalido, solucionado, tbl_tipo_problemas.descricao AS nome_problema, municipio, uf, tbl_denuncias.descricao AS descricao, numero_apoios')
					  ->from('tbl_denuncias')
					  ->join('tbl_tipo_problemas', 'tbl_tipo_problemas_codigo = tbl_tipo_problemas.codigo')
					  ->join('tbl_prefeituras', 'tbl_prefeituras_codigo = tbl_prefeituras.codigo')
					  ->offset($offset)
					  ->limit($limit)
					  ->order_by('tbl_denuncias.codigo')
					  ->get();
		
		return $q->result();
	}
	
	/*
	 * Procura por codigo
	 */
	public function get_by_codigo($codigo) {
		$q = $this->db->select('endereco, verificada, tbl_tipo_problemas.codigo AS codigo_problema, tbl_denuncias.codigo AS codigo, tbl_denuncias.foto AS foto, DATE(tbl_denuncias.data_add) AS data_add, TIME(tbl_denuncias.data_add) AS hora_add, DATE(tbl_denuncias.data_solu) AS data_solu, TIME(tbl_denuncias.data_solu) AS hora_solu, invalido, solucionado, tbl_tipo_problemas.descricao AS nome_problema, municipio, uf, tbl_denuncias.descricao AS descricao, numero_apoios')
					  ->from('tbl_denuncias')
					  ->join('tbl_tipo_problemas', 'tbl_tipo_problemas_codigo = tbl_tipo_problemas.codigo')
					  ->join('tbl_prefeituras', 'tbl_prefeituras_codigo = tbl_prefeituras.codigo')
					  ->where('tbl_denuncias.codigo', $codigo)
					  ->get();
		
		return $q->row();
	}

	/*
	 * Procura por cpf
	 */
	public function get_by_cpf($cpf, $offset, $limit) {
		$q = $this->db->select('verificada, tbl_tipo_problemas.codigo AS codigo_problema, tbl_denuncias.codigo AS codigo, tbl_denuncias.foto AS foto, DATE(tbl_denuncias.data_add) AS data_add, TIME(tbl_denuncias.data_add) AS hora_add, DATE(tbl_denuncias.data_solu) AS data_solu, TIME(tbl_denuncias.data_solu) AS hora_solu, invalido, solucionado, tbl_tipo_problemas.descricao AS nome_problema, municipio, uf, tbl_denuncias.descricao AS descricao, numero_apoios')
					  ->from('tbl_denuncias')
					  ->join('tbl_tipo_problemas', 'tbl_tipo_problemas_codigo = tbl_tipo_problemas.codigo')
					  ->join('tbl_prefeituras', 'tbl_prefeituras_codigo = tbl_prefeituras.codigo')
					  ->where('tbl_cidadaos_cpf', $cpf)
					  ->offset($offset)
					  ->limit($limit)
					  ->get();
		
		return $q->result();
	}

	/*
	 * Procura por prefeitura
	 */
	public function get_by_prefeitura($codigo) {
		$q = $this->db->select('DATE(tbl_denuncias.data_add) AS data_add, TIME(tbl_denuncias.data_add) AS hora_add, numero_apoios, tbl_denuncias.codigo AS codigo, tbl_denuncias.descricao AS descricao, tbl_tipo_problemas.descricao AS problema')
					  ->from('tbl_denuncias')
					  ->join('tbl_tipo_problemas', 'tbl_tipo_problemas_codigo = tbl_tipo_problemas.codigo')
					  ->where(array('invalido' => 'N', 'tbl_prefeituras_codigo' => $codigo, 'solucionado' => 'N'))
					  ->get();
		
		return $q->result();
	}
	
	/*
	 * Procura de acordo com os parametros
	 */
	public function get_by_param($arr) {
		$q = $this->db->select('verificada, tbl_tipo_problemas.codigo AS codigo_problema, tbl_denuncias.codigo AS codigo, tbl_denuncias.foto AS foto, DATE(tbl_denuncias.data_add) AS data_add, DATE(tbl_denuncias.data_solu) AS data_solu, invalido, solucionado, tbl_tipo_problemas.descricao AS nome_problema, municipio, uf, tbl_denuncias.descricao AS descricao, numero_apoios')
					  ->from('tbl_denuncias')
					  ->join('tbl_tipo_problemas', 'tbl_tipo_problemas_codigo = tbl_tipo_problemas.codigo')
					  ->join('tbl_prefeituras', 'tbl_prefeituras_codigo = tbl_prefeituras.codigo')
					  ->like($arr)
					  ->get();
		
		return $q->result();
	}
	
	/*
	 * Define como inválida de acordo com oodigo
	 */
	public function set_invalida_by_codigo($codigo) {
		$this->db->set('invalido', 'S')
				 ->where('codigo', $codigo)
				 ->update('tbl_denuncias');
	}

	/*
	 * Define como valida de acordo com o codigo
	 */
	public function set_valida_by_codigo($codigo) {
		$this->db->set('invalido', 'N')
				 ->where('codigo', $codigo)
				 ->update('tbl_denuncias');
	}

	/*
	 * Define como valida de acordo com o codigo
	 */
	public function set_verificada_by_codigo($codigo) {
		$this->db->set('verificada', 'S')
				 ->where('codigo', $codigo)
				 ->update('tbl_denuncias');
	}

	/*
	 * Define como valida de acordo com o codigo
	 */
	public function set_naoverificada_by_codigo($codigo) {
		$this->db->set('verificada', 'N')
				 ->where('codigo', $codigo)
				 ->update('tbl_denuncias');
	}
	
	/**
	 * Conta o total de denuncias
	 */
	public function num_rows() {
		$q = $this->db->get('tbl_denuncias');
		
		return $q->num_rows();
	}
	
	/**
	 * Conta o total de denuncias por cpf
	 */
	public function num_rows_by_cpf($cpf) {
		$q = $this->db->where('tbl_cidadaos_cpf', $cpf)
					  ->get('tbl_denuncias');
		
		return $q->num_rows();
	}
	
	/*
	 * Procura por codigo
	 */
	public function get_by_apoios_and_orgao($num_apoios, $codigo_orgao) {
		$q = $this->db->select('DATE(tbl_denuncias.data_add) AS data_add, TIME(tbl_denuncias.data_add) AS hora_add, numero_apoios, tbl_denuncias.codigo AS codigo, tbl_denuncias.descricao AS descricao, tbl_tipo_problemas.descricao AS problema')
					  ->from('tbl_denuncias')
					  ->join('tbl_tipo_problemas', 'tbl_tipo_problemas_codigo = tbl_tipo_problemas.codigo')
					  ->where(array('numero_apoios >=' => $num_apoios, 'invalido' => 'N', 'tbl_orgaos_codigo' => $codigo_orgao, 'solucionado' => 'N'))
					  ->get();
		
		return $q->result();
	}
}