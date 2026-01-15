(function ($) {
  "use strict";

  //   wishlist
  $(document).on("click", ".wishlist", function (e) {
    e.preventDefault();
    const $this = $(this);
    if ($(this).data("href")) {
      $.get($(this).data("href"), function (data) {
        if (data[0] == 1) {
          toastr.success(data["success"]);
          $("#wishlist-count").html(data[1]);
          $this.children().addClass("active");
        } else {
          toastr.error(data["error"]);
        }
      });
    }
  });

  $(document).on("click", ".removewishlist", function (e) {
    e.preventDefault();
    let $this = $(this);
    $.get($(this).attr("data-href"), function (data) {
      $("#wishlist-count").html(data[1]);
      $this.parent().parent().parent().remove();
    });
  });

  // aDD TO FAVORITE
  $(document).on("click", ".favorite-prod", function () {
    var $this = $(this);
    $.get($(this).data("href"), function (data) {
      $this.attr("data-href", "");
      $this.attr("disabled", true);
      $this.removeClass("favorite-prod");
      $this.html(data["icon"] + " " + data["text"]);
    });
  });

  $(document).on("click", ".stars", function () {
    $(".stars").removeClass("active");
    $(this).addClass("active");
    $("#rating").val($(this).data("val"));
  });



  //////////// Add cart in product box ///////////////
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).on("click", ".add_cart_click", function (e) {
    e.preventDefault();

    const $btn = $(this);
    const pid = $btn.data("product-id");
    const wrap = $btn.closest(".single-product");

    const measureType = wrap.find(".measure-select").data("measure-type");
    const measureValue = parseFloat(wrap.find(".measure-select").val() || 1);
    const basePrice = parseFloat(wrap.find(".product-price").data("base-price"));
    const finalPrice = basePrice * measureValue;

    $.ajax({
      url: $btn.data("href"),
      method: "POST",
      data: {
        product_id: pid,
        measure_type: measureType,
        measure_value: measureValue,
        final_price: finalPrice,
        quantity: 1
      },
      success: function (data) {

        updateCartUI(data);
        reloadOffcanvasCart();

        const uniqueKey = data.unique_key;

        // OVERLAY UI
        $(`.overlay-add-btn[data-product-id="${pid}"]`).html(`
                <div class="outofstock-box-2 qty-plus-wrap qty-wrapper-overlay flex-row justify-content-evenly align-items-center"
                    data-product-id="${pid}" data-unique-key="${uniqueKey}">
                    <button class="btn btn-outline-light border-2 btn-sm qty-minus rounded-circle">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span class="h3 text-white qty-text">1</span>
                    <button class="btn btn-outline-light border-2 btn-sm qty-plus rounded-circle">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            `);

        // NORMAL UI
        $(`.add-btn-wrapper[data-product-id="${pid}"]`).html(`
                <div class="qty-box mt-auto qty-plus-wrap qty-wrapper-normal"
                    data-product-id="${pid}" data-unique-key="${uniqueKey}">
                    <button class="qty-btn qty-minus"><i class="fas fa-minus"></i></button>
                    <span class="qty-text">1 </span>
                    <button class="qty-btn qty-plus"><i class="fas fa-plus"></i></button>
                </div>
            `);
      }
    });
  });


  /////////////// Start product details page cart
  $(document).on("click", ".add_cart_details", function (e) {
    e.preventDefault();

    let productId = $("#product-id").val();
    const $btn = $(this);
    const pid = $btn.data("product-id");

    const measureType = $(".measure-select").data("measure-type");
    const selectedMeasureValue = parseFloat($(".measure-select").val() || 1);
    const basePrice = parseFloat($(".product-price").data("base-price"));

    // Calculate price
    let finalPrice = basePrice * selectedMeasureValue;
    console.log(finalPrice);


    $.ajax({
      url: $btn.data("href"),
      method: "POST",
      data: {
        product_id: productId,
        measure_value: selectedMeasureValue,
        measure_type: measureType,
        final_price: finalPrice,
        quantity: 1
      },
      success: function (data) {
        updateCartUI(data);
        reloadOffcanvasCart();

        // Change Add button → Qty UI
        const newQtyHTML = `
                <div class="qty-box mt-auto qty-wrapper flex-row justify-content-evenly align-items-center" data-product-id="${pid}" data-unique-key="${data.unique_key}">
                    <button type="button" class="qty-btn qty-minus"><i class="fas fa-minus"></i></button>
                    <span class="qty-text">1 </span>
                    <button type="button" class="qty-btn qty-plus"><i class="fas fa-plus"></i></button>
                </div>
            `;

        $btn.closest(".add-btn-wrapper").html(newQtyHTML);
      },
    });
  });
  ////end product details cart

  $(document).on("click", ".qty-plus", function () {

    const wrap = $(this).closest("[data-unique-key]");
    const pid = wrap.data("product-id");
    const unique_key = wrap.data("unique-key");

    $.ajax({
      url: mainurl + "/cart/increment",
      method: "POST",
      data: { unique_key },
      success: function (data) {

        //const pid = data.product_id;
        const qty = data.qty;

        $(".cart-count").text(data.cart_count);
        $(".total_price").text(data.total_price);
        reloadOffcanvasCart();

        $(`.qty-wrapper-normal[data-product-id="${pid}"] .qty-text`)
          .text(qty + " ");

        $(`.qty-wrapper-overlay[data-product-id="${pid}"] .qty-text`)
          .text(qty + " ");
      }
    });
  });


  $(document).on("click", ".qty-minus", function () {

    const wrap = $(this).closest("[data-unique-key]");
    const pid = wrap.data("product-id");
    const unique_key = wrap.data("unique-key");

    $.ajax({
      url: mainurl + "/cart/decrement",
      method: "POST",
      data: { unique_key },
      success: function (data) {

        const qty = data.qty;
        const addRoute = getAddToCartRoute(pid);

        updateCartUI(data);
        reloadOffcanvasCart();

        if (qty <= 0) {

          // NORMAL UI RESET
          $(`.qty-wrapper-normal[data-product-id="${pid}"]`)
            .parent()
            .html(`
                        <div class="w-100 d-block mt-auto add-btn-wrapper" data-product-id="${pid}">
                            <button class="btn btn-sm add-cart-btn btn-info d-flex d-block w-100 justify-content-center align-items-center add_cart_click"
                                data-href="${addRoute}" data-product-id="${pid}">
                                <i class="fa fa-bolt me-2"></i> Add To Cart
                            </button>
                        </div>
                    `);

          // OVERLAY UI RESET
          $(`.qty-wrapper-overlay[data-product-id="${pid}"]`).parent().html(`
                        <div class="overlay-add-btn" data-product-id="${pid}">
                            <button style="flex-direction: column !important;" type="button" class="outofstock-box-2 add_cart_click d-flex flex-column"
                                data-href="${addRoute}" data-product-id="${pid}">
                                <div class="text-center text-white">
                                    <i style="font-size: 1.3rem" class="fas fa-shopping-bag    "></i>
                                </div>
                                <p style="font-size: 1rem; margin-bottom: 0;" class="text-white">Add to <br> Shopping <br> Bag</p>
                            </button>
                        </div>
                    `);

        } else {
          // UPDATE BOTH UI
          $(`.qty-wrapper-normal[data-product-id="${pid}"] .qty-text`)
            .text(qty + " ");

          $(`.qty-wrapper-overlay[data-product-id="${pid}"] .qty-text`)
            .text(qty + " ");
        }
      }
    });
  });


  $(document).on("click", ".remove-item-cart", function () {

    const key = $(this).data("key");
    const pid = $(this).data("product-id");

    $.ajax({
      url: mainurl + "/cart/remove",
      method: "POST",
      data: { unique_key: key },
      success: function (res) {

        if (!res.status) return;

        $(".offCanva-right-cartItems").html(res.html);
        $(".total_price").text(res.total);
        $(".cart-count").text(res.count);

        const addRoute = getAddToCartRoute(pid);

        // NORMAL UI RESET
        $(`.qty-wrapper-normal[data-product-id="${pid}"]`)
          .parent()
          .html(`
                    <div class="w-100 d-block mt-auto add-btn-wrapper" data-product-id="${pid}">
                        <button class="btn btn-sm add-cart-btn btn-info d-flex w-100 justify-content-center align-items-center add_cart_click"
                            data-href="${addRoute}" data-product-id="${pid}">
                            <i class="fa fa-bolt me-2"></i> Add To Cart
                        </button>
                    </div>
                `);

        // OVERLAY UI RESET
        $(`.qty-wrapper-overlay[data-product-id="${pid}"]`).parent().html(`
                    <div class="overlay-add-btn" data-product-id="${pid}">
                        <button type="button" class="outofstock-box-2 add_cart_click d-flex flex-column"
                            data-href="${addRoute}" data-product-id="${pid}">
                            <div class="text-center text-white">
                               <i style="font-size: 1.3rem" class="fas fa-shopping-bag    "></i>
                            </div>
                           <p style="font-size: 1rem; margin-bottom: 0;" class="text-white">Add to <br> Shopping <br> Bag</p>
                        </button>
                    </div>
                `);
      }
    });
  });


  function getAddToCartRoute(pid) {
    return mainurl + "/product/cart/add/" + pid;
  }


  function updateCartUI(data) {
    $(".cart-count").html(data.cart_count);
    $(".total_price").html(data.total_price);
    $(".cart-popup").load(mainurl + "/carts/view");
  }
  function reloadOffcanvasCart() {
    $(".offCanva-right-cartItems").load(mainurl + "/cart/offcanvas");
  }



  //End add to cart
})(jQuery);
