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
        				<li><a href="/avisos">Avisos</a> <span class="divider">/</span></li>
        				<li><li class="active">Novo aviso</li></li>
        			</ul>
        			
        			<div class="page-header">
        				<h1>
        					Nova aviso
        				</h1>
        			</div>
        			
        			<? if(isset($erro) || validation_errors()):?>
					<div class="alert alert-error">
						<?=@$erro?>
						<?=validation_errors()?>
					</div>
					<? endif; ?>
        			
          			<form class="form-horizontal" action="/avisos/novo" method="post">
          				<fieldset>         					
          					<div class="control-group">
          						<label class="control-label" for="aviso">Aviso</label>
          						<div class="controls">
          							<textarea class="input-xlarge" id="aviso" name="aviso" maxlength="255" rows="10"></textarea>
          							<p class="help-block">Corpo do aviso.</p>
          						</div>
          					</div>
          					
          					<div class="control-group">
          						<label class="control-label" for="periodo">Periodo</label>
          						<div class="controls">
          							<input type="text" class="input-xlarge" id="periodo" name="periodo" maxlength="10">
          							<p class="help-block">Tempo de duraçao, em dias.</p>
          						</div>
          					</div>
          					
          					<div class="control-group">
          						<label class="control-label" for="tipo">Tipo</label>
          						<div class="controls">
          							<select id="tipo" name="tipo">
          								<option value="1">Erro</option>
          								<option value="2">Sucesso</option>
          								<option value="3">Informação</option>
          							</select>
          							<p class="help-block">Tipo de mensagem a ser exibida.</p>
          						</div>
          					</div>
          					
          					<div class="control-group">
		  						<label class="control-label" for="alvo">Público alvo</label>
		  						<div class="controls">
		  							<label class="checkbox">
		  								<input type="checkbox" name="interno" value="sim">
		  								Interno
		  							</label>
		  							
		  							<label class="checkbox">
		  								<input type="checkbox" name="sup" value="sim">
		  								SUP
		  							</label>
		  							
		  							<label class="checkbox">
		  								<input type="checkbox" name="suo" value="sim">
		  								SUO
		  							</label>
		  							
		  							<p class="help-block">Quem irá receber o aviso.</p>
		  						</div>
		  					</div>
          					
          					<div class="form-actions">
          						<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Publicar</button>
          						<button type="reset" class="btn btn-danger"><i class="icon-trash icon-white"></i> Limpar</button>
          						<a href="javascript:history.go(-1)" class="btn btn-inverse"><i class="icon-arrow-left icon-white"></i> Voltar</a>
          					</div>
          				</fieldset>
          			</form>
        		</div><!--/span-->
      		</div><!--/row-->