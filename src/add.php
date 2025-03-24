<?php
session_start();

pg_connect("host=localhost dbname=r205dodeyk user=dodeyk password=8AepKo port=5433"); 
pg_query("set names 'UTF8'");
pg_query("SET search_path TO games");

$name = pg_escape_string($_POST["name"]);

$category = pg_escape_string($_POST["category"]);

//TEST DE Validité des données --> si champ vide, ne rien insérer
if (empty($name)||empty($category)){
    $_SESSION["error"]="Champs obligatoires !";
} else{
    pg_query("insert into game(name,category)
            values('$name','$category')");
    unset($_SESSION["error"]);
}
header("Location: .");