<?php
include "db.php"; // Inclui o arquivo de conexão com o banco de dados

// Função para validar se o nome contém ao menos dois nomes
function validarNome($nome) {
    $nomes = explode(' ', trim($nome));
    return count($nomes) >= 2;
}

// Função para exibir mensagens de erro
function exibirErros($erros) {
    foreach ($erros as $erro) {
        echo "<script>alert('$erro');</script>";
    }
    echo "<script>window.history.back();</script>"; // Volta para a página anterior
}

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém e sanitiza os dados do formulário
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $data_nascimento = $_POST["datanascimento"];
    $genero = $_POST["genero"];
    $biografia = trim($_POST["biografia"]);

    // Inicializa um array para armazenar mensagens de erro
    $erros = [];

    // Valida os campos
    if (empty($nome) || !validarNome($nome)) {
        $erros[] = "O nome deve conter pelo menos dois nomes.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erros[] = "E-mail inválido.";
    }

    if (empty($datanascimento)) {
        $erros[] = "A data de nascimento é obrigatória.";
    }

    if (empty($genero)) {
        $erros[] = "O gênero é obrigatório.";
    }

    if (empty($biografia)) {
        $erros[] = "A biografia é obrigatória.";
    }

    // Se houver erros, exibe-os e interrompe a execução
    if (!empty($erros)) {
        exibirErros($erros);
        exit;
    }

    // Caso não haja erros, tenta inserir os dados no banco de dados
    try {
        $stmt = $conn->prepare("INSERT INTO Cadastro (Nome, Email, DataNasc, Genero, Biografia) VALUES (?, ?, ?, ?, ?)");
    
        // Faz o bind dos parâmetros com os valores reais fornecidos pelo formulário
        // O parâmetro "sssss" significa que cada uma das cinco variáveis é uma string (s)
        $stmt->bind_param("sssss", $nome, $email, $data_nascimento, $genero, $biografia);
    
        // Tenta executar a declaração preparada
        if ($stmt->execute()) {
            // Se a execução for bem-sucedida, exibe uma mensagem de sucesso ao usuário
            echo "<script>alert('Cadastro realizado com sucesso!');</script>";
        } else {
            // Se houver um erro na execução, lança uma exceção com a mensagem de erro retornada pelo MySQL
            throw new Exception("Erro ao realizar o cadastro: " . $stmt->error);
        }
    
        // Fecha o statement (declaração preparada) para liberar recursos do servidor
        $stmt->close();
        
        // Fecha a conexão com o banco de dados
        $conn->close();
    
        // Redireciona o usuário para a página principal (ou para outra página conforme o caminho especificado)
        echo "<script>window.location.href = 'index.php';</script>"; // Certifique-se de que 'index.php' é o caminho correto
    } catch (Exception $e) {
        // Se uma exceção for capturada, exibe uma mensagem de erro ao usuário com o conteúdo da exceção
        echo "<script>alert('Erro: " . $e->getMessage() . "');</script>";
    
        // Volta o usuário à página anterior para que ele possa corrigir os dados do formulário
        echo "<script>window.history.back();</script>";
    }    
}
?>
