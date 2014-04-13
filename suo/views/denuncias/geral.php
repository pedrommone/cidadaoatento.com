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
		<h1>Geral</h1>
	</div>

	<div class="row-fluid">
		<div class="span4 well">
			<h2>Denúncias</h2>
			<h1><?=$numero_denuncias?></h1>
		</div>
		
		<div class="span4 well">
			<h2>Cidadãos</h2>
			<h1><?=$numero_cidadaos?></h1>
		</div>
		
		<div class="span4 well">
			<h2>Apoios</h2>
			<h1><?=$numero_apoios?></h1>
		</div>
	</div>
	
	<div class="row-fluid">
		<div class="span4 well">
			<h2>Denúncias solucionadas</h2>
			<h1><?=$numero_solucionadas?></h1>
		</div>
		
		<div class="span4 well">
			<h2>Denúncias não solucionadas</h2>
			<h1><?=$numero_pendentes?></h1>
		</div>
	</div>
</div>