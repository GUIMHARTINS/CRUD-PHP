<?php

Class Pessoa {

    private $pdo;
    //CONEXAO COM BANCO DE DADOS
     public function __construct($dbname, $host, $user, $senha){
        try{
            $this->pdo = new PDO("mysql:dbname=".$dbname.";host=".$host,$user,$senha);
        }
        catch(PDOException $e){
            echo "Erro no banco: ".$e->getMessage();
            exit();
        }
        catch (Exception $e){
            echo "Erro generico: ".$e->getMessage();
            exit();
        }
        
     }

     // FUNCAO PARA BUSCAR OS DADOS E COLOCAR NO LADO DIREITO DA TELA
     public function buscarDados() {
        // DECLARANDO RES COMO ARRAY CASO ELE NÃO RETORNE NENHUMA
        // PESSOA ELE NAO DA ERRO, APENAS RETORNA UM ARRAY VAZIO
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM pessoa");

        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);
        return $res;
     }

     // FUNCAO DE CADASTRAR PESSOAS NO BANCO DE DADOS
     public function cadastrarPessoa($nome, $telefone, $email) {
        //ANTES DE CADASTRAR VERIFICAMOS SE JA TEM O EMAIL CADASTRADO
        $cmd = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();
        if($cmd->rowCount() > 0){ 
            // CASO SEJA MAIOR QUE 0, ENTAO O EMAIL JA EXISTE NO BANCO DE DADOS
            return false;
        } else {
        /*ENTAO O EMAIL NAO FOI ENCONTRADO NO BANCO DE DADOS*/
            $cmd = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:n, :t, :e)");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":e", $email);
            $cmd->execute();
            return true;
        }
     }

     // FUNCAO PARA DELETAR PESSOA
     public function excluirPessoa($id) {
        $cmd = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
     }

     // BUSCAR DADOS DE UMA PESSOA
     public function buscarDadosPessoa($id) {
        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
     }

     // ATUALIZAR DADOS NO BANCO DE DADOS
     public function atualizarDados($id, $nome, $telefone, $email) {
        
        $cmd = $this->pdo->prepare("UPDATE pessoa SET nome = :n,
            telefone = :t, email = :e WHERE id = :id");
        $cmd->bindValue(":n", $nome);
        $cmd->bindValue(":t", $telefone);
        $cmd->bindValue(":e", $email);
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        
     }
}