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

        print_r($this->_sql->getSqlStringForSqlObject($select)); exit;

//        $statement = $this->sql->prepareStatementForSqlObject($select);
//
//        $result = $statement->execute();
//
//        $selectCount = $this->sql->select();
//        $selectCount->columns(array('total' => new \Zend\Db\Sql\Expression("count(*)")));
//        $selectCount->where($where);
//        $statementCount = $this->sql->prepareStatementForSqlObject($selectCount);
//        $resultCount = $statementCount->execute();
//
//        $resultSetCount = new ResultSet();
//        $resultSetCount->initialize($resultCount);
//
//        $resultSet = new ResultSet();
//        $resultSet->initialize($result);
//
//        $returnArray['array'] = $resultSet->toArray();
//        $returnArray['count'] = $resultSetCount->count();
//
//        return $returnArray;

    }

//    public function save(Array $values) {
//
//        if ($values) {
//
//            $arr = array('token', 'qtde', 'referencia');
//
//            foreach ($arr as $val) {
//                if (!array_key_exists($val, $values)) {
//                    return array(
//                            'status' => 406,
//                            'response' => array(
//                                'status' => 'Not Acceptable',
//                                'message' => 'Informações insuficientes'
//                            )
//                        );
//                }
//            }
//
//            $tokenExists = $this->getByToken($values['token'], true);
//
//            if (empty($tokenExists)) {
//                return array(
//                        'status' => 403,
//                        'response' => array(
//                            'status' => 'Forbidden',
//                            'message' => 'Token inválida'
//                        )
//                    );
//            }
//
//            $sql = new Sql($this->getAdapter());
//            $select = $sql->select();
//            $select->from('tbl_peca')
//                ->where(array(
//                    'fabrica' => self::FABRICA,
//                    'referencia' => $values['referencia']
//                    )
//                );
//            $statement = $sql->prepareStatementForSqlObject($select);
//            $results = $statement->execute();
//
//            $resultSet = new ResultSet();
//            $resultSet->initialize($results);
//            $result = $resultSet->toArray();
//
//            if (!$result) {
//                return array(
//                        'status' => 406,
//                        'response' => array(
//                            'status' => 'Not Acceptable',
//                            'message' => 'Referência não encontrada'
//                        )
//                    );
//            }
//
//            $values['fabrica'] = self::FABRICA;
//
//            $insert = $this->_sql->insert();
//            $insert->values($values);
//
//            $statement = $this->_sql->prepareStatementForSqlObject($insert);
//            $statement->execute();
//
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//
//    }


    public function getAdapter()
    {
        return $this->_adapter;
    }

}

?>
