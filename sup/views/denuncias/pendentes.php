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
	      		<div class="span12">	    			
	    			<div class="page-header">	    				
	    				<h1>
	    					Relatório <small>Exibindo denúncias não solucionadas</small>
	    				</h1>	    				
	    			</div>
	    			
	   				<? if(count($dados) == 0): ?>
	  					<h2>Nenhuma denúncia encontrada!</h2>
	  				<? else: ?>
	      				<table class="table table-striped table-condensed">
							<thead>
								<tr>
									<th width="30">#</th>
									<th width="150">Tipo</th>
									<th>Endereço</th>
									<th width="60">Total de apoios</th>
									<th width="250"></th>
								</tr>
							</thead>
	
							<tbody>
								<? foreach($dados as $r): ?>
									<tr>
										<td><?=$r->codigo?></td>
										<td><?=$r->nome_problema?></td>
										<td><?=$r->endereco?></td>
										<td><?=$r->numero_apoios?></td>
										<td style="text-align: right;">										
											<a href="/denuncias/ver/<?=$r->codigo?>"class="btn btn-warning"><i class="icon-search icon-white"></i> Ver</a>
											<a href="http://mapa.cidadaoatento.com/#<?=$r->codigo?>" target="_blank" class="btn btn-info"><i class="icon-picture icon-white"></i> Mapa</a>
											
											<? if($r->solucionado == "N"): ?>
												<a href="/denuncias/solucionar/<?=$r->codigo?>"class="btn btn-danger"><i class="icon-remove icon-white"></i> Solucionar</a>	
											<? endif; ?>
										</td>
									</tr>
								<? endforeach; ?>
							</tbody>
						</table>
					<? endif; ?>
					
					<?=(isset($pag) ? $pag : '')?>				
				</div>