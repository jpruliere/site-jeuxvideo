<?php

require_once('../inc/connecteur.php');

require_once('../classes/version.class.php');


$res = $pdo->query("SELECT version.*, jeu.titre jeu, console.nom || ' (' || console.sigle || ')' console
	FROM version
	JOIN jeu ON jeu.id = version.idjeu
	JOIN console ON console.id = version.idconsole")->fetchAll(PDO::FETCH_ASSOC);
$jeux = [];
foreach ($res as $jeu) {
	$v = new Version();
	$v->setId($jeu['id'])
		->setJeu($jeu['jeu'])
		->setTitre($jeu['titre'])
		->setConsole($jeu['console'])
		->setDatesortie($jeu['datesortie'])
		->setTypesortie($jeu['typesortie'])
		->setDeveloppeur($jeu['developpeur'])
		->setEditeur($jeu['editeur']);
	$jeux[] = $v;
}

require_once('../tpl/header.tpl');

?>
<a href="add.php">Ajouter une version</a>
<?php if (!count($jeux)): ?><p>Pas de versions de jeux dans la base pour l'instant</p><?php else: ?>
<table>
	<thead>
		<tr>
			<th>Jeu</th>
			<th>Console (sigle)</th>
			<th>Type de sortie</th>
			<th>Date de sortie</th>
			<th>Editeur / Développeur</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($jeux as $jeu): ?>
		<tr>
			<td><?=$jeu->getTitre()?></td>
			<td><?=$jeu->getConsole()?></td>
			<td><?=$jeu->getTypesortie()?></td>
			<td><?=$jeu->getDatesortie(true)?></td>
			<td><?=$jeu->getEditeur()." / ".$jeu->getDeveloppeur()?></td>
			<td><a href="view.php?id=<?=$jeu->getId()?>">Voir</a> <a href="edit.php?id=<?=$jeu->getId()?>">Modifier</a> <a href="delete.php?id=<?=$jeu->getId()?>">Supprimer</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif;

require_once('../tpl/footer.tpl');