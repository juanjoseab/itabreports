<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Formulario
 *
 * @author webmaster
 */

MasterController::requerirClase("InputText");
MasterController::requerirClase("InputSelect");
MasterController::requerirClase("InputTextarea");

class Formulario {
    var $inputs = Array();
    var $form = "";
    var $constructionError;
    var $cssClase = array();
    var $action = FALSE;
    var $method = "POST";
    var $id = FALSE;
    var $titulo  = FALSE;
    var $submitTitle = "Enviar";
    
    
    function addInput($input){
        $this->inputs[] = $input;
    }
    
     function addClaseCss($cssClase){
        $this->cssClase[] = $cssClase;
    }
    
    function construir(){
        if(empty ($this->action)){
            $this->constructionError = "El formulario debe tener una url de destino, una ACTION";
            return false;
        }
        if(count($this->inputs)){
            $this->constructionError = "El formulario debe tener campos para contener. por favor asigne al menos un campo";
            return false;
        }
        
        $this->form = "<form action=\"{$this->action}\" method=\"{$this->method}\"";
        if($id){
            $this->form.=" id=\"{$this->id}\" ";
        }
        
        if(count($this->cssClase)>0){
            $input .= "class=\"";
            foreach ($this->cssClase AS $css ){
                $input .= $css . " ";
            }
            $input .= "\" ";
        }
        
        $this->form .= ">
            ";
        
        if($titulo){
            $this->form .= "<legend>{$this->titulo}</legend>";
        }
        
        
        foreach ($this->inputs as $input){
            $this->form .= $input->output();
        }
        
        $this->form .= "<input type=\"submit\" value=\"{$this->submitTitle}\" >
        ";
        $this->form .= "</form>";
        
       
    }
    
    function load($obj){
        
    }
    
    
    function output(){
        $this->construir();
        return $this->form;
    }
    
    
    
}

?>
