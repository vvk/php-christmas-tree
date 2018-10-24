<?php

/**
* php圣诞树
*/

class tree{

	public $color = [
		'red' => '0;31m',
		'green' => '0;32m',
		'blue' => '0;34m',
		'purple' => '0;35m',
		'yellow' => '1;33m',
	];

	public $charList = ['⁂', '@', '&', '$', '*', '(', ')', '^', '%'];

	public $width = 43;

	public function run()
	{
		if (php_sapi_name() != 'cli') {
			echo "请以命令行模式运行\n";
			exit;
		}

		$this->draw();
	}

	protected function draw()
	{
		$width = $this->width;
		echo "\n";
		for ($i = 1; $i <= $width/2; $i++) {
			$spaceLength = intval($width/2)-$i;
			if ($i == 1) {
				$this->setSpace($spaceLength);
				$this->setChar('*', 'yellow');
				$this->setSpace($spaceLength, true);
			} else {
				$this->setSpace($spaceLength);
				$this->start();
				$this->setTreeBody(($i-1)*2);
				$this->end();
				$this->setSpace($spaceLength, true);
			}
		}
		echo "\n";
		$this->treeBottom($width);
		$this->coryRight();
	}

	protected function setTreeBody($length)
	{
		for($i=0; $i < $length; $i++) {
			$char = $this->getRoundChar();
			$color = $this->getRoundColor();

			$this->setChar($char, $color);
		}
	}

	protected function start()
	{
		$this->setChar('/', 'green');
	}

	protected function end()
	{
		$this->setChar('\\', 'green');
	} 
	protected function treeBottom($length)
	{
		$center = ceil($length/2);
		for ($i = 0; $i < $length; $i++) {
			switch ($i) {
				case $center : 
					$this->setSpace(1);
					break;
				case $center - 1 :
				case $center + 1 :
					$this->setChar('|', 'green');
					break;	
				default:
					$this->setChar('^', 'green');
					break;
			}
		}

		echo "\n";

		for ($n = 0; $n < 2; $n++) {
			$this->setSpace($center-1);
			$this->setChar('|', 'green');
			$this->setSpace(1);
			$this->setChar('|', 'green');
			echo "\n";
		}		

		echo "\n";
	}

	protected function coryRight()
	{
		$coryRight = "Powerd by Sunwq!";
		$length = strlen($coryRight);
		$spaceLength = ceil(($this->width-$length)/2);
		$this->setSpace($spaceLength);
		for ($i = 0; $i < $length; $i++) {
			$color = $this->getRoundColor(); 
			$char = substr($coryRight, $i, 1);
			$this->setChar($char, $color);
		}
		echo "\n\n\n\n";
	}

	/**
	 * 获取随机颜色
	 * @return string
	 */
	protected function getRoundColor()
	{
		$colorLength = count($this->color);
		return array_keys($this->color)[mt_rand(0, $colorLength -1 )];
	}

	/**
	 * 获取随机字符
	 * @param  boolean $empty 是否有空白
	 * @return string
	 */
	protected function getRoundChar($empty = true)
	{
		$charLength = count($this->charList);
		if (mt_rand(1, 5) <= 2 && $empty) {
			$char = ' ';
		} else {
			$char = $this->charList[mt_rand(0, $charLength - 1)];
		}

		return $char;
	}

	/**
	 * 空白
	 * @param integer $length 空白长度
	 * @param boolean $enter  是否有换行
	 */
	protected function setSpace($length, $enter = false)
	{
		if ($length > 0) {
			echo str_repeat(' ', $length).($enter ? "\n" : '');
		}
	}

	/**
	 * 单个字符
	 * @param string $char  字符
	 * @param string $color 颜色
	 */
	protected function setChar($char, $color)
	{
		$color = isset($this->color[$color]) ? $this->color[$color] : $this->color[$this->getRoundColor()];
		echo "\033[{$color}{$char}\x1B[0m";
	}
}



