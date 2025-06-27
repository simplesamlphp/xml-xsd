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
use SimpleSAML\XML\Type\{AnyURIValue, BooleanValue, IDValue, NCNameValue, StringValue, QNameValue};
use SimpleSAML\XML\XsNamespace as NS;
//use SimpleSAML\XSD\XML\xsd\NamespaceEnum;
use SimpleSAML\XSD\Type\{
    BlockSetValue,
    DerivationSetValue,
    FormChoiceValue,
    MaxOccursValue,
    MinOccursValue,
    NamespaceListValue,
    ProcessContentsValue,
    SimpleDerivationSetValue,
};
use SimpleSAML\XSD\XML\xsd\AbstractOpenAttrs;
use SimpleSAML\XSD\XML\xsd\AbstractXsdElement;
use SimpleSAML\XSD\XML\xsd\All;
use SimpleSAML\XSD\XML\xsd\Annotation;
use SimpleSAML\XSD\XML\xsd\AnyAttribute;
use SimpleSAML\XSD\XML\xsd\LocalAttribute;
use SimpleSAML\XSD\XML\xsd\DerivationControlEnum;
use SimpleSAML\XSD\XML\xsd\Documentation;
use SimpleSAML\XSD\XML\xsd\Field;
use SimpleSAML\XSD\XML\xsd\FormChoiceEnum;
use SimpleSAML\XSD\XML\xsd\Keyref;
use SimpleSAML\XSD\XML\xsd\LocalSimpleType;
use SimpleSAML\XSD\XML\xsd\NamedAttributeGroup;
use SimpleSAML\XSD\XML\xsd\NamedGroup;
use SimpleSAML\XSD\XML\xsd\NarrowMaxMinElement;
use SimpleSAML\XSD\XML\xsd\ProcessContentsEnum;
use SimpleSAML\XSD\XML\xsd\Redefine;
use SimpleSAML\XSD\XML\xsd\ReferencedAttributeGroup;
use SimpleSAML\XSD\XML\xsd\ReferencedGroup;
use SimpleSAML\XSD\XML\xsd\Restriction;
use SimpleSAML\XSD\XML\xsd\Selector;
use SimpleSAML\XSD\XML\xsd\TopLevelComplexType;
use SimpleSAML\XSD\XML\xsd\TopLevelSimpleType;
use SimpleSAML\XSD\XML\xsd\XsList;

use function dirname;
use function strval;

/**
 * Tests for xs:redefine
 *
 * @package simplesamlphp/xml-xsd
 */
#[Group('xs')]
#[CoversClass(Redefine::class)]
#[CoversClass(AbstractOpenAttrs::class)]
#[CoversClass(AbstractXsdElement::class)]
final class RedefineTest extends TestCase
{
    use SchemaValidationTestTrait;
    use SerializableElementTestTrait;


    /**
     */
    public static function setUpBeforeClass(): void
    {
        self::$testedClass = Redefine::class;

        self::$xmlRepresentation = DOMDocumentFactory::fromFile(
            dirname(__FILE__, 3) . '/resources/xml/redefine.xml',
        );
    }


    // test marshalling


    /**
     * Test creating an Redefine object from scratch.
     */
    public function testMarshalling(): void
    {
        $simpleTypeDocument = DOMDocumentFactory::create();
        $simpleTypeText = new DOMText('SimpleType');
        $simpleTypeDocument->appendChild($simpleTypeText);

        $complexTypeDocument = DOMDocumentFactory::create();
        $complexTypeText = new DOMText('ComplexType');
        $complexTypeDocument->appendChild($complexTypeText);

        $groupDocument = DOMDocumentFactory::create();
        $groupText = new DOMText('Group');
        $groupDocument->appendChild($groupText);

        $attributeGroupDocument = DOMDocumentFactory::create();
        $attributeGroupText = new DOMText('AttributeGroup');
        $attributeGroupDocument->appendChild($attributeGroupText);

        $attr1 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr1', StringValue::fromString('value1'));
        $attr2 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr2', StringValue::fromString('value2'));
        $attr3 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr3', StringValue::fromString('value3'));
        $attr4 = new XMLAttribute('urn:x-simplesamlphp:namespace', 'ssp', 'attr4', StringValue::fromString('value4'));
        $langattr = new XMLAttribute(C::NS_XML, 'xml', 'lang', StringValue::fromString('nl'));

        $documentation1 = new Documentation(
            $simpleTypeDocument->childNodes,
            $langattr,
            AnyURIValue::fromString('urn:x-simplesamlphp:source'),
            [$attr2],
        );
        $documentation2 = new Documentation(
            $complexTypeDocument->childNodes,
            $langattr,
            AnyURIValue::fromString('urn:x-simplesamlphp:source'),
            [$attr2],
        );
        $documentation3 = new Documentation(
            $groupDocument->childNodes,
            $langattr,
            AnyURIValue::fromString('urn:x-simplesamlphp:source'),
            [$attr2],
        );
        $documentation4 = new Documentation(
            $attributeGroupDocument->childNodes,
            $langattr,
            AnyURIValue::fromString('urn:x-simplesamlphp:source'),
            [$attr2],
        );

        $annotation1 = new Annotation(
            [],
            [$documentation1],
            IDValue::fromString('phpunit_annotation1'),
            [$attr1],
        );

        $annotation2 = new Annotation(
            [],
            [$documentation2],
            IDValue::fromString('phpunit_annotation2'),
            [$attr1],
        );

        $annotation3 = new Annotation(
            [],
            [$documentation3],
            IDValue::fromString('phpunit_annotation3'),
            [$attr1],
        );

        $annotation4 = new Annotation(
            [],
            [$documentation4],
            IDValue::fromString('phpunit_annotation4'),
            [$attr1],
        );

        $restriction = new Restriction(
            null,
            [],
            QNameValue::fromString('{http://www.w3.org/2001/XMLSchema}xsd:nonNegativeInteger'),
        );


        // TopLevelSimpleType
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
            null,
            IDValue::fromString('phpunit_simpleType'),
            [$attr4],
        );

        // TopLevelComplexType
        $anyAttribute1 = new AnyAttribute(
            NamespaceListValue::fromEnum(NS::ANY),
            ProcessContentsValue::fromEnum(ProcessContentsEnum::Strict),
            null,
            IDValue::fromString('phpunit_anyattribute1'),
        );

        $referencedGroup = new ReferencedGroup(
            QNameValue::fromString("{http://www.w3.org/2001/XMLSchema}xsd:nestedParticle"),
            null,
            IDValue::fromString('phpunit_group1'),
            [$attr4],
        );

        $topLevelComplexType = new TopLevelComplexType(
            NCNameValue::fromString('complex'),
            BooleanValue::fromBoolean(true),
            BooleanValue::fromBoolean(false),
            DerivationSetValue::fromEnum(DerivationControlEnum::Restriction),
            DerivationSetValue::fromString('#all'),
            null, // content
            $referencedGroup,
            [
                new LocalAttribute(
                    type: QNameValue::fromString('{http://www.w3.org/2001/XMLSchema}xsd:integer'),
                    name: NCNameValue::fromString('phpunit'),
                ),
                new ReferencedAttributeGroup(
                    QNameValue::fromString('{http://www.w3.org/2001/XMLSchema}xsd:defRef'),
                ),
            ],
            $anyAttribute1,
            null,
            IDValue::fromString('phpunit_complexType'),
            [$attr4],
        );

        // Group
        $selector = new Selector(
            StringValue::fromString('.//annotation'),
            null,
            IDValue::fromString('phpunit_selector'),
            [$attr4],
        );

        $field = new Field(
            StringValue::fromString('@id'),
            null,
            IDValue::fromString('phpunit_field'),
            [$attr4],
        );

        $keyref = new Keyref(
            QNameValue::fromString('{http://www.w3.org/2001/XMLSchema}xsd:integer'),
            NCNameValue::fromString('phpunit_keyref'),
            $selector,
            [$field],
            null,
            IDValue::fromString('phpunit_keyref'),
            [$attr3],
        );

        $narrowMaxMinElement = new NarrowMaxMinElement(
            name: NCNameValue::fromString('phpunit'),
            localType: $localSimpleType,
            identityConstraint: [$keyref],
            type: QNameValue::fromString('{http://www.w3.org/2001/XMLSchema}xsd:group'),
            minOccurs: MinOccursValue::fromInteger(0),
            maxOccurs: MaxOccursValue::fromInteger(1),
            default: StringValue::fromString('1'),
            nillable: BooleanValue::fromBoolean(true),
            block: BlockSetValue::fromString('#all'),
            form: FormChoiceValue::fromEnum(FormChoiceEnum::Qualified),
            annotation: null,
            id: IDValue::fromString('phpunit_localElement'),
            namespacedAttributes: [$attr4],
        );

        $all = new All(null, null, [$narrowMaxMinElement], null, IDValue::fromString('phpunit_all'));

        $namedGroup = new NamedGroup(
            $all,
            NCNameValue::fromString("dulyNoted"),
            null,
            IDValue::fromString('phpunit_group2'),
            [$attr4],
        );

        // AttributeGroup
        $anyAttribute2 = new AnyAttribute(
            NamespaceListValue::fromEnum(NS::ANY),
            ProcessContentsValue::fromEnum(ProcessContentsEnum::Strict),
            null,
            IDValue::fromString('phpunit_anyattribute2'),
        );

        $attributeGroup = new NamedAttributeGroup(
            NCNameValue::fromString("number"),
            [
                new LocalAttribute(
                    type: QNameValue::fromString('{http://www.w3.org/2001/XMLSchema}xsd:integer'),
                    name: NCNameValue::fromString('phpunit'),
                ),
                new ReferencedAttributeGroup(
                    QNameValue::fromString('{http://www.w3.org/2001/XMLSchema}xsd:defRef'),
                ),
            ],
            $anyAttribute2,
            null,
            IDValue::fromString('phpunit_attributeGroup'),
            [$attr4],
        );

        $redefine = new Redefine(
            AnyURIValue::fromString('https://example.org/schema.xsd'),
            IDValue::fromString('phpunit_redefine'),
            [
                $annotation1,
                $topLevelSimpleType,
                $annotation2,
                $topLevelComplexType,
                $annotation3,
                $namedGroup,
                $annotation4,
                $attributeGroup,
            ],
            [$attr3],
        );

        $this->assertEquals(
            self::$xmlRepresentation->saveXML(self::$xmlRepresentation->documentElement),
            strval($redefine),
        );

        $this->assertFalse($redefine->isEmptyElement());
    }
}
