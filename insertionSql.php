<?php
    require 'require/database_connect.php';

    $server = connect_mysql();
    $cegid = connect_cegid();
    /* fonction qui va permettre la création de la section en rapport avec cette demande */
    function createSection($code, $destinateur, $sujet, $demande, $server, $tmp_name, $namefile, $sizefile)
    {
        $req = 'insert into demande(clientid) values ((select CLIENTID from client where CODE ='.$code.'))';
        $res = $server->query($req);
        $section = 'insert into section(demandeid, sectype, content) values ('.$server->insert_id.',1,"'.addslashes($demande).'")';
        $resSection = $server->query($section);
        $id = $server->insert_id;
        for ($cpt=0; $cpt<count($namefile); $cpt++)
        {      
            $document ='insert into document(sectionid, bytes, nom) values ('.$id.', "'.addslashes(file_get_contents($tmp_name[$cpt])).'", "'.addslashes($namefile[$cpt]).'")';
            $resDocument = $server->query($document);
        }
    }

    function depot_doc($namefile, $tmp_name)
    {
        for ($cpt=0; $cpt<count($namefile); $cpt++)
        {      
            $document ='insert into document(sectionid, bytes, nom) values (3, "'.addslashes(file_get_contents($tmp_name[$cpt])).'", "'.addslashes($namefile[$cpt]).'")';
            $resDocument = $server->query($document);
        }
    }
?>