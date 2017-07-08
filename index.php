after：".$data -> after ."\n
---项目--
项目名称：".$data -> project ->name ."\n
项目路径：".$data -> project ->path ."\n
项目描述：".$data -> project ->description ."\n
项目地址：".$data -> project ->url ."\n
项目Git：".$data -> project ->git_http_url ."\n
项目分支：".$data -> project ->default_branch ."\n
---仓库--
仓库名称：".$data -> repository ->name ."\n
仓库链接：".$data -> repository ->url ."\n
仓库描述：".$data -> repository ->description ."\n
";
 return $messages;
    }
switch ($hook_name){
    case "push_hooks":
        $messages=fnPush($git_Data);
        break;
    case "note_hooks":
        $messages=fn_Note($git_Data);
        break;
    case "merge_request_hooks":
        $messages=fnMerge_request($git_Data);
        break;
    case "issue_hooks":
        $messages=fn_Issue($git_Data);
        break;
    case "tag_push_hooks":
        $messages=fn_Tag($git_Data);
        break;

    default:
    $messages="Error ! The ip is ".$_SERVER["REMOTE_ADDR"];
    break;
}


/*************
 *
 *  To DingTalk
 *
 ************/
$access_token="";
$isAtAll=false;
$data = array ('msgtype' => 'text','text' => array ('content' => $messages,),'at' => array ('atMobiles' => array (),'isAtAll' => $isAtAll,),);
$data_string = json_encode($data);
$urls="https://oapi.dingtalk.com/robot/send?access_token=".$access_token;
$ch = curl_init();
curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json; charset=utf-8'));
curl_setopt($ch, CURLOPT_URL, "$urls");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
$retBase = curl_exec($ch);
curl_close($ch);
}
