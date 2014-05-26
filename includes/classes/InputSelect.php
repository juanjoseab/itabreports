<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InputSelect
 *
 * @author webmaster
 */

if(!class_exists("Input")){
    MasterController::requerirClase("Input");
    MasterController::requerirClase("InputOption");
}
class InputSelect extends Input{
    var $options = array();
    var $multiple = FALSE;
    
    function addOption(InputOption $option){
        $this->options[] =  $option;
    }
    
    function habilitarSeleccionMultiple(){
        $this->multiple = TRUE;
    }
    
    function inhabilitarSeleccionMultiple(){
        $this->multiple = FALSE;
    }
    
    function output(){
        $input = "";
        if($this->label){
            $input .= "<label>".$this->label."</label>";
        }
        
        $input .= "<select ";
        if($this->name){
            $input .= "name=\"".$this->name."\" ";
        }
        
        if($this->id){
            $input .= "id=\"".$this->id."\" ";
        }
        
        if($this->multiple){
            $input .= "multiple=\"multiple\" ";
        }
        
        
        if($this->placeholder){
            $input .= "placeholder=\"".$this->placeholder."\" ";
        }
        
        if(count($this->cssClase)>0){
            $input .= "class=\"";
            foreach ($this->cssClase AS $css ){
                $input .= $css . " ";
            }
            $input .= "\" ";
        }
        
        if(count($this->attr)>0){
            $input .= "class=\"";
            foreach ($this->attr AS $atr => $val ){
                $input .= " {$atr}=\"{$val}\" ";
            }
            
        }
        $input .= ">";
        
        
        
        if( count($this->options) > 0 ){
            foreach ($this->options as $option){
                $input .= $option->output();
            }
        }
        
        $input .= "</select>";
        
        return $input;
    }
    
}

?>
