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
	
	/**
	 * Procura por uma denuncia espeficia
	 */
	public function procura($codigo) {
		$q = $this->db->select('numero_apoios, tbl_denuncias.descricao AS descricao_denuncia, tbl_tipo_problemas.descricao AS descricao_tipo, tbl_denuncias.codigo AS codigo, foto, DATE(data_add) as data_add')
					  ->from('tbl_denuncias')
					  ->join('tbl_tipo_problemas', 'tbl_tipo_problemas_codigo = tbl_tipo_problemas.codigo')
					  ->where('tbl_denuncias.codigo', $codigo)
					  ->get();
					  
		return $q->row();
	}
	
	/**
	 * Procura no banco de dados as denúncias mais próximas de acordo com as variáveis
	 */
	public function procuraRegiao($lat = 0, $lng = 0, $rad = 0) {
		
		$query = "SELECT foto, data_add, lat, lng, ( 3959 * acos( cos( radians('$lat') ) * cos( radians( lat ) ) * cos( radians( lng ) - radians('$lng') ) + sin( radians('$lat') ) * sin( radians( lat ) ) ) ) AS dist
							FROM tbl_denuncias
							WHERE invalido != 'S' AND solucionado != 'S'
							HAVING dist < '$rad'
							ORDER BY dist";
  
		$q = $this->db->query($query);
							
		return $q->result();
	}
	
	/**
	 * Lista todas as denúncias
	 */	
	public function listaTodas($array = false) {
		$q = $this->db->select('img, lat, lng, tbl_tipo_problemas.descricao AS nome, tbl_denuncias.codigo AS codigo')
					  ->from('tbl_denuncias')
					  ->join('tbl_tipo_problemas', 'tbl_tipo_problemas_codigo = tbl_tipo_problemas.codigo')
					  ->where(array('invalido' => 'N', 'solucionado' => 'N'))
					  ->get();
		
		if (! $array)
			return $q->result();
		return $q->result_array();
	}
	
	/**
	 * Adiciona uma denúncia no banco de dados
	 */
	public function adicionar($lat, $lng, $tipo, $cpf, $fot, $prefeitura, $descricao, $endereco) {
		$dados = array(
			'ip'				=> $this->input->ip_address(),
			'lat'				=> $lat,
			'lng'				=> $lng,
			'data_add'			=> date('Y-m-d h:i:s', time()),
			'tbl_tipo_problemas_codigo' => $tipo,
			'tbl_cidadaos_cpf' 	=> $cpf,
			'foto'				=> $fot,
			'descricao'			=> $descricao,
			'tbl_prefeituras_codigo'	=> $prefeitura,
			'endereco'			=> $endereco
		);
		
		$this->db->insert('tbl_denuncias', $dados);
		
		$q = $this->db->where('tbl_cidadaos_cpf', $cpf)
					  ->get('tbl_denuncias');
					  
		$this->db->where('cpf', $cpf)
				 ->set('num_denuncias', $q->num_rows())
				 ->update('tbl_cidadaos');
		
		if ($this->db->_error_message() == null) {
			$json['erro'] = 0;
			$json['html'] = 1;
		} else {
			$json['erro'] = 1;
			$json['html'] = 'Erro Ajax: Erro com banco de dados';
		}
		
		return $json;
	}
	
	/**
	 * Verifica se o cidadão está no limite de denúncias
	 */
	 
	 public function podeDenunciar($cpf, $ip) {
	 	$maximo_denuncias = 2;
		
	 	$json = array(
			'erro' => 2,
			'html' => 'Erro Ajax: Requisição inválida'
		);
		
	 	$q = $this->db->query("SELECT *
	 							FROM tbl_denuncias
								WHERE (tbl_cidadaos_cpf = $cpf OR ip = '$ip') AND data_add > DATE_SUB(NOW(), INTERVAL 1 DAY)");
		
		if ($this->db->_error_message() == null) {
			if ($q->num_rows() >= $maximo_denuncias) {
				$json['erro'] = 4;
				$json['html'] = 'Erro Ajax: Limite excedido';
			} else {
				$json['erro'] = 0;
				$json['html'] = '';
			}
		} else {
			$json['erro'] = 3;
			$json['html'] = 'Erro Ajax: Erro com banco de dados';
		}
		
		return $json;
	 }
}