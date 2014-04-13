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

$json = array();

if (isset($_POST['email'])) {	
	$conn = mysql_connect('mysql03-farm26.kinghost.net', 'cidadaoatento01', 'T5Ju2l5P');
	mysql_select_db('cidadaoatento01', $conn);
	
	$email 		= mysql_real_escape_string($_POST['email']);
	$hora		= date("Y-m-d h:i:s", time());
	$ip 		= $_SERVER['REMOTE_ADDR'];
	$navegador 	= isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';  
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		if (mysql_query("INSERT INTO tbl_emails VALUES (NULL, '$email', '$hora', '$ip', '$navegador')", $conn))
			$json['msg'] = "success";
		else
			$json['msg'] = "error";
	} else
		$json['msg'] = "error";
} else
	$json['msg'] = "error";

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
echo json_encode($json);