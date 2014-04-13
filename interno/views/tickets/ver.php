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
        				<li><a href="/tickets">Tickets</a> <span class="divider">/</span></li>
        				<li><li class="active">Ver</li></li>
        			</ul>
        			
        			<div class="page-header">
        				<h1>
        					Mostrando ticket #<?=$ticket->codigo?>
        				</h1>
        			</div>
        			
        			<div class="row-fluid"> 
        				<div class="span9">
        					<dl class="dl-horizontal">
        						<dt>Nome</dt>
        							<dd><?=$ticket->nome?></dd>
        						<dt>Email</dt>
        							<dd><?=$ticket->email?></dd>
        						<dt>Assunto</dt>
        							<dd><?=$ticket->assunto?></dd>
        						<dt>Horario</dt>
        							<dd><?=converteData($ticket->dia_add)?> as <?=$ticket->hora_add?></dd>
        						<dt>Texto</dt>
        							<dd><?=$ticket->texto?></dd>
        					</dl>
        				</div>
        				
	          			<div class="span3" style="text-align: right;">
	          				<? if($ticket->aberto == 'S'): ?>
								<a href="/tickets/encerrar/<?=$ticket->codigo?>"class="btn btn-danger"><i class="icon-remove icon-white"></i> Encerrar</a>
							<? else: ?>
								<a href="/tickets/abrir/<?=$ticket->codigo?>"class="btn btn-sucess"><i class="icon-ok"></i> Abrir</a>
							<? endif; ?>
							
							<a href="javascript:history.go(-1)" class="btn btn-inverse"><i class="icon-arrow-left icon-white"></i> Voltar</a>
	          			</div>
	          			
	          			<script type="text/javascript">
	          				$(document).ready(function(){
	          					$("#resposta").keypress(function(event){
								    var key = event.which;
								 	var maxLength = 500;
								    var length = this.value.length;
								        
								    //todas as teclas incluindo enter
								    if(key >= 33 || key == 13 || key == 8)
								    	if(length >= maxLength)
								            event.preventDefault();
								            
								    $('#left').text(maxLength - length);
								});
	          				});
						</script>
							          			
	          			<div class="span12">
		          			<? if(count($respostas) == 0): ?>
		          				<h2>Nenhuma reposta para exibir</h2>
		          				<hr>
		          			<? else: ?>
		          				<h2>Respostas</h2>
			          			<? foreach($respostas as $r): ?>			          			
		        					<dl class="dl-horizontal">
		        						<dt>Horario</dt>
		        							<dd><?=$r->dia_add?> as <?=$r->hora_add?></dd>
		        						<dt>Autor</dt>
		        							<dd><?=($r->nome == null ? 'Usuário' : $r->nome)?></dd>
		        						<dt>Resposta</dt>
		        							<dd style="width: 60%; height: 60px; overflow: auto;"><?=$r->resposta?></dd>
		        					</dl>		
		        				
		        					<hr>		        				        				
			        			<? endforeach; ?>
			        		<? endif; ?>
			        	</div>
			        	
			        	<hr>
			        	
			        	<div class="span12">
			        		<? if(isset($erro) || @validation_errors()):?>
								<div class="alert alert-error">
									<?=@$erro?>
									<?=@validation_errors()?>
								</div>
							<? endif; ?>
								
			        		<form class="form-horizontal" action="/tickets/ver/<?=$ticket->codigo?>" method="post">
		          				<fieldset>
		          					<div class="control-group">
		          						<label class="control-label" for="resposta">Resposta</label>
		          						<div class="controls">
		          							<textarea id="resposta" class="input-xlarge" maxlength="500" style="width: 70%;" id="resposta" name="resposta" rows="10" cols="40" ></textarea>
		          							<p class="help-block">Resposta do ticket. (Ainda restam <span id="left">500</span> caracteres a serem digitados.)</p>
		          						</div>
		          					</div>
		          					
		          					<div class="form-actions">
		          						<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> Responder</button>
		          					</div>
		          				</fieldset>
		          			</form>
			        	</div>
	          		</div>
        		</div><!--/span-->
      		</div><!--/row-->