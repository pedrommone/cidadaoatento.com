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
        				<li><li class="active">Editar problema</li></li>
        			</ul>
        			
        			<div class="page-header">
        				<h1>
        					Editando problema #<?=$d->codigo?>
        				</h1>
        			</div>
        			
        			<? if(isset($erro) || @validation_errors()):?>
					<div class="alert alert-error">
						<?=@$erro?>
						<?=@validation_errors()?>
					</div>
					<? endif; ?>
        			
          			<form class="form-horizontal" action="/problemas/editar/<?=$d->codigo?>" method="post" enctype='multipart/form-data'>
          				<fieldset>
          					<div class="control-group">
          						<label class="control-label" for="codigo">Código</label>
          						<div class="controls">
          							<input type="text" class="input-xlarge disabled" id="codigo" name="codigo" maxlength="45" value="<?=$d->codigo?>" disabled>
          							<p class="help-block">Código do problema.</p>
          						</div>
          					</div>
          					
          					<div class="control-group">
          						<label class="control-label" for="descricao">Descrição</label>
          						<div class="controls">
          							<input type="text" class="input-xlarge" id="descricao" name="descricao" maxlength="45" value="<?=$d->descricao?>">
          							<p class="help-block">Descrição (nome) do problema.</p>
          						</div>
          					</div>
          			
          					<div class="control-group">
          						<label class="control-label" for="imagem">Nova imagem</label>
          						<div class="controls">
          							<input type="file" class="input-file" id="imagem" name="imagem" >
          							<p class="help-block">Ícone do problema.</p>
          						</div>
          					</div>
          					
          					<div class="control-group">
          						<label class="control-label" for="imagem">Imagem atual</label>
          						<div class="controls">
          							<img src="http://mapa.cidadaoatento.com/web-dir/upload/<?=$d->img?>">
          						</div>
          					</div>
          					
          					<div class="control-group">
          						<label class="control-label" for="orgao">Orgão</label>
          						<div class="controls">
          							<select id="orgao" name="orgao">
          								<? foreach($orgaos as $orgao): ?>
          									<option value="<?=$orgao->codigo?>" <?=($orgao->codigo == $d->codigo_orgao) ? 'selected' : ''?>><?=$orgao->sigla?></option>
          								<? endforeach; ?>
          							</select>
          							<p class="help-block">Orgão responsável pelo problema.</p>
          						</div>
          					</div>
          					
          					<div class="form-actions">
          						<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Editar</button>
          						<a href="javascript:history.go(-1)" class="btn btn-inverse"><i class="icon-arrow-left icon-white"></i> Voltar</a>
          					</div>
          				</fieldset>
          			</form>
        		</div><!--/span-->
      		</div><!--/row-->