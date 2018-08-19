<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Sla</title>
    <meta name="author" content="Adtile">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet/less" type="text/css" href="css/styles.less" />
    <script src="//cdnjs.cloudflare.com/ajax/libs/less.js/3.0.0/less.min.js" ></script>
    <script src="js/responsive-nav.js"></script>
  </head>
  <body>

    <header>
      <a href="#home" class="logo" data-scroll>Fixed Nav</a>
      <nav class="nav-collapse">
        <ul>
          <li class="menu-item active"><a href="#home" data-scroll>Home</a></li>
          <li class="menu-item"><a href="#about" data-scroll>About</a></li>
          <li class="menu-item"><a href="#projects" data-scroll>Projects</a></li>
          <li class="menu-item"><a href="#blog" data-scroll>Blog</a></li>
          <li class="menu-item"><a href="http://www.google.com" target="_blank">Google</a></li>
        </ul>
      </nav>
    </header>
    <!--<div class="carrousel">
            <div>
                <img  src="imagens/banner.jpg" alt="imagem do banner" style="width:100% ;min-width:100%;  ">
            </div>
            <div>
                <img src="imagens/banner2.jpg" alt="imagem do banner">
            </div>
            <div>
                <img src="imagens/banner3.jpg" alt="imagem do banner">
            </div>
        </div>-->
    <main id="main">
        
        <div class="container-escolha">
                <h3>Qual tipo de cadastro você deseja?</h3>
                <input type="submit" name="cliente" id="cliente" value="Cadastrar como cliente">
                <input type="submit" name="profissional" id="profissional"value="Cadastrar como Profissional">
        </div>

        <div class="form-profissional">
            <form action="" method="post">
                <label for="nome">Nome:</label><br>
                <input type="text" name="nome" id="nome"><br>
                <label for="cpf">Cpf</label><br>
                <input type="text" name="cpf" id="cpf"><br>
                <label for="email">Email:</label><br>
                <input type="email" name="email" id="email"><br>
                <label for="telefone">Telefone:</label><br>
                <input type="text" name="telefone" id="telefone"><br>
                <select name="cidade" id="cidade"><br>
                    <option value="Recife">Recife</option>
                </select>
                <select name="bairro" id="bairro"><br>
                    <option value="bairro1">bairro1</option>
                    <option value="bairro2">bairro2</option>
                    <option value="bairro3">bairro3</option>
                    <option value="bairro4">bairro4</option>
                </select>
            </form>
        </div>
        <!--enviar um array via ajax no post do js pra o php com os bairros que ele atende-->
        <div class="form-cliente">
        <form action="" method="post">
                <label for="nome">Nome:</label><br>
                <input type="text" name="nome" id="nome"><br>
                <label for="cpf">Cpf</label><br>
                <input type="text" name="cpf" id="cpf"><br>
                <label for="email">Email:</label><br>
                <input type="email" name="email" id="email"><br>
                <label for="telefone">Telefone:</label><br>
                <input type="text" name="telefone" id="telefone"><br>
            </form>
        </div>
         
    </main>
    
    <script src="js/fastclick.js"></script>
    <script src="js/scroll.js"></script>
    <script src="js/fixed-responsive-nav.js"></script>
    
    <script>

            $(document).ready(() => {
    
            });
    
    
        </script>
  </body>
</html>
