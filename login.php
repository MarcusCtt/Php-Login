<?php
    // Passa o arquivo conexao.php como parâmetro
    include('conectar.php');

    // Bloco para verificar se as variáveis email e senha existem
    if(isset($_POST['email']) || isset($_POST['senha'])){

        if(strlen($_POST['email']) == 0){
            echo "Preencha seu e-mail";
        } else if(strlen($_POST['senha']) == 0) {
            echo "Preencha sua senha";
        } else {

            // Prevenção de SQL Injection - Limpeza de string
            $email = $mysqli->real_escape_string($_POST['email']);
            $senha = $mysqli->real_escape_string($_POST['senha']);

            // Selecionar todos os campos email e senha da tabela usuários
            $sql_code = "SELECT * FROM cliente WHERE email = '$email' AND senha = '$senha'";

            // Caso ocorra algum erro
            $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

            // Verificar se a quantidade de registro encontrado for 1
            $quantidade = $sql_query->num_rows;

            if($quantidade == 1){

                // Guardar os dados do usuario na variável
                $usuario = $sql_query->fetch_assoc();

                // Caso não exista sessão 
                if(!isset($_SESSION)) {
                    session_start(); // Criar nova sessão
                }

                // Armazenar o id e nome na sessão - continua válida mesmo quando a pessoa troca de página
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['email'] = $usuario['email'];

                // Redirecionar para a página painel.php
                header("Location: painel.php");

            } else {
                // Erro - email e senha incorretos
                echo "Falha ao logar! E-mail ou senha incorretos";
            }
        }

    }
?>



<doctype! html>
<html>

<link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">


<head>
<meta charset="UTF-8">


<style>

html {
  height: 100%;
}

body {
  display: flex;
  justify-content: center;
  margin:0;
  padding:0;
  font-family: sans-serif;
  background: linear-gradient(to right, #ffecd2, #fcb69f);

}

.login-box {

  top: 50%;
  left: 50%;
  width: 400px;
  padding: 70px;
  transform: translate(-50%, -50%);
  background-image: linear-gradient(to left, #f59b7d, rgb(255, 172, 172));
  box-sizing: border-box;
  box-shadow: 0 15px 25px rgba(0,0,0,.6);
  border-radius: 57px;
  z-index: 99;
  position: absolute;
  overflow: hidden;
  z-index: 10;
box-shadow: inset 10px 10px 10px rgba(247,127,0,0.05),15px 25px 10px rgba(247,127,0,0.1),15px 20px 20px rgba(247,127,0,0.1),
inset -10px -10px 15px rgba(255,255,255,0.5);

}

.login-box h2 {
  margin: 0 0 30px;
  padding: 0;
  color: #fff;
  text-align: center;
}

.login-box .user-box {
  position: relative;
}

.login-box .user-box input {
  width: 100%;
  padding: 10px 0;
  font-size: 16px;
  color: #fff;
  margin-bottom: 30px;
  border: none;
  border-bottom: 1px solid #fff;
  outline: none;
  background: transparent;
}
.login-box .user-box label {
  position: absolute;
  top:0;
  left: 0;
  padding: 10px 0;
  font-size: 16px;
  color: #fff;
  pointer-events: none;
  transition: .5s;
}

.login-box .user-box input:focus ~ label,
.login-box .user-box input:valid ~ label {
  top: -20px;
  left: 0;
  color: #ffecd2;
  font-size: 12px;
}

.login-box form a {
  position: relative;
  display: inline-block;
  padding: 10px 20px;
  color: #ffecd2;
  font-size: 16px;
  text-decoration: none;
  text-transform: uppercase;
  overflow: hidden;
  transition: .5s;
  margin-top: 40px;
  letter-spacing: 4px
}

.login:hover {
  background: linear-gradient(to right, #fcb69f, #ffecd2);
  color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 5px #ffc0cb,
              0 0 25px #ff6f9c,
              0 0 50px #ffc4d8,
              0 0 100px #fad0dd;
}

.login-box a span {
  position: absolute;
  display: block;
}

.login-box a span:nth-child(1) {
  top: 0;
  left: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, transparent, #ffecd2);
  animation: btn-anim1 1s linear infinite;
}

@keyframes btn-anim1 {
  0% {
    left: -100%;
  }
  50%,100% {
    left: 100%;
  }
}

.login-box a span:nth-child(2) {
  top: -100%;
  right: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(180deg, transparent, #ffecd2);
  animation: btn-anim2 1s linear infinite;
  animation-delay: .25s
}

@keyframes btn-anim2 {
  0% {
    top: -100%;
  }
  50%,100% {
    top: 100%;
  }
}

.login-box a span:nth-child(3) {
  bottom: 0;
  right: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(270deg, transparent, #ffecd2);
  animation: btn-anim3 1s linear infinite;
  animation-delay: .5s
}

@keyframes btn-anim3 {
  0% {
    right: -100%;
  }
  50%,100% {
    right: 100%;
  }
}

.login-box a span:nth-child(4) {
  bottom: -100%;
  left: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(360deg, transparent, #ffecd2);
  animation: btn-anim4 1s linear infinite;
  animation-delay: .75s;
}

@keyframes btn-anim4 {
  0% {
    bottom: -100%;
  }
  50%,100% {
    bottom: 100%;
  }
}

.login {
  color: white;
  text-decoration: none;
}

.lnr-eye {
    position: absolute;
    color: white;
    top: 19px;
    right: 10px;
    cursor: pointer;
}

.btn.signin{
color: white;
padding-top: 35px;
text-align: center;
bottom: 150px;
right: -140px;
margin-left: 700px;
z-index: 1;
width: 120px;
height: 100px;
border-radius: 49% 51% 52% 48% / 63% 59% 41% 37%;
background-image: linear-gradient(to left, #f59b7d, rgb(255, 172, 172));
box-shadow: inset 10px 10px 10px rgba(247,127,0,0.05),15px 25px 10px rgba(247,127,0,0.1),15px 20px 20px rgba(247,127,0,0.1),
inset -10px -10px 15px rgba(255,255,255,0.5);
font-family: arial;

}
.btn.signin::before{
left: 20px;
width: 15px;
height: 15px;
}
.btn.signin:hover {
  background: linear-gradient(to right, #fcb69f, #ffecd2);
  color: #fff;
  box-shadow: 0 0 5px #ffc0cb,
              0 0 25px #ff6f9c,
              0 0 50px #ffc4d8,
              0 0 100px #fad0dd;
}

</style>

</head>
<body>

 <nav class="navbar navbar-expand-lg bg-transparent fixed-top" id="NavbarHomepage">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Brenda Nunes</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Categorias
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Anéis</a></li>
                            <li><a class="dropdown-item" href="#">Brincos</a></li>
                            <li><a class="dropdown-item" href="#">Colares</a></li>
                            <li><a class="dropdown-item" href="#">Pulseiras/Braceletes</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Novidades</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Coleções
                        </a>
                        <ul class="dropdown-menu">


                            <li><a class="dropdown-item" href="#">Oliva</a></li>
                            <li><a class="dropdown-item" href="#">Florescer</a></li>
                            <li><a class="dropdown-item" href="#">Pedras Naturais</a></li>

                        </ul>
                       
                    <li class="nav-item dropdown">
                        <div class="container-fluid">
                        <a class="navbar-brand"  href="#">
                        <img src="C:\Users\ALUNO\Downloads\shoppingcart.png" style="width: 4%; margin-left: 800px;" alt="#" >
                    </a>
                    </div>
                    </li>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<script>

lnr-eye.addEventListener('click',function(){
input.type = input.type == 'text' ? 'password' : 'text';

document.getElementById('lnr-eye').addEventListener('mousemove', function() {
  document.getElementById('pass').type = 'password';
});

</script>

<div class="login-box">
  <h2>Login</h2>
  <form method="post">
    <div class="user-box">
      <input type="text" name="email" required="">
      <label>E-mail/Usuário</label>
    </div>
    <div class="user-box">
      <input type="password" name="senha" id= "password" required="">
      <label>Senha</label>
      <span class="lnr lnr-eye"></span>
    </div>
    <a  href="#" class="login" style="margin-left: 69px;">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      Log in
</a>


  </form>
</div>
<br><br><br><br>
<a href="cadastro.html" class='btn signin'>Cadastre-se</a>

</body>
</html>