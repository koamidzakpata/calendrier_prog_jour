<?php
require '../src/bootstrap.php';
$pdo = get_pdo();
$events = new Calendar\Events($pdo);
$errors = [];
try {
    $event = $events->find($_GET['id'] ?? null);
} catch (Exception $e) {
    e404();
} catch (Error $e) {
    e404();
}
$data = [
    'nom' => $event->getNom(),
    'date' => $event->getDebut()->format('Y-m-d'),
    'debut' => $event->getDebut()->format('H:i'),
    'fin' => $event->getFin()->format('H:i'),
    'description' => $event->getDescription()

];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $validator = new Calendar\EventValidator();
    $errors = $validator->validates($data);
    if (empty($errors)) {
        $events->hydrate($event, $data);
        $events->update($event);
        header('Location: ../public/index.php?success=1');
        exit();
    }
}

render('header', ['title' => $event->getNom()]);
?>

<div class="container">
    <h1>Editer l'évènement <small><?= h($event->getNom()); ?></small></h1>
    <form action="" method="post" class="form">
        <?php render('/calendar/form', ['data' => $data, 'errors' => $errors]); ?>

        <div class="form-group">
            <button class="btn btn-primary">Modifier l'évènement</button>
        </div>
    </form>
</div>

<?php render('footer'); ?>