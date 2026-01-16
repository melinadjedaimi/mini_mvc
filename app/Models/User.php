<?php

// Ici je définit le namespace ou il y aura ma class
namespace Mini\Models;

use Mini\Core\Database;
use PDO;

class User
{
    private $id;
    private $nom;
    private $email;
    private $mot_de_passe;

    // =====================
    // Getters / Setters
    // =====================

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getnom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getMotDePasse()
    {
        return $this->mot_de_passe;
    }

    public function setMotDePasse(string $motDePasseClair)
    {
        // On stocke toujours le mot de passe hashé
        $this->mot_de_passe = password_hash($motDePasseClair, PASSWORD_BCRYPT);
    }

    // =====================
    // Méthodes CRUD
    // =====================

    /**
     * Récupère tous les utilisateurs
     * @return array
     */
    public static function getAll()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->query("SELECT id, nom, email, created_at FROM users ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un utilisateur par son ID
     * @param int $id
     * @return array|null
     */
    public static function findById($id)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user !== false ? $user : null;
    }

    /**
     * Récupère un utilisateur par son email
     * @param string $email
     * @return array|null
     */
    public static function findByEmail($email)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user !== false ? $user : null;
    }

    /**
     * Crée un nouvel utilisateur avec mot de passe hashé
     * @return bool
     */
    public function save()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("INSERT INTO users (nom, email, mot_de_passe) VALUES (?, ?, ?)");
        return $stmt->execute([$this->nom, $this->email, $this->mot_de_passe]);
    }

    /**
     * Met à jour les informations d’un utilisateur existant (sans changer le mot de passe)
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("UPDATE users SET nom = ?, email = ? WHERE id = ?");
        return $stmt->execute([$this->nom, $this->email, $this->id]);
    }

    /**
     * Met à jour le mot de passe d’un utilisateur existant
     * @param string $nouveauMotDePasseClair
     * @return bool
     */
    public function updatePassword(string $nouveauMotDePasseClair): bool
    {
        $pdo = Database::getPDO();
        $hash = password_hash($nouveauMotDePasseClair, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("UPDATE users SET mot_de_passe = ? WHERE id = ?");
        return $stmt->execute([$hash, $this->id]);
    }

    /**
     * Supprime un utilisateur
     * @return bool
     */
    public function delete()
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$this->id]);
    }

    /**
     * Vérifie les identifiants de connexion et retourne l'utilisateur si OK
     * @param string $email
     * @param string $motDePasseClair
     * @return array|null
     */
    public static function verifyCredentials(string $email, string $motDePasseClair): ?array
    {
        $user = self::findByEmail($email);
        if (!$user) {
            return null;
        }

        if (!password_verify($motDePasseClair, $user['mot_de_passe'])) {
            return null;
        }

        return $user;
    }
}
