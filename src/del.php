<?php
session_start();

// $db = new PDO('pgsql:dbname=' . $_SERVER['DB_NAME'] . ';port=' . $_SERVER['DB_PORT'] . ';host=' . $_SERVER['DB_HOST'], $_SERVER['DB_USER'], $_SERVER['DB_PASS']);
// $db->query("SET search_path TO legrosprojet_dodeyk;");

$idtache = pg_escape_string($_POST["id_tache"]);

$result = $db->query("delete from tache where id_tache=$idtache");
header("Location: .");


