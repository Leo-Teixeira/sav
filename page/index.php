<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  session_start();
  $error_text = '';
  $identifiant = htmlspecialchars($_POST['identifiant'] ?? '');
  $password = htmlspecialchars($_POST['motdepasse'] ?? '');

  if(!empty($identifiant))
  {
    /* Database connexion */
    include '../require/database_connect.php';
    $db = connect_mysql();
    
    /* Verifications */
    if(empty($identifiant) || empty($password))
    {
      $error_text .= "Veuillez remplir tous les champs.\n";
    }
    else
    {
      /* Query */
      $res = $db->query('SELECT * FROM UTILISATEUR LEFT JOIN CLIENT USING(UTILISATEURID) LEFT JOIN FOURNISSEUR USING(UTILISATEURID) WHERE IDENTIFIANT = "'.$db->real_escape_string($identifiant).'"');
      if(password_verify($password, ($ar = $res->fetch_array())['MDP']))
      {
        $_SESSION['user'] = $ar;
      }
      else
      {
        $error_text .= "Le mot de passe ou le nom d'utilisateur est incorrect.\n";
      }
    }

    /* Error display */
    if(!empty($error_text))
    {
      $error['type'] = 'danger';
      $error['content'] = $error_text;
    }
    else
    {      
      /* Redirect */
      $_SESSION['message']['content'] = "Vous êtes connecté.\n";
      $_SESSION['message']['type'] = "success";
      header("Location: main.php");
      exit();
    }

    /* Database closing */
    mysqli_close($db);
  }

  ob_start();
?>
<div class="card my-3">
  <div class="card-body">
    <h1 class="card-title">Connexion</h1>
    <hr/>
    <form id="form-connexion" method="POST">
      <div class="form-group">
        <label class="col-form-label col-form-label-lg" for="identifiant">Identifiant : </label>
        <input type="text" class="form-control" name="identifiant" value="<?=htmlspecialchars($identifiant)?>"></input>
      </div>
      <div class="form-group">
        <label class="col-form-label col-form-label-lg" for="motdepasse">Mot de passe : </label>
        <input type="password" class="form-control" name="motdepasse"></input>
      </div>
      <div class="text-center">
        <input type="submit" class="btn btn-primary btn-lg col-12" value="Valider">
      </div>
    </form>
  </div>
</div>

<?php
  $content = ob_get_clean();
  require('alert.php');
?>