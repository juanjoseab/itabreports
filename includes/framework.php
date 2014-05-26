<?php


class Framework {
    var $modelo;
    var $controlador;
    var $display;
    public function __construct() {
        $this->modelo = new MasterModel();
        $this->controlador = new MasterController();
        $this->display = new Display();
    }
}

?>
