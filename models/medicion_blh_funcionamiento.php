<?php
class medicion_blh_funcionamiento extends OrmClass{
    	protected $_datasource = "medicion_blh_funcionamiento";	public $medicion_blh_funcionamiento_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $fecha = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $fecha_medicion = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $centros_recolectores_extrahospitalarios = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $clinicas_lactancia_materna = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $actividades_recoleccion_extrahospitalaria = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $actividades_promocion_donacion_extrahospitalaria = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $hospital_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'hospital', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setMedicionBlhFuncionamientoId($var){
                $this->medicion_blh_funcionamiento_id['val'] = $var;
             }	function getMedicionBlhFuncionamientoId(){
                return $this->medicion_blh_funcionamiento_id['val'];
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
             }	function setActividadesRecoleccionExtrahospitalaria($var){
                $this->actividades_recoleccion_extrahospitalaria['val'] = $var;
             }	function getActividadesRecoleccionExtrahospitalaria(){
                return $this->actividades_recoleccion_extrahospitalaria['val'];
             }	function setActividadesPromocionDonacionExtrahospitalaria($var){
                $this->actividades_promocion_donacion_extrahospitalaria['val'] = $var;
             }	function getActividadesPromocionDonacionExtrahospitalaria(){
                return $this->actividades_promocion_donacion_extrahospitalaria['val'];
             }	function setHospitalId($var){
                $this->hospital_id['val'] = $var;
             }	function getHospitalId(){
                return $this->hospital_id['val'];
             }}