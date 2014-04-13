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
		<title>Interno - Cidadão Atento</title>
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
		<script type="text/javascript" src="/web-dir/js/jquery.limit-1.2.js"></script>
		<script type="text/javascript" src="/web-dir/js/jquery.mask.js"></script>
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
          			
          			<a class="brand" href="/">Cidadão Atento</a>
          			
          			<div class="btn-group pull-right">
          				<a class="btn" href="javascript:abrirManual('/manual');"><i class="icon-question-sign"></i></a>
          				
	            		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
	              			<i class="icon-user"></i> <?=$nome?>
	              			<span class="caret"></span>
	            		</a>
	           	 	
	           	 		<ul class="dropdown-menu">
	              			<li><a href="/moderadores/mudarsenha/<?=$codigo?>">Trocar senha</a></li>
	              			<li><a href="/moderadores/editar/<?=$codigo?>">Editar dados</a></li>
	              			<li class="divider"></li>
	              			<li><a href="/login/logout">Sair</a></li>
	            		</ul>            		
          			</div>
          
	          		<div class="nav-collapse">
	            		<ul class="nav">	              			
	              			<li class="dropdown">
	              				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Blog <b class="caret"></b></a>
	              				<ul class="dropdown-menu">
	              					<li><a href="/blog/novo"><i class="icon-file"></i> Novo post</a></li>
	              					<li><a href="/blog/listar"><i class="icon-book"></i> Ver posts</a></li>
								</ul>
							</li>
							
							<li class="dropdown">
	              				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Avisos <b class="caret"></b></a>
	              				<ul class="dropdown-menu">
	              					<li><a href="/avisos/novo"><i class="icon-file"></i> Novo aviso</a></li>
	              					<li><a href="/avisos/listar"><i class="icon-book"></i> Ver avisos</a></li>
								</ul>
							</li>
	              			
	              			<li class="divider-vertical"></li>
	              			
	              			<li class="dropdown">
	              				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Denúncias <b class="caret"></b></a>
	              				<ul class="dropdown-menu">
	              					<li class="nav-header">Denúncias</li>
	              					<li><a href="/denuncias/listar"><i class="icon-book"></i> Todos</a></li>
	              					<li><a href="/denuncias/procurar"><i class="icon-search"></i> Procurar</a></li>
	              					<li><a href="/denuncias/invalidar"><i class="icon-ban-circle"></i> Invalidar</a></li>
	              					<li class="nav-header">Problemas</li>
	              					<li><a href="/problemas/listar"><i class="icon-book"></i> Todos</a></li>
	              					<li><a href="/problemas/procurar"><i class="icon-search"></i> Procurar</a></li>
	              					<li><a href="/problemas/cadastrar"><i class="icon-file"></i> Cadastrar</a></li>
	              					<li class="nav-header">Orgãos</li>
	              					<li><a href="/orgaos/listar"><i class="icon-book"></i> Todos</a></li>
	              					<li><a href="/orgaos/procurar"><i class="icon-search"></i> Procurar</a></li>
	              					<li><a href="/orgaos/cadastrar"><i class="icon-file"></i> Cadastrar</a></li>
	              					<li class="nav-header">Prefeituras</li>
	              					<li><a href="/prefeituras/listar"><i class="icon-book"></i> Todas</a></li>
	              					<li><a href="/prefeituras/procurar"><i class="icon-search"></i> Procurar</a></li>
	              					<li><a href="/prefeituras/cadastrar"><i class="icon-file"></i> Cadastrar</a></li>
								</ul>
							</li>
							
							<li class="dropdown">
	              				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Cidadãos <b class="caret"></b></a>
	              				<ul class="dropdown-menu">
	              					<li><a href="/cidadaos/listar"><i class="icon-book"></i> Todos</a></li>
	              					<li><a href="/cidadaos/procurar"><i class="icon-search"></i> Procurar</a></li>
								</ul>
							</li>
							
							<li class="divider-vertical"></li>
							
							<li class="dropdown">
	              				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Tickets <b class="caret"></b></a>
	              				<ul class="dropdown-menu">
	              					<li><a href="/tickets/listar"><i class="icon-book"></i> Todos</a></li>
	              					<li class="divider"></li>
	              					<li><a href="/tickets/novos"><i class="icon-book"></i> Novos</a></li>	              					
	              					<li><a href="/tickets/meus"><i class="icon-book"></i> Meus tickets</a></li>
	              					<li class="divider"></li>	              					
	              					<li><a href="/tickets/procurar"><i class="icon-search"></i> Procurar</a></li>
								</ul>
							</li>
							
							<li class="divider-vertical"></li>
							
							<li class="dropdown">
	              				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Moderadores <b class="caret"></b></a>
	              				<ul class="dropdown-menu">
	              					<li><a href="/moderadores/listar"><i class="icon-book"></i> Todos</a></li>
	              					<li><a href="/moderadores/cadastrar"><i class="icon-file"></i> Cadastrar</a></li>
								</ul>
							</li>
	            		</ul>
	          		</div><!--/.nav-collapse -->
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