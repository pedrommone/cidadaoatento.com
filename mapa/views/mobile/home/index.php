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
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
        
<html dir="ltr" xml:lang="pt-br" lang="pt-br" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Cidadão Atento</title>
		
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
		
		<meta name="description" content=""/>
		<meta name="keywords" content=""/>
	    
		<link rel="stylesheet" href="/web-dir/css/jquery.mobile-1.1.0.css" type="text/css" charset="utf-8" />
		
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script type="text/javascript" src="/web-dir/js/jquery.mobile-1.1.0.min.js"></script>
	</head>
	<body>
		<div data-role="page" id="home">
            <div data-role="content">
                <h2>
                    Cidadão Atento
                </h2>
                <ul data-role="listview" data-divider-theme="b" data-inset="true">
                    <li data-role="list-divider" role="heading">
                        Denúncias
                    </li>
                    <li data-theme="c">
                        <a href="/mobile/enviar" data-transition="slide">
                            Enviar
                        </a>
                    </li>
                    <li data-theme="c">
                        <a href="/mobile/denuncias" data-transition="slide">
                            Denúncias próximas
                        </a>
                    </li>
                    
                    <li data-role="list-divider" role="heading">
                        Outros
                    </li>
                    <li data-theme="c">
                        <a href="#" data-transition="slide">
                            Como funciona
                        </a>
                    </li>
                    <li data-theme="c">
                        <a href="#" data-transition="slide">
                        	Blog
                        </a>
                    </li>
                    <li data-theme="c">
                        <a href="#" data-transition="slide">
                            Contato
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <script>
            //App custom javascript
        </script>
	</body>
</html>
