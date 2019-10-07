<?php declare (strict_types = 1);

namespace Wavevision\PropsControlTests;

use PHPUnit\Framework\TestCase;
use Wavevision\PropsControl\ClassName;

/**
 * @covers \Wavevision\PropsControl\ClassName
 */
class ClassNameTest extends TestCase
{

	public function testBlock(): void
	{
		$className = $this->createClassName('some-class', 'firstModifier');
		$this->assertEquals(
			'some-class some-class--first-modifier some-class--extra-modifier',
			$className->block('extraModifier')
		);
	}

	public function testCreate(): void
	{
		$className = $this->createClassName();
		$sub1 = $className->create('');
		$sub2 = $className->create('', false);
		$this->assertEquals('', $sub2->getBaseClass());
		$this->assertInstanceOf(ClassName::class, $sub1);
		$this->assertInstanceOf(ClassName::class, $sub2);
		$this->assertInstanceOf(ClassName::class, $sub1->setElementDelimiter(''));
		$this->assertInstanceOf(ClassName::class, $sub1->setModifierDelimiter(''));
		$this->assertInstanceOf(ClassName::class, $sub1->setSubBlockDelimiter(''));
	}

	public function testElement(): void
	{
		$className = $this->createClassName('my-class');
		$this->assertEquals('my-class__element', $className->element('element'));
	}

	private function createClassName(string $baseClass = '', string ...$modifiers): ClassName
	{
		return new ClassName(
			$baseClass,
			function () use ($modifiers): array {
				return $modifiers;
			}
		);
	}
}
