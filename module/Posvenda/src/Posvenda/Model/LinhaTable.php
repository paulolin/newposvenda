<?php

namespace Posvenda\Model;

use Zend\Db\Adapter\Adapter;

class LinhaTable extends AbstractTable
{
    public $primaryColumn = "linha";
    public function __construct(Adapter $adapter) {
        $tableConfig = array(
            'table' => 'tbl_linha',
        );

        parent::__construct($adapter, $tableConfig);
    }
}
