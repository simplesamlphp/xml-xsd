<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\IDValue;
use SimpleSAML\XSD\Type\{MinOccursValue, MaxOccursValue, NamespaceListValue, ProcessContentsValue};

use function array_pop;
use function strval;

/**
 * Class representing the Any element
 *
 * @package simplesamlphp/xml-xsd
 */
final class Any extends AbstractWildcard implements SchemaValidatableElementInterface
{
    use OccursTrait;
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'any';


    /**
     * Wildcard constructor
     *
     * @param \SimpleSAML\XSD\Type\NamespaceListValue|null $namespace
     * @param \SimpleSAML\XSD\Type\ProcessContents|null $processContents
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     * @param \SimpleSAML\XSD\Type\MinOccursValue|null $minOccurs
     * @param \SimpleSAML\XSD\Type\MaxOccursValue|null $maxOccurs
     */
    public function __construct(
        protected ?NamespaceListValue $namespace = null,
        protected ?ProcessContentsValue $processContents = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
        ?MinOccursValue $minOccurs = null,
        ?MaxOccursValue $maxOccurs = null,
    ) {
        parent::__construct($namespace, $processContents, $annotation, $id, $namespacedAttributes);

        $this->setMinOccurs($minOccurs);
        $this->setMaxOccurs($maxOccurs);
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return parent::isEmptyElement() &&
            empty($this->getMinOccurs()) &&
            empty($this->getMaxOccurs());
    }


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

        return new static(
            self::getOptionalAttribute($xml, 'namespace', NamespaceListValue::class, null),
            self::getOptionalAttribute($xml, 'processContents', ProcessContentsValue::class, null),
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            self::getAttributesNSFromXML($xml),
            self::getOptionalAttribute($xml, 'minOccurs', MinOccursValue::class, null),
            self::getOptionalAttribute($xml, 'maxOccurs', MaxOccursvalue::class, null),
        );
    }


    /**
     * Add this Wildcard to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this Wildcard to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getMinOccurs() !== null) {
            $e->setAttribute('minOccurs', strval($this->getMinOccurs()));
        }

        if ($this->getMaxOccurs() !== null) {
            $e->setAttribute('maxOccurs', strval($this->getMaxOccurs()));
        }

        return $e;
    }
}
