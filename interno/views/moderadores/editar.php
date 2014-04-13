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
        				<li><a href="/moderadores">Moderadores</a> <span class="divider">/</span></li>
        				<li><li class="active">Editar</li></li>
        			</ul>
        			
        			<div class="page-header">
        				<h1>
        					Editando moderador # <?=$d->codigo?>
        				</h1>
        			</div>
        			
        			<? if(isset($erro) || @validation_errors()):?>
					<div class="alert alert-error">
						<?=@$erro?>
						<?=@validation_errors()?>
					</div>
					<? endif; ?>
        			
          			<form class="form-horizontal" action="/moderadores/editar/<?=$d->codigo?>" method="post">
          				<fieldset>
          					<div class="control-group">
          						<label class="control-label" for="nome">Nome</label>
          						<div class="controls">
          							<input type="text" class="input-xlarge" id="nome" name="nome" maxlength="100" value="<?=$d->nome?>">
          							<p class="help-block">Nome do moderador.</p>
          						</div>
          					</div>
          					
          					<div class="control-group">
          						<label class="control-label" for="email">Email</label>
          						<div class="controls">
          							<input type="text" class="input-xlarge" id="email" name="email" maxlength="255" value="<?=$d->email?>">
          							<p class="help-block">Email do moderador.</p>
          						</div>
          					</div>
          					
          					<div class="control-group">
		  						<label class="control-label" for="relatorios">Notificações</label>
		  						<div class="controls">
		  							<label class="checkbox">
		  								<input type="checkbox" name="relatorios" value="sim" <?=($d->relatorios == 'S' ? 'checked' : '')?>>
		  								Receber relatórios por e-mail
		  							</label>
		  							
		  							<label class="checkbox">
		  								<input type="checkbox" name="avisos" value="sim" <?=($d->avisos == 'S' ? 'checked' : '')?>>
		  								Receber avisos por e-mail
		  							</label>
		  							
		  							<p class="help-block">Os e-mails são enviados todas as segundas, exceto para os avisos.</p>
		  						</div>
		  					</div>
          					
          					<div class="form-actions">
          						<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Editar</button>
          						<button type="reset" class="btn btn-danger"><i class="icon-trash icon-white"></i> Limpar</button>
          						<a href="javascript:history.go(-1)" class="btn btn-inverse"><i class="icon-arrow-left icon-white"></i> Voltar</a>
          					</div>
          				</fieldset>
          			</form>
        		</div><!--/span-->
      		</div><!--/row-->