<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------------
 *
 * MiOWL                                                     (v1) | codename dave
 *
 * ------------------------------------------------------------------------------
 *
 * Copyright (c) 2012, Alan Wynn
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * ------------------------------------------------------------------------------
 */

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

if (!function_exists('gen_categories_id'))
{
    function gen_categories_id($owl = FALSE)
    {
        $CI =& get_instance();
        $cat_array = NULL;

        // get our root categories
        if (($roots = $CI->cat_model->get_roots($owl)))
        {
            foreach ($roots->result() as $root)
            {
                $cat_array[$root->id] = array();

                // child this roots children
                if (($kids = $CI->cat_model->get_children($owl, $root->id)))
                {
                    foreach ($kids->result() as $child)
                    {
                        $cat_array[$root->id][$child->id] = array();

                        // get our childs children
                        if (($kids_kids = $CI->cat_model->get_children($owl, $child->id)))
                        {
                            foreach ($kids_kids->result() as $childs_childs)
                            {
                                $cat_array[$root->id][$child->id][$childs_childs->id] = array();
                            }
                        }
                    }
                }

            }
        }

        return $cat_array;
    }
}

if (!function_exists('gen_categories_a'))
{
    function gen_categories_a($owl = FALSE)
    {
        return url_walk( gen_categories_id($owl) );
    }
}

if (!function_exists('url_walk'))
{
    function url_walk($input = array())
    {
        $CI =& get_instance();
        $CI->load->model('cat_model');
        $ouput = array();
        foreach ($input as $key => $value) {
            if( is_array( $value ) )
                $output[$key] = url_walk( $value );
            else
            {
                if( (( $data = $CI->cat_model->get_category( $value ) )) )
                $cat_name = $data->row()->name;
                $output[$key] = "<a href='{$value}'>{$cat_name}</a>";
            }
        }
        return $output;
    }
}

if (!function_exists('gen_drop_categories'))
{
    function gen_drop_categories($owl = FALSE, $create_page = FALSE, $cat_pid = FALSE)
    {
        $CI =& get_instance();
        $cat_array = NULL;

        // get our root categories
        if (($roots = $CI->cat_model->get_roots($owl)))
        {
            foreach ($roots->result() as $root)
            {
                if ($create_page && $cat_pid != FALSE && $cat_pid == $root->id)
                    $cat_array[] = array('id' => $root->id, 'name' => $root->name, 'selected' => TRUE);
                else
                    $cat_array[] = array('id' => $root->id, 'name' => $root->name, 'selected' => FALSE);

                // child this roots children
                if (($kids = $CI->cat_model->get_children($owl, $root->id)))
                {
                    foreach ($kids->result() as $child)
                    {
                        if ($create_page && $cat_pid != FALSE && $cat_pid == $child->id)
                            $cat_array[] = array('id' => $child->id, 'name' => '- ' . $child->name, 'selected' => TRUE);
                        else
                            $cat_array[] = array('id' => $child->id, 'name' => '- ' . $child->name, 'selected' => FALSE);

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
        $breadcrumb_text = cat_breadcrumb($cat_id);

        // get our category information
        if (($chosen = $CI->cat_model->get_category($cat_id)))
        {
            // start our breadcrumb
            $breadcrumb = '<li class="last">' . $chosen->row()->name . "</li>{$breadcrumb}";

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

        return '<ul class="breadcrumb" title="' . $breadcrumb_text . '">' . $breadcrumb;
    }
}


// eof.