# Rosenfield Collection Theme

## Requirements

| Requirement | How to Check | How to Install |
| :---------- | :----------- | :------------- |
| PHP >= 5.4 | `php -v` | [php.net](http://php.net/manual/en/install.php) |
| WordPress >= 5.2 | `Admin Footer` | [wordpress.org](https://codex.wordpress.org/Installing_WordPress) |
| Genesis >= 3.1.1 | `Theme Page` | [studiopress.com](http://www.shareasale.com/r.cfm?b=346198&u=1459023&m=28169&urllink=&afftrack=) |
| Composer >= 1.5.0 | `composer --version` | [getcomposer.org](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx) |
| Node >= 9.10.1 | `node -v` | [nodejs.org](https://nodejs.org/) |
| NPM >= 5.6.0 | `npm -v` | [npm.js](https://www.npmjs.com/) |

## Installation

Install node dependencies and build the theme assets:

```shell
npm install && npm run build
```

## Usage

Static assets are organized in the `assets` directory. This folder contains theme scripts, styles, images, fonts, views and language translation files. All of the main theme styles are contained in the `assets/css/main.css` file, the `style.css` file at the root of the theme is left blank intentionally and only contains the required stylesheet header comment. 

## Development

Please refer to the Laravel Mix documentation for further information on how to use the `webpack.mix.js` file.

All build tasks are located in the theme's `package.json` file, under the *scripts* section.
