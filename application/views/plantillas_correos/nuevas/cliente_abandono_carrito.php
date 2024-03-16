<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" style="margin: 0; outline: none; padding: 0;"><head><!--[if !mso]><meta http-equiv="X-UA-Compatible" content="IE=edge"><!--<![endif]--><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><script type="text/javascript">window.NREUM||(NREUM={}),__nr_require=function(e,t,n){function r(n){if(!t[n]){var o=t[n]={exports:{}};e[n][0].call(o.exports,function(t){var o=e[n][1][t];return r(o||t)},o,o.exports)}return t[n].exports}if("function"==typeof __nr_require)return __nr_require;for(var o=0;o<n.length;o++)r(n[o]);return r}({1:[function(e,t,n){function r(){}function o(e,t,n){return function(){return i(e,[(new Date).getTime()].concat(u(arguments)),t?null:this,n),t?void 0:this}}var i=e("handle"),a=e(2),u=e(3),c=e("ee").get("tracer"),f=NREUM;"undefined"==typeof window.newrelic&&(newrelic=f);var s=["setPageViewName","setCustomAttribute","setErrorHandler","finished","addToTrace","inlineHit"],l="api-",p=l+"ixn-";a(s,function(e,t){f[t]=o(l+t,!0,"api")}),f.addPageAction=o(l+"addPageAction",!0),f.setCurrentRouteName=o(l+"routeName",!0),t.exports=newrelic,f.interaction=function(){return(new r).get()};var d=r.prototype={createTracer:function(e,t){var n={},r=this,o="function"==typeof t;return i(p+"tracer",[Date.now(),e,n],r),function(){if(c.emit((o?"":"no-")+"fn-start",[Date.now(),r,o],n),o)try{return t.apply(this,arguments)}finally{c.emit("fn-end",[Date.now()],n)}}}};a("setName,setAttribute,save,ignore,onEnd,getContext,end,get".split(","),function(e,t){d[t]=o(p+t)}),newrelic.noticeError=function(e){"string"==typeof e&&(e=new Error(e)),i("err",[e,(new Date).getTime()])}},{}],2:[function(e,t,n){function r(e,t){var n=[],r="",i=0;for(r in e)o.call(e,r)&&(n[i]=t(r,e[r]),i+=1);return n}var o=Object.prototype.hasOwnProperty;t.exports=r},{}],3:[function(e,t,n){function r(e,t,n){t||(t=0),"undefined"==typeof n&&(n=e?e.length:0);for(var r=-1,o=n-t||0,i=Array(o<0?0:o);++r<o;)i[r]=e[t+r];return i}t.exports=r},{}],ee:[function(e,t,n){function r(){}function o(e){function t(e){return e&&e instanceof r?e:e?c(e,u,i):i()}function n(n,r,o){if(!p.aborted){e&&e(n,r,o);for(var i=t(o),a=v(n),u=a.length,c=0;c<u;c++)a[c].apply(i,r);var f=s[w[n]];return f&&f.push([y,n,r,i]),i}}function d(e,t){b[e]=v(e).concat(t)}function v(e){return b[e]||[]}function g(e){return l[e]=l[e]||o(n)}function m(e,t){f(e,function(e,n){t=t||"feature",w[n]=t,t in s||(s[t]=[])})}var b={},w={},y={on:d,emit:n,get:g,listeners:v,context:t,buffer:m,abort:a,aborted:!1};return y}function i(){return new r}function a(){(s.api||s.feature)&&(p.aborted=!0,s=p.backlog={})}var u="nr@context",c=e("gos"),f=e(2),s={},l={},p=t.exports=o();p.backlog=s},{}],gos:[function(e,t,n){function r(e,t,n){if(o.call(e,t))return e[t];var r=n();if(Object.defineProperty&&Object.keys)try{return Object.defineProperty(e,t,{value:r,writable:!0,enumerable:!1}),r}catch(i){}return e[t]=r,r}var o=Object.prototype.hasOwnProperty;t.exports=r},{}],handle:[function(e,t,n){function r(e,t,n,r){o.buffer([e],r),o.emit(e,t,n)}var o=e("ee").get("handle");t.exports=r,r.ee=o},{}],id:[function(e,t,n){function r(e){var t=typeof e;return!e||"object"!==t&&"function"!==t?-1:e===window?0:a(e,i,function(){return o++})}var o=1,i="nr@id",a=e("gos");t.exports=r},{}],loader:[function(e,t,n){function r(){if(!h++){var e=y.info=NREUM.info,t=l.getElementsByTagName("script")[0];if(setTimeout(f.abort,3e4),!(e&&e.licenseKey&&e.applicationID&&t))return f.abort();c(b,function(t,n){e[t]||(e[t]=n)}),u("mark",["onload",a()],null,"api");var n=l.createElement("script");n.src="https://"+e.agent,t.parentNode.insertBefore(n,t)}}function o(){"complete"===l.readyState&&i()}function i(){u("mark",["domContent",a()],null,"api")}function a(){return(new Date).getTime()}var u=e("handle"),c=e(2),f=e("ee"),s=window,l=s.document,p="addEventListener",d="attachEvent",v=s.XMLHttpRequest,g=v&&v.prototype;NREUM.o={ST:setTimeout,CT:clearTimeout,XHR:v,REQ:s.Request,EV:s.Event,PR:s.Promise,MO:s.MutationObserver},e(1);var m=""+location,b={beacon:"bam.nr-data.net",errorBeacon:"bam.nr-data.net",agent:"js-agent.newrelic.com/nr-998.min.js"},w=v&&g&&g[p]&&!/CriOS/.test(navigator.userAgent),y=t.exports={offset:a(),origin:m,features:{},xhrWrappable:w};l[p]?(l[p]("DOMContentLoaded",i,!1),s[p]("load",r,!1)):(l[d]("onreadystatechange",o),s[d]("onload",r)),u("mark",["firstbyte",a()],null,"api");var h=0},{}]},{},["loader"]);</script><meta http-equiv="Content-Language" content="en-us"><meta name="format-detection" content="telephone=no"><meta name="format-detection" content="date=no"><meta name="format-detection" content="address=no"><meta name="format-detection" content="email=no"><title>Preview</title><style data-ac-keep="true">
.ExternalClass {width:100%; background:inherit; background-color:inherit;}
.ExternalClass p, .ExternalClass ul, .ExternalClass ol { Margin: 0; }
.undoreset div p, .undoreset p { margin-bottom: 20px; }
</style><style data-ac-keep="true">
@media only screen and (max-width: 600px) {	body { padding: 0!important; font-size:1em!important; } * { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; } * a:link, * a:hover, * a:visited, * a:active { word-wrap: break-word; } *[class].divbody {-webkit-text-size-adjust:none !important; width:auto !important;} *[class].td_picture img {width:auto !important;} *[class].td_text { line-height: 110%; } *[class].td_button { width: auto; } /* Collapse all block elements */ :not(.body) table { display: block!important; float:none!important; border-collapse:collapse !important; width:100% !important; min-width:100% !important; clear:both!important; } :not(.body) thead, :not(.body) tbody, :not(.body) tr { display:block!important; float:none!important; width:100% !important; } :not(.body) th, :not(.body) td, :not(.body) p { display:block!important; float:none!important; width:100% !important; clear:both!important; } /* Remove browser default styling for elements */ ul, ol { margin-left: 20px; margin-bottom: 10px; margin-top: 10px; -webkit-margin-before: 0; -webkit-margin-after: 0; -webkit-padding-start: 0; } /* Set default height for spacer once collapse */ *[class].spacer { height: auto!important; } a[href^=date]{ color:inherit !important; text-decoration:none !important;} a[href^=telephone]{ color:inherit !important; text-decoration:none !important;} a[href^=address]{ color:inherit !important; text-decoration:none !important;} a[href^=email]{ color:inherit !important; text-decoration:none !important;} /* Default table cell height */ /* Default social icons */ *[class].ac-social-icon-16 {width:16px !important; height:16px !important;} *[class].ac-social-icon-24 {width:24px !important; height:24px !important;} *[class].ac-social-icon-28 {width:28px !important; height:28px !important;} *[class].__ac_social_icons { margin-right: 0px !important; } }
</style><style data-ac-keep="true"> @media only screen and (max-width: 667px) { #layout-row1074 { max-height: 0px!important; font-size: 0px!important; display: none!important; visibility: hidden!important; } #layout-row1075 img { width: 100% !important; height: auto !important; max-width: 667px !important; } #layout-row1077 img { width: 100% !important; height: auto !important; max-width: 667px !important; } #layout-row1079 .break-line { width: 100% !important; margin: auto !important; } u + .body { display: table !important; width: 100vw !important; min-width: 100vw !important; } u + .body table { display: table !important; width: 100% !important; min-width: 100% !important; } u + .body td { display: block !important; width: 100% !important; min-width: 100% !important; } u + .body img { display: inline-block !important; margin: auto !important; width: auto !important; vertical-align: bottom !important; } u + .body center { display: block !important; margin: auto !important; width: 100% !important; min-width: 100% !important; text-align: center !important; } u + .body table._ac_social_table, u + .body table._ac_social_table td, u + .body table._ac_social_table div, u + .body table._ac_social_table a { display: inline-block !important; margin: auto !important; width: auto !important; min-width: auto !important; text-align: center !important; } u + .body table._ac_social_table img { display: inline-block !important; margin: auto !important; width: 32px !important; min-width: 32px !important; max-width: 32px !important; }
}
@media only screen and (max-width: 414px) { #layout-row1074 { max-height: 0px!important; font-size: 0px!important; display: none!important; visibility: hidden!important; } #layout-row1075 img { width: 100% !important; height: auto !important; max-width: 414px !important; } #layout-row1077 img { width: 100% !important; height: auto !important; max-width: 414px !important; } #layout-row1079 .break-line { width: 100% !important; margin: auto !important; } u + .body { display: table !important; width: 100vw !important; min-width: 100vw !important; } u + .body table { display: table !important; width: 100% !important; min-width: 100% !important; } u + .body td { display: block !important; width: 100% !important; min-width: 100% !important; } u + .body img { display: inline-block !important; margin: auto !important; width: auto !important; vertical-align: bottom !important; } u + .body center { display: block !important; margin: auto !important; width: 100% !important; min-width: 100% !important; text-align: center !important; } u + .body table._ac_social_table, u + .body table._ac_social_table td, u + .body table._ac_social_table div, u + .body table._ac_social_table a { display: inline-block !important; margin: auto !important; width: auto !important; min-width: auto !important; text-align: center !important; } u + .body table._ac_social_table img { display: inline-block !important; margin: auto !important; width: 32px !important; min-width: 32px !important; max-width: 32px !important; }
}
@media only screen and (max-width: 375px) { #layout-row1074 { max-height: 0px!important; font-size: 0px!important; display: none!important; visibility: hidden!important; } #layout-row1075 img { width: 100% !important; height: auto !important; max-width: 375px !important; } #layout-row1077 img { width: 100% !important; height: auto !important; max-width: 375px !important; } #layout-row1079 .break-line { width: 100% !important; margin: auto !important; } u + .body { display: table !important; width: 100vw !important; min-width: 100vw !important; } u + .body table { display: table !important; width: 100% !important; min-width: 100% !important; } u + .body td { display: block !important; width: 100% !important; min-width: 100% !important; } u + .body img { display: inline-block !important; margin: auto !important; width: auto !important; vertical-align: bottom !important; } u + .body center { display: block !important; margin: auto !important; width: 100% !important; min-width: 100% !important; text-align: center !important; } u + .body table._ac_social_table, u + .body table._ac_social_table td, u + .body table._ac_social_table div, u + .body table._ac_social_table a { display: inline-block !important; margin: auto !important; width: auto !important; min-width: auto !important; text-align: center !important; } u + .body table._ac_social_table img { display: inline-block !important; margin: auto !important; width: 32px !important; min-width: 32px !important; max-width: 32px !important; }
}
@media only screen and (max-width: 375px) { #layout-row1074 { max-height: 0px!important; font-size: 0px!important; display: none!important; visibility: hidden!important; } #layout-row1075 img { width: 100% !important; height: auto !important; max-width: 375px !important; } #layout-row1077 img { width: 100% !important; height: auto !important; max-width: 375px !important; } #layout-row1079 .break-line { width: 100% !important; margin: auto !important; } u + .body { display: table !important; width: 100vw !important; min-width: 100vw !important; } u + .body table { display: table !important; width: 100% !important; min-width: 100% !important; } u + .body td { display: block !important; width: 100% !important; min-width: 100% !important; } u + .body img { display: inline-block !important; margin: auto !important; width: auto !important; vertical-align: bottom !important; } u + .body center { display: block !important; margin: auto !important; width: 100% !important; min-width: 100% !important; text-align: center !important; } u + .body table._ac_social_table, u + .body table._ac_social_table td, u + .body table._ac_social_table div, u + .body table._ac_social_table a { display: inline-block !important; margin: auto !important; width: auto !important; min-width: auto !important; text-align: center !important; } u + .body table._ac_social_table img { display: inline-block !important; margin: auto !important; width: 32px !important; min-width: 32px !important; max-width: 32px !important; }
}
</style></head><body id="ac-designer" class="body" style="font-family: Arial; line-height: 1.1; margin: 0px; background-color: #e6e6e6; width: 100%; text-align: center;"><div class="divbody" style="margin: 0px; outline: none; padding: 0px; color: #5D5D5D; font-family: arial; line-height: 1.1; width: 100%; background-color: #e6e6e6; background: #e6e6e6; text-align: center;"><table class="template-table" border="0" cellpadding="0" cellspacing="0" width="100%" align="left" style="font-size: 13px; min-width: auto; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #e6e6e6; background: #e6e6e6;"><tr><td align="center" valign="top" width="100%"><table class="template-table" border="0" cellpadding="0" cellspacing="0" width="650" bgcolor="#e6e6e6" style="font-size: 13px; min-width: auto; mso-table-lspace: 0pt; mso-table-rspace: 0pt; max-width: 650px;"><tr><td id="layout_table_c8c730c753d928422c6d6b970b49767da8885dae" valign="top" align="center" width="650" style="background-color: #ffffff;"><table cellpadding="0" cellspacing="0" border="0" class="layout layout-table root-table" width="650" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tr><td id="layout-row-margin1074" valign="top" style="background-color: #e6e6e6; padding: 0;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: initial !important;"></table></td></tr><tr><td id="layout-row-margin1075" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tr id="layout-row1075" class="layout layout-row widget _widget_picture " align="left"><td id="layout-row-padding1075" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tr><td class="image-td" align="left" valign="top" width="650"><img src="http://avanda.img-us10.com/public/082efe991598f96d11e616f48aff7d3f.jpg?r=705519989" alt="" width="650" style="display: block; border: none; outline: none; width: 650px; opacity: 1; max-width: 100%;"></td></tr></table></td></tr></table></td></tr><tr><td id="layout-row-margin1073" valign="top" style="background-color: #ffffff; padding: 0;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: initial !important;"><tr id="layout-row1073" class="layout layout-row widget _widget_text style1073" style="margin: 0; padding: 0; background-color: #ffffff;"><td id="layout-row-padding1073" valign="top" style="background-color: #ffffff; padding: 0px 25px 0px 25px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tr><td id="text_div984" class="td_text td_block" valign="top" align="left" style="line-height: 190%; color: inherit; font-size: inherit; font-weight: inherit; line-height: 1.9; text-decoration: inherit; font-family: Arial; mso-line-height-rule: exactly;"> <div style="line-height: 190%; margin: 0; outline: none; padding: 0; color: #fa6b23; mso-line-height-rule: exactly; line-height: 1.9;" data-line-height="1.9"> <div style="margin: 0; outline: none; padding: 0; font-size: 18px; color: #fa6b23;"> <div style="margin: 0; outline: none; padding: 0; color: #fa6b23;"> <span class="" style="color: #fa6b23; font-size: inherit; font-weight: bold; line-height: inherit; text-decoration: inherit; font-family: arial, helvetica, sans;"> </span><p style="margin: 0; outline: none; padding: 0; color: #fa6b23; font-size: inherit; font-weight: inherit; line-height: inherit; text-decoration: inherit; text-align: left;"><span class="" style="color: #fa6b23; font-size: inherit; font-weight: bold; line-height: inherit; text-decoration: inherit; font-family: arial, helvetica, sans;">¡Hola <?php echo $nombre; ?>!<br></span></p> </div> </div> </div><!--[if (gte mso 12)&(lte mso 15) ]>
<style data-ac-keep="true" data-ac-inline="false"> #text_div984, #text_div984 div { line-height: 1.9% !important; };
</style>
<![endif]--></td></tr></table></td></tr></table></td></tr><tr><td id="layout-row-margin1076" valign="top" style="background-color: #ffffff; padding: 0px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: initial !important;"><tr id="layout-row1076" class="layout layout-row widget _widget_text style1076" style="margin: 0; padding: 0; background-color: #ffffff;"><td id="layout-row-padding1076" valign="top" style="background-color: #ffffff; padding: 9px 25px 0px 25px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tr><td id="text_div987" class="td_text td_block" valign="top" align="left" style="line-height: 149%; color: inherit; font-size: inherit; font-weight: inherit; line-height: 1.49; text-decoration: inherit; font-family: Arial; mso-line-height-rule: exactly;"> <div style="line-height: 149%; margin: 0; outline: none; padding: 0; mso-line-height-rule: exactly; line-height: 1.49;" data-line-height="1.49">

<table border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
															<tr>
																<td align="left" class="td_text td_block" id="text_div450" style="color: inherit; font-size: inherit; font-weight: inherit; line-height: 1; text-decoration: inherit; font-family: Arial;" valign="top">
																	<div style="margin: 0; outline: none; padding: 0;">
																		<span style="color: inherit; font-size: 10px; font-weight: inherit; line-height: inherit; text-decoration: inherit;"></span><br />
																		<span class="" style="color: inherit; font-size: 16px; font-weight: inherit; line-height: inherit; text-decoration: inherit;"><br style="color:#858585;" />
																		<span class="" style="color: #999999; font-size: inherit; font-weight: inherit; line-height: inherit; text-decoration: inherit;"><br style="color:#999999;" />
																		<span lang="ES-TRAD" style="color: black; font-size: 16px; font-weight: inherit; line-height: inherit; text-decoration: inherit; font-family: arial, helvetica, sans;">¡¿Se te cruzó algo en la vida?! Tus productos te esperan…<br><br></span>
																		<span lang="ES-TRAD" style="color: black; font-size: 16px; font-weight: inherit; line-height: inherit; text-decoration: inherit; font-family: arial, helvetica, sans;">Regálale 5 minutos más a tu pedido y disfruta de tus nuevos productos.<br><br></span>
																		<?php
																		
																		$filas = ceil(sizeof($productos)/3);
			
																		$html = '<table style="width:100%;">';
																		
																		for($i = 0; $i < $filas; $i++) { 
																			$html .= '<tr colspan="3">';
																			for($j = 0; $j < 3; $j++) {
																				if(isset($productos[($i*3)+$j])) {
																					$html .= '<td width="33%"><img src="'.$productos[($i*3)+$j].'" style="width:100%;height:auto;max-width:200px" /></td>';
																				}
																			}
																			$html .= '</tr>';
																		}
																		
																		$html .= '</table>';
																		
																		echo $html;
																		
																		?>

																		<br />
                                                                        <span lang="ES-TRAD" style="color: black; font-size: 16px; font-weight: inherit; line-height: inherit; text-decoration: inherit; font-family: arial, helvetica, sans;">No esperes más, haz tu pedido ¡YA!<br><br></span>
                                                                        <span lang="ES-TRAD" style="color: black; font-size: 16px; font-weight: inherit; line-height: inherit; text-decoration: inherit; font-family: arial, helvetica, sans;">Y comienza a destacar entre tus amigos con un diseño tan único como tú.<br><br></span>
																	</div>
																</td>
															</tr>
														</table><!--[if (gte mso 12)&(lte mso 15) ]>
<style data-ac-keep="true" data-ac-inline="false"> #text_div987, #text_div987 div { line-height: 1.49% !important; };
</style>
<![endif]--></td></tr></table></td></tr></table></td></tr><tr id="layout-row1101" class="layout layout-row clear-this "><td id="layout-row-padding1101" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tbody><tr><td class="td_button td_block customizable" valign="top" align="left" width="310"> <div class="button-wrapper" style="margin: 0; outline: none; padding: 0; text-align: center;">
<!--[if mso]> <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://www.dhlmovil.mx" style="v-text-anchor:middle; width:210px; height:64px; font-weight: bold;" arcsize="10%" strokecolor="#d40511" strokeweight="1pt" fillcolor="#ffcc00" o:button="true" o:allowincell="true" o:allowoverlap="false" > <v:textbox inset="2px,2px,2px,2px"> <center style="color:#d40511;font-family:Arial; font-size:16px; font-weight: bold;;line-height: 1.1;">Rastrear desde móvil</center> </v:textbox> </v:roundrect>
<![endif]--> <a href="<?php echo site_url('Servicios'); ?>" style="margin: 20px 0 0;outline: none;padding: 13px 30px;color: #ffffff;background-color: #fb4a02;border: 1px solid #d40511;border-radius: 2px;font-family: Arial;font-size: 16px;display: inline-block;line-height: 1.1;text-align: center;text-decoration: none;mso-hide: all;"> <span style="color: #ffffff;font-family:Arial;font-size:16px;font-weight: bold;"> Ir a carrito</span> </a> </div>
</td></tr></tbody></table></td></tr><tr><td id="layout-row-margin1077" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tr id="layout-row1077" class="layout layout-row widget _widget_picture " align="left"><td id="layout-row-padding1077" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tr><td class="image-td" align="left" valign="top" width="650"><img src="http://avanda.img-us10.com/public/20b11cceb56475d7db7a5a3c33f31f43.jpg?r=1918522552" alt="" width="650" style="display: block; border: none; outline: none; width: 650px; opacity: 1; max-width: 100%;"></td></tr></table></td></tr></table></td></tr><tr><td id="layout-row-margin1079" valign="top" style="padding: 0;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: initial !important;"><tr id="layout-row1079" class="layout layout-row widget _widget_break style1079" style=""><td id="layout-row-border1079" valign="top" style="line-height: 0; mso-line-height-rule: exactly; border-color: #ffffff; border-style: solid; border-width: 1px;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; line-height: 0; mso-line-height-rule: exactly;"><tr><td id="layout-row-padding1079" valign="top" style="line-height: 0; mso-line-height-rule: exactly; padding: 0;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; line-height: 0; mso-line-height-rule: exactly;"><tr><td height="5" style="line-height: 0; mso-line-height-rule: exactly;"></td></tr><tr><td align="center" height="1" width="650" style="line-height: 0; mso-line-height-rule: exactly;"> <table align="center" border="0" cellpadding="0" cellspacing="0" height="1" width="650" style="font-size: 13px; min-width: auto!important; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: collapse; line-height: 0; mso-line-height-rule: exactly; width: 100%; max-width: 100%;"><tr><td class="break-line" bgcolor="#a6a3a3" height="1" width="650" style="line-height: 1px; mso-line-height-rule: exactly; height: 1px; width: 650px; background-color: #a6a3a3;"> </td> </tr></table></td> </tr><tr><td height="5" style="line-height: 0; mso-line-height-rule: exactly;"></td></tr></table></td></tr></table></td></tr></table></td></tr><tr><td id="layout-row-margin1078" valign="top" style="background-color: #84d422; padding: 0;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-collapse: initial !important;"><tr id="layout-row1078" class="layout layout-row widget _widget_text style1078" style="margin: 0; padding: 0; background-color: #84d422;"><td id="layout-row-padding1078" valign="top" style="background-color: #84d422; padding: 0;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 13px; min-width: 100%; mso-table-lspace: 0pt; mso-table-rspace: 0pt;"><tr><td id="text_div989" class="td_text td_block" valign="top" align="left" style="color: inherit; font-size: inherit; font-weight: inherit; line-height: 1; text-decoration: inherit; font-family: Arial;"> <div style="margin: 0; outline: none; padding: 0;"><br></div></td></tr></table></td></tr></table></td></tr></table></td></tr></table></td></tr></table></div></body></html>
