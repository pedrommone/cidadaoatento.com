<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

class Denuncias extends CI_Controller {
	
	public function carrega() {
		$this->security->csrf_verify();
		
		$this->load->helper('text');
		
		$codigo = $this->input->post('codigo');
		
		$json = array(
			'erro' => 0,
			'html' => ''
		);
		
		if (empty($codigo))
			$json = array(
				'erro' => 1,
				'html' => 'Erro Ajax: Dados inválidos.'
			);
		else {
			$this->load->model('Denuncias_model');
			$r = $this->Denuncias_model->procura($codigo);
			
			if (count($r) == 0)
				$json = array(
					'erro' => 2,
					'html' => 'Erro Ajax: Dados inválidos.'
				);
			else {
				$this->load->model(array('Reportes_model', 'Apoios_model'));
				$cpf = $this->session->userdata('cpf');
				
				$reportar = true;
				$apoiar	  = true;
				
				if (! is_null($cpf)) {
					$reportar = $this->Reportes_model->podeDenunciar($cpf, $codigo);
					$apoiar	  = $this->Apoios_model->podeApoiar($cpf, $codigo);
				} else {
					$reportar = false;
					$apoiar	  = false;
				}
				
				$this->load->library('googl', 'AIzaSyACAWXVZVaYQhmsBQhhwR7poAare23Eu-o');
				
				$foto = explode(".", $r->foto);
				
				$json = array(
					'descricao_tipo'	=> character_limiter($r->descricao_tipo, 10),
					'data_add'			=> converteData($r->data_add),
					'foto'				=> $foto[0],
					'ext'				=> $foto[1],
					'descricao_denuncia'=> character_limiter($r->descricao_denuncia, 90),
					'codigo'			=> $r->codigo,
					'numero_apoios'		=> $r->numero_apoios,
					'pode_reportar' 	=> $reportar,		
					'pode_apoiar'		=> $apoiar,	
					'url'				=> $this->googl->createShortcut('http://mapa.cidadaoatento.com/#' . $r->codigo)
				);
			}
		}
		
		$this->output->set_content_type('application/json')
    				 ->set_output(json_encode($json));
	}
	
	public function listaClusterer() {
		$this->security->csrf_verify();
		
		if ($this->input->post('post')) {
			$this->load->model('Denuncias_model');
			$dados = $this->Denuncias_model->listaTodas();
			
			$denuncias = array();
			
			foreach($dados as $r)		
				$denuncias[] = array(
					'img'		=> $r->img,
					'lat'		=> $r->lat,
					'lng'		=> $r->lng,
					'nome'		=> $r->nome,
					'codigo'	=> $r->codigo
				);
			
			$dados = array(
				'count' 	=> count($denuncias),
				'denuncias'	=> $denuncias
			);
			
			$this->output->set_content_type('application/json')
	    				 ->set_output(json_encode($dados));
		} else {
			$this->security->csrf_show_error();
		}
	}
	
	public function upload() {
		$config = array(
			'upload_path'		=> '/home/cidadaoatento/www/mapa/web-dir/upload/',
			'allowed_types'		=> 'jpeg|jpg|png',
			'max_size'			=> '10240',
			'encrypt_name'		=> true
		);
				
		$this->load->library('upload', $config);
				
		if ( ! $this->upload->do_upload('foto') )
			$json = array(
				'erro' => 1,
				'html' => $this->upload->display_errors()
			);
		else {
			if ( ! $res = $this->upload->data() )
				$json = array(
					'erro' => 2,
					'html' => 'Erro Ajax: Erro com o upload'
				);
			else {				
				$this->create_thumb($res['raw_name'], $res['file_ext']);
				
				$json = array(
					'erro' => 0,
					'html' => $res['raw_name'] . $res['file_ext']
				);
			}
		}
		
		echo json_encode($json);
	}
	
	public function reportar() {
		$this->security->csrf_verify();
		
		$token = $this->input->post('token');
		$codig = $this->input->post('codigo');
		$cpf   = $this->session->userdata('cpf');
		$ip    = $this->input->ip_address();
		
		if ( ! $this->session->userdata('logado'))
			$json = array(
				'erro' => 2,
				'html' => 'Erro Ajax: Dados inválidos'
			);
		else {
			$this->load->model('Denuncias_model');
			$dados = $this->Denuncias_model->podeDenunciar($this->session->userdata('cpf'), $this->input->ip_address());
			
			if ($dados['erro'] == 0) {			
				if (empty($codig)) {
					$json = array(
						'erro' => 3,
						'html' => 'Erro Ajax: Dados inválidos'
					);				
				} else {
					$this->load->model('Reportes_model');						
					if ($this->Reportes_model->podeDenunciar($cpf, $ip)) {
						$json = $this->Reportes_model->adicionar($codig, $cpf);
					} else {
						$json = array(
							'erro' => 4,
							'html' => 'Erro Ajax: Dados inválidos'
						);	
					}				
				}
			} else {
				$json = array(
					'erro' => 5,
					'html' => 'Limite excedido'
				);
			}
		}
		
		$this->output->set_content_type('application/json')
    				 ->set_output(json_encode($json));
	}
	
	public function apoiar() {
		$this->security->csrf_verify();
		
		$token = $this->input->post('token');
		$codig = $this->input->post('codigo');
		$cpf   = $this->session->userdata('cpf');
		
		if ( ! $this->session->userdata('logado'))
			$json = array(
				'erro' => 3,
				'html' => 'Erro Ajax: Dados inválidos'
			);
		else {
			if (empty($codig)) {
				$json = array(
					'erro' => 4,
					'html' => 'Erro Ajax: Dados inválidos'
				);				
			} else {
				$this->load->model('Apoios_model');
				
				if ($this->Apoios_model->podeApoiar($cpf, $codig))				
					$json = $this->Apoios_model->adicionar($codig, $cpf);
				else
					$json = array(
						'erro' => 5,
						'html' => 'Erro Ajax: Dados inválidos'
					);			
			}
		}
		
		$this->output->set_content_type('application/json')
    				 ->set_output(json_encode($json));
	}

	public function adicionar() {
		$this->security->csrf_verify();
		
		$key = "ABQIAAAAhdDokCu8GspRD8rZaYYaoRR5dndtY5oS-GFuRoRAautbbsCzexTbXFh0ItLJ_JAtzGaD1Nh8I-kRzQ";
						
		$lat = $this->input->post('lat');
		$lng = $this->input->post('lng');
		$tip = $this->input->post('tip');
		$fot = $this->input->post('fot');
		$cpf = $this->session->userdata('cpf');
		$descricao = substr($this->input->post('descricao'), 0, 100);
		
		$json = array();
		
		if ( ! $this->session->userdata('logado'))
			$json = array(
				'erro' => 3,
				'html' => 'Erro Ajax: Dados inválidos'
			);
		else {		
			if (empty($lat) || empty($lng) || empty($tip))
				$json = array(
					'erro' => 4,
					'html' => 'Erro Ajax: Dados inválidos'
				);
			else {
				$this->load->model(array('Denuncias_model', 'Prefeituras_model'));
				
				$url = "http://maps.google.com/maps/geo?q=$lat,$lng&output=json&key=" . $key;
				
				$json_content = file_get_contents($url);
				$data = json_decode($json_content);
				
				$uf 	= $data->Placemark[0]->AddressDetails->Country->AdministrativeArea->AdministrativeAreaName;
				$cidade	= $data->Placemark[0]->AddressDetails->Country->AdministrativeArea->Locality->LocalityName;
				$end	= $data->Placemark[0]->address;
				
				($cidade ? "" : $cidade = "N/A");
				($end ? "" : $end = "N/A");
			
				$prefeitura = $this->Prefeituras_model->registrada($cidade, $uf);
				
				if ($prefeitura['erro'] == 2) {
					$json = $this->Prefeituras_model->add($cidade, $uf);
					$prefeitura = $json;
				}
				
				if ($json['erro'] == 0)
					$json = $this->Denuncias_model->adicionar($lat, $lng, $tip, $cpf, $fot, $prefeitura['html'], $descricao, $end);
			}
		}
				
		echo json_encode($json);
	}

	protected function create_thumb($nome, $formato) {
		$this->load->library('image_moo');
		
		$base 		= '/home/cidadaoatento/www/mapa/web-dir/upload/' . $nome . $formato;
		$final 		= '/home/cidadaoatento/www/mapa/web-dir/upload/' . $nome . '_thumb' . $formato;
		
		$this->image_moo->load($base)
						->resize_crop(210, 210)
        				->save($final);
	}
}

/* End of file denuncias.php */
/* Location: ./application/controllers/denuncias.php */