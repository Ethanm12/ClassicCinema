/**
 * Created by emorgan on 8/11/17.
 */
var Reviews = (function() {
    "use strict";
    var pub = {};

    function parseReviews(data, target) {
        var text;

        if (data.getElementsByTagName("review").length > 0) {


            text = "<dl>";

            $(data).find("review").each(function () {
                //window.alert($(this).find("rating")[0].textContent);
                var rating = $(this).find("rating")[0].textContent;
                var user = $(this).find("user")[0].textContent;

                text += "<dt>" + user + ":</dt> <dd>" + rating + "</dd>";

            });
            text += "</dl>";
        } else {
            text = "<p>There are no reviews for this book.</p>";
        }
        $(target).html(text);

    }

    function showReviews() {
        window.console.log("Show Reviews called");
        /* jshint -W040 */
        var target = $(this).parent().find(".review")[0];

        //window.alert($(this).parent().find("img").attr("src"));
        var imgSource = $(this).parent().find("img").attr("src");
        var xmlSource = imgSource.replace("images","./reviews");
        xmlSource = xmlSource.replace("jpg","xml");
        /* jshint +W040 */
        //$(".review").load(parseReviews);
        $.ajax({
            type: "GET",
            url: xmlSource,
            cache: false,
            success: function(data) {
                parseReviews(data, target);
            },
            error: function(){
                $(target).append("<p>There are no reviews for this book.</p>");

            }
        });
    }
    pub.setup = function() {

        $(".film").append("<input type='button' class='showReviews' value='Show Reviews'><div class='review'></div>");
        $(".showReviews").click(showReviews);


    };
    return pub;
}());
$(document).ready(Reviews.setup);