<?php
class actividad_promocion_donacion_extrahospitalaria extends OrmClass{
    	protected $_datasource = "actividad_promocion_donacion_extrahospitalaria";	public $actividad_promocion_donacion_extrahospitalaria_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $actividad = Array ('type' => 'text', 'null' =>  'YES', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setActividadPromocionDonacionExtrahospitalariaId($var){
                $this->actividad_promocion_donacion_extrahospitalaria_id['val'] = $var;
             }	function getActividadPromocionDonacionExtrahospitalariaId(){
                return $this->actividad_promocion_donacion_extrahospitalaria_id['val'];
             }	function setActividad($var){
                $this->actividad['val'] = $var;
             }	function getActividad(){
                return $this->actividad['val'];
             }}