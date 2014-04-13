<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Migre_me {
	private $_api = "http://migre.me/api.json?url=";
	private $_target, $_erro, $_info, $_criado_em, $_url, $_id, $_migre, $_ping, $_consumo_api_hora, $_tempo;
	
	private function get() {
		$json = json_decode(file_get_contents($this->_api . urlencode($this->_target)));
		
		$this->_erro				= $json->erro;
		$this->_info				= $json->info;
		$this->_criado_em			= $json->criado_em;
		$this->_url					= $json->url;
		$this->_id					= $json->id;
		$this->_migre				= $json->migre;
		$this->_ping				= $json->ping;
		$this->_consumo_api_hora	= $json->consumo_api_hora;
		$this->_tempo				= $json->tempo;
	}
	
	public function set_target($url) {
		$this->_target = $url;
	}
	
	public function encurta() {
		$this->get();
		return $this->_migre;
	}
}