<?php
namespace LCIA\LineChartImageAnalyzer\BaseLine;

use LCIA\LineChartImageAnalyzer\{ Attributes, PointColors, PointColor, Color };

class BaseLine extends Attributes
{
    protected $_key;

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
                ->groupBy(function(PointColor $pointcolor) {
                    return $pointcolor->{ $this->_key };
                })
                ->map(function($collect, $key) {
                    return [$key, $collect->count()];
                });
        }
        return $this->_extractedPoints;
    }

    public function getAttributesBase() {
        return $this->extractedPoints->sort(function($first, $second) {
            if ($first[1] === $second[1]) {
                return $first[0] < $second[0] ? -1 : 1 ;
            }
            return $first[1] > $second[1] ? -1 : 1 ; 
        })
        ->first()[0];
    }

}