<?php

declare(strict_types=1);

namespace SimpleSAML\XSD\XML\xsd;

enum DerivationControlEnum: string
{
    case Extension = 'extension';
    case List = 'list';
    case Restriction = 'restriction';
    case Substitution = 'substitution';
    case Union = 'union';
}
