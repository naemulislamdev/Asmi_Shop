/*
  Modified simpleCropper
  - Uses actual image display size
  - Allows custom output width/height and optional aspect ratio via data attributes
  - Selection is resizable unless an aspect ratio is provided
*/

(function($) {

  $.fn.simpleCropper = function() {

    // Defaults (no fixed forcing here)
    var maxDisplayWidth = 900;   // maximum preview width (in px) to fit in viewport
    var maxDisplayHeight = 700;  // maximum preview height (in px) to fit in viewport

    var scaled_width = 0;
    var scaled_height = 0;
    var x1 = 0;
    var y1 = 0;
    var x2 = 0;
    var y2 = 0;
    var current_image = null;
    var file_display_area = null;
    var jcrop_api = null;

    // bottom html only created once
    if (!$('#simplecropper-bottom').length) {
      var bottom_html = "<div id='simplecropper-bottom' style='display:none;'>" +
        "<input type='file' id='fileInput' accept='image/*'/>" +
        "<canvas id='sc-myCanvas' style='display:none;'></canvas>" +
        "<div id='sc-modal' style='display:none;position:fixed;left:0;top:0;right:0;bottom:0;background:rgba(0,0,0,0.5);z-index:9998;'></div>" +
        "<div id='sc-preview' style='display:none;position:fixed;z-index:9999;padding:10px;background:#fff;border-radius:6px;box-shadow:0 6px 30px rgba(0,0,0,0.3);'>" +
          "<div id='sc-image-wrap' style='overflow:hidden;display:inline-block;max-width:100%;max-height:100%;'></div>" +
          "<div style='margin-top:8px;display:flex;gap:8px;justify-content:flex-end;'>" +
            "<button class='sc-cancel btn btn-secondary'>Cancel</button>" +
            "<button class='sc-ok btn btn-primary'>OK</button>" +
          "</div>" +
        "</div>" +
      "</div>";
      $('body').append(bottom_html);
    }

    // add click to element - allow passing desired output size and aspect via data attributes:
    // data-output-width, data-output-height, data-aspect (like "16:9" or "1:1") - optional
    this.click(function() {
      file_display_area = $(this);
      $('#fileInput').click();
    });

    $(document).ready(function() {
      // file input change
      $('#fileInput').on('change', function() {
        if (this.files && this.files[0]) {
          imageUpload($('#sc-image-wrap').get(0), file_display_area);
          // reset the input so same file can be selected again if needed
          $(this).val('');
        }
      });

      // OK listener
      $(document).on('click', '.sc-ok', function() {
        preview(file_display_area);
        $('#sc-preview').hide();
        $('#sc-modal').hide();
        if (jcrop_api) {
          jcrop_api.destroy();
          jcrop_api = null;
        }
      });

      // Cancel listener
      $(document).on('click', '.sc-cancel', function() {
        $('#sc-preview').hide();
        $('#sc-modal').hide();
        if (jcrop_api) {
          jcrop_api.destroy();
          jcrop_api = null;
        }
        $('#sc-image-wrap').html('');
        current_image = null;
      });
    });

    function imageUpload(dropbox, triggerElem) {
      var file = $("#fileInput").get(0).files[0];
      var imageType = /image.*/;

      if (!file) return;
      if (!file.type.match(imageType)) {
        alert('File not supported!');
        return;
      }

      var reader = new FileReader();
      reader.onload = function(e) {

        // remove previous image
        $('#sc-image-wrap #sc-photo').remove();

        current_image = new Image();
        current_image.id = 'sc-photo';
        current_image.src = e.target.result;
        current_image.style.display = 'block';
        current_image.style.maxWidth = '100%';
        current_image.style.height = 'auto';

        current_image.onload = function() {
          // natural sizes
          var natW = current_image.naturalWidth;
          var natH = current_image.naturalHeight;

          // compute scaled display size to fit into preview viewport but keep aspect ratio
          var viewportW = Math.min(maxDisplayWidth, $(window).width() - 80); // leave margins
          var viewportH = Math.min(maxDisplayHeight, $(window).height() - 120);

          // start with natural size then scale down proportionally if needed
          scaled_width = natW;
          scaled_height = natH;

          var scale = Math.min(1, viewportW / natW, viewportH / natH);
          scaled_width = Math.round(natW * scale);
          scaled_height = Math.round(natH * scale);

          // set the wrapper size and append image
          var $wrap = $('#sc-image-wrap');
          $wrap.css({
            width: scaled_width + 'px',
            height: scaled_height + 'px',
            lineHeight: 0
          });

          current_image.width = scaled_width;
          current_image.height = scaled_height;

          $wrap.html(''); // clear
          $wrap.append(current_image);

          // position modal & preview center
          $('#sc-modal').show();
          var left = ($(window).width() - (scaled_width + 40)) / 2;
          var top = ($(window).height() - (scaled_height + 120)) / 2;
          $('#sc-preview').css({ left: Math.max(10, left) + 'px', top: Math.max(10, top) + 'px' }).show();

          // Get optional config from the trigger element
          var asp = null;
          var outW = null;
          var outH = null;
          if (triggerElem && triggerElem.length) {
            var aspData = triggerElem.data('aspect') || triggerElem.attr('data-aspect');
            if (aspData) {
              // data-aspect can be "16:9" or "1:1" etc
              var parts = String(aspData).split(':');
              if (parts.length === 2 && parseFloat(parts[0]) > 0 && parseFloat(parts[1]) > 0) {
                asp = parseFloat(parts[0]) / parseFloat(parts[1]);
              }
            }
            outW = parseInt(triggerElem.data('output-width') || triggerElem.attr('data-output-width')) || null;
            outH = parseInt(triggerElem.data('output-height') || triggerElem.attr('data-output-height')) || null;
          }

          // Initialize Jcrop - allow resize unless aspect ratio specified (we still allow ratio if specified)
          // Build initial selection: center area 60% of smaller dimension
          var selW = Math.round(scaled_width * 0.6);
          var selH = Math.round(scaled_height * 0.6);
          if (asp) {
            // adjust selection to match aspect ratio
            if (selW / selH > asp) {
              selW = Math.round(selH * asp);
            } else {
              selH = Math.round(selW / asp);
            }
          }

          var x0 = Math.round((scaled_width - selW) / 2);
          var y0 = Math.round((scaled_height - selH) / 2);
          var x1_sel = x0 + selW;
          var y1_sel = y0 + selH;

          // destroy previous jcrop if exists
          if (jcrop_api) {
            jcrop_api.destroy();
            jcrop_api = null;
          }

          // jQuery Jcrop initialization
          $(current_image).Jcrop({
            onSelect: showCoords,
            onChange: showCoords,
            bgColor: '#000',
            bgOpacity: 0.4,
            allowSelect: true,
            allowResize: true,
            aspectRatio: asp || 0, // 0 = free
            setSelect: [x0, y0, x1_sel, y1_sel],
            boxWidth: scaled_width,
            boxHeight: scaled_height
          }, function() {
            jcrop_api = this;
          });

          // reset coords initially
          x1 = x0; y1 = y0; x2 = x1_sel; y2 = y1_sel;
        }; // onload

      }; // reader.onload

      reader.readAsDataURL(file);
    } // imageUpload

    function showCoords(c) {
      // coordinates refer to displayed image pixels (not natural)
      x1 = c.x;
      y1 = c.y;
      x2 = c.x2;
      y2 = c.y2;
    }

    function preview(triggerElem) {
      if (!current_image) return;

      // optional output size from trigger element
      var outW = null;
      var outH = null;
      if (triggerElem && triggerElem.length) {
        outW = parseInt(triggerElem.data('output-width') || triggerElem.attr('data-output-width')) || null;
        outH = parseInt(triggerElem.data('output-height') || triggerElem.attr('data-output-height')) || null;
      }

      // If no selection made, use full image
      var sw = Math.max(1, x2 - x1);
      var sh = Math.max(1, y2 - y1);

      // natural image size
      var natW = current_image.naturalWidth;
      var natH = current_image.naturalHeight;

      // displayed image size
      var dispW = current_image.width;
      var dispH = current_image.height;

      // scaling factor from displayed image to natural image
      var scaleX = natW / dispW;
      var scaleY = natH / dispH;

      // coordinates in natural image
      var nx = Math.round(x1 * scaleX);
      var ny = Math.round(y1 * scaleY);
      var nsw = Math.round(sw * scaleX);
      var nsh = Math.round(sh * scaleY);

      // determine canvas output size
      var canvasW = outW || nsw; // if no target size specified, use selection natural width
      var canvasH = outH || nsh;

      // If an output width is specified but not height, preserve aspect ratio
      if (outW && !outH) {
        canvasH = Math.round(outW * (nsh / nsw));
      } else if (!outW && outH) {
        canvasW = Math.round(outH * (nsw / nsh));
      }

      // Draw to canvas, respecting desired output size
      var canvas = document.getElementById('sc-myCanvas');
      var context = canvas.getContext('2d');

      canvas.width = canvasW;
      canvas.height = canvasH;

      // clear
      context.clearRect(0, 0, canvas.width, canvas.height);

      // draw image portion into canvas scaled to desired canvas size
      context.drawImage(current_image,
                        nx, ny, nsw, nsh,  // source rect (natural image coords)
                        0, 0, canvasW, canvasH); // destination rect (canvas)

      var dataUrl = canvas.toDataURL('image/jpeg');

      // emit result into input inside trigger element if exists or append image
      // keep the same behavior you had: set #feature_photo input value and add img into area
      $('#feature_photo').val(dataUrl).trigger('change');

      // show thumbnail in the trigger element
      var imageFoo = document.createElement('img');
      imageFoo.src = dataUrl;
      imageFoo.style.maxWidth = '100%';
      imageFoo.style.height = 'auto';

      if (file_display_area && file_display_area.length) {
        file_display_area.html('');
        file_display_area.append(imageFoo);
      }

      // cleanup
      $('#sc-image-wrap').html('');
      current_image = null;
    }

    // reposition on window resize so preview stays centered
    $(window).resize(function() {
      if ($('#sc-preview').is(':visible')) {
        var left = ($(window).width() - ($('#sc-image-wrap').width() + 40)) / 2;
        var top = ($(window).height() - ($('#sc-image-wrap').height() + 120)) / 2;
        $('#sc-preview').css({ left: Math.max(10, left) + 'px', top: Math.max(10, top) + 'px' });
      }
    });

  };
}(jQuery));
