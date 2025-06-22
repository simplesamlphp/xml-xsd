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
use SimpleSAML\XML\Type\{
    AnyURIValue,
    BooleanValue,
    IDValue,
    NCNameValue,
    NonNegativeIntegerValue,
    PositiveIntegerValue,
    QNameValue,
    StringValue,
};
use SimpleSAML\XML\XsNamespace as NS;
use SimpleSAML\XSD\Type\{NamespaceListValue, ProcessContentsValue, WhiteSpaceValue};
use SimpleSAML\XSD\XML\xsd\AbstractAnnotated;
use SimpleSAML\XSD\XML\xsd\AbstractSimpleRestrictionType;
use SimpleSAML\XSD\XML\xsd\AbstractRestrictionType;
use SimpleSAML\XSD\XML\xsd\AbstractOpenAttrs;
use SimpleSAML\XSD\XML\xsd\AbstractXsdElement;
use SimpleSAML\XSD\XML\xsd\Annotation;
use SimpleSAML\XSD\XML\xsd\AnyAttribute;
use SimpleSAML\XSD\XML\xsd\Appinfo;
use SimpleSAML\XSD\XML\xsd\Attribute;
use SimpleSAML\XSD\XML\xsd\Documentation;
use SimpleSAML\XSD\XML\xsd\Enumeration;
use SimpleSAML\XSD\XML\xsd\FractionDigits;
use SimpleSAML\XSD\XML\xsd\Length;
use SimpleSAML\XSD\XML\xsd\LocalSimpleType;
use SimpleSAML\XSD\XML\xsd\MaxExclusive;
use SimpleSAML\XSD\XML\xsd\MaxInclusive;
use SimpleSAML\XSD\XML\xsd\MaxLength;
use SimpleSAML\XSD\XML\xsd\MinExclusive;
use SimpleSAML\XSD\XML\xsd\MinInclusive;
use SimpleSAML\XSD\XML\xsd\MinLength;
//use SimpleSAML\XSD\XML\xsd\NamespaceEnum;
use SimpleSAML\XSD\XML\xsd\Pattern;
use SimpleSAML\XSD\XML\xsd\ProcessContentsEnum;
use SimpleSAML\XSD\XML\xsd\ReferencedAttributeGroup;
use SimpleSAML\XSD\XML\xsd\Restriction;
use SimpleSAML\XSD\XML\xsd\SimpleRestriction;
use SimpleSAML\XSD\XML\xsd\TotalDigits;
use SimpleSAML\XSD\XML\xsd\WhiteSpace;
use SimpleSAML\XSD\XML\xsd\WhiteSpaceEnum;

use function dirname;
use function strval;

/**
 * Tests for xs:restriction
 *
 * @package simplesamlphp/xml-xsd
 */
#[Group('xs')]
#[CoversClass(SimpleRestriction::class)]
#[CoversClass(AbstractSimpleRestrictionType::class)]
#[CoversClass(AbstractRestrictionType::class)]
#[CoversClass(AbstractAnnotated::class)]
#[CoversClass(AbstractOpenAttrs::class)]
#[CoversClass(AbstractXsdElement::class)]
final class SimpleRestrictionTest extends TestCase
{
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = SimpleRestriction::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/simpleRestriction.xml',
        );
    }


    // test marshalling


    /**
     * Test creating a SimpleRestriction object from scratch.
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

        $restriction = new Restriction(
            null,
            [],
            QNameValue::fromString('{http://www.w3.org/2001/XMLSchema}xsd:nonNegativeInteger'),
        );

        $localSimpleType = new LocalSimpleType(
            $restriction,
            null,
            IDValue::fromString('phpunit_simpleType'),
            [$attr4],
        );

        $facets = [
            new MaxExclusive(
                StringValue::fromString('1024'),
                BooleanValue::fromBoolean(true),
                null,
                IDValue::fromString('phpunit_maxexclusive'),
                [$attr4],
            ),
            new MaxInclusive(
                StringValue::fromString('1024'),
                BooleanValue::fromBoolean(true),
                null,
                IDValue::fromString('phpunit_maxinclusive'),
                [$attr4],
            ),
            new MinExclusive(
                StringValue::fromString('128'),
                BooleanValue::fromBoolean(true),
                null,
                IDValue::fromString('phpunit_minexclusive'),
                [$attr4],
            ),
            new MinInclusive(
                StringValue::fromString('128'),
                BooleanValue::fromBoolean(true),
                null,
                IDValue::fromString('phpunit_mininclusive'),
                [$attr4],
            ),
            new TotalDigits(
                PositiveIntegerValue::fromInteger(2),
                BooleanValue::fromBoolean(true),
                null,
                IDValue::fromString('phpunit_totalDigits'),
                [$attr4],
            ),
            new FractionDigits(
                NonNegativeIntegerValue::fromInteger(2),
                BooleanValue::fromBoolean(true),
                null,
                IDValue::fromString('phpunit_fractionDigits'),
                [$attr4],
            ),
            new Length(
                NonNegativeIntegerValue::fromInteger(512),
                BooleanValue::fromBoolean(true),
                null,
                IDValue::fromString('phpunit_length'),
                [$attr4],
            ),
            new MaxLength(
                NonNegativeIntegerValue::fromInteger(1024),
                BooleanValue::fromBoolean(true),
                null,
                IDValue::fromString('phpunit_maxlength'),
                [$attr4],
            ),
            new MinLength(
                NonNegativeIntegerValue::fromInteger(128),
                BooleanValue::fromBoolean(true),
                null,
                IDValue::fromString('phpunit_minlength'),
                [$attr4],
            ),
            new Enumeration(
                StringValue::fromString('dummy'),
                null,
                IDValue::fromString('phpunit_enumeration'),
                [$attr4],
            ),
            new WhiteSpace(
                WhiteSpaceValue::fromEnum(WhiteSpaceEnum::Collapse),
                BooleanValue::fromBoolean(true),
                null,
                IDValue::fromString('phpunit_whitespace'),
                [$attr4],
            ),
            new Pattern(
                StringValue::fromString('[A-Za-z0-9]'),
                null,
                IDValue::fromString('phpunit_pattern'),
                [$attr4],
            ),
        ];

        $simpleRestriction = new SimpleRestriction(
            QNameValue::fromString('{http://www.w3.org/2001/XMLSchema}xsd:string'),
            $localSimpleType,
            $facets,
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
            IDValue::fromString('phpunit_restriction'),
            [$attr4],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($simpleRestriction),
        );
    }
}
