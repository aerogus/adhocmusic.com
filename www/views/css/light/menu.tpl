/* menu */

#menu-wrapper {
    position: relative;
}
#menu_haut {
    background: #000;
    height: 30px;
    margin: 0;
    font: bold 1.1em Arial;
}
#menu_haut > li {
    float: left;
    list-style: none;
    display: inline;
}
#menu_haut > li:hover, #menu_haut > li.menuselected:hover {
    background-color: #b00;
}
#menu_haut > li.menuselected {
    background-color: #555;
}
#menu_haut > li > a {
    display: block;
    color: #fff;
    font-size: 14px;
    height: 20px;
    text-shadow: 1px 1px 1px #000;
    padding: 5px 12px;
    text-decoration: none;
    text-transform: uppercase;
}
ul.sub-menu {
    background-color: #b00;
    width: 1000px;
    height: 30px;
    top: 30px;
    margin: 0;
    left: 0;
    float: left;
    position: absolute;
    z-index: 10;
    display: inline;
}
ul.sub-menu > li {
    display: inline;
    ppadding: 5px 2px;
    float: left;
}
ul.sub-menu > li > a {
    text-decoration: none;
    font: bold 1.0em Arial;
    color: #fff;
    padding: 5px;
    text-shadow: 1px 1px 1px #000;
    height: 20px;
    display: block;
}

/* social icons */

#social {
    float: right;
    margin-top: 1px;
}
#social ul {
    margin: 0;
}
#social ul li, #follow ul li {
    float: left;
    width: 24px;
    height: 24px;
    margin: 0 2px;
    background-repeat: no-repeat;
    background-image: url(http://static.adhocmusic.com/img/icones/social-sprite.png);
}
#follow ul li {
    margin: 0 3px;
}
#social ul li a, #follow ul li a {
    display: block;
    width: 24px;
    height: 24px;
}
#social ul:hover, #follow ul:hover {
    cursor: pointer;
}
.item-mobile {
    background-position: 0px -24px;
}
.item-mobile:hover {
    background-position: 0px 0px;
}
.item-search {
    background-position: -24px -24px;
}
.item-search:hover {
    background-position: -24px 0px;
}
.item-facebook {
    background-position: -48px -24px;
}
.item-facebook:hover {
    background-position: -48px 0px;
}
.item-myspace {
    background-position: -72px -24px;
}
.item-myspace:hover {
    background-position: -72px 0px;
}
.item-twitter {
    background-position: -96px -24px;
}
.item-twitter:hover {
    background-position: -96px 0px;
}
.item-dailymotion {
    background-position: -120px -24px;
}
.item-dailymotion:hover {
    background-position: -120px 0px;
}
.item-youtube {
    background-position: -144px -24px;
}
.item-youtube:hover {
    background-position: -144px 0px;
}
.item-rss {
    background-position: -168px -24px;
}
.item-rss:hover {
    background-position: -168px 0px;
}
