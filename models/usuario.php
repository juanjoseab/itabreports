<?php
class usuario extends OrmClass{
    	protected $_datasource = "usuario";	public $usuario_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $nombre = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $login = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $clave = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $rol_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'rol', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setUsuarioId($var){
                $this->usuario_id['val'] = $var;
             }	function getUsuarioId(){
                return $this->usuario_id['val'];
             }	function setNombre($var){
                $this->nombre['val'] = $var;
             }	function getNombre(){
                return $this->nombre['val'];
             }	function setLogin($var){
                $this->login['val'] = $var;
             }	function getLogin(){
                return $this->login['val'];
             }	function setClave($var){
                $this->clave['val'] = $var;
             }	function getClave(){
                return $this->clave['val'];
             }	function setRolId($var){
                $this->rol_id['val'] = $var;
             }	function getRolId(){
                return $this->rol_id['val'];
             }}