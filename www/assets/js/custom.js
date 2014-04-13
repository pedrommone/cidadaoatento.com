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
 $(document).ready(function(){	
	var a = new Date("November 9, 2012 00:00:00");
	
	$("#counter").countdown({
		until: a, 
		layout:'<div class="first"><p>{dn}</p> <span class="days">{dl}</span></div> <div class="item"><p>{hn}</p> <span class="hours">{hl}</span></div> <div class="item"><p>{mn}</p> <span class="minutes">{ml}</span></div> <div class="item"><p>{sn}</p> <span class="seconds">{sl}</span></div>'}
	);
	
	$("#year").text(a.getFullYear());
	
	$('#newsletter').click(function(){
		$.post('/cadastro.php', {email: $('#email').val()}, function(data){
			$('#form').hide();
			
			switch (data.msg) {
				case 'success':
					$('#success').fadeIn('slow');
					break;
				case 'error':
					$('#error').fadeIn('slow');
					break;
			}
		}, 'json')
	});
});