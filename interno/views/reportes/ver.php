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
        				<li><a href="/reportes">Reportes</a> <span class="divider">/</span></li>
        				<li><li class="active">Ver</li></li>
        			</ul>
        			
        			<div class="page-header">
        				<h1>
        					Mostrando reporte #<?=$d->codigo?>
        				</h1>
        			</div>
        			
        			<div class="row-fluid"> 
        				<div class="span7">
        					<dl class="dl-horizontal">
        						<dt>Código</dt>
        							<dd><?=$d->codigo?></dd>
        						<dt>Data adicionado</dt>
        							<dd><?=converteData($d->data_add)?></dd>
        						<dt>Solucionado</dt>
        							<dd><?=simNao($d->solucionado)?></dd>
        						<? if($d->solucionado == "S"): ?>
        						<dt>Data solucionado</dt>
        							<dd><?=converteData($d->data_solu)?></dd>
        						<? endif; ?>
        						<dt>Denúncia</dt>
        							<dd><a href="/denuncias/ver/<?=$d->codigo_denuncia?>">#<?=$d->codigo_denuncia?></a></dd>
        						<dt>Cidadão</dt>
        							<dd><a href="/cidadaos/ver/<?=$d->cpf?>"><?=mask($d->cpf, MASK_CPF)?></a></dd>
        					</dl>
        				</div>
        				
	          			<div class="span5" style="text-align: right;">
							<a href="http://mapa.cidadaoatento.com/#<?=$d->codigo_denuncia?>" target="_blank" class="btn btn-info"><i class="icon-picture icon-white"></i> Mapa</a>
							<a href="/denuncias/ver/<?=$d->codigo_denuncia?>"class="btn btn-success"><i class="icon-search icon-white"></i> Ver denúncia</a>
							<a href="/reportes/solucionar/<?=$d->codigo?>"class="btn btn-danger"><i class="icon-remove icon-white"></i> Solucionado</a>
	          				<a href="javascript:history.go(-1)" class="btn btn-inverse"><i class="icon-arrow-left icon-white"></i> Voltar</a>
	          			</div>
	          		</div>
        		</div><!--/span-->
      		</div><!--/row-->