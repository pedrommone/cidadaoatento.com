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
			Mostrando denúncia #<?=$d->codigo?>
		</h1>
	</div>
	
	<div class="row-fluid"> 
		<div class="span8">
			<dl class="dl-horizontal">
				<dt>Código</dt>
					<dd><?=$d->codigo?></dd>
				<dt>Data adicionada</dt>
					<dd><?=converteData($d->data_add)?> as <?=$d->hora_add?></dd>
				<? if(($d->solucionado == "S")): ?>
				<dt>Data solucionada</dt>
					<dd><?=converteData($d->data_solu)?> as <?=$d->hora_solu?></dd>
				<? endif; ?>
				<dt>Verificada</dt>
					<dd><?=simNao($d->verificada)?></dd>
				<dt>Solucionada</dt>
					<dd><?=simNao($d->solucionado)?></dd>
				<dt>Tipo de problema</dt>
					<dd><?=$d->nome_problema?></dd>
					<dd><?=strtoupper($d->uf)?></dd>
				<dt>Descrição</dt>
					<dd><?=$d->descricao?></dd>
				<dt>Apoios</dt>
					<dd><?=$d->numero_apoios?></dd>
				<dt>Endereço</dt>
					<dd><?=($d->endereco == null ? 'N/A' : $d->endereco)?></dd>
				<dt>Foto</dt>
					<dd><img src="http://mapa.cidadaoatento.com/web-dir/upload/<?=$d->foto?>"></dd>
			</dl>
		</div>
		
		<div class="span4" style="text-align: right;">
			<a href="http://mapa.cidadaoatento.com/#<?=$d->codigo?>" target="_blank" class="btn btn-info"><i class="icon-picture icon-white"></i> Mapa</a>
			
			<? if($d->solucionado == "N"): ?>
				<a href="/denuncias/solucionar/<?=$d->codigo?>"class="btn btn-danger"><i class="icon-remove icon-white"></i> Solucionar</a>	
			<? endif; ?>
			
			<a href="javascript:history.go(-1)" class="btn btn-inverse"><i class="icon-arrow-left icon-white"></i> Voltar</a>
		</div>
	</div>
</div><!--/span-->