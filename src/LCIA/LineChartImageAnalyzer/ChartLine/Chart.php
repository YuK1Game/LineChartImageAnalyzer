<?php
namespace LCIA\LineChartImageAnalyzer\ChartLine;

use LCIA\LineChartImageAnalyzer\{ Attributes, PointColors, PointColor, Point, Color };

class Chart extends Attributes
{
    protected $_pointColors;

    protected $_color;

    protected $_extractedPoints;

    public function __construct(PointColors $pointColors, Color $color) {
        $this->_pointColors = $pointColors;
        $this->_color = $color;
    }

    public function getAttributesExtractedPoints() {
        if ( ! $this->_extractedPoints) {
            $this->_extractedPoints = $this->_pointColors
                ->getSimilarities($this->_color)
                ->map(function(PointColor $pointColor) {
                    return $pointColor->point;
                })
                ->values();
        }
        return $this->_extractedPoints;
    }

    public function getAttributesTopPoint() {
        return $this->extractedPoints
            ->sortBy(function(Point $point) {
                return (int) $point->y;
            })
            ->values()
            ->first();
    }

    public function getAttributesBottomPoint() {
        return $this->extractedPoints
            ->sortBy(function(Point $point) {
                return $point->y;
            })
            ->values()
            ->last();
    }

    public function getAttributesFirstPoint() {
        return $this->extractedPoints
            ->sortBy(function(Point $point) {
                return $point->x;
            })
            ->values()
            ->first();
    }

    public function getAttributesLastPoint() {
        return $this->extractedPoints
            ->sortBy(function(Point $point) {
                return $point->x;
            })
            ->values()
            ->last();
    }

}