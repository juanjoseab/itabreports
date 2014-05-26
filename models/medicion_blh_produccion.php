<?php
class medicion_blh_produccion extends OrmClass{
    	protected $_datasource = "medicion_blh_produccion";	public $medicion_blh_produccion_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $fecha = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $fecha_medicion = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $litros_leche_recolectada = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $litros_leche_distribuida = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $litros_leche_recolectada_intrahospitalaria = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $litros_leche_recolectada_extrahospitalaria = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $litros_leche_pasteurizada = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $litros_leche_descartada = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $uso_leche_recolectada = Array ('type' => '', 'null' =>  'YES', 'val'=>''); 	public $rn_atendidos_ucip_neumo_rn = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $rn_tratados_leche_humana = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $cobertura_atencion = Array ('type' => '', 'null' =>  'NO', 'val'=>''); 	public $cantidad_madres_donadoras = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $numero_madres_donadoras_internas = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $numero_madres_donadoras_externas = Array ('type' => 'int', 'null' =>  'NO', 'val'=>''); 	public $hospital_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'hospital', 'val'=>''); 	public $medicion_tardia = Array ('type' => 'tinyint', 'null' =>  'NO', 'val'=>''); 	public $stock = Array ('type' => 'int', 'null' =>  'YES', 'val'=>''); 	public $stock_anterior = Array ('type' => 'int', 'null' =>  'YES', 'val'=>''); 	public $stock_leche_pasteurizada = Array ('type' => 'int', 'null' =>  'YES', 'val'=>''); 	public $stock_leche_pasteurizada_anterior = Array ('type' => 'int', 'null' =>  'YES', 'val'=>''); 	public $porcentaje_donadoras_internas = Array ('type' => '', 'null' =>  'YES', 'val'=>''); 	public $porcentaje_donadoras_externas = Array ('type' => '', 'null' =>  'YES', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setMedicionBlhProduccionId($var){
                $this->medicion_blh_produccion_id['val'] = $var;
             }	function getMedicionBlhProduccionId(){
                return $this->medicion_blh_produccion_id['val'];
             }	function setFecha($var){
                $this->fecha['val'] = $var;
             }	function getFecha(){
                return $this->fecha['val'];
             }	function setFechaMedicion($var){
                $this->fecha_medicion['val'] = $var;
             }	function getFechaMedicion(){
                return $this->fecha_medicion['val'];
             }	function setLitrosLecheRecolectada($var){
                $this->litros_leche_recolectada['val'] = $var;
             }	function getLitrosLecheRecolectada(){
                return $this->litros_leche_recolectada['val'];
             }	function setLitrosLecheDistribuida($var){
                $this->litros_leche_distribuida['val'] = $var;
             }	function getLitrosLecheDistribuida(){
                return $this->litros_leche_distribuida['val'];
             }	function setLitrosLecheRecolectadaIntrahospitalaria($var){
                $this->litros_leche_recolectada_intrahospitalaria['val'] = $var;
             }	function getLitrosLecheRecolectadaIntrahospitalaria(){
                return $this->litros_leche_recolectada_intrahospitalaria['val'];
             }	function setLitrosLecheRecolectadaExtrahospitalaria($var){
                $this->litros_leche_recolectada_extrahospitalaria['val'] = $var;
             }	function getLitrosLecheRecolectadaExtrahospitalaria(){
                return $this->litros_leche_recolectada_extrahospitalaria['val'];
             }	function setLitrosLechePasteurizada($var){
                $this->litros_leche_pasteurizada['val'] = $var;
             }	function getLitrosLechePasteurizada(){
                return $this->litros_leche_pasteurizada['val'];
             }	function setLitrosLecheDescartada($var){
                $this->litros_leche_descartada['val'] = $var;
             }	function getLitrosLecheDescartada(){
                return $this->litros_leche_descartada['val'];
             }	function setUsoLecheRecolectada($var){
                $this->uso_leche_recolectada['val'] = $var;
             }	function getUsoLecheRecolectada(){
                return $this->uso_leche_recolectada['val'];
             }	function setRnAtendidosUcipNeumoRn($var){
                $this->rn_atendidos_ucip_neumo_rn['val'] = $var;
             }	function getRnAtendidosUcipNeumoRn(){
                return $this->rn_atendidos_ucip_neumo_rn['val'];
             }	function setRnTratadosLecheHumana($var){
                $this->rn_tratados_leche_humana['val'] = $var;
             }	function getRnTratadosLecheHumana(){
                return $this->rn_tratados_leche_humana['val'];
             }	function setCoberturaAtencion($var){
                $this->cobertura_atencion['val'] = $var;
             }	function getCoberturaAtencion(){
                return $this->cobertura_atencion['val'];
             }	function setCantidadMadresDonadoras($var){
                $this->cantidad_madres_donadoras['val'] = $var;
             }	function getCantidadMadresDonadoras(){
                return $this->cantidad_madres_donadoras['val'];
             }	function setNumeroMadresDonadorasInternas($var){
                $this->numero_madres_donadoras_internas['val'] = $var;
             }	function getNumeroMadresDonadorasInternas(){
                return $this->numero_madres_donadoras_internas['val'];
             }	function setNumeroMadresDonadorasExternas($var){
                $this->numero_madres_donadoras_externas['val'] = $var;
             }	function getNumeroMadresDonadorasExternas(){
                return $this->numero_madres_donadoras_externas['val'];
             }	function setHospitalId($var){
                $this->hospital_id['val'] = $var;
             }	function getHospitalId(){
                return $this->hospital_id['val'];
             }	function setMedicionTardia($var){
                $this->medicion_tardia['val'] = $var;
             }	function getMedicionTardia(){
                return $this->medicion_tardia['val'];
             }	function setStock($var){
                $this->stock['val'] = $var;
             }	function getStock(){
                return $this->stock['val'];
             }	function setStockAnterior($var){
                $this->stock_anterior['val'] = $var;
             }	function getStockAnterior(){
                return $this->stock_anterior['val'];
             }	function setStockLechePasteurizada($var){
                $this->stock_leche_pasteurizada['val'] = $var;
             }	function getStockLechePasteurizada(){
                return $this->stock_leche_pasteurizada['val'];
             }	function setStockLechePasteurizadaAnterior($var){
                $this->stock_leche_pasteurizada_anterior['val'] = $var;
             }	function getStockLechePasteurizadaAnterior(){
                return $this->stock_leche_pasteurizada_anterior['val'];
             }	function setPorcentajeDonadorasInternas($var){
                $this->porcentaje_donadoras_internas['val'] = $var;
             }	function getPorcentajeDonadorasInternas(){
                return $this->porcentaje_donadoras_internas['val'];
             }	function setPorcentajeDonadorasExternas($var){
                $this->porcentaje_donadoras_externas['val'] = $var;
             }	function getPorcentajeDonadorasExternas(){
                return $this->porcentaje_donadoras_externas['val'];
             }}