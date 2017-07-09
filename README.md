docker-jma-xml-downloader  

## 概要  
気象庁は収集した気象データの一部を一般に公開しています。  
気象庁XMLをダウンロードするだけのプログラムとDockerイメージを作ったので説明します。  
説明は要らないからとりあえず気象庁XML欲しい、という方はdocker-compose.yml書いてください。  
残念なプログラムを見たい人は最下部にGitHubのリンク貼ったのでそっちをお願いします。  

ベースイメージ : alpine:3.6  
プログラム : php7  

プログラム類はMITライセンスにしたので使いたい奇特な人は好きに使ってください。    

## 気象庁XMLについて  
気象庁では気象庁が収集した気象データを、XML形式のファイルにして公開しています。    
天気予報、気象警報・注意報、地震、異常天候の予測など、様々なデータがあり、定時または随時更新されています。    

以前はPubsubhubbubを使った登録制のPush型配信だけでした。  
今はPull型のデータ公開も行っており、自由にダウンロードすることが可能です。  
Atomフィードを取得、解析し、XMLデータを取得するだけなので、とても簡単です。  

詳細は気象庁ホームページを参照してください。  
気象データ高度利用ポータルサイト  
http://www.data.jma.go.jp/developer/index.html  

※ダウンロードした気象データは気象庁の公開するルールに従って使いましょう。  
※気象データの利用は自己責任です。  

## docker-compose.yml  
気象庁では気象データを以下の4つに分類分けし公開しています。  
今回作ったプログラム中では、公開されているAtomフィードのURLに従って以下の通り環境変数を用意しています。  

* 定時 : DATA_TYPE_REGULAR  
* 随時 : DATA_TYPE_EXTRA  
* 地震火山 : DATA_TYPE_EQVOL  
* その他 : DATA_TYPE_OTHER  

各環境変数を`true`に設定することで、対象の気象庁XMLをダウンロードします。  
下記の通り設定した場合、「定時」の気象庁XMLだけを対象にします。  

~~~
version: '2'

services:
  jma-xml-downloader:
    image:  ancolin/jma-xml-downloader
    volumes:
    - /tmp:/app
    environment:
    - FEED_DIR=/app/feed
    - DATA_DIR=/app/data

    - DATA_TYPE_REGULAR=true
    - DATA_TYPE_EXTRA=false
    - DATA_TYPE_EQVOL=false
    - DATA_TYPE_OTHER=false
~~~

## コンテナの起動 (プログラムの実行)  
`docker-compose run`で実行する使い捨て型で、常駐はしません。  
下記のようなコマンドで実行してください。  
`docker-compose run --rm jma-xml-downloader`  

気象庁では先述の4情報種別それぞれに「高頻度フィード」と「長期フィード」を用意しています。  
標準では高頻度フィードを取得するようになっています。  
もし長期フィードのデータを取得したいときは、下記のように引数に`longer`を指定して実行してください。  
`docker-compose run --rm jma-xml-downloader longer`  

cronに書いて定期的に実行する、とかすれば良いと思います。  
「毎秒実行する」とか相手サーバに負荷がかかるようなことは避けてあげましょう。  
あとバックアップ、圧縮、削除などは全くしないので、そのあたりは自分でshellスクリプト書くとかしてください。  

## プログラムとDockerfile  
プログラムとDockerfileはこちらで公開しています。  
https://github.com/ancolin/docker-jma-xml-downloader  

## Copyright and license  
Code copyright 2017 ancolin.  
Code released under the MIT License.
