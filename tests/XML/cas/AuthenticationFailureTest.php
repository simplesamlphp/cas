<?php

declare(strict_types=1);

namespace SimpleSAML\CAS\Test\CAS\XML\User;

use DOMDocument;
use PHPUnit\Framework\TestCase;
use SimpleSAML\CAS\XML\cas\AuthenticationFailure;
use SimpleSAML\Test\XML\SerializableXMLTestTrait;
use SimpleSAML\XML\DOMDocumentFactory;

use function dirname;
use function strval;

/**
 * Class \SimpleSAML\CAS\XML\cas\AuthenticationFailureTest
 *
 * @covers \SimpleSAML\CAS\XML\cas\AuthenticationFailure
 * @covers \SimpleSAML\CAS\XML\cas\AbstractCasElement
 *
 * @package simplesamlphp/cas
 */
final class AuthenticationFailureTest extends TestCase
{
    use SerializableXMLTestTrait;

    /**
     */
    protected function setUp(): void
    {
        $this->testedClass = AuthenticationFailure::class;

        $this->xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(dirname(dirname(__FILE__))) . '/resources/xml/cas_authenticationFailure.xml'
        );
    }


    /**
     */
    public function testMarshalling(): void
    {
        $authenticationFailure = new AuthenticationFailure(
            'Ticket ST-1856339-aA5Yuvrxzpv8Tau1cYQ7 not recognized',
            'INVALID_TICKET'
        );

        $authenticationFailureElement = $authenticationFailure->toXML();
        $this->assertEquals(
            'Ticket ST-1856339-aA5Yuvrxzpv8Tau1cYQ7 not recognized',
            $authenticationFailureElement->textContent
        );
        $this->assertEquals('INVALID_TICKET', $authenticationFailureElement->getAttribute('code'));

        $this->assertEquals(
            $this->xmlRepresentation->saveXML($this->xmlRepresentation->documentElement),
            strval($authenticationFailure)
        );
    }


    /**
     */
    public function testUnmarshalling(): void
    {
        $authenticationFailure = AuthenticationFailure::fromXML($this->xmlRepresentation->documentElement);

        $this->assertEquals(
            'Ticket ST-1856339-aA5Yuvrxzpv8Tau1cYQ7 not recognized',
            $authenticationFailure->getContent()
        );
        $this->assertEquals('INVALID_TICKET', $authenticationFailure->getCode());
    }
}