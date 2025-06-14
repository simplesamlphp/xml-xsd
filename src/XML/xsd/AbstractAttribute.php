<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use DOMElement;
use SimpleSAML\XML\Assert\Assert;
use SimpleSAML\XML\Exception\SchemaViolationException;
use SimpleSAML\XML\Type\{BooleanValue, IDValue, NCNameValue, QNameValue};
use SimpleSAML\XSD\Type\{FormChoiceValue, UseValue};

use function strval;

/**
 * Abstract class representing the attribute-type.
 *
 * @package simplesamlphp/xml-xsd
 */
abstract class AbstractAttribute extends AbstractAnnotated
{
    use DefRefTrait;
    use FormChoiceTrait;


    /**
     * Attribute constructor
     *
     * @param \SimpleSAML\XML\Type\NCNameValue $name
     * @param \SimpleSAML\XML\Type\QNameValue $reference
     * @param \SimpleSAML\XML\Type\QNameValue $type
     * @param \SimpleSAML\XSD\Type\UseValue|null $use
     * @param string|null $default
     * @param \SimpleSAML\XML\Type\BooleanValue|null $fixed
     * @param \SimpleSAML\XSD\Type\FormChoiceValue|null $formChoice
     * @param array $simpleType
     * @param \SimpleSAML\XSD\XML\xsd\Annotation|null $annotation
     * @param \SimpleSAML\XML\Type\IDValue|null $id
     * @param array<\SimpleSAML\XML\Attribute> $namespacedAttributes
     */
    public function __construct(
        NCNameValue $name,
        QNameValue $reference,
        protected QNameValue $type,
        protected ?UseValue $use = null,
        protected ?string $default = null,
        protected ?BooleanValue $fixed = null,
        protected ?FormChoiceValue $formChoice = null,
        protected array $simpleType = [],
        ?Annotation $annotation = null,
        ?IDValue $id = null,
        array $namespacedAttributes = [],
    ) {
        Assert::validQName($type, SchemaViolationException::class);

        parent::__construct($annotation, $id, $namespacedAttributes);

        $this->setName($name);
        $this->setReference($reference);
        $this->setFormChoice($formChoice);
    }


    /**
     * Collect the value of the simpleType-property
     *
     * @return array
     */
    public function getSimpleType(): array
    {
        return $this->simpleType;
    }


    /**
     * Collect the value of the type-property
     *
     * @return \SimpleSAML\XML\Type\QNameValue
     */
    public function getType(): QNameValue
    {
        return $this->type;
    }


    /**
     * Collect the value of the use-property
     *
     * @return \SimpleSAML\XSD\Type\UseValue|null
     */
    public function getUse(): ?UseValue
    {
        return $this->use;
    }


    /**
     * Collect the value of the default-property
     *
     * @return string|null
     */
    public function getDefault(): ?string
    {
        return $this->default;
    }


    /**
     * Collect the value of the fixed-property
     *
     * @return \SimpleSAML\XML\Type\BooleanValue|null
     */
    public function getFixed(): ?BooleanValue
    {
        return $this->fixed;
    }


    /**
     * Add this Attribute to an XML element.
     *
     * @param \DOMElement|null $parent The element we should append this facet to.
     * @return \DOMElement
     */
    public function toXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        $e->setAttribute('name', strval($this->getName()));
        $e->setAttribute('reference', strval($this->getReference()));
        $e->setAttribute('type', strval($this->getType()));

        if ($this->getUse() !== null) {
            $e->setAttribute('use', strval($this->getUse()));
        }

        if ($this->getDefault() !== null) {
            $e->setAttribute('default', $this->getDefault());
        }

        if ($this->getFixed() !== null) {
            $e->setAttribute('fixed', strval($this->getFixed()));
        }

        if ($this->getFormChoice() !== null) {
            $e->setAttribute('formChoice', strval($this->getFormChoice()));
        }

        foreach ($this->getSimpleType() as $st) {
            $st->toXML($e);
        }

        return $e;
    }
}
