/**************
 * pagination
 **************/
.pagination {
    clear: both;
    width: 50%;
    margin: 20px auto;
    text-align: center;
}
a.unselectedpage {
    padding: 5px;
    border-top: 1px #999 solid;
    border-left: 1px #999 solid;
    border-bottom: 1px #666 solid;
    border-right: 1px #666 solid;
    background: url({#STATIC_URL#}/img/gradient_noir.png) repeat-x #111;
    color: #fff;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
}
a.unselectedpage:hover {
    padding: 8px 5px 8px 5px;
    background: url({#STATIC_URL#}/img/gradient_gris.png) repeat-x #666;
    color: #000;
}
a.selectedpage {
    padding: 8px;
    border-top: 1px #ccc solid;
    border-left: 1px #ccc solid;
    border-bottom: 1px #999 solid;
    border-right: 1px #999 solid;
    background: url({#STATIC_URL#}/img/gradient_gris.png) repeat-x #666;
    color: #000;
    font-weight: bold;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
}
a.selectedpage:hover {
    color: #000;
}
