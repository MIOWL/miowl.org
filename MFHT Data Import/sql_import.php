<?php

/* *********** *
 *  Variables  *
 * *********** */

$owl = 2;
$file_location = '/local_files/';
$new_file_location = '/home/miowl/www/mfht_import/';


/* ********************** *
 *  Database Connections  *
 * ********************** */

// connect to the mfht database
$mfht = new mysqli('server', 'username', 'password', 'database');

// did this connection succeed?
if($mfht->connect_errno > 0)
    die('Unable to connect to mfht database [' . $mfht->connect_error . ']');

// connect to the mfht database
$miowl = new mysqli('server', 'username', 'password', 'database');

// did this connection succeed?
if($miowl->connect_errno > 0)
    die('Unable to connect to miowl database [' . $miowl->connect_error . ']');


/* *********************** *
 *  Data Migration Begins  *
 * *********************** */

// select all the files from the MFHT database
$mfht_files = 'SELECT * FROM `cyb_files`';
if(!$mfht_files_result = $mfht->query($mfht_files))
    die('There was an error running the mfht_query [' . $mfht->error . ']');

// print out the results as we get them and process
while($row = $mfht_files_result->fetch_assoc())
{
    print "\n";

    $filenameLocation = $file_location . $row['doc_file_name'];

    if(file_exists($filenameLocation))
    {
        echo exec("cp \"" . $filenameLocation . "\" \"/Users/alan/Desktop/miowl_import/" . $row['doc_file_name'] . "\"");

        print "id: \t\t\t";
        print $row['id'] . "\n";

        print "doc_readable_name: \t";
        print $row['doc_readable_name'] . "\n";

        print "description: \t\t";
        print $row['description'] . "\n";

        print "doc_file_name: \t\t";
        print $row['doc_file_name'] . "\n";

        print "doc_ext: \t\t";
        print $row['doc_ext'] . "\n";

        print "doc_file_size: \t\t";
        print $row['doc_file_size'] . "\n";

        print "doc_updated: \t\t";
        print $row['doc_updated'] . "\n";

        print "category_id: \t\t";
        print $row['category_id'] . "\n";

        print "keywords: \t\t";
        print $row['keywords'] . "\n";

        print "copyright_id: \t\t";
        print $row['copyright_id'] . "\n";

        print "review_date: \t\t";
        print $row['review_date'] . "\n";

        print "\n";
        print "NEW: review_date: \t";
        print $row['review_date'] === '0000-00-00' ? "FALSE\n" : strtotime($row['review_date']) . "\n";

        print "\n";

        // map the old categories to the new ones
        if ($cat_statment_old = $mfht->prepare("SELECT * FROM `cyb_categories` WHERE `id` = ?"))
        {
            $old_cat = array();

            // bind the params
            $cat_statment_old->bind_param("i", $row['category_id']);

            // execute query
            $cat_statment_old->execute();

            // bind result variables
            $cat_statment_old->bind_result($old_cat['id'], $old_cat['name'], $old_cat['pid']);

            // fetch result
            $cat_statment_old->fetch();

            // close
            $cat_statment_old->close();

            if($old_cat['pid'] != '0')
            {
                // move this cat to the child object
                $old_cat['child'] = $old_cat;

                if ($cat_statment_old = $mfht->prepare("SELECT * FROM `cyb_categories` WHERE `id` = ?"))
                {
                    // bind the params
                    $cat_statment_old->bind_param("i", $old_cat['child']['pid']);

                    // execute query
                    $cat_statment_old->execute();

                    // bind result variables
                    $cat_statment_old->bind_result($old_cat['id'], $old_cat['name'], $old_cat['pid']);

                    // fetch result
                    $cat_statment_old->fetch();

                    // close
                    $cat_statment_old->close();

                    if($old_cat['child']['pid'] != '0')
                    {
                        // move this cat to the child's child object
                        $old_cat['child'] = $old_cat;

                        if ($cat_statment_old = $mfht->prepare("SELECT * FROM `cyb_categories` WHERE `id` = ?"))
                        {
                            // bind the params
                            $cat_statment_old->bind_param("i", $old_cat['child']['pid']);

                            // execute query
                            $cat_statment_old->execute();

                            // bind result variables
                            $cat_statment_old->bind_result($old_cat['id'], $old_cat['name'], $old_cat['pid']);

                            // fetch result
                            $cat_statment_old->fetch();

                            // close
                            $cat_statment_old->close();
                        }
                    }
                }
            }

            // process the results
            print "Old category layout\n";
            print_r($old_cat);
            print "\n";
        }
        else
        {
            die('There was an error running the cat_statment_old [' . $mfht->error . ']');
        }


        // now we have the old category layout, lets get the new version
        if ($cat_statment_new = $miowl->prepare("SELECT * FROM `categories` WHERE `owl` = ? AND `parent_id` = ? AND `parent_id` = '0' AND `name` LIKE ?"))
        {
            $new_cat = array();

            // bind the params
            $cat_statment_new->bind_param("iis", $owl, $old_cat['pid'], $old_cat['name']);

            // execute query
            $cat_statment_new->execute();

            // bind result variables
            $cat_statment_new->bind_result($new_cat['id'], $new_cat['name'], $new_cat['pid'], $new_cat['owl']);

            // fetch result
            $cat_statment_new->fetch();

            // close
            $cat_statment_new->close();

            if($new_cat['id'] != FALSE && isset($old_cat['child']) && $old_cat['child'])
            {
                // move this cat to its parent's object
                $new_cat['parent'] = $new_cat;
                $new_cat['id'] = $new_cat['name'] = $new_cat['pid'] = $new_cat['owl'] = null;

                if ($cat_statment_new = $miowl->prepare("SELECT * FROM `categories` WHERE `owl` = ? AND `parent_id` = ? AND `name` LIKE ?"))
                {
                    // bind the params
                    $cat_statment_new->bind_param("iss", $owl, $new_cat['parent']['id'], $old_cat['child']['name']);

                    // execute query
                    $cat_statment_new->execute();

                    // bind result variables
                    $cat_statment_new->bind_result($new_cat['id'], $new_cat['name'], $new_cat['pid'], $new_cat['owl']);

                    // fetch result
                    $cat_statment_new->fetch();

                    // close
                    $cat_statment_new->close();

                    if($new_cat['id'] != FALSE && $old_cat['child']['pid'] != '0')
                    {
                        // move this cat to its parent's object
                        $new_cat['parent'] = $new_cat;
                        $new_cat['id'] = $new_cat['name'] = $new_cat['pid'] = $new_cat['owl'] = null;

                        if ($cat_statment_new = $miowl->prepare("SELECT * FROM `categories` WHERE `owl` = ? AND `parent_id` = ? AND `name` LIKE ?"))
                        {
                            // bind the params
                            $cat_statment_new->bind_param("iss", $owl, $new_cat['parent']['id'], $old_cat['child']['child']['name']);

                            // execute query
                            $cat_statment_new->execute();

                            // bind result variables
                            $cat_statment_new->bind_result($new_cat['id'], $new_cat['name'], $new_cat['pid'], $new_cat['owl']);

                            // fetch result
                            $cat_statment_new->fetch();

                            // close
                            $cat_statment_new->close();
                        }
                    }
                }
            }

            // process the results
            print "New category layout\n";
            print_r($new_cat);

            if($new_cat['id'])
            {
                print "\nNew category ID: " . $new_cat['id'];
                $new_cat_id = $new_cat['id'];
            }
            elseif (isset($new_cat['parent']))
            {
                print "\nNew category ID: " . $new_cat['parent']['id'];
                $new_cat_id = $new_cat['parent']['id'];
            }
            else
            {
                print "\nUNCATEGORIZED!\n";
                $new_cat_id = FALSE;
            }

        }
        else
        {
            die('There was an error running the cat_statment_new [' . $miowl->error . ']');
        }

        print "\n";

        // map the old license id's to the new ones
        $license_id = array(
            '1', '7',    // The GNU General Public License
            '2', '8',    // The BSD Clause License
            '3', '10'    // MIT License
        );

        // do the databse insert
        if ($insert = $miowl->prepare("INSERT INTO uploads (upload_time, upload_user, owl, file_name, full_path, upload_category, upload_license, file_type, client_name, file_size, file_ext, description, revision_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))
        {
            // build the params
            $insert_data = array();
            $insert_data['timestamp']    = time();
            $insert_data['user']         = 6;
            $insert_data['full_path']    = $new_file_location . $row['doc_file_name'];
            $insert_data['cat']          = $new_cat_id != TRUE ? '' : $new_cat_id;
            $insert_data['doc_ext']      = '.' . $row['doc_ext'];
            $insert_data['rev_date']     = $row['review_date'] === '0000-00-00' ? NULL : strtotime($row['review_date']);
            $insert_data['license']      = $license_id[$row['copyright_id']];

            // if the description is below 255 with the old keywords added on then use that. Else just use the description...
            if(strlen(trim($row['description']) . "\n\n" . trim($row['keywords'])) <= 255)
                $insert_data['description'] = trim($row['description']) . "\n\n" . trim($row['keywords']);
            else
                $insert_data['description'] = trim($row['description']);

            // bind the params
            $insert->bind_param(
                            "iiissiississi",
                            $insert_data['timestamp'],
                            $insert_data['user'],
                            $owl,
                            $row['doc_readable_name'],
                            $insert_data['full_path'],
                            $insert_data['cat'],
                            $insert_data['license'],
                            $row['doc_ext'],
                            $row['doc_file_name'],
                            $row['doc_file_size'],
                            $insert_data['doc_ext'],
                            $insert_data['description'],
                            $insert_data['rev_date']
            );

            // execute query
            $insert->execute();

            // close
            $insert->close();

            // inform the user its inserted
            print "\"{$row['doc_readable_name']}\" Successfully imported into the database...\n";
        }
        else
        {
            die('There was an error inserting the new upload [' . $miowl->error . ']');
        }
    }

    else
        print "\n\"{$row['doc_readable_name']}\" Not found and therefor not added to the database...\n";

    print "\n-=========================================================================-\n";
}

// close the database connections
$miowl->close();
$mfht->close();

    print "\nDatabase import successfully finished.\n";

?>
