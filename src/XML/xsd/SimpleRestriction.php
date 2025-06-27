<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, TooManyElementsException};
use SimpleSAML\XML\Type\{IDValue, QNameValue};

use function array_merge;
use function array_pop;

/**
 * Class representing the simple version of the xs:restriction.
 *
 * @package simplesamlphp/xml-xsd
 */
final class SimpleRestriction extends AbstractSimpleRestrictionType
{
    /** @var string */
    public const LOCALNAME = 'restriction';


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

        $localAttribute = LocalAttribute::getChildrenOfClass($xml);
        $attributeGroup = ReferencedAttributeGroup::getChildrenOfClass($xml);
        $attributes = array_merge($localAttribute, $attributeGroup);

        $anyAttribute = AnyAttribute::getChildrenOfClass($xml);
        Assert::maxCount($anyAttribute, 1, TooManyElementsException::class);

        $localSimpleType = LocalSimpleType::getChildrenOfClass($xml);
        Assert::maxCount($localSimpleType, 1, TooManyElementsException::class);

        $minExclusive = MinExclusive::getChildrenOfClass($xml);
        $minInclusive = MinInclusive::getChildrenOfClass($xml);
        $maxExclusive = MaxExclusive::getChildrenOfClass($xml);
        $maxInclusive = MaxInclusive::getChildrenOfClass($xml);
        $totalDigits = TotalDigits::getChildrenOfClass($xml);
        $fractionDigits = FractionDigits::getChildrenOfClass($xml);
        $length = Length::getChildrenOfClass($xml);
        $minLength = MinLength::getChildrenOfClass($xml);
        $maxLength = MaxLength::getChildrenOfClass($xml);
        $enumeration = Enumeration::getChildrenOfClass($xml);
        $whiteSpace = WhiteSpace::getChildrenOfClass($xml);
        $pattern = Pattern::getChildrenOfClass($xml);

        $facets = array_merge(
            $maxExclusive,
            $maxInclusive,
            $minExclusive,
            $minInclusive,
            $totalDigits,
            $fractionDigits,
            $length,
            $maxLength,
            $minLength,
            $enumeration,
            $whiteSpace,
            $pattern,
        );

        return new static(
            self::getAttribute($xml, 'base', QNameValue::class),
            array_pop($localSimpleType),
            $facets,
            $attributes,
            array_pop($anyAttribute),
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
