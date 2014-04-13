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
										<th>#</th>
										<th>Data adionada</th>
										<th>Denúncia</th>
										<th>CPF Cidadão</th>
										<th></th>
									</tr>
								</thead>
	
								<tbody>
									<? foreach($dados as $r): ?>
										<tr>
											<td><?=$r->codigo?></td>
											<td><?=converteData($r->data_add)?></td>
											<td><a href="/denuncias/ver/<?=$r->codigo_denuncia?>">#<?=$r->codigo_denuncia?></a></td>
											<td><a href="/cidadaos/ver/<?=$r->cpf?>"><?=mask($r->cpf, MASK_CPF)?></a></td>
											<td style="text-align: right;">										
												<a href="/reportes/ver/<?=$r->codigo?>"class="btn btn-warning"><i class="icon-search icon-white"></i> Ver</a>
												<a href="http://mapa.cidadaoatento.com/#<?=$r->codigo_denuncia?>" target="_blank" class="btn btn-info"><i class="icon-picture icon-white"></i> Mapa</a>
												<a href="/denuncias/ver/<?=$r->codigo_denuncia?>"class="btn btn-success"><i class="icon-search icon-white"></i> Ver denúncia</a>
												<a href="/reportes/solucionar/<?=$r->codigo?>"class="btn btn-danger"><i class="icon-remove icon-white"></i> Solucionado</a>
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