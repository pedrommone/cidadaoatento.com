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

class Cidadaos_model extends CI_Model {
	
	/**
	 * Válida uma token e atribui uma nova token para o usuário.
	 */
	public function validaToken($token, $cpf, $tipo = 'in') {
		$json = array(
			'erro' => 1,
			'html' => 'Erro Ajax: Requisição inválida'
		);
		
		$w = array('cpf' => $cpf);
		
		if ($tipo == 'in')
			$w['token_in']  = $token;
		else
			$w['token_out'] = $token;
		
		$q = $this->db->select('*')
					  ->from('tbl_cidadaos')
					  ->where($w)
					  ->limit(1)
					  ->get();
					  
		if ( $q->num_rows() > 0 ) {
			$newToken = $this->encrypt->sha1(time() . rand(11111, 99999));
			
			$dados = array (
					 	'ultimo_login' => date('Y-m-d h:m:s', time()),
					 	'ultimo_ip' => $this->input->ip_address()
			);
			
			if ($tipo == 'in')
				$dados['token_in']  = $token;
			else
				$dados['token_out'] = $token;
			
			$this->db->where('cpf', $cpf)
					 ->update('tbl_cidadaos', $dados);
			
			if ($this->db->_error_message() == null) {
				$json['erro'] = 0;
				$json['html'] = 1;
				$json['token'] = $newToken;
			} else {
				$json['erro'] = 2;
				$json['html'] = 'Erro Ajax: Erro com banco de dados';
			}
		} else {
			$json['erro'] = 3;
			$json['html'] = 'Erro Ajax: Token inválida';
		}
		
		return $json;
	}
	
	/**
	 * Verifica se usuário é válido e/ou cria conta caso não exista
	 */
	public function login($cpf, $tel) {
		$json = array(
			'erro' => 1,
			'html' => 'Erro Ajax: Requisição inválida'
		);
		
		$tokenIn  = $this->encrypt->sha1(time() . rand(11111, 99999));
		$tokenOut = $this->encrypt->sha1(time() . rand(11111, 99999));
		
		$q = $this->db->select('*')
					  ->from('tbl_cidadaos')
					  ->where('cpf', $cpf)
					  ->or_where('telefone', $tel)
					  ->limit(1)
					  ->get();
		
		if ( $q->num_rows() > 0 ) {
			$q = $this->db->select('*')
						  ->from('tbl_cidadaos')
						  ->where(array('cpf' => $cpf, 'telefone' => $tel))
						  ->limit(1)
						  ->get();
						  
			if ( $q->num_rows() > 0 ) {
				$dados = array (
						 	'token_in'		=> $tokenIn,
							'token_out'		=> $tokenOut,
						 	'ultimo_login' 	=> date('Y-m-d h:m:s', time()),
						 	'ultimo_ip' 	=> $this->input->ip_address()
				);
				
				$this->db->where(array('cpf' => $cpf, 'telefone' => $tel))
						 ->update('tbl_cidadaos', $dados);
				
				if ($this->db->_error_message() == null) {
					$json['erro']		= 0;
					$json['html'] 		= 1;
					$json['token'] 		= $tokenOut;
				} else {
					$json['erro'] = 2;
					$json['html'] = 'Erro Ajax: Erro com banco de dados';
				}
			} else {
				$json['erro'] = 3;
				$json['html'] = 'Ajax Erro: CPF ou Telefone existentes, porem incorretos';
			}
		} else {
			$dados = array (
						'cpf' 			=> $cpf,
						'telefone'		=> $tel,
						'data_add'		=> date('Y-m-d h:m:s', time()),
						'ultimo_login' 	=> date('Y-m-d h:m:s', time()),
						'ultimo_ip' 	=> $this->input->ip_address(),
						'token_in'		=> $tokenIn,
						'token_out'		=> $tokenOut
			);
			
			$this->db->insert('tbl_cidadaos', $dados);
			
			if ( $this->db->_error_message() == null ) {
				$json['erro'] 		= 0;
				$json['html'] 		= 1;
				$json['token'] 		= $tokenOut;
			} else {
				$json['erro'] = 3;
				$json['html'] = 'Erro Ajax: Erro com banco de dados';
			}
		}
		
		return array('token' => $tokenIn, 'json' => $json);
	}
}