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
			Ranking de cidades
		</h1>	    				
	</div>
	
		<? foreach($graficos as $g): ?>
			<div class="span5">
				<h3><?=$g['nome']?></h3>
				
				<table class="table table-condensed">
					<thead>
						<tr>
							<th width="90%">Nome</th>
							<th>Total</th>
						</tr>
					</thead>
		
					<tbody>
						<? foreach($g['dados'] as $r): ?>
							<tr>
								<td><?=ucwords($r->nome)?></td>
								<td><?=$r->total?></td>
							</tr>
						<? endforeach; ?>
					</tbody>
				</table>
			</div>
		<? endforeach; ?>
</div>