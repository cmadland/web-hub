<?php
namespace Grav\Theme;

use Grav\Common\Cache;
use Grav\Common\Page\Interfaces\PageInterface;
use Grav\Common\Page\Media;
use Grav\Common\Page\Pages;
use Grav\Common\Theme;
use Grav\Common\Utils;
use Grav\Plugin\ColorTools\Color;
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
            'onThemeInitialized'    => ['onThemeInitialized', 0],
            'onTwigLoader'          => ['onTwigLoader', 0],
            'onTwigInitialized'     => ['onTwigInitialized', 0],
            'onPageInitialized'     => ['onPageInitialized', 0],
            'registerNextGenEditorPlugin' => ['registerNextGenEditorPluginShortcodes', 0],
        ];
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
        if ($this->links) {
            return $this->links;
        }

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
            $this->links = $links;
        }

        return $links;
    }

    public function getPrimaryMenu()
    {
        if ($this->primary) {
            return $this->primary;
        }

        /** @var Cache $cache */
        $cache = $this->grav['cache'];
        $key = 'typhoon-primary-menu-' . $this->cache_key;
        $primary = $cache->fetch($key);

        if (!$primary) {
            $primary = $this->stripSecondaryItems($this->getMenu());
            $cache->save($key, $primary);
            $this->primary = $primary;
        }

        return $primary;

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
    protected function buildLinkNode(PageInterface $page, $level)
    {
        $children = $page->children()->visible();
        $has_children = $children->count() > 0;
        $split_level = $level >= ($this->primary_menu_levels ?? 100);
        $page_split_level = $page->header()->show_children_in_secondary_menu ?? false;
        $show_children_in_secondary_menu =  $split_level ?: $page_split_level;
        $open_in_new_tab = $this->config->get( 'theme.external_in_new_tab', false);
        $external_url = $page->header()->external_url ?? false;

        $link['rawroute'] = $page->rawRoute();
        $link['href'] = $page->url();
        $link['text'] = $page->menu();
        $link['id'] = $page->slug();
        $link['level'] = $level;
        $link['show_children_in_secondary_menu'] = $show_children_in_secondary_menu;
        $link['routable'] = $page->routable();
        $link['external'] = $external_url && $open_in_new_tab;

        if ($has_children) {
            $child_links = [];
            foreach ($children as $child) {
                $child_links[$child->slug()] = $this->buildLinkNode($child, $level + 1);
            }
            $link['links'] = $child_links;
        }

        return $link;
    }

    protected function isHex($hex)
    {
         return preg_match('/^#*([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $hex);
    }
}
