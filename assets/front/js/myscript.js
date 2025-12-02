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

  //   compare
  $(document).on("click", ".compare_product", function (e) {
    e.preventDefault();
    $.get($(this).data("href"), function (data) {
      $("#compare-count").html(data[1]);
      $("#compare-count1").html(data[1]);
      if (data[0] == 0) {
        toastr.success(data["success"]);
      } else {
        toastr.error(data["error"]);
      }
    });
  });

  // Product Add Qty
  $(document).on("click", ".qtplus", function () {
    var $tselector = $("#order-qty");
    var stock = $("#stock").val();
    var total = $($tselector).val();
    if (stock != "") {
      var stk = parseInt(stock);
      if (total < stk) {
        total++;
        $($tselector).val(total);
      }
    } else {
      total++;
    }

    $($tselector).val(total);
  });

  // Product Minus Qty
  $(document).on("click", ".qtminus", function () {
    var $tselector = $("#order-qty");
    var total = $($tselector).val();
    if (total > 1) {
      total--;
    }
    $($tselector).val(total);
  });

  $(".qttotal").keypress(function (e) {
    if (this.value.length == 0 && e.which == 48) {
      return false;
    }
    if (e.which != 8 && e.which != 32) {
      if (isNaN(String.fromCharCode(e.which))) {
        e.preventDefault();
      }
    }
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

  // add to card
  // $(document).on("click", ".add_cart_click", function (e) {
  //   e.preventDefault();
  //   $.get($(this).attr("data-href"), function (data) {
  //     if (data == "digital") {
  //       toastr.error(lang.cart_already);
  //     } else if (data[0] == 0) {
  //       toastr.error(lang.cart_out);
  //     } else {
  //       $("#cart-count").html(data[0]);
  //       $("#cart-count1").html(data[0]);
  //       $("#total-cost").html(data[1]);
  //       $(".cart-popup").load(mainurl + "/carts/view");
  //       toastr.success(lang.cart_success);
  //     }
  //   });
  //   return true;
  // });
  //modify add to cart logic for cross products
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).on("click", ".add_cart_click", function (e) {
    e.preventDefault();

    const $btn = $(this);
    const productId = $btn.data("product-id");
    const $wrapper = $btn.closest(".single-product");
    const measureType = $wrapper.find(".measure-select").data("measure-type");
    const selectedMeasureValue = parseFloat($wrapper.find(".measure-select").val() || 1);
    const basePrice = parseFloat($wrapper.find(".product-price").data("base-price"));
    let finalPrice = basePrice;

    // price calculation logic
    if (measureType === "KG" || measureType === "LTR") {
      finalPrice = basePrice * selectedMeasureValue;
    } else if (measureType === "PCS") {
      finalPrice = basePrice * selectedMeasureValue;
    }

    // send price & measure info via AJAX
    $.ajax({
      url: $btn.data("href"),
      method: "POST",
      data: {
        product_id: productId,
        measure_value: selectedMeasureValue,
        measure_type: measureType,
        final_price: finalPrice
      },
      success: function (data) {
        if (data == "digital") {
          toastr.error(lang.cart_already);
        } else if (data[0] == 0) {
          toastr.error(lang.cart_out);
        } else {
          console.log(data);
          
          $(".cart-count").html(data[0]);
          //$("#cart-count1").html(data[0]);
          //$("#total-cost").html(data[1]);
          $(".total_price").html(data[1]);
          $(".cart-popup").load(mainurl + "/carts/view");
          toastr.success(lang.cart_success);
        }
      },
    });
  });
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $(document).on("click", ".add_cart_details, .buy-now-btn", function (e) {
    e.preventDefault();

    let productId = $("#product-id").val();
    let quantity = $("#order-qty").val();
    const $btn = $(this);

    const measureType = $(".measure-select").data("measure-type");
    const selectedMeasureValue = parseFloat($(".measure-select").val() || 1);
    const basePrice = parseFloat($(".product-price").data("base-price"));

    // Calculate price
    let finalPrice = basePrice * selectedMeasureValue;
    console.log(finalPrice);
    

    $.ajax({
      url: $(".add_cart_details").data("href"), // same add-to-cart route
      method: "POST",
      data: {
        product_id: productId,
        measure_value: selectedMeasureValue,
        measure_type: measureType,
        final_price: finalPrice,
        quantity: quantity
      },
      success: function (data) {
        if (data == "digital") {
          return toastr.error(lang.cart_already);
        }

        if (data[0] == 0) {
          return toastr.error(lang.cart_out);
        }

        // Update cart info
        $("#cart-count").html(data[0]);
        $("#cart-count1").html(data[0]);
        $("#total-cost").html(data[1]);
        $(".cart-popup").load(mainurl + "/carts/view");

        // If BUY NOW clicked → redirect to cart
        if ($btn.hasClass("buy-now-btn")) {
          window.location.href = mainurl + "/carts";
        } else {
          toastr.success(lang.cart_success);
        }
      },
    });
  });

  //End add to cart

  $(document).on("click", ".quantity-up", function () {
    var pid = $(this).parent().find(".prodid").val();
    var itemid = $(this).parent().find(".itemid").val();
    var size_qty = $(this).parent().find(".size_qty").val();
    var item_price = $(this).parent().find(".item_price").val();
    var unique_key = $(this).parent().find(".unique_key").val();

    var size_price = $(this)
      .parent()
      .parent()
      .parent()
      .find(".size_price")
      .val();

    var stck = $("#stock" + itemid).val();
    var qty = parseInt($("#qty" + itemid).val());
    if (stck != "") {
      var stk = parseInt(stck);
      if (qty < stk) {
        qty++;
        $("#qty" + itemid).html(qty);
      }
    } else {
      qty++;
      $("#qty" + itemid).html(qty);
    }
    $.ajax({
      type: "GET",
      url: mainurl + "/addbyone",
      data: {
        id: pid,
        itemid: itemid,
        size_qty: size_qty,
        size_price: size_price,
        item_price: item_price,
        unique_key: unique_key,
      },
      success: function (data) {
        $(".gocover").hide();
        if (data == 0) {
          toastr.error(lang.cart_out);
        } else {
          $.get(mainurl + "/carts", function (response) {
            $(".load_cart").html(response);
          });
          window.location.reload();
        }
      },
    });
  });

  $(document).on("click", ".quantity-down", function () {
    var pid = $(this).siblings(".prodid").val();
    var itemid = $(this).siblings(".itemid").val();
    var size_qty = $(this).siblings(".size_qty").val();
    var size_price = $(this).siblings(".size_price").val();
    var qty = parseInt($("#qty" + itemid).val());
    var minimum_qty = $(this).siblings(".minimum_qty").val();
    var item_price = $(this).parent().find(".item_price").val();
    var unique_key = $(this).parent().find(".unique_key").val();

    $(".gocover").show();
    if (qty <= 1) {
      $("#qty" + itemid).val("1");
      $(".gocover").hide();
      return false;
    } else if (qty < minimum_qty) {
      return false;
    } else {
      $(".gocover").show();

      $("#qty" + itemid).val(qty);
      $.ajax({
        type: "GET",
        url: mainurl + "/reducebyone",
        data: {
          id: pid,
          itemid: itemid,
          size_qty: size_qty,
          size_price: size_price,
          item_price: item_price,
          unique_key: unique_key,
        },
        success: function (data) {
          console.log(data);
          if (data.qty >= 1) {
            $.get(mainurl + "/carts", function (response) {
              $(".load_cart").html(response);
            });

            window.location.reload();
          } else {
            console.log("Quantity less than 1");
            return false;
          }
        },
      });
    }
  });

  $(document).on("click", ".cart_size", function () {
    let qty = $(this).data("qty");
    $("#stock").val(qty);
    updateProductPrice();
  });
  $(document).on("click", ".cart_color", function () {
    updateProductPrice();
  });
  $(document).on("click", ".cart_attr", function () {
    updateProductPrice();
  });

  function updateProductPrice() {
    let size_price = $(".cart_size input:checked").attr("data-price");
    let color_price = $(".cart_color input:checked").attr("data-price");
    let attr_price = $(".cart_attr:checked")
      .map(function () {
        return $(this).data("price");
      })
      .get()
      .reduce((a, b) => a + b, 0);
    let main_price = $("#product_price").val();

    if (size_price == undefined) {
      size_price = 0;
    }
    if (color_price == undefined) {
      color_price = 0;
    }

    let total =
      parseFloat(size_price) +
      parseFloat(color_price) +
      parseFloat(attr_price) +
      parseFloat(main_price);

    var pos = $("#curr_pos").val();
    var sign = $("#curr_sign").val();
    if (pos == "0") {
      $("#sizeprice").html(sign + total);
    } else {
      $("#sizeprice").html(total + sign);
    }
  }
})(jQuery);
