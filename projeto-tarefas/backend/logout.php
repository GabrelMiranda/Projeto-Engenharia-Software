<?php
session_start();
session_destroy();
header("Location: ../Frontend/pages/index.html");
exit;
?>
