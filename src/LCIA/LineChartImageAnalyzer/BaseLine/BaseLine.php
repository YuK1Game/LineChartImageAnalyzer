<?php
namespace LCIA\LineChartImageAnalyzer\BaseLine;

use LCIA\LineChartImageAnalyzer\{ Attributes, PointColors, PointColor, Color };

class BaseLine extends Attributes
{
    protected $_key;

    protected $_pointColors;

    protected $_color;

    protected $_extractedPoints;

    protected $_is_left_first = true;

    protected $_is_bottom_first = true;

    public function __construct(PointColors $pointColors, Color $color) {
        $this->_pointColors = $pointColors;
        $this->_color = $color;
    }

    public function getExtractedPointsAttribute() {
        if ( ! $this->_extractedPoints) {
            $this->_extractedPoints = $this->_pointColors
                ->groupBy(function(PointColor $pointcolor) {
                    return $pointcolor->{ $this->_key };
                })
                ->map(function($collect, $key) {
                    return [$key, $collect->count()];
                });
        }
        return $this->_extractedPoints;
    }

    public function getBaseAttribute() {
        return $this->extractedPoints->reject(function($row) {
            list($top_key, $top_count) = $this->top;
            list($row_key, $row_count) = $row;
            return $top_count * 0.8 > $row_count;
        })
        ->sortBy(function($row) {
            return $row[0];
        })
        ->first()[0];
    }

    public function getTopAttribute() {
        return $this->extractedPoints->sort(function($first, $second) {
            if ($first[1] === $second[1]) {
                return $first[0] < $second[0] ? -1 : 1 ;
            }
            return $first[1] > $second[1] ? -1 : 1 ; 
        })
        ->first();
    }

}