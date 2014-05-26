<?php
class submision extends OrmClass{
    	protected $_datasource = "submision";	public $submision_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $fecha = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $nombre_personal = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $cargo = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $historia_clinica = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $estandar_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'estandar', 'val'=>''); 	public $hospital_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'hospital', 'val'=>''); 	public $servicio_intrahospitalario_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'servicio_intrahospitalario', 'val'=>''); 	public $valor_indicador_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'valor_indicador', 'val'=>''); 	public $fecha_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'fecha', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setSubmisionId($var){
                $this->submision_id['val'] = $var;
             }	function getSubmisionId(){
                return $this->submision_id['val'];
             }	function setFecha($var){
                $this->fecha['val'] = $var;
             }	function getFecha(){
                return $this->fecha['val'];
             }	function setNombrePersonal($var){
                $this->nombre_personal['val'] = $var;
             }	function getNombrePersonal(){
                return $this->nombre_personal['val'];
             }	function setCargo($var){
                $this->cargo['val'] = $var;
             }	function getCargo(){
                return $this->cargo['val'];
             }	function setHistoriaClinica($var){
                $this->historia_clinica['val'] = $var;
             }	function getHistoriaClinica(){
                return $this->historia_clinica['val'];
             }	function setEstandarId($var){
                $this->estandar_id['val'] = $var;
             }	function getEstandarId(){
                return $this->estandar_id['val'];
             }	function setHospitalId($var){
                $this->hospital_id['val'] = $var;
             }	function getHospitalId(){
                return $this->hospital_id['val'];
             }	function setServicioIntrahospitalarioId($var){
                $this->servicio_intrahospitalario_id['val'] = $var;
             }	function getServicioIntrahospitalarioId(){
                return $this->servicio_intrahospitalario_id['val'];
             }	function setValorIndicadorId($var){
                $this->valor_indicador_id['val'] = $var;
             }	function getValorIndicadorId(){
                return $this->valor_indicador_id['val'];
             }	function setFechaId($var){
                $this->fecha_id['val'] = $var;
             }	function getFechaId(){
                return $this->fecha_id['val'];
             }}