<?php
class accessslist extends OrmClass{
    	protected $_datasource = "accessslist";	public $id_user = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'val'=>''); 	public $id_module = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setIdUser($var){
                $this->id_user['val'] = $var;
             }	function getIdUser(){
                return $this->id_user['val'];
             }	function setIdModule($var){
                $this->id_module['val'] = $var;
             }	function getIdModule(){
                return $this->id_module['val'];
             }}