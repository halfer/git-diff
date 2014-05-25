<?php

namespace ilovephp;

class DiffLine
{
	protected $lineText;
	protected $section;

	public function __construct($lineText)
	{
		$this->lineText = $lineText;
	}

	public function setSection(DiffSection $section)
	{
		$this->section = $section;
	}

	public function getSection()
	{
		return $this->section;
	}

	public function getText()
	{
		return substr($this->lineText, 1);
	}

	public function getType()
	{
		$type = substr($this->lineText, 0, 1);
		switch ($type)
		{
			case '-':
			case '+':
				return $type;
			default:
				return null;
		}
	}

	public function getTypeName()
	{
		switch ($this->getType())
		{
			case '-':
				return 'diff-line-deleted';
			case '+':
				return 'diff-line-added';
			default:
				return '';
		}
	}
}
