<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('gen_categories'))
{
    function gen_categories()
    {   
        $cat_array = NULL;

        // get our root categories
        if (($roots = $this->cat_model->get_roots()))
        {
            foreach ($roots->result() as $root)
            {
                $cat_array[$root->name] = array();

                // child this roots children
                if (($kids = $this->cat_model->get_children($root->id)))
                {
                    foreach ($kids->result() as $child)
                    {
                        $cat_array[$root->name][$child->name] = array();

                        // get our childs children
                        if (($kids_kids = $this->cat_model->get_children($child->id)))
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

