<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <link href="../bootstrap/bootstrap.min.css" rel="stylesheet">  
    <script src="../js/jquery/jquery.js"></script>
    <script src="../js/bootstrap/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
      <!-- Brand -->
      <a class="navbar-brand" href="#">RASEC - SAV</a>

      <!-- Toggler/collapsibe Button -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar links -->
      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="../page/main.php">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../page_sav/intervention.php">Faire une demande d'intervention</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../page_sav/devis.php">Faire un devis</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../page/mes_demandes.php">Mes demandes</a>
          </li>
        </ul>
<?php
  if(isset($_SESSION['user']) && !empty($_SESSION['user']))
  {
?>
<a href="../require/deconnexion.php" class="btn btn-outline-primary btn-lg ml-auto">Déconnexion</a>
<?php
  }
  else
  {
?>
<?php
  }
?>
      </div>
    </nav>
<?php
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);
?>