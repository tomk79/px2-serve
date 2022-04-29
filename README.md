# px2-serve

[Pickles 2](https://pickles2.pxt.jp/) の開発用ローカルサーバーを起動します。


## Usage - 使い方

### インストール

```
composer require tomk79/px2-serve;
```

### セットアップ

`px-files/config.php` に、 `tomk79\pickles2\px2serve\serve::register()` の設定を追加する。

```php
	// funcs: Before sitemap
	$conf->funcs->before_sitemap = [
		// px2-serve
		tomk79\pickles2\px2serve\serve::register(),
	];
```

### プレビュー環境サーバーを起動する

```
php path/to/.px_execute.php "/?PX=serve";
```

### パブリッシュ環境サーバーを起動する

```
php path/to/.px_execute.php "/?PX=serve.pub";
```


起動したら、ブラウザで `http://localhost:8080/` にアクセスする。


## オプション

### `S`: サーバー名を指定して起動する

```
php path/to/.px_execute.php "/?PX=serve&S=localhost:8080";
```


## 更新履歴 - Change log

### tomk79/px2-serve v0.1.3 (リリース日未定)

- `S` オプションを追加。
- `.htaccess` から `RewriteCond` 中の拡張子のパターンを取り込むようになった。

### tomk79/px2-serve v0.1.2 (2022年4月24日)

- `$conf->controot` が深いパスに設定されている場合に、`$_SERVER['PATH_INFO]` が誤った値にセットされる不具合を修正。

### tomk79/px2-serve v0.1.1 (2022年4月19日)

- パブリッシュ環境を起動する `PX=serve.pub` を追加。

### tomk79/px2-serve v0.1.0 (2022年4月17日)

- Initial Release



## ライセンス - License

MIT License
https://opensource.org/licenses/mit-license.php


## 作者 - Author

- Tomoya Koyanagi <tomk79@gmail.com>
- website: <https://www.pxt.jp/>
- Twitter: @tomk79 <https://twitter.com/tomk79/>
