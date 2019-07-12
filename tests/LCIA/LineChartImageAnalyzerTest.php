<?php
declare(strict_types=1);

namespace Tests\LCIA;

use PHPUnit\Framework\TestCase;

use LCIA\LineChartImageAnalyzer;
use LCIA\LineChartImageAnalyzer\Point;

class LineChartImageAnalyzerTest extends TestCase
{
    public function testGraph04(): void {
        $lcia = new LineChartImageAnalyzer('tests/images/graph04.png');
        $lcia->setBaseLineColor(255, 255, 255);
        $lcia->setChartLineColor(255, 165, 0);

        $this->assertSame( 81, $lcia->base_y->base);
        $this->assertSame( 80, $lcia->base_x->base);

        $this->assertSame( 81, $lcia->chart_line->first_point->y);
        $this->assertSame(118, $lcia->chart_line->last_point->y);
        
    }
/*
    public function testLoad(): void
    {
        // $lcia = new LineChartImageAnalyzer('tests/images/graph01.png');
        // $lcia->setBaseLineColor(108, 100, 100);
        // $lcia->setChartLineColor(154, 4, 255);

        $lcia = new LineChartImageAnalyzer('tests/images/graph04.png');
        $lcia->setBaseLineColor(255, 255, 255);
        $lcia->setChartLineColor(255, 165, 0);
        
        $x     = $lcia->baseLineX();
        $y     = $lcia->baseLineY();
        $chart = $lcia->chartLine();

        $maxMochidama = 326;

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

        echo sprintf('Base   Y : %d', $y->base) . PHP_EOL;
        echo sprintf('Bottom X : %d', $bottomPoint->x) . PHP_EOL;
        echo sprintf('Bottom Y : %d', $bottomPoint->y) . PHP_EOL;
        echo sprintf('Dedama X : %d', $dedamaPoint->x) . PHP_EOL;
        echo sprintf('Dedama Y : %d', $dedamaPoint->y) . PHP_EOL;
        echo sprintf('Last   Y : %d', $chart->lastPoint->y) . PHP_EOL;
        
            

        $pxPerDedama = $maxMochidama / ($bottomPoint->y - $dedamaPoint->y);
        die;
    }
*/

}
