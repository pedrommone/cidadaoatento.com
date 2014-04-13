<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="eng" lang="eng">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>Cidadão Atento</title>
	<link href='http://fonts.googleapis.com/css?family=Bangers&amp;v2' rel='stylesheet' type='text/css' />	
	<link rel="stylesheet" type="text/css" href="http://mapa.cidadaoatento.com/web-dir/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="http://mapa.cidadaoatento.com/web-dir/css/main.css" />	
	<script src="http://mapa.cidadaoatento.com/web-dir/js/jquery-1.6.2.js" type="text/javascript"></script>
	<script src="http://mapa.cidadaoatento.com/web-dir/js/jquery.spritely-0.6.js" type="text/javascript"></script>
	<script type="text/javascript">
		(function($) {
			$(document).ready(function() {			
				$('#astronaut')
					.sprite({fps: 8, no_of_frames: 1})
					.spRandom({top: 40, bottom: 300, left: 30, right: 300, speed: 5000, pause: 1000});
				$('#space').pan({fps: 30, speed: 2, dir: 'right', depth: 70});
			});
		})(jQuery);	
	</script>
</head>
<body>
<div id="container">
	<div id="stage" class="stage">
		<div id="space" class="stage"></div>
		<div id="astronaut" class="stage">
			<div id="text_1">Houston,<br />we have a<br />problem!</div>
			<div id="text_2">Erro 404!</div>
			<div id="text_3">O endereço<br />que você procura<br />não existe</div>
			<div id="text_4">Tente outra dimensão!</div>
			<div id="text_5">Ou tente <a href="http://mapa.cidadaoatento.com">voltar para a terra!</a></div>
		</div>
	</div>
</div>
</body>
</html>
