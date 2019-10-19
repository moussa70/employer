<?php
$monfichier = file('data.txt');
$nombreDeLigne = count($monfichier);
for ($i=0; $i < $nombreDeLigne; $i++) {
    $ligne = $monfichier[$i];
    $mot = explode(' ', $ligne);
    if($mot[0]==$_POST['editer']){
        $ligneAModifier = $monfichier[$i];
    }
}

if (isset($_POST['editer'])) {
    $variables = explode(' ', $ligneAModifier);
    $matricule = $variables[0];
    $nom = $variables[1];
    $prenom = $variables[2];
    $birthday = $variables[3];
    $salaire = $variables[4];
    $phone = $variables[5];
    $mail = $variables[6];
}
    if (isset($_POST['validation'])) {
        

        if (!empty($_POST['nom']) and !empty($_POST['prenom']) and !empty($_POST['birthday']) and !empty($_POST['salaire']) and !empty($_POST['phone']) and !empty($_POST['mail'])) {
            $prenom = trim(htmlspecialchars($_POST['prenom']));
            $nom = trim(htmlspecialchars($_POST['nom']));
            $birthday = trim(htmlspecialchars($_POST['birthday']));
            $salaire = trim(htmlspecialchars($_POST['salaire']));
            $phone = trim(htmlspecialchars($_POST['phone']));
            $mail = trim(htmlspecialchars($_POST['mail']));
            
            if (ctype_alpha($prenom) && ctype_alpha($nom)) {
                if (strptime($birthday, "%d/%m/%Y")) {
                    if ($salaire>=25000 && $salaire<=2000000) {
                        if (preg_match('#^7[7|6|0|8][0-9]{7}$#', $phone)) {
                            if (preg_match('#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#', $mail)) {
                                
                                $matricule = $_POST['matricule'];

                                $tab = "$matricule $nom $prenom $birthday $salaire $phone $mail\n";

                                for ($i=0; $i < $nombreDeLigne; $i++) {
                                    $ligne = $monfichier[$i];
                                    $mot = explode(' ', $ligne);

                                    if ($mot[0]==$matricule) {
                                        $monfichier[$i] = $tab;
                                        file_put_contents('employé.bin', $monfichier);
                                        header("Location: liste.php");
                                    }
                                }


                            } else {
                                $erreur = "Veillez saisir un adresse mail valide";
                            }
                        } else {
                            $erreur = "Veillez saisir un numero de telephone valide";
                        }
                    } else {
                        $erreur = "Le sailaire doit etre compris entre 25000 et 1000000";
                    }
                } else {
                    $erreur = "Veillez saisir une date sous le format Jour/Mois/Année";
                }
            } else {
                $erreur = "le nom et le prénom ne doivent comporter que de lettres";
            }
        } else {
            $erreur = "Tous les champs doivent etre remplis !";
        }
    }


if ($_POST['choix'] == 'oui') {
    
    $matricule = $_POST['matricule'];
    
    $fichier = new SplFileObject('employé.bin');
    foreach ($fichier as $ligne) {
        if (preg_match('#'.$matricule.'#', $ligne)) {
            $num = $fichier->key();
        }
    }

    $fichier = fopen('employé.bin', 'r');
    $contenu = fread($fichier, filesize('employé.bin'));
    fclose($fichier);

    $contenu = explode(PHP_EOL, $contenu);
    unset($contenu[$num]);/* On supprime la ligne*/
    $contenu = array_values($contenu); /* Ré-indexe l'array */

   /* Puis on reconstruit le tout et on l'écrit */
    $contenu = implode(PHP_EOL, $contenu);
    $fichier = fopen("employé.bin", "w");
    fwrite($fichier, $contenu);

    header("Location: liste.php");
}
if ($_POST['choix'] == 'non') {
    header("Location: liste.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
 <?php if (isset($_POST['supprimer'])) { ?>
 <div class='sup'>
 <h1>Voulez-vous supprimer l'employé avec la matricule <?php echo $_POST['supprimer']; ?> ?</h1>
 <form method="POST">
 <input  type="hidden" name="matricule " value="<?php echo $_POST['supprimer'] ?>">
 <button class="btn" type="subit" name="choix" value="oui">OUI</button>
 <button class="btn" type="subit" name="choix" value="non">NON</button>
 </form>
 </div>
 <?php } ?>
 <?php if(isset($_POST['editer'])) { ?>
 <div class="pgge">
 <form method="POST">
 <h1>Modification des données de l'employé<br>avec le matricule <?php echo $_POST['editer']; ?></h1>
 <input type="hidden" name="matricule" value="<?php echo $_POST['editer']; ?>">
 <table>
 <tr>
     <td><label for="" >Matricule</label></td>
     <td><input type="text" name="matricule" disabled="disabled" value="<?php echo $matricule; ?>"></td>
</tr>
<tr>
    <td><label for="">Nom</label></td>
    <td><input type="text" name="nom" value="<?php echo $nom; ?>"></td>
 </tr>
 <tr>
    <td><label for="">Prenom</label></td>
    <td><input type="text" name="prenom" value="<?php echo $prenom; ?>"></td>
</tr>
<tr>
    <td><label for="">Date de naissance</label></td>
    <td><input type="text" name="birthday" value="<?php echo $birthday; ?>"></td>
</tr>
 <tr>
    <td><label for="">Salaire</label></td>
    <td><input type="text" name="salaire" value="<?php echo $salaire; ?>"></td>
</tr>
<tr>
    <td><label for="">Téléphone</label></td>
    <td><input type="text" name="phone" value="<?php echo $phone; ?>"></td>
</tr>
<tr>
    <td><label for="">Email</label></td>
    <td><input type="text" name="mail" value="<?php echo $mail; ?>"></td>
</tr>
<tr>
    <td></td>
    <td><input type="submit" name="validation" value="Modifier"></td>
</tr>
</table>
</form>
</div>
    <?php } ?>  
</body>
</html>