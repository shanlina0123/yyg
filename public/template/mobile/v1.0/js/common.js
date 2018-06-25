$(function() {
    slide(".indexbanner", 420);
});
//右侧划上事件
$(".rightlink li a").hover(function() {
    $(this).siblings().show()
}, function() {
    $(this).siblings().hide()
});
//向上点击事件
$(".gotoplink").click(function() {
        $("html,body").animate({
            "scrollTop": '0'
        }, 500);
    })
    //轮播
function slide(name, width, height) {
    if ($(name).children().length > 1) {
        $(name).slidesjs({
            width: width,
            height: height,
            navigation: false,
            play: {
                auto: true,
                restartDelay: 2000
            },
            callback: {
                complete: function(number) {
                    clearTimeout(slideTimer)
                    var slideTimer = setTimeout(function() {
                        $(".slidesjs-play").click();
                    }, 5000)
                }
            }
        });
    }
}