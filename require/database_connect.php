<?php

mysqli_report(MYSQLI_REPORT_ERROR);

/* Functions */
/*function update_users($database)
{
  $server = connect_mysql();
  $sql = "SELECT DISTINCT UTCTNOM FROM UTILISAT WHERE UTCTDIALO = 'SAV-R'";
  if(!$res = sqlsrv_query($database, $sql))
  {
    die(sqlsrv_errors());
  }

  while($v = sqlsrv_fetch_array($res, SQLSRV_FETCH_NUMERIC))
  {
    $server->query("INSERT INTO utilisateur(IDENTIFIANT) VALUES ('".$v[0]."')");
  }
}

function update_Four($database)
{
  $server = connect_mysql();
  $requetePhp = "SELECT MAX(DATECREA) FROM fournisseur";
  $sql = "SELECT DISTINCT CLKTCODE, CLCJCRE FROM FOURNIS ORDER BY CLCJCRE";
  if (!$res = sqlsrv_query($database, $sql))
  {
    die(sqlsrv_errors());
  }
  while($v = sqlsrv_fetch_array($res, SQLSRV_FETCH_NUMERIC))
  {
    $server->query("INSERT INTO fournisseur(CODE, DATECREA) VALUES ('".$v[0]."', '".$v[1]."')");
  }
}*/

/*function update_Client($database)
{
  $server = connect_mysql();
  //$requetePhp = $server->query("SELECT MAX(DATECREA) FROM client");
  $sql = "SELECT DISTINCT CLKTCODE, CLCJCRE FROM client order by CLCJCRE";
  if (!$res = sqlsrv_query($database, $sql))
  {
    die(sqlsrv_errors());
  }
  while($v = sqlsrv_fetch_array($res, SQLSRV_FETCH_NUMERIC))
  {
    $server->query("INSERT INTO client(CODE, DATECREA) VALUES ('".$v[0]."', '".$v[1]."')");
  }
}*/

function connect_mysql()
{
  $res = new mysqli("localhost", "root", "", "sav");
  if(!$res)
  {
    return mysqli_connect_error();
  }
  return $res;
}

/*function connect_cegid()
{
  $servername = "rasec-cegid";
  $connectionInfo = array("Database" => "PMITEST5", "UID" => "SA", "PWD" => "cegid2008@");
  $conn = sqlsrv_connect($servername, $connectionInfo);
  update_users($conn);
  update_Four($conn);
  update_Client($conn);
  sqlsrv_close($conn);
}*/
?>