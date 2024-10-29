<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

enum FormChoiceEnum: string
{
    case Qualified = 'qualified';
    case Unqualified = 'unqualified';
}
