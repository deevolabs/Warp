<!DOCTYPE html>
<html>
<head>
  <title>Formulário</title>
  <link rel="stylesheet" type="text/css" href="dx.contact-form.css"/>
  <link rel="stylesheet" type="text/css" href="dx.grid.fluid.12.css"/>
  <link rel="stylesheet" type="text/css" href="dropzone.css"/>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script src="dropzone.js"></script>
  <script src="dx.contact-form.js"></script>

  <meta charset="UTF-8">
</head>
<body class="grid-fluid-12">  

<div id="contact-form" class="grid-fluid-12">
  <div class="row">
    <div class="small-12 columns">
      <h1 class="cabecalho-form-contato">Contate-nos</h1>
      <p>Se tiver qualquer pergunta ou comentário sobre nós, envie-nos um e-mail.</P> 
      <P>Use o formulário fornecido e responderemos assim que possível.</p>
    </div>
  </div>
      

  <!-- TODO: parametro action está Hardcoded, tirar quando for fazer componente-->
  <form method="post" enctype="multipart/form-data" action="/wp-content/themes/warp/libs/dx/dx.sendmail.php">

  <div class="row">
    <div class="small-12 columns">
      <div class="field">
        <label for="name">Nome: </label>
        <span class="icon-head default"></span>
        <input id="name" name="name" class="campo-nome" type="text" placeholder="Digite seu Nome" required>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="small-12 columns">
      <div class="field">
        <label for="email">E-mail: </label>
          
            <span class="icon-mail default"></span>                    
            <input name="email" id="email" type="email" placeholder="Digite seu E-mail" class="campo" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$">
          
        </div>  
    </div>   
  </div>

  <div class="row">
    <div class="small-12 columns">
      <div class="field">
      <label for="name">Anexo: </label>
        
          <span class="icon-paper-clip default"></span>                             
          <input id="anexo" name="anexo" class="anexo" type="file" required> 
          </div>
        
    </div>
  </div>      
  
  <div class="row">
    <div class="small-12 columns">
      <div class="field">               
        <label class="dp-email-label" for="departamento">Departamento: </label>      
          <span class="icon-world defalut"></span>
          <select name="departamento" class="dp-email">
            <option value="selecione">Selecione</option>
            <option>Departamento - 1</option>
            <option>Departamento - 2</option>
            <option>Departamento - 3</option>
          </select>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="small-12 columns">
      <div class="field">
        <label for="message">Mensagem: </label>
        
          <span class="icon-file default"></span>                  
          <textarea id="message" name="message" rows="10" placeholder="Digite sua mensagem aqui..."></textarea>
        
      </div>
    </div>
  </div>

  <div class="row">
    <div class="small-12 columns">
      <div class="field check-email">          
        <input id="check-email" name="check-email" class="input-check-email" type="checkbox" value="Sim" checked><span class="span-check-email" name="check-email" >Deseja receber e-mail.</span>
      </div>
    </div>
  </div>

  <div class="row espaco">
    <div class="large-6 small-12 columns">
      <div id="recaptcha" class="g-recaptcha" data-sitekey="6LeNRwkTAAAAAN6antYytXfJgil0nzw-rd9_qYnn"></div>
    </div>

    <div class="large-6 small-12 columns">
      <div class="field enviar"> 
        <input type="submit" value="Enviar" class="btnEnviar">
      </div>
    </div>
  </div>

  <div class="row">
    <div class="small-12 columns">
      <div class="alert"></div>  
    </div>
  </div>

  </form>
  <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>    
</div>

</body>
</html> 






