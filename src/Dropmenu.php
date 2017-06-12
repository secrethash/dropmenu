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
    * Global Settings
    *
    * @access protected
    */

    protected $globalMethod = "URL";           # URL Rendering Method, EX: ROUTE or URL


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
    protected function childSettings($set)
    {
        if (!empty($set['ul_attributes']))
        {
            $this->childULA = $set['ul_attributes'];
        }
    }

    /**
    * Setting up the Icons
    * 
    * @var iconSettings()
    * @return Icon Settings
    * @access protected
    */

    protected function iconSettings($set)
    {
        if (!empty($set['prefix']))
        {
            $this->icon_pre = $set['prefix'];
        }
        if (!empty($set['suffix']))
        {
            $this->icon_suf = $set['suffix'];
        }
        if (!empty($set['line_end']))
        {
            $this->full_suf = $set['line_end'];
        }
    }

    /**
    * Global Settings
    * 
    * @var globalSettings()
    * @return Settings
    * @access protected
    */
    protected function globalSettings($set)
    {
        if (!empty($set['method']))
        {
            $this->globalMethod = $set['method'];
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
                
                $link = URL::to($element['link']);

                if ($this->globalMethod==="ROUTE") {

                    if ($element['link']==="#" OR $element['link']===NULL) # if link is a hashtag, print as it is.
                    {
                        $link = $element['link'];
                    } else {
                        $link = route($element['link']);
                    }
                }

                $menu_html .= "\n<li><a ".($element['link'])!=NULL ? "href='".$link."' ").$element['link_attr'].">".$icon_pre.$element['icon'].$icon_suf."".$element['name'].$full_suf."</a>";
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
    public function display($type, $set=array())
    {
        // Checking for icon settings
        $this->iconSettings($set['icon']);

        // Checking for Child Settings
        $this->childSettings($set['child']);

        // Checking for Global Settings
        $this->globalSettings($set['global']);

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