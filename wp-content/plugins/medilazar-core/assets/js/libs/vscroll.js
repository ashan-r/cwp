// Works on mobile but needs enhancements

( function( $ ) {
    
  /****** Osf Vertical Scroll Handler ******/
  var OsfVerticalScrollHandler = function($scope, $) {
      
    var vScrollElem     = $scope.find( ".osf-vscroll-wrap" ),
        instance        = null,
        vScrollSettings = vScrollElem.data( "settings" );

//    var touch = vScrollSettings.touch;

        instance = new osfVerticalScroll( vScrollElem, vScrollSettings );
        instance.init();

//        var isTouchDevice = navigator.userAgent.match(/(iPhone|iPod|iPad|Android|playbook|silk|BlackBerry|BB10|Windows Phone|Tizen|Bada|webOS|IEMobile|Opera Mini)/);
//      var isTouch = (('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0) || (navigator.maxTouchPoints));
//
//
//        if( touch ) {
//            instance = new osfVerticalScroll2( vScrollElem, vScrollSettings );
//            instance.init();
//        } else {
//            if ( isTouchDevice || isTouch ) {
//                instance = new osfVerticalScroll( vScrollElem, vScrollSettings );
//                instance.init();
//            } else {
//                instance = new osfVerticalScroll2( vScrollElem, vScrollSettings );
//                instance.init();
//            }
//        }
        

  };
  
  
  window.osfVerticalScroll2 = function( $selector, settings ) {
      
    var self            = this,
        $instance       = $selector,
        $window         = $( window ),
        $htmlBody       = $("html, body"),
        checkTemps      = $selector.find( ".osf-vscroll-sections-wrap" ).length,
        deviceType      = $("body").data("elementor-device-mode"),
        $itemsList      = $(".osf-vscroll-dot-item", $instance),
        $menuItems      = $(".osf-vscroll-nav-item", $instance),
        animated        = 0;
        
    
    var $lastItem       = $itemsList.last(),
        lastSectionId   = $lastItem.data("menuanchor"),
        lastOffset      = Math.round( $( "#" + lastSectionId ).offset().top );
    
    self.init = function() {
        
        self.setSectionsData();
        
        $itemsList.on("click.osfVerticalScroll", self.onNavDotChange);
        $menuItems.on("click.osfVerticalScroll", self.onNavDotChange);

        $itemsList.on( "mouseenter.osfVerticalScroll", self.onNavDotEnter );

        $itemsList.on( "mouseleave.osfVerticalScroll", self.onNavDotLeave );
        
        $.scrollify({
            section:                ".osf-vscroll-section",
            updateHash:             false,
            standardScrollElements: "#" + lastSectionId,
            scrollSpeed:            settings.speed,
            overflowScroll:         settings.overflow,
            setHeights:             settings.setHeight,
            before: function( index ) {
                
                $menuItems.removeClass("active");
                $itemsList.removeClass("active");

                $( $itemsList[ index ] ).addClass( "active" );
                $( $menuItems[ index ] ).addClass( "active" );
                
            },
            after: function( index ) {
                
                if ( index === $lastItem.index() ) {
//                    $.scrollify.disable();
                }
                
            },
            afterRender: function() {
                
                $( $itemsList[ 0 ] ).addClass( "active" );
                $( $menuItems[ 0 ] ).addClass( "active" );
                
            }
        });
        
        if ( deviceType === "desktop" ) {
            
            $window.on( "scroll.osfVerticalScroll2", self.onWheel );
            
        }
        
        if ( settings.fullSection ) {
            
            var vSection = document.getElementById( $instance.attr("id") );
            
            if ( checkTemps ) {
                
                document.addEventListener
                ? vSection.addEventListener("wheel", self.onWheel, !1)
                : vSection.attachEvent("onmousewheel", self.onWheel);
                
            } else {
                
                document.addEventListener
                ? document.addEventListener("wheel", self.onWheel, !1)
                : document.attachEvent("onmousewheel", self.onWheel);
                
            }
        }
    
    };
    
    self.onWheel = function( event ) {
      
        var $target         = $( event.target ),
            sectionSelector = checkTemps ? ".osf-vscroll-temp" : ".elementor-top-section",
            $section        = $target.closest( sectionSelector ),
            sectionId       = $section.attr( "id" ),
            $currentSection  = $.scrollify.current();
        
        //re-enable Scrollify
        if ( sectionId !== lastSectionId && $section.hasClass("osf-vscroll-section") && $.scrollify.isDisabled() ) {
            
            $(".osf-vscroll-dots, .osf-vscroll-nav-menu").removeClass(
                "osf-vscroll-dots-hide"
            );
            
            $.scrollify.enable();
            
        } 
        
        if ( ! $section.hasClass("osf-vscroll-section") && $.scrollify.isDisabled() ) {
            
            $(".osf-vscroll-tooltip").hide();
            
            $(".osf-vscroll-dots, .osf-vscroll-nav-menu").addClass(
                "osf-vscroll-dots-hide"
            );
            
        } 
        
        
        
    };
    
    self.moveSectionDown = function() {
        $.scrollify.next();
    }
    
    self.moveSectionUp = function() {
        $.scrollify.previous();
    }
    
    self.moveToSection = function( index ) {
        
        $.scrollify.move( index );
    }
    
    self.setSectionsData = function() {
        
      $itemsList.each( function() {
          
        var $this       = $( this ),
            sectionId   = $this.data( "menuanchor" ),
            $section    = $( "#" + sectionId );
          
        $section.addClass( "osf-vscroll-section" );
        
      });
      
    };
    
    self.onNavDotChange = function( event ) {
        
        var $this       = $( this ),
            index       = $this.index(),
            sectionId   = $this.data("menuanchor");

//      if ( ! isScrolling ) {
          
        if ( $.scrollify.isDisabled() ) {
            
            $.scrollify.enable();
            
        }

        $menuItems.removeClass("active");
        $itemsList.removeClass("active");

        if ( $this.hasClass( "osf-vscroll-nav-item") ) {
            
          $( $itemsList[ index ] ).addClass( "active" );
          
        } else {
            
          $( $menuItems[ index ] ).addClass( "active" );
        }

        $this.addClass( "active" );
        
        self.moveToSection( index );
        
//      }
    };
    
    self.onNavDotEnter = function() {
        
        var $this = $( this ),
            index = $this.data("index");
    
      if ( settings.tooltips ) {
          
        $('<div class="osf-vscroll-tooltip"><span>' + settings.dotsText[index] + "</span></div>" ).hide().appendTo( $this ).fadeIn( 200 );
      }
      
    };

    self.onNavDotLeave = function() {
        
      $( ".osf-vscroll-tooltip" ).fadeOut( 200, function() {
          
        $( this ).remove();
        
      });
      
    };

    
      
  };

  window.osfVerticalScroll = function($selector, settings) {
    var self = this,
      $window = $(window),
      $instance = $selector,
      checkTemps = $selector.find(".osf-vscroll-sections-wrap").length,
      $htmlBody = $("html, body"),
      deviceType = $("body").data("elementor-device-mode"),
      $itemsList = $(".osf-vscroll-dot-item", $instance),
      $menuItems = $(".osf-vscroll-nav-item", $instance),
      defaultSettings = {
        speed: 700,
        offset: 1,
        fullSection: true
      },
      settings = $.extend({}, defaultSettings, settings),
      sections = {},
      currentSection = null,
      isScrolling = false;

    jQuery.extend(jQuery.easing, {
      easeInOutCirc: function(x, t, b, c, d) {
        if ((t /= d / 2) < 1) return (-c / 2) * (Math.sqrt(1 - t * t) - 1) + b;
        return (c / 2) * (Math.sqrt(1 - (t -= 2) * t) + 1) + b;
      }
    });

    self.checkNextSection = function(object, key) {
      var keys = Object.keys(object),
        idIndex = keys.indexOf(key),
        nextIndex = (idIndex += 1);

      if (nextIndex >= keys.length) {
        return false;
      }

      var nextKey = keys[nextIndex];

      return nextKey;
    };

    self.checkPrevSection = function(object, key) {
      var keys = Object.keys(object),
        idIndex = keys.indexOf(key),
        prevIndex = (idIndex -= 1);

      if (0 > idIndex) {
        return false;
      }

      var prevKey = keys[prevIndex];

      return prevKey;
    };

    self.debounce = function(threshold, callback) {
      var timeout;

      return function debounced($event) {
        function delayed() {
          callback.call(this, $event);
          timeout = null;
        }

        if (timeout) {
          clearTimeout(timeout);
        }

        timeout = setTimeout(delayed, threshold);
      };
    };
    self.visible = function(selector, partial, hidden){
        
        var s = selector.get(0),
            vpHeight = $window.outerHeight(),
            clientSize = hidden === true ? s.offsetWidth * s.offsetHeight : true;
        if (typeof s.getBoundingClientRect === 'function') {
            var rec = s.getBoundingClientRect();
            var tViz = rec.top >= 0 && rec.top < vpHeight,
                bViz = rec.bottom > 0 && rec.bottom <= vpHeight,
                vVisible = partial ? tViz || bViz : tViz && bViz,
                vVisible = (rec.top < 0 && rec.bottom > vpHeight) ? true : vVisible;
            return clientSize && vVisible;
        } else {
            var viewTop = 0,
                viewBottom = viewTop + vpHeight,
                position = $window.position(),
                _top = position.top,
                _bottom = _top + $window.height(),
                compareTop = partial === true ? _bottom : _top,
                compareBottom = partial === true ? _top : _bottom;
            return !!clientSize && ((compareBottom <= viewBottom) && (compareTop >= viewTop));
        }
        
    };

    self.init = function() {
      self.setSectionsData();
      $itemsList.on("click.osfVerticalScroll", self.onNavDotChange);
      $menuItems.on("click.osfVerticalScroll", self.onNavDotChange);

      $itemsList.on("mouseenter.osfVerticalScroll", self.onNavDotEnter);

      $itemsList.on("mouseleave.osfVerticalScroll", self.onNavDotLeave);

      if (deviceType === "desktop") {
        $window.on("scroll.osfVerticalScroll", self.onWheel);
      }
      $window.on(
        "resize.osfVerticalScroll orientationchange.osfVerticalScroll",
        self.debounce(50, self.onResize)
      );
      $window.on("load", function() {
        self.setSectionsData();
      });

      $(document).keydown(function(event) {
        if (38 == event.keyCode) {
          self.onKeyUp(event, "up");
        }

        if (40 == event.keyCode) {
          self.onKeyUp(event, "down");
        }
      });
      if (settings.fullSection) {
        var vSection = document.getElementById($instance.attr("id"));
        if (checkTemps) {
          document.addEventListener
            ? vSection.addEventListener("wheel", self.onWheel, !1)
            : vSection.attachEvent("onmousewheel", self.onWheel);
        } else {
          document.addEventListener
            ? document.addEventListener("wheel", self.onWheel, !1)
            : document.attachEvent("onmousewheel", self.onWheel);
        }
      }

      for (var section in sections) {
        var $section = sections[section].selector;
        elementorFrontend.waypoint(
          $section,
          function(direction) {
            var $this = $(this),
              sectionId = $this.attr("id");
            if ("down" === direction && !isScrolling) {
              currentSection = sectionId;
              $itemsList.removeClass("active");
              $menuItems.removeClass("active");
              $("[data-menuanchor=" + sectionId + "]", $instance).addClass(
                "active"
              );
            }
          },
          {
            offset: "95%",
            triggerOnce: false
          }
        );

        elementorFrontend.waypoint(
          $section,
          function(direction) {
            var $this = $(this),
              sectionId = $this.attr("id");
            if ("up" === direction && !isScrolling) {
              currentSection = sectionId;
              $itemsList.removeClass("active");
              $menuItems.removeClass("active");
              $("[data-menuanchor=" + sectionId + "]", $instance).addClass(
                "active"
              );
            }
          },
          {
            offset: "0%",
            triggerOnce: false
          }
        );
      }
    };

    self.setSectionsData = function() {
      $itemsList.each(function() {
        var $this = $(this),
          sectionId = $this.data("menuanchor"),
          $section = $("#" + sectionId);
        if ($section[0]) {
          sections[sectionId] = {
            selector: $section,
            offset: Math.round($section.offset().top),
            height: $section.outerHeight()
          };
        }
      });
    };

    self.onNavDotEnter = function() {
      var $this = $(this),
        index = $this.data("index");
      if (settings.tooltips) {
        $(
          '<div class="osf-vscroll-tooltip"><span>' +
            settings.dotsText[index] +
            "</span></div>"
        )
          .hide()
          .appendTo($this)
          .fadeIn(200);
      }
    };

    self.onNavDotLeave = function() {
      $(".osf-vscroll-tooltip").fadeOut(200, function() {
        $(this).remove();
      });
    };

    self.onNavDotChange = function(event) {
      var $this = $(this),
        index = $this.index(),
        sectionId = $this.data("menuanchor"),
        offset = null;

      if (!sections.hasOwnProperty(sectionId)) {
        return false;
      }

      offset = sections[sectionId].offset - settings.offset;

      if (!isScrolling) {
        isScrolling = true;

        currentSection = sectionId;
        $menuItems.removeClass("active");
        $itemsList.removeClass("active");

        if ($this.hasClass("osf-vscroll-nav-item")) {
          $($itemsList[index]).addClass("active");
        } else {
          $($menuItems[index]).addClass("active");
        }

        $this.addClass("active");

        $htmlBody
          .stop()
          .clearQueue()
          .animate(
            { scrollTop: offset },
            settings.speed,
            "easeInOutCirc",
            function() {
              isScrolling = false;
            }
          );
      }
    };

    self.onKeyUp = function(event, direction) {
      var direction = direction || "up",
        sectionId,
        nextItem = $(
          ".osf-vscroll-dot-item[data-menuanchor=" + currentSection + "]",
          $instance
        ).next(),
        prevItem = $(
          ".osf-vscroll-dot-item[data-menuanchor=" + currentSection + "]",
          $instance
        ).prev();

      event.preventDefault();

      if (isScrolling) {
        return false;
      }

      if ("up" === direction) {
        if (prevItem[0]) {
          prevItem.trigger("click.osfVerticalScroll");
        }
      }

      if ("down" === direction) {
        if (nextItem[0]) {
          nextItem.trigger("click.osfVerticalScroll");
        }
      }
    };

    self.onScroll = function(event) {
      /* On Scroll Event */
      if (isScrolling) {
        event.preventDefault();
      }
    };

    function getFirstSection(object) {
      return Object.keys(object)[0];
    }

    function getLastSection(object) {
      return Object.keys(object)[Object.keys(object).length - 1];
    }

    function getDirection(e) {
      e = window.event || e;
      var t = Math.max(-1, Math.min(1, e.wheelDelta || -e.deltaY || -e.detail));
      return t;
    }

    self.onWheel = function(event) {
      if (isScrolling) {
        event.preventDefault();
        return false;
      }

      var $target = $(event.target),
        sectionSelector = checkTemps
          ? ".osf-vscroll-temp"
          : ".elementor-top-section",
        $section = $target.closest(sectionSelector),
        $vTarget = self.visible($instance, true, false),
        sectionId = $section.attr("id"),
        offset = 0,
        newSectionId = false,
        prevSectionId = false,
        nextSectionId = false,
        delta = getDirection(event),
        direction = 0 > delta ? "down" : "up",
        windowScrollTop = $window.scrollTop(),
        dotIndex = $(".osf-vscroll-dot-item.active").index();
      if ("mobile" === deviceType || "tablet" === deviceType) {
        $(".osf-vscroll-tooltip").hide();
        if (dotIndex === $itemsList.length - 1 && !$vTarget) {
          $(".osf-vscroll-dots, .osf-vscroll-nav-menu").addClass(
            "osf-vscroll-dots-hide"
          );
        } else if (dotIndex === 0 && !$vTarget) {
          if ($instance.offset().top - $(document).scrollTop() > 200) {
            $(".osf-vscroll-dots, .osf-vscroll-nav-menu").addClass(
              "osf-vscroll-dots-hide"
            );
          }
        } else {
          $(".osf-vscroll-dots, .osf-vscroll-nav-menu").removeClass(
            "osf-vscroll-dots-hide"
          );
        }
      }

      if (beforeCheck()) {
        sectionId = getFirstSection(sections);
      }

      if (afterCheck()) {
        sectionId = getLastSection(sections);
      }
      if (sectionId && sections.hasOwnProperty(sectionId)) {
        prevSectionId = self.checkPrevSection(sections, sectionId);
        nextSectionId = self.checkNextSection(sections, sectionId);
        if ("up" === direction) {
          if (!nextSectionId && sections[sectionId].offset < windowScrollTop) {
            newSectionId = sectionId;
          } else {
            newSectionId = prevSectionId;
          }
        }

        if ("down" === direction) {
          if (
            !prevSectionId &&
            sections[sectionId].offset > windowScrollTop + 5
          ) {
            newSectionId = sectionId;
          } else {
            newSectionId = nextSectionId;
          }
        }

        if (newSectionId) {
          $(".osf-vscroll-dots, .osf-vscroll-nav-menu").removeClass(
            "osf-vscroll-dots-hide"
          );
//          event.preventDefault();
          offset = sections[newSectionId].offset - settings.offset;
          currentSection = newSectionId;
          $itemsList.removeClass("active");
          $menuItems.removeClass("active");
          $("[data-menuanchor=" + newSectionId + "]", $instance).addClass(
            "active"
          );

          isScrolling = true;
          self.scrollStop();
          $htmlBody.animate(
            { scrollTop: offset },
            settings.speed,
            "easeInOutCirc",
            function() {
              isScrolling = false;
            }
          );
        } else {
          var $lastselector = checkTemps ? $instance : $("#" + sectionId);
          if ("down" === direction) {
            if (
              $lastselector.offset().top +
                $lastselector.innerHeight() -
                $(document).scrollTop() >
              600
            ) {
              $(".osf-vscroll-dots, .osf-vscroll-nav-menu").addClass(
                "osf-vscroll-dots-hide"
              );
            }
          } else if ("up" === direction) {
            if ($lastselector.offset().top - $(document).scrollTop() > 200) {
              $(".osf-vscroll-dots, .osf-vscroll-nav-menu").addClass(
                "osf-vscroll-dots-hide"
              );
            }
          }
        }
      }
    };

    function beforeCheck(event) {
      var windowScrollTop = $window.scrollTop(),
        firstSectionId = getFirstSection(sections),
        offset = sections[firstSectionId].offset,
        topBorder = windowScrollTop + $window.outerHeight(),
        visible = self.visible($instance, true, false);

      if (topBorder > offset) {
        return false;
      } else if (visible) {
        return true;
      }
      return false;
    }

    function afterCheck(event) {
      var windowScrollTop = $window.scrollTop(),
        lastSectionId = getLastSection(sections),
        offset = sections[lastSectionId].offset,
        bottomBorder =
          sections[lastSectionId].offset + sections[lastSectionId].height,
        visible = self.visible($instance, true, false);

      if (windowScrollTop < bottomBorder) {
        return false;
      } else if (visible) {
        return true;
      }

      return false;
    }

    self.onResize = function(event) {
      self.setSectionsData();
    };

    self.scrollStop = function() {
      $htmlBody.stop(true);
    };
  };

  $(window).on("elementor/frontend/init", function() {
    elementorFrontend.hooks.addAction(
      "frontend/element_ready/opal-vertical-scroll.default",
      OsfVerticalScrollHandler
    );
  });
})( jQuery );