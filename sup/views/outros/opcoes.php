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
			Opções
		</h1>
	</div>
	
	<div class="row-fluid">
		<div class="span12">
			<? if(isset($erro) || validation_errors()):?>
			<div class="alert alert-error">
				<?=@$erro?>
				<?=validation_errors()?>
			</div>
			<? endif; ?>
								
  			<form class="form-horizontal" action="/outros/opcoes" method="post">
  				<fieldset>
  					<div class="control-group">
  						<label class="control-label" for="email">E-mail</label>
  						<div class="controls">
  							<input type="text" class="input-xlarge" id="email" name="email" maxlength="255" value="<?=$dados->email?>">
  							<p class="help-block">E-mail para contato e/ou envio de relatórios.</p>
  						</div>
  					</div>
  					
  					<div class="control-group">
  						<label class="control-label" for="relatorios">Notificações</label>
  						<div class="controls">
  							<label class="checkbox">
  								<input type="checkbox" name="relatorios" value="sim" <?=($dados->relatorios == 'S' ? 'checked' : '')?>>
  								Receber relatórios por e-mail
  							</label>
  							
  							<label class="checkbox">
  								<input type="checkbox" name="avisos" value="sim" <?=($dados->avisos == 'S' ? 'checked' : '')?>>
  								Receber avisos por e-mail
  							</label>
  							
  							<p class="help-block">Os e-mails são enviados todas as segundas, exceto para os avisos.</p>
  						</div>
  					</div>  					
  					
  					<div class="form-actions">
  						<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Salvar</button>
  						<a href="javascript:history.go(-1)" class="btn btn-inverse"><i class="icon-arrow-left icon-white"></i> Voltar</a>
  					</div>
  				</fieldset>
  			</form>
  		</div>
	</div>
</div><!--/span-->