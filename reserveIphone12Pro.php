<?php

$models = [
    'MGLL3CH/A' => '512GB 金色',
    'MGLA3CH/A' => '128GB 银色',
    'MGLD3CH/A' => '128GB 海蓝色',
    'MGLJ3CH/A' => '512GB 石墨色',
    'MGLF3CH/A' => '256GB 银色',
    'MGL93CH/A' => '128GB 石墨色',
    'MGLE3CH/A' => '256GB 石墨色',
    'MGLH3CH/A' => '256GB 海蓝色',
    'MGLM3CH/A' => '512GB 海蓝色',
    'MGLC3CH/A' => '128GB 金色',
    'MGLG3CH/A' => '256GB 金色',
    'MGLK3CH/A' => '512GB 银色',
];

function curlGet($url = "https://reserve-prime.apple.com/CN/zh_CN/reserve/A/availability.json")
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_URL, $url);
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

function objectToArray($obj)
{
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return null;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)objectToArray($v);
        }
    }
    return $obj;
}

$stores = curlGet("https://reserve-prime.apple.com/CN/zh_CN/reserve/A/stores.json");
$stores = json_decode($stores);
$stores = objectToArray($stores->stores);
$storeArray = [];
foreach ($stores as $store) {
    $storeArray[$store['storeNumber']] = $store['city'] . ' - ' . $store['storeName'];
}

while (true) {
    $result = curlGet();
    if ($result) {
        $result = json_decode($result);
        $result = objectToArray($result);
        $wanxiangcheng = $result['stores']['R502'];
        $taiguli = $result['stores']['R580'];

        foreach ($wanxiangcheng as $item) {
            if ($item['availability']['unlocked']) {
                echo "============================================================" . "\n";
                echo '万象城有' . $models[$item] . ' 📱 可以预约了 🔥🔥🔥🔥🔥🔥' . "\n";
                echo "============================================================" . "\n";
            }
        }

        foreach ($taiguli as $item) {
            if ($item['availability']['unlocked']) {
                echo "============================================================" . "\n";
                echo '太古里有' . $models[$item] . ' 📱 可以预约了 🔥🔥🔥🔥🔥🔥' . "\n";
                echo "============================================================" . "\n";
            }
        }

        foreach ($result['stores'] as $key => $value) {
            foreach ($value as $k => $v) {
                if ($v['availability']['unlocked']) {
                    echo ' 📢📢📢 🔥🔥🔥🔥🔥🔥 有 📱 可以预约了 ' . $storeArray[$key] . ' - ' . $models[$k] . "\n";
                }
            }
        }

    } else {
        echo "💣💣💣💣💣💣 !!!数据获取失败!!! 💣💣💣💣💣💣";
        exit;
    }

    sleep(10);
}
