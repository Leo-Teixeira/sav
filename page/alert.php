<?php
if(isset($_SESSION['user']))
{
  if(!empty($_SESSION['user']['CLIENTID']))
  {
    require('../require/header_client.php');
  }
  else if(!empty($_SESSION['user']['FOURNISSEURID']))
  {
    require('../require/header_tech.php');
  }
  else if(!empty($_SESSION['user']['UTILISATEURID']))
  {
    require('../require/header_sav.php');
  }
}
else
{
  require('../require/header.php');
}
?>

<div class="container-fluid py-3 px-5">
  <?php
    /* Message display */
    $msg = htmlspecialchars($_SESSION['message']['content'] ?? '');
    if(!empty($msg))
    {
  ?>
    <div class="alert alert-<?= $_SESSION['message']['type'] ?> my-3" role="alert">
      <?= $msg ?>
    </div>
  <?php
      $_SESSION['message'] = array();
    }
    /* Error display */
    if($error ?? false)
    {
  ?>
  <div class="alert alert-<?=htmlspecialchars($error['type']) ?> my-3" role="alert">
    <?= nl2br($error['content']) ?>
  </div>
  <?php
    }
  ?>

  <!-- Page content -->
  <?= $content ?>
</div>

<?php
  require('../require/footer.php');
?>