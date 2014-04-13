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
        				<li><a href="/blog">Blog</a> <span class="divider">/</span></li>
        				<li><li class="active">Novo post</li></li>
        			</ul>
        			
        			<div class="page-header">
        				<h1>
        					Nova postagem no blog
        				</h1>
        			</div>
        			
        			<? if(isset($erro) || validation_errors()):?>
					<div class="alert alert-error">
						<?=@$erro?>
						<?=validation_errors()?>
					</div>
					<? endif; ?>
        			
          			<form class="form-horizontal" action="/blog/novo" method="post">
          				<fieldset>
          					<div class="control-group">
          						<label class="control-label" for="titulo">Título</label>
          						<div class="controls">
          							<input type="text" class="input-xlarge" id="titulo" name="titulo" maxlength="45">
          							<p class="help-block">Título do post.</p>
          						</div>
          					</div>
          					
          					<div class="control-group">
          						<label class="control-label" for="post">Conteúdo</label>
          						<div class="controls">
          							<textarea class="input-xlarge" id="post" name="post" maxlength="512" rows="10"></textarea>
          							<p class="help-block">Corpo do post.</p>
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