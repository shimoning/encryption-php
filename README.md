# PHP 用の簡易可逆暗号化ライブラリ

[![MIT License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat)](LICENSE)
![PHP8.1](https://img.shields.io/badge/-PHP8.1-777BB4.svg?style=flat&logo=php&labelColor=777BB4&logoColor=FFF)
[![codecov](https://codecov.io/gh/shimoning/encryption-php/graph/badge.svg)](https://codecov.io/gh/shimoning/encryption-php)

## 動作環境

- PHP >= 8.1

## Install

### composer で追加する

利用するプロジェクトの `composer.json` に以下を追加する。

```composer.json
"repositories": {
  "shimoning/encryption": {
    "type": "vcs",
    "url": "https://github.com/shimoning/encryption-php.git"
  }
},
```

その後以下でインストールする。

```bash
composer require shimoning/encryption
```

## 実装

### 暗号化

1. 文字列を openssl で暗号化
2. それを base64 でエンコード

### 復号化

1. 文字列を base64 でデコード
2. それを openssl で復号化
