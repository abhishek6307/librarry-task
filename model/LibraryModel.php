<?php

class LibraryModel {
    private $db;

    public function __construct() {
        // Modify these database credentials to match your environment
        $dbHost = 'localhost';
        $dbName = 'library';
        $dbUser = 'root';
        $dbPass = '';

        try {
            $this->db = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function addBook($title, $author, $publicationYear, $genre) {
        $stmt = $this->db->prepare("INSERT INTO books (title, author, publicationYear, genre) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $author, $publicationYear, $genre]);
    }

    public function getLibrary() {
        $stmt = $this->db->query("SELECT * FROM books");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchBook($title) {
        $stmt = $this->db->prepare("SELECT * FROM books WHERE title LIKE ?");
        $stmt->execute(["%$title%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteBook($id) {
        $stmt = $this->db->prepare("DELETE FROM books WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
