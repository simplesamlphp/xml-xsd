<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Exception\{InvalidDOMElementException, TooManyElementsException};
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\IDValue;

use function array_merge;

/**
 * Class representing the simpleContent-type.
 *
 * @package simplesamlphp/xml-xsd
 */
final class SimpleContent extends AbstractAnnotated implements SchemaValidatableElementInterface
{
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'simpleContent';


    /**
     * SimpleContent constructor
     *
     * @param \SimpleSAML\XSD\XML\xsd\SimpleRestriction|\SimpleSAML\XSD\XML\xsd\SimpleExtension $content
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        protected SimpleRestriction|SimpleExtension $content,
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        parent::__construct($annotation, $id, $namespacedAttributes);
    }


    /**
     * Collect the value of the content-property
     *
     * @return \SimpleSAML\XSD\XML\xsd\SimpleRestriction|\SimpleSAML\XSD\XML\xsd\SimpleExtension
     */
    public function getContent(): SimpleRestriction|SimpleExtension
    {
        return $this->content;
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
     * Add this SimpleContent to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this SimpleContent to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

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

        $simpleRestriction = SimpleRestriction::getChildrenOfClass($xml);
        Assert::maxCount($simpleRestriction, 1, TooManyElementsException::class);

        $simpleExtension = SimpleExtension::getChildrenOfClass($xml);
        Assert::maxCount($simpleExtension, 1, TooManyElementsException::class);

        $content = array_merge($simpleRestriction, $simpleExtension);
        Assert::maxCount($content, 1, TooManyElementsException::class);

        return new static(
            $content[0],
            array_pop($annotation),
            self::getOptionalAttribute($xml, 'id', IDValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }
}
