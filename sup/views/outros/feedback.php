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
			Feedback
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
								
  			<form class="form-horizontal" action="/outros/feedback" method="post">
  				<fieldset>
  					
  					<div class="control-group">
  						<div class="control-group">
      						<div class="controls">
      							<p class="help-block">Use o feedback somente para requisitar uma nova ferramenta e/ou relatório.</p>
      						</div>
      					</div>
  					</div>
  					<div class="control-group">
  						<div class="control-group">
      						<label class="control-label" for="feedback">Feedback</label>
      						<div class="controls">
      							<textarea id="feedback" class="input-xlarge" style="width: 70%;" id="feedback" name="feedback" rows="10" cols="40" ></textarea>
      							<p class="help-block">Preencha com o máximo de detalhes possível.</p>
      						</div>
      					</div>
  					</div>				
  					
  					<div class="form-actions">
  						<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Enviar</button>
  						<a href="javascript:history.go(-1)" class="btn btn-inverse"><i class="icon-arrow-left icon-white"></i> Voltar</a>
  					</div>
  				</fieldset>
  			</form>
  		</div>
	</div>
</div><!--/span-->