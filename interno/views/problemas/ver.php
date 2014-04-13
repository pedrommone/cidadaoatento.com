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
        				<li><a href="/problemas">Problemas</a> <span class="divider">/</span></li>
        				<li><li class="active">Ver</li></li>
        			</ul>
        			
        			<div class="page-header">
        				<h1>
        					Mostrando problema #<?=$d->codigo?>
        				</h1>
        			</div>
        			
        			<div class="row-fluid"> 
        				<div class="span9">
        					<dl class="dl-horizontal">
        						<dt>Código</dt>
        							<dd><?=$d->codigo?></dd>
        						<dt>Descrição</dt>
        							<dd><?=$d->descricao?></dd>
        						<dt>Orgão responsável</dt>
        							<dd><?=$d->nome?></dd>
        						<dt>Apoios p/ disparo</dt>
        							<dd><?=$d->minimo_apoios?></dd>
        						<dt>Icone</dt>
        							<dd><img src="http://mapa.cidadaoatento.com/web-dir/upload/<?=$d->img?>"></dd>
        					</dl>
        				</div>
        				
	          			<div class="span3" style="text-align: right;">
							<a href="/problemas/editar/<?=$d->codigo?>"class="btn btn-info"><i class="icon-font icon-white"></i> Editar</a>
							<a href="/problemas/apagar/<?=$d->codigo?>"class="btn btn-danger"><i class="icon-remove icon-white"></i> Apagar</a>
							<a href="javascript:history.go(-1)" class="btn btn-inverse"><i class="icon-arrow-left icon-white"></i> Voltar</a>
	          			</div>
	          		</div>
        		</div><!--/span-->
      		</div><!--/row-->