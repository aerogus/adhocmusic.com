body {
    width: 515px;
    margin: 0;
    padding: 0;
    overflow: hidden;
    height: 100%;
}
/* boites */
.box {
    margin: 0 0 10px 0;
    padding: 0;
}
.boxtitle {
    background-color: #6d84b4;
    color: #fff;
    padding: 3px 10px 3px 15px;
    font-weight: bold;
    border-left: 0px #c99 solid;
    border-top: 0px #c99 solid;
    border-bottom: 0px #633 solid;
    border-right: 0px #633 solid;
    letter-spacing: 3px;
    box-shadow: 0px 0px 5px #333;
}
.boxcontent {
    color: #000;
    background-color: #ececec;
    padding: 10px;
    border-right: 1px solid #999;
    border-bottom: 1px solid #999;
    border-left: 1px solid #999;
    box-shadow: 0px 1px 5px #333;
}
.spacer {
    visibility: hidden;
    clear: both;
}

/* liste groupes */
.boxgrp {
    float: left;
    width: 162px;
    height: 80px;
    padding: 5px;
    margin: 3px;
    border: 1px solid transparent;
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
    border: 1px solid #fff;
}
.imggrp {
    float: left;
    border: 1px solid #ccc;
    width: 64px;
    height: 64px;
    background: #333 url(http://static.adhocmusic.com/img/note_adhoc_64.png);
}
.grpactif {
}
.grpinactif {
    opacity: 0.5;
}
.powered {
    background-color: #6d84b4;
    text-align: right;
    padding: 3px;
}
/* thumbnails photo et video */
.thumb-80 {
    position: relative;
    float: left;
    margin: 3px;
}
.overlay-80 {
    visibility: hidden;
    position: absolute;
    width: 80px;
    height: 80px;
    top: 0;
    left: 0;
}
.overlay-photo-80 {
    background-image: url(http://static.adhocmusic.com/img/cache-photo-zoom.png);
}
.overlay-video-80 {
    background-image: url(http://static.adhocmusic.com/img/cache-video-play.png);
}

div#feature_list {
    width: 700px !important;
    height: 240px;
    overflow: hidden;
    position: relative;
}
div#feature_list ul {
    position: absolute;
    top: 0;
    list-style: none;   
    padding: 0;
    margin: 0;
}
#feature_list h3 {
    color: #000;
    margin-bottom: 3px;
    padding: 0;
}
ul#tabs {
    right: 0;
    z-index: 2;
    width: 320px;
}
ul#tabs li {
    font-size: 12px;
    font-family: Arial;
}
ul#tabs li a {
    color: #222;
    text-decoration: none;  
    display: block;
    padding: 10px 10px 10px 33px;
    height: 40px;
    outline: none;
    background: url(http://static.adhocmusic.com/img/featured.png) 0px -180px no-repeat;
}
ul#tabs li a:hover {
    background: url(http://static.adhocmusic.com/img/featured.png) 0px -120px no-repeat;
    color: #fff;
    text-shadow: 1px 1px 1px #000;
}
ul#tabs li a:hover h3,
ul#tabs li a.current h3 {
    color: #fff;
    text-shadow: 1px 1px 1px #000;
}
ul#tabs li a.current {
    background: url(http://static.adhocmusic.com/img/featured.png) 0px -60px no-repeat;
    color: #fff;
    text-shadow: 1px 1px 1px #000;
}
ul#tabs li a.current:hover {
    background: url(http://static.adhocmusic.com/img/featured.png) 0px -60px no-repeat;
    color: #fff;
    text-shadow: 1px 1px 1px #000;
    text-decoration: none;
}
ul#output {
    left: 0;
    width: 427px;
    height: 240px;
    position: relative;
}
ul#output li {
    position: absolute;
    width: 427px;
    height: 240px;
}
