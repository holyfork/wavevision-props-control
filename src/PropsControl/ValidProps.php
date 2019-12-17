<?php declare (strict_types = 1);

namespace Wavevision\PropsControl;

use stdClass;
use Wavevision\PropsControl\Exceptions\NotAllowed;

final class ValidProps extends stdClass
{

	private ?Props $props;

	/**
	 * @var mixed[]
	 */
	private array $values;

	/**
	 * @param mixed[] $values
	 */
	public function __construct(array $values)
	{
		$this->values = $values;
	}

	/**
	 * @param mixed[] $arguments
	 */
	public function __call(string $method, array $arguments): void
	{
		throw new NotAllowed("Cannot call an undefined method '$method'.");
	}

	/**
	 * @param mixed[] $arguments
	 */
	public static function __callStatic(string $method, array $arguments): void
	{
		throw new NotAllowed("Cannot call an undefined static method '$method'.");
	}

	/**
	 * @return mixed
	 */
	public function &__get(string $name)
	{
		if (!$this->isSet($name)) {
			throw new NotAllowed("Cannot read an undeclared prop '$name'.");
		}
		return $this->values[$name];
	}

	/**
	 * @param mixed $value
	 */
	public function __set(string $name, $value): void
	{
		if ($this->isSet($name)) {
			throw new NotAllowed("Cannot write to a read-only prop '$name'.");
		}
		throw new NotAllowed("Cannot write to an undeclared prop '$name'.");
	}

	public function __isset(string $name): bool
	{
		return $this->isSet($name);
	}

	public function __unset(string $name): void
	{
		throw new NotAllowed("Cannot unset prop '$name', props are read-only.");
	}

	/**
	 * @return mixed
	 */
	public function get(string $prop)
	{
		return $this->values[$prop];
	}

	/**
	 * @param mixed $default
	 * @return mixed
	 */
	public function getNullable(string $prop, $default = null)
	{
		return $this->isSet($prop) ? $this->get($prop) : $default;
	}

	public function isSet(string $prop): bool
	{
		return array_key_exists($prop, $this->values);
	}

	public function getProps(): ?Props
	{
		return $this->props;
	}

	public function setProps(Props $props): self
	{
		$this->props = $props;
		return $this;
	}

}
