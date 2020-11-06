<?php

$models = [
    'MGCA3CH/A' => 'iPhone 12 Pro Max 512GB 银色',
    'MGC03CH/A' => 'iPhone 12 Pro Max 128GB 石墨色',
    'MGC63CH/A' => 'iPhone 12 Pro Max 256GB 金色',
    'MGC13CH/A' => 'iPhone 12 Pro Max 128GB 银色',
    'MGC93CH/A' => 'iPhone 12 Pro Max 512GB 石墨色',
    'MGC53CH/A' => 'iPhone 12 Pro Max 256GB 银色',
    'MGCE3CH/A' => 'iPhone 12 Pro Max 512GB 海蓝色',
    'MGC43CH/A' => 'iPhone 12 Pro Max 256GB 石墨色',
    'MGC23CH/A' => 'iPhone 12 Pro Max 128GB 金色',
    'MGCC3CH/A' => 'iPhone 12 Pro Max 512GB 金色',
    'MGC33CH/A' => 'iPhone 12 Pro Max 128GB 海蓝色',
    'MGC73CH/A' => 'iPhone 12 Pro Max 256GB 海蓝色',
];

/**
 * @param string $url
 * @return bool|string
 */
function curlGet($url = "https://reserve-prime.apple.com/CN/zh_CN/reserve/G/availability.json")
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_URL, $url);
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

/**
 * @param $obj
 * @return array|null
 */
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

$stores = curlGet("https://reserve-prime.apple.com/CN/zh_CN/reserve/G/stores.json");
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

        if (isset($result) && array_key_exists('stores', $result)) {

            foreach ($result['stores'] as $key => $value) {
                foreach ($value as $k => $v) {
                    if ($v['availability']['unlocked']) {
                        echo date('Y-m-d H:i:s') . ' 📢📢📢 🔥🔥🔥🔥🔥🔥 有 📱 可以预约了 ' . $storeArray[$key] . ' - ' . $models[$k] . "\n";
                    }
                }
            }
        }

    } else {
        echo date('Y-m-d H:i:s') . "💣💣💣💣💣💣 !!!数据获取失败!!! 💣💣💣💣💣💣";
        exit;
    }

    sleep(5);
}
