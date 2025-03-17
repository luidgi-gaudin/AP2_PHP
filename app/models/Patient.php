<?php

namespace App\Models;

use App\Core\Database;

class Patient {
    private ?int $patientId;
    private string $nom_p;
    private string $prenom_p;
    private string $sexe_p;
    private string $num_secu;

    public function __construct($patientId = null, $nom_p = '', $prenom_p = '', $sexe_p = '', $num_secu = '') {
        $this->patientId = $patientId;
        $this->nom_p = $nom_p;
        $this->prenom_p = $prenom_p;
        $this->sexe_p = $sexe_p;
        $this->num_secu = $num_secu;
    }

    // Getters et Setters
    public function getPatientId(): ?int {
        return $this->patientId;
    }

    public function getNom(): string {
        return $this->nom_p;
    }

    public function setNom($nom_p): void {
        $this->nom_p = $nom_p;
    }

    public function getPrenom(): string {
        return $this->prenom_p;
    }

    public function setPrenom($prenom_p): void {
        $this->prenom_p = $prenom_p;
    }

    public function getSexe(): string {
        return $this->sexe_p;
    }

    public function setSexe($sexe_p): void {
        $this->sexe_p = $sexe_p;
    }

    public function getNumSecu(): string {
        return $this->num_secu;
    }

    public function setNumSecu($num_secu): void {
        $this->num_secu = $num_secu;
    }

    // Méthodes CRUD
    public function save(): ?int {
        $db = Database::getInstance();

        if ($this->patientId) {
            // Update
            $sql = "UPDATE patients SET Nom_p = :nom, Prenom_p = :prenom, Sexe_p = :sexe, 
                    Num_secu = :num_secu WHERE PatientId = :id";
            $db->prepare($sql);
            $db->bind(':nom', $this->nom_p);
            $db->bind(':prenom', $this->prenom_p);
            $db->bind(':sexe', $this->sexe_p);
            $db->bind(':num_secu', $this->num_secu);
            $db->bind(':id', $this->patientId);
            if ($db->execute()) {
                return $this->patientId;
            }
        } else {
            // Insert
            $sql = "INSERT INTO patients (Nom_p, Prenom_p, Sexe_p, Num_secu) 
                    VALUES (:nom, :prenom, :sexe, :num_secu)";
            $db->prepare($sql);
            $db->bind(':nom', $this->nom_p);
            $db->bind(':prenom', $this->prenom_p);
            $db->bind(':sexe', $this->sexe_p);
            $db->bind(':num_secu', $this->num_secu);
            if ($db->execute()) {
                $this->patientId = (int)$db->lastInsertId();
                return $this->patientId;
            }
        }

        return null;
    }

    public static function findById($id): ?Patient {
        $db = Database::getInstance();
        $sql = "SELECT * FROM patients WHERE PatientId = :id";
        $result = $db->single($sql, [':id' => $id]);

        if ($result) {
            return new Patient(
                $result['PatientId'],
                $result['Nom_p'],
                $result['Prenom_p'],
                $result['Sexe_p'],
                $result['Num_secu']
            );
        }

        return null;
    }

    public static function getAll(): array {
        $db = Database::getInstance();
        $patients = [];

        $results = $db->query("SELECT * FROM patients");

        foreach ($results as $row) {
            $patients[] = new Patient(
                $row['PatientId'],
                $row['Nom_p'],
                $row['Prenom_p'],
                $row['Sexe_p'],
                $row['Num_secu']
            );
        }

        return $patients;
    }

    public function delete(): bool {
        if (!$this->patientId) return false;

        $db = Database::getInstance();
        $sql = "DELETE FROM patients WHERE PatientId = :id";
        $db->prepare($sql);
        $db->bind(':id', $this->patientId);

        return $db->execute();
    }
}