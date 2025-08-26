<?php

namespace Calendar;

class Event
{
    private $id;
    private $nom;
    private $description;
    private $debut;
    private $fin;

    /**
     * Retourne l'id de l'événement
     * @return string
     */
    public function getId(): string
    {
        return $this->id ?? '';
    }

    /**
     * Retourne le nom de l'événement
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom ?? '';
    }

    /**
     * Retourne la description de l'événement
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description ?? '';
    }

    /**
     * Retourne la date de début sous forme d'objet DateTime
     * @return \DateTime
     */
    public function getDebut(): \DateTime
    {
        try {
            return new \DateTime($this->debut);
        } catch (\Exception $e) {
            // Si la date est invalide ou null, on renvoie la date actuelle
            return new \DateTime();
        }
    }

    /**
     * Retourne la date de fin sous forme d'objet DateTime
     * @return \DateTime
     */
    public function getFin(): \DateTime
    {
        try {
            return new \DateTime($this->fin);
        } catch (\Exception $e) {
            return new \DateTime();
        }
    }

    public function setNom (string $nom) {
        $this->nom = $nom;
    }

    public function setDescription (string $description) {
        $this->description = $description;
    }

    public function setDebut (string $debut) {
        $this->debut = $debut;
    }

    public function setFin (string $fin) {
        $this->fin = $fin;
    }
}

?>