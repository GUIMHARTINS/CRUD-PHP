<?php

try {
    $pdo = new PDO("mysql:dbname=CRUDPDO;host=localhost", "root", "root");
    
}

catch (PDOException $e) {
    echo "Erro com banco de dados: ".$e->getMessage();
}

catch(Exception $e) {
    echo "Erro genérico:".$e->getMessage();
}


//----------INSERT--------------

// 1 FORMA: PREPARE

//$res = $pdo->prepare("INSERT INTO pessoa(nome, telefone, email) VALUES (:n, :t, :e)"); 

//$res->bindValue(":n", "Guilherme Gatinho");
//$res->bindValue(":t", "14991451576");
//$res->bindValue(":e", "guilhermemartins011@gmail.com");
//$res->execute();

// 2 FORMA: QUERY

//$pdo->query("INSERT INTO pessoa(nome, telefone, email) VALUES ('Gui Fofo', '14998598189', 'guifofo@gmail.com')");

//------------ DELETE E UPDATE ---------------

//$cmd = $pdo->prepare("DELETE FROM pessoa WHERE id = :id");
//$id = 2;
//$cmd->bindValue(":id", $id);
//$cmd->execute();

// OU

//$res = $pdo->query("DELETE FROM pessoa WHERE id = '3'");

//$cmd = $pdo->prepare("UPDATE pessoa SET email = :e WHERE id = :id");
//$cmd->bindValue(":e", "guizinho595@hotmail.com");
//$cmd->bindValue(":id", 1);
//$cmd->execute();

//$res = $pdo->query("UPDATE pessoa SET nome = 'João Guilherme'")

//------------ SELECT --------------

$cmd = $pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
$cmd->bindValue(":id", 1);
$cmd->execute();
//(PDO::FETCH_ASSOC) -> Filtra pelo nome da coluna
$resultado = $cmd->fetch(PDO::FETCH_ASSOC);

foreach ($resultado as $key => $value) {
    echo $key.": ".$value."<br>";
}
?>