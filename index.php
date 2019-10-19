<?php
$fichier=file('data.txt');

$nbrligne=count($fichier);
$dernierligne=$fichier[$nbrligne-1];
$mot=explode(' ', $dernierligne);
$matricule=$mot[0];
if($matricule==''){
    $matricule='EM'.'-'.sprintf("%05d",1);
}
else{
    $matricule++;
}

if(isset($_POST['validation'])){
  
    if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['datenaissance']) AND !empty($_POST['salaire']) AND !empty($_POST['telephone']) AND !empty($_POST['email'])){
        
    $prenom=$_POST['prenom'];
    $nom=$_POST['nom'];
    $datenaissance=$_POST['datenaissance'];
    $salaire=$_POST['salaire'];
    $telephone=$_POST['telephone'];
    $email=$_POST['email'];
    if(preg_match("#^7[8|6|0|7][0-9]{7}#",$telephone)){
      
        if ($salaire>=25000 && $salaire<2000000){
        //1:on ouvre notre fichier en lecture ecriture
        $employe=fopen('data.txt','a+');
        //2:on effectue le tarif demandé
        $infoper="$matricule $prenom $nom $datenaissance $salaire $telephone $email \n";
        fwrite($employe,$infoper);
        //3:en fin on ferme le fichier
        fclose($employe);

        header('location:go.php');
    }
}
    }
    if(isset($_POST['annuler'])){
        $prenom='';
        $nom='';
        $datenaissance='';
        $salaire='';
        $telephone='';
        $email='';
    }
    else {
        $erreur="veillez remplir tous les champs";
    }
}
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>formulaire employé</title>
    <link rel="stylesheet" href="go.css" class="rel">
</head>
<body>
<div class="formulaire">
<form method="post">
<h1>enregistrer un employé</h1>
<div>
    <label>Matricule</label><br>
    <input type="text"name="matricule" disabled="disabled" placeholder="<?php echo $matricule;?>"><br>
</div>
<div>
<label>Nom</label><br>
 <input type="text" name="nom"><br>
</div>
<div>
<label>Prenom</label><br>
<input type="text" name="prenom"><br>
</div>
<div>
<label>Date de naissance</label><br>
 <input type="text" name="datenaissance" placeholder="jj/mm/aa"><br>
</div>
<div>
<label>Salaire</label><br>
 <input type="text" name="salaire"><br>
</div>
<div>
<label>Telephone</label><br>
 <input type="text" name="telephone"><br>
</div>
<label> Email</label><br>
<input  type="text" name="email" placeholder="email"><br><br>
<input class="submit" type="submit" name="validation" value="enregistrer">
</form> 
</div>
</body>
</html>