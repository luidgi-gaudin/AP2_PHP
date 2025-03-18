<?php

namespace App\Models;

use App\Core\Database;

class Antecedent {
    private ?int $antecedentId;
    private string $libelle_a;

    public function __construct($antecedentId = null, $libelle_a = '') {
        $this->antecedentId = $antecedentId;
        $this->libelle_a = $libelle_a;
    }

    // Getters et Setters
    public function getAntecedentId(): ?int {
        return $this->antecedentId;
    }

    public function getLibelle(): string {
        return $this->libelle_a;
    }

    public function setLibelle($libelle_a): void {
        $this->libelle_a = $libelle_a;
    }

    // Méthodes CRUD
    public function save(): ?int {
        $db = Database::getInstance();

        if ($this->antecedentId) {
            // Update
            $sql = "UPDATE antecedents SET Libelle_a = :libelle WHERE AntecedentId = :id";
            $db->prepare($sql);
            $db->bind(':libelle', $this->libelle_a);
            $db->bind(':id', $this->antecedentId);
            if ($db->execute()) {
                return $this->antecedentId;
            }
        } else {
            // Insert
            $sql = "INSERT INTO antecedents (Libelle_a) VALUES (:libelle)";
            $db->prepare($sql);
            $db->bind(':libelle', $this->libelle_a);
            if ($db->execute()) {
                $this->antecedentId = (int)$db->lastInsertId();
                return $this->antecedentId;
            }
        }

        return null;
    }

    public static function findById($id): ?Antecedent {
        $db = Database::getInstance();
        $sql = "SELECT * FROM antecedents WHERE AntecedentId = :id";
        $result = $db->single($sql, [':id' => $id]);

        if ($result) {
            return new Antecedent($result['AntecedentId'], $result['Libelle_a']);
        }

        return null;
    }

    public static function getAll(): array {
        $db = Database::getInstance();
        $antecedents = [];

        $results = $db->query("SELECT * FROM antecedents");

        foreach ($results as $row) {
            $antecedents[] = new Antecedent($row['AntecedentId'], $row['Libelle_a']);
        }

        return $antecedents;
    }

    public function delete(): bool {
        if (!$this->antecedentId) return false;

        $db = Database::getInstance();
        $sql = "DELETE FROM antecedents WHERE AntecedentId = :id";
        $db->prepare($sql);
        $db->bind(':id', $this->antecedentId);

        return $db->execute();
    }
}