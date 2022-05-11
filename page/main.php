<?php
  session_start();
  ob_start();
?>

<h1 class="container text-center">Comment marche le site</h1>
<p class="container text-justify text-center">Ce site à pour but principal de décharger le sav. Grâce à ce site vous pourrais envoyer des demandes au sav, ainsi que voir le déroulement de l'intervention. <br> Il y'a pour ce faire une page ou vous pourrez effectuer une demande au SAV en y ajoutant des pièces jointes. <br> Dans l'onglet mes demandes vous pourrez consulté toutes les demandes que vous avez effectué, voir celles qui sont finis, ainsi que celles en cours.</p>

<?php
  $content = ob_get_clean();
  require('alert.php');
?>