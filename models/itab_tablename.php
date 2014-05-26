<?php
class itab_tablename extends OrmClass{
    	protected $_datasource = "itab_tablename";	public $id_itab_tablename = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $name = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $status = Array ('type' => 'tinyint', 'size' => '3', 'unsigned' => TRUE, 'null' =>  'NO', 'default' => '1', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setIdItabTablename($var){
                $this->id_itab_tablename['val'] = $var;
             }	function getIdItabTablename(){
                return $this->id_itab_tablename['val'];
             }	function setName($var){
                $this->name['val'] = $var;
             }	function getName(){
                return $this->name['val'];
             }	function setStatus($var){
                $this->status['val'] = $var;
             }	function getStatus(){
                return $this->status['val'];
             }}