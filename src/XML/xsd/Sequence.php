<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, SchemaViolationException, TooManyElementsException};
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\{IDValue, NCNameValue, QNameValue};

use function array_merge;
use function array_pop;

/**
 * Class representing the sequence-element.
 *
 * @package simplesamlphp/xml-xsd
 */
final class Sequence extends AbstractExplicitGroup implements
    NestedParticleInterface,
    ParticleInterface,
    SchemaValidatableElementInterface,
    TypeDefParticleInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'sequence';


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

        $annotation = Annotation::getChildrenOfClass($xml);
        Assert::maxCount($annotation, 1, TooManyElementsException::class);

        $all = All::getChildrenOfClass($xml);
        $choice = Choice::getChildrenOfClass($xml);
        $localElement = LocalElement::getChildrenOfClass($xml);
        $referencedGroup = ReferencedGroup::getChildrenOfClass($xml);
        $sequence = Sequence::getChildrenOfClass($xml);

        $particles = array_merge($all, $choice, $localElement, $referencedGroup, $sequence);

        return new static(
            nestedParticles: $particles,
            annotation: array_pop($annotation),
            id: self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            namespacedAttributes: self::getAttributesNSFromXML($xml),
        );
    }
}
