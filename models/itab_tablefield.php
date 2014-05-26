<?php
class itab_tablefield extends OrmClass{
    	protected $_datasource = "itab_tablefield";	public $id_itab_tablefield = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $name = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $status = Array ('type' => 'tinyint', 'size' => '3', 'unsigned' => TRUE, 'null' =>  'NO', 'default' => '1', 'val'=>''); 	public $is_filtrable = Array ('type' => 'tinyint', 'size' => '3', 'unsigned' => TRUE, 'null' =>  'NO', 'val'=>''); 	public $id_fieldtype = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'id_fieldtype', 'val'=>''); 	public $id_itab_tablename = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'id_itab_tablename', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setIdItabTablefield($var){
                $this->id_itab_tablefield['val'] = $var;
             }	function getIdItabTablefield(){
                return $this->id_itab_tablefield['val'];
             }	function setName($var){
                $this->name['val'] = $var;
             }	function getName(){
                return $this->name['val'];
             }	function setStatus($var){
                $this->status['val'] = $var;
             }	function getStatus(){
                return $this->status['val'];
             }	function setIsFiltrable($var){
                $this->is_filtrable['val'] = $var;
             }	function getIsFiltrable(){
                return $this->is_filtrable['val'];
             }	function setIdFieldtype($var){
                $this->id_fieldtype['val'] = $var;
             }	function getIdFieldtype(){
                return $this->id_fieldtype['val'];
             }	function setIdItabTablename($var){
                $this->id_itab_tablename['val'] = $var;
             }	function getIdItabTablename(){
                return $this->id_itab_tablename['val'];
             }}