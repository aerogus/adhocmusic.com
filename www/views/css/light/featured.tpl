div#feature_list {
    width: 680px;
    height: 240px;
    overflow: hidden;
    position: relative;
    margin-bottom: 20px;
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
    width: 319px;
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
    background: url({#STATIC_URL#}/img/featured.png) 0px -180px no-repeat;
}
ul#tabs li a:hover {
    background: url({#STATIC_URL#}/img/featured.png) 0px -120px no-repeat;
    color: #fff;
    text-shadow: 1px 1px 1px #000;
}
ul#tabs li a:hover h3,
ul#tabs li a.current h3 {
    color: #fff;
    text-shadow: 1px 1px 1px #000;
}
ul#tabs li a.current {
    background: url({#STATIC_URL#}/img/featured.png) 0px -60px no-repeat;
    color: #fff;
    text-shadow: 1px 1px 1px #000;
}
ul#tabs li a.current:hover {
    background: url({#STATIC_URL#}/img/featured.png) 0px -60px no-repeat;
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
