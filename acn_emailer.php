<?php

//If post author changed, act
function check_if_author_changed($post_id, $post_after, $post_before)
{
	if ($post_before->post_author != $post_after->post_author) {
        //Replace dynamic placeholders in email body
        $ex_user_data = get_userdata($post_before->post_author);
        $new_user_data = get_userdata($post_after->post_author);
        //Process placeholdersd for ex-author message
        $ex_author_msg = str_ireplace('%post_title%',$post_before->post_title,get_option('acn_ex_author_msg'));
        $ex_author_msg = str_ireplace('%ex_author_login%',$ex_user_data->user_login,$ex_author_msg);
        $ex_author_msg = str_ireplace('%new_author_login%',$new_user_data->user_login,$ex_author_msg);
        $ex_author_msg = str_ireplace('%ex_author_email%',$ex_user_data->user_email,$ex_author_msg);
        $ex_author_msg = str_ireplace('%new_author_email%',$new_user_data->user_email,$ex_author_msg);
        $ex_author_msg = str_ireplace('%new_author_id%',$post_after->post_author,$ex_author_msg);
        $ex_author_msg = str_ireplace('%ex_author_id%',$post_before->post_author,$ex_author_msg);
        $ex_author_msg = str_ireplace('%post_id%',$post_id,$ex_author_msg);
        //Process placeholdersd for new-author message
        $new_author_msg = str_ireplace('%post_title%',$post_before->post_title,get_option('acn_new_author_msg'));
        $new_author_msg = str_ireplace('%ex_author_login%',$ex_user_data->user_login,$new_author_msg);
        $new_author_msg = str_ireplace('%new_author_login%',$new_user_data->user_login,$new_author_msg);
        $new_author_msg = str_ireplace('%ex_author_email%',$ex_user_data->user_email,$new_author_msg);
        $new_author_msg = str_ireplace('%new_author_email%',$new_user_data->user_email,$new_author_msg);
        $new_author_msg = str_ireplace('%new_author_id%',$post_after->post_author,$new_author_msg);
        $new_author_msg = str_ireplace('%ex_author_id%',$post_before->post_author,$new_author_msg);
        $new_author_msg = str_ireplace('%post_id%',$post_id,$new_author_msg);
        //Prepare mail headers
        $headers = 'From: ' . get_option('acn_sender_name') . ' <' . get_option('acn_email_from') . '>' . "\r\n";
        //Send ex-author first
        wp_mail($ex_user_data->user_email,get_option('acn_ex_author_subject'),$ex_author_msg,$headers);
        //Send new-author
        wp_mail($new_user_data->user_email,get_option('acn_new_author_subject'),$new_author_msg,$headers);
	}
}

?>