<?php

require_once('model/LibraryModel.php');

class LibraryController {
    private $model;

    public function __construct() {
        $this->model = new LibraryModel();
    }

    public function addBook($title, $author, $publicationYear, $genre) {
        $this->model->addBook($title, $author, $publicationYear, $genre);
    }

    public function getLibrary() {
        return $this->model->getLibrary();
    }

    public function searchBook($title) {
        return $this->model->searchBook($title);
    }

    public function deleteBook($index) {
        $this->model->deleteBook($index);
    }
}
?>
