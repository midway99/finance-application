<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 3/31/16
 * Time: 9:38 AM
 */

use Smorken\Sanitizer\Handler;

class SanitizeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Handler
     */
    protected $sut;

    public function setUp()
    {
        parent::setUp();
        $this->sut = new Handler($this->getOptions());
    }

    public function testExplicitMethodCallsWithSimpleString()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->get('standard')->sanitize('string', $test));
    }

    public function testExplicitMethodCallToAnotherSanitizer()
    {
        $test = 'foo';
        $this->assertEquals('bar', $this->sut->get('mock')->sanitize('fake', $test));
    }

    public function testDefaultMethodCallsWithSimpleString()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->get()->sanitize('string', $test));
    }

    public function testSanitizeMethodWithDefault()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->sanitize('string', $test));
    }

    public function testSanitizeMethodWithAnotherSanitizer()
    {
        $test = 'foo';
        $this->assertEquals('bar', $this->sut->sanitize('fake', $test, 'mock'));
    }

    public function testCallUsesDefaultSanitizer()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->string($test));
    }

    public function testCallWithSpecificSanitizer()
    {
        $test = 'foo';
        $this->assertEquals('bar', $this->sut->fake($test, 'mock'));
    }

    public function testInvalidSanitizerThrowsException()
    {
        $this->setExpectedException('\Smorken\Sanitizer\SanitizerException');
        $this->sut->get('foo');
    }

    public function testGetSanitizerWithInvalidTypeThrowsException()
    {
        $this->setExpectedException('\Smorken\Sanitizer\SanitizerException');
        $this->sut->get('standard')->foo('bar');
    }

    public function testExplicitWithParams()
    {
        $test = 'foo';
        $param = 'bar';
        $this->assertEquals('foobar', $this->sut->get('mock')->sanitize('with_params', $test, $param));
    }

    public function testCallWithParams()
    {
        $test = 'foo';
        $param = 'bar';
        $this->assertEquals('foobar', $this->sut->with_params($test, 'mock', $param));
    }

    protected function getOptions()
    {
        return [
            'default' => 'standard',
            'sanitizers' => [
                'standard' => \Smorken\Sanitizer\Sanitizers\Standard::class,
                'mock' => MockSanitizer::class,
            ],
        ];
    }
}

class MockSanitizer extends \Smorken\Sanitizer\Sanitizers\Base
{
    protected function fake($value)
    {
        return 'bar';
    }

    protected function withParams($value, $param)
    {
        return $value . $param;
    }
}
