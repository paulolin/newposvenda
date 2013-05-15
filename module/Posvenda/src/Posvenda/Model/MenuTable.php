<?php

namespace Posvenda\Model;

use Zend\Db\Adapter\Adapter;

class MenuTable extends AbstractTable
{
    public function __construct(Adapter $adapter) {
        $tableConfig = array(
            'table' => 'tbl_menu'
        );

        parent::__construct($adapter, $tableConfig);
    }
}
