{* où ? *}

#event-box-info {
    margin: 10px;
    background: #ececec;
    width: 300px;
    padding: 10px;
    border: 1px solid #ffffff;
}
#event-box-map {
    float: left;
    margin: 0 5px 5px 0;
}

{* page listing *}

.events_of_the_day {
    margin: 10px;
}
.events_of_the_day h3 {
    background: #333333 url({#STATIC_URL#}/img/icones/event.png) no-repeat 3px 4px;
    color: #ffffff;
    border-bottom: 0px solid #999999;
    padding: 5px 25px;
    text-shadow: #000000 1px 1px 1px;
}
div.event {
    margin-bottom: 0;
}
div.event div.event_header {
    float: left;
    padding: 10px 5px;
}
div.event_date {
    background: url({#STATIC_URL#}/img/icones/clock.png) no-repeat;
    padding-left: 20px;
    font-weight: bold;
    margin-bottom: 5px;
}
div.event_lieu {
    background: url({#STATIC_URL#}/img/icones/map.png) no-repeat;
    padding-left: 20px;
    margin-bottom: 5px;
}
div.event span.event_title {
    background-color: #666666;
    display: block;
    padding: 5px;
}
div.event span.event_title a {
    color: #ffffff;
    text-shadow: #000000 1px 1px 1px;
}
div.event div.event_content {
    padding: 0px;
    margin-left: 200px;
    border-left: 1px solid #999999;
    margin-bottom: 0px;
}
div.event div.event_body {
    padding: 5px;
}
p.event_price {
    background: url({#STATIC_URL#}/img/icones/coins.png) no-repeat;
    padding-left: 20px;
}
p.event_facebook {
    margin-top: 15px;
    background: url({#STATIC_URL#}/img/facebook.gif) no-repeat;
    padding-left: 20px;
}
div.event div.event_footer {
    background-color: #acacac;
    padding: 5px;
}
div.event_media {
    margin-left: 200px;
}
span.event_media_video {
    background: url({#STATIC_URL#}/img/icones/video.png) no-repeat;
    padding-left: 20px;
}
span.event_media_photo {
    background: url({#STATIC_URL#}/img/icones/photo.png) no-repeat;
    padding-left: 20px;
}
span.event_media_audio {
    background: url({#STATIC_URL#}/img/icones/audio.png) no-repeat;
    padding-left: 20px;
}

{* calendrier *}

#cal {
    border-collapse: collapse;
    width: 300px;
    float: right;
}
#cal tr.top {
    background-color: #bb0000;
}
#cal tr.top a {
    color: #ffffff;
}
#cal tr.days {
    background-color: #000;
    color: #fff;
}
#cal th, #cal td {
    text-align: center;
    padding: 4px;
}
#cal td.blank {
    background-color: #999999;
}
#cal td.none {
    background-color: #ececec;
}
#cal td.event {
    background-color: #ececec;
}
#cal td.today {
    background-color: #fff;
}
#cal td.event a {
    color: #ff0000;
}
