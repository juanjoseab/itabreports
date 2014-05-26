<?php
class funcion extends OrmClass{
    	protected $_datasource = "funcion";	public $funcion_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $nombre = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $descripcion = Array ('type' => 'text', 'null' =>  'YES', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setFuncionId($var){
                $this->funcion_id['val'] = $var;
             }	function getFuncionId(){
                return $this->funcion_id['val'];
             }	function setNombre($var){
                $this->nombre['val'] = $var;
             }	function getNombre(){
                return $this->nombre['val'];
             }	function setDescripcion($var){
                $this->descripcion['val'] = $var;
             }	function getDescripcion(){
                return $this->descripcion['val'];
             }}