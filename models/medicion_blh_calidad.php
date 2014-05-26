<?php
class medicion_blh_calidad extends OrmClass{
    	protected $_datasource = "medicion_blh_calidad";	public $medicion_blh_calidad_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $fecha = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $fecha_medicion = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $cantidad_analisis_acidez_dormic = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $cantidad_aceptable_acidez_dormic = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $cantidad_no_aceptable_acidez_dormic = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $conformidad_acidez_dormic = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $acidez_dormic_promedio = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $valor_crematocrito_mas_alto = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $valor_crematocrito_mas_bajo = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $total_crematocrito = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $cantidad_analisis_coliformes = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $cantidad_aceptable_coliformes = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $cantidad_no_aceptable_coliformes = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $conformidad_coliformes = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $hospital_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'hospital', 'val'=>''); 	public $medicion_tardia = Array ('type' => 'tinyint', 'null' =>  'NO', 'val'=>''); 	public $litros_leche_descartada_analisis_sensiorial = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $porcentaje_leche_descartada_analisis_sensorial = Array ('type' => 'int', 'null' =>  'YES', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setMedicionBlhCalidadId($var){
                $this->medicion_blh_calidad_id['val'] = $var;
             }	function getMedicionBlhCalidadId(){
                return $this->medicion_blh_calidad_id['val'];
             }	function setFecha($var){
                $this->fecha['val'] = $var;
             }	function getFecha(){
                return $this->fecha['val'];
             }	function setFechaMedicion($var){
                $this->fecha_medicion['val'] = $var;
             }	function getFechaMedicion(){
                return $this->fecha_medicion['val'];
             }	function setCantidadAnalisisAcidezDormic($var){
                $this->cantidad_analisis_acidez_dormic['val'] = $var;
             }	function getCantidadAnalisisAcidezDormic(){
                return $this->cantidad_analisis_acidez_dormic['val'];
             }	function setCantidadAceptableAcidezDormic($var){
                $this->cantidad_aceptable_acidez_dormic['val'] = $var;
             }	function getCantidadAceptableAcidezDormic(){
                return $this->cantidad_aceptable_acidez_dormic['val'];
             }	function setCantidadNoAceptableAcidezDormic($var){
                $this->cantidad_no_aceptable_acidez_dormic['val'] = $var;
             }	function getCantidadNoAceptableAcidezDormic(){
                return $this->cantidad_no_aceptable_acidez_dormic['val'];
             }	function setConformidadAcidezDormic($var){
                $this->conformidad_acidez_dormic['val'] = $var;
             }	function getConformidadAcidezDormic(){
                return $this->conformidad_acidez_dormic['val'];
             }	function setAcidezDormicPromedio($var){
                $this->acidez_dormic_promedio['val'] = $var;
             }	function getAcidezDormicPromedio(){
                return $this->acidez_dormic_promedio['val'];
             }	function setValorCrematocritoMasAlto($var){
                $this->valor_crematocrito_mas_alto['val'] = $var;
             }	function getValorCrematocritoMasAlto(){
                return $this->valor_crematocrito_mas_alto['val'];
             }	function setValorCrematocritoMasBajo($var){
                $this->valor_crematocrito_mas_bajo['val'] = $var;
             }	function getValorCrematocritoMasBajo(){
                return $this->valor_crematocrito_mas_bajo['val'];
             }	function setTotalCrematocrito($var){
                $this->total_crematocrito['val'] = $var;
             }	function getTotalCrematocrito(){
                return $this->total_crematocrito['val'];
             }	function setCantidadAnalisisColiformes($var){
                $this->cantidad_analisis_coliformes['val'] = $var;
             }	function getCantidadAnalisisColiformes(){
                return $this->cantidad_analisis_coliformes['val'];
             }	function setCantidadAceptableColiformes($var){
                $this->cantidad_aceptable_coliformes['val'] = $var;
             }	function getCantidadAceptableColiformes(){
                return $this->cantidad_aceptable_coliformes['val'];
             }	function setCantidadNoAceptableColiformes($var){
                $this->cantidad_no_aceptable_coliformes['val'] = $var;
             }	function getCantidadNoAceptableColiformes(){
                return $this->cantidad_no_aceptable_coliformes['val'];
             }	function setConformidadColiformes($var){
                $this->conformidad_coliformes['val'] = $var;
             }	function getConformidadColiformes(){
                return $this->conformidad_coliformes['val'];
             }	function setHospitalId($var){
                $this->hospital_id['val'] = $var;
             }	function getHospitalId(){
                return $this->hospital_id['val'];
             }	function setMedicionTardia($var){
                $this->medicion_tardia['val'] = $var;
             }	function getMedicionTardia(){
                return $this->medicion_tardia['val'];
             }	function setLitrosLecheDescartadaAnalisisSensiorial($var){
                $this->litros_leche_descartada_analisis_sensiorial['val'] = $var;
             }	function getLitrosLecheDescartadaAnalisisSensiorial(){
                return $this->litros_leche_descartada_analisis_sensiorial['val'];
             }	function setPorcentajeLecheDescartadaAnalisisSensorial($var){
                $this->porcentaje_leche_descartada_analisis_sensorial['val'] = $var;
             }	function getPorcentajeLecheDescartadaAnalisisSensorial(){
                return $this->porcentaje_leche_descartada_analisis_sensorial['val'];
             }}