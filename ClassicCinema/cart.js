/**
 * Shopping cart functions for the category pages
 */

/* global Cookie */

/**
 * Module pattern for Cart functions
 */
var Cart = (function () {
    "use strict";

    var pub;

    // Public interface
    pub = {};

    /**
     * Add items to the cart
     *
     * This function is called when a 'Buy' button is clicked.
     * The cart itself is stored in a cookie, which is updated each time this function is called.
     */
    function addToCart() {
        var itemList, newItem;
        itemList = Cookie.get("cart");
        if (itemList) {
            itemList = JSON.parse(itemList);
        } else {
            itemList = [];
        }
        newItem = {};
        /* jshint -W040 */

        //newItem.title = this.parentNode.parentNode.getElementsByTagName("h3")[0].innerHTML;
        newItem.title = $(this).parent().parent().find("h3").text();

        //newItem.price = this.parentNode.getElementsByClassName("price")[0].innerHTML;
        newItem.price = $(this).parent().find(".price").text();

        /* jshint +W040 */
        itemList.push(newItem);
        Cookie.set("cart", JSON.stringify(itemList));
    }

    /**
     * Setup function for the cart functions
     *
     * Gets a list of 'Buy' buttons, and sets them to call addToCart when clicked
     */
    pub.setup = function () {
        $(".buy").click(addToCart);

    };
        // var buybuttons, b
        //buyButtons = document.getElementsByClassName("buy");
        //for (b = 0; b < buyButtons.length; b += 1) {
        //    buyButtons[b].onclick = addToCart;
        //}


    // Expose public interface
    return pub;
}());

// The usual onload event handling to call Cart.setup

$(document).ready(Cart.setup);
