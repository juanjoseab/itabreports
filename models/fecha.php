<?php
class fecha extends OrmClass{
    	protected $_datasource = "fecha";	public $fecha_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $mes = Array ('type' => 'int', 'size' => '11', 'unsigned' => TRUE, 'null' =>  'NO', 'val'=>''); 	public $anio = Array ('type' => 'int', 'size' => '11', 'unsigned' => TRUE, 'null' =>  'NO', 'val'=>''); 	public $date = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $estado = Array ('type' => 'tinyint', 'size' => '4', 'unsigned' => TRUE, 'null' =>  'NO', 'default' => '1', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setFechaId($var){
                $this->fecha_id['val'] = $var;
             }	function getFechaId(){
                return $this->fecha_id['val'];
             }	function setMes($var){
                $this->mes['val'] = $var;
             }	function getMes(){
                return $this->mes['val'];
             }	function setAnio($var){
                $this->anio['val'] = $var;
             }	function getAnio(){
                return $this->anio['val'];
             }	function setDate($var){
                $this->date['val'] = $var;
             }	function getDate(){
                return $this->date['val'];
             }	function setEstado($var){
                $this->estado['val'] = $var;
             }	function getEstado(){
                return $this->estado['val'];
             }}