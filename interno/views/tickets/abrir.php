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
        				<li><a href="/reportes">Tickets</a> <span class="divider">/</span></li>
        				<li><li class="active">Abrir</li></li>
        			</ul>
        			
        			<div class="page-header">
        				<h1>
        					Abrindo ticket #<?=$codigo?>
        				</h1>
        			</div>
        			
          			<form class="form-horizontal" action="/tickets/abrir/<?=$codigo?>" method="post">
          				<fieldset>          					
          					<div class="control-group">
          						<div class="controls">
          							<p>Você deseja realmente abrir o ticket #<?=$codigo?>?</p>
          						</div>
          					</div>
          					
          					<input type="hidden" name="sim" value="sim">          					
          					
          					<div class="form-actions">
          						<button type="submit" class="btn btn-danger"><i class="icon-warning-sign icon-white"></i> Sim</button>
          						<a href="/tickets/ver/<?=$codigo?>" class="btn btn-success"><i class="icon-ok icon-white"></i> Não</a>
          					</div>
          				</fieldset>
          			</form>
        		</div><!--/span-->
      		</div><!--/row-->