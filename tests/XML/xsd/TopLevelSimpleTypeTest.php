<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\Test\XML\xsd;

use DOMText;
use PHPUnit\Framework\Attributes\{CoversClass, Group};
use PHPUnit\Framework\TestCase;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\{SchemaValidationTestTrait, SerializableElementTestTrait};
use SimpleSAML\XML\Type\{AnyURIValue, IDValue, NCNameValue, StringValue, QNameValue};
use SimpleSAML\XSD\Type\SimpleDerivationSetValue;
use SimpleSAML\XSD\XML\xsd\AbstractAnnotated;
use SimpleSAML\XSD\XML\xsd\AbstractTopLevelSimpleType;
use SimpleSAML\XSD\XML\xsd\AbstractOpenAttrs;
use SimpleSAML\XSD\XML\xsd\AbstractSimpleType;
use SimpleSAML\XSD\XML\xsd\AbstractXsdElement;
use SimpleSAML\XSD\XML\xsd\Annotation;
use SimpleSAML\XSD\XML\xsd\Appinfo;
use SimpleSAML\XSD\XML\xsd\Documentation;
use SimpleSAML\XSD\XML\xsd\LocalSimpleType;
use SimpleSAML\XSD\XML\xsd\Restriction;
use SimpleSAML\XSD\XML\xsd\TopLevelSimpleType;
use SimpleSAML\XSD\XML\xsd\XsList;

use function dirname;
use function strval;

/**
 * Tests for xs:simpleType (xs:topLevelSimpleType)
 *
 * @package simplesamlphp/xml-xsd
 */
#[Group('xs')]
#[CoversClass(TopLevelSimpleType::class)]
#[CoversClass(AbstractTopLevelSimpleType::class)]
#[CoversClass(AbstractSimpleType::class)]
#[CoversClass(AbstractAnnotated::class)]
#[CoversClass(AbstractOpenAttrs::class)]
#[CoversClass(AbstractXsdElement::class)]
final class TopLevelSimpleTypeTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = TopLevelSimpleType::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/topLevelSimpleType.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an TopLevelSimpleType object from scratch.
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

        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('value1'));
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('value2'));
        $attr3 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr3', StringValue::fromString('value3'));
        $attr4 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr4', StringValue::fromString('value4'));
        $langattr = new XMLAttribute(C::NS_XML, 'xml', 'lang', StringValue::fromString('nl'));

        $appinfo1 = new Appinfo(
            $appinfoDocument->childNodes,
            AnyURIValue::fromString('urn:x-simplesamlphp:source'),
            [$attr1],
        );
        $appinfo2 = new Appinfo(
            $otherAppinfoDocument->childNodes,
            AnyURIValue::fromString('urn:x-simplesamlphp:source'),
            [$attr2],
        );

        $documentation1 = new Documentation(
            $documentationDocument->childNodes,
            $langattr,
            AnyURIValue::fromString('urn:x-simplesamlphp:source'),
            [$attr1],
        );
        $documentation2 = new Documentation(
            $otherDocumentationDocument->childNodes,
            $langattr,
            AnyURIValue::fromString('urn:x-simplesamlphp:source'),
            [$attr2],
        );

        $annotation = new Annotation(
            [$appinfo1, $appinfo2],
            [$documentation1, $documentation2],
            IDValue::fromString('phpunit_annotation'),
            [$attr3],
        );

        $restriction = new Restriction(
            null,
            [],
            QNameValue::fromString('{http://www.w3.org/2001/XMLSchema}xsd:nonNegativeInteger'),
        );

        $localSimpleType = new LocalSimpleType(
            $restriction,
        );

        $xsList = new XsList(
            $localSimpleType,
            QNameValue::fromString('{http://www.w3.org/2001/XMLSchema}xsd:integer'),
        );

        $topLevelSimpleType = new TopLevelSimpleType(
            $xsList,
            NCNameValue::fromString('phpunit'),
            SimpleDerivationSetValue::fromString('#all'),
            $annotation,
            IDValue::fromString('phpunit_simpleType'),
            [$attr4],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($topLevelSimpleType),
        );

        $this->assertFalse($topLevelSimpleType->isEmptyElement());
    }
}
