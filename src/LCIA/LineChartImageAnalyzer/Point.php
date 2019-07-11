<?php
namespace LCIA\LineChartImageAnalyzer;

use LCIA\LineChartImageAnalyzer\Attributes;

class Point extends Attributes
{
    /**
     * @var int
     */
    protected $_x;

    /**
     * @var int
     */
    protected $_y;

    public function __construct(int $x, int $y) {
        $this->_x = $x;
        $this->_y = $y;
    }

    public function getXAttribute() {
        return $this->_x;
    }

    public function getYAttribute() {
        return $this->_y;
    }

    public function __toString() {
        return sprintf('%d,%d', $this->x, $this->y);
    }

}