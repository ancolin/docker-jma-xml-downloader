docker-jma-xml-downloader

## 概要
気象庁の提供しているXML電文をダウンロードするプログラムと、その実行環境のDockerfileです。  
`docker build`して`docker-compose run`すればすぐ使うことができます。
自由に利用して貰えればと思います。

気象データやその取扱の詳細は気象庁「気象データ高度利用ポータルサイト」を参照してください。
http://www.data.jma.go.jp/developer/index.html

**このリポジトリで公開しているプログラム等は自己責任でご利用ください。
どのような問題が発生しても責任は負えません。**

**毎秒実行とか気象庁のサーバに負荷をかける使い方は控えましょう。**

**バックアップ、圧縮、削除などはプログラム中では一切行いません。**

## イメージのビルド
以下のようなコマンドでビルドしてください。  
`docker build -t ancolin/jma-xml-downloader:latest ./`

## docker-compose.ymlの書き方
環境変数が2種、計6つ用意されています。

1. ダウンロードしたデータの保存先
Atomフィードと気象データの保存先を指定することができます。
この変数を初期状態から変更する意味は特にないですが、各ディレクトリをホストと共有することでデータの永続的保存ができます。
    - FEED_DIR= **Atomフィードの保存先**
    - DATA_DIR= **気象データの保存先**
1. ダウンロードするデータの種類  
ダウンロードする気象データの種類を選択することができます。
有効(true)にすることでダウンロードを実行します。
分類については気象データ高度利用ポータルサイトを参照してください。
    - DATA_TYPE_REGULAR=  **定時**
    - DATA_TYPE_EXTRA=    **随時**
    - DATA_TYPE_EQVOL=    **地震火山**
    - DATA_TYPE_OTHER=    **その他**

## ダウンロードの実行
`docker-compose run`で実行する使い捨て型で、常駐はしません。
以下のようなコマンドで実行してください。  
`docker-compose run --rm jma-xml-downloader`

もし長期フィードのデータを取得したいときは、引数に`longer`を指定して実行してください。  
`docker-compose run --rm jma-xml-downloader longer`

## Copyright and license
Code copyright 2017 ancolin.
Code released under the MIT License.
