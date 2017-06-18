/*
 * Dropit v1.0
 * http://dev7studios.com/dropit
 *
 * Copyright 2012, Dev7studios
 * Free to use and abuse under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 */

;(function($) {

    $.fn.dropit = function(method) {

        var methods = {

            init : function(options) {
                this.dropit.settings = $.extend({}, this.dropit.defaults, options);
                return this.each(function() {
                    var $el = $(this),
                         el = this,
                         settings = $.fn.dropit.settings;
                    
                    // Hide initial submenus     
                    $el.addClass('dropit')
                    .find('>'+ settings.triggerParentEl +':has('+ settings.submenuEl +')').addClass('dropit-trigger')
                    .find(settings.submenuEl).addClass('dropit-submenu').hide();
                    
                    // Open on click
                    $el.on(settings.action, settings.triggerParentEl +':has('+ settings.submenuEl +') > '+ settings.triggerEl +'', function(){
                        if($(this).parents(settings.triggerParentEl).hasClass('dropit-open')) return false;
                        settings.beforeHide.call(this);
                        $('.dropit-open').removeClass('dropit-open').find('.dropit-submenu').hide();
                        settings.afterHide.call(this);
                        settings.beforeShow.call(this);
                        $(this).parents(settings.triggerParentEl).addClass('dropit-open').find(settings.submenuEl).show();
                        settings.afterShow.call(this);
                        return false;
                    });
                    
                    // Close if outside click
                    $(document).on('click', function(){
                        settings.beforeHide.call(this);
                        $('.dropit-open').removeClass('dropit-open').find('.dropit-submenu').hide();
                        settings.afterHide.call(this);
                    });
                    
                    settings.afterLoad.call(this);
                });
            }
            
        }

        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error( 'Method "' +  method + '" does not exist in dropit plugin!');
        }

    }

    $.fn.dropit.defaults = {
        action: 'click', // The open action for the trigger
        submenuEl: 'ul', // The submenu element
        triggerEl: 'a', // The trigger element
        triggerParentEl: 'li', // The trigger parent element
        afterLoad: function(){}, // Triggers when plugin has loaded
        beforeShow: function(){}, // Triggers before submenu is shown
        afterShow: function(){}, // Triggers after submenu is shown
        beforeHide: function(){}, // Triggers before submenu is hidden
        afterHide: function(){} // Triggers before submenu is hidden
    }

    $.fn.dropit.settings = {}

})(jQuery);

/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright Â© 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
*/

// t: current time, b: begInnIng value, c: change In value, d: duration
jQuery.easing['jswing'] = jQuery.easing['swing'];

jQuery.extend( jQuery.easing,
{
    def: 'easeOutQuad',
    swing: function (x, t, b, c, d) {
        //alert(jQuery.easing.default);
        return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
    },
    easeInQuad: function (x, t, b, c, d) {
        return c*(t/=d)*t + b;
    },
    easeOutQuad: function (x, t, b, c, d) {
        return -c *(t/=d)*(t-2) + b;
    },
    easeInOutQuad: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t + b;
        return -c/2 * ((--t)*(t-2) - 1) + b;
    },
    easeInCubic: function (x, t, b, c, d) {
        return c*(t/=d)*t*t + b;
    },
    easeOutCubic: function (x, t, b, c, d) {
        return c*((t=t/d-1)*t*t + 1) + b;
    },
    easeInOutCubic: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t*t + b;
        return c/2*((t-=2)*t*t + 2) + b;
    },
    easeInQuart: function (x, t, b, c, d) {
        return c*(t/=d)*t*t*t + b;
    },
    easeOutQuart: function (x, t, b, c, d) {
        return -c * ((t=t/d-1)*t*t*t - 1) + b;
    },
    easeInOutQuart: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
        return -c/2 * ((t-=2)*t*t*t - 2) + b;
    },
    easeInQuint: function (x, t, b, c, d) {
        return c*(t/=d)*t*t*t*t + b;
    },
    easeOutQuint: function (x, t, b, c, d) {
        return c*((t=t/d-1)*t*t*t*t + 1) + b;
    },
    easeInOutQuint: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
        return c/2*((t-=2)*t*t*t*t + 2) + b;
    },
    easeInSine: function (x, t, b, c, d) {
        return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
    },
    easeOutSine: function (x, t, b, c, d) {
        return c * Math.sin(t/d * (Math.PI/2)) + b;
    },
    easeInOutSine: function (x, t, b, c, d) {
        return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
    },
    easeInExpo: function (x, t, b, c, d) {
        return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
    },
    easeOutExpo: function (x, t, b, c, d) {
        return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
    },
    easeInOutExpo: function (x, t, b, c, d) {
        if (t==0) return b;
        if (t==d) return b+c;
        if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
        return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
    },
    easeInCirc: function (x, t, b, c, d) {
        return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
    },
    easeOutCirc: function (x, t, b, c, d) {
        return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
    },
    easeInOutCirc: function (x, t, b, c, d) {
        if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
        return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
    },
    easeInElastic: function (x, t, b, c, d) {
        var s=1.70158;var p=0;var a=c;
        if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
        if (a < Math.abs(c)) { a=c; var s=p/4; }
        else var s = p/(2*Math.PI) * Math.asin (c/a);
        return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
    },
    easeOutElastic: function (x, t, b, c, d) {
        var s=1.70158;var p=0;var a=c;
        if (t==0) return b;  if ((t/=d)==1) return b+c;  if (!p) p=d*.3;
        if (a < Math.abs(c)) { a=c; var s=p/4; }
        else var s = p/(2*Math.PI) * Math.asin (c/a);
        return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
    },
    easeInOutElastic: function (x, t, b, c, d) {
        var s=1.70158;var p=0;var a=c;
        if (t==0) return b;  if ((t/=d/2)==2) return b+c;  if (!p) p=d*(.3*1.5);
        if (a < Math.abs(c)) { a=c; var s=p/4; }
        else var s = p/(2*Math.PI) * Math.asin (c/a);
        if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
        return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
    },
    easeInBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        return c*(t/=d)*t*((s+1)*t - s) + b;
    },
    easeOutBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158;
        return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
    },
    easeInOutBack: function (x, t, b, c, d, s) {
        if (s == undefined) s = 1.70158; 
        if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
        return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
    },
    easeInBounce: function (x, t, b, c, d) {
        return c - jQuery.easing.easeOutBounce (x, d-t, 0, c, d) + b;
    },
    easeOutBounce: function (x, t, b, c, d) {
        if ((t/=d) < (1/2.75)) {
            return c*(7.5625*t*t) + b;
        } else if (t < (2/2.75)) {
            return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
        } else if (t < (2.5/2.75)) {
            return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
        } else {
            return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
        }
    },
    easeInOutBounce: function (x, t, b, c, d) {
        if (t < d/2) return jQuery.easing.easeInBounce (x, t*2, 0, c, d) * .5 + b;
        return jQuery.easing.easeOutBounce (x, t*2-d, 0, c, d) * .5 + c*.5 + b;
    }
});

/*
 *
 * TERMS OF USE - EASING EQUATIONS
 * 
 * Open source under the BSD License. 
 * 
 * Copyright Â© 2001 Robert Penner
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
 */

/*!
 * hoverIntent r7 // 2013.03.11 // jQuery 1.9.1+
 * http://cherne.net/brian/resources/jquery.hoverIntent.html
 *
 * You may use hoverIntent under the terms of the MIT license.
 * Copyright 2007, 2013 Brian Cherne
 */
(function(e){e.fn.hoverIntent=function(t,n,r){var i={interval:100,sensitivity:7,timeout:0};if(typeof t==="object"){i=e.extend(i,t)}else if(e.isFunction(n)){i=e.extend(i,{over:t,out:n,selector:r})}else{i=e.extend(i,{over:t,out:t,selector:n})}var s,o,u,a;var f=function(e){s=e.pageX;o=e.pageY};var l=function(t,n){n.hoverIntent_t=clearTimeout(n.hoverIntent_t);if(Math.abs(u-s)+Math.abs(a-o)<i.sensitivity){e(n).off("mousemove.hoverIntent",f);n.hoverIntent_s=1;return i.over.apply(n,[t])}else{u=s;a=o;n.hoverIntent_t=setTimeout(function(){l(t,n)},i.interval)}};var c=function(e,t){t.hoverIntent_t=clearTimeout(t.hoverIntent_t);t.hoverIntent_s=0;return i.out.apply(t,[e])};var h=function(t){var n=jQuery.extend({},t);var r=this;if(r.hoverIntent_t){r.hoverIntent_t=clearTimeout(r.hoverIntent_t)}if(t.type=="mouseenter"){u=n.pageX;a=n.pageY;e(r).on("mousemove.hoverIntent",f);if(r.hoverIntent_s!=1){r.hoverIntent_t=setTimeout(function(){l(n,r)},i.interval)}}else{e(r).off("mousemove.hoverIntent",f);if(r.hoverIntent_s==1){r.hoverIntent_t=setTimeout(function(){c(n,r)},i.timeout)}}};return this.on({"mouseenter.hoverIntent":h,"mouseleave.hoverIntent":h},i.selector)}})(jQuery);

// Magnific Popup v0.9.7 by Dmitry Semenov
// http://bit.ly/magnific-popup#build=inline+image+ajax+iframe+gallery+retina+imagezoom+fastclick
(function(a){var b="Close",c="BeforeClose",d="AfterClose",e="BeforeAppend",f="MarkupParse",g="Open",h="Change",i="mfp",j="."+i,k="mfp-ready",l="mfp-removing",m="mfp-prevent-close",n,o=function(){},p=!!window.jQuery,q,r=a(window),s,t,u,v,w,x=function(a,b){n.ev.on(i+a+j,b)},y=function(b,c,d,e){var f=document.createElement("div");return f.className="mfp-"+b,d&&(f.innerHTML=d),e?c&&c.appendChild(f):(f=a(f),c&&f.appendTo(c)),f},z=function(b,c){n.ev.triggerHandler(i+b,c),n.st.callbacks&&(b=b.charAt(0).toLowerCase()+b.slice(1),n.st.callbacks[b]&&n.st.callbacks[b].apply(n,a.isArray(c)?c:[c]))},A=function(){(n.st.focus?n.content.find(n.st.focus).eq(0):n.wrap).focus()},B=function(b){if(b!==w||!n.currTemplate.closeBtn)n.currTemplate.closeBtn=a(n.st.closeMarkup.replace("%title%",n.st.tClose)),w=b;return n.currTemplate.closeBtn},C=function(){a.magnificPopup.instance||(n=new o,n.init(),a.magnificPopup.instance=n)},D=function(b){if(a(b).hasClass(m))return;var c=n.st.closeOnContentClick,d=n.st.closeOnBgClick;if(c&&d)return!0;if(!n.content||a(b).hasClass("mfp-close")||n.preloader&&b===n.preloader[0])return!0;if(b!==n.content[0]&&!a.contains(n.content[0],b)){if(d&&a.contains(document,b))return!0}else if(c)return!0;return!1},E=function(){var a=document.createElement("p").style,b=["ms","O","Moz","Webkit"];if(a.transition!==undefined)return!0;while(b.length)if(b.pop()+"Transition"in a)return!0;return!1};o.prototype={constructor:o,init:function(){var b=navigator.appVersion;n.isIE7=b.indexOf("MSIE 7.")!==-1,n.isIE8=b.indexOf("MSIE 8.")!==-1,n.isLowIE=n.isIE7||n.isIE8,n.isAndroid=/android/gi.test(b),n.isIOS=/iphone|ipad|ipod/gi.test(b),n.supportsTransition=E(),n.probablyMobile=n.isAndroid||n.isIOS||/(Opera Mini)|Kindle|webOS|BlackBerry|(Opera Mobi)|(Windows Phone)|IEMobile/i.test(navigator.userAgent),s=a(document.body),t=a(document),n.popupsCache={}},open:function(b){var c;if(b.isObj===!1){n.items=b.items.toArray(),n.index=0;var d=b.items,e;for(c=0;c<d.length;c++){e=d[c],e.parsed&&(e=e.el[0]);if(e===b.el[0]){n.index=c;break}}}else n.items=a.isArray(b.items)?b.items:[b.items],n.index=b.index||0;if(n.isOpen){n.updateItemHTML();return}n.types=[],v="",b.mainEl&&b.mainEl.length?n.ev=b.mainEl.eq(0):n.ev=t,b.key?(n.popupsCache[b.key]||(n.popupsCache[b.key]={}),n.currTemplate=n.popupsCache[b.key]):n.currTemplate={},n.st=a.extend(!0,{},a.magnificPopup.defaults,b),n.fixedContentPos=n.st.fixedContentPos==="auto"?!n.probablyMobile:n.st.fixedContentPos,n.st.modal&&(n.st.closeOnContentClick=!1,n.st.closeOnBgClick=!1,n.st.showCloseBtn=!1,n.st.enableEscapeKey=!1),n.bgOverlay||(n.bgOverlay=y("bg").on("click"+j,function(){n.close()}),n.wrap=y("wrap").attr("tabindex",-1).on("click"+j,function(a){D(a.target)&&n.close()}),n.container=y("container",n.wrap)),n.contentContainer=y("content"),n.st.preloader&&(n.preloader=y("preloader",n.container,n.st.tLoading));var h=a.magnificPopup.modules;for(c=0;c<h.length;c++){var i=h[c];i=i.charAt(0).toUpperCase()+i.slice(1),n["init"+i].call(n)}z("BeforeOpen"),n.st.showCloseBtn&&(n.st.closeBtnInside?(x(f,function(a,b,c,d){c.close_replaceWith=B(d.type)}),v+=" mfp-close-btn-in"):n.wrap.append(B())),n.st.alignTop&&(v+=" mfp-align-top"),n.fixedContentPos?n.wrap.css({overflow:n.st.overflowY,overflowX:"hidden",overflowY:n.st.overflowY}):n.wrap.css({top:r.scrollTop(),position:"absolute"}),(n.st.fixedBgPos===!1||n.st.fixedBgPos==="auto"&&!n.fixedContentPos)&&n.bgOverlay.css({height:t.height(),position:"absolute"}),n.st.enableEscapeKey&&t.on("keyup"+j,function(a){a.keyCode===27&&n.close()}),r.on("resize"+j,function(){n.updateSize()}),n.st.closeOnContentClick||(v+=" mfp-auto-cursor"),v&&n.wrap.addClass(v);var l=n.wH=r.height(),m={};if(n.fixedContentPos&&n._hasScrollBar(l)){var o=n._getScrollbarSize();o&&(m.paddingRight=o)}n.fixedContentPos&&(n.isIE7?a("body, html").css("overflow","hidden"):m.overflow="hidden");var p=n.st.mainClass;return n.isIE7&&(p+=" mfp-ie7"),p&&n._addClassToMFP(p),n.updateItemHTML(),z("BuildControls"),a("html").css(m),n.bgOverlay.add(n.wrap).prependTo(document.body),n._lastFocusedEl=document.activeElement,setTimeout(function(){n.content?(n._addClassToMFP(k),A()):n.bgOverlay.addClass(k),t.on("focusin"+j,function(b){if(b.target!==n.wrap[0]&&!a.contains(n.wrap[0],b.target))return A(),!1})},16),n.isOpen=!0,n.updateSize(l),z(g),b},close:function(){if(!n.isOpen)return;z(c),n.isOpen=!1,n.st.removalDelay&&!n.isLowIE&&n.supportsTransition?(n._addClassToMFP(l),setTimeout(function(){n._close()},n.st.removalDelay)):n._close()},_close:function(){z(b);var c=l+" "+k+" ";n.bgOverlay.detach(),n.wrap.detach(),n.container.empty(),n.st.mainClass&&(c+=n.st.mainClass+" "),n._removeClassFromMFP(c);if(n.fixedContentPos){var e={paddingRight:""};n.isIE7?a("body, html").css("overflow",""):e.overflow="",a("html").css(e)}t.off("keyup"+j+" focusin"+j),n.ev.off(j),n.wrap.attr("class","mfp-wrap").removeAttr("style"),n.bgOverlay.attr("class","mfp-bg"),n.container.attr("class","mfp-container"),n.st.showCloseBtn&&(!n.st.closeBtnInside||n.currTemplate[n.currItem.type]===!0)&&n.currTemplate.closeBtn&&n.currTemplate.closeBtn.detach(),n._lastFocusedEl&&a(n._lastFocusedEl).focus(),n.currItem=null,n.content=null,n.currTemplate=null,n.prevHeight=0,z(d)},updateSize:function(a){if(n.isIOS){var b=document.documentElement.clientWidth/window.innerWidth,c=window.innerHeight*b;n.wrap.css("height",c),n.wH=c}else n.wH=a||r.height();n.fixedContentPos||n.wrap.css("height",n.wH),z("Resize")},updateItemHTML:function(){var b=n.items[n.index];n.contentContainer.detach(),n.content&&n.content.detach(),b.parsed||(b=n.parseEl(n.index));var c=b.type;z("BeforeChange",[n.currItem?n.currItem.type:"",c]),n.currItem=b;if(!n.currTemplate[c]){var d=n.st[c]?n.st[c].markup:!1;z("FirstMarkupParse",d),d?n.currTemplate[c]=a(d):n.currTemplate[c]=!0}u&&u!==b.type&&n.container.removeClass("mfp-"+u+"-holder");var e=n["get"+c.charAt(0).toUpperCase()+c.slice(1)](b,n.currTemplate[c]);n.appendContent(e,c),b.preloaded=!0,z(h,b),u=b.type,n.container.prepend(n.contentContainer),z("AfterChange")},appendContent:function(a,b){n.content=a,a?n.st.showCloseBtn&&n.st.closeBtnInside&&n.currTemplate[b]===!0?n.content.find(".mfp-close").length||n.content.append(B()):n.content=a:n.content="",z(e),n.container.addClass("mfp-"+b+"-holder"),n.contentContainer.append(n.content)},parseEl:function(b){var c=n.items[b],d=c.type;c.tagName?c={el:a(c)}:c={data:c,src:c.src};if(c.el){var e=n.types;for(var f=0;f<e.length;f++)if(c.el.hasClass("mfp-"+e[f])){d=e[f];break}c.src=c.el.attr("data-mfp-src"),c.src||(c.src=c.el.attr("href"))}return c.type=d||n.st.type||"inline",c.index=b,c.parsed=!0,n.items[b]=c,z("ElementParse",c),n.items[b]},addGroup:function(a,b){var c=function(c){c.mfpEl=this,n._openClick(c,a,b)};b||(b={});var d="click.magnificPopup";b.mainEl=a,b.items?(b.isObj=!0,a.off(d).on(d,c)):(b.isObj=!1,b.delegate?a.off(d).on(d,b.delegate,c):(b.items=a,a.off(d).on(d,c)))},_openClick:function(b,c,d){var e=d.midClick!==undefined?d.midClick:a.magnificPopup.defaults.midClick;if(!e&&(b.which===2||b.ctrlKey||b.metaKey))return;var f=d.disableOn!==undefined?d.disableOn:a.magnificPopup.defaults.disableOn;if(f)if(a.isFunction(f)){if(!f.call(n))return!0}else if(r.width()<f)return!0;b.type&&(b.preventDefault(),n.isOpen&&b.stopPropagation()),d.el=a(b.mfpEl),d.delegate&&(d.items=c.find(d.delegate)),n.open(d)},updateStatus:function(a,b){if(n.preloader){q!==a&&n.container.removeClass("mfp-s-"+q),!b&&a==="loading"&&(b=n.st.tLoading);var c={status:a,text:b};z("UpdateStatus",c),a=c.status,b=c.text,n.preloader.html(b),n.preloader.find("a").on("click",function(a){a.stopImmediatePropagation()}),n.container.addClass("mfp-s-"+a),q=a}},_addClassToMFP:function(a){n.bgOverlay.addClass(a),n.wrap.addClass(a)},_removeClassFromMFP:function(a){this.bgOverlay.removeClass(a),n.wrap.removeClass(a)},_hasScrollBar:function(a){return(n.isIE7?t.height():document.body.scrollHeight)>(a||r.height())},_parseMarkup:function(b,c,d){var e;d.data&&(c=a.extend(d.data,c)),z(f,[b,c,d]),a.each(c,function(a,c){if(c===undefined||c===!1)return!0;e=a.split("_");if(e.length>1){var d=b.find(j+"-"+e[0]);if(d.length>0){var f=e[1];f==="replaceWith"?d[0]!==c[0]&&d.replaceWith(c):f==="img"?d.is("img")?d.attr("src",c):d.replaceWith('<img src="'+c+'" class="'+d.attr("class")+'" />'):d.attr(e[1],c)}}else b.find(j+"-"+a).html(c)})},_getScrollbarSize:function(){if(n.scrollbarSize===undefined){var a=document.createElement("div");a.id="mfp-sbm",a.style.cssText="width: 99px; height: 99px; overflow: scroll; position: absolute; top: -9999px;",document.body.appendChild(a),n.scrollbarSize=a.offsetWidth-a.clientWidth,document.body.removeChild(a)}return n.scrollbarSize}},a.magnificPopup={instance:null,proto:o.prototype,modules:[],open:function(b,c){return C(),b?b=a.extend(!0,{},b):b={},b.isObj=!0,b.index=c||0,this.instance.open(b)},close:function(){return a.magnificPopup.instance&&a.magnificPopup.instance.close()},registerModule:function(b,c){c.options&&(a.magnificPopup.defaults[b]=c.options),a.extend(this.proto,c.proto),this.modules.push(b)},defaults:{disableOn:0,key:null,midClick:!1,mainClass:"",preloader:!0,focus:"",closeOnContentClick:!1,closeOnBgClick:!0,closeBtnInside:!0,showCloseBtn:!0,enableEscapeKey:!0,modal:!1,alignTop:!1,removalDelay:0,fixedContentPos:"auto",fixedBgPos:"auto",overflowY:"auto",closeMarkup:'<button title="%title%" type="button" class="mfp-close">&times;</button>',tClose:"Close (Esc)",tLoading:"Loading..."}},a.fn.magnificPopup=function(b){C();var c=a(this);if(typeof b=="string")if(b==="open"){var d,e=p?c.data("magnificPopup"):c[0].magnificPopup,f=parseInt(arguments[1],10)||0;e.items?d=e.items[f]:(d=c,e.delegate&&(d=d.find(e.delegate)),d=d.eq(f)),n._openClick({mfpEl:d},c,e)}else n.isOpen&&n[b].apply(n,Array.prototype.slice.call(arguments,1));else b=a.extend(!0,{},b),p?c.data("magnificPopup",b):c[0].magnificPopup=b,n.addGroup(c,b);return c};var F="inline",G,H,I,J=function(){I&&(H.after(I.addClass(G)).detach(),I=null)};a.magnificPopup.registerModule(F,{options:{hiddenClass:"hide",markup:"",tNotFound:"Content not found"},proto:{initInline:function(){n.types.push(F),x(b+"."+F,function(){J()})},getInline:function(b,c){J();if(b.src){var d=n.st.inline,e=a(b.src);if(e.length){var f=e[0].parentNode;f&&f.tagName&&(H||(G=d.hiddenClass,H=y(G),G="mfp-"+G),I=e.after(H).detach().removeClass(G)),n.updateStatus("ready")}else n.updateStatus("error",d.tNotFound),e=a("<div>");return b.inlineElement=e,e}return n.updateStatus("ready"),n._parseMarkup(c,{},b),c}}});var K="ajax",L,M=function(){L&&s.removeClass(L)},N=function(){M(),n.req&&n.req.abort()};a.magnificPopup.registerModule(K,{options:{settings:null,cursor:"mfp-ajax-cur",tError:'<a href="%url%">The content</a> could not be loaded.'},proto:{initAjax:function(){n.types.push(K),L=n.st.ajax.cursor,x(b+"."+K,N),x("BeforeChange."+K,N)},getAjax:function(b){L&&s.addClass(L),n.updateStatus("loading");var c=a.extend({url:b.src,success:function(c,d,e){var f={data:c,xhr:e};z("ParseAjax",f),n.appendContent(a(f.data),K),b.finished=!0,M(),A(),setTimeout(function(){n.wrap.addClass(k)},16),n.updateStatus("ready"),z("AjaxContentAdded")},error:function(){M(),b.finished=b.loadError=!0,n.updateStatus("error",n.st.ajax.tError.replace("%url%",b.src))}},n.st.ajax.settings);return n.req=a.ajax(c),""}}});var O,P=function(b){if(b.data&&b.data.title!==undefined)return b.data.title;var c=n.st.image.titleSrc;if(c){if(a.isFunction(c))return c.call(n,b);if(b.el)return b.el.attr(c)||""}return""};a.magnificPopup.registerModule("image",{options:{markup:'<div class="mfp-figure"><div class="mfp-close"></div><div class="mfp-img"></div><div class="mfp-bottom-bar"><div class="mfp-title"></div><div class="mfp-counter"></div></div></div>',cursor:"mfp-zoom-out-cur",titleSrc:"title",verticalFit:!0,tError:'<a href="%url%">The image</a> could not be loaded.'},proto:{initImage:function(){var a=n.st.image,c=".image";n.types.push("image"),x(g+c,function(){n.currItem.type==="image"&&a.cursor&&s.addClass(a.cursor)}),x(b+c,function(){a.cursor&&s.removeClass(a.cursor),r.off("resize"+j)}),x("Resize"+c,n.resizeImage),n.isLowIE&&x("AfterChange",n.resizeImage)},resizeImage:function(){var a=n.currItem;if(!a||!a.img)return;if(n.st.image.verticalFit){var b=0;n.isLowIE&&(b=parseInt(a.img.css("padding-top"),10)+parseInt(a.img.css("padding-bottom"),10)),a.img.css("max-height",n.wH-b)}},_onImageHasSize:function(a){a.img&&(a.hasSize=!0,O&&clearInterval(O),a.isCheckingImgSize=!1,z("ImageHasSize",a),a.imgHidden&&(n.content&&n.content.removeClass("mfp-loading"),a.imgHidden=!1))},findImageSize:function(a){var b=0,c=a.img[0],d=function(e){O&&clearInterval(O),O=setInterval(function(){if(c.naturalWidth>0){n._onImageHasSize(a);return}b>200&&clearInterval(O),b++,b===3?d(10):b===40?d(50):b===100&&d(500)},e)};d(1)},getImage:function(b,c){var d=0,e=function(){b&&(b.img[0].complete?(b.img.off(".mfploader"),b===n.currItem&&(n._onImageHasSize(b),n.updateStatus("ready")),b.hasSize=!0,b.loaded=!0,z("ImageLoadComplete")):(d++,d<200?setTimeout(e,100):f()))},f=function(){b&&(b.img.off(".mfploader"),b===n.currItem&&(n._onImageHasSize(b),n.updateStatus("error",g.tError.replace("%url%",b.src))),b.hasSize=!0,b.loaded=!0,b.loadError=!0)},g=n.st.image,h=c.find(".mfp-img");if(h.length){var i=document.createElement("img");i.className="mfp-img",b.img=a(i).on("load.mfploader",e).on("error.mfploader",f),i.src=b.src,h.is("img")&&(b.img=b.img.clone()),b.img[0].naturalWidth>0&&(b.hasSize=!0)}return n._parseMarkup(c,{title:P(b),img_replaceWith:b.img},b),n.resizeImage(),b.hasSize?(O&&clearInterval(O),b.loadError?(c.addClass("mfp-loading"),n.updateStatus("error",g.tError.replace("%url%",b.src))):(c.removeClass("mfp-loading"),n.updateStatus("ready")),c):(n.updateStatus("loading"),b.loading=!0,b.hasSize||(b.imgHidden=!0,c.addClass("mfp-loading"),n.findImageSize(b)),c)}}});var Q,R=function(){return Q===undefined&&(Q=document.createElement("p").style.MozTransform!==undefined),Q};a.magnificPopup.registerModule("zoom",{options:{enabled:!1,easing:"ease-in-out",duration:300,opener:function(a){return a.is("img")?a:a.find("img")}},proto:{initZoom:function(){var a=n.st.zoom,d=".zoom",e;if(!a.enabled||!n.supportsTransition)return;var f=a.duration,g=function(b){var c=b.clone().removeAttr("style").removeAttr("class").addClass("mfp-animated-image"),d="all "+a.duration/1e3+"s "+a.easing,e={position:"fixed",zIndex:9999,left:0,top:0,"-webkit-backface-visibility":"hidden"},f="transition";return e["-webkit-"+f]=e["-moz-"+f]=e["-o-"+f]=e[f]=d,c.css(e),c},h=function(){n.content.css("visibility","visible")},i,j;x("BuildControls"+d,function(){if(n._allowZoom()){clearTimeout(i),n.content.css("visibility","hidden"),e=n._getItemToZoom();if(!e){h();return}j=g(e),j.css(n._getOffset()),n.wrap.append(j),i=setTimeout(function(){j.css(n._getOffset(!0)),i=setTimeout(function(){h(),setTimeout(function(){j.remove(),e=j=null,z("ZoomAnimationEnded")},16)},f)},16)}}),x(c+d,function(){if(n._allowZoom()){clearTimeout(i),n.st.removalDelay=f;if(!e){e=n._getItemToZoom();if(!e)return;j=g(e)}j.css(n._getOffset(!0)),n.wrap.append(j),n.content.css("visibility","hidden"),setTimeout(function(){j.css(n._getOffset())},16)}}),x(b+d,function(){n._allowZoom()&&(h(),j&&j.remove(),e=null)})},_allowZoom:function(){return n.currItem.type==="image"},_getItemToZoom:function(){return n.currItem.hasSize?n.currItem.img:!1},_getOffset:function(b){var c;b?c=n.currItem.img:c=n.st.zoom.opener(n.currItem.el||n.currItem);var d=c.offset(),e=parseInt(c.css("padding-top"),10),f=parseInt(c.css("padding-bottom"),10);d.top-=a(window).scrollTop()-e;var g={width:c.width(),height:(p?c.innerHeight():c[0].offsetHeight)-f-e};return R()?g["-moz-transform"]=g.transform="translate("+d.left+"px,"+d.top+"px)":(g.left=d.left,g.top=d.top),g}}});var S="iframe",T="//about:blank",U=function(a){if(n.currTemplate[S]){var b=n.currTemplate[S].find("iframe");b.length&&(a||(b[0].src=T),n.isIE8&&b.css("display",a?"block":"none"))}};a.magnificPopup.registerModule(S,{options:{markup:'<div class="mfp-iframe-scaler"><div class="mfp-close"></div><iframe class="mfp-iframe" src="//about:blank" frameborder="0" allowfullscreen></iframe></div>',srcAction:"iframe_src",patterns:{youtube:{index:"youtube.com",id:"v=",src:"//www.youtube.com/embed/%id%?autoplay=1"},vimeo:{index:"vimeo.com/",id:"/",src:"//player.vimeo.com/video/%id%?autoplay=1"},gmaps:{index:"//maps.google.",src:"%id%&output=embed"}}},proto:{initIframe:function(){n.types.push(S),x("BeforeChange",function(a,b,c){b!==c&&(b===S?U():c===S&&U(!0))}),x(b+"."+S,function(){U()})},getIframe:function(b,c){var d=b.src,e=n.st.iframe;a.each(e.patterns,function(){if(d.indexOf(this.index)>-1)return this.id&&(typeof this.id=="string"?d=d.substr(d.lastIndexOf(this.id)+this.id.length,d.length):d=this.id.call(this,d)),d=this.src.replace("%id%",d),!1});var f={};return e.srcAction&&(f[e.srcAction]=d),n._parseMarkup(c,f,b),n.updateStatus("ready"),c}}});var V=function(a){var b=n.items.length;return a>b-1?a-b:a<0?b+a:a},W=function(a,b,c){return a.replace(/%curr%/gi,b+1).replace(/%total%/gi,c)};a.magnificPopup.registerModule("gallery",{options:{enabled:!1,arrowMarkup:'<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"></button>',preload:[0,2],navigateByImgClick:!0,arrows:!0,tPrev:"Previous (Left arrow key)",tNext:"Next (Right arrow key)",tCounter:"%curr% of %total%"},proto:{initGallery:function(){var c=n.st.gallery,d=".mfp-gallery",e=Boolean(a.fn.mfpFastClick);n.direction=!0;if(!c||!c.enabled)return!1;v+=" mfp-gallery",x(g+d,function(){c.navigateByImgClick&&n.wrap.on("click"+d,".mfp-img",function(){if(n.items.length>1)return n.next(),!1}),t.on("keydown"+d,function(a){a.keyCode===37?n.prev():a.keyCode===39&&n.next()})}),x("UpdateStatus"+d,function(a,b){b.text&&(b.text=W(b.text,n.currItem.index,n.items.length))}),x(f+d,function(a,b,d,e){var f=n.items.length;d.counter=f>1?W(c.tCounter,e.index,f):""}),x("BuildControls"+d,function(){if(n.items.length>1&&c.arrows&&!n.arrowLeft){var b=c.arrowMarkup,d=n.arrowLeft=a(b.replace(/%title%/gi,c.tPrev).replace(/%dir%/gi,"left")).addClass(m),f=n.arrowRight=a(b.replace(/%title%/gi,c.tNext).replace(/%dir%/gi,"right")).addClass(m),g=e?"mfpFastClick":"click";d[g](function(){n.prev()}),f[g](function(){n.next()}),n.isIE7&&(y("b",d[0],!1,!0),y("a",d[0],!1,!0),y("b",f[0],!1,!0),y("a",f[0],!1,!0)),n.container.append(d.add(f))}}),x(h+d,function(){n._preloadTimeout&&clearTimeout(n._preloadTimeout),n._preloadTimeout=setTimeout(function(){n.preloadNearbyImages(),n._preloadTimeout=null},16)}),x(b+d,function(){t.off(d),n.wrap.off("click"+d),n.arrowLeft&&e&&n.arrowLeft.add(n.arrowRight).destroyMfpFastClick(),n.arrowRight=n.arrowLeft=null})},next:function(){n.direction=!0,n.index=V(n.index+1),n.updateItemHTML()},prev:function(){n.direction=!1,n.index=V(n.index-1),n.updateItemHTML()},goTo:function(a){n.direction=a>=n.index,n.index=a,n.updateItemHTML()},preloadNearbyImages:function(){var a=n.st.gallery.preload,b=Math.min(a[0],n.items.length),c=Math.min(a[1],n.items.length),d;for(d=1;d<=(n.direction?c:b);d++)n._preloadItem(n.index+d);for(d=1;d<=(n.direction?b:c);d++)n._preloadItem(n.index-d)},_preloadItem:function(b){b=V(b);if(n.items[b].preloaded)return;var c=n.items[b];c.parsed||(c=n.parseEl(b)),z("LazyLoad",c),c.type==="image"&&(c.img=a('<img class="mfp-img" />').on("load.mfploader",function(){c.hasSize=!0}).on("error.mfploader",function(){c.hasSize=!0,c.loadError=!0,z("LazyLoadError",c)}).attr("src",c.src)),c.preloaded=!0}}});var X="retina";a.magnificPopup.registerModule(X,{options:{replaceSrc:function(a){return a.src.replace(/\.\w+$/,function(a){return"@2x"+a})},ratio:1},proto:{initRetina:function(){if(window.devicePixelRatio>1){var a=n.st.retina,b=a.ratio;b=isNaN(b)?b():b,b>1&&(x("ImageHasSize."+X,function(a,c){c.img.css({"max-width":c.img[0].naturalWidth/b,width:"100%"})}),x("ElementParse."+X,function(c,d){d.src=a.replaceSrc(d,b)}))}}}}),function(){var b=1e3,c="ontouchstart"in window,d=function(){r.off("touchmove"+f+" touchend"+f)},e="mfpFastClick",f="."+e;a.fn.mfpFastClick=function(e){return a(this).each(function(){var g=a(this),h;if(c){var i,j,k,l,m,n;g.on("touchstart"+f,function(a){l=!1,n=1,m=a.originalEvent?a.originalEvent.touches[0]:a.touches[0],j=m.clientX,k=m.clientY,r.on("touchmove"+f,function(a){m=a.originalEvent?a.originalEvent.touches:a.touches,n=m.length,m=m[0];if(Math.abs(m.clientX-j)>10||Math.abs(m.clientY-k)>10)l=!0,d()}).on("touchend"+f,function(a){d();if(l||n>1)return;h=!0,a.preventDefault(),clearTimeout(i),i=setTimeout(function(){h=!1},b),e()})})}g.on("click"+f,function(){h||e()})})},a.fn.destroyMfpFastClick=function(){a(this).off("touchstart"+f+" click"+f),c&&r.off("touchmove"+f+" touchend"+f)}}()})(window.jQuery||window.Zepto);

/*
 * jQuery Superfish Menu Plugin - v1.7.4
 * Copyright (c) 2013 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 *  http://www.opensource.org/licenses/mit-license.php
 *  http://www.gnu.org/licenses/gpl.html
 */

;(function(e){"use strict";var s=function(){var s={bcClass:"sf-breadcrumb",menuClass:"sf-js-enabled",anchorClass:"sf-with-ul",menuArrowClass:"sf-arrows"},o=function(){var s=/iPhone|iPad|iPod/i.test(navigator.userAgent);return s&&e(window).load(function(){e("body").children().on("click",e.noop)}),s}(),n=function(){var e=document.documentElement.style;return"behavior"in e&&"fill"in e&&/iemobile/i.test(navigator.userAgent)}(),t=function(e,o){var n=s.menuClass;o.cssArrows&&(n+=" "+s.menuArrowClass),e.toggleClass(n)},i=function(o,n){return o.find("li."+n.pathClass).slice(0,n.pathLevels).addClass(n.hoverClass+" "+s.bcClass).filter(function(){return e(this).children(n.popUpSelector).hide().show().length}).removeClass(n.pathClass)},r=function(e){e.children("a").toggleClass(s.anchorClass)},a=function(e){var s=e.css("ms-touch-action");s="pan-y"===s?"auto":"pan-y",e.css("ms-touch-action",s)},l=function(s,t){var i="li:has("+t.popUpSelector+")";e.fn.hoverIntent&&!t.disableHI?s.hoverIntent(u,p,i):s.on("mouseenter.superfish",i,u).on("mouseleave.superfish",i,p);var r="MSPointerDown.superfish";o||(r+=" touchend.superfish"),n&&(r+=" mousedown.superfish"),s.on("focusin.superfish","li",u).on("focusout.superfish","li",p).on(r,"a",t,h)},h=function(s){var o=e(this),n=o.siblings(s.data.popUpSelector);n.length>0&&n.is(":hidden")&&(o.one("click.superfish",!1),"MSPointerDown"===s.type?o.trigger("focus"):e.proxy(u,o.parent("li"))())},u=function(){var s=e(this),o=d(s);clearTimeout(o.sfTimer),s.siblings().superfish("hide").end().superfish("show")},p=function(){var s=e(this),n=d(s);o?e.proxy(f,s,n)():(clearTimeout(n.sfTimer),n.sfTimer=setTimeout(e.proxy(f,s,n),n.delay))},f=function(s){s.retainPath=e.inArray(this[0],s.$path)>-1,this.superfish("hide"),this.parents("."+s.hoverClass).length||(s.onIdle.call(c(this)),s.$path.length&&e.proxy(u,s.$path)())},c=function(e){return e.closest("."+s.menuClass)},d=function(e){return c(e).data("sf-options")};return{hide:function(s){if(this.length){var o=this,n=d(o);if(!n)return this;var t=n.retainPath===!0?n.$path:"",i=o.find("li."+n.hoverClass).add(this).not(t).removeClass(n.hoverClass).children(n.popUpSelector),r=n.speedOut;s&&(i.show(),r=0),n.retainPath=!1,n.onBeforeHide.call(i),i.stop(!0,!0).animate(n.animationOut,r,function(){var s=e(this);n.onHide.call(s)})}return this},show:function(){var e=d(this);if(!e)return this;var s=this.addClass(e.hoverClass),o=s.children(e.popUpSelector);return e.onBeforeShow.call(o),o.stop(!0,!0).animate(e.animation,e.speed,function(){e.onShow.call(o)}),this},destroy:function(){return this.each(function(){var o,n=e(this),i=n.data("sf-options");return i?(o=n.find(i.popUpSelector).parent("li"),clearTimeout(i.sfTimer),t(n,i),r(o),a(n),n.off(".superfish").off(".hoverIntent"),o.children(i.popUpSelector).attr("style",function(e,s){return s.replace(/display[^;]+;?/g,"")}),i.$path.removeClass(i.hoverClass+" "+s.bcClass).addClass(i.pathClass),n.find("."+i.hoverClass).removeClass(i.hoverClass),i.onDestroy.call(n),n.removeData("sf-options"),void 0):!1})},init:function(o){return this.each(function(){var n=e(this);if(n.data("sf-options"))return!1;var h=e.extend({},e.fn.superfish.defaults,o),u=n.find(h.popUpSelector).parent("li");h.$path=i(n,h),n.data("sf-options",h),t(n,h),r(u),a(n),l(n,h),u.not("."+s.bcClass).superfish("hide",!0),h.onInit.call(this)})}}}();e.fn.superfish=function(o){return s[o]?s[o].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof o&&o?e.error("Method "+o+" does not exist on jQuery.fn.superfish"):s.init.apply(this,arguments)},e.fn.superfish.defaults={popUpSelector:"ul,.sf-mega",hoverClass:"sfHover",pathClass:"overrideThisToUse",pathLevels:1,delay:800,animation:{opacity:"show"},animationOut:{opacity:"hide"},speed:"normal",speedOut:"fast",cssArrows:!0,disableHI:!1,onInit:e.noop,onBeforeShow:e.noop,onShow:e.noop,onBeforeHide:e.noop,onHide:e.noop,onIdle:e.noop,onDestroy:e.noop},e.fn.extend({hideSuperfishUl:s.hide,showSuperfishUl:s.show})})(jQuery);

/*
 * jQuery FlexSlider v2.2.0
 * Copyright 2012 WooThemes
 * Contributing Author: Tyler Smith
 */
 (function(e){e.flexslider=function(t,n){var r=e(t);r.vars=e.extend({},e.flexslider.defaults,n);var i=r.vars.namespace,s=window.navigator&&window.navigator.msPointerEnabled&&window.MSGesture,o=("ontouchstart"in window||s||window.DocumentTouch&&document instanceof DocumentTouch)&&r.vars.touch,u="click touchend MSPointerUp",a="",f,l=r.vars.direction==="vertical",c=r.vars.reverse,h=r.vars.itemWidth>0,p=r.vars.animation==="fade",d=r.vars.asNavFor!=="",v={},m=!0;e.data(t,"flexslider",r);v={init:function(){r.animating=!1;r.currentSlide=parseInt(r.vars.startAt?r.vars.startAt:0);isNaN(r.currentSlide)&&(r.currentSlide=0);r.animatingTo=r.currentSlide;r.atEnd=r.currentSlide===0||r.currentSlide===r.last;r.containerSelector=r.vars.selector.substr(0,r.vars.selector.search(" "));r.slides=e(r.vars.selector,r);r.container=e(r.containerSelector,r);r.count=r.slides.length;r.syncExists=e(r.vars.sync).length>0;r.vars.animation==="slide"&&(r.vars.animation="swing");r.prop=l?"top":"marginLeft";r.args={};r.manualPause=!1;r.stopped=!1;r.started=!1;r.startTimeout=null;r.transitions=!r.vars.video&&!p&&r.vars.useCSS&&function(){var e=document.createElement("div"),t=["perspectiveProperty","WebkitPerspective","MozPerspective","OPerspective","msPerspective"];for(var n in t)if(e.style[t[n]]!==undefined){r.pfx=t[n].replace("Perspective","").toLowerCase();r.prop="-"+r.pfx+"-transform";return!0}return!1}();r.vars.controlsContainer!==""&&(r.controlsContainer=e(r.vars.controlsContainer).length>0&&e(r.vars.controlsContainer));r.vars.manualControls!==""&&(r.manualControls=e(r.vars.manualControls).length>0&&e(r.vars.manualControls));if(r.vars.randomize){r.slides.sort(function(){return Math.round(Math.random())-.5});r.container.empty().append(r.slides)}r.doMath();r.setup("init");r.vars.controlNav&&v.controlNav.setup();r.vars.directionNav&&v.directionNav.setup();r.vars.keyboard&&(e(r.containerSelector).length===1||r.vars.multipleKeyboard)&&e(document).bind("keyup",function(e){var t=e.keyCode;if(!r.animating&&(t===39||t===37)){var n=t===39?r.getTarget("next"):t===37?r.getTarget("prev"):!1;r.flexAnimate(n,r.vars.pauseOnAction)}});r.vars.mousewheel&&r.bind("mousewheel",function(e,t,n,i){e.preventDefault();var s=t<0?r.getTarget("next"):r.getTarget("prev");r.flexAnimate(s,r.vars.pauseOnAction)});r.vars.pausePlay&&v.pausePlay.setup();r.vars.slideshow&&r.vars.pauseInvisible&&v.pauseInvisible.init();if(r.vars.slideshow){r.vars.pauseOnHover&&r.hover(function(){!r.manualPlay&&!r.manualPause&&r.pause()},function(){!r.manualPause&&!r.manualPlay&&!r.stopped&&r.play()});if(!r.vars.pauseInvisible||!v.pauseInvisible.isHidden())r.vars.initDelay>0?r.startTimeout=setTimeout(r.play,r.vars.initDelay):r.play()}d&&v.asNav.setup();o&&r.vars.touch&&v.touch();(!p||p&&r.vars.smoothHeight)&&e(window).bind("resize orientationchange focus",v.resize);r.find("img").attr("draggable","false");setTimeout(function(){r.vars.start(r)},200)},asNav:{setup:function(){r.asNav=!0;r.animatingTo=Math.floor(r.currentSlide/r.move);r.currentItem=r.currentSlide;r.slides.removeClass(i+"active-slide").eq(r.currentItem).addClass(i+"active-slide");if(!s)r.slides.click(function(t){t.preventDefault();var n=e(this),s=n.index(),o=n.offset().left-e(r).scrollLeft();if(o<=0&&n.hasClass(i+"active-slide"))r.flexAnimate(r.getTarget("prev"),!0);else if(!e(r.vars.asNavFor).data("flexslider").animating&&!n.hasClass(i+"active-slide")){r.direction=r.currentItem<s?"next":"prev";r.flexAnimate(s,r.vars.pauseOnAction,!1,!0,!0)}});else{t._slider=r;r.slides.each(function(){var t=this;t._gesture=new MSGesture;t._gesture.target=t;t.addEventListener("MSPointerDown",function(e){e.preventDefault();e.currentTarget._gesture&&e.currentTarget._gesture.addPointer(e.pointerId)},!1);t.addEventListener("MSGestureTap",function(t){t.preventDefault();var n=e(this),i=n.index();if(!e(r.vars.asNavFor).data("flexslider").animating&&!n.hasClass("active")){r.direction=r.currentItem<i?"next":"prev";r.flexAnimate(i,r.vars.pauseOnAction,!1,!0,!0)}})})}}},controlNav:{setup:function(){r.manualControls?v.controlNav.setupManual():v.controlNav.setupPaging()},setupPaging:function(){var t=r.vars.controlNav==="thumbnails"?"control-thumbs":"control-paging",n=1,s,o;r.controlNavScaffold=e('<ol class="'+i+"control-nav "+i+t+'"></ol>');if(r.pagingCount>1)for(var f=0;f<r.pagingCount;f++){o=r.slides.eq(f);s=r.vars.controlNav==="thumbnails"?'<img src="'+o.attr("data-thumb")+'"/>':"<a>"+n+"</a>";if("thumbnails"===r.vars.controlNav&&!0===r.vars.thumbCaptions){var l=o.attr("data-thumbcaption");""!=l&&undefined!=l&&(s+='<span class="'+i+'caption">'+l+"</span>")}r.controlNavScaffold.append("<li>"+s+"</li>");n++}r.controlsContainer?e(r.controlsContainer).append(r.controlNavScaffold):r.append(r.controlNavScaffold);v.controlNav.set();v.controlNav.active();r.controlNavScaffold.delegate("a, img",u,function(t){t.preventDefault();if(a===""||a===t.type){var n=e(this),s=r.controlNav.index(n);if(!n.hasClass(i+"active")){r.direction=s>r.currentSlide?"next":"prev";r.flexAnimate(s,r.vars.pauseOnAction)}}a===""&&(a=t.type);v.setToClearWatchedEvent()})},setupManual:function(){r.controlNav=r.manualControls;v.controlNav.active();r.controlNav.bind(u,function(t){t.preventDefault();if(a===""||a===t.type){var n=e(this),s=r.controlNav.index(n);if(!n.hasClass(i+"active")){s>r.currentSlide?r.direction="next":r.direction="prev";r.flexAnimate(s,r.vars.pauseOnAction)}}a===""&&(a=t.type);v.setToClearWatchedEvent()})},set:function(){var t=r.vars.controlNav==="thumbnails"?"img":"a";r.controlNav=e("."+i+"control-nav li "+t,r.controlsContainer?r.controlsContainer:r)},active:function(){r.controlNav.removeClass(i+"active").eq(r.animatingTo).addClass(i+"active")},update:function(t,n){r.pagingCount>1&&t==="add"?r.controlNavScaffold.append(e("<li><a>"+r.count+"</a></li>")):r.pagingCount===1?r.controlNavScaffold.find("li").remove():r.controlNav.eq(n).closest("li").remove();v.controlNav.set();r.pagingCount>1&&r.pagingCount!==r.controlNav.length?r.update(n,t):v.controlNav.active()}},directionNav:{setup:function(){var t=e('<ul class="'+i+'direction-nav"><li><a class="'+i+'prev" href="#">'+r.vars.prevText+'</a></li><li><a class="'+i+'next" href="#">'+r.vars.nextText+"</a></li></ul>");if(r.controlsContainer){e(r.controlsContainer).append(t);r.directionNav=e("."+i+"direction-nav li a",r.controlsContainer)}else{r.append(t);r.directionNav=e("."+i+"direction-nav li a",r)}v.directionNav.update();r.directionNav.bind(u,function(t){t.preventDefault();var n;if(a===""||a===t.type){n=e(this).hasClass(i+"next")?r.getTarget("next"):r.getTarget("prev");r.flexAnimate(n,r.vars.pauseOnAction)}a===""&&(a=t.type);v.setToClearWatchedEvent()})},update:function(){var e=i+"disabled";r.pagingCount===1?r.directionNav.addClass(e).attr("tabindex","-1"):r.vars.animationLoop?r.directionNav.removeClass(e).removeAttr("tabindex"):r.animatingTo===0?r.directionNav.removeClass(e).filter("."+i+"prev").addClass(e).attr("tabindex","-1"):r.animatingTo===r.last?r.directionNav.removeClass(e).filter("."+i+"next").addClass(e).attr("tabindex","-1"):r.directionNav.removeClass(e).removeAttr("tabindex")}},pausePlay:{setup:function(){var t=e('<div class="'+i+'pauseplay"><a></a></div>');if(r.controlsContainer){r.controlsContainer.append(t);r.pausePlay=e("."+i+"pauseplay a",r.controlsContainer)}else{r.append(t);r.pausePlay=e("."+i+"pauseplay a",r)}v.pausePlay.update(r.vars.slideshow?i+"pause":i+"play");r.pausePlay.bind(u,function(t){t.preventDefault();if(a===""||a===t.type)if(e(this).hasClass(i+"pause")){r.manualPause=!0;r.manualPlay=!1;r.pause()}else{r.manualPause=!1;r.manualPlay=!0;r.play()}a===""&&(a=t.type);v.setToClearWatchedEvent()})},update:function(e){e==="play"?r.pausePlay.removeClass(i+"pause").addClass(i+"play").html(r.vars.playText):r.pausePlay.removeClass(i+"play").addClass(i+"pause").html(r.vars.pauseText)}},touch:function(){var e,n,i,o,u,a,f=!1,d=0,v=0,m=0;if(!s){t.addEventListener("touchstart",g,!1);function g(s){if(r.animating)s.preventDefault();else if(window.navigator.msPointerEnabled||s.touches.length===1){r.pause();o=l?r.h:r.w;a=Number(new Date);d=s.touches[0].pageX;v=s.touches[0].pageY;i=h&&c&&r.animatingTo===r.last?0:h&&c?r.limit-(r.itemW+r.vars.itemMargin)*r.move*r.animatingTo:h&&r.currentSlide===r.last?r.limit:h?(r.itemW+r.vars.itemMargin)*r.move*r.currentSlide:c?(r.last-r.currentSlide+r.cloneOffset)*o:(r.currentSlide+r.cloneOffset)*o;e=l?v:d;n=l?d:v;t.addEventListener("touchmove",y,!1);t.addEventListener("touchend",b,!1)}}function y(t){d=t.touches[0].pageX;v=t.touches[0].pageY;u=l?e-v:e-d;f=l?Math.abs(u)<Math.abs(d-n):Math.abs(u)<Math.abs(v-n);var s=500;if(!f||Number(new Date)-a>s){t.preventDefault();if(!p&&r.transitions){r.vars.animationLoop||(u/=r.currentSlide===0&&u<0||r.currentSlide===r.last&&u>0?Math.abs(u)/o+2:1);r.setProps(i+u,"setTouch")}}}function b(s){t.removeEventListener("touchmove",y,!1);if(r.animatingTo===r.currentSlide&&!f&&u!==null){var l=c?-u:u,h=l>0?r.getTarget("next"):r.getTarget("prev");r.canAdvance(h)&&(Number(new Date)-a<550&&Math.abs(l)>50||Math.abs(l)>o/2)?r.flexAnimate(h,r.vars.pauseOnAction):p||r.flexAnimate(r.currentSlide,r.vars.pauseOnAction,!0)}t.removeEventListener("touchend",b,!1);e=null;n=null;u=null;i=null}}else{t.style.msTouchAction="none";t._gesture=new MSGesture;t._gesture.target=t;t.addEventListener("MSPointerDown",w,!1);t._slider=r;t.addEventListener("MSGestureChange",E,!1);t.addEventListener("MSGestureEnd",S,!1);function w(e){e.stopPropagation();if(r.animating)e.preventDefault();else{r.pause();t._gesture.addPointer(e.pointerId);m=0;o=l?r.h:r.w;a=Number(new Date);i=h&&c&&r.animatingTo===r.last?0:h&&c?r.limit-(r.itemW+r.vars.itemMargin)*r.move*r.animatingTo:h&&r.currentSlide===r.last?r.limit:h?(r.itemW+r.vars.itemMargin)*r.move*r.currentSlide:c?(r.last-r.currentSlide+r.cloneOffset)*o:(r.currentSlide+r.cloneOffset)*o}}function E(e){e.stopPropagation();var n=e.target._slider;if(!n)return;var r=-e.translationX,s=-e.translationY;m+=l?s:r;u=m;f=l?Math.abs(m)<Math.abs(-r):Math.abs(m)<Math.abs(-s);if(e.detail===e.MSGESTURE_FLAG_INERTIA){setImmediate(function(){t._gesture.stop()});return}if(!f||Number(new Date)-a>500){e.preventDefault();if(!p&&n.transitions){n.vars.animationLoop||(u=m/(n.currentSlide===0&&m<0||n.currentSlide===n.last&&m>0?Math.abs(m)/o+2:1));n.setProps(i+u,"setTouch")}}}function S(t){t.stopPropagation();var r=t.target._slider;if(!r)return;if(r.animatingTo===r.currentSlide&&!f&&u!==null){var s=c?-u:u,l=s>0?r.getTarget("next"):r.getTarget("prev");r.canAdvance(l)&&(Number(new Date)-a<550&&Math.abs(s)>50||Math.abs(s)>o/2)?r.flexAnimate(l,r.vars.pauseOnAction):p||r.flexAnimate(r.currentSlide,r.vars.pauseOnAction,!0)}e=null;n=null;u=null;i=null;m=0}}},resize:function(){if(!r.animating&&r.is(":visible")){h||r.doMath();if(p)v.smoothHeight();else if(h){r.slides.width(r.computedW);r.update(r.pagingCount);r.setProps()}else if(l){r.viewport.height(r.h);r.setProps(r.h,"setTotal")}else{r.vars.smoothHeight&&v.smoothHeight();r.newSlides.width(r.computedW);r.setProps(r.computedW,"setTotal")}}},smoothHeight:function(e){if(!l||p){var t=p?r:r.viewport;e?t.animate({height:r.slides.eq(r.animatingTo).height()},e):t.height(r.slides.eq(r.animatingTo).height())}},sync:function(t){var n=e(r.vars.sync).data("flexslider"),i=r.animatingTo;switch(t){case"animate":n.flexAnimate(i,r.vars.pauseOnAction,!1,!0);break;case"play":!n.playing&&!n.asNav&&n.play();break;case"pause":n.pause()}},pauseInvisible:{visProp:null,init:function(){var e=["webkit","moz","ms","o"];if("hidden"in document)return"hidden";for(var t=0;t<e.length;t++)e[t]+"Hidden"in document&&(v.pauseInvisible.visProp=e[t]+"Hidden");if(v.pauseInvisible.visProp){var n=v.pauseInvisible.visProp.replace(/[H|h]idden/,"")+"visibilitychange";document.addEventListener(n,function(){v.pauseInvisible.isHidden()?r.startTimeout?clearTimeout(r.startTimeout):r.pause():r.started?r.play():r.vars.initDelay>0?setTimeout(r.play,r.vars.initDelay):r.play()})}},isHidden:function(){return document[v.pauseInvisible.visProp]||!1}},setToClearWatchedEvent:function(){clearTimeout(f);f=setTimeout(function(){a=""},3e3)}};r.flexAnimate=function(t,n,s,u,a){!r.vars.animationLoop&&t!==r.currentSlide&&(r.direction=t>r.currentSlide?"next":"prev");d&&r.pagingCount===1&&(r.direction=r.currentItem<t?"next":"prev");if(!r.animating&&(r.canAdvance(t,a)||s)&&r.is(":visible")){if(d&&u){var f=e(r.vars.asNavFor).data("flexslider");r.atEnd=t===0||t===r.count-1;f.flexAnimate(t,!0,!1,!0,a);r.direction=r.currentItem<t?"next":"prev";f.direction=r.direction;if(Math.ceil((t+1)/r.visible)-1===r.currentSlide||t===0){r.currentItem=t;r.slides.removeClass(i+"active-slide").eq(t).addClass(i+"active-slide");return!1}r.currentItem=t;r.slides.removeClass(i+"active-slide").eq(t).addClass(i+"active-slide");t=Math.floor(t/r.visible)}r.animating=!0;r.animatingTo=t;n&&r.pause();r.vars.before(r);r.syncExists&&!a&&v.sync("animate");r.vars.controlNav&&v.controlNav.active();h||r.slides.removeClass(i+"active-slide").eq(t).addClass(i+"active-slide");r.atEnd=t===0||t===r.last;r.vars.directionNav&&v.directionNav.update();if(t===r.last){r.vars.end(r);r.vars.animationLoop||r.pause()}if(!p){var m=l?r.slides.filter(":first").height():r.computedW,g,y,b;if(h){g=r.vars.itemMargin;b=(r.itemW+g)*r.move*r.animatingTo;y=b>r.limit&&r.visible!==1?r.limit:b}else r.currentSlide===0&&t===r.count-1&&r.vars.animationLoop&&r.direction!=="next"?y=c?(r.count+r.cloneOffset)*m:0:r.currentSlide===r.last&&t===0&&r.vars.animationLoop&&r.direction!=="prev"?y=c?0:(r.count+1)*m:y=c?(r.count-1-t+r.cloneOffset)*m:(t+r.cloneOffset)*m;r.setProps(y,"",r.vars.animationSpeed);if(r.transitions){if(!r.vars.animationLoop||!r.atEnd){r.animating=!1;r.currentSlide=r.animatingTo}r.container.unbind("webkitTransitionEnd transitionend");r.container.bind("webkitTransitionEnd transitionend",function(){r.wrapup(m)})}else r.container.animate(r.args,r.vars.animationSpeed,r.vars.easing,function(){r.wrapup(m)})}else if(!o){r.slides.eq(r.currentSlide).css({zIndex:1}).animate({opacity:0},r.vars.animationSpeed,r.vars.easing);r.slides.eq(t).css({zIndex:2}).animate({opacity:1},r.vars.animationSpeed,r.vars.easing,r.wrapup)}else{r.slides.eq(r.currentSlide).css({opacity:0,zIndex:1});r.slides.eq(t).css({opacity:1,zIndex:2});r.wrapup(m)}r.vars.smoothHeight&&v.smoothHeight(r.vars.animationSpeed)}};r.wrapup=function(e){!p&&!h&&(r.currentSlide===0&&r.animatingTo===r.last&&r.vars.animationLoop?r.setProps(e,"jumpEnd"):r.currentSlide===r.last&&r.animatingTo===0&&r.vars.animationLoop&&r.setProps(e,"jumpStart"));r.animating=!1;r.currentSlide=r.animatingTo;r.vars.after(r)};r.animateSlides=function(){!r.animating&&m&&r.flexAnimate(r.getTarget("next"))};r.pause=function(){clearInterval(r.animatedSlides);r.animatedSlides=null;r.playing=!1;r.vars.pausePlay&&v.pausePlay.update("play");r.syncExists&&v.sync("pause")};r.play=function(){r.playing&&clearInterval(r.animatedSlides);r.animatedSlides=r.animatedSlides||setInterval(r.animateSlides,r.vars.slideshowSpeed);r.started=r.playing=!0;r.vars.pausePlay&&v.pausePlay.update("pause");r.syncExists&&v.sync("play")};r.stop=function(){r.pause();r.stopped=!0};r.canAdvance=function(e,t){var n=d?r.pagingCount-1:r.last;return t?!0:d&&r.currentItem===r.count-1&&e===0&&r.direction==="prev"?!0:d&&r.currentItem===0&&e===r.pagingCount-1&&r.direction!=="next"?!1:e===r.currentSlide&&!d?!1:r.vars.animationLoop?!0:r.atEnd&&r.currentSlide===0&&e===n&&r.direction!=="next"?!1:r.atEnd&&r.currentSlide===n&&e===0&&r.direction==="next"?!1:!0};r.getTarget=function(e){r.direction=e;return e==="next"?r.currentSlide===r.last?0:r.currentSlide+1:r.currentSlide===0?r.last:r.currentSlide-1};r.setProps=function(e,t,n){var i=function(){var n=e?e:(r.itemW+r.vars.itemMargin)*r.move*r.animatingTo,i=function(){if(h)return t==="setTouch"?e:c&&r.animatingTo===r.last?0:c?r.limit-(r.itemW+r.vars.itemMargin)*r.move*r.animatingTo:r.animatingTo===r.last?r.limit:n;switch(t){case"setTotal":return c?(r.count-1-r.currentSlide+r.cloneOffset)*e:(r.currentSlide+r.cloneOffset)*e;case"setTouch":return c?e:e;case"jumpEnd":return c?e:r.count*e;case"jumpStart":return c?r.count*e:e;default:return e}}();return i*-1+"px"}();if(r.transitions){i=l?"translate3d(0,"+i+",0)":"translate3d("+i+",0,0)";n=n!==undefined?n/1e3+"s":"0s";r.container.css("-"+r.pfx+"-transition-duration",n)}r.args[r.prop]=i;(r.transitions||n===undefined)&&r.container.css(r.args)};r.setup=function(t){if(!p){var n,s;if(t==="init"){r.viewport=e('<div class="'+i+'viewport"></div>').css({overflow:"hidden",position:"relative"}).appendTo(r).append(r.container);r.cloneCount=0;r.cloneOffset=0;if(c){s=e.makeArray(r.slides).reverse();r.slides=e(s);r.container.empty().append(r.slides)}}if(r.vars.animationLoop&&!h){r.cloneCount=2;r.cloneOffset=1;t!=="init"&&r.container.find(".clone").remove();r.container.append(r.slides.first().clone().addClass("clone").attr("aria-hidden","true")).prepend(r.slides.last().clone().addClass("clone").attr("aria-hidden","true"))}r.newSlides=e(r.vars.selector,r);n=c?r.count-1-r.currentSlide+r.cloneOffset:r.currentSlide+r.cloneOffset;if(l&&!h){r.container.height((r.count+r.cloneCount)*200+"%").css("position","absolute").width("100%");setTimeout(function(){r.newSlides.css({display:"block"});r.doMath();r.viewport.height(r.h);r.setProps(n*r.h,"init")},t==="init"?100:0)}else{r.container.width((r.count+r.cloneCount)*200+"%");r.setProps(n*r.computedW,"init");setTimeout(function(){r.doMath();r.newSlides.css({width:r.computedW,"float":"left",display:"block"});r.vars.smoothHeight&&v.smoothHeight()},t==="init"?100:0)}}else{r.slides.css({width:"100%","float":"left",marginRight:"-100%",position:"relative"});t==="init"&&(o?r.slides.css({opacity:0,display:"block",webkitTransition:"opacity "+r.vars.animationSpeed/1e3+"s ease",zIndex:1}).eq(r.currentSlide).css({opacity:1,zIndex:2}):r.slides.css({opacity:0,display:"block",zIndex:1}).eq(r.currentSlide).css({zIndex:2}).animate({opacity:1},r.vars.animationSpeed,r.vars.easing));r.vars.smoothHeight&&v.smoothHeight()}h||r.slides.removeClass(i+"active-slide").eq(r.currentSlide).addClass(i+"active-slide")};r.doMath=function(){var e=r.slides.first(),t=r.vars.itemMargin,n=r.vars.minItems,i=r.vars.maxItems;r.w=r.viewport===undefined?r.width():r.viewport.width();r.h=e.height();r.boxPadding=e.outerWidth()-e.width();if(h){r.itemT=r.vars.itemWidth+t;r.minW=n?n*r.itemT:r.w;r.maxW=i?i*r.itemT-t:r.w;r.itemW=r.minW>r.w?(r.w-t*(n-1))/n:r.maxW<r.w?(r.w-t*(i-1))/i:r.vars.itemWidth>r.w?r.w:r.vars.itemWidth;r.visible=Math.floor(r.w/r.itemW);r.move=r.vars.move>0&&r.vars.move<r.visible?r.vars.move:r.visible;r.pagingCount=Math.ceil((r.count-r.visible)/r.move+1);r.last=r.pagingCount-1;r.limit=r.pagingCount===1?0:r.vars.itemWidth>r.w?r.itemW*(r.count-1)+t*(r.count-1):(r.itemW+t)*r.count-r.w-t}else{r.itemW=r.w;r.pagingCount=r.count;r.last=r.count-1}r.computedW=r.itemW-r.boxPadding};r.update=function(e,t){r.doMath();if(!h){e<r.currentSlide?r.currentSlide+=1:e<=r.currentSlide&&e!==0&&(r.currentSlide-=1);r.animatingTo=r.currentSlide}if(r.vars.controlNav&&!r.manualControls)if(t==="add"&&!h||r.pagingCount>r.controlNav.length)v.controlNav.update("add");else if(t==="remove"&&!h||r.pagingCount<r.controlNav.length){if(h&&r.currentSlide>r.last){r.currentSlide-=1;r.animatingTo-=1}v.controlNav.update("remove",r.last)}r.vars.directionNav&&v.directionNav.update()};r.addSlide=function(t,n){var i=e(t);r.count+=1;r.last=r.count-1;l&&c?n!==undefined?r.slides.eq(r.count-n).after(i):r.container.prepend(i):n!==undefined?r.slides.eq(n).before(i):r.container.append(i);r.update(n,"add");r.slides=e(r.vars.selector+":not(.clone)",r);r.setup();r.vars.added(r)};r.removeSlide=function(t){var n=isNaN(t)?r.slides.index(e(t)):t;r.count-=1;r.last=r.count-1;isNaN(t)?e(t,r.slides).remove():l&&c?r.slides.eq(r.last).remove():r.slides.eq(t).remove();r.doMath();r.update(n,"remove");r.slides=e(r.vars.selector+":not(.clone)",r);r.setup();r.vars.removed(r)};v.init()};e(window).blur(function(e){focused=!1}).focus(function(e){focused=!0});e.flexslider.defaults={namespace:"flex-",selector:".slides > li",animation:"fade",easing:"swing",direction:"horizontal",reverse:!1,animationLoop:!0,smoothHeight:!1,startAt:0,slideshow:!0,slideshowSpeed:7e3,animationSpeed:600,initDelay:0,randomize:!1,thumbCaptions:!1,pauseOnAction:!0,pauseOnHover:!1,pauseInvisible:!0,useCSS:!0,touch:!0,video:!1,controlNav:!0,directionNav:!0,prevText:"Previous",nextText:"Next",keyboard:!0,multipleKeyboard:!1,mousewheel:!1,pausePlay:!1,pauseText:"Pause",playText:"Play",controlsContainer:"",manualControls:"",sync:"",asNavFor:"",itemWidth:0,itemMargin:0,minItems:1,maxItems:0,move:0,allowOneSlide:!0,start:function(){},before:function(){},after:function(){},end:function(){},added:function(){},removed:function(){}};e.fn.flexslider=function(t){t===undefined&&(t={});if(typeof t=="object")return this.each(function(){var n=e(this),r=t.selector?t.selector:".slides > li",i=n.find(r);if(i.length===1&&t.allowOneSlide===!0||i.length===0){i.fadeIn(400);t.start&&t.start(n)}else n.data("flexslider")===undefined&&new e.flexslider(this,t)});var n=e(this).data("flexslider");switch(t){case"play":n.play();break;case"pause":n.pause();break;case"stop":n.stop();break;case"next":n.flexAnimate(n.getTarget("next"),!0);break;case"prev":case"previous":n.flexAnimate(n.getTarget("prev"),!0);break;default:typeof t=="number"&&n.flexAnimate(t,!0)}}})(jQuery);

 /*global jQuery */
/*jshint multistr:true browser:true */
/*!
* FitVids 1.0.3
*
* Copyright 2013, Chris Coyier - http://css-tricks.com + Dave Rupert - http://daverupert.com
* Credit to Thierry Koblentz - http://www.alistapart.com/articles/creating-intrinsic-ratios-for-video/
* Released under the WTFPL license - http://sam.zoy.org/wtfpl/
*
* Date: Thu Sept 01 18:00:00 2011 -0500
*/

(function( $ ){

  "use strict";

  $.fn.fitVids = function( options ) {
    var settings = {
      customSelector: null
    };

    if(!document.getElementById('fit-vids-style')) {

      var div = document.createElement('div'),
          ref = document.getElementsByTagName('base')[0] || document.getElementsByTagName('script')[0],
          cssStyles = '&shy;<style>.fluid-width-video-wrapper{width:100%;position:relative;padding:0;}.fluid-width-video-wrapper iframe,.fluid-width-video-wrapper object,.fluid-width-video-wrapper embed {position:absolute;top:0;left:0;width:100%;height:100%;}</style>';

      div.className = 'fit-vids-style';
      div.id = 'fit-vids-style';
      div.style.display = 'none';
      div.innerHTML = cssStyles;

      ref.parentNode.insertBefore(div,ref);

    }

    if ( options ) {
      $.extend( settings, options );
    }

    return this.each(function(){
      var selectors = [
        "iframe[src*='player.vimeo.com']",
        "iframe[src*='youtube.com']",
        "iframe[src*='youtube-nocookie.com']",
        "iframe[src*='kickstarter.com'][src*='video.html']",
        "object",
        "embed"
      ];

      if (settings.customSelector) {
        selectors.push(settings.customSelector);
      }

      var $allVideos = $(this).find(selectors.join(','));
      $allVideos = $allVideos.not("object object"); // SwfObj conflict patch

      $allVideos.each(function(){
        var $this = $(this);
        if (this.tagName.toLowerCase() === 'embed' && $this.parent('object').length || $this.parent('.fluid-width-video-wrapper').length) { return; }
        var height = ( this.tagName.toLowerCase() === 'object' || ($this.attr('height') && !isNaN(parseInt($this.attr('height'), 10))) ) ? parseInt($this.attr('height'), 10) : $this.height(),
            width = !isNaN(parseInt($this.attr('width'), 10)) ? parseInt($this.attr('width'), 10) : $this.width(),
            aspectRatio = height / width;
        if(!$this.attr('id')){
          var videoID = 'fitvid' + Math.floor(Math.random()*999999);
          $this.attr('id', videoID);
        }
        $this.wrap('<div class="fluid-width-video-wrapper"></div>').parent('.fluid-width-video-wrapper').css('padding-top', (aspectRatio * 100)+"%");
        $this.removeAttr('height').removeAttr('width');
      });
    });
  };
// Works with either jQuery or Zepto
})( window.jQuery || window.Zepto );


/* ===========================================================
 * bootstrap-alert.js v2.3.0
 * ========================================================== */
!function(d){var c='[data-dismiss="alert"]',b=function(e){d(e).on("click",c,this.close)};b.prototype.close=function(j){var i=d(this),g=i.attr("data-target"),h;if(!g){g=i.attr("href");g=g&&g.replace(/.*(?=#[^\s]*$)/,"")}h=d(g);j&&j.preventDefault();h.length||(h=i.hasClass("alert")?i:i.parent());h.trigger(j=d.Event("close"));if(j.isDefaultPrevented()){return}h.removeClass("in");function f(){h.trigger("closed").remove()}d.support.transition&&h.hasClass("fade")?h.on(d.support.transition.end,f):f()};var a=d.fn.alert;d.fn.alert=function(e){return this.each(function(){var g=d(this),f=g.data("alert");if(!f){g.data("alert",(f=new b(this)))}if(typeof e=="string"){f[e].call(g)}})};d.fn.alert.Constructor=b;d.fn.alert.noConflict=function(){d.fn.alert=a;return this};d(document).on("click.alert.data-api",c,b.prototype.close)}(window.jQuery);

// Generated by CoffeeScript 1.6.3
(function() {
  var $;

  $ = window.jQuery || window.Zepto || window.$;

  $.fn.fancySelect = function(opts) {
    var isiOS, settings;
    settings = $.extend({
      forceiOS: false
    }, opts);
    isiOS = !!navigator.userAgent.match(/iP(hone|od|ad)/i);
    return this.each(function() {
      var copyOptionsToList, disabled, options, sel, trigger, updateTriggerText, wrapper;
      sel = $(this);
      if (sel.hasClass('fancified') || sel[0].tagName !== 'SELECT') {
        return;
      }
      sel.addClass('fancified');
      sel.css({
        width: 1,
        height: 1,
        display: 'block',
        position: 'absolute',
        top: 0,
        left: 0,
        opacity: 0
      });
      sel.wrap('<div class="fancy-select">');
      wrapper = sel.parent();
      if (sel.data('class')) {
        wrapper.addClass(sel.data('class'));
      }
      wrapper.append('<div class="trigger">');
      if (!(isiOS && !settings.forceiOS)) {
        wrapper.append('<ul class="options">');
      }
      trigger = wrapper.find('.trigger');
      options = wrapper.find('.options');
      disabled = sel.prop('disabled');
      if (disabled) {
        wrapper.addClass('disabled');
      }
      updateTriggerText = function() {
        return trigger.text(sel.find(':selected').text());
      };
      sel.on('blur', function() {
        if (trigger.hasClass('open')) {
          return setTimeout(function() {
            return trigger.trigger('close');
          }, 120);
        }
      });
      trigger.on('close', function() {
        trigger.removeClass('open');
        return options.removeClass('open');
      });
      trigger.on('click', function() {
        var offParent, parent;
        if (!disabled) {
          trigger.toggleClass('open');
          if (isiOS && !settings.forceiOS) {
            if (trigger.hasClass('open')) {
              return sel.focus();
            }
          } else {
            if (trigger.hasClass('open')) {
              parent = trigger.parent();
              offParent = parent.offsetParent();
              if ((parent.offset().top + parent.outerHeight() + options.outerHeight() + 20) > $(window).height()) {
                options.addClass('overflowing');
              } else {
                options.removeClass('overflowing');
              }
            }
            options.toggleClass('open');
            if (!isiOS) {
              return sel.focus();
            }
          }
        }
      });
      sel.on('enable', function() {
        sel.prop('disabled', false);
        wrapper.removeClass('disabled');
        disabled = false;
        return copyOptionsToList();
      });
      sel.on('disable', function() {
        sel.prop('disabled', true);
        wrapper.addClass('disabled');
        return disabled = true;
      });
      sel.on('change', function(e) {
        if (e.originalEvent && e.originalEvent.isTrusted) {
          return e.stopPropagation();
        } else {
          return updateTriggerText();
        }
      });
      sel.on('keydown', function(e) {
        var hovered, newHovered, w;
        w = e.which;
        hovered = options.find('.hover');
        hovered.removeClass('hover');
        if (!options.hasClass('open')) {
          if (w === 13 || w === 32 || w === 38 || w === 40) {
            e.preventDefault();
            return trigger.trigger('click');
          }
        } else {
          if (w === 38) {
            e.preventDefault();
            if (hovered.length && hovered.index() > 0) {
              hovered.prev().addClass('hover');
            } else {
              options.find('li:last-child').addClass('hover');
            }
          } else if (w === 40) {
            e.preventDefault();
            if (hovered.length && hovered.index() < options.find('li').length - 1) {
              hovered.next().addClass('hover');
            } else {
              options.find('li:first-child').addClass('hover');
            }
          } else if (w === 27) {
            e.preventDefault();
            trigger.trigger('click');
          } else if (w === 13 || w === 32) {
            e.preventDefault();
            hovered.trigger('click');
          } else if (w === 9) {
            if (trigger.hasClass('open')) {
              trigger.trigger('close');
            }
          }
          newHovered = options.find('.hover');
          if (newHovered.length) {
            options.scrollTop(0);
            return options.scrollTop(newHovered.position().top - 12);
          }
        }
      });
      options.on('click', 'li', function(e) {
        sel.val($(this).data('value'));
        if (!isiOS) {
          sel.trigger('blur').trigger('focus');
        }
        options.find('.selected').removeClass('selected');
        $(e.currentTarget).addClass('selected');
        return sel.val($(this).data('value')).trigger('change').trigger('blur').trigger('focus');
      });
      options.on('mouseenter', 'li', function() {
        var hovered, nowHovered;
        nowHovered = $(this);
        hovered = options.find('.hover');
        hovered.removeClass('hover');
        return nowHovered.addClass('hover');
      });
      options.on('mouseleave', 'li', function() {
        return options.find('.hover').removeClass('hover');
      });
      copyOptionsToList = function() {
        var selOpts;
        updateTriggerText();
        if (isiOS && !settings.forceiOS) {
          return;
        }
        selOpts = sel.find('option');
        return sel.find('option').each(function(i, opt) {
          opt = $(opt);
          if (opt.val() && !opt.prop('disabled')) {
            if (opt.prop('selected')) {
              return options.append("<li data-value=\"" + (opt.val()) + "\" class=\"selected\">" + (opt.text()) + "</li>");
            } else {
              return options.append("<li data-value=\"" + (opt.val()) + "\">" + (opt.text()) + "</li>");
            }
          }
        });
      };
      sel.on('update', function() {
        wrapper.find('.options').empty();
        return copyOptionsToList();
      });
      return copyOptionsToList();
    });
  };

}).call(this);

;(function(e,t,n,r){function u(t,n){this.element=t;this.options=e.extend({},o,n);this._defaults=o;this._name=s;this.init()}function a(){return!!("ontouchstart"in t)}function f(){var e=n.body||n.documentElement;var t=e.style;var r="transition";if(typeof t[r]=="string"){return true}v=["Moz","Webkit","Khtml","O","ms"],r=r.charAt(0).toUpperCase()+r.substr(1);for(var i=0;i<v.length;i++){if(typeof t[v[i]+r]=="string"){return true}}return false}var s="tooltipster",o={animation:"fade",arrow:true,arrowColor:"",content:"",delay:200,fixedWidth:0,maxWidth:0,functionInit:function(e,t){},functionBefore:function(e,t){t()},functionReady:function(e,t){},functionAfter:function(e){},icon:"(?)",iconDesktop:false,iconTouch:false,iconTheme:".tooltipster-icon",interactive:false,interactiveTolerance:350,interactiveAutoClose:true,offsetX:0,offsetY:0,onlyOne:true,position:"top",speed:350,timer:0,theme:".tooltipster-default",touchDevices:true,trigger:"hover",updateAnimation:true};var l=true;if(!f()){l=false}var c=a();e(t).on("mousemove.tooltipster",function(){c=false;e(t).off("mousemove.tooltipster")});u.prototype={init:function(){var t=e(this.element);var i=this;var s=true;if(!i.options.touchDevices&&c){s=false}if(n.all&&!n.querySelector){s=false}if(s){var o=e.trim(i.options.content).length>0?i.options.content:t.attr("title");var u=i.options.functionInit(t,o);if(u)o=u;t.data("tooltipsterContent",o);t.removeAttr("title");if(i.options.iconDesktop&&!c||i.options.iconTouch&&c){var a=i.options.iconTheme;var f=e('<span class="'+a.replace(".","")+'"></span>');f.data("tooltipsterContent",o).append(i.options.icon).insertAfter(t);t.data("tooltipsterIcon",f);t=f}if(i.options.touchDevices&&c&&(i.options.trigger=="click"||i.options.trigger=="hover")){t.on("touchstart.tooltipster",function(e,t){i.showTooltip()})}else{if(i.options.trigger=="hover"){t.on("mouseenter.tooltipster",function(){i.showTooltip()});if(i.options.interactive){t.on("mouseleave.tooltipster",function(){var n=t.data("tooltipster");var s=false;if(n!==r&&n!==""){n.mouseenter(function(){s=true});n.mouseleave(function(){s=false});var o=setTimeout(function(){if(s){if(i.options.interactiveAutoClose){n.find("select").on("change",function(){i.hideTooltip()});n.mouseleave(function(t){var n=e(t.target);if(n.parents(".tooltipster-base").length===0||n.hasClass("tooltipster-base")){i.hideTooltip()}else{n.on("mouseleave",function(e){i.hideTooltip()})}})}}else{i.hideTooltip()}},i.options.interactiveTolerance)}else{i.hideTooltip()}})}else{t.on("mouseleave.tooltipster",function(){i.hideTooltip()})}}if(i.options.trigger=="click"){t.on("click.tooltipster",function(){if(t.data("tooltipster")===""||t.data("tooltipster")===r){i.showTooltip()}else{i.hideTooltip()}})}}}},showTooltip:function(t){var n=e(this.element);var i=this;if(n.data("tooltipsterIcon")!==r){n=n.data("tooltipsterIcon")}if(!n.hasClass("tooltipster-disable")){if(e(".tooltipster-base").not(".tooltipster-dying").length>0&&i.options.onlyOne){e(".tooltipster-base").not(".tooltipster-dying").not(n.data("tooltipster")).each(function(){e(this).addClass("tooltipster-kill");var t=e(this).data("origin");t.data("plugin_tooltipster").hideTooltip()})}n.clearQueue().delay(i.options.delay).queue(function(){i.options.functionBefore(n,function(){if(n.data("tooltipster")!==r&&n.data("tooltipster")!==""){var t=n.data("tooltipster");if(!t.hasClass("tooltipster-kill")){var s="tooltipster-"+i.options.animation;t.removeClass("tooltipster-dying");if(l){t.clearQueue().addClass(s+"-show")}if(i.options.timer>0){var o=t.data("tooltipsterTimer");clearTimeout(o);o=setTimeout(function(){t.data("tooltipsterTimer",r);i.hideTooltip()},i.options.timer);t.data("tooltipsterTimer",o)}if(i.options.touchDevices&&c){e("body").bind("touchstart",function(t){if(i.options.interactive){var n=e(t.target);var r=true;n.parents().each(function(){if(e(this).hasClass("tooltipster-base")){r=false}});if(r){i.hideTooltip();e("body").unbind("touchstart")}}else{i.hideTooltip();e("body").unbind("touchstart")}})}}}else{i.options._bodyOverflowX=e("body").css("overflow-x");e("body").css("overflow-x","hidden");var u=i.getContent(n);var a=i.options.theme;var h=a.replace(".","");var s="tooltipster-"+i.options.animation;var p="-webkit-transition-duration: "+i.options.speed+"ms; -webkit-animation-duration: "+i.options.speed+"ms; -moz-transition-duration: "+i.options.speed+"ms; -moz-animation-duration: "+i.options.speed+"ms; -o-transition-duration: "+i.options.speed+"ms; -o-animation-duration: "+i.options.speed+"ms; -ms-transition-duration: "+i.options.speed+"ms; -ms-animation-duration: "+i.options.speed+"ms; transition-duration: "+i.options.speed+"ms; animation-duration: "+i.options.speed+"ms;";var d=i.options.fixedWidth>0?"width:"+Math.round(i.options.fixedWidth)+"px;":"";var v=i.options.maxWidth>0?"max-width:"+Math.round(i.options.maxWidth)+"px;":"";var m=i.options.interactive?"pointer-events: auto;":"";var t=e('<div class="tooltipster-base '+h+" "+s+'" style="'+d+" "+v+" "+m+" "+p+'"></div>');var g=e('<div class="tooltipster-content"></div>');g.html(u);t.append(g);t.appendTo("body");n.data("tooltipster",t);t.data("origin",n);i.positionTooltip();i.options.functionReady(n,t);if(l){t.addClass(s+"-show")}else{t.css("display","none").removeClass(s).fadeIn(i.options.speed)}var y=u;var b=setInterval(function(){var r=i.getContent(n);if(e("body").find(n).length===0){t.addClass("tooltipster-dying");i.hideTooltip()}else if(y!==r&&r!==""){y=r;t.find(".tooltipster-content").html(r);if(i.options.updateAnimation){if(f()){t.css({width:"","-webkit-transition":"all "+i.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms","-moz-transition":"all "+i.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms","-o-transition":"all "+i.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms","-ms-transition":"all "+i.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms",transition:"all "+i.options.speed+"ms, width 0ms, height 0ms, left 0ms, top 0ms"}).addClass("tooltipster-content-changing");setTimeout(function(){t.removeClass("tooltipster-content-changing");setTimeout(function(){t.css({"-webkit-transition":i.options.speed+"ms","-moz-transition":i.options.speed+"ms","-o-transition":i.options.speed+"ms","-ms-transition":i.options.speed+"ms",transition:i.options.speed+"ms"})},i.options.speed)},i.options.speed)}else{t.fadeTo(i.options.speed,.5,function(){t.fadeTo(i.options.speed,1)})}}i.positionTooltip()}if(e("body").find(t).length===0||e("body").find(n).length===0){clearInterval(b)}},200);if(i.options.timer>0){var o=setTimeout(function(){t.data("tooltipsterTimer",r);i.hideTooltip()},i.options.timer+i.options.speed);t.data("tooltipsterTimer",o)}if(i.options.touchDevices&&c){e("body").bind("touchstart",function(t){if(i.options.interactive){var n=e(t.target);var r=true;n.parents().each(function(){if(e(this).hasClass("tooltipster-base")){r=false}});if(r){i.hideTooltip();e("body").unbind("touchstart")}}else{i.hideTooltip();e("body").unbind("touchstart")}})}}});n.dequeue()})}},hideTooltip:function(t){var n=e(this.element);var i=this;if(n.data("tooltipsterIcon")!==r){n=n.data("tooltipsterIcon")}var s=n.data("tooltipster");if(s===r){s=e(".tooltipster-dying")}n.clearQueue();if(s!==r&&s!==""){var o=s.data("tooltipsterTimer");if(o!==r){clearTimeout(o)}var u="tooltipster-"+i.options.animation;if(l){s.clearQueue().removeClass(u+"-show").addClass("tooltipster-dying").delay(i.options.speed).queue(function(){s.remove();n.data("tooltipster","");e("body").css("overflow-x",i.options._bodyOverflowX);i.options.functionAfter(n)})}else{s.clearQueue().addClass("tooltipster-dying").fadeOut(i.options.speed,function(){s.remove();n.data("tooltipster","");e("body").css("overflow-x",i.options._bodyOverflowX);i.options.functionAfter(n)})}}},positionTooltip:function(n){var s=e(this.element);var o=this;if(s.data("tooltipsterIcon")!==r){s=s.data("tooltipsterIcon")}if(s.data("tooltipster")!==r&&s.data("tooltipster")!==""){var u=s.data("tooltipster");u.css("width","");var a=e(t).width();var f=s.outerWidth(false);var l=s.outerHeight(false);var c=u.outerWidth(false);var h=u.innerWidth()+1;var p=u.outerHeight(false);var d=s.offset();var v=d.top;var m=d.left;var g=r;if(s.is("area")){var y=s.attr("shape");var b=s.parent().attr("name");var w=e('img[usemap="#'+b+'"]');var E=w.offset().left;var S=w.offset().top;var x=s.attr("coords")!==r?s.attr("coords").split(","):r;if(y=="circle"){var T=parseInt(x[0]);var N=parseInt(x[1]);var C=parseInt(x[2]);l=C*2;f=C*2;v=S+N-C;m=E+T-C}else if(y=="rect"){var T=parseInt(x[0]);var N=parseInt(x[1]);var k=parseInt(x[2]);var L=parseInt(x[3]);l=L-N;f=k-T;v=S+N;m=E+T}else if(y=="poly"){var A=[];var O=[];var M=0,_=0,D=0,P=0;var H="even";for(i=0;i<x.length;i++){var B=parseInt(x[i]);if(H=="even"){if(B>D){D=B;if(i===0){M=D}}if(B<M){M=B}H="odd"}else{if(B>P){P=B;if(i==1){_=P}}if(B<_){_=B}H="even"}}l=P-_;f=D-M;v=S+_;m=E+M}else{l=w.outerHeight(false);f=w.outerWidth(false);v=S;m=E}}if(o.options.fixedWidth===0){u.css({width:Math.round(h)+"px","padding-left":"0px","padding-right":"0px"})}var j=0,F=0,I=0;var q=parseInt(o.options.offsetY);var R=parseInt(o.options.offsetX);var U="";function z(){var n=e(t).scrollLeft();if(j-n<0){var r=j-n;j=n;u.data("arrow-reposition",r)}if(j+c-n>a){var r=j-(a+n-c);j=a+n-c;u.data("arrow-reposition",r)}}function W(n,r){if(v-e(t).scrollTop()-p-q-12<0&&r.indexOf("top")>-1){o.options.position=n;g=r}if(v+l+p+12+q>e(t).scrollTop()+e(t).height()&&r.indexOf("bottom")>-1){o.options.position=n;g=r;I=v-p-q-12}}if(o.options.position=="top"){var X=m+c-(m+f);j=m+R-X/2;I=v-p-q-12;z();W("bottom","top")}if(o.options.position=="top-left"){j=m+R;I=v-p-q-12;z();W("bottom-left","top-left")}if(o.options.position=="top-right"){j=m+f+R-c;I=v-p-q-12;z();W("bottom-right","top-right")}if(o.options.position=="bottom"){var X=m+c-(m+f);j=m-X/2+R;I=v+l+q+12;z();W("top","bottom")}if(o.options.position=="bottom-left"){j=m+R;I=v+l+q+12;z();W("top-left","bottom-left")}if(o.options.position=="bottom-right"){j=m+f+R-c;I=v+l+q+12;z();W("top-right","bottom-right")}if(o.options.position=="left"){j=m-R-c-12;F=m+R+f+12;var V=v+p-(v+s.outerHeight(false));I=v-V/2-q;if(j<0&&F+c>a){var J=parseFloat(u.css("border-width"))*2;var K=c+j-J;u.css("width",K+"px");p=u.outerHeight(false);j=m-R-K-12-J;V=v+p-(v+s.outerHeight(false));I=v-V/2-q}else if(j<0){j=m+R+f+12;u.data("arrow-reposition","left")}}if(o.options.position=="right"){j=m+R+f+12;F=m-R-c-12;var V=v+p-(v+s.outerHeight(false));I=v-V/2-q;if(j+c>a&&F<0){var J=parseFloat(u.css("border-width"))*2;var K=a-j-J;u.css("width",K+"px");p=u.outerHeight(false);V=v+p-(v+s.outerHeight(false));I=v-V/2-q}else if(j+c>a){j=m-R-c-12;u.data("arrow-reposition","right")}}if(o.options.arrow){var Q="tooltipster-arrow-"+o.options.position;if(o.options.arrowColor.length<1){var G=u.css("background-color")}else{var G=o.options.arrowColor}var Y=u.data("arrow-reposition");if(!Y){Y=""}else if(Y=="left"){Q="tooltipster-arrow-right";Y=""}else if(Y=="right"){Q="tooltipster-arrow-left";Y=""}else{Y="left:"+Math.round(Y)+"px;"}if(o.options.position=="top"||o.options.position=="top-left"||o.options.position=="top-right"){var Z=parseFloat(u.css("border-bottom-width"));var et=u.css("border-bottom-color")}else if(o.options.position=="bottom"||o.options.position=="bottom-left"||o.options.position=="bottom-right"){var Z=parseFloat(u.css("border-top-width"));var et=u.css("border-top-color")}else if(o.options.position=="left"){var Z=parseFloat(u.css("border-right-width"));var et=u.css("border-right-color")}else if(o.options.position=="right"){var Z=parseFloat(u.css("border-left-width"));var et=u.css("border-left-color")}else{var Z=parseFloat(u.css("border-bottom-width"));var et=u.css("border-bottom-color")}if(Z>1){Z++}var tt="";if(Z!==0){var nt="";var rt="border-color: "+et+";";if(Q.indexOf("bottom")!==-1){nt="margin-top: -"+Math.round(Z)+"px;"}else if(Q.indexOf("top")!==-1){nt="margin-bottom: -"+Math.round(Z)+"px;"}else if(Q.indexOf("left")!==-1){nt="margin-right: -"+Math.round(Z)+"px;"}else if(Q.indexOf("right")!==-1){nt="margin-left: -"+Math.round(Z)+"px;"}tt='<span class="tooltipster-arrow-border" style="'+nt+" "+rt+';"></span>'}u.find(".tooltipster-arrow").remove();U='<div class="'+Q+' tooltipster-arrow" style="'+Y+'">'+tt+'<span style="border-color:'+G+';"></span></div>';u.append(U)}u.css({top:Math.round(I)+"px",left:Math.round(j)+"px"});if(g!==r){o.options.position=g}}},getContent:function(t){var n=t.data("tooltipsterContent");n=e(e.parseHTML("<div>"+n+"</div>")).html();return n}};e.fn[s]=function(t){if(t&&t==="setDefaults"){e.extend(o,arguments[1])}else{if(typeof t==="string"){var n=this;var i=arguments[1];var a=null;if(n.data("plugin_tooltipster")===r){var f=n.find("*");n=e();f.each(function(){if(e(this).data("plugin_tooltipster")!==r){n.push(e(this))}})}n.each(function(){switch(t.toLowerCase()){case"show":e(this).data("plugin_tooltipster").showTooltip();break;case"hide":e(this).data("plugin_tooltipster").hideTooltip();break;case"disable":e(this).addClass("tooltipster-disable");break;case"enable":e(this).removeClass("tooltipster-disable");break;case"destroy":e(this).data("plugin_tooltipster").hideTooltip();var s=e(this).data("tooltipsterIcon");if(s)s.remove();e(this).attr("title",n.data("tooltipsterContent")).removeData("plugin_tooltipster").removeData("tooltipsterContent").removeData("tooltipsterIcon").off(".tooltipster");break;case"elementicon":a=e(this).data("tooltipsterIcon");a=a?a[0]:r;return false;case"update":var o=i;if(e(this).data("tooltipsterIcon")===r){e(this).data("tooltipsterContent",o)}else{var u=e(this).data("tooltipsterIcon");u.data("tooltipsterContent",o)}break;case"reposition":e(this).data("plugin_tooltipster").positionTooltip();break;case"val":a=e(this).data("tooltipsterContent");console.log(a);return false}});return a!==null?a:this}else{return this.each(function(){if(!e.data(this,"plugin_"+s)){e.data(this,"plugin_"+s,new u(this,t))}})}}};if(c){t.addEventListener("orientationchange",function(){if(e(".tooltipster-base").length>0){e(".tooltipster-base").each(function(){var t=e(this).data("origin");t.data("plugin_tooltipster").hideTooltip()})}},false)}e(t).on("scroll.tooltipster",function(){var t=e(".tooltipster-base").data("origin");if(t){t.tooltipster("reposition")}});e(t).on("resize.tooltipster",function(){var t=e(".tooltipster-base").data("origin");if(t!==null&&t!==r){t.tooltipster("reposition")}})})(jQuery,window,document);


/*!
 * validetta - Client-side form validation jQuery plugin
 * Version: 0.6.0 (15 November 2013) | Copyright 2013 Hasan Aydoğdu - http://www.hasanaydogdu.com
 */
(function(g){var e={},a={},d=new RegExp(/(minChecked|maxChecked|minSelected|maxSelected|minLength|maxLength|equal|customReg)\[[(\w)-_]{1,15}\]/i),c=new RegExp(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/),b=new RegExp(/^[\-\+]?\d+\.?\d*$/);var f={empty:"This field is required. Please be sure to check.",email:"Your E-mail address appears to be invalid. Please be sure to check.",number:"You can enter only numbers in this field.",maxLength:"Maximum {count} characters allowed!",minLength:"Minimum {count} characters allowed!",checkbox:"This checkbox is required. Please be sure to check.",maxChecked:"Maximum {count} options allowed. Please be sure to check.",minChecked:"Please select minimum {count} options.",selectbox:"Please select an option.",maxSelected:"Maximum {count} selection allowed. Please be sure to check.",minSelected:"Minimum {count} selection allowed. Please be sure to check.",notEqual:"Fields do not match. Please be sure to check.",creditCard:"Invalid credit card number. Please be sure to check."};var h={errorClass:"validetta-error",errorCloseClass:"validetta-errorClose",ajax:{call:false,type:"GET",url:null,dataType:"html",beforeSend:g.noop,success:g.noop,fail:g.noop,complete:g.noop},realTime:false,onCompleteFunc:g.noop,customReg:{}};e=function(j,i){this.handler=false;this.options=g.extend(true,{},h,i);this.form=j;return this.events.call(this)};e.prototype.events=function(){var i=this;g(this.form).submit(function(j){a=this.querySelectorAll("[data-validetta]");return i.init.call(i,j)});if(this.options.realTime===true){g(this.form).find("[data-validetta]").not("[type=checkbox]").on("change",function(j){a=g(this);return i.init.call(i,j)});g(this.form).find("[data-validetta][type=checkbox]").on("click",function(j){a=i.form.querySelectorAll("[data-validetta][type=checkbox][name="+this.name+"]");return i.init.call(i,j)})}g(this.form).find("[type=reset]").on("click",function(){return i.reset.call(i)});g(this.form).on("click","."+this.options.errorCloseClass,function(){var j=this.parentNode;if(j){i.window.close.call(i,j)}return false})};e.prototype.init=function(r){var q=this;this.reset.call(this,a);for(var p=a.length-1;p>=0;p--){var s,m,o=[],l=[];s=a[p];m="";o=g(s).val();l=s.getAttribute("data-validetta").split(",");for(var n=l.length-1;n>=0;n--){if(l[n]==="required"){var k=s.getAttribute("type");if(k==="checkbox"&&!q.check.checkbox.checked(s)){m+=f.checkbox+"<br />"}else{if(s.tagName==="SELECT"&&!q.check.selectbox.selected(o)){m+=f.selectbox+"<br />"}}if((k==="text"||k==="password"||s.tagName==="TEXTAREA")&&!q.check.empty.call(q,o)){m+=f.empty+"<br />"}}if(l[n]==="number"&&!q.check.number(o)){m+=f.number+"<br />"}if(l[n]==="email"&&!q.check.mail(o)){m+=f.email+"<br />"}if(l[n]==="creditCard"&&o!==""&&!q.check.creditCard(o)){m+=f.creditCard+"<br />"}if(d.test(l[n])){var t=l[n].split(/\[|,|\]/);if(t[0]==="maxLength"&&!q.check.maxLength(o,t[1])){m+=f.maxLength.replace("{count}",t[1])+"<br />"}else{if(t[0]==="minLength"&&!q.check.minLength(o,t[1])){m+=f.minLength.replace("{count}",t[1])+"<br />"}else{if(t[0]==="maxChecked"&&!q.check.checkbox.maxChecked.call(q,s,t[1])){s=q.form.querySelectorAll("input[type=checkbox][data-validetta][name="+s.name+"]")[0];m+=f.maxChecked.replace("{count}",t[1])+"<br />"}else{if(t[0]==="minChecked"&&!q.check.checkbox.minChecked.call(q,s,t[1])){s=q.form.querySelectorAll("input[type=checkbox][data-validetta][name="+s.name+"]")[0];m+=f.minChecked.replace("{count}",t[1])+"<br />"}else{if(t[0]==="maxSelected"&&!q.check.selectbox.maxSelected(o,t[1])){m+=f.maxSelected.replace("{count}",t[1])+"<br />"}else{if(t[0]==="minSelected"&&!q.check.selectbox.minSelected(o,t[1])){m+=f.minSelected.replace("{count}",t[1])+"<br />"}else{if(t[0]==="equal"&&!q.check.equal.call(q,o,t[1])){m+=f.notEqual+"<br />"}else{if(t[0]==="customReg"&&!q.check.customReg(o,q.options.customReg[t[1]].method)){m+=(q.options.customReg[t[1]].errorMessage||f.empty)+"<br />"}}}}}}}}}}if(m!==""){q.window.open.call(q,s,m)}}if(r.type!=="submit"){return}else{if(q.handler===true){return false}else{if(q.options.ajax.call){q.ajax.call(q,arguments);return false}return q.options.onCompleteFunc(q,r)}}};e.prototype.check={empty:function(i){return(this.clear(i)==="")?false:true},mail:function(i){return((c.test(i)===false)&&i!=="")?false:true},number:function(i){return((b.test(i)===false)&&i!=="")?false:true},minLength:function(j,i){var k=j.length;return(k<i&&k!==0)?false:true},maxLength:function(j,i){return(j.length>i)?false:true},equal:function(j,i){return(g(this.form).find("input[name="+i+"]").val()!==j)?false:true},creditCard:function(k){var j,r,o,p,l,n,m=0,q;j=new RegExp(/[^0-9]+/g);r=k.replace(j,"");q=r.length;if(q<16){return false}for(l=0;l<q;l++){o=q-l;p=parseInt(r.substring(o-1,o),10);if(l%2===1){n=p*2;if(n>9){n=1+(n-10)}}else{n=p}m+=n}if(m>0&&m%10===0){return true}return false},checkbox:{checked:function(i){return(!i.checked)?false:true},maxChecked:function(k,i){var j=g(this.form.querySelectorAll("input[type=checkbox][name="+k.name+"]")).filter(":checked").length;return(j>i)?false:true},minChecked:function(k,i){var j=g(this.form.querySelectorAll("input[type=checkbox][name="+k.name+"]")).filter(":checked").length;return(j<i)?false:true}},selectbox:{selected:function(i){return(i===""||i===null)?false:true},maxSelected:function(j,i){return(j!==null&&j!==""&&j.length>i)?false:true},minSelected:function(j,i){return(j!==null&&j!==""&&j.length<i)?false:true}},customReg:function(k,i){var j=new RegExp(i);return((j.test(k)===false)&&k!=="")?false:true}};e.prototype.window={open:function(q,n){var m=q.parentNode;if(typeof m==="undefined"){m=q[0].parentNode}if(g(m).find("."+this.options.errorClass).length>0){return}var o,j,p,l,i,k;o=g(q).position();j=g(q).width();p=g(q).height();l=o.top;i=document.createElement("span");i.className=this.options.errorClass;k=document.createElement("span");k.innerHTML="x";k.className=this.options.errorCloseClass;g(i).empty().css({left:o.left+j+30+"px",top:l+"px"});m.appendChild(i);i.innerHTML=n;i.appendChild(k);this.handler=true},close:function(i){i.parentNode.removeChild(i);this.handler=false}};e.prototype.reset=function(k){var l={};if(typeof k==="undefined"||(k.length>1&&k[0].getAttribute("type")!=="checkbox")){l=g(this.form).find("."+this.options.errorClass)}else{l=g(k[0].parentNode).find("."+this.options.errorClass)}for(var j=l.length-1;j>=0;j--){this.window.close.call(this,l[j])}};e.prototype.clear=function(i){return i.replace(/^\s+|\s+$/g,"")};e.prototype.ajax=function(){var l,j,k=this,i;l=g(this.form).serialize();i=this.form.getAttribute("action");j=(this.options.ajax.url)?this.options.ajax.url:i;if(!this.options.ajax.url&&(i===""||i===null)){return console.log("Form action not valid !")}g.ajax({type:k.options.ajax.type,url:j,data:l,dataType:k.options.ajax.dataType,options:k.options,beforeSend:function(){return k.options.ajax.beforeSend()}}).done(function(m){k.options.ajax.success(k,m)}).fail(function(m,n){k.options.ajax.fail(m,n)}).always(function(m){k.options.ajax.complete(m)})};g.fn.validetta=function(i){if(g.validettaLanguage){f=g.extend(true,{},f,g.validettaLanguage.messages)}return this.each(function(){new e(this,i);return this})}})(jQuery);

// Ion.RangeSlider
// version 1.8.2
// https://github.com/IonDen/ion.rangeSlider
(function(c,X,ea,S){var Y=0,O=function(){var c=S.userAgent,a=/msie\s\d+/i;return 0<c.search(a)&&(c=a.exec(c).toString(),c=c.split(" ")[1],9>c)?!0:!1}(),H;try{X.createEvent("TouchEvent"),H=!0}catch(ga){H=!1}var N={init:function(A){return this.each(function(){var a=c.extend({min:10,max:100,from:null,to:null,type:"single",step:1,prefix:"",postfix:"",hasGrid:!1,hideMinMax:!1,hideFromTo:!1,prettify:!0,onChange:null,onLoad:null,onFinish:null},A),d=c(this),u=this;if(!d.data("isActive")){d.data("isActive",
!0);this.pluginCount=Y+=1;d.prop("value")&&(a.min=parseInt(d.prop("value").split(";")[0],10),a.max=parseInt(d.prop("value").split(";")[1],10));"number"!==typeof a.from&&(a.from=a.min);"number"!==typeof a.to&&(a.to=a.max);"number"===typeof d.data("from")&&(a.from=parseFloat(d.data("from")));"number"===typeof d.data("to")&&(a.to=parseFloat(d.data("to")));d.data("step")&&(a.step=parseFloat(d.data("step")));d.data("type")&&(a.type=d.data("type"));d.data("prefix")&&(a.prefix=d.data("prefix"));d.data("postfix")&&
(a.postfix=d.data("postfix"));d.data("hasgrid")&&(a.hasGrid=d.data("hasgrid"));d.data("hideminmax")&&(a.hideMinMax=d.data("hideminmax"));d.data("hidefromto")&&(a.hideFromTo=d.data("hidefromto"));d.data("prettify")&&(a.prettify=d.data("prettify"));a.from<a.min&&(a.from=a.min);a.to>a.max&&(a.to=a.max);"double"===a.type&&(a.from>a.to&&(a.from=a.to),a.to<a.from&&(a.to=a.from));var v=function(b){b=b.toString();a.prettify&&(b=b.replace(/(\d{1,3}(?=(?:\d\d\d)+(?!\d)))/g,"$1 "));return b},N='<span class="irs" id="irs-'+
this.pluginCount+'"></span>';d[0].style.display="none";d.before(N);var w=c("#irs-"+this.pluginCount),C=c(X.body),I=c(ea),l,D,E,x,y,q,r,e,m,s,T,Z,p=!1,t=!1,P=!0,g={},U=0,J=0,K=0,k=0,B=0,L=0,V=0,Q=0,R=0,$=0,n=0;parseInt(a.step,10)!==parseFloat(a.step)&&(n=a.step.toString().split(".")[1],n=Math.pow(10,n.length));this.updateData=function(b){P=!0;a=c.extend(a,b);w.find("*").off();I.off("mouseup.irs"+u.pluginCount);C.off("mouseup.irs"+u.pluginCount);C.off("mousemove.irs"+u.pluginCount);w.html("");aa()};
this.removeSlider=function(){w.find("*").off();I.off("mouseup.irs"+u.pluginCount);C.off("mouseup.irs"+u.pluginCount);C.off("mousemove.irs"+u.pluginCount);w.html("").remove();d.data("isActive",!1);d.show()};var aa=function(){w.html('<span class="irs"><span class="irs-line"><span class="irs-line-left"></span><span class="irs-line-mid"></span><span class="irs-line-right"></span></span><span class="irs-min">0</span><span class="irs-max">1</span><span class="irs-from">0</span><span class="irs-to">0</span><span class="irs-single">0</span></span><span class="irs-grid"></span>');
l=w.find(".irs");D=l.find(".irs-min");E=l.find(".irs-max");x=l.find(".irs-from");y=l.find(".irs-to");q=l.find(".irs-single");Z=w.find(".irs-grid");a.hideMinMax&&(D[0].style.display="none",E[0].style.display="none",K=J=0);a.hideFromTo&&(x[0].style.display="none",y[0].style.display="none",q[0].style.display="none");a.hideMinMax||(D.html(a.prefix+v(a.min)+a.postfix),E.html(a.prefix+v(a.max)+a.postfix),J=D.outerWidth(),K=E.outerWidth());if("single"===a.type){if(l.append('<span class="irs-slider single"></span>'),
r=l.find(".single"),r.on("mousedown",function(a){a.preventDefault();a.stopPropagation();F(a,c(this),null);t=p=!0;O&&c("*").prop("unselectable",!0)}),H)r.on("touchstart",function(a){a.preventDefault();a.stopPropagation();F(a.originalEvent.touches[0],c(this),null);t=p=!0})}else"double"===a.type&&(l.append('<span class="irs-diapason"></span><span class="irs-slider from"></span><span class="irs-slider to"></span>'),e=l.find(".from"),m=l.find(".to"),T=l.find(".irs-diapason"),M(),e.on("mousedown",function(a){a.preventDefault();
a.stopPropagation();c(this).addClass("last");m.removeClass("last");F(a,c(this),"from");t=p=!0;O&&c("*").prop("unselectable",!0)}),m.on("mousedown",function(a){a.preventDefault();a.stopPropagation();c(this).addClass("last");e.removeClass("last");F(a,c(this),"to");t=p=!0;O&&c("*").prop("unselectable",!0)}),H&&(e.on("touchstart",function(a){a.preventDefault();a.stopPropagation();c(this).addClass("last");m.removeClass("last");F(a.originalEvent.touches[0],c(this),"from");t=p=!0}),m.on("touchstart",function(a){a.preventDefault();
a.stopPropagation();c(this).addClass("last");e.removeClass("last");F(a.originalEvent.touches[0],c(this),"to");t=p=!0})),a.to===a.max&&e.addClass("last"));var b=function(){p&&(p=t=!1,s.removeAttr("id"),s=null,"double"===a.type&&M(),W(),O&&c("*").prop("unselectable",!1))};C.on("mouseup.irs"+u.pluginCount,function(){b()});I.on("mouseup.irs"+u.pluginCount,function(){b()});C.on("mousemove.irs"+u.pluginCount,function(a){p&&(U=a.pageX,ba())});H&&(I.on("touchend",function(){p&&(p=t=!1,s.removeAttr("id"),
s=null,"double"===a.type&&M(),W())}),I.on("touchmove",function(a){p&&(U=a.originalEvent.touches[0].pageX,ba())}));ca();S();a.hasGrid&&fa()},ca=function(){k=l.width();L=r?r.width():e.width();B=k-L},F=function(b,f,c){ca();P=!1;s=f;s.attr("id","irs-active-slider");f=s.offset().left;$=f+(b.pageX-f)-s.position().left;"single"===a.type?V=l.width()-L:"double"===a.type&&("from"===c?(Q=0,R=parseInt(m.css("left"),10)):(Q=parseInt(e.css("left"),10),R=l.width()-L))},M=function(){var a=e.width(),f=c.data(e[0],
"x")||parseInt(e[0].style.left,10)||e.position().left,G=(c.data(m[0],"x")||parseInt(m[0].style.left,10)||m.position().left)-f;T[0].style.left=f+a/2+"px";T[0].style.width=G+"px"},ba=function(){var b=U-$;"single"===a.type?(0>b&&(b=0),b>V&&(b=V)):"double"===a.type&&(b<Q&&(b=Q),b>R&&(b=R),M());c.data(s[0],"x",b);W();b=Math.round(b);s[0].style.left=b+"px"},W=function(){var b={fromNumber:0,toNumber:0,fromPers:0,toPers:0,fromX:0,toX:0},f=a.max-a.min,G;"single"===a.type?(b.fromX=c.data(r[0],"x")||parseInt(r[0].style.left,
10)||r.position().left,b.fromPers=b.fromX/B*100,G=f/100*b.fromPers+parseInt(a.min,10),b.fromNumber=Math.round(G/a.step)*a.step,n&&(b.fromNumber=parseInt(b.fromNumber*n,10)/n)):"double"===a.type&&(b.fromX=c.data(e[0],"x")||parseInt(e[0].style.left,10)||e.position().left,b.fromPers=b.fromX/B*100,G=f/100*b.fromPers+parseInt(a.min,10),b.fromNumber=Math.round(G/a.step)*a.step,b.toX=c.data(m[0],"x")||parseInt(m[0].style.left,10)||m.position().left,b.toPers=b.toX/B*100,f=f/100*b.toPers+parseInt(a.min,10),
b.toNumber=Math.round(f/a.step)*a.step,n&&(b.fromNumber=parseInt(b.fromNumber*n,10)/n,b.toNumber=parseInt(b.toNumber*n,10)/n));g=b;da()},S=function(){var b={fromNumber:a.from,toNumber:a.to,fromPers:0,toPers:0,fromX:0,fromX_pure:0,toX:0,toX_pure:0},f=a.max-a.min;"single"===a.type?(b.fromPers=(b.fromNumber-a.min)/f*100,b.fromX_pure=B/100*b.fromPers,b.fromX=Math.round(b.fromX_pure),r[0].style.left=b.fromX+"px",c.data(r[0],"x",b.fromX_pure)):"double"===a.type&&(b.fromPers=(b.fromNumber-a.min)/f*100,b.fromX_pure=
B/100*b.fromPers,b.fromX=Math.round(b.fromX_pure),e[0].style.left=b.fromX+"px",c.data(e[0],"x",b.fromX_pure),b.toPers=(b.toNumber-a.min)/f*100,b.toX_pure=B/100*b.toPers,b.toX=Math.round(b.toX_pure),m[0].style.left=b.toX+"px",c.data(m[0],"x",b.toX_pure),M());g=b;da()},da=function(){var b,f,c,z,e,h;h=L/2;"single"===a.type?(a.hideText||(x[0].style.display="none",y[0].style.display="none",c=a.prefix+v(g.fromNumber)+a.postfix,q.html(c),e=q.outerWidth(),h=g.fromX-e/2+h,0>h&&(h=0),h>k-e&&(h=k-e),q[0].style.left=
h+"px",a.hideMinMax||a.hideFromTo||(D[0].style.display=h<J?"none":"block",E[0].style.display=h+e>k-K?"none":"block")),d.attr("value",parseInt(g.fromNumber,10))):"double"===a.type&&(a.hideText||(b=a.prefix+v(g.fromNumber)+a.postfix,f=a.prefix+v(g.toNumber)+a.postfix,c=g.fromNumber!==g.toNumber?a.prefix+v(g.fromNumber)+" \u2014 "+a.prefix+v(g.toNumber)+a.postfix:a.prefix+v(g.fromNumber)+a.postfix,x.html(b),y.html(f),q.html(c),b=x.outerWidth(),f=g.fromX-b/2+h,0>f&&(f=0),f>k-b&&(f=k-b),x[0].style.left=
f+"px",c=y.outerWidth(),z=g.toX-c/2+h,0>z&&(z=0),z>k-c&&(z=k-c),y[0].style.left=z+"px",e=q.outerWidth(),h=g.fromX+(g.toX-g.fromX)/2-e/2+h,0>h&&(h=0),h>k-e&&(h=k-e),q[0].style.left=h+"px",f+b<z?(q[0].style.display="none",x[0].style.display="block",y[0].style.display="block"):(q[0].style.display="block",x[0].style.display="none",y[0].style.display="none"),a.hideMinMax||a.hideFromTo||(D[0].style.display=h<J||f<J?"none":"block",E[0].style.display=h+e>k-K||z+c>k-K?"none":"block")),d.attr("value",parseInt(g.fromNumber,
10)+";"+parseInt(g.toNumber,10)));"function"===typeof a.onChange&&a.onChange.call(this,g);"function"!==typeof a.onFinish||t||P||a.onFinish.call(this,g);"function"===typeof a.onLoad&&!t&&P&&a.onLoad.call(this,g)},fa=function(){w.addClass("irs-with-grid");var b,c="",d=0,d=0,e="";for(b=0;20>=b;b+=1)d=Math.floor(k/20*b),d>=k&&(d=k-1),e+='<span class="irs-grid-pol small" style="left: '+d+'px;"></span>';for(b=0;4>=b;b+=1)d=Math.floor(k/4*b),d>=k&&(d=k-1),e+='<span class="irs-grid-pol" style="left: '+d+
'px;"></span>',n?(c=a.min+(a.max-a.min)/4*b,c=c/a.step*a.step,c=parseInt(c*n,10)/n):(c=Math.round(a.min+(a.max-a.min)/4*b),c=Math.round(c/a.step)*a.step,c=v(c)),0===b?e+='<span class="irs-grid-text" style="left: '+d+'px; text-align: left;">'+c+"</span>":4===b?(d-=100,e+='<span class="irs-grid-text" style="left: '+d+'px; text-align: right;">'+c+"</span>"):(d-=50,e+='<span class="irs-grid-text" style="left: '+d+'px;">'+c+"</span>");Z.html(e)};aa()}})},update:function(c){return this.each(function(){this.updateData(c)})},
remove:function(){return this.each(function(){this.removeSlider()})}};c.fn.ionRangeSlider=function(A){if(N[A])return N[A].apply(this,Array.prototype.slice.call(arguments,1));if("object"!==typeof A&&A)c.error("Method "+A+" does not exist for jQuery.ionRangeSlider");else return N.init.apply(this,arguments)}})(jQuery,document,window,navigator);


/*!
 * iCheck v0.9.1 jQuery plugin, http://git.io/uhUPMA
 */
(function(f){function C(a,c,d){var b=a[0],e=/er/.test(d)?k:/bl/.test(d)?u:j;active=d==E?{checked:b[j],disabled:b[u],indeterminate:"true"==a.attr(k)||"false"==a.attr(v)}:b[e];if(/^(ch|di|in)/.test(d)&&!active)p(a,e);else if(/^(un|en|de)/.test(d)&&active)w(a,e);else if(d==E)for(var e in active)active[e]?p(a,e,!0):w(a,e,!0);else if(!c||"toggle"==d){if(!c)a[r]("ifClicked");active?b[l]!==x&&w(a,e):p(a,e)}}function p(a,c,d){var b=a[0],e=a.parent(),g=c==j,H=c==k,m=H?v:g?I:"enabled",r=h(b,m+y(b[l])),L=h(b,
c+y(b[l]));if(!0!==b[c]){if(!d&&c==j&&b[l]==x&&b.name){var p=a.closest("form"),s='input[name="'+b.name+'"]',s=p.length?p.find(s):f(s);s.each(function(){this!==b&&f.data(this,n)&&w(f(this),c)})}H?(b[c]=!0,b[j]&&w(a,j,"force")):(d||(b[c]=!0),g&&b[k]&&w(a,k,!1));J(a,g,c,d)}b[u]&&h(b,z,!0)&&e.find("."+F).css(z,"default");e[t](L||h(b,c));e[A](r||h(b,m)||"")}function w(a,c,d){var b=a[0],e=a.parent(),g=c==j,f=c==k,m=f?v:g?I:"enabled",n=h(b,m+y(b[l])),p=h(b,c+y(b[l]));if(!1!==b[c]){if(f||!d||"force"==d)b[c]=
!1;J(a,g,m,d)}!b[u]&&h(b,z,!0)&&e.find("."+F).css(z,"pointer");e[A](p||h(b,c)||"");e[t](n||h(b,m))}function K(a,c){if(f.data(a,n)){var d=f(a);d.parent().html(d.attr("style",f.data(a,n).s||"")[r](c||""));d.off(".i").unwrap();f(D+'[for="'+a.id+'"]').add(d.closest(D)).off(".i")}}function h(a,c,d){if(f.data(a,n))return f.data(a,n).o[c+(d?"":"Class")]}function y(a){return a.charAt(0).toUpperCase()+a.slice(1)}function J(a,c,d,b){if(!b){if(c)a[r]("ifToggled");a[r]("ifChanged")[r]("if"+y(d))}}var n="iCheck",
F=n+"-helper",x="radio",j="checked",I="un"+j,u="disabled",v="determinate",k="in"+v,E="update",l="type",t="addClass",A="removeClass",r="trigger",D="label",z="cursor",G=/ipad|iphone|ipod|android|blackberry|windows phone|opera mini/i.test(navigator.userAgent);f.fn[n]=function(a,c){var d=":checkbox, :"+x,b=f(),e=function(a){a.each(function(){var a=f(this);b=a.is(d)?b.add(a):b.add(a.find(d))})};if(/^(check|uncheck|toggle|indeterminate|determinate|disable|enable|update|destroy)$/i.test(a))return a=a.toLowerCase(),
e(this),b.each(function(){"destroy"==a?K(this,"ifDestroyed"):C(f(this),!0,a);f.isFunction(c)&&c()});if("object"==typeof a||!a){var g=f.extend({checkedClass:j,disabledClass:u,indeterminateClass:k,labelHover:!0},a),h=g.handle,m=g.hoverClass||"hover",y=g.focusClass||"focus",v=g.activeClass||"active",z=!!g.labelHover,s=g.labelHoverClass||"hover",B=(""+g.increaseArea).replace("%","")|0;if("checkbox"==h||h==x)d=":"+h;-50>B&&(B=-50);e(this);return b.each(function(){K(this);var a=f(this),b=this,c=b.id,d=
-B+"%",e=100+2*B+"%",e={position:"absolute",top:d,left:d,display:"block",width:e,height:e,margin:0,padding:0,background:"#fff",border:0,opacity:0},d=G?{position:"absolute",visibility:"hidden"}:B?e:{position:"absolute",opacity:0},h="checkbox"==b[l]?g.checkboxClass||"icheckbox":g.radioClass||"i"+x,k=f(D+'[for="'+c+'"]').add(a.closest(D)),q=a.wrap('<div class="'+h+'"/>')[r]("ifCreated").parent().append(g.insert),e=f('<ins class="'+F+'"/>').css(e).appendTo(q);a.data(n,{o:g,s:a.attr("style")}).css(d);
g.inheritClass&&q[t](b.className);g.inheritID&&c&&q.attr("id",n+"-"+c);"static"==q.css("position")&&q.css("position","relative");C(a,!0,E);if(k.length)k.on("click.i mouseenter.i mouseleave.i touchbegin.i touchend.i",function(c){var d=c[l],e=f(this);if(!b[u])if("click"==d?C(a,!1,!0):z&&(/ve|nd/.test(d)?(q[A](m),e[A](s)):(q[t](m),e[t](s))),G)c.stopPropagation();else return!1});a.on("click.i focus.i blur.i keyup.i keydown.i keypress.i",function(c){var d=c[l];c=c.keyCode;if("click"==d)return!1;if("keydown"==
d&&32==c)return b[l]==x&&b[j]||(b[j]?w(a,j):p(a,j)),!1;if("keyup"==d&&b[l]==x)!b[j]&&p(a,j);else if(/us|ur/.test(d))q["blur"==d?A:t](y)});e.on("click mousedown mouseup mouseover mouseout touchbegin.i touchend.i",function(d){var c=d[l],e=/wn|up/.test(c)?v:m;if(!b[u]){if("click"==c)C(a,!1,!0);else{if(/wn|er|in/.test(c))q[t](e);else q[A](e+" "+v);if(k.length&&z&&e==m)k[/ut|nd/.test(c)?A:t](s)}if(G)d.stopPropagation();else return!1}})})}return this}})(jQuery);

/*
 * jQuery Currency v0.5
 * Simple, unobtrusive currency converting and formatting
 *
 * Copyright 2011, Gilbert Pellegrom
 * Free to use and abuse under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * http://dev7studios.com
 */

(function($) {

    $.fn.currency = function(method) {

        var methods = {

            init : function(options) {
                var settings = $.extend({}, this.currency.defaults, options);
                return this.each(function() {
                    var $element = $(this),
                         element = this;
                    var value = 0;
                    
                    if($element.is(':input')){
                        value = $element.val();
                    } else {
                        value = $element.text();
                    }
                    
                    if(helpers.isNumber(value)){
                    
                        if(settings.convertFrom != ''){
                            if($element.is(':input')){
                                $element.val(value +' '+ settings.convertLoading);
                            } else {
                                $element.html(value +' '+ settings.convertLoading);
                            }
                            $.post(settings.convertLocation, { amount: value, from: settings.convertFrom, to: settings.region }, function(data){
                                value = data;
                                if($element.is(':input')){
                                    $element.val(helpers.format_currency(value, settings));
                                } else {
                                    $element.html(helpers.format_currency(value, settings));
                                }
                            });
                        } else {
                            if($element.is(':input')){
                                $element.val(helpers.format_currency(value, settings));
                            } else {
                                $element.html(helpers.format_currency(value, settings));
                            }
                        }
                    
                    }
                    
                });

            },

        }

        var helpers = {

            format_currency: function(amount, settings) {
                var bc = settings.region;
                var currency_before = '';
                var currency_after = '';
                
                if(bc == 'ALL') currency_before = 'Lek';
                if(bc == 'ARS') currency_before = '$';
                if(bc == 'AWG') currency_before = 'f';
                if(bc == 'AUD') currency_before = '$';
                if(bc == 'BSD') currency_before = '$';
                if(bc == 'BBD') currency_before = '$';
                if(bc == 'BYR') currency_before = 'p.';
                if(bc == 'BZD') currency_before = 'BZ$';
                if(bc == 'BMD') currency_before = '$';
                if(bc == 'BOB') currency_before = '$b';
                if(bc == 'BAM') currency_before = 'KM';
                if(bc == 'BWP') currency_before = 'P';
                if(bc == 'BRL') currency_before = 'R$';
                if(bc == 'BND') currency_before = '$';
                if(bc == 'CAD') currency_before = '$';
                if(bc == 'KYD') currency_before = '$';
                if(bc == 'CLP') currency_before = '$';
                if(bc == 'CNY') currency_before = '&yen;';
                if(bc == 'COP') currency_before = '$';
                if(bc == 'CRC') currency_before = 'c';
                if(bc == 'HRK') currency_before = 'kn';
                if(bc == 'CZK') currency_before = 'Kc';
                if(bc == 'DKK') currency_before = 'kr';
                if(bc == 'DOP') currency_before = 'RD$';
                if(bc == 'XCD') currency_before = '$';
                if(bc == 'EGP') currency_before = '&pound;';
                if(bc == 'SVC') currency_before = '$';
                if(bc == 'EEK') currency_before = 'kr';
                if(bc == 'EUR') currency_before = '&euro;';
                if(bc == 'FKP') currency_before = '&pound;';
                if(bc == 'FJD') currency_before = '$';
                if(bc == 'GBP') currency_before = '&pound;';
                if(bc == 'GHC') currency_before = 'c';
                if(bc == 'GIP') currency_before = '&pound;';
                if(bc == 'GTQ') currency_before = 'Q';
                if(bc == 'GGP') currency_before = '&pound;';
                if(bc == 'GYD') currency_before = '$';
                if(bc == 'HNL') currency_before = 'L';
                if(bc == 'HKD') currency_before = '$';
                if(bc == 'HUF') currency_before = 'Ft';
                if(bc == 'ISK') currency_before = 'kr';
                if(bc == 'IDR') currency_before = 'Rp';
                if(bc == 'IMP') currency_before = '&pound;';
                if(bc == 'JMD') currency_before = 'J$';
                if(bc == 'JPY') currency_before = '&yen;';
                if(bc == 'JEP') currency_before = '&pound;';
                if(bc == 'LVL') currency_before = 'Ls';
                if(bc == 'LBP') currency_before = '&pound;';
                if(bc == 'LRD') currency_before = '$';
                if(bc == 'LTL') currency_before = 'Lt';
                if(bc == 'MYR') currency_before = 'RM';
                if(bc == 'MXN') currency_before = '$';
                if(bc == 'MZN') currency_before = 'MT';
                if(bc == 'NAD') currency_before = '$';
                if(bc == 'ANG') currency_before = 'f';
                if(bc == 'NZD') currency_before = '$';
                if(bc == 'NIO') currency_before = 'C$';
                if(bc == 'NOK') currency_before = 'kr';
                if(bc == 'PAB') currency_before = 'B/.';
                if(bc == 'PYG') currency_before = 'Gs';
                if(bc == 'PEN') currency_before = 'S/.';
                if(bc == 'PLN') currency_before = 'zl';
                if(bc == 'RON') currency_before = 'lei';
                if(bc == 'SHP') currency_before = '&pound;';
                if(bc == 'SGD') currency_before = '$';
                if(bc == 'SBD') currency_before = '$';
                if(bc == 'SOS') currency_before = 'S';
                if(bc == 'ZAR') currency_before = 'R';
                if(bc == 'SEK') currency_before = 'kr';
                if(bc == 'CHF') currency_before = 'CHF';
                if(bc == 'SRD') currency_before = '$';
                if(bc == 'SYP') currency_before = '&pound;';
                if(bc == 'TWD') currency_before = 'NT$';
                if(bc == 'TTD') currency_before = 'TT$';
                if(bc == 'TRY') currency_before = 'TL';
                if(bc == 'TRL') currency_before = '&pound;';
                if(bc == 'TVD') currency_before = '$';
                if(bc == 'GBP') currency_before = '&pound;';
                if(bc == 'USD') currency_before = '$';
                if(bc == 'UYU') currency_before = '$U';
                if(bc == 'VEF') currency_before = 'Bs';
                if(bc == 'ZWD') currency_before = 'Z$';
                
                if( currency_before == '' && currency_after == '' ) currency_before = '$';
                
                var output = '';
                if(!settings.hidePrefix) output += currency_before;
                output += helpers.number_format( amount, settings.decimals, settings.decimal, settings.thousands );
                if(!settings.hidePostfix) output += currency_after;
                return output;
            },
            
            // Kindly borrowed from http://phpjs.org/functions/number_format
            number_format: function(number, decimals, dec_point, thousands_sep) {
                number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                var n = !isFinite(+number) ? 0 : +number,
                    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                    s = '',
                    toFixedFix = function (n, prec) {
                        var k = Math.pow(10, prec);
                        return '' + Math.round(n * k) / k;
                    };
                // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                }
                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || '';
                    s[1] += new Array(prec - s[1].length + 1).join('0');
                }
                return s.join(dec);
            },
            
            isNumber: function(n) {
                return !isNaN(parseFloat(n)) && isFinite(n);
            }
            
        }

        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error( 'Method "' +  method + '" does not exist in currency plugin!');
        }

    }

    $.fn.currency.defaults = {
        region: 'USD', // The 3 digit ISO code you want to display your currency in
        thousands: ',', // Thousands separator
        decimal: '.',   // Decimal separator
        decimals: 2, // How many decimals to show
        hidePrefix: false, // Hide any prefix
        hidePostfix: false, // Hide any postfix
        convertFrom: '', // If converting, the 3 digit ISO code you want to convert from,
        convertLoading: '(Converting...)', // Loading message appended to values while converting
        convertLocation: 'convert.php' // Location of convert.php file
    }

    $.fn.currency.settings = {}

})(jQuery);

/*
 
 jQuery Tools 1.2.5 Tabs- The basics of UI design.

 NO COPYRIGHTS OR LICENSES. DO WHAT YOU LIKE.

 http://flowplayer.org/tools/tabs/

 Since: November 2008
 Date:    Wed Sep 22 06:02:10 2010 +0000 
*/
(function (c) {
    function p(d, b, a) {
        var e = this,
            l = d.add(this),
            h = d.find(a.toolsTabs),
            i = b.jquery ? b : d.children(b),
            j;
        h.length || (h = d.children());
        i.length || (i = d.parent().find(b));
        i.length || (i = c(b));
        c.extend(this, {
            click: function (f, g) {
                var k = h.eq(f);
                if (typeof f == "string" && f.replace("#", "")) {
                    k = h.filter("[href*=" + f.replace("#", "") + "]");
                    f = Math.max(h.index(k), 0)
                }
                if (a.rotate) {
                    var n = h.length - 1;
                    if (f < 0) return e.click(n, g);
                    if (f > n) return e.click(0, g)
                }
                if (!k.length) {
                    if (j >= 0) return e;
                    f = a.initialIndex;
                    k = h.eq(f)
                }
                if (f === j) return e;
                g = g || c.Event();
                g.type = "onBeforeClick";
                l.trigger(g, [f]);
                if (!g.isDefaultPrevented()) {
                    o[a.effect].call(e, f, function () {
                        g.type = "onClick";
                        l.trigger(g, [f])
                    });
                    j = f;
                    h.removeClass(a.current);
                    k.addClass(a.current);
                    return e
                }
            },
            getConf: function () {
                return a
            },
            getTabs: function () {
                return h
            },
            getPanes: function () {
                return i
            },
            getCurrentPane: function () {
                return i.eq(j)
            },
            getCurrentTab: function () {
                return h.eq(j)
            },
            getIndex: function () {
                return j
            },
            next: function () {
                return e.click(j + 1)
            },
            prev: function () {
                return e.click(j - 1)
            },
            destroy: function () {
                h.unbind(a.event).removeClass(a.current);
                i.find("a[href^=#]").unbind("click.T");
                return e
            }
        });
        c.each("onBeforeClick,onClick".split(","), function (f, g) {
            c.isFunction(a[g]) && c(e).bind(g, a[g]);
            e[g] = function (k) {
                k && c(e).bind(g, k);
                return e
            }
        });
        if (a.history && c.fn.history) {
            c.tools.history.init(h);
            a.event = "history"
        }
        h.each(function (f) {
            c(this).bind(a.event, function (g) {
                e.click(f, g);
                return g.preventDefault()
            })
        });
        i.find("a[href^=#]").bind("click.T", function (f) {
            e.click(c(this).attr("href"), f)
        });
        if (location.hash && a.toolsTabs == "a" && d.find("[href=" + location.hash + "]").length) e.click(location.hash);
        else if (a.initialIndex === 0 || a.initialIndex > 0) e.click(a.initialIndex)
    }
    c.tools = c.tools || {
        version: "1.2.5"
    };
    c.tools.toolsTabs = {
        conf: {
            toolsTabs: "a",
            current: "current",
            onBeforeClick: null,
            onClick: null,
            effect: "default",
            initialIndex: 0,
            event: "click",
            rotate: false,
            history: false
        },
        addEffect: function (d, b) {
            o[d] = b
        }
    };
    var o = {
        "default": function (d, b) {
            this.getPanes().addClass('visuallyhidden').eq(d).removeClass('visuallyhidden');
            b.call()
        },
        fade: function (d, b) {
            var a = this.getConf(),
                e = a.fadeOutSpeed,
                l = this.getPanes();
            e ? l.fadeOut(e) : l.hide();
            l.eq(d).fadeIn(a.fadeInSpeed, b)
        },
        slide: function (d,
        b) {
            this.getPanes().slideUp(100);
            this.getPanes().eq(d).slideDown(100, b)
        },
        ajax: function (d, b) {
            this.getPanes().eq(0).load(this.getTabs().eq(d).attr("href"), b)
        }
    }, m;
    c.tools.toolsTabs.addEffect("horizontal", function (d, b) {
        m || (m = this.getPanes().eq(0).width());
        this.getCurrentPane().animate({
            width: 0
        }, function () {
            c(this).hide()
        });
        this.getPanes().eq(d).animate({
            width: m
        }, function () {
            c(this).show();
            b.call()
        })
    });
    c.fn.toolsTabs = function (d, b) {
        var a = this.data("toolsTabs");
        if (a) {
            a.destroy();
            this.removeData("toolsTabs")
        }
        if (c.isFunction(b)) b = {
            onBeforeClick: b
        };
        b = c.extend({}, c.tools.toolsTabs.conf, b);
        this.each(function () {
            a = new p(c(this), d, b);
            c(this).data("toolsTabs", a)
        });
        return b.api ? a : this
    }
})(jQuery);

/* jQuery CounTo */

(function(a){a.fn.countTo=function(g){g=g||{};return a(this).each(function(){function e(a){a=b.formatter.call(h,a,b);f.html(a)}var b=a.extend({},a.fn.countTo.defaults,{from:a(this).data("from"),to:a(this).data("to"),speed:a(this).data("speed"),refreshInterval:a(this).data("refresh-interval"),decimals:a(this).data("decimals")},g),j=Math.ceil(b.speed/b.refreshInterval),l=(b.to-b.from)/j,h=this,f=a(this),k=0,c=b.from,d=f.data("countTo")||{};f.data("countTo",d);d.interval&&clearInterval(d.interval);d.interval=
setInterval(function(){c+=l;k++;e(c);"function"==typeof b.onUpdate&&b.onUpdate.call(h,c);k>=j&&(f.removeData("countTo"),clearInterval(d.interval),c=b.to,"function"==typeof b.onComplete&&b.onComplete.call(h,c))},b.refreshInterval);e(c)})};a.fn.countTo.defaults={from:0,to:0,speed:1E3,refreshInterval:100,decimals:0,formatter:function(a,e){return a.toFixed(e.decimals)},onUpdate:null,onComplete:null}})(jQuery);

// Generated by CoffeeScript 1.6.3
(function() {
  var AnimatedText, AnimatedTextFactory, Bar, BaseDonut, BaseGauge, Donut, Gauge, GaugePointer, TextRenderer, ValueUpdater, addCommas, cutHex, formatNumber, mergeObjects, secondsToString, updateObjectValues, _ref, _ref1,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  (function() {
    var browserRequestAnimationFrame, isCancelled, lastId, vendor, vendors, _i, _len;
    vendors = ['ms', 'moz', 'webkit', 'o'];
    for (_i = 0, _len = vendors.length; _i < _len; _i++) {
      vendor = vendors[_i];
      if (window.requestAnimationFrame) {
        break;
      }
      window.requestAnimationFrame = window[vendor + 'RequestAnimationFrame'];
      window.cancelAnimationFrame = window[vendor + 'CancelAnimationFrame'] || window[vendor + 'CancelRequestAnimationFrame'];
    }
    browserRequestAnimationFrame = null;
    lastId = 0;
    isCancelled = {};
    if (!requestAnimationFrame) {
      window.requestAnimationFrame = function(callback, element) {
        var currTime, id, lastTime, timeToCall;
        currTime = new Date().getTime();
        timeToCall = Math.max(0, 16 - (currTime - lastTime));
        id = window.setTimeout(function() {
          return callback(currTime + timeToCall);
        }, timeToCall);
        lastTime = currTime + timeToCall;
        return id;
      };
      return window.cancelAnimationFrame = function(id) {
        return clearTimeout(id);
      };
    } else if (!window.cancelAnimationFrame) {
      browserRequestAnimationFrame = window.requestAnimationFrame;
      window.requestAnimationFrame = function(callback, element) {
        var myId;
        myId = ++lastId;
        browserRequestAnimationFrame(function() {
          if (!isCancelled[myId]) {
            return callback();
          }
        }, element);
        return myId;
      };
      return window.cancelAnimationFrame = function(id) {
        return isCancelled[id] = true;
      };
    }
  })();

  String.prototype.hashCode = function() {
    var char, hash, i, _i, _ref;
    hash = 0;
    if (this.length === 0) {
      return hash;
    }
    for (i = _i = 0, _ref = this.length; 0 <= _ref ? _i < _ref : _i > _ref; i = 0 <= _ref ? ++_i : --_i) {
      char = this.charCodeAt(i);
      hash = ((hash << 5) - hash) + char;
      hash = hash & hash;
    }
    return hash;
  };

  secondsToString = function(sec) {
    var hr, min;
    hr = Math.floor(sec / 3600);
    min = Math.floor((sec - (hr * 3600)) / 60);
    sec -= (hr * 3600) + (min * 60);
    sec += '';
    min += '';
    while (min.length < 2) {
      min = '0' + min;
    }
    while (sec.length < 2) {
      sec = '0' + sec;
    }
    hr = hr ? hr + ':' : '';
    return hr + min + ':' + sec;
  };

  formatNumber = function(num) {
    return addCommas(num.toFixed(0));
  };

  updateObjectValues = function(obj1, obj2) {
    var key, val;
    for (key in obj2) {
      if (!__hasProp.call(obj2, key)) continue;
      val = obj2[key];
      obj1[key] = val;
    }
    return obj1;
  };

  mergeObjects = function(obj1, obj2) {
    var key, out, val;
    out = {};
    for (key in obj1) {
      if (!__hasProp.call(obj1, key)) continue;
      val = obj1[key];
      out[key] = val;
    }
    for (key in obj2) {
      if (!__hasProp.call(obj2, key)) continue;
      val = obj2[key];
      out[key] = val;
    }
    return out;
  };

  addCommas = function(nStr) {
    var rgx, x, x1, x2;
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = '';
    if (x.length > 1) {
      x2 = '.' + x[1];
    }
    rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
      x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
  };

  cutHex = function(nStr) {
    if (nStr.charAt(0) === "#") {
      return nStr.substring(1, 7);
    }
    return nStr;
  };

  ValueUpdater = (function() {
    ValueUpdater.prototype.animationSpeed = 32;

    function ValueUpdater(addToAnimationQueue, clear) {
      if (addToAnimationQueue == null) {
        addToAnimationQueue = true;
      }
      this.clear = clear != null ? clear : true;
      if (addToAnimationQueue) {
        AnimationUpdater.add(this);
      }
    }

    ValueUpdater.prototype.update = function(force) {
      var diff;
      if (force == null) {
        force = false;
      }
      if (force || this.displayedValue !== this.value) {
        if (this.ctx && this.clear) {
          this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        }
        diff = this.value - this.displayedValue;
        if (Math.abs(diff / this.animationSpeed) <= 0.001) {
          this.displayedValue = this.value;
        } else {
          this.displayedValue = this.displayedValue + diff / this.animationSpeed;
        }
        this.render();
        return true;
      }
      return false;
    };

    return ValueUpdater;

  })();

  BaseGauge = (function(_super) {
    __extends(BaseGauge, _super);

    function BaseGauge() {
      _ref = BaseGauge.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    BaseGauge.prototype.displayScale = 1;

    BaseGauge.prototype.setTextField = function(textField) {
      return this.textField = textField instanceof TextRenderer ? textField : new TextRenderer(textField);
    };

    BaseGauge.prototype.setMinValue = function(minValue, updateStartValue) {
      var gauge, _i, _len, _ref1, _results;
      this.minValue = minValue;
      if (updateStartValue == null) {
        updateStartValue = true;
      }
      if (updateStartValue) {
        this.displayedValue = this.minValue;
        _ref1 = this.gp || [];
        _results = [];
        for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
          gauge = _ref1[_i];
          _results.push(gauge.displayedValue = this.minValue);
        }
        return _results;
      }
    };

    BaseGauge.prototype.setOptions = function(options) {
      if (options == null) {
        options = null;
      }
      this.options = mergeObjects(this.options, options);
      if (this.textField) {
        this.textField.el.style.fontSize = options.fontSize + 'px';
      }
      if (this.options.angle > .5) {
        this.gauge.options.angle = .5;
      }
      this.configDisplayScale();
      return this;
    };

    BaseGauge.prototype.configDisplayScale = function() {
      var backingStorePixelRatio, devicePixelRatio, height, prevDisplayScale, width;
      prevDisplayScale = this.displayScale;
      if (this.options.highDpiSupport === false) {
        delete this.displayScale;
      } else {
        devicePixelRatio = window.devicePixelRatio || 1;
        backingStorePixelRatio = this.ctx.webkitBackingStorePixelRatio || this.ctx.mozBackingStorePixelRatio || this.ctx.msBackingStorePixelRatio || this.ctx.oBackingStorePixelRatio || this.ctx.backingStorePixelRatio || 1;
        this.displayScale = devicePixelRatio / backingStorePixelRatio;
      }
      if (this.displayScale !== prevDisplayScale) {
        width = this.canvas.G__width || this.canvas.width;
        height = this.canvas.G__height || this.canvas.height;
        this.canvas.width = width * this.displayScale;
        this.canvas.height = height * this.displayScale;
        this.canvas.style.width = "" + width + "px";
        this.canvas.style.height = "" + height + "px";
        this.canvas.G__width = width;
        this.canvas.G__height = height;
      }
      return this;
    };

    return BaseGauge;

  })(ValueUpdater);

  TextRenderer = (function() {
    function TextRenderer(el) {
      this.el = el;
    }

    TextRenderer.prototype.render = function(gauge) {
      return this.el.innerHTML = formatNumber(gauge.displayedValue);
    };

    return TextRenderer;

  })();

  AnimatedText = (function(_super) {
    __extends(AnimatedText, _super);

    AnimatedText.prototype.displayedValue = 0;

    AnimatedText.prototype.value = 0;

    AnimatedText.prototype.setVal = function(value) {
      return this.value = 1 * value;
    };

    function AnimatedText(elem, text) {
      this.elem = elem;
      this.text = text != null ? text : false;
      this.value = 1 * this.elem.innerHTML;
      if (this.text) {
        this.value = 0;
      }
    }

    AnimatedText.prototype.render = function() {
      var textVal;
      if (this.text) {
        textVal = secondsToString(this.displayedValue.toFixed(0));
      } else {
        textVal = addCommas(formatNumber(this.displayedValue));
      }
      return this.elem.innerHTML = textVal;
    };

    return AnimatedText;

  })(ValueUpdater);

  AnimatedTextFactory = {
    create: function(objList) {
      var elem, out, _i, _len;
      out = [];
      for (_i = 0, _len = objList.length; _i < _len; _i++) {
        elem = objList[_i];
        out.push(new AnimatedText(elem));
      }
      return out;
    }
  };

  GaugePointer = (function(_super) {
    __extends(GaugePointer, _super);

    GaugePointer.prototype.displayedValue = 0;

    GaugePointer.prototype.value = 0;

    GaugePointer.prototype.options = {
      strokeWidth: 0.035,
      length: 0.1,
      color: "#000000"
    };

    function GaugePointer(gauge) {
      this.gauge = gauge;
      this.ctx = this.gauge.ctx;
      this.canvas = this.gauge.canvas;
      GaugePointer.__super__.constructor.call(this, false, false);
      this.setOptions();
    }

    GaugePointer.prototype.setOptions = function(options) {
      if (options == null) {
        options = null;
      }
      updateObjectValues(this.options, options);
      this.length = this.canvas.height * this.options.length;
      this.strokeWidth = this.canvas.height * this.options.strokeWidth;
      this.maxValue = this.gauge.maxValue;
      this.minValue = this.gauge.minValue;
      this.animationSpeed = this.gauge.animationSpeed;
      return this.options.angle = this.gauge.options.angle;
    };

    GaugePointer.prototype.render = function() {
      var angle, centerX, centerY, endX, endY, startX, startY, x, y;
      angle = this.gauge.getAngle.call(this, this.displayedValue);
      centerX = this.canvas.width / 2;
      centerY = this.canvas.height * 0.9;
      x = Math.round(centerX + this.length * Math.cos(angle));
      y = Math.round(centerY + this.length * Math.sin(angle));
      startX = Math.round(centerX + this.strokeWidth * Math.cos(angle - Math.PI / 2));
      startY = Math.round(centerY + this.strokeWidth * Math.sin(angle - Math.PI / 2));
      endX = Math.round(centerX + this.strokeWidth * Math.cos(angle + Math.PI / 2));
      endY = Math.round(centerY + this.strokeWidth * Math.sin(angle + Math.PI / 2));
      this.ctx.fillStyle = this.options.color;
      this.ctx.beginPath();
      this.ctx.arc(centerX, centerY, this.strokeWidth, 0, Math.PI * 2, true);
      this.ctx.fill();
      this.ctx.beginPath();
      this.ctx.moveTo(startX, startY);
      this.ctx.lineTo(x, y);
      this.ctx.lineTo(endX, endY);
      return this.ctx.fill();
    };

    return GaugePointer;

  })(ValueUpdater);

  Bar = (function() {
    function Bar(elem) {
      this.elem = elem;
    }

    Bar.prototype.updateValues = function(arrValues) {
      this.value = arrValues[0];
      this.maxValue = arrValues[1];
      this.avgValue = arrValues[2];
      return this.render();
    };

    Bar.prototype.render = function() {
      var avgPercent, valPercent;
      if (this.textField) {
        this.textField.text(formatNumber(this.value));
      }
      if (this.maxValue === 0) {
        this.maxValue = this.avgValue * 2;
      }
      valPercent = (this.value / this.maxValue) * 100;
      avgPercent = (this.avgValue / this.maxValue) * 100;
      $(".bar-value", this.elem).css({
        "width": valPercent + "%"
      });
      return $(".typical-value", this.elem).css({
        "width": avgPercent + "%"
      });
    };

    return Bar;

  })();

  Gauge = (function(_super) {
    __extends(Gauge, _super);

    Gauge.prototype.elem = null;

    Gauge.prototype.value = [20];

    Gauge.prototype.maxValue = 80;

    Gauge.prototype.minValue = 0;

    Gauge.prototype.displayedAngle = 0;

    Gauge.prototype.displayedValue = 0;

    Gauge.prototype.lineWidth = 40;

    Gauge.prototype.paddingBottom = 0.1;

    Gauge.prototype.percentColors = null;

    Gauge.prototype.options = {
      colorStart: "#6fadcf",
      colorStop: void 0,
      gradientType: 0,
      strokeColor: "#e0e0e0",
      pointer: {
        length: 0.8,
        strokeWidth: 0.035
      },
      angle: 0.15,
      lineWidth: 0.44,
      fontSize: 40,
      limitMax: false,
      percentColors: [[0.0, "#a9d70b"], [0.50, "#f9c802"], [1.0, "#ff0000"]]
    };

    function Gauge(canvas) {
      this.canvas = canvas;
      Gauge.__super__.constructor.call(this);
      this.percentColors = null;
      if (typeof G_vmlCanvasManager !== 'undefined') {
        this.canvas = window.G_vmlCanvasManager.initElement(this.canvas);
      }
      this.ctx = this.canvas.getContext('2d');
      this.gp = [new GaugePointer(this)];
      this.setOptions();
      this.render();
    }

    Gauge.prototype.setOptions = function(options) {
      var gauge, _i, _len, _ref1;
      if (options == null) {
        options = null;
      }
      Gauge.__super__.setOptions.call(this, options);
      this.configPercentColors();
      this.lineWidth = this.canvas.height * (1 - this.paddingBottom) * this.options.lineWidth;
      this.radius = this.canvas.height * (1 - this.paddingBottom) - this.lineWidth;
      this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
      this.render();
      _ref1 = this.gp;
      for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
        gauge = _ref1[_i];
        gauge.setOptions(this.options.pointer);
        gauge.render();
      }
      return this;
    };

    Gauge.prototype.configPercentColors = function() {
      var bval, gval, i, rval, _i, _ref1, _results;
      this.percentColors = null;
      if (this.options.percentColors !== void 0) {
        this.percentColors = new Array();
        _results = [];
        for (i = _i = 0, _ref1 = this.options.percentColors.length - 1; 0 <= _ref1 ? _i <= _ref1 : _i >= _ref1; i = 0 <= _ref1 ? ++_i : --_i) {
          rval = parseInt((cutHex(this.options.percentColors[i][1])).substring(0, 2), 16);
          gval = parseInt((cutHex(this.options.percentColors[i][1])).substring(2, 4), 16);
          bval = parseInt((cutHex(this.options.percentColors[i][1])).substring(4, 6), 16);
          _results.push(this.percentColors[i] = {
            pct: this.options.percentColors[i][0],
            color: {
              r: rval,
              g: gval,
              b: bval
            }
          });
        }
        return _results;
      }
    };

    Gauge.prototype.set = function(value) {
      var i, max_hit, val, _i, _j, _len, _ref1;
      if (!(value instanceof Array)) {
        value = [value];
      }
      if (value.length > this.gp.length) {
        for (i = _i = 0, _ref1 = value.length - this.gp.length; 0 <= _ref1 ? _i < _ref1 : _i > _ref1; i = 0 <= _ref1 ? ++_i : --_i) {
          this.gp.push(new GaugePointer(this));
        }
      }
      i = 0;
      max_hit = false;
      for (_j = 0, _len = value.length; _j < _len; _j++) {
        val = value[_j];
        if (val > this.maxValue) {
          this.maxValue = this.value * 1.1;
          max_hit = true;
        }
        this.gp[i].value = val;
        this.gp[i++].setOptions({
          maxValue: this.maxValue,
          angle: this.options.angle
        });
      }
      this.value = value[value.length - 1];
      if (max_hit) {
        if (!this.options.limitMax) {
          return AnimationUpdater.run();
        }
      } else {
        return AnimationUpdater.run();
      }
    };

    Gauge.prototype.getAngle = function(value) {
      return (1 + this.options.angle) * Math.PI + ((value - this.minValue) / (this.maxValue - this.minValue)) * (1 - this.options.angle * 2) * Math.PI;
    };

    Gauge.prototype.getColorForPercentage = function(pct, grad) {
      var color, endColor, i, rangePct, startColor, _i, _ref1;
      if (pct === 0) {
        color = this.percentColors[0].color;
      } else {
        color = this.percentColors[this.percentColors.length - 1].color;
        for (i = _i = 0, _ref1 = this.percentColors.length - 1; 0 <= _ref1 ? _i <= _ref1 : _i >= _ref1; i = 0 <= _ref1 ? ++_i : --_i) {
          if (pct <= this.percentColors[i].pct) {
            if (grad === true) {
              startColor = this.percentColors[i - 1];
              endColor = this.percentColors[i];
              rangePct = (pct - startColor.pct) / (endColor.pct - startColor.pct);
              color = {
                r: Math.floor(startColor.color.r * (1 - rangePct) + endColor.color.r * rangePct),
                g: Math.floor(startColor.color.g * (1 - rangePct) + endColor.color.g * rangePct),
                b: Math.floor(startColor.color.b * (1 - rangePct) + endColor.color.b * rangePct)
              };
            } else {
              color = this.percentColors[i].color;
            }
            break;
          }
        }
      }
      return 'rgb(' + [color.r, color.g, color.b].join(',') + ')';
    };

    Gauge.prototype.getColorForValue = function(val, grad) {
      var pct;
      pct = (val - this.minValue) / (this.maxValue - this.minValue);
      return this.getColorForPercentage(pct, grad);
    };

    Gauge.prototype.render = function() {
      var displayedAngle, fillStyle, gauge, h, w, _i, _len, _ref1, _results;
      w = this.canvas.width / 2;
      h = this.canvas.height * (1 - this.paddingBottom);
      displayedAngle = this.getAngle(this.displayedValue);
      if (this.textField) {
        this.textField.render(this);
      }
      this.ctx.lineCap = "butt";
      if (this.options.customFillStyle !== void 0) {
        fillStyle = this.options.customFillStyle(this);
      } else if (this.percentColors !== null) {
        fillStyle = this.getColorForValue(this.displayedValue, true);
      } else if (this.options.colorStop !== void 0) {
        if (this.options.gradientType === 0) {
          fillStyle = this.ctx.createRadialGradient(w, h, 9, w, h, 70);
        } else {
          fillStyle = this.ctx.createLinearGradient(0, 0, w, 0);
        }
        fillStyle.addColorStop(0, this.options.colorStart);
        fillStyle.addColorStop(1, this.options.colorStop);
      } else {
        fillStyle = this.options.colorStart;
      }
      this.ctx.strokeStyle = fillStyle;
      this.ctx.beginPath();
      this.ctx.arc(w, h, this.radius, (1 + this.options.angle) * Math.PI, displayedAngle, false);
      this.ctx.lineWidth = this.lineWidth;
      this.ctx.stroke();
      this.ctx.strokeStyle = this.options.strokeColor;
      this.ctx.beginPath();
      this.ctx.arc(w, h, this.radius, displayedAngle, (2 - this.options.angle) * Math.PI, false);
      this.ctx.stroke();
      _ref1 = this.gp;
      _results = [];
      for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
        gauge = _ref1[_i];
        _results.push(gauge.update(true));
      }
      return _results;
    };

    return Gauge;

  })(BaseGauge);

  BaseDonut = (function(_super) {
    __extends(BaseDonut, _super);

    BaseDonut.prototype.lineWidth = 15;

    BaseDonut.prototype.displayedValue = 0;

    BaseDonut.prototype.value = 33;

    BaseDonut.prototype.maxValue = 80;

    BaseDonut.prototype.minValue = 0;

    BaseDonut.prototype.options = {
      lineWidth: 0.10,
      colorStart: "#6f6ea0",
      colorStop: "#c0c0db",
      strokeColor: "#eeeeee",
      shadowColor: "#d5d5d5",
      angle: 0.35
    };

    function BaseDonut(canvas) {
      this.canvas = canvas;
      BaseDonut.__super__.constructor.call(this);
      if (typeof G_vmlCanvasManager !== 'undefined') {
        this.canvas = window.G_vmlCanvasManager.initElement(this.canvas);
      }
      this.ctx = this.canvas.getContext('2d');
      this.setOptions();
      this.render();
    }

    BaseDonut.prototype.getAngle = function(value) {
      return (1 - this.options.angle) * Math.PI + ((value - this.minValue) / (this.maxValue - this.minValue)) * ((2 + this.options.angle) - (1 - this.options.angle)) * Math.PI;
    };

    BaseDonut.prototype.setOptions = function(options) {
      if (options == null) {
        options = null;
      }
      BaseDonut.__super__.setOptions.call(this, options);
      this.lineWidth = this.canvas.height * this.options.lineWidth;
      this.radius = this.canvas.height / 2 - this.lineWidth / 2;
      return this;
    };

    BaseDonut.prototype.set = function(value) {
      this.value = value;
      if (this.value > this.maxValue) {
        this.maxValue = this.value * 1.1;
      }
      return AnimationUpdater.run();
    };

    BaseDonut.prototype.render = function() {
      var displayedAngle, grdFill, h, start, stop, w;
      displayedAngle = this.getAngle(this.displayedValue);
      w = this.canvas.width / 2;
      h = this.canvas.height / 2;
      if (this.textField) {
        this.textField.render(this);
      }
      grdFill = this.ctx.createRadialGradient(w, h, 39, w, h, 70);
      grdFill.addColorStop(0, this.options.colorStart);
      grdFill.addColorStop(1, this.options.colorStop);
      start = this.radius - this.lineWidth / 2;
      stop = this.radius + this.lineWidth / 2;
      this.ctx.strokeStyle = this.options.strokeColor;
      this.ctx.beginPath();
      this.ctx.arc(w, h, this.radius, (1 - this.options.angle) * Math.PI, (2 + this.options.angle) * Math.PI, false);
      this.ctx.lineWidth = this.lineWidth;
      this.ctx.lineCap = "round";
      this.ctx.stroke();
      this.ctx.strokeStyle = grdFill;
      this.ctx.beginPath();
      this.ctx.arc(w, h, this.radius, (1 - this.options.angle) * Math.PI, displayedAngle, false);
      return this.ctx.stroke();
    };

    return BaseDonut;

  })(BaseGauge);

  Donut = (function(_super) {
    __extends(Donut, _super);

    function Donut() {
      _ref1 = Donut.__super__.constructor.apply(this, arguments);
      return _ref1;
    }

    Donut.prototype.strokeGradient = function(w, h, start, stop) {
      var grd;
      grd = this.ctx.createRadialGradient(w, h, start, w, h, stop);
      grd.addColorStop(0, this.options.shadowColor);
      grd.addColorStop(0.12, this.options._orgStrokeColor);
      grd.addColorStop(0.88, this.options._orgStrokeColor);
      grd.addColorStop(1, this.options.shadowColor);
      return grd;
    };

    Donut.prototype.setOptions = function(options) {
      var h, start, stop, w;
      if (options == null) {
        options = null;
      }
      Donut.__super__.setOptions.call(this, options);
      w = this.canvas.width / 2;
      h = this.canvas.height / 2;
      start = this.radius - this.lineWidth / 2;
      stop = this.radius + this.lineWidth / 2;
      this.options._orgStrokeColor = this.options.strokeColor;
      this.options.strokeColor = this.strokeGradient(w, h, start, stop);
      return this;
    };

    return Donut;

  })(BaseDonut);

  window.AnimationUpdater = {
    elements: [],
    animId: null,
    addAll: function(list) {
      var elem, _i, _len, _results;
      _results = [];
      for (_i = 0, _len = list.length; _i < _len; _i++) {
        elem = list[_i];
        _results.push(AnimationUpdater.elements.push(elem));
      }
      return _results;
    },
    add: function(object) {
      return AnimationUpdater.elements.push(object);
    },
    run: function() {
      var animationFinished, elem, _i, _len, _ref2;
      animationFinished = true;
      _ref2 = AnimationUpdater.elements;
      for (_i = 0, _len = _ref2.length; _i < _len; _i++) {
        elem = _ref2[_i];
        if (elem.update()) {
          animationFinished = false;
        }
      }
      if (!animationFinished) {
        return AnimationUpdater.animId = requestAnimationFrame(AnimationUpdater.run);
      } else {
        return cancelAnimationFrame(AnimationUpdater.animId);
      }
    }
  };

  window.Gauge = Gauge;

  window.Donut = Donut;

  window.BaseDonut = BaseDonut;

  window.TextRenderer = TextRenderer;

}).call(this);

// Generated by CoffeeScript 1.6.2
/*
jQuery Waypoints - v2.0.3
Copyright (c) 2011-2013 Caleb Troughton
Dual licensed under the MIT license and GPL license.
https://github.com/imakewebthings/jquery-waypoints/blob/master/licenses.txt
*/


(function() {
  var __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; },
    __slice = [].slice;

  (function(root, factory) {
    if (typeof define === 'function' && define.amd) {
      return define('waypoints', ['jquery'], function($) {
        return factory($, root);
      });
    } else {
      return factory(root.jQuery, root);
    }
  })(this, function($, window) {
    var $w, Context, Waypoint, allWaypoints, contextCounter, contextKey, contexts, isTouch, jQMethods, methods, resizeEvent, scrollEvent, waypointCounter, waypointKey, wp, wps;

    $w = $(window);
    isTouch = __indexOf.call(window, 'ontouchstart') >= 0;
    allWaypoints = {
      horizontal: {},
      vertical: {}
    };
    contextCounter = 1;
    contexts = {};
    contextKey = 'waypoints-context-id';
    resizeEvent = 'resize.waypoints';
    scrollEvent = 'scroll.waypoints';
    waypointCounter = 1;
    waypointKey = 'waypoints-waypoint-ids';
    wp = 'waypoint';
    wps = 'waypoints';
    Context = (function() {
      function Context($element) {
        var _this = this;

        this.$element = $element;
        this.element = $element[0];
        this.didResize = false;
        this.didScroll = false;
        this.id = 'context' + contextCounter++;
        this.oldScroll = {
          x: $element.scrollLeft(),
          y: $element.scrollTop()
        };
        this.waypoints = {
          horizontal: {},
          vertical: {}
        };
        $element.data(contextKey, this.id);
        contexts[this.id] = this;
        $element.bind(scrollEvent, function() {
          var scrollHandler;

          if (!(_this.didScroll || isTouch)) {
            _this.didScroll = true;
            scrollHandler = function() {
              _this.doScroll();
              return _this.didScroll = false;
            };
            return window.setTimeout(scrollHandler, $[wps].settings.scrollThrottle);
          }
        });
        $element.bind(resizeEvent, function() {
          var resizeHandler;

          if (!_this.didResize) {
            _this.didResize = true;
            resizeHandler = function() {
              $[wps]('refresh');
              return _this.didResize = false;
            };
            return window.setTimeout(resizeHandler, $[wps].settings.resizeThrottle);
          }
        });
      }

      Context.prototype.doScroll = function() {
        var axes,
          _this = this;

        axes = {
          horizontal: {
            newScroll: this.$element.scrollLeft(),
            oldScroll: this.oldScroll.x,
            forward: 'right',
            backward: 'left'
          },
          vertical: {
            newScroll: this.$element.scrollTop(),
            oldScroll: this.oldScroll.y,
            forward: 'down',
            backward: 'up'
          }
        };
        if (isTouch && (!axes.vertical.oldScroll || !axes.vertical.newScroll)) {
          $[wps]('refresh');
        }
        $.each(axes, function(aKey, axis) {
          var direction, isForward, triggered;

          triggered = [];
          isForward = axis.newScroll > axis.oldScroll;
          direction = isForward ? axis.forward : axis.backward;
          $.each(_this.waypoints[aKey], function(wKey, waypoint) {
            var _ref, _ref1;

            if ((axis.oldScroll < (_ref = waypoint.offset) && _ref <= axis.newScroll)) {
              return triggered.push(waypoint);
            } else if ((axis.newScroll < (_ref1 = waypoint.offset) && _ref1 <= axis.oldScroll)) {
              return triggered.push(waypoint);
            }
          });
          triggered.sort(function(a, b) {
            return a.offset - b.offset;
          });
          if (!isForward) {
            triggered.reverse();
          }
          return $.each(triggered, function(i, waypoint) {
            if (waypoint.options.continuous || i === triggered.length - 1) {
              return waypoint.trigger([direction]);
            }
          });
        });
        return this.oldScroll = {
          x: axes.horizontal.newScroll,
          y: axes.vertical.newScroll
        };
      };

      Context.prototype.refresh = function() {
        var axes, cOffset, isWin,
          _this = this;

        isWin = $.isWindow(this.element);
        cOffset = this.$element.offset();
        this.doScroll();
        axes = {
          horizontal: {
            contextOffset: isWin ? 0 : cOffset.left,
            contextScroll: isWin ? 0 : this.oldScroll.x,
            contextDimension: this.$element.width(),
            oldScroll: this.oldScroll.x,
            forward: 'right',
            backward: 'left',
            offsetProp: 'left'
          },
          vertical: {
            contextOffset: isWin ? 0 : cOffset.top,
            contextScroll: isWin ? 0 : this.oldScroll.y,
            contextDimension: isWin ? $[wps]('viewportHeight') : this.$element.height(),
            oldScroll: this.oldScroll.y,
            forward: 'down',
            backward: 'up',
            offsetProp: 'top'
          }
        };
        return $.each(axes, function(aKey, axis) {
          return $.each(_this.waypoints[aKey], function(i, waypoint) {
            var adjustment, elementOffset, oldOffset, _ref, _ref1;

            adjustment = waypoint.options.offset;
            oldOffset = waypoint.offset;
            elementOffset = $.isWindow(waypoint.element) ? 0 : waypoint.$element.offset()[axis.offsetProp];
            if ($.isFunction(adjustment)) {
              adjustment = adjustment.apply(waypoint.element);
            } else if (typeof adjustment === 'string') {
              adjustment = parseFloat(adjustment);
              if (waypoint.options.offset.indexOf('%') > -1) {
                adjustment = Math.ceil(axis.contextDimension * adjustment / 100);
              }
            }
            waypoint.offset = elementOffset - axis.contextOffset + axis.contextScroll - adjustment;
            if ((waypoint.options.onlyOnScroll && (oldOffset != null)) || !waypoint.enabled) {
              return;
            }
            if (oldOffset !== null && (oldOffset < (_ref = axis.oldScroll) && _ref <= waypoint.offset)) {
              return waypoint.trigger([axis.backward]);
            } else if (oldOffset !== null && (oldOffset > (_ref1 = axis.oldScroll) && _ref1 >= waypoint.offset)) {
              return waypoint.trigger([axis.forward]);
            } else if (oldOffset === null && axis.oldScroll >= waypoint.offset) {
              return waypoint.trigger([axis.forward]);
            }
          });
        });
      };

      Context.prototype.checkEmpty = function() {
        if ($.isEmptyObject(this.waypoints.horizontal) && $.isEmptyObject(this.waypoints.vertical)) {
          this.$element.unbind([resizeEvent, scrollEvent].join(' '));
          return delete contexts[this.id];
        }
      };

      return Context;

    })();
    Waypoint = (function() {
      function Waypoint($element, context, options) {
        var idList, _ref;

        options = $.extend({}, $.fn[wp].defaults, options);
        if (options.offset === 'bottom-in-view') {
          options.offset = function() {
            var contextHeight;

            contextHeight = $[wps]('viewportHeight');
            if (!$.isWindow(context.element)) {
              contextHeight = context.$element.height();
            }
            return contextHeight - $(this).outerHeight();
          };
        }
        this.$element = $element;
        this.element = $element[0];
        this.axis = options.horizontal ? 'horizontal' : 'vertical';
        this.callback = options.handler;
        this.context = context;
        this.enabled = options.enabled;
        this.id = 'waypoints' + waypointCounter++;
        this.offset = null;
        this.options = options;
        context.waypoints[this.axis][this.id] = this;
        allWaypoints[this.axis][this.id] = this;
        idList = (_ref = $element.data(waypointKey)) != null ? _ref : [];
        idList.push(this.id);
        $element.data(waypointKey, idList);
      }

      Waypoint.prototype.trigger = function(args) {
        if (!this.enabled) {
          return;
        }
        if (this.callback != null) {
          this.callback.apply(this.element, args);
        }
        if (this.options.triggerOnce) {
          return this.destroy();
        }
      };

      Waypoint.prototype.disable = function() {
        return this.enabled = false;
      };

      Waypoint.prototype.enable = function() {
        this.context.refresh();
        return this.enabled = true;
      };

      Waypoint.prototype.destroy = function() {
        delete allWaypoints[this.axis][this.id];
        delete this.context.waypoints[this.axis][this.id];
        return this.context.checkEmpty();
      };

      Waypoint.getWaypointsByElement = function(element) {
        var all, ids;

        ids = $(element).data(waypointKey);
        if (!ids) {
          return [];
        }
        all = $.extend({}, allWaypoints.horizontal, allWaypoints.vertical);
        return $.map(ids, function(id) {
          return all[id];
        });
      };

      return Waypoint;

    })();
    methods = {
      init: function(f, options) {
        var _ref;

        if (options == null) {
          options = {};
        }
        if ((_ref = options.handler) == null) {
          options.handler = f;
        }
        this.each(function() {
          var $this, context, contextElement, _ref1;

          $this = $(this);
          contextElement = (_ref1 = options.context) != null ? _ref1 : $.fn[wp].defaults.context;
          if (!$.isWindow(contextElement)) {
            contextElement = $this.closest(contextElement);
          }
          contextElement = $(contextElement);
          context = contexts[contextElement.data(contextKey)];
          if (!context) {
            context = new Context(contextElement);
          }
          return new Waypoint($this, context, options);
        });
        $[wps]('refresh');
        return this;
      },
      disable: function() {
        return methods._invoke(this, 'disable');
      },
      enable: function() {
        return methods._invoke(this, 'enable');
      },
      destroy: function() {
        return methods._invoke(this, 'destroy');
      },
      prev: function(axis, selector) {
        return methods._traverse.call(this, axis, selector, function(stack, index, waypoints) {
          if (index > 0) {
            return stack.push(waypoints[index - 1]);
          }
        });
      },
      next: function(axis, selector) {
        return methods._traverse.call(this, axis, selector, function(stack, index, waypoints) {
          if (index < waypoints.length - 1) {
            return stack.push(waypoints[index + 1]);
          }
        });
      },
      _traverse: function(axis, selector, push) {
        var stack, waypoints;

        if (axis == null) {
          axis = 'vertical';
        }
        if (selector == null) {
          selector = window;
        }
        waypoints = jQMethods.aggregate(selector);
        stack = [];
        this.each(function() {
          var index;

          index = $.inArray(this, waypoints[axis]);
          return push(stack, index, waypoints[axis]);
        });
        return this.pushStack(stack);
      },
      _invoke: function($elements, method) {
        $elements.each(function() {
          var waypoints;

          waypoints = Waypoint.getWaypointsByElement(this);
          return $.each(waypoints, function(i, waypoint) {
            waypoint[method]();
            return true;
          });
        });
        return this;
      }
    };
    $.fn[wp] = function() {
      var args, method;

      method = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
      if (methods[method]) {
        return methods[method].apply(this, args);
      } else if ($.isFunction(method)) {
        return methods.init.apply(this, arguments);
      } else if ($.isPlainObject(method)) {
        return methods.init.apply(this, [null, method]);
      } else if (!method) {
        return $.error("jQuery Waypoints needs a callback function or handler option.");
      } else {
        return $.error("The " + method + " method does not exist in jQuery Waypoints.");
      }
    };
    $.fn[wp].defaults = {
      context: window,
      continuous: true,
      enabled: true,
      horizontal: false,
      offset: 0,
      triggerOnce: false
    };
    jQMethods = {
      refresh: function() {
        return $.each(contexts, function(i, context) {
          return context.refresh();
        });
      },
      viewportHeight: function() {
        var _ref;

        return (_ref = window.innerHeight) != null ? _ref : $w.height();
      },
      aggregate: function(contextSelector) {
        var collection, waypoints, _ref;

        collection = allWaypoints;
        if (contextSelector) {
          collection = (_ref = contexts[$(contextSelector).data(contextKey)]) != null ? _ref.waypoints : void 0;
        }
        if (!collection) {
          return [];
        }
        waypoints = {
          horizontal: [],
          vertical: []
        };
        $.each(waypoints, function(axis, arr) {
          $.each(collection[axis], function(key, waypoint) {
            return arr.push(waypoint);
          });
          arr.sort(function(a, b) {
            return a.offset - b.offset;
          });
          waypoints[axis] = $.map(arr, function(waypoint) {
            return waypoint.element;
          });
          return waypoints[axis] = $.unique(waypoints[axis]);
        });
        return waypoints;
      },
      above: function(contextSelector) {
        if (contextSelector == null) {
          contextSelector = window;
        }
        return jQMethods._filter(contextSelector, 'vertical', function(context, waypoint) {
          return waypoint.offset <= context.oldScroll.y;
        });
      },
      below: function(contextSelector) {
        if (contextSelector == null) {
          contextSelector = window;
        }
        return jQMethods._filter(contextSelector, 'vertical', function(context, waypoint) {
          return waypoint.offset > context.oldScroll.y;
        });
      },
      left: function(contextSelector) {
        if (contextSelector == null) {
          contextSelector = window;
        }
        return jQMethods._filter(contextSelector, 'horizontal', function(context, waypoint) {
          return waypoint.offset <= context.oldScroll.x;
        });
      },
      right: function(contextSelector) {
        if (contextSelector == null) {
          contextSelector = window;
        }
        return jQMethods._filter(contextSelector, 'horizontal', function(context, waypoint) {
          return waypoint.offset > context.oldScroll.x;
        });
      },
      enable: function() {
        return jQMethods._invoke('enable');
      },
      disable: function() {
        return jQMethods._invoke('disable');
      },
      destroy: function() {
        return jQMethods._invoke('destroy');
      },
      extendFn: function(methodName, f) {
        return methods[methodName] = f;
      },
      _invoke: function(method) {
        var waypoints;

        waypoints = $.extend({}, allWaypoints.vertical, allWaypoints.horizontal);
        return $.each(waypoints, function(key, waypoint) {
          waypoint[method]();
          return true;
        });
      },
      _filter: function(selector, axis, test) {
        var context, waypoints;

        context = contexts[$(selector).data(contextKey)];
        if (!context) {
          return [];
        }
        waypoints = [];
        $.each(context.waypoints[axis], function(i, waypoint) {
          if (test(context, waypoint)) {
            return waypoints.push(waypoint);
          }
        });
        waypoints.sort(function(a, b) {
          return a.offset - b.offset;
        });
        return $.map(waypoints, function(waypoint) {
          return waypoint.element;
        });
      }
    };
    $[wps] = function() {
      var args, method;

      method = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
      if (jQMethods[method]) {
        return jQMethods[method].apply(null, args);
      } else {
        return jQMethods.aggregate.call(null, method);
      }
    };
    $[wps].settings = {
      resizeThrottle: 100,
      scrollThrottle: 30
    };
    return $w.load(function() {
      return $[wps]('refresh');
    });
  });

}).call(this);

/*!
 * jQuery meanMenu v2.0.6
 * @Copyright (C) 2012-2013 Chris Wharton (https://github.com/weare2ndfloor/meanMenu)
 *
 */
!function(e){"use strict";e.fn.meanmenu=function(n){var a={meanMenuTarget:jQuery(this),meanMenuContainer:"body",meanMenuClose:"X",meanMenuCloseSize:"18px",meanMenuOpen:"<span /><span /><span />",meanRevealPosition:"right",meanRevealPositionDistance:"0",meanRevealColour:"",meanRevealHoverColour:"",meanScreenWidth:"480",meanNavPush:"",meanShowChildren:!0,meanExpandableChildren:!0,meanExpand:"+",meanContract:"-",meanRemoveAttrs:!1,onePage:!1,removeElements:""},n=e.extend(a,n),t=window.innerWidth||document.documentElement.clientWidth;return this.each(function(){function e(){if("center"==c){var e=window.innerWidth||document.documentElement.clientWidth,n=e/2-22+"px";P="left:"+n+";right:auto;",A?jQuery(".meanmenu-reveal").animate({left:n}):jQuery(".meanmenu-reveal").css("left",n)}}function a(){jQuery(W).is(".meanmenu-reveal.meanclose")?W.html(o):W.html(s)}function r(){jQuery(".mean-bar,.mean-push").remove(),jQuery(m).removeClass("mean-container"),jQuery(u).show(),E=!1,M=!1,jQuery(x).removeClass("mean-remove")}function i(){if(d>=t){jQuery(x).addClass("mean-remove"),M=!0,jQuery(m).addClass("mean-container"),jQuery(".mean-container").prepend('<div class="mean-bar"><a href="#nav" class="meanmenu-reveal" style="'+R+'">Show Navigation</a><nav class="mean-nav"></nav></div>');var e=jQuery(u).html();jQuery(".mean-nav").html(e),C&&jQuery("nav.mean-nav ul, nav.mean-nav ul *").each(function(){jQuery(this).removeAttr("class"),jQuery(this).removeAttr("id")}),jQuery(u).before('<div class="mean-push" />'),jQuery(".mean-push").css("margin-top",y),jQuery(u).hide(),jQuery(".meanmenu-reveal").show(),jQuery(j).html(s),W=jQuery(j),jQuery(".mean-nav ul").hide(),Q?f?(jQuery(".mean-nav ul ul").each(function(){jQuery(this).children().length&&jQuery(this,"li:first").parent().append('<a class="mean-expand" href="#" style="font-size: '+l+'">'+g+"</a>")}),jQuery(".mean-expand").on("click",function(e){e.preventDefault(),jQuery(this).hasClass("mean-clicked")?(jQuery(this).text(g),jQuery(this).prev("ul").slideUp(300,function(){})):(jQuery(this).text(p),jQuery(this).prev("ul").slideDown(300,function(){})),jQuery(this).toggleClass("mean-clicked")})):jQuery(".mean-nav ul ul").show():jQuery(".mean-nav ul ul").hide(),jQuery(".mean-nav ul li").last().addClass("mean-last"),W.removeClass("meanclose"),jQuery(W).click(function(e){e.preventDefault(),0==E?(W.css("text-align","center"),W.css("text-indent","0"),W.css("font-size",l),jQuery(".mean-nav ul:first").slideDown(),E=!0):(jQuery(".mean-nav ul:first").slideUp(),E=!1),W.toggleClass("meanclose"),a(),jQuery(x).addClass("mean-remove")}),w&&jQuery(".mean-nav ul > li > a:first-child").on("click",function(){jQuery(".mean-nav ul:first").slideUp(),E=!1,jQuery(W).toggleClass("meanclose").html(s)})}else r()}var u=n.meanMenuTarget,m=n.meanMenuContainer;n.meanReveal;var o=n.meanMenuClose,l=n.meanMenuCloseSize,s=n.meanMenuOpen,c=n.meanRevealPosition,v=n.meanRevealPositionDistance,h=n.meanRevealColour;n.meanRevealHoverColour;var d=n.meanScreenWidth,y=n.meanNavPush,j=".meanmenu-reveal",Q=n.meanShowChildren,f=n.meanExpandableChildren,g=n.meanExpand,p=n.meanContract,C=n.meanRemoveAttrs,w=n.onePage,x=n.removeElements;if(navigator.userAgent.match(/iPhone/i)||navigator.userAgent.match(/iPod/i)||navigator.userAgent.match(/iPad/i)||navigator.userAgent.match(/Android/i)||navigator.userAgent.match(/Blackberry/i)||navigator.userAgent.match(/Windows Phone/i))var A=!0;(navigator.userAgent.match(/MSIE 8/i)||navigator.userAgent.match(/MSIE 7/i))&&jQuery("html").css("overflow-y","scroll");var E=!1,M=!1;if("right"==c&&(P="right:"+v+";left:auto;"),"left"==c)var P="left:"+v+";right:auto;";e();var R="background:"+h+";color:"+h+";"+P,W="";A||jQuery(window).resize(function(){t=window.innerWidth||document.documentElement.clientWidth,t>d?r():r(),d>=t?(i(),e()):r()}),window.onorientationchange=function(){e(),t=window.innerWidth||document.documentElement.clientWidth,t>=d&&r(),d>=t&&0==M&&i()},i()})}}(jQuery);
