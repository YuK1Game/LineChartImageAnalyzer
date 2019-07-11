<?php
namespace LCIA\LineChartImageAnalyzer;

abstract class Attributes
{
    public function __get(string $key) {
        $name = collect(preg_split('/_/', $key))
            ->map(function($value) {
                return ucfirst($value);
            })
            ->implode('');
        $method = sprintf('get%sAttribute', $name);
            
        if (method_exists($this, $method)) {
            return $this->{ $method }();
        }

        return $this->{ $key };
    }
}