<?php

namespace Secrethash\Dropmenu;

use Secrethash\Dropmenu\Model\Menu as Menu;
use Auth;
use URL;
use Secrethash\Trickster;

class Dropmenu {

    /**
    # Displays the menus provided
    # by the name and using the 
    # settings that are provided.
    # 
    # Created by: Shashwat Mishra <secrethash96@gmail.com>
    # License: MIT (Given that Credits should be given)
    */

    /**
    * Icon Settings Variables
    * 
    * @access protected
    * @return string
    */

    protected $icon_pre = "<i class='"; # prefix
    protected $icon_suf = "'></i> ";    # suffix
    protected $full_suf = "";           # line end


    /**
    * Child Settings
    *
    * @access protected
    */

    protected $childULA = "";           # Unordered List Attributes


    /**
    * Stores User's details, if logged in.
    * 
    * @var $user
    * @access protected
    */

    protected $user = '';

    protected function users()
    {
        if (Auth::check())
        {
            $this->user = Auth::user();
        }
    }

    /**
    * Setting up the Child Items
    * 
    * @var childSettings()
    * @return Child Settings
    * @access protected
    */
    protected function childSettings($child_set)
    {
        if (!empty($child_set['ul_attributes']))
        {
            $this->childULA = $child_set['ul_attributes'];
        }
    }

    /**
    * Setting up the Icons
    * 
    * @var iconSettings()
    * @return Icon Settings
    * @access protected
    */

    protected function iconSettings($icon_set)
    {
        if (!empty($icon_set['prefix']))
        {
            $this->icon_pre = $icon_set['prefix'];
        }
        if (!empty($icon_set['suffix']))
        {
            $this->icon_suf = $icon_set['suffix'];
        }
        if (!empty($icon_set['line_end']))
        {
            $this->full_suf = $icon_set['line_end'];
        }
    }

    /**
    * Renders the HTML Menu
    * 
    * @var render
    * @return HTML Menu
    * @access protected
    */
    protected function render($array, $parent_id=0, $parents=array())
    {
        $icon_pre = "";
        $icon_suf = "";
        $full_suf = "";

        if (Auth::check())
        {
            $this->users();
        }

        if ($parent_id===0)
        {
            foreach ($array as $element) {
                if (($element['parent_id'] != 0) && !in_array($element['parent_id'], $parents))
                {
                    $parents[] = $element['parent_id'];
                }
            }
        }
        $menu_html = '';
        foreach ($array as $element) {
            if ($element['parent_id']===$parent_id)
            {
                if (!empty($element['icon']))
                {
                    $icon_pre = $this->icon_pre;
                    $icon_suf = $this->icon_suf;
                    $full_suf = $this->full_suf;
                }

                $menu_html .= "\n<li><a href='".URL::to($element['link'])."' ".$element['link_attr'].">".$icon_pre.$element['icon'].$icon_suf."".$element['name'].$full_suf."</a>";
                if(in_array($element['id'], $parents))
                {
                    $menu_html .= "\n\t<ul ".$this->childULA.">\n";
                    $menu_html .= $this->render($array, $element['id'], $parents);
                    $menu_html .= "\n\t</ul>\n";
                }
                $menu_html .= "</li>";
            }
        }
        $menu_html .= '';
        return $menu_html;
    }

    /**
    * Displays the menu
    *
    * @access public
    * @return Show Menu
    */
    public function display($type, $icon_set=array(), $child_set=array())
    {
        // Checking for icon settings
        $this->iconSettings($icon_set);

        // Checking for Child Settings
        $this->childSettings($child_set);

        if (Auth::check())
        {
            $getAuth = [1, 0];
            $this->users();
        }
        else
        {
            $getAuth = [2, 0];
        }
        $arrayMenu = Menu::orderBy('order_by', 'asc')
                    ->where('type', $type)
                    ->whereIn('auth', $getAuth)
                    ->get();

        // Initiating the Icon Settings
        // $this->iconSettings();

        $menu = $this->render($arrayMenu);

        return $menu;
    }
}