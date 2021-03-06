<?php
/**
 * @component     CG Résa - Joomla 4.0.0
 * Version			: 2.0.3
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 * @copyright (c) 2020 ConseilGouz. All Rights Reserved.
 * @author ConseilGouz 
**/
defined('_JEXEC') or die;

use Joomla\CMS\Component\Router\RouterFactoryInterface;
use Joomla\CMS\Dispatcher\ComponentDispatcherFactoryInterface;
use Joomla\CMS\Extension\ComponentInterface;
use Joomla\CMS\Extension\Service\Provider\ComponentDispatcherFactory;
use Joomla\CMS\Extension\Service\Provider\MVCFactory;
use Joomla\CMS\Extension\Service\Provider\RouterFactory;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use ConseilGouz\Component\CGDictionary\Administrator\Extension\CGDictionaryComponent;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

/**
 * The Page service provider.
 *
 * @since  4.0.0
 */
return new class implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 *
	 * @since   4.0.0
	 */
	public function register(Container $container)
	{
		$container->registerServiceProvider(new MVCFactory('\\ConseilGouz\\Component\\CGDictionary'));
		$container->registerServiceProvider(new ComponentDispatcherFactory('\\ConseilGouz\\Component\\CGDictionary'));
		$container->registerServiceProvider(new RouterFactory('\\ConseilGouz\\Component\\CGDictionary'));
		$container->set(
			ComponentInterface::class,
			function (Container $container)
			{
				$component = new CGDictionaryComponent($container->get(ComponentDispatcherFactoryInterface::class));
				$component->setMVCFactory($container->get(MVCFactoryInterface::class));
				$component->setRouterFactory($container->get(RouterFactoryInterface::class));

				return $component;
			}
		);
	}
};
