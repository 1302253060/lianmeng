/*
 *  地推弹框提示
 *  @author damon
 *  @email  zhangyinfei@baidu.com
 *  @date 2014-10-02
 *
 */
$.widget("bd.tips",{
options: {
    'attrKey' : null,
    'content' : null,
    'left'    : 0,
    'top'     : 0,
    'direct'  : 'down',
    /*class|id name*/
    'arrowClass'      : 'tipArrow',
    /*style class*/
    'css'     : {},
    'backgroundColor' : '#FFF',
    'position'        : 'absolute',
    'border'          : '1px solid #CCC'
},
$Html:null,
$element: null,
offsetX:0,
offsetY:0,
iTarWidth: 0,
iTarHeight: 0,
//初始化
_create: function (){
    this._ready();
},
_ready: function(){
    var that  = this;
    var $this = that.$element = $(this.element);

    that._getContent();

    $this.mouseenter(function(e){
        var offsetX  = that.offsetX = $(this).offset().left;
        var offsetY  = that.offsetY = $(this).offset().top;
        that.iWidth  = $(this).width();
        that.iHeight = $(this).height();
        var $Html    = that._generateHtml(that.options.content,that.options.direct);
        $Html        = that._setPos($Html);
    }).mouseout(function(){
        that.$Html.remove();
    });
},
_getContent: function(){
    if (this.options.content === null) {
        this.options.content = this.$element.attr(this.options.attrKey);
    };
},
//方向
_generateHtml: function(sMsg, direct){
    var css = $.extend({},{
        'border' : this.options.border
    },this.options.css);
    var $body  = $("<div>"+sMsg+"</div>").css(css);

    var arrowTop = '';
    switch(this.options.direct) {
        case 'down':
            arrowTop = '-1px';
            break;
        case 'up':
            arrowTop = '0px';
            break;
    }
    var $arrow = $('<div class="'+this.options.arrowClass+'"></div>').css({
            'position' : 'relative',
            'top'      : arrowTop
    });
    switch(this.options.direct) {
        case 'down':
            this.$Html    = $('<div></div>').append($body).append($arrow);
            break;
        case 'up':
            this.$Html    = $('<div></div>').append($arrow).append($body);
            break;
        default:
            this.$Html    = $('<div></div>').append($body).append($arrow);
            break;
    }
    this.$Html.css({
        'position'        : this.options.position,
        'background-color': this.options.backgroundColor
    }).appendTo('body');
    $arrow.css('width',this.$Html.width());
    return this.$Html;
},
_setPos: function($Html){
    var iWidth  = $Html.width();
    var iHeight = $Html.height();
    var left    = this.offsetX - iWidth/2 + this.iWidth/2;
    var top     = this.offsetY;

    $Html.css({
        'left'  : left + this.options.left,
        'top'   : this._getTopByDirect($Html)//this.offsetY - iHeight + this.options.top
    });
    return $Html;
},
_getTopByDirect: function($Html){
    var iWidth  = $Html.width();
    var iHeight = $Html.height();
    var tarHeight = this.$element.height();
    var left    = this.offsetX - iWidth/2 + this.iWidth/2;
    var top     = this.offsetY;

    var direct = this.options.direct, setTop=0;

    switch(direct) {
        case 'down':
            setTop = this.offsetY - iHeight + this.options.top;
            break;
        case 'up':
            setTop = this.offsetY +tarHeight + this.options.top;
            break;
        default:
            setTop = this.offsetY - iHeight + this.options.top;
            break;
    }
    return setTop;
}
});
