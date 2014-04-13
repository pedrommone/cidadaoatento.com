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
 <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html dir="ltr" xml:lang="pt-br" lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Cidadão Atento</title>
		
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		
		<meta name="description" content="Denuncie problemas de infraestrutura da sua rua, bairro ou cidade em um espaço democrático. Exerça sua cidadania." />
		<meta name="keywords" content="Cidadão Atento, infraestrutura, esogoto, buracos, prefeitura, problemas, cidade, rua, bairro" />
		<meta name="csrf" content="<?=$csrf_token?>" />
		
		<meta property="og:title" content="Cidadão Atento" />
		<meta property="og:description" content="Denuncie problemas de infraestrutura da sua rua, bairro ou cidade em um espaço democrático. Exerça sua cidadania." />
		<meta property="og:image" content="http://cidadaoatento.com/assets/img/fb_ico.jpg" />
		
		<link href='http://fonts.googleapis.com/css?family=Port+Lligat+Sans' rel='stylesheet' type='text/css'>
		
		<link rel="shortcut icon" href="/web-dir/favicon.ico">
		
		<link rel="stylesheet" href="/web-dir/css/resets.css" type="text/css" chatset="utf-8" />
		<link rel="stylesheet" href="/web-dir/css/jqueryUI-desktop.css" type="text/css" charset="utf-8" />
		<link rel="stylesheet" href="/web-dir/css/desktop.css" type="text/css" charset="utf-8" />
		<link rel="stylesheet" href="/web-dir/css/buttons.css" type="text/css" charset="utf-8" />
		<link rel="stylesheet" href="/web-dir/css/rcarousel.css" type="text/css" charset="utf-8" />
		
		<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-32375201-1']);
		  _gaq.push(['_setDomainName', 'cidadaoatento.com']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
		
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1&appId=368882579832451";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
		<script type="text/javascript" src="https://maps.google.com/maps/api/js?libraries=adsense&sensor=true"></script>
		<script type="text/javascript" src="/web-dir/js/infoBox.js"></script>
		<script type="text/javascript" src="/web-dir/js/jquery.mask.js"></script>
		<script type="text/javascript" src="/web-dir/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="/web-dir/js/markerClusterer.min.js"></script>
		<script type="text/javascript" src="/web-dir/js/jquery.hashable.min.js"></script>	
		<script type="text/javascript" src="/web-dir/js/jquery.ui.rcarousel.js"></script>
		<script type="text/javascript" src="/web-dir/js/sistema.js"></script>
		<script type="text/javascript" src="http://sawpf.com/1.0.js"></script>
	</head>
	
	<body>
		<div id="mapa"></div>
		
		<div class="nav-top-core">
			<div class="nav-terminar">
				<ul>
					<li><a href="javascript:void(0)" id="cancela-denuncia-click">Terminar</a></li>
					<li><input type="search" id="procurar-query" placeholder="Procurar endereço"></li>
				</ul>
			</div>
			
			<div class="nav-top">
				<div class="logo">
					<a href="javascript:void(0)" id="logo-click" alt="Cidadão Atento">
						<img src="/web-dir/img/ui-logo.png" height="80" alt="Cidadão Atento">
					</a>				
				</div>
				
				<div class="menu">
					<ul>
						<li><a href="javascript:void(0)" id="como-funciona-click">como funciona</a></li>
						<li><a href="javascript:void(0)" id="blog-click">blog</a></li>
						<li><a href="javascript:void(0)" id="contato-click">contato</a></li>
					</ul>
				</div>
				
				<div class="busca-end">
					<input type="search" id="procurar-query-dois" placeholder="Procurar endereço">
				</div>
				
				<div class="social">
					<ul>
						<li><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://cidadaoatento.com" data-lang="pt">Tweetar</a></li>
						<li></li><div class="fb-like" data-href="https://www.facebook.com/CidadaoAtento" data-send="true" data-layout="button_count" data-width="100" data-show-faces="false"></div></li>
					</ul>
				</div>
				
				<div class="nav-denuncia">
					<a href="javascript:void(0)" id="registra-denuncia-click" alt="Registrar denúncia">
						<img src="/web-dir/img/ui-registra-denuncia.png" width="240" alt="Registrar denúncia">
					</a>
				</div>
				
				<div class="denuncia-box">
					<a href="javascript:void(0)" id="close-box-click">
						<div class="close" id="close-box"></div>
					</a>
					
					<img src="/web-dir/img/ui-loading-gif.gif" alt="Carregando" id="carregando-denuncia">
					
					<div id="conteudo-denuncia">
						<div class="tipo"></div>
						
						<div class="data"></div>
						
						<img class="foto" src="" alt=""></img>
						
						<div>
							<blockquote class="comentario">							
							</blockquote>
						</div>
						
						<ul>
							<li><a id="reportarDenuncia" class="btn btn-danger btn-mini" href="">Reportar</a></li>
							<li><a id="apoiarDenuncia" class="btn btn-success btn-mini" href="">Apoiar</a></li>
							<li><div id="totalApoios" class="btn btn-mini disabled">1</div></li>
							<li><input id="urlShort" value=""></li>
						</ul>
					</div>
				</div>
			</div>	
		</div>	
		
		<div class="nav-bot">
			<div class="nav-bot-conteudo">
				<div class="box-problemas">
					<? foreach($problemas as $r): ?>
						<div class="box-problema">
							<img src="/web-dir/upload/<?=$r->img?>" height="45" alt="<?=$r->descricao?>" title="<?=$r->descricao?>">
						</div>
					<? endforeach; ?>
				</div>
				<div class="box-patrocinadores">
					<div id="carousel">
						<!--<img src="/web-dir/img/patrocinadores/1.jpg" alt="Patrocinador 1" />
						<img src="/web-dir/img/patrocinadores/2.jpg" alt="Patrocinador 2" />
						<img src="/web-dir/img/patrocinadores/3.jpg" alt="Patrocinador 3" />
						<img src="/web-dir/img/patrocinadores/4.jpg" alt="Patrocinador 4" />-->
					</div>
				</div>
			</div>
		</div>
		
		<div id="dialog-add-denuncia" title="Registrar uma denúncia">
			<br />
			<br />
			
			<p class="validateTips">Preencha todos os campos.</p>
			
			<form id='upload_form' method='post' enctype='multipart/form-data' action='/denuncias/upload' target='upload_to'>
				<p>
					<label for="tipo">Tipo de denúncia</label><br />
					<select name="tipo" id="tipo">
						<? foreach($problemas as $r): ?>
						<option value="<?=$r->codigo?>"><?=$r->descricao?></option>
						<? endforeach; ?>
					</select>
				</p>
			
				<p>
					<label for="foto">Foto</label><br />
					<input type="file" name="foto" id="foto">
				</p>
				
				<p>
					<label for="descricao">Descrição do problema</label><br />
					<textarea rows="5" cols="50" name="descricao" id="descricao"></textarea>
				</p>
				
				<div class="erro-form-geral">
					<p>
						<div class="error"></div>
					</p>
				</div>
			</form>
				
			<iframe name='upload_to' id='upload_to'></iframe>
		</div>
		
		<div id="dialog-logado" title="Aviso">
			<br />
			<br />
			
			<p>
				Você foi logado com sucesso.
			</p>
		</div>
		
		<div id="dialog-adicionado" title="Denúncia registrada">
			<br />
			<br />
			
			<p>
				Sua denúncia foi registrada com sucesso. Para ganhar mais força você pode compartilhá-la com seus amigos!
			</p>
		</div>
		
		<div id="dialog-erro" title="Erro">
			<br />
			<br />
			
			<p>
				Alguma coisa não funcionou corretamente, tente novamente em instantes.
			</p>
		</div>
		
		<div id="dialog-erro-limite" title="Erro">
			<br />
			<br />
			
			<p>
				Você excedeu o limite máximo de denúncias, tente novamente mais tarde.
			</p>
		</div>
		
		<div id="dialog-usuario-telefone" title="Erro">
			<br />
			<br />
			
			<p>
				Você digitou um CPF/Telefone que existe em nosso banco de dados, porem, eles não estão relacionados na mesma conta! Tente lembrar o CPF e o telefone que você digitou pela primeira vez.
			</p>
		</div>
		
		<div id="dialog-reporte-adicionado" title="Reporte enviado">
			<br />
			<br />
			
			<p>
				Seu report foi registrado com sucesso e será verificado em breve por um moderador.
			</p>
		</div>
		
		<div id="dialog-ticket-enviado" title="Ticket enviado">
			<br />
			<br />
			
			<p>
				O seu ticket foi enviado com sucesso! Algum moderador irá verificar logo.
			</p>
		</div>
		
		<div id="dialog-carregando" title="Carregando...">
		</div>
		
		<div id="dialog-termos" title="Termos de uso">
			<br />
			<br />
			
			<div id="termos-conteudo" class="termos">
				<p>
					O website www.cidadaoatento.com é um serviço interativo oferecido por meio de página eletrônica na internet que oferece informações sobre a situação das ruas da Região Metropolitana de Belo Horizonte/MG a partir da integração de diversas fontes de informação, especialmente aqueles fornecidas pelos visitantes do website www.cidadaoatento.com.
				</p>
				<p>
					O acesso ao website  www.cidadaoatento.com representa a aceitação expressa e irrestrita dos termos de uso abaixo descritos. Se você não concorda com os termos, por favor, não acesse nem utilize este website.
				</p>
				<p>
					O visitante poderá usar este site apenas para finalidades lícitas. Este espaço não poderá ser utilizado para publicar, enviar, distribuir ou divulgar conteúdos ou informação de caráter difamatório, obsceno ou ilícito, inclusive informações de propriedade exclusiva pertencentes a outras pessoas ou empresas, bem como marcas registradas ou informações protegidas por direitos autorais, sem a expressa autorização do detentor desses direitos. Ainda, o visitante não poderá usar o site www.cidadaoatento.com para obter ou divulgar informações pessoais, inclusive endereços na Internet, sobre os usuários do site.
				</p>
				<p>
					O website www.cidadaoatento.com empenha-se em manter a qualidade, atualidade e autenticidade das informações do site, mas seus criadores e colaboradores não se responsabilizam por eventuais falhas nos serviços ou inexatidão das informações oferecidas. O usuário não deve ter como pressuposto que tais serviços e informações são isentos de erros ou serão adequados aos seus objetivos particulares. Os criadores e colaboradores tampouco assumem o compromisso de atualizar as informações, e reservam-se o direito de alterar as condições de uso a qualquer momento.   
				</p>
				<p>
					O acesso ao site www.cidadaoatento.com é gratuito. O website www.cidadaoatento.com poderá criar áreas de acesso exclusivo às pessoas autorizadas. 
				</p>
				<p>
					Os criadores e colaboradores do website www.cidadaoatento.com poderão a seu exclusivo critério e em qualquer tempo, modificar ou desativar o site, bem como limitar, cancelar ou suspender seu uso ou o acesso. Também estes Termos de Uso poderão ser alterados a qualquer tempo. Visite regularmente esta página e consulte os Termos então vigentes. Algumas disposições destes Termos podem ser substituídas por termos ou avisos legais expressos localizados em determinadas páginas deste site.  
				</p>
				<p>
					Os documentos, informações, imagens e gráficos publicados neste site podem conter imprecisões técnicas ou erros tipográficos. Em nenhuma hipótese o website www.cidadaoatento.com será responsável por qualquer dano direto ou indireto decorrente da impossibilidade de uso, perda de dados ou lucros, resultante do acesso e desempenho do site, dos serviços oferecidos ou de informações disponíveis neste site. O acesso aos serviços, materiais, informações e facilidades contidas neste website não garante a sua qualidade. 
				</p>
				<p>
					Qualquer material, informação, artigos ou outras comunicações que forem transmitidas, enviadas  ou publicadas neste site serão considerados informação não confidencial, e qualquer violação aos direitos dos seus criadores não será de responsabilidade do website www.cidadaoatento.com.
				</p>
				<p>
					O website www.cidadaoatento.com poderá, mas não é obrigado, a monitorar, revistar e restringir o acesso a qualquer área no site onde usuários transmitem e trocam informações entre si. Porém, o website www.cidadaoatento.com não é responsável pelo conteúdo de qualquer uma das informações trocadas entre os usuários, sejam elas lícitas ou ilícitas.
 				</p>
 				<p>
 					O website www.cidadaoatento.com respeita a propriedade intelectual de outras pessoas ou empresas e solicitamos aos nossos membros que façam o mesmo. Toda e qualquer violação de direitos autorais deverá ser notificada ao website www.cidadaoatento.com e acompanhada dos documentos e informações que confirmam a autoria. A notificação poderá ser enviada pelos e-mails constantes do site.
 				</p>
 				<p>
					O acesso ao website www.cidadaoatento.com representa a aceitação expressa e irrestrita dos termos de uso acima descritos. 
				</p>
			</div>
		</div>
		
		<div id="dialog-como-funciona" title="Como funciona">
			<br />
			<br />
			
			<p>
				<iframe src="http://player.vimeo.com/video/47812201?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff&amp;autoplay=0&amp;loop=1" width="500" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			</p>
		</div>
		
		<div id="dialog-primeira-visita" title="Primeira visita">
			<br />
			<br />
			
			<p>
				<iframe src="http://player.vimeo.com/video/47812201?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff&amp;autoplay=0&amp;loop=1" width="500" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			</p>
		</div>
		
		<div id="dialog-blog" title="Blog">
			<br />
			<br />
			
			<div id="blog-conteudo" class="blog">
				<? foreach($blog as $r): ?>
					<p>
						<h1><?=$r->titulo?></h1>
						
						<blockquote>
							<?=$r->post?>
						</blockquote>
						
						<small>Em <?=converteData($r->data_post)?>, por <?=$r->nome?></small>
					</p>
				<? endforeach; ?>
			</div>
		</div>
		
		<div id="dialog-login" title="Entrar">
			<br />
			<br />
			
			<div class="box">
				<form id="welcome">				
					<p>
						<label for="cpf">CPF</label>
						<input type="text" id="cpf" name="cpf" alt="cpf"/>
					</p>
						
					<p>
						<label for="telefone">Telefone</label>
						<input type="text" id="telefone" name="telefone" alt="telefone"/>
					</p>
					
					<p id="termos">
						<input type="checkbox" id="termos" name="termos" value="s"><b />
						Declaro que li e aceito os <a id="termos-click" href="#">termos</a>.		
					</p>
					
					<div class="erro-form-geral">
						<p>
							<div class="error"></div>
						</p>
					</div>
				</form>
			</div>
		</div>
		
		<div id="dialog-contato" title="Contato">
			<br />
			<br />
			
			<div class="box">
				<form id="contato">		
					<p>
						<label for="nome-contato">Nome</label>
						<input type="text" id="nome-contato" name="nome-contato" alt="nome-contato"/>
					</p>
							
					<p>
						<label for="email-contato">Email</label>
						<input type="text" id="email-contato" name="email-contato" alt="email-contato"/>
					</p>
						
					<p>
						<label for="assunto-contato">Assunto</label>
						<input type="text" id="assunto-contato" name="assunto-contato" alt="assunto-contato"/>
					</p>
					
					<p>
						<label for="texto-contato">Mensagem</label>
						<textarea id="texto-contato" name="texto-contato" alt="texto-contato"></textarea>
					</p>
					
					<div class="erro-form-geral">
						<p>
							<div class="error"></div>
						</p>
					</div>
				</form>
			</div>
		</div>
		
		<div id="fb-root"></div>
	</body>	
</html>