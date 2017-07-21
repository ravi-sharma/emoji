<?php

# @author Ravi Sharma <me@rvish.com>

# Copyright (c) 2017 Ravi Sharma (http://www.rvish.com)

namespace Rvish\Emoji\Test;
use Rvish\Emoji\Emoji;
use PHPUnit\Framework\TestCase;

class EmojiTest extends TestCase
{
	/** @test */
	public function test_decoded_method()
	{
		$emoji = new Emoji;

		$this->assertSame("Test1 Test2 💡 Test3", $emoji->decode("Test1 Test2 \xf0\x9f\x92\xa1 Test3"));
	}

	/** @test */
	public function test_encoded_method()
	{
		$emoji = new Emoji;

		$this->assertSame($emoji->encode("Test1 Test2 💡 Test3"), $emoji->encode("Test1 Test2 💡 Test3"));
	}
}
