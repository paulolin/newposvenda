<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Posvenda;

use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        /** @var \Zend\ModuleManager\ModuleManager $moduleManager */
		$moduleManager = $e->getApplication()->getServiceManager()->get('modulemanager');
		/** @var \Zend\EventManager\SharedEventManager $sharedEvents */
		$sharedEvents = $moduleManager->getEventManager()->getSharedManager();

		$sharedEvents->attach('Zend\Mvc\Controller\AbstractRestfulController', MvcEvent::EVENT_DISPATCH, array($this, 'postProcess'), -100);
//		$sharedEvents->attach('Zend\Mvc\Application', MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'errorProcess'), 999);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getAppConfig() {
        $path = __DIR__ . '/../../config/autoload/';
        $include = (file_exists($path . 'local.php')) ? 'local' : 'global';
        return include $path . $include . '.php';
    }

    /**
	 * @param MvcEvent $e
	 * @return null|\Zend\Http\PhpEnvironment\Response
	 */
	public function postProcess(MvcEvent $e)
	{
        if ($e->getResult() instanceof \Zend\View\Model\ViewModel) {
            $vars = $e->getResult()->getVariables();
        } else {
            $vars = $e->getResult();
        }
        
        $response = new \Posvenda\Response($vars);

        return $response->getResponse();
	}

    public function getModel($modelName)
    {
        $config = $this->getAppConfig();

        $adapter = new \Zend\Db\Adapter\Adapter($config['db']);;
        $model = new $modelName($adapter);

        return $model;
    }
}
