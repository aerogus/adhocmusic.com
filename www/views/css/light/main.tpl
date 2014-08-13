/**************
 * general
 **************/
body {
    background: #a0a0a0;
    font-family: Arial;
    font-size: 12px;
    line-height: 1.2em;
    color: #333;
}
#conteneur {
    position: relative;
    width: 1000px;
    margin: 20px auto;
}
#header {
}
#main 
{
    margin-top: 20px;
    position: relative;
}
#logo {
    display: inline-block;
    width: 110px;
    height: 97px;
    background: url({#STATIC_URL#}/img/logo_adhoc.png);
}
#logo span {
    display: none;
}
#megabanner {
    float: right;
    width: 728px;
    height: 90px;
}
#megabanner img {
    width: 728px;
    height: 90px;
    display: block;
}
#featured {
    width: 172px !important;
    height: 244px !important;
}
#featured ul {
    margin: 0;
}
#recherche input[type=text] {
    border: none;
    position: relative;
    top: 142px;
    right: 2px;
    float: right;
    padding: 0 20px;
    background: #ececec url({#STATIC_URL#}/img/icones/search.png) no-repeat 0 0;
    font-style: italic;
    font-size: 14px;
    color: #333;
    width: 100px;
    height: 26px;
    -webkit-transition-duration: 400ms;
    -webkit-transition-property: width, background;
    -webkit-transition-timing-function: ease;
    -moz-transition-duration: 400ms;
    -moz-transition-property: width, background;
    -moz-transition-timing-function: ease;
    -o-transition-duration: 400ms;
    -o-transition-property: width, background;
    -o-transition-timing-function: ease;
}
#recherche input[type=text]:focus, #recherche input[type=text]:hover {
    font-style: normal;
    background-color: #f9f9f9;
    width: 120px;
}
.button {
    text-align: center;
    margin: 10px auto;
    width: 120px;
    background: url({#STATIC_URL#}/img/gradient_noir.png) repeat-x #040404;
    padding: 10px;
    border-top: 1px #999 solid;
    border-left: 1px #999 solid;
    border-bottom: 1px #666 solid;
    border-right: 1px #666 solid;
    {css_border_radius radius='5px'}
    color: #fff !important;
    font-weight: bold;
    display: block;
}
.button:hover {
    background: url({#STATIC_URL#}/img/gradient_blanc.png) repeat-x #fff;
    color: #000 !important;
    text-decoration: none;
}
strong {
    font-weight: bold;
}
/**************
 * footer
 **************/
#footer {
    background: #333;
    height: 100px;
    margin: 0;
}
#footer > li strong {
    display: block;
    margin-bottom: 5px;
    color: #fff;
    font-weight: bold;
}
#footer > li {
    position: relative;
    left: 100px;
    margin: 15px 0 0 25px;
    padding: 0 10px 0 0;
    list-style: none;
    display: inline;
    text-align: left;
    float: left;
}
#footer > li a {
    color: #999;
}
.footermenu strong {
    padding-left: 20px;
}
#footermenuwho strong {
    background: url({#STATIC_URL#}/img/icones/loupe.png) 0 0 no-repeat;
}
#footermenuchiffres strong {
    background: url({#STATIC_URL#}/img/icones/stats.png) 0 0 no-repeat;
}
#footermenucontact strong {
    background: url({#STATIC_URL#}/img/icones/email_write.png) 0 0 no-repeat;
}
#footermenusocial strong {
    background: url({#STATIC_URL#}/img/icones/groupe.png) 0 0 no-repeat;
}
#footermenudev strong {
    background: url({#STATIC_URL#}/img/icones/gear.png) 0 0 no-repeat;
}
#chemin {
    margin: 0;
    padding: 10px 0 0 15px;
    font-size : 90%;
}
#chemin .item {
    color: #fff;
    font-weight: bold;
}
#countdown {
    position: absolute;
    padding: 10px 0 0 15px;
    right: 10px;
    font-size : 90%;
}
/**************
 * box login
 **************/
#boxlogin-outter {
    position: absolute;
    right: 8px;
    top: 7px;
    z-index: 99;
    text-align: right;
    font-size: 13px;
    font-weight: bold;
}
#boxlogin-outter > span {
    color: #fff;
    text-shadow: #000 1px 1px 1px;
    padding-left: 18px;
    background: no-repeat url({#STATIC_URL#}/img/icones/cadenas.png);
}
#boxlogin-outter > span > a {
    color: #fff;
    text-shadow: #000 1px 1px 1px;
    text-decoration: none;
}
#boxlogin-inner {
    margin-top: 10px;
    font-size: 12px;
    font-weight: normal;
    text-align: left;
}
.mbr {
    list-style-type: none;
    list-style-image: none;
    margin-top: 14px;
    padding: 0;
}
.mbr li {
    padding-bottom: 5px;
    padding-left: 20px;
    margin-left: 5px;
    background-repeat:no-repeat;
    background-position: 0%;
}
.mbr li:hover 
{
    background-color: #ececec;
}
.mbr li a:hover {
    text-decoration: none;
}
.mbrmessagerie {
    background-image: url({#STATIC_URL#}/img/icones/email.png);
}
.mbralerting {
    background-image: url({#STATIC_URL#}/img/icones/star.png);
}
.mbrcompte {
    background-image: url({#STATIC_URL#}/img/icones/profil.png);
}
.mbrgroupes {
    background-image: url({#STATIC_URL#}/img/icones/groupe.png);
}
.mbrphotos {
    background-image: url({#STATIC_URL#}/img/icones/photo.png);
}
.mbraudios {
    background-image: url({#STATIC_URL#}/img/icones/audio.png);
}
.mbrvideos {
    background-image: url({#STATIC_URL#}/img/icones/video.png);
}
.mbrdates {
    background-image: url({#STATIC_URL#}/img/icones/event.png);
}
.mbrlieux {
    background-image: url({#STATIC_URL#}/img/icones/lieu.png);
}
.mbradmin {
    background-image: url({#STATIC_URL#}/img/icones/cadenas.png);
}
.mbrlogout {
    background-image: url({#STATIC_URL#}/img/icones/logout.png);
}
.mbrarticles {
    background-image: url({#STATIC_URL#}/img/icones/article.png);
}
#form-login #login-pseudo {
    padding-left: 10px;
    margin: 5px;
}
#form-login #login-password {
    padding-left: 10px;
    margin: 5px;
}
#form-login label {
    display: inline;
}
#form-login ul {
    margin-right: 5px;
}
#form-login li {
    font-size: 1em;
    text-align: right;
    padding: 2px 0;
}
#form-login input[type=text],
#form-login input[type=password] {
    width: 152px;
}
#form-login input[type=submit] {
    width: 30%;
    float: left;
    margin: 6px 4px;
    padding: 3px 2px;
    font-weight: bold;
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    background-color: #040404;
}
/**************
 * squelette general
 **************/
#left {
    position: relative;
    float: left;
    width: 300px;
}
#right {
    float: right;
    width: 300px;
}
#center {
    position: relative;
    float: left;
    width: 530px;
}
#left-center {
    position: relative;
    float: left;
    width: 680px;
}
#center-right {
    position: relative;
    float: right;
    width: 680px;
}
/**************
 * tableau
 **************/
tr {
    vertical-align: top;
}
tr.odd {
    background-color: #ddd;
}
tr.even {
    background-color: #eee;
}
/**************
 * images
 **************/
img {
    border: 0;
}
/**************
 * cadre autour des mini images
 **************/
div.pic {
    float: left;
    height: 125px;
    width: 125px;
    padding: 0;
    margin: 5px 12px 20px 12px;
    background: #222;
    border: 1px solid;
    border-color: #444 #999 #999 #444;
    -moz-border-radius: 10px;
    -webkit-border-radius: 5px;
}
div.pt {
}
div.pic img {
    border: 1px solid;
    border-color: #444 #aaa #aaa #444;
}
div.ls img {
    height: 75px;
    width: 100px;
    margin: 25px 2px 2px 12px;
}
div.pt img {
    height: 100px;
    width: 75px;
    margin: 12px 0 0 25px;
}
/**************
 * icones outils
 **************/
ul.tools {
    padding-left: 0;
}
ul.tools li {
    display: inline;
    margin: 0;
    padding: 5px;
}
/**************
 * titres
 **************/
h1, h2, h3, h4, h5, h6 {
    color: #000;
    font-weight: bold;
    padding: 5px 0;
}
h1 {
    font-size: 1.5em;
}
h2 {
    font-size: 1.4em;
}
h3 {
    font-size: 1.3em;
}
h4 {
    font-size: 1.2em;
}
h5 {
    font-size: 1.1em;
}
h6 {
    font-size: 1.0em;
}
/**************
 * liens
 **************/
a, a:link, a:visited, a:active {
    color: #000;
    text-decoration: none;
}
a:hover {
    color: #000;
    text-decoration: underline;
}
a.extlink {
    padding-left: 16px;
    background: url({#STATIC_URL#}/img/icones/extlink.gif) no-repeat;
}
/**************
 * divers
 **************/
blockquote {
    font-family: Arial;
    color: #000;
    background: none repeat;
}
pre {
    color: #000;
    line-height: 0.6em;
}
/**************
 * listes
 **************/
ul {
    list-style: none;
    margin: 5px 0 5px 0;
}
#newsletter ul {
    list-style: square;
    padding-left: 25px;
}
/**************
 * formulaires
 **************/
form {
}
fieldset {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #666;
}
legend {
    color: #fff;
    font-weight: bold;
    font-size: 1.4em;
    padding: 5px;
    border: 1px solid #999;
    background-color: #666;
}
label {
    margin-top: 10px;
    display: block;
    font-size: 90%;
}
label.inline {
    display: inline;
}
input, textarea {
    border: #ccc 1px solid;
    background-color: #efefef;
    color: #333;
    font-family: Courier;
    font-size: 1.3em;
    line-height: 1.4em;
}
input[type=radio] {
}
input[type=submit], input[type=button] {
    background: url({#STATIC_URL#}/img/gradient_noir.png) repeat-x #040404;
    color: #fff;
    border: #888 1px solid;
    padding: 0 5px 0 5px;
}
select {
    border: 1px solid #888;
    background-color: #ececec;
    color: #000;
}
option {
    background-color: #ececec;
    color: #000;
}
input:focus, textarea:focus {
    background-color: #fff;
}
fieldset ol li {
    clear: right;
}
.required {
}
.optional {
}
.conditional {
}
/**************
 * code de partage
 **************/
.share {
    border: #fff 1px solid;
    background-color: #000;
    color: #fff;
    font-family: Courier;
}
.spacer {
    visibility: hidden;
    clear: both;
}
/**************
 * moteur de recherche
 **************/
.match {
    background: #ff0;
    color: #000;
    font-weight: bold;
}
/**************
 * divers
 **************/
.rubrique {
    color : #ff9;
    background: none repeat;
    font-weight: bold;
}
.texterub {
    color: #fff;
    background: none repeat;
}
.blocinfo {
    position: relative;
    margin: 10px;
    padding: 5px;
    clear: both;
}
.blocinfo h3 {
    margin: 5px auto 15px;
    text-align: center;
    background-color: #bb0000;
    color: #ffffff;
    text-shadow: #000000 1px 1px;
}
.blocinfo td {
    text-align: left;
}

/**************
 * inscription
 **************/
.registerblock {
    float: left;
    width: 200px;
    height: 350px;
    margin: 5px;
    padding: 15px;
    background-color: #ececec;
    background-image: -moz-linear-gradient(top, #ffffff, #dddddd);
    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #ffffff), color-stop(1, #dddddd));
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorStr='#ffffff', EndColorStr='#dddddd')";
    box-shadow: 3px 3px 5px #999999;
    -moz-box-shadow: 3px 3px 5px #999999;
    -webkit-box-shadow: 3px 3px 5px #999999;
}
.registerblock h3 {
    color: #fff;
    padding: 5px;
    text-align: center;
    background-color: #bb0000;
    background-image: -moz-linear-gradient(top, #ff0000, #660000);
    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0, #ff0000), color-stop(1, #660000));
    -ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorStr='#ff0000', EndColorStr='#660000')";
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    margin-bottom: 15px;
}
.registerbutton {
    display: block;
    background-color: #300;
    color: #fff !important;
    padding: 5px;
    text-align: center;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    margin-top: 15px;
    font-weight: bold;
}
.registerbutton:hover {
    background-color: #c00;
    color: #fff;
}
/**************
 * page groupes
 **************/
ul.listgrp {
    margin: 0;
}
.boxgrp {
    float: left;
    width: 162px;
    height: 80px;
    padding: 5px;
    background-color: #999;
    text-align: right;
}
.boxgrp a {
    color: #000;
    text-decoration: none;
}
.boxgrp strong {
    color: #fff;
}
.boxgrp:hover {
}
.imggrp {
    float: left;
    width: 64px;
    height: 64px;
    background: url({#STATIC_URL#}/img/note_adhoc_64.png);
}
.grpactif {
}
.grpinactif {
    opacity: 0.5;
}
/**************
 * box à découvrir
 **************/
.adecouvrir {
    clear: left;
    border-bottom: 1px #ececec solid;
    padding: 5px 0 5px 0;
}
.adecouvririmg {
    margin: 5px 0 10px 0;
}
.adecouvririmg a {
    color: #300;
}
.adecouvririmg img {
    border: 1px solid #999;
}
.adecouvririmg span {
    background: #999 url({#STATIC_URL#}/img/gradient_gris.png);
    padding: 0 15px;
    -moz-border-radius-bottomright: 5px;
    -webkit-border-bottom-right-radius: 5px;
}
/**************
 * page partenaire
 **************/
ul.partenaire li {
    border: 0;
    display: inline;
    margin: 10px;
    padding: 5px;
}
.admvideos {
    float: left;
    width: 282px;
    height: 235px;
    overflow: auto;
    margin: 5px;
    background: #666;
    padding: 5px;
}
/**************
 * adm featured
 **************/
.programme {
    background-color: #ff9999;
}
.enligne {
    background-color: #99ff99;
}
.archive {
    background-color: #666666;
}
/**************
 * messages box
 **************/
.info, .success, .warning, .error, .validation {
    border: 1px solid;
    margin: 10px;
    padding: 15px 10px 15px 50px;
    background-repeat: no-repeat;
    background-position: 10px center;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
}
.info ul, .success ul, .warning ul, .error ul, .validation ul {
    padding: 0;
    margin: 0;
}
.info ul li, .success ul li, .warning ul li, .error ul li, .validation ul li {
    background: url({#STATIC_URL#}/favicon.png) no-repeat 0 0;
    padding-left: 25px;
    margin: 5px;
}
.info {
    color: #00529b;
    background-color: #bde5f8;
    background-image: url({#STATIC_URL#}/img/icones/info.png);
}
.success {
    color: #4f8a10;
    background-color: #dff2bf;
    background-image:url({#STATIC_URL#}/img/icones/success.png);
}
.warning {
    color: #9f6000;
    background-color: #feefb3;
    background-image: url({#STATIC_URL#}/img/icones/warning.png);
}
.error {
    color: #d8000c;
    background-color: #ffbaba;
    background-image: url({#STATIC_URL#}/img/icones/error.png);
}
.validation {
    color: #d63301;
    background-color: #ffccba;
    background-image: url({#STATIC_URL#}/img/icones/validation.png);
}
.fb-profil {
    float: left;
    border: 1px solid #999;
    padding: 5px;
    width: 150px;
    height: 70px;
    margin: 5px;
    background-color: #922;
}
.fb-profil-with-account {
    background-color: #292;
}
.fb-profil img {
    float: right;
}
/* thumbnails photo et video */
.thumb-80 {
    position: relative;
    float: left;
    margin: 3px 3px;
    width: 80px;
    height: 80px;
    border-radius: 1px;
    border-top: 1px solid #999;
    border-right: 1px solid #999;
    border-bottom: 1px solid #999;
    border-left: 1px solid #999;
    background-color: #f9f5ef;
    font-size: 0.9em;
    padding: 2px 2px 20px 2px;
    {css_border_radius radius='1px'}
    -webkit-transition: all 0.2s ease-in-out;
    -moz-transition: all 0.2s ease-in-out;
    -o-transition: all 0.2s ease-in-out;
    -ms-transition: all 0.2s ease-in-out;
}
.thumb-80:hover {
}
.overlay-80 {
    visibility: hidden;
    position: absolute;
    width: 80px;
    height: 80px;
    top: 3px;
    left: 3px;
    background-image: url({#STATIC_URL#}/img/cache-media.png);
}
.overlay-photo-80 {
    background-position: -0px -80px;
}
.overlay-video-80 {
    background-position: -0px -160px;
}
.overlay-audio-80 {
    background-position: -0px -0px;
}
.thumb-100 {
    position: relative;
    float: left;
    width: 100px;
    height: 100px;
}
.thumb-100 h3 {
    position: absolute;
    bottom: 0;
    width: 100px;
    text-align: center;
    min-height: 20px;
    background: rgba(150, 0, 0, .85);
    color: #fff;
    text-shadow: 1px 1px 1px #000;
    text-transform: uppercase;
    font-size: 10px;
    
}
.thumb-100:hover {
}
.photofull img {
    box-shadow: 3px 3px 5px #999999;
    -moz-box-shadow: 3px 3px 5px #999999;
    -webkit-box-shadow: 3px 3px 5px #999999;
    filter:progid:DXImageTransform.Microsoft.Shadow(color='#999999', Direction=135, Strength=5);
    zoom: 1;
}
/* search */
#search-box-results {
    margin: 0;
}
.search-box-result {
    margin: 8px 8px 0 0;
    width: 100px;
    height: 100px;
    float: left;
}
.search-box-result:nth-child(6n) {
    margin-right: 0;
}
.search-box-result-audio {
    width: 100%;
    height: 100%;
}
.search-box-result-video {
    height: 100%;
    width: 100%;
}
.search-box-result-photo {
    height: 100%;
    width: 100%;
}
#up {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 40px;
    height: 36px;
    background-color: #bb0000;
    display: none;
    padding: 0;
    font-size: 11px;
    z-index: 1800;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
}
#up:hover {
    background-color: #dd0000;
}
#up img {
    display: block;
    width: 32px;
    height: 32px;
    margin: 0 auto;
}

div.tree_top {
    background: url({#STATIC_URL#}/img/tree/top.gif) no-repeat -1px -3px;
    padding-left: 24px;
    padding-bottom: 10px;
    padding-top: 3px;
}
ul.tree {
    margin-top: -5px;
    margin-left: -1px;
}
ul.tree, ul.tree ul {
    list-style-type: none;
}
ul.tree li {
    padding-left: 1.2em;
    border-left: 1px gray dotted;
    background: url({#STATIC_URL#}/img/tree/horizontal.gif) no-repeat left 10px;
    margin-left: 1em;
    font-weight: bold;
    padding-top: 4px;
    padding-bottom: 1px;
}
ul.tree a {
    padding-left: 0.2em
}
ul.tree a.selected {
    font-weight: bold;
}
ul.tree li.last {
    background: url({#STATIC_URL#}/img/tree/last.gif) no-repeat -12px -2px;
    border: none;
}
ul.tree {
    padding-left: 0em;
}
ul.tree li.last {
    padding-bottom: 0;
}
ul.tree li ul {
    padding: 0;
}
ul.tree li ul li {
    padding: 1px 0 1px 15px;
    font-size: 11px;
    font-weight: normal;
}
ul.tree li ul li.last {
    padding-bottom: 0;
}
ul.tree a {
    padding-left: 2px;
}
div.alerting-sub a, div.alerting-auth a, div.alerting-unsub a {
    background: url({#STATIC_URL#}/img/icones/star.png) no-repeat left top;
    margin: 5px;
    padding: 3px 5px 3px 20px;
    background-color: #eceef5;
    border: 1px solid #cad4e7;
    text-decoration: none;
}
div.alerting-sub a:hover, div.alerting-auth a:hover, div.alerting-unsub a:hover {
    border: 1px solid #a8b2c5;
}
