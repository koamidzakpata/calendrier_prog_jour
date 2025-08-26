<?php

namespace Calendar;

use Calendar\Event;

class Events
{

    private $pdo;

    /**private \PDO $pdo;

    public function __construct() {
        $this->pdo = new \PDO('mysql:host=localhost;dbname=calendar', 'root', '', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ]);
    }
     */

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupère les évènements commençants entre deux dates
     * @param \DateTime $start
     * @param \DateTime $end
     * @param return array
     */
    public function getEventsBetween(\DateTime  $start, \DateTime $end): array
    {
        $sql = "SELECT * FROM evenements WHERE debut BETWEEN
        '{$start->format('Y-m-d 00:00:00')}' AND
        '{$end->format('Y-m-d 23:59:59')}' ORDER BY debut ASC";
        $statement = $this->pdo->query($sql);
        $results = $statement->fetchAll();
        return $results;
    }

    /**
     * Récupère les évènements commençants entre deux dates indexé par jour
     * @param \DateTime $start
     * @param \DateTime $end
     * @param return array
     */
    public function getEventsBetweenByDay(\DateTime  $start, \DateTime $end): array
    {
        $events = $this->getEventsBetween($start, $end);
        $days = [];
        foreach ($events as $event) {
            $date = explode(' ', $event['debut'])[0];
            if (!isset($days[$date])) {
                $days[$date] = [$event];
            } else {
                $days[$date][] = $event;
            }
        }
        return $days;
    }

    /**
     * Récupère un évènement par son ID
     */
    /**public function find(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM evenements WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $event = $stmt->fetch();
        return $event ?: null;
    }
     */


    /**
     * Récupère un évènement par son ID
     * @param int $id
     * @return array
     */

    public function find(int $id): Event {
        require 'Event.php';
        $statement = $this->pdo->prepare("SELECT * FROM evenements WHERE id = $id LIMIT 1");
        $statement->execute();
        // On utilise le mode FETCH_CLASS pour instancier la classe Event
        $statement->setFetchMode(\PDO::FETCH_CLASS, Event::class);
        $result = $statement->fetch();
        if ($result === false) {
            throw new \Exception("Aucun résultat n'a été trouvé pour l'ID $id");
        }
        return $result;
    }

    public function hydrate (Event $event, array $data) {
                $event->setNom($data['nom']);
        $event->setDescription($data['description']);
        $event->setDebut(\DateTime::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['début'])->format('Y-m-d H:i:s'));
        $event->setFin(\DateTime::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['fin'])->format('Y-m-d H:i:s'));
        return $event;
    }

    /**
     * Crée un évènement au niveau de la base de données
     * @param Event $event
     * @return bool
     */
    public function create(Event $event): bool
    {
        $statement = $this->pdo->prepare('INSERT INTO evenements (nom, description, debut, fin) VALUES (?, ?, ?, ?)');
        return $statement->execute([
            $event->getNom(),
            $event->getDescription(),
            $event->getDebut()->format('Y-m-d H:i:s'),
            $event->getFin()->format('Y-m-d H:i:s'),

        ]);
    }

    /**
     * Met à jour un évènement au niveau de la base de données
     * @param Event $event
     * @return bool
     */
    public function update(Event $event): bool
    {
        $statement = $this->pdo->prepare('UPDATE evenements SET nom = ?, description = ?, debut = ?, fin = ? WHERE id = ?');
        return $statement->execute([
            $event->getNom(),
            $event->getDescription(),
            $event->getDebut()->format('Y-m-d H:i:s'),
            $event->getFin()->format('Y-m-d H:i:s'),
            $event->getId()
        ]);
    }

    /**
     * Supprime un évènement par son id.
     *
     * @param int $id
     * @return void
     * @throws \Exception si la suppression échoue
     */
    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare('DELETE FROM evenements WHERE id = :id');
        $success = $statement->execute(['id' => $id]);

        if ($success === false) {
            throw new \Exception('Impossible de supprimer l\'évènement (id: ' . $id . ').');
        }
    }


}
