(function(a,b){
    a.widget("dattaya.maccordion",{
        options:{
            active:0,
            header:"> li > :first-child,> :not(li):even",
            event:"click",
            effect:"blind",
            options:{},
            easing:"swing",
            speed:"normal",
            disabled:false,
            heightStyle:"auto",
            icons:{
                activeHeader:"ui-icon-triangle-1-s",
                header:"ui-icon-triangle-1-e"
            }
        },
    _toggle:function(g,f){
        var c=g.next().not(".ui-effects-wrapper").not(":animated"),e=this.options,h={
            toggled:g=c.prev()
            },d=this;
        if(g.length===0||(this._trigger("beforeActivate",f,h)===false)){
            return
        }
        g.toggleClass("ui-state-active ui-corner-all ui-corner-top dattaya-maccordion-header-active").maccordionToggleAttributes("aria-selected aria-expanded").children(".dattaya-maccordion-header-icon").toggleClass(e.icons.header+" "+e.icons.activeHeader);
        c.toggleClass("dattaya-maccordion-content-active");
        if(e.effect){
            c.toggle(e.effect,e.options,e.speed,function(){
                d._trigger("activate",f,h)
                })
            }else{
            c.toggle();
            this._trigger("activate",f,h)
            }
        },
    _handleEvent:function(d){
        var c=this.options;
        if(c.disabled){
            return
        }
        this._toggle(a(d.currentTarget),d);
        d.preventDefault()
        },
    _create:function(){
        var c=this.options;
        this._setOption("options",c.options);
        this._setupElement();
        this.$headers=this.element.find(c.header);
        this._setupTabs(this.$headers);
        this._setupHelpers();
        this._setZeroTabindex(this.$headers.eq(0));
        this._heightStyle();
        this._activate(c.active)
        },
    _setupHelpers:function(){
        if(!a.fn.maccordionToggleAttributes){
            a.fn.maccordionToggleAttributes=function(c){
                c=a.trim(c).split(" ");
                this.each(function(d,e){
                    a.each(c,function(g,f){
                        a(e).attr(f,a(e).attr(f)!="true")
                        })
                    });
                return this
                }
            }
    },
destroy:function(){
    this._cleanupElement();
    this._cleanupHeaders();
    this._cleanupContents();
    return a.Widget.prototype.destroy.call(this)
    },
_cleanupHeaders:function(){
    this.$headers.off(".maccordion").removeClass("dattaya-maccordion-header ui-helper-reset ui-state-default ui-corner-all ui-state-active ui-corner-top dattaya-maccordion-header-active ui-maccordion-disabled ui-state-disabled ui-state-focus ui-state-hover").removeAttr("role tabindex aria-selected aria-expanded");
    this._destroyIcons();
    this._cleanupAnchors()
    },
_cleanupContents:function(){
    this.$headers.next().filter(".ui-effects-wrapper").children().unwrap();
    this.$headers.next().stop(true,true).css("display","").removeClass("dattaya-maccordion-content ui-helper-reset ui-widget-content ui-corner-bottom dattaya-maccordion-content-active ui-maccordion-disabled ui-state-disabled").removeAttr("role")
    },
_cleanupElement:function(){
    this.element.removeClass("dattaya-maccordion ui-widget ui-helper-reset").removeAttr("aria-multiselectable role")
    },
_activate:function(c){
    if(this.options.disabled){
        return
    }
    this._toggle(this._transformActiveToElement(c))
    },
_handleKeydown:function(f){
    if(this.options.disabled||f.altKey||f.ctrlKey){
        return
    }
    if(f.target!=f.currentTarget){
        return
    }
    var g=a.ui.keyCode,e=this.$headers.length,c=this.$headers.index(f.currentTarget),d=false;
    switch(f.keyCode){
        case g.RIGHT:case g.DOWN:
            d=(c+1)%e;
            break;
        case g.LEFT:case g.UP:
            d=(e+c-1)%e;
            break;
        case g.SPACE:case g.ENTER:
            this._handleEvent(f);
            break;
        default:
            return
            }
            if(d!==false){
        this._setZeroTabindex(this.$headers.eq(d).focus())
        }
        f.preventDefault()
    },
_heightStyle:function(){
    var c=this.$headers.next();
    if(this.options.heightStyle==="auto"){
        c.height(this._getMaxHeight(c))
        }
    },
_getMaxHeight:function(c){
    var d=0;
    c.height("").each(function(){
        d=Math.max(d,a(this).height())
        });
    return d
    },
refresh:function(){
    var c=this.options;
    this._setupTabs(this.element.find(c.header).not(this.$headers));
    this.$headers=this.element.find(c.header);
    this._heightStyle()
    },
_setOption:function(d,e){
    var c=this.options;
    if(d==="event"){
        if(c.event){
            this.$headers.off(c.event.split(" ").join(".maccordion ")+".maccordion")
            }
            this._setupEvents(e,this.$headers)
        }
        a.Widget.prototype._setOption.apply(this,arguments);
    switch(d){
        case"disabled":
            this.$headers.add(this.$headers.next()).toggleClass("dattaya-maccordion-disabled ui-state-disabled",!!e);
            break;
        case"active":
            this._activate(e);
            break;
        case"icons":
            this._destroyIcons();
            this._setupIcons(this.$headers);
            break;
        case"options":
            c.options=a.extend({},e,{
            easing:c.easing
            });
        break
        }
        },
_setupEvents:function(d,c){
    if(d){
        c.on(d.split(" ").join(".maccordion ")+".maccordion",a.proxy(this,"_handleEvent"))
        }
    },
_setupElement:function(){
    this.element.addClass("dattaya-maccordion ui-widget ui-helper-reset");
    this.element.attr("aria-multiselectable",true).attr("role","tablist")
    },
_setupTabs:function(c){
    this._setupHeaders(c);
    this._setupContents(c)
    },
_setupHeaders:function(d){
    var c=this.options;
    d.addClass("dattaya-maccordion-header ui-helper-reset ui-state-default ui-corner-all").attr({
        role:"tab",
        tabindex:-1,
        "aria-selected":false,
        "aria-expanded":false
    }).on({
        "mouseenter.maccordion":function(){
            if(c.disabled){
                return
            }
            a(this).addClass("ui-state-hover")
            },
        "mouseleave.maccordion":function(){
            if(c.disabled){
                return
            }
            a(this).removeClass("ui-state-hover")
            },
        "focus.maccordion":function(){
            if(c.disabled){
                return
            }
            a(this).addClass("ui-state-focus")
            },
        "blur.maccordion":function(){
            if(c.disabled){
                return
            }
            a(this).removeClass("ui-state-focus")
            },
        "keydown.maccordion":a.proxy(this,"_handleKeydown")
        });
    this._setupEvents(this.options.event,d);
    this._setupAnchors(d);
    this._setupIcons(d)
    },
_setupContents:function(c){
    c.next().attr("role","tabpanel");
    c.next().addClass("dattaya-maccordion-content ui-helper-reset ui-widget-content ui-corner-bottom")
    },
_setupIcons:function(c){
    if(this.options.icons){
        a("<span>").addClass("dattaya-maccordion-header-icon ui-icon "+this.options.icons.header).prependTo(c);
        this.$headers.filter(".dattaya-maccordion-header-active").children(".dattaya-maccordion-header-icon").removeClass(this.options.icons.header).addClass(this.options.icons.activeHeader);
        this.element.addClass("dattaya-maccordion-icons")
        }
    },
_setupAnchors:function(c){
    c.children("a:first-child").addClass("dattaya-maccordion-heading").attr("tabindex",-1)
    },
_cleanupAnchors:function(){
    this.$headers.children("a:first-child").removeClass("dattaya-maccordion-heading").removeAttr("tabindex")
    },
_destroyIcons:function(){
    this.element.removeClass("dattaya-maccordion-icons");
    this.$headers.children(".dattaya-maccordion-header-icon").remove()
    },
_setZeroTabindex:function(c){
    if(this.$zeroTabIndex){
        this.$zeroTabIndex.attr("tabindex",-1)
        }
        this.$zeroTabIndex=c.attr("tabindex",0)
    },
_transformActiveToElement:function(c){
    if(c instanceof jQuery){
        return c.filter(".dattaya-maccordion-header")
        }
        switch(true){
        case a.isNumeric(c):
            return this.$headers.eq(c);
        case c===true:
            return this.$headers.not(".dattaya-maccordion-header-active");
        case c==="toggle":
            return this.$headers;
        case a.isArray(c):
            return this.$headers.not(function(d){
            return a.inArray(d,c)===-1
            });
        case c===false:
            return this.$headers.filter(".dattaya-maccordion-header-active");
        default:
            return a([])
            }
        }
})
})(jQuery);