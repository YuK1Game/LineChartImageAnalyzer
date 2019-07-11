<?php
namespace LCIA\LineChartImageAnalyzer;

use LCIA\LineChartImageAnalyzer\{ Attributes };

class Color extends Attributes
{
    /**
     * @var int
     */
    protected $_red;

    /**
     * @var int
     */
    protected $_green;

    /**
     * @var int
     */
    protected $_blue;

    /**
     * @var float
     */
    protected $_alpha;

    public function __construct(int $red, int $green, int $blue, ?float $alpha = null) {
        $this->_red   = $red;
        $this->_green = $green;
        $this->_blue  = $blue;
        $this->_alpha = $alpha ?? 0;
    }

    public function getRedSimilarity(int $red) {
        return 1 - (abs($red - $this->_red) / 255);
    }

    public function getGreenSimilarity(int $green) {
        return 1 - (abs($green - $this->_green) / 255);
    }

    public function getBlueSimilarity(int $blue) {
        return 1 - (abs($blue - $this->_blue) / 255);
    }

    public function getRedAttribute() {
        return $this->_red;
    }
    
    public function getGreenAttribute() {
        return $this->_green;
    }
    
    public function getBlueAttribute() {
        return $this->_blue;
    }
    
    public function getSimilarity(Color $color) {
        return $this->getRedSimilarity($color->red)
            * $this->getGreenSimilarity($color->green)
            * $this->getBlueSimilarity($color->blue);
    }

    public function __toString() {
        return sprintf('%d,%d,%d', $this->red, $this->green, $this->blue);
    }

}