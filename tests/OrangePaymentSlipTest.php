<?php
/**
 * Swiss Payment Slip
 *
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 * @copyright 2012-2015 Some nice Swiss guys
 * @author Manuel Reinhard <manu@sprain.ch>
 * @author Peter Siska <pesche@gridonic.ch>
 * @author Marc Würth ravage@bluewin.ch
 * @link https://github.com/sprain/class.Einzahlungsschein.php
 */

namespace SwissPaymentSlip\SwissPaymentSlip\Tests;

use SwissPaymentSlip\SwissPaymentSlip\OrangePaymentSlip;
use SwissPaymentSlip\SwissPaymentSlip\OrangePaymentSlipData;

/**
 * Tests for the OrangePaymentSlip class
 *
 * @coversDefaultClass SwissPaymentSlip\SwissPaymentSlip\OrangePaymentSlip
 */
class OrangePaymentSlipTest extends \PHPUnit_Framework_TestCase
{
    /**
     * The object under test
     *
     * @var OrangePaymentSlip
     */
    protected $paymentSlip;

    /**
     * The default attributes to test against
     *
     * @var array
     */
    protected $defaultAttributes;

    /**
     * The set attributes to test against
     *
     * @var array
     */
    protected $setAttributes;

    /**
     * Setup a slip to test and some default and set attributes to test
     *
     * @return void
     */
    protected function setUp()
    {
        $slipData = new OrangePaymentSlipData();
        $this->paymentSlip = new OrangePaymentSlip($slipData);

        $attributes = array();
        $attributes['PosX'] = 0;
        $attributes['PosY'] = 0;
        $attributes['Width'] = 0;
        $attributes['Height'] = 0;
        $attributes['Background'] = 'transparent';
        $attributes['FontFamily'] = 'Helvetica';
        $attributes['FontSize'] = '10';
        $attributes['FontColor'] = '#000';
        $attributes['LineHeight'] = 4;
        $attributes['TextAlign'] = 'L';

        $this->defaultAttributes = $attributes;

        $attributes = array();
        $attributes['PosX'] = 123;
        $attributes['PosY'] = 456;
        $attributes['Width'] = 987;
        $attributes['Height'] = 654;
        $attributes['Background'] = '#123456';
        $attributes['FontFamily'] = 'Courier';
        $attributes['FontSize'] = '1';
        $attributes['FontColor'] = '#654321';
        $attributes['LineHeight'] = '15';
        $attributes['TextAlign'] = 'C';

        $this->setAttributes = $attributes;
    }

    /**
     * Test the constructor method with a null parameter
     *
     * @return void
     * @covers ::__construct
     * @expectedException \PHPUnit_Framework_Error
     * @expectedExceptionMessage Argument 1 passed to SwissPaymentSlip\SwissPaymentSlip\OrangePaymentSlip::__construct() must be an instance of SwissPaymentSlip\SwissPaymentSlip\OrangePaymentSlipData, null given
     */
    public function testNullSlipDataParameter()
    {
        new OrangePaymentSlip(null);
    }

    /**
     * Test the constructor method with a invalid object parameter
     *
     * @return void
     * @covers ::__construct
     * @expectedException \PHPUnit_Framework_Error
     * @expectedExceptionMessage Argument 1 passed to SwissPaymentSlip\SwissPaymentSlip\OrangePaymentSlip::__construct() must be an instance of SwissPaymentSlip\SwissPaymentSlip\OrangePaymentSlipData, instance of ArrayObject given
     */
    public function testInvalidSlipDataParameter()
    {
        if (defined('HHVM_VERSION')) {
            $this->markTestSkipped('This test fails with HHVM');
        }
        new OrangePaymentSlip(new \ArrayObject());
    }

    /**
     * Tests the getPaymentSlipData method
     *
     * @return void
     * @covers ::getPaymentSlipData
     */
    public function testGetPaymentSlipDataIsInstanceOf()
    {
        $this->assertInstanceOf(
            'SwissPaymentSlip\SwissPaymentSlip\OrangePaymentSlipData',
            $this->paymentSlip->getPaymentSlipData()
        );
    }

    /**
     * Tests setting the slip position
     *
     * @return void
     * @covers ::setSlipPosition
     * @covers ::setSlipPosX
     * @covers ::setSlipPosY
     * @covers ::getSlipPosX
     * @covers ::getSlipPosY
     */
    public function testSetSlipPosition()
    {
        $this->paymentSlip->setSlipPosition(200, 100);
        $this->assertEquals(200, $this->paymentSlip->getSlipPosX());
        $this->assertEquals(100, $this->paymentSlip->getSlipPosY());

        $this->paymentSlip->setSlipPosition('A', 150);
        $this->assertEquals(200, $this->paymentSlip->getSlipPosX());
        $this->assertEquals(150, $this->paymentSlip->getSlipPosY());

        $this->paymentSlip->setSlipPosition(225, 'B');
        $this->assertEquals(225, $this->paymentSlip->getSlipPosX());
        $this->assertEquals(150, $this->paymentSlip->getSlipPosY());
    }

    /**
     * Tests setting the slip size
     *
     * @return void
     * @covers ::setSlipSize
     * @covers ::setSlipWidth
     * @covers ::setSlipHeight
     * @covers ::getSlipWidth
     * @covers ::getSlipHeight
     */
    public function testSetSlipSize()
    {
        $this->paymentSlip->setSlipSize(250, 150);
        $this->assertEquals(250, $this->paymentSlip->getSlipWidth());
        $this->assertEquals(150, $this->paymentSlip->getSlipHeight());

        $this->paymentSlip->setSlipSize('A', 175);
        $this->assertEquals(250, $this->paymentSlip->getSlipWidth());
        $this->assertEquals(175, $this->paymentSlip->getSlipHeight());

        $this->paymentSlip->setSlipSize(225, 'B');
        $this->assertEquals(225, $this->paymentSlip->getSlipWidth());
        $this->assertEquals(175, $this->paymentSlip->getSlipHeight());
    }

    /**
     * Tests setting the slip background
     *
     * @return void
     * @covers ::setSlipBackground
     * @covers ::getSlipBackground
     */
    public function testSetSlipBackground()
    {
        $this->paymentSlip->setSlipBackground('#123456');
        $this->assertEquals('#123456', $this->paymentSlip->getSlipBackground());

        $this->paymentSlip->setSlipBackground(__DIR__.'/Resources/img/ezs_orange.gif');
        $this->assertEquals(__DIR__.'/Resources/img/ezs_orange.gif', $this->paymentSlip->getSlipBackground());
    }

    /**
     * Tests the default attributes of the left bank element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testBankLeftAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getBankLeftAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 3;
        $expectedAttributes['PosY'] = 8;
        $expectedAttributes['Width'] = 50;
        $expectedAttributes['Height'] = 4;

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default attributes of the right bank element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testBankRightAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getBankRightAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 66;
        $expectedAttributes['PosY'] = 8;
        $expectedAttributes['Width'] = 50;
        $expectedAttributes['Height'] = 4;

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default attributes of the left recipient element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testRecipientLeftAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getRecipientLeftAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 3;
        $expectedAttributes['PosY'] = 23;
        $expectedAttributes['Width'] = 50;
        $expectedAttributes['Height'] = 4;

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default attributes of the right recipient element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testRecipientRightAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getRecipientRightAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 66;
        $expectedAttributes['PosY'] = 23;
        $expectedAttributes['Width'] = 50;
        $expectedAttributes['Height'] = 4;

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default attributes of the left account element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testAccountLeftAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getAccountLeftAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 27;
        $expectedAttributes['PosY'] = 43;
        $expectedAttributes['Width'] = 30;
        $expectedAttributes['Height'] = 4;

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default attributes of the right account element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testAccountRightAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getAccountRightAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 90;
        $expectedAttributes['PosY'] = 43;
        $expectedAttributes['Width'] = 30;
        $expectedAttributes['Height'] = 4;

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default attributes of the left francs amount element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testAmountFrancsLeftAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getAmountFrancsLeftAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 5;
        $expectedAttributes['PosY'] = 50.5;
        $expectedAttributes['Width'] = 35;
        $expectedAttributes['Height'] = 4;
        $expectedAttributes['TextAlign'] = 'R';

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default attributes of the right francs amount element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testAmountFrancsRightAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getAmountFrancsRightAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 66;
        $expectedAttributes['PosY'] = 50.5;
        $expectedAttributes['Width'] = 35;
        $expectedAttributes['Height'] = 4;
        $expectedAttributes['TextAlign'] = 'R';

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default attributes of the left cents amount element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testAmountCentsLeftAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getAmountCentsLeftAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 50;
        $expectedAttributes['PosY'] = 50.5;
        $expectedAttributes['Width'] = 6;
        $expectedAttributes['Height'] = 4;

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default attributes of the right cents amount element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testAmountCentsRightAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getAmountCentsRightAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 111;
        $expectedAttributes['PosY'] = 50.5;
        $expectedAttributes['Width'] = 6;
        $expectedAttributes['Height'] = 4;

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default attributes of the left reference number element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testReferenceNumberLeftAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getReferenceNumberLeftAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 3;
        $expectedAttributes['PosY'] = 60;
        $expectedAttributes['Width'] = 50;
        $expectedAttributes['Height'] = 4;
        $expectedAttributes['FontSize'] = 8;

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default attributes of the right reference number element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testReferenceNumberRightAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getReferenceNumberRightAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 125;
        $expectedAttributes['PosY'] = 33.5;
        $expectedAttributes['Width'] = 80;
        $expectedAttributes['Height'] = 4;
        $expectedAttributes['TextAlign'] = 'R';

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default attributes of the left payer element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testPayerLeftAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getPayerLeftAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 3;
        $expectedAttributes['PosY'] = 65;
        $expectedAttributes['Width'] = 50;
        $expectedAttributes['Height'] = 4;

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default attributes of the right payer element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testPayerRightAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getPayerRightAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 125;
        $expectedAttributes['PosY'] = 48;
        $expectedAttributes['Width'] = 50;
        $expectedAttributes['Height'] = 4;

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default attributes of the code line element for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testCodeLineAttrDefaultValues()
    {
        $attributes = $this->paymentSlip->getCodeLineAttr();

        $expectedAttributes = $this->defaultAttributes;

        $expectedAttributes['PosX'] = 64;
        $expectedAttributes['PosY'] = 85;
        $expectedAttributes['Width'] = 140;
        $expectedAttributes['Height'] = 4;
        $expectedAttributes['FontFamily'] = 'OCRB10';
        $expectedAttributes['TextAlign'] = 'R';

        $this->assertEquals($expectedAttributes, $attributes);
    }

    /**
     * Tests the default background for an orange slip
     *
     * @return void
     * @covers ::setDefaults
     */
    public function testSlipBackgroundDefaultValues()
    {
        $this->assertEquals('ezs_orange.gif', basename($this->paymentSlip->getSlipBackground()));
    }

    /**
     * Tests the setBankLeftAttr method
     *
     * @return void
     * @covers ::setBankLeftAttr
     * @covers ::setAttributes
     * @covers ::getBankLeftAttr
     */
    public function testSetBankLeftAttr()
    {
        $this->paymentSlip->setBankLeftAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getBankLeftAttr());
    }

    /**
     * Tests the setBankRightAttr method
     *
     * @return void
     * @covers ::setBankRightAttr
     * @covers ::setAttributes
     * @covers ::getBankRightAttr
     */
    public function testSetBankRightAttr()
    {
        $this->paymentSlip->setBankRightAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getBankRightAttr());
    }

    /**
     * Tests the setRecipientLeftAttr method
     *
     * @return void
     * @covers ::setRecipientLeftAttr
     * @covers ::setAttributes
     * @covers ::getRecipientLeftAttr
     */
    public function testSetRecipientLeftAttr()
    {
        $this->paymentSlip->setRecipientLeftAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getRecipientLeftAttr());
    }

    /**
     * Tests the setRecipientRightAttr method
     *
     * @return void
     * @covers ::setRecipientRightAttr
     * @covers ::setAttributes
     * @covers ::getRecipientRightAttr
     */
    public function testSetRecipientRightAttr()
    {
        $this->paymentSlip->setRecipientRightAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getRecipientRightAttr());
    }

    /**
     * Tests the setAccountLeftAttr method
     *
     * @return void
     * @covers ::setAccountLeftAttr
     * @covers ::setAttributes
     * @covers ::getAccountLeftAttr
     */
    public function testSetAccountLeftAttr()
    {
        $this->paymentSlip->setAccountLeftAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getAccountLeftAttr());
    }

    /**
     * Tests the setAccountRightAttr method
     *
     * @return void
     * @covers ::setAccountRightAttr
     * @covers ::setAttributes
     * @covers ::getAccountRightAttr
     */
    public function testSetAccountRightAttr()
    {
        $this->paymentSlip->setAccountRightAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getAccountRightAttr());
    }

    /**
     * Tests the setAmountFrancsLeftAttr method
     *
     * @return void
     * @covers ::setAmountFrancsLeftAttr
     * @covers ::setAttributes
     * @covers ::getAmountFrancsLeftAttr
     */
    public function testSetAmountFrancsLeftAttr()
    {
        $this->paymentSlip->setAmountFrancsLeftAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getAmountFrancsLeftAttr());
    }

    /**
     * Tests the setAmountCentsLeftAttr method
     *
     * @return void
     * @covers ::setAmountCentsLeftAttr
     * @covers ::setAttributes
     * @covers ::getAmountCentsLeftAttr
     */
    public function testSetAmountCentsLeftAttr()
    {
        $this->paymentSlip->setAmountCentsLeftAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getAmountCentsLeftAttr());
    }

    /**
     * Tests the setAmountCentsRightAttr method
     *
     * @return void
     * @covers ::setAmountCentsRightAttr
     * @covers ::setAttributes
     * @covers ::getAmountCentsRightAttr
     */
    public function testSetAmountCentsRightAttr()
    {
        $this->paymentSlip->setAmountCentsRightAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getAmountCentsRightAttr());
    }

    /**
     * Tests the setAmountFrancsRightAttr method
     *
     * @return void
     * @covers ::setAmountFrancsRightAttr
     * @covers ::setAttributes
     * @covers ::getAmountFrancsRightAttr
     */
    public function testSetAmountFrancsRightAttr()
    {
        $this->paymentSlip->setAmountFrancsRightAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getAmountFrancsRightAttr());
    }

    /**
     * Tests the setReferenceNumberLeftAttr method
     *
     * @return void
     * @covers ::setReferenceNumberLeftAttr
     * @covers ::setAttributes
     * @covers ::getReferenceNumberLeftAttr
     */
    public function testSetReferenceNumberLeftAttr()
    {
        $this->paymentSlip->setReferenceNumberLeftAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getReferenceNumberLeftAttr());
    }

    /**
     * Tests the setReferenceNumberRightAttr method
     *
     * @return void
     * @covers ::setReferenceNumberRightAttr
     * @covers ::setAttributes
     * @covers ::getReferenceNumberRightAttr
     */
    public function testSetReferenceNumberRightAttr()
    {
        $this->paymentSlip->setReferenceNumberRightAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getReferenceNumberRightAttr());
    }

    /**
     * Tests the setPayerLeftAttr method
     *
     * @return void
     * @covers ::setPayerLeftAttr
     * @covers ::setAttributes
     * @covers ::getPayerLeftAttr
     */
    public function testSetPayerLeftAttr()
    {
        $this->paymentSlip->setPayerLeftAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getPayerLeftAttr());
    }

    /**
     * Tests the setPayerRightAttr method
     *
     * @return void
     * @covers ::setPayerRightAttr
     * @covers ::setAttributes
     * @covers ::getPayerRightAttr
     */
    public function testSetPayerRightAttr()
    {
        $this->paymentSlip->setPayerRightAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getPayerRightAttr());
    }

    /**
     * Tests the setCodeLineAttr method
     *
     * @return void
     * @covers ::setCodeLineAttr
     * @covers ::setAttributes
     * @covers ::getCodeLineAttr
     */
    public function testSetCodeLineAttr()
    {
        $this->paymentSlip->setCodeLineAttr(123, 456, 987, 654, '#123456', 'Courier', '1', '#654321', '15', 'C');
        $this->assertEquals($this->setAttributes, $this->paymentSlip->getCodeLineAttr());
    }

    /**
     * Tests the setDisplayBank method
     *
     * @return void
     * @covers ::setDisplayBank
     * @covers ::getDisplayBank
     */
    public function testSetDisplayBank()
    {
        $this->paymentSlip->setDisplayBank();
        $this->assertEquals(true, $this->paymentSlip->getDisplayBank());

        $this->paymentSlip->setDisplayBank(true);
        $this->assertEquals(true, $this->paymentSlip->getDisplayBank());

        $this->paymentSlip->setDisplayBank(false);
        $this->assertEquals(false, $this->paymentSlip->getDisplayBank());

        $this->paymentSlip->setDisplayBank('XXX');
    }

    /**
     * Tests the setDisplayAccount method
     *
     * @return void
     * @covers ::setDisplayAccount
     * @covers ::getDisplayAccount
     */
    public function testSetDisplayAccount()
    {
        $this->paymentSlip->setDisplayAccount();
        $this->assertEquals(true, $this->paymentSlip->getDisplayAccount());

        $this->paymentSlip->setDisplayAccount(true);
        $this->assertEquals(true, $this->paymentSlip->getDisplayAccount());

        $this->paymentSlip->setDisplayAccount(false);
        $this->assertEquals(false, $this->paymentSlip->getDisplayAccount());

        $this->paymentSlip->setDisplayAccount('XXX');
    }

    /**
     * Tests the setDisplayRecipient method
     *
     * @return void
     * @covers ::setDisplayRecipient
     * @covers ::getDisplayRecipient
     */
    public function testSetDisplayRecipient()
    {
        $this->paymentSlip->setDisplayRecipient();
        $this->assertEquals(true, $this->paymentSlip->getDisplayRecipient());

        $this->paymentSlip->setDisplayRecipient(true);
        $this->assertEquals(true, $this->paymentSlip->getDisplayRecipient());

        $this->paymentSlip->setDisplayRecipient(false);
        $this->assertEquals(false, $this->paymentSlip->getDisplayRecipient());

        $this->paymentSlip->setDisplayRecipient('XXX');
    }

    /**
     * Tests the setDisplayAmount method
     *
     * @return void
     * @covers ::setDisplayAmount
     * @covers ::getDisplayAmount
     */
    public function testSetDisplayAmount()
    {
        $this->paymentSlip->setDisplayAmount();
        $this->assertEquals(true, $this->paymentSlip->getDisplayAmount());

        $this->paymentSlip->setDisplayAmount(true);
        $this->assertEquals(true, $this->paymentSlip->getDisplayAmount());

        $this->paymentSlip->setDisplayAmount(false);
        $this->assertEquals(false, $this->paymentSlip->getDisplayAmount());

        $this->paymentSlip->setDisplayAmount('XXX');
    }

    /**
     * Tests the setDisplayReferenceNr method
     *
     * @return void
     * @covers ::setDisplayReferenceNr
     * @covers ::getDisplayReferenceNr
     */
    public function testSetDisplayReferenceNr()
    {
        $this->paymentSlip->setDisplayReferenceNr();
        $this->assertEquals(true, $this->paymentSlip->getDisplayReferenceNr());

        $this->paymentSlip->setDisplayReferenceNr(true);
        $this->assertEquals(true, $this->paymentSlip->getDisplayReferenceNr());

        $this->paymentSlip->setDisplayReferenceNr(false);
        $this->assertEquals(false, $this->paymentSlip->getDisplayReferenceNr());

        $this->paymentSlip->setDisplayReferenceNr('XXX');
    }

    /**
     * Tests the setDisplayPayer method
     *
     * @return void
     * @covers ::setDisplayPayer
     * @covers ::getDisplayPayer
     */
    public function testSetDisplayPayer()
    {
        $this->paymentSlip->setDisplayPayer();
        $this->assertEquals(true, $this->paymentSlip->getDisplayPayer());

        $this->paymentSlip->setDisplayPayer(true);
        $this->assertEquals(true, $this->paymentSlip->getDisplayPayer());

        $this->paymentSlip->setDisplayPayer(false);
        $this->assertEquals(false, $this->paymentSlip->getDisplayPayer());

        $this->paymentSlip->setDisplayPayer('XXX');
    }

    /**
     * Tests the setDisplayCodeLine method
     *
     * @return void
     * @covers ::setDisplayCodeLine
     * @covers ::getDisplayCodeLine
     */
    public function testSetDisplayCodeLine()
    {
        $this->paymentSlip->setDisplayCodeLine();
        $this->assertEquals(true, $this->paymentSlip->getDisplayCodeLine());

        $this->paymentSlip->setDisplayCodeLine(true);
        $this->assertEquals(true, $this->paymentSlip->getDisplayCodeLine());

        $this->paymentSlip->setDisplayCodeLine(false);
        $this->assertEquals(false, $this->paymentSlip->getDisplayCodeLine());

        $this->paymentSlip->setDisplayCodeLine('XXX');
    }

    /**
     * Tests the getAllElements method
     *
     * @return void
     * @covers ::getAllElements
     */
    public function testGetAllElements()
    {
        $elements = $this->paymentSlip->getAllElements();

        $expectedElementsArray = array(
        'bankLeft',
        'bankRight',
        'recipientLeft',
        'recipientRight',
        'accountLeft',
        'accountRight',
        'amountFrancsLeft',
        'amountFrancsRight',
        'amountCentsLeft',
        'amountCentsRight',
        'referenceNumberLeft',
        'referenceNumberRight',
        'payerLeft',
        'payerRight',
        'codeLine'
        );

        foreach ($expectedElementsArray as $elementNr => $element) {
            $this->assertArrayHasKey($element, $elements);

            $this->assertArrayHasKey('lines', $elements[$element]);
            $this->assertArrayHasKey('attributes', $elements[$element]);
        }
    }
}
