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
                if (($kids = $CI->cat_model->get_children($root->id, $owl)))
                {
                    foreach ($kids->result() as $child)
                    {
                        $cat_array[$root->name][$child->name] = array();

                        // get our childs children
                        if (($kids_kids = $CI->cat_model->get_children($child->id, $owl)))
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
                if (($kids = $CI->cat_model->get_children($root->id, $owl)))
                {
                    foreach ($kids->result() as $child)
                    {
                        $cat_array[] = array('id' => $child->id, 'name' => '- ' . $child->name);

                        // Are we in the creation page? If so DON'T display this section...
                        if (!$create_page)
                        {
                            // get our childs children
                            if (($kids_kids = $CI->cat_model->get_children($child->id, $owl)))
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

