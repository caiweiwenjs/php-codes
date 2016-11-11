<?php
	class InterpreterContext {
		private $expressionStore = array();

		public function replace(Expression $expression, $value) {
			$this->expressionStore[$expression->getKey()] = $value;
		}

		public function lookup(Expression $expression) {
			return $this->expressionStore[$expression->getKey()];
		}
	}

	abstract class Expression {
		private static $keyCount = 0;
		private $key;

		public abstract function interpret(InterpreterContext $context);

		public function getKey() {
			if (!isset($this->key)) {
				self::$keyCount++;
				$this->key = self::$keyCount;
			}
			return $this->key;
		}
	}

	class LiteralExpression extends Expression {
		private $value;

		public function __construct($value) {
			$this->value = $value;
		}

		public function interpret(InterpreterContext $context) {
			$context->replace($this, $this->value);
		}
	}

	class VariableExpression extends Expression {
		private $name;
		private $value;

		public function __construct($name, $value = null) {
			$this->name = $name;
			$this->value = $value;
		}

		public function interpret(InterpreterContext $context) {
			if (!is_null($this->value)) {
				$context->replace($this, $this->value);
				$this->value = null;
			}
		}

		public function setValue($value) {
			$this->value = $value;
		}

		public function getKey() {
			return $this->name;
		}
	}

	abstract class OperatorExpression extends Expression {
		protected $l_op;
		protected $r_op;

		public function __construct(Expression $l_op, Expression $r_op) {
			$this->l_op = $l_op;
			$this->r_op = $r_op;
		}

		public function interpret(InterpreterContext $context) {
			$this->l_op->interpret($context);
			$this->r_op->interpret($context);
			$result_l = $context->lookup($this->l_op);
			$result_r = $context->lookup($this->r_op);
			$this->doInterpret($context, $result_l, $result_r);
		}
		
		protected abstract function doInterpret(InterpreterContext $context, $result_l, $result_r);	
	}

	class BooleanOrExpression extends OperatorExpression {
		protected function doInterpret(InterpreterContext $context, $result_l, $result_r) {
			$context->replace($this, $result_l || $result_r);
		}
	}

	class BooleanAndExpression extends OperatorExpression {
		protected function doInterpret(InterpreterContext $context, $result_l, $result_r) {
			$context->replace($this, $result_l && $result_r);
		}
	}

	class EqualsExpression extends OperatorExpression {
		protected function doInterpret(InterpreterContext $context, $result_l, $result_r) {
			$context->replace($this, $result_l == $result_r);
		}
	}

	//test
	$context = new InterpreterContext();
	$literal = new LiteralExpression('four');
	$literal->interpret($context);
	print $context->lookup($literal)."<br/>";

	$myvar = new VariableExpression('input', 'five');
	$myvar->interpret($context);
	print $myvar->getKey() . " = " . $context->lookup($myvar) . "<br/>";

	$newvar = new VariableExpression('input');
	$newvar->interpret($context);
	print $newvar->getKey() . " = " . $context->lookup($newvar) . "<br/>";

	$myvar->setValue("six");
	$myvar->interpret($context);
	print $myvar->getKey() . " = " . $context->lookup($myvar) . "<br/>";
	print $newvar->getKey() . " = " . $context->lookup($newvar) . "<br/>";

	$input = new VariableExpression('input2');
	$statement = new BooleanOrExpression(
			new EqualsExpression( $input, new LiteralExpression('four')),
			new EqualsExpression( $input, new literalExpression('4')));
	foreach (array("four", "4", "52") as $val) {
		$input->setValue($val);
		print $input->getKey() . " = " . "$val:";
		$statement->interpret($context);
		if ($context->lookup($statement)) {
			print "true.<br/>";
		} else {
			print "false.<br/>";
		}
	}
?>
