<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Posvenda\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;

class LinhaController extends AbstractRestfulController
{
    private $_model;

    public function __construct() {
        $module = new \Posvenda\Module;
        $this->_model = $module->getModel('\Posvenda\Model\LinhaTable');
    }

    /**
	 * Return list of resources
	 *
	 * @return array
	 */
	public function getList()
	{
                        $data = $this->_model->getList();
        
                         return $data;
	}

	/**
	 * Return single resource
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function get($id) {
                         $data = $this->_model->getList(array('linha'=>"$id"));
        
                         return $data;
            
                    }

	/**
	 * Create a new resource
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	public function create($data) {
                        $resultado = $this->_model->save($data);
                        return $resultado;
                   }

	/**
	 * Update an existing resource
	 *
	 * @param mixed $id
	 * @param mixed $data
	 * @return mixed
	 */
	public function update($id, $data) {
                        $resultado = $this->_model->update($id,$data);
                        return $resultado;
                    }

	/**
	 * Delete an existing resource
	 *
	 * @param  mixed $id
	 * @return mixed
	 */
	public function delete($id) {
                        $resultado = $this->_model->delete($id);
        
                    }
}
