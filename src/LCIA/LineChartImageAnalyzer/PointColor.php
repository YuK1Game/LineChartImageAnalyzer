<?php
namespace LCIA\LineChartImageAnalyzer;

use LCIA\LineChartImageAnalyzer\{Attributes, Color, Point};

class PointColor extends Attributes
{
    /**
     * @var LCIA\LineChartImageAnalyzer\Point
     */
    protected $_point;

    /**
     * @var LCIA\LineChartImageAnalyzer\Color
     */
    protected $_color;

    public function __construct(Point $point, Color $color) {
        $this->_point = $point;
        $this->_color = $color;
    }

    public function getAttributesColor() {
        return $this->_color;
    }

    public function getAttributesPoint() {
        return $this->_point;
    }

    public function getAttributesX() {
        return $this->_point->x;
    }

    public function getAttributesY() {
        return $this->_point->y;
    }

    public function getAttributesRed() {
        return $this->_color->red;
    }

    public function getAttributesGreen() {
        return $this->_color->green;
    }

    public function getAttributesBlue() {
        return $this->_color->blue;
    }

    public function __toString() {
        return sprintf('%d,%d %d,%d,%d', $this->x, $this->y, $this->red, $this->green, $this->blue);
    }

}