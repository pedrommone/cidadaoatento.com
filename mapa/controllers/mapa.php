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

class Mapa extends CI_Controller {
	
	public function index() {
		$this->security->csrf_verify();
		/*$this->load->library('user_agent');
		
		if ($this->agent->is_mobile()) {
			$this->load->view('mobile/home/index');
		} else {*/
			$this->load->model(array('Problemas_model', 'Blog_model'));
		
			$dados = array(
				'problemas' => $this->Problemas_model->listaProblemas(),
				'blog'		=> $this->Blog_model->recentes(5),
				'csrf_nome'	=> $this->security->get_csrf_token_name(),
				'csrf_token'=> $this->security->get_csrf_hash()
			);
			
			$this->load->view('desktop/mapa/index', $dados);
		//}
	}

	public function procuraProxima($lat = null, $lng = null, $rad = null) {
		$this->security->csrf_verify();
		
		if (is_null($lat) || is_null($lng) || is_null($rad))
			redirect('/');
		
		$this->load->model('Denuncias_model');
		$denuncias = $this->Denuncias_model->procura($lat, $lng, $rad);
		
		$dom = new DOMDocument("1.0");
		$node = $dom->createElement("markers");
		$parnode = $dom->appendChild($node);

		header("Content-type: text/xml");

		foreach ($denuncias as $row){
		  $node = $dom->createElement("marker");
		  $newnode = $parnode->appendChild($node);
		  $newnode->setAttribute("foto", $row->foto);
		  $newnode->setAttribute("data_add", $row->data_add);
		  $newnode->setAttribute("lat", $row->lat);
		  $newnode->setAttribute("lng", $row->lng);		  
		  $newnode->setAttribute("dist", $row->dist);
		}
		
		echo $dom->saveXML();
	}

	public function listaTodas() {
		$this->security->csrf_verify();
				
		$this->load->model('Denuncias_model');
		$denuncias = $this->Denuncias_model->listaTodas();
		
		$dom = new DOMDocument("1.0");
		$node = $dom->createElement("markers");
		$parnode = $dom->appendChild($node);

		header("Content-type: text/xml");

		foreach ($denuncias as $row){
			$node = $dom->createElement("marker");
			$newnode = $parnode->appendChild($node);
			$newnode->setAttribute("nome", $row->nome);
			$newnode->setAttribute("foto", $row->foto);
			$newnode->setAttribute("data_add", $row->data_add);
			$newnode->setAttribute("lat", $row->lat);
			$newnode->setAttribute("lng", $row->lng);
			$newnode->setAttribute("img", $row->img);
		}
		
		echo $dom->saveXML();
	}

	public function adicionar($lat = null, $lng = null, $tipo = null) {
		$this->security->csrf_verify();
		
		if (is_null($lat) || is_null($lng) || is_null($tipo))
			redirect('/');
			
		$this->load->model('Denuncias_model');
		$this->Denuncias_model->adicionar($lat, $lng, $tipo);
	}
}

/* End of file mapa.php */
/* Location: ./application/controllers/mapa.php */