<?php
class profesion_coordinadora_blh extends OrmClass{
    	protected $_datasource = "profesion_coordinadora_blh";	public $profesion_coordinadora_blh_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $profesion = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setProfesionCoordinadoraBlhId($var){
                $this->profesion_coordinadora_blh_id['val'] = $var;
             }	function getProfesionCoordinadoraBlhId(){
                return $this->profesion_coordinadora_blh_id['val'];
             }	function setProfesion($var){
                $this->profesion['val'] = $var;
             }	function getProfesion(){
                return $this->profesion['val'];
             }}