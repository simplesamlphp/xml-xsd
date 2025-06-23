<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, TooManyElementsException};
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\{BooleanValue, IDValue, NCNameValue};
use SimpleSAML\XSD\Type\DerivationSetValue;

use function array_merge;
use function array_pop;

/**
 * Class representing the xs:complexType element.
 *
 * @package simplesamlphp/xml-xsd
 */
final class ComplexType extends AbstractTopLevelComplexType implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'complexType';


    /**
     * Create an instance of this object from its XML representation.
     *
     * @param \DOMElement $xml
     * @return static
     *
     * @throws \SimpleSAML\XML\Exception\InvalidDOMElementException
     *   if the qualified name of the supplied element is wrong
     */
    public static function fromXML(DOMElement $xml): static
    {
        Assert::same($xml->localName, static::getLocalName(), InvalidDOMElementException::class);
        Assert::same($xml->namespaceURI, static::NS, InvalidDOMElementException::class);

        $annotation = Annotation::getChildrenOfClass($xml);
        Assert::maxCount($annotation, 1, TooManyElementsException::class);

        $simpleContent = SimpleContent::getChildrenOfClass($xml);
        Assert::maxCount($simpleContent, 1, TooManyElementsException::class);

        $complexContent = ComplexContent::getChildrenOfClass($xml);
        Assert::maxCount($complexContent, 1, TooManyElementsException::class);

        $content = array_merge($simpleContent, $complexContent);
        Assert::maxCount($content, 1, TooManyElementsException::class);

        $referencedGroup = ReferencedGroup::getChildrenOfClass($xml);
        Assert::maxCount($referencedGroup, 1, TooManyElementsException::class);

        $all = All::getChildrenOfClass($xml);
        Assert::maxCount($all, 1, TooManyElementsException::class);

        $choice = Choice::getChildrenOfClass($xml);
        Assert::maxCount($choice, 1, TooManyElementsException::class);

        $sequence = Sequence::getChildrenOfClass($xml);
        Assert::maxCount($sequence, 1, TooManyElementsException::class);

        $particles = array_merge($referencedGroup, $all, $choice, $sequence);
        Assert::maxCount($particles, 1, TooManyElementsException::class);

        $attribute = Attribute::getChildrenOfClass($xml);
        $referencedAttributeGroup = ReferencedAttributeGroup::getChildrenOfClass($xml);
        $attributes = array_merge($attribute, $referencedAttributeGroup);

        $anyAttribute = AnyAttribute::getChildrenOfClass($xml);
        Assert::maxCount($anyAttribute, 1, TooManyElementsException::class);

        return new static(
            self::getAttribute($xml, 'name', NCNameValue::class),
            self::getOptionalAttribute($xml, 'mixed', BooleanValue::class, null),
            self::getOptionalAttribute($xml, 'abstract', BooleanValue::class, null),
            self::getOptionalAttribute($xml, 'final', DerivationSetValue::class, null),
            self::getOptionalAttribute($xml, 'block', DerivationSetValue::class, null),
            array_pop($content),
            array_pop($particles),
            $attributes,
            array_pop($anyAttribute),
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
