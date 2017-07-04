<?php 

try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=annuaire;charset=utf8', 'root', 'j9hn2x2');
	}
	catch (Exception $e)
	{
	    die('Erreur : ' . $e->getMessage());
	}
$last_name = $_POST['last_name'];
$first_name = $_POST['first_name'];
$business = $_POST['business'];
$address = $_POST['address'];
$dat = $_POST['dat'];
$phone = $_POST['phone'];
$groupe = $_POST['groupe'];


	$req = $bdd->prepare('INSERT INTO annuaire(last_name, first_name, business, address, dat, phone) VALUES(:last_name, :first_name, :business, :address, :dat, :phone)');
	$req->execute(array(
	    'last_name' => $last_name,
	    'first_name' => $first_name,
	    'business' => $business,
	    'address' => $address,
	    'dat' => $dat,
	    'phone' => $phone
	    
	    ));
$id = $bdd->lastInsertId();
var_dump($id);
var_dump($groupe);
$req = $bdd->prepare("INSERT INTO appartenir (`fk_user`,`fk_groupe`) VALUES (:id, :groupe)");
foreach($groupe as $valeur){
  $req->execute([
    "id"=>$id,
    "groupe"=>$valeur
  ]);
};

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title></title>
</head>
<body>
<table border=solid>
	<thead>
        <th>Nom</th>
        <th>Prenom</th>
        <th>Téléphone</th>
        <th>Date de naissance</th>
        <th>Entreprise</th>
        <th>Adresse</th>
        <th>Groupes</th>
        <th>Modifier</th>
        <th>Supprimer</th>
      </thead>
      <tbody>
		<?php
//Jointure de la table appartenir avec la table groupe et de appartenir avec annuaire
	$reponse = $bdd->query('SELECT * FROM appartenir
INNER JOIN groupe
ON appartenir.fk_groupe = groupe.id
INNER JOIN annuaire
On appartenir.fk_user = annuaire.id');
//Gestion des groupes
//on affiche le tableau
		while($donnees=$reponse->fetch()){

		echo '<tr>
				<td>'.$donnees['last_name'].'</td>
				<td>'.$donnees['first_name'].'</td>
				<td>'.$donnees['phone'].'</td>
				<td>'.$donnees['dat'].'</td>
				<td>'.$donnees['business'].'</td>
				<td>'.$donnees['address'].'</td>
				<td>'.$donnees['groupe'].'</td>
				<td><button>Modifier</button></td>
				<td><form action="Delete.php" method="POST"><input type="HIDDEN" name="id" value='.$donnees['id'].'><button type="submit">Supprimer</button></form></td>
				</tr>';
		}

?>
	</tbody>
</table>
</body>
</html>