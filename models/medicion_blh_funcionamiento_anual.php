<?php
class medicion_blh_funcionamiento_anual extends OrmClass{
    	protected $_datasource = "medicion_blh_funcionamiento_anual";	public $medicion_blh_funcionamiento_anual_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $fecha = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $fecha_medicion = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $anio = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $numero_tesis_estudios = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $medicion_tardia = Array ('type' => 'tinyint', 'null' =>  'NO', 'val'=>''); 	public $hospital_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'hospital', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setMedicionBlhFuncionamientoAnualId($var){
                $this->medicion_blh_funcionamiento_anual_id['val'] = $var;
             }	function getMedicionBlhFuncionamientoAnualId(){
                return $this->medicion_blh_funcionamiento_anual_id['val'];
             }	function setFecha($var){
                $this->fecha['val'] = $var;
             }	function getFecha(){
                return $this->fecha['val'];
             }	function setFechaMedicion($var){
                $this->fecha_medicion['val'] = $var;
             }	function getFechaMedicion(){
                return $this->fecha_medicion['val'];
             }	function setAnio($var){
                $this->anio['val'] = $var;
             }	function getAnio(){
                return $this->anio['val'];
             }	function setNumeroTesisEstudios($var){
                $this->numero_tesis_estudios['val'] = $var;
             }	function getNumeroTesisEstudios(){
                return $this->numero_tesis_estudios['val'];
             }	function setMedicionTardia($var){
                $this->medicion_tardia['val'] = $var;
             }	function getMedicionTardia(){
                return $this->medicion_tardia['val'];
             }	function setHospitalId($var){
                $this->hospital_id['val'] = $var;
             }	function getHospitalId(){
                return $this->hospital_id['val'];
             }}