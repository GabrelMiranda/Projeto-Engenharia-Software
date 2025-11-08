<?php
$hostname = "localhost";
$username = "";
$password = "";
$dbname = "banco";

// Conecta-se ao banco de dados
$con = mysqli_connect($hostname, $username, $password, $dbname);

// Verifica se a conexão foi bem-sucedida
if (!$con) {
    die("Erro na conexão: " . mysqli_connect_error());
}

// Para selecionar o banco de dados (se não foi passado no construtor)
// mysqli_select_db($con, $dbname);

echo "Conectado com sucesso!";

// Para fechar a conexão
// mysqli_close($con);
?>