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

require_once('cones_backup/zip.lib.php');

$email = date("H:i:s")." Iniciando Backup. (Cone's Backup System)\n";
$erros = 0;

// CONFIGURAÇÔES
if (!class_exists('S3'))require_once('cones_backup/S3.php');
			
if (!defined('awsAccessKey')) define('awsAccessKey', '');
if (!defined('awsSecretKey')) define('awsSecretKey', '');

$nomeZip = "files_backup-".date("j_m_Y-H_i_s").".zip";

$archive = new PclZip($nomeZip);
$v_dir = dirname("../mapa/web-dir/upload/");
 
//$v_list = $archive->create($v_dir, PCLZIP_OPT_REMOVE_PATH, $v_dir);
$v_list = $archive->create($v_dir);
if ($v_list == 0) {
	$email .= "ERRO: ".$archive->errorInfo(true)."\n";
	$erros++;
} else {
	$email .= date("H:i:s")." ZIP temporario compactado. (nome: ".$nomeZip." tamanho: ". filesize($nomeZip) / 1024 ." kb)\n";
}

// UPLOAD S3
$s3 = new S3(awsAccessKey, awsSecretKey);
	
if (!$s3->putObjectFile($nomeZip, "s3.cidadaoatento.com", $nomeZip)) {
	$email .= date("H:i:s")." ERRO AO ENVIAR ZIP PARA A S3! (NOME: ".$nomeZip." TAMANHO: ".filesize($nomeZip).")\n";
	$erros++;
} else {
	$email .= date("H:i:s")." Backup enviado com sucesso!\n";
}
	
// DELETA .ZIP
if (unlink($nomeZip)) {
	$email .= date("H:i:s")." ZIP temporario deletado.\n";
} else {
	$email .= date("H:i:s")." ZIP temporario deletado.\n";
	$erros++;
}
	
	
// ENVIA LOG
$headers = implode("\n", array("From: cidadaoatento@cidadaoatento.com",
								"Reply-To: cidadaoatento@cidadaoatento.com",
								"Subject: [MySQL] ".date("H:i:s j/m/y"),
								"Return-Path: cidadaoatento@cidadaoatento.com",
								"MIME-Version: 1.0",
								"X-Priority: 3",
								"Content-Type: text/html; charset=UTF-8"));
	
$assunto = "[Arquivos]";
if ($erros > 0) { $assunto = "[ERRO]"; }

if ( !mail("pedromaia@cidadaoatento.com", $assunto." ".date("H:i:s j/m/y"), nl2br($email), $headers)){
	echo "Erro ao enviar email.";
}

?>