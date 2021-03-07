# v1.0.11
## 03/01/2021

1. [](#improved)
    * Allow **unroutable** page to serve as parent dropdown menu items, but not be linkable.

# v1.0.10
## 02/23/2021

1. [](#improved)
    * Support retina images in hero by default [getgrav/grav-premium-issues#48](https://github.com/getgrav/grav-premium-issues/issues/48)
1. [](#bugfix)
    * Fixed issue with `hero.display` not taking page variable into account [getgrav/grav-premium-issues/53](https://github.com/getgrav/grav-premium-issues/issues/53)
    * Rename the **Inter** font to remove `.var.` as this can cause an error on some Apache server configurations [getgrav/grav-premium-issues#49](https://github.com/getgrav/grav-premium-issues/issues/49)
    * Fix issue with side menu on homepage [getgrav/grav-premium-issues#52](https://github.com/getgrav/grav-premium-issues/issues/52)

# v1.0.9
## 02/12/2021

1. [](#improved)
    * Updated `tailwindcss` core package to latest `v2.0.3`
    * Updated `@tailwindcss/typography` package to latest `v0.4.0`  
    * Cleaned up spacing in Twig templates (2 space indents)
    * Force `|raw` on some output in `partials/hero.html.twig`
1. [](#bugfix)
    * Fix typo in `gallery` blueprint causing `grid_classes`, and `thumb` width & height options to have no effect. [getgrav/grav-premium-issues#37](https://github.com/getgrav/grav-premium-issues/issues/37)
    * Force `|raw` on simple search results [getgrav/grav-premium-issues#47](https://github.com/getgrav/grav-premium-issues/issues/47) 

# v1.0.8
## 01/28/2021

1. [](#new)
    * Added option to control location of **primary menu**, either `header` or `sidebar`
    * Added option to enable/disable mobile navigation hamburger + menu
1. [](#improved)
    * Moved `primary_menu_levels` under `menu:` configuration. You may need to reset this value.
    * Fixed some header navigation CSS styling that was infecting side navigation
    * Active sidebar menu items are now bold for clarity
    * Improved contrast of sidebar navigation in dark mode

# v1.0.7
## 01/25/2021

1. [](#improved)
    * Added `500px` and `GitBook` to social icon chooser. Now supports any brand in format of `gitbook__brand` for the value. Colors need to defined though. See `css/custom/social.css`.
1. [](#bugfix)
    * Removed a debug statement

# v1.0.6
## 01/15/2021

1. [](#improved)
    * Added instructions in `typhoon.yaml` configuration file
    * Added a new sidebar include with `/modular/sidebar` page if it exists
1. [](#bugfix)
    * Added fix for Safari overflow bug on gallery view
    * Added back support for `group-hover:scale` for gallery view
    
# v1.0.5
## 12/19/2020

1. [](#improved)
    * Typo in `getting-started.md`
    * Added toggles for Footer `menu` and `social` display enabled [getgrav/grav-premium-issues#6](https://github.com/getgrav/grav-premium-issues/issues/6)

# v1.0.4
## 12/15/2020

1. [](#improved)    
    * Improved hero image handling
    * Added `getting-started.md` file to help with CSS compilation questions
    * Upgraded to latest TailwindCSS 2.0.2
    * Various escaping fixes
    * Added Demo link

# v1.0.3
## 12/14/2020

1. [](#improved)
    * Upgraded to latest TailwindCSS 1.9.6
    * Switched some `yes`/`no` Typhoon option toggles to boolean
    * Switch to using `site.css`

# v1.0.2
## 10/07/2020

1. [](#new)
    * Light/Dark modes with automatic detection
    * Grav 1.6x support
1. [](#improved)
    * Added new fields in `gallery` modular template to control grid + thumb sizes
    * Improved semantic tags usages
    * Various SEO fixes (courtesy of SEO-Magic)
    * Various iOS fixes
    * Aria improvements
    * Tailwind upgrades
    * Many CSS and HTML fixes

# v1.0.1
## 09/02/2020

1. [](#new)
    * Initial Release
