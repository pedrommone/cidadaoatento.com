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

class Problemas extends CI_Controller {

	public function __construct() {
		parent::__construct();
		
		if (! $this->session->userdata('logado'))
			redirect('/login');
		
		$this->output->enable_profiler(FALSE);
		
		$this->load->model('Avisos_model');
		
		$this->dados = array(
			'avisos'	=> $this->Avisos_model->get_aviso(),
			'nome'		=> $this->session->userdata('nome'),
			'codigo'	=> $this->session->userdata('moderador')
		);
		
		$this->output->set_header("Expires: Tue, 01 Jan 2000 00:00:00 GMT"); 
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); 
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false); 
		$this->output->set_header("Pragma: no-cache");
	}
	
	public function listar($offset = null, $limit = 15) {
		$this->load->model('Problemas_model');
		$this->load->library('pagination');
		
		$paginacao = array(
			'base_url'			=> 'http://interno.cidadaoatento.com/denuncias/listar',
			'total_rows'		=> $this->Problemas_model->num_rows(),
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
		
		$this->dados['pag']	  = $this->pagination->create_links();
		$this->dados['dados'] = $this->Problemas_model->get($offset, $limit);
		
		montaPagina('/problemas/listar', $this->dados);
	}

	public function cadastrar() {
		$this->load->library('form_validation');		
		
		$regras = array(
			array(
				'field'   => 'descricao', 
				'label'   => 'Descrição', 
 				'rules'   => 'required|min_length[10]|max_length[45]'
				)
		);
		
		$this->form_validation->set_rules($regras);		
		
		if ($this->form_validation->run()) {
			$upload = array(
				'upload_path'		=> '/home/cidadaoatento/www/mapa/web-dir/upload/',
				'allowed_types'		=> 'gif|jpg|png|jpeg',
				'max_size'			=> '10240',
				'encrypt_name'		=> true
			);
			
			$this->load->library('upload', $upload);
			
			if ( $this->upload->do_upload('imagem') ) {
				if ( $res = $this->upload->data() ) {					
					$this->load->library('image_moo');
					
					$base 	= '/home/cidadaoatento/www/mapa/web-dir/upload/' . $res['raw_name'] . $res['file_ext'];
					$final 	= '/home/cidadaoatento/www/mapa/web-dir/upload/' . $res['raw_name'] . '_ico' . $res['file_ext'];
					
					$this->image_moo->load($base)
									->resize_crop(64, 64)
        							->save($final);
									
					$this->load->model('Problemas_model');
					
					$img 		= $res['raw_name'] . $res['file_ext'];
					$descricao 	= $this->input->post('descricao');
					$orgao		= $this->input->post('orgao');
					
					$this->Problemas_model->add($descricao, $img, $orgao);
					
					montaPagina('/problemas/sucesso', $this->dados);
				}
			}
		} else {
			$this->load->model('Orgaos_model');
			$this->dados['orgaos'] = $this->Orgaos_model->get_all();		
			montaPagina('/problemas/cadastrar', $this->dados);
		}
	}
	
	public function procurar() {
		$this->load->library('form_validation');
		
		$regras = array(
        	array(
            	'field'	=> 'codigo', 
                'label'	=> 'Codigo', 
                'rules'	=> 'required|integer'
        	)
        );			
		
		$this->form_validation->set_rules($regras);
		
		$this->load->model('Problemas_model');
		
		if ($this->form_validation->run()) {
			$codigo = $this->input->post('codigo');
			$dados = $this->Problemas_model->get_by_codigo($codigo);
			
			if (empty($dados))
				montaPagina('/problemas/nao_encontrado', $this->dados);
			else
				redirect('/problemas/ver/' . $codigo);
		} else {
			montaPagina('/problemas/procurar', $this->dados);
		}		
	}
	
	public function ver($codigo) {
		$this->load->model('Problemas_model');
		
		$this->dados['d'] = $this->Problemas_model->get_by_codigo($codigo);
			
		if (empty($this->dados['d']))
			montaPagina('/problemas/nao_encontrado', $this->dados);
		else
			montaPagina('/problemas/ver', $this->dados);
	}
	
	public function editar($codigo) {
		$this->load->model(array('Problemas_model', 'Orgaos_model'));
		
		$this->dados['d'] 	   = $this->Problemas_model->get_by_codigo($codigo);
		$this->dados['orgaos'] = $this->Orgaos_model->get_all();
			
		if (empty($this->dados['d']))
			montaPagina('/problemas/nao_encontrado', $this->dados);
		else {
			$this->load->library('form_validation');		
		
			$regras = array(
				array(
					'field'   => 'descricao', 
					'label'   => 'Descrição', 
	 				'rules'   => 'required|min_length[5]|max_length[45]'
					)
			);
			
			$this->form_validation->set_rules($regras);
			
			$imagem = $this->input->post('imagem');
			
			if ($this->form_validation->run()) {	
				$upload = array(
					'upload_path'		=> '/home/cidadaoatento/www/mapa/web-dir/upload/',
					'allowed_types'		=> 'gif|jpg|png|jpeg',
					'max_size'			=> '10240',
					'encrypt_name'		=> true
				);
			
				$this->load->library('upload', $upload);
			
				if ( $this->upload->do_upload('imagem') ) {
					if ( $res = $this->upload->data() ) {					
						$this->load->library('image_moo');
					
						$base 	= '/home/cidadaoatento/www/mapa/web-dir/upload/' . $res['raw_name'] . $res['file_ext'];
						$final 	= '/home/cidadaoatento/www/mapa/web-dir/upload/' . $res['raw_name'] . '_ico' . $res['file_ext'];
					
						$this->image_moo->load($base)
										->resize_crop(64, 64)
	        							->save($final);
																
						$img = $res['raw_name'] . '_ico' . $res['file_ext'];
					}
				}
				
				$dados = array(
					'descricao'			=> $this->input->post('descricao'),
					'tbl_orgaos_codigo'	=> $this->input->post('orgao')					
				);
				
				if (isset($img))
					$dados['img'] = $img;
				
				$this->load->model('Problemas_model');
				$this->Problemas_model->update($dados, $codigo);							
				montaPagina('/problemas/sucesso', $this->dados);
			} else {
				$this->load->model('Orgaos_model');
				$this->dados['orgaos'] = $this->Orgaos_model->get_all();		
				montaPagina('/problemas/editar', $this->dados);
			}
		}
	}
		
	public function apagar($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {
			$sim = $this->input->post('sim');
			$this->dados['codigo'] = $codigo;
			
			if (! empty($sim)) {
				$this->load->model('Problemas_model');
				$this->Problemas_model->delete($codigo);
				
				if ($this->db->_error_number() == 1451)
					montaPagina('/problemas/erro_apagar', $this->dados);
				else
					montaPagina('/problemas/sucesso_apagar', $this->dados);
			} else {
				montaPagina('/problemas/apagar', $this->dados);
			}
		}
	}
	
	public function index() {
		montaPagina('/problemas/index', $this->dados);
	}
}

/* End of file problemas.php */
/* Location: ./application/controllers/problemas.php */