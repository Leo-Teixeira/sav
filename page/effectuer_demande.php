<?php
  session_start();
  ob_start();
  
  /* detect session */
  if(isset($_SESSION['user']) && !empty($_SESSION['user']['CLIENTID']))
  {
?>

<h1 class="text-justify text-center">Effectuez une demande en ligne</h1>
<form method="POST" action="../mail.php" enctype="multipart/form-data">
    <div class="mx-3">
        <label for="code" class="form-label">Code Client :</label>
        <input type="text" class="form-control" name="code" id="code">
    </div>
    <div class="mx-3">
        <label for="email" class="form-label">Adresse email : </label>
        <input type="email" class="form-control" name="email" id="email">
    </div>
    <div class="mx-3">
        <label for="sujet_demande" class="form-label">Sujet de la demande : </label>
        <textarea type="text" class="form-control" name="sujet_demande" id="sujet_demande" placeholder="Entrez votre demande"></textarea>
    </div>
    <div class="mx-3">
        <label for="parcours_fichier[]" class="form-label">Déposer un document : </label>
        <input type="hidden" name="MAX_FILE_SIZE" value="4194304">
        <input type="file" multiple="oui" class="form-control" name="parcours_fichier[]" id="parcours_fichier">
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>

<?php
  }
  else
  {
    $_SESSION['message']['content'] = "Vous devez être connecté pour accéder à cette page.\n";
    $_SESSION['message']['type'] = "danger";
    header("Location: index.php");
    exit();
  }

  $content = ob_get_clean();
  require("alert.php")
?>