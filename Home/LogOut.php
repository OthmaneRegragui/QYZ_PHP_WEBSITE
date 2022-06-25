<?php
include_once('./php/session.php');
session_unset(); 
session_destroy(); 
gc_collect_cycles();
header("Location: ".$Url);
?>