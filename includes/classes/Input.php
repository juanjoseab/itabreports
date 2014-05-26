<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Input
 *
 * @author webmaster
 */
class Input {
    var $type = "text";
    
    var $name = FALSE;
    var $id = FALSE;
    var $placeholder = FALSE;
    var $label = FALSE;    
    var $val  = FALSE;
    
    var $maxlength;
    
    var $cssClase = array() ;
    var $attr = array();
    
    function addMaxlength($maxlength){
        $this->maxlength = $maxlength;
   }
    
    function addLabel($label){
        $this->label = $label;
    }
    
    function addType($type){
        $this->type = $type;
    }
    
    function addVal($val){
        $this->val = $val;
    }
    
    function addClaseCss($cssClase){
        $this->cssClase[] = $cssClase;
    }
    
    function addAttr($attr , $attrVal){
        if($attr && $attrVal){
            $this->attr[$attr] = $attrVal;
        }
    }
    
    function output(){
        $input = "";
        if($this->label){
            $input .= "<label>".$this->label."</label>";
        }
        
        $input .= "<input type=\"".$this->type."\" ";
        if($this->name){
            $input .= "name=\"".$this->name."\" ";
        }
        
        if($this->id){
            $input .= "id=\"".$this->id."\" ";
        }
        
        if($this->placeholder){
            $input .= "placeholder=\"".$this->placeholder."\" ";
        }
        
        if($this->maxlength){
            $input .= "maxlength=\"".$this->maxlength."\" ";
        }
        
        if($this->val){
            $input .= "val=\"".$this->val."\" ";
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
        $input .= "/>";
        
        return $input;
    }
    
    
}

?>
