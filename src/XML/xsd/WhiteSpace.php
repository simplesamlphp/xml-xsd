<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};

use function array_pop;

/**
 * Class representing the whiteSpace element
 *
 * @package simplesamlphp/xml-xsd
 */
final class WhiteSpace extends AbstractFacet implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'whiteSpace';


    /**
     * WhiteSpace constructor
     *
     * @param string $value
     * @param bool $fixed
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param string|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        string $value,
        ?bool $fixed = false,
        ?Annotation $annotation = null,
        ?string $id = null,
        array $namespacedAttributes = [],
    ) {
        Assert::oneOf($value, ['preserve', 'replace', 'collapse'], SchemaViolationException::class);
        parent::__construct($value, $fixed, $annotation, $id, $namespacedAttributes);
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
            self::getAttribute($xml, 'value'),
            self::getOptionalBooleanAttribute($xml, 'fixed', null),
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
