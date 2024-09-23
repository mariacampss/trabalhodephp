<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Cadastro</title>
    <link rel="stylesheet" href="style.css"> <!-- Link para seu arquivo CSS -->
</head>
<body>
    <div class="form-container">
        <h1>Formulário de Cadastro</h1>
        <form action="func.php" method="post">
            <label for="nome">Nome Completo</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>

            <label for="data_nascimento">Data de Nascimento</label>
            <input type="date" id="datanascimento" name="datanascimento" required>

            <label for="genero">Gênero</label>
            <select id="genero" name="genero" required>
                <option value="masculino">Masculino</option>
                <option value="feminino">Feminino</option>
                <option value="outros">Outros</option>
            </select>

            <label for="biografia">Biografia</label>
            <textarea id="biografia" name="biografia" rows="4" required></textarea>

            <button type="submit">Enviar</button>
        </form>

    </div>
</body>
</html>