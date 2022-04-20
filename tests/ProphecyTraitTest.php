<?php declare(strict_types=1);

namespace Prophecy\PhpUnit\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\BaseTestRunner;
use Prophecy\PhpUnit\Tests\Fixtures\Error;
use Prophecy\PhpUnit\Tests\Fixtures\MockFailure;
use Prophecy\PhpUnit\Tests\Fixtures\SpyFailure;
use Prophecy\PhpUnit\Tests\Fixtures\Success;

/**
 * @covers \Prophecy\PhpUnit\ProphecyTrait
 */
final class ProphecyTraitTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp()
    {
        // Define the constant because our tests are running PHPUnit test cases themselves
        if (!\defined('PHPUNIT_TESTSUITE')) {
            \define('PHPUNIT_TESTSUITE', true);
        }
    }

    /**
     * @return void
     */
    public function testSuccess()
    {
        $test = new Success('testMethod');

        $result = $test->run();

        $this->assertSame(0, $result->errorCount());
        $this->assertSame(0, $result->failureCount());
        $this->assertCount(1, $result);
        $this->assertSame(1, $test->getNumAssertions());
        $this->assertSame(BaseTestRunner::STATUS_PASSED, $test->getStatus());
    }

    /**
     * @return void
     */
    public function testSpyPredictionFailure()
    {
        $test = new SpyFailure('testMethod');

        $result = $test->run();

        $this->assertSame(0, $result->errorCount());
        $this->assertSame(1, $result->failureCount());
        $this->assertCount(1, $result);
        $this->assertSame(1, $test->getNumAssertions());
        $this->assertSame(BaseTestRunner::STATUS_FAILURE, $test->getStatus());
    }

    /**
     * @return void
     */
    public function testMockPredictionFailure()
    {
        $test = new MockFailure('testMethod');

        $result = $test->run();

        $this->assertSame(0, $result->errorCount());
        $this->assertSame(1, $result->failureCount());
        $this->assertCount(1, $result);
        $this->assertSame(1, $test->getNumAssertions());
        $this->assertSame(BaseTestRunner::STATUS_FAILURE, $test->getStatus());
    }

    /**
     * @return void
     */
    public function testDoublingError()
    {
        $test = new Error('testMethod');

        $result = $test->run();

        $this->assertSame(1, $result->errorCount());
        $this->assertSame(0, $result->failureCount());
        $this->assertCount(1, $result);
        $this->assertSame(0, $test->getNumAssertions());
        $this->assertSame(BaseTestRunner::STATUS_ERROR, $test->getStatus());
    }
}
