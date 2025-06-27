<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

use SimpleSAML\XSD\Type\FormChoiceValue;

/**
 * Trait grouping common functionality for elements that can hold a formChoice attribute.
 *
 * @package simplesamlphp/xml-xsd
 */
trait FormChoiceTrait
{
    /**
     * The formChoice.
     *
     * @var \SimpleSAML\XSD\Type\FormChoiceValue|null
     */
    protected ?FormChoiceValue $formChoice = null;


    /**
     * Collect the value of the formChoice-property
     *
     * @return \SimpleSAML\XSD\Type\FormChoiceValue|null
     */
    public function getFormChoice(): ?FormChoiceValue
    {
        return $this->formChoice;
    }


    /**
     * Set the value of the formChoice-property
     *
     * @param \SimpleSAML\XSD\Type\FormChoiceValue|null $formChoice
     */
    protected function setFormChoice(?FormChoiceValue $formChoice): void
    {
        $this->formChoice = $formChoice;
    }
}
