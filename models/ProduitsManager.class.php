<?php

	include_once 'models/Produit.class.php';
	include_once 'models/CategoriesManager.class.php';
	/**
	* Classe de gestion des produits
	*/
	class ProduitsManager
	{
		private $_db;
		public $catManager;

		//Constructeur du manager, on y instancie PDO
		function __construct($db)
		{
			$this->_db = $db;
			$this->catManager = new CategoriesManager($db);
		}

		/**
		* Fonction permettant d'ajouter un Produit
		**/
		function add(array $data){
			extract($data);
			$query = $this->_db->prepare('INSERT INTO produits(nom,prix,categorie) VALUES (:nom, :prix, :categorie)');
			$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			$query -> bindParam(':prix', $prix,PDO::PARAM_STR);
			$query -> bindParam(':categorie', $categorie,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de retirer un Produit
		**/
		function remove(array $data){
			extract($data);
			if(isset($id))
			{
				$query = $this->_db->prepare('DELETE FROM produits WHERE id=:id');
				$query -> bindParam(':id', $id,PDO::PARAM_INT);
			}
			else if(isset($nom))
			{
				$query = $this->_db->prepare('DELETE FROM produits WHERE nom=:nom');
				$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			}
			$query->execute() or die(print_r($query->errorInfo()));
		}

		/**
		* Fonction permettant de récupérer un Produit. Paramètre: array contenant soit id=>$id soit nom=>$nom (pour que la recherche fonctionne avec l'un et l'autre)
		**/
		function get(array $data){
			extract($data);
			if(isset($id))
			{
				$query = $this->_db->prepare('SELECT * FROM produits WHERE id=:id');
				$query -> bindParam(':id', $id,PDO::PARAM_INT);
			}
			else if(isset($nom))
			{
				$query = $this->_db->prepare('SELECT * FROM produits WHERE nom=:nom');
				$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			}

			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetch();
			$result['categorie'] = $this->catManager->get(array("id"=>$result['categorie']));
			$produit = new Produit();
			$produit->hydrate($result);
			return $produit;
		}

		/**
		* Fonction permettant d'obtenir une liste des produits
		**/
		function getList($champs=NULL){
			// On vérifie le paramètre. S'il n'y en a pas, on retourne la liste complète. Sinon, on analyse le tableau des champs
			if($champs==NULL)
			{
				$query = $this->_db->prepare('SELECT * FROM produits');
			}
			else
			{
				$query_str = "SELECT * FROM produits WHERE 1"; //Début de la requête. Le WHERE 1 (toujours vrai) est là pour faciliter la boucle qui suit et que le "statement" puisse toujours commencer par " AND" m^me s'il s'agit du premier champ
				foreach ($champs as $champ => $val) {
					if($val!="") //On vérifie que la valeur ne soit pas nulle
					{
						$query_str .= ' AND ' . $champ . ' LIKE "%' . $val . '%"'; // Ici on priviligie le LIKE à l'égalité pour plus de tolérance dans la saisie
					}
				}
				$query = $this->_db->prepare($query_str);
			}
			$query->execute() or die(print_r($query->errorInfo()));

			$result = $query->fetchAll();
			$list = array();

			// On ajoute au tableau de retour les objets produit créés avec chaque ligne de la BDD retournée
			foreach ($result as $key => &$value) {
				$produit = new Produit();
				$value['categorie'] = $this->catManager->get(array("id"=>$value['categorie']));
				$produit->hydrate($value);
				array_push($list, $produit);
			}
			return $list;
		}

		/**
		* Fonction permettant de mettre à jour un produit
		**/
		function update($produit){
			extract($produit);
			$query = $this->_db->prepare('UPDATE produits SET nom=:nom,prix=:prix,categorie=:categorie WHERE id=:id');
			$query -> bindParam(':id', $id,PDO::PARAM_INT);
			$query -> bindParam(':nom', $nom,PDO::PARAM_STR);
			$query -> bindParam(':prix', $prix,PDO::PARAM_STR);
			$query -> bindParam(':categorie', $categorie,PDO::PARAM_STR);
			$query->execute() or die(print_r($query->errorInfo()));
		}
	}

?>