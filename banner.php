<?php

$file = './close.png';
$type = mime_content_type($file);
header('Content-Type:'.$type);
header('Content-Length: ' . filesize($file));

        $db_user = 'a99876_tiger';
        $db_pass = 'Qew2X5OOO4';
        $db_name = 'a99876_tiger';
        $db_host = 'a99876.mysql.mchost.ru';

        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'empty_ip';
        $agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'empty_agent';
        $page= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'empty_page';
        $link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

        $sql = 'SELECT * from banner_log
                WHERE
                        ip_address = "'.$ip.'" AND
                        user_agent = "'.$agent.'" AND
                        page_url = "'.$page.'"
        ';
        $result = mysqli_query($link, $sql);
        if($result->num_rows >0)
        {
                $row = mysqli_fetch_array($result);
                $new_count = $row['views_count'] + 1;
                $update = 'UPDATE banner_log SET views_count = '.$new_count.', view_date = NOW() WHERE id = '.$row['id'];
                mysqli_query($link,$update);
        }
        else
        {
                $insert = 'INSERT INTO banner_log (ip_address, user_agent, view_date, page_url)
                        VALUES ("'.$ip.'","'.$agent.'",NOW(),"'.$page.'")';
                mysqli_query($link,$insert);
        }
        mysqli_close($link);

readfile($file);


?>

