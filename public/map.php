<?php

/**
 * 向服务器上传结果
 */

require './private/dbcfg.php';
require './private/illegal_words_list.php';
require './utils.php';
require './sqlgenerator.php';

$request_type = $_SERVER['REQUEST_METHOD']; //请求类型GET POST PUT DELETE
$json = file_get_contents('php://input'); //获取CURL GET POST PUT DELETE 请求的数据
$data = json_decode($json);


$sqllink = @mysqli_connect(HOST, USER, PASS, DBNAME) or die('数据库连接出错');
mysqli_set_charset($sqllink, 'utf8');

$result = '';

switch ($request_type) {
    case 'POST':
        @$type = trim((string)($data->type));
        @$name = trim((string)($data->name));
        @$desc = trim((string)($data->desc));
        @$lng = ($data->lng);
        @$lat = ($data->lat);
        @$like = ($data->like);
        @$dislike = ($data->dislike);
        @$ip = trim((string)($data->ip));

        $sql = 'INSERT 
        INTO map (`type`, `name`, `desc`, `lng`, `lat`, `like`, `dislike`, `ip`, `is_deleted`)
        VALUES ("' . anti_inj($type) . '","' . cator_to_cn_censorship(anti_inj($name)) . '","' . cator_to_cn_censorship(anti_inj($desc)) . '","' . $lng . '","' . $lat . '","' . $like . '","' . $dislike . '","' . anti_inj($ip) . '", "0");
        ';

        $result = mysqli_query($sqllink, $sql);

        echo ($result);
        break;
    case 'GET':
        /** IP */
        @$ip_ori = $_GET['ip'];
        /** 个数, 不填为全部 */
        @$count_ori = $_GET['count'];
        @$type_ori = $_GET['type'];
        @$kword_ori = $_GET['kword'];
        @$under_ori = $_GET['under'];

        $ip = '';
        $count = 0;
        $type = '';
        $kword = '';
        $under = 0; //0 全部，1 地下， 2 地面
        if (is_numeric($count_ori)) {
            $count = (int)$count_ori;
        }

        if ($count == 0) {
            $count = '*';
        } else {
            $count = 'TOP ' . $count;
        }
        if (is_numeric($under_ori)) {
            switch ($under_ori) {
                case 0:
                    $under = '';
                    break;
                case 1:
                    $under = '1';
                    break;
                case 2:
                    $under = '0';
                    break;
                default:
                    break;
            }
        }
        if (isset($ip_ori)) {
            $ip = trim(anti_inj((string)$ip_ori));
        }
        $typearr = [];
        if (isset($type_ori)) {
            $type = trim(anti_inj((string)$type_ori));
            if ($type != '') {
                $types = explode('|', $type);
                if (is_string($types)) {
                    $types = [$type];
                }
                if (count($types) > 0) {
                    for ($i = 0; $i < count($types); $i++) {
                        array_push($typearr, ['', ['type', $types[$i]]]);
                    }
                }
            }
        }
        if (isset($kword_ori)) {
            $kword = trim(anti_inj((string)$kword_ori));
        }


        $select = [
            'AND',
            [
                ['OR', $typearr],
                [
                    'OR', [
                        ['LIKE', ['name', $kword]],
                        ['LIKE', ['desc', $kword]]
                    ]
                ],
                ['', ['ip', $ip]],
                ['', ['is_underground', $under]],
                ['', ['is_deleted', '0']]
            ]
        ];

        $geneRes = get_condition($select);
        if ($geneRes != '') {
            $geneRes = "WHERE $geneRes";
        }

        $sql = "SELECT $count
        FROM map
        $geneRes
        ORDER BY `like` DESC;
        ";

        $result = mysqli_query($sqllink, $sql);

        $res = [];

        if ($result->num_rows > 0) {
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                array_push($res, [
                    'id' => $row['id'],
                    'type' => $row['type'],
                    'name' => $row['name'],
                    'desc' => $row['desc'],
                    'lng' => $row['lng'],
                    'lat' => $row['lat'],
                    'like' => $row['like'],
                    'dislike' => $row['dislike'],
                    'ip' => $row['ip'],
                    'is_deleted' => $row['is_deleted'],
                    'create_date' => $row['create_date'],
                    'update_date' => $row['update_date'],
                ]);
                $i++;
            }
        }

        echo json_encode($res);

        break;
    case 'DELETE':

        break;
    case 'PUT':

        break;
    default:
        break;
}
