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
<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<meta charset="utf-8">
		<title>SUP - Cidadão Atento</title>
		<meta name="viewport" content="width=device-width, inital-scale=1.0">	

		<!-- estilos -->
		<link rel="stylesheet" href="/web-dir/css/bootstrap.min.css" title="Bootstrap">
		<link ref="stylesheet" href="/web-dir/css/bootstrap-responsive.min.css" title="Bootstrap-responsive">
		<style type="text/css">
			body {
				padding-top: 20px;
			}
		</style>

		<!-- icone -->
		<link rel="shortcut icon" href="/web-dir/favicon.ico">		

		<!-- suporte IE 6 -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- javascript -->
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="/web-dir/js/bootstrap.min.js"></script>
	</head>

	<body>		
		<div class="container">
			<div class="row">
				<div class="span8 offset2">	
					<? if(isset($erro) || validation_errors()):?>
					<div class="alert alert-error">
						<?=@$erro?>
						<?=validation_errors()?>
					</div>
					<? endif; ?>
					<form class="well form-horizontal" action="/login" method="POST">
						<fieldset>
							<div class="control-group">
								<label class="control-label" for="codigo">Código</label>
								<div class="controls">
									<input name="codigo" class="input-xlarge" id="codigo" type="text" placeholder="Código">
								</div>
							</div>							

							<div class="control-group">
								<label class="control-label" for="senha">Senha</label>
								<div class="controls">
									<input name="senha" class="input-xlarge" id="senha" type="password" placeholder="Senha">
								</div>
							</div>
							
							<div class="form-actions">
								<button type="submit" class="btn btn-primary">Entrar</button>
							</div>
						</fieldset>
					</form>
				</div>	
			</div>
		</div>
	</body>

</html>