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

	public function __construct() {
		parent::__construct();
		
		if (! $this->session->userdata('logado'))
			redirect('/login');
		
		$this->output->enable_profiler(FALSE);
		
		$this->load->model('Avisos_model');
		
		$this->dados = array(
			'codigo'		=> $this->session->userdata('codigo'),
			'uf'			=> $this->session->userdata('uf'),
			'municipio'		=> $this->session->userdata('municipio'),
			'ultimo_login'	=> $this->session->userdata('ultimo_login'),
			'avisos'	=> $this->Avisos_model->get_aviso()
		);
	}
	
	public function heatmap() {
		$this->load->model('Denuncias_model');
		$points = $this->Denuncias_model->get_by_cidade($this->dados['codigo']);
		
		$this->output->set_content_type('application/json')
    				 ->set_output(json_encode($points));	
	}
	
	public function geral() {
		$this->load->model('Denuncias_model');
		
		$this->dados['numero_denuncias']	= $this->Denuncias_model->num_rows_by_municipio($this->dados['codigo']);
		$this->dados['numero_pendentes']	= $this->Denuncias_model->num_rows_pendentes_by_municipio($this->dados['codigo']);
		$this->dados['numero_solucionadas']	= $this->Denuncias_model->num_rows_solucionadas_by_municipio($this->dados['codigo']);
		$this->dados['numero_apoios']		= $this->Denuncias_model->num_rows_apoios_by_municipio($this->dados['codigo']);
		$this->dados['numero_cidadaos']		= $this->Denuncias_model->num_rows_cidadaos_by_municipio($this->dados['codigo']);
				
		montaPagina('/denuncias/geral', $this->dados);
	}

	public function pendentes($offset = null, $limit = 15) {
		$this->load->model('Denuncias_model');
		$this->load->library('pagination');
		
		$paginacao = array(
			'base_url'			=> 'http://sup.cidadaoatento.com/denuncias/pendentes',
			'total_rows'		=> $this->Denuncias_model->num_rows_by_municipio($this->dados['codigo']),
			'per_page'			=> $limit,
			'num_links'			=> 10,
			'full_tag_open'		=> '<div class="pagination"><ul>',
			'full_tag_close'	=> '</ul></div>',
			'first_link'		=> 'Primeiro',
			'first_tag_open'	=> '<li>',
			'first_tag_close'	=> '</li>',
			'last_link'			=> 'Último',
			'last_tag_open'		=> '<li>',
			'last_tag_close'	=> '</li>',
			'next_tag_open'		=> '<li>',
			'next_tag_close'	=> '</li>',
			'prev_tag_open'		=> '<li>',
			'prev_tag_close'	=> '<li>',
			'cur_tag_open'		=> '<li class="active"><a href="#">',
			'cur_tag_close'		=> '</a><li/>',
			'num_tag_open'		=> '<li>',
			'num_tag_close'		=> '<li/>'
		);
		
		$this->pagination->initialize($paginacao); 
		
		$this->dados['dados'] = $this->Denuncias_model->get_by_municipio($this->dados['codigo'], $offset, $limit);
		$this->dados['pag']	  = $this->pagination->create_links();
		
		montaPagina('/denuncias/pendentes', $this->dados);
	}

	public function todas($offset = null, $limit = 15) {
		$this->load->model('Denuncias_model');
		$this->load->library('pagination');
		
		$paginacao = array(
			'base_url'			=> 'http://sup.cidadaoatento.com/denuncias/todas',
			'total_rows'		=> $this->Denuncias_model->num_rows_all_by_municipio($this->dados['codigo']),
			'per_page'			=> $limit,
			'num_links'			=> 10,
			'full_tag_open'		=> '<div class="pagination"><ul>',
			'full_tag_close'	=> '</ul></div>',
			'first_link'		=> 'Primeiro',
			'first_tag_open'	=> '<li>',
			'first_tag_close'	=> '</li>',
			'last_link'			=> 'Último',
			'last_tag_open'		=> '<li>',
			'last_tag_close'	=> '</li>',
			'next_tag_open'		=> '<li>',
			'next_tag_close'	=> '</li>',
			'prev_tag_open'		=> '<li>',
			'prev_tag_close'	=> '<li>',
			'cur_tag_open'		=> '<li class="active"><a href="#">',
			'cur_tag_close'		=> '</a><li/>',
			'num_tag_open'		=> '<li>',
			'num_tag_close'		=> '<li/>'
		);
		
		$this->pagination->initialize($paginacao); 
		
		$this->dados['dados'] = $this->Denuncias_model->get_all_by_municipio($this->dados['codigo'], $offset, $limit);
		$this->dados['pag']	  = $this->pagination->create_links();
		
		montaPagina('/denuncias/todas', $this->dados);
	}

	public function solucionar($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {
			$sim = $this->input->post('sim');
			
			if (! empty($sim)) {
				$this->load->model('Denuncias_model');
				$this->Denuncias_model->set_solucionada_by_codigo($codigo, $this->dados['codigo']);
				montaPagina('/denuncias/sucesso_solucionar', $this->dados);
			} else {
				montaPagina('/denuncias/solucionar', $this->dados);
			}
		}
	}

	public function procurar() {		
		montaPagina('/denuncias/procurar', $this->dados);
	}
	
	public function simples() {
		$this->load->library('form_validation');
		
		$regras = array(
        	array(
            	'field'	=> 'codigo', 
                'label'	=> 'Codigo', 
                'rules'	=> 'required|integer'
        	)
        );			
		
		$this->form_validation->set_rules($regras);
		
		$this->load->model('Denuncias_model');
		
		if ($this->form_validation->run()) {
			$codigo = $this->input->post('codigo');
			$dados = $this->Denuncias_model->get_by_codigo($codigo, $this->dados['codigo']);
			
			if (empty($dados))
				montaPagina('/denuncias/nao_encontrado', $this->dados);
			else
				redirect('/denuncias/ver/' . $codigo);
		} else {
			montaPagina('/denuncias/procurar_validadores', $this->dados);
		}
	}

	public function avancada() {
		$this->load->library('form_validation');
		
		$regras = array(
			array(
				'field' => 'solucionada',
				'label' => 'Solucionada',
				'rules' => 'required'
			),
			array(
				'field' => 'invalida',
				'label' => 'Inválida',
				'rules' => 'required'
			),
			array(
				'field' => 'problema',
				'label' => 'Tipo de problema',
				'rules' => 'required'
			)
		);
		
		$this->form_validation->set_rules($regras);
		
		$this->load->model('Denuncias_model');
		
		$param = array();
		
		if ($this->form_validation->run()) {
			$invalida  		= $this->input->post('invalida');
			$solucionada 	= $this->input->post('solucionada');
			$problema 		= $this->input->post('problema');
			
			if ($invalida != "T")
				$param['invalido'] = $invalida;
			if ($solucionada != "T")
				$param['solucionado'] = $solucionada;
			if ($problema != "T")
				$param['tbl_tipo_problemas.descricao'] = $problema;
			
			$this->dados['dados'] = $this->Denuncias_model->get_by_param($param, $this->dados['codigo']);
			
			if (empty($this->dados['dados']))
				montaPagina('/denuncias/nao_encontrado', $this->dados);
			else
				montaPagina('/denuncias/listar', $this->dados);
		} else {
			montaPagina('/denuncias/procurar_validadores', $this->dados);
		}
	}

	public function ver($codigo = null) {
		if (is_null($codigo))
			show_404();
		else {
			$this->load->model('Denuncias_model');
			
			$this->dados['d'] = $this->Denuncias_model->get_by_codigo($codigo, $this->dados['codigo']);
				
			if (empty($this->dados['d']))
				montaPagina('/denuncias/nao_encontrado', $this->dados);
			else
				montaPagina('/denuncias/ver', $this->dados);
		}
	}
}

/* End of file Denuncias.php */
/* Location: ./application/controllers/dashboard.php */