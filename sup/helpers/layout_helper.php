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


function montaPagina($pagina, $dados = null) {
	$CI =& get_instance();
	
	$CI->load->view('html/header', $dados);
	$CI->load->view($pagina, $dados);
	$CI->load->view('html/footer', $dados);
}

function avisosLayout($str) {
	switch ($str) {
		case 1: return "alert-error"; break;
		case 2: return "alert-success"; break;
		case 3: return "alert-info"; break;
	}
}

?>