<?php
declare(strict_types=1);

namespace Tests\LCIA;

use PHPUnit\Framework\TestCase;

use LCIA\LineChartImageAnalyzer;
use LCIA\LineChartImageAnalyzer\Point;

class LineChartImageAnalyzerTest extends TestCase
{
    public function testLoad(): void
    {
        // $lcia = new LineChartImageAnalyzer('tests/images/graph01.png');
        // $lcia->setBaseLineColor(108, 100, 100);
        // $lcia->setChartLineColor(154, 4, 255);

        $lcia = new LineChartImageAnalyzer('tests/images/graph02.png');
        $lcia->setBaseLineColor(255, 255, 255);
        $lcia->setChartLineColor(255, 165, 0);
        
        $x     = $lcia->baseLineX();
        $y     = $lcia->baseLineY();
        $chart = $lcia->chartLine();

        $maxMochidama = 1236;

        $bottomPoint = $chart->bottomPoint;

        $dedamaPoint = $chart->extractedPoints
            ->reject(function(Point $point) use($bottomPoint) {
                return $point->x < $bottomPoint->x;
            })
            ->sortBy(function(Point $point) {
                return $point->y;
            })
            ->values()
            ->first();

        $pxPerDedama = $maxMochidama / ($bottomPoint->y - $dedamaPoint->y);

        echo sprintf('First : %d', ($y->base - $chart->firstPoint->y) * $pxPerDedama) . PHP_EOL;
        echo sprintf('Bottom: %d', ($y->base - $bottomPoint->y) * $pxPerDedama) . PHP_EOL;
        echo sprintf('Last  : %d', ($y->base - $chart->lastPoint->y) * $pxPerDedama) . PHP_EOL;
        die;
    }

}
