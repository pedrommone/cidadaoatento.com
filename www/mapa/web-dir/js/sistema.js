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
	var initialLocation, latlng, token = 0, registrandoDenuncia = false, logado = false, localMarcado = false;
	
	var opt = {
		zoom: 15,
		maxZoom: 19,
		minZoom: 5,
		mapTypeControl: false,
		streetViewControl: false,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
		disableDefaultUI: true
	};
	
	var map = new google.maps.Map(document.getElementById("mapa"), opt);
	
	var geocoder = new google.maps.Geocoder();
	var markers = [];
	var markerHelper = [];
	var denuncias = null;
	var busca = [];
	var markerCluster;
	var csrf = $("meta[name=csrf]").attr("content");
	var adUnit
	
	novaCSRF = function() {		
		$.getJSON('/seguranca/get_new', function(dados){
			csrf = dados.token;
		});
	}
	
	var adUnitDiv = document.createElement('div');	
	
	if(navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			map.setCenter(initialLocation);
			marcaLocalCidadao();
		}, function() {
			handleNoGeolocation();
		});
	} else if (google.gears) {
		var geo = google.gears.factory.create('beta.geolocation');
		geo.getCurrentPosition(function(position) {
			initialLocation = new google.maps.LatLng(position.latitude, position.longitude);
			map.setCenter(initialLocation);
			marcaLocalCidadao();
		}, function() {
			handleNoGeoLocation();
		});
	} else {
		handleNoGeolocation();
	}
	  
	function handleNoGeolocation() {
		initialLocation = new google.maps.LatLng(-19.9634, -44.1995);
		map.setCenter(initialLocation);
	}
	
	marcaLocalCidadao = function() {
		if (! localMarcado) {
			var icon = new google.maps.MarkerImage(
				"/web-dir/img/ui-marcador-pessoa.png",
				null,
				null,
				new google.maps.Point(0, 16),
				new google.maps.Size(22, 32)
			);
				
			var marker = new google.maps.Marker({
				position: initialLocation,
				map: map,
				icon: icon,
				title: "Você"
			});
			
			google.maps.event.addListener(marker, 'click', function() {
				map.setZoom(17);
				map.setCenter(marker.position);
				_gaq.push(['_trackEvent', 'Cidadão', 'Local', codigo]);
			});
			
			markers.push(marker);			
			localMarcado = true;
			
			$(window).hashChange(hashChangedCallback);
		}
	}
	
	carregaDenuncias = function() {		
		markers = [];
		markerHelper = [];
		
		$.post('/denuncias/listaClusterer', {csrfTest: csrf, post: 'true'}, function(data) {
			denuncias = data;
			
			for (var i = 0; i < denuncias.count; i++) {
				var dataDenuncia = denuncias.denuncias[i];
				
				var icon = new google.maps.MarkerImage(
					"/web-dir/upload/" + dataDenuncia.img,
					null,
					null,
					new google.maps.Point(32, 32),
					new google.maps.Size(60, 60)
				);
				
				var marker = new google.maps.Marker({
					position: new google.maps.LatLng(dataDenuncia.lat, dataDenuncia.lng),
					map: map,
					icon: icon,
					title: dataDenuncia.nome
				});
				
				addMarker(marker, dataDenuncia.codigo);
				markerHelper[dataDenuncia.codigo] = marker;
				markers.push(marker);
			}
			
			markerCluster = new MarkerClusterer(map, markers);			
		});
		
		_gaq.push(['_trackEvent', 'Denúncias', 'Carregar', 'Todas']);		
		novaCSRF();
	}
	
	carregaDenuncias();
	
	addMarker = function(marker, codigo) {
		google.maps.event.addListener(marker, 'click', function() {
			carregaDenuncia(codigo);
			map.setZoom(17);
			map.setCenter(marker.position);
			_gaq.push(['_trackEvent', 'Denúncias', 'Ver', codigo]);
		});
	};
	
	$('#close-box-click').click(function(){
		$('.denuncia-box').fadeOut('slow');
	});
	
	$('.denuncia-box').hide();
	
	carregaDenuncia = function(codigo) {
		$('.denuncia-box').fadeIn('slow');
		$('#carregando-denuncia').show();
		$('#conteudo-denuncia').hide();
		
		$.post('/denuncias/carrega', {csrfTest: csrf, codigo: codigo}, function(data) {			
			$('.denuncia-box .tipo').html(data.descricao_tipo);
			$('.denuncia-box .data').html('Registrado dia ' + data.data_add);
			$('.denuncia-box .foto').attr('src', '/web-dir/upload/' + data.foto + '_thumb.' + data.ext).attr('alt', data.descricao_tipo);
			$('.denuncia-box blockquote').html(data.descricao_denuncia);
			$('#reportarDenuncia').attr('href', 'javascript:reportarDenuncia(' + data.codigo +');');
			$('#apoiarDenuncia').attr('href', 'javascript:apoiarDenuncia(' + data.codigo +');');
			$('#totalApoios').html(data.numero_apoios);
			
			if (data.pode_reportar == false)
				$('#reportarDenuncia').attr('class', 'btn btn-danger btn-mini disabled');
			else
				$('#reportarDenuncia').attr('class', 'btn btn-danger btn-mini');
				
			if (data.pode_apoiar == false)
				$('#apoiarDenuncia').attr('class', 'btn btn-success btn-mini disabled');
			else
				$('#apoiarDenuncia').attr('class', 'btn btn-success btn-mini');
				
			$('#urlShort').val(data.url);
			
			$('#conteudo-denuncia').show();
			$('#carregando-denuncia').hide();
		});
		
		_gaq.push(['_trackEvent', 'Denúncias', 'Carrega', codigo]);
		novaCSRF();
	}
	
	reportarDenuncia = function(codigo) {
		if (! $('#reportarDenuncia').hasClass('btn btn-danger btn-mini disabled')) {					
			$.post('/denuncias/reportar', {csrfTest: csrf, token: token, codigo: codigo}, function(dados){})
				.success(function() { $("#dialog-reporte-adicionado").dialog("open"); })
				.error(function() { $("#dialog-erro").dialog("open"); });
			
			carregaDenuncia(codigo);
			
			_gaq.push(['_trackEvent', 'Denúncias', 'Reportar', codigo]);
			novaCSRF();
		}
		
	};
	
	apoiarDenuncia = function(codigo) {
		if (! $('#apoiarDenuncia').hasClass('btn btn-success btn-mini disabled')) {
			$.post('/denuncias/apoiar', {csrfTest: csrf, token: token, codigo: codigo}, function(dados){});
			
			carregaDenuncia(codigo);
			
			_gaq.push(['_trackEvent', 'Denúncias', 'Apoiar', codigo]);
			novaCSRF();
		}
	};
	
	$('.nav-terminar').hide();
	
	$("#procurar-query").autocomplete({
		source: function(request, response) {
			_gaq.push(['_trackEvent', 'Denúncias', 'Procurar', request]);
			
			geocoder.geocode( {'address': request.term }, function(results, status) {
				response($.map(results, function(item) {
					return {
						label:  item.formatted_address,
						value: item.formatted_address,
						latitude: item.geometry.location.lat(),
						longitude: item.geometry.location.lng()
					}
				}));
			})
		}, select: function(event, ui) {
      		_gaq.push(['_trackEvent', 'Denúncias', 'Procurar-click', ui.item.formatted_address]);        	
       		map.setCenter(location);
      	}
    });
    
    $("#procurar-query-dois").autocomplete({
		source: function(request, response) {
			_gaq.push(['_trackEvent', 'Denúncias', 'Procurar', request]);
			
			geocoder.geocode( {'address': request.term }, function(results, status) {
				response($.map(results, function(item) {
					return {
						label:  item.formatted_address,
						value: item.formatted_address,
						latitude: item.geometry.location.lat(),
						longitude: item.geometry.location.lng()
					}
				}));
			})
		},
      	select: function(event, ui) {
      		_gaq.push(['_trackEvent', 'Denúncias', 'Procurar-click', ui.item.formatted_address]);
        	var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
       		map.setCenter(location);
      	}
    });
	
	function escondeControles() {
		$('.nav-top').fadeOut('slow');
	}
	
	function mostraControles() {
		$('.nav-top').fadeIn('slow');
	}
	
	$('#cancela-denuncia-click').click(function(){
		$('.nav-terminar').hide();
		mostraControles(); 
		map.setOptions({ draggableCursor: 'url(http://maps.google.com/mapfiles/openhand.cur), move'});
		registrandoDenuncia = false;
		_gaq.push(['_trackEvent', 'Denúncias', 'Cancela']);
	});
	
	$('#registra-denuncia-click').click(function(){
		$.getJSON('/cidadaos/validaSession', function(data){
			_gaq.push(['_trackEvent', 'Denúncias', 'Adicionar']);
			token = data.token;			
			escondeControles();
			
			if (data.erro != 0) {
				registrandoDenuncia = true;
				map.setOptions({ draggableCursor: 'crosshair' });
				
				$('.nav-terminar').show();
				
				$("#telefone").mask("(99) 9999-9999");
				$("#cpf").mask("999.999.999-99");
				
				$("#dialog-login").dialog("open");
				$("#welcome").validate({
					errorLabelContainer: $("#welcome .error"),
					rules: {
						cpf: {
							required: true,
							verificaCPF: true
						},
						telefone: {
							required: true,
							minlength: 14
						},
						termos: "required"
					},
					messages: {
						cpf: {
							required: "Preencha o seu CPF.<br />",
							verificaCPF: "Use um CPF válido.<br />"
						},
						telefone: "Preencha o seu telefone.<br />",
						termos: "Você deve aceitar os nossos termos.<br />"
					}
				});
				
				$.validator.addMethod("verificaCPF", function(value, element) {
					value = value.replace('.','');
					value = value.replace('.','');
					cpf = value.replace('-','');
				    
					while(cpf.length < 11) cpf = "0" + cpf;
					
					var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
					var a = [];
					var b = new Number;
					var c = 11;
				    
				    for (i = 0; i < 11; i++){
						a[i] = cpf.charAt(i);
						if (i < 9) b += (a[i] * --c);
				    }
				    
				    if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
					b = 0;
					c = 11;
					
					for (y = 0; y < 10; y++) b += (a[y] * c--);
					
					if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
					
					if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) return false;
				    
				    return true;
				}, 
					"Informe um CPF válido."
				);
				
			} else if (data.erro != 0){
				$("#dialog-erro").dialog("open");
				registrandoDenuncia = false;
			} else {					
				registrandoDenuncia = true;
				$('.nav-terminar').show();
				map.setOptions({ draggableCursor: 'crosshair' });
			}
		});
	});
	
	google.maps.event.addListener(map, "click", function(event) {					
		latlng = event.latLng;
		
		if (registrandoDenuncia) {
			$.post('/cidadaos/podeDenunciar', {csrfTest: csrf, token: token}, function(dados){									
				switch (dados.erro) {
					case 4:
						$("#dialog-erro-limite").dialog("open");
						break;
					case 0:
						$("#dialog-add-denuncia").dialog("open");
						break;
					case 2:
					default:
						$("#dialog-erro").dialog("open");
						break;
				}
			}, "json");
		};
		
		novaCSRF();
	});
	
	$("#dialog:ui-dialog").dialog("destroy");
	
	$("#dialog-add-denuncia").dialog({
		autoOpen: false,
		height: 350,
		width: 340,
		modal: true,
		draggable: false,
		resizable: false,
		show: "fold",
		open: function() {
			$("#foto").replaceWith($("#foto").clone(true)); 
			$("#descricao").val('');
		},
		buttons: {
			"Enviar": function() {
				$("#upload_form").validate({
					errorLabelContainer: $("#upload_form .error"),
					rules: {
						descricao: "required",
						foto: {
					    	required: true,
					    	accept: "gif|jpg|png"
					    }
					},
					messages: {
						foto: {
							required: "Você deve enviar uma foto junto com a denúncia.<br />",
							accept: "Formato de foto inválido.<br />"
						},
						descricao: "Você deve fazer um breve comentário sobre a denúncia.<br />"
					}
				});
				
				if ($("#upload_form").valid()) {
					$('#upload_form').submit();
					$("#dialog-carregando").dialog("open");				
					
					$('#upload_to').load(function(){
						var res = $.parseJSON($(this).contents().text());
						
						if (res != null) {
							$.post('/denuncias/adicionar', {csrfTest: csrf, lat: latlng.lat(), lng: latlng.lng(), tip: $('#tipo').val(), descricao: $('#descricao').val(), fot: res.html}, function(data){						
							})
							.complete(function() {
								$("#dialog-carregando").dialog("close");
								$('#dialog-adicionado').dialog('open');	
								carregaDenuncias();
								novaCSRF();
							});
						}
					});
					
					$(this).dialog("close");
				}
			},
			"Cancelar": function() {
				$(this).dialog("close");
			}
		},					
		close: function() {
			$(this).dialog("close");
		}
	})
	
	$('#contato-click').click(function() {
		$('#dialog-contato').dialog('open');
		_gaq.push(['_trackEvent', 'Contato', 'Abrir']);
	});
	
	$("#dialog-contato").dialog({
		autoOpen: false,
		height: 460,
		width: 450,
		modal: true,
		draggable: false,
		resizable: false,
		show: "fold",
		open: function(event, ui) { 
			$(".ui-dialog-titlebar-close ui-corner-all").attr('href', 'javascript:void(0)');
		},
		buttons: {
			"Enviar": function() {
				$("#contato").validate({
					errorLabelContainer: $("#contato .error"),
					rules: {
						'nome-contato': {
							required: true,
							minlength: 10
						},
						'email-contato': {
							required: true,
							email: true
						},
						'assunto-contato': {
							required: true,
							minlength: 10
						},
						'texto-contato': {
							required: true,
							minlength: 30
						}
					},
					messages: {
						'nome-contato': {
							required: "Digite seu nome. <br />",
							minlength: "O seu nome deve conter mais que 10 caracteres. <br />"
						},
						'email-contato': {
							required: "Digite um email. <br />",
							email: "Digite um email válido. <br />"
						},
						'assunto-contato': {
							required: "Digite um assunto. <br />",
							minlength: "O assunto deve conter mais que 10 caracteres. <br />"
						},
						'texto-contato': {
							required: "Digite uma mensagem. <br />",
							minlength: "A mensagem deve conter mais que 30 caracteres. <br/>"
						}
					}
				});
				
				if ($("#contato").valid()) {					
					$.post('/ticket/novo', {csrfTest: csrf, nome: $('#nome-contato').val(), email: $('#email-contato').val(), assunto: $('#assunto-contato').val(), texto: $('#texto-contato').val()}, function(data){
						switch (data.erro) {
							case 0:
								$("#dialog-ticket-enviado").dialog("open");
								
								$('#nome-contato').val('');
								$('#email-contato').val('');
								$('#assunto-contato').val('');
								$('#texto-contato').val('');	
								break;
							default:
								$("#dialog-erro").dialog("open");
								break;								
						}					
						
						$('#dialog-contato').dialog('close');	
						novaCSRF();	
					});					
				}															
			},
			"Cancelar": function() {
				$(this).dialog("close");
			}
		},					
		close: function() {
			$(this).dialog("close");
		}
	})
	
	$("#dialog-adicionado").dialog({
		modal: true,
		autoOpen: false,
		draggable: false,
		minWidth: 500,
		resizable: false,
		show: "fold",
		hide: "fold",
		buttons: {
			Ok: function() {
				$(this).dialog("close");
			}
		}
	});
	
	$("#dialog-erro").dialog({
		modal: true,
		autoOpen: false,
		draggable: false,
		minWidth: 500,
		resizable: false,
		show: "fold",
		hide: "fold",
		buttons: {
			Ok: function() {
				$(this).dialog("close");
			}
		}
	});
	
	$("#dialog-ticket-enviado").dialog({
		modal: true,
		autoOpen: false,
		draggable: false,
		minWidth: 500,
		resizable: false,
		show: "fold",
		hide: "fold",
		buttons: {
			Ok: function() {
				$(this).dialog("close");
			}
		}
	});
	
	$("#dialog-usuario-telefone").dialog({
		modal: true,
		autoOpen: false,
		draggable: false,
		minWidth: 500,
		resizable: false,
		show: "fold",
		hide: "fold",
		buttons: {
			Ok: function() {
				$(this).dialog("close");
			}
		}
	});
	
	$("#dialog-erro-limite").dialog({
		modal: true,
		autoOpen: false,
		draggable: false,
		minWidth: 500,
		resizable: false,
		show: "fold",
		hide: "fold",
		buttons: {
			Ok: function() {
				$(this).dialog("close");
			}
		}
	});
	
	$("#dialog-logado").dialog({
		modal: true,
		autoOpen: false,
		draggable: false,
		minWidth: 500,
		resizable: false,
		show: "fold",
		hide: "fold",
		buttons: {
			Ok: function() {
				$(this).dialog("close");
			}
		}
	});
	
	$("#dialog-reporte-adicionado").dialog({
		modal: true,
		autoOpen: false,
		draggable: false,
		minWidth: 500,
		resizable: false,
		show: "fold",
		hide: "fold",
		buttons: {
			Ok: function() {
				$(this).dialog("close");
			}
		}
	});
	
	$("#dialog-login").dialog({
		modal: true,
		autoOpen: false,
		draggable: false,
		minWidth: 500,
		minHeight: 500,
		resizable: false,
		show: "fold",
		hide: "fold",
		close: function(ev, ui) {
			if (! logado) {
				$('.nav-terminar').hide();
				mostraControles();
			}
		},
		buttons: {
			"Enviar": function() {
				if ($("#welcome").valid()) {
					$.post('/cidadaos/login', {csrfTest: csrf, cpf: $('#cpf').val(), telefone: $('#telefone').val()}, function(dados){
						token = dados.token;
						
						switch (dados.erro) {
							case 3:
								$('#dialog-usuario-telefone').dialog("open");
								logado = false;
								break;
							case 0:
								$('#dialog-login').dialog("close");
								$("#dialog-logado").dialog("open");
								logado = true;
								break;
							default:
								$("#dialog-erro").dialog("open");
								logado = false;
								break;
						}
						
						novaCSRF();						
					}, "json");
				}
			},
			"Cancelar": function() {
				$(this).dialog("close");
				$('.nav-terminar').hide();
				mostraControles();
			}
		}
	});
	
	$("#dialog-carregando").dialog({
		height: 140,
		modal: true,
		autoOpen: false,
		draggable: false,
		resizable: false,
		height: 85,
		show: "fold",
		hide: "fold",
		closeOnEscape: false,
		open: function(event, ui) { 
			$(".ui-dialog-titlebar-close").hide();
		}		
	});
	
	$("#dialog-termos").dialog({
		modal: true,
		autoOpen: false,
		draggable: false,
		minWidth: 500,
		minHeight: 500,
		resizable: false,
		show: "fold",
		hide: "fold",
		buttons: {
			"Ok": function() {
				$(this).dialog("close");
			}
		}
	});
	
	$('#termos-click').click(function(){
		$("#dialog-termos").dialog("open");
		_gaq.push(['_trackEvent', 'Termos', 'Abrir']);
	});
	
	$("#dialog-como-funciona").dialog({
		modal: true,
		autoOpen: false,
		draggable: false,
		minWidth: 550,
		minHeight: 355,
		resizable: false,
		show: "fold",
		hide: "fold",
		open: function(event, ui) { 
			$(".ui-dialog-titlebar-close ui-corner-all").attr('href', 'javascript:void(0)');
		}
	});
	
	$("#dialog-primeira-visita").dialog({
		modal: true,
		autoOpen: false,
		draggable: false,
		minWidth: 550,
		minHeight: 355,
		resizable: false,
		show: "fold",
		hide: "fold",
		buttons: [
			{
				text: 'Pular',
				click: function() {
					$(this).dialog("close");
					_gaq.push(['_trackEvent', 'Apresentação', 'Pular']);
				}
			}
		],
		open: function(event, ui) { 
			$(".ui-dialog-titlebar-close ui-corner-all").attr('href', 'javascript:void(0)');
			_gaq.push(['_trackEvent', 'Apresentação', 'Abrir']);
		}
	});
	
	$('#como-funciona-click').click(function(){
		$("#dialog-como-funciona").dialog("open");
		_gaq.push(['_trackEvent', 'Como-funciona', 'Abrir']);
	});
	
	$("#dialog-blog").dialog({
		modal: true,
		autoOpen: false,
		draggable: false,
		minWidth: 500,
		minHeight: 500,
		resizable: false,
		show: "fold",
		hide: "fold",
		open: function(event, ui) { 
			$(".ui-dialog-titlebar-close ui-corner-all").attr('href', 'javascript:void(0)');
		}
	});
	
	$('#blog-click').click(function(){
		$("#dialog-blog").dialog("open");
		_gaq.push(['_trackEvent', 'Blog', 'Abrir']);
	});
	
	function hashChangedCallback(newHash, oldHash) {
		google.maps.event.trigger(markerHelper[newHash], 'click');
	}
	
	criaHash = function(codigo){
		window.location.hash = "#" + codigo;
		return false;
	}
	
	$('#logo-click').click(function(){
		carregaDenuncias();
		map.setCenter(initialLocation);
		map.setZoom(17);
		_gaq.push(['_trackEvent', 'Logo', 'Click']);
	});
	
	$('#urlShort').click(function(){
		this.select();
		_gaq.push(['_trackEvent', 'Denúncias', 'Encurtador', 'Click']);
	})
	
	$("#carousel").rcarousel({
		auto: {enabled: true, direction: 'next', interval: 10000},
		width: 300,
		height: 45,
		visible: 1,
		step: 1
	});
	
	$(window).hashChange(hashChangedCallback);
	
	checkPrimeiraVisita = function() {		
		$.getJSON('/cidadaos/primeiraVisita', function(dados){
			if (dados.primeira)
				$("#dialog-primeira-visita").dialog("open");
		});
	}
	
	checkPrimeiraVisita();
});