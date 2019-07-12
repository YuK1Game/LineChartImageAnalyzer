<?php
declare(strict_types=1);

namespace LCIA;

use LCIA\LineChartImageAnalyzer\{Attributes, Color, Point, PointColor, PointColors};
use LCIA\LineChartImageAnalyzer\BaseLine\{X, Y};
use LCIA\LineChartImageAnalyzer\ChartLine\Chart;

class LineChartImageAnalyzer extends Attributes
{
    /**
     * @var string
     */
    protected $_binary;

    /**
     * @var resource
     */
    protected $_image;

    /**
     * @var array
     */
    protected $_info;

    /**
     * @var LCIA\LineChartImageAnalyzer\PointColors
     */
    protected $_colors;

    /**
     * @var LCIA\LineChartImageAnalyzer\Color
     */
    protected $_baseLineColor;

    /**
     * @var LCIA\LineChartImageAnalyzer\Color
     */
    protected $_chartLineColor;

    /**
     * @var LCIA\LineChartImageAnalyzer\PointColors
     */
    protected $_baseColors;

    /**
     * @var LCIA\LineChartImageAnalyzer\PointColors
     */
    protected $_chartColors;


    public function __construct($filepath) {
        $this->_binary   = file_get_contents($filepath);
        $this->_info     = collect(getimagesize($filepath));
        $this->_colors   = new PointColors();
    }

    public function getImageAttribute() {
        if ( ! $this->_image) {
            $this->_image = imagecreatefromstring($this->_binary);
        }
        return $this->_image;
    }

    private function initColors() {
        if ( ! $this->_baseColors || ! $this->_chartColors) {
            $this->_baseColors = new PointColors();
            $this->_chartColors = new PointColors();

            foreach ($this->getAllPoints() as $point) {
                $colors = imagecolorsforindex($this->image, imagecolorat($this->image, $point->x, $point->y));
                $color = new Color($colors['red'], $colors['green'], $colors['blue'], $colors['alpha']);

                if ($color->getSimilarity($this->_baseLineColor) >= 0.8) {
                    $this->_baseColors->add(new PointColor($point, $color));
                }
                if ($color->getSimilarity($this->_chartLineColor) >= 0.8) {
                    $this->_chartColors->add(new PointColor($point, $color));
                }
            }
        }
    }

    public function setBaseLineColor(int $red, int $green, int $blue) {
        $this->_baseLineColor = new Color($red, $green, $blue);
    }

    public function setChartLineColor(int $red, int $green, int $blue) {
        $this->_chartLineColor = new Color($red, $green, $blue);
    }

    public function getAllPoints() {
        for ($x = 0 ; $x < $this->_info->get(0, 0) ; ++$x) {
            for ($y = 0 ; $y < $this->_info->get(1, 0) ; ++$y) {
                yield new Point($x, $y);
            }
        }
    }

    public function getBaseYAttribute() {
        $this->initColors();
        return new Y($this->_baseColors, $this->_baseLineColor);
    }

    public function getBaseXAttribute() {
        $this->initColors();
        return new X($this->_baseColors, $this->_baseLineColor);
    }

    public function getChartLineAttribute() {
        $this->initColors();
        return new Chart($this->_chartColors, $this->_chartLineColor);
    }

}