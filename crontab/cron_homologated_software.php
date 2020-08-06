#!/usr/bin/php
<?php
require_once('../dbconfig.inc.php');
require_once('../var.php');
require_once('../require/function_commun.php');
require_once('../require/softwares/SoftwareHomologated.php');
require_once('../require/config/include.php');
require_once('../require/fichierConf.class.php');

$_SESSION['OCS']["writeServer"] = dbconnect(SERVER_WRITE, COMPTE_BASE, PSWD_BASE, DB_NAME, SSL_KEY, SSL_CERT, CA_CERT, SERVER_PORT);
$_SESSION['OCS']["readServer"] = dbconnect(SERVER_READ, COMPTE_BASE, PSWD_BASE, DB_NAME, SSL_KEY, SSL_CERT, CA_CERT, SERVER_PORT);

$aux = new SoftwareHomologated();
$arr = $aux->get_all_not_homologated();
$aux->create_occurrences($arr);

?>