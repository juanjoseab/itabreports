<?php
class module extends OrmClass{
    	protected $_datasource = "module";	public $id_module = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $name = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $path = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $id_parent = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'YES', 'foreign' => TRUE, 'reference' => 'id_parent', 'val'=>''); 	public $visible = Array ('type' => 'tinyint', 'null' =>  'NO', 'default' => '1', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setIdModule($var){
                $this->id_module['val'] = $var;
             }	function getIdModule(){
                return $this->id_module['val'];
             }	function setName($var){
                $this->name['val'] = $var;
             }	function getName(){
                return $this->name['val'];
             }	function setPath($var){
                $this->path['val'] = $var;
             }	function getPath(){
                return $this->path['val'];
             }	function setIdParent($var){
                $this->id_parent['val'] = $var;
             }	function getIdParent(){
                return $this->id_parent['val'];
             }	function setVisible($var){
                $this->visible['val'] = $var;
             }	function getVisible(){
                return $this->visible['val'];
             }}