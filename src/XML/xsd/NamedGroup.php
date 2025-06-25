<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\{
    InvalidDOMElementException,
    MissingElementException,
    SchemaViolationException,
    TooManyElementsException,
};
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\{IDValue, NCNameValue, QNameValue};
use SimpleSAML\XSD\Type\{MinOccursValue, MaxOccursValue};

use function array_merge;
use function array_pop;

/**
 * Class representing the group-element.
 *
 * @package simplesamlphp/xml-xsd
 */
final class NamedGroup extends AbstractNamedGroup implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'group';


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

        // Prohibited attributes
        $ref = self::getOptionalAttribute($xml, 'ref', QNameValue::class, null);
        Assert::null($ref, SchemaViolationException::class);

        $minCount = self::getOptionalAttribute($xml, 'minCount', MinOccursValue::class, null);
        Assert::null($minCount, SchemaViolationException::class);

        $maxCount = self::getOptionalAttribute($xml, 'maxCount', MaxOccursValue::class, null);
        Assert::null($maxCount, SchemaViolationException::class);

        $annotation = Annotation::getChildrenOfClass($xml);
        Assert::maxCount($annotation, 1, TooManyElementsException::class);

        $narrowMaxMinElement = NarrowMaxMinElement::getChildrenOfClass($xml);
        Assert::minCount($narrowMaxMinElement, 1, MissingElementException::class);
        Assert::maxCount($narrowMaxMinElement, 1, TooManyElementsException::class);

        return new static(
            array_pop($narrowMaxMinElement),
            name: self::getAttribute($xml, 'name', NCNameValue::class),
            annotation: array_pop($annotation),
            id: self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            namespacedAttributes: self::getAttributesNSFromXML($xml),
        );
    }
}
