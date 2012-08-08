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

if (!function_exists('insert_3d_categories'))
{
    function insert_3d_categories( $type = FALSE, $owl_id = FALSE )
    {
        // do we have a type? or OWL
        if( !$type || !$owl_id )
            die( 'no type or owl id' );

        // determin the filename from the type
        switch ( $type )
        {
            case 'clinic':
                $filename = realpath(APPPATH . 'clinic_categories.csv');
                break;

            case 'hospital':
                $filename = realpath(APPPATH . 'hospital_categories.csv');
                break;

            default:
                exit( 'invalid type' );
                break;
        }

        // get our CodeIgniter instance
        $CI =& get_instance();

        // start up the insert array
        $insert = array();

        // get the array of strings from the file
        $cats = file( $filename );

        // extract each line and parse it
        foreach ($cats as $cat)
        {
            // get the 3 elements from the string
            list( $id, $name, $pid ) = explode( ',', $cat );

            // add the elements in an array to the insert array
            $insert[] = array(
                'id'        => trim( $id ),
                'name'      => trim( $name ),
                'parent_id' => trim( $pid ),
            );
        }

        // do the SQL insert
        foreach ($insert as $cat)
        {
            // 1st lets get the root cats
            if ( trim( $cat['parent_id'] ) == 0 )
            {
                // add this cat to the database and get its insert id
                $root_insert_id = $CI->cat_model->add_category(
                                        array(
                                            'name'      => trim( $cat['name'] ),
                                            'parent_id' => '0',
                                            'owl'       => $owl_id,
                                        ),
                                        TRUE
                                    );

                // get root children
                foreach ($insert as $sub_cat)
                {
                    if ( $sub_cat['parent_id'] === $cat['id'] )
                    {
                        // add this cat to the database and get its insert id
                        $sub_insert_id = $CI->cat_model->add_category(
                                                array(
                                                    'name'      => trim( $sub_cat['name'] ),
                                                    'parent_id' => $root_insert_id,
                                                    'owl'       => $owl_id,
                                                ),
                                                TRUE
                                            );

                        // get sub children
                        foreach ($insert as $sub_sub_cat)
                        {
                            if ( $sub_sub_cat['parent_id'] === $sub_cat['id'] )
                            {
                                // add this cat to the database
                                $CI->cat_model->add_category(
                                    array(
                                        'name'      => trim( $sub_sub_cat['name'] ),
                                        'parent_id' => $sub_insert_id,
                                        'owl'       => $owl_id,
                                    ),
                                    TRUE
                                );
                            }
                        }
                    }
                }
            }
        }
    }
}


// eof.