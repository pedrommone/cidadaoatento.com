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
        				<li><a href="/cidadaos">Cidadãos</a> <span class="divider">/</span></li>
        				<li><li class="active">Ver</li></li>
        			</ul>
        			
        			<div class="page-header">
        				<h1>
        					Mostrando cidadão com o CPF <?=mask($d->cpf, MASK_CPF)?>
        				</h1>
        			</div>
        			
        			<div class="row-fluid"> 
        				<div class="span7">
        					<dl class="dl-horizontal">
        						<dt>CPF</dt>
        							<dd><?=mask($d->cpf, MASK_CPF)?></dd>
        						<dt>Telefone</dt>
        							<dd><?=mask($d->telefone, MASK_TELEFONE)?></dd>
        						<dt>Adicionado em</dt>
        							<dd><?=converteData($d->dia_add)?> as <?=$d->hora_add?></dd>
        						<dt>Último login</dt>
        							<dd><?=converteData($d->dia_ultimo_login)?> as <?=$d->hora_ultimo_login?></dd>
								<dt>Último ip</dt>
        							<dd><?=$d->ultimo_ip?></dd>
        						<dt>Denúncias</dt>
        							<dd><a href="/cidadaos/denuncias/<?=$d->cpf?>"><?=$d->num_denuncias?></a></dd>
        						<dt>Apoios</dt>
        							<dd><a href="/cidadaos/apoios/<?=$d->cpf?>"><?=$d->num_apoios?></a></dd>
        						<dt>Reportes</dt>
        							<dd><a href="/cidadaos/reportes/<?=$d->cpf?>"><?=$d->num_denuncias?></a></dd>
        						<dt>Bloqueado</dt>
        							<dd><?=simNao($d->bloqueado)?></dd>
        					</dl>
        				</div>
        				
	          			<div class="span5" style="text-align: right;">
	          				<a href="/cidadaos/denuncias/<?=$d->cpf?>" class="btn btn-warning"><i class="icon-search icon-white"></i> Ver denúncias</a>
	          				
							<? if($d->bloqueado == 'S'): ?>
								<a href="/cidadaos/desbloquear/<?=$d->cpf?>"class="btn btn-danger"><i class="icon-remove icon-white"></i> Desbloquear</a>
							<? else: ?>
								<a href="/cidadaos/bloquear/<?=$d->cpf?>"class="btn btn-success"><i class="icon-ok icon-white"></i> Bloquear</a>
							<? endif; ?>
							
							<a href="javascript:history.go(-1)" class="btn btn-inverse"><i class="icon-arrow-left icon-white"></i> Voltar</a>
	          			</div>
	          		</div>
        		</div><!--/span-->
      		</div><!--/row-->