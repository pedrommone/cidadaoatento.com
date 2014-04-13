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

class Blog extends CI_Controller {

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

	public function novo() {
		$this->load->library('form_validation');		
		
		$regras = array(
               array(
                     'field'   => 'titulo', 
                     'label'   => 'Título', 
                     'rules'   => 'required|min_length[10]|max_length[45]'
                  ),
               array(
                     'field'   => 'post', 
                     'label'   => 'Conteúdo', 
                     'rules'   => 'required|min_length[10]'
                  )
            );
		
		$this->form_validation->set_rules($regras);
		
		if ($this->form_validation->run()) {
			$this->load->model('Blog_model');
			
			$titulo = $this->input->post('titulo');
			$texto 	= $this->input->post('post');
			$moderador = $this->session->userdata('moderador');
			
			$this->Blog_model->add($titulo, $texto, $moderador);
			
			$this->dados['cod'] = $this->db->insert_id();
			montaPagina('blog/sucesso', $this->dados);
		} else {			
			montaPagina('blog/novo', $this->dados);
		}		
	}
	
	public function listar($offset = null, $limit = 15) {
		$this->load->model('Blog_model');
		$this->load->library('pagination');
		
		$paginacao = array(
			'base_url'			=> 'http://interno.cidadaoatento.com/blog/listar',
			'total_rows'		=> $this->Blog_model->num_rows(),
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
		
		$this->dados['posts'] = $this->Blog_model->get_all($offset, $limit);
		$this->dados['pag']	  = $this->pagination->create_links();
		
		montaPagina('blog/listar', $this->dados);
	}

	public function editar($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {		
			$this->load->library('form_validation');
			
			$regras = array(
	               array(
	                     'field'   => 'titulo', 
	                     'label'   => 'Título', 
	                     'rules'   => 'required|min_length[10]|max_length[45]'
	                  ),
	               array(
	                     'field'   => 'post', 
	                     'label'   => 'Conteúdo', 
	                     'rules'   => 'required|min_length[10]'
	                  )
	            );
				
			$this->form_validation->set_rules($regras);
			$this->load->model('Blog_model');
			$this->dados['post'] = $this->Blog_model->get($codigo);
			
			if ($this->form_validation->run()) {
				$dados = array(
					'titulo' 	=> $this->input->post('titulo'),
					'post' 	=> $this->input->post('post')
				);
				
				$this->Blog_model->update($dados, $codigo);			
				montaPagina('blog/sucesso_editar', $this->dados);	
			} else {				
				montaPagina('blog/editar', $this->dados);
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
				$this->load->model('Blog_model');
				$this->Blog_model->delete($codigo);
				montaPagina('blog/sucesso_apagar', $this->dados);
			} else {
				montaPagina('blog/apagar', $this->dados);
			}
		}
	}
	
	public function ver($codigo = null) {
		if (is_null($codigo)) {
			show_404();
		} else {
			$this->load->model('Blog_model');
			$this->dados['p'] =  $this->Blog_model->get($codigo);
			
			if (empty($this->dados['p']))
				montaPagina('blog/nao_encontrado', $this->dados);
			else
				montaPagina('blog/ver', $this->dados);
		}
	}

	public function index() {
		montaPagina('/blog/index', $this->dados);
	}
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */