<?php

namespace ilovephp;

class DiffPage
{
	protected $sections = array();

	public function parseDiff($diff)
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
	 * Note $page +is+ used, in the included files
	 */
	public function render()	
	{
		$page = $this;

		require $this->getRoot() . '/templates/page.php';
	}

	/**
	 * Renders a line number and diff block for the left or right side
	 * 
	 * Note $side and $page +are+ used, in the included files
	 * 
	 * @param string $side Either 'left' or 'right
	 */
	public function renderSide($side)
	{
		$page = $this;

		require $this->getRoot() . '/templates/line-numbers.php';
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

	protected function getRoot()
	{
		return realpath(__DIR__ . '/..');
	}
}
