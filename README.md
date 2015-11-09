# youJQtube

The youJQtube project is a school assignment with the intention to learn some git, how to use github
and how to use packagist and composer to create our own packages for inclusion in "frameworks".

I named it youJQtube as it involves jQuery and youtube.
The name might be a bit misleading. :P

The intention of this particular repo (and it's packagist package) is to provide the ability to create
div's on the webpage that contains a iframe with the Youtube media player implemented.

The two main features of this is it's jQuery part. Which enables you to resize the 
div and in essence the Youtube player in it. And to move the div around on the webpage.

Backup your project folder in the case that everything might crash and burn.

SOFTWARE IS PROVIDED AS-IS, I DO NOT GUARANTEE YOUR PROJECTS SAFETY.
THIS IS THE FIRST TIME I DO THIS OKAY!

***How to install youJQtube***

youJQtube is intended to be used with Packagist and installed with composer.
It also comes with a autoloader. The installation instructions will not be going trough
how to create an autoloader and such. Go read: http://php.net/manual/en/language.oop5.autoload.php
And make a autoloader for your project.

Anax-MVC users should read at the bottom of this README.md in the section "Anax-MVC"!

As such that is the way we will install this package.

1. Ensure that you have composer installed. If you do not, here's how to install it using LinuxMint KDE as an example.
You should note that composer will be installed in your project directory.
If you got several projects and don't wish to install composer several times for each project folder, follow this link and read up
more about installing composer: https://getcomposer.org/doc/00-intro.md#using-composer
2. Move to your framework folder or the folder where you are working on your website. 
3. Run this command while your terminal is in the specified folder (rightclick inside your folder and Actions>Open in Terminal):
```
curl -sS https://getcomposer.org/installer | php
```

You have now installed composer. Now you need a composer.json file with the bare minimum required to get going.
Open a text-editor and paste this text into it:

```
{
    "require": {
        "php": ">=5.4",
        "fynrir/youjqtube": "1.0"
    }
}
```

Save this text in your project folder as composer.json.

By the way, before you continue. https://wutcode.files.wordpress.com/2013/12/31804326.jpg
Can't argue with that!

Before we continue. You really should read this: https://getcomposer.org/doc/01-basic-usage.md

#If you use GIT!!!!

The composer team suggests that you add vendor to your .gitignore
Otherwise all code in the vendor folder will be uploaded too when you push
your projects to wherever you store them.

If you project depends on what's in the vendor folder. I suggest you first read the licenses for the packages
you are using. Then rip out the packages from the vendor folder and move the classes directly to your project.

Don't forget to also provide the licenses for the packages.
And specify which parts of the project is from which package.

#Continuation

Here's the commands for installing the package.

First, validate the composer.json file so it is valid:

```
php composer.phar validate
```

The validation process might spit out a warning or two. But it should not show any errors.
The warnings can be ignored for now.

Then, do this:

```
php composer.phar install --no-dev
```

We tell it --no-dev because we don't want any strange dev settings on.

Now, you need to add this to your head section in the html:
```
<link rel="stylesheet" type="text/css"
href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css"/>
```

And this somewhere on the page. Just make sure it's BEFORE where the player will appear:

```
<script type="text/javascript"
src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript"
src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.js"></script>
```
***Basic Usage***

The quickest way to test and see if the package was installed correctly is this:

In your index.php or similar, place this code somewhere:
```
$youjqtube = new \fynrir\youJQtube\youJQtube('Your Domain here or path to your index.php or front controller.');
```
examples:

```
$youjqtube = new \fynrir\youJQtube\youJQtube('www.example.com');
$youjqtube = new \fynrir\youJQtube\youJQtube('www.example.com/index.php');
```
Please provide a full path including the filetype ending. Not just /index

As I want my package to be as secure as it can be. It absolutely demands you do set a origin.
It's the only constructor parameter that does not have a default value. 
If you do not own the entire domain. I highly recommend pointing the origin
at the page where the player is to be implemented. As you can see in the example 
that was provided earlier for you.

Why? Because not specifying a origin when creating the youtube player can lead to some nasty side effects
like... javascript injections and such. This is a recommendation from google as seen here:
https://developers.google.com/youtube/iframe_api_reference#Loading_a_Video_Player

Quote from the section "Loading a video player" near the end:

> As an extra security measure, you should also include the origin parameter to the URL, specifying the URL scheme 
> (http:// or https://) and full domain of your host page as the parameter value. 
> While origin is optional, including it protects against malicious third-party JavaScript being injected into 
> your page and hijacking control of your YouTube player.

NOTE: If you make use of front controllers. It should be enough to just specify the frontcontroller. 
Like www.example.com/index.php
And not www.example.com/index.php/news
You should not need to specify for every single different route/whatever name your
framework you might use. This is how I have percivied it.
This has not been tested tough to that extent as I do not know how the origin works fully.
Up to you.

When you are done with that and have filled in a valid origin, do this:
echo $youjqtube->getHTML();

You are not done yet. While this will be enough to display the
youtube player on the page. You need to do a couple more things before you can take benefit of the two main features.

in the src folder is a css folder. Grab the CSS file in there and shove it into your projects css folder.
Then link the CSS file before the youjqtube class object. Preferably in your header.

This CSS file is not to be modified unless you know what you are doing. 
You can add css classes yourself to the div that is generated using
$options['css_class'] = "String of classes. Seperate classes with spaces and do not use spaces inside the class name";

Example of css class names:

```
Valid:

blue-color
Bluecolor

Invalid:

blue color
Blue color

Valid string when using self-made css classes:

"blue-color Bluecolor"

Invalid string when using self-made css classes:

"blue-colorBluecolor"
"blue color Bluecolor"
```

Therefor, No spaces inside class names. And when you create a string for 
the $options['css_class'], you want to seperate your class names with 1 space.


###$options###

This is where the majority of your configuring will happen.
The class youJQtube will create it's own default options if you
ethier just create a simple youjqtube variable. Or if you only
specify a youtube url. It will be resizeable and draggable inside the entire
browser by default.

However, you can specify the options yourself! And here's the way on creating
the $options array:

```
$options = array(
'div_id'     	=> 'youJStube-Default-ID',
'min_height' 	=> 360,
'min_width'  	=> 640,
'resize_able'	=> true,
'move_able'  	=> true,
);
```
Note: Do not make it a object. The package is intended to use associative arrays where key=value.
It will crash and burn if you mess it up so you get something like Indexes or type stdClass on the array.

Also, only use one of the resize or moveable options at a time.
If you use resize_able_container, then don't use resize_able.

List of all options and what they do:

> **'div_id' => 'String'**
> 
> This needs to be set if you intend to use your own $options array.
> The script will kill your PHP execution with a vengeance if you don't.
> 
> Make the ID unique, don't make two players and use the same ID for them both.
> Use a css class instead to style them!
> 
> **'min_height' => Whole int number here. No decimals or funny stuff.**
> 
> The number of pixels in height the player should start out as.
> **Do not put single or double qoute tags around the number!!**
> 
> **'min_width' => Whole int number here. No decimals or funny stuff.**
> 
> The number of pixels in height the player should start out as.
> **Do not put single or double qoute tags around the number!!**
> 
> **'css_class' => 'String of class names'**
> 
> If you set this option, you can add more CSS classes to style the div further.
> The string should look like this:
> 
> 'Blue-color FontAwesomeMixer Testclass bananaClass bananamango'
> 
> Spaces denote that another class is coming. So no spaces inside the actual class name!
> Also no spaces at the beginning of the string and at the end!
> 
> **'resize_able'	=> true/false**
> 
> Should the user be able to resize the generated div (and subsequently the youtube player)?
> 
> **'move_able'	=> true/false**
> 
> Should the user be able to move the generated div (and subsequently the youtube player)?
> 
> **'move_able_container'	=> true/false**
> 
> Should the user be able to move the generated div (and subsequently the youtube player)?
> Do note that it will not be able to move outside the size of the parent element.
> 
> **'move_able_container_y.axis'	=> true/false**
> 
> Should the user be able to move the generated div (and subsequently the youtube player)?
> Do note that it will not be able to move outside the size of the parent element.
> It will also not be able to move on the X axis. Only the Y axis.
> 
> **'move_able_container_x.axis'	=> true/false**
> 
> Should the user be able to move the generated div (and subsequently the youtube player)?
> Do note that it will not be able to move outside the size of the parent element.
> It will also not be able to move on the Y axis. Only the X axis.
> 
> **'resize_able_container'	=> true/false**
> 
> Should the user be able to resize the generated div (and subsequently the youtube player)?
> Do note that it will not be able to be resized outside of the parent element.
> **Warning: This option is a bit bugged. And has not been fully tested.**

###Anax-MVC###

Here are specific instructions for users of Anax-MVC, or if you are one of the few 
people who happens to see this package and want to quickly test the package.

Make a folder. Call it something, Like "youJQtubetest".

Open the folder as a terminal, and do: git clone https://github.com/mosbth/Anax-MVC.git

Then. Do the instructions for installing composer up until the composer.json part.
There, you want to just take the line
```
"fynrir/youjqtube": "1.0"
```

And paste it into the require part of the composer.json that came with Anax-MVC.

After that, you want to validate your composer.json file in the fresh anax-mvc install, and then install the package.

After that. Grab the CSS file from the css folder in the package you installed. And put it into
the css folder inside the webroot folder in the Anax-MVC install. After that, you want to copy the hello.php
file from the packages webroot folder and overwrite the hello.php inside the webroot folder of
the Anax-MVC install.

Then, you want the config file too. So go into app/config of the package and grab the file in there. theme.php
Overwrite the one that already exists in the same location in the actual Anax-MVC install.

And at last, you want to go into the theme folder in the package and grab index.tpl.php,
And then go into theme/anax-base of the Anax-MVC install, and overwrite the one
that is already there.



I claim no ownership of Anax-MVC. Read more about Anax-MVC here (google translated link. The accuracy of translation is mediocre:

https://translate.google.com/translate?sl=sv&tl=en&js=y&prev=_t&hl=en&ie=UTF-8&u=http%3A%2F%2Fdbwebb.se%2Fkunskap%2Fanax-som-mvc-ramverk&edit-text=&act=url


Versions:

Version 1.0
Complete release of intended features.


To do:
I don't know. Not sure if I will be updating this package. Considering this has probably been done better, and several times already.

Had passed the Travis building using PHPUnit command line:




![Passed the Travis Build! Yay!](https://travis-ci.org/fynrir/youjqtube.svg?branch=master)
















