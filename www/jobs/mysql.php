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

// CONFIGURAÇÔES
if (!class_exists('S3')) require_once('cones_backup/S3.php');
		
if (!defined('awsAccessKey')) define('awsAccessKey', '');
if (!defined('awsSecretKey')) define('awsSecretKey', '');

$bancos = array(
				array(
						'host' 	=> 'mysql03-farm26.kinghost.net',
						'user' 	=> 'cidadaoatento',
						'pass' 	=> 'PEOsLcel',
						'db'	=> 'cidadaoatento'),
				array(
						'host'	=> 'mysql03-farm26.kinghost.net',
						'user'	=> 'cidadaoatento01',
						'pass'	=> 'T5Ju2l5P',
						'db'	=> 'cidadaoatento01')
				);

$email = date("H:i:s")." Iniciando Backup. (Cone's Backup System)\n";
$erros = 0;

$arquivo = array();
	
// CONECTA DB
foreach ($bancos as $banco)
{
	if ($link = mysql_connect($banco['host'], $banco['user'], $banco['pass'])) {
		$email .= date("H:i:s")." Contado com o MySQL: servidor: ".$banco['host']." usuario: ".$banco['user']."\n";
		if (mysql_select_db($banco['db'], $link)) {
			$email .= date("H:i:s")." Banco de dados selecionado: ".$banco['db']."\n";
		} else {
			$email .= date("H:i:s")." ERRO AO SELECIONAR BANCO DE DADOS!\n";
			$erros++;
		}
	} else {
		$email .= date("H:i:s")." ERRO AO SE CONECTAR COM O SERVIDOR MYSQL!\n";
		$erros++;
	}
 
	$tabelas = array();
	$resultado = mysql_query('SHOW TABLES');
	
	while ($coluna = mysql_fetch_row($resultado)) { $tabelas[] = $coluna[0]; }
	$email .= date("H:i:s")." Listando ".mysql_num_rows($resultado)." tabelas.\n";
 
	foreach ($tabelas as $tabelas)
	{
		$resultado = mysql_query('SELECT * FROM '.$tabelas);
		$num_campos = mysql_num_fields($resultado);
 
		$return.= 'DROP TABLE IF EXISTS '.$tabelas.';';
		$coluna2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$tabelas));
		$return.= "\n\n".$coluna2[1].";\n\n";
 
		for ($i = 0; $i < $num_campos; $i++)
		{
			while($coluna = mysql_fetch_row($resultado))
			{
				$return.= 'INSERT INTO '.$tabelas.' VALUES(';
				for($j=0; $j<$num_campos; $j++)
				{
					//$coluna[$j] = addslashes($row[$j]);
					$coluna[$j] = ereg_replace("\n","\\n",$coluna[$j]);
					if (isset($coluna[$j])) { $return.= '\''.$coluna[$j].'\'' ; } else { $return.= '\'\''; }
					if ($j<($num_campos-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	$email .= date("H:i:s")." Banco de dados inserido em string (tamanho: ".strlen($return).").\n";
	
	$arquivo[$banco['db']] = "bd-backup-".$banco['db'].".sql";
	
	// SALVA ARQUIVO
	$ficheiro = fopen($arquivo[$banco['db']],'w+');
	fwrite($ficheiro, $return);
	fclose($ficheiro);
	
	$return = '';
		
	if (file_exists($arquivo[$banco['db']])) {
		$email .= date("H:i:s")." SQL temporario salvo (". filesize($arquivo[$banco['db']]) / 1024 ." kb).\n";
	} else {
		$email .= date("H:i:s")." ERRO AO SALVAR ARQUIVO SQL TEMPORARIO!\n";
		$erros++;
	}
	
	$email .= "------------------------------------------------------------------------------------------\n";
}

$zip = "db_backup-".date("j_m_Y-H_i_s").".zip";
	
// COMPACTA
include("cones_backup/zip.lib.php");
$ziper = new zipfile(); 
$ziper->addFiles($arquivo);
$ziper->output($zip); 

if (file_exists($zip)) {
	$email .= date("H:i:s")." Arquivos compactados. (nome: ".$zip." tamanho: ". filesize($zip) / 1024 ." kb)\n";
} else {
	$email .= date("H:i:s")." ERRO AO COMPACTAR ARQUIVO SQL.\n";
	$erros++;
}
	
// DELETA .SQL
foreach ($arquivo as $arq)
{
	if (unlink($arq)) {
		$email .= date("H:i:s")." SQL ".$arq." temporario deletado.\n";
	} else {
		$email .= date("H:i:s")." ERRO AO DELETAR ARQUIVO SQL TEMPORARIO (".$arq.").\n";
		$erros++;
	}
}

// UPLOAD S3
$s3 = new S3(awsAccessKey, awsSecretKey);

if (!$s3->putObjectFile($zip, "s3.cidadaoatento.com", $zip)) {
	$email .= date("H:i:s")." ERRO AO ENVIAR ZIP PARA A S3! (NOME: ".$zip." TAMANHO: ".filesize($zip).")\n";
	$erros++;
} else {
	$email .= date("H:i:s")." Backup enviado com sucesso!\n";
}

// DELETA .ZIP
if (unlink($zip)) {
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

$assunto = "[MySQL]";
if ($erros > 0) { $assunto = "[ERRO]"; }

if ( !mail("pedromaia@cidadaoatento.com", $assunto." ".date("H:i:s j/m/y"), nl2br($email), $headers)){
	echo "Erro ao enviar email.";
}

?>