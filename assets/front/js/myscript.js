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
    let finalPrice = basePrice * measureValue;

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

        // Change Add button → Qty UI
        const newQtyHTML = `
                <div class="qty-box mt-auto qty-wrapper" data-product-id="${pid}" data-unique-key="${data[2]}">
                    <button class="qty-btn qty-minus"><i class="fas fa-minus"></i></button>
                    <span class="qty-text">1 in Bag</span>
                    <button class="qty-btn qty-plus"><i class="fas fa-plus"></i></button>
                </div>
            `;

        $btn.closest(".add-btn-wrapper").html(newQtyHTML);

      }
    });
  });
  //// add cart on overlay product box /////////////////
  $(document).on("click", ".add_cart_overlay", function (e) {
    e.preventDefault();

    const $btn = $(this);
    const pid = $btn.data("product-id");
    const wrap = $btn.closest(".single-product");

    const measureType = wrap.find(".measure-select").data("measure-type");
    const measureValue = parseFloat(wrap.find(".measure-select").val() || 1);
    const basePrice = parseFloat(wrap.find(".product-price").data("base-price"));
    let finalPrice = basePrice * measureValue;

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

        // Change Add button → Qty UI
        const newQtyHTML = `
               <div class="outofstock-box-2 qty-wrapper" style="flex-direction: row; gap: 20px;" data-product-id="${pid}" data-unique-key="${data[2]}">
                                    <button class="btn btn-outline-light rounded-circle border-2 btn-sm qty-minus"> <i
                                            class="fas fa-minus"></i></button>
                                    <span class="h3 text-white" style="font-weight: 400">1</span>
                                    <button class="btn btn-outline-light rounded-circle border-2 btn-sm qty-plus"> <i
                                            class="fas fa-plus"></i></button>
                                </div>
            `;

        $btn.closest(".ov-cart-wrapper").html(newQtyHTML);

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
                <div class="qty-box mt-auto qty-wrapper" data-product-id="${pid}" data-unique-key="${data[2]}">
                    <button type="button" class="qty-btn qty-minus"><i class="fas fa-minus"></i></button>
                    <span class="qty-text">1 in Bag</span>
                    <button type="button" class="qty-btn qty-plus"><i class="fas fa-plus"></i></button>
                </div>
            `;

        $btn.closest(".add-btn-wrapper").html(newQtyHTML);
      },
    });
  });
  ////end product details cart

  $(document).on("click", ".qty-plus", function () {

    const wrap = $(this).closest(".qty-wrapper");
    const unique_key = wrap.data("unique-key");

    $.ajax({
      url: mainurl + "/cart/increment",
      method: "POST",
      data: { unique_key: unique_key },
      success: function (data) {
        updateCartUI(data);
        reloadOffcanvasCart();

        wrap.find(".qty-text").text(data[2] + " in Bag");
      }
    });

  });


  $(document).on("click", ".qty-minus", function () {

    const wrap = $(this).closest(".qty-wrapper");
    const unique_key = wrap.data("unique-key");

    $.ajax({
      url: mainurl + "/cart/decrement",
      method: "POST",
      data: { unique_key: unique_key },
      success: function (data) {

        $(".total_price").text(data.total_price);

        // update cart count
        $(".cart-count").text(data.cart_count);
        reloadOffcanvasCart();

        const pid = data.product_id;

        if (data.qty <= 0) {
          // Qty = 0 → Replace qty box with Add To Cart button
          const addRoute = getAddToCartRoute(pid);
          wrap.parent().html(`
                    <div class="w-100 d-block mt-auto add-btn-wrapper">
                        <button type="button" class="btn btn-sm add-cart-btn btn-info d-flex w-100 justify-content-center align-items-center add_cart_click"
                            data-href="${addRoute}"
                            data-product-id="${pid}">
                            <i class="fa fa-bolt mr-2" aria-hidden="true"> </i> Add To Cart
                        </button>
                    </div>
                `);
        } else {
          wrap.find(".qty-text").text(data.qty + " in Bag");
        }
      }
    });
  });


  $(document).on("click", ".remove-item-cart", function () {
    let key = $(this).data("key");
    let pid = $(this).data("product-id");

    $.ajax({
      url: mainurl + "/cart/remove",
      method: "POST",
      data: {
        unique_key: key
      },
      success: function (res) {
        if (res.status) {

          // update offcanvas HTML
          $(".offCanva-right-cartItems").html(res.html);

          // update total cart price
          $(".total_price").text(res.total);

          // update cart count
          $(".cart-count").text(res.count);
          const addRoute = getAddToCartRoute(pid);

          $(`.qty-wrapper[data-product-id="${pid}"]`).parent().html(`
              <div class="w-100 d-block mt-auto add-btn-wrapper">
                  <button type="button" class="btn btn-sm add-cart-btn btn-info d-flex w-100 justify-content-center align-items-center add_cart_click"
                      data-href="${addRoute}"
                      data-product-id="${pid}">
                      <i class="fa fa-bolt mr-2"></i> Add To Cart
                  </button>
              </div>
          `);
        }
      }
    });
  });

  function getAddToCartRoute(pid) {
    return mainurl + "/product/cart/add/" + pid;
  }


  function updateCartUI(data) {
    $(".cart-count").html(data[0]);
    $(".total_price").html(data[1]);
    $(".cart-popup").load(mainurl + "/carts/view");
  }
  function reloadOffcanvasCart() {
    $(".offCanva-right-cartItems").load(mainurl + "/cart/offcanvas");
  }

  

  //End add to cart
})(jQuery);
