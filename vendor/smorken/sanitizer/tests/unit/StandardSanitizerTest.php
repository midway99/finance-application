<?php
/**
 * Created by IntelliJ IDEA.
 * User: scoce95461
 * Date: 3/31/16
 * Time: 9:13 AM
 */

class StandardSanitizerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Smorken\Sanitizer\Sanitizers\Standard
     */
    protected $sut;

    public function setUp()
    {
        parent::setUp();
        $this->sut = new \Smorken\Sanitizer\Sanitizers\Standard();
    }

    public function testSimpleStringWithFullMethod()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->sanitize('string', $test));
    }

    public function testSimpleStringWithConvertedHtmlFullMethod()
    {
        $test = 'foo<script>';
        $this->assertEquals('foo&lt;script&gt;', $this->sut->sanitize('string', $test));
    }

    public function testThrowExceptionOnInvalidSanitizerName()
    {
        $test = 'foo';
        $this->setExpectedException('\Smorken\Sanitizer\SanitizerException');
        $this->sut->sanitize('foo', $test);
    }

    public function testSimpleStringWithCall()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->string($test));
    }

    public function testCallThrowsExceptionOnInvalidSanitizerName()
    {
        $test = 'foo';
        $this->setExpectedException('\Smorken\Sanitizer\SanitizerException');
        $this->sut->foo($test);
    }

    public function testConvertsToCamelCaseWithFullMethod()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->sanitize('alpha_num', $test));
    }

    public function testConvertsToCamelCaseWithCall()
    {
        $test = 'foo';
        $this->assertEquals($test, $this->sut->alpha_num($test));
    }

    public function testIntConvertsNonInt()
    {
        $test = 'f42f<script>';
        $this->assertEquals(42, $this->sut->sanitize('int', $test));
    }

    public function testFloatConvertsNonFloatToZero()
    {
        $test = 'f42f<script>';
        $this->assertEquals(0.0, $this->sut->sanitize('float', $test));
    }

    public function testFloatConvertsPartialFloat()
    {
        $test = '42f<script>';
        $this->assertEquals(42, $this->sut->sanitize('int', $test));
    }

    public function testAlphaNumStripsInvalidChars()
    {
        $test = '_f42f<script>';
        $this->assertEquals('_f42fscript', $this->sut->sanitize('alphaNum', $test));
    }

    public function testAlphaNumDashesStripsInvalidChars()
    {
        $test = '_f42f-<script>';
        $this->assertEquals('_f42f-script', $this->sut->sanitize('alphaNumDashes', $test));
    }

    public function testAlphaStripsInvalidChars()
    {
        $test = '_f42f-<script>';
        $this->assertEquals('_ffscript', $this->sut->sanitize('alpha', $test));
    }

    public function testBoolConvertsToBool()
    {
        $test = 0;
        $this->assertFalse($this->sut->sanitize('bool', $test));
    }

    public function testStripTagsSingleTag()
    {
        $test = '<foo>Bar</foo><script>alert("Hello");</script>';
        $this->assertEquals('<foo>Bar</foo>', $this->sut->sanitize('strip_tags', $test, 'script'));
    }

    public function testStripTagsMultipleTags()
    {
        $test = '<foo>Bar</foo><script>alert("Hello");</script>';
        $this->assertEquals('', $this->sut->sanitize('strip_tags', $test, ['foo', 'script']));
    }
}
