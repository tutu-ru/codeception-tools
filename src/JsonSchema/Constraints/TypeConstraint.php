<?php
/**
 * @author Dima Baldin <baldin@tutu.ru>
 *
 * @description
 */

namespace TutuRu\CodeceptionTools\JsonSchema\Constraints;

use JsonSchema\Constraints\TypeConstraint as TypeConstraintBase;
use JsonSchema\Entity\JsonPointer;

class TypeConstraint extends TypeConstraintBase
{
    /**
     * {@inheritdoc}
     */
    public function check(&$value = null, $schema = null, JsonPointer $path = null, $i = null)
    {
        $type = isset($schema->type) ? $schema->type : null;
        $isValid = false;
        $wording = array();

        if (isset($schema->nullable) && $schema->nullable) {
            if (!is_array($type)) {
                $type = [$type];
            }

            $type[] = "null";
        }

        if (is_array($type)) {
            $this->validateTypesArray($value, $type, $wording, $isValid, $path);
        } elseif (is_object($type)) {
            $this->checkUndefined($value, $type, $path);

            return;
        } else {
            $isValid = $this->validateType($value, $type);
        }

        if ($isValid === false) {
            if (!is_array($type)) {
                $this->validateTypeNameWording($type);
                $wording[] = self::$wording[$type];
            }
            $this->addError($path, ucwords(gettype($value)) . ' value found, but ' .
                $this->implodeWith($wording, ', ', 'or') . ' is required', 'type');
        }
    }
}