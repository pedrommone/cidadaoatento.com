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

if ($_SERVER["REMOTE_ADDR"] != "189.38.85.36")
	die("Acesso não autorizado");

if (!class_exists('S3')) require_once('cones_backup/S3.php');
			
if (!defined('awsAccessKey')) define('awsAccessKey', '');
if (!defined('awsSecretKey')) define('awsSecretKey', '');

$files = "";
$erros = 0;
$cont = 0;

$s3 = new S3(awsAccessKey, awsSecretKey);

$buckets = $s3->getBucket("s3.cidadaoatento.com");

$oldTime = time() - (4 * 24 * 60 * 60);
//					 D    H    M    S

$email .= date("H:i:s")." Iniciando o rotina de limpeza! (Cone's Backup System)\n";

foreach ($buckets as $bucket)
{
	if ($bucket['time'] < $oldTime) {
		//echo "old file!</br>";
		if ($s3->deleteObject("s3.cidadaoatento.com", $bucket['name'])) {
			$email .= date("H:i:s")." ".$bucket['name']."  deletado com sucesso!\n";
			$cont++;
		} else {
			$email .= date("H:i:s")." Ocorreu um erro ao deletar o arquivo ".$bucket['name']."!\n";
			$erros++;
		}
	}
}

$email .= date("H:i:s")." Rotina concluida! ".$cont." arquivos foram apagados!\n";

$headers = implode("\n", array("From: cidadaoatento@cidadaoatento.com",
								"Reply-To: cidadaoatento@cidadaoatento.com",
								"Subject: [MySQL] ".date("H:i:s j/m/y"),
								"Return-Path: cidadaoatento@cidadaoatento.com",
								"MIME-Version: 1.0",
								"X-Priority: 3",
								"Content-Type: text/html; charset=UTF-8"));

$assunto = "[Cleaner]";
if ($erros > 0) { $assunto = "[ERRO]"; }

if ( !mail("pedromaia@cidadaoatento.com", $assunto." ".date("H:i:s j/m/y"), nl2br($email), $headers)){
	echo "Erro ao enviar email.";
}

?>