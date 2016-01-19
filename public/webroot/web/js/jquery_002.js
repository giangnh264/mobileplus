/*
 * jQuery mmenu v5.0.4
 * @requires jQuery 1.7.0 or later
 *
 * mmenu.frebsite.nl
 *
 * Copyright (c) Fred Heusschen
 * www.frebsite.nl
 *
 * Licensed under the MIT license:
 * http://en.wikipedia.org/wiki/MIT_License
 */
!function(t){function n(){t[s].glbl||(d={$wndw:t(window),$html:t("html"),$body:t("body")},a={},l={},r={},t.each([a,l,r],function(e,t){t.add=function(e){e=e.split(" ");for(var n in e)t[e[n]]=t.mm(e[n])}}),a.mm=function(e){return"mm-"+e},a.add("wrapper menu vertical panel nopanel current highest opened subopened header hasheader title btn prev next first last listview nolistview selected divider spacer hidden fullsubopen"),a.umm=function(e){return"mm-"==e.slice(0,3)&&(e=e.slice(3)),e},l.mm=function(e){return"mm-"+e},l.add("parent sub"),r.mm=function(e){return e+".mm"},r.add("transitionend webkitTransitionEnd mousedown mouseup touchstart touchmove touchend click keydown"),t[s]._c=a,t[s]._d=l,t[s]._e=r,t[s].glbl=d)}var s="mmenu",i="5.0.4";if(!t[s]){t[s]=function(e,t,n){this.$menu=e,this._api=["bind","init","update","setSelected","getInstance","openPanel","closePanel","closeAllPanels"],this.opts=t,this.conf=n,this.vars={},this.cbck={},"function"==typeof this.___deprecated&&this.___deprecated(),this._initMenu(),this._initAnchors();var s=this.$menu.children(this.conf.panelNodetype);return this._initAddons(),this.init(s),"function"==typeof this.___debug&&this.___debug(),this},t[s].version=i,t[s].addons={},t[s].uniqueId=0,t[s].defaults={extensions:[],onClick:{setSelected:!0},slidingSubmenus:!0},t[s].configuration={classNames:{panel:"Panel",vertical:"Vertical",selected:"Selected",divider:"Divider",spacer:"Spacer"},clone:!1,openingInterval:25,panelNodetype:"ul, ol, div",transitionDuration:400},t[s].prototype={init:function(e){e=e.not("."+a.nopanel),e=this._initPanels(e),this.trigger("init",e),this.trigger("update")},update:function(){this.trigger("update")},setSelected:function(e){this.$menu.find("."+a.listview).children().removeClass(a.selected),e.addClass(a.selected),this.trigger("setSelected",e)},openPanel:function(e){var n=e.parent();if(n.hasClass(a.vertical)){var s=n.parents("."+a.subopened);if(s.length)return this.openPanel(s.first());n.addClass(a.opened)}else{if(e.hasClass(a.current))return;var i=t(this.$menu).children("."+a.panel),l=i.filter("."+a.current);i.removeClass(a.highest).removeClass(a.current).not(e).not(l).not("."+a.vertical).addClass(a.hidden),e.hasClass(a.opened)?l.addClass(a.highest).removeClass(a.opened).removeClass(a.subopened):(e.addClass(a.highest),l.addClass(a.subopened)),e.removeClass(a.hidden).addClass(a.current),setTimeout(function(){e.removeClass(a.subopened).addClass(a.opened)},this.conf.openingInterval)}this.trigger("openPanel",e)},closePanel:function(e){var t=e.parent();t.hasClass(a.vertical)&&(t.removeClass(a.opened),this.trigger("closePanel",e))},closeAllPanels:function(){this.$menu.find("."+a.listview).children().removeClass(a.selected).filter("."+a.vertical).removeClass(a.opened);var e=this.$menu.children("."+a.panel),t=e.first();this.$menu.children("."+a.panel).not(t).removeClass(a.subopened).removeClass(a.opened).removeClass(a.current).removeClass(a.highest).addClass(a.hidden),this.openPanel(t)},togglePanel:function(e){var t=e.parent();t.hasClass(a.vertical)&&this[t.hasClass(a.opened)?"closePanel":"openPanel"](e)},getInstance:function(){return this},bind:function(e,t){this.cbck[e]=this.cbck[e]||[],this.cbck[e].push(t)},trigger:function(){var t=this,n=Array.prototype.slice.call(arguments),s=n.shift();if(this.cbck[s])for(e in this.cbck[s])this.cbck[s][e].apply(t,n)},_initMenu:function(){this.opts.offCanvas&&this.conf.clone&&(this.$menu=this.$menu.clone(!0),this.$menu.add(this.$menu.find("*")).filter("[id]").each(function(){t(this).attr("id",a.mm(t(this).attr("id")))})),this.$menu.contents().each(function(){3==t(this)[0].nodeType&&t(this).remove()}),this.$menu.parent().addClass(a.wrapper);var e=[a.menu];this.opts.slidingSubmenus||e.push(a.vertical),this.opts.extensions=this.opts.extensions.length?"mm-"+this.opts.extensions.join(" mm-"):"",this.opts.extensions&&e.push(this.opts.extensions),this.$menu.addClass(e.join(" "))},_initPanels:function(e){var n=this;this.__findAddBack(e,"ul, ol").not("."+a.nolistview).addClass(a.listview);var s=this.__findAddBack(e,"."+a.listview).children();this.__refactorClass(s,this.conf.classNames.selected,"selected"),this.__refactorClass(s,this.conf.classNames.divider,"divider"),this.__refactorClass(s,this.conf.classNames.spacer,"spacer"),this.__refactorClass(this.__findAddBack(e,"."+this.conf.classNames.panel),this.conf.classNames.panel,"panel");var i=t(),r=e.add(this.__findAddBack(e,"."+a.listview).children().children(this.conf.panelNodetype)).not("."+a.nopanel);this.__refactorClass(r,this.conf.classNames.vertical,"vertical"),this.opts.slidingSubmenus||r.addClass(a.vertical),r.each(function(){var e=t(this),s=e;e.is("ul, ol")?(e.wrap('<div class="'+a.panel+'" />'),s=e.parent()):s.addClass(a.panel);var l=e.attr("id");e.removeAttr("id"),s.attr("id",l||n.__getUniqueId()),e.hasClass(a.vertical)&&(e.removeClass(n.conf.classNames.vertical),s.add(s.parent()).addClass(a.vertical)),i=i.add(s);var r=s.children().first(),d=s.children().last();r.is("."+a.listview)&&r.addClass(a.first),d.is("."+a.listview)&&d.addClass(a.last)});var d=t("."+a.panel,this.$menu);i.each(function(){var e=t(this),n=e.parent(),s=n.children("a, span");if(!n.is("."+a.menu)&&!e.data(l.parent)){if(n.data(l.sub,e),e.data(l.parent,n),n.parent().is("."+a.listview)){var i=e.attr("id"),r=t('<a class="'+a.next+'" href="#'+i+'" data-target="#'+i+'" />').insertBefore(s);s.is("a")||r.addClass(a.fullsubopen)}if(!n.hasClass(a.vertical)){var d=n.closest("."+a.panel);if(d.length){var i=d.attr("id");e.prepend('<div class="'+a.header+'"><a class="'+a.btn+" "+a.prev+'" href="#'+i+'" data-target="#'+i+'"></a><a class="'+a.title+'">'+s.text()+"</a></div>"),e.addClass(a.hasheader)}}}});var o=this.__findAddBack(e,"."+a.listview).children("."+a.selected).removeClass(a.selected).last().addClass(a.selected);o.add(o.parentsUntil("."+a.menu,"li")).filter("."+a.vertical).addClass(a.opened).end().not("."+a.vertical).each(function(){t(this).parentsUntil("."+a.menu,"."+a.panel).not("."+a.vertical).first().addClass(a.opened).parentsUntil("."+a.menu,"."+a.panel).not("."+a.vertical).first().addClass(a.opened).addClass(a.subopened)}),o.children("."+a.panel).not("."+a.vertical).addClass(a.opened).parentsUntil("."+a.menu,"."+a.panel).not("."+a.vertical).first().addClass(a.opened).addClass(a.subopened);var c=d.filter("."+a.opened);return c.length||(c=i.first()),c.addClass(a.opened).last().addClass(a.current),i.not("."+a.vertical).not(c.last()).addClass(a.hidden).end().appendTo(this.$menu),i},_initAnchors:function(){var e=this;d.$body.on(r.click+"-oncanvas","a[href]",function(n){var i=t(this),l=!1,r=e.$menu.find(i).length;for(var o in t[s].addons)if(l=t[s].addons[o].clickAnchor.call(e,i,r))break;if(!l&&r){var c=i.attr("href");if(c.length>1&&"#"==c.slice(0,1)){var h=t(c,e.$menu);h.is("."+a.panel)&&(l=!0,e[i.parent().hasClass(a.vertical)?"togglePanel":"openPanel"](h))}}if(l&&n.preventDefault(),!l&&r&&i.is("."+a.listview+" > li > a")&&!i.is('[rel="external"]')&&!i.is('[target="_blank"]')){e.__valueOrFn(e.opts.onClick.setSelected,i)&&e.setSelected(t(n.target).parent());var u=e.__valueOrFn(e.opts.onClick.preventDefault,i,"#"==c.slice(0,1));u&&n.preventDefault(),e.__valueOrFn(e.opts.onClick.blockUI,i,!u)&&d.$html.addClass(a.blocking),e.__valueOrFn(e.opts.onClick.close,i,u)&&e.close()}})},_initAddons:function(){for(var e in t[s].addons)t[s].addons[e].add.call(this),t[s].addons[e].add=function(){};for(var e in t[s].addons)t[s].addons[e].setup.call(this)},__api:function(){var e=this,n={};return t.each(this._api,function(){var t=this;n[t]=function(){var s=e[t].apply(e,arguments);return"undefined"==typeof s?n:s}}),n},__valueOrFn:function(e,t,n){return"function"==typeof e?e.call(t[0]):"undefined"==typeof e&&"undefined"!=typeof n?n:e},__refactorClass:function(e,t,n){return e.filter("."+t).removeClass(t).addClass(a[n])},__findAddBack:function(e,t){return e.find(t).add(e.filter(t))},__filterListItems:function(e){return e.not("."+a.divider).not("."+a.hidden)},__transitionend:function(e,t,n){var s=!1,i=function(){s||t.call(e[0]),s=!0};e.one(r.transitionend,i),e.one(r.webkitTransitionEnd,i),setTimeout(i,1.1*n)},__getUniqueId:function(){return a.mm(t[s].uniqueId++)}},t.fn[s]=function(e,i){return n(),e=t.extend(!0,{},t[s].defaults,e),i=t.extend(!0,{},t[s].configuration,i),this.each(function(){var n=t(this);if(!n.data(s)){var a=new t[s](n,e,i);n.data(s,a.__api())}})},t[s].support={touch:"ontouchstart"in window||navigator.msMaxTouchPoints};var a,l,r,d}}(jQuery);
/*
 * jQuery mmenu offCanvas addon
 * mmenu.frebsite.nl
 *
 * Copyright (c) Fred Heusschen
 */
!function(e){var t="mmenu",o="offCanvas";e[t].addons[o]={setup:function(){if(this.opts[o]){var n=this.opts[o],i=this.conf[o];a=e[t].glbl,this._api=e.merge(this._api,["open","close","setPage"]),("top"==n.position||"bottom"==n.position)&&(n.zposition="front"),"string"!=typeof i.pageSelector&&(i.pageSelector="> "+i.pageNodetype),a.$allMenus=(a.$allMenus||e()).add(this.$menu),this.vars.opened=!1;var r=[s.offcanvas];"left"!=n.position&&r.push(s.mm(n.position)),"back"!=n.zposition&&r.push(s.mm(n.zposition)),this.$menu.addClass(r.join(" ")).parent().removeClass(s.wrapper),this.setPage(a.$page),this._initBlocker(),this["_initWindow_"+o](),this.$menu[i.menuInjectMethod+"To"](i.menuWrapperSelector)}},add:function(){s=e[t]._c,n=e[t]._d,i=e[t]._e,s.add("offcanvas slideout modal background opening blocker page"),n.add("style"),i.add("resize")},clickAnchor:function(e){if(!this.opts[o])return!1;var t=this.$menu.attr("id");if(t&&t.length&&(this.conf.clone&&(t=s.umm(t)),e.is('[href="#'+t+'"]')))return this.open(),!0;if(a.$page){var t=a.$page.attr("id");return t&&t.length&&e.is('[href="#'+t+'"]')?(this.close(),!0):!1}}},e[t].defaults[o]={position:"left",zposition:"back",modal:!1,moveBackground:!0},e[t].configuration[o]={pageNodetype:"div",pageSelector:null,menuWrapperSelector:"body",menuInjectMethod:"prepend"},e[t].prototype.open=function(){if(!this.vars.opened){var e=this;this._openSetup(),setTimeout(function(){e._openFinish()},this.conf.openingInterval),this.trigger("open")}},e[t].prototype._openSetup=function(){var e=this;this.closeAllOthers(),a.$page.data(n.style,a.$page.attr("style")||""),a.$wndw.trigger(i.resize+"-offcanvas",[!0]);var t=[s.opened];this.opts[o].modal&&t.push(s.modal),this.opts[o].moveBackground&&t.push(s.background),"left"!=this.opts[o].position&&t.push(s.mm(this.opts[o].position)),"back"!=this.opts[o].zposition&&t.push(s.mm(this.opts[o].zposition)),this.opts.extensions&&t.push(this.opts.extensions),a.$html.addClass(t.join(" ")),setTimeout(function(){e.vars.opened=!0},this.conf.openingInterval),this.$menu.addClass(s.current+" "+s.opened)},e[t].prototype._openFinish=function(){var e=this;this.__transitionend(a.$page,function(){e.trigger("opened")},this.conf.transitionDuration),a.$html.addClass(s.opening),this.trigger("opening")},e[t].prototype.close=function(){if(this.vars.opened){var e=this;this.__transitionend(a.$page,function(){e.$menu.removeClass(s.current).removeClass(s.opened),a.$html.removeClass(s.opened).removeClass(s.modal).removeClass(s.background).removeClass(s.mm(e.opts[o].position)).removeClass(s.mm(e.opts[o].zposition)),e.opts.extensions&&a.$html.removeClass(e.opts.extensions),a.$page.attr("style",a.$page.data(n.style)),e.vars.opened=!1,e.trigger("closed")},this.conf.transitionDuration),a.$html.removeClass(s.opening),this.trigger("close"),this.trigger("closing")}},e[t].prototype.closeAllOthers=function(){a.$allMenus.not(this.$menu).each(function(){var o=e(this).data(t);o&&o.close&&o.close()})},e[t].prototype.setPage=function(t){t&&t.length||(t=e(this.conf[o].pageSelector,a.$body),t.length>1&&(t=t.wrapAll("<"+this.conf[o].pageNodetype+" />").parent())),t.attr("id",t.attr("id")||this.__getUniqueId()),t.addClass(s.page+" "+s.slideout),a.$page=t,this.trigger("setPage",t)},e[t].prototype["_initWindow_"+o]=function(){a.$wndw.off(i.keydown+"-offcanvas").on(i.keydown+"-offcanvas",function(e){return a.$html.hasClass(s.opened)&&9==e.keyCode?(e.preventDefault(),!1):void 0});var e=0;a.$wndw.off(i.resize+"-offcanvas").on(i.resize+"-offcanvas",function(t,o){if(o||a.$html.hasClass(s.opened)){var n=a.$wndw.height();(o||n!=e)&&(e=n,a.$page.css("minHeight",n))}})},e[t].prototype._initBlocker=function(){var t=this;a.$blck||(a.$blck=e('<div id="'+s.blocker+'" class="'+s.slideout+'" />')),a.$blck.appendTo(a.$body).off(i.touchstart+"-offcanvas "+i.touchmove+"-offcanvas").on(i.touchstart+"-offcanvas "+i.touchmove+"-offcanvas",function(e){e.preventDefault(),e.stopPropagation(),a.$blck.trigger(i.mousedown+"-offcanvas")}).off(i.mousedown+"-offcanvas").on(i.mousedown+"-offcanvas",function(e){e.preventDefault(),a.$html.hasClass(s.modal)||(t.closeAllOthers(),t.close())})};var s,n,i,a}(jQuery);
