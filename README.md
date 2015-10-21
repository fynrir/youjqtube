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
It also requires autoloading.

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
        "fynrir/youjqtube": "dev-master",
    }
}
```

Save this test in your project folder as composer.json.






