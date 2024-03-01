<?php

class Usuario {

    private $id;
    private $email;
    private $isAdmin;
    private $nombre;

    public function __construct($id, $nombre,$email, $isAdmin) {
        $this->id = $id;
        $this->email = $email;
        $this->isAdmin = $isAdmin;
        $this->nombre = $nombre;
    }

    // Getters y setters

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getIsAdmin() {
        return $this->isAdmin;
    }

    public function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    // Ejemplo de método
    public function saludar() {
        echo "Hola, " . $this->nombre . "<" . $this->email . ">.";
    }
}


?>