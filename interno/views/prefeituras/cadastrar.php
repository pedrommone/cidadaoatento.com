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
        				<li><li class="active">Cadastrar</li></li>
        			</ul>
        			
        			<div class="page-header">
        				<h1>
        					Cadastrar nova prefeitura
        				</h1>
        			</div>
        			
          			<form class="form-horizontal" action="/prefeituras/cadastrar" method="post">
          				<fieldset>
          					<div class="control-group">
          						<label class="control-label" for="municipio">Município</label>
          						<div class="controls">
          							<input type="text" class="input-xlarge" id="municipio" name="municipio" maxlength="50">
          							<p class="help-block">Nome do município.</p>
          						</div>
          					</div>
          					
          					<div class="control-group">
          						<label class="control-label" for="uf">UF</label>
          						<div class="controls">
          							<input type="text" class="input-xlarge" id="uf" name="uf" maxlength="2">
          							<p class="help-block">UF do município.</p>
          						</div>
          					</div>
          					
          					<div class="control-group">
          						<label class="control-label" for="email">E-mail</label>
          						<div class="controls">
          							<input type="text" class="input-xlarge" id="email" name="email" maxlength="255">
          							<p class="help-block">E-mail do município.</p>
          						</div>
          					</div>
          					
          					<div class="control-group">
          						<label class="control-label" for="senha">Senha</label>
          						<div class="controls">
          							<input type="password" class="input-xlarge" id="senha" name="senha" maxlength="50">
          							<p class="help-block">Senha da prefeitura.</p>
          						</div>
          					</div>
          					
          					<div class="control-group">
          						<label class="control-label" for="confirmar_senha">Confirmar senha</label>
          						<div class="controls">
          							<input type="password" class="input-xlarge" id="confirmar_senha" name="confirmar_senha" maxlength="50">
          							<p class="help-block">Senha da prefeitura.</p>
          						</div>
          					</div>         					
          					
          					<div class="form-actions">
          						<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Cadastrar</button>
          						<button type="reset" class="btn btn-danger"><i class="icon-trash icon-white"></i> Limpar</button>
          						<a href="javascript:history.go(-1)" class="btn btn-inverse"><i class="icon-arrow-left icon-white"></i> Voltar</a>
          					</div>
          				</fieldset>
          			</form>
        		</div><!--/span-->
      		</div><!--/row-->