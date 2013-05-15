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

class MenuController extends AbstractRestfulController
{
    private $_model;

    public function __construct() {
        $module = new \Posvenda\Module;
        $this->_model = $module->getModel('\Posvenda\Model\MenuTable');
    }

    /**
	 * Return list of resources
	 *
	 * @return array
	 */
	public function getList()
	{
        $data = array(
                    'status' => 200,
                    'result' => array(
                        'ok' => 'ok'
                    )
            );

        return $data;
	}

	/**
	 * Return single resource
	 *
	 * @param mixed $id
	 * @return mixed
	 */
	public function get($id) {}

	/**
	 * Create a new resource
	 *
	 * @param mixed $data
	 * @return mixed
	 */
	public function create($data) {}

	/**
	 * Update an existing resource
	 *
	 * @param mixed $id
	 * @param mixed $data
	 * @return mixed
	 */
	public function update($id, $data) {}

	/**
	 * Delete an existing resource
	 *
	 * @param  mixed $id
	 * @return mixed
	 */
	public function delete($id) {}
}
