<?php

namespace ilovephp;

class DiffSection
{
	protected $details;
	protected $lines;

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
		foreach ($this->lines as $line)
		{
			/* @var $line DiffLine */
			if (in_array($line->getType(), $types))
			{
				$lines[] = $line;
			}
			else
			{
				$lines[] = null;
			}
		}

		return $lines;
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
