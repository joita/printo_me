<html lang="en" style="margin: 0; outline: none; padding: 0;"><head><style>
        .ac-social-icon { display: inline-block!important; }
    </style>
    <!--[if !mso]><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]--><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><script type="text/javascript" src="https://bam.nr-data.net/1/d3d5c809d5?a=456978955&amp;v=1167.2a4546b&amp;to=M1JQYEMHVhFXB0AMXAoYZ0ZYSVwHRQ1TC1YWGEJGVBBRB0FLQgxWExlCXEE%3D&amp;rst=1129&amp;ref=https://avanda.activehosted.com/designer/155/preview&amp;ap=278&amp;be=457&amp;fe=1122&amp;dc=484&amp;perf=%7B%22timing%22:%7B%22of%22:1587595602213,%22n%22:0,%22f%22:1,%22dn%22:1,%22dne%22:1,%22c%22:1,%22ce%22:1,%22rq%22:7,%22rp%22:407,%22rpe%22:418,%22dl%22:413,%22di%22:483,%22ds%22:483,%22de%22:487,%22dc%22:1118,%22l%22:1118,%22le%22:1123%7D,%22navigation%22:%7B%7D%7D&amp;fp=483&amp;fcp=483&amp;at=HxVHFgsdRU4UBRZfSBlK&amp;jsonp=NREUM.setToken"></script><script src="https://js-agent.newrelic.com/nr-1167.min.js"></script><script type="text/javascript">(window.NREUM||(NREUM={})).loader_config={licenseKey:"d3d5c809d5",applicationID:"456978955"};window.NREUM||(NREUM={}),__nr_require=function(e,n,t){function r(t){if(!n[t]){var i=n[t]={exports:{}};e[t][0].call(i.exports,function(n){var i=e[t][1][n];return r(i||n)},i,i.exports)}return n[t].exports}if("function"==typeof __nr_require)return __nr_require;for(var i=0;i<t.length;i++)r(t[i]);return r}({1:[function(e,n,t){function r(){}function i(e,n,t){return function(){return o(e,[u.now()].concat(f(arguments)),n?null:this,t),n?void 0:this}}var o=e("handle"),a=e(4),f=e(5),c=e("ee").get("tracer"),u=e("loader"),s=NREUM;"undefined"==typeof window.newrelic&&(newrelic=s);var p=["setPageViewName","setCustomAttribute","setErrorHandler","finished","addToTrace","inlineHit","addRelease"],l="api-",d=l+"ixn-";a(p,function(e,n){s[n]=i(l+n,!0,"api")}),s.addPageAction=i(l+"addPageAction",!0),s.setCurrentRouteName=i(l+"routeName",!0),n.exports=newrelic,s.interaction=function(){return(new r).get()};var m=r.prototype={createTracer:function(e,n){var t={},r=this,i="function"==typeof n;return o(d+"tracer",[u.now(),e,t],r),function(){if(c.emit((i?"":"no-")+"fn-start",[u.now(),r,i],t),i)try{return n.apply(this,arguments)}catch(e){throw c.emit("fn-err",[arguments,this,e],t),e}finally{c.emit("fn-end",[u.now()],t)}}}};a("actionText,setName,setAttribute,save,ignore,onEnd,getContext,end,get".split(","),function(e,n){m[n]=i(d+n)}),newrelic.noticeError=function(e,n){"string"==typeof e&&(e=new Error(e)),o("err",[e,u.now(),!1,n])}},{}],2:[function(e,n,t){function r(e,n){var t=e.getEntries();t.forEach(function(e){"first-paint"===e.name?c("timing",["fp",Math.floor(e.startTime)]):"first-contentful-paint"===e.name&&c("timing",["fcp",Math.floor(e.startTime)])})}function i(e,n){var t=e.getEntries();t.length>0&&c("lcp",[t[t.length-1]])}function o(e){if(e instanceof s&&!l){var n,t=Math.round(e.timeStamp);n=t>1e12?Date.now()-t:u.now()-t,l=!0,c("timing",["fi",t,{type:e.type,fid:n}])}}if(!("init"in NREUM&&"page_view_timing"in NREUM.init&&"enabled"in NREUM.init.page_view_timing&&NREUM.init.page_view_timing.enabled===!1)){var a,f,c=e("handle"),u=e("loader"),s=NREUM.o.EV;if("PerformanceObserver"in window&&"function"==typeof window.PerformanceObserver){a=new PerformanceObserver(r),f=new PerformanceObserver(i);try{a.observe({entryTypes:["paint"]}),f.observe({entryTypes:["largest-contentful-paint"]})}catch(p){}}if("addEventListener"in document){var l=!1,d=["click","keydown","mousedown","pointerdown","touchstart"];d.forEach(function(e){document.addEventListener(e,o,!1)})}}},{}],3:[function(e,n,t){function r(e,n){if(!i)return!1;if(e!==i)return!1;if(!n)return!0;if(!o)return!1;for(var t=o.split("."),r=n.split("."),a=0;a<r.length;a++)if(r[a]!==t[a])return!1;return!0}var i=null,o=null,a=/Version\/(\S+)\s+Safari/;if(navigator.userAgent){var f=navigator.userAgent,c=f.match(a);c&&f.indexOf("Chrome")===-1&&f.indexOf("Chromium")===-1&&(i="Safari",o=c[1])}n.exports={agent:i,version:o,match:r}},{}],4:[function(e,n,t){function r(e,n){var t=[],r="",o=0;for(r in e)i.call(e,r)&&(t[o]=n(r,e[r]),o+=1);return t}var i=Object.prototype.hasOwnProperty;n.exports=r},{}],5:[function(e,n,t){function r(e,n,t){n||(n=0),"undefined"==typeof t&&(t=e?e.length:0);for(var r=-1,i=t-n||0,o=Array(i<0?0:i);++r<i;)o[r]=e[n+r];return o}n.exports=r},{}],6:[function(e,n,t){n.exports={exists:"undefined"!=typeof window.performance&&window.performance.timing&&"undefined"!=typeof window.performance.timing.navigationStart}},{}],ee:[function(e,n,t){function r(){}function i(e){function n(e){return e&&e instanceof r?e:e?c(e,f,o):o()}function t(t,r,i,o){if(!l.aborted||o){e&&e(t,r,i);for(var a=n(i),f=v(t),c=f.length,u=0;u<c;u++)f[u].apply(a,r);var p=s[y[t]];return p&&p.push([b,t,r,a]),a}}function d(e,n){h[e]=v(e).concat(n)}function m(e,n){var t=h[e];if(t)for(var r=0;r<t.length;r++)t[r]===n&&t.splice(r,1)}function v(e){return h[e]||[]}function g(e){return p[e]=p[e]||i(t)}function w(e,n){u(e,function(e,t){n=n||"feature",y[t]=n,n in s||(s[n]=[])})}var h={},y={},b={on:d,addEventListener:d,removeEventListener:m,emit:t,get:g,listeners:v,context:n,buffer:w,abort:a,aborted:!1};return b}function o(){return new r}function a(){(s.api||s.feature)&&(l.aborted=!0,s=l.backlog={})}var f="nr@context",c=e("gos"),u=e(4),s={},p={},l=n.exports=i();l.backlog=s},{}],gos:[function(e,n,t){function r(e,n,t){if(i.call(e,n))return e[n];var r=t();if(Object.defineProperty&&Object.keys)try{return Object.defineProperty(e,n,{value:r,writable:!0,enumerable:!1}),r}catch(o){}return e[n]=r,r}var i=Object.prototype.hasOwnProperty;n.exports=r},{}],handle:[function(e,n,t){function r(e,n,t,r){i.buffer([e],r),i.emit(e,n,t)}var i=e("ee").get("handle");n.exports=r,r.ee=i},{}],id:[function(e,n,t){function r(e){var n=typeof e;return!e||"object"!==n&&"function"!==n?-1:e===window?0:a(e,o,function(){return i++})}var i=1,o="nr@id",a=e("gos");n.exports=r},{}],loader:[function(e,n,t){function r(){if(!x++){var e=E.info=NREUM.info,n=d.getElementsByTagName("script")[0];if(setTimeout(s.abort,3e4),!(e&&e.licenseKey&&e.applicationID&&n))return s.abort();u(y,function(n,t){e[n]||(e[n]=t)}),c("mark",["onload",a()+E.offset],null,"api");var t=d.createElement("script");t.src="https://"+e.agent,n.parentNode.insertBefore(t,n)}}function i(){"complete"===d.readyState&&o()}function o(){c("mark",["domContent",a()+E.offset],null,"api")}function a(){return O.exists&&performance.now?Math.round(performance.now()):(f=Math.max((new Date).getTime(),f))-E.offset}var f=(new Date).getTime(),c=e("handle"),u=e(4),s=e("ee"),p=e(3),l=window,d=l.document,m="addEventListener",v="attachEvent",g=l.XMLHttpRequest,w=g&&g.prototype;NREUM.o={ST:setTimeout,SI:l.setImmediate,CT:clearTimeout,XHR:g,REQ:l.Request,EV:l.Event,PR:l.Promise,MO:l.MutationObserver};var h=""+location,y={beacon:"bam.nr-data.net",errorBeacon:"bam.nr-data.net",agent:"js-agent.newrelic.com/nr-1167.min.js"},b=g&&w&&w[m]&&!/CriOS/.test(navigator.userAgent),E=n.exports={offset:f,now:a,origin:h,features:{},xhrWrappable:b,userAgent:p};e(1),e(2),d[m]?(d[m]("DOMContentLoaded",o,!1),l[m]("load",r,!1)):(d[v]("onreadystatechange",i),l[v]("onload",r)),c("mark",["firstbyte",f],null,"api");var x=0,O=e(6)},{}],"wrap-function":[function(e,n,t){function r(e){return!(e&&e instanceof Function&&e.apply&&!e[a])}var i=e("ee"),o=e(5),a="nr@original",f=Object.prototype.hasOwnProperty,c=!1;n.exports=function(e,n){function t(e,n,t,i){function nrWrapper(){var r,a,f,c;try{a=this,r=o(arguments),f="function"==typeof t?t(r,a):t||{}}catch(u){l([u,"",[r,a,i],f])}s(n+"start",[r,a,i],f);try{return c=e.apply(a,r)}catch(p){throw s(n+"err",[r,a,p],f),p}finally{s(n+"end",[r,a,c],f)}}return r(e)?e:(n||(n=""),nrWrapper[a]=e,p(e,nrWrapper),nrWrapper)}function u(e,n,i,o){i||(i="");var a,f,c,u="-"===i.charAt(0);for(c=0;c<n.length;c++)f=n[c],a=e[f],r(a)||(e[f]=t(a,u?f+i:i,o,f))}function s(t,r,i){if(!c||n){var o=c;c=!0;try{e.emit(t,r,i,n)}catch(a){l([a,t,r,i])}c=o}}function p(e,n){if(Object.defineProperty&&Object.keys)try{var t=Object.keys(e);return t.forEach(function(t){Object.defineProperty(n,t,{get:function(){return e[t]},set:function(n){return e[t]=n,n}})}),n}catch(r){l([r])}for(var i in e)f.call(e,i)&&(n[i]=e[i]);return n}function l(n){try{e.emit("internal-error",n)}catch(t){}}return e||(e=i),t.inPlace=u,t.flag=a,t}},{}]},{},["loader"]);</script><meta http-equiv="Content-Language" content="es-es"><meta name="format-detection" content="telephone=no"><meta name="format-detection" content="date=no"><meta name="format-detection" content="address=no"><meta name="format-detection" content="email=no"><title>Vista Previa</title><style data-ac-keep="true"> .ExternalClass { width: 100%; background: inherit; background-color: inherit; } .ExternalClass p, .ExternalClass ul, .ExternalClass ol { Margin: 0; } .undoreset div p, .undoreset p { margin-bottom: 20px; } div[class^="aolmail_divbody"] { overflow: auto; } [owa] #ac-footer { padding: 20px 0px !important; background: inherit; background-color: inherit; } </style><style data-ac-keep="true">
        @media only screen and (max-width: 600px) { /*-------------------------------------------------------------------------*\ Abandoned Cart widget \*------------------------------------------------------------------------*/ .td_abandoned-cart img {display: block;padding-right: 0 !important;padding-bottom: 0 !important;width: 100% !important;max-width: 100% !important;height: auto !important;} body { padding: 0!important; font-size:1em!important; } * { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; } *[class].divbody {-webkit-text-size-adjust:none !important; width:auto !important;} *[class].td_picture img {width:auto !important;} *[class].td_text { line-height: 110%; } *[class].td_button { width: auto; } /* Collapse all block elements */ :not(.body) table { display: block!important; float:none!important; border-collapse:collapse !important; width:100% !important; min-width:100% !important; clear:both!important; } :not(.body) thead, :not(.body) tbody, :not(.body) tr { display:block!important; float:none!important; width:100% !important; } :not(.body) th, :not(.body) td, :not(.body) p { display:block!important; float:none!important; width:100% !important; clear:both!important; } /* Remove browser default styling for elements */ ul, ol { margin-left: 20px; margin-bottom: 10px; margin-top: 10px; -webkit-margin-before: 0; -webkit-margin-after: 0; -webkit-padding-start: 0; } /* Set default height for spacer once collapse */ *[class].spacer { height: auto!important; } a[href^=date]{ color:inherit !important; text-decoration:none !important;} a[href^=telephone]{ color:inherit !important; text-decoration:none !important;} a[href^=address]{ color:inherit !important; text-decoration:none !important;} a[href^=email]{ color:inherit !important; text-decoration:none !important;} /* Default table cell height */ td[height="14"]{height:14px!important;font-size:14px!important;line-height:14px!important;} /*-------------------------------------------------------------------------*\ Product Widget \*-------------------------------------------------------------------------*/ .td_product > div { float: none !important; width: 100% !important; margin-bottom: 20px !important; } .td_product > div img { width: 75% !important; } /* Default social icons */ *[class].ac-social-icon-16 {width:16px !important; height:16px !important;} *[class].ac-social-icon-24 {width:24px !important; height:24px !important;} *[class].ac-social-icon-28 {width:28px !important; height:28px !important;} *[class].__ac_social_icons { margin-right: 0px !important; } }
    </style><style data-ac-keep="true"> @media only screen and (max-width: 320px) { #layout-row1949 { max-height: 0px!important; font-size: 0px!important; display: none!important; visibility: hidden!important; } #layout-row1950 img { width: 100% !important; height: auto !important; max-width: 320px !important; } #layout-row1952 img { width: 100% !important; height: auto !important; max-width: 320px !important; } #layout-row1954 img { width: 100% !important; height: auto !important; max-width: 320px !important; } #layout-row1955 img { width: 100% !important; height: auto !important; max-width: 320px !important; } .td_rss .rss-item img.iphone_large_image { width: auto !important; } u + .body { display: table !important; width: 100vw !important; min-width: 100vw !important; } u + .body table { display: table !important; width: 100% !important; min-width: 100% !important; } u + .body td { display: block !important; width: 100% !important; min-width: 100% !important; } u + .body img { display: inline-block !important; margin: auto !important; width: auto !important; vertical-align: bottom !important; } u + .body center { display: block !important; margin: auto !important; width: 100% !important; min-width: 100% !important; text-align: center !important; } u + .body table._ac_social_table, u + .body table._ac_social_table td, u + .body table._ac_social_table div, u + .body table._ac_social_table a { display: inline-block !important; margin: auto !important; width: auto !important; min-width: auto !important; text-align: center !important; } u + .body table._ac_social_table img { display: inline-block !important; margin: auto !important; width: 32px !important; min-width: 32px !important; max-width: 32px !important; }
        }
        @media only screen and (max-width: 375px) { #layout-row1949 { max-height: 0px!important; font-size: 0px!important; display: none!important; visibility: hidden!important; } #layout-row1950 img { width: 100% !important; height: auto !important; max-width: 375px !important; } #layout-row1952 img { width: 100% !important; height: auto !important; max-width: 375px !important; } #layout-row1954 img { width: 100% !important; height: auto !important; max-width: 375px !important; } #layout-row1955 img { width: 100% !important; height: auto !important; max-width: 375px !important; } .td_rss .rss-item img.iphone_large_image { width: auto !important; } u + .body { display: table !important; width: 100vw !important; min-width: 100vw !important; } u + .body table { display: table !important; width: 100% !important; min-width: 100% !important; } u + .body td { display: block !important; width: 100% !important; min-width: 100% !important; } u + .body img { display: inline-block !important; margin: auto !important; width: auto !important; vertical-align: bottom !important; } u + .body center { display: block !important; margin: auto !important; width: 100% !important; min-width: 100% !important; text-align: center !important; } u + .body table._ac_social_table, u + .body table._ac_social_table td, u + .body table._ac_social_table div, u + .body table._ac_social_table a { display: inline-block !important; margin: auto !important; width: auto !important; min-width: auto !important; text-align: center !important; } u + .body table._ac_social_table img { display: inline-block !important; margin: auto !important; width: 32px !important; min-width: 32px !important; max-width: 32px !important; }
        }
        @media only screen and (max-width: 414px) { #layout-row1949 { max-height: 0px!important; font-size: 0px!important; display: none!important; visibility: hidden!important; } #layout-row1950 img { width: 100% !important; height: auto !important; max-width: 414px !important; } #layout-row1952 img { width: 100% !important; height: auto !important; max-width: 414px !important; } #layout-row1954 img { width: 100% !important; height: auto !important; max-width: 414px !important; } #layout-row1955 img { width: 100% !important; height: auto !important; max-width: 414px !important; } .td_rss .rss-item img.iphone_large_image { width: auto !important; } u + .body { display: table !important; width: 100vw !important; min-width: 100vw !important; } u + .body table { display: table !important; width: 100% !important; min-width: 100% !important; } u + .body td { display: block !important; width: 100% !important; min-width: 100% !important; } u + .body img { display: inline-block !important; margin: auto !important; width: auto !important; vertical-align: bottom !important; } u + .body center { display: block !important; margin: auto !important; width: 100% !important; min-width: 100% !important; text-align: center !important; } u + .body table._ac_social_table, u + .body table._ac_social_table td, u + .body table._ac_social_table div, u + .body table._ac_social_table a { display: inline-block !important; margin: auto !important; width: auto !important; min-width: auto !important; text-align: center !important; } u + .body table._ac_social_table img { display: inline-block !important; margin: auto !important; width: 32px !important; min-width: 32px !important; max-width: 32px !important; }
        }
        @media only screen and (max-width: 667px) { #layout-row1949 { max-height: 0px!important; font-size: 0px!important; display: none!important; visibility: hidden!important; } #layout-row1950 img { width: 100% !important; height: auto !important; max-width: 667px !important; } #layout-row1952 img { width: 100% !important; height: auto !important; max-width: 667px !important; } #layout-row1954 img { width: 100% !important; height: auto !important; max-width: 667px !important; } #layout-row1955 img { width: 100% !important; height: auto !important; max-width: 667px !important; } .td_rss .rss-item img.iphone_large_image { width: auto !important; } u + .body { display: table !important; width: 100vw !important; min-width: 100vw !important; } u + .body table { display: table !important; width: 100% !important; min-width: 100% !important; } u + .body td { display: block !important; width: 100% !important; min-width: 100% !important; } u + .body img { display: inline-block !important; margin: auto !important; width: auto !important; vertical-align: bottom !important; } u + .body center { display: block !important; margin: auto !important; width: 100% !important; min-width: 100% !important; text-align: center !important; } u + .body table._ac_social_table, u + .body table._ac_social_table td, u + .body table._ac_social_table div, u + .body table._ac_social_table a { display: inline-block !important; margin: auto !important; width: auto !important; min-width: auto !important; text-align: center !important; } u + .body table._ac_social_table img { display: inline-block !important; margin: auto !important; width: 32px !important; min-width: 32px !important; max-width: 32px !important; }
        } </style><!--[if !mso]><!-- webfonts --><!--<![endif]--><!--[if lt mso 12]> <![endif]--></head><body id="ac-designer" class="body" style="font-family: Arial; line-height: 1.1; margin: 0px; background-color: #e6e6e6; width: 100%; text-align: center;" marginwidth="0" marginheight="0"><div class="divbody" style="margin: 0px; outline: none; padding: 0px; color: #000000; font-family: arial; line-height: 1.1; width: 100%; background-color: #e6e6e6; background: #e6e6e6; text-align: center;"><table class="template-table" border="0" cellpadding="0" cellspacing="0" width="100%" align="left" style="font-size: 14px; min-width: auto; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #e6e6e6; background: #e6e6e6;"><tbody><tr><td align="center" valign="top" width="100%"><table class="template-table" border="0" cellpadding="0" cellspacing="0" width="650" bgcolor="#e6e6e6" style="font-size: 14px; min-width: auto; mso-table-lspace: 0pt; mso-table-rspace: 0pt; max-width: 650px;"><tbody><tr><td id="layout_table_510ea247092bdbc2a21fc885749ce188d2f29a59" valign="top" align="center" width="650" style="background-color: #ffffff;"><table cellpadding="0" cellspacing="0" border="0" class="layout layout-table root-table" width="650" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff;"><tbody><tr style="background-color: #ffffff;"><td id="layout-row-margin1949" valign="top" style="padding: 0; background-color: #ffffff;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: initial !important;"><tbody><tr id="layout-row1949" class="layout layout-row widget _widget_text style1949" style="margin: 0; padding: 0; background-color: #e6e6e6;"></tr></tbody></table></td></tr><tr style="background-color: #ffffff;"><td id="layout-row-margin1950" valign="top" style="background-color: #ffffff;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr id="layout-row1950" class="layout layout-row widget _widget_picture " align="left"><td id="layout-row-padding1950" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr><td class="image-td" align="left" valign="top" width="650"><img src="https://avanda.img-us10.com/public//3fb4c2784f794d02ad6637fca1af8886.jpg?r=899200387" alt="" width="650" style="display: block; border: none; outline: none; width: 650px; opacity: 1; max-width: 100%;"></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr style="background-color: #ffffff;"><td id="layout-row-margin1948" valign="top" style="padding: 0; background-color: #ffffff;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: initial !important;"><tbody><tr id="layout-row1948" class="layout layout-row widget _widget_text style1948" style="margin: 0; padding: 0; background-color: #ffffff;"><td id="layout-row-padding1948" valign="top" style="background-color: #ffffff; padding: 0px 25px 0px 25px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr><td id="text_div1808" class="td_text td_block" valign="top" align="left" width="600" style="line-height: 190%; margin: 0; outline: none; padding: 0; color: inherit; font-size: 12px; font-weight: inherit; line-height: 1.9; text-decoration: inherit; font-family: Arial; mso-line-height-rule: exactly;"> <div style="line-height: 190%; margin: 0; outline: none; padding: 0; color: #fa6b23; line-height: 1.9; mso-line-height-rule: exactly;" data-line-height="1.9"> <div style="margin: 0; outline: none; padding: 0; font-size: 18px; color: #fa6b23;"> <div style="margin: 0; outline: none; padding: 0; color: #fa6b23;"> <span class="" style="color: #fa6b23; font-size: inherit; font-weight: bold; line-height: inherit; text-decoration: inherit; font-family: arial, helvetica, sans;"> </span><p style="margin: 0; outline: none; padding: 0; color: #fa6b23; font-size: inherit; font-weight: inherit; line-height: inherit; text-decoration: inherit; text-align: left;"><span class="" style="color: #fa6b23; font-size: inherit; font-weight: bold; line-height: inherit; text-decoration: inherit; font-family: arial, helvetica, sans;">¡Hola <?php echo $nombre?>!<br></span></p> </div> </div> </div><!--[if (gte mso 12)&(lte mso 15) ]>
                                                                <style data-ac-keep="true" data-ac-inline="false"> #text_div1808, #text_div1808 div { line-height: 190% !important; };
                                                                </style>
                                                                <![endif]--></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr style="background-color: #ffffff;"><td id="layout-row-margin1957" valign="top" style="padding: 0; background-color: #ffffff;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: initial !important;"><tbody><tr id="layout-row1957" class="layout layout-row widget _widget_text style1957" style="margin: 0; padding: 0; background-color: #ffffff;"><td id="layout-row-padding1957" valign="top" style="background-color: #ffffff; padding: 0px 25px 0px 25px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr><td id="text_div1816" class="td_text td_block" valign="top" align="left" width="600" style="line-height: 190%; margin: 0; outline: none; padding: 0; color: inherit; font-size: 12px; font-weight: inherit; line-height: 1.9; text-decoration: inherit; font-family: Arial; mso-line-height-rule: exactly;"> <div style="line-height: 190%; margin: 0; outline: none; padding: 0; text-align: justify; line-height: 1.9; mso-line-height-rule: exactly;" data-line-height="1.9"> <span style="color: #000000; font-size: 16px; font-weight: 400; line-height: inherit; text-decoration: inherit; font-family: arial; font-style: normal;">¡Aún estás a tiempo!<br>Nuestros paquetes de cubrebocas reutilizables están esperando por ti.</span><span style="color: #000000; font-size: 16px; font-weight: 400; line-height: inherit; text-decoration: inherit; font-family: arial; font-style: normal;"> </span> <br></div><!--[if (gte mso 12)&(lte mso 15) ]>
                                                                <style data-ac-keep="true" data-ac-inline="false"> #text_div1816, #text_div1816 div { line-height: 190% !important; };
                                                                </style>
                                                                <![endif]--></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr style="background-color: #ffffff;"><td id="layout-row-margin1962" valign="top" style="padding: 0px; background-color: #ffffff;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: initial !important;"><tbody><tr id="layout-row1962" class="layout layout-row widget _widget_text style1962" style="margin: 0; padding: 0; background-color: #ffffff;"><td id="layout-row-padding1962" valign="top" style="background-color: #ffffff; padding: 9px 25px 0px 25px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr><td id="text_div1819" class="td_text td_block" valign="top" align="left" width="600" style="line-height: 152%; margin: 0; outline: none; padding: 0; color: inherit; font-size: 12px; font-weight: inherit; line-height: 1.52; text-decoration: inherit; font-family: Arial; mso-line-height-rule: exactly;"> <div style="line-height: 152%; margin: 0; outline: none; padding: 0; font-size: 16px; line-height: 1.52; mso-line-height-rule: exactly;" data-line-height="1.52"> <div style="margin: 0; outline: none; padding: 0;"><span style="color: #000000; font-size: inherit; font-weight: 400; line-height: inherit; text-decoration: inherit; font-family: arial; font-style: normal;">Contamos con dos increíbles diseños “No manches, cuidémonos.” y “Si sabes contar cuenta conmigo”  disponibles en paquetes de 10 piezas para que puedas adquirirlos, cuidarte con estilo y cuidar del medio ambiente.</span> <br><br><ul style="margin: 0 0 0 40px; padding: 0;"><li style="display: list-item; line-height: inherit; list-style-type: disc; margin: 0 0 0 3px;">Hechos 100% de algodón.</li><li style="display: list-item; line-height: inherit; list-style-type: disc; margin: 0 0 0 3px;">¡Envío gratis inmediato!</li><li style="display: list-item; line-height: inherit; list-style-type: disc; margin: 0 0 0 3px;">Por solo $399 pesos</li></ul><br></div> </div><!--[if (gte mso 12)&(lte mso 15) ]>
                                                                <style data-ac-keep="true" data-ac-inline="false"> #text_div1819, #text_div1819 div { line-height: 152% !important; };
                                                                </style>
                                                                <![endif]--></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr id="layout-row1956" class="layout layout-row clear-this " style="background-color: #ffffff;"><td id="layout-row-padding1956" valign="top" style="background-color: #ffffff;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr><td id="layout_table_5f9720bae1cd11300a4f77dde8b6884f3932c246" valign="top" width="325" style="background-color: #ffffff;"><table cellpadding="0" cellspacing="0" border="0" class="layout layout-table " width="325" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff;"><tbody><tr style="background-color: #ffffff;"><td id="layout-row-margin1954" valign="top" style="background-color: #ffffff;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr id="layout-row1954" class="layout layout-row widget _widget_picture " align="center"><td id="layout-row-padding1954" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr><td class="image-td" align="center" valign="top" width="325"><a href="https://printome.mx/compra/venta-inmediata/cubrebocas-no-manches-cuidemonos-34924" style="margin: 0; outline: none; padding: 0; color: #cccccc; display: block; min-width: 100%;"><img src="https://avanda.img-us10.com/public//2dde4f7fcf7232df87edd796c33fe411.jpg?r=1009665364" alt="cubrebocas no manches cuidemonos" width="267" style="border: none; display: block; outline: none; width: 267px; opacity: 1; max-width: 100%;"></a></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr style="background-color: #ffffff;"><td id="layout-row-margin1953" valign="top" style="padding: 5px; background-color: #ffffff;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: initial !important;"><tbody><tr id="layout-row1953" class="layout layout-row widget _widget_button style1953" style=""><td id="layout-row-padding1953" valign="top" style="padding: 5px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr><td class="td_button td_block customizable" valign="top" align="left" width="305"> <div class="button-wrapper" style="margin: 0; outline: none; padding: 0; text-align: center;">
                                                                                            <!--[if mso]> <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://printome.mx/compra/venta-inmediata/cubrebocas-no-manches-cuidemonos-34924" style="v-text-anchor:middle; width:185px; height:60px; " arcsize="10%" strokecolor="#ffffff" strokeweight="1pt" fillcolor="#fa6b23" o:button="true" o:allowincell="true" o:allowoverlap="false" > <v:textbox inset="2px,2px,2px,2px"> <center style="color:#ffffff;font-family:Arial Black, Arial-BoldMT, Arial Bold, Arial, sans-serif; font-size:14px; line-height: 1.1;">¡Encuentralo aquí!</center> </v:textbox> </v:roundrect>
                                                                                            <![endif]--> <a href="https://printome.mx/compra/venta-inmediata/cubrebocas-no-manches-cuidemonos-34924" style="margin: 0; outline: none; padding: 12px; color: #ffffff; background-color: #fa6b23; border: 1px solid #ffffff; border-radius: 10px; font-family: Arial Black, Arial-BoldMT, Arial Bold, Arial, sans-serif; font-size: 14px; display: inline-block; line-height: 1.1; text-align: center; text-decoration: none; mso-hide: all;"> <span style="color:#ffffff;font-family:Arial Black, Arial-BoldMT, Arial Bold, Arial, sans-serif;font-size:14px;"> ¡Encuentralo aquí! </span> </a> </div>
                                                                                    </td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td><td id="layout_table_8ec0837ba2faf14281e0ca15e06bcedc6db68af7" valign="top" width="325" style="background-color: #ffffff;"><table cellpadding="0" cellspacing="0" border="0" class="layout layout-table " width="325" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff;"><tbody><tr style="background-color: #ffffff;"><td id="layout-row-margin1955" valign="top" style="background-color: #ffffff;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr id="layout-row1955" class="layout layout-row widget _widget_picture " align="center"><td id="layout-row-padding1955" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr><td class="image-td" align="center" valign="top" width="325"><a href="https://printome.mx/compra/venta-inmediata/cubrebocas-si-sabes-contar-cuenta-conmigo-34925" style="margin: 0; outline: none; padding: 0; color: #cccccc; display: block; min-width: 100%;"><img src="https://avanda.img-us10.com/public//c28d0aba08ade9e17d34217d21f0707c.jpg?r=794419272" alt="cubrebocas si sabes contar cuenta conmigo" width="267" style="border: none; display: block; outline: none; width: 267px; opacity: 1; max-width: 100%;"></a></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr style="background-color: #ffffff;"><td id="layout-row-margin1965" valign="top" style="padding: 5px; background-color: #ffffff;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: initial !important;"><tbody><tr id="layout-row1965" class="layout layout-row widget _widget_button style1965" style=""><td id="layout-row-padding1965" valign="top" style="padding: 5px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr><td class="td_button td_block customizable" valign="top" align="left" width="305"> <div class="button-wrapper" style="margin: 0; outline: none; padding: 0; text-align: center;">
                                                                                            <!--[if mso]> <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="https://printome.mx/compra/venta-inmediata/cubrebocas-si-sabes-contar-cuenta-conmigo-34925" style="v-text-anchor:middle; width:185px; height:60px; " arcsize="10%" strokecolor="#ffffff" strokeweight="1pt" fillcolor="#fa6b23" o:button="true" o:allowincell="true" o:allowoverlap="false" > <v:textbox inset="2px,2px,2px,2px"> <center style="color:#ffffff;font-family:Arial Black, Arial-BoldMT, Arial Bold, Arial, sans-serif; font-size:14px; line-height: 1.1;">¡Encuentralo aquí!</center> </v:textbox> </v:roundrect>
                                                                                            <![endif]--> <a href="https://printome.mx/compra/venta-inmediata/cubrebocas-si-sabes-contar-cuenta-conmigo-34925" style="margin: 0; outline: none; padding: 12px; color: #ffffff; background-color: #fa6b23; border: 1px solid #ffffff; border-radius: 10px; font-family: Arial Black, Arial-BoldMT, Arial Bold, Arial, sans-serif; font-size: 14px; display: inline-block; line-height: 1.1; text-align: center; text-decoration: none; mso-hide: all;"> <span style="color:#ffffff;font-family:Arial Black, Arial-BoldMT, Arial Bold, Arial, sans-serif;font-size:14px;"> ¡Encuentralo aquí! </span> </a> </div>
                                                                                    </td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr style="background-color: #ffffff;"><td id="layout-row-margin1952" valign="top" style="background-color: #ffffff;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr id="layout-row1952" class="layout layout-row widget _widget_picture " align="left"><td id="layout-row-padding1952" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 14px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr><td class="image-td" align="left" valign="top" width="650"><img src="https://avanda.img-us10.com/public//dd9030661f69033bc9318a9f4d42042f.jpg?r=1483167749" alt="" width="650" style="display: block; border: none; outline: none; width: 650px; opacity: 1; max-width: 100%;"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td align="center"></td></tr></tbody></table></td></tr></tbody></table></div><script type="text/javascript">window.NREUM||(NREUM={});NREUM.info={"beacon":"bam.nr-data.net","licenseKey":"d3d5c809d5","applicationID":"456978955","transactionName":"M1JQYEMHVhFXB0AMXAoYZ0ZYSVwHRQ1TC1YWGEJGVBBRB0FLQgxWExlCXEE=","queueTime":0,"applicationTime":278,"atts":"HxVHFgsdRU4UBRZfSBlK","errorBeacon":"bam.nr-data.net","agent":""}</script>
</body></html>