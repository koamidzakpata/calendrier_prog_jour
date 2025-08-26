<?php
require '../src/bootstrap.php';
$pdo = get_pdo();
$events = new Calendar\Events($pdo);
if (!isset($_GET['id'])) {
    header('location: ../public/404.php');
}
try {
    $event = $events->find($_GET['id']);
} catch (Exception $e) {
    e404();
}
render('header', ['title' => $event->getNom()]);
?>

<h1><?= h($event->getNom()); ?></h1>

<ul>
    <li>Date: <?=  $event->getDebut()->format('d/m/Y'); ?></li>
    <li>Heure de démarrage: <?= $event->getDebut()->format('H:i'); ?></li>
    <li>Heure de fin: <?= $event->getFin()->format('H:i'); ?></li>
    <li>Description:<br />
         <?= h($event->getDescription()); ?>
    </li>
</ul>

<?php require '../views/footer.php'; ?>