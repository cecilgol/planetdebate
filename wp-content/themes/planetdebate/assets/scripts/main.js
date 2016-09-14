/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages
        $('input#s.form-control').focusin(function(){
          var initialValue = $(this).attr('placeholder');
          $(this).attr('placeholder','Find any File');
          $(this).focusout(function(){
            $(this).attr('placeholder',initialValue);
          });
        });
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired

        $('.subscriber-download-button').click(function(e){
        var dlid = this.id;
        var dlpk = $(this).data("product-id");
          $.post({
            url : document.location.origin + '/wp-admin/admin-ajax.php',
            data : {
              dlid: dlid,
              dlpk: dlpk,
              action: 'pd_subscriber_download'
            },
            success: function(response) {
              $('.subscriber-download-button#'+dlid).html(response).attr('href','/my-account').removeClass('subscriber-download-button');
            },
          });
        });


        $('.subcategory-link').click(function(e){
          var sclid = this.id;
          $.post({
            url : document.location.origin + '/wp-admin/admin-ajax.php',
            data : {
              sclid: sclid,
              action: 'pd_subcategory_link_clicked'
            },
            success: function(response) {
              $('.subcategory-link.active').removeClass('active');

              $('a#'+sclid+'.subcategory-link').addClass('active');

              $('ul.products').html(response);

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
          });
        });


        $('.i-heart-this').click(function(){
          var e = $(this);
          var pid = e.parents('.product-card').attr('id');
          var a = (e.hasClass('favorite'))?'d':'a';

          $.post({
            url : document.location.origin + '/wp-admin/admin-ajax.php',
            data : {
              a:a,
              pid: pid,
              action: 'pd_add_or_remove_hearts'
            },
            success: function(response) {
              var o = JSON.parse(response);
              if(o.hearts != null){
                var hearts = o.hearts;
                e.toggleClass('favorite');
                e.parents('.product-card#'+pid).find('.hearts').html("&nbsp;"+hearts);
              }
              if (o.html != null){
                e.attr('data-toggle','popover').attr('data-content',o.html);
                e.popover();
              }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
            }
          });
        });
        $('button.description-sh-btn').click(function(){
          var tic = $(this);
          $('.product-description#' + $(this).prop('id') + '-description').slideToggle(function(){
            if($(this).is(':visible')){
              tic.text("-");
            }else{
              tic.text("+");
            }
          });

        });


      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
       },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page

      }
    },
    'contact_us':{
      init: function(){
        function set_cookie(){
          var date = new Date();
          var minutes = 30;
          date.setTime(date.getTime() + (minutes * 60 * 1000));
          $.cookie("has_sent_message", true, { expires: date });
        }

        function is_email(email) {
          var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          return regex.test(email);
        }

        function send_pd_cu_email(){
          if($.cookie('has_sent_message')==="true"){
            $('.contact-us-submit').prop("disabled", true);
            $('.pd-cu-form').find('input, textarea').each(function(e){$(this).prop('disabled',true);});
            $('.pd-cu-form').find('.inline-warning').addClass('has-success').html('<p>We already recieved your message. You can navigate back <a href="/">home</a> or to <a href="/my-account">your account</a></p>');
            return;
          }
          var email   = $('.pd-cu-form').find('input#pd-cu-form-email').val();
          var name    = $('.pd-cu-form').find('input#pd-cu-form-name').val();
          var message = $('.pd-cu-form').find('textarea#pd-cu-form-message').val();
          var rr      = $('.pd-cu-form').find('input#pd-cu-form-rr').is(':checked');
          if (is_email(email)){
             $.post({
                url : document.location.origin + '/wp-admin/admin-ajax.php',
                data : {
                  action: 'pd_contact_us_submit',
                  e: $('.pd-cu-form').find('input#pd-cu-form-email').val(),
                  n: $('.pd-cu-form').find('input#pd-cu-form-name').val(),
                  m: $('.pd-cu-form').find('textarea#pd-cu-form-message').val(),
                  rr: $('.pd-cu-form').find('input#pd-cu-form-rr').is(':checked')
                },
                success: function(response) {
                  $('.contact-us-submit').prop("disabled", true);
                  $('.pd-cu-form').find('input,texatrea').each(function(){$(this).prop('disabled',true);});

                  $('.pd-cu-form').find('input#pd-cu-form-email').siblings('.inline-warning').addClass('has-success').html('<p>Your message was received! You can navigate back <a href="/">home</a> or to <a href="/my-account">your account</a></p>');
                  set_cookie();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {

                }
            });
          } else {
            $('.pd-cu-form').find('input#pd-cu-form-email').parents('.form-group').addClass('has-error');
            $('.pd-cu-form').find('input#pd-cu-form-email').siblings('.inline-warning').html('<p>Invalid email address.</p>');
          }
        }
        $('.pd-cu-form').submit(function(e){

          e.preventDefault();
          send_pd_cu_email();
          return false;
        });
      }
    },
    'free':{
      init: function(){
        var p = 2;
        $(window).scroll(function(){
          if ($(window).scrollTop() === $(document).height()-$(window).height()){
            $('uil-squares-css').removeClass('hidden');
            $.post({
              url : document.location.origin + '/wp-admin/admin-ajax.php',
              data : {
                p: p,
                action: 'pd_infinite_scroll'
              },
              success: function(response) {
                p += 1;
                $('.main').append(response);
                $('uil-squares-css').addClass('hidden');
              },
              error: function(XMLHttpRequest, textStatus, errorThrown) {
              }
            });
          }
        });
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
