<?php

require('../../../include/mellivora.inc.php');

enforce_authentication(CONST_USER_CLASS_MODERATOR);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    validate_xsrf_token($_POST[CONST_XSRF_TOKEN_KEY]);

    if ($_POST['action'] == 'new') {

        require_fields(array('title'), $_POST);

       $id = db_insert(
          'categories',
          array(
             'added'=>time(),
             'added_by'=>$_SESSION['id'],
             'title'=>$_POST['title'],
             'description'=>$_POST['description'],
             'exposed'=>1,
             'available_from'=>strtotime(wactf_start()),
             'available_until'=>strtotime(wactf_end())
          )
       );

        if ($id) {
            redirect(Config::get('MELLIVORA_CONFIG_SITE_ADMIN_RELPATH') . 'edit_category.php?id='.$id);
        } else {
            message_error('Could not insert new category.');
        }
    }
}