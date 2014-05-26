<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of inputTextarea
 *
 * @author webmaster
 */

if(!class_exists("Input")){
    MasterController::requerirClase("Input");
}
class inputTextarea extends Input{
    var $cols;
    var $rows;
    
    function addCols($cols){
        $this->cols = $cols;
    }
    
    function addRows($rows){
        $this->rows = $rows;
    }
    
    function output(){
        $input = "";
        if($this->label){
            $input .= "<label>".$this->label."</label>";
        }
        
        $input .= "<textarea ";
        if($this->name){
            $input .= "name=\"".$this->name."\" ";
        }
        
        if($this->id){
            $input .= "id=\"".$this->id."\" ";
        }
        
        if($this->rows){
            $input .= "rows=\"".$this->rows."\" ";
        }
        
        if($this->cols){
            $input .= "cols=\"".$this->cols."\" ";
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
        
        
        
        if($this->val){
            $input .= $this->val;
        }
        
        $input .= "</textarea>";
        
        return $input;
    }
}

?>
