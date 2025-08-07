<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login do Sistema</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 30px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }
        .icon {
            font-size: 50px;
            margin-bottom: 10px;
        }
        h2 {
            margin-bottom: 20px;
        }
        input {
            box-sizing: border-box;
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #218838;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .forgot {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            text-decoration: none;
            color: #007bff;
        }
        .forgot:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">👤</div>
        <h2>Login do Sistema</h2>
        <form method="POST" action="valida_login.php">
            <input type="text" name="usuario" placeholder="Usuário ou e-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Entrar</button>           
        </form>
        <a href="recuperar_senha.php" class="forgot">Esqueceu a senha?</a>
    </div>
</body>
</html>