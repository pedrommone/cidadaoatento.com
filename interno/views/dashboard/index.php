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
      			<div class="hero-unit">
      				<div class="row-fluid" style="text-align: center;">
          				<div class="span2">
          					<h1><?=$count_denuncias?></h1>
          					<p>Denúncias!</p>
          				</div>
          				
          				<div class="span2">
          					<h1><?=$count_cidadaos?></h1>
          					<p>Cidadãos cadastrados!</p>
          				</div>
          				
          				<div class="span2">
          					<h1><?=$count_prefeituras?></h1>
          					<p>Prefeituras cadastradas!</p>
          				</div>
          				
          				<div class="span2">
          					<h1><?=$count_apoios?></h1>
          					<p>Apoios!</p>
          				</div>
          				
          				<div class="span2">
          					<h1><?=$count_reportes?></h1>
          					<p>Reportes!</p>
          				</div>
          				
          				<div class="span2">
          					<h1><?=$count_blog?></h1>
          					<p>Posts no blog!</p>
          				</div>
          			</div>
      			</div>
      		
	      		<? if(count($meusTickets) > 0): ?>
	      			<div class="page-header">
	    				<h1>
	    					Meus tickets (<?=count($meusTickets)?>)
	    				</h1>
	    			</div>    			
	      			
	  				<table class="table table-striped table-condensed">
						<thead>
							<tr>
								<th width="5%">#</th>
								<th width="15%">Nome</th>
								<th width="20%"width>Email</th>
								<th width="30%">Assunto</th>
								<th width="30%"></th>
							</tr>
						</thead>
	
						<tbody>
							<? foreach($meusTickets as $r): ?>
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
	      		<? endif; ?>	
      		
	      		<? if(count($tickets) > 0): ?>
	      			<div class="page-header">
	    				<h1>
	    					Novos tickets (<?=count($tickets)?>)
	    				</h1>
	    			</div>    			
	  			
	  				<table class="table table-striped table-condensed">
						<thead>
							<tr>
								<th width="5%">#</th>
								<th width="15%">Nome</th>
								<th width="20%"width>Email</th>
								<th width="30%">Assunto</th>
								<th width="30%"></th>
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
	      		<? endif; ?>	
					
        	<? if(count($reportes) > 0): ?>
				<div class="page-header">
    				<h1>
    					Novos reportes (<?=count($reportes)?>)
    				</h1>
    			</div>			
      			
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
						<? foreach($reportes as $r): ?>
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
      		<? endif; ?>
      	</div>