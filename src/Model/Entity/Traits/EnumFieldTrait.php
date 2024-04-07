<?php
declare(strict_types=1);

namespace App\Model\Entity\Traits;

use BackedEnum;

trait EnumFieldTrait
{
    /**
     * Retrieves the enum value for the specified field.
     *
     * @param string $fieldName The name of the field.
     * @return mixed The enum value.
     * @throws \InvalidArgumentException If the field does not exist, is not an enumField, or the enum class does not exist.
     */
    public function enum(string $fieldName): mixed
    {
        if (!$this->has($fieldName)) {
            return null;
        }

        if (!array_key_exists($fieldName, $this->enumFields)) {
            throw new \InvalidArgumentException('Field ' . $fieldName . ' is not an enumField');
        }

        $enumClass = $this->enumFields[$fieldName];

        if (!class_exists($enumClass) && !is_subclass_of($enumClass, BackedEnum::class)) {
            throw new \InvalidArgumentException('Enum class ' . $enumClass . ' does not exist');
        }

        return $enumClass::tryFrom($this->$fieldName);
    }

    /**
     * Get the enum fields of the entity.
     *
     * @return array The enum fields.
     */
    public function enumFields(): array
    {
        return $this->enumFields ?? [];
    }

    /**
     * Magic method to handle dynamic calls for getting enum values.
     *
     * @param string $name The name of the method being called.
     * @param array $arguments The arguments passed to the method.
     * @return mixed The result of the method call.
     */
    public function __call($name, $arguments)
    {
        if (strpos($name, 'enum') === 0) {
            $fieldName = lcfirst(substr($name, 4));
            if (array_key_exists($fieldName, $this->enumFields)) {
                return $this->enum($fieldName);
            }
        }

        return parent::__call($name, $arguments);
    }
}
