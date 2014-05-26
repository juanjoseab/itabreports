<?php
class medicion_blh_funcionamiento_mensual extends OrmClass{
    	protected $_datasource = "medicion_blh_funcionamiento_mensual";	public $medicion_blh_funcionamiento_mensual_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $fecha = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $fecha_medicion = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $hospital_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'hospital', 'val'=>''); 	public $numero_madres_consegeria_individual = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $recoleccion_visita_domiciliar = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $recoleccion_centros_recolectores = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $recoleccion_otras_actividades_especiales = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $promocion_radio = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $promocion_television = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $promocion_prensa_medios_escritos = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $promocion_perifoneo = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $promocion_servicios_salud = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $promocion_talleres_charlas_conferencias = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $medicion_tardia = Array ('type' => 'tinyint', 'null' =>  'NO', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setMedicionBlhFuncionamientoMensualId($var){
                $this->medicion_blh_funcionamiento_mensual_id['val'] = $var;
             }	function getMedicionBlhFuncionamientoMensualId(){
                return $this->medicion_blh_funcionamiento_mensual_id['val'];
             }	function setFecha($var){
                $this->fecha['val'] = $var;
             }	function getFecha(){
                return $this->fecha['val'];
             }	function setFechaMedicion($var){
                $this->fecha_medicion['val'] = $var;
             }	function getFechaMedicion(){
                return $this->fecha_medicion['val'];
             }	function setHospitalId($var){
                $this->hospital_id['val'] = $var;
             }	function getHospitalId(){
                return $this->hospital_id['val'];
             }	function setNumeroMadresConsegeriaIndividual($var){
                $this->numero_madres_consegeria_individual['val'] = $var;
             }	function getNumeroMadresConsegeriaIndividual(){
                return $this->numero_madres_consegeria_individual['val'];
             }	function setRecoleccionVisitaDomiciliar($var){
                $this->recoleccion_visita_domiciliar['val'] = $var;
             }	function getRecoleccionVisitaDomiciliar(){
                return $this->recoleccion_visita_domiciliar['val'];
             }	function setRecoleccionCentrosRecolectores($var){
                $this->recoleccion_centros_recolectores['val'] = $var;
             }	function getRecoleccionCentrosRecolectores(){
                return $this->recoleccion_centros_recolectores['val'];
             }	function setRecoleccionOtrasActividadesEspeciales($var){
                $this->recoleccion_otras_actividades_especiales['val'] = $var;
             }	function getRecoleccionOtrasActividadesEspeciales(){
                return $this->recoleccion_otras_actividades_especiales['val'];
             }	function setPromocionRadio($var){
                $this->promocion_radio['val'] = $var;
             }	function getPromocionRadio(){
                return $this->promocion_radio['val'];
             }	function setPromocionTelevision($var){
                $this->promocion_television['val'] = $var;
             }	function getPromocionTelevision(){
                return $this->promocion_television['val'];
             }	function setPromocionPrensaMediosEscritos($var){
                $this->promocion_prensa_medios_escritos['val'] = $var;
             }	function getPromocionPrensaMediosEscritos(){
                return $this->promocion_prensa_medios_escritos['val'];
             }	function setPromocionPerifoneo($var){
                $this->promocion_perifoneo['val'] = $var;
             }	function getPromocionPerifoneo(){
                return $this->promocion_perifoneo['val'];
             }	function setPromocionServiciosSalud($var){
                $this->promocion_servicios_salud['val'] = $var;
             }	function getPromocionServiciosSalud(){
                return $this->promocion_servicios_salud['val'];
             }	function setPromocionTalleresCharlasConferencias($var){
                $this->promocion_talleres_charlas_conferencias['val'] = $var;
             }	function getPromocionTalleresCharlasConferencias(){
                return $this->promocion_talleres_charlas_conferencias['val'];
             }	function setMedicionTardia($var){
                $this->medicion_tardia['val'] = $var;
             }	function getMedicionTardia(){
                return $this->medicion_tardia['val'];
             }}