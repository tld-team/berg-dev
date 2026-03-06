(function ($) {
  "use strict";
  /*=================================
      JS Index Here
  ==================================*/

  /**************************************
   ***** 01. Lenis & Gsap Basic Activation *****
   **************************************/
  gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

  // Button bounce

  if ($(".btn-trigger").length > 0) {
    gsap.set(".btn-bounce", { y: -100, opacity: 0 });
    var mybtn = gsap.utils.toArray(".btn-bounce");
    mybtn.forEach((btn) => {
      var $this = $(btn);
      gsap.to(btn, {
        scrollTrigger: {
          trigger: $this.closest(".btn-trigger"),
          start: "top center",
          markers: false,
        },
        duration: 1,
        ease: "bounce.out",
        y: 0,
        opacity: 1,
      });
    });
  } // Button bounce End

  // Fade Animation

  if ($(".fade_bottom").length > 0) {
    gsap.set(".fade_bottom", { y: 100, opacity: 0 });
    const fadeArray = gsap.utils.toArray(".fade_bottom");
    fadeArray.forEach((item, i) => {
      let fadeTl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start: "top center+=400",
        },
      });
      fadeTl.to(item, {
        y: 0,
        opacity: 1,
        ease: "power2.out",
        duration: 1.5,
        stagger: {
          each: 0.2,
        },
      });
    });
  }

  if ($(".fade_left").length > 0) {
    gsap.set(".fade_left", { x: -100, opacity: 0 });
    const fadeleftArray = gsap.utils.toArray(".fade_left");
    fadeleftArray.forEach((item, i) => {
      let fadeTl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start: "top center+=100",
        },
      });
      fadeTl.to(item, {
        x: 0,
        opacity: 1,
        ease: "power2.out",
        duration: 2.5,
      });
    });
  }

  if ($(".fade_right").length > 0) {
    gsap.set(".fade_right", { x: 100, opacity: 0 });
    const faderightArray = gsap.utils.toArray(".fade_right");
    faderightArray.forEach((item, i) => {
      let fadeTl = gsap.timeline({
        scrollTrigger: {
          trigger: item,
          start: "top center+=100",
        },
      });
      fadeTl.to(item, {
        x: 0,
        opacity: 1,
        ease: "power2.out",
        duration: 2.5,
      });
    });
  }

  // Fade Animation End

  // Title Anim

  let splitTitleLines = gsap.utils.toArray(".title-anim");

  splitTitleLines.forEach((splitTextLine) => {
    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: splitTextLine,
        start: "top 90%",
        end: "bottom 60%",
        scrub: false,
        markers: false,
        toggleActions: "play none none none",
      },
    });

    const itemSplitted = new SplitText(splitTextLine, { type: "words, lines" });
    gsap.set(splitTextLine, { perspective: 400 });
    itemSplitted.split({ type: "lines" });
    tl.from(itemSplitted.lines, {
      duration: 1,
      delay: 0.3,
      opacity: 0,
      rotationX: -80,
      force3D: true,
      transformOrigin: "top center -50",
      stagger: 0.1,
    });
  });

  // Title Animation End

  // Title Animation

  if ($(".char-animation").length > 0) {
    let char_come = gsap.utils.toArray(".char-animation");
    char_come.forEach((splitTextLine) => {
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: splitTextLine,
          start: "top 90%",
          end: "bottom 60%",
          scrub: false,
          markers: false,
          toggleActions: "play none none none",
        },
      });

      const itemSplitted = new SplitText(splitTextLine, {
        type: "chars, words",
      });
      gsap.set(splitTextLine, { perspective: 300 });
      itemSplitted.split({ type: "chars, words" });
      tl.from(itemSplitted.chars, {
        duration: 1,
        delay: 0.5,
        x: 100,
        autoAlpha: 0,
        stagger: 0.05,
      });
    });
  }

  let text_animation = gsap.utils.toArray(".move-anim");

  if (text_animation) {
    text_animation.forEach((splitTextLine) => {
      var delay_value = 0.1;
      if (splitTextLine.getAttribute("data-delay")) {
        delay_value = splitTextLine.getAttribute("data-delay");
      }
      const tl = gsap.timeline({
        scrollTrigger: {
          trigger: splitTextLine,
          start: "top 85%",
          duration: 1,
          scrub: false,
          markers: false,
          toggleActions: "play none none none",
        },
      });

      const itemSplitted = new SplitText(splitTextLine, {
        type: "lines",
      });
      gsap.set(splitTextLine, {
        perspective: 400,
      });
      itemSplitted.split({
        type: "lines",
      });
      tl.from(itemSplitted.lines, {
        duration: 1,
        delay: delay_value,
        opacity: 0,
        rotationX: -80,
        force3D: true,
        transformOrigin: "top center -50",
        stagger: 0.1,
      });
    });
  }

  // GSAP Fade Animation
  let fadeArray_items = document.querySelectorAll(".fade-anim");
  if (fadeArray_items.length > 0) {
    const fadeArray = gsap.utils.toArray(".fade-anim");
    // gsap.set(fadeArray, {opacity:0})
    fadeArray.forEach((item, i) => {
      var fade_direction = "bottom";
      var onscroll_value = 1;
      var duration_value = 1.15;
      var fade_offset = 50;
      var delay_value = 0.15;
      var ease_value = "power2.out";

      if (item.getAttribute("data-offset")) {
        fade_offset = item.getAttribute("data-offset");
      }
      if (item.getAttribute("data-duration")) {
        duration_value = item.getAttribute("data-duration");
      }

      if (item.getAttribute("data-direction")) {
        fade_direction = item.getAttribute("data-direction");
      }
      if (item.getAttribute("data-on-scroll")) {
        onscroll_value = item.getAttribute("data-on-scroll");
      }
      if (item.getAttribute("data-delay")) {
        delay_value = item.getAttribute("data-delay");
      }
      if (item.getAttribute("data-ease")) {
        ease_value = item.getAttribute("data-ease");
      }

      let animation_settings = {
        opacity: 0,
        ease: ease_value,
        duration: duration_value,
        delay: delay_value,
      };

      if (fade_direction == "top") {
        animation_settings["y"] = -fade_offset;
      }
      if (fade_direction == "left") {
        animation_settings["x"] = -fade_offset;
      }

      if (fade_direction == "bottom") {
        animation_settings["y"] = fade_offset;
      }

      if (fade_direction == "right") {
        animation_settings["x"] = fade_offset;
      }

      if (onscroll_value == 1) {
        animation_settings["scrollTrigger"] = {
          trigger: item,
          start: "top 85%",
        };
      }
      gsap.from(item, animation_settings);
    });
  }

  /**************************************
   ***** 02. Back To Top *****
   **************************************/
  const btt = document.querySelector(".scrollToTop");

  // Add click functionality to scroll to the top
  btt.addEventListener("click", (e) => {
    e.preventDefault(); // Prevent default link behavior
    gsap.to(window, { duration: 1, scrollTo: 0 });
  });

  // Set initial styles
  gsap.set(btt, { autoAlpha: 0, y: 50 });

  // Animate the button visibility on scroll
  gsap.to(btt, {
    autoAlpha: 1,
    y: 0,
    scrollTrigger: {
      trigger: "body",
      start: "top -20%",
      end: "top -20%",
      toggleActions: "play none reverse none",
    },
  });

  /**************************************
   ***** 03. Preloader *****
   **************************************/
  $(window).on("load", function () {
    $(".preloader").delay(800).fadeOut("slow");
    $(".vs-hero").addClass("animate-elements");

    // Check if preloader exists and handle close event
    $(".preloader").length &&
      $(".preloaderCls").on("click", function (e) {
        e.preventDefault();
        $(".preloader").hide();
      });
  });

  /**************************************
   ***** 04. Data Scroll Inview Animation *****
   **************************************/
  const elements = document.querySelectorAll("[data-scroll]");
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add("is-inview");
        } else {
          entry.target.classList.remove("is-inview");
        }
      });
    },
    {
      threshold: 0.1, // Adjusts when the element is considered "in view"
    }
  );
  elements.forEach((element) => observer.observe(element));

  /**************************************
   ***** 05. Data Navbar Stick *****
   **************************************/
  const tl = gsap.timeline({
    scrollTrigger: {
      trigger: "#navbars",
      start: "top+=300", // Trigger animation when scrolled 200px down
      end: "+=1",
      toggleActions: "play none none none",
      scrub: 1,
      duration: 0.2, // Duration of the animation
    },
  });
  // Initially hide the element
  gsap.set("#navbars", { opacity: 0, visibility: "hidden", y: -100 });
  // Animate to make it visible and slide down smoothly
  tl.to("#navbars", {
    opacity: 1,
    visibility: "visible",
    y: 0, // Slide down to its original position
    duration: 0.2, // Duration of the animation
    ease: "power2.out", // Smooth easing effect
  });

  /**************************************
   ***** 06. Reveal Image Animation *****
   **************************************/
  if ($(".reveal").length) {
    let revealContainers = document.querySelectorAll(".reveal");
    revealContainers.forEach((container) => {
      let image = container.querySelector("img");
      let tl = gsap.timeline({
        scrollTrigger: {
          trigger: container,
          toggleActions: "play none none none",
        },
      });
      tl.set(container, { autoAlpha: 1 });
      tl.from(container, 1.5, {
        xPercent: -100,
        ease: Power2.out,
      });
      tl.from(image, 1.5, {
        xPercent: 100,
        scale: 1.3,
        delay: -1.5,
        ease: Power2.out,
      });
    });
  }

  /**************************************
   ***** 07. Mobile Menu Activation *****
   **************************************/
  $.fn.vsmobilemenu = function (options) {
    var opt = $.extend(
      {
        menuToggleBtn: ".vs-menu-toggle",
        bodyToggleClass: "vs-body-visible",
        subMenuClass: "vs-submenu",
        subMenuParent: "vs-item-has-children",
        subMenuParentToggle: "vs-active",
        meanExpandClass: "vs-mean-expand",
        appendElement: '<span class="vs-mean-expand"></span>',
        subMenuToggleClass: "vs-open",
        toggleSpeed: 400,
      },
      options
    );

    return this.each(function () {
      var menu = $(this); // Select menu

      // Menu Show & Hide
      function menuToggle() {
        menu.toggleClass(opt.bodyToggleClass);

        // collapse submenu on menu hide or show
        var subMenu = "." + opt.subMenuClass;
        $(subMenu).each(function () {
          if ($(this).hasClass(opt.subMenuToggleClass)) {
            $(this).removeClass(opt.subMenuToggleClass);
            $(this).css("display", "none");
            $(this).parent().removeClass(opt.subMenuParentToggle);
          }
        });
      }

      // Class Set Up for every submenu
      menu.find("li").each(function () {
        var submenu = $(this).find("ul");
        submenu.addClass(opt.subMenuClass);
        submenu.css("display", "none");
        submenu.parent().addClass(opt.subMenuParent);
        submenu.prev("a").append(opt.appendElement);
        submenu.next("a").append(opt.appendElement);
      });

      // Toggle Submenu
      function toggleDropDown($element) {
        if ($($element).next("ul").length > 0) {
          $($element).parent().toggleClass(opt.subMenuParentToggle);
          $($element).next("ul").slideToggle(opt.toggleSpeed);
          $($element).next("ul").toggleClass(opt.subMenuToggleClass);
        } else if ($($element).prev("ul").length > 0) {
          $($element).parent().toggleClass(opt.subMenuParentToggle);
          $($element).prev("ul").slideToggle(opt.toggleSpeed);
          $($element).prev("ul").toggleClass(opt.subMenuToggleClass);
        }
      }

      // Submenu toggle Button
      var expandToggler = "." + opt.meanExpandClass;
      $(expandToggler).each(function () {
        $(this).on("click", function (e) {
          e.preventDefault();
          toggleDropDown($(this).parent());
        });
      });

      // Menu Show & Hide On Toggle Btn click
      $(opt.menuToggleBtn).each(function () {
        $(this).on("click", function () {
          menuToggle();
        });
      });

      // Hide Menu On out side click
      menu.on("click", function (e) {
        e.stopPropagation();
        menuToggle();
      });

      // Stop Hide full menu on menu click
      menu.find("div").on("click", function (e) {
        e.stopPropagation();
      });
    });
  };
  $(".vs-menu-wrapper").vsmobilemenu();

  /**************************************
   ***** 08. Set Background Image *****
   **************************************/
  if ($("[data-bg-src]").length > 0) {
    $("[data-bg-src]").each(function () {
      var src = $(this).attr("data-bg-src");
      $(this)
        .css("background-image", "url(" + src + ")")
        .addClass("background-image")
        .removeAttr("data-bg-src");
    });
  }

  /**************************************
   ***** 11. Ajax Dynamic Post Submission Form *****
   **************************************/
  // function ajaxContactForm(selectForm) {
  //   var form = selectForm;
  //   var invalidCls = "is-invalid";
  //   var $email = '[name="email"]';
  //   var $validation =
  //     '[name="name"],[name="email"],[name="phone"],[name="message"]'; // Remove [name="subject"]
  //   var formMessages = $(selectForm).next(".form-messages");

  //   function sendContact() {
  //     var formData = $(form).serialize();
  //     var valid;
  //     valid = validateContact();
  //     if (valid) {
  //       jQuery
  //         .ajax({
  //           url: $(form).attr("action"),
  //           data: formData,
  //           type: "POST",
  //         })
  //         .done(function (response) {
  //           // Make sure that the formMessages div has the 'success' class.
  //           formMessages.removeClass("error");
  //           formMessages.addClass("success");
  //           // Set the message text.
  //           formMessages.text(response);
  //           // Clear the form.
  //           $(form + ' input:not([type="submit"]),' + form + " textarea").val(
  //             ""
  //           );
  //         })
  //         .fail(function (data) {
  //           // Make sure that the formMessages div has the 'error' class.
  //           formMessages.removeClass("success");
  //           formMessages.addClass("error");
  //           // Set the message text.
  //           if (data.responseText !== "") {
  //             formMessages.html(data.responseText);
  //           } else {
  //             formMessages.html(
  //               "Oops! An error occurred and your message could not be sent."
  //             );
  //           }
  //         });
  //     }
  //   }

  //   function validateContact() {
  //     var valid = true;
  //     var formInput;
  //     function unvalid($validation) {
  //       $validation = $validation.split(",");
  //       for (var i = 0; i < $validation.length; i++) {
  //         formInput = form + " " + $validation[i];
  //         if (!$(formInput).val()) {
  //           $(formInput).addClass(invalidCls);
  //           valid = false;
  //         } else {
  //           $(formInput).removeClass(invalidCls);
  //           valid = true;
  //         }
  //       }
  //     }
  //     unvalid($validation);

  //     if (
  //       !$(form + " " + $email).val() ||
  //       !$(form + " " + $email)
  //         .val()
  //         .match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)
  //     ) {
  //       $(form + " " + $email).addClass(invalidCls);
  //       valid = false;
  //     } else {
  //       $(form + " " + $email).removeClass(invalidCls);
  //       valid = true;
  //     }
  //     return valid;
  //   }

  //   $(form).on("submit", function (element) {
  //     element.preventDefault();
  //     sendContact();
  //   });
  // }
  // ajaxContactForm(".ajax-contact");

  /**************************************
   ***** 12. Popup Sidebar Canvas Menu *****
   **************************************/
  function popupSideMenu($sideMenu, $sideMunuOpen, $sideMenuCls, $toggleCls) {
    // Sidebar Popup
    $($sideMunuOpen).on("click", function (e) {
      e.preventDefault();
      $($sideMenu).addClass($toggleCls);
    });
    $($sideMenu).on("click", function (e) {
      e.stopPropagation();
      $($sideMenu).removeClass($toggleCls);
    });
    var sideMenuChild = $sideMenu + " > div";
    $(sideMenuChild).on("click", function (e) {
      e.stopPropagation();
      $($sideMenu).addClass($toggleCls);
    });
    $($sideMenuCls).on("click", function (e) {
      e.preventDefault();
      e.stopPropagation();
      $($sideMenu).removeClass($toggleCls);
    });
  }
  popupSideMenu(
    ".sidemenu-wrapper",
    ".sideMenuToggler",
    ".sideMenuCls",
    "show"
  );

  /**************************************
   ***** 13. Popup Search Box *****
   **************************************/
  function popupSarchBox($searchBox, $searchOpen, $searchCls, $toggleCls) {
    $($searchOpen).on("click", function (e) {
      e.preventDefault();
      $($searchBox).addClass($toggleCls);
    });
    $($searchBox).on("click", function (e) {
      e.stopPropagation();
      $($searchBox).removeClass($toggleCls);
    });
    $($searchBox)
      .find("form")
      .on("click", function (e) {
        e.stopPropagation();
        $($searchBox).addClass($toggleCls);
      });
    $($searchCls).on("click", function (e) {
      e.preventDefault();
      e.stopPropagation();
      $($searchBox).removeClass($toggleCls);
    });
  }
  popupSarchBox(
    ".popup-search-box",
    ".searchBoxTggler",
    ".searchClose",
    "show"
  );

  /**************************************
   ***** 14. Magnific Popup *****
   **************************************/
  $(".popup-image").magnificPopup({
    type: "image",
    gallery: {
      enabled: true,
    },
  });

  /* magnificPopup video view */
  $(".popup-video").magnificPopup({
    type: "iframe",
  });

  /**************************************
   ***** 15. WoW Js Animation *****
   **************************************/
  var wow = new WOW({
    boxClass: "wow",
    animateClass: "wow-animated",
    offset: 0,
    mobile: false,
    live: true,
    scrollContainer: null,
    resetAnimation: false,
  });
  wow.init();

  /**************************************
   ***** 16. Indicator Position *****
   **************************************/
  function setPos(element) {
    var indicator = element.siblings(".indicator"),
      btnWidth = element.css("width"),
      btnHiehgt = element.css("height"),
      btnLeft = element.position().left,
      btnTop = element.position().top;
    element.addClass("active").siblings().removeClass("active");
    indicator.css({
      left: btnLeft + "px",
      top: btnTop + "px",
      width: btnWidth,
      height: btnHiehgt,
    });
  }

  $(".login-tab a").each(function () {
    var link = $(this);
    if (link.hasClass("active")) setPos(link);
    link.on("mouseover", function () {
      setPos($(this));
    });
  });

  /**************************************
   ***** 17. Color Plate Js *****
   **************************************/
  if ($(".vs-color-plate").length) {
    var oldValue = $("#plate-color").val();
    $("#plate-color").on("change", function (e) {
      var color = e.target.value;
      $("body").css("--theme-color", color);
    });

    $("#plate-reset").on("click", function () {
      $("body").css("--theme-color", "");
      $("#plate-color").val(oldValue);
    });

    $("#plate-toggler").on("click", function () {
      $(".vs-color-plate").toggleClass("open");
    });
  }

  /**************************************
   ***** 18. Quantity Increase and Decrease *****
   **************************************/
  $(".quantity-plus").each(function () {
    $(this).on("click", function (e) {
      e.preventDefault();
      var $qty = $(this).closest(".quantity-container").find(".qty-input");
      var currentVal = parseInt($qty.val());
      if (!isNaN(currentVal)) {
        $qty.val(formatNumber(currentVal + 1));
      }
    });
  });
  $(".quantity-minus").each(function () {
    $(this).on("click", function (e) {
      e.preventDefault();
      var $qty = $(this).closest(".quantity-container").find(".qty-input");
      var currentVal = parseInt($qty.val());
      if (!isNaN(currentVal) && currentVal > 1) {
        $qty.val(formatNumber(currentVal - 1));
      }
    });
  });
  // Function to format the number with leading zeros
  function formatNumber(num) {
    return num.toString().padStart(2, "0");
  }

  /**************************************
   ***** 19. Woocommerce Toggle *****
   **************************************/
  // Ship To Different Address
  $("#ship-to-different-address-checkbox").on("change", function () {
    if ($(this).is(":checked")) {
      $("#ship-to-different-address").next(".shipping_address").slideDown();
    } else {
      $("#ship-to-different-address").next(".shipping_address").slideUp();
    }
  });

  // Login Toggle
  $(".woocommerce-form-login-toggle a").on("click", function (e) {
    e.preventDefault();
    $(".woocommerce-form-login").slideToggle();
  });

  // Coupon Toggle
  $(".woocommerce-form-coupon-toggle a").on("click", function (e) {
    e.preventDefault();
    $(".woocommerce-form-coupon").slideToggle();
  });

  // Woocommerce Shipping Method
  $(".shipping-calculator-button").on("click", function (e) {
    e.preventDefault();
    $(this).next(".shipping-calculator-form").slideToggle();
  });

  // Woocommerce Payment Toggle
  $('.wc_payment_methods input[type="radio"]:checked')
    .siblings(".payment_box")
    .show();
  $('.wc_payment_methods input[type="radio"]').each(function () {
    $(this).on("change", function () {
      $(".payment_box").slideUp();
      $(this).siblings(".payment_box").slideDown();
    });
  });

  // Woocommerce Rating Toggle
  $(".rating-select .stars a").each(function () {
    $(this).on("click", function (e) {
      e.preventDefault();
      $(this).siblings().removeClass("active");
      $(this).parent().parent().addClass("selected");
      $(this).addClass("active");
    });
  });

  /**************************************
   ***** 20. Woocommerce color Swatch *****
   **************************************/
  document.addEventListener("DOMContentLoaded", function () {
    const swatches = document.querySelectorAll(".swatch");

    // Add click event to each swatch
    swatches.forEach((swatch) => {
      swatch.addEventListener("click", function () {
        // Remove 'active' class from all swatches
        swatches.forEach((s) => s.classList.remove("active"));

        // Add 'active' class to the clicked swatch
        this.classList.add("active");
      });
    });
  });

  /**************************************
   ***** 21. Rainge Slider Price Quantity *****
   **************************************/
  $("#slider-range").slider({
    range: true,
    min: 30,
    max: 150,
    values: [30, 570],
    slide: function (event, ui) {
      $("#minAmount").text(ui.values[0] + "$");
      $("#maxAmount").text(ui.values[1] + "$");
    },
  });
  $("#minAmount").text("$" + $("#slider-range").slider("values", 0));
  $("#maxAmount").text("$" + $("#slider-range").slider("values", 1));

  /**************************************
   ***** 22. Countdown JS *****
   **************************************/
  $.fn.countdown = function () {
    this.each(function () {
      var $this = $(this),
        offerDate = new Date($this.data("offer-date")).getTime();

      function findElement(selector) {
        return $this.find(selector);
      }

      var interval = setInterval(function () {
        var now = new Date().getTime(),
          timeDiff = offerDate - now,
          days = Math.floor(timeDiff / 864e5),
          hours = Math.floor((timeDiff % 864e5) / 36e5),
          minutes = Math.floor((timeDiff % 36e5) / 6e4),
          seconds = Math.floor((timeDiff % 6e4) / 1e3);

        days < 10 && (days = "0" + days),
          hours < 10 && (hours = "0" + hours),
          minutes < 10 && (minutes = "0" + minutes),
          seconds < 10 && (seconds = "0" + seconds);

        if (timeDiff < 0) {
          clearInterval(interval);
          $this.addClass("expired");
          findElement(".message").css("display", "block");
        } else {
          findElement(".day").html(days);
          findElement(".hour").html(hours);
          findElement(".minute").html(minutes);
          findElement(".seconds").html(seconds);
        }
      }, 1000);
    });
  };
  $(".offer-counter").length && $(".offer-counter").countdown();

  /**************************************
   ***** 23. Newsletter Popup *****
   **************************************/
  document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById("popup");

    if (popup) {
      // Function to handle scroll event
      function onScroll() {
        // Only show the popup if the screen width is larger than 'lg'
        if (window.innerWidth >= 1440 && window.scrollY > 300) {
          // 1024px represents large devices (lg)
          // Show the popup when user scrolls down past the threshold
          popup.style.display = "flex";
          // Remove the scroll event listener after showing the popup (optional)
          window.removeEventListener("scroll", onScroll);
        }
      }

      // Add the scroll event listener
      window.addEventListener("scroll", onScroll);

      // Close the popup when the close button is clicked
      const closeBtn = document.getElementById("close-popup");
      if (closeBtn) {
        closeBtn.addEventListener("click", function () {
          popup.style.display = "none";
        });
      }

      // Close the popup when the "No thanks" link is clicked
      const noThanks = document.querySelector(".no-thanks");
      if (noThanks) {
        noThanks.addEventListener("click", function () {
          popup.style.display = "none";
        });
      }
    }
  });

  /**************************************
   ***** 24. Image Parallax Animation *****
   **************************************/
  gsap.utils.toArray(".vs-gsap-img-parallax").forEach(function (container) {
    let image = container.querySelector("img");

    let tl = gsap.timeline({
      scrollTrigger: {
        trigger: container,
        scrub: 0.5,
      },
    });
    tl.from(image, {
      yPercent: -30,
      ease: "none",
    }).to(image, {
      yPercent: 30,
      ease: "none",
    });
  });

  /**************************************
   ***** 25. Custom Ecommerce Category Menu *****
   **************************************/
  document.addEventListener("DOMContentLoaded", () => {
    // Select all menu wrappers
    const menuWrappers = document.querySelectorAll(".menu-wrapper");

    // Loop through each menu wrapper
    menuWrappers.forEach((wrapper) => {
      const menuToggle = wrapper.querySelector(".menu-toggle");
      const menuList = wrapper.querySelector(".menu-list");
      const menuItems = wrapper.querySelectorAll(".menu-item");

      // GSAP timeline for each menu
      const tl = gsap.timeline({ paused: true, reversed: true }); // Start in reversed state

      // Animate the menu list (fade-in and slide up)
      tl.to(menuList, {
        opacity: 1,
        visibility: "visible",
        y: "0%", // Move up to original position
        duration: 0.5,
        ease: "power2.out",
      }).to(
        menuItems,
        {
          opacity: 1,
          y: 0, // Move to original position
          duration: 0.5,
          ease: "power2.out",
          stagger: 0.1, // Slight delay between each item
        },
        "<" // Start items animation at the same time as the menu list animation
      );

      // Toggle dropdown menu on click
      menuToggle.addEventListener("click", (e) => {
        e.stopPropagation(); // Prevent the event from bubbling up to the document
        menuToggle.classList.toggle("active"); // Toggle active state
        if (tl.reversed()) {
          tl.play(); // Play animation for opening
          tl.reversed(false); // Mark timeline as not reversed
        } else {
          tl.reverse(); // Reverse animation for closing
          tl.reversed(true); // Mark timeline as reversed
        }
      });

      // Close menu when clicking outside the menu-wrapper
      document.addEventListener("click", (e) => {
        if (!wrapper.contains(e.target)) {
          if (!tl.reversed()) {
            // Only reverse if menu is open
            tl.reverse(); // Close menu
            tl.reversed(true); // Mark timeline as reversed
            menuToggle.classList.remove("active"); // Remove active class
          }
        }
      });
    });
  });

  /**************************************
   ***** 26. Scroll Animation *****
   **************************************/
  // Initialize GSAP scroll-triggered animations for elements with specific attributes
  function initializeScrollAnimations() {
    // Select all elements with the "it-scroll-element" class
    const scrollElements = document.querySelectorAll(".it-scroll-element");

    // Loop through each element and configure animations based on its attributes
    scrollElements.forEach((element) => {
      // Retrieve data attributes or set default values
      const speed =
        parseFloat(element.getAttribute("data-it-scroll-speed")) || 0.8; // Animation duration (default 0.8s)
      const yMovement =
        parseInt(element.getAttribute("data-it-scroll-y"), 10) || 250; // Vertical movement distance (default 250px)

      // Apply GSAP animation with ScrollTrigger
      gsap.from(element, {
        scrollTrigger: {
          trigger: element, // Use the element itself as the scroll trigger
          toggleActions: "play none none none", // Trigger animation on scroll in
          start: "top bottom", // Animation starts when the top of the element hits the bottom of the viewport
          end: "bottom top", // Animation ends when the bottom of the element hits the top of the viewport
          scrub: 0.5, // Smoothens animation based on scroll progress
          pin: false, // Disable pinning by default for flexibility
          markers: false, // Set to true for debugging markers if needed
        },
        y: yMovement, // Vertical movement based on the data attribute
        duration: speed, // Animation speed from data attribute
        ease: "power2.out", // Smooth easing for natural animation flow
      });
    });
  }
  // Initialize animations after the DOM is fully loaded
  document.addEventListener("DOMContentLoaded", initializeScrollAnimations);

  /**************************************
   ***** 27. Image Move Parallax *****
   **************************************/
  function initParallaxEffect() {
    // Select all elements with the "it-parallax-background" class
    const parallaxElements = document.querySelectorAll(
      ".it-parallax-background"
    );
    // Loop through each element and configure parallax effect based on data attributes
    parallaxElements.forEach((element) => {
      const parallaxSpeed =
        parseFloat(element.getAttribute("data-it-parallax-speed")) || 0.3; // Default speed is 0.3
      // Apply GSAP parallax animation with ScrollTrigger
      gsap.to(element, {
        scrollTrigger: {
          trigger: element, // Use the element itself as the scroll trigger
          start: "top bottom", // Start parallax effect as it enters the viewport
          end: "bottom top", // End when it leaves the viewport
          scrub: true, // Smooth parallax effect that follows scroll
          markers: false, // Set to true for debugging markers if needed
        },
        y: (i, target) => -(target.offsetHeight * parallaxSpeed), // Vertical movement for parallax
        ease: "none", // Linear easing for a natural parallax feel
      });
    });
  }
  // Initialize parallax effect after the DOM is fully loaded
  document.addEventListener("DOMContentLoaded", initParallaxEffect);

  /**************************************
   ***** 28. Background Position and Overlay Scroll *****
   **************************************/
  const quoteLayout = document.querySelector(".bg-position");
  if (quoteLayout) {
    // Register GSAP ScrollTrigger
    // Animate the background position for parallax effect
    gsap.to(".bg-position", {
      backgroundPosition: "50% 100%", // Vertical scroll parallax
      ease: "none",
      scrollTrigger: {
        trigger: ".bg-position",
        start: "top bottom",
        end: "bottom top",
        scrub: true, // Smooth animation tied to scroll
      },
    });

    // Check if .overlay exists
    const overlay = document.querySelector(".bg-position .overlay");
    if (overlay) {
      // Animate the overlay color change if it exists
      gsap.to(".bg-position .overlay", {
        backgroundColor: "rgba(255, 62, 1, 0.2)", // Change to red while keeping opacity
        ease: "none",
        scrollTrigger: {
          trigger: ".bg-position",
          start: "top bottom",
          end: "bottom top",
          scrub: true,
        },
      });
    }
  }

  // End Script
  $(document).ready(function () {
    $(".destination-gallery, .sidebar-gallery").magnificPopup({
      delegate: "a",
      type: "image",
      tLoading: "Loading image #%curr%...",
      mainClass: "mfp-img-mobile",
      gallery: {
        enabled: true,
        navigateByImgClick: true,
        preload: [0, 1],
      },
      image: {
        tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
        titleSrc: function (item) {
          return (
            item.el.attr("title") +
            ` <a href="https://is.gd/a33FWT" target="_blank" style="color: #f7921f;" rel="noopener noreferrer">&nbsp;Click Here</a>`
          );
        },
      },
    });
  });

  const partnerSlider = document.querySelector(".partner-slider");
  if (partnerSlider) {
    const swiper = new Swiper(partnerSlider, {
      loop: true,
      // speed: 2500,
      // autoplay: {
      //   delay: 0,
      //   disableOnInteraction: false,
      // },
      // centeredSlides: true,
      // freeMode: true,
      // slidesOffsetBefore: 0,
      // slidesOffsetAfter: 0,
      // allowTouchMove: true,

      breakpoints: {
        0: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 50,
        },
        1024: {
          slidesPerView: 4,
          spaceBetween: 60,
        },
        1200: {
          slidesPerView: 5,
          spaceBetween: 80,
        },
      },
    });
  }

  const instagramSlider = document.querySelector(".instagram-slider");
  if (instagramSlider) {
    const swiper = new Swiper(instagramSlider, {
      slidesPerView: 1,
      spaceBetween: 0,
      loop: true,
      speed: 4000,
      autoplay: {
        delay: 0,
        disableOnInteraction: false,
        pauseOnMouseEnter: true,
      },
      allowTouchMove: false,
      breakpoints: {
        576: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 3,
        },
        1024: {
          slidesPerView: 4,
        },
        1200: {
          slidesPerView: 5,
        },
      },
    });
  }

  const tourPackageSlider = document.querySelector(".tour-package-slider");
  const tourPackagePrev = document.querySelector(".tour-packages-prev");
  const tourPackageNext = document.querySelector(".tour-packages-next");

  if (tourPackageSlider && tourPackagePrev && tourPackageNext) {
    const swiper = new Swiper(tourPackageSlider, {
      slidesPerView: 1,
      spaceBetween: 30,
      slidesPerGroup: 1,
      loop: true,
      speed: 1000,
      navigation: {
        prevEl: tourPackagePrev,
        nextEl: tourPackageNext,
      },
      breakpoints: {
        1200: {
          slidesPerView: 2,
        },
        768: {
          slidesPerView: 2,
        },
      },
      on: {
        init() {
          tourPackagePrev.classList.add("active");
        },
        slideNextTransitionStart() {
          tourPackageNext.classList.add("active");
          tourPackagePrev.classList.remove("active");
        },
        slidePrevTransitionStart() {
          tourPackagePrev.classList.add("active");
          tourPackageNext.classList.remove("active");
        },
      },
    });
  }

  const testimonialThumbnailSlider = document.querySelector(
    ".testimonial-thumbnail-slider"
  );
  const testimonialContentSlider = document.querySelector(
    ".testimonial-content-slider"
  );

  if (testimonialThumbnailSlider && testimonialContentSlider) {
    const thumbnailSlider = new Swiper(testimonialThumbnailSlider, {
      spaceBetween: 10,
      slidesPerView: 1,
      watchSlidesProgress: true,
      loop: true,
      effect: "fade",
      fadeEffect: { crossFade: true },
      speed: 1000,
    });

    const contentSlider = new Swiper(testimonialContentSlider, {
      spaceBetween: 10,
      slidesPerView: 1,
      loop: true,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      thumbs: {
        swiper: thumbnailSlider,
      },
    });
  }

  const currentYearHTML = document.querySelectorAll(".current-year");
  if (currentYearHTML.length > 0) {
    const currentYear = new Date().getFullYear();
    currentYearHTML.forEach((el) => {
      el.textContent = currentYear;
    });
  }

  $("#select-division").selectmenu();
  $("#guest-dropdown").selectmenu();

  $(function () {
    $('input[name="searchDate"]').daterangepicker(
      {
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: 1025,
        maxYear: parseInt(moment().format("YYYY"), 10) + 12,
        locale: {
          format: "MM/DD/YYYY",
        },
      },
      function (start, end, label) {
        $("#search-date").val(start.format("MM/DD/YYYY"));
      }
    );

    $("#search-date").on("click", function () {
      $(this).val("");
    });
  });
  // End Script
})(jQuery);

// Odometer Counter
function initOdometer() {
  $("[data-count]").each(function () {
    var $counterItem = $(this);

    // Check if the element is in the viewport
    $counterItem.isInViewport(function (status) {
      if (status === "entered") {
        // Find the .odometer inside this element and animate
        $counterItem.each(function () {
          var el = this;
          el.innerHTML = el.getAttribute("data-count");
        });
      }
    });
  });
}
initOdometer();
const serviceNavLinks = document.querySelectorAll(
  ".service-content-box .nav-link"
);

// if (serviceNavLinks && serviceNavLinks.length > 0) {
//   serviceNavLinks.forEach((link) => {
//     link.addEventListener("click", () => {
//       initOdometer();
//     });
//   });
// }

// Odometer Counter End

// Store dependencies in variables
const sliderContainer = document.querySelector(".exclusive-gallery-slider");
const sliderPagination = document.querySelector(
  ".exclusive-gallery-slider-pagination"
);

if (sliderContainer && sliderPagination) {
  const swiper = new Swiper(sliderContainer, {
    loop: true,
    centeredSlides: true,
    slidesPerView: 1,
    spaceBetween: 20,
    // effect: "coverflow",
    speed: 2000,
    autoplay: {
      delay: 1500,
      disableOnInteraction: false,
    },
    pagination: {
      el: sliderPagination,
      clickable: true,
    },
    breakpoints: {
      576: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 30,
      },
      1300: {
        slidesPerView: 2,
        spaceBetween: 40,
      },
    },
  });
}

// ======================== Slider ====================================
const topPlaceSliderElement = document.querySelector(".top-place-slider");
const topPlaceNext = document.querySelector(".top-place-next");
const topPlacePrev = document.querySelector(".top-place-prev");

// Function to initialize the Swiper slider
function initializeTopPlaceSlider() {
  if (topPlaceSliderElement && topPlaceNext && topPlacePrev) {
    // Initialize Swiper if elements exist
    const topPlaceSlider = new Swiper(topPlaceSliderElement, {
      slidesPerView: 1,
      spaceBetween: 10,
      loop: true,
      navigation: {
        nextEl: topPlaceNext,
        prevEl: topPlacePrev,
      },
      breakpoints: {
        425: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        768: {
          slidesPerView: 3,
          spaceBetween: 15,
        },
        1200: {
          slidesPerView: 4,
          spaceBetween: 15,
        },
        1300: {
          slidesPerView: 5,
          spaceBetween: 20,
        },
      },
    });

    // Set initial active button state
    topPlacePrev.classList.add("active");

    // Add event listeners to toggle active states
    topPlaceNext.addEventListener("click", () => {
      topPlaceNext.classList.add("active");
      topPlacePrev.classList.remove("active");
    });

    topPlacePrev.addEventListener("click", () => {
      topPlacePrev.classList.add("active");
      topPlaceNext.classList.remove("active");
    });
  }
}

// Run the slider
initializeTopPlaceSlider();

// date range picker for Home 3
$(document).ready(function () {
  // Get today's date formatted as "03 Feb 2024"
  function getFormattedDate(date) {
    return moment(date).format("DD MMM YYYY");
  }

  let today = moment();
  let tomorrow = moment().add(1, "days");

  // Initialize Date Range Picker for Check-in
  $("#check-in").daterangepicker(
    {
      singleDatePicker: true,
      autoUpdateInput: true,
      minDate: today,
      locale: {
        format: "DD MMM YYYY",
      },
    },
    function (start) {
      // Set Check-out minDate to selected Check-in date +1 day
      $("#check-out").daterangepicker({
        singleDatePicker: true,
        autoUpdateInput: true,
        minDate: start.add(1, "days"),
        locale: {
          format: "DD MMM YYYY",
        },
      });
    }
  );

  // Initialize Date Range Picker for Check-out
  $("#check-out").daterangepicker({
    singleDatePicker: true,
    autoUpdateInput: true,
    minDate: tomorrow,
    locale: {
      format: "DD MMM YYYY",
    },
  });

  // Set default values
  $("#check-in").val(getFormattedDate(today));
  $("#check-out").val(getFormattedDate(tomorrow));
});

// ======================== Mouse movement Animation ====================================
function setupMouseMoveAnimation() {
  const moveItems = document.querySelectorAll(".move-item");

  if (!moveItems || moveItems.length === 0) {
    return;
  }

  // Set initial position for move-items
  gsap.set(moveItems, { x: 0, y: 0 });

  // Maximum movement in pixels
  const maxMovement = 20;

  moveItems.forEach((item) => {
    item.addEventListener("mousemove", (e) => {
      if (!e) return;

      // Get item size and position
      const rect = item.getBoundingClientRect();
      const mouseX = e.clientX - rect.left;
      const mouseY = e.clientY - rect.top;

      // Calculate movement as a percentage of item size
      const moveX = (mouseX / rect.width - 0.5) * 2 * maxMovement;
      const moveY = (mouseY / rect.height - 0.5) * 2 * maxMovement;

      // Animate only the hovered move-item
      gsap.to(item, {
        x: moveX,
        y: moveY,
        duration: 0.3,
        ease: "power2.out",
      });
    });

    // Reset position when mouse leaves the move-item
    item.addEventListener("mouseleave", () => {
      gsap.to(item, {
        x: 0,
        y: 0,
        duration: 0.5,
        ease: "power2.out",
      });
    });
  });
}

// Run setup on DOMContentLoaded
document.addEventListener("DOMContentLoaded", setupMouseMoveAnimation);

// Also run setup now in case the DOM is already loaded
if (
  document.readyState === "complete" ||
  document.readyState === "interactive"
) {
  setupMouseMoveAnimation();
}

// BERG Awards Slider (5 tabs, show 3 on desktop)
document.querySelectorAll(".berg-awards-slider").forEach((sliderEl) => {
  const wrap = sliderEl.closest(".berg-awards-slider-wrap");
  if (!wrap) return;

  const prev = wrap.querySelector(".berg-awards-prev");
  const next = wrap.querySelector(".berg-awards-next");
  if (!prev || !next) return;

  new Swiper(sliderEl, {
    slidesPerView: 1,
    spaceBetween: 30,
    slidesPerGroup: 1,
    loop: true,
    speed: 1000,
    navigation: {
      prevEl: prev,
      nextEl: next,
    },
    breakpoints: {
      1200: { slidesPerView: 3 },
      768: { slidesPerView: 2 },
    },
  });
});

// BENEFITS - ACCORDIAN

document.addEventListener("DOMContentLoaded", () => {
  const section = document.querySelector("#benefits-tabs");
  if (!section) return;

  const cards = Array.from(section.querySelectorAll("a.benefit-tile"));

  const isTouchDevice = () =>
    window.matchMedia("(hover: none) and (pointer: coarse)").matches;

  const clearActive = () =>
    cards.forEach((c) => c.classList.remove("is-active"));

  const setActive = (el) => {
    clearActive();
    if (el) el.classList.add("is-active");
  };

  /* DESKTOP:
     - NEMA "sticky" open preko JS-a
     - Hover otvara/zatvara preko CSS (:hover)
     - Po želji: tastatura (focus) otvara/zatvara */
  cards.forEach((card) => {
    card.addEventListener("focusin", () => {
      if (!isTouchDevice()) card.classList.add("is-active");
    });

    card.addEventListener("focusout", () => {
      if (!isTouchDevice()) card.classList.remove("is-active");
    });
  });

  /* MOBILE:
     - prvi tap otvara (spreči link)
     - drugi tap ide na link */
  cards.forEach((card) => {
    card.addEventListener("click", (e) => {
      if (!isTouchDevice()) return;

      if (!card.classList.contains("is-active")) {
        e.preventDefault();
        setActive(card);
      }
    });
  });

  /* Tap van sekcije zatvara aktivno (mobilno) */
  document.addEventListener("click", (e) => {
    if (!isTouchDevice()) return;
    if (!section.contains(e.target)) clearActive();
  });
});

// MEMBERSHIP PACKAGES

(function () {
  const order = document.getElementById("berg-order");
  if (!order) return;

  const steps = Array.from(order.querySelectorAll(".berg-step"));
  const panels = Array.from(order.querySelectorAll(".berg-step-panel"));
  const buyButtons = Array.from(document.querySelectorAll(".berg-buy-btn"));
  const cancelBtn = order.querySelector(".berg-cancel");

  const planValue = document.getElementById("bergPlanValue");
  const optionValue = document.getElementById("bergOptionValue");

  const selectedPlanEl = document.getElementById("bergSelectedPlan");
  const selectedOptionEl = document.getElementById("bergSelectedOption");

  const partnerBlock = document.getElementById("bergPartnerBlock");
  const addChildBtn = order.querySelector(".berg-add-child");
  const childrenList = document.getElementById("bergChildrenList");
  const childTpl = document.getElementById("bergChildTpl");

  const success = document.getElementById("bergSuccess");

  function humanPlan(plan) {
    if (plan === "explorer") return "BERG EXPLORER";
    if (plan === "family") return "FAMILY";
    return plan || "—";
  }

  function humanOption(plan, option) {
    if (!option) return "—";
    if (plan === "explorer") {
      const map = {
        adult: "Adult (28–64)",
        senior: "Senior",
        junior: "Junior",
        mountain_rescuer: "Mountain rescuer",
        child: "Child",
        disabled: "Disabled (50%+)",
      };
      return map[option] || option;
    }
    if (plan === "family") {
      const map = {
        berg_explorer: "BERG EXPLORER",
        berg_family: "BERG FAMILY",
      };
      return map[option] || option;
    }
    return option;
  }

  function setActiveStep(n) {
    steps.forEach((s) =>
      s.classList.toggle("is-active", s.dataset.step === String(n))
    );
    panels.forEach((p) => (p.hidden = p.dataset.stepPanel !== String(n)));
  }

  function syncSummary() {
    selectedPlanEl.textContent = humanPlan(planValue.value);
    selectedOptionEl.textContent = humanOption(
      planValue.value,
      optionValue.value
    );

    // Partner/children only if plan is family
    const isFamily = planValue.value === "family";
    partnerBlock.hidden = !isFamily;

    // reset children if switching away from family
    if (!isFamily) {
      childrenList.innerHTML = "";
    }
  }

  function openOrderFlow() {
    order.hidden = false;
    success.hidden = true;
    setActiveStep(1);
    syncSummary();

    // smooth scroll
    order.scrollIntoView({ behavior: "smooth", block: "start" });
  }

  // Buy now buttons
  buyButtons.forEach((btn) => {
    btn.addEventListener("click", function (e) {
      e.preventDefault();

      const card = btn.closest(".berg-plan-card");
      const plan = card ? card.getAttribute("data-plan") : "";
      planValue.value = plan;

      if (plan === "explorer") {
        const sel = card.querySelector('select[data-role="explorerType"]');
        optionValue.value = sel ? sel.value : "adult";
      } else if (plan === "family") {
        const sel = card.querySelector('select[data-role="familyType"]');
        optionValue.value = sel ? sel.value : "berg_explorer";
      } else {
        optionValue.value = "";
      }

      openOrderFlow();
    });
  });

  // If user changes selects after open, update summary too
  document.querySelectorAll(".berg-select").forEach((sel) => {
    sel.addEventListener("change", function () {
      const card = sel.closest(".berg-plan-card");
      if (!card) return;

      const plan = card.getAttribute("data-plan");
      if (planValue.value !== plan) return; // update only if same plan is currently selected

      optionValue.value = sel.value;
      syncSummary();
    });
  });

  // Next / Prev
  order.addEventListener("click", function (e) {
    const next = e.target.closest(".berg-next");
    const prev = e.target.closest(".berg-prev");

    if (next) {
      const step = Number(next.dataset.next);
      setActiveStep(step);
      return;
    }
    if (prev) {
      const step = Number(prev.dataset.prev);
      setActiveStep(step);
      return;
    }
  });

  // Cancel
  if (cancelBtn) {
    cancelBtn.addEventListener("click", function () {
      order.hidden = true;
      success.hidden = true;
    });
  }

  // Children add/remove (max 4 like reference)
  function addChild() {
    if (!childTpl) return;
    const count = childrenList.querySelectorAll(".berg-child-card").length;
    if (count >= 4) return;

    const fragment = childTpl.content.cloneNode(true);
    const card = fragment.querySelector(".berg-child-card");
    const title = fragment.querySelector(".berg-child-title");
    if (title) title.textContent = `${count + 1}. Child`;

    const removeBtn = fragment.querySelector(".berg-child-remove");
    if (removeBtn) {
      removeBtn.addEventListener("click", function () {
        card.remove();
        // reindex
        Array.from(childrenList.querySelectorAll(".berg-child-card")).forEach(
          (c, i) => {
            const t = c.querySelector(".berg-child-title");
            if (t) t.textContent = `${i + 1}. Child`;
          }
        );
      });
    }

    childrenList.appendChild(fragment);
  }

  if (addChildBtn) {
    addChildBtn.addEventListener("click", function () {
      addChild();
    });
  }

  // Submit (placeholder)
  const submitBtn = order.querySelector(".berg-submit");
  if (submitBtn) {
    submitBtn.addEventListener("click", function () {
      // OVDE kasnije vezuješ API / payment flow.
      success.hidden = false;
      success.scrollIntoView({ behavior: "smooth", block: "nearest" });
    });
  }
})();

// Klik na karticu vodi na data-href, ali klik na dugme ostaje normalno
document.addEventListener("click", function (e) {
  const tile = e.target.closest(".benefit-tile[data-href]");
  if (!tile) return;

  // ako je klik na link/dugme – ne diraj
  if (e.target.closest("a, button")) return;

  window.location.href = tile.getAttribute("data-href");
});

// Enter/Space za tastaturu
document.addEventListener("keydown", function (e) {
  const tile = document.activeElement?.closest?.(".benefit-tile[data-href]");
  if (!tile) return;
  if (e.key === "Enter" || e.key === " ") {
    e.preventDefault();
    window.location.href = tile.getAttribute("data-href");
  }
});

document.addEventListener("DOMContentLoaded", function () {
  // Toggle click on title or more info
  document.querySelectorAll(".js-ins-toggle").forEach(function (btn) {
    btn.addEventListener("click", function () {
      const id = btn.getAttribute("data-target");
      const collapseEl = document.getElementById(id);
      if (!collapseEl) return;

      // (Opcija) ako želiš da samo jedna kartica bude otvorena u grid-u:
      const grid = btn.closest(".insurance-guide-grid");
      if (grid) {
        grid
          .querySelectorAll(".insurance-guide-collapse.show")
          .forEach(function (openEl) {
            if (openEl.id !== id) {
              bootstrap.Collapse.getOrCreateInstance(openEl, {
                toggle: false,
              }).hide();
            }
          });
      }

      // Toggle this one
      const instance = bootstrap.Collapse.getOrCreateInstance(collapseEl, {
        toggle: false,
      });
      if (collapseEl.classList.contains("show")) instance.hide();
      else instance.show();
    });
  });

  // Sync aria + open class on card (nice UX)
  document.querySelectorAll(".insurance-guide-collapse").forEach(function (el) {
    const card = el.closest(".insurance-guide-card");
    const id = el.id;

    el.addEventListener("shown.bs.collapse", function () {
      if (card) card.classList.add("is-open");
      document
        .querySelectorAll('.js-ins-toggle[data-target="' + id + '"]')
        .forEach(function (b) {
          b.setAttribute("aria-expanded", "true");
        });
    });

    el.addEventListener("hidden.bs.collapse", function () {
      if (card) card.classList.remove("is-open");
      document
        .querySelectorAll('.js-ins-toggle[data-target="' + id + '"]')
        .forEach(function (b) {
          b.setAttribute("aria-expanded", "false");
        });
    });
  });
});

document.addEventListener("click", function (e) {
  const btn = e.target.closest(".berg-pass-toggle");
  if (!btn) return;

  const wrap = btn.closest(".berg-pass-wrap");
  const input = wrap.querySelector(".berg-pass-input");
  const isPass = input.type === "password";

  input.type = isPass ? "text" : "password";
  btn.textContent = isPass ? "Hide" : "Show";
});

document.addEventListener("DOMContentLoaded", function () {
  /* =========================================================
     I) REQUIRED POPUP ON PAGE OPEN
     ========================================================= */
  const pop = document.getElementById("maOfflinePopup");
  const popCacheBtn = document.getElementById("maPopCacheNow");

  const openPop = () => {
    if (!pop) return;
    pop.hidden = false;
    document.body.style.overflow = "hidden";
  };

  const closePop = () => {
    if (!pop) return;
    pop.hidden = true;
    document.body.style.overflow = "";
  };

  if (pop) {
    // Always show on page open (as you requested)
    openPop();

    pop.addEventListener("click", (e) => {
      if (e.target.matches("[data-pop-close]")) closePop();
    });

    document.addEventListener("keydown", (e) => {
      if (!pop.hidden && e.key === "Escape") closePop();
    });

    if (popCacheBtn) {
      popCacheBtn.addEventListener("click", () => {
        popCacheBtn.disabled = true;
        popCacheBtn.textContent = "Caching...";
        // simulate cache 10–20 sec (we'll keep UX fast for now)
        setTimeout(() => {
          popCacheBtn.textContent = "Cached ✓";
          setTimeout(() => closePop(), 500);
          // update status in Documents panel too
          const st = document.getElementById("maCacheStatus");
          if (st) st.innerHTML = "Cache status: <strong>Cached</strong>";
        }, 1200);
      });
    }
  }

  /* =========================================================
     II) 4 TILES + PANEL SWITCHING (Back/Next + X close)
     ========================================================= */
  const order = ["sos", "docs", "accident", "helpline"];

  const tiles = Array.from(document.querySelectorAll(".ma-tile[data-key]"));
  const panel = document.getElementById("maPanel");
  const panelTitle = document.getElementById("maPanelTitle");
  const closePanelBtn = document.getElementById("maClosePanel");

  const sections = Array.from(
    document.querySelectorAll(".ma-section[data-section]")
  );

  const btnPrev = document.getElementById("maPrev");
  const btnNext = document.getElementById("maNext");

  function humanTitle(key) {
    if (key === "sos") return "SOS";
    if (key === "docs") return "MY EMERGENCY DOCUMENTS";
    if (key === "accident") return "REPORT ACCIDENT";
    if (key === "helpline") return "HELPLINE";
    return key.toUpperCase();
  }

  function setActiveTile(key) {
    tiles.forEach((t) => {
      const isActive = t.getAttribute("data-key") === key;
      t.classList.toggle("is-active", isActive);
      t.setAttribute("aria-selected", isActive ? "true" : "false");
    });
  }

  function showSection(key) {
    sections.forEach((s) => {
      s.hidden = s.getAttribute("data-section") !== key;
    });
  }

  function openPanel(key, doScroll = true) {
    if (!panel) return;
    panel.hidden = false;
    setActiveTile(key);
    showSection(key);
    if (panelTitle) panelTitle.textContent = humanTitle(key);

    // update nav button states
    const idx = order.indexOf(key);
    if (btnPrev) btnPrev.disabled = idx <= 0;
    if (btnNext) btnNext.disabled = idx >= order.length - 1;

    if (doScroll) {
      panel.scrollIntoView({ behavior: "smooth", block: "start" });
    }
  }

  function closePanel() {
    if (!panel) return;
    panel.hidden = true;
  }

  // Default: panel opens on SOS (because SOS is 1st and dominant)
  openPanel("sos", false);

  // Tile clicks
  tiles.forEach((t) => {
    t.addEventListener("click", () => {
      const key = t.getAttribute("data-key");
      openPanel(key);
    });
  });

  // X close
  if (closePanelBtn) {
    closePanelBtn.addEventListener("click", closePanel);
  }

  // Back/Next
  if (btnPrev) {
    btnPrev.addEventListener("click", () => {
      const active =
        document
          .querySelector(".ma-tile.is-active")
          ?.getAttribute("data-key") || "sos";
      const idx = order.indexOf(active);
      if (idx > 0) openPanel(order[idx - 1]);
    });
  }

  if (btnNext) {
    btnNext.addEventListener("click", () => {
      const active =
        document
          .querySelector(".ma-tile.is-active")
          ?.getAttribute("data-key") || "sos";
      const idx = order.indexOf(active);
      if (idx < order.length - 1) openPanel(order[idx + 1]);
    });
  }

  // Jump buttons (e.g., "GO TO SOS" inside Accident panel)
  document.addEventListener("click", (e) => {
    const jump = e.target.closest("[data-jump]");
    if (!jump) return;
    const key = jump.getAttribute("data-jump");
    if (order.includes(key)) openPanel(key);
  });

  /* =========================================================
     SOS: Local numbers toggle + simple search
     ========================================================= */
  const localBtn = document.getElementById("btnLocalRescue");
  const localBox = document.getElementById("maLocalRescueBox");
  const search = document.getElementById("maRescueSearch");
  const list = document.getElementById("maRescueList");

  if (localBtn && localBox) {
    localBtn.addEventListener("click", () => {
      localBox.hidden = !localBox.hidden;
    });
  }

  if (search && list) {
    search.addEventListener("input", () => {
      const q = (search.value || "").trim().toLowerCase();
      Array.from(list.querySelectorAll(".ma-list__row")).forEach((row) => {
        const name =
          row.querySelector(".ma-list__k")?.textContent?.toLowerCase() || "";
        row.style.display = name.includes(q) ? "" : "none";
      });
    });
  }
});

(function () {
  const root = document.querySelector('.ma-section[data-section="sos"]');
  if (!root) return;

  const btnLocal = root.querySelector("#btnLocalRescue");
  const localBox = root.querySelector("#maLocalRescueBox");
  const searchEl = root.querySelector("#maRescueSearch");
  const listEl = root.querySelector("#maRescueList");
  const countEl = root.querySelector("#maRescueCount");
  const hintEl = root.querySelector("#maRescueHint");
  const btnCsv = root.querySelector("#maDownloadCsv");
  const btnPdf = root.querySelector("#maDownloadPdf");

  // ISO / Country / Emergency / SAR
  const RESCUE_DATA = [
    ["SRB", "Serbia", "112", "+381 62 464646"],
    ["MNE", "Montenegro", "112", "112"],
    ["BIH", "Bosnia and Herzegovina", "112", "112"],
    ["HRV", "Croatia", "112", "112"],
    ["SVN", "Slovenia", "112", "112"],
    ["MKD", "North Macedonia", "112", "13 112"],
    ["ALB", "Albania", "112", "112"],
    ["GRC", "Greece", "112", "112"],
    ["BGR", "Bulgaria", "112", "+359 1470"],
    ["ROU", "Romania", "112", "+40 725 826668"],
    ["AND", "Andorra", "112", "112"],
    ["AUT", "Austria", "112", "140"],
    ["BEL", "Belgium", "112", "112"],
    ["BLR", "Belarus", "112", "112"],
    ["CZE", "Czechia", "112", "112"],
    ["DNK", "Denmark", "112", "112"],
    ["EST", "Estonia", "112", "112"],
    ["FIN", "Finland", "112", "112"],
    ["FRA", "France", "112", "112"],
    ["ISL", "Iceland", "112", "112"],
    ["IRL", "Ireland", "112", "999"],
    ["ITA", "Italy", "112", "118"],
    ["CYP", "Cyprus", "112", "199"],
    ["LVA", "Latvia", "112", "112"],
    ["LTU", "Lithuania", "112", "112"],
    ["LIE", "Liechtenstein", "112", "144"],
    ["LUX", "Luxembourg", "112", "112"],
    ["HUN", "Hungary", "112", "112"],
    ["MLT", "Malta", "112", "112"],
    ["MDA", "Moldova", "112", "112"],
    ["MCO", "Monaco", "112", "18"],
    ["DEU", "Germany", "112", "112"],
    ["NLD", "Netherlands", "112", "112"],
    ["NOR", "Norway", "112", "112"],
    ["POL", "Poland", "112", "985"],
    ["PRT", "Portugal", "112", "112"],
    ["RUS", "Russia", "112", "112"],
    ["SMR", "San Marino", "112", "112"],
    ["SVK", "Slovakia", "112", "18300"],
    ["ESP", "Spain", "112", "112"],
    ["SWE", "Sweden", "112", "112"],
    ["CHE", "Switzerland", "112", "1414"],
    ["TUR", "Turkey", "112", "112"],
    ["UKR", "Ukraine", "112", "112"],
    ["GBR", "United Kingdom", "112", "999"],
    ["VAT", "Vatican City", "112", "112"],

    ["DZA", "Algeria", "112", "17"],
    ["AGO", "Angola", "112", "112"],
    ["BEN", "Benin", "117", "117"],
    ["BWA", "Botswana", "999", "999"],
    ["BFA", "Burkina Faso", "17", "17"],
    ["BDI", "Burundi", "112", "112"],
    ["CMR", "Cameroon", "112", "112"],
    ["CPV", "Cabo Verde", "132", "132"],
    ["CAF", "Central African Republic", "117", "117"],
    ["TCD", "Chad", "17", "17"],
    ["COM", "Comoros", "17", "17"],
    ["COG", "Congo", "112", "112"],
    ["COD", "DR Congo", "112", "112"],
    ["CIV", "Côte d’Ivoire", "112", "112"],
    ["DJI", "Djibouti", "17", "17"],
    ["EGY", "Egypt", "122", "122"],
    ["GNQ", "Equatorial Guinea", "112", "112"],
    ["ERI", "Eritrea", "113", "113"],
    ["SWZ", "Eswatini", "999", "999"],
    ["ETH", "Ethiopia", "911", "911"],
    ["GAB", "Gabon", "1730", "1730"],
    ["GMB", "Gambia", "112", "112"],
    ["GHA", "Ghana", "112", "112"],
    ["GIN", "Guinea", "117", "117"],
    ["GNB", "Guinea-Bissau", "112", "112"],
    ["KEN", "Kenya", "999", "999"],
    ["LSO", "Lesotho", "112", "112"],
    ["LBR", "Liberia", "911", "911"],
    ["LBY", "Libya", "1515", "1515"],
    ["MDG", "Madagascar", "117", "117"],
    ["MWI", "Malawi", "997", "997"],
    ["MLI", "Mali", "17", "17"],
    ["MRT", "Mauritania", "117", "117"],
    ["MUS", "Mauritius", "999", "999"],
    ["MYT", "Mayotte", "112", "112"],
    ["MAR", "Morocco", "190", "190"],
    ["MOZ", "Mozambique", "117", "117"],
    ["NAM", "Namibia", "10111", "10111"],
    ["NER", "Niger", "17", "17"],
    ["NGA", "Nigeria", "112", "112"],
    ["RWA", "Rwanda", "112", "112"],
    ["SHN", "Saint Helena", "999", "999"],
    ["STP", "São Tomé and Príncipe", "112", "112"],
    ["SEN", "Senegal", "17", "17"],
    ["SYC", "Seychelles", "999", "999"],
    ["SLE", "Sierra Leone", "112", "112"],
    ["SOM", "Somalia", "888", "888"],
    ["ZAF", "South Africa", "112", "112"],
    ["SSD", "South Sudan", "999", "999"],
    ["SDN", "Sudan", "999", "999"],
    ["TZA", "Tanzania", "112", "112"],
    ["TGO", "Togo", "117", "117"],
    ["TUN", "Tunisia", "190", "190"],
    ["UGA", "Uganda", "999", "999"],
    ["ESH", "Western Sahara", "1500", "1500"],
    ["ZMB", "Zambia", "999", "999"],
    ["ZWE", "Zimbabwe", "999", "999"],

    ["ATG", "Antigua and Barbuda", "999", "999"],
    ["BHS", "Bahamas", "911", "911"],
    ["BRB", "Barbados", "211", "211"],
    ["BLZ", "Belize", "911", "911"],
    ["CAN", "Canada", "911", "911"],
    ["CRI", "Costa Rica", "911", "911"],
    ["CUB", "Cuba", "106", "106"],
    ["DMA", "Dominica", "999", "999"],
    ["DOM", "Dominican Republic", "911", "911"],
    ["SLV", "El Salvador", "911", "911"],
    ["GRD", "Grenada", "911", "911"],
    ["GTM", "Guatemala", "110", "110"],
    ["HTI", "Haiti", "114", "114"],
    ["HND", "Honduras", "911", "911"],
    ["JAM", "Jamaica", "119", "119"],
    ["MEX", "Mexico", "911", "911"],
    ["NIC", "Nicaragua", "118", "118"],
    ["PAN", "Panama", "911", "911"],
    ["USA", "United States", "911", "911"],
    ["PRI", "Puerto Rico", "911", "911"],
    ["LCA", "Saint Lucia", "911", "911"],
    ["VCT", "Saint Vincent and the Grenadines", "999", "999"],
    ["TTO", "Trinidad and Tobago", "999", "999"],

    ["ARG", "Argentina", "911", "911"],
    ["BOL", "Bolivia", "110", "110"],
    ["BRA", "Brazil", "190", "190"],
    ["CHL", "Chile", "131", "131"],
    ["COL", "Colombia", "123", "123"],
    ["ECU", "Ecuador", "911", "911"],
    ["GUY", "Guyana", "999", "999"],
    ["PRY", "Paraguay", "911", "911"],
    ["PER", "Peru", "105", "105"],
    ["SUR", "Suriname", "112", "112"],
    ["URY", "Uruguay", "911", "911"],
    ["VEN", "Venezuela", "911", "911"],

    ["AFG", "Afghanistan", "119", "119"],
    ["ARM", "Armenia", "112", "112"],
    ["AZE", "Azerbaijan", "112", "112"],
    ["BHR", "Bahrain", "999", "999"],
    ["BGD", "Bangladesh", "999", "999"],
    ["BTN", "Bhutan", "113", "113"],
    ["BRN", "Brunei", "993", "993"],
    ["KHM", "Cambodia", "117", "117"],
    ["CHN", "China", "110", "120"],
    ["TWN", "Taiwan", "110", "119"],
    ["GEO", "Georgia", "112", "112"],
    ["HKG", "Hong Kong", "999", "999"],
    ["IND", "India", "112", "112"],
    ["IDN", "Indonesia", "112", "112"],
    ["IRN", "Iran", "110", "115"],
    ["IRQ", "Iraq", "104", "104"],
    ["ISR", "Israel", "100", "100"],
    ["JPN", "Japan", "110", "119"],
    ["JOR", "Jordan", "911", "911"],
    ["KAZ", "Kazakhstan", "112", "112"],
    ["PRK", "North Korea", "119", "119"],
    ["KOR", "South Korea", "112", "119"],
    ["KWT", "Kuwait", "112", "112"],
    ["KGZ", "Kyrgyzstan", "112", "112"],
    ["LAO", "Laos", "119", "119"],
    ["LBN", "Lebanon", "112", "112"],
    ["MYS", "Malaysia", "999", "999"],
    ["MDV", "Maldives", "118", "118"],
    ["MNG", "Mongolia", "103", "103"],
    ["MMR", "Myanmar", "199", "199"],
    ["NPL", "Nepal", "100", "100"],
    ["PAK", "Pakistan", "15", "1122"],
    ["PHL", "Philippines", "911", "911"],
    ["QAT", "Qatar", "999", "999"],
    ["SAU", "Saudi Arabia", "999", "999"],
    ["SGP", "Singapore", "999", "999"],
    ["LKA", "Sri Lanka", "119", "119"],
    ["SYR", "Syria", "112", "112"],
    ["TJK", "Tajikistan", "112", "112"],
    ["THA", "Thailand", "191", "191"],
    ["TLS", "Timor-Leste", "112", "112"],
    ["TKM", "Turkmenistan", "03", "03"],
    ["ARE", "United Arab Emirates", "999", "999"],
    ["UZB", "Uzbekistan", "112", "112"],
    ["VNM", "Vietnam", "113", "114"],

    ["AUS", "Australia", "000", "000"],
    ["NZL", "New Zealand", "111", "111"],
    ["FJI", "Fiji", "911", "911"],
    ["PNG", "Papua New Guinea", "000", "000"],
    ["SLB", "Solomon Islands", "999", "999"],
    ["WSM", "Samoa", "911", "911"],
    ["TUV", "Tuvalu", "911", "911"],
    ["VUT", "Vanuatu", "112", "112"],
    ["NCL", "New Caledonia", "112", "112"],
    ["ALA", "Åland Islands", "112", "112"],
    ["GRL", "Greenland", "112", "112"],
    ["PYF", "French Polynesia", "112", "112"],
    ["GUM", "Guam", "911", "911"],
    ["MAC", "Macao", "999", "999"],
    ["REU", "Réunion", "112", "112"],
  ];

  const norm = (s) =>
    (s || "")
      .toString()
      .toLowerCase()
      .normalize("NFD")
      .replace(/[\u0300-\u036f]/g, "")
      .trim();

  function telHref(num) {
    const cleaned = (num || "").toString().replace(/[^\d+]/g, "");
    return cleaned ? `tel:${cleaned}` : "#";
  }

  function renderRows(query) {
    const q = norm(query);
    const filtered = RESCUE_DATA.filter(([iso, country, emg, sar]) => {
      if (!q) return true;
      return (
        norm(iso).includes(q) ||
        norm(country).includes(q) ||
        norm(emg).includes(q) ||
        norm(sar).includes(q)
      );
    });

    listEl.innerHTML = filtered
      .map(([iso, country, emg, sar]) => {
        const emgLink = `<a class="ma-call" href="${telHref(emg)}">${emg}</a>`;
        const sarLink = `<a class="ma-call ma-call--sar" href="${telHref(
          sar
        )}">${sar}</a>`;
        return `
          <div class="ma-rescue-row" role="row">
            <div class="ma-rescue-cell" role="cell"><span class="ma-iso-badge">${iso}</span></div>
            <div class="ma-rescue-cell" role="cell">${country}</div>
            <div class="ma-rescue-cell ma-rescue-cell--right" role="cell">${emgLink}</div>
            <div class="ma-rescue-cell ma-rescue-cell--right" role="cell">${sarLink}</div>
          </div>
        `;
      })
      .join("");

    countEl.textContent = `Showing ${filtered.length} result${
      filtered.length === 1 ? "" : "s"
    }`;

    // keep first ~10 visible via CSS max-height; user scrolls for the rest
  }

  function openLocalBox() {
    localBox.hidden = false;
    btnLocal.setAttribute("aria-expanded", "true");
    // nice UX: jump to the list
    localBox.scrollIntoView({ behavior: "smooth", block: "start" });
    setTimeout(() => searchEl?.focus(), 250);
  }

  function toggleLocalBox() {
    const willOpen = localBox.hidden;
    localBox.hidden = !willOpen;
    btnLocal.setAttribute("aria-expanded", willOpen ? "true" : "false");
    if (willOpen) openLocalBox();
  }

  // Basic region suggestion (offline-safe)
  function suggestByLanguageRegion() {
    try {
      const lang = (navigator.language || "").toUpperCase(); // e.g. SR-RS
      const parts = lang.split("-");
      const region = parts[1] || "";
      const regionToIso3 = {
        RS: "SRB",
        ME: "MNE",
        BA: "BIH",
        HR: "HRV",
        SI: "SVN",
        MK: "MKD",
        AL: "ALB",
        GR: "GRC",
        BG: "BGR",
        RO: "ROU",
        AT: "AUT",
        DE: "DEU",
        CH: "CHE",
        IT: "ITA",
        FR: "FRA",
        ES: "ESP",
        PT: "PRT",
        GB: "GBR",
        IE: "IRL",
        NL: "NLD",
        BE: "BEL",
        DK: "DNK",
        NO: "NOR",
        SE: "SWE",
        FI: "FIN",
        PL: "POL",
        CZ: "CZE",
        SK: "SVK",
        HU: "HUN",
      };
      const iso3 = regionToIso3[region];
      if (!iso3) return;

      const hit = RESCUE_DATA.find((x) => x[0] === iso3);
      if (!hit) return;

      hintEl.textContent = navigator.onLine
        ? `Suggested: ${hit[1]} (based on device language/region).`
        : `Suggested: ${hit[1]} (offline).`;

      // prefill only if empty
      if (!searchEl.value) {
        searchEl.value = hit[1];
        renderRows(searchEl.value);
        // scroll list to that row (best effort)
        const badge = listEl.querySelector(`.ma-iso-badge`);
        if (badge) listEl.scrollTop = 0;
      }
    } catch (_) {}
  }

  // Downloads
  function downloadCSV(rows) {
    const header = ["ISO", "Country", "Emergency", "SAR"];
    const csv = [header, ...rows]
      .map((r) => r.map((v) => `"${String(v).replace(/"/g, '""')}"`).join(","))
      .join("\n");

    const blob = new Blob([csv], { type: "text/csv;charset=utf-8" });
    const url = URL.createObjectURL(blob);

    const a = document.createElement("a");
    a.href = url;
    a.download = "berg-rescue-numbers.csv";
    document.body.appendChild(a);
    a.click();
    a.remove();

    URL.revokeObjectURL(url);
  }

  function openPrintablePDF(rows) {
    const w = window.open("", "_blank");
    if (!w) return;

    const html = `
      <html>
        <head>
          <title>BERG - Emergency & SAR Numbers</title>
          <meta name="viewport" content="width=device-width, initial-scale=1" />
          <style>
            body{ font-family: Arial, sans-serif; padding: 24px; }
            h1{ font-size: 20px; margin: 0 0 12px; }
            p{ opacity:.8; margin:0 0 18px; }
            table{ width:100%; border-collapse: collapse; }
            th,td{ border:1px solid #ddd; padding:10px; text-align:left; }
            th{ background:#f6f6f6; }
          </style>
        </head>
        <body>
          <h1>BERG – Emergency & SAR Numbers</h1>
          <p>Use the national emergency number first whenever unsure. This list is informational only.</p>
          <table>
            <thead>
              <tr><th>ISO</th><th>Country</th><th>Emergency</th><th>SAR</th></tr>
            </thead>
            <tbody>
              ${rows
                .map(
                  ([iso, country, emg, sar]) =>
                    `<tr><td>${iso}</td><td>${country}</td><td>${emg}</td><td>${sar}</td></tr>`
                )
                .join("")}
            </tbody>
          </table>
          <script>
            window.onload = () => { window.print(); };
          </script>
        </body>
      </html>
    `;
    w.document.open();
    w.document.write(html);
    w.document.close();
  }

  // Initial render
  renderRows("");
  suggestByLanguageRegion();

  btnLocal?.addEventListener("click", toggleLocalBox);

  searchEl?.addEventListener("input", function () {
    renderRows(searchEl.value);
  });

  btnCsv?.addEventListener("click", function () {
    downloadCSV(RESCUE_DATA);
  });

  btnPdf?.addEventListener("click", function () {
    openPrintablePDF(RESCUE_DATA);
  });
})();

/* =========================================================
   Rotating tips carousel
   Desktop: 3 visible, auto-rotate
   Mobile: 1 visible, auto every 4s, swipe enabled
   ========================================================= */
(function () {
  const viewport = document.getElementById("maTipsViewport");
  const track = document.getElementById("maTipsTrack");
  const btnPrev = document.getElementById("maTipsPrev");
  const btnNext = document.getElementById("maTipsNext");
  const dotsWrap = document.getElementById("maTipsDots");

  if (!viewport || !track) return;

  const cards = Array.from(track.querySelectorAll(".ma-tip-card"));
  const total = cards.length;
  if (!total) return;

  let idx = 0;
  let timer = null;

  function perView() {
    return window.matchMedia("(max-width: 767px)").matches ? 1 : 3;
  }

  function maxIndex() {
    return Math.max(0, total - perView());
  }

  function clampIndex(i) {
    const m = maxIndex();
    if (i < 0) return m;
    if (i > m) return 0;
    return i;
  }

  function cardStepPx() {
    // Each step = card width + gap (12px from CSS)
    const first = cards[0];
    if (!first) return 0;
    const style = window.getComputedStyle(track);
    const gap = parseFloat(style.columnGap || style.gap || "12") || 12;
    return first.getBoundingClientRect().width + gap;
  }

  function renderDots() {
    if (!dotsWrap) return;

    const m = maxIndex();
    const dotCount = m + 1; // positions, not total cards

    dotsWrap.innerHTML = "";
    for (let i = 0; i < dotCount; i++) {
      const b = document.createElement("button");
      b.type = "button";
      b.className = "ma-tips__dot" + (i === idx ? " is-active" : "");
      b.setAttribute("aria-label", `Go to tips set ${i + 1}`);
      b.addEventListener("click", () => {
        idx = i;
        apply();
        restartAuto();
      });
      dotsWrap.appendChild(b);
    }
  }

  function apply() {
    idx = clampIndex(idx);
    const x = idx * cardStepPx();
    track.style.transform = `translateX(${-x}px)`;

    // update dots
    if (dotsWrap) {
      Array.from(dotsWrap.children).forEach((d, i) => {
        d.classList.toggle("is-active", i === idx);
      });
    }
  }

  function next() {
    idx = clampIndex(idx + 1);
    apply();
  }

  function prev() {
    idx = clampIndex(idx - 1);
    apply();
  }

  function autoInterval() {
    // Mobile 4s (requested), desktop slightly slower
    return window.matchMedia("(max-width: 767px)").matches ? 4000 : 5500;
  }

  function startAuto() {
    stopAuto();
    timer = setInterval(next, autoInterval());
  }

  function stopAuto() {
    if (timer) clearInterval(timer);
    timer = null;
  }

  function restartAuto() {
    startAuto();
  }

  // Buttons
  btnPrev &&
    btnPrev.addEventListener("click", () => {
      prev();
      restartAuto();
    });
  btnNext &&
    btnNext.addEventListener("click", () => {
      next();
      restartAuto();
    });

  // Pause on hover/focus (desktop)
  viewport.addEventListener("mouseenter", stopAuto);
  viewport.addEventListener("mouseleave", startAuto);
  viewport.addEventListener("focusin", stopAuto);
  viewport.addEventListener("focusout", startAuto);

  // Keyboard
  viewport.addEventListener("keydown", (e) => {
    if (e.key === "ArrowLeft") {
      prev();
      restartAuto();
    }
    if (e.key === "ArrowRight") {
      next();
      restartAuto();
    }
  });

  // Swipe (mobile + touch devices)
  let startX = 0;
  let deltaX = 0;
  let isDown = false;

  function onStart(x) {
    isDown = true;
    startX = x;
    deltaX = 0;
    stopAuto();
  }
  function onMove(x) {
    if (!isDown) return;
    deltaX = x - startX;
  }
  function onEnd() {
    if (!isDown) return;
    isDown = false;

    const threshold = 40; // px
    if (deltaX < -threshold) next();
    else if (deltaX > threshold) prev();

    startAuto();
  }

  viewport.addEventListener(
    "touchstart",
    (e) => onStart(e.touches[0].clientX),
    { passive: true }
  );
  viewport.addEventListener("touchmove", (e) => onMove(e.touches[0].clientX), {
    passive: true,
  });
  viewport.addEventListener("touchend", onEnd);

  // Recalc on resize
  window.addEventListener("resize", () => {
    idx = clampIndex(idx);
    renderDots();
    apply();
    restartAuto();
  });

  // Init
  renderDots();
  apply();
  startAuto();
})();

/* =========================================================
   Insurance conditions segments (no page reload)
   ========================================================= */
(function () {
  const root = document.querySelector("#insurance-conditions [data-ic-root]");
  if (!root) return;

  const tabs = Array.from(root.querySelectorAll("[data-ic-tab]"));
  const panels = Array.from(root.querySelectorAll("[data-ic-panel]"));

  function activate(tabKey, updateHash = true) {
    const tabBtn = tabs.find((b) => b.dataset.icTab === tabKey);
    const panel = panels.find((p) => p.dataset.icPanel === tabKey);
    if (!tabBtn || !panel) return;

    // tabs
    tabs.forEach((btn) => {
      const isActive = btn.dataset.icTab === tabKey;
      btn.classList.toggle("is-active", isActive);
      btn.setAttribute("aria-selected", isActive ? "true" : "false");
    });

    // panels
    panels.forEach((p) => {
      const isActive = p.dataset.icPanel === tabKey;
      if (isActive) {
        p.hidden = false;
        p.classList.add("is-active");
      } else {
        p.hidden = true;
        p.classList.remove("is-active");
      }
    });

    // focus content for accessibility
    panel.focus({ preventScroll: true });

    // hash
    if (updateHash) {
      const hash = tabBtn.dataset.icHash || tabKey;
      history.replaceState(null, "", "#" + hash);
    }
  }

  // click
  tabs.forEach((btn) => {
    btn.addEventListener("click", () => activate(btn.dataset.icTab, true));
  });

  // init from hash
  function initFromHash() {
    const hash = (location.hash || "").replace("#", "").trim();
    if (!hash) return activate("duration", false);

    const btn = tabs.find((b) => (b.dataset.icHash || "") === hash);
    if (btn) return activate(btn.dataset.icTab, false);

    // fallback
    activate("duration", false);
  }

  window.addEventListener("hashchange", initFromHash);
  initFromHash();
})();

// INSURANCE CONTIDIONS

document.addEventListener("DOMContentLoaded", function () {
  const root = document.querySelector("#insurance-conditions [data-ic-root]");
  if (!root) return;

  const tabs = Array.from(root.querySelectorAll("[data-ic-tab]"));
  const panels = Array.from(root.querySelectorAll("[data-ic-panel]"));

  function activate(tabKey, updateHash = true) {
    const tabBtn = tabs.find((b) => b.dataset.icTab === tabKey);
    const panel = panels.find((p) => p.dataset.icPanel === tabKey);
    if (!tabBtn || !panel) return;

    tabs.forEach((btn) => {
      const isActive = btn.dataset.icTab === tabKey;
      btn.classList.toggle("is-active", isActive);
      btn.setAttribute("aria-selected", isActive ? "true" : "false");
    });

    panels.forEach((p) => {
      const isActive = p.dataset.icPanel === tabKey;
      p.hidden = !isActive;
      p.classList.toggle("is-active", isActive);
    });

    if (updateHash) {
      const hash = tabBtn.dataset.icHash || tabKey;
      history.replaceState(null, "", "#" + hash);
    }
  }

  tabs.forEach((btn) => {
    btn.addEventListener("click", () => activate(btn.dataset.icTab, true));
  });

  function initFromHash() {
    const hash = (location.hash || "").replace("#", "").trim();
    if (!hash) return activate("duration", false);

    const btn = tabs.find((b) => (b.dataset.icHash || "") === hash);
    if (btn) return activate(btn.dataset.icTab, false);

    activate("duration", false);
  }

  window.addEventListener("hashchange", initFromHash);
  initFromHash();
});

// INSURANCE PAGE

/* ================= Scope of coverage tabs (BERG) ================= */
(function () {
  function getQueryParam(name) {
    var p = new URLSearchParams(window.location.search);
    return p.get(name);
  }

  function normalizeTabKey(val) {
    if (!val) return "";
    return String(val).trim().toLowerCase();
  }

  function activateTab(root, key, pushUrl) {
    var tabs = root.querySelectorAll("[data-ic-tab]");
    var panels = root.querySelectorAll("[data-ic-panel]");

    if (!tabs.length || !panels.length) return;

    var targetTab = null;
    tabs.forEach(function (t) {
      if (normalizeTabKey(t.getAttribute("data-ic-tab")) === key) targetTab = t;
    });

    if (!targetTab) return;

    tabs.forEach(function (btn) {
      var isActive = btn === targetTab;
      btn.classList.toggle("is-active", isActive);
      btn.setAttribute("aria-selected", isActive ? "true" : "false");
      if (isActive) btn.removeAttribute("tabindex");
      else btn.setAttribute("tabindex", "-1");
    });

    panels.forEach(function (panel) {
      var isActive =
        normalizeTabKey(panel.getAttribute("data-ic-panel")) === key;
      panel.classList.toggle("is-active", isActive);
      if (isActive) panel.removeAttribute("hidden");
      else panel.setAttribute("hidden", "");
    });

    // URL: #transport (da radi linkovanje sa “globalne” stranice)
    if (pushUrl) {
      try {
        history.replaceState(null, "", "#" + encodeURIComponent(key));
      } catch (e) {}
    }
  }

  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("[data-ic-root]").forEach(function (root) {
      var defaultKey =
        normalizeTabKey(root.getAttribute("data-ic-default")) || "intro";

      // Prioritet: ?tab=...  ->  #hash  -> default
      var fromQuery = normalizeTabKey(getQueryParam("tab"));
      var fromHash = normalizeTabKey(
        (window.location.hash || "").replace("#", "")
      );
      var initial = fromQuery || fromHash || defaultKey;

      activateTab(root, initial, false);

      root.querySelectorAll("[data-ic-tab]").forEach(function (btn) {
        btn.addEventListener("click", function () {
          var key = normalizeTabKey(btn.getAttribute("data-ic-tab"));
          activateTab(root, key, true);
        });
      });
    });
  });
})();

(function () {
  function closeAll(except) {
    document.querySelectorAll(".berg-select-ui.is-open").forEach((w) => {
      if (w !== except) {
        w.classList.remove("is-open");
        const btn = w.querySelector(".berg-select-ui__btn");
        if (btn) btn.setAttribute("aria-expanded", "false");
      }
    });
  }

  function initDropdown(wrap) {
    const btn = wrap.querySelector(".berg-select-ui__btn");
    const list = wrap.querySelector(".berg-select-ui__list");
    const valueBox = wrap.querySelector(".berg-select-ui__value");
    const native = wrap.querySelector("select.berg-select-native");

    if (!btn || !list || !valueBox || !native) return;

    // set initial from native selected
    const nativeSelected = native.value;
    const initialOpt =
      list.querySelector(
        `.berg-select-ui__opt[data-value="${nativeSelected}"]`
      ) || list.querySelector(".berg-select-ui__opt");
    if (initialOpt) {
      list
        .querySelectorAll(".berg-select-ui__opt")
        .forEach((o) => o.setAttribute("aria-selected", "false"));
      initialOpt.setAttribute("aria-selected", "true");
      valueBox.innerHTML = initialOpt.innerHTML;
    }

    btn.addEventListener("click", (e) => {
      e.preventDefault();
      const willOpen = !wrap.classList.contains("is-open");
      closeAll(wrap);
      wrap.classList.toggle("is-open", willOpen);
      btn.setAttribute("aria-expanded", willOpen ? "true" : "false");
    });

    list.addEventListener("click", (e) => {
      const opt = e.target.closest(".berg-select-ui__opt");
      if (!opt) return;

      const val = opt.getAttribute("data-value");

      // UI update
      list
        .querySelectorAll(".berg-select-ui__opt")
        .forEach((o) => o.setAttribute("aria-selected", "false"));
      opt.setAttribute("aria-selected", "true");
      valueBox.innerHTML = opt.innerHTML;

      // native select update (keeps your existing purchase JS working)
      native.value = val;
      native.dispatchEvent(new Event("change", { bubbles: true }));

      // close
      wrap.classList.remove("is-open");
      btn.setAttribute("aria-expanded", "false");
    });
  }

  document.querySelectorAll(".berg-select-ui").forEach(initDropdown);

  document.addEventListener("click", (e) => {
    const inside = e.target.closest(".berg-select-ui");
    if (!inside) closeAll(null);
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") closeAll(null);
  });
})();

/* =========================================================
   BERG - STEP 1: sync Option + Price from custom dropdown
   Copy/paste at the END of main.js
   ========================================================= */
(function () {
  const orderEl = document.getElementById("berg-order");
  if (!orderEl) return;

  const elPlan = document.getElementById("bergSelectedPlan");
  const elOpt = document.getElementById("bergSelectedOption");
  const elPrice = document.getElementById("bergSelectedPrice");

  const inputPlan = document.getElementById("bergPlanValue");
  const inputOpt = document.getElementById("bergOptionValue");

  let activePlanKey = "explorer"; // default

  // Helper: order is visible?
  const isOrderVisible = () => !!orderEl && !orderEl.hidden;

  // Helper: nice plan label
  const planLabel = (key) =>
    key === "family" ? "BERG FAMILY" : "BERG EXPLORER";

  // Extract {label, price, value} from custom UI by syncKey (explorerType/familyType)
  function readFromCustomUI(syncKey) {
    const wrap = document.querySelector(
      `.berg-select-ui[data-sync-select="${syncKey}"]`
    );
    if (!wrap) return null;

    const selected =
      wrap.querySelector('.berg-select-ui__opt[aria-selected="true"]') ||
      wrap.querySelector(".berg-select-ui__opt");

    if (!selected) return null;

    const value = selected.getAttribute("data-value") || "";

    const left = selected.querySelector(".berg-opt-left");
    const meta =
      left?.querySelector(".berg-opt-meta")?.textContent?.trim() || "";
    // naziv bez meta (uzima samo "Adult", "Senior"...)
    const name =
      left?.childNodes?.[0]?.textContent?.trim() ||
      left?.textContent?.trim() ||
      "";

    const price =
      selected.querySelector(".berg-opt-price")?.textContent?.trim() || "—";

    const label = (name + (meta ? " " + meta : "")).trim();

    return { label, price, value };
  }

  // Fallback: read from native hidden select text like "Adult (birth...) 95 €"
  function readFromNative(syncKey) {
    const native = document.querySelector(`select[data-role="${syncKey}"]`);
    if (!native) return null;

    const opt = native.options[native.selectedIndex];
    if (!opt) return null;

    const raw = (opt.textContent || "").trim();
    // pokušaj da izvučeš cenu (zadnji broj + €)
    const m = raw.match(/(\d+)\s*€\s*$/);
    const price = m ? `${m[1]} €` : "—";

    // label = raw bez cene na kraju
    const label = raw.replace(/\s*\d+\s*€\s*$/, "").trim();

    return { label, price, value: native.value || "" };
  }

  function getSelected(syncKey) {
    return (
      readFromCustomUI(syncKey) ||
      readFromNative(syncKey) || { label: "—", price: "—", value: "" }
    );
  }

  function updateStep1Summary() {
    const syncKey = activePlanKey === "family" ? "familyType" : "explorerType";
    const sel = getSelected(syncKey);

    if (elPlan) elPlan.textContent = planLabel(activePlanKey);
    if (elOpt) elOpt.textContent = sel.label || "—";
    if (elPrice) elPrice.textContent = sel.price || "—";

    // hidden inputs for form submit
    if (inputPlan) inputPlan.value = activePlanKey || "";
    if (inputOpt) inputOpt.value = sel.value || "";
  }

  // 1) When user clicks BUY NOW, remember which card (plan) and update immediately
  document.querySelectorAll(".berg-buy-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const card = btn.closest(".berg-plan-card");
      const key = card?.getAttribute("data-plan");
      if (key) activePlanKey = key;

      // After anchor scroll / show order by your existing logic:
      setTimeout(updateStep1Summary, 0);
    });
  });

  // 2) When native select changes (your dropdown code dispatches change), update summary
  document
    .querySelectorAll("select.berg-select-native, select[data-role]")
    .forEach((native) => {
      native.addEventListener("change", () => {
        if (!isOrderVisible()) return;

        // guess active plan from select role (optional)
        const role = native.getAttribute("data-role");
        if (role === "familyType") activePlanKey = "family";
        if (role === "explorerType") activePlanKey = "explorer";

        updateStep1Summary();
      });
    });

  // 3) Backup: when clicking custom list option, update after DOM flips aria-selected
  document.querySelectorAll(".berg-select-ui__list").forEach((list) => {
    list.addEventListener("click", () => {
      if (!isOrderVisible()) return;
      setTimeout(updateStep1Summary, 0);
    });
  });

  // Optional: if order is already visible on load
  if (isOrderVisible()) updateStep1Summary();
})();

// =========================================================
// Insurance Conditions tabs: switch + update hash + auto scroll to content
// =========================================================
(function () {
  const root = document.querySelector("[data-ic-root]");
  if (!root) return;

  const tabs = Array.from(root.querySelectorAll(".ic-nav-item[data-ic-tab]"));
  const panels = Array.from(root.querySelectorAll(".ic-panel[data-ic-panel]"));

  function setActive(
    tabKey,
    opts = { scroll: true, focus: false, updateHash: true }
  ) {
    const tabBtn = tabs.find((t) => t.dataset.icTab === tabKey);
    const panel = panels.find((p) => p.dataset.icPanel === tabKey);
    if (!tabBtn || !panel) return;

    // --- tabs UI state
    tabs.forEach((t) => {
      const active = t === tabBtn;
      t.classList.toggle("is-active", active);
      t.setAttribute("aria-selected", active ? "true" : "false");
      t.setAttribute("tabindex", active ? "0" : "-1");
    });

    // --- panels state
    panels.forEach((p) => {
      const active = p === panel;
      p.classList.toggle("is-active", active);
      if (active) {
        p.removeAttribute("hidden");
      } else {
        p.setAttribute("hidden", "");
      }
    });

    // --- update hash (no hard jump)
    const hash = tabBtn.dataset.icHash;
    if (opts.updateHash && hash) {
      history.replaceState(null, "", `#${hash}`);
    }

    // --- auto scroll to anchor inside that panel (mobile-friendly)
    if (opts.scroll) {
      const anchorId = tabBtn.dataset.icHash;
      const anchorEl = anchorId ? document.getElementById(anchorId) : null;

      // fallback: scroll to panel itself if anchor missing
      const target = anchorEl || panel;

      // small delay so layout updates before scroll
      requestAnimationFrame(() => {
        target.scrollIntoView({ behavior: "smooth", block: "start" });
      });
    }

    if (opts.focus) {
      panel.focus({ preventScroll: true });
    }
  }

  // click handlers
  tabs.forEach((btn) => {
    btn.addEventListener("click", () => {
      setActive(btn.dataset.icTab, {
        scroll: true,
        focus: false,
        updateHash: true,
      });
    });
  });

  // open from URL hash on load (deep link support)
  function openFromHash() {
    const h = (location.hash || "").replace("#", "").trim();
    if (!h) return;

    const tabByHash = tabs.find((t) => t.dataset.icHash === h);
    if (tabByHash) {
      setActive(tabByHash.dataset.icTab, {
        scroll: true,
        focus: false,
        updateHash: false,
      });
    }
  }

  // run on load + hash change
  openFromHash();
  window.addEventListener("hashchange", openFromHash);
})();
