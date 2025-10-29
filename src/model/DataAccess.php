<?php

trait DataAccess {
  public function __set($name, $value) {
    $this->$name = $value;
  }

  public function __get($name) {
    return isset($this->$name) ? $this->$name : null;
  }

  public function __call($metodo, $args) {
    $campo = lcfirst(substr($metodo, 3));

    if (stripos($metodo, "set") === 0) {
      $this->$campo = $args[0];
      return;
    }
    if (stripos($metodo, "get") === 0) {
      return $this->$campo;
    }
    throw new Exception("Método indefinido");
  }
}