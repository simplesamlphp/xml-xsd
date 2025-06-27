<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, SchemaViolationException, TooManyElementsException};
use SimpleSAML\XML\Type\{IDValue, NCNameValue, QNameValue};
use SimpleSAML\XSD\Type\{MaxOccursValue, MinOccursValue};

use function array_merge;
use function array_pop;

/**
 * Class representing the choice-element.
 *
 * @package simplesamlphp/xml-xsd
 */
final class SimpleChoice extends AbstractSimpleExplicitGroup
{
    /** @var string */
    public const LOCALNAME = 'choice';


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

        $minOccurs = self::getOptionalAttribute($xml, 'minOccurs', MinOccursValue::class, null);
        Assert::null($minOccurs, SchemaViolationException::class);

        $maxOccurs = self::getOptionalAttribute($xml, 'maxOccurs', MaxOccursValue::class, null);
        Assert::null($maxOccurs, SchemaViolationException::class);

        // Start here
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
