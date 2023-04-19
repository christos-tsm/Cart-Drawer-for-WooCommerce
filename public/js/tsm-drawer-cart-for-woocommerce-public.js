(function ($) {
    "use strict";

    $(".tsm-drawer-cart-floating-button").on("click", function () {
        console.log("skata");
        $(".tsm-drawer-cart__container").addClass("tsm-drawer-cart__container--active");
        $(".tsm-drawer-cart__overlay").addClass("tsm-drawer-cart__overlay--active");
    });

    $(".tsm-drawer-cart__overlay").on("click", function () {
        $(".tsm-drawer-cart__container").removeClass("tsm-drawer-cart__container--active");
        $(".tsm-drawer-cart__overlay").removeClass("tsm-drawer-cart__overlay--active");
    });

    // Update the mini cart content
    function update_mini_cart_content(html) {
        $(".tsm-drawer-cart__content").html(html);
    }

    // Register AJAX event listeners
    $(document).on("added_to_cart removed_from_cart updated_cart_totals", function () {
        $.post(
            wc_add_to_cart_params.ajax_url,
            {
                action: "tsm_drawer_cart_ajax_update",
            },
            function (response) {
                update_mini_cart_content(response);
            }
        );
    });

    // Quantity change AJAX request
    $(document).on("click", ".tsm-drawer-cart-product__quantity .quantity .plus, .tsm-drawer-cart-product__quantity .quantity .minus", function (e) {
        e.preventDefault();
        var $button = $(this);
        var $quantityInput = $button.siblings("input.qty");
        var cart_item_key = $quantityInput.attr("name").match(/\[(.*?)\]/)[1];
        var current_quantity = parseInt($quantityInput.val());
        var new_quantity = $button.hasClass("plus") ? current_quantity + 1 : current_quantity - 1;
        if (new_quantity < 0) {
            new_quantity = 0;
        }
        $.post(
            wc_add_to_cart_params.ajax_url,
            {
                action: "tsm_drawer_cart_ajax_update_quantity",
                cart_item_key: cart_item_key,
                quantity: new_quantity,
            },
            function (response) {
                update_mini_cart_content(response);
                $(document.body).trigger("updated_cart_totals");
            }
        );
    });
})(jQuery);
