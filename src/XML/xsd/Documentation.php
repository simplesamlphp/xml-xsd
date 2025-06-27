<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use DOMNodeList;
use SimpleSAML\Assert\Assert;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XML\Constants as C;
use SimpleSAML\XML\Exception\InvalidDOMElementException;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\{SchemaValidatableElementInterface, SchemaValidatableElementTrait};
use SimpleSAML\XML\Type\{AnyURIValue, StringValue};
//use SimpleSAML\XSD\XML\xsd\NamespaceEnum;
use SimpleSAML\XML\XsNamespace;

use function strval;

/**
 * Class representing the documentation element
 *
 * @package simplesamlphp/xml-xsd
 */
final class Documentation extends AbstractXsdElement implements SchemaValidatableElementInterface
{
    use ExtendableAttributesTrait;
    use SchemaValidatableElementTrait;

    /** @var string */
    public const LOCALNAME = 'documentation';

    /** The namespace-attribute for the xs:anyAttribute element */
    public const XS_ANY_ATTR_NAMESPACE = XsNamespace::OTHER;
//    public const XS_ANY_ATTR_NAMESPACE = NamespaceEnum::Other;

    /** The exclusions for the xs:anyAttribute element */
    public const XS_ANY_ATTR_EXCLUSIONS = [
        ['http://www.w3.org/XML/1998/namespace', 'lang'],
    ];


    /**
     * Documentation constructor
     *
     * @param \DOMNodeList<\DOMNode> $content
     * @param \SimpleSAML\XML\Attribute|null $lang
     * @param \SimpleSAML\XML\Type\AnyURIValue|null $source
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    final public function __construct(
        protected DOMNodeList $content,
        protected ?XMLAttribute $lang = null,
        protected ?AnyURIValue $source = null,
        array $namespacedAttributes = [],
    ) {
        $this->setAttributesNS($namespacedAttributes);
    }


    /**
     * Get the content property.
     *
     * @return \DOMNodeList<\DOMNode>
     */
    public function getContent(): DOMNodeList
    {
        return $this->content;
    }


    /**
     * Get the lang property.
     *
     * @return \SimpleSAML\XML\Attribute|null
     */
    public function getLang(): ?XMLAttribute
    {
        return $this->lang;
    }


    /**
     * Get the source property.
     *
     * @return \SimpleSAML\XML\Type\AnyURIValue|null
     */
    public function getSource(): ?AnyURIValue
    {
        return $this->source;
    }


    /**
     * Test if an object, at the state it's in, would produce an empty XML-element
     *
     * @return bool
     */
    public function isEmptyElement(): bool
    {
        return $this->getContent()->count() === 0
            && empty($this->getLang())
            && empty($this->getSource())
            && empty($this->getAttributesNS());
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

        $lang = null;
        if ($xml->hasAttributeNS(C::NS_XML, 'lang')) {
            $lang = new XMLAttribute(
                C::NS_XML,
                'xml',
                'lang',
                StringValue::fromString($xml->getAttributeNS(C::NS_XML, 'lang')),
            );
        }

        return new static(
            $xml->childNodes,
            $lang,
            self::getOptionalAttribute($xml, 'source', AnyURIValue::class, null),
            self::getAttributesNSFromXML($xml),
        );
    }


    /**
     * Add this Documentation to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this Documentation to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::instantiateParentElement($parent);

        if ($this->getSource() !== null) {
            $e->setAttribute('source', strval($this->getSource()));
        }

        if ($this->getLang() !== null) {
            $this->getLang()->toXML($e);
        }

        foreach ($this->getAttributesNS() as $attr) {
            $attr->toXML($e);
        }

        foreach ($this->getContent() as $i) {
            $e->appendChild($e->ownerDocument->importNode($i, true));
        }

        return $e;
    }
}
