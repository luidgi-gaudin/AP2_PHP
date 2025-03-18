<?php

    namespace App\Models;

    use App\Core\Database;

    class Allergie {
        private ?int $allergieId;
        private string $libelle_al;

        public function __construct($allergieId = null, $libelle_al = '') {
            $this->allergieId = $allergieId;
            $this->libelle_al = $libelle_al;
        }

        // Getters et Setters
        public function getAllergieId(): ?int {
            return $this->allergieId;
        }

        public function getLibelle(): string {
            return $this->libelle_al;
        }

        public function setLibelle($libelle_al): void {
            $this->libelle_al = $libelle_al;
        }

        // Méthodes CRUD
        public function save(): ?int {
            $db = Database::getInstance();

            if ($this->allergieId) {
                // Update
                $sql = "UPDATE allergies SET Libelle_al = :libelle WHERE AllergieId = :id";
                $db->prepare($sql);
                $db->bind(':libelle', $this->libelle_al);
                $db->bind(':id', $this->allergieId);
                if ($db->execute()) {
                    return $this->allergieId;
                }
            } else {
                // Insert
                $sql = "INSERT INTO allergies (Libelle_al) VALUES (:libelle)";
                $db->prepare($sql);
                $db->bind(':libelle', $this->libelle_al);
                if ($db->execute()) {
                    $this->allergieId = (int)$db->lastInsertId();
                    return $this->allergieId;
                }
            }

            return null;
        }

        public static function findById($id): ?Allergie {
            $db = Database::getInstance();
            $sql = "SELECT * FROM allergies WHERE AllergieId = :id";
            $result = $db->single($sql, [':id' => $id]);

            if ($result) {
                return new Allergie($result['AllergieId'], $result['Libelle_al']);
            }

            return null;
        }

        public static function getAll(): array {
            $db = Database::getInstance();
            $allergies = [];

            $results = $db->query("SELECT * FROM allergies");

            foreach ($results as $row) {
                $allergies[] = new Allergie($row['AllergieId'], $row['Libelle_al']);
            }

            return $allergies;
        }

        public function delete(): bool {
            if (!$this->allergieId) return false;

            $db = Database::getInstance();
            $sql = "DELETE FROM allergies WHERE AllergieId = :id";
            $db->prepare($sql);
            $db->bind(':id', $this->allergieId);

            return $db->execute();
        }
    }