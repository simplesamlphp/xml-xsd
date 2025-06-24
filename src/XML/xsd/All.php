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
 * Class representing the all-element.
 *
 * @package simplesamlphp/xml-xsd
 */
final class All extends AbstractAll implements
    ParticleInterface,
    SchemaValidatableElementInterface,
    TypeDefParticleInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'all';


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
        $name = self::getOptionalAttribute($xml, 'name', NCNameValue::class, null);
        Assert::null($name, SchemaViolationException::class);

        $ref = self::getOptionalAttribute($xml, 'ref', QNameValue::class, null);
        Assert::null($ref, SchemaViolationException::class);

        // The annotation
        $annotation = Annotation::getChildrenOfClass($xml);
        Assert::maxCount($annotation, 1, TooManyElementsException::class);

        // The content
        $all = All::getChildrenOfClass($xml);
        $choice = Choice::getChildrenOfClass($xml);
        $sequence = Sequence::getChildrenOfClass($xml);

        $particles = array_merge($all, $choice, $sequence);
        Assert::minCount($particles, 1, MissingElementException::class);
        Assert::maxCount($particles, 1, TooManyElementsException::class);

        return new static(
            self::getOptionalAttribute($xml, 'minCount', MinOccursValue::class, null),
            self::getOptionalAttribute($xml, 'maxCount', MaxOccursValue::class, null),
            $particles,
            annotation: array_pop($annotation),
            id: self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            namespacedAttributes: self::getAttributesNSFromXML($xml),
        );
    }
}
