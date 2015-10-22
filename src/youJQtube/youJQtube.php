<?php

namespace fynrir\youJQtube;

/**
 * A utility class for creating resizeable Youtube mediaplayers for DIVs using javascript and php.
 * You can also just make it create a normal unmoveable div.
 * You need to add jQuery and jQueryUI to your head section like so:
 *
 * <script type="text/javascript"
 * src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
 * <script type="text/javascript"
 * src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>
 * <link rel="stylesheet" type="text/css"
 * href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css"/>
 * 
 *
 * @package youJQtube
 */

class youJQtube
{

	/**
	 * Properties
	 */

	public $youtubeurlid_; //The extracted ID from the youtube url.
	public $options_; 		//The options.
	public $origin_;       //It's extremly important that you assign $origin_; a proper domain. OR the path to where the player will appear.
                    //If you use fontcontrollers/frameworks etc. Then it should be enough to get the path for the froncontroller.
			 		//Failure to do so can lead to malicious javascript hackers taking control of the youtube media player.
				    //Example: http://example.com or https://example.com or https://example.com/frontcontroller.php
                    //If you have https, USE IT! NO EXCUSES!!!
/**
     * Constructor
     *
     * @param string $youtubeurl the complete URL for a youtube video
     * @param array $options options for the div.
     * 
     * These options are: div_id (string), min_height (int), min_width (int), css_class (string),
     * resize_able (boolean), and move_able (boolean).
     * frameborder is also a possible option. But I suggest leaving it as it is already
     * in the getHTML method near the bottom of this class.
     *
     * Do NOT apply a width and height yourself using CSS. The div will resize itself automatically to what options says.
     * 
     * You must give the div a ID, which is done trough options. Failure to give a ID when you call method leads to
     * a die("NO id key defined in $options array, failure to continue execution"); 
     * 
     * If you call this class without defining anything (URL and options), a default "nature" movie will be displayed to 
     * test if resize and moving works.
     *
     * See the accompanying README.md for Versions, and more details regarding what each method does!
     *
     * Code is released as public domain excluding the youtube iframe implentation and any code google owns.
     * see UNLINCENSE.md, and also read it's exception section so we are clear on what is correct.
     *
     */
    public function __construct($origin, $youtubeurl = '', $options = [])
    {
    	//If the $youtubeurl is empty, assign a default URL for testing this package and it's full extent of
    	//resizeable and moveability.
    	if (empty($youtubeurl)) {
    		$youtubeurl = "https://www.youtube.com/watch?v=mcixldqDIEQ";
    		try {
    		$youtubeid = $this->youtube_id_from_url($youtubeurl);
    	} catch (Exception $e) 
    	{print_r('YoutubeURL convertion FAILED For unknown reasons. File a bug report and what<br> you were doing at the time it happened.');}
    	
    	}
		//If the $options array is empty, assign some default values for testing.
		if (empty($options)) {
			$options = array(
        'div_id'      => 'youJStube-Default-ID',
    		'min_height'	=> 640,
    		'min_width'		=> 360,
    		'resize_able'	=> true,
    		'move_able'		=> true,
		);
		}
        //Check if div_id key is null or if it contains nothing. If it happens. Kill PHP execution.
        if (!array_key_exists('div_id', $options)) {
            $Message = <<<EOD
NO id key defined in &#36;options array in youJStube, failure to continue execution.<br>
You MUST give &#36;options a div_id key with a string when using the youJStube package.<br>
Please do so in your code. If you belivie this is a error not from your doing.<br>
As in you actually gave it a ID. Fill a bug report and describe what you were doing when it happened.

The key you need to assign to your options array is div_id, give it something unique to seperate it from all other youtube players.
EOD;
            die($Message);
        }

		$this->create($youtubeid, $options, $origin);
    }

    public function create($youtubeid, $options, $origin) {

        if (empty($origin)) {
            $Message = <<<EOD
<span style='font-size: 60px; font-color: red;'>Security Alert!</span>
<br><br>This page contains a youJQtube player that has not had a origin set on it!<br>
This is wrong and you need to inform your web administrator of this error immediatly.<br>
Not setting the origin is tantamount to unlocking the door for the house robber<br>
And letting him/her in freely.

For webadministrator: Variable origin not set in class. Did you call the method correctly?
EOD;
            die($Message);
        }

        $this->origin_ = $origin;
    	$this->youtubeurlid_ = $youtubeid;
    	$this->options_ = $options;
        return $this;
    }

    public function getHTML() {

    //All isset checks will be done here. If they are not set. They will be given default values (true for any booleans).
    //==============================================================================================================
    if (!isset($this->options_['min_width'])) {$this->options_['min_width'] = 640;}
    if (!isset($this->options_['min_height'])) {$this->options_['min_height'] = 360;}    
    if (!isset($this->options_['resize_able'])) {$this->options_['resize_able'] = true;}
    if (!isset($this->options_['move_able'])) {$this->options_['move_able'] = true;}
    //==============================================================================================================
    //Default setting for frameborder, Change 0 to 1 if you like the frameborder for some wierd reason (it is ugly).
    $this->options_->frameborder = '0';
    //==============================================================================================================
    // If checks for width and height to prevent possible errors. Decimals are not okay.
    //If any of them get's caught in the if checks. It will revent them to default values.
    if (is_int($this->options_->min_width) == false || !is_numeric($this->options_->min_width)) {
        $this->options_->min_width = 640;
    }
    if (is_int($this->options_->min_height) == false || !is_numeric($this->options_->min_height)) {
        $this->options_->min_height = 360;
    }
    
    //If checks to see if user forgot to set false or true on resize_able and move_able in $options array.
    //If so, revert to default which is true. 
    if ($this->options_->resize_able == null || empty($this->options_->resize_able)) {$this->options_->resize_able = true;}
    if ($this->options_->move_able == null || empty($this->options_->move_able)) {$this->options_->move_able   = true;}
    //==============================================================================================================
    $min_width   = $this->options_->min_width;
    $min_height  = $this->options_->min_height;

    if (empty($this->options_->css_class) || $this->options_->css_class == null) {
        $css_class = '';
    } else 
    {$css_class   = "class='".$this->options_->css_class."'";}
    $div_id = $this->options_->div_id;
    
    if ($this->options_->move_able == true) {$move_able = ".draggable()";}
    if ($this->options_->resize_able == true) {$resize_able = ".resizable()";}
    if (!empty($move_able) || !empty($resize_able)) {
        $scriptfinisher = ";";
    }

    


    	$html_jquery = <<<EOD
<script>
$('#{$div_id}')
    {$move_able}
    {$resize_able}{$scriptfinisher}
</script>
<div id='{$div_id}' {$css_class} style='width:{$min_width}px; height:{$min_height}px'>
<iframe id="player" type="text/html" width="{$min_width}" height="{$min_height}"
src="http://www.youtube.com/embed/{$this->youtubeurlid_}?enablejsapi=1&origin={$this->origin_}"
frameborder="{$this->options_->frameborder}"></iframe>
<div>

EOD;



	return $html_jquery;
    }

    /**
 * get youtube video ID from URL
 * pattern and code borrowed from a stackoverflow post.
 * Hence it is under Creative Commons. http://creativecommons.org/licenses/by-sa/3.0/
 *
 * @param string $url
 * @return string Youtube video id or FALSE if none found. 
 */
public function youtube_id_from_url($url) {
    $pattern = 
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
    $result = preg_match($pattern, $url, $matches);
    if (false !== $result) {
        return $matches[1];
    }
    return false;
}



}