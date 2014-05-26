<?php
class user extends OrmClass{
    	protected $_datasource = "user";	public $id_user = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $name = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $login = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $pass = Array ('type' => 'text', 'null' =>  'NO', 'val'=>''); 	public $status = Array ('type' => 'tinyint', 'size' => '3', 'unsigned' => TRUE, 'null' =>  'NO', 'default' => '1', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setIdUser($var){
                $this->id_user['val'] = $var;
             }	function getIdUser(){
                return $this->id_user['val'];
             }	function setName($var){
                $this->name['val'] = $var;
             }	function getName(){
                return $this->name['val'];
             }	function setLogin($var){
                $this->login['val'] = $var;
             }	function getLogin(){
                return $this->login['val'];
             }	function setPass($var){
                $this->pass['val'] = $var;
             }	function getPass(){
                return $this->pass['val'];
             }	function setStatus($var){
                $this->status['val'] = $var;
             }	function getStatus(){
                return $this->status['val'];
             }}