<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, TooManyElementsException};
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\{BooleanValue, IDValue};

use function array_merge;
use function strval;

/**
 * Class representing the complexContent-type.
 *
 * @package simplesamlphp/xml-xsd
 */
final class ComplexContent extends AbstractAnnotated implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'complexContent';


    /**
     * ComplexContent constructor
     *
     * @param \SimpleSAML\XSD\XML\xsd\ComplexRestriction|\SimpleSAML\XSD\XML\xsd\Extension $content
     * @param \SimpleSAML\XML\Type\BooleanValue|null $mixed
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected ComplexRestriction|Extension $content,
        protected ?BooleanValue $mixed = null,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($annotation, $id, $namespacedAttributes);
    }


    /**
     * Collect the value of the content-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\ComplexRestriction|\SimpleSAML\XSD\XML\xsd\Extension
     */
    public function getContent(): ComplexRestriction|Extension
    {
        return $this->content;
    }


    /**
     * Collect the value of the mixed-property
     *
     * @return \SimpleSAML\XML\Type\BooleanValue|null
     */
    public function getMixed(): ?BooleanValue
    {
        return $this->mixed;
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
     * Add this ComplexContent to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this ComplexContent to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        if ($this->getMixed() !== null) {
            $e->setAttribute('mixed', strval($this->getMixed()));
        }

        $this->getContent()->toXML($e);

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

        $complexRestriction = ComplexRestriction::getChildrenOfClass($xml);
        Assert::maxCount($complexRestriction, 1, TooManyElementsException::class);

        $extension = Extension::getChildrenOfClass($xml);
        Assert::maxCount($extension, 1, TooManyElementsException::class);

        $content = array_merge($complexRestriction, $extension);
        Assert::maxCount($content, 1, TooManyElementsException::class);

        return new static(
            $content[0],
            self::getOptionalAttribute($xml, 'mixed', BooleanValue::class, null),
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
