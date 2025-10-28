<?php

trait DataAccess {
  public function __set($name, $value) {
    $this->$name = $value;
  }

  public function __get($name) {
    return isset($this->$name) ? $this->$name : null;
  }

  public function __call($method, $args) {
    $campo = lcfirst(substr($method, 3));
    if (stripos($method, 'set')) {
      $this->$campo = $args[0];
    }
    if (stripos($method, 'get')) {
      return $this->$campo;
    }
  }
}

// precisa de revisão. Métodos mágicos não estão funcionando