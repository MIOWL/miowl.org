<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('gen_categories'))
{
    function gen_categories($owl = FALSE)
    {
        $CI =& get_instance();
        $cat_array = NULL;

        // get our root categories
        if (($roots = $CI->cat_model->get_roots($owl)))
        {
            foreach ($roots->result() as $root)
            {
                $cat_array[$root->name] = array();

                // child this roots children
                if (($kids = $CI->cat_model->get_children($owl, $root->id)))
                {
                    foreach ($kids->result() as $child)
                    {
                        $cat_array[$root->name][$child->name] = array();

                        // get our childs children
                        if (($kids_kids = $CI->cat_model->get_children($owl, $child->id)))
                        {
                            foreach ($kids_kids->result() as $childs_childs)
                            {
                                $cat_array[$root->name][$child->name][$childs_childs->name] = array();
                            }
                        }
                    }
                }
                
            }
        }

        return $cat_array;
    }
}

if (!function_exists('gen_drop_categories'))
{
    function gen_drop_categories($owl = FALSE, $create_page = FALSE)
    {
        $CI =& get_instance();
        $cat_array = NULL;

        // get our root categories
        if (($roots = $CI->cat_model->get_roots($owl)))
        {
            foreach ($roots->result() as $root)
            {
                $cat_array[] = array('id' => $root->id, 'name' => $root->name);

                // child this roots children
                if (($kids = $CI->cat_model->get_children($owl, $root->id)))
                {
                    foreach ($kids->result() as $child)
                    {
                        $cat_array[] = array('id' => $child->id, 'name' => '- ' . $child->name);

                        // Are we in the creation page? If so DON'T display this section...
                        if (!$create_page)
                        {
                            // get our childs children
                            if (($kids_kids = $CI->cat_model->get_children($owl, $child->id)))
                            {
                                foreach ($kids_kids->result() as $childs_childs)
                                {
                                    $cat_array[] = array('id' => $childs_childs->id, 'name' => '-- ' . $childs_childs->name);
                                }
                            }
                        }
                    }
                }
                
            }
        }

        return $cat_array;
    }
}

if (!function_exists('cat_breadcrumb'))
{
    function cat_breadcrumb($cat_id = FALSE)
    {
        if(!$cat_id)
            return FALSE;

        $CI =& get_instance();
        $breadcrumb = NULL;

        // get our category information
        if (($chosen = $CI->cat_model->get_category($cat_id)))
        {
            // start our breadcrumb
            $breadcrumb = $chosen->row()->name;

            // is this a root cat?
            if($chosen->row()->parent_id != 0)
            {
                // who is it a child of?
                if (($chosen_sub = $CI->cat_model->get_category($chosen->row()->parent_id)))
                {
                    // prepend our breadcrumb
                    $breadcrumb = $chosen_sub->row()->name . " &gt; {$breadcrumb}";

                    // is this a root cat?
                    if($chosen_sub->row()->parent_id != 0)
                    {
                        // who is it a child of?
                        if (($chosen_sub_sub = $CI->cat_model->get_category($chosen_sub->row()->parent_id)))
                        {
                            // prepend our breadcrumb
                            $breadcrumb = $chosen_sub_sub->row()->name . " &gt; {$breadcrumb}";
                        }
                    }
                }
            }
        }

        return $breadcrumb;
    }
}

if (!function_exists('cat_breadcrumb_ul'))
{
    function cat_breadcrumb_ul($cat_id = FALSE)
    {
        if(!$cat_id)
            return FALSE;

        $CI =& get_instance();
        $breadcrumb = '</ul>';

        // get our category information
        if (($chosen = $CI->cat_model->get_category($cat_id)))
        {
            // start our breadcrumb
            $breadcrumb = '<li>' . $chosen->row()->name . "</li>{$breadcrumb}";

            // is this a root cat?
            if($chosen->row()->parent_id != 0)
            {
                // who is it a child of?
                if (($chosen_sub = $CI->cat_model->get_category($chosen->row()->parent_id)))
                {
                    // prepend our breadcrumb
                    $breadcrumb = '<li>' . $chosen_sub->row()->name . "</li>{$breadcrumb}";

                    // is this a root cat?
                    if($chosen_sub->row()->parent_id != 0)
                    {
                        // who is it a child of?
                        if (($chosen_sub_sub = $CI->cat_model->get_category($chosen_sub->row()->parent_id)))
                        {
                            // prepend our breadcrumb
                            $breadcrumb = '<li>' . $chosen_sub_sub->row()->name . "</li>{$breadcrumb}";
                        }
                    }
                }
            }
        }

        return '<ul class="breadcrumb">' . $breadcrumb;
    }
}

