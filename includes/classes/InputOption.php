<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of InputOption
 *
 * @author webmaster
 */
class InputOption {
    var $disable = FALSE;
    var $label = FALSE;
    var $value = FALSE;
    var $selected = FALSE;
    
    public function __construct($label,$value,$selected=FALSE,$disabled = FALSE) {
        if(empty (trim($label))){
            return false;
        }
        
        $this->label = $label;
        $this->value = $value;
        $this->selected = $selected;
        $this->disable = $disabled;
    }
    
    function output(){
        $option = "<option ";
        if($this->value){
            $option .= 'value="'.$this->value.'" ';
        }
        
        if($this->selected){
            $option .= 'selected="selected" ';
        }
        
        if($this->disable){
            $option .= 'disabled="disabled" ';
        }
        
        if($this->label){
            $option .= '>'.$this->label.'</option>"';
        }
        
        return $option;
        
    }
    
    
    
    
    
    
}

?>
