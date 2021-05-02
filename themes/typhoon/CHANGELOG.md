# v2.0.0
## 04/30/2021

1. [](#new)
    * Reinstated **Tailwind JIT compiler** for much faster compilation + production quality 'purged' CSS + arbitrary styles + all variants
    * Multi-language support for **Footer elements + Notices** via new custom modular pages.  These take precedence over the theme level configuration and is backwards compatible with existing setups.
    * Move all lang strings into language files.  Please feel free to submit language translations!
    * Removed redundant **Development** / **Production** mode toggle.  JIT now provides optimal CSS at runtime.  To compress use the CSS pipeline feature of Grav.
1. [](#improved)
    * Updated to latest `v2.1.2` of Tailwind CSS
    * Set primary darker/lighter to `20%` rather than `10%`
  
# v1.1.1
## 04/12/2021

1. [](#improved)
    * Added `body_classes` configuration option in theme settings [getgrav/grav-premium-issues#72](https://github.com/getgrav/grav-premium-issues/issues/72)
    * Support SVG via `page.media.files` rather than `page.media.images` [getgrav/grav-premium-issues#78](https://github.com/getgrav/grav-premium-issues/issues/78)
    * Upgraded to Tailwind 2.1.1
1. [](#bugfix)
    * Forced to Roll-back JIT compilation until TailwindCSS fixes the compiler to support parent-page purge [tailwindlabs/tailwindcss#4059](https://github.com/tailwindlabs/tailwindcss/issues/4059)
    * Fixed issue with brands-based social icons in Safari + Mobile [getgrav/grav-premium-issues#73](https://github.com/getgrav/grav-premium-issues/issues/73)
    * Fixed tailwind import ordering [getgrav/grav-premium-issues#84](https://github.com/getgrav/grav-premium-issues/issues/84)


# v1.1.0
## 03/22/2021

1. [](#new)
    * Using **NEW** Tailwind JIT compiler for much faster compilation + production quality 'purged' CSS + arbitrary styles + all variants
    * Removed redundant **Development** / **Production** mode toggle.  JIT now provides optimal CSS at runtime.  To compress use the CSS pipeline feature of Grav.
    * Added support for custom favicon [getgrav/grav-premium-issues#65](https://github.com/getgrav/grav-premium-issues/issues/65)
1. [](#improved)
    * Updated to latest TailwindCSS `v2.0.4`
    * Added **Vimeo** to footer social icons [getgrav/grav-premium-issues#70](https://github.com/getgrav/grav-premium-issues/issues/70)
1. [](#bugfix)
    * Fixed an issue with Gallery modular page type not resetting `video` variable

# v1.0.12
## 03/15/2021

1. [](#new)
    * Added support for External URLs in new tabs [getgrav/grav-premium-issues#63](https://github.com/getgrav/grav-premium-issues/issues/63)
1. [](#improved)
    * Added **YouTube** to footer social icons [getgrav/grav-premium-issues#64](https://github.com/getgrav/grav-premium-issues/issues/64)
    * Added **Video** Support to the Gallery modular page type [getgrav/grav-premium-issues#61](https://github.com/getgrav/grav-premium-issues/issues/61)
1. [](#bugfix)
    * Removed a testing `dump()` statement
  
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
