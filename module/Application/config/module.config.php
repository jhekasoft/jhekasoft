<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'settings' => array(
        'sitename' => 'Jhekasoft',
        'email' => 'jheka@mail.ru',
    ),
    'router' => array(
        'routes' => array(
            'coming-soon' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/coming-soon',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'coming-soon',
                    ),
                ),
            ),
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            // Base RSS feed is blog RSS feed
            'rss' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/rss',
                    'defaults' => array(
                        'controller' => 'Blog\Controller\Blog',
                        'action'     => 'rss',
                    ),
                ),
            ),
        ),
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Software',
                'route' => 'software',
            ),
            array(
                'label' => 'Games',
                'route' => 'software/default',
                'params' => array('type' => 'game'),
            ),
            array(
                'label' => 'Sound',
                'route' => 'bilet33',
            ),
            array(
                'label' => 'Video',
                'route' => 'video',
            ),
            array(
                'label' => 'Blog',
                'route' => 'blog',
            ),
            array(
                'label' => 'About',
                'route' => 'about',
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'ru_RU',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Index' => 'Application\Controller\IndexController',
            'Application\Controller\WebEditor' => 'Application\Controller\WebEditorController',
        ),
    ),
    'view_manager' => array(
//        'display_not_found_reason' => true,
//        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/error'           => __DIR__ . '/../view/layout/clean.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'view_helpers' => array(
        'invokables'=> array(
            'side_right' => 'Application\View\Helper\SideRight',
            'final_countdown_block' => 'Application\View\Helper\FinalCountdownBlock',
            'like_block' => 'Application\View\Helper\LikeBlock',
            'share_block' => 'Application\View\Helper\ShareBlock',
            'comments_block' => 'Application\View\Helper\CommentsBlock',
            'goto_top' => 'Application\View\Helper\GotoTop',
			'walk_header' => 'Application\View\Helper\WalkHeader',
        )
    ),
);
