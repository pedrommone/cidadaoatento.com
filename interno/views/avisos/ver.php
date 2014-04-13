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
      		<div class="row-fluid">        	
        		<div class="span12">
        			<ul class="breadcrumb">
        				<li><a href="/dashboard">Dashboard</a> <span class="divider">/</span></li>
        				<li><a href="/avisos">Avisos</a> <span class="divider">/</span></li>
        				<li><li class="active">Ver</li></li>
        			</ul>
        			
        			<div class="page-header">
        				<h1>
        					Mostrando aviso #<?=$p->codigo?>
        				</h1>
        			</div>
        			
        			<div class="row-fluid"> 
        				<div class="span9">
        					<dl class="dl-horizontal">
        						<dt>Aviso</dt>
        							<dd><?=$p->aviso?></dd>
        						<dt>Tipo</dt>
        							<dd><?=avisos($p->tipo)?></dd>
        						<dt>Data</dt>
        							<dd><?=converteData($p->data_add)?> as <?=$p->hora_add?></dd>
        						<dt>Periodo</dt>
        							<dd><?=$p->periodo?> dia(s)</dd>
        						<dt>Interno</dt>
        							<dd><?=simNao($p->interno)?></dd>
        						<dt>SUP</dt>
        							<dd><?=simNao($p->sup)?></dd>
        						<dt>SUO</dt>
        							<dd><?=simNao($p->suo)?></dd>
        						<dt>Autor</dt>
        							<dd><?=$p->nome?></dd>
        					</dl>
        				</div>
        				
	          			<div class="span3" style="text-align: left;">
							<a href="/avisos/editar/<?=$p->codigo?>"class="btn btn-info"><i class="icon-font icon-white"></i> Editar</a>
							<a href="/avisos/apagar/<?=$p->codigo?>"class="btn btn-danger"><i class="icon-remove icon-white"></i> Apagar</a>
							<a href="javascript:history.go(-1)" class="btn btn-inverse"><i class="icon-arrow-left icon-white"></i> Voltar</a>
	          			</div>
	          		</div>
        		</div><!--/span-->
      		</div><!--/row-->