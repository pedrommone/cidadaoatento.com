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

?>
<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<meta charset="utf-8">
		<title>SUP - Cidadão Atento</title>
		<meta name="viewport" content="width=device-width, inital-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">		

		<!-- estilos -->
		<link rel="stylesheet" href="/web-dir/css/bootstrap.min.css" title="Bootstrap">
		<link ref="stylesheet" href="/web-dir/css/bootstrap-responsive.min.css" title="Bootstrap-responsive">
		
		<!-- icone -->
		<link rel="shortcut icon" href="/web-dir/favicon.ico">		

		<!-- suporte IE 6 -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- javascript -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="/web-dir/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=visualization"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(".alert").alert();
			})			
			
			function abrirManual(endereco) {
				var width = 600, height = 600, left = 0, right = 0;
				
				window.open(endereco, 'Manual - Cidadão Atento', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
			}
		</script>
	</head>

	<body>		
		<div class="navbar navbar-fixed-top">
      		<div class="navbar-inner">
       	 		<div class="container">
          			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            			<span class="icon-bar"></span>
            			<span class="icon-bar"></span>
            			<span class="icon-bar"></span>
          			</a>
          			
          			<a class="brand" href="/mapa/geral">Cidadão Atento</a>
          			<div class="btn-group pull-right">
          				<a class="btn" href="javascript:abrirManual('/manual');"><i class="icon-question-sign"></i></a>
          				
	            		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
	              			<i class="icon-user"></i> <?=strtoupper($uf)?> - <?=ucwords($municipio)?>
	              			<span class="caret"></span>
	            		</a>
	           	 	
	           	 		<ul class="dropdown-menu">
	              			<li><a href="/outros/senha">Trocar senha</a></li>
	              			<li class="divider"></li>
	              			<li><a href="/login/logout">Sair</a></li>
	            		</ul>
          			</div>
        		</div>
      		</div>
    	</div>

    	<div class="container">
    		<br/><br/><br/>
    		
    		<? foreach($avisos as $a): ?>
				<div class="alert alert-block <?=avisosLayout($a->tipo)?> fade in">
	            	<button type="button" class="close" data-dismiss="alert">&times;</button>
	            	<p><?=$a->aviso?></p>
				</div>
			<? endforeach; ?>
			
			<div class="row-fluid">
				<div class="span3">
					<div class="well sidebar-nav">
						<ul class="nav nav-list">
							<li class="nav-header">Mapa</li>
							<li <?=($this->uri->rsegment(1) == 'mapa' && $this->uri->rsegment(2) == 'geral' ? 'class="active"' : '')?>><a href="/mapa/geral">Visão geral</a></li>
							<li class="nav-header">Denúncias</li>
							<li <?=($this->uri->rsegment(1) == 'denuncias' && $this->uri->rsegment(2) == 'geral' ? 'class="active"' : '')?>><a href="/denuncias/geral">Visão geral</a></li>
							<li <?=($this->uri->rsegment(1) == 'denuncias' && $this->uri->rsegment(2) == 'pendentes' ? 'class="active"' : '')?>><a href="/denuncias/pendentes">Pendentes</a></li>
							<li <?=($this->uri->rsegment(1) == 'denuncias' && $this->uri->rsegment(2) == 'todas' ? 'class="active"' : '')?>><a href="/denuncias/todas">Todas</a></li>
							<li <?=($this->uri->rsegment(1) == 'denuncias' && $this->uri->rsegment(2) == 'procurar' ? 'class="active"' : '')?>><a href="/denuncias/procurar">Procurar</a></li>
							<li class="nav-header">Estatisticas</li>
							<li <?=($this->uri->rsegment(1) == 'estatisticas' && $this->uri->rsegment(2) == 'ranking' ? 'class="active"' : '')?>><a href="/estatisticas/ranking">Ranking de cidades</a></li>
							<li class="nav-header">Outros</li>
							<li <?=($this->uri->rsegment(1) == 'outros' && $this->uri->rsegment(2) == 'opcoes' ? 'class="active"' : '')?>><a href="/outros/opcoes">Opções</a></li>
							<li <?=($this->uri->rsegment(1) == 'outros' && $this->uri->rsegment(2) == 'feedback' ? 'class="active"' : '')?>><a href="/outros/feedback">Feedback</a></li>
							<li <?=($this->uri->rsegment(1) == 'outros' && $this->uri->rsegment(2) == 'sobre' ? 'class="active"' : '')?>><a href="/outros/sobre">Sobre</a></li>
						</ul>
					</div><!--/.well -->
				</div><!--/span-->
				
				<div class="span9">		
