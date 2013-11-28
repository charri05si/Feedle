<?php

namespace MVC;

class TableRow {

    private $_table; //string
    
    /**
     * Permet de retourner l'instance correcte nécéssaire pour chaque modèle
     * @return \MVC\TableRowOracle|\MVC\TableRowMysql
     * @throws Exception
     */
    public static function getInstance()
    {
        switch(\Install\App::BDD_TYPE)
        {
            case BddType::ORACLE: 
                return new TableRowOracle();
                break;
            
            case BddType::MYSQL: 
                return new TableRowMysql();
                break;
            
            case BddType::SQLSERVER:
                throw new Exception('Not Yet Implented');
                break;
            
            default:
                throw new Exception('Invalid BDD Type');
                break;
        }
    }
    
    //Destructeur
    public function __destruct() {
        $attributs = get_object_vars($this);
        $keys = array_keys($attributs);
        foreach ($keys as $cle) {
            unset($this->$cle);
        }
    }

    //Table de travaille
    public function setTable($table) {
       $this->_table = $table;
    }
    
    /**
     * 
     * @param String $table
     * @param PDO $pdo
     * @return \MVC\TableRow
     * @throws \Exception
     */
    public function store($table = null, $pdo = null) {
        if (is_null($pdo)) {
            $pdo = Connexion::get();
        }
        if (is_null($table)) {
            $table = $this->_table;
        }
        $attributs = get_object_vars($this);
        //suppression des attributs de la classe TableRow
        $keys = array_keys($attributs);
        foreach ($keys as $cle) {
            if (substr($cle, 0, 1) == '_') {
                unset($attributs[$cle]);
            }
        }
        $values = array_values($attributs);

        if (isset($this->id) and is_numeric($this->id)) {
            $query = 'update ' . $table . ' set ';
            $query.=implode('=?,', array_keys($attributs)) . '=?';
            $query.=' where id=?';
            $values[] = $this->id;
        } else {
            $query = 'insert into '
                    . $table
                    . '(' . implode(',', array_keys($attributs)) . ') values ('
                    . substr(str_repeat('?,', sizeof($attributs)), 0, -1) . ')';
        }
        $queryPrepare = $pdo->prepare($query);
        
        if (!$queryPrepare->execute($values)) {
            $error = $queryPrepare->errorInfo();
            throw new \Exception("\nPDO::errorInfo():\n" . $error[2]);
        }
        if (!is_numeric($this->id)) {
            $this->id = $pdo->lastInsertId();
        }
        return $this;
    }

    public function delete($table = null, $pdo = null) {
        if (is_null($pdo)) {
            $pdo = Connexion::get();
        }
        if (is_null($table)) {
            $table = $this->_table;
        }
        if (isset($this->id) and !is_null($this->id)) {
            $query = 'delete from ' . $table;
            $query.=' where id=?';
            $queryPrepare = $pdo->prepare($query);
            $ex = $queryPrepare->execute(array($this->id));
        } else {
            $ex = null;
        }
        unset($this);
        return $ex;
    }

    public function populate($params) {
        $cles = get_object_vars($this);
        $keys = array_keys($cles);
        foreach ($keys as $cle) {
            if (substr($cle, 0, 1) != '_' and isset($params[$cle])) {
                $this->$cle = $params[$cle];
            }
        }
    }

    /*
      public function __call($name) {

      if (substr($name, 0, 3) == 'get') {
      $nom = ucfirst(substr($name, 3, -1));
      $class = '\\APPLI\\M\\' . $nom;

      $classThis = strtolower(substr(get_class($this), 0, -3));
      $pos = strrpos($classThis, '\\');
      $classThis = substr($classThis, $pos + 1);

      return $class::getInstance()->where($classThis . '_id=?', array($this->id));
      }
      }
     */

}
