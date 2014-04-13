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
        				<li><a href="/orgaos">Problemas</a> <span class="divider">/</span></li>
        				<li><li class="active">Cadastrar problema</li></li>
        			</ul>
        			
        			<div class="page-header">
        				<h1>
        					Cadastrando novo problema
        				</h1>
        			</div>
        			
        			<? if(isset($erro) || @validation_errors()):?>
					<div class="alert alert-error">
						<?=@$erro?>
						<?=@validation_errors()?>
					</div>
					<? endif; ?>
        			
          			<form class="form-horizontal" action="/problemas/cadastrar" method="post" enctype='multipart/form-data'>
          				<fieldset>
          					<div class="control-group">
          						<label class="control-label" for="descricao">Descrição</label>
          						<div class="controls">
          							<input type="text" class="input-xlarge" id="descricao" name="descricao" maxlength="45">
          							<p class="help-block">Descrição (nome) do problema.</p>
          						</div>
          					</div>
          			
          					<div class="control-group">
          						<label class="control-label" for="imagem">Imagem</label>
          						<div class="controls">
          							<input type="file" class="input-file" id="imagem" name="imagem" >
          							<p class="help-block">Ícone do problema.</p>
          						</div>
          					</div>
          					
          					<div class="control-group">
          						<label class="control-label" for="orgao">Orgão</label>
          						<div class="controls">
          							<select id="orgao" name="orgao">
          								<? foreach($orgaos as $orgao): ?>
          									<option value="<?=$orgao->codigo?>"><?=$orgao->sigla?></option>
          								<? endforeach; ?>
          							</select>
          							<p class="help-block">Orgão responsável pelo problema.</p>
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