<?php
class actividad_recoleccion_extrahospitalaria extends OrmClass{
    	protected $_datasource = "actividad_recoleccion_extrahospitalaria";	public $actividad_recoleccion_extrahospitalaria_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $actividad = Array ('type' => 'text', 'null' =>  'NO', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setActividadRecoleccionExtrahospitalariaId($var){
                $this->actividad_recoleccion_extrahospitalaria_id['val'] = $var;
             }	function getActividadRecoleccionExtrahospitalariaId(){
                return $this->actividad_recoleccion_extrahospitalaria_id['val'];
             }	function setActividad($var){
                $this->actividad['val'] = $var;
             }	function getActividad(){
                return $this->actividad['val'];
             }}