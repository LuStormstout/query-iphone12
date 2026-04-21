# reserveIphone12Pro

[English](./README.md) | [简体中文](./README.zh-CN.md)

---

## Description

A simple script to check whether iPhone 12 Pro and iPhone 12 Pro Max are available for reservation.

This tool is useful for quickly monitoring stock availability without manually refreshing the official website.

---

## Environment

- PHP > 7.0 (requires `php-curl` extension)
- Python > 3.8 (requires `requests` library)

---

## Installation

### PHP

Make sure `php-curl` is enabled:

```shell
php -m | grep curl
```

### Python

Install dependencies:

```shell
pip install requests
```

---

## Usage

### iPhone 12 Pro

```shell
php /your/path/to/project/php/reserveIphone12Pro.php
```

### iPhone 12 Pro Max

```shell
php /your/path/to/project/php/reserveIphone12ProMax.php
```

### Python Version (Experimental)

```shell
python /your/path/to/project/python/query_iphone.py
```

---

## Output

- If available: shows reservable stock information
- If unavailable: shows no stock message

---

## Screenshot

![screenshot](./assets/images/reserve-iphone12pro.jpg)
