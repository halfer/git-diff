<?php

namespace ilovephp;

class DiffSection
{
	protected $details;
	// Commit this change separately
	protected $lines = array();

	public function __construct($details)
	{
		$this->details = $details;
	}

	public function addLine(DiffLine $line)
	{
		$line->setSection($this);
		$this->lines[] = $line;
	}

	public function getStartNumber()
	{
		$matches = array();
		preg_match('/-(\d+),(\d+) \+(\d+),(\d+)/', $this->details, $matches);
		if ($matches)
		{
			$startLine = $matches[3];
		}
		else
		{
			// Throw an error here?
			$startLine = null;
		}

		return $startLine;
	}

	public function getLinesForSide($side)
	{
		return ($side === 'left') ? $this->getLeftLines() : $this->getRightLines();
	}

	public function getLeftLines()
	{
		return $this->getLines(array(null, '-'));
	}

	public function getRightLines()
	{
		return $this->getLines(array(null, '+'));
	}

	public function getLines(array $types)
	{
		$lines = array();
		$left = 0;
		$right = 0;
		foreach ($this->lines as $line)
		{
			$type = $line->getType();
			switch ($type)
			{
				case '+':
					$right++; break;
				case '-':
					$left++; break;
				default:
					$left = $right = 0;
			}

			/* @var $line DiffLine */
			if (in_array($type, $types))
			{
				$lines[] = $line;
			}
			else
			{
				// Only add blanks in if they're required (@todo requires more testing)
				if ($right > $left)
				{
					$lines[] = null;
				}
			}
		}

		return $lines;
	}

	public function getLineNumbersForSide($side)
	{
		return ($side === 'left') ? $this->getLeftLineNumbers() : $this->getRightLineNumbers();
	}

	public function getFirstLineNumberForSide($side)
	{
		return reset($this->getLineNumbersForSide($side));
	}

	public function getLeftLineNumbers()
	{
		return $this->getLineNumbers($this->getLeftLines());
	}

	public function getRightLineNumbers()
	{
		return $this->getLineNumbers($this->getRightLines());
	}

	public function getLineNumbers($lines)
	{
		$numbers = array();
		$currentLine = $this->getStartNumber();
		foreach ($lines as $line)
		{
			if ($line)
			{
				$numbers[] = $currentLine;
				$currentLine++;
			}
			else
			{
				$numbers[] = null;
			}
		}

		return $numbers;
	}
}
