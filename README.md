
# EVE-srpmail



#### Library's used
The following library's were used:
* [Composer](https://getcomposer.org/download/)
* CCP's [ESI API](https://esi.tech.ccp.is/latest/)
  * To update the API simply replace the folder with the generated PHP client from the new swagger.json.
  * To use the api, every PHP document must include the api [manually](https://github.com/jbs1/eve-srpmail/tree/master/SwaggerClient-php#manual-installation).
* [OAuth Client](https://github.com/thephpleague/oauth2-client)
  * Installed via compser (`composer require league/oauth2-client` inside the repo's root folder)
* ~~a [webhook](hook.md) to pull commits for webserver~~
