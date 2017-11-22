
# EVE-srpmail

## How to install

Download the clean source from the [latest release](https://github.com/jbs1/eve-sso/releases) or clone this repository and also clone/download the [ESI php implementation](https://github.com/jbs1/esi-php-client) somewhere and run composer in this dir.
```shell
git clone git@github.com:jbs1/esi-php-client.git
git clone git@github.com:jbs1/eve-sso.git
composer install -d eve-sso
```

Then setup the `provider.php` with the proper scopes and secrets from CCP's [dev-site](https://developers.eveonline.com/applications).

Then you can either work directly in the sso dir or you copy the index.php to your webdir and symlink the important files.
```shell
export webdir=<path to webdir>
export ssodir=<path to sso-repo dir>
cp $ssodir/index.php $webdir
ln -vsf $ssodir/header.php $webdir
ln -vsf $ssodir/oauth.php $webdir
ln -vsf $ssodir/oauth-func.php $webdir
ln -vsf $ssodir/ses-info.php $webdir
```
The path's should be absolute without trailing /.  




#### Resources used:
* [Composer](https://getcomposer.org/download/)
* CCP's [ESI API](https://esi.tech.ccp.is/latest/)
* [OAuth Client](https://github.com/thephpleague/oauth2-client)
