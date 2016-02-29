<?php

namespace Khill\Lavacharts\Symfony\Bundle\Twig;

use \Khill\Lavacharts\Lavacharts;
use \Khill\Lavacharts\Charts\ChartFactory;

/**
 * LKavachartsExtension - A PHP wrapper library for the Google Chart API
 *
 *
 * @category  Class
 * @package   Khill\Lavacharts
 * @author    Kevin Hill <kevinkhill@gmail.com>
 * @copyright (c) 2016, KHill Designs
 * @link      http://github.com/kevinkhill/lavacharts GitHub Repository Page
 * @link      http://lavacharts.com                   Official Docs Site
 * @license   http://opensource.org/licenses/MIT MIT
 */
class LavachartsExtension extends \Twig_Extension
{
    /**
     * The Lavacharts object passed in from the service container.
     *
     * @var \Khill\Lavacharts\Lavacharts
     */
    private $lava;

    public function __construct(Lavacharts $lava)
    {
        $this->lava = $lava;
    }

    /**
     * Get the custom twig functions
     *
     * @return array Array of custom twig functions
     */
    public function getFunctions()
    {
        $twigFunctions = $this->getChartFunctions();

        $twigFunctions[] = new \Twig_SimpleFunction('renderAll', function () {
            return $this->lava->renderAll();
        });

        return $twigFunctions;
    }

    /**
     * Create new twig functions for each chart type.
     *
     * @return array Array of chart specific twig functions
     */
    private function getChartFunctions()
    {
        $functions = [];

        foreach (ChartFactory::getChartTypes() as $chartClass) {
            $functions[] = new \Twig_SimpleFunction(strtolower($chartClass),
                function ($chartLabel) use ($chartClass) {
                    return $this->lava->render($chartClass, $chartLabel);
                }
            );
        }

        return $functions;
    }

    /**
     * Get the name of the Twig extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'lavacharts_twig_extension';
    }
}
