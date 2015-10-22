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
        "fynrir/youjqtube": "dev-master"
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


***Basic Usage***

The quickest way to test and see if the package was installed correctly is this:

In your index.php or similar, place this code somewhere:
```
$youtube = new \fynrir\youJQtube\youJQtube('Your Domain here or path to your index.php or front controller.');
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
Then include the CSS file before the youjqtube class object. Preferably in your header.

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

List of all options and what they do:

**'div_id' => 'String'**

This needs to be set if you intend to use your own $options array.
The script will kill your PHP execution with a vengeance if you don't.

Make the ID unique, don't make two players and use the same ID for them both.
Use a css class instead to style them!

**'min_height' => Whole int number here. No decimals or funny stuff.**

The number of pixels in height the player should start out as.
**Do not put single or double qoute tags around the number!!**














