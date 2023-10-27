<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laisse pas trainer ton file</title>
</head>
<body>
    
<?php

$errors=[];

if($_SERVER['REQUEST_METHOD'] === "POST"){
    
    if(!isset($_POST['user-name']) || trim($_POST['user_name']) === '') 
    $errors[] = "Le nom est obligatoire";
    if(!isset($_POST['user_first_name']) || trim($_POST['user_first_name']) === '') 
    $errors[] = "Le prénom est obligatoire";
    if(!isset($_POST['user_age']) || trim($_POST['user_age']) === '') 
    $errors[] = "L'âge' est obligatoire";

    $uploadDir = 'public/upload/';  
    $uploadFile = $uploadDir . basename($_FILES['picture']['name']);
    $extension = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
    $authorizedExtensions = ['jpg','png','gif','webp'];
    $maxFileSize = 1000000;
    
    if( (!in_array($extension, $authorizedExtensions))){
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Png ou gif ou webp !';
    }

    if( file_exists($_FILES['picture']['tmp_name']) && filesize($_FILES['picture']['tmp_name']) > $maxFileSize)
    {
        $errors[] = "Votre fichier doit faire moins de 1M !";
    }

    if (empty($errors)) 
    {
        $uniqueFileName=uniqid('picture') . '.' . $extension;
        $uploadFile = $uploadDir . $uniqueFileName;
        move_uploaded_file($_FILES['picture']['name'], $uploadFile);
}
}

    if(!empty($errors))
    {
        echo "Prénom :" . " " . ($_POST["user_first_name"]) . '</br>' . "Nom :" . " " . ($_POST["user_name"]) . '</br>' . "Age :" . " " . ($_POST["user_age"]) . '</br>';
        print_r($uploadFile) . '</br>';
    }
    
?>

<form method="post" enctype="multipart/form-data">
    <div style="padding: 10px"> 
      <label  for="nom">Nom :</label>
      <input  type="text"  id="nom"  name="user_name" placeholder="Nom" required/>
    </div>
    <div style="padding: 10px">
      <label  for="prénom">Prénom :</label>
      <input  type="text"  id="prenom"  name="user_first_name" placeholder="Prénom" required/>
    </div>
    <div style="padding: 10px">
      <label  for="âge">Age :</label>
      <input  type="number"  id="age"  name="user_age" placeholder="Age" required/>
    </div>
    <div style="padding: 10px">
        <label for="imageUpload">Upload an profile image</label>    
        <input type="file" name="picture" id="imageUpload" />
    </div>
    <div class="button">
        <button type ="submit" name="send">Envoyer</button>
    </div>
</form>

</body>
</html>
