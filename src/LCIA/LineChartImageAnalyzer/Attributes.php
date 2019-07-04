<?php
namespace LCIA\LineChartImageAnalyzer;

abstract class Attributes
{
    public function __get(string $key) {
        $method = 'getAttributes' . collect(preg_split('/_/', $key))
            ->map(function($value) {
                return ucfirst($value);
            })
            ->implode('');
            
        if (method_exists($this, $method)) {
            return $this->{ $method }();
        }

        return $this->{ $key };
    }
}