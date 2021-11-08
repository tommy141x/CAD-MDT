<?php
require '../connectdb.php';
$database->query("DELETE FROM mdt_warrants WHERE warrant_desc='".$_POST["warrant_desc"]."' AND warrant_owner='".$_POST["warrant_owner"]."'");
