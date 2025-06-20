<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, TooManyElementsException};
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\{AnyURIValue, IDValue, NCNameValue};

use function strval;

/**
 * Class representing the import-element.
 *
 * @package simplesamlphp/xml-xsd
 */
final class Import extends AbstractAnnotated implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'import';


    /**
     * Import constructor
     *
     * @param \SimpleSAML\XML\Type\AnyURIValue|null $namespace
     * @param \SimpleSAML\XML\Type\AnyURIValue|null $schemaLocation
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected ?AnyURIValue $namespace = null,
        protected ?AnyURIValue $schemaLocation = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($annotation, $id, $namespacedAttributes);
    }


    /**
     * Collect the value of the namespace-property
     *
     * @return \SimpleSAML\XML\Type\AnyURIValue|null
     */
    public function getNamespace(): ?AnyURIValue
    {
        return $this->namespace;
    }


    /**
     * Collect the value of the schemaLocation-property
     *
     * @return \SimpleSAML\XML\Type\AnyURIValue|null
     */
    public function getSchemaLocation(): ?AnyURIValue
    {
        return $this->schemaLocation;
    }


    /**
     * Add this Import to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this import to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getNamespace() !== null) {
            $e->setAttribute('namespace', strval($this->getNamespace()));
        }

        if ($this->getSchemaLocation() !== null) {
            $e->setAttribute('schemaLocation', strval($this->getSchemaLocation()));
        }

        return $e;
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
        Assert::maxCount($annotation, 1, TooManyElementsException::class);

        return new static(
            self::getOptionalAttribute($xml, 'namespace', AnyURIValue::class, null),
            self::getOptionalAttribute($xml, 'schemaLocation', AnyURIValue::class, null),
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
