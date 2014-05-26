<?php
class hospital extends OrmClass{
    	protected $_datasource = "hospital";	public $hospital_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'primary' => TRUE, 'val'=>''); 	public $nombre = Array ('type' => 'varchar', 'null' =>  'NO', 'val'=>''); 	public $municipio_id = Array ('type' => 'int', 'size' => '10', 'unsigned' => TRUE, 'null' =>  'NO', 'foreign' => TRUE, 'reference' => 'municipio', 'val'=>''); 	function getReference() {
            return $this->_datasource;
        }	function setHospitalId($var){
                $this->hospital_id['val'] = $var;
             }	function getHospitalId(){
                return $this->hospital_id['val'];
             }	function setNombre($var){
                $this->nombre['val'] = $var;
             }	function getNombre(){
                return $this->nombre['val'];
             }	function setMunicipioId($var){
                $this->municipio_id['val'] = $var;
             }	function getMunicipioId(){
                return $this->municipio_id['val'];
             }}