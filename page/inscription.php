<?php
  /* Post data treatment */
  session_start();
  require('../require/database_connect.php');
  $error_text = '';
  $db = connect_mysql();

  /* Selection verifications */
  /* Identifiant verifications */
  $identifiant = htmlspecialchars($_POST['identifiant'] ?? '');
  if(preg_match('/^[a-zA-Z0-9]{5,}$/', $identifiant))
  { 
    // for english chars + numbers only
    // valid username, alphanumeric & longer than or equals 5 chars
    $res = $db->query('SELECT UTILISATEURID FROM UTILISATEUR WHERE IDENTIFIANT = "'.$db->real_escape_string($identifiant).'"');
    if($res->num_rows > 0)
    {
      $error_text .= "Le nom d'utilisateur existe déjà, choisissez en un autre.\n";
    }
  }
  else
    $error_text .= "- Veuillez entrer un nom d'utilisateur valide : 5 caractères minimun, sans caractères spéciaux.\n";
  
  /* Password verifications */
  $password = htmlspecialchars($_POST['motdepasse'] ?? '');
  if(preg_match('/^\S{8,}/', $password))
  {
    if(!strcmp($password, htmlspecialchars($_POST['confpass'] ?? '')) == 0)
      $error_text .= "- Les deux mots de passe ne correspondent pas.\n";
    else
      $password = password_hash($password, PASSWORD_DEFAULT);
  }
  else
    $error_text .= "- Veuillez entrer un mot de passe valide : 8 caractères minimun.\n";

  /* Code clef verifications */
  $code = htmlspecialchars($_POST['codeclef'] ?? '');
  $options = htmlspecialchars($_POST['options'] ?? '');
  if(preg_match('/^[a-zA-Z0-9]{6}$/', $code))
  {
    if(strcmp($options, 'CLIENT') == 0)
    {
      $res = $db->query('SELECT * FROM UTILISATEUR JOIN CLIENT USING(UTILISATEURID) WHERE CODE = "'.$db->real_escape_string($code).'"');
      if($res->num_rows > 0)
      {
        $error_text .= "Un utilisateur est a déjà été attribué pour ce code CLIENT.\n";
      }
    }
    else if(strcmp($options, 'FOURNISSEUR') == 0)
    {
      $res = $db->query('SELECT * FROM UTILISATEUR JOIN FOURNISSEUR USING(UTILISATEURID) WHERE CODE = "'.$db->real_escape_string($code).'"');
      if($res->num_rows > 0)
      {
        $error_text .= "Un utilisateur est a déjà été attribué pour ce code FOURNISSEUR.\n";
      }
    }
    else
      $error_text .= "- Veuillez choisir un type de compte : Client ou Fournisseur / Technicien.\n";
  }
  else
    $error_text .= "- Le code clef n'est pas valide.\n";


  /* display error */
  if(!empty($error_text))
  {
    $error['type'] = 'danger';
    $error['content'] = $error_text;
  }
  else
  {
    /* Register account */
    $stmt = $db->prepare('INSERT INTO UTILISATEUR(IDENTIFIANT, MDP) VALUES(?, ?)');
    $stmt->bind_param('ss', $identifiant, $password);
    $stmt->execute();
  
    $uid = $stmt->insert_id;
    
    $stmt = $db->prepare('UPDATE '.$options.' SET UTILISATEURID = ? WHERE CODE = ?');
    $stmt->bind_param('ds', $uid, $code);
    $stmt->execute();


    $stmt->close();

    mysqli_close($db);

    /* Redirect */
    $_SESSION['message'] = "Votre inscription a été pris en compte, connectez-vous via la page de connexion.\n";
    header("Location: index.php");
    exit();
  }

  /* Database closing */
  mysqli_close($db);
  ob_start();
?>

<h1 class="card-title">Inscription</h1>
<hr/>
<form id="form-connexion" method="POST">
  <h2>Inscription en tant que : </h2>
  <div class="form-check-inline">
    <label class="form-check-label">
      <input type="radio" class="form-check-input" name="options" value="CLIENT">Client
    </label>
  </div>
  <div class="form-check-inline">
    <label class="form-check-label">
      <input type="radio" class="form-check-input" name="options" value="FOURNISSEUR">Fournisseur ou Technicien
    </label>
  </div>
  <div class="form-group">
    <label class="col-form-label col-form-label-lg" for="identifiant">Identifiant : </label>
    <input type="text" class="form-control" name="identifiant" value="<?= $identifiant ?>"></input>
  </div>
  <div class="form-group">
    <label class="col-form-label col-form-label-lg" for="motdepasse">Mot de passe : </label>
    <input type="password" class="form-control" name="motdepasse"></input>
  </div>
  <div class="form-group">
    <label class="col-form-label col-form-label-lg" for="confpass">Confirmer le mot de passe : </label>
    <input type="password" class="form-control" name="confpass"></input>
  </div>
  <div class="form-group">
    <label class="col-form-label col-form-label-lg" for="codeclef">Code clef  : </label>
    <input type="text" class="form-control" name="codeclef" value="<?= $code ?>"></input>
  </div>
  <div class="text-center">
    <input type="submit" class="btn btn-primary btn-lg col-12" value="Valider">
  </div>
</form>

<?php
  $content = ob_get_clean();
  require('alert.php');
?>