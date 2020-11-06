# coding:utf-8

import time
import requests

iphone_models = {
    'MGLL3CH/A': '512GB 金色',
    'MGLA3CH/A': '128GB 银色',
    'MGLD3CH/A': '128GB 海蓝色',
    'MGLJ3CH/A': '512GB 石墨色',
    'MGLF3CH/A': '256GB 银色',
    'MGL93CH/A': '128GB 石墨色',
    'MGLE3CH/A': '256GB 石墨色',
    'MGLH3CH/A': '256GB 海蓝色',
    'MGLM3CH/A': '512GB 海蓝色',
    'MGLC3CH/A': '128GB 金色',
    'MGLG3CH/A': '256GB 金色',
    'MGLK3CH/A': '512GB 银色',
    'MGCA3CH/A': 'iPhone 12 Pro Max 512GB 银色',
    'MGC03CH/A': 'iPhone 12 Pro Max 128GB 石墨色',
    'MGC63CH/A': 'iPhone 12 Pro Max 256GB 金色',
    'MGC13CH/A': 'iPhone 12 Pro Max 128GB 银色',
    'MGC93CH/A': 'iPhone 12 Pro Max 512GB 石墨色',
    'MGC53CH/A': 'iPhone 12 Pro Max 256GB 银色',
    'MGCE3CH/A': 'iPhone 12 Pro Max 512GB 海蓝色',
    'MGC43CH/A': 'iPhone 12 Pro Max 256GB 石墨色',
    'MGC23CH/A': 'iPhone 12 Pro Max 128GB 金色',
    'MGCC3CH/A': 'iPhone 12 Pro Max 512GB 金色',
    'MGC33CH/A': 'iPhone 12 Pro Max 128GB 海蓝色',
    'MGC73CH/A': 'iPhone 12 Pro Max 256GB 海蓝色',
}

urls = {
    1: {
        'iphone12_pro_url': 'https://reserve-prime.apple.com/CN/zh_CN/reserve/A/availability.json',
        'iphone12_pro_stores_url': 'https://reserve-prime.apple.com/CN/zh_CN/reserve/A/stores.json'
    },
    2: {
        'iphone12_pro_max_url': 'https://reserve-prime.apple.com/CN/zh_CN/reserve/G/availability.json',
        'iphone12_pro_max_stores_url': 'https://reserve-prime.apple.com/CN/zh_CN/reserve/G/stores.json'
    }
}

iphone_url = 'https://reserve-prime.apple.com/CN/zh_CN/reserve/A/availability.json'
stores_url = 'https://reserve-prime.apple.com/CN/zh_CN/reserve/A/stores.json'

while True:
    print('1、iPhone 12 Pro')
    print('2、iPhone 12 Pro Max')
    model = int(input('请输入手机型号编号:'))
    if model == 1:
        iphone_url = urls[model]['iphone12_pro_url']
        stores_url = urls[model]['iphone12_pro_stores_url']
        break
    elif model == 2:
        iphone_url = urls[model]['iphone12_pro_max_url']
        stores_url = urls[model]['iphone12_pro_max_stores_url']
        break
    else:
        print('你的输入有误，请输入正确的编号。')
        continue

stores_list = list()
stores = requests.get(stores_url).json()
for store in stores['stores']:
    stores_list.append(store)


def print_waiting(seconds=3):
    time.sleep(1)
    print('...')
    time.sleep(1)
    print('..')
    time.sleep(1)
    print('.')
    time.sleep(seconds)


def get_store_info(store_code):
    for item in stores_list:
        if store_code == item['storeNumber']:
            return item


while True:
    try:
        result = requests.get(iphone_url)
    except:
        print('获取数据失败！正在重新加载')
        print_waiting()
        continue
    result = result.json()

    if result and 'stores' in result:
        for key, value in result['stores'].items():
            for model, has_iphone in value.items():
                store_info = get_store_info(key)
                if has_iphone['availability']['unlocked']:
                    print(
                        f"📢 有 iPhone 可以预约了 {store_info['city']} - {store_info['storeName']} - {iphone_models[model]}")
    else:
        print('获取数据失败！正在重新加载')
        print_waiting()
        continue

    time.sleep(3)
