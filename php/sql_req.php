<?php 
function sql_inser_p($bdd, $id){

    $uploaddir = 'wamp/www/php/cdcf/';
    $uploadfile = $uploaddir . basename($_FILES['cdcf']['name']);

    $request = $bdd->prepare("INSERT INTO Projects VALUES(NULL, '".$_POST["project_name"]."', '".$_POST["descript"]."',
                        NULL, '-1', '-1', '-1', '-1', '-1', '".$id."', '".$uploadfile."')");
    $request->execute();

    move_uploaded_file($_FILES["cdcf"]["name"], $uploadfile);


    $id_proj = sql_select($bdd, "id", "projects", "WHERE Creator_id=".$id);

    sql_update($bdd, "members", "project_ID = '".$id_proj[0][0]."'", "ID = '".$id."'" );
}

function sql_insert_v($bdd, $id_user, $id_project, $nb_vote){
    if ($_POST["vote"]){
        if ($nb_vote[0][5] == -1)
            $nb_vote[0][5] = 1;
        else
            $nb_vote[0][5]+=1;

        $request = $bdd->prepare("INSERT INTO vote VALUES(NULL, '".$id_user."', '".$id_project."', '1')");
        $request->execute();

        sql_update($bdd, "projects", "vote_nbr = '".$nb_vote[0][5]."'", "ID = '".$id_project."'" );
        sql_update($bdd, "projects", "Valid = '1'", "ID = '".$id_project."'" );
    }else{
        $request = $bdd->prepare("INSERT INTO vote VALUES(NULL, '".$id_user."', '".$id_project."', '0')");
        $request->execute();
    }
}

function sql_update($bdd, $colomn, $table_set, $precision){
    $request = $bdd->prepare("UPDATE ".$colomn." SET ".$table_set." WHERE ".$precision);
    $request->execute();
}

function sql_select($bdd, $column, $table, $precision = ""){
    $request = "SELECT ".$column." FROM ".$table."  ".$precision;
    $responce = $bdd->query($request);

    for ($i=0; $result = $responce->fetch() ; $i++) { 
        for ($u=0; $result[$u]; $u++) { 
            $tab[$i][$u] = $result[$u];
        }
    }
    return $tab;
}
