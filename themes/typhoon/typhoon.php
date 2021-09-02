<?php
namespace Grav\Theme;

use Composer\Autoload\ClassLoader;
use Grav\Common\Cache;
use Grav\Common\Language\Language;
use Grav\Common\Language\LanguageCodes;
use Grav\Common\Page\Interfaces\PageInterface;
use Grav\Common\Page\Media;
use Grav\Common\Page\Pages;
use Grav\Common\Theme;
use Grav\Common\Uri;
use Grav\Common\User\Interfaces\UserInterface;
use Grav\Common\Utils;
use Grav\Plugin\ColorTools\Color;
use Grav\Plugin\SVGIconsPlugin;
use RocketTheme\Toolbox\Event\Event;
use RocketTheme\Toolbox\ResourceLocator\UniformResourceLocator;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Typhoon extends Theme
{
    protected $rawroute;
    protected $primary_menu_levels = 100;
    protected $cache_key;
    protected $links;
    protected $primary;

    public static function getSubscribedEvents()
    {
        return [
            'onThemeInitialized'            => [
                ['autoload', 100001],
                ['onThemeInitialized', 0]
            ],
            'onTwigLoader'                  => ['onTwigLoader', 0],
            'onTwigInitialized'             => ['onTwigInitialized', 0],
            'onPageInitialized'             => ['onPageInitialized', 0],
            'registerNextGenEditorPlugin'   => ['registerNextGenEditorPluginShortcodes', 0],
            'onSiteThemeMenu'               => ['onSiteThemeMenu', 0],
        ];
    }

    /**
     * [onPluginsInitialized:100000] Composer autoload.
     *is
     * @return ClassLoader
     */
    public function autoload(): ClassLoader
    {
        return require __DIR__ . '/vendor/autoload.php';
    }

    public function onThemeInitialized()
    {
        if ($this->isAdmin()) {
            $this->enable([
                'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            ]);
        }
    }

    public function registerNextGenEditorPluginShortcodes($event) {
        $plugins = $event['plugins'];

        $plugins['css'][] = 'theme://js/nextgen-shortcode.css';
        $plugins['js'][] = 'theme://js/nextgen-shortcode.js';

        $event['plugins']  = $plugins;
        return $event;
    }

    public function onSiteThemeMenu($event)
    {
        $menu = $event['menu'];

        /** @var Language $language */
        $language = $this->grav['language'];

        /** @var UserInterface $user */
        $user = $this->grav['user'] ?? null;
        $icon_classes = $this->config->get('theme.menu.icon_classes');

        // Login
        if ($user && $this->config->get( 'theme.menu.login.enabled')) {
            $login_url = $this->config->get('plugins.login.route');
            $login_icon = $this->config->get('theme.menu.login.icon');
            $profile_url = $this->config->get('plugins.login.route_profile');

            if ($user->authenticated && $user->authorized) {
                $logged_in_display = $this->config->get('theme.menu.login.logged_in_display');
                $logout_icon = $this->config->get('theme.menu.login.logout_icon');

                $logout_item = new SiteMenuItem([
                    'text' => $language->translate('THEME_TYPHOON.LOGIN.LOGOUT'),
                    'href' => Uri::addNonce(Utils::url('/task:login.logout'), 'logout-form', 'logout-nonce'),
                    'rawroute' => $login_url,
                    'level' => 2,
                    'after_icon' => $logout_icon ? SVGIconsPlugin::svgIconFunction($logout_icon, $icon_classes . ' ml-1'):  null,
                    'id' => 'logout',
                ]);

                $login_item = [
                    'text' => $user->{$logged_in_display},
                    'href' => Utils::url($profile_url),
                    'links' => [$logout_item->id => $logout_item->toArray()],
                ];
            } else {
                $login_item = [
                    'text' => $language->translate('THEME_TYPHOON.LOGIN.LOGIN'),
                    'href' => Utils::url($login_url),
                ];
            }
            $link = new SiteMenuItem([
                'rawroute' => $login_url,
                'id' => 'login',
                'before_icon' => $login_icon ? SVGIconsPlugin::svgIconFunction($login_icon, $icon_classes) : null,
            ]);
            $menu->{$link->id} = $link->mergeData($login_item)->toArray();
        }

        // Langswitcher
        $langswitcher = $this->grav['langswitcher'] ?? null;
        if ($langswitcher && $language->enabled() && $this->config->get( 'theme.menu.langswitcher.enabled')) {
            $lang_icon = $this->config->get('theme.menu.langswitcher.icon');
            $untranslated_pages_behavior = $this->config->get('plugins.langswitcher.untranslated_pages_behavior');
            $page = $this->grav['page'];
            $uri = $this->grav['uri'];

            $entry = new SiteMenuItem([
                'text' => $language->translate('THEME_TYPHOON.LANGUAGES'),
                'before_icon' => $lang_icon ? SVGIconsPlugin::svgIconFunction($lang_icon, $icon_classes) : null,
                'id' => 'langswitcher',
                'href' => null,
                'rawroute' => null,
                'routable' => false,
                'active_support' => false,
            ]);
            $other_languages = [];

            foreach ($langswitcher->languages as $lang) {
                $show_language = true;
                if ($lang === $langswitcher->current) {
                    $entry->mergeData([
                        'text' => LanguageCodes::getNativeName($lang),
                        'href' => $page->url(),
                        'rawroute' => $page->rawroute(),
                    ]);
                } else {
                    $base_lang_url = Utils::url($language->getLanguageUrlPrefix($lang));
                    $lang_url = $base_lang_url . $langswitcher->page_route . $page->urlExtension();
                    if ($untranslated_pages_behavior !== 'none') {
                        $translated_page = $langswitcher->translated_pages[$lang];
                        if (!$translated_page or !$translated_page->published()) {
                            if ($untranslated_pages_behavior === 'redirect') {
                                $lang_url = $base_lang_url . '/';
                            } elseif ($untranslated_pages_behavior === 'hide') {
                                $show_language = false;
                            }
                        }
                    }
                    $language_url = Utils::url($lang_url . $uri->params());
                    if ($show_language) {
                        $lang_entry = new SiteMenuItem([
                            'text' => LanguageCodes::getNativeName($lang),
                            'href' => $language_url,
                            'rawroute' => $language_url,
                            'active_support' => false,
                            'level' => 2,
                        ]);
                        $other_languages[] = $lang_entry->toArray();
                    }
                }
            }

            if (!empty($other_languages)) {
                $entry->links = $other_languages;
            }

            $menu->langswitcher = $entry->toArray();
        }

        return $menu;
    }

    // Add images to twig template paths to allow inclusion of SVG files
    public function onTwigLoader()
    {
        $theme_images = $this->grav['locator']->findResources('theme://images');
        foreach($theme_images as $images_path) {
            $this->grav['twig']->addPath($images_path, 'images');
        }
    }

    // Access plugin events in this class
    public function onTwigInitialized()
    {
        $twig = $this->grav['twig'];

        $twig->twig()->addFilter(
            new TwigFilter('color_object', [$this, 'getColorObject'], ['needs_context' => true])
        );
        $twig->twig()->addFilter(
            new TwigFilter('hero_image', [$this, 'getHeroImage'], ['needs_context' => true])
        );

        // Add Twig functions
        $twig->twig()->addFunction(
            new TwigFunction('typhoon_full_menu', [$this, 'getMenu'])
        );
        $twig->twig()->addFunction(
            new TwigFunction('typhoon_primary_menu', [$this, 'getPrimaryMenu'])
        );
        $twig->twig()->addFunction(
            new TwigFunction('typhoon_secondary_menu', [$this, 'getSecondaryMenu'])
        );
        $twig->twig()->addFunction(
            new TwigFunction('is_active_item', [$this, 'isActiveItem'])
        );
        $twig->twig()->addFunction(
            new TwigFunction('get_mime_type', [$this, 'getMimeType'])
        );
        $twig->twig()->addFunction(
            new TwigFunction('page_exists', [$this, 'pageExists'])
        );


        $form_class_variables = [
            'form_outer_classes' => '',
            'form_button_outer_classes' => 'text-center',
            'form_button_classes' => 'form-button',
            'form_errors_classes' => '',
            'form_field_outer_classes' => '',
            'form_field_outer_label_classes' => '',
            'form_field_label_classes' => '',
            'form_field_outer_data_classes' => '',
            'form_field_input_classes' => 'form-input',
            'form_field_textarea_classes' => 'form-textarea',
            'form_field_select_classes' => 'form-select',
            'form_field_radio_classes' => 'form-radio',
            'form_field_checkbox_classes' => 'form-checkbox',
        ];

        $twig->twig_vars = array_merge($twig->twig_vars, $form_class_variables);

    }

        /**
     * Add twig paths to plugin templates.
     */
    public function onTwigTemplatePaths()
    {
        $twig = $this->grav['twig'];
        $twig->twig_paths[] = __DIR__ . '/templates';
    }

    public function onPageInitialized(Event $e)
    {
        $this->cache_key = $this->grav['pages']->getPagesCacheId();

        $page = $e['page'];
        if ($page) {
            $this->rawroute = $page->rawRoute();
            $this->primary_menu_levels = $this->config->get( 'theme.menu.primary_menu_levels');
        }
    }

    public function getColorObject($context, $color, $default = null)
    {
        if ($color === 'primary') {
            $obj = $context['primary_color'];
        } elseif ($color === 'light') {
            $obj = new Color('#eeeeee');
        } elseif ($color === 'lighter') {
            $obj = new Color('#ffffff');
        } elseif ($color === 'dark') {
            $obj = new Color('#222222');
        } elseif ($color === 'darker') {
            $obj = new Color('#111111');
        } elseif ($this->isHex($color)) {
            $obj = new Color($color);
        } elseif ($default) {
            $obj = new Color($default);
        } else {
            $obj = new Color('#000000');
        }

        return $obj;
    }

    public function getHeroImage($context, $image)
    {
        /** @var UniformResourceLocator $locator */
        $locator = $this->grav['locator'];
        /** @var PageInterface $page */
        $page = $context['page'];
        $hero_image = null;
        $route = null;
        $images = null;
        $valid_images = [];

        if (is_array($image)) {
            $images = $image;
        } else {
            $images = array_map('trim', explode(',', $image));
        }

        foreach ($images as $image) {
            // Check if it's a route already
            if (Utils::startsWith($image, '/')) {
                $new_page = $page->find($image);
                if ($new_page) {
                    $media = $new_page->getMedia();
                    $images = $media->images();

                    if (count($images) > 0) {
                        $image_media = $images[array_rand($images)] ?? null;
                        if ($image_media) {
                            $valid_images[] = $image_media;
                        }
                    }
                }
                continue;
            }

            if ($locator->isStream($image) || $route) {
                $stream = $image;
                if (is_file($locator->findResource($stream))) {
                    $image_media = $page->getMedia()[$stream];
                    if ($image_media) {
                        $valid_images[] = $image_media;
                    }
                } else {
                    if (Utils::startsWith($stream, 'page://')) {
                        $route = str_replace('page:/', '', $stream);
                        $new_page = $page->find($route);
                        if ($new_page) {
                            $media = $new_page->getMedia();
                        }
                    } else {
                        $media = new Media($stream);
                    }
                    $images = (array) $media->images();
                    if (count($images) > 0) {
                        $image_media = $images[array_rand($images)] ?? null;
                        if ($image_media) {
                            $valid_images[] = $image_media;
                        }
                    }
                }
                continue;
            } else {
                if (is_array($image)) {
                    $hero_image = $image[array_rand($image)];
                } else {
                    $hero_image = $image;
                }
            }

            while ($page && !$page->root()) {
                $images = (array) $page->getMedia()->images();
                $image_media = $images[$hero_image] ?? null;
                if ($image_media) {
                    $valid_images[] = $image_media;
                    break;
                }

                $page = $page->parent();
            }
        }

        if (count($valid_images) > 0) {
            return $valid_images[array_rand($valid_images)];
        }
        return $image;
    }

    public function getMenu()
    {
        $links = $this->links;

        if (!$links) {
            /** @var Cache $cache */
            $cache = $this->grav['cache'];
            $key = 'typhoon-full-menu-' . $this->cache_key;
            $links = $cache->fetch($key);

            if (!$links) {
                /** @var Pages $pages */
                $pages = $this->grav['pages'];

                /** @var PageInterface $nav */
                $nav = $pages->root()->children()->visible();

                // Loop through top-level menu items
                $links = [];
                foreach ($nav as $page) {
                    $links[$page->slug()] = $this->buildLinkNode($page, 1);
                }

                $cache->save($key, $links);
            }
            $menu = (object) $links;
            $this->grav->fireEvent('onSiteThemeMenu', new Event(['menu' => $menu]));
            $links = (array) $menu;
            $this->links = $links;
        }

        return $links;
    }

    public function getPrimaryMenu()
    {
        return $this->stripSecondaryItems($this->getMenu());
    }

    protected function stripSecondaryItems($menu)
    {
        foreach ($menu as $slug => $link) {
            $links = $link['links'] ?? null;
            $secondary = $link['show_children_in_secondary_menu'] ?? false;
            if ($links && $secondary) {
                unset($menu[$slug]['show_children_in_secondary_menu']);
                unset($menu[$slug]['links']);
                continue;
            }
            if ($links) {
                $menu[$slug]['links'] = $this->stripSecondaryItems($links);
            }
        }
        return $menu;
    }

    public function getSecondaryMenu($page)
    {
        $route = $page->route();

        if ($route === '/') {
            $route = $page->slug();
        }

        $slugs = explode('/', trim($route, '/'));
        $menu = $this->getMenu();
        $level = 0;
        $sublevel_start = $this->primary_menu_levels + 1;

        // Get chunk we need to work with
        foreach ($slugs as $slug) {
            $level++;
            $links = $menu[$slug]['links'] ?? null;
            $secondary = $menu[$slug]['show_children_in_secondary_menu'] ?? false;
            $menu = $links;
            if ($secondary && $links) {
                return $menu;
            }
        }

        if ($level < $sublevel_start) {
            return null;
        }

        return $menu;
    }


    public function isActiveItem($link)
    {
        if (isset($link['active_support']) && $link['active_support'] === false) {
            return false;
        }
        $page_rawroute = $this->rawroute;
        $item_rawroute = $link['rawroute'];
        $active = Utils::startsWith($page_rawroute, $item_rawroute);
        return $active;
    }

    public function getMimeType($file)
    {
        return Utils::getMimeByFilename($file);
    }

    public function pageExists($field)
    {
        $config = $this->config();
        $pages = $this->grav['pages'];
        $page_field = $field['page_field'] ?? '';
        $page_template = $field['page_template'] ?? '';
        $page_route = $config[$page_field] ?? '';

        $pages->enablePages();
        $found_page = $pages->find($page_route);

        return ($found_page instanceof PageInterface && $found_page->template() === $page_template);
    }

    /**
     * Builds nested notes from page structure
     *
     * @param PageInterface $page
     * @param int $level
     * @return array
     */
    protected function buildLinkNode(PageInterface $page, $level): array
    {
        $icon_classes = $this->config->get('theme.menu.icon_classes');
        $header = $page->header();
        $children = $page->children()->visible();
        $has_children = $children->count() > 0;
        $split_level = $level >= ($this->primary_menu_levels ?? 100);
        $page_split_level = $header->show_children_in_secondary_menu ?? false;
        $show_children_in_secondary_menu =  $split_level ?: $page_split_level;
        $open_in_new_tab = $this->config->get( 'theme.external_in_new_tab', false);
        $external_url = $header->external_url ?? false;
        $before_icon = $header->menu_before_icon ?? null;
        $after_icon = $header->menu_after_icon ?? null;
        $icon_extra_classes = $header->menu_icon_classes ?? '';

        $link = new SiteMenuItem();

        $link->rawroute = $page->rawRoute();
        $link->href = $page->url();
        $link->text = $page->menu();
        $link->id = $page->slug();
        $link->level = $level;
        $link->before_icon = $before_icon ? SVGIconsPlugin::svgIconFunction($before_icon, $icon_classes . ' ' . $icon_extra_classes) : null;
        $link->after_icon = $after_icon ? SVGIconsPlugin::svgIconFunction($after_icon, $icon_classes . ' ml-1 ' . $icon_extra_classes) : null;;
        $link->show_children_in_secondary_menu = $show_children_in_secondary_menu;
        $link->routable = $page->routable();
        $link->external = $external_url && $open_in_new_tab;

        if ($has_children) {
            $child_links = [];
            foreach ($children as $child) {
                $child_links[$child->slug()] = $this->buildLinkNode($child, $level + 1);
            }
            $link->links = $child_links;
        }

        return $link->toArray();
    }

    protected function isHex($hex)
    {
         return preg_match('/^#*([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $hex);
    }
}
