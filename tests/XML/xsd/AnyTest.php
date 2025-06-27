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
use SimpleSAML\XML\Type\{AnyURIValue, IDValue, StringValue};
use SimpleSAML\XML\XsNamespace as NS;
use SimpleSAML\XSD\Type\{MaxOccursValue, MinOccursValue, NamespaceListValue, ProcessContentsValue};
use SimpleSAML\XSD\XML\xsd\AbstractAnnotated;
use SimpleSAML\XSD\XML\xsd\AbstractOpenAttrs;
use SimpleSAML\XSD\XML\xsd\AbstractWildcard;
use SimpleSAML\XSD\XML\xsd\AbstractXsdElement;
use SimpleSAML\XSD\XML\xsd\Annotation;
use SimpleSAML\XSD\XML\xsd\Any;
use SimpleSAML\XSD\XML\xsd\Appinfo;
use SimpleSAML\XSD\XML\xsd\Documentation;
use SimpleSAML\XSD\XML\xsd\MaxOccursTrait;
use SimpleSAML\XSD\XML\xsd\MinOccursTrait;
//use SimpleSAML\XSD\XML\xsd\NamespaceEnum;
use SimpleSAML\XSD\XML\xsd\OccursTrait;
use SimpleSAML\XSD\XML\xsd\ProcessContentsEnum;

use function dirname;
use function strval;

/**
 * Tests for xs:any
 *
 * @package simplesamlphp/xml-xsd
 */
#[Group('xs')]
#[CoversClass(Any::class)]
#[CoversClass(AbstractWildcard::class)]
#[CoversClass(AbstractAnnotated::class)]
#[CoversClass(AbstractOpenAttrs::class)]
#[CoversClass(AbstractXsdElement::class)]
#[CoversClass(MinOccursTrait::class)]
#[CoversClass(MaxOccursTrait::class)]
#[CoversClass(OccursTrait::class)]
final class AnyTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Any::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/any.xml',
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

        $any = new Any(
            NamespaceListValue::fromEnum(NS::ANY),
            ProcessContentsValue::fromEnum(ProcessContentsEnum::Strict),
            $annotation,
            IDValue::fromString('phpunit_any'),
            [$attr4],
            MinOccursValue::fromInteger(1),
            MaxOccursValue::fromString('unbounded'),
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($any),
        );
    }


    /**
     * Adding an empty xs:Any element should yield an empty element.
     */
    public function testMarshallingEmptyElement(): void
    {
        $xsns = C::NS_XS;
        $any = new Any();
        $this->assertEquals(
            "<xsd:any xmlns:xsd=\"$xsns\"/>",
            strval($any),
        );
        $this->assertTrue($any->isEmptyElement());
    }
}
