<?php
class departamento extends OrmClass{
    	protected $_datasource = "departamento";	public $departamento_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $nombre = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $codigo = Array ('type' => 'varchar', 'null' =>  'YES', 'val'=>''); 	public $estado = Array ('type' => 'tinyint', 'null' =>  'NO', 'default' => '1', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setDepartamentoId($var){
                $this->departamento_id['val'] = $var;
             }	function getDepartamentoId(){
                return $this->departamento_id['val'];
             }	function setNombre($var){
                $this->nombre['val'] = $var;
             }	function getNombre(){
                return $this->nombre['val'];
             }	function setCodigo($var){
                $this->codigo['val'] = $var;
             }	function getCodigo(){
                return $this->codigo['val'];
             }	function setEstado($var){
                $this->estado['val'] = $var;
             }	function getEstado(){
                return $this->estado['val'];
             }}