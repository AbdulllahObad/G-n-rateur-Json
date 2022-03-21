<?php
session_start();
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8" />
      <title>QuiEstCe</title>
      <meta name="description" content="this is our play" />
      <link rel="stylesheet" href="css2.css">
      <link rel="stylesheet" href="style.css">
   </head>
   <body>
      <?php if (!empty($_POST["telecharger"])) {
         $array_for_verif=$_SESSION['json']['possibilites'];
         for($i=1;$i<$_SESSION['json']['colonne']*$_SESSION['json']['ligne'];$i++){
            for($j=1;$j<$_SESSION['json']['colonne']*$_SESSION['json']['ligne'];$j++){
               $equal=true;
               if($i!=$j){
                  foreach($array_for_verif[$i] as $key=>$val){
                     if($key!='fichier'){
                        if($array_for_verif[$i][$key]!=$array_for_verif[$j][$key]){
                           echo $array_for_verif[$i][$key].' : '.$array_for_verif[$j][$key].' <br>';
                           $equal=false;
                        }
                     }
                     }
                  }
                  if($equal){
                     //echo $array_for_verif[$i]['nom']." et ".$array_for_verif[$j]['nom']." sont identiques || <br> ||";
                  }else{
                     if (file_put_contents("C:/Users/ayoub/Downloads/"."fichier.json", json_encode($_SESSION['json']))) {
                        echo "Bravo !";
                    } else {
                        echo "Merde";
                    }
               }
            }
         }
         } ?>
      <div id="gris"></div>
      <br>
      <div class="div_attribut">
         <?php if (isset($_SESSION['json']) && $_SESSION['json']['colonne'] > 0 && $_SESSION['json']['ligne'] > 0) { ?>
         <div><button class="ajouter">Ajouter</button></div>
         <div class="div">
            <form action="" method="post" class="form_attribut">
               <?php
                  $perso_current = $_SESSION['json']["possibilites"]["1"];
                  foreach ($perso_current as $key => $val) {
                      if ($key != "fichier") {
                          echo '<input type="texte" name="attribut[]" value=' . $key . '>';
                      }
                  }
                  ?>
               <div><input type="submit" name="valide_attribut" value="Valider"></div>
            </form>
            <?php } else {echo '<div style="color:red;">Veuillez d\'abord saisir un nombre de colonnes et lignes positifs avant d\'ajouter des attributs</div>';} ?>
         </div>
      </div>
      <div class="container2">
         <div>
            <form action="" method="post"><input type="submit" name="telecharger" value="Telecharger"></form>
         </div>
         <div class="attributperso"></div>
         <div style="" class="container1">
            <form action="" method="post">
               <div class="form" style="height:100%;">
                  <label for="ligne">Nombre de lignes :</label>
                  <br>
                  <input type="text" name="ligne" style="height:43%;">
               </div>
               <div class="form" class="form" style="height:100%;">
                  <label for="colonne">Nombre de colonnes :</label>
                  <br>
                  <input type="text" name="colonne" style="height:43%;">
               </div>
               <input type="submit" name="valider" value="Valider grille" style="height:100%;">
            </form>
            <div class="form2" style="height:100%;">
               <button style="height:48%;width:100%;" class="but">Modifier arguments</button>
               <form method="post" style="height:48%;">
                  <input type="submit" name="reset" value="Reset tableau" style="height:100%;width:100%;">
               </form>
            </div>
         </div>
         <br>
         <div class="toutesPersonnages">
            <?php
               if (!empty($_POST['valider'])) {
                   $_SESSION['json'] = [];
                   $_SESSION['json']['colonne'] = $_POST['ligne'];
                   $_SESSION['json']['ligne'] = $_POST['colonne'];
                   $taille_colonne = $_SESSION['json']['colonne'];
                   $taille_ligne = $_SESSION['json']['ligne'];
                   $taille_tab = intval($taille_colonne) * intval($taille_ligne);
                   for ($i = 0; $i < $taille_tab; $i++) {
                       $_SESSION['json']['possibilites'][strval($i + 1)] = ["fichier" => ""];
                   }
                   file_put_contents('temp_fichier.json',json_encode($_SESSION['json']));
               }
               if (!empty($_SESSION['json']['colonne']) && !empty($_SESSION['json']['ligne'])) {
                   $taille_colonne = $_SESSION['json']['colonne'];
                   $taille_ligne = $_SESSION['json']['ligne'];
                   $taille_tab = intval($taille_colonne) * intval($taille_ligne);
                   $size_div = (98-0.6*($taille_colonne-1))/$taille_colonne;
                   for ($i = 0; $i < $taille_ligne; $i++) { ?>
            <div class="ligne">
               <?php for ($j = 0; $j < $taille_colonne; $j++) { ?>
               <div class='personnage' style=<?php echo "width:".$size_div."%;height:".$size_div*7.4116108786610878661087866108787."px;" ?> id=<?php echo $i * $taille_colonne + $j + 1; ?> style="display:inline-flex;" ><img style="height:100%;width:100%" src=<?php echo "'" . $_SESSION['json']['possibilites'][$i * $taille_colonne + $j + 1]['fichier'] . "'"; ?> alt=""></div>
               <?php } ?>
            </div>
            <?php }
               }
               ?>
         </div>
      </div>
      <?php
         if (!empty($_POST['reset'])) {
             $_SESSION['json']['colonne'] = 0;
             $_SESSION['json']['ligne'] = 0;
             $_SESSION['json']['possibilites'] = null;
         }
         /*if(!empty($_POST['reset'])){
         $_SESSION['json']['possibilites']=NULL;
         $taille_tab=$_SESSION['json']['ligne']*$_SESSION['json']['colonne'];
         for($i=0;$i<$taille_tab;$i++){
         
         
         $_SESSION['json']['possibilites'][strval($i+1)]=array("fichier"=>"");
         
         
         }
         file_put_contents('fichier.json',json_encode($_SESSION['json']));
         }*/
         if (!empty($_POST['valide_attribut']) && $_SESSION['json']['colonne'] > 0 && $_SESSION['json']['ligne'] > 0) {
             $taille_tab = intval($_SESSION['json']['colonne']) * intval($_SESSION['json']['ligne']);
             for ($i = 0; $i < $taille_tab; $i++) {
                 foreach ($_POST['attribut'] as $key => $val) {
                     $id = (string) $i + 1;
                     if (empty($_SESSION['json']['possibilites'][$id]["$val"])) {
                         $_SESSION['json']['possibilites'][$id]["$val"] = '';
                     }
                 }
             }
             file_put_contents('temp_fichier.json', json_encode($_SESSION['json']));
         }
         if (!empty($_POST['modif_attribut'])) {
             $perso_current = $_SESSION['json']["possibilites"][$_POST['id']];
             foreach ($perso_current as $key => $val) {
                 if ($key == 'fichier' && $_POST[$key] != "") {
                     $_SESSION['json']["possibilites"][$_POST['id']][$key] = $_POST[$key];
                 } elseif ($key != 'fichier') {
                     $_SESSION['json']["possibilites"][$_POST['id']][$key] = $_POST[$key];
                 }
             }
             file_put_contents('temp_fichier.json', json_encode($_SESSION['json']));
         }
         ?>
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
      <script src="script.js"></script>
   </body>
</html>