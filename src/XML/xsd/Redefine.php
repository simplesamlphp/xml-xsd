<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, SchemaViolationException};
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\{AnyURIValue, IDValue};

use function strval;

/**
 * Class representing the redefine-element
 *
 * @package simplesamlphp/xml-xsd
 */
final class Redefine extends AbstractOpenAttrs implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'redefine';

    /**
     * Schema constructor
     *
     * @param \SimpleSAML\XML\Type\AnyURIValue $schemaLocation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XSD\XML\xsd\Annotation|\SimpleSAML\XSD\XML\xsd\RedefinableInterface> $redefineElements
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected AnyURIValue $schemaLocation,
        protected ?IDValue $id = null,
        protected array $redefineElements = [],
        array $namespacedAttributes = [],
    ) {
        Assert::allIsInstanceOfAny(
            $redefineElements,
            [RedefinableInterface::class, Annotation::class],
            SchemaViolationException::class,
        );

        parent::__construct($namespacedAttributes);
    }


    /**
     * Collect the value of the redefineElements-property
     *
     * @return array<\SimpleSAML\XSD\XML\xsd\RedefinableInterface|\SimpleSAML\XSD\XML\xsd\Annotation>
     */
    public function getRedefineElements(): array
    {
        return $this->redefineElements;
    }


    /**
     * Collect the value of the schemaLocation-property
     *
     * @return \SimpleSAML\XML\Type\AnyURIValue
     */
    public function getSchemaLocation(): AnyURIValue
    {
        return $this->schemaLocation;
    }


    /**
     * Collect the value of the id-property
     *
     * @return \SimpleSAML\XML\Type\IDValue|null
     */
    public function getID(): ?IDValue
    {
        return $this->id;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return false;
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

        $allowed = [
            'annotation' => Annotation::class,
            'attributeGroup' => NamedAttributeGroup::class,
            'complexType' => TopLevelComplexType::class,
            'group' => NamedGroup::class,
            'simpleType' => TopLevelSimpleType::class,
        ];

        $redefineElements = [];
        foreach ($xml->childNodes as $node) {
            /** @var \DOMElement $node */
            if ($node instanceof DOMElement) {
                if ($node->namespaceURI === C::NS_XS && array_key_exists($node->localName, $allowed)) {
                    $redefineElements[] = $allowed[$node->localName]::fromXML($node);
                }
            }
        }

        return new static(
            self::getAttribute($xml, 'schemaLocation', AnyURIValue::class),
            self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            $redefineElements,
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this Schema to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this Schema to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);
        $e->setAttribute('schemaLocation', strval($this->getSchemaLocation()));

        if ($this->getId() !== null) {
            $e->setAttribute('id', strval($this->getId()));
        }

        foreach ($this->getRedefineElements() as $elt) {
            $elt->toXML($e);
        }

        return $e;
    }
}
