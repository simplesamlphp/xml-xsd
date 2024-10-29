<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\Test\XML\xsd;

use DOMText;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SchemaValidationTestTrait;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XML\XsNamespace as NS;
use SimpleSAML\XML\XsProcess;
use SimpleSAML\XSD\XML\xsd\AbstractAnnotated;
use SimpleSAML\XSD\XML\xsd\AbstractOpenAttrs;
use SimpleSAML\XSD\XML\xsd\AbstractWildcard;
use SimpleSAML\XSD\XML\xsd\AbstractXsdElement;
use SimpleSAML\XSD\XML\xsd\Annotation;
use SimpleSAML\XSD\XML\xsd\AnyAttribute;
use SimpleSAML\XSD\XML\xsd\Appinfo;
use SimpleSAML\XSD\XML\xsd\Documentation;

use function dirname;
use function strval;

/**
 * Tests for xsd:anyAttribute
 *
 * @package simplesamlphp/xml-xsd
 */
#[Group('xsd')]
#[CoversClass(AnyAttribute::class)]
#[CoversClass(AbstractWildcard::class)]
#[CoversClass(AbstractAnnotated::class)]
#[CoversClass(AbstractOpenAttrs::class)]
#[CoversClass(AbstractXsdElement::class)]
final class AnyAttributeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = AnyAttribute::class;

        self::$schemaFile = dirname(__FILE__, 4) . '/resources/schemas/XMLSchema.xsd';

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/anyAttribute.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an AnyAttribute object from scratch.
     */
    public function testMarshalling(): void
    {
        $appinfoDocument = DOMDocumentFactory::create();
        $text = new DOMText('Application Information');
        $appinfoDocument->appendChild($text);

        $otherAppinfoDocument = DOMDocumentFactory::create();
        $otherText = new DOMText('Other Application Information');
        $otherAppinfoDocument->appendChild($otherText);

        $documentationDocument = DOMDocumentFactory::create();
        $text = new DOMText('Some Documentation');
        $documentationDocument->appendChild($text);

        $otherDocumentationDocument = DOMDocumentFactory::create();
        $text = new DOMText('Other Documentation');
        $otherDocumentationDocument->appendChild($text);

        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', 'value1');
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', 'value2');
        $attr3 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr3', 'value3');
        $attr4 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr4', 'value4');

        $appinfo1 = new Appinfo($appinfoDocument->childNodes, 'urn:x-simplesamlphp:source', [$attr1]);
        $appinfo2 = new Appinfo($otherAppinfoDocument->childNodes, 'urn:x-simplesamlphp:source', [$attr2]);

        $documentation1 = new Documentation(
            $documentationDocument->childNodes,
            'nl',
            'urn:x-simplesamlphp:source',
            [$attr1],
        );
        $documentation2 = new Documentation(
            $otherDocumentationDocument->childNodes,
            'nl',
            'urn:x-simplesamlphp:source',
            [$attr2],
        );

        $annotation = new Annotation(
            [$appinfo1, $appinfo2],
            [$documentation1, $documentation2],
            'phpunit',
            [$attr3],
        );

        $anyAttribute = new AnyAttribute(NS::ANY, XsProcess::STRICT, $annotation, 'phpunit', [$attr4]);

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($anyAttribute),
        );
    }
}
