$ = jQuery;

// Check for iPad - transforms are knackered in iPad...
var isiPad = navigator.userAgent.match(/iPad/i) != null;

var mobileRez = 930;

var pushHistoryEnabled = (window.history && window.history.pushState);

function getAndroidVersion(ua) {
    var ua = ua || navigator.userAgent; 
    var match = ua.match(/Android\s([0-9\.]*)/);
    return match ? match[1] : false;
};

function detectIE() {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf('MSIE ');
    var trident = ua.indexOf('Trident/');

    if (msie > 0) {
        // IE 10 or older => return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    if (trident > 0) {
        // IE 11 (or newer) => return version number
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    // other browser
    return false;
}

var ieV = detectIE();

var ie8 = ieV && ieV < 9;
var isIe = ieV != false;



var $body = $("body"),
    $window = $(window),
    dw = $window.width(),
    dh = $window.height();

var cev = 'click';

var gallery = {
	$descCol : null,
	$picItems : null,
	init : function() {
		var that = this;
		this.$descCol = $(".gallery_desc_col");
		this.$picItems = $(".gallery-pic-items");
		$(".gallery_pic").bind("click touchend", function() {
			$(".gallery_desc", that.$descCol).hide();
			$("#gallery_item_" + $(this).data("ind"), that.$descCol).show();
			$(".active", that.$picItems).removeClass("active");
			$(this).addClass("active");
		});
	}
};

var overlayCarousel = {
    $container : null,
    images : [],
    minH : 0,
    currentInd : 0,
    height : 0,
    itemsNo : 0,
	swSlider : null, //desktop slider
    init : function($container) {
        var that = this;
        this.$container = $container.parent();
        $(".close", this.$container).click(function(){ that.close() });

        this.itemsNo = $(".item", this.$container).size();


        $(".item", this.$container).each( function(ind) {
            $(this).css('left', 100 * ind  + '%');
        });

        $(window).on('resize', function(){
            that.resizeOverlay();
        });
        that.resizeOverlay();

        /*
        $(".arrow-left", this.$container).click( function() {
            that.slideTo(that.currentInd - 1);
        });
        $(".arrow-right", this.$container).click( function() {
            that.slideTo(that.currentInd + 1);
        });
        */
    },

    resizeOverlay : function() {
        //console.log(this.images.length);
        if(!this.images.length) return;

        //calculate carousel height
        var cHeight = 0, imgW = dw - 325;

		//console.log(this.images);

        //for(var i = 0; i < this.images.length; i++) {
        var i = 0;
            var h = (dw - 325) * this.images[i].h / this.images[i].w;
            if(h > dh) h = dh;
            if(h < this.minH) h = this.minH;
            cHeight = h;
        //}
        $(".overlay_carousel, .swiper-container", this.$container).height( cHeight );

        //console.log(cHeight);
        this.height = cHeight;

        for(var i = 0; i < this.images.length; i++) {
            var w = this.images[i].w, h = this.images[i].h;
            if( w / h  > imgW / cHeight ){
                this.images[i].inst.css({'width': 'auto', 'height': '100%', 'margin-left': ((imgW - w * cHeight / h)/2), 'margin-top': '0px', 'left': '0%', 'top': '0'});
            } else {
                this.images[i].inst.css({'width': '100%', 'height': 'auto', 'margin-top': ((cHeight - h * imgW / w)/2), 'margin-left': '0px', 'left': '0px', 'top': '0'});
            }
        }
    },

    close : function() {
		
		if(this.swSlider) {			
			this.swSlider.destroy(true);		
			this.swSlider = null;			
		}

        $(".overlay_carousel", this.$container).slideUp();
        $(".col-frame", londonPage.$prjSection).show();
    },

    /*
    slideTo : function(ind) {
        if(ind >= this.itemsNo) ind = 0;
        if(ind < 0) ind = this.itemsNo - 1;

        this.currentInd = ind;

        $(".carousel_c", this.$container).animate({marginLeft: -100 * ind + "%"});
    },
    */

    show : function(el, defaultInd) {
        var that = this;

		if(this.swSlider) {
			this.swSlider.destroy(true);		
			this.swSlider = null;
		}

        //calculate the col-frame element that will be used to display
        $(".col-frame", londonPage.$prjSection).eq( Math.floor(defaultInd / 2) * 2).before( this.$container );

        var box = $(el).parents(".frame");

        var slides = box.data("desk-slides");
        var sSlides = '<div class="swiper-container" style="display: block;"><div class="swiper-wrapper">';
		


        for(var i = 0; i < slides.length; i++) {
            sSlides += '<div class="swiper-slide"><img data-ind="' + i + '" src="' + slides[i].url + '" data-h="' + slides[i].h + '" data-w="' + slides[i].w + '" alt="" class="" ></div>'; //full-width-img
        }
        sSlides += '</div>' +
               '<div class="slide-ind"> <span class="current">1</span> / <span class="total">' + slides.length + '</span> </div>' +
            '</div>';


        $(".carousel_c .img", this.$container).html(sSlides);

        var sTxt = '<h2>' + $("h1", box).html() + '</h2>' +
                    $(".mobile-prj-view-section .mobile-det", box).html() +
                    '<br /><br />' +
                    '<a href="mailto:Info@strawberrystar.com">Register interest</a>';
        $(".carousel_c .txt .in", this.$container).html(sTxt);


        that.images = [];
        $(".img img", this.$container).each( function() {
            that.images.push( {inst : $(this), w : $(this).data("w"), h : $(this).data("h")} );
           // that.images.push( {inst : $(this), w : 640, h : 400} );
        });

        $(".overlay_carousel", this.$container).show();
        $(".item .txt", this.$container).each( function() {
            var h = $(this).height() + 40;
            if(h > that.minH) that.minH = h;
        });
        $(".overlay_carousel", this.$container).hide();

        //$(".carousel_c", this.$container).css({marginLeft: -100 * defaultInd + "%"});
        this.currentInd = defaultInd;

        this.resizeOverlay();

		// console.log(ie8);
	
        this.swSlider = new Swiper($('.swiper-container', this.$container)[0],{
            loop: true,
            grabCursor: true,
            mode:'horizontal',
            initialSlide : 0,
            watchActiveIndex : true,
            resizeReInit : true,
            calculateHeight : true,
            onSlideChangeEnd : function(swiper, direction) {
                var currentSlide  = $("img", swiper.activeSlide()).data("ind");
                currentSlide = parseInt(currentSlide) + 1;
                $(".slide-ind .current", swiper.container).html(currentSlide);
            }
        });	
		var swSlider = this.swSlider;

        //console.log(swSlider);
        //console.log($('.swiper-container', this.$container));

        $(".overlay_carousel", this.$container).slideDown(function() {
            //swSlider.reInit();
            swSlider.resizeFix()
        });

        $(".col-frame", londonPage.$prjSection).eq( Math.floor(defaultInd / 2) * 2).hide();
        $(".col-frame", londonPage.$prjSection).eq( Math.floor(defaultInd / 2) * 2 + 1).hide();



        $(".arrow-left", this.$container).unbind("click").click( function() {
            //that.slideTo(that.currentInd - 1);
            swSlider.swipePrev();
        });
        $(".arrow-right", this.$container).unbind("click").click( function() {
            //that.slideTo(that.currentInd + 1);
            swSlider.swipeNext();
        });

    },

	mobileShow : function(el, defaultInd) {
		$(el).parents(".frame").addClass('mobile-open');
        //$(window).trigger('resize');
		return false;
	},

	mobileHide : function(el, defaultInd) {
		$(el).parents('.mobile-open').removeClass('mobile-open');
		return false;
	}
};

var londonPage = {
    prjSectionImgW : 0,
    prjSectionImgH : 0,
    $prjSection : null,
    prjSlides : {},	
    init : function() {
        overlayCarousel.init( $(".overlay_carousel") );
        var that = this;

        this.$prjSection = $(".projects-section");

        this.prjSectionImgH = $("img.pa[data-w]:first", this.$prjSection).data("h");
        this.prjSectionImgW = $("img.pa[data-w]:first", this.$prjSection).data("w");

		var thTm = 0;
		var winWidth = $window.width(),
			winHeight = $window.height();
        $(window).on('resize', function(){						
			//New height and width // ie8 infinite loop fix
			var winNewWidth = $window.width(),
				winNewHeight = $window.height();

			if(winWidth!=winNewWidth || winHeight!=winNewHeight) {
				if( thTm ){
					clearTimeout( thTm );
				}
				thTm = window.setTimeout(function() { that.resizePrjImages(); }, 10);
			}
			//Update the width and height
			winWidth = winNewWidth;
			winHeight = winNewHeight;
        });
        that.resizePrjImages();

		if($("html").hasClass("touch")) {
			$(".s_img", this.$prjSection).bind("click touchend", function() {
				overlayCarousel.show(this, $(this).data('prj-ind'));
			});
		}

        this.setProjectsSwiper();
    },

    // bottom images sizes
    resizePrjImages : function() {
        var frameW = dw / 2;
        if(dw <= mobileRez ) frameW = dw;
        var h = frameW * this.prjSectionImgH / this.prjSectionImgW;
        $(".frame", this.$prjSection).height( h )
        //$(".s_img").css( {width: dw/2 } );

		//set margin on top text
		var t = $("#our-project-text-section");
		t.css('padding', 0);
		$(".middle-container", t).css({paddingTop : 0});

		var sH = t.parent().css('min-height', 0).height();
		//console.log(sH + " - " + dh);
		if(sH < dh) {
			t.css({paddingBottom: (dh - sH) / 2 + 'px'});
			$(".middle-container:first", t).css({paddingTop : (dh - sH) / 2 + 'px'});
		}
		t.parent().css('min-height', dh + "px");
    },
		
    setProjectsSwiper : function() {
		if(dw > mobileRez) return;

        this.prjSlides = {};
        $(".frame", this.$prjSection).each(function (index) {
            var slides = [];

        });
        $('.swiper-container', this.$prjSection).each(function (index) {
            new Swiper($(this)[0],{
                loop: true,
                grabCursor: true,
                mode:'horizontal',
                initialSlide : 0,
                watchActiveIndex : true,
                resizeReInit : true,
                calculateHeight : true,
                onSlideChangeEnd : function(swiper, direction) {
                    var currentSlide  = $("img", swiper.activeSlide()).data("ind");
                    currentSlide = parseInt(currentSlide) + 1;
                    $(".slide-ind .current", swiper.container).html(currentSlide);
                }
            })
        });
    }
};


var layout = {
    sectionSizes : [],
	$sectionPages : null,
	$middleContainers : null,

	slides : null,
	noOfSections : 0,
	curPage : 0,
	animating : false,

	reinit : function() {
		this.$sectionPages = $("#one, .section_page");
        this.$middleContainers = $(".section_page .middle-container");
		
		var that = this;

		this.slides = $(".scroll-section"); //$("#one").add(".section_page").add("footer"),
        this.noOfSections = this.slides.size();
		this.curPage = 0;
		this.animating = false;
		
		if(!ie8) {
			$('.jumper').unbind(cev).on(cev, function( e ){
				e.preventDefault();

				//console.log("A");

				that.animating = true;
				var el = $( $(this).data('slide') );			

				that.curPage = that.slides.index(el);

				$window.scrollTo( that.slides.eq( that.curPage ), 600, { easing: 'linear', axis:'y', onAfter: function(){ that.animating=false; } });
			});
		}

		var docViewTop = $window.scrollTop();
        this.slides.each(function(ind) {
            if( $(this).offset().top + 10 < docViewTop) {
                that.curPage = ind;
            }
        });
		
		$(window).trigger('resize');

        //this.scrolling();
	},

    init : function() {
		
		var that = this;
        this.$sectionPages = $("#one, .section_page");
        this.$middleContainers = $(".section_page .middle-container");

		this.reinit();

        $(window).on('resize', function(){
            dw = $window.width();
            dh = $window.height();

            if (dw < 641) {
                $body.addClass('mobile');
            }
            else {
                $body.removeClass('mobile');
            }

            that.$sectionPages.css('min-height', dh + "px");
            that.$middleContainers.each( function() {
				var p = $(this).parents('.section_page');
				if(!p.hasClass('skip-middle-valign')) {
	                var h = $(this).parents('.section_page').height();
		            $(this).css({marginTop: (h - 88 - $(this).height()) / 2 });
				}
            });

            $("#one .middle-content").each( function() {
                var h = $(this).parents('#one').height();
                $(this).css({marginTop: (h - 88 - $(this).height()) / 3  });
            });
			if(dh < 670 && $body.hasClass('page-node-1')) {
				$("#one").css('min-height', '670px');
			}
			if(dh < 550 && $body.hasClass('page-node-3')) {
				$("#one").css('min-height', '550px');
			}
        });

        $(window).trigger('resize');

        this.scrolling();
    },

    scrolling: function () {

        var dir;
        var timer;        

		that = this;
        

        // If user scrolls, move to releveant section
        $(window).bind('DOMMouseScroll mousewheel',function (e) {

            if( ($window.width() > mobileRez) && (isiPad != true) && that.noOfSections > 1 ){
                if( that.animating ) {
                    e.preventDefault();
                }

                if (e.originalEvent.wheelDelta >= 0) {
                    dir = 'up';
                }
                else {
                    dir = 'down';
                }

                if(that.slides.eq( that.curPage).height() > dh + 30 ) {					

                    //if current slide is bigger than window height then cancel automatic scroll
                    var docViewTop = $window.scrollTop();
                    var viewSlideInd = that.curPage;
                    //console.log("docViewTop " +  docViewTop);

                    that.slides.each(function(ind) {
                        var offsetTop = $(this).offset().top;
                        //console.log(ind + " - elTop:" + offsetTop + " elBot : " + (offsetTop + $(this).height() ) + ", h = " + $(this).height());
                        //console.log("docViewTop + dh " + (docViewTop + dh));

                        if(dir == "down") {
                            var elBottom = offsetTop + $(this).height();
                            if( offsetTop - dh <= docViewTop &&  (elBottom > (docViewTop + dh - 100)) ) {
                                viewSlideInd = ind;
                            }
                        }
                        else {
                            if( offsetTop + 80 < docViewTop && offsetTop + dh + 80 > docViewTop ) {
                                viewSlideInd = ind;
                            }
                        }
                    });
                    if(that.curPage == viewSlideInd) return;
                }

                clearTimeout(timer);
                timer = setTimeout( function() { that.scrollPage(dir); } , 1 );
            }
        });

        //if user uses keys, go to relevant section
        $(document).keydown(function(e){
            if (e.keyCode == 38) {
                dir = 'up';
                that.scrollPage(dir);
                return false;
            }else if(e.keyCode == 40) {
                dir = 'down';
                that.scrollPage(dir);
                return false;
            }
        });
    },

	scrollPage : function (dir) {

		var pageHeight = $window.height();
		var footHeight = $('footer').height();
		//var moveFoot = (100/pageHeight)*footHeight;
		var that = this;
		if(this.animating == false){
			this.animating = true;
			if ((dir == 'up') && (this.curPage > 0)){
				//$('.main-nav .branding .logo').animate({'bottom':'0'},500);
				this.curPage--;
				//pos = curPage*100;
			}else if ((dir == 'down') && (this.curPage < this.noOfSections-2)){
				this.curPage++;
				//pos = curPage*100;
			}else if ((dir == 'down') && (this.curPage == this.noOfSections-2)){				
				//pos = (curPage*100)+moveFoot;
				this.curPage++;
				//$('.main-nav .branding .logo').animate({'bottom':parseInt($('.section').eq(curPage).height())-25+'px'},500);
			}

			$window.scrollTo( this.slides.eq( this.curPage ), 600, { easing: 'linear', axis:'y', onAfter: function(){ that.animating=false; } });
		}
	}
} ;


var menuScroll = {
	currentNid : 0,
    blockSystemMain: null,

	init : function() {
        var that = this;
		this.blockSystemMain = $("#block-system-main");
		$("nav .menu a").unbind("click").click ( function() {

            var link = $(this);

			var nid = link.data("nid");
			if(!nid) return ;

            if(nid + "" == that.currentNid + "") return;

            that.loadPage(nid, link);
			return false;
		});
	},

    loadPage : function(nid, link) {
        var that = this;

        $("#ajax-page-loading").show();
        $.ajax(Drupal.settings.basePath + "node/get/ajax/" + nid)
            .done(function( data ) {
                $ = jQuery;
                $("#ajax-page-loading").hide();

                if(pushHistoryEnabled && link) {
                    history.pushState( {type:'node', nid : nid }, link.text(), link.attr("href"));
                }

                layout.animating = true;

                //region-content
                that.blockSystemMain.parent().css( {width:dw + "px", overflow:"hidden"} );


                var $c = $("> .content", that.blockSystemMain);
                $c.css({ width: dw + "px"});

                that.blockSystemMain.css({width: 2 * dw, position:"relative" } );

                that.blockSystemMain.append('<div class="content" id="newContent" style="width: ' + dw + 'px; position:absolute; left:' + dw + 'px; top:' + $window.scrollTop() + 'px;">' + data + '</div>');
                //blockSystemMain.html(data);
                siteReinit(nid);

                that.blockSystemMain.animate( { marginLeft : "-" + dw + "px"}, function() {
                    $c.remove();
                    var $n = $("#newContent");
                    $n.css({width : 'auto', position : 'static'}).removeAttr("id");
                    $body.removeClass('page-node-' + menuScroll.currentNid).addClass('page-node-' + nid);
                    menuScroll.currentNid = nid;
                    that.blockSystemMain.parent().css( {width:"auto", overflow:"visible"} );
                    that.blockSystemMain.css({marginLeft : 0, width : 'auto'});
                    layout.animating = false;
                    window.scrollTo(0, 0);
                    layout.reinit();
                    $("nav .menu a.active").removeClass("active");
                    $("nav .menu a[data-nid=" + nid + "]").addClass("active");

                    //console.log($n);
                    Drupal.attachBehaviors($n, Drupal.settings);
                });
            });
    }
};


function siteReinit(nid) {
	layout.reinit();

    if(nid == 3) {
        gallery.init();
    }
    else if(nid == 4) { // londong
        londonPage.init();
        //setProjectsSwipper();
    }
	else if(nid == 7) { //contact
		$(".region-content .content .webform-client-form").attr( "action", $("#one nav .menu a[data-nid=7]").attr("href") );
		contactPageInit();
	}

	$('input, textarea').placeholder();

	menuScroll.init();
}

function contactPageInit() {
	//alert($("#edit-submitted-name").size());

	$("#edit-submitted-phone").unbind("keypress").on('keypress', function(evt) {
		  var charCode = (evt.which) ? evt.which : event.keyCode;
		  var r = !(charCode != 46 && charCode != 43 && charCode != 32 && (charCode < 48 || charCode > 57));
		  if(!r) {
			evt.preventDefault();
		  }
		  return r;
	});

	$("#edit-submitted-name").unbind("keypress").on('keypup', function(evt) {
			var charCode = (evt.which) ? evt.which : event.keyCode;			
			if(charCode >= 47 && charCode <= 64 || charCode >= 33 && charCode <= 43) {
				evt.preventDefault();
				return false;
			}
			return true;
		});

	$("#edit-submitted-email").unbind("keypress").on('keypress', function(evt) {
			var charCode = (evt.which) ? evt.which : event.keyCode;
			if(charCode >= 32 && charCode <= 44 || charCode == 47 || charCode >= 58 && charCode <= 63 || charCode >= 91 && charCode <= 94 || charCode == 96 || charCode >= 123 && charCode <= 126) {
				evt.preventDefault();
				return false;
			}
			return true;
		});
}


$(document).on('pageinit',function(event){
	if($body.hasClass('page-node-7')) {
		//alert("a");
        contactPageInit();
    }
});

$(document).ready(function() {
	
	layout.init();

    if($body.hasClass('node-type-about')) {
        gallery.init();
    }
    else if($body.hasClass('node-type-london')) {
        londonPage.init();
        //setProjectsSwipper();
    }
	else if($body.hasClass('page-node-7')) {
        contactPageInit();
    }

	$('input, textarea').placeholder();

    if($body.data('nid')) {
        menuScroll.currentNid = $body.data('nid');
        if(pushHistoryEnabled) {
            history.pushState( {type:'node', nid : $body.data('nid') }, document.title, document.URL);
        }
    }
	menuScroll.init();

    window.onpopstate = function(event) {
        if(event.state) {
            if(event.state.type && event.state.type == 'node' && event.state.nid) {
                menuScroll.loadPage(event.state.nid, false);
            }
        }

        //document.getElementById('log').innerHTML += message+"\n\n";
    };



	//console.log($("footer .newsletter-form form").size());

     $(document).bind('clientsideValidationFormHasErrors', function(event, form) {
        $(form).parents(".newsletter-c").addClass("newsletter-submited");
    });
	$(document).bind('form-submit-notify', function(event, form) {
        $(form).parents(".newsletter-c").addClass("newsletter-submited");
    });

	$("input[type=email]").on('keypress', function(evt) {
			var charCode = (evt.which) ? evt.which : event.keyCode;
			if(charCode >= 32 && charCode <= 44 || charCode == 47 || charCode >= 58 && charCode <= 63 || charCode >= 91 && charCode <= 94 || charCode == 96 || charCode >= 123 && charCode <= 126) return false;
			return true;
		});


	/*
	$(".pushy").on("click touchstart touchend", function(e) {
		e.preventDefault();
	});
	*/
	
	/*
	$(".site-overlay").on("click touchstart touchend", function(e) {
		e.preventDefault();
	});
	*/
	//$.nonbounce();
});


jQuery.extend({
    handleError: function( s, xhr, status, e ) {
        // If a local callback was specified, fire it
        if ( s.error )
            s.error( xhr, status, e );
        // If we have some XML response text (e.g. from an AJAX call) then log it in the console
        else if(xhr.responseText) {
            //console.log(xhr.responseText);
        }
    }
});