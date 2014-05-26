<?php
class indicador extends OrmClass{
    	protected $_datasource = "indicador";	public $indicador_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $nombre = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $descripcion = Array ('type' => 'text', 'null' =>  'YES', 'val'=>''); 	public $estandar_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'estandar', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setIndicadorId($var){
                $this->indicador_id['val'] = $var;
             }	function getIndicadorId(){
                return $this->indicador_id['val'];
             }	function setNombre($var){
                $this->nombre['val'] = $var;
             }	function getNombre(){
                return $this->nombre['val'];
             }	function setDescripcion($var){
                $this->descripcion['val'] = $var;
             }	function getDescripcion(){
                return $this->descripcion['val'];
             }	function setEstandarId($var){
                $this->estandar_id['val'] = $var;
             }	function getEstandarId(){
                return $this->estandar_id['val'];
             }}