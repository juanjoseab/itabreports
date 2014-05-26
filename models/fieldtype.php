<?php
class fieldtype extends OrmClass{
    	protected $_datasource = "fieldtype";	public $id_fieldtype = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $name = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setIdFieldtype($var){
                $this->id_fieldtype['val'] = $var;
             }	function getIdFieldtype(){
                return $this->id_fieldtype['val'];
             }	function setName($var){
                $this->name['val'] = $var;
             }	function getName(){
                return $this->name['val'];
             }}