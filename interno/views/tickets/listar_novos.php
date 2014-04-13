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
        				<li><a href="/tickets">Tickets</a> <span class="divider">/</span></li>
        				<li><li class="active">Listar</li></li>
        			</ul>
        			
        			<div class="page-header">
        				<h1>
        					Novos tickets em aberto
        				</h1>
        			</div>
        			
        			<div class="row-fluid"> 
	          			<div class="span12">
	          				<? if(count($tickets) == 0): ?>
	          				<h2>Nenhum ticket em aberto!</h2>
	          				<? else: ?>
	          				<table class="table table-striped table-condensed">
								<thead>
									<tr>
										<th>#</th>
										<th>Nome</th>
										<th>Email</th>
										<th>Assunto</th>
										<th></th>
									</tr>
								</thead>
	
								<tbody>
									<? foreach($tickets as $r): ?>
										<tr>
											<td><?=$r->codigo?></td>
											<td><?=$r->nome?></td>
											<td><?=$r->email?></td>
											<td><?=$r->assunto?></a></td>
											<td style="text-align: right;">										
												<a href="/tickets/ver/<?=$r->codigo?>"class="btn btn-warning"><i class="icon-search icon-white"></i> Ver</a>
											</td>
										</tr>
									<? endforeach; ?>
								</tbody>
							</table>
							
							<?=(isset($pag) ? $pag : '')?>
							<? endif; ?>
	          			</div>
	          		</div>
        		</div><!--/span-->
      		</div><!--/row-->