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
    protected $_filepath;

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



    public function __construct($filepath) {
        $this->_filepath = $filepath;
        $this->_info     = collect(getimagesize($filepath));
        $this->_colors   = new PointColors();
    }

    public function getAttributesImage() {
        if ( ! $this->_image) {
            switch ($this->_info->get('mime', null)) {
                case 'image/png': 
                    $this->_image = imagecreatefrompng($this->_filepath);
                    break;
                case 'image/jpg':
                case 'image/jpeg':
                    $this->_image = imagecreatefromjpeg($this->_filepath);
                    break;
                default:
                    throw new \Exception('E');
            }
        }
        return $this->_image;
    }

    public function getAttributesPointColors() {
        if ($this->_colors->count() === 0) {
            foreach ($this->getAllPoints() as $point) {
                $colorValue = imagecolorat($this->image, $point->x, $point->y);
                $colors = imagecolorsforindex($this->image, $colorValue);
                $this->_colors->add(new PointColor($point, new Color($colors['red'], $colors['green'], $colors['blue'], $colors['alpha'])));
            }
        }
        return $this->_colors;
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

    public function baseLineY() {
        return new Y($this->pointColors, $this->_baseLineColor);
    }

    public function baseLineX() {
        return new X($this->pointColors, $this->_baseLineColor);
    }

    public function chartLine() {
        return new Chart($this->pointColors, $this->_chartLineColor);
    }

}