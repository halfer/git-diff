<?php

namespace ilovephp;

class DiffPage
{
	const DELETED    = 1;
	const INSERTED   = 2;

	protected $sections = array();
	protected $forceStatus = null;
	protected $enableLineNumbers = true;

	public function parseDiff($diff, $forceStatus = null)
	{
		$inputLines = explode("\n", $diff);

		// Parsing
		foreach ($inputLines as $inputLine)
		{
			$matches = array();
			preg_match('/@@ (.+) @@/', $inputLine, $matches);

			// If we find a block declaration, create one
			if ($matches)
			{
				$this->startSection($matches[1]);
			}
			else
			{
				if ($currentSection = $this->getCurrentSection())
				{
					$currentSection->addLine(
						new DiffLine($inputLine)
					);
				}
			}
		}

		if ($forceStatus)
		{
			$this->forceStatus = $forceStatus;
		}
	}

	protected function startSection($details)
	{
		$this->sections[] = new DiffSection($details);
	}

	public function getSections()
	{
		return $this->sections;
	}

	public function getRender()
	{
		ob_start();
		$this->render();

		return ob_get_clean();
	}

	/**
	 * Renders a whole left-right diff block
	 * 
	 * Note $page and $forceStatus +are+ used, in the included files
	 */
	public function render()	
	{
		$page = $this;
		$forceStatus = $this->forceStatus;

		require $this->getRoot() . '/templates/page.php';
	}

	/**
	 * Renders a line number and diff block for the left or right side
	 * 
	 * Note $side, $page and $isFullWidth +are+ used, in the included files
	 * 
	 * @param string $side Either 'left' or 'right
	 */
	public function renderSide($side)
	{
		$page = $this;
		$isFullWidth = (boolean) $this->forceStatus;

		if ($this->getEnableLineNumbers())
		{
			require $this->getRoot() . '/templates/line-numbers.php';
		}
		require $this->getRoot() . '/templates/diff.php';
	}

	/**
	 * 
	 * @return DiffSection
	 */
	public function getCurrentSection()
	{
		return $this->sections ? $this->sections[count($this->sections) - 1] : null;
	}

	public function getLeftLines()
	{
		$lines = array();
		foreach($this->sections as $section)
		{
			$sectionLines = $section->getLines(array(null, '-'));
			$lines = array_merge($lines, $sectionLines);
		}

		return $lines;		
	}

	public function getRightLines()
	{
		$lines = array();
		foreach($this->sections as $section)
		{
			$sectionLines = $section->getLines(array(null, '+'));
			$lines = array_merge($lines, $sectionLines);
		}

		return $lines;		
	}

	public function getLeftLineNumbers()
	{
		$numbers = array();
		foreach($this->sections as $section)
		{
			/* @var $section DiffSection */
			$sectionNumbers = $section->getLeftLineNumbers();
			$numbers = array_merge($numbers, $sectionNumbers);
		}

		return $numbers;
	}

	public function getRightLineNumbers()
	{
		$numbers = array();
		foreach($this->sections as $section)
		{
			/* @var $section DiffSection */
			$sectionNumbers = $section->getRightLineNumbers();
			$numbers = array_merge($numbers, $sectionNumbers);
		}

		return $numbers;		
	}

	public function setEnableLineNumbers($enableLineNumbers)
	{
		$this->enableLineNumbers = $enableLineNumbers;
	}

	protected function getEnableLineNumbers()
	{
		return $this->enableLineNumbers;
	}

	protected function getRoot()
	{
		return realpath(__DIR__ . '/..');
	}
}
