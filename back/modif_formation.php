<?php
require_once 'inc/init.inc.php';

extract($_SESSION['t_utilisateurs']);

//-------------------mise à jour dune experience---------------
if (!empty($_POST)) {

    $result = executeRequete(
        " UPDATE t_formations SET formation = :formation, stitre_form = :stitre_form, dates_form = :dates_form, description_form = :description_form, id_utilisateur = $id_utilisateur WHERE id_formation = :id_formation",
                                array(
                                    ':id_formation' => $_POST['id_formation'],
                                    ':formation' => $_POST['formation'],
                                    ':stitre_form' => $_POST['stitre_form'],
                                    ':dates_form' => $_POST['dates_form'],
                                    ':description_form' => $_POST['description_form']
                                ));

    if ($result -> rowCount() == 1) { // si j'ai une ligne dans $result, j'ai modifié une formation
    $contenu .= '<div class="alert alert-success" role="alert">la formation à bien été modifier</div>';
    } else {
        $contenu .= '<div class="alert alert-danger" role="alert">Erreur lors de la modification</div>';
    }
}

//-------------------------------
$id_formation = $_GET['id_formation'];

$resultat = $pdo->query(" SELECT * FROM t_formations WHERE id_formation = '$id_formation' ");


while($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
    $contenu .= '<form method="post" action="formations.php">';
        // debug($ligne);
        
        foreach($ligne as $indice => $valeur){ 
            $contenu .= '<div class="form-group">';
                
                if ($indice == 'id_formation' || $indice =='id_utilisateur'){
                        
                    $contenu .= '<input type="hidden" name="'. $indice .'" id="'. $indice .'" value="' . $valeur . '">';
                }else{
                    $contenu .='<label for="'.$indice.'">    '.$indice.'</label>';
                    $contenu .= '<input class="form-control"  id="'. $indice .'" value="' . $valeur . '" name="'. $indice .'">';
                }
                
            $contenu .='</div>';
            
        }
        $contenu .='<input type ="submit" id="'.$ligne['id_formation'] .'" value="Modifier" class="form-control btn-success">';
        $contenu .='<form>';
        $contenu .= '<div class="mt-2"><strong ><a href="formations.php" class="form-control btn-success"><i class="fas fa-graduation-cap"></i>&nbsp;Formations</a></div class="danger"></strong></div>';    
    }// fin while($ligne = $resultat->fetch(PDO::FETCH_ASSOC))
//--------------------------AFFICHAGE--------------------------
    require_once 'inc/haut.inc.php';
    ?>
    
    <div class="container mt-5" style="min-width: 180vh">
       
        <div class="row d-flex justify-content-center bg-info mt-5">
            <div class="col-lg-6 m-3">
            <h2 class="text-center m-5">La mise à jour d'une formation</h2>
                <?php echo  $contenu ;?>
            </div>
        </div>
    
    </div>
    
    <?php
    //le bas de page
    require_once 'inc/bas.inc.php';
