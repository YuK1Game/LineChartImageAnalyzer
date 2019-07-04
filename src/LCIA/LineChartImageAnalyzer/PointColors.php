<?php
namespace LCIA\LineChartImageAnalyzer;

use LCIA\LineChartImageAnalyzer\{ Attributes, PointColor, Color };

class PointColors extends Attributes
{
    /**
     * @var Collection
     */
    protected $_pointcolors;

    public function __construct($data = null) {
        $this->_pointcolors = $data ?? collect();
    }

    public function add(PointColor $pointcolor) {
        $this->_pointcolors->push($pointcolor);
    }

    public function getSimilarities(Color $color, ?float $similarity = null) {
        $result = $this->_pointcolors->reject(function(PointColor $pointcolor) use($color, $similarity) {
            return $pointcolor->color->getSimilarity($color) < ($similarity ?? 0.8);
        });
        return new self($result);
    }

    public function __call($method, $argv) {
        if (method_exists($this->_pointcolors, $method)) {
            return $this->_pointcolors->{$method}(...$argv);
        }
        return $this->{$method}(...$argv);
    }

}