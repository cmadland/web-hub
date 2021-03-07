# How to get Started with Typhoon

## Turn off "Start Here" Notice

To disable the getting started notice, simply edit your `user/config/themes/typhoon.yaml` in the `Notices` tab, and **remove** or **unpublish** this example notice.

## Configuration Instructions

To find out how to configure Typhoon Theme, check out the [Typhoon Theme Documenation](https://getgrav.org/premium/typhoon/docs?target=_blank) on the GetGrav.org site.

## Theme Modification

### Create a Custom Theme from Typhoon

It is strongly advised to create a new theme based on Typhoon if you want to make any modifications to the Twig templates, CSS etc.  Typhoon makes a fantastic base theme to build your custom theme on top of because it has already been built responsively, and with a powerful navigation system.  These are the most complex and time-consuming aspects of building any theme.

To create your new custom theme, simply install the `devtools` plugin for Grav.  Then from the CLI run the command:

```shell script
bin/plugin devtools newtheme
```

This will then ask you for some information about your new theme.  When it asks you how to create the new theme select **Copy**, then choose **Typhoon** as the theme to copy.  Of course this means you must have Typhoon already installed in your Grav installation.  This will then create a copy of Typhoon but with your new theme name.  From this point forward, make all your changes in the new theme.

### Modify the CSS

While Typhoon is highly customizable, you will undoubtedly want to make your own tweaks and modifications to the design of the theme. Some of this is done via CSS which is powered by the [TailwindCSS](https://tailwindcss.com/) framework. You will need to familiarize yourself with this framework, but have no fear, it's very well documented and has an active and supportive community.

#### Installing NPM to Compile CSS

99% of everything you need to make modifications is actually already available in Tailwind's utility classes, and you can apply these directly in your Twig templates, or even directly in your content using HTML or shortcodes.

Depending on your platform, installing NPM is different. So please follow the official [NPM Installation Instructions](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm?target=_blank) to accomplish this. After you have NPM installed you will first need to install the required packages, you can do this by just typing `npm install` in the root of the typhoon theme:

! Replace `typhoon` with your custom theme name if you have already created a custom theme from Typhoon.

 ```shell script
cd user/themes/typhoon
npm install
```

In case you ever want to upgrade the packages (such as to use the latest version of TailwindCSS) run this:

```shell script
npm update
```

#### Developing Custom CSS

There are times when you need to step beyond the TailwindCSS-provided utility classes and use your own custom CSS.  This is most likely to occur when you have no ability to change the output and include the required classes.  For these situations, or when you want to make modifications to the core `tailwind.config.js` file or add your own custom css, you need to recompile the development `build/css/site.css` file.  The best way to do this is to run in a dynamic 'watch' mode that automatically recompiles when a change is detected:

```shell script
npm run watch
```

If you want to do a quick compile that does not watch, simply use:

```shell
npm run build
```

The custom modifications should be put in the `css/custom/` folder.  If you create a new file you should reference that in the top level `css/site.css` file to ensure it gets picked up and compiled. Best practices for developing custom Tailwind CSS dictates that you should try to use the existing Tailwind classes via the `@apply` directive as much as possible to ensure global configuration trickles down to your custom CSS.

A good example of this approach can be found in the `css/custom/typography.css` file, and here's a short extract from it:

```sass
body {
  &.debug-screens:before {
    @apply left-inherit right-0;
  }

  @apply text-gray-700;
}

.site-logo {
  img, svg {
    @apply h-full;
  }
}
```

#### Building Tailwind for Production

When you are getting ready for a production deployment, you need to make sure you have compiled the **Production** CSS. This is because the production CSS is purged to only include the CSS classes you are actually using.  Also, it is minified to ensure it's as small as possible. You should get into the habbit of running this whenever you do a major change or a push to your production environment.  This way you will always have an accurate and optimized production CSS.

To compile the production CSS simply run:

```shell script
npm run prod
```

This will create a `build/css/site.prod.css` file that you can compare to the development `build/css/site.css` file.

#### Troubleshooting Production CSS issues

The production version of the Tailwind CSS which is built into `buld/css/site.prod.css` file utilizes the `purgecss` package to only include CSS classes that are being used.  PostCSS is used to handle this process, and the configuration for where `purgecss` looks for classes is contained in the `tailwind.config.js` file.  Feel free to modify this file to include other locations if a class is not getting found and included in the production CSS.

By default, Typhoon's purge configuration looks like this:

```json
  purge: [
    '../../config/**/*.yaml',
    '../../pages/**/*.md',
    './blueprints/**/*.yaml',
    './js/**/*.js',
    './templates/**/*.twig',
    './typhoon.yaml',
    './typhoon.php',
    './available-classes.md',
  ],
```

Feel free to edit or adjust this file to include paths and files that need to be inspected for possible Tailwind CSS classes.

At the root of your Typhoon theme you can find an `available-classes.md` file that you can consult at any time. This file also allows keeping certain classes upon purge which is used for the build of the production css, even if they have never been used.

! Remember, if you change the theme name, you should also change the `typhoon.yaml` and `typhoon.php` section in the purge configuration.

### Modify Twig Templates

Most modifications will take the form of editing the [Twig templates](https://twig.symfony.com/doc/3.x/templates.html) which controls the HTML but also is used for setting the Tailwind utility classes for CSS. These are organized in the `templates/` folder of the theme.

If you have already created a new custom theme based on Typhoon, then you can edit this as you need.  Also, you can override other twig files that come from plugins for example, simply copy the Twig file from the plugin (including any folder structure inside the plugin's templates folder) and copy into your theme's templates folder.  Then you can modify the twig as you need to get the desired result.

A good example of this can be seen in the `templates/partials/pagination.html.twig` where the `pagination` plugin's existing twig partial, has been copied to Typhoon and modified to make use of Tailwind's CSS utility classes.  No custom CSS was required because all the modifications were made directly by modifying the Twig file.

For more information, check out the [Typhoon Theme Documenation](https://getgrav.org/premium/typhoon/docs?target=_blank) on the GetGrav.org site.