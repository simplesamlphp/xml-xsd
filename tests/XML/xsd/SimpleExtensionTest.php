<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\Test\XML\xsd;

use DOMText;
use PHPUnit\Framework\Attributes\{CoversClass, Group};
use PHPUnit\Framework\TestCase;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TestUtils\SerializableElementTestTrait;
use SimpleSAML\XML\Type\{AnyURIValue, IDValue, NCNameValue, QNameValue, StringValue};
use SimpleSAML\XML\XsNamespace as NS;
use SimpleSAML\XSD\Type\{NamespaceListValue, ProcessContentsValue};
use SimpleSAML\XSD\XML\xsd\AbstractAnnotated;
use SimpleSAML\XSD\XML\xsd\AbstractSimpleExtensionType;
use SimpleSAML\XSD\XML\xsd\AbstractExtensionType;
use SimpleSAML\XSD\XML\xsd\AbstractOpenAttrs;
use SimpleSAML\XSD\XML\xsd\AbstractXsdElement;
use SimpleSAML\XSD\XML\xsd\Annotation;
use SimpleSAML\XSD\XML\xsd\AnyAttribute;
use SimpleSAML\XSD\XML\xsd\Appinfo;
use SimpleSAML\XSD\XML\xsd\Attribute;
use SimpleSAML\XSD\XML\xsd\Documentation;
//use SimpleSAML\XSD\XML\xsd\NamespaceEnum;
use SimpleSAML\XSD\XML\xsd\ProcessContentsEnum;
use SimpleSAML\XSD\XML\xsd\ReferencedAttributeGroup;
use SimpleSAML\XSD\XML\xsd\SimpleExtension;

use function dirname;
use function strval;

/**
 * Tests for xs:extension
 *
 * @package simplesamlphp/xml-xsd
 */
#[Group('xs')]
#[CoversClass(SimpleExtension::class)]
#[CoversClass(AbstractSimpleExtensionType::class)]
#[CoversClass(AbstractExtensionType::class)]
#[CoversClass(AbstractAnnotated::class)]
#[CoversClass(AbstractOpenAttrs::class)]
#[CoversClass(AbstractXsdElement::class)]
final class SimpleExtensionTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SimpleExtension::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/simpleExtension.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a SimpleExtension object from scratch.
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

        $anyAttribute = new AnyAttribute(
            NamespaceListValue::fromEnum(NS::ANY),
            ProcessContentsValue::fromEnum(ProcessContentsEnum::Strict),
            null,
            IDValue::fromString('phpunit_anyattribute'),
        );

        $simpleExtension = new SimpleExtension(
            QNameValue::fromString('{http://www.w3.org/2001/XMLSchema}xsd:string'),
            [
                new Attribute(
                    type: QNameValue::fromString('{http://www.w3.org/2001/XMLSchema}xsd:integer'),
                    name: NCNameValue::fromString('phpunit'),
                ),
                new ReferencedAttributeGroup(
                    QNameValue::fromString('{http://www.w3.org/2001/XMLSchema}xsd:defRef'),
                ),
            ],
            $anyAttribute,
            $annotation,
            IDValue::fromString('phpunit_extension'),
            [$attr4],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($simpleExtension),
        );
    }
}
