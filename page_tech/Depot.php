<?php
  session_start();
  ob_start();
  
  /* detect session */
  if(isset($_SESSION['user']) && !empty($_SESSION['user']['FOURNISSEURID']))
  {
?>

<form method="POST" action="sendDoc.php" enctype="multipart/form-data">
    <div class="mx-3">
        <label for="parcours_doc[]" class="form-label">Déposer un document : </label>
        <input type="hidden" name="MAX_FILE_SIZE" value="4194304">
        <input type="file" multiple="oui" class="form-control" name="parcours_doc[]" id="parcours_doc">
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Déposer</button>
</form>

<?php
  }
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
  $content = ob_get_clean();
  require("../page/alert.php")
?>