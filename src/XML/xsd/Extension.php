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
 * Class representing the local version of xs:extension.
 *
 * @package simplesamlphp/xml-xsd
 */
final class Extension extends AbstractExtensionType
{
    /** @var string */
    public const LOCALNAME = 'extension';


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
        $attributeGroup = ReferencedAttributeGroup::getChildrenOfClass($xml);
        $attributes = array_merge($attribute, $attributeGroup);

        $anyAttribute = AnyAttribute::getChildrenOfClass($xml);
        Assert::maxCount($anyAttribute, 1, TooManyElementsException::class);

        return new static(
            self::getAttribute($xml, 'base', QNameValue::class),
            array_pop($particles),
            $attributes,
            array_pop($anyAttribute),
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
