<?php

namespace ilovephp;

class DiffPage
{
	protected $sections = array();

	public function startSection($details)
	{
		$this->sections[] = new DiffSection($details);
	}

	public function getSections()
	{
		return $this->sections;
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
}
