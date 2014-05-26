<?php

class ClassTransaction {

    var $obj;
    var $saveError = false;

    function loadClass(&$object) {
        $this->obj = $object;
    }

    function save($pk = false, $showQUERY = FALSE) {

        if (is_object($this->obj)) {
            $className = strtolower(get_class($this->obj));
            $fields = get_object_vars($this->obj);
            //var_dump($fields);
            $f;
            $v;
            if (($pk == false)) {
                $pks = $this->getPKS($className);
            }

            foreach ($fields as $field => $val) {

                if (is_array($val)) {
                    if (($pk == false) && !in_array(strtolower($field), $pks)) {
                        if ($val['val']) {
                            $f .= "{$field},";
                            $v .= "'{$val[val]}',";
                        }
                        //echo $field;
                    } elseif (($pk == true)) {
                        if ($val['val']) {
                            $f .= "{$field},";
                            $v .= "'{$val[val]}',";
                        }
                    }
                }
            }
            $f = substr($f, 0, -1);
            $v = substr($v, 0, -1);


            $sql = "INSERT INTO {$className} ({$f}) VALUES ({$v});";

            if ($showQUERY) {
                echo "<p>" . $sql . "</p>";
            }
            /* echo $sql;
              return $sql;
              die; */
            $dbo = new Dbexec();
            $dbo->queryExecute($sql);
            if (($pk == false)) {
                $id = $dbo->ultimoIndice($className, $pks[0]);
                $set = str_replace("_", "", "set" . ucfirst($pks[0]));
                $this->obj->$set($id);
            }



            if ($dbo->error) {
                print( $this->saveError = $dbo->error);
                return false;
            } else {
                return true;
            }
        }
    }

    function update() {

        if (is_object($this->obj)) {
            $className = strtolower(get_class($this->obj));
            $fields = get_object_vars($this->obj);
            $primaryKey = false;
            $primaryKeyVal = false;
            //var_dump($fields);
            $f;
            $v;
            if (($pk == false)) {
                $pks = $this->getPKS($className);
            }

            foreach ($fields as $field => $val) {

                if (is_array($val)) {
                    if (($pk == false) && !in_array(strtolower($field), $pks)) {
                        if ($val['val']) {
                            $f .= "{$field} = '{$val[val]}', ";
                        }
                    } elseif (in_array(strtolower($field), $pks)) {
                        $primaryKey = $field;
                        $primaryKeyVal = $val['val'];
                    }
                }
            }
            $f = substr($f, 0, -2);


            $sql = "UPDATE {$className} SET {$f} WHERE {$primaryKey} = '{$primaryKeyVal}';";

            //return $sql;
            //echo $sql; die;
            $dbo = new Dbexec();
            $dbo->queryExecute($sql);




            if ($dbo->error) {
                print( $this->saveError = $dbo->error);
                return false;
            } else {
                return true;
            }
        }
    }

    function delete() {

        if (is_object($this->obj)) {
            $className = strtolower(get_class($this->obj));
            $fields = get_object_vars($this->obj);
            $primaryKey = false;

            //var_dump($fields);
            $f;
            $v;
            if (($pk == false)) {
                $pks = $this->getPKS($className);
            }

            foreach ($fields as $field => $val) {

                if (is_array($val)) {
                    if (($pk == false) && !in_array(strtolower($field), $pks)) {
                        $f .= "{$field} = '{$val[val]}', ";
                    } elseif (in_array(strtolower($field), $pks)) {
                        $a = array("campo" => $field, "valor" => $val['val']);
                        $primaryKey[] = $a;
                    }
                }
            }
            $f = substr($f, 0, -2);
            if (is_array($primaryKey) && count($primaryKey) > 0) {
                $where = "";
                foreach ($primaryKey AS $pk) {
                    $where .= " " . $pk['campo'] . " = '" . $pk['valor'] . "' AND";
                }
                $where = substr($where, 0, -3);
            }

            $sql = "DELETE FROM {$className} WHERE {$where};";

            //return $sql;
            $dbo = new Dbexec();
            $dbo->queryExecute($sql);

            if ($dbo->error) {
                if ($dbo->errno == 1451) {
                    echo '<div class="alert alert-error">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <h4>Error!</h4>
                    El campo que desea eliminar esta relacionado con otros, por favor verifique que no tenga relaciones asignadas.
                </div>';
                } else {

                    $this->saveError = $dbo->error;
                    print($this->saveError);
                    return false;
                }
            } else {
                $this->obj = NULL;
                return true;
            }
        }
    }

    function table_exists($table) {
        $dbo = new Dbexec();
        $dbo->queryExecute("SHOW TABLES ");
        while ($row = $dbo->getArray()) {
            if ($row == $table) {
                return TRUE;
            }
        }
        return FALSE;
    }

    private function getPKS($tabla) {
        $dbo = new Dbexec();
        $dbo->queryExecute("SHOW KEYS FROM {$tabla} WHERE Key_name = 'PRIMARY'");
        $res = array();
        while ($row = $dbo->getArray()) {
            $res[] = strtolower($row['Column_name']);
        }
        return $res;
    }

    function returnObjectValues() {
        if (is_object($this->obj)) {
            $array = array();
            $className = strtolower(get_class($this->obj));
            $sql = "SELECT * FROM {$className} WHERE ";
            $fields = get_object_vars($this->obj);
            foreach ($fields AS $field => $val) {
                if ($val['primary'] == true) {
                    $sql.=" {$field} = '{$val[val]}' AND";
                }
            }
            $sql = substr($sql, 0, -3) . " LIMIT 1;";
            $dbo = new Dbexec();
            $dbo->queryExecute($sql);
            //echo $sql;
            if ($dbo->error) {
                print( $this->saveError = $dbo->error);
                return false;
            } else {
                if ($dbo->numeroFilas() > 0) {
                    while ($r = $dbo->getArray()) {
                        foreach ($fields AS $field => $val) {
                            $array[$field] = $r[$field];
                        }
                    }
                    return $array;
                } else {
                    return FALSE;
                }
            }
        }
    }

}

?>
