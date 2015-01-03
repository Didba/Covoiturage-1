<?php
	include 'config/connexion.php';
	include 'models/AdherentManager.class.php';
 ?>

<html>
	<body>
	<?php
	var_dump($_POST);
	if (isset($_POST['formaction']))
	{
		switch ($_POST['action']) {
			case 'add':
				echo '
				<form action="" method="POST">
					Prenom <input type="text"name="prenom"><br>
					Nom <input type="text" name="nom"><br>
					Genre <input type="text" name="sexe"><br>
					Mail <input type="text" name="mail"><br>
					Tel <input type="text" name="telephone"><br>
					Date de naissance <input type="text" name="dateNaiss"><br>
					mdp <input type="text" name="password"><br>
					<input type="submit" name="name" value="add">
				</form>
				';
				break;

			case 'remove':
				echo '
				<form action="" method="POST">
					id <input type="text" name="id"><br>
					<input type="submit" name="name" value="remove">
				</form>
				';
				break;

			case 'get':
				echo '
				<form action="" method="POST">
					id <input type="text" name="id"><br>
					<input type="submit" name="name" value="get">
				</form>
				';
				break;

			default:
				# code...
				break;
		}

	}

	if(isset($_POST)&&isset($_POST['name']))
	{
		extract($_POST);
		$manager = new AdherentManager($db);

		if ($name=="add")
		{
			$manager->add($_POST);
		}

		if ($name=="get")
		{
			$adh = $manager->get($_POST);
			$adh->toString();
		}

		if ($name=="remove")
		{
			$manager->remove($_POST);
		}
	}

	?>
		<br>
		<br>
		<br>
		<br>
		<form action="" method="POST">
			Quelle action tester? <input type="text" name="action">
			<input type="submit" name="formaction">
		</form>
	</body>
</html>