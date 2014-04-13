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
	    				<li><a href="/denuncias">Denúncias</a> <span class="divider">/</span></li>
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
	    			
	   				<? if(count($dados) == 0): ?>
	  					<h2>Nenhuma denúncia encontrada!</h2>
	  				<? else: ?>
	      				<table class="table table-striped table-condensed">
							<thead>
								<tr>
									<th>#</th>
									<th>Tipo</th>
									<th>Municipio</th>
									<th>UF</th>
									<th>Total de apoios</th>
									<th>Solucionada</th>
									<th>Inválida</th>
									<th></th>
								</tr>
							</thead>
	
							<tbody>
								<? foreach($dados as $r): ?>
									<tr>
										<td><?=$r->codigo?></td>
										<td><?=$r->nome_problema?></td>
										<td><?=ucwords($r->municipio)?></td>
										<td><?=strtoupper($r->uf)?></td>
										<td><?=$r->numero_apoios?></td>
										<td><?=simNao($r->solucionado)?></td>
										<td><?=simNao($r->invalido)?></td>
										<td style="text-align: right;">										
											<a href="/denuncias/ver/<?=$r->codigo?>"class="btn btn-warning"><i class="icon-search icon-white"></i> Ver</a>
											<? if($r->invalido == "N"): ?>
												<a href="http://mapa.cidadaoatento.com/#<?=$r->codigo?>" target="_blank" class="btn btn-info"><i class="icon-picture icon-white"></i> Mapa</a>
											<? else: ?>
												<a href="javascript:void(0)" class="btn btn-info disabled"><i class="icon-picture icon-white"></i> Mapa</a>
											<? endif; ?>
											<? if($r->invalido == "N"): ?>
												<a href="/denuncias/invalidar/<?=$r->codigo?>"class="btn btn-danger"><i class="icon-remove icon-white"></i> Invalidar</a>	
											<? else: ?>
												<a href="/denuncias/validar/<?=$r->codigo?>"class="btn btn-success"><i class="icon-remove icon-white"></i> Validar&nbsp;</a>
											<? endif; ?>
										</td>
									</tr>
								<? endforeach; ?>
							</tbody>
						</table>
					<? endif; ?>
					
					<?=(isset($pag) ? $pag : '')?>				
				</div>
      		</div><!--/row-->