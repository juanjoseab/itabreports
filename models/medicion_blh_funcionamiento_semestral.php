<?php
class medicion_blh_funcionamiento_semestral extends OrmClass{
    	protected $_datasource = "medicion_blh_funcionamiento_semestral";	public $medicion_blh_funcionamiento_semestral_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $fecha = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $fecha_medicion = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $centros_recolectores_extrahospitalarios = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $clinicas_lactancia_materna = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $hospital_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'hospital', 'val'=>''); 	public $medicion_tardia = Array ('type' => 'tinyint', 'null' =>  'NO', 'val'=>''); 	public $semestre = Array ('type' => 'tinyint', 'null' =>  'NO', 'default' => '1', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setMedicionBlhFuncionamientoSemestralId($var){
                $this->medicion_blh_funcionamiento_semestral_id['val'] = $var;
             }	function getMedicionBlhFuncionamientoSemestralId(){
                return $this->medicion_blh_funcionamiento_semestral_id['val'];
             }	function setFecha($var){
                $this->fecha['val'] = $var;
             }	function getFecha(){
                return $this->fecha['val'];
             }	function setFechaMedicion($var){
                $this->fecha_medicion['val'] = $var;
             }	function getFechaMedicion(){
                return $this->fecha_medicion['val'];
             }	function setCentrosRecolectoresExtrahospitalarios($var){
                $this->centros_recolectores_extrahospitalarios['val'] = $var;
             }	function getCentrosRecolectoresExtrahospitalarios(){
                return $this->centros_recolectores_extrahospitalarios['val'];
             }	function setClinicasLactanciaMaterna($var){
                $this->clinicas_lactancia_materna['val'] = $var;
             }	function getClinicasLactanciaMaterna(){
                return $this->clinicas_lactancia_materna['val'];
             }	function setHospitalId($var){
                $this->hospital_id['val'] = $var;
             }	function getHospitalId(){
                return $this->hospital_id['val'];
             }	function setMedicionTardia($var){
                $this->medicion_tardia['val'] = $var;
             }	function getMedicionTardia(){
                return $this->medicion_tardia['val'];
             }	function setSemestre($var){
                $this->semestre['val'] = $var;
             }	function getSemestre(){
                return $this->semestre['val'];
             }}