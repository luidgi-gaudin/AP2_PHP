<?php

namespace App\Models;

use App\Core\Database;

class Medicament {
    private ?int $medicamentId;
    private string $libelle_med;
    private string $contr_indication;
    private int $stock;

    public function __construct($medicamentId = null, $libelle_med = '', $contr_indication = '', $stock = 0) {
        $this->medicamentId = $medicamentId;
        $this->libelle_med = $libelle_med;
        $this->contr_indication = $contr_indication;
        $this->stock = $stock;
    }

    // Getters et Setters
    public function getMedicamentId(): ?int {
        return $this->medicamentId;
    }

    public function getLibelle(): string {
        return $this->libelle_med;
    }

    public function setLibelle($libelle_med): void {
        $this->libelle_med = $libelle_med;
    }

    public function getContrIndication(): string {
        return $this->contr_indication;
    }

    public function setContrIndication($contr_indication): void {
        $this->contr_indication = $contr_indication;
    }

    public function getStock(): int {
        return $this->stock;
    }

    public function setStock($stock): void {
        $this->stock = $stock;
    }

    // Méthodes CRUD
    public function save(): ?int {
        $db = Database::getInstance();

        if ($this->medicamentId) {
            // Update
            $sql = "UPDATE medicaments SET Libelle_med = :libelle, Contr_indication = :contr_indication, 
                    Stock = :stock WHERE MedicamentId = :id";
            $db->prepare($sql);
            $db->bind(':libelle', $this->libelle_med);
            $db->bind(':contr_indication', $this->contr_indication);
            $db->bind(':stock', $this->stock);
            $db->bind(':id', $this->medicamentId);
            if ($db->execute()) {
                return $this->medicamentId;
            }
        } else {
            // Insert
            $sql = "INSERT INTO medicaments (Libelle_med, Contr_indication, Stock) 
                    VALUES (:libelle, :contr_indication, :stock)";
            $db->prepare($sql);
            $db->bind(':libelle', $this->libelle_med);
            $db->bind(':contr_indication', $this->contr_indication);
            $db->bind(':stock', $this->stock);
            if ($db->execute()) {
                $this->medicamentId = (int)$db->lastInsertId();
                return $this->medicamentId;
            }
        }

        return null;
    }

    public static function findById($id): ?Medicament {
        $db = Database::getInstance();
        $sql = "SELECT * FROM medicaments WHERE MedicamentId = :id";
        $result = $db->single($sql, [':id' => $id]);

        if ($result) {
            return new Medicament(
                $result['MedicamentId'],
                $result['Libelle_med'],
                $result['Contr_indication'],
                $result['Stock']
            );
        }

        return null;
    }

    public static function getAll(): array {
        $db = Database::getInstance();
        $medicaments = [];

        $results = $db->query("SELECT * FROM medicaments");

        foreach ($results as $row) {
            $medicaments[] = new Medicament(
                $row['MedicamentId'],
                $row['Libelle_med'],
                $row['Contr_indication'],
                $row['Stock']
            );
        }

        return $medicaments;
    }

    public function delete(): bool {
        if (!$this->medicamentId) return false;

        $db = Database::getInstance();
        $sql = "DELETE FROM medicaments WHERE MedicamentId = :id";
        $db->prepare($sql);
        $db->bind(':id', $this->medicamentId);

        return $db->execute();
    }
}