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

class Estatisticas extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if (! $this->session->userdata('logado'))
			redirect('/login');
		
		$this->output->enable_profiler(FALSE);
		
		$this->load->model('Avisos_model');
		
		$this->dados = array(
			'codigo'		=> $this->session->userdata('codigo'),
			'sigla'			=> $this->session->userdata('sigla'),
			'ultimo_login'	=> $this->session->userdata('ultimo_login'),
			'avisos'	=> $this->Avisos_model->get_aviso()
		);
	}
	
	public function ranking() {
		$this->load->model('Estatisticas_model');		
		
		$this->dados['graficos'] = array(
			array(
				'nome'	=> 'Municipios com mais denúncias.',
				'dados' => $this->Estatisticas_model->municipios_com_mais_denuncias()
			),
			array(
				'nome'	=> 'Problemas mais frequentes.',
				'dados'	=> $this->Estatisticas_model->problemas_mais_usados()
			),
			array(
				'nome'	=> 'Municipios com mais denúncias pendentes',
				'dados' => $this->Estatisticas_model->municipios_com_mais_denuncias_abertas(),
			),
			array(
				'nome'	=> 'Municipios com mais denúncias solucionadas',
				'dados'	=> $this->Estatisticas_model->municipios_com_mais_denuncias_solucionadas()
			)
		);
		
		montaPagina('/estatisticas/ranking', $this->dados);
	}
}

/* End of file Geral.php */
/* Location: ./application/controllers/dashboard.php */