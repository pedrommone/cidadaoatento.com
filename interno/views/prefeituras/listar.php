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
        				<li><a href="/prefeituras">Prefeituras</a> <span class="divider">/</span></li>
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
										<th>Município</th>
										<th>UF</th>
										<th>Último login</th>
										<th></th>
									</tr>
								</thead>
	
								<tbody>
									<? foreach($dados as $r): ?>
										<tr>
											<td><?=$r->codigo?></td>
											<td><?=ucwords($r->municipio)?></td>
											<td><?=strtoupper($r->uf)?></td>
											<td><?=converteData($r->dia_ultimo_login)?> as <?=$r->hora_ultimo_login?></td>
											<td style="text-align: right;">										
												<a href="/prefeituras/ver/<?=$r->codigo?>"class="btn btn-warning"><i class="icon-search icon-white"></i> Ver</a>
												<a href="/prefeituras/editar/<?=$r->codigo?>"class="btn btn-info"><i class="icon-font icon-white"></i> Editar</a>
												<a href="/prefeituras/senha/<?=$r->codigo?>"class="btn btn-primary"><i class="icon-wrench icon-white"></i> Alterar senha</a>
												<a href="/prefeituras/apagar/<?=$r->codigo?>"class="btn btn-danger"><i class="icon-remove icon-white"></i> Apagar</a>
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