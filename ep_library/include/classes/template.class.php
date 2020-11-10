<?php

	/*
	* COPYRIGHT 2017 Entice Website Design
	* entice.com.au
	* No unauthorised copying permitted
	*
	*/

function object_to_array($object)
{
	$array = array();
	foreach($object as $property => $value)
	{
		$array[$property] = $value;
	}
	
	return $array;
}

class Template
{
	public $source;
	public $path;
	public $result;
	public $parent;
	
	public function __construct($path=false, $source=false)
	{
		$this->source = ($source === false) ? array() : $source;
		$this->extract($source);
		$this->path($path);
	}
	
	public function __toString()
	{
		return $this->run();
	}
	
	public function extract($source)
	{
		if ($source)
		{
			foreach ($source as $property => $value)
			{
				$this->source[$property] = $value;
			}
		}
	}
	
	public function parent($parent)
	{
		$this->parent = $parent;
	}
	
	public function path($path)
	{
		$this->path = $path;
	}
	
	public function __set($name, $value)
	{
		$this->source[$name] = $value;
	}
	
	public function __get($name)
	{
		return isset($this->source[$name]) ? $this->source[$name] : "";
	}
	
	public function mergeSource()
	{
		if (isset($this->parent))
			return array_merge($this->parent->mergeSource(), $this->source);
		else
			return $this->source;
	}
	
	public function run()
	{
		ob_start();
		extract ($this->mergeSource());
        include $this->path;
        $this->result = ob_get_contents();
        ob_end_clean();
        return $this->result;
	}
}