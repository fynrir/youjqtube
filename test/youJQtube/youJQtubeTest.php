<?php
namespace fynrir\youJQtube;
 

class youJQtubeTest extends \PHPUnit_Framework_TestCase
{



	/**
	 * Test the class construction of youJQtube
	 * With only entering the origin as input (default settings of youJQtube).
	 *
	 * @return void
	 *
	 */
	public function testClassConstructionNoCustom() {
		$origin = "www.example.com";

		$el = new \fynrir\youJQtube\youJQtube($origin);
		
		$object_vars = get_object_vars($el);
		

		$this->assertEquals($object_vars['origin_'], $origin, "origin_ in youJQtube object does not match the origin variable in the test!");

	}

	/**
	 * Test the class construction of youJQtube
	 * With entering all variables origin, youtubeurl and options.
	 *
	 * @return void
	 *
	 */
	public function testClassConstruction() {
		$origin = "www.example.com";
		$youtubeurl = "https://www.youtube.com/watch?v=OzAKZiNwzs0";
		$expectedyoutubeurlid = "OzAKZiNwzs0";
		$options = array(
        	'div_id'      => 'youJStube-Default-ID',
    		'min_height'	=> 400,
    		'min_width'		=> 400,
    		'resize_able'	=> true,
    		'move_able'		=> false,
		);

		$el = new \fynrir\youJQtube\youJQtube($origin, $youtubeurl, $options);
		
		$object_vars = get_object_vars($el);
		

		$this->assertEquals($object_vars['origin_'], $origin, "origin_ in youJQtube object does not match the origin variable in the test!");
		$this->assertEquals($object_vars['youtubeurlid_'], $expectedyoutubeurlid, "youtubeurlid_ in youJQtube object does not match the expectedyoutubeurlid variable in the test!");
		$this->assertEquals($object_vars['options_'], $options, "options_ in youJQtube object does not match the options variable in the test!");

	}

	/**
	 * Test the class construction of youJQtube
	 * With entering all variables, but using a nonexisting ID part of the adress for the youtube clip.
	 *
	 * @expectedException Exception
	 *
	 * @return void
	 *
	 */
	public function testClassConstructionFaultyVideoUrl() {
		$origin = "www.example.com";
		$youtubeurl = "https://www.youtube.com/watch?v=goatsman";
		$expectedyoutubeurlid = "OzAKZiNwzs0";
		$options = array(
        	'div_id'      => 'youJStube-Default-ID',
    		'min_height'	=> 400,
    		'min_width'		=> 400,
    		'resize_able'	=> true,
    		'move_able'		=> false,
		);

		$el = new \fynrir\youJQtube\youJQtube($origin, $youtubeurl, $options);
		
		$object_vars = get_object_vars($el);
		

		$this->assertEquals($object_vars['origin_'], $origin, "origin_ in youJQtube object does not match the origin variable in the test!");
		$this->assertEquals($object_vars['youtubeurlid_'], $expectedyoutubeurlid, "youtubeurlid_ in youJQtube object does not match the expectedyoutubeurlid variable in the test!");
		$this->assertEquals($object_vars['options_'], $options, "options_ in youJQtube object does not match the options variable in the test!");

	}

	/**
	 * Test the class construction of youJQtube
	 * With entering all variables, but not setting a div_id in options.
	 *
	 * @expectedException Exception
	 *
	 * @return void
	 *
	 */
	public function testClassConstructionNoDivID() {
		$origin = "www.example.com";
		$youtubeurl = "https://www.youtube.com/watch?v=goatsman";
		$expectedyoutubeurlid = "OzAKZiNwzs0";
		$options = array(
        	'min_height'	=> 400,
    		'min_width'		=> 400,
    		'resize_able'	=> true,
    		'move_able'		=> false,
		);

		$el2 = new \fynrir\youJQtube\youJQtube($origin, $youtubeurl, $options);
		
		$object_vars = get_object_vars($el2);
		

		$this->assertEquals($object_vars['origin_'], $origin, "origin_ in youJQtube object does not match the origin variable in the test!");
		$this->assertEquals($object_vars['youtubeurlid_'], $expectedyoutubeurlid, "youtubeurlid_ in youJQtube object does not match the expectedyoutubeurlid variable in the test!");
		$this->assertEquals($object_vars['options_'], $options, "options_ in youJQtube object does not match the options variable in the test!");

	}
	/**
	 * Test the create method that creates the object and assigns the parameters from new \fynrir\youJQtube\youJQtube($origin);
	 * to the properties of the class.
	 *
	 * @return void
	 *
	 */
	public function testCreateObject() {
		
		
	}

	public function testgetHTMLmethod() {

	}

	public function testYoutubeURLfail() {

	}


}