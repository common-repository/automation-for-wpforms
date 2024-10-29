rndefine("#RNAUTOInputs",["lit/decorators","lit","lit-html/directives/live.js","#RNAUTOCore/LitElementBase","#RNAUTOCore/Sanitizer","flatpickr"],(function(e,t,n,i,r,o){"use strict";function a(e){return e&&"object"==typeof e&&"default"in e?e:{default:e}}var s=a(o);function l(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(e);t&&(i=i.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,i)}return n}class u extends i.LitElementBase{constructor(...e){super(...e),this.store=null,this.label="",this.propertyName="",this.value=null}static get properties(){return{}}render(){return t.html` <div> ${this.GetLabel()} <div> ${this.SubRender()} </div> </div> `}GetParentStyles(){return function(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?l(Object(n),!0).forEach((function(t){babelHelpers.defineProperty(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):l(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}({},super.GetParentStyles(),{verticalAlign:"top",marginBottom:""==this.style.marginBottom?"10px":this.style.marginBottom})}GetLabel(){return""==this.label?null:t.html` <label style="font-weight: bold;display: block;">${this.label}</label> `}SetValue(e){this.FireEvent("change",e).defaultPrevented||null==this.store||(void 0!==this.store[this.propertyName]&&this.store.SetValue(this.propertyName,e),this.forceUpdate())}GetValue(){return null==this.store?this.value:this.store.GetValue(this.propertyName)}GetStringValue(){return r.Sanitizer.SanitizeString(this.GetValue())}SetStringValue(e){this.SetValue(r.Sanitizer.SanitizeString(e))}GetBooleanValue(){return r.Sanitizer.SanitizeBoolean(this.GetValue())}SetBooleanValue(e){this.SetValue(r.Sanitizer.SanitizeBoolean(e))}}e.customElement("rn-inputs-text")(class extends u{constructor(...e){super(...e),this.placeHolder=""}static get properties(){return{disabled:{type:Boolean,attribute:!0}}}SubRender(){return t.html` <input ?disabled="${this.disabled}" .placeholder="${this.placeHolder}" type="text" style="width: 100%" .value="${n.live(this.GetValue())}" @change="${e=>{e.preventDefault(),e.stopImmediatePropagation()}}" @input="${e=>{this.SetValue(e.target.value)}}"/> `}});var c="top",p="bottom",f="right",d="left",h="auto",m=[c,p,f,d],v="start",g="end",b="viewport",y="popper",w=m.reduce((function(e,t){return e.concat([t+"-"+v,t+"-"+g])}),[]),x=[].concat(m,[h]).reduce((function(e,t){return e.concat([t,t+"-"+v,t+"-"+g])}),[]),O=["beforeRead","read","afterRead","beforeMain","main","afterMain","beforeWrite","write","afterWrite"];function S(e){return e?(e.nodeName||"").toLowerCase():null}function P(e){if(null==e)return window;if("[object Window]"!==e.toString()){var t=e.ownerDocument;return t&&t.defaultView||window}return e}function V(e){return e instanceof P(e).Element||e instanceof Element}function D(e){return e instanceof P(e).HTMLElement||e instanceof HTMLElement}function j(e){return"undefined"!=typeof ShadowRoot&&(e instanceof P(e).ShadowRoot||e instanceof ShadowRoot)}var T={name:"applyStyles",enabled:!0,phase:"write",fn:function(e){var t=e.state;Object.keys(t.elements).forEach((function(e){var n=t.styles[e]||{},i=t.attributes[e]||{},r=t.elements[e];D(r)&&S(r)&&(Object.assign(r.style,n),Object.keys(i).forEach((function(e){var t=i[e];!1===t?r.removeAttribute(e):r.setAttribute(e,!0===t?"":t)})))}))},effect:function(e){var t=e.state,n={popper:{position:t.options.strategy,left:"0",top:"0",margin:"0"},arrow:{position:"absolute"},reference:{}};return Object.assign(t.elements.popper.style,n.popper),t.styles=n,t.elements.arrow&&Object.assign(t.elements.arrow.style,n.arrow),function(){Object.keys(t.elements).forEach((function(e){var i=t.elements[e],r=t.attributes[e]||{},o=Object.keys(t.styles.hasOwnProperty(e)?t.styles[e]:n[e]).reduce((function(e,t){return e[t]="",e}),{});D(i)&&S(i)&&(Object.assign(i.style,o),Object.keys(r).forEach((function(e){i.removeAttribute(e)})))}))}},requires:["computeStyles"]};function k(e){return e.split("-")[0]}var E=Math.max,A=Math.min,B=Math.round;function L(){var e=navigator.userAgentData;return null!=e&&e.brands?e.brands.map((function(e){return e.brand+"/"+e.version})).join(" "):navigator.userAgent}function H(){return!/^((?!chrome|android).)*safari/i.test(L())}function G(e,t,n){void 0===t&&(t=!1),void 0===n&&(n=!1);var i=e.getBoundingClientRect(),r=1,o=1;t&&D(e)&&(r=e.offsetWidth>0&&B(i.width)/e.offsetWidth||1,o=e.offsetHeight>0&&B(i.height)/e.offsetHeight||1);var a=(V(e)?P(e):window).visualViewport,s=!H()&&n,l=(i.left+(s&&a?a.offsetLeft:0))/r,u=(i.top+(s&&a?a.offsetTop:0))/o,c=i.width/r,p=i.height/o;return{width:c,height:p,top:u,right:l+c,bottom:u+p,left:l,x:l,y:u}}function I(e){var t=G(e),n=e.offsetWidth,i=e.offsetHeight;return Math.abs(t.width-n)<=1&&(n=t.width),Math.abs(t.height-i)<=1&&(i=t.height),{x:e.offsetLeft,y:e.offsetTop,width:n,height:i}}function R(e,t){var n=t.getRootNode&&t.getRootNode();if(e.contains(t))return!0;if(n&&j(n)){var i=t;do{if(i&&e.isSameNode(i))return!0;i=i.parentNode||i.host}while(i)}return!1}function z(e){return P(e).getComputedStyle(e)}function C(e){return["table","td","th"].indexOf(S(e))>=0}function $(e){return((V(e)?e.ownerDocument:e.document)||window.document).documentElement}function F(e){return"html"===S(e)?e:e.assignedSlot||e.parentNode||(j(e)?e.host:null)||$(e)}function M(e){return D(e)&&"fixed"!==z(e).position?e.offsetParent:null}function W(e){for(var t=P(e),n=M(e);n&&C(n)&&"static"===z(n).position;)n=M(n);return n&&("html"===S(n)||"body"===S(n)&&"static"===z(n).position)?t:n||function(e){var t=/firefox/i.test(L());if(/Trident/i.test(L())&&D(e)&&"fixed"===z(e).position)return null;var n=F(e);for(j(n)&&(n=n.host);D(n)&&["html","body"].indexOf(S(n))<0;){var i=z(n);if("none"!==i.transform||"none"!==i.perspective||"paint"===i.contain||-1!==["transform","perspective"].indexOf(i.willChange)||t&&"filter"===i.willChange||t&&i.filter&&"none"!==i.filter)return n;n=n.parentNode}return null}(e)||t}function N(e){return["top","bottom"].indexOf(e)>=0?"x":"y"}function U(e,t,n){return E(e,A(t,n))}function q(e){return Object.assign({},{top:0,right:0,bottom:0,left:0},e)}function _(e,t){return t.reduce((function(t,n){return t[n]=e,t}),{})}var Y={name:"arrow",enabled:!0,phase:"main",fn:function(e){var t,n=e.state,i=e.name,r=e.options,o=n.elements.arrow,a=n.modifiersData.popperOffsets,s=k(n.placement),l=N(s),u=[d,f].indexOf(s)>=0?"height":"width";if(o&&a){var h=function(e,t){return q("number"!=typeof(e="function"==typeof e?e(Object.assign({},t.rects,{placement:t.placement})):e)?e:_(e,m))}(r.padding,n),v=I(o),g="y"===l?c:d,b="y"===l?p:f,y=n.rects.reference[u]+n.rects.reference[l]-a[l]-n.rects.popper[u],w=a[l]-n.rects.reference[l],x=W(o),O=x?"y"===l?x.clientHeight||0:x.clientWidth||0:0,S=y/2-w/2,P=h[g],V=O-v[u]-h[b],D=O/2-v[u]/2+S,j=U(P,D,V),T=l;n.modifiersData[i]=((t={})[T]=j,t.centerOffset=j-D,t)}},effect:function(e){var t=e.state,n=e.options.element,i=void 0===n?"[data-popper-arrow]":n;null!=i&&("string"!=typeof i||(i=t.elements.popper.querySelector(i)))&&R(t.elements.popper,i)&&(t.elements.arrow=i)},requires:["popperOffsets"],requiresIfExists:["preventOverflow"]};function X(e){return e.split("-")[1]}var J={top:"auto",right:"auto",bottom:"auto",left:"auto"};function K(e){var t,n=e.popper,i=e.popperRect,r=e.placement,o=e.variation,a=e.offsets,s=e.position,l=e.gpuAcceleration,u=e.adaptive,h=e.roundOffsets,m=e.isFixed,v=a.x,b=void 0===v?0:v,y=a.y,w=void 0===y?0:y,x="function"==typeof h?h({x:b,y:w}):{x:b,y:w};b=x.x,w=x.y;var O=a.hasOwnProperty("x"),S=a.hasOwnProperty("y"),V=d,D=c,j=window;if(u){var T=W(n),k="clientHeight",E="clientWidth";if(T===P(n)&&"static"!==z(T=$(n)).position&&"absolute"===s&&(k="scrollHeight",E="scrollWidth"),T=T,r===c||(r===d||r===f)&&o===g)D=p,w-=(m&&T===j&&j.visualViewport?j.visualViewport.height:T[k])-i.height,w*=l?1:-1;if(r===d||(r===c||r===p)&&o===g)V=f,b-=(m&&T===j&&j.visualViewport?j.visualViewport.width:T[E])-i.width,b*=l?1:-1}var A,L=Object.assign({position:s},u&&J),H=!0===h?function(e){var t=e.x,n=e.y,i=window.devicePixelRatio||1;return{x:B(t*i)/i||0,y:B(n*i)/i||0}}({x:b,y:w}):{x:b,y:w};return b=H.x,w=H.y,l?Object.assign({},L,((A={})[D]=S?"0":"",A[V]=O?"0":"",A.transform=(j.devicePixelRatio||1)<=1?"translate("+b+"px, "+w+"px)":"translate3d("+b+"px, "+w+"px, 0)",A)):Object.assign({},L,((t={})[D]=S?w+"px":"",t[V]=O?b+"px":"",t.transform="",t))}var Q={name:"computeStyles",enabled:!0,phase:"beforeWrite",fn:function(e){var t=e.state,n=e.options,i=n.gpuAcceleration,r=void 0===i||i,o=n.adaptive,a=void 0===o||o,s=n.roundOffsets,l=void 0===s||s,u={placement:k(t.placement),variation:X(t.placement),popper:t.elements.popper,popperRect:t.rects.popper,gpuAcceleration:r,isFixed:"fixed"===t.options.strategy};null!=t.modifiersData.popperOffsets&&(t.styles.popper=Object.assign({},t.styles.popper,K(Object.assign({},u,{offsets:t.modifiersData.popperOffsets,position:t.options.strategy,adaptive:a,roundOffsets:l})))),null!=t.modifiersData.arrow&&(t.styles.arrow=Object.assign({},t.styles.arrow,K(Object.assign({},u,{offsets:t.modifiersData.arrow,position:"absolute",adaptive:!1,roundOffsets:l})))),t.attributes.popper=Object.assign({},t.attributes.popper,{"data-popper-placement":t.placement})},data:{}},Z={passive:!0};var ee={name:"eventListeners",enabled:!0,phase:"write",fn:function(){},effect:function(e){var t=e.state,n=e.instance,i=e.options,r=i.scroll,o=void 0===r||r,a=i.resize,s=void 0===a||a,l=P(t.elements.popper),u=[].concat(t.scrollParents.reference,t.scrollParents.popper);return o&&u.forEach((function(e){e.addEventListener("scroll",n.update,Z)})),s&&l.addEventListener("resize",n.update,Z),function(){o&&u.forEach((function(e){e.removeEventListener("scroll",n.update,Z)})),s&&l.removeEventListener("resize",n.update,Z)}},data:{}},te={left:"right",right:"left",bottom:"top",top:"bottom"};function ne(e){return e.replace(/left|right|bottom|top/g,(function(e){return te[e]}))}var ie={start:"end",end:"start"};function re(e){return e.replace(/start|end/g,(function(e){return ie[e]}))}function oe(e){var t=P(e);return{scrollLeft:t.pageXOffset,scrollTop:t.pageYOffset}}function ae(e){return G($(e)).left+oe(e).scrollLeft}function se(e){var t=z(e),n=t.overflow,i=t.overflowX,r=t.overflowY;return/auto|scroll|overlay|hidden/.test(n+r+i)}function le(e){return["html","body","#document"].indexOf(S(e))>=0?e.ownerDocument.body:D(e)&&se(e)?e:le(F(e))}function ue(e,t){var n;void 0===t&&(t=[]);var i=le(e),r=i===(null==(n=e.ownerDocument)?void 0:n.body),o=P(i),a=r?[o].concat(o.visualViewport||[],se(i)?i:[]):i,s=t.concat(a);return r?s:s.concat(ue(F(a)))}function ce(e){return Object.assign({},e,{left:e.x,top:e.y,right:e.x+e.width,bottom:e.y+e.height})}function pe(e,t,n){return t===b?ce(function(e,t){var n=P(e),i=$(e),r=n.visualViewport,o=i.clientWidth,a=i.clientHeight,s=0,l=0;if(r){o=r.width,a=r.height;var u=H();(u||!u&&"fixed"===t)&&(s=r.offsetLeft,l=r.offsetTop)}return{width:o,height:a,x:s+ae(e),y:l}}(e,n)):V(t)?function(e,t){var n=G(e,!1,"fixed"===t);return n.top=n.top+e.clientTop,n.left=n.left+e.clientLeft,n.bottom=n.top+e.clientHeight,n.right=n.left+e.clientWidth,n.width=e.clientWidth,n.height=e.clientHeight,n.x=n.left,n.y=n.top,n}(t,n):ce(function(e){var t,n=$(e),i=oe(e),r=null==(t=e.ownerDocument)?void 0:t.body,o=E(n.scrollWidth,n.clientWidth,r?r.scrollWidth:0,r?r.clientWidth:0),a=E(n.scrollHeight,n.clientHeight,r?r.scrollHeight:0,r?r.clientHeight:0),s=-i.scrollLeft+ae(e),l=-i.scrollTop;return"rtl"===z(r||n).direction&&(s+=E(n.clientWidth,r?r.clientWidth:0)-o),{width:o,height:a,x:s,y:l}}($(e)))}function fe(e,t,n,i){var r="clippingParents"===t?function(e){var t=ue(F(e)),n=["absolute","fixed"].indexOf(z(e).position)>=0&&D(e)?W(e):e;return V(n)?t.filter((function(e){return V(e)&&R(e,n)&&"body"!==S(e)})):[]}(e):[].concat(t),o=[].concat(r,[n]),a=o[0],s=o.reduce((function(t,n){var r=pe(e,n,i);return t.top=E(r.top,t.top),t.right=A(r.right,t.right),t.bottom=A(r.bottom,t.bottom),t.left=E(r.left,t.left),t}),pe(e,a,i));return s.width=s.right-s.left,s.height=s.bottom-s.top,s.x=s.left,s.y=s.top,s}function de(e){var t,n=e.reference,i=e.element,r=e.placement,o=r?k(r):null,a=r?X(r):null,s=n.x+n.width/2-i.width/2,l=n.y+n.height/2-i.height/2;switch(o){case c:t={x:s,y:n.y-i.height};break;case p:t={x:s,y:n.y+n.height};break;case f:t={x:n.x+n.width,y:l};break;case d:t={x:n.x-i.width,y:l};break;default:t={x:n.x,y:n.y}}var u=o?N(o):null;if(null!=u){var h="y"===u?"height":"width";switch(a){case v:t[u]=t[u]-(n[h]/2-i[h]/2);break;case g:t[u]=t[u]+(n[h]/2-i[h]/2)}}return t}function he(e,t){void 0===t&&(t={});var n=t,i=n.placement,r=void 0===i?e.placement:i,o=n.strategy,a=void 0===o?e.strategy:o,s=n.boundary,l=void 0===s?"clippingParents":s,u=n.rootBoundary,d=void 0===u?b:u,h=n.elementContext,v=void 0===h?y:h,g=n.altBoundary,w=void 0!==g&&g,x=n.padding,O=void 0===x?0:x,S=q("number"!=typeof O?O:_(O,m)),P=v===y?"reference":y,D=e.rects.popper,j=e.elements[w?P:v],T=fe(V(j)?j:j.contextElement||$(e.elements.popper),l,d,a),k=G(e.elements.reference),E=de({reference:k,element:D,strategy:"absolute",placement:r}),A=ce(Object.assign({},D,E)),B=v===y?A:k,L={top:T.top-B.top+S.top,bottom:B.bottom-T.bottom+S.bottom,left:T.left-B.left+S.left,right:B.right-T.right+S.right},H=e.modifiersData.offset;if(v===y&&H){var I=H[r];Object.keys(L).forEach((function(e){var t=[f,p].indexOf(e)>=0?1:-1,n=[c,p].indexOf(e)>=0?"y":"x";L[e]+=I[n]*t}))}return L}function me(e,t){void 0===t&&(t={});var n=t,i=n.placement,r=n.boundary,o=n.rootBoundary,a=n.padding,s=n.flipVariations,l=n.allowedAutoPlacements,u=void 0===l?x:l,c=X(i),p=c?s?w:w.filter((function(e){return X(e)===c})):m,f=p.filter((function(e){return u.indexOf(e)>=0}));0===f.length&&(f=p);var d=f.reduce((function(t,n){return t[n]=he(e,{placement:n,boundary:r,rootBoundary:o,padding:a})[k(n)],t}),{});return Object.keys(d).sort((function(e,t){return d[e]-d[t]}))}var ve={name:"flip",enabled:!0,phase:"main",fn:function(e){var t=e.state,n=e.options,i=e.name;if(!t.modifiersData[i]._skip){for(var r=n.mainAxis,o=void 0===r||r,a=n.altAxis,s=void 0===a||a,l=n.fallbackPlacements,u=n.padding,m=n.boundary,g=n.rootBoundary,b=n.altBoundary,y=n.flipVariations,w=void 0===y||y,x=n.allowedAutoPlacements,O=t.options.placement,S=k(O),P=l||(S===O||!w?[ne(O)]:function(e){if(k(e)===h)return[];var t=ne(e);return[re(e),t,re(t)]}(O)),V=[O].concat(P).reduce((function(e,n){return e.concat(k(n)===h?me(t,{placement:n,boundary:m,rootBoundary:g,padding:u,flipVariations:w,allowedAutoPlacements:x}):n)}),[]),D=t.rects.reference,j=t.rects.popper,T=new Map,E=!0,A=V[0],B=0;B<V.length;B++){var L=V[B],H=k(L),G=X(L)===v,I=[c,p].indexOf(H)>=0,R=I?"width":"height",z=he(t,{placement:L,boundary:m,rootBoundary:g,altBoundary:b,padding:u}),C=I?G?f:d:G?p:c;D[R]>j[R]&&(C=ne(C));var $=ne(C),F=[];if(o&&F.push(z[H]<=0),s&&F.push(z[C]<=0,z[$]<=0),F.every((function(e){return e}))){A=L,E=!1;break}T.set(L,F)}if(E)for(var M=function(e){var t=V.find((function(t){var n=T.get(t);if(n)return n.slice(0,e).every((function(e){return e}))}));if(t)return A=t,"break"},W=w?3:1;W>0;W--){if("break"===M(W))break}t.placement!==A&&(t.modifiersData[i]._skip=!0,t.placement=A,t.reset=!0)}},requiresIfExists:["offset"],data:{_skip:!1}};function ge(e,t,n){return void 0===n&&(n={x:0,y:0}),{top:e.top-t.height-n.y,right:e.right-t.width+n.x,bottom:e.bottom-t.height+n.y,left:e.left-t.width-n.x}}function be(e){return[c,f,p,d].some((function(t){return e[t]>=0}))}var ye={name:"hide",enabled:!0,phase:"main",requiresIfExists:["preventOverflow"],fn:function(e){var t=e.state,n=e.name,i=t.rects.reference,r=t.rects.popper,o=t.modifiersData.preventOverflow,a=he(t,{elementContext:"reference"}),s=he(t,{altBoundary:!0}),l=ge(a,i),u=ge(s,r,o),c=be(l),p=be(u);t.modifiersData[n]={referenceClippingOffsets:l,popperEscapeOffsets:u,isReferenceHidden:c,hasPopperEscaped:p},t.attributes.popper=Object.assign({},t.attributes.popper,{"data-popper-reference-hidden":c,"data-popper-escaped":p})}};var we={name:"offset",enabled:!0,phase:"main",requires:["popperOffsets"],fn:function(e){var t=e.state,n=e.options,i=e.name,r=n.offset,o=void 0===r?[0,0]:r,a=x.reduce((function(e,n){return e[n]=function(e,t,n){var i=k(e),r=[d,c].indexOf(i)>=0?-1:1,o="function"==typeof n?n(Object.assign({},t,{placement:e})):n,a=o[0],s=o[1];return a=a||0,s=(s||0)*r,[d,f].indexOf(i)>=0?{x:s,y:a}:{x:a,y:s}}(n,t.rects,o),e}),{}),s=a[t.placement],l=s.x,u=s.y;null!=t.modifiersData.popperOffsets&&(t.modifiersData.popperOffsets.x+=l,t.modifiersData.popperOffsets.y+=u),t.modifiersData[i]=a}};var xe={name:"popperOffsets",enabled:!0,phase:"read",fn:function(e){var t=e.state,n=e.name;t.modifiersData[n]=de({reference:t.rects.reference,element:t.rects.popper,strategy:"absolute",placement:t.placement})},data:{}};var Oe={name:"preventOverflow",enabled:!0,phase:"main",fn:function(e){var t=e.state,n=e.options,i=e.name,r=n.mainAxis,o=void 0===r||r,a=n.altAxis,s=void 0!==a&&a,l=n.boundary,u=n.rootBoundary,h=n.altBoundary,m=n.padding,g=n.tether,b=void 0===g||g,y=n.tetherOffset,w=void 0===y?0:y,x=he(t,{boundary:l,rootBoundary:u,padding:m,altBoundary:h}),O=k(t.placement),S=X(t.placement),P=!S,V=N(O),D="x"===V?"y":"x",j=t.modifiersData.popperOffsets,T=t.rects.reference,B=t.rects.popper,L="function"==typeof w?w(Object.assign({},t.rects,{placement:t.placement})):w,H="number"==typeof L?{mainAxis:L,altAxis:L}:Object.assign({mainAxis:0,altAxis:0},L),G=t.modifiersData.offset?t.modifiersData.offset[t.placement]:null,R={x:0,y:0};if(j){if(o){var z,C="y"===V?c:d,$="y"===V?p:f,F="y"===V?"height":"width",M=j[V],q=M+x[C],_=M-x[$],Y=b?-B[F]/2:0,J=S===v?T[F]:B[F],K=S===v?-B[F]:-T[F],Q=t.elements.arrow,Z=b&&Q?I(Q):{width:0,height:0},ee=t.modifiersData["arrow#persistent"]?t.modifiersData["arrow#persistent"].padding:{top:0,right:0,bottom:0,left:0},te=ee[C],ne=ee[$],ie=U(0,T[F],Z[F]),re=P?T[F]/2-Y-ie-te-H.mainAxis:J-ie-te-H.mainAxis,oe=P?-T[F]/2+Y+ie+ne+H.mainAxis:K+ie+ne+H.mainAxis,ae=t.elements.arrow&&W(t.elements.arrow),se=ae?"y"===V?ae.clientTop||0:ae.clientLeft||0:0,le=null!=(z=null==G?void 0:G[V])?z:0,ue=M+oe-le,ce=U(b?A(q,M+re-le-se):q,M,b?E(_,ue):_);j[V]=ce,R[V]=ce-M}if(s){var pe,fe="x"===V?c:d,de="x"===V?p:f,me=j[D],ve="y"===D?"height":"width",ge=me+x[fe],be=me-x[de],ye=-1!==[c,d].indexOf(O),we=null!=(pe=null==G?void 0:G[D])?pe:0,xe=ye?ge:me-T[ve]-B[ve]-we+H.altAxis,Oe=ye?me+T[ve]+B[ve]-we-H.altAxis:be,Se=b&&ye?function(e,t,n){var i=U(e,t,n);return i>n?n:i}(xe,me,Oe):U(b?xe:ge,me,b?Oe:be);j[D]=Se,R[D]=Se-me}t.modifiersData[i]=R}},requiresIfExists:["offset"]};function Se(e,t,n){void 0===n&&(n=!1);var i,r,o=D(t),a=D(t)&&function(e){var t=e.getBoundingClientRect(),n=B(t.width)/e.offsetWidth||1,i=B(t.height)/e.offsetHeight||1;return 1!==n||1!==i}(t),s=$(t),l=G(e,a,n),u={scrollLeft:0,scrollTop:0},c={x:0,y:0};return(o||!o&&!n)&&(("body"!==S(t)||se(s))&&(u=(i=t)!==P(i)&&D(i)?{scrollLeft:(r=i).scrollLeft,scrollTop:r.scrollTop}:oe(i)),D(t)?((c=G(t,!0)).x+=t.clientLeft,c.y+=t.clientTop):s&&(c.x=ae(s))),{x:l.left+u.scrollLeft-c.x,y:l.top+u.scrollTop-c.y,width:l.width,height:l.height}}function Pe(e){var t=new Map,n=new Set,i=[];function r(e){n.add(e.name),[].concat(e.requires||[],e.requiresIfExists||[]).forEach((function(e){if(!n.has(e)){var i=t.get(e);i&&r(i)}})),i.push(e)}return e.forEach((function(e){t.set(e.name,e)})),e.forEach((function(e){n.has(e.name)||r(e)})),i}var Ve={placement:"bottom",modifiers:[],strategy:"absolute"};function De(){for(var e=arguments.length,t=new Array(e),n=0;n<e;n++)t[n]=arguments[n];return!t.some((function(e){return!(e&&"function"==typeof e.getBoundingClientRect)}))}function je(e){void 0===e&&(e={});var t=e,n=t.defaultModifiers,i=void 0===n?[]:n,r=t.defaultOptions,o=void 0===r?Ve:r;return function(e,t,n){void 0===n&&(n=o);var r,a,s={placement:"bottom",orderedModifiers:[],options:Object.assign({},Ve,o),modifiersData:{},elements:{reference:e,popper:t},attributes:{},styles:{}},l=[],u=!1,c={state:s,setOptions:function(n){var r="function"==typeof n?n(s.options):n;p(),s.options=Object.assign({},o,s.options,r),s.scrollParents={reference:V(e)?ue(e):e.contextElement?ue(e.contextElement):[],popper:ue(t)};var a,u,f=function(e){var t=Pe(e);return O.reduce((function(e,n){return e.concat(t.filter((function(e){return e.phase===n})))}),[])}((a=[].concat(i,s.options.modifiers),u=a.reduce((function(e,t){var n=e[t.name];return e[t.name]=n?Object.assign({},n,t,{options:Object.assign({},n.options,t.options),data:Object.assign({},n.data,t.data)}):t,e}),{}),Object.keys(u).map((function(e){return u[e]}))));return s.orderedModifiers=f.filter((function(e){return e.enabled})),s.orderedModifiers.forEach((function(e){var t=e.name,n=e.options,i=void 0===n?{}:n,r=e.effect;if("function"==typeof r){var o=r({state:s,name:t,instance:c,options:i}),a=function(){};l.push(o||a)}})),c.update()},forceUpdate:function(){if(!u){var e=s.elements,t=e.reference,n=e.popper;if(De(t,n)){s.rects={reference:Se(t,W(n),"fixed"===s.options.strategy),popper:I(n)},s.reset=!1,s.placement=s.options.placement,s.orderedModifiers.forEach((function(e){return s.modifiersData[e.name]=Object.assign({},e.data)}));for(var i=0;i<s.orderedModifiers.length;i++)if(!0!==s.reset){var r=s.orderedModifiers[i],o=r.fn,a=r.options,l=void 0===a?{}:a,p=r.name;"function"==typeof o&&(s=o({state:s,options:l,name:p,instance:c})||s)}else s.reset=!1,i=-1}}},update:(r=function(){return new Promise((function(e){c.forceUpdate(),e(s)}))},function(){return a||(a=new Promise((function(e){Promise.resolve().then((function(){a=void 0,e(r())}))}))),a}),destroy:function(){p(),u=!0}};if(!De(e,t))return c;function p(){l.forEach((function(e){return e()})),l=[]}return c.setOptions(n).then((function(e){!u&&n.onFirstUpdate&&n.onFirstUpdate(e)})),c}}je();var Te,ke,Ee,Ae,Be,Le,He,Ge,Ie=je({defaultModifiers:[ee,xe,Q,T,we,ve,Oe,Y,ye]});Te=e.customElement("rn-inputs-select"),ke=e.query("select"),Te((Ee=class extends u{constructor(...e){super(...e),this.placeholder="",this.valueField="",this.load=void 0,babelHelpers.initializerDefineProperty(this,"Select",Ae,this),this.createOnSpace=!1,this.Loaded=!0,this.onCustomizeItem=void 0,this.options=[]}static get properties(){return{value:{type:Object}}}SubRender(){return t.html` <select .placeholder="${this.placeholder}" ?multiple="${this.multiple}" value="${this.GetValueFromOptions()}" style="display:none;width: 100%;max-width: 100%;" @change="${e=>{e.preventDefault(),e.stopPropagation(),e.stopImmediatePropagation(),this.SetValueFromOptions()}}"></select> `}GetValueFromOptions(){if(null==this.TomSelect)return;let e=[],t=this.GetValue();Array.isArray(t)||(t=[t]);for(let n of t){let t=n;""!=this.valueField&&(t=n[this.valueField]);for(let n in this.TomSelect.options)this.TomSelect.options[n].Value==t&&e.push(t)}return this.multiple?e:e[0]}SetValueFromOptions(){let e=this.TomSelect.getValue();Array.isArray(e)||(e=[e]);let t=[];for(let n of e){let e=this.TomSelect.options[n];null!=e&&(null!=e.Item?t.push(e.Item):t.push(e.Value))}if(!this.multiple)return this.SetValue(t[0]);this.SetValue(t)}get multiple(){return this.hasAttribute("multiple")}update(e){if(this.hasUpdated&&(e.has("value")||0==e.size&&this.TomSelect.getValue()!=this.GetValueFromOptions())){this.TomSelect.clearOptions(),this.Loaded=!1;for(let e of this.GetOptions())this.TomSelect.addOption(e);this.TomSelect.setValue(this.GetValueFromOptions(),!0),this.Loaded=!0}super.update(e)}GetOptions(){return"function"==typeof this.options?this.options():this.options}firstUpdated(e){super.firstUpdated(e);let t=[];this.multiple&&t.push("remove_button"),this.Loaded=!1;let n={};null!=this.onCustomizeItem&&(n.item=this.onCustomizeItem),this.TomSelect=new TomSelect(this.Select,{valueField:"Value",labelField:"Label",searchField:"Label",load:this.load,options:this.GetOptions(),plugins:t,placeholder:this.placeholder,hidePlaceholder:!0,create:null!=this.onCreate&&this.onCreate,render:n,createOnBlur:null!=this.onCreate,onItemAdd:(e,t)=>{this.Loaded&&null!=this.TomSelect.options[e]&&this.FireEvent("itemAdded",this.TomSelect.options[e])},onChange:e=>{},onDropdownOpen:e=>{let t=this.TomSelect.control.getBoundingClientRect();e.style.position="absolute",e.style.zIndex="10000000000000000000000",e.style.width=t.width+"px",Ie(this.TomSelect.control,e,{modifiers:[{name:"offset",options:{offset:[0,2]}}]})},dropdownParent:document.body}),this.TomSelect.control.style.minHeight=""==this.style.minHeight?"33.5px":this.style.minHeight,this.createOnSpace&&this.TomSelect.control_input.addEventListener("keydown",(e=>{if(" "==e.key){let t=e.target.value;this.TomSelect.createItem(t,!0),this.TomSelect.addItem(t,!0)}})),this.TomSelect.setValue(this.GetValueFromOptions(),!0),this.Loaded=!0}},Ae=babelHelpers.applyDecoratedDescriptor(Ee.prototype,"Select",[ke],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),Ee)),e.customElement("rn-inputs-checkbox")(class extends u{static get properties(){return{}}SubRender(){return t.html` <div> <input type="checkbox" ?checked="${n.live(this.GetBooleanValue())}" @change="${e=>{e.stopImmediatePropagation(),this.SetBooleanValue(e.target.checked)}}"/> <label @click=${e=>this.SetBooleanValue(!this.GetBooleanValue())} style="font-weight: bold;margin-left: 3px;">${this.label}</label> </div> `}GetLabel(){return""}}),e.customElement("rn-inputs-number")(class extends u{static get properties(){return{}}SubRender(){return t.html` <input type="number" style="width: 100%" .value="${n.live(this.GetValue())}" @change="${e=>{e.stopPropagation(),e.stopImmediatePropagation(),e.preventDefault()}}" @input="${e=>{this.SetValue(e.target.value)}}"/> `}});class Re{static UnixToDate(e,t=0){if(e>0){let n=new Date(1e3*(r.Sanitizer.SanitizeNumber(e)+t));return n=new Date(n.setMinutes(n.getMinutes()+n.getTimezoneOffset())),n}return null}static DateToUnix(e,t=0){return(e.getTime()-t)/1e3+-1*e.getTimezoneOffset()*60}}Be=e.customElement("rn-inputs-datepicker"),Le=e.query("input"),Be((He=class extends u{constructor(...e){super(...e),this.disabled=!1,this.IsReadOnly=!1,this.Placeholder="",this.flatPickr=null,this.format="d/m/Y",this.timeFormat="H:i",babelHelpers.initializerDefineProperty(this,"Input",Ge,this)}static get properties(){return{disabled:{type:Boolean},value:{type:Object}}}SubRender(){return t.html` <input class="datePickerInput" ?readOnly=${this.IsReadOnly} @change="${e=>e.stopPropagation()}" .placeholder=${this.Placeholder} style="width: 100%;${t.rnsg({height:this.style.height,minHeight:this.style.minHeight})}" type='text' value=${n.live(this.GetValue())}/> `}attributeChangedCallback(e,t,n){super.attributeChangedCallback(e,t,n),null!=this.flatPickr&&(this.flatPickr._input.disabled=this.disabled)}updated(e){super.updated(e),e.has("value")&&null!=this.flatPickr&&this.flatPickr.setDate(this.value)}firstUpdated(e){super.firstUpdated(e),null!=this.flatPickr&&(this.flatPickr.destroy(),this.flatPickr=null);let t={enableTime:this.enableTime,dateFormat:this.format+(this.enableTime?" "+this.timeFormat:""),time_24hr:!0,onChange:(e,t,n)=>{0==e.length?this.SetValue(0):this.SetValue(Re.DateToUnix(e[0]))}},n=null;this.Input.value="",0!=this.GetValue()&&(n=Re.UnixToDate(this.GetValue()),null!=n&&isNaN(n.getTime())&&(n=null),t.defaultDate=n),this.flatPickr=s.default(this.Input,t),this.disabled&&(this.flatPickr._input.disabled=!0)}},Ge=babelHelpers.applyDecoratedDescriptor(He.prototype,"Input",[Le],{configurable:!0,enumerable:!0,writable:!0,initializer:null}),He)),exports.InputBase=u}));
