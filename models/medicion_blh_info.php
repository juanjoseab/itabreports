<?php
class medicion_blh_info extends OrmClass{
    	protected $_datasource = "medicion_blh_info";	public $medicion_blh_info_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $fecha = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $hospital_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'hospital', 'val'=>''); 	public $inauguracion = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $cantidad_cunas_servicio_recien_nacido = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $cantidad_camas_maternidad = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $nombre_coordinadora = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $profesion_coordinadora_blh_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'profesion_coordinadora_blh', 'val'=>''); 	public $telefono = Array ('type' => 'text', 'null' =>  'YES', 'val'=>''); 	public $email_contacto = Array ('type' => 'text', 'null' =>  'YES', 'val'=>''); 	public $fecha_primera_pasteurizacion = Array ('type' => '', 'null' =>  'YES', 'val'=>''); 	public $dias_pasteurizacion_semanal = Array ('type' => 'int', 'null' =>  'YES', 'val'=>''); 	public $veces_pasteurizacion_diaria = Array ('type' => 'int', 'null' =>  'YES', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setMedicionBlhInfoId($var){
                $this->medicion_blh_info_id['val'] = $var;
             }	function getMedicionBlhInfoId(){
                return $this->medicion_blh_info_id['val'];
             }	function setFecha($var){
                $this->fecha['val'] = $var;
             }	function getFecha(){
                return $this->fecha['val'];
             }	function setHospitalId($var){
                $this->hospital_id['val'] = $var;
             }	function getHospitalId(){
                return $this->hospital_id['val'];
             }	function setInauguracion($var){
                $this->inauguracion['val'] = $var;
             }	function getInauguracion(){
                return $this->inauguracion['val'];
             }	function setCantidadCunasServicioRecienNacido($var){
                $this->cantidad_cunas_servicio_recien_nacido['val'] = $var;
             }	function getCantidadCunasServicioRecienNacido(){
                return $this->cantidad_cunas_servicio_recien_nacido['val'];
             }	function setCantidadCamasMaternidad($var){
                $this->cantidad_camas_maternidad['val'] = $var;
             }	function getCantidadCamasMaternidad(){
                return $this->cantidad_camas_maternidad['val'];
             }	function setNombreCoordinadora($var){
                $this->nombre_coordinadora['val'] = $var;
             }	function getNombreCoordinadora(){
                return $this->nombre_coordinadora['val'];
             }	function setProfesionCoordinadoraBlhId($var){
                $this->profesion_coordinadora_blh_id['val'] = $var;
             }	function getProfesionCoordinadoraBlhId(){
                return $this->profesion_coordinadora_blh_id['val'];
             }	function setTelefono($var){
                $this->telefono['val'] = $var;
             }	function getTelefono(){
                return $this->telefono['val'];
             }	function setEmailContacto($var){
                $this->email_contacto['val'] = $var;
             }	function getEmailContacto(){
                return $this->email_contacto['val'];
             }	function setFechaPrimeraPasteurizacion($var){
                $this->fecha_primera_pasteurizacion['val'] = $var;
             }	function getFechaPrimeraPasteurizacion(){
                return $this->fecha_primera_pasteurizacion['val'];
             }	function setDiasPasteurizacionSemanal($var){
                $this->dias_pasteurizacion_semanal['val'] = $var;
             }	function getDiasPasteurizacionSemanal(){
                return $this->dias_pasteurizacion_semanal['val'];
             }	function setVecesPasteurizacionDiaria($var){
                $this->veces_pasteurizacion_diaria['val'] = $var;
             }	function getVecesPasteurizacionDiaria(){
                return $this->veces_pasteurizacion_diaria['val'];
             }}