<?php
class actividad_recoleccion_medicion extends OrmClass{
    	protected $_datasource = "actividad_recoleccion_medicion";	public $medicion_blh_funcionamiento_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'val'=>''); 	public $actividad_recoleccion_extrahospitalaria_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'val'=>''); 	public $cantidad = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setMedicionBlhFuncionamientoId($var){
                $this->medicion_blh_funcionamiento_id['val'] = $var;
             }	function getMedicionBlhFuncionamientoId(){
                return $this->medicion_blh_funcionamiento_id['val'];
             }	function setActividadRecoleccionExtrahospitalariaId($var){
                $this->actividad_recoleccion_extrahospitalaria_id['val'] = $var;
             }	function getActividadRecoleccionExtrahospitalariaId(){
                return $this->actividad_recoleccion_extrahospitalaria_id['val'];
             }	function setCantidad($var){
                $this->cantidad['val'] = $var;
             }	function getCantidad(){
                return $this->cantidad['val'];
             }}