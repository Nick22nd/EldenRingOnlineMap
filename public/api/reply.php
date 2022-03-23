<?php

/**
 * 回复后端
 */

require './private/dbcfg.php';
require './utils.php';
require './sqlgenerator.php';

$request_type = $_SERVER['REQUEST_METHOD']; //请求类型GET POST PUT DELETE
$json = file_get_contents('php://input'); //获取CURL GET POST PUT DELETE 请求的数据
$data = json_decode($json);


$sqllink = @mysqli_connect(HOST, USER, PASS, DBNAME) or die('数据库连接出错');
mysqli_set_charset($sqllink, 'utf8mb4');

$result = '';

switch ($request_type) {
    case 'POST':
        @$pid = trim((string)($data->pid));
        @$content = trim((string)($data->content));
        @$like = ($data->like);
        @$dislike = ($data->dislike);
        @$ip = trim((string)($data->ip));

        $sql = 'INSERT 
        INTO apo_reply (`pid`, `content`, `like`, `dislike`, `ip`, `is_deleted`)
        VALUES ("' . anti_inj($pid) . '","' . cator_to_cn_censorship(anti_inj($content)) . '","' . $like . '","' . $dislike . '","' . anti_inj($ip) . '", "0");
        ';

        $result = mysqli_query($sqllink, $sql);

        echo json_encode($result);
        break;
    case 'GET':
        @$id_ori = $_GET['id'];
        @$pid_ori = $_GET['pid'];
        /** IP */
        @$ip_ori = $_GET['ip'];
        /** 个数, 不填为全部 */
        @$count_ori = $_GET['count'];
        @$kword_ori = $_GET['kword'];

        $id = '';
        $ip = '';
        $pid = 0;
        $count = 0;
        $kword = '';
        if (is_numeric($pid_ori)) {
            $pid = (int)$pid_ori;
        }
        if (is_numeric($count_ori)) {
            $count = (int)$count_ori;
        }
        if (is_numeric($id_ori)) {
            $id = (int)$id_ori;
        }

        if ($count == 0) {
            $count = '*';
        } else {
            $count = 'TOP ' . $count;
        }
        if (isset($ip_ori)) {
            $ip = trim(anti_inj((string)$ip_ori));
        }
        if (isset($kword_ori)) {
            $kword = trim(anti_inj((string)$kword_ori));
        }

        $select = [];

        if ($id <= 0) {
            $select = [
                'AND',
                [
                    ['', ['pid', $pid]],
                    [
                        'OR', [
                            ['LIKE', ['content', $kword]]
                        ]
                    ],
                    ['', ['ip', $ip]],
                    ['', ['is_deleted', '0']]
                ]
            ];
        } else {
            $select =  ['', ['id', $id]];
        }

        $geneRes = get_condition($select);
        if ($geneRes != '') {
            $geneRes = "WHERE $geneRes";
        }

        $sql = "SELECT $count
        FROM apo_reply
        $geneRes
        ORDER BY `update_date` DESC;
        ";

        $result = mysqli_query($sqllink, $sql);

        $res = [];

        if ($result->num_rows > 0) {
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                array_push($res, [
                    'id' => $row['id'],
                    'pid' => $row['pid'],
                    'content' => $row['content'],
                    'like' =>  (int)$row['like'],
                    'dislike' => (int)$row['dislike'],
                    'ip' => $row['ip'],
                    'is_deleted' => (bool)(int)$row['is_deleted'],
                    'create_date' => $row['create_date'],
                    'update_date' => $row['update_date'],
                ]);
                $i++;
            }
        }

        echo json_encode($res);

        break;
    case 'DELETE':
        @$id = trim((string)($data->id));

        $sql = "UPDATE apo_reply
        SET `is_deleted`=1
        WHERE `id`=$id;";

        $result = mysqli_query($sqllink, $sql);

        echo ($result);

        break;
    case 'PATCH':
        @$id =property_exists($data, 'id') ?  trim((string)($data->id)): null;
        @$pid =property_exists($data, 'pid') ?  trim((string)($data->pid)): null;
        @$content = property_exists($data, 'content') ? trim((string)($data->name)): null;
        @$like =property_exists($data, 'like') ?  (string)($data->like): null;
        @$dislike =property_exists($data, 'dislike') ?  (string)($data->dislike): null;
        @$ip =property_exists($data, 'ip') ?  trim((string)($data->ip)): null;
        @$is_deleted = property_exists($data, 'is_deleted') ? (string)($data->is_deleted): null;

        if ($is_deleted == 'false') $is_deleted = "0";

        $select = [
            ['pid', $pid],
            ['content', $content],
            ['like', $like, true, 'increment'],
            ['dislike', $dislike, true, 'increment'],
            ['ip', $ip],
            ['is_deleted', $is_deleted, true],
        ];

        $geneRes = patch_condition($select);

        $sql = "UPDATE apo_reply
        SET $geneRes
        WHERE `id`=$id;";

        $result = mysqli_query($sqllink, $sql);

        echo ($result);
        break;
    default:
        break;
}
