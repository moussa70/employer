<?php
    $monfichier = file('data.txt');
    $nombreDeLigne = count($monfichier);
    
    for ($i=0; $i < $nombreDeLigne; $i++) {
    
        $var = explode(' ', $monfichier[$i]);
        $tableau[$i] = array($var[0], $var[1], $var[2], $var[3], $var[4], $var[5], $var[6]);
    }
     
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="main.css" class="rel">
</head>
<body>
    
    <div class="liste">
        <table>
            <tr>
                <td>Matricule</td>
                <td>Nom</td>
                <td>Prénom</td>
                <td>Date naissance</td>
                <td>Salaire</td>
                <td>Téléphone</td>
                <td>Email</td>
                <td>Actions</td>
            </tr>
            <?php 
                foreach($tableau as $ligne){
            ?>
            <tr class="valeurs">
                <?php
                    foreach ($ligne as $element) {
                        echo '<td>'.$element.'</td>';
                    }
                ?>
                <td>
                    <form method="POST">
                    <button name="editer" value="<?php echo "$ligne[0]"; ?>">Editer</button>
                    <button name="supprimer" value="<?php echo "$ligne[0]"; ?>">Supprimer</button>
                    </form>
                </td>
            </tr>
            <?php
                }
            ?>
            
        </table>
    </div>
</body>
</html>