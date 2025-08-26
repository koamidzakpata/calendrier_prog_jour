<?php
require '../src/bootstrap.php';
$pdo = get_pdo();
$events = new Calendar\Events($pdo);

try {
    $event = $events->find($_GET['id'] ?? null);
} catch (Exception $e) {
    e404();
} catch (Error $e) {
    e404();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Suppression de l'évènement
    $events->delete($event->getId());
    header('Location: ../public/index.php?delete=1');
    exit();
}

render('header', ['title' => "Supprimer " . $event->getNom()]);
?>

<div class="container">
    <h1>Supprimer l'évènement</h1>
    <p>Voulez-vous vraiment supprimer l'évènement : 
        <strong><?= h($event->getNom()); ?></strong> ?
    </p>

    <form action="" method="post" style="margin-top:20px;">
        <button type="submit" class="btn btn-danger">Oui, supprimer</button>
        <a href="../public/index.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php render('footer'); ?>
