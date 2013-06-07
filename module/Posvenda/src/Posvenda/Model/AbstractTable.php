<?php

namespace Posvenda\Model;

use Zend\Db\Sql\Sql,
    Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet;

abstract class AbstractTable
{
    protected $_sql;
    protected $_table;
    protected $_adapter;
    protected $_columns = null;
    protected $primaryColumn;
    protected $_joins = array();

    public function __construct(Adapter $adapter, $tableConfig) {
        $this->_adapter = $adapter;
        $this->_table = $tableConfig['table'];

        if (array_key_exists('columns', $tableConfig)) {
            $this->_columns = $tableConfig['columns'];
        }

        if (array_key_exists('joins', $tableConfig)) {
            $this->_joins = $tableConfig['joins'];
        }

        $this->_sql = new Sql($this->_adapter, $this->_table);
    }

    public function getList($where = array())
    {
        $select = $this->_sql->select();

        if (!empty($this->_columns)) {
            $select->columns($this->_columns);
        }

        if (!empty($this->_joins)) {
            foreach ($this->_joins as $join) {
                $arg1 = $join[0];
                $arg2 = $join[1];
                $arg3 = null;
                $arg4 = null;

                if (array_key_exists(2, $join)) {
                    $arg3 = $join[2];
                }

                if (array_key_exists(3, $join)) {
                    $arg4 = $join[3];
                }

                $select->join($arg1, $arg2, $arg3, $arg4);
            }
        }

        if (!empty($where)) {
            $select->where($where);
        }

        $statement = $this->_sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        $selectCount = $this->_sql->select();
        $selectCount->columns(array('total' => new \Zend\Db\Sql\Expression("count(*)")));
        $selectCount->where($where);
        $statementCount = $this->_sql->prepareStatementForSqlObject($selectCount);
        $resultCount = $statementCount->execute();

        $resultSetCount = new ResultSet();
        $resultSetCount->initialize($resultCount);

        $resultSet = new ResultSet();
        $resultSet->initialize($result);

        $returnArray['array'] = $resultSet->toArray();
        $returnArray['count'] = $resultSetCount->count();
        
        return $returnArray;

    }


        public function save($data) {

        $insert = $this->_sql->insert();

        $insert->values($data);
        $statement = $this->_sql->prepareStatementForSqlObject($insert);
        $result = $statement->execute();

        $id = $this->_adapter->getDriver()->getConnection()->getLastGeneratedValue();
        
        
        return array('status'=>200, $this->primaryColumn=>$id,);
    }

    
    public function update($id, $data) {
        $update = $this->_sql->update();
        $update->set($data)
                ->where(
                        array(
                            $this->primaryColumn => $id
                       ));

        $statement = $this->_sql->prepareStatementForSqlObject($update);
        $result = $statement->execute();
        
        return array('status'=>200, $this->primaryColumn=>$id,);
    }

    
    public function delete($id) {

        $delete = $this->_sql->delete();
        $delete->where(array($this->primaryColumn => $id));
        $statement = $this->_sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();

        return $result;
    }
    
    public function genericSQL($table, array $columns, array $params) {
        $sql = new Sql($this->adapter);
        
        $select = $sql->select();
        $select->from($table)
                ->columns($columns)
                ->where($params);
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();

        $resultSet = new ResultSet();
        $resultSet->initialize($result);

        return $resultSet->toArray();
    }


    public function getAdapter()
    {
        return $this->_adapter;
    }

}

?>
