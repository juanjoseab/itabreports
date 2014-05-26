<?php
class valor_indicador extends OrmClass{
    	protected $_datasource = "valor_indicador";	public $valor_indicador_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'auto_increment' => TRUE, 'val'=>''); 	public $valor = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $indicador_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'indicador', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setValorIndicadorId($var){
                $this->valor_indicador_id['val'] = $var;
             }	function getValorIndicadorId(){
                return $this->valor_indicador_id['val'];
             }	function setValor($var){
                $this->valor['val'] = $var;
             }	function getValor(){
                return $this->valor['val'];
             }	function setIndicadorId($var){
                $this->indicador_id['val'] = $var;
             }	function getIndicadorId(){
                return $this->indicador_id['val'];
             }}