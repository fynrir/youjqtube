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
examples

```
$youjqtube = new \fynrir\youJQtube\youJQtube('www.example.com');
$youjqtube = new \fynrir\youJQtube\youJQtube('www.example.com/index.php');
```
Please provide a full path including the filetype ending. Not just /index

And then do this:
echo $youtube->getHTML();










