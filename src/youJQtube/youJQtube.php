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
                     * The div can be styled further by creating css classes.
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
            }

        $youtubeid = $this->youtube_id_from_url($youtubeurl);
      
        //If the $options array is empty, assign some default values for testing.
        if ($options == '' || $options == null) {
            $options = array(
        'div_id'      => 'youJStube-Default-ID',
            'min_height'	=> 200,
            'min_width'		=> 200,
            'resize_able'	=> true,
            'move_able'		=> true,
        );
        }
    
        //Check if div_id key is null or if it contains nothing. If it happens. Throw exception.
        if (!isset($options['div_id'])) {

            $Message = <<<EOD
NO id key defined in &#36;options array in youJStube, failure to continue execution.<br>
You MUST give &#36;options a div_id key with a string when using the youJStube package.<br>
Please do so in your code. If you belivie this is a error not from your doing.<br>
As in you actually gave it a ID. Fill a bug report and describe what you were doing when it happened.

The key you need to assign to your options array is div_id, give it something unique to seperate it from all other youtube players.
EOD;
            throw new \Exception($Message, 1);
          
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
            throw new \Exception($Message, 1);
        }

        $this->origin_ = $origin;
        $this->youtubeurlid_ = $youtubeid;
        $this->options_ = $options;
        //return $this;
    }
    //If check methods to seperate if checks into parts instead of being part of the getHTML method.
    //==============================================================================================================
    public function CheckIfForSizes() {
    // If checks for width and height to prevent possible errors. Decimals are not okay.
    //If any of them get's caught in the if checks. It will revert them to default values.
        if (!isset($this->options_['min_width'])) {$this->options_['min_width'] = '';}
        if (!is_int($this->options_['min_width']) || !is_numeric($this->options_['min_width'])) {
            $this->options_['min_width'] = 640;
        }
        if (!isset($this->options_['min_height'])) {$this->options_['min_height'] = '';}
        if (!is_int($this->options_['min_height']) || !is_numeric($this->options_['min_height'])) {
            $this->options_['min_height'] = 360;
        }

    } // End of Check for Sizes.
    public function CheckIfForCustomCSS() {
    //Check to see if we got some custom css class names entered into options or not. 
    //If not, peform the default text line in order to be able to use resizeable feature.
        if (empty($this->options_['css_class']) || $this->options_['css_class'] == null) {
        $css_class = "class='youjqtubecontainer ui-resizable-helper'";
    } else 
    {$css_class = "class='".$this->options_['css_class']." youjqtubecontainer ui-resizable-helper'";}
    return $css_class;
    }// End of Check for Custom CSS.
    public function CheckIfForMoveAble() {
    //======================================================================================================================================
    //Draggable default check, and it's other options.
    //======================================================================================================================================
    
    if (isset($this->options_['move_able']) && $this->options_['move_able'] == true) {
      $move_able = ".draggable()";
      $divmovehandicon = "<div class='handgrab'>👋</div>";

    } elseif (isset($this->options_['move_able_container']) && $this->options_['move_able_container'] == true){
      $move_able = <<<EOD
.draggable({
  containment: "parent"
})
EOD;

      $divmovehandicon = "<div class='handgrab'>👋</div>";
    }
    //Vertical movement only.
    elseif (isset($this->options_['move_able_container_y.axis']) && $this->options_['move_able_container_y.axis'] == true){
      $move_able = <<<EOD
.draggable({
  containment: "parent",
  axis: "y"
})
EOD;
      $divmovehandicon = "<div class='handgrab'>👋</div>";
    }
    //Horizontal movement only.
    elseif (isset($this->options_['move_able_container_x.axis']) && $this->options_['move_able_container_x.axis'] == true){
      $move_able = <<<EOD
.draggable({
  containment: "parent",
  axis: "x"
})
EOD;
      $divmovehandicon = "<div class='handgrab'>👋</div>";
    } else {$move_able = ''; $divmovehandicon = '';}

    $Array = array(
      'moveable' => $move_able,
      'moveableicon' => $divmovehandicon,
      );

    return $Array;
    //==============================================================================================================
    }//End of Moveable check method.
    public function CheckIfForResizeable() {
    //======================================================================================================================================
    //Resizeable default check, and it's other options.
    //======================================================================================================================================
    if (isset($this->options_['resize_able']) && $this->options_['resize_able'] == true) {
      $resize_able = <<<'EOD'
.resizable({
helper: "ui-resizable-helper"
})
EOD;
      $divresizearrow = "<div class='arrowresize'>↘</div>";
    } elseif (isset($this->options_['resize_able_container']) && $this->options_['resize_able_container'] == true) {
      $resize_able = <<<'EOD'
.resizable({
containment: "parent",
helper: "ui-resizable-helper"
})
EOD;
      $divresizearrow = "<div class='arrowresize'>↘</div>";
    } else {$resize_able = ''; $divresizearrow= '';}

    $Array = array(
      'resizeable' => $resize_able,
      'resizeableicon' => $divresizearrow,
      );

    return $Array;
    //==============================================================================================================
    }// End of Check Method for Resizeable

    public function getHTML() {
    //==============================================================================================================
    //Default setting for frameborder, Change 0 to 1 if you like the frameborder for some wierd reason (it is ugly).
    $this->options_['frameborder'] = '0';
    //==============================================================================================================
    //What follows now, is getting all the variables from the checks and assigning our other variables to be used in
    //in the creation of the youJQtube player.
    //==============================================================================================================
    //Check size variables. And turn them to default incase user does not provide any sizes.
    $this->CheckIfForSizes();
    //==============================================================================================================
    //Since we already have given the sizes to the class member properties, grab them from there. The 
    //CheckIfForSizes will have made them default incase they were inproperly defined or not defined at all
    $min_width   = $this->options_['min_width'];
    $min_height  = $this->options_['min_height'];
    //Run the method for checking custom css classes. And return the result of the check to be assigned to our
    //$css_class variable in this getHTML method.
    $css_class = $this->CheckIfForCustomCSS();
    $div_id = $this->options_['div_id'];
    //Peform moveable if check using method, and get the array returned with the options that was determined from
    //the Check.
    $MoveAbleArray = $this->CheckIfForMoveAble();
    //Spread out the array to the variables used in the creation of the youJQtube player code.
    $move_able = $MoveAbleArray['moveable'];
    $divmovehandicon = $MoveAbleArray['moveableicon'];
    //Peform resizeable if check using method, and get the array returned with the options that was determined from
    //the Check.
    $ResizeAbleArray = $this->CheckIfForResizeable();
    //Spread out the array to the variables used in the creation of the youJQtube player code.
    $resize_able = $ResizeAbleArray['resizeable'];
    $divresizearrow = $ResizeAbleArray['resizeableicon'];
    //==================================================================================================================================
    //This if check is kept in getHTML as we want to be able to properly decide if we should finish the script or not. We do not want 
    //the script code to be completed incase both features are not used.
    if (!empty($move_able) || !empty($resize_able)) {
        $scriptfinisher = ";";
    } else {$scriptfinisher = "";}
//======================================================================================================================================

    


    	$html_jquery = <<<EOD
<div id='{$div_id}' {$css_class} style='width:{$min_width}px; min-height:{$min_height}px;'>
<iframe id="{$div_id}" type="text/html" height="100%"
src="http://www.youtube.com/embed/{$this->youtubeurlid_}?enablejsapi=1&origin={$this->origin_}&amp;wmode=transparent"
frameborder="{$this->options_['frameborder']}"></iframe>
{$divmovehandicon}
{$divresizearrow}
<div id='{$div_id}button' class='closeplayer'><p>X</p></div>
</div>
<script>
$('#{$div_id}')
    {$move_able}
    {$resize_able}
    {$scriptfinisher}
</script>
<script>
$('#{$div_id}button').click(function() {
  $(this).closest('#{$div_id}').remove();
});
</script>

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
        if (!isset($matches[1])) {
          throw new \Exception("Error Processing YoutubeID, was not found in matches. Faulty Video ID!", 1);
        }
        return $matches[1];

    }
    return false;
}



}