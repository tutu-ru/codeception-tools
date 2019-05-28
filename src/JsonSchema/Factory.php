<?php
/**
 * @author Dima Baldin <baldin@tutu.ru>
 *
 * @description
 */

namespace TutuRu\CodeceptionTools\JsonSchema;

use JsonSchema\Constraints\Factory as FactoryBase;
use TutuRu\CodeceptionTools\JsonSchema\Constraints\TypeConstraint;

class Factory extends FactoryBase
{
    /**
     * @var array
     */
    protected $constraintMap = array(
        'array' => 'JsonSchema\Constraints\CollectionConstraint',
        'collection' => 'JsonSchema\Constraints\CollectionConstraint',
        'object' => 'JsonSchema\Constraints\ObjectConstraint',
        'type' => TypeConstraint::class,
        'undefined' => 'JsonSchema\Constraints\UndefinedConstraint',
        'string' => 'JsonSchema\Constraints\StringConstraint',
        'number' => 'JsonSchema\Constraints\NumberConstraint',
        'enum' => 'JsonSchema\Constraints\EnumConstraint',
        'format' => 'JsonSchema\Constraints\FormatConstraint',
        'schema' => 'JsonSchema\Constraints\SchemaConstraint',
        'validator' => 'JsonSchema\Validator'
    );
}