<?php

declare(strict_types=1);

namespace SimpleSAML\Test\XSD;

use DOMDocument;
use DOMElement;
use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SimpleSAML\XSD\XML\xsd\Schema;

use function dirname;

/**
 * Class \SimpleSAML\Test\XSD\SchemaTest
 *
 * @package simplesamlphp\xml-xsd
 */
final class SchemaTest extends TestCase
{
    private int $failure;


    /**
     * @param \DOMElement $schema;
     */
    #[DataProvider('provideSchema')]
    public function testUnmarshalling(DOMElement $schema): void
    {
        $this->failure = 0;

        try {
            Schema::fromXML($schema);
        } catch (Exception $e) {
            $this->failure = 1;
        }

        $this->assertEquals($this->failure, 0, $e->getMessage() . PHP_EOL . $e->getTraceAsString());
    }


    /**
     * @return array
     */
    public static function provideSchema(): array
    {
        $dir = dirname(__FILE__, 2);

        $saml2p = file_get_contents($dir . '/resources/schemas/saml-schema-protocol-2.0.xsd');
        $saml2pdoc = new DOMDocument();
        $saml2pdoc->loadXML($saml2p);

        $soapenv11 = file_get_contents($dir . '/resources/schemas/soap-envelope-1.1.xsd');
        $soapenv11doc = new DOMDocument();
        $soapenv11doc->loadXML($soapenv11);

        return [
            'SOAP Envelope 1.1' => [
                $soapenv11doc->documentElement,
            ],
//            'SAML 2.0 Protocol' => [
//                $saml2pdoc->documentElement,
//            ],
        ];
    }
}
