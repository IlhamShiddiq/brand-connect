<?php

namespace Tests\Unit;

use App\Helpers\OutletHelper;
use PHPUnit\Framework\TestCase;

class OutletHelperTest extends TestCase
{
    /**
     * Test convert outlet distance helper function
     *
     * @return void
     */
    public function testConvertOutletDistance(): void
    {
        $distance = 10.988888;
        $resultExpected = '10.9 km';

        $result = OutletHelper::convertOutletDistance($distance);

        $this->assertTrue($result === $resultExpected);
    }

    /**
     * Test convert outlet distance helper function (whole number distance)
     *
     * @return void
     */
    public function testConvertOutletDistanceWholeNumber(): void
    {
        $distance = 10.0;
        $resultExpected = '10 km';

        $result = OutletHelper::convertOutletDistance($distance);

        $this->assertTrue($result === $resultExpected);
    }

    /**
     * Test convert outlet distance helper function (zero number distance)
     *
     * @return void
     */
    public function testConvertOutletDistanceZeroNumber(): void
    {
        $distance = 0.0;
        $resultExpected = '0 km';

        $result = OutletHelper::convertOutletDistance($distance);

        $this->assertTrue($result === $resultExpected);
    }
}
