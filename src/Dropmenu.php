<?php

namespace Secrethash\Dropmenu;

use Secrethash\Dropmenu\Model\Menu as Menu;
use Auth;
use URL;
use Secrethash\Trickster;

class Dropmenu {
    // Icon Settings
    var $icon_suf = '';
    var $icon_pre = '';
    var $full_suf = '';

    /**
    * Stores User's details, if logged in.
    * 
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
    * Setting up the Icons
    * 
    * @var iconSettings()
    * @return Icon Settings
    */

    protected function iconSettings($icon_pre, $icon_suf, $full_suf)
    {
        if (!empty($icon_pre))
        {
            $this->icon_pre = $icon_pre;
        }
        if (!empty($icon_suf))
        {
            $this->icon_suf = $icon_suf;
        }
        if (!empty($full_suf))
        {
            $this->full_suf = $full_suf;
        }
    }

    /**
    * Renders the HTML Menu
    * 
    * @var render
    * @return HTML Menu
    */
    protected function render($array, $parent_id=0, $parents=array())
    {

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
                    if (empty($this->icon_pre))
                    {
                        $icon_pre = "<div><i class='";
                    }
                    else
                    {
                        $icon_pre = $this->icon_pre;
                    }

                    if (empty($this->icon_suf))
                    {
                        $icon_suf = "'></i> ";
                    }
                    else
                    {
                        $icon_suf = $this->icon_suf;
                    }

                    if (empty($this->full_suf))
                    {
                        $full_suf = "</div>";
                    }
                    else
                    {
                        $full_suf = $this->full_suf;
                    }

                }
                else
                {
                    $icon_pre = "<div>"; // Prefix
                    $icon_suf = ""; // Suffix
                    $full_suf = "</div>"; // Full Suffix
                }
                $menu_html .= "\n<li><a href='".URL::to($element['link'])."' ".$element['link_attr'].">".$icon_pre.$element['icon'].$icon_suf."".$element['name'].$full_suf."</a>";
                if(in_array($element['id'], $parents))
                {
                    $menu_html .= "\n\t<ul>\n";
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
    * 
    * 
    * @return Show Menu
    */
    public function display($type)
    {
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
        $menu = $this->render($arrayMenu);
        $this->iconSettings("<i class='", "'></i> ", "<!--#-->");

        return $menu;
    }
}