<?php
namespace Grav\Theme;

use Grav\Framework\Object\Access\ArrayAccessTrait;

class SiteMenuItem
{
    use ArrayAccessTrait;

    public $text = 'Item';
    public $href = '/';
    public $rawroute = '/';
    public $id = 'item';
    public $level = 1;
    public $routable = true;
    public $before_icon = null;
    public $after_icon = null;
    public $show_children_in_secondary_menu = false;
    public $show_in_menu = true;
    public $external = false;
    public $links = null;
    public $active_support = true;

    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->mergeData($data);
        }
    }

    public function mergeData($data): SiteMenuItem
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        return $this;
    }

    public function toArray(): array
    {
        return (array) $this;
    }

}