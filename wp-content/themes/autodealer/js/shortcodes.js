/* =Custom JS
-------------------------------------------------------------- */

jQuery(document).ready(function() {
        "use strict";

        // init Fullwidth row
        jQuery('.tdp_row_fullwidth').each(function(){
            var $this = jQuery(this);
            var $wrapper = jQuery('#theme-wrapper');

            $this.css({
                'width' : $wrapper.width(),
                'max-width': $wrapper.width(),
                'left': ($this.width()-$wrapper.width())/2+'px',
                'visibility': 'visible'
            });
            
            jQuery(window).resize(function(){
                var $resize_wrapper = jQuery('#theme-wrapper');
                $this.css({
                    'width' : $resize_wrapper.width(),
                    'max-width': $resize_wrapper.width(),
                    'left': ($this.find('>.wrapper').width()-$resize_wrapper.width())/2+'px',
                    'visibility': 'visible'
                });
            });

            
            if( $this.hasClass('row_video_wrapper') ){
                $this.find('.row_video video').width( jQuery(window).width() );
                $this.find('.row_video video').height( parseInt( jQuery(window).width()/1.777 ) );
                $this.find('.row_video video').mediaelementplayer();
            }

        });

        //Toggle
        jQuery(".tt_toggle").not(".tt_toggle_open").find(".tt_toggle_inner").hide();
        jQuery(".tt_toggle").each( function () {
            var $this=jQuery(this);
            $this.find('.tt_toggle_title').click(function(e){
                e.preventDefault();
                $this.toggleClass('tt_toggle_open');
                if($this.hasClass('tt_toggle_open')){
                    $this.find('.tt_icon').addClass('icon-minus').removeClass('icon-plus');
                    $this.find('.tt_toggle_inner').stop().slideDown('fast');
                }else{
                    $this.find('.tt_icon').addClass('icon-plus').removeClass('icon-minus');
                    $this.find('.tt_toggle_inner').stop().slideUp('fast');
                }
            });
        });
         
         
        //Accordion
        jQuery(".tt_accordion").each(function(){
            jQuery(this).find(".accordion_title").not(".current").next(".accordion_content").hide(); var $self = jQuery(this);
            jQuery(this).find('.accordion_title').click(function(e){
                e.preventDefault();
                $self.find('.accordion_title').not(this).removeClass('current');
                jQuery(this).toggleClass('current');
                $self.find('.accordion_title').each(function(){
                    if(jQuery(this).hasClass('current')){
                        jQuery(this).find('.tt_icon').addClass('icon-minus').removeClass('icon-plus');
                        jQuery(this).next('.accordion_content').slideDown('fast');
                    }else{
                        jQuery(this).find('.tt_icon').removeClass('icon-plus').addClass('icon-minus'); jQuery(this).next('.accordion_content').slideUp('fast'); }
                });
            });
        });

        // JPlayer Audio
        jQuery('.tdp_elem_audio .tdp-jplayer-audio').each(function(){
            jQuery(this).jPlayer({
                ready: function () {
                    jQuery(this).jPlayer("setMedia", {
                        mp3: jQuery(this).attr('src')
                    });
                },
                play: function(){
                    jQuery('.tdp_elem_audio .tdp-jplayer-audio').not(this).jPlayer("pause");
                },
                wmode:"window",
                swfPath: "",
                cssSelectorAncestor: "#jp_interface_"+jQuery(this).attr('pid'),
                supplied: "mp3"
            });
        });

        // JPlayer Video
        jQuery('.tdp_elem_video .tdp-jplayer-video').each(function(){
            var $this = jQuery(this);
            $this.jPlayer({
                ready: function () {
                    if( jQuery(this).attr('ext') == 'flv' ){
                        jQuery(this).jPlayer("setMedia", {
                            flv: jQuery(this).attr('src'),
                            poster: jQuery(this).attr('poster')
                        });
                    }
                    else if( jQuery(this).attr('ext') == 'mp4' ){
                        jQuery(this).jPlayer("setMedia", {
                            mp4: jQuery(this).attr('src'),
                            poster: jQuery(this).attr('poster')
                        });
                    }
                    else if( jQuery(this).attr('ext') == 'm4v' ){
                        jQuery(this).jPlayer("setMedia", {
                            m4v: jQuery(this).attr('src'),
                            poster: jQuery(this).attr('poster')
                        });
                    }
                    else if( jQuery(this).attr('ext') == 'ogv' ){
                        jQuery(this).jPlayer("setMedia", {
                            ogv: jQuery(this).attr('src'),
                            poster: jQuery(this).attr('poster')
                        });
                    }
                    else if( jQuery(this).attr('ext') == 'webmv' ){
                        jQuery(this).jPlayer("setMedia", {
                            webmv: jQuery(this).attr('src'),
                            poster: jQuery(this).attr('poster')
                        });
                    }
                    else if( jQuery(this).attr('ext') == 'webm' ){
                        jQuery(this).jPlayer("setMedia", {
                            webmv: jQuery(this).attr('src'),
                            poster: jQuery(this).attr('poster')
                        });
                    }
                    else if( jQuery(this).attr('ext') == 'ogg' ){
                        jQuery(this).jPlayer("setMedia", {
                            ogg: jQuery(this).attr('src'),
                            poster: jQuery(this).attr('poster')
                        });
                    }

                    jQuery(this).find('.fluid-width-video-wrapper').attr('style', '');
                },
                play: function(){
                    jQuery('.tdp_elem_video .tdp-jplayer-video').not(this).jPlayer("pause");
                },
                wmode:"window",
                swfPath: tdp_plugin_path+"/js/jplayer/",
                solution: "html, flash",
                cssSelectorAncestor: "#jp_interface_"+jQuery(this).attr('pid'),
                supplied: ( jQuery(this).attr('ext')=='webm' ? 'webmv' : jQuery(this).attr('ext') ),
                preload: "metadata",
                size: {
                    width: $this.width(),
                    height: parseInt( $this.width()*360/640 )
                }
            });
        });


        //gallery 


        jQuery('.tdp_gallery').each(function(){
            var $this = jQuery(this);
            
            if( $this.hasClass('gallery_layout2') ){
                
                var $cloned =  $this.find('.gallery_thumbs a').eq(0).clone();
                $cloned.attr('rel', '');
                $cloned.find('img').attr('src', $cloned.attr('data-preview'));
                $this.find('.gallery_preview .preview_panel').html( $cloned );
                
                $this.find('.gallery_preview').find('a').unbind('click').click(function(){
                    $this.find('.gallery_thumbs a').eq(0).trigger('click');
                    return false;
                });
                
                $this.find('.gallery_thumbs a').hover(
                    function(){
                        var $cloned_item =  jQuery(this).clone();
                        $cloned_item.attr('rel', '');
                        $cloned_item.find('img').attr('src', $cloned_item.attr('data-preview'))
                        $this.find('.gallery_preview .preview_panel').html( $cloned_item );
                        
                        var selected_index = $this.find('.gallery_thumbs a').index( jQuery(this) );
                        $this.find('.gallery_preview').find('a').unbind('click')
                            .click(function(){
                                $this.find('.gallery_thumbs a').eq(selected_index).trigger('click');
                                return false;
                            });
                    },
                    function(){
                        
                    }
                );
            }
            else if( $this.hasClass('gallery_imac') || $this.hasClass('gallery_laptop') || $this.hasClass('gallery_iphone') ){
                if( $this.find('.gallery_viewport > div').length<2 ){
                    $this.find('.gallery_prev,.gallery_next').hide();
                }
                $this.find('.gallery_viewport').cycle({
                    slides: '>div',
                    prev: $this.find('.gallery_prev'),
                    next: $this.find('.gallery_next'),
                    swipe: true
                });
            }
            else if( $this.hasClass('gallery_layout_slider') ){
                $this.find('.gallery_preview').cycle({
                    pager: $this.find('.gallery_pager'),
                    swipe: true
                });
            }
            else{
                
            }
        });

        jQuery('.tdp_elem_progress').waypoint(
            function(direction){
                var $active = jQuery(this);
                if( direction==='down' ){
                    $active.find('.tdp_progress_line').show();
                    $active.find('.tdp_progress_vline').show();
                }
                else{
                    $active.find('.tdp_progress_line').hide();
                    $active.find('.tdp_progress_vline').hide();
                }
            },
            {
                offset: function(){
                    return jQuery.waypoints('viewportHeight')+100;
                }
            }
        );

        // Tabs
    //When page loads...
    jQuery('.tabs-wrapper').each(function() {
        jQuery(this).find(".tab_content").hide(); //Hide all content
        if(document.location.hash && jQuery(this).find("ul.tabs li a[href='"+document.location.hash+"']").length >= 1) {
            jQuery(this).find("ul.tabs li a[href='"+document.location.hash+"']").parent().addClass("active").show(); //Activate first tab
            jQuery(this).find(document.location.hash+".tab_content").show(); //Show first tab content
        } else {
            jQuery(this).find("ul.tabs li:first").addClass("active").show(); //Activate first tab
            jQuery(this).find(".tab_content:first").show(); //Show first tab content
        }
    });
    
    //On Click Event
    jQuery("ul.tabs li").click(function(e) {
        jQuery(this).parents('.tabs-wrapper').find("ul.tabs li").removeClass("active"); //Remove any "active" class
        jQuery(this).addClass("active"); //Add "active" class to selected tab
        jQuery(this).parents('.tabs-wrapper').find(".tab_content").hide(); //Hide all tab content

        var activeTab = jQuery(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
        jQuery(this).parents('.tabs-wrapper').find(activeTab).fadeIn(); //Fade in the active ID content

        jQuery(this).parents('.tabs-wrapper').find(activeTab).find('.content-boxes').each(function() {
            var cols = jQuery(this).find('.col').length;
            jQuery(this).addClass('columns-'+cols);
        });

        jQuery(this).parents('.tabs-wrapper').find(activeTab).find('.columns-3 .col:nth-child(3n), .columns-4 .col:nth-child(4n)').css('margin-right', '0px');
    
        jQuery(this).parents('.tabs-wrapper').find(activeTab).find('.portfolio-wrapper').isotope('reLayout');
    
        jQuery(this).parents('.tabs-wrapper').find(activeTab).find('.content-boxes-icon-boxed').each(function() {
            //console.log(jQuery(this).find('.col'));
            jQuery(this).find('.col').equalHeights();
        });

        e.preventDefault();
    });
    
    jQuery("ul.tabs li a").click(function(e) {
        e.preventDefault();
    })

    jQuery('.project-content .tabs-horizontal .tabset,.post-content .tabs-horizontal .tabset').each(function() {
        var menuWidth = jQuery(this).width();
        var menuItems = jQuery(this).find('li').size();
        var menuItemsExcludingLast = jQuery(this).find('li:not(:last)');
        var menuItemsExcludingLastSize = jQuery(this).find('li:not(:last)').size();

        if(menuItems%2 == 0) {
            var itemWidth = Math.ceil(menuWidth/menuItems)-2;
        } else {
            var itemWidth = Math.ceil(menuWidth/menuItems)-1;
        }

        jQuery(this).css({'width': menuWidth +'px'});
        jQuery(this).find('li').css({'width': itemWidth +'px'});

        /*if(jQuery('body').hasClass('dark')) {
            var menuItemsExcludingLastWidth = ((menuItemsExcludingLast.width() + 1) * menuItemsExcludingLastSize);
        } else {*/
            var menuItemsExcludingLastWidth = ((menuItemsExcludingLast.width() + 1) * menuItemsExcludingLastSize);
        //}
        var lastItemSize = menuWidth - menuItemsExcludingLastWidth;

        jQuery(this).find('li:last').css({'width': lastItemSize +'px'}).addClass('no-border-right');
    });

});

jQuery(window).load(function() {
    jQuery('.progress-bar').each(function() {
        var percentage = jQuery(this).find('.progress-bar-content').data('percentage');
        jQuery(this).find('.progress-bar-content').css('width', '0%');
        jQuery(this).find('.progress-bar-content').animate({
            width: percentage+'%'
        }, 'slow');
    });

    if(jQuery().waypoint) {
        jQuery('#progress-bars').waypoint(function() {
            jQuery('.progress-bar').each(function() {
                var percentage = jQuery(this).find('.progress-bar-content').data('percentage');
                jQuery(this).find('.progress-bar-content').css('width', '0%');
                jQuery(this).find('.progress-bar-content').animate({
                    width: percentage+'%'
                }, 'slow');
            });
        }, {
            triggerOnce: true,
            offset: '100%'
        });
    }

    jQuery('.display-percentage').each(function() {
        var percentage = jQuery(this).data('percentage');
        jQuery(this).countTo({from: 0, to: percentage, speed: 900});
    });

    if(jQuery().waypoint) {
        jQuery('.counters-box').waypoint(function() {
            jQuery(this).find('.display-percentage').each(function() {
                var percentage = jQuery(this).data('percentage');
                jQuery(this).countTo({from: 0, to: percentage, speed: 900});
            });
        }, {
            triggerOnce: true,
            offset: '100%'
        });
    }

    jQuery('.simple-products-slider .product-buttons a').text('');

    var isMobile = {
        Android: function() {
            return navigator.userAgent.match(/Android/i);
        },
        BlackBerry: function() {
            return navigator.userAgent.match(/BlackBerry/i);
        },
        iOS: function() {
            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
        },
        Opera: function() {
            return navigator.userAgent.match(/Opera Mini/i);
        },
        Windows: function() {
            return navigator.userAgent.match(/IEMobile/i);
        },
        any: function() {
            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
        }
    };

    if(jQuery().waypoint || !isMobile.any() ) {
        jQuery('.animated').waypoint(function() {
        
            jQuery(this).css('visibility', 'visible');

            // this code is executed for each appeared element
            var animation_type = jQuery(this).attr('animation_type');
            var animation_duration = jQuery(this).attr('animation_duration');

            jQuery(this).addClass('animated '+animation_type);

            if(animation_duration) {
                jQuery(this).css('-moz-animation-duration', animation_duration+'s');
                jQuery(this).css('-webkit-animation-duration', animation_duration+'s');
                jQuery(this).css('-ms-animation-duration', animation_duration+'s');
                jQuery(this).css('-o-animation-duration', animation_duration+'s');
                jQuery(this).css('animation-duration', animation_duration+'s');
            }
    },{ triggerOnce: true, offset: 'bottom-in-view' });
    }

    var width = jQuery(window).width();
    if (width <= 1023) {
         jQuery('.animated').removeAttr( "animation_type" );
    } 

    if( isMobile.any() ) {

       

    }

});

/**
 * jQuery goMap
 *
 * @url     http://www.pittss.lv/jquery/gomap/
 * @author  Jevgenijs Shtrauss <pittss@gmail.com>
 * @version 1.3.2 2011.07.01
 * This software is released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 */
 (function(e){function n(e){this.setMap(e)}var t=new google.maps.Geocoder;n.prototype=new google.maps.OverlayView;n.prototype.onAdd=function(){};n.prototype.onRemove=function(){};n.prototype.draw=function(){};e.goMap={};e.fn.goMap=function(t){return this.each(function(){var n=e(this).data("goMap");if(!n){var r=e.extend(!0,{},e.goMapBase);e(this).data("goMap",r.init(this,t));e.goMap=r}else e.goMap=n})};e.goMapBase={defaults:{address:"",latitude:56.9,longitude:24.1,zoom:4,delay:200,hideByClick:!0,oneInfoWindow:!0,prefixId:"gomarker",polyId:"gopoly",groupId:"gogroup",navigationControl:!0,navigationControlOptions:{position:"TOP_LEFT",style:"DEFAULT"},mapTypeControl:!0,mapTypeControlOptions:{position:"TOP_RIGHT",style:"DEFAULT"},scaleControl:!1,scrollwheel:!0,directions:!1,directionsResult:null,disableDoubleClickZoom:!1,streetViewControl:!1,markers:[],overlays:[],polyline:{color:"#FF0000",opacity:1,weight:2},polygon:{color:"#FF0000",opacity:1,weight:2,fillColor:"#FF0000",fillOpacity:.2},circle:{color:"#FF0000",opacity:1,weight:2,fillColor:"#FF0000",fillOpacity:.2},rectangle:{color:"#FF0000",opacity:1,weight:2,fillColor:"#FF0000",fillOpacity:.2},maptype:"HYBRID",html_prepend:"<div class=gomapMarker>",html_append:"</div>",addMarker:!1},map:null,count:0,markers:[],polylines:[],polygons:[],circles:[],rectangles:[],tmpMarkers:[],geoMarkers:[],lockGeocode:!1,bounds:null,overlays:null,overlay:null,mapId:null,plId:null,pgId:null,cId:null,rId:null,opts:null,centerLatLng:null,init:function(t,r){var i=e.extend(!0,{},e.goMapBase.defaults,r);this.mapId=e(t);this.opts=i;i.address?this.geocode({address:i.address,center:!0}):e.isArray(i.markers)&&i.markers.length>0?i.markers[0].address?this.geocode({address:i.markers[0].address,center:!0}):this.centerLatLng=new google.maps.LatLng(i.markers[0].latitude,i.markers[0].longitude):this.centerLatLng=new google.maps.LatLng(i.latitude,i.longitude);var s={center:this.centerLatLng,disableDoubleClickZoom:i.disableDoubleClickZoom,mapTypeControl:i.mapTypeControl,streetViewControl:i.streetViewControl,mapTypeControlOptions:{position:google.maps.ControlPosition[i.mapTypeControlOptions.position.toUpperCase()],style:google.maps.MapTypeControlStyle[i.mapTypeControlOptions.style.toUpperCase()]},mapTypeId:google.maps.MapTypeId[i.maptype.toUpperCase()],navigationControl:i.navigationControl,navigationControlOptions:{position:google.maps.ControlPosition[i.navigationControlOptions.position.toUpperCase()],style:google.maps.NavigationControlStyle[i.navigationControlOptions.style.toUpperCase()]},scaleControl:i.scaleControl,scrollwheel:i.scrollwheel,zoom:i.zoom,zoomControl:i.navigationControl,panControl:i.navigationControl};this.map=new google.maps.Map(t,s);this.overlay=new n(this.map);this.overlays={polyline:{id:"plId",array:"polylines",create:"createPolyline"},polygon:{id:"pgId",array:"polygons",create:"createPolygon"},circle:{id:"cId",array:"circles",create:"createCircle"},rectangle:{id:"rId",array:"rectangles",create:"createRectangle"}};this.plId=e('<div style="display:none;"/>').appendTo(this.mapId);this.pgId=e('<div style="display:none;"/>').appendTo(this.mapId);this.cId=e('<div style="display:none;"/>').appendTo(this.mapId);this.rId=e('<div style="display:none;"/>').appendTo(this.mapId);for(var o=0,u=i.markers.length;o<u;o++)this.createMarker(i.markers[o]);for(var o=0,u=i.overlays.length;o<u;o++)this[this.overlays[i.overlays[o].type].create](i.overlays[o]);var a=this;i.addMarker==1||i.addMarker=="multi"?google.maps.event.addListener(a.map,"click",function(e){var t={position:e.latLng,draggable:!0},n=a.createMarker(t);google.maps.event.addListener(n,"dblclick",function(e){n.setMap(null);a.removeMarker(n.id)})}):i.addMarker=="single"&&google.maps.event.addListener(a.map,"click",function(e){if(!a.singleMarker){var t={position:e.latLng,draggable:!0},n=a.createMarker(t);a.singleMarker=!0;google.maps.event.addListener(n,"dblclick",function(e){n.setMap(null);a.removeMarker(n.id);a.singleMarker=!1})}});delete i.markers;delete i.overlays;return this},ready:function(e){google.maps.event.addListenerOnce(this.map,"bounds_changed",function(){return e()})},geocode:function(e,n){var r=this;setTimeout(function(){t.geocode({address:e.address},function(t,i){i==google.maps.GeocoderStatus.OK&&e.center&&r.map.setCenter(t[0].geometry.location);if(i==google.maps.GeocoderStatus.OK&&n&&n.markerId)n.markerId.setPosition(t[0].geometry.location);else if(i==google.maps.GeocoderStatus.OK&&n){if(r.lockGeocode){r.lockGeocode=!1;n.position=t[0].geometry.location;n.geocode=!0;r.createMarker(n)}}else i==google.maps.GeocoderStatus.OVER_QUERY_LIMIT&&r.geocode(e,n)})},this.opts.delay)},geoMarker:function(){if(this.geoMarkers.length>0&&!this.lockGeocode){this.lockGeocode=!0;var e=this.geoMarkers.splice(0,1);this.geocode({address:e[0].address},e[0])}else if(this.lockGeocode){var t=this;setTimeout(function(){t.geoMarker()},this.opts.delay)}},setMap:function(e){delete e.mapTypeId;if(e.address){this.geocode({address:e.address,center:!0});delete e.address}else if(e.latitude&&e.longitude){e.center=new google.maps.LatLng(e.latitude,e.longitude);delete e.longitude;delete e.latitude}e.mapTypeControlOptions&&e.mapTypeControlOptions.position&&(e.mapTypeControlOptions.position=google.maps.ControlPosition[e.mapTypeControlOptions.position.toUpperCase()]);e.mapTypeControlOptions&&e.mapTypeControlOptions.style&&(e.mapTypeControlOptions.style=google.maps.MapTypeControlStyle[e.mapTypeControlOptions.style.toUpperCase()]);e.navigationControlOptions&&e.navigationControlOptions.position&&(e.navigationControlOptions.position=google.maps.ControlPosition[e.navigationControlOptions.position.toUpperCase()]);e.navigationControlOptions&&e.navigationControlOptions.style&&(e.navigationControlOptions.style=google.maps.NavigationControlStyle[e.navigationControlOptions.style.toUpperCase()]);this.map.setOptions(e)},getMap:function(){return this.map},createListener:function(t,n,r){var i;typeof t!="object"&&(t={type:t});t.type=="map"?i=this.map:t.type=="marker"&&t.marker?i=e(this.mapId).data(t.marker):t.type=="info"&&t.marker&&(i=e(this.mapId).data(t.marker+"info"));if(i)return google.maps.event.addListener(i,n,r);if((t.type=="marker"||t.type=="info")&&this.getMarkerCount()!=this.getTmpMarkerCount())var s=this;setTimeout(function(){s.createListener(t,n,r)},this.opts.delay)},removeListener:function(e){google.maps.event.removeListener(e)},setInfoWindow:function(t,n){var r=this;n.content=r.opts.html_prepend+n.content+r.opts.html_append;var i=new google.maps.InfoWindow(n);i.show=!1;e(r.mapId).data(t.id+"info",i);if(n.popup){r.openWindow(i,t,n);i.show=!0}google.maps.event.addListener(t,"click",function(){if(i.show&&r.opts.hideByClick){i.close();i.show=!1}else{r.openWindow(i,t,n);i.show=!0}})},openWindow:function(t,n,r){this.opts.oneInfoWindow&&this.clearInfo();if(r.ajax){t.open(this.map,n);e.ajax({url:r.ajax,success:function(e){t.setContent(e)}})}else if(r.id){t.setContent(e(r.id).html());t.open(this.map,n)}else t.open(this.map,n)},setInfo:function(t,n){var r=e(this.mapId).data(t+"info");typeof n=="object"?r.setOptions(n):r.setContent(n)},getInfo:function(t,n){var r=e(this.mapId).data(t+"info").getContent();return n?e(r).html():r},clearInfo:function(){for(var t=0,n=this.markers.length;t<n;t++){var r=e(this.mapId).data(this.markers[t]+"info");if(r){r.close();r.show=!1}}},fitBounds:function(t,n){var r=this;if(this.getMarkerCount()!=this.getTmpMarkerCount())setTimeout(function(){r.fitBounds(t,n)},this.opts.delay);else{this.bounds=new google.maps.LatLngBounds;if(!t||t&&t=="all")for(var i=0,s=this.markers.length;i<s;i++)this.bounds.extend(e(this.mapId).data(this.markers[i]).position);else if(t&&t=="visible")for(var i=0,s=this.markers.length;i<s;i++)this.getVisibleMarker(this.markers[i])&&this.bounds.extend(e(this.mapId).data(this.markers[i]).position);else if(t&&t=="markers"&&e.isArray(n))for(var i=0,s=n.length;i<s;i++)this.bounds.extend(e(this.mapId).data(n[i]).position);this.map.fitBounds(this.bounds)}},getBounds:function(){return this.map.getBounds()},createPolyline:function(e){e.type="polyline";return this.createOverlay(e)},createPolygon:function(e){e.type="polygon";return this.createOverlay(e)},createCircle:function(e){e.type="circle";return this.createOverlay(e)},createRectangle:function(e){e.type="rectangle";return this.createOverlay(e)},createOverlay:function(e){var t=[];if(!e.id){this.count++;e.id=this.opts.polyId+this.count}switch(e.type){case"polyline":if(!(e.coords.length>0))return!1;for(var n=0,r=e.coords.length;n<r;n++)t.push(new google.maps.LatLng(e.coords[n].latitude,e.coords[n].longitude));t=new google.maps.Polyline({map:this.map,path:t,strokeColor:e.color?e.color:this.opts.polyline.color,strokeOpacity:e.opacity?e.opacity:this.opts.polyline.opacity,strokeWeight:e.weight?e.weight:this.opts.polyline.weight});break;case"polygon":if(!(e.coords.length>0))return!1;for(var n=0,r=e.coords.length;n<r;n++)t.push(new google.maps.LatLng(e.coords[n].latitude,e.coords[n].longitude));t=new google.maps.Polygon({map:this.map,path:t,strokeColor:e.color?e.color:this.opts.polygon.color,strokeOpacity:e.opacity?e.opacity:this.opts.polygon.opacity,strokeWeight:e.weight?e.weight:this.opts.polygon.weight,fillColor:e.fillColor?e.fillColor:this.opts.polygon.fillColor,fillOpacity:e.fillOpacity?e.fillOpacity:this.opts.polygon.fillOpacity});break;case"circle":t=new google.maps.Circle({map:this.map,center:new google.maps.LatLng(e.latitude,e.longitude),radius:e.radius,strokeColor:e.color?e.color:this.opts.circle.color,strokeOpacity:e.opacity?e.opacity:this.opts.circle.opacity,strokeWeight:e.weight?e.weight:this.opts.circle.weight,fillColor:e.fillColor?e.fillColor:this.opts.circle.fillColor,fillOpacity:e.fillOpacity?e.fillOpacity:this.opts.circle.fillOpacity});break;case"rectangle":t=new google.maps.Rectangle({map:this.map,bounds:new google.maps.LatLngBounds(new google.maps.LatLng(e.sw.latitude,e.sw.longitude),new google.maps.LatLng(e.ne.latitude,e.ne.longitude)),strokeColor:e.color?e.color:this.opts.circle.color,strokeOpacity:e.opacity?e.opacity:this.opts.circle.opacity,strokeWeight:e.weight?e.weight:this.opts.circle.weight,fillColor:e.fillColor?e.fillColor:this.opts.circle.fillColor,fillOpacity:e.fillOpacity?e.fillOpacity:this.opts.circle.fillOpacity});break;default:return!1}this.addOverlay(e,t);return t},addOverlay:function(t,n){e(this[this.overlays[t.type].id]).data(t.id,n);this[this.overlays[t.type].array].push(t.id)},setOverlay:function(t,n,r){n=e(this[this.overlays[t].id]).data(n);if(r.coords&&r.coords.length>0){var i=[];for(var s=0,o=r.coords.length;s<o;s++)i.push(new google.maps.LatLng(r.coords[s].latitude,r.coords[s].longitude));r.path=i;delete r.coords}else if(r.ne&&r.sw){r.bounds=new google.maps.LatLngBounds(new google.maps.LatLng(r.sw.latitude,r.sw.longitude),new google.maps.LatLng(r.ne.latitude,r.ne.longitude));delete r.ne;delete r.sw}else if(r.latitude&&r.longitude){r.center=new google.maps.LatLng(r.latitude,r.longitude);delete r.latitude;delete r.longitude}n.setOptions(r)},showHideOverlay:function(t,n,r){typeof r=="undefined"&&(this.getVisibleOverlay(t,n)?r=!1:r=!0);r?e(this[this.overlays[t].id]).data(n).setMap(this.map):e(this[this.overlays[t].id]).data(n).setMap(null)},getVisibleOverlay:function(t,n){return e(this[this.overlays[t].id]).data(n).getMap()?!0:!1},getOverlaysCount:function(e){return this[this.overlays[e].array].length},removeOverlay:function(t,n){var r=e.inArray(n,this[this.overlays[t].array]),i;if(r>-1){i=this[this.overlays[t].array].splice(r,1);var s=i[0];e(this[this.overlays[t].id]).data(s).setMap(null);e(this[this.overlays[t].id]).removeData(s);return!0}return!1},clearOverlays:function(t){for(var n=0,r=this[this.overlays[t].array].length;n<r;n++){var i=this[this.overlays[t].array][n];e(this[this.overlays[t].id]).data(i).setMap(null);e(this[this.overlays[t].id]).removeData(i)}this[this.overlays[t].array]=[]},showHideMarker:function(t,n){if(typeof n=="undefined")if(this.getVisibleMarker(t)){e(this.mapId).data(t).setVisible(!1);var r=e(this.mapId).data(t+"info");if(r&&r.show){r.close();r.show=!1}}else e(this.mapId).data(t).setVisible(!0);else e(this.mapId).data(t).setVisible(n)},showHideMarkerByGroup:function(t,n){for(var r=0,i=this.markers.length;r<i;r++){var s=this.markers[r],o=e(this.mapId).data(s);if(o.group==t)if(typeof n=="undefined")if(this.getVisibleMarker(s)){o.setVisible(!1);var u=e(this.mapId).data(s+"info");if(u&&u.show){u.close();u.show=!1}}else o.setVisible(!0);else o.setVisible(n)}},getVisibleMarker:function(t){return e(this.mapId).data(t).getVisible()},getMarkerCount:function(){return this.markers.length},getTmpMarkerCount:function(){return this.tmpMarkers.length},getVisibleMarkerCount:function(){return this.getMarkers("visiblesInMap").length},getMarkerByGroupCount:function(e){return this.getMarkers("group",e).length},getMarkers:function(t,n){var r=[];switch(t){case"json":for(var i=0,s=this.markers.length;i<s;i++){var o="'"+i+"': '"+e(this.mapId).data(this.markers[i]).getPosition().toUrlValue()+"'";r.push(o)}r="{'markers':{"+r.join(",")+"}}";break;case"data":for(var i=0,s=this.markers.length;i<s;i++){var o="marker["+i+"]="+e(this.mapId).data(this.markers[i]).getPosition().toUrlValue();r.push(o)}r=r.join("&");break;case"visiblesInBounds":for(var i=0,s=this.markers.length;i<s;i++)this.isVisible(e(this.mapId).data(this.markers[i]).getPosition())&&r.push(this.markers[i]);break;case"visiblesInMap":for(var i=0,s=this.markers.length;i<s;i++)this.getVisibleMarker(this.markers[i])&&r.push(this.markers[i]);break;case"group":if(n)for(var i=0,s=this.markers.length;i<s;i++)e(this.mapId).data(this.markers[i]).group==n&&r.push(this.markers[i]);break;case"markers":for(var i=0,s=this.markers.length;i<s;i++){var o=e(this.mapId).data(this.markers[i]);r.push(o)}break;default:for(var i=0,s=this.markers.length;i<s;i++){var o=e(this.mapId).data(this.markers[i]).getPosition().toUrlValue();r.push(o)}}return r},getVisibleMarkers:function(){return this.getMarkers("visiblesInBounds")},createMarker:function(e){if(!e.geocode){this.count++;e.id||(e.id=this.opts.prefixId+this.count);this.tmpMarkers.push(e.id)}if(e.address&&!e.geocode){this.geoMarkers.push(e);this.geoMarker()}else if(e.latitude&&e.longitude||e.position){var t={map:this.map};t.id=e.id;t.group=e.group?e.group:this.opts.groupId;t.zIndex=e.zIndex?e.zIndex:0;t.zIndexOrg=e.zIndexOrg?e.zIndexOrg:0;e.visible==0&&(t.visible=e.visible);e.title&&(t.title=e.title);e.draggable&&(t.draggable=e.draggable);if(e.icon&&e.icon.image){t.icon=e.icon.image;e.icon.shadow&&(t.shadow=e.icon.shadow)}else if(e.icon)t.icon=e.icon;else if(this.opts.icon&&this.opts.icon.image){t.icon=this.opts.icon.image;this.opts.icon.shadow&&(t.shadow=this.opts.icon.shadow)}else this.opts.icon&&(t.icon=this.opts.icon);t.position=e.position?e.position:new google.maps.LatLng(e.latitude,e.longitude);var n=new google.maps.Marker(t);if(e.html){!e.html.content&&!e.html.ajax&&!e.html.id?e.html={content:e.html}:e.html.content||(e.html.content=null);this.setInfoWindow(n,e.html)}this.addMarker(n);return n}},addMarker:function(t){e(this.mapId).data(t.id,t);this.markers.push(t.id)},setMarker:function(t,n){var r=e(this.mapId).data(t);delete n.id;delete n.visible;if(n.icon){var i=n.icon;delete n.icon;if(i&&i=="default")if(this.opts.icon&&this.opts.icon.image){n.icon=this.opts.icon.image;this.opts.icon.shadow&&(n.shadow=this.opts.icon.shadow)}else this.opts.icon&&(n.icon=this.opts.icon);else if(i&&i.image){n.icon=i.image;i.shadow&&(n.shadow=i.shadow)}else i&&(n.icon=i)}if(n.address){this.geocode({address:n.address},{markerId:r});delete n.address;delete n.latitude;delete n.longitude;delete n.position}else if(n.latitude&&n.longitude||n.position)n.position||(n.position=new google.maps.LatLng(n.latitude,n.longitude));r.setOptions(n)},removeMarker:function(t){var n=e.inArray(t,this.markers),r;if(n>-1){this.tmpMarkers.splice(n,1);r=this.markers.splice(n,1);var i=r[0],t=e(this.mapId).data(i),s=e(this.mapId).data(i+"info");t.setVisible(!1);t.setMap(null);e(this.mapId).removeData(i);if(s){s.close();s.show=!1;e(this.mapId).removeData(i+"info")}return!0}return!1},clearMarkers:function(){for(var t=0,n=this.markers.length;t<n;t++){var r=this.markers[t],i=e(this.mapId).data(r),s=e(this.mapId).data(r+"info");i.setVisible(!1);i.setMap(null);e(this.mapId).removeData(r);if(s){s.close();s.show=!1;e(this.mapId).removeData(r+"info")}}this.singleMarker=!1;this.lockGeocode=!1;this.markers=[];this.tmpMarkers=[];this.geoMarkers=[]},isVisible:function(e){return this.map.getBounds().contains(e)}}})(jQuery);

 