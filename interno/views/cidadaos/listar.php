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
        				<li><li class="active">Listar</li></li>
        			</ul>
        			
        			<div class="page-header">
	    				<div style="text-align: right;">
	    					<a href="javascript:history.go(-1)" class="btn btn-inverse"><i class="icon-arrow-left icon-white"></i> Voltar</a>
	    				</div>
	    				
	    				<h1>
	    					Mostrando resultados da pesquisa
	    				</h1>	    				
	    			</div>
        			
        			<div class="row-fluid"> 
	          			<div class="span12">
	          				<table class="table table-striped table-condensed">
								<thead>
									<tr>
										<th>CPF</th>
										<th>Telefone</th>
										<th>Data Adicionado</th>
										<th>Último login</th>
										<th>Denúncias</th>
										<th>Apoios</th>
										<th>Reportes</th>
										<th></th>
									</tr>
								</thead>
	
								<tbody>
									<? foreach($dados as $r): ?>
										<tr>
											<td><?=mask($r->cpf, MASK_CPF)?></td>
											<td><?=mask($r->telefone, MASK_TELEFONE)?></td>
											<td><?=converteData($r->dia_add)?> as <?=$r->hora_add?></td>
											<td><?=converteData($r->dia_ultimo_login)?> as <?=$r->hora_ultimo_login?></td>
											<td><a href="/cidadaos/denuncias/<?=$r->cpf?>"><?=$r->num_denuncias?></a></td>
											<td><a href="/cidadaos/apoios/<?=$r->cpf?>"><?=$r->num_apoios?></a></td>
											<td><a href="/cidadaos/reportes/<?=$r->cpf?>"><?=$r->num_reportes?></a></td>
											<td style="text-align: right;">
												<a href="/cidadaos/ver/<?=$r->cpf?>" class="btn btn-success"><i class="icon-search icon-white"></i> Ver</a>
												
												<? if($r->bloqueado == 'S'): ?>
													<a href="/cidadaos/desbloquear/<?=$r->cpf?>"class="btn btn-danger"><i class="icon-remove icon-white"></i> Desbloquear</a>
												<? else: ?>
													<a href="/cidadaos/bloquear/<?=$r->cpf?>"class="btn btn-danger"><i class="icon-ok icon-white"></i> Bloquear</a>
												<? endif; ?>
											</td>
										</tr>
									<? endforeach; ?>
								</tbody>
							</table>
							
							<?=(isset($pag) ? $pag : '')?>
	          			</div>
	          		</div>
        		</div><!--/span-->
      		</div><!--/row-->