/*! jQuery v2.1.4 | (c) 2005, 2015 jQuery Foundation, Inc. | jquery.org/license */
!function(a,b){"object"==typeof module&&"object"==typeof module.exports?module.exports=a.document?b(a,!0):function(a){if(!a.document)throw new Error("jQuery requires a window with a document");return b(a)}:b(a)}("undefined"!=typeof window?window:this,function(a,b){var c=[],d=c.slice,e=c.concat,f=c.push,g=c.indexOf,h={},i=h.toString,j=h.hasOwnProperty,k={},l=a.document,m="2.1.4",n=function(a,b){return new n.fn.init(a,b)},o=/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,p=/^-ms-/,q=/-([\da-z])/gi,r=function(a,b){return b.toUpperCase()};n.fn=n.prototype={jquery:m,constructor:n,selector:"",length:0,toArray:function(){return d.call(this)},get:function(a){return null!=a?0>a?this[a+this.length]:this[a]:d.call(this)},pushStack:function(a){var b=n.merge(this.constructor(),a);return b.prevObject=this,b.context=this.context,b},each:function(a,b){return n.each(this,a,b)},map:function(a){return this.pushStack(n.map(this,function(b,c){return a.call(b,c,b)}))},slice:function(){return this.pushStack(d.apply(this,arguments))},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},eq:function(a){var b=this.length,c=+a+(0>a?b:0);return this.pushStack(c>=0&&b>c?[this[c]]:[])},end:function(){return this.prevObject||this.constructor(null)},push:f,sort:c.sort,splice:c.splice},n.extend=n.fn.extend=function(){var a,b,c,d,e,f,g=arguments[0]||{},h=1,i=arguments.length,j=!1;for("boolean"==typeof g&&(j=g,g=arguments[h]||{},h++),"object"==typeof g||n.isFunction(g)||(g={}),h===i&&(g=this,h--);i>h;h++)if(null!=(a=arguments[h]))for(b in a)c=g[b],d=a[b],g!==d&&(j&&d&&(n.isPlainObject(d)||(e=n.isArray(d)))?(e?(e=!1,f=c&&n.isArray(c)?c:[]):f=c&&n.isPlainObject(c)?c:{},g[b]=n.extend(j,f,d)):void 0!==d&&(g[b]=d));return g},n.extend({expando:"jQuery"+(m+Math.random()).replace(/\D/g,""),isReady:!0,error:function(a){throw new Error(a)},noop:function(){},isFunction:function(a){return"function"===n.type(a)},isArray:Array.isArray,isWindow:function(a){return null!=a&&a===a.window},isNumeric:function(a){return!n.isArray(a)&&a-parseFloat(a)+1>=0},isPlainObject:function(a){return"object"!==n.type(a)||a.nodeType||n.isWindow(a)?!1:a.constructor&&!j.call(a.constructor.prototype,"isPrototypeOf")?!1:!0},isEmptyObject:function(a){var b;for(b in a)return!1;return!0},type:function(a){return null==a?a+"":"object"==typeof a||"function"==typeof a?h[i.call(a)]||"object":typeof a},globalEval:function(a){var b,c=eval;a=n.trim(a),a&&(1===a.indexOf("use strict")?(b=l.createElement("script"),b.text=a,l.head.appendChild(b).parentNode.removeChild(b)):c(a))},camelCase:function(a){return a.replace(p,"ms-").replace(q,r)},nodeName:function(a,b){return a.nodeName&&a.nodeName.toLowerCase()===b.toLowerCase()},each:function(a,b,c){var d,e=0,f=a.length,g=s(a);if(c){if(g){for(;f>e;e++)if(d=b.apply(a[e],c),d===!1)break}else for(e in a)if(d=b.apply(a[e],c),d===!1)break}else if(g){for(;f>e;e++)if(d=b.call(a[e],e,a[e]),d===!1)break}else for(e in a)if(d=b.call(a[e],e,a[e]),d===!1)break;return a},trim:function(a){return null==a?"":(a+"").replace(o,"")},makeArray:function(a,b){var c=b||[];return null!=a&&(s(Object(a))?n.merge(c,"string"==typeof a?[a]:a):f.call(c,a)),c},inArray:function(a,b,c){return null==b?-1:g.call(b,a,c)},merge:function(a,b){for(var c=+b.length,d=0,e=a.length;c>d;d++)a[e++]=b[d];return a.length=e,a},grep:function(a,b,c){for(var d,e=[],f=0,g=a.length,h=!c;g>f;f++)d=!b(a[f],f),d!==h&&e.push(a[f]);return e},map:function(a,b,c){var d,f=0,g=a.length,h=s(a),i=[];if(h)for(;g>f;f++)d=b(a[f],f,c),null!=d&&i.push(d);else for(f in a)d=b(a[f],f,c),null!=d&&i.push(d);return e.apply([],i)},guid:1,proxy:function(a,b){var c,e,f;return"string"==typeof b&&(c=a[b],b=a,a=c),n.isFunction(a)?(e=d.call(arguments,2),f=function(){return a.apply(b||this,e.concat(d.call(arguments)))},f.guid=a.guid=a.guid||n.guid++,f):void 0},now:Date.now,support:k}),n.each("Boolean Number String Function Array Date RegExp Object Error".split(" "),function(a,b){h["[object "+b+"]"]=b.toLowerCase()});function s(a){var b="length"in a&&a.length,c=n.type(a);return"function"===c||n.isWindow(a)?!1:1===a.nodeType&&b?!0:"array"===c||0===b||"number"==typeof b&&b>0&&b-1 in a}var t=function(a){var b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u="sizzle"+1*new Date,v=a.document,w=0,x=0,y=ha(),z=ha(),A=ha(),B=function(a,b){return a===b&&(l=!0),0},C=1<<31,D={}.hasOwnProperty,E=[],F=E.pop,G=E.push,H=E.push,I=E.slice,J=function(a,b){for(var c=0,d=a.length;d>c;c++)if(a[c]===b)return c;return-1},K="checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",L="[\\x20\\t\\r\\n\\f]",M="(?:\\\\.|[\\w-]|[^\\x00-\\xa0])+",N=M.replace("w","w#"),O="\\["+L+"*("+M+")(?:"+L+"*([*^$|!~]?=)"+L+"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|("+N+"))|)"+L+"*\\]",P=":("+M+")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|"+O+")*)|.*)\\)|)",Q=new RegExp(L+"+","g"),R=new RegExp("^"+L+"+|((?:^|[^\\\\])(?:\\\\.)*)"+L+"+$","g"),S=new RegExp("^"+L+"*,"+L+"*"),T=new RegExp("^"+L+"*([>+~]|"+L+")"+L+"*"),U=new RegExp("="+L+"*([^\\]'\"]*?)"+L+"*\\]","g"),V=new RegExp(P),W=new RegExp("^"+N+"$"),X={ID:new RegExp("^#("+M+")"),CLASS:new RegExp("^\\.("+M+")"),TAG:new RegExp("^("+M.replace("w","w*")+")"),ATTR:new RegExp("^"+O),PSEUDO:new RegExp("^"+P),CHILD:new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\("+L+"*(even|odd|(([+-]|)(\\d*)n|)"+L+"*(?:([+-]|)"+L+"*(\\d+)|))"+L+"*\\)|)","i"),bool:new RegExp("^(?:"+K+")$","i"),needsContext:new RegExp("^"+L+"*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\("+L+"*((?:-\\d)?\\d*)"+L+"*\\)|)(?=[^-]|$)","i")},Y=/^(?:input|select|textarea|button)$/i,Z=/^h\d$/i,$=/^[^{]+\{\s*\[native \w/,_=/^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,aa=/[+~]/,ba=/'|\\/g,ca=new RegExp("\\\\([\\da-f]{1,6}"+L+"?|("+L+")|.)","ig"),da=function(a,b,c){var d="0x"+b-65536;return d!==d||c?b:0>d?String.fromCharCode(d+65536):String.fromCharCode(d>>10|55296,1023&d|56320)},ea=function(){m()};try{H.apply(E=I.call(v.childNodes),v.childNodes),E[v.childNodes.length].nodeType}catch(fa){H={apply:E.length?function(a,b){G.apply(a,I.call(b))}:function(a,b){var c=a.length,d=0;while(a[c++]=b[d++]);a.length=c-1}}}function ga(a,b,d,e){var f,h,j,k,l,o,r,s,w,x;if((b?b.ownerDocument||b:v)!==n&&m(b),b=b||n,d=d||[],k=b.nodeType,"string"!=typeof a||!a||1!==k&&9!==k&&11!==k)return d;if(!e&&p){if(11!==k&&(f=_.exec(a)))if(j=f[1]){if(9===k){if(h=b.getElementById(j),!h||!h.parentNode)return d;if(h.id===j)return d.push(h),d}else if(b.ownerDocument&&(h=b.ownerDocument.getElementById(j))&&t(b,h)&&h.id===j)return d.push(h),d}else{if(f[2])return H.apply(d,b.getElementsByTagName(a)),d;if((j=f[3])&&c.getElementsByClassName)return H.apply(d,b.getElementsByClassName(j)),d}if(c.qsa&&(!q||!q.test(a))){if(s=r=u,w=b,x=1!==k&&a,1===k&&"object"!==b.nodeName.toLowerCase()){o=g(a),(r=b.getAttribute("id"))?s=r.replace(ba,"\\$&"):b.setAttribute("id",s),s="[id='"+s+"'] ",l=o.length;while(l--)o[l]=s+ra(o[l]);w=aa.test(a)&&pa(b.parentNode)||b,x=o.join(",")}if(x)try{return H.apply(d,w.querySelectorAll(x)),d}catch(y){}finally{r||b.removeAttribute("id")}}}return i(a.replace(R,"$1"),b,d,e)}function ha(){var a=[];function b(c,e){return a.push(c+" ")>d.cacheLength&&delete b[a.shift()],b[c+" "]=e}return b}function ia(a){return a[u]=!0,a}function ja(a){var b=n.createElement("div");try{return!!a(b)}catch(c){return!1}finally{b.parentNode&&b.parentNode.removeChild(b),b=null}}function ka(a,b){var c=a.split("|"),e=a.length;while(e--)d.attrHandle[c[e]]=b}function la(a,b){var c=b&&a,d=c&&1===a.nodeType&&1===b.nodeType&&(~b.sourceIndex||C)-(~a.sourceIndex||C);if(d)return d;if(c)while(c=c.nextSibling)if(c===b)return-1;return a?1:-1}function ma(a){return function(b){var c=b.nodeName.toLowerCase();return"input"===c&&b.type===a}}function na(a){return function(b){var c=b.nodeName.toLowerCase();return("input"===c||"button"===c)&&b.type===a}}function oa(a){return ia(function(b){return b=+b,ia(function(c,d){var e,f=a([],c.length,b),g=f.length;while(g--)c[e=f[g]]&&(c[e]=!(d[e]=c[e]))})})}function pa(a){return a&&"undefined"!=typeof a.getElementsByTagName&&a}c=ga.support={},f=ga.isXML=function(a){var b=a&&(a.ownerDocument||a).documentElement;return b?"HTML"!==b.nodeName:!1},m=ga.setDocument=function(a){var b,e,g=a?a.ownerDocument||a:v;return g!==n&&9===g.nodeType&&g.documentElement?(n=g,o=g.documentElement,e=g.defaultView,e&&e!==e.top&&(e.addEventListener?e.addEventListener("unload",ea,!1):e.attachEvent&&e.attachEvent("onunload",ea)),p=!f(g),c.attributes=ja(function(a){return a.className="i",!a.getAttribute("className")}),c.getElementsByTagName=ja(function(a){return a.appendChild(g.createComment("")),!a.getElementsByTagName("*").length}),c.getElementsByClassName=$.test(g.getElementsByClassName),c.getById=ja(function(a){return o.appendChild(a).id=u,!g.getElementsByName||!g.getElementsByName(u).length}),c.getById?(d.find.ID=function(a,b){if("undefined"!=typeof b.getElementById&&p){var c=b.getElementById(a);return c&&c.parentNode?[c]:[]}},d.filter.ID=function(a){var b=a.replace(ca,da);return function(a){return a.getAttribute("id")===b}}):(delete d.find.ID,d.filter.ID=function(a){var b=a.replace(ca,da);return function(a){var c="undefined"!=typeof a.getAttributeNode&&a.getAttributeNode("id");return c&&c.value===b}}),d.find.TAG=c.getElementsByTagName?function(a,b){return"undefined"!=typeof b.getElementsByTagName?b.getElementsByTagName(a):c.qsa?b.querySelectorAll(a):void 0}:function(a,b){var c,d=[],e=0,f=b.getElementsByTagName(a);if("*"===a){while(c=f[e++])1===c.nodeType&&d.push(c);return d}return f},d.find.CLASS=c.getElementsByClassName&&function(a,b){return p?b.getElementsByClassName(a):void 0},r=[],q=[],(c.qsa=$.test(g.querySelectorAll))&&(ja(function(a){o.appendChild(a).innerHTML="<a id='"+u+"'></a><select id='"+u+"-\f]' msallowcapture=''><option selected=''></option></select>",a.querySelectorAll("[msallowcapture^='']").length&&q.push("[*^$]="+L+"*(?:''|\"\")"),a.querySelectorAll("[selected]").length||q.push("\\["+L+"*(?:value|"+K+")"),a.querySelectorAll("[id~="+u+"-]").length||q.push("~="),a.querySelectorAll(":checked").length||q.push(":checked"),a.querySelectorAll("a#"+u+"+*").length||q.push(".#.+[+~]")}),ja(function(a){var b=g.createElement("input");b.setAttribute("type","hidden"),a.appendChild(b).setAttribute("name","D"),a.querySelectorAll("[name=d]").length&&q.push("name"+L+"*[*^$|!~]?="),a.querySelectorAll(":enabled").length||q.push(":enabled",":disabled"),a.querySelectorAll("*,:x"),q.push(",.*:")})),(c.matchesSelector=$.test(s=o.matches||o.webkitMatchesSelector||o.mozMatchesSelector||o.oMatchesSelector||o.msMatchesSelector))&&ja(function(a){c.disconnectedMatch=s.call(a,"div"),s.call(a,"[s!='']:x"),r.push("!=",P)}),q=q.length&&new RegExp(q.join("|")),r=r.length&&new RegExp(r.join("|")),b=$.test(o.compareDocumentPosition),t=b||$.test(o.contains)?function(a,b){var c=9===a.nodeType?a.documentElement:a,d=b&&b.parentNode;return a===d||!(!d||1!==d.nodeType||!(c.contains?c.contains(d):a.compareDocumentPosition&&16&a.compareDocumentPosition(d)))}:function(a,b){if(b)while(b=b.parentNode)if(b===a)return!0;return!1},B=b?function(a,b){if(a===b)return l=!0,0;var d=!a.compareDocumentPosition-!b.compareDocumentPosition;return d?d:(d=(a.ownerDocument||a)===(b.ownerDocument||b)?a.compareDocumentPosition(b):1,1&d||!c.sortDetached&&b.compareDocumentPosition(a)===d?a===g||a.ownerDocument===v&&t(v,a)?-1:b===g||b.ownerDocument===v&&t(v,b)?1:k?J(k,a)-J(k,b):0:4&d?-1:1)}:function(a,b){if(a===b)return l=!0,0;var c,d=0,e=a.parentNode,f=b.parentNode,h=[a],i=[b];if(!e||!f)return a===g?-1:b===g?1:e?-1:f?1:k?J(k,a)-J(k,b):0;if(e===f)return la(a,b);c=a;while(c=c.parentNode)h.unshift(c);c=b;while(c=c.parentNode)i.unshift(c);while(h[d]===i[d])d++;return d?la(h[d],i[d]):h[d]===v?-1:i[d]===v?1:0},g):n},ga.matches=function(a,b){return ga(a,null,null,b)},ga.matchesSelector=function(a,b){if((a.ownerDocument||a)!==n&&m(a),b=b.replace(U,"='$1']"),!(!c.matchesSelector||!p||r&&r.test(b)||q&&q.test(b)))try{var d=s.call(a,b);if(d||c.disconnectedMatch||a.document&&11!==a.document.nodeType)return d}catch(e){}return ga(b,n,null,[a]).length>0},ga.contains=function(a,b){return(a.ownerDocument||a)!==n&&m(a),t(a,b)},ga.attr=function(a,b){(a.ownerDocument||a)!==n&&m(a);var e=d.attrHandle[b.toLowerCase()],f=e&&D.call(d.attrHandle,b.toLowerCase())?e(a,b,!p):void 0;return void 0!==f?f:c.attributes||!p?a.getAttribute(b):(f=a.getAttributeNode(b))&&f.specified?f.value:null},ga.error=function(a){throw new Error("Syntax error, unrecognized expression: "+a)},ga.uniqueSort=function(a){var b,d=[],e=0,f=0;if(l=!c.detectDuplicates,k=!c.sortStable&&a.slice(0),a.sort(B),l){while(b=a[f++])b===a[f]&&(e=d.push(f));while(e--)a.splice(d[e],1)}return k=null,a},e=ga.getText=function(a){var b,c="",d=0,f=a.nodeType;if(f){if(1===f||9===f||11===f){if("string"==typeof a.textContent)return a.textContent;for(a=a.firstChild;a;a=a.nextSibling)c+=e(a)}else if(3===f||4===f)return a.nodeValue}else while(b=a[d++])c+=e(b);return c},d=ga.selectors={cacheLength:50,createPseudo:ia,match:X,attrHandle:{},find:{},relative:{">":{dir:"parentNode",first:!0}," ":{dir:"parentNode"},"+":{dir:"previousSibling",first:!0},"~":{dir:"previousSibling"}},preFilter:{ATTR:function(a){return a[1]=a[1].replace(ca,da),a[3]=(a[3]||a[4]||a[5]||"").replace(ca,da),"~="===a[2]&&(a[3]=" "+a[3]+" "),a.slice(0,4)},CHILD:function(a){return a[1]=a[1].toLowerCase(),"nth"===a[1].slice(0,3)?(a[3]||ga.error(a[0]),a[4]=+(a[4]?a[5]+(a[6]||1):2*("even"===a[3]||"odd"===a[3])),a[5]=+(a[7]+a[8]||"odd"===a[3])):a[3]&&ga.error(a[0]),a},PSEUDO:function(a){var b,c=!a[6]&&a[2];return X.CHILD.test(a[0])?null:(a[3]?a[2]=a[4]||a[5]||"":c&&V.test(c)&&(b=g(c,!0))&&(b=c.indexOf(")",c.length-b)-c.length)&&(a[0]=a[0].slice(0,b),a[2]=c.slice(0,b)),a.slice(0,3))}},filter:{TAG:function(a){var b=a.replace(ca,da).toLowerCase();return"*"===a?function(){return!0}:function(a){return a.nodeName&&a.nodeName.toLowerCase()===b}},CLASS:function(a){var b=y[a+" "];return b||(b=new RegExp("(^|"+L+")"+a+"("+L+"|$)"))&&y(a,function(a){return b.test("string"==typeof a.className&&a.className||"undefined"!=typeof a.getAttribute&&a.getAttribute("class")||"")})},ATTR:function(a,b,c){return function(d){var e=ga.attr(d,a);return null==e?"!="===b:b?(e+="","="===b?e===c:"!="===b?e!==c:"^="===b?c&&0===e.indexOf(c):"*="===b?c&&e.indexOf(c)>-1:"$="===b?c&&e.slice(-c.length)===c:"~="===b?(" "+e.replace(Q," ")+" ").indexOf(c)>-1:"|="===b?e===c||e.slice(0,c.length+1)===c+"-":!1):!0}},CHILD:function(a,b,c,d,e){var f="nth"!==a.slice(0,3),g="last"!==a.slice(-4),h="of-type"===b;return 1===d&&0===e?function(a){return!!a.parentNode}:function(b,c,i){var j,k,l,m,n,o,p=f!==g?"nextSibling":"previousSibling",q=b.parentNode,r=h&&b.nodeName.toLowerCase(),s=!i&&!h;if(q){if(f){while(p){l=b;while(l=l[p])if(h?l.nodeName.toLowerCase()===r:1===l.nodeType)return!1;o=p="only"===a&&!o&&"nextSibling"}return!0}if(o=[g?q.firstChild:q.lastChild],g&&s){k=q[u]||(q[u]={}),j=k[a]||[],n=j[0]===w&&j[1],m=j[0]===w&&j[2],l=n&&q.childNodes[n];while(l=++n&&l&&l[p]||(m=n=0)||o.pop())if(1===l.nodeType&&++m&&l===b){k[a]=[w,n,m];break}}else if(s&&(j=(b[u]||(b[u]={}))[a])&&j[0]===w)m=j[1];else while(l=++n&&l&&l[p]||(m=n=0)||o.pop())if((h?l.nodeName.toLowerCase()===r:1===l.nodeType)&&++m&&(s&&((l[u]||(l[u]={}))[a]=[w,m]),l===b))break;return m-=e,m===d||m%d===0&&m/d>=0}}},PSEUDO:function(a,b){var c,e=d.pseudos[a]||d.setFilters[a.toLowerCase()]||ga.error("unsupported pseudo: "+a);return e[u]?e(b):e.length>1?(c=[a,a,"",b],d.setFilters.hasOwnProperty(a.toLowerCase())?ia(function(a,c){var d,f=e(a,b),g=f.length;while(g--)d=J(a,f[g]),a[d]=!(c[d]=f[g])}):function(a){return e(a,0,c)}):e}},pseudos:{not:ia(function(a){var b=[],c=[],d=h(a.replace(R,"$1"));return d[u]?ia(function(a,b,c,e){var f,g=d(a,null,e,[]),h=a.length;while(h--)(f=g[h])&&(a[h]=!(b[h]=f))}):function(a,e,f){return b[0]=a,d(b,null,f,c),b[0]=null,!c.pop()}}),has:ia(function(a){return function(b){return ga(a,b).length>0}}),contains:ia(function(a){return a=a.replace(ca,da),function(b){return(b.textContent||b.innerText||e(b)).indexOf(a)>-1}}),lang:ia(function(a){return W.test(a||"")||ga.error("unsupported lang: "+a),a=a.replace(ca,da).toLowerCase(),function(b){var c;do if(c=p?b.lang:b.getAttribute("xml:lang")||b.getAttribute("lang"))return c=c.toLowerCase(),c===a||0===c.indexOf(a+"-");while((b=b.parentNode)&&1===b.nodeType);return!1}}),target:function(b){var c=a.location&&a.location.hash;return c&&c.slice(1)===b.id},root:function(a){return a===o},focus:function(a){return a===n.activeElement&&(!n.hasFocus||n.hasFocus())&&!!(a.type||a.href||~a.tabIndex)},enabled:function(a){return a.disabled===!1},disabled:function(a){return a.disabled===!0},checked:function(a){var b=a.nodeName.toLowerCase();return"input"===b&&!!a.checked||"option"===b&&!!a.selected},selected:function(a){return a.parentNode&&a.parentNode.selectedIndex,a.selected===!0},empty:function(a){for(a=a.firstChild;a;a=a.nextSibling)if(a.nodeType<6)return!1;return!0},parent:function(a){return!d.pseudos.empty(a)},header:function(a){return Z.test(a.nodeName)},input:function(a){return Y.test(a.nodeName)},button:function(a){var b=a.nodeName.toLowerCase();return"input"===b&&"button"===a.type||"button"===b},text:function(a){var b;return"input"===a.nodeName.toLowerCase()&&"text"===a.type&&(null==(b=a.getAttribute("type"))||"text"===b.toLowerCase())},first:oa(function(){return[0]}),last:oa(function(a,b){return[b-1]}),eq:oa(function(a,b,c){return[0>c?c+b:c]}),even:oa(function(a,b){for(var c=0;b>c;c+=2)a.push(c);return a}),odd:oa(function(a,b){for(var c=1;b>c;c+=2)a.push(c);return a}),lt:oa(function(a,b,c){for(var d=0>c?c+b:c;--d>=0;)a.push(d);return a}),gt:oa(function(a,b,c){for(var d=0>c?c+b:c;++d<b;)a.push(d);return a})}},d.pseudos.nth=d.pseudos.eq;for(b in{radio:!0,checkbox:!0,file:!0,password:!0,image:!0})d.pseudos[b]=ma(b);for(b in{submit:!0,reset:!0})d.pseudos[b]=na(b);function qa(){}qa.prototype=d.filters=d.pseudos,d.setFilters=new qa,g=ga.tokenize=function(a,b){var c,e,f,g,h,i,j,k=z[a+" "];if(k)return b?0:k.slice(0);h=a,i=[],j=d.preFilter;while(h){(!c||(e=S.exec(h)))&&(e&&(h=h.slice(e[0].length)||h),i.push(f=[])),c=!1,(e=T.exec(h))&&(c=e.shift(),f.push({value:c,type:e[0].replace(R," ")}),h=h.slice(c.length));for(g in d.filter)!(e=X[g].exec(h))||j[g]&&!(e=j[g](e))||(c=e.shift(),f.push({value:c,type:g,matches:e}),h=h.slice(c.length));if(!c)break}return b?h.length:h?ga.error(a):z(a,i).slice(0)};function ra(a){for(var b=0,c=a.length,d="";c>b;b++)d+=a[b].value;return d}function sa(a,b,c){var d=b.dir,e=c&&"parentNode"===d,f=x++;return b.first?function(b,c,f){while(b=b[d])if(1===b.nodeType||e)return a(b,c,f)}:function(b,c,g){var h,i,j=[w,f];if(g){while(b=b[d])if((1===b.nodeType||e)&&a(b,c,g))return!0}else while(b=b[d])if(1===b.nodeType||e){if(i=b[u]||(b[u]={}),(h=i[d])&&h[0]===w&&h[1]===f)return j[2]=h[2];if(i[d]=j,j[2]=a(b,c,g))return!0}}}function ta(a){return a.length>1?function(b,c,d){var e=a.length;while(e--)if(!a[e](b,c,d))return!1;return!0}:a[0]}function ua(a,b,c){for(var d=0,e=b.length;e>d;d++)ga(a,b[d],c);return c}function va(a,b,c,d,e){for(var f,g=[],h=0,i=a.length,j=null!=b;i>h;h++)(f=a[h])&&(!c||c(f,d,e))&&(g.push(f),j&&b.push(h));return g}function wa(a,b,c,d,e,f){return d&&!d[u]&&(d=wa(d)),e&&!e[u]&&(e=wa(e,f)),ia(function(f,g,h,i){var j,k,l,m=[],n=[],o=g.length,p=f||ua(b||"*",h.nodeType?[h]:h,[]),q=!a||!f&&b?p:va(p,m,a,h,i),r=c?e||(f?a:o||d)?[]:g:q;if(c&&c(q,r,h,i),d){j=va(r,n),d(j,[],h,i),k=j.length;while(k--)(l=j[k])&&(r[n[k]]=!(q[n[k]]=l))}if(f){if(e||a){if(e){j=[],k=r.length;while(k--)(l=r[k])&&j.push(q[k]=l);e(null,r=[],j,i)}k=r.length;while(k--)(l=r[k])&&(j=e?J(f,l):m[k])>-1&&(f[j]=!(g[j]=l))}}else r=va(r===g?r.splice(o,r.length):r),e?e(null,g,r,i):H.apply(g,r)})}function xa(a){for(var b,c,e,f=a.length,g=d.relative[a[0].type],h=g||d.relative[" "],i=g?1:0,k=sa(function(a){return a===b},h,!0),l=sa(function(a){return J(b,a)>-1},h,!0),m=[function(a,c,d){var e=!g&&(d||c!==j)||((b=c).nodeType?k(a,c,d):l(a,c,d));return b=null,e}];f>i;i++)if(c=d.relative[a[i].type])m=[sa(ta(m),c)];else{if(c=d.filter[a[i].type].apply(null,a[i].matches),c[u]){for(e=++i;f>e;e++)if(d.relative[a[e].type])break;return wa(i>1&&ta(m),i>1&&ra(a.slice(0,i-1).concat({value:" "===a[i-2].type?"*":""})).replace(R,"$1"),c,e>i&&xa(a.slice(i,e)),f>e&&xa(a=a.slice(e)),f>e&&ra(a))}m.push(c)}return ta(m)}function ya(a,b){var c=b.length>0,e=a.length>0,f=function(f,g,h,i,k){var l,m,o,p=0,q="0",r=f&&[],s=[],t=j,u=f||e&&d.find.TAG("*",k),v=w+=null==t?1:Math.random()||.1,x=u.length;for(k&&(j=g!==n&&g);q!==x&&null!=(l=u[q]);q++){if(e&&l){m=0;while(o=a[m++])if(o(l,g,h)){i.push(l);break}k&&(w=v)}c&&((l=!o&&l)&&p--,f&&r.push(l))}if(p+=q,c&&q!==p){m=0;while(o=b[m++])o(r,s,g,h);if(f){if(p>0)while(q--)r[q]||s[q]||(s[q]=F.call(i));s=va(s)}H.apply(i,s),k&&!f&&s.length>0&&p+b.length>1&&ga.uniqueSort(i)}return k&&(w=v,j=t),r};return c?ia(f):f}return h=ga.compile=function(a,b){var c,d=[],e=[],f=A[a+" "];if(!f){b||(b=g(a)),c=b.length;while(c--)f=xa(b[c]),f[u]?d.push(f):e.push(f);f=A(a,ya(e,d)),f.selector=a}return f},i=ga.select=function(a,b,e,f){var i,j,k,l,m,n="function"==typeof a&&a,o=!f&&g(a=n.selector||a);if(e=e||[],1===o.length){if(j=o[0]=o[0].slice(0),j.length>2&&"ID"===(k=j[0]).type&&c.getById&&9===b.nodeType&&p&&d.relative[j[1].type]){if(b=(d.find.ID(k.matches[0].replace(ca,da),b)||[])[0],!b)return e;n&&(b=b.parentNode),a=a.slice(j.shift().value.length)}i=X.needsContext.test(a)?0:j.length;while(i--){if(k=j[i],d.relative[l=k.type])break;if((m=d.find[l])&&(f=m(k.matches[0].replace(ca,da),aa.test(j[0].type)&&pa(b.parentNode)||b))){if(j.splice(i,1),a=f.length&&ra(j),!a)return H.apply(e,f),e;break}}}return(n||h(a,o))(f,b,!p,e,aa.test(a)&&pa(b.parentNode)||b),e},c.sortStable=u.split("").sort(B).join("")===u,c.detectDuplicates=!!l,m(),c.sortDetached=ja(function(a){return 1&a.compareDocumentPosition(n.createElement("div"))}),ja(function(a){return a.innerHTML="<a href='#'></a>","#"===a.firstChild.getAttribute("href")})||ka("type|href|height|width",function(a,b,c){return c?void 0:a.getAttribute(b,"type"===b.toLowerCase()?1:2)}),c.attributes&&ja(function(a){return a.innerHTML="<input/>",a.firstChild.setAttribute("value",""),""===a.firstChild.getAttribute("value")})||ka("value",function(a,b,c){return c||"input"!==a.nodeName.toLowerCase()?void 0:a.defaultValue}),ja(function(a){return null==a.getAttribute("disabled")})||ka(K,function(a,b,c){var d;return c?void 0:a[b]===!0?b.toLowerCase():(d=a.getAttributeNode(b))&&d.specified?d.value:null}),ga}(a);n.find=t,n.expr=t.selectors,n.expr[":"]=n.expr.pseudos,n.unique=t.uniqueSort,n.text=t.getText,n.isXMLDoc=t.isXML,n.contains=t.contains;var u=n.expr.match.needsContext,v=/^<(\w+)\s*\/?>(?:<\/\1>|)$/,w=/^.[^:#\[\.,]*$/;function x(a,b,c){if(n.isFunction(b))return n.grep(a,function(a,d){return!!b.call(a,d,a)!==c});if(b.nodeType)return n.grep(a,function(a){return a===b!==c});if("string"==typeof b){if(w.test(b))return n.filter(b,a,c);b=n.filter(b,a)}return n.grep(a,function(a){return g.call(b,a)>=0!==c})}n.filter=function(a,b,c){var d=b[0];return c&&(a=":not("+a+")"),1===b.length&&1===d.nodeType?n.find.matchesSelector(d,a)?[d]:[]:n.find.matches(a,n.grep(b,function(a){return 1===a.nodeType}))},n.fn.extend({find:function(a){var b,c=this.length,d=[],e=this;if("string"!=typeof a)return this.pushStack(n(a).filter(function(){for(b=0;c>b;b++)if(n.contains(e[b],this))return!0}));for(b=0;c>b;b++)n.find(a,e[b],d);return d=this.pushStack(c>1?n.unique(d):d),d.selector=this.selector?this.selector+" "+a:a,d},filter:function(a){return this.pushStack(x(this,a||[],!1))},not:function(a){return this.pushStack(x(this,a||[],!0))},is:function(a){return!!x(this,"string"==typeof a&&u.test(a)?n(a):a||[],!1).length}});var y,z=/^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]*))$/,A=n.fn.init=function(a,b){var c,d;if(!a)return this;if("string"==typeof a){if(c="<"===a[0]&&">"===a[a.length-1]&&a.length>=3?[null,a,null]:z.exec(a),!c||!c[1]&&b)return!b||b.jquery?(b||y).find(a):this.constructor(b).find(a);if(c[1]){if(b=b instanceof n?b[0]:b,n.merge(this,n.parseHTML(c[1],b&&b.nodeType?b.ownerDocument||b:l,!0)),v.test(c[1])&&n.isPlainObject(b))for(c in b)n.isFunction(this[c])?this[c](b[c]):this.attr(c,b[c]);return this}return d=l.getElementById(c[2]),d&&d.parentNode&&(this.length=1,this[0]=d),this.context=l,this.selector=a,this}return a.nodeType?(this.context=this[0]=a,this.length=1,this):n.isFunction(a)?"undefined"!=typeof y.ready?y.ready(a):a(n):(void 0!==a.selector&&(this.selector=a.selector,this.context=a.context),n.makeArray(a,this))};A.prototype=n.fn,y=n(l);var B=/^(?:parents|prev(?:Until|All))/,C={children:!0,contents:!0,next:!0,prev:!0};n.extend({dir:function(a,b,c){var d=[],e=void 0!==c;while((a=a[b])&&9!==a.nodeType)if(1===a.nodeType){if(e&&n(a).is(c))break;d.push(a)}return d},sibling:function(a,b){for(var c=[];a;a=a.nextSibling)1===a.nodeType&&a!==b&&c.push(a);return c}}),n.fn.extend({has:function(a){var b=n(a,this),c=b.length;return this.filter(function(){for(var a=0;c>a;a++)if(n.contains(this,b[a]))return!0})},closest:function(a,b){for(var c,d=0,e=this.length,f=[],g=u.test(a)||"string"!=typeof a?n(a,b||this.context):0;e>d;d++)for(c=this[d];c&&c!==b;c=c.parentNode)if(c.nodeType<11&&(g?g.index(c)>-1:1===c.nodeType&&n.find.matchesSelector(c,a))){f.push(c);break}return this.pushStack(f.length>1?n.unique(f):f)},index:function(a){return a?"string"==typeof a?g.call(n(a),this[0]):g.call(this,a.jquery?a[0]:a):this[0]&&this[0].parentNode?this.first().prevAll().length:-1},add:function(a,b){return this.pushStack(n.unique(n.merge(this.get(),n(a,b))))},addBack:function(a){return this.add(null==a?this.prevObject:this.prevObject.filter(a))}});function D(a,b){while((a=a[b])&&1!==a.nodeType);return a}n.each({parent:function(a){var b=a.parentNode;return b&&11!==b.nodeType?b:null},parents:function(a){return n.dir(a,"parentNode")},parentsUntil:function(a,b,c){return n.dir(a,"parentNode",c)},next:function(a){return D(a,"nextSibling")},prev:function(a){return D(a,"previousSibling")},nextAll:function(a){return n.dir(a,"nextSibling")},prevAll:function(a){return n.dir(a,"previousSibling")},nextUntil:function(a,b,c){return n.dir(a,"nextSibling",c)},prevUntil:function(a,b,c){return n.dir(a,"previousSibling",c)},siblings:function(a){return n.sibling((a.parentNode||{}).firstChild,a)},children:function(a){return n.sibling(a.firstChild)},contents:function(a){return a.contentDocument||n.merge([],a.childNodes)}},function(a,b){n.fn[a]=function(c,d){var e=n.map(this,b,c);return"Until"!==a.slice(-5)&&(d=c),d&&"string"==typeof d&&(e=n.filter(d,e)),this.length>1&&(C[a]||n.unique(e),B.test(a)&&e.reverse()),this.pushStack(e)}});var E=/\S+/g,F={};function G(a){var b=F[a]={};return n.each(a.match(E)||[],function(a,c){b[c]=!0}),b}n.Callbacks=function(a){a="string"==typeof a?F[a]||G(a):n.extend({},a);var b,c,d,e,f,g,h=[],i=!a.once&&[],j=function(l){for(b=a.memory&&l,c=!0,g=e||0,e=0,f=h.length,d=!0;h&&f>g;g++)if(h[g].apply(l[0],l[1])===!1&&a.stopOnFalse){b=!1;break}d=!1,h&&(i?i.length&&j(i.shift()):b?h=[]:k.disable())},k={add:function(){if(h){var c=h.length;!function g(b){n.each(b,function(b,c){var d=n.type(c);"function"===d?a.unique&&k.has(c)||h.push(c):c&&c.length&&"string"!==d&&g(c)})}(arguments),d?f=h.length:b&&(e=c,j(b))}return this},remove:function(){return h&&n.each(arguments,function(a,b){var c;while((c=n.inArray(b,h,c))>-1)h.splice(c,1),d&&(f>=c&&f--,g>=c&&g--)}),this},has:function(a){return a?n.inArray(a,h)>-1:!(!h||!h.length)},empty:function(){return h=[],f=0,this},disable:function(){return h=i=b=void 0,this},disabled:function(){return!h},lock:function(){return i=void 0,b||k.disable(),this},locked:function(){return!i},fireWith:function(a,b){return!h||c&&!i||(b=b||[],b=[a,b.slice?b.slice():b],d?i.push(b):j(b)),this},fire:function(){return k.fireWith(this,arguments),this},fired:function(){return!!c}};return k},n.extend({Deferred:function(a){var b=[["resolve","done",n.Callbacks("once memory"),"resolved"],["reject","fail",n.Callbacks("once memory"),"rejected"],["notify","progress",n.Callbacks("memory")]],c="pending",d={state:function(){return c},always:function(){return e.done(arguments).fail(arguments),this},then:function(){var a=arguments;return n.Deferred(function(c){n.each(b,function(b,f){var g=n.isFunction(a[b])&&a[b];e[f[1]](function(){var a=g&&g.apply(this,arguments);a&&n.isFunction(a.promise)?a.promise().done(c.resolve).fail(c.reject).progress(c.notify):c[f[0]+"With"](this===d?c.promise():this,g?[a]:arguments)})}),a=null}).promise()},promise:function(a){return null!=a?n.extend(a,d):d}},e={};return d.pipe=d.then,n.each(b,function(a,f){var g=f[2],h=f[3];d[f[1]]=g.add,h&&g.add(function(){c=h},b[1^a][2].disable,b[2][2].lock),e[f[0]]=function(){return e[f[0]+"With"](this===e?d:this,arguments),this},e[f[0]+"With"]=g.fireWith}),d.promise(e),a&&a.call(e,e),e},when:function(a){var b=0,c=d.call(arguments),e=c.length,f=1!==e||a&&n.isFunction(a.promise)?e:0,g=1===f?a:n.Deferred(),h=function(a,b,c){return function(e){b[a]=this,c[a]=arguments.length>1?d.call(arguments):e,c===i?g.notifyWith(b,c):--f||g.resolveWith(b,c)}},i,j,k;if(e>1)for(i=new Array(e),j=new Array(e),k=new Array(e);e>b;b++)c[b]&&n.isFunction(c[b].promise)?c[b].promise().done(h(b,k,c)).fail(g.reject).progress(h(b,j,i)):--f;return f||g.resolveWith(k,c),g.promise()}});var H;n.fn.ready=function(a){return n.ready.promise().done(a),this},n.extend({isReady:!1,readyWait:1,holdReady:function(a){a?n.readyWait++:n.ready(!0)},ready:function(a){(a===!0?--n.readyWait:n.isReady)||(n.isReady=!0,a!==!0&&--n.readyWait>0||(H.resolveWith(l,[n]),n.fn.triggerHandler&&(n(l).triggerHandler("ready"),n(l).off("ready"))))}});function I(){l.removeEventListener("DOMContentLoaded",I,!1),a.removeEventListener("load",I,!1),n.ready()}n.ready.promise=function(b){return H||(H=n.Deferred(),"complete"===l.readyState?setTimeout(n.ready):(l.addEventListener("DOMContentLoaded",I,!1),a.addEventListener("load",I,!1))),H.promise(b)},n.ready.promise();var J=n.access=function(a,b,c,d,e,f,g){var h=0,i=a.length,j=null==c;if("object"===n.type(c)){e=!0;for(h in c)n.access(a,b,h,c[h],!0,f,g)}else if(void 0!==d&&(e=!0,n.isFunction(d)||(g=!0),j&&(g?(b.call(a,d),b=null):(j=b,b=function(a,b,c){return j.call(n(a),c)})),b))for(;i>h;h++)b(a[h],c,g?d:d.call(a[h],h,b(a[h],c)));return e?a:j?b.call(a):i?b(a[0],c):f};n.acceptData=function(a){return 1===a.nodeType||9===a.nodeType||!+a.nodeType};function K(){Object.defineProperty(this.cache={},0,{get:function(){return{}}}),this.expando=n.expando+K.uid++}K.uid=1,K.accepts=n.acceptData,K.prototype={key:function(a){if(!K.accepts(a))return 0;var b={},c=a[this.expando];if(!c){c=K.uid++;try{b[this.expando]={value:c},Object.defineProperties(a,b)}catch(d){b[this.expando]=c,n.extend(a,b)}}return this.cache[c]||(this.cache[c]={}),c},set:function(a,b,c){var d,e=this.key(a),f=this.cache[e];if("string"==typeof b)f[b]=c;else if(n.isEmptyObject(f))n.extend(this.cache[e],b);else for(d in b)f[d]=b[d];return f},get:function(a,b){var c=this.cache[this.key(a)];return void 0===b?c:c[b]},access:function(a,b,c){var d;return void 0===b||b&&"string"==typeof b&&void 0===c?(d=this.get(a,b),void 0!==d?d:this.get(a,n.camelCase(b))):(this.set(a,b,c),void 0!==c?c:b)},remove:function(a,b){var c,d,e,f=this.key(a),g=this.cache[f];if(void 0===b)this.cache[f]={};else{n.isArray(b)?d=b.concat(b.map(n.camelCase)):(e=n.camelCase(b),b in g?d=[b,e]:(d=e,d=d in g?[d]:d.match(E)||[])),c=d.length;while(c--)delete g[d[c]]}},hasData:function(a){return!n.isEmptyObject(this.cache[a[this.expando]]||{})},discard:function(a){a[this.expando]&&delete this.cache[a[this.expando]]}};var L=new K,M=new K,N=/^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,O=/([A-Z])/g;function P(a,b,c){var d;if(void 0===c&&1===a.nodeType)if(d="data-"+b.replace(O,"-$1").toLowerCase(),c=a.getAttribute(d),"string"==typeof c){try{c="true"===c?!0:"false"===c?!1:"null"===c?null:+c+""===c?+c:N.test(c)?n.parseJSON(c):c}catch(e){}M.set(a,b,c)}else c=void 0;return c}n.extend({hasData:function(a){return M.hasData(a)||L.hasData(a)},data:function(a,b,c){
return M.access(a,b,c)},removeData:function(a,b){M.remove(a,b)},_data:function(a,b,c){return L.access(a,b,c)},_removeData:function(a,b){L.remove(a,b)}}),n.fn.extend({data:function(a,b){var c,d,e,f=this[0],g=f&&f.attributes;if(void 0===a){if(this.length&&(e=M.get(f),1===f.nodeType&&!L.get(f,"hasDataAttrs"))){c=g.length;while(c--)g[c]&&(d=g[c].name,0===d.indexOf("data-")&&(d=n.camelCase(d.slice(5)),P(f,d,e[d])));L.set(f,"hasDataAttrs",!0)}return e}return"object"==typeof a?this.each(function(){M.set(this,a)}):J(this,function(b){var c,d=n.camelCase(a);if(f&&void 0===b){if(c=M.get(f,a),void 0!==c)return c;if(c=M.get(f,d),void 0!==c)return c;if(c=P(f,d,void 0),void 0!==c)return c}else this.each(function(){var c=M.get(this,d);M.set(this,d,b),-1!==a.indexOf("-")&&void 0!==c&&M.set(this,a,b)})},null,b,arguments.length>1,null,!0)},removeData:function(a){return this.each(function(){M.remove(this,a)})}}),n.extend({queue:function(a,b,c){var d;return a?(b=(b||"fx")+"queue",d=L.get(a,b),c&&(!d||n.isArray(c)?d=L.access(a,b,n.makeArray(c)):d.push(c)),d||[]):void 0},dequeue:function(a,b){b=b||"fx";var c=n.queue(a,b),d=c.length,e=c.shift(),f=n._queueHooks(a,b),g=function(){n.dequeue(a,b)};"inprogress"===e&&(e=c.shift(),d--),e&&("fx"===b&&c.unshift("inprogress"),delete f.stop,e.call(a,g,f)),!d&&f&&f.empty.fire()},_queueHooks:function(a,b){var c=b+"queueHooks";return L.get(a,c)||L.access(a,c,{empty:n.Callbacks("once memory").add(function(){L.remove(a,[b+"queue",c])})})}}),n.fn.extend({queue:function(a,b){var c=2;return"string"!=typeof a&&(b=a,a="fx",c--),arguments.length<c?n.queue(this[0],a):void 0===b?this:this.each(function(){var c=n.queue(this,a,b);n._queueHooks(this,a),"fx"===a&&"inprogress"!==c[0]&&n.dequeue(this,a)})},dequeue:function(a){return this.each(function(){n.dequeue(this,a)})},clearQueue:function(a){return this.queue(a||"fx",[])},promise:function(a,b){var c,d=1,e=n.Deferred(),f=this,g=this.length,h=function(){--d||e.resolveWith(f,[f])};"string"!=typeof a&&(b=a,a=void 0),a=a||"fx";while(g--)c=L.get(f[g],a+"queueHooks"),c&&c.empty&&(d++,c.empty.add(h));return h(),e.promise(b)}});var Q=/[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,R=["Top","Right","Bottom","Left"],S=function(a,b){return a=b||a,"none"===n.css(a,"display")||!n.contains(a.ownerDocument,a)},T=/^(?:checkbox|radio)$/i;!function(){var a=l.createDocumentFragment(),b=a.appendChild(l.createElement("div")),c=l.createElement("input");c.setAttribute("type","radio"),c.setAttribute("checked","checked"),c.setAttribute("name","t"),b.appendChild(c),k.checkClone=b.cloneNode(!0).cloneNode(!0).lastChild.checked,b.innerHTML="<textarea>x</textarea>",k.noCloneChecked=!!b.cloneNode(!0).lastChild.defaultValue}();var U="undefined";k.focusinBubbles="onfocusin"in a;var V=/^key/,W=/^(?:mouse|pointer|contextmenu)|click/,X=/^(?:focusinfocus|focusoutblur)$/,Y=/^([^.]*)(?:\.(.+)|)$/;function Z(){return!0}function $(){return!1}function _(){try{return l.activeElement}catch(a){}}n.event={global:{},add:function(a,b,c,d,e){var f,g,h,i,j,k,l,m,o,p,q,r=L.get(a);if(r){c.handler&&(f=c,c=f.handler,e=f.selector),c.guid||(c.guid=n.guid++),(i=r.events)||(i=r.events={}),(g=r.handle)||(g=r.handle=function(b){return typeof n!==U&&n.event.triggered!==b.type?n.event.dispatch.apply(a,arguments):void 0}),b=(b||"").match(E)||[""],j=b.length;while(j--)h=Y.exec(b[j])||[],o=q=h[1],p=(h[2]||"").split(".").sort(),o&&(l=n.event.special[o]||{},o=(e?l.delegateType:l.bindType)||o,l=n.event.special[o]||{},k=n.extend({type:o,origType:q,data:d,handler:c,guid:c.guid,selector:e,needsContext:e&&n.expr.match.needsContext.test(e),namespace:p.join(".")},f),(m=i[o])||(m=i[o]=[],m.delegateCount=0,l.setup&&l.setup.call(a,d,p,g)!==!1||a.addEventListener&&a.addEventListener(o,g,!1)),l.add&&(l.add.call(a,k),k.handler.guid||(k.handler.guid=c.guid)),e?m.splice(m.delegateCount++,0,k):m.push(k),n.event.global[o]=!0)}},remove:function(a,b,c,d,e){var f,g,h,i,j,k,l,m,o,p,q,r=L.hasData(a)&&L.get(a);if(r&&(i=r.events)){b=(b||"").match(E)||[""],j=b.length;while(j--)if(h=Y.exec(b[j])||[],o=q=h[1],p=(h[2]||"").split(".").sort(),o){l=n.event.special[o]||{},o=(d?l.delegateType:l.bindType)||o,m=i[o]||[],h=h[2]&&new RegExp("(^|\\.)"+p.join("\\.(?:.*\\.|)")+"(\\.|$)"),g=f=m.length;while(f--)k=m[f],!e&&q!==k.origType||c&&c.guid!==k.guid||h&&!h.test(k.namespace)||d&&d!==k.selector&&("**"!==d||!k.selector)||(m.splice(f,1),k.selector&&m.delegateCount--,l.remove&&l.remove.call(a,k));g&&!m.length&&(l.teardown&&l.teardown.call(a,p,r.handle)!==!1||n.removeEvent(a,o,r.handle),delete i[o])}else for(o in i)n.event.remove(a,o+b[j],c,d,!0);n.isEmptyObject(i)&&(delete r.handle,L.remove(a,"events"))}},trigger:function(b,c,d,e){var f,g,h,i,k,m,o,p=[d||l],q=j.call(b,"type")?b.type:b,r=j.call(b,"namespace")?b.namespace.split("."):[];if(g=h=d=d||l,3!==d.nodeType&&8!==d.nodeType&&!X.test(q+n.event.triggered)&&(q.indexOf(".")>=0&&(r=q.split("."),q=r.shift(),r.sort()),k=q.indexOf(":")<0&&"on"+q,b=b[n.expando]?b:new n.Event(q,"object"==typeof b&&b),b.isTrigger=e?2:3,b.namespace=r.join("."),b.namespace_re=b.namespace?new RegExp("(^|\\.)"+r.join("\\.(?:.*\\.|)")+"(\\.|$)"):null,b.result=void 0,b.target||(b.target=d),c=null==c?[b]:n.makeArray(c,[b]),o=n.event.special[q]||{},e||!o.trigger||o.trigger.apply(d,c)!==!1)){if(!e&&!o.noBubble&&!n.isWindow(d)){for(i=o.delegateType||q,X.test(i+q)||(g=g.parentNode);g;g=g.parentNode)p.push(g),h=g;h===(d.ownerDocument||l)&&p.push(h.defaultView||h.parentWindow||a)}f=0;while((g=p[f++])&&!b.isPropagationStopped())b.type=f>1?i:o.bindType||q,m=(L.get(g,"events")||{})[b.type]&&L.get(g,"handle"),m&&m.apply(g,c),m=k&&g[k],m&&m.apply&&n.acceptData(g)&&(b.result=m.apply(g,c),b.result===!1&&b.preventDefault());return b.type=q,e||b.isDefaultPrevented()||o._default&&o._default.apply(p.pop(),c)!==!1||!n.acceptData(d)||k&&n.isFunction(d[q])&&!n.isWindow(d)&&(h=d[k],h&&(d[k]=null),n.event.triggered=q,d[q](),n.event.triggered=void 0,h&&(d[k]=h)),b.result}},dispatch:function(a){a=n.event.fix(a);var b,c,e,f,g,h=[],i=d.call(arguments),j=(L.get(this,"events")||{})[a.type]||[],k=n.event.special[a.type]||{};if(i[0]=a,a.delegateTarget=this,!k.preDispatch||k.preDispatch.call(this,a)!==!1){h=n.event.handlers.call(this,a,j),b=0;while((f=h[b++])&&!a.isPropagationStopped()){a.currentTarget=f.elem,c=0;while((g=f.handlers[c++])&&!a.isImmediatePropagationStopped())(!a.namespace_re||a.namespace_re.test(g.namespace))&&(a.handleObj=g,a.data=g.data,e=((n.event.special[g.origType]||{}).handle||g.handler).apply(f.elem,i),void 0!==e&&(a.result=e)===!1&&(a.preventDefault(),a.stopPropagation()))}return k.postDispatch&&k.postDispatch.call(this,a),a.result}},handlers:function(a,b){var c,d,e,f,g=[],h=b.delegateCount,i=a.target;if(h&&i.nodeType&&(!a.button||"click"!==a.type))for(;i!==this;i=i.parentNode||this)if(i.disabled!==!0||"click"!==a.type){for(d=[],c=0;h>c;c++)f=b[c],e=f.selector+" ",void 0===d[e]&&(d[e]=f.needsContext?n(e,this).index(i)>=0:n.find(e,this,null,[i]).length),d[e]&&d.push(f);d.length&&g.push({elem:i,handlers:d})}return h<b.length&&g.push({elem:this,handlers:b.slice(h)}),g},props:"altKey bubbles cancelable ctrlKey currentTarget eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),fixHooks:{},keyHooks:{props:"char charCode key keyCode".split(" "),filter:function(a,b){return null==a.which&&(a.which=null!=b.charCode?b.charCode:b.keyCode),a}},mouseHooks:{props:"button buttons clientX clientY offsetX offsetY pageX pageY screenX screenY toElement".split(" "),filter:function(a,b){var c,d,e,f=b.button;return null==a.pageX&&null!=b.clientX&&(c=a.target.ownerDocument||l,d=c.documentElement,e=c.body,a.pageX=b.clientX+(d&&d.scrollLeft||e&&e.scrollLeft||0)-(d&&d.clientLeft||e&&e.clientLeft||0),a.pageY=b.clientY+(d&&d.scrollTop||e&&e.scrollTop||0)-(d&&d.clientTop||e&&e.clientTop||0)),a.which||void 0===f||(a.which=1&f?1:2&f?3:4&f?2:0),a}},fix:function(a){if(a[n.expando])return a;var b,c,d,e=a.type,f=a,g=this.fixHooks[e];g||(this.fixHooks[e]=g=W.test(e)?this.mouseHooks:V.test(e)?this.keyHooks:{}),d=g.props?this.props.concat(g.props):this.props,a=new n.Event(f),b=d.length;while(b--)c=d[b],a[c]=f[c];return a.target||(a.target=l),3===a.target.nodeType&&(a.target=a.target.parentNode),g.filter?g.filter(a,f):a},special:{load:{noBubble:!0},focus:{trigger:function(){return this!==_()&&this.focus?(this.focus(),!1):void 0},delegateType:"focusin"},blur:{trigger:function(){return this===_()&&this.blur?(this.blur(),!1):void 0},delegateType:"focusout"},click:{trigger:function(){return"checkbox"===this.type&&this.click&&n.nodeName(this,"input")?(this.click(),!1):void 0},_default:function(a){return n.nodeName(a.target,"a")}},beforeunload:{postDispatch:function(a){void 0!==a.result&&a.originalEvent&&(a.originalEvent.returnValue=a.result)}}},simulate:function(a,b,c,d){var e=n.extend(new n.Event,c,{type:a,isSimulated:!0,originalEvent:{}});d?n.event.trigger(e,null,b):n.event.dispatch.call(b,e),e.isDefaultPrevented()&&c.preventDefault()}},n.removeEvent=function(a,b,c){a.removeEventListener&&a.removeEventListener(b,c,!1)},n.Event=function(a,b){return this instanceof n.Event?(a&&a.type?(this.originalEvent=a,this.type=a.type,this.isDefaultPrevented=a.defaultPrevented||void 0===a.defaultPrevented&&a.returnValue===!1?Z:$):this.type=a,b&&n.extend(this,b),this.timeStamp=a&&a.timeStamp||n.now(),void(this[n.expando]=!0)):new n.Event(a,b)},n.Event.prototype={isDefaultPrevented:$,isPropagationStopped:$,isImmediatePropagationStopped:$,preventDefault:function(){var a=this.originalEvent;this.isDefaultPrevented=Z,a&&a.preventDefault&&a.preventDefault()},stopPropagation:function(){var a=this.originalEvent;this.isPropagationStopped=Z,a&&a.stopPropagation&&a.stopPropagation()},stopImmediatePropagation:function(){var a=this.originalEvent;this.isImmediatePropagationStopped=Z,a&&a.stopImmediatePropagation&&a.stopImmediatePropagation(),this.stopPropagation()}},n.each({mouseenter:"mouseover",mouseleave:"mouseout",pointerenter:"pointerover",pointerleave:"pointerout"},function(a,b){n.event.special[a]={delegateType:b,bindType:b,handle:function(a){var c,d=this,e=a.relatedTarget,f=a.handleObj;return(!e||e!==d&&!n.contains(d,e))&&(a.type=f.origType,c=f.handler.apply(this,arguments),a.type=b),c}}}),k.focusinBubbles||n.each({focus:"focusin",blur:"focusout"},function(a,b){var c=function(a){n.event.simulate(b,a.target,n.event.fix(a),!0)};n.event.special[b]={setup:function(){var d=this.ownerDocument||this,e=L.access(d,b);e||d.addEventListener(a,c,!0),L.access(d,b,(e||0)+1)},teardown:function(){var d=this.ownerDocument||this,e=L.access(d,b)-1;e?L.access(d,b,e):(d.removeEventListener(a,c,!0),L.remove(d,b))}}}),n.fn.extend({on:function(a,b,c,d,e){var f,g;if("object"==typeof a){"string"!=typeof b&&(c=c||b,b=void 0);for(g in a)this.on(g,b,c,a[g],e);return this}if(null==c&&null==d?(d=b,c=b=void 0):null==d&&("string"==typeof b?(d=c,c=void 0):(d=c,c=b,b=void 0)),d===!1)d=$;else if(!d)return this;return 1===e&&(f=d,d=function(a){return n().off(a),f.apply(this,arguments)},d.guid=f.guid||(f.guid=n.guid++)),this.each(function(){n.event.add(this,a,d,c,b)})},one:function(a,b,c,d){return this.on(a,b,c,d,1)},off:function(a,b,c){var d,e;if(a&&a.preventDefault&&a.handleObj)return d=a.handleObj,n(a.delegateTarget).off(d.namespace?d.origType+"."+d.namespace:d.origType,d.selector,d.handler),this;if("object"==typeof a){for(e in a)this.off(e,b,a[e]);return this}return(b===!1||"function"==typeof b)&&(c=b,b=void 0),c===!1&&(c=$),this.each(function(){n.event.remove(this,a,c,b)})},trigger:function(a,b){return this.each(function(){n.event.trigger(a,b,this)})},triggerHandler:function(a,b){var c=this[0];return c?n.event.trigger(a,b,c,!0):void 0}});var aa=/<(?!area|br|col|embed|hr|img|input|link|meta|param)(([\w:]+)[^>]*)\/>/gi,ba=/<([\w:]+)/,ca=/<|&#?\w+;/,da=/<(?:script|style|link)/i,ea=/checked\s*(?:[^=]|=\s*.checked.)/i,fa=/^$|\/(?:java|ecma)script/i,ga=/^true\/(.*)/,ha=/^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g,ia={option:[1,"<select multiple='multiple'>","</select>"],thead:[1,"<table>","</table>"],col:[2,"<table><colgroup>","</colgroup></table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],_default:[0,"",""]};ia.optgroup=ia.option,ia.tbody=ia.tfoot=ia.colgroup=ia.caption=ia.thead,ia.th=ia.td;function ja(a,b){return n.nodeName(a,"table")&&n.nodeName(11!==b.nodeType?b:b.firstChild,"tr")?a.getElementsByTagName("tbody")[0]||a.appendChild(a.ownerDocument.createElement("tbody")):a}function ka(a){return a.type=(null!==a.getAttribute("type"))+"/"+a.type,a}function la(a){var b=ga.exec(a.type);return b?a.type=b[1]:a.removeAttribute("type"),a}function ma(a,b){for(var c=0,d=a.length;d>c;c++)L.set(a[c],"globalEval",!b||L.get(b[c],"globalEval"))}function na(a,b){var c,d,e,f,g,h,i,j;if(1===b.nodeType){if(L.hasData(a)&&(f=L.access(a),g=L.set(b,f),j=f.events)){delete g.handle,g.events={};for(e in j)for(c=0,d=j[e].length;d>c;c++)n.event.add(b,e,j[e][c])}M.hasData(a)&&(h=M.access(a),i=n.extend({},h),M.set(b,i))}}function oa(a,b){var c=a.getElementsByTagName?a.getElementsByTagName(b||"*"):a.querySelectorAll?a.querySelectorAll(b||"*"):[];return void 0===b||b&&n.nodeName(a,b)?n.merge([a],c):c}function pa(a,b){var c=b.nodeName.toLowerCase();"input"===c&&T.test(a.type)?b.checked=a.checked:("input"===c||"textarea"===c)&&(b.defaultValue=a.defaultValue)}n.extend({clone:function(a,b,c){var d,e,f,g,h=a.cloneNode(!0),i=n.contains(a.ownerDocument,a);if(!(k.noCloneChecked||1!==a.nodeType&&11!==a.nodeType||n.isXMLDoc(a)))for(g=oa(h),f=oa(a),d=0,e=f.length;e>d;d++)pa(f[d],g[d]);if(b)if(c)for(f=f||oa(a),g=g||oa(h),d=0,e=f.length;e>d;d++)na(f[d],g[d]);else na(a,h);return g=oa(h,"script"),g.length>0&&ma(g,!i&&oa(a,"script")),h},buildFragment:function(a,b,c,d){for(var e,f,g,h,i,j,k=b.createDocumentFragment(),l=[],m=0,o=a.length;o>m;m++)if(e=a[m],e||0===e)if("object"===n.type(e))n.merge(l,e.nodeType?[e]:e);else if(ca.test(e)){f=f||k.appendChild(b.createElement("div")),g=(ba.exec(e)||["",""])[1].toLowerCase(),h=ia[g]||ia._default,f.innerHTML=h[1]+e.replace(aa,"<$1></$2>")+h[2],j=h[0];while(j--)f=f.lastChild;n.merge(l,f.childNodes),f=k.firstChild,f.textContent=""}else l.push(b.createTextNode(e));k.textContent="",m=0;while(e=l[m++])if((!d||-1===n.inArray(e,d))&&(i=n.contains(e.ownerDocument,e),f=oa(k.appendChild(e),"script"),i&&ma(f),c)){j=0;while(e=f[j++])fa.test(e.type||"")&&c.push(e)}return k},cleanData:function(a){for(var b,c,d,e,f=n.event.special,g=0;void 0!==(c=a[g]);g++){if(n.acceptData(c)&&(e=c[L.expando],e&&(b=L.cache[e]))){if(b.events)for(d in b.events)f[d]?n.event.remove(c,d):n.removeEvent(c,d,b.handle);L.cache[e]&&delete L.cache[e]}delete M.cache[c[M.expando]]}}}),n.fn.extend({text:function(a){return J(this,function(a){return void 0===a?n.text(this):this.empty().each(function(){(1===this.nodeType||11===this.nodeType||9===this.nodeType)&&(this.textContent=a)})},null,a,arguments.length)},append:function(){return this.domManip(arguments,function(a){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var b=ja(this,a);b.appendChild(a)}})},prepend:function(){return this.domManip(arguments,function(a){if(1===this.nodeType||11===this.nodeType||9===this.nodeType){var b=ja(this,a);b.insertBefore(a,b.firstChild)}})},before:function(){return this.domManip(arguments,function(a){this.parentNode&&this.parentNode.insertBefore(a,this)})},after:function(){return this.domManip(arguments,function(a){this.parentNode&&this.parentNode.insertBefore(a,this.nextSibling)})},remove:function(a,b){for(var c,d=a?n.filter(a,this):this,e=0;null!=(c=d[e]);e++)b||1!==c.nodeType||n.cleanData(oa(c)),c.parentNode&&(b&&n.contains(c.ownerDocument,c)&&ma(oa(c,"script")),c.parentNode.removeChild(c));return this},empty:function(){for(var a,b=0;null!=(a=this[b]);b++)1===a.nodeType&&(n.cleanData(oa(a,!1)),a.textContent="");return this},clone:function(a,b){return a=null==a?!1:a,b=null==b?a:b,this.map(function(){return n.clone(this,a,b)})},html:function(a){return J(this,function(a){var b=this[0]||{},c=0,d=this.length;if(void 0===a&&1===b.nodeType)return b.innerHTML;if("string"==typeof a&&!da.test(a)&&!ia[(ba.exec(a)||["",""])[1].toLowerCase()]){a=a.replace(aa,"<$1></$2>");try{for(;d>c;c++)b=this[c]||{},1===b.nodeType&&(n.cleanData(oa(b,!1)),b.innerHTML=a);b=0}catch(e){}}b&&this.empty().append(a)},null,a,arguments.length)},replaceWith:function(){var a=arguments[0];return this.domManip(arguments,function(b){a=this.parentNode,n.cleanData(oa(this)),a&&a.replaceChild(b,this)}),a&&(a.length||a.nodeType)?this:this.remove()},detach:function(a){return this.remove(a,!0)},domManip:function(a,b){a=e.apply([],a);var c,d,f,g,h,i,j=0,l=this.length,m=this,o=l-1,p=a[0],q=n.isFunction(p);if(q||l>1&&"string"==typeof p&&!k.checkClone&&ea.test(p))return this.each(function(c){var d=m.eq(c);q&&(a[0]=p.call(this,c,d.html())),d.domManip(a,b)});if(l&&(c=n.buildFragment(a,this[0].ownerDocument,!1,this),d=c.firstChild,1===c.childNodes.length&&(c=d),d)){for(f=n.map(oa(c,"script"),ka),g=f.length;l>j;j++)h=c,j!==o&&(h=n.clone(h,!0,!0),g&&n.merge(f,oa(h,"script"))),b.call(this[j],h,j);if(g)for(i=f[f.length-1].ownerDocument,n.map(f,la),j=0;g>j;j++)h=f[j],fa.test(h.type||"")&&!L.access(h,"globalEval")&&n.contains(i,h)&&(h.src?n._evalUrl&&n._evalUrl(h.src):n.globalEval(h.textContent.replace(ha,"")))}return this}}),n.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(a,b){n.fn[a]=function(a){for(var c,d=[],e=n(a),g=e.length-1,h=0;g>=h;h++)c=h===g?this:this.clone(!0),n(e[h])[b](c),f.apply(d,c.get());return this.pushStack(d)}});var qa,ra={};function sa(b,c){var d,e=n(c.createElement(b)).appendTo(c.body),f=a.getDefaultComputedStyle&&(d=a.getDefaultComputedStyle(e[0]))?d.display:n.css(e[0],"display");return e.detach(),f}function ta(a){var b=l,c=ra[a];return c||(c=sa(a,b),"none"!==c&&c||(qa=(qa||n("<iframe frameborder='0' width='0' height='0'/>")).appendTo(b.documentElement),b=qa[0].contentDocument,b.write(),b.close(),c=sa(a,b),qa.detach()),ra[a]=c),c}var ua=/^margin/,va=new RegExp("^("+Q+")(?!px)[a-z%]+$","i"),wa=function(b){return b.ownerDocument.defaultView.opener?b.ownerDocument.defaultView.getComputedStyle(b,null):a.getComputedStyle(b,null)};function xa(a,b,c){var d,e,f,g,h=a.style;return c=c||wa(a),c&&(g=c.getPropertyValue(b)||c[b]),c&&(""!==g||n.contains(a.ownerDocument,a)||(g=n.style(a,b)),va.test(g)&&ua.test(b)&&(d=h.width,e=h.minWidth,f=h.maxWidth,h.minWidth=h.maxWidth=h.width=g,g=c.width,h.width=d,h.minWidth=e,h.maxWidth=f)),void 0!==g?g+"":g}function ya(a,b){return{get:function(){return a()?void delete this.get:(this.get=b).apply(this,arguments)}}}!function(){var b,c,d=l.documentElement,e=l.createElement("div"),f=l.createElement("div");if(f.style){f.style.backgroundClip="content-box",f.cloneNode(!0).style.backgroundClip="",k.clearCloneStyle="content-box"===f.style.backgroundClip,e.style.cssText="border:0;width:0;height:0;top:0;left:-9999px;margin-top:1px;position:absolute",e.appendChild(f);function g(){f.style.cssText="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;display:block;margin-top:1%;top:1%;border:1px;padding:1px;width:4px;position:absolute",f.innerHTML="",d.appendChild(e);var g=a.getComputedStyle(f,null);b="1%"!==g.top,c="4px"===g.width,d.removeChild(e)}a.getComputedStyle&&n.extend(k,{pixelPosition:function(){return g(),b},boxSizingReliable:function(){return null==c&&g(),c},reliableMarginRight:function(){var b,c=f.appendChild(l.createElement("div"));return c.style.cssText=f.style.cssText="-webkit-box-sizing:content-box;-moz-box-sizing:content-box;box-sizing:content-box;display:block;margin:0;border:0;padding:0",c.style.marginRight=c.style.width="0",f.style.width="1px",d.appendChild(e),b=!parseFloat(a.getComputedStyle(c,null).marginRight),d.removeChild(e),f.removeChild(c),b}})}}(),n.swap=function(a,b,c,d){var e,f,g={};for(f in b)g[f]=a.style[f],a.style[f]=b[f];e=c.apply(a,d||[]);for(f in b)a.style[f]=g[f];return e};var za=/^(none|table(?!-c[ea]).+)/,Aa=new RegExp("^("+Q+")(.*)$","i"),Ba=new RegExp("^([+-])=("+Q+")","i"),Ca={position:"absolute",visibility:"hidden",display:"block"},Da={letterSpacing:"0",fontWeight:"400"},Ea=["Webkit","O","Moz","ms"];function Fa(a,b){if(b in a)return b;var c=b[0].toUpperCase()+b.slice(1),d=b,e=Ea.length;while(e--)if(b=Ea[e]+c,b in a)return b;return d}function Ga(a,b,c){var d=Aa.exec(b);return d?Math.max(0,d[1]-(c||0))+(d[2]||"px"):b}function Ha(a,b,c,d,e){for(var f=c===(d?"border":"content")?4:"width"===b?1:0,g=0;4>f;f+=2)"margin"===c&&(g+=n.css(a,c+R[f],!0,e)),d?("content"===c&&(g-=n.css(a,"padding"+R[f],!0,e)),"margin"!==c&&(g-=n.css(a,"border"+R[f]+"Width",!0,e))):(g+=n.css(a,"padding"+R[f],!0,e),"padding"!==c&&(g+=n.css(a,"border"+R[f]+"Width",!0,e)));return g}function Ia(a,b,c){var d=!0,e="width"===b?a.offsetWidth:a.offsetHeight,f=wa(a),g="border-box"===n.css(a,"boxSizing",!1,f);if(0>=e||null==e){if(e=xa(a,b,f),(0>e||null==e)&&(e=a.style[b]),va.test(e))return e;d=g&&(k.boxSizingReliable()||e===a.style[b]),e=parseFloat(e)||0}return e+Ha(a,b,c||(g?"border":"content"),d,f)+"px"}function Ja(a,b){for(var c,d,e,f=[],g=0,h=a.length;h>g;g++)d=a[g],d.style&&(f[g]=L.get(d,"olddisplay"),c=d.style.display,b?(f[g]||"none"!==c||(d.style.display=""),""===d.style.display&&S(d)&&(f[g]=L.access(d,"olddisplay",ta(d.nodeName)))):(e=S(d),"none"===c&&e||L.set(d,"olddisplay",e?c:n.css(d,"display"))));for(g=0;h>g;g++)d=a[g],d.style&&(b&&"none"!==d.style.display&&""!==d.style.display||(d.style.display=b?f[g]||"":"none"));return a}n.extend({cssHooks:{opacity:{get:function(a,b){if(b){var c=xa(a,"opacity");return""===c?"1":c}}}},cssNumber:{columnCount:!0,fillOpacity:!0,flexGrow:!0,flexShrink:!0,fontWeight:!0,lineHeight:!0,opacity:!0,order:!0,orphans:!0,widows:!0,zIndex:!0,zoom:!0},cssProps:{"float":"cssFloat"},style:function(a,b,c,d){if(a&&3!==a.nodeType&&8!==a.nodeType&&a.style){var e,f,g,h=n.camelCase(b),i=a.style;return b=n.cssProps[h]||(n.cssProps[h]=Fa(i,h)),g=n.cssHooks[b]||n.cssHooks[h],void 0===c?g&&"get"in g&&void 0!==(e=g.get(a,!1,d))?e:i[b]:(f=typeof c,"string"===f&&(e=Ba.exec(c))&&(c=(e[1]+1)*e[2]+parseFloat(n.css(a,b)),f="number"),null!=c&&c===c&&("number"!==f||n.cssNumber[h]||(c+="px"),k.clearCloneStyle||""!==c||0!==b.indexOf("background")||(i[b]="inherit"),g&&"set"in g&&void 0===(c=g.set(a,c,d))||(i[b]=c)),void 0)}},css:function(a,b,c,d){var e,f,g,h=n.camelCase(b);return b=n.cssProps[h]||(n.cssProps[h]=Fa(a.style,h)),g=n.cssHooks[b]||n.cssHooks[h],g&&"get"in g&&(e=g.get(a,!0,c)),void 0===e&&(e=xa(a,b,d)),"normal"===e&&b in Da&&(e=Da[b]),""===c||c?(f=parseFloat(e),c===!0||n.isNumeric(f)?f||0:e):e}}),n.each(["height","width"],function(a,b){n.cssHooks[b]={get:function(a,c,d){return c?za.test(n.css(a,"display"))&&0===a.offsetWidth?n.swap(a,Ca,function(){return Ia(a,b,d)}):Ia(a,b,d):void 0},set:function(a,c,d){var e=d&&wa(a);return Ga(a,c,d?Ha(a,b,d,"border-box"===n.css(a,"boxSizing",!1,e),e):0)}}}),n.cssHooks.marginRight=ya(k.reliableMarginRight,function(a,b){return b?n.swap(a,{display:"inline-block"},xa,[a,"marginRight"]):void 0}),n.each({margin:"",padding:"",border:"Width"},function(a,b){n.cssHooks[a+b]={expand:function(c){for(var d=0,e={},f="string"==typeof c?c.split(" "):[c];4>d;d++)e[a+R[d]+b]=f[d]||f[d-2]||f[0];return e}},ua.test(a)||(n.cssHooks[a+b].set=Ga)}),n.fn.extend({css:function(a,b){return J(this,function(a,b,c){var d,e,f={},g=0;if(n.isArray(b)){for(d=wa(a),e=b.length;e>g;g++)f[b[g]]=n.css(a,b[g],!1,d);return f}return void 0!==c?n.style(a,b,c):n.css(a,b)},a,b,arguments.length>1)},show:function(){return Ja(this,!0)},hide:function(){return Ja(this)},toggle:function(a){return"boolean"==typeof a?a?this.show():this.hide():this.each(function(){S(this)?n(this).show():n(this).hide()})}});function Ka(a,b,c,d,e){return new Ka.prototype.init(a,b,c,d,e)}n.Tween=Ka,Ka.prototype={constructor:Ka,init:function(a,b,c,d,e,f){this.elem=a,this.prop=c,this.easing=e||"swing",this.options=b,this.start=this.now=this.cur(),this.end=d,this.unit=f||(n.cssNumber[c]?"":"px")},cur:function(){var a=Ka.propHooks[this.prop];return a&&a.get?a.get(this):Ka.propHooks._default.get(this)},run:function(a){var b,c=Ka.propHooks[this.prop];return this.options.duration?this.pos=b=n.easing[this.easing](a,this.options.duration*a,0,1,this.options.duration):this.pos=b=a,this.now=(this.end-this.start)*b+this.start,this.options.step&&this.options.step.call(this.elem,this.now,this),c&&c.set?c.set(this):Ka.propHooks._default.set(this),this}},Ka.prototype.init.prototype=Ka.prototype,Ka.propHooks={_default:{get:function(a){var b;return null==a.elem[a.prop]||a.elem.style&&null!=a.elem.style[a.prop]?(b=n.css(a.elem,a.prop,""),b&&"auto"!==b?b:0):a.elem[a.prop]},set:function(a){n.fx.step[a.prop]?n.fx.step[a.prop](a):a.elem.style&&(null!=a.elem.style[n.cssProps[a.prop]]||n.cssHooks[a.prop])?n.style(a.elem,a.prop,a.now+a.unit):a.elem[a.prop]=a.now}}},Ka.propHooks.scrollTop=Ka.propHooks.scrollLeft={set:function(a){a.elem.nodeType&&a.elem.parentNode&&(a.elem[a.prop]=a.now)}},n.easing={linear:function(a){return a},swing:function(a){return.5-Math.cos(a*Math.PI)/2}},n.fx=Ka.prototype.init,n.fx.step={};var La,Ma,Na=/^(?:toggle|show|hide)$/,Oa=new RegExp("^(?:([+-])=|)("+Q+")([a-z%]*)$","i"),Pa=/queueHooks$/,Qa=[Va],Ra={"*":[function(a,b){var c=this.createTween(a,b),d=c.cur(),e=Oa.exec(b),f=e&&e[3]||(n.cssNumber[a]?"":"px"),g=(n.cssNumber[a]||"px"!==f&&+d)&&Oa.exec(n.css(c.elem,a)),h=1,i=20;if(g&&g[3]!==f){f=f||g[3],e=e||[],g=+d||1;do h=h||".5",g/=h,n.style(c.elem,a,g+f);while(h!==(h=c.cur()/d)&&1!==h&&--i)}return e&&(g=c.start=+g||+d||0,c.unit=f,c.end=e[1]?g+(e[1]+1)*e[2]:+e[2]),c}]};function Sa(){return setTimeout(function(){La=void 0}),La=n.now()}function Ta(a,b){var c,d=0,e={height:a};for(b=b?1:0;4>d;d+=2-b)c=R[d],e["margin"+c]=e["padding"+c]=a;return b&&(e.opacity=e.width=a),e}function Ua(a,b,c){for(var d,e=(Ra[b]||[]).concat(Ra["*"]),f=0,g=e.length;g>f;f++)if(d=e[f].call(c,b,a))return d}function Va(a,b,c){var d,e,f,g,h,i,j,k,l=this,m={},o=a.style,p=a.nodeType&&S(a),q=L.get(a,"fxshow");c.queue||(h=n._queueHooks(a,"fx"),null==h.unqueued&&(h.unqueued=0,i=h.empty.fire,h.empty.fire=function(){h.unqueued||i()}),h.unqueued++,l.always(function(){l.always(function(){h.unqueued--,n.queue(a,"fx").length||h.empty.fire()})})),1===a.nodeType&&("height"in b||"width"in b)&&(c.overflow=[o.overflow,o.overflowX,o.overflowY],j=n.css(a,"display"),k="none"===j?L.get(a,"olddisplay")||ta(a.nodeName):j,"inline"===k&&"none"===n.css(a,"float")&&(o.display="inline-block")),c.overflow&&(o.overflow="hidden",l.always(function(){o.overflow=c.overflow[0],o.overflowX=c.overflow[1],o.overflowY=c.overflow[2]}));for(d in b)if(e=b[d],Na.exec(e)){if(delete b[d],f=f||"toggle"===e,e===(p?"hide":"show")){if("show"!==e||!q||void 0===q[d])continue;p=!0}m[d]=q&&q[d]||n.style(a,d)}else j=void 0;if(n.isEmptyObject(m))"inline"===("none"===j?ta(a.nodeName):j)&&(o.display=j);else{q?"hidden"in q&&(p=q.hidden):q=L.access(a,"fxshow",{}),f&&(q.hidden=!p),p?n(a).show():l.done(function(){n(a).hide()}),l.done(function(){var b;L.remove(a,"fxshow");for(b in m)n.style(a,b,m[b])});for(d in m)g=Ua(p?q[d]:0,d,l),d in q||(q[d]=g.start,p&&(g.end=g.start,g.start="width"===d||"height"===d?1:0))}}function Wa(a,b){var c,d,e,f,g;for(c in a)if(d=n.camelCase(c),e=b[d],f=a[c],n.isArray(f)&&(e=f[1],f=a[c]=f[0]),c!==d&&(a[d]=f,delete a[c]),g=n.cssHooks[d],g&&"expand"in g){f=g.expand(f),delete a[d];for(c in f)c in a||(a[c]=f[c],b[c]=e)}else b[d]=e}function Xa(a,b,c){var d,e,f=0,g=Qa.length,h=n.Deferred().always(function(){delete i.elem}),i=function(){if(e)return!1;for(var b=La||Sa(),c=Math.max(0,j.startTime+j.duration-b),d=c/j.duration||0,f=1-d,g=0,i=j.tweens.length;i>g;g++)j.tweens[g].run(f);return h.notifyWith(a,[j,f,c]),1>f&&i?c:(h.resolveWith(a,[j]),!1)},j=h.promise({elem:a,props:n.extend({},b),opts:n.extend(!0,{specialEasing:{}},c),originalProperties:b,originalOptions:c,startTime:La||Sa(),duration:c.duration,tweens:[],createTween:function(b,c){var d=n.Tween(a,j.opts,b,c,j.opts.specialEasing[b]||j.opts.easing);return j.tweens.push(d),d},stop:function(b){var c=0,d=b?j.tweens.length:0;if(e)return this;for(e=!0;d>c;c++)j.tweens[c].run(1);return b?h.resolveWith(a,[j,b]):h.rejectWith(a,[j,b]),this}}),k=j.props;for(Wa(k,j.opts.specialEasing);g>f;f++)if(d=Qa[f].call(j,a,k,j.opts))return d;return n.map(k,Ua,j),n.isFunction(j.opts.start)&&j.opts.start.call(a,j),n.fx.timer(n.extend(i,{elem:a,anim:j,queue:j.opts.queue})),j.progress(j.opts.progress).done(j.opts.done,j.opts.complete).fail(j.opts.fail).always(j.opts.always)}n.Animation=n.extend(Xa,{tweener:function(a,b){n.isFunction(a)?(b=a,a=["*"]):a=a.split(" ");for(var c,d=0,e=a.length;e>d;d++)c=a[d],Ra[c]=Ra[c]||[],Ra[c].unshift(b)},prefilter:function(a,b){b?Qa.unshift(a):Qa.push(a)}}),n.speed=function(a,b,c){var d=a&&"object"==typeof a?n.extend({},a):{complete:c||!c&&b||n.isFunction(a)&&a,duration:a,easing:c&&b||b&&!n.isFunction(b)&&b};return d.duration=n.fx.off?0:"number"==typeof d.duration?d.duration:d.duration in n.fx.speeds?n.fx.speeds[d.duration]:n.fx.speeds._default,(null==d.queue||d.queue===!0)&&(d.queue="fx"),d.old=d.complete,d.complete=function(){n.isFunction(d.old)&&d.old.call(this),d.queue&&n.dequeue(this,d.queue)},d},n.fn.extend({fadeTo:function(a,b,c,d){return this.filter(S).css("opacity",0).show().end().animate({opacity:b},a,c,d)},animate:function(a,b,c,d){var e=n.isEmptyObject(a),f=n.speed(b,c,d),g=function(){var b=Xa(this,n.extend({},a),f);(e||L.get(this,"finish"))&&b.stop(!0)};return g.finish=g,e||f.queue===!1?this.each(g):this.queue(f.queue,g)},stop:function(a,b,c){var d=function(a){var b=a.stop;delete a.stop,b(c)};return"string"!=typeof a&&(c=b,b=a,a=void 0),b&&a!==!1&&this.queue(a||"fx",[]),this.each(function(){var b=!0,e=null!=a&&a+"queueHooks",f=n.timers,g=L.get(this);if(e)g[e]&&g[e].stop&&d(g[e]);else for(e in g)g[e]&&g[e].stop&&Pa.test(e)&&d(g[e]);for(e=f.length;e--;)f[e].elem!==this||null!=a&&f[e].queue!==a||(f[e].anim.stop(c),b=!1,f.splice(e,1));(b||!c)&&n.dequeue(this,a)})},finish:function(a){return a!==!1&&(a=a||"fx"),this.each(function(){var b,c=L.get(this),d=c[a+"queue"],e=c[a+"queueHooks"],f=n.timers,g=d?d.length:0;for(c.finish=!0,n.queue(this,a,[]),e&&e.stop&&e.stop.call(this,!0),b=f.length;b--;)f[b].elem===this&&f[b].queue===a&&(f[b].anim.stop(!0),f.splice(b,1));for(b=0;g>b;b++)d[b]&&d[b].finish&&d[b].finish.call(this);delete c.finish})}}),n.each(["toggle","show","hide"],function(a,b){var c=n.fn[b];n.fn[b]=function(a,d,e){return null==a||"boolean"==typeof a?c.apply(this,arguments):this.animate(Ta(b,!0),a,d,e)}}),n.each({slideDown:Ta("show"),slideUp:Ta("hide"),slideToggle:Ta("toggle"),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"},fadeToggle:{opacity:"toggle"}},function(a,b){n.fn[a]=function(a,c,d){return this.animate(b,a,c,d)}}),n.timers=[],n.fx.tick=function(){var a,b=0,c=n.timers;for(La=n.now();b<c.length;b++)a=c[b],a()||c[b]!==a||c.splice(b--,1);c.length||n.fx.stop(),La=void 0},n.fx.timer=function(a){n.timers.push(a),a()?n.fx.start():n.timers.pop()},n.fx.interval=13,n.fx.start=function(){Ma||(Ma=setInterval(n.fx.tick,n.fx.interval))},n.fx.stop=function(){clearInterval(Ma),Ma=null},n.fx.speeds={slow:600,fast:200,_default:400},n.fn.delay=function(a,b){return a=n.fx?n.fx.speeds[a]||a:a,b=b||"fx",this.queue(b,function(b,c){var d=setTimeout(b,a);c.stop=function(){clearTimeout(d)}})},function(){var a=l.createElement("input"),b=l.createElement("select"),c=b.appendChild(l.createElement("option"));a.type="checkbox",k.checkOn=""!==a.value,k.optSelected=c.selected,b.disabled=!0,k.optDisabled=!c.disabled,a=l.createElement("input"),a.value="t",a.type="radio",k.radioValue="t"===a.value}();var Ya,Za,$a=n.expr.attrHandle;n.fn.extend({attr:function(a,b){return J(this,n.attr,a,b,arguments.length>1)},removeAttr:function(a){return this.each(function(){n.removeAttr(this,a)})}}),n.extend({attr:function(a,b,c){var d,e,f=a.nodeType;if(a&&3!==f&&8!==f&&2!==f)return typeof a.getAttribute===U?n.prop(a,b,c):(1===f&&n.isXMLDoc(a)||(b=b.toLowerCase(),d=n.attrHooks[b]||(n.expr.match.bool.test(b)?Za:Ya)),
void 0===c?d&&"get"in d&&null!==(e=d.get(a,b))?e:(e=n.find.attr(a,b),null==e?void 0:e):null!==c?d&&"set"in d&&void 0!==(e=d.set(a,c,b))?e:(a.setAttribute(b,c+""),c):void n.removeAttr(a,b))},removeAttr:function(a,b){var c,d,e=0,f=b&&b.match(E);if(f&&1===a.nodeType)while(c=f[e++])d=n.propFix[c]||c,n.expr.match.bool.test(c)&&(a[d]=!1),a.removeAttribute(c)},attrHooks:{type:{set:function(a,b){if(!k.radioValue&&"radio"===b&&n.nodeName(a,"input")){var c=a.value;return a.setAttribute("type",b),c&&(a.value=c),b}}}}}),Za={set:function(a,b,c){return b===!1?n.removeAttr(a,c):a.setAttribute(c,c),c}},n.each(n.expr.match.bool.source.match(/\w+/g),function(a,b){var c=$a[b]||n.find.attr;$a[b]=function(a,b,d){var e,f;return d||(f=$a[b],$a[b]=e,e=null!=c(a,b,d)?b.toLowerCase():null,$a[b]=f),e}});var _a=/^(?:input|select|textarea|button)$/i;n.fn.extend({prop:function(a,b){return J(this,n.prop,a,b,arguments.length>1)},removeProp:function(a){return this.each(function(){delete this[n.propFix[a]||a]})}}),n.extend({propFix:{"for":"htmlFor","class":"className"},prop:function(a,b,c){var d,e,f,g=a.nodeType;if(a&&3!==g&&8!==g&&2!==g)return f=1!==g||!n.isXMLDoc(a),f&&(b=n.propFix[b]||b,e=n.propHooks[b]),void 0!==c?e&&"set"in e&&void 0!==(d=e.set(a,c,b))?d:a[b]=c:e&&"get"in e&&null!==(d=e.get(a,b))?d:a[b]},propHooks:{tabIndex:{get:function(a){return a.hasAttribute("tabindex")||_a.test(a.nodeName)||a.href?a.tabIndex:-1}}}}),k.optSelected||(n.propHooks.selected={get:function(a){var b=a.parentNode;return b&&b.parentNode&&b.parentNode.selectedIndex,null}}),n.each(["tabIndex","readOnly","maxLength","cellSpacing","cellPadding","rowSpan","colSpan","useMap","frameBorder","contentEditable"],function(){n.propFix[this.toLowerCase()]=this});var ab=/[\t\r\n\f]/g;n.fn.extend({addClass:function(a){var b,c,d,e,f,g,h="string"==typeof a&&a,i=0,j=this.length;if(n.isFunction(a))return this.each(function(b){n(this).addClass(a.call(this,b,this.className))});if(h)for(b=(a||"").match(E)||[];j>i;i++)if(c=this[i],d=1===c.nodeType&&(c.className?(" "+c.className+" ").replace(ab," "):" ")){f=0;while(e=b[f++])d.indexOf(" "+e+" ")<0&&(d+=e+" ");g=n.trim(d),c.className!==g&&(c.className=g)}return this},removeClass:function(a){var b,c,d,e,f,g,h=0===arguments.length||"string"==typeof a&&a,i=0,j=this.length;if(n.isFunction(a))return this.each(function(b){n(this).removeClass(a.call(this,b,this.className))});if(h)for(b=(a||"").match(E)||[];j>i;i++)if(c=this[i],d=1===c.nodeType&&(c.className?(" "+c.className+" ").replace(ab," "):"")){f=0;while(e=b[f++])while(d.indexOf(" "+e+" ")>=0)d=d.replace(" "+e+" "," ");g=a?n.trim(d):"",c.className!==g&&(c.className=g)}return this},toggleClass:function(a,b){var c=typeof a;return"boolean"==typeof b&&"string"===c?b?this.addClass(a):this.removeClass(a):this.each(n.isFunction(a)?function(c){n(this).toggleClass(a.call(this,c,this.className,b),b)}:function(){if("string"===c){var b,d=0,e=n(this),f=a.match(E)||[];while(b=f[d++])e.hasClass(b)?e.removeClass(b):e.addClass(b)}else(c===U||"boolean"===c)&&(this.className&&L.set(this,"__className__",this.className),this.className=this.className||a===!1?"":L.get(this,"__className__")||"")})},hasClass:function(a){for(var b=" "+a+" ",c=0,d=this.length;d>c;c++)if(1===this[c].nodeType&&(" "+this[c].className+" ").replace(ab," ").indexOf(b)>=0)return!0;return!1}});var bb=/\r/g;n.fn.extend({val:function(a){var b,c,d,e=this[0];{if(arguments.length)return d=n.isFunction(a),this.each(function(c){var e;1===this.nodeType&&(e=d?a.call(this,c,n(this).val()):a,null==e?e="":"number"==typeof e?e+="":n.isArray(e)&&(e=n.map(e,function(a){return null==a?"":a+""})),b=n.valHooks[this.type]||n.valHooks[this.nodeName.toLowerCase()],b&&"set"in b&&void 0!==b.set(this,e,"value")||(this.value=e))});if(e)return b=n.valHooks[e.type]||n.valHooks[e.nodeName.toLowerCase()],b&&"get"in b&&void 0!==(c=b.get(e,"value"))?c:(c=e.value,"string"==typeof c?c.replace(bb,""):null==c?"":c)}}}),n.extend({valHooks:{option:{get:function(a){var b=n.find.attr(a,"value");return null!=b?b:n.trim(n.text(a))}},select:{get:function(a){for(var b,c,d=a.options,e=a.selectedIndex,f="select-one"===a.type||0>e,g=f?null:[],h=f?e+1:d.length,i=0>e?h:f?e:0;h>i;i++)if(c=d[i],!(!c.selected&&i!==e||(k.optDisabled?c.disabled:null!==c.getAttribute("disabled"))||c.parentNode.disabled&&n.nodeName(c.parentNode,"optgroup"))){if(b=n(c).val(),f)return b;g.push(b)}return g},set:function(a,b){var c,d,e=a.options,f=n.makeArray(b),g=e.length;while(g--)d=e[g],(d.selected=n.inArray(d.value,f)>=0)&&(c=!0);return c||(a.selectedIndex=-1),f}}}}),n.each(["radio","checkbox"],function(){n.valHooks[this]={set:function(a,b){return n.isArray(b)?a.checked=n.inArray(n(a).val(),b)>=0:void 0}},k.checkOn||(n.valHooks[this].get=function(a){return null===a.getAttribute("value")?"on":a.value})}),n.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error contextmenu".split(" "),function(a,b){n.fn[b]=function(a,c){return arguments.length>0?this.on(b,null,a,c):this.trigger(b)}}),n.fn.extend({hover:function(a,b){return this.mouseenter(a).mouseleave(b||a)},bind:function(a,b,c){return this.on(a,null,b,c)},unbind:function(a,b){return this.off(a,null,b)},delegate:function(a,b,c,d){return this.on(b,a,c,d)},undelegate:function(a,b,c){return 1===arguments.length?this.off(a,"**"):this.off(b,a||"**",c)}});var cb=n.now(),db=/\?/;n.parseJSON=function(a){return JSON.parse(a+"")},n.parseXML=function(a){var b,c;if(!a||"string"!=typeof a)return null;try{c=new DOMParser,b=c.parseFromString(a,"text/xml")}catch(d){b=void 0}return(!b||b.getElementsByTagName("parsererror").length)&&n.error("Invalid XML: "+a),b};var eb=/#.*$/,fb=/([?&])_=[^&]*/,gb=/^(.*?):[ \t]*([^\r\n]*)$/gm,hb=/^(?:about|app|app-storage|.+-extension|file|res|widget):$/,ib=/^(?:GET|HEAD)$/,jb=/^\/\//,kb=/^([\w.+-]+:)(?:\/\/(?:[^\/?#]*@|)([^\/?#:]*)(?::(\d+)|)|)/,lb={},mb={},nb="*/".concat("*"),ob=a.location.href,pb=kb.exec(ob.toLowerCase())||[];function qb(a){return function(b,c){"string"!=typeof b&&(c=b,b="*");var d,e=0,f=b.toLowerCase().match(E)||[];if(n.isFunction(c))while(d=f[e++])"+"===d[0]?(d=d.slice(1)||"*",(a[d]=a[d]||[]).unshift(c)):(a[d]=a[d]||[]).push(c)}}function rb(a,b,c,d){var e={},f=a===mb;function g(h){var i;return e[h]=!0,n.each(a[h]||[],function(a,h){var j=h(b,c,d);return"string"!=typeof j||f||e[j]?f?!(i=j):void 0:(b.dataTypes.unshift(j),g(j),!1)}),i}return g(b.dataTypes[0])||!e["*"]&&g("*")}function sb(a,b){var c,d,e=n.ajaxSettings.flatOptions||{};for(c in b)void 0!==b[c]&&((e[c]?a:d||(d={}))[c]=b[c]);return d&&n.extend(!0,a,d),a}function tb(a,b,c){var d,e,f,g,h=a.contents,i=a.dataTypes;while("*"===i[0])i.shift(),void 0===d&&(d=a.mimeType||b.getResponseHeader("Content-Type"));if(d)for(e in h)if(h[e]&&h[e].test(d)){i.unshift(e);break}if(i[0]in c)f=i[0];else{for(e in c){if(!i[0]||a.converters[e+" "+i[0]]){f=e;break}g||(g=e)}f=f||g}return f?(f!==i[0]&&i.unshift(f),c[f]):void 0}function ub(a,b,c,d){var e,f,g,h,i,j={},k=a.dataTypes.slice();if(k[1])for(g in a.converters)j[g.toLowerCase()]=a.converters[g];f=k.shift();while(f)if(a.responseFields[f]&&(c[a.responseFields[f]]=b),!i&&d&&a.dataFilter&&(b=a.dataFilter(b,a.dataType)),i=f,f=k.shift())if("*"===f)f=i;else if("*"!==i&&i!==f){if(g=j[i+" "+f]||j["* "+f],!g)for(e in j)if(h=e.split(" "),h[1]===f&&(g=j[i+" "+h[0]]||j["* "+h[0]])){g===!0?g=j[e]:j[e]!==!0&&(f=h[0],k.unshift(h[1]));break}if(g!==!0)if(g&&a["throws"])b=g(b);else try{b=g(b)}catch(l){return{state:"parsererror",error:g?l:"No conversion from "+i+" to "+f}}}return{state:"success",data:b}}n.extend({active:0,lastModified:{},etag:{},ajaxSettings:{url:ob,type:"GET",isLocal:hb.test(pb[1]),global:!0,processData:!0,async:!0,contentType:"application/x-www-form-urlencoded; charset=UTF-8",accepts:{"*":nb,text:"text/plain",html:"text/html",xml:"application/xml, text/xml",json:"application/json, text/javascript"},contents:{xml:/xml/,html:/html/,json:/json/},responseFields:{xml:"responseXML",text:"responseText",json:"responseJSON"},converters:{"* text":String,"text html":!0,"text json":n.parseJSON,"text xml":n.parseXML},flatOptions:{url:!0,context:!0}},ajaxSetup:function(a,b){return b?sb(sb(a,n.ajaxSettings),b):sb(n.ajaxSettings,a)},ajaxPrefilter:qb(lb),ajaxTransport:qb(mb),ajax:function(a,b){"object"==typeof a&&(b=a,a=void 0),b=b||{};var c,d,e,f,g,h,i,j,k=n.ajaxSetup({},b),l=k.context||k,m=k.context&&(l.nodeType||l.jquery)?n(l):n.event,o=n.Deferred(),p=n.Callbacks("once memory"),q=k.statusCode||{},r={},s={},t=0,u="canceled",v={readyState:0,getResponseHeader:function(a){var b;if(2===t){if(!f){f={};while(b=gb.exec(e))f[b[1].toLowerCase()]=b[2]}b=f[a.toLowerCase()]}return null==b?null:b},getAllResponseHeaders:function(){return 2===t?e:null},setRequestHeader:function(a,b){var c=a.toLowerCase();return t||(a=s[c]=s[c]||a,r[a]=b),this},overrideMimeType:function(a){return t||(k.mimeType=a),this},statusCode:function(a){var b;if(a)if(2>t)for(b in a)q[b]=[q[b],a[b]];else v.always(a[v.status]);return this},abort:function(a){var b=a||u;return c&&c.abort(b),x(0,b),this}};if(o.promise(v).complete=p.add,v.success=v.done,v.error=v.fail,k.url=((a||k.url||ob)+"").replace(eb,"").replace(jb,pb[1]+"//"),k.type=b.method||b.type||k.method||k.type,k.dataTypes=n.trim(k.dataType||"*").toLowerCase().match(E)||[""],null==k.crossDomain&&(h=kb.exec(k.url.toLowerCase()),k.crossDomain=!(!h||h[1]===pb[1]&&h[2]===pb[2]&&(h[3]||("http:"===h[1]?"80":"443"))===(pb[3]||("http:"===pb[1]?"80":"443")))),k.data&&k.processData&&"string"!=typeof k.data&&(k.data=n.param(k.data,k.traditional)),rb(lb,k,b,v),2===t)return v;i=n.event&&k.global,i&&0===n.active++&&n.event.trigger("ajaxStart"),k.type=k.type.toUpperCase(),k.hasContent=!ib.test(k.type),d=k.url,k.hasContent||(k.data&&(d=k.url+=(db.test(d)?"&":"?")+k.data,delete k.data),k.cache===!1&&(k.url=fb.test(d)?d.replace(fb,"$1_="+cb++):d+(db.test(d)?"&":"?")+"_="+cb++)),k.ifModified&&(n.lastModified[d]&&v.setRequestHeader("If-Modified-Since",n.lastModified[d]),n.etag[d]&&v.setRequestHeader("If-None-Match",n.etag[d])),(k.data&&k.hasContent&&k.contentType!==!1||b.contentType)&&v.setRequestHeader("Content-Type",k.contentType),v.setRequestHeader("Accept",k.dataTypes[0]&&k.accepts[k.dataTypes[0]]?k.accepts[k.dataTypes[0]]+("*"!==k.dataTypes[0]?", "+nb+"; q=0.01":""):k.accepts["*"]);for(j in k.headers)v.setRequestHeader(j,k.headers[j]);if(k.beforeSend&&(k.beforeSend.call(l,v,k)===!1||2===t))return v.abort();u="abort";for(j in{success:1,error:1,complete:1})v[j](k[j]);if(c=rb(mb,k,b,v)){v.readyState=1,i&&m.trigger("ajaxSend",[v,k]),k.async&&k.timeout>0&&(g=setTimeout(function(){v.abort("timeout")},k.timeout));try{t=1,c.send(r,x)}catch(w){if(!(2>t))throw w;x(-1,w)}}else x(-1,"No Transport");function x(a,b,f,h){var j,r,s,u,w,x=b;2!==t&&(t=2,g&&clearTimeout(g),c=void 0,e=h||"",v.readyState=a>0?4:0,j=a>=200&&300>a||304===a,f&&(u=tb(k,v,f)),u=ub(k,u,v,j),j?(k.ifModified&&(w=v.getResponseHeader("Last-Modified"),w&&(n.lastModified[d]=w),w=v.getResponseHeader("etag"),w&&(n.etag[d]=w)),204===a||"HEAD"===k.type?x="nocontent":304===a?x="notmodified":(x=u.state,r=u.data,s=u.error,j=!s)):(s=x,(a||!x)&&(x="error",0>a&&(a=0))),v.status=a,v.statusText=(b||x)+"",j?o.resolveWith(l,[r,x,v]):o.rejectWith(l,[v,x,s]),v.statusCode(q),q=void 0,i&&m.trigger(j?"ajaxSuccess":"ajaxError",[v,k,j?r:s]),p.fireWith(l,[v,x]),i&&(m.trigger("ajaxComplete",[v,k]),--n.active||n.event.trigger("ajaxStop")))}return v},getJSON:function(a,b,c){return n.get(a,b,c,"json")},getScript:function(a,b){return n.get(a,void 0,b,"script")}}),n.each(["get","post"],function(a,b){n[b]=function(a,c,d,e){return n.isFunction(c)&&(e=e||d,d=c,c=void 0),n.ajax({url:a,type:b,dataType:e,data:c,success:d})}}),n._evalUrl=function(a){return n.ajax({url:a,type:"GET",dataType:"script",async:!1,global:!1,"throws":!0})},n.fn.extend({wrapAll:function(a){var b;return n.isFunction(a)?this.each(function(b){n(this).wrapAll(a.call(this,b))}):(this[0]&&(b=n(a,this[0].ownerDocument).eq(0).clone(!0),this[0].parentNode&&b.insertBefore(this[0]),b.map(function(){var a=this;while(a.firstElementChild)a=a.firstElementChild;return a}).append(this)),this)},wrapInner:function(a){return this.each(n.isFunction(a)?function(b){n(this).wrapInner(a.call(this,b))}:function(){var b=n(this),c=b.contents();c.length?c.wrapAll(a):b.append(a)})},wrap:function(a){var b=n.isFunction(a);return this.each(function(c){n(this).wrapAll(b?a.call(this,c):a)})},unwrap:function(){return this.parent().each(function(){n.nodeName(this,"body")||n(this).replaceWith(this.childNodes)}).end()}}),n.expr.filters.hidden=function(a){return a.offsetWidth<=0&&a.offsetHeight<=0},n.expr.filters.visible=function(a){return!n.expr.filters.hidden(a)};var vb=/%20/g,wb=/\[\]$/,xb=/\r?\n/g,yb=/^(?:submit|button|image|reset|file)$/i,zb=/^(?:input|select|textarea|keygen)/i;function Ab(a,b,c,d){var e;if(n.isArray(b))n.each(b,function(b,e){c||wb.test(a)?d(a,e):Ab(a+"["+("object"==typeof e?b:"")+"]",e,c,d)});else if(c||"object"!==n.type(b))d(a,b);else for(e in b)Ab(a+"["+e+"]",b[e],c,d)}n.param=function(a,b){var c,d=[],e=function(a,b){b=n.isFunction(b)?b():null==b?"":b,d[d.length]=encodeURIComponent(a)+"="+encodeURIComponent(b)};if(void 0===b&&(b=n.ajaxSettings&&n.ajaxSettings.traditional),n.isArray(a)||a.jquery&&!n.isPlainObject(a))n.each(a,function(){e(this.name,this.value)});else for(c in a)Ab(c,a[c],b,e);return d.join("&").replace(vb,"+")},n.fn.extend({serialize:function(){return n.param(this.serializeArray())},serializeArray:function(){return this.map(function(){var a=n.prop(this,"elements");return a?n.makeArray(a):this}).filter(function(){var a=this.type;return this.name&&!n(this).is(":disabled")&&zb.test(this.nodeName)&&!yb.test(a)&&(this.checked||!T.test(a))}).map(function(a,b){var c=n(this).val();return null==c?null:n.isArray(c)?n.map(c,function(a){return{name:b.name,value:a.replace(xb,"\r\n")}}):{name:b.name,value:c.replace(xb,"\r\n")}}).get()}}),n.ajaxSettings.xhr=function(){try{return new XMLHttpRequest}catch(a){}};var Bb=0,Cb={},Db={0:200,1223:204},Eb=n.ajaxSettings.xhr();a.attachEvent&&a.attachEvent("onunload",function(){for(var a in Cb)Cb[a]()}),k.cors=!!Eb&&"withCredentials"in Eb,k.ajax=Eb=!!Eb,n.ajaxTransport(function(a){var b;return k.cors||Eb&&!a.crossDomain?{send:function(c,d){var e,f=a.xhr(),g=++Bb;if(f.open(a.type,a.url,a.async,a.username,a.password),a.xhrFields)for(e in a.xhrFields)f[e]=a.xhrFields[e];a.mimeType&&f.overrideMimeType&&f.overrideMimeType(a.mimeType),a.crossDomain||c["X-Requested-With"]||(c["X-Requested-With"]="XMLHttpRequest");for(e in c)f.setRequestHeader(e,c[e]);b=function(a){return function(){b&&(delete Cb[g],b=f.onload=f.onerror=null,"abort"===a?f.abort():"error"===a?d(f.status,f.statusText):d(Db[f.status]||f.status,f.statusText,"string"==typeof f.responseText?{text:f.responseText}:void 0,f.getAllResponseHeaders()))}},f.onload=b(),f.onerror=b("error"),b=Cb[g]=b("abort");try{f.send(a.hasContent&&a.data||null)}catch(h){if(b)throw h}},abort:function(){b&&b()}}:void 0}),n.ajaxSetup({accepts:{script:"text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"},contents:{script:/(?:java|ecma)script/},converters:{"text script":function(a){return n.globalEval(a),a}}}),n.ajaxPrefilter("script",function(a){void 0===a.cache&&(a.cache=!1),a.crossDomain&&(a.type="GET")}),n.ajaxTransport("script",function(a){if(a.crossDomain){var b,c;return{send:function(d,e){b=n("<script>").prop({async:!0,charset:a.scriptCharset,src:a.url}).on("load error",c=function(a){b.remove(),c=null,a&&e("error"===a.type?404:200,a.type)}),l.head.appendChild(b[0])},abort:function(){c&&c()}}}});var Fb=[],Gb=/(=)\?(?=&|$)|\?\?/;n.ajaxSetup({jsonp:"callback",jsonpCallback:function(){var a=Fb.pop()||n.expando+"_"+cb++;return this[a]=!0,a}}),n.ajaxPrefilter("json jsonp",function(b,c,d){var e,f,g,h=b.jsonp!==!1&&(Gb.test(b.url)?"url":"string"==typeof b.data&&!(b.contentType||"").indexOf("application/x-www-form-urlencoded")&&Gb.test(b.data)&&"data");return h||"jsonp"===b.dataTypes[0]?(e=b.jsonpCallback=n.isFunction(b.jsonpCallback)?b.jsonpCallback():b.jsonpCallback,h?b[h]=b[h].replace(Gb,"$1"+e):b.jsonp!==!1&&(b.url+=(db.test(b.url)?"&":"?")+b.jsonp+"="+e),b.converters["script json"]=function(){return g||n.error(e+" was not called"),g[0]},b.dataTypes[0]="json",f=a[e],a[e]=function(){g=arguments},d.always(function(){a[e]=f,b[e]&&(b.jsonpCallback=c.jsonpCallback,Fb.push(e)),g&&n.isFunction(f)&&f(g[0]),g=f=void 0}),"script"):void 0}),n.parseHTML=function(a,b,c){if(!a||"string"!=typeof a)return null;"boolean"==typeof b&&(c=b,b=!1),b=b||l;var d=v.exec(a),e=!c&&[];return d?[b.createElement(d[1])]:(d=n.buildFragment([a],b,e),e&&e.length&&n(e).remove(),n.merge([],d.childNodes))};var Hb=n.fn.load;n.fn.load=function(a,b,c){if("string"!=typeof a&&Hb)return Hb.apply(this,arguments);var d,e,f,g=this,h=a.indexOf(" ");return h>=0&&(d=n.trim(a.slice(h)),a=a.slice(0,h)),n.isFunction(b)?(c=b,b=void 0):b&&"object"==typeof b&&(e="POST"),g.length>0&&n.ajax({url:a,type:e,dataType:"html",data:b}).done(function(a){f=arguments,g.html(d?n("<div>").append(n.parseHTML(a)).find(d):a)}).complete(c&&function(a,b){g.each(c,f||[a.responseText,b,a])}),this},n.each(["ajaxStart","ajaxStop","ajaxComplete","ajaxError","ajaxSuccess","ajaxSend"],function(a,b){n.fn[b]=function(a){return this.on(b,a)}}),n.expr.filters.animated=function(a){return n.grep(n.timers,function(b){return a===b.elem}).length};var Ib=a.document.documentElement;function Jb(a){return n.isWindow(a)?a:9===a.nodeType&&a.defaultView}n.offset={setOffset:function(a,b,c){var d,e,f,g,h,i,j,k=n.css(a,"position"),l=n(a),m={};"static"===k&&(a.style.position="relative"),h=l.offset(),f=n.css(a,"top"),i=n.css(a,"left"),j=("absolute"===k||"fixed"===k)&&(f+i).indexOf("auto")>-1,j?(d=l.position(),g=d.top,e=d.left):(g=parseFloat(f)||0,e=parseFloat(i)||0),n.isFunction(b)&&(b=b.call(a,c,h)),null!=b.top&&(m.top=b.top-h.top+g),null!=b.left&&(m.left=b.left-h.left+e),"using"in b?b.using.call(a,m):l.css(m)}},n.fn.extend({offset:function(a){if(arguments.length)return void 0===a?this:this.each(function(b){n.offset.setOffset(this,a,b)});var b,c,d=this[0],e={top:0,left:0},f=d&&d.ownerDocument;if(f)return b=f.documentElement,n.contains(b,d)?(typeof d.getBoundingClientRect!==U&&(e=d.getBoundingClientRect()),c=Jb(f),{top:e.top+c.pageYOffset-b.clientTop,left:e.left+c.pageXOffset-b.clientLeft}):e},position:function(){if(this[0]){var a,b,c=this[0],d={top:0,left:0};return"fixed"===n.css(c,"position")?b=c.getBoundingClientRect():(a=this.offsetParent(),b=this.offset(),n.nodeName(a[0],"html")||(d=a.offset()),d.top+=n.css(a[0],"borderTopWidth",!0),d.left+=n.css(a[0],"borderLeftWidth",!0)),{top:b.top-d.top-n.css(c,"marginTop",!0),left:b.left-d.left-n.css(c,"marginLeft",!0)}}},offsetParent:function(){return this.map(function(){var a=this.offsetParent||Ib;while(a&&!n.nodeName(a,"html")&&"static"===n.css(a,"position"))a=a.offsetParent;return a||Ib})}}),n.each({scrollLeft:"pageXOffset",scrollTop:"pageYOffset"},function(b,c){var d="pageYOffset"===c;n.fn[b]=function(e){return J(this,function(b,e,f){var g=Jb(b);return void 0===f?g?g[c]:b[e]:void(g?g.scrollTo(d?a.pageXOffset:f,d?f:a.pageYOffset):b[e]=f)},b,e,arguments.length,null)}}),n.each(["top","left"],function(a,b){n.cssHooks[b]=ya(k.pixelPosition,function(a,c){return c?(c=xa(a,b),va.test(c)?n(a).position()[b]+"px":c):void 0})}),n.each({Height:"height",Width:"width"},function(a,b){n.each({padding:"inner"+a,content:b,"":"outer"+a},function(c,d){n.fn[d]=function(d,e){var f=arguments.length&&(c||"boolean"!=typeof d),g=c||(d===!0||e===!0?"margin":"border");return J(this,function(b,c,d){var e;return n.isWindow(b)?b.document.documentElement["client"+a]:9===b.nodeType?(e=b.documentElement,Math.max(b.body["scroll"+a],e["scroll"+a],b.body["offset"+a],e["offset"+a],e["client"+a])):void 0===d?n.css(b,c,g):n.style(b,c,d,g)},b,f?d:void 0,f,null)}})}),n.fn.size=function(){return this.length},n.fn.andSelf=n.fn.addBack,"function"==typeof define&&define.amd&&define("jquery",[],function(){return n});var Kb=a.jQuery,Lb=a.$;return n.noConflict=function(b){return a.$===n&&(a.$=Lb),b&&a.jQuery===n&&(a.jQuery=Kb),n},typeof b===U&&(a.jQuery=a.$=n),n});

/*!
 * Bootstrap v3.3.0 (http://getbootstrap.com)
 * Copyright 2011-2014 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */
if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");+function(a){var b=a.fn.jquery.split(" ")[0].split(".");if(b[0]<2&&b[1]<9||1==b[0]&&9==b[1]&&b[2]<1)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher")}(jQuery),+function(a){"use strict";function b(){var a=document.createElement("bootstrap"),b={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var c in b)if(void 0!==a.style[c])return{end:b[c]};return!1}a.fn.emulateTransitionEnd=function(b){var c=!1,d=this;a(this).one("bsTransitionEnd",function(){c=!0});var e=function(){c||a(d).trigger(a.support.transition.end)};return setTimeout(e,b),this},a(function(){a.support.transition=b(),a.support.transition&&(a.event.special.bsTransitionEnd={bindType:a.support.transition.end,delegateType:a.support.transition.end,handle:function(b){return a(b.target).is(this)?b.handleObj.handler.apply(this,arguments):void 0}})})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var c=a(this),e=c.data("bs.alert");e||c.data("bs.alert",e=new d(this)),"string"==typeof b&&e[b].call(c)})}var c='[data-dismiss="alert"]',d=function(b){a(b).on("click",c,this.close)};d.VERSION="3.3.0",d.TRANSITION_DURATION=150,d.prototype.close=function(b){function c(){g.detach().trigger("closed.bs.alert").remove()}var e=a(this),f=e.attr("data-target");f||(f=e.attr("href"),f=f&&f.replace(/.*(?=#[^\s]*$)/,""));var g=a(f);b&&b.preventDefault(),g.length||(g=e.closest(".alert")),g.trigger(b=a.Event("close.bs.alert")),b.isDefaultPrevented()||(g.removeClass("in"),a.support.transition&&g.hasClass("fade")?g.one("bsTransitionEnd",c).emulateTransitionEnd(d.TRANSITION_DURATION):c())};var e=a.fn.alert;a.fn.alert=b,a.fn.alert.Constructor=d,a.fn.alert.noConflict=function(){return a.fn.alert=e,this},a(document).on("click.bs.alert.data-api",c,d.prototype.close)}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.button"),f="object"==typeof b&&b;e||d.data("bs.button",e=new c(this,f)),"toggle"==b?e.toggle():b&&e.setState(b)})}var c=function(b,d){this.$element=a(b),this.options=a.extend({},c.DEFAULTS,d),this.isLoading=!1};c.VERSION="3.3.0",c.DEFAULTS={loadingText:"loading..."},c.prototype.setState=function(b){var c="disabled",d=this.$element,e=d.is("input")?"val":"html",f=d.data();b+="Text",null==f.resetText&&d.data("resetText",d[e]()),setTimeout(a.proxy(function(){d[e](null==f[b]?this.options[b]:f[b]),"loadingText"==b?(this.isLoading=!0,d.addClass(c).attr(c,c)):this.isLoading&&(this.isLoading=!1,d.removeClass(c).removeAttr(c))},this),0)},c.prototype.toggle=function(){var a=!0,b=this.$element.closest('[data-toggle="buttons"]');if(b.length){var c=this.$element.find("input");"radio"==c.prop("type")&&(c.prop("checked")&&this.$element.hasClass("active")?a=!1:b.find(".active").removeClass("active")),a&&c.prop("checked",!this.$element.hasClass("active")).trigger("change")}else this.$element.attr("aria-pressed",!this.$element.hasClass("active"));a&&this.$element.toggleClass("active")};var d=a.fn.button;a.fn.button=b,a.fn.button.Constructor=c,a.fn.button.noConflict=function(){return a.fn.button=d,this},a(document).on("click.bs.button.data-api",'[data-toggle^="button"]',function(c){var d=a(c.target);d.hasClass("btn")||(d=d.closest(".btn")),b.call(d,"toggle"),c.preventDefault()}).on("focus.bs.button.data-api blur.bs.button.data-api",'[data-toggle^="button"]',function(b){a(b.target).closest(".btn").toggleClass("focus","focus"==b.type)})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.carousel"),f=a.extend({},c.DEFAULTS,d.data(),"object"==typeof b&&b),g="string"==typeof b?b:f.slide;e||d.data("bs.carousel",e=new c(this,f)),"number"==typeof b?e.to(b):g?e[g]():f.interval&&e.pause().cycle()})}var c=function(b,c){this.$element=a(b),this.$indicators=this.$element.find(".carousel-indicators"),this.options=c,this.paused=this.sliding=this.interval=this.$active=this.$items=null,this.options.keyboard&&this.$element.on("keydown.bs.carousel",a.proxy(this.keydown,this)),"hover"==this.options.pause&&!("ontouchstart"in document.documentElement)&&this.$element.on("mouseenter.bs.carousel",a.proxy(this.pause,this)).on("mouseleave.bs.carousel",a.proxy(this.cycle,this))};c.VERSION="3.3.0",c.TRANSITION_DURATION=600,c.DEFAULTS={interval:5e3,pause:"hover",wrap:!0,keyboard:!0},c.prototype.keydown=function(a){switch(a.which){case 37:this.prev();break;case 39:this.next();break;default:return}a.preventDefault()},c.prototype.cycle=function(b){return b||(this.paused=!1),this.interval&&clearInterval(this.interval),this.options.interval&&!this.paused&&(this.interval=setInterval(a.proxy(this.next,this),this.options.interval)),this},c.prototype.getItemIndex=function(a){return this.$items=a.parent().children(".item"),this.$items.index(a||this.$active)},c.prototype.getItemForDirection=function(a,b){var c="prev"==a?-1:1,d=this.getItemIndex(b),e=(d+c)%this.$items.length;return this.$items.eq(e)},c.prototype.to=function(a){var b=this,c=this.getItemIndex(this.$active=this.$element.find(".item.active"));return a>this.$items.length-1||0>a?void 0:this.sliding?this.$element.one("slid.bs.carousel",function(){b.to(a)}):c==a?this.pause().cycle():this.slide(a>c?"next":"prev",this.$items.eq(a))},c.prototype.pause=function(b){return b||(this.paused=!0),this.$element.find(".next, .prev").length&&a.support.transition&&(this.$element.trigger(a.support.transition.end),this.cycle(!0)),this.interval=clearInterval(this.interval),this},c.prototype.next=function(){return this.sliding?void 0:this.slide("next")},c.prototype.prev=function(){return this.sliding?void 0:this.slide("prev")},c.prototype.slide=function(b,d){var e=this.$element.find(".item.active"),f=d||this.getItemForDirection(b,e),g=this.interval,h="next"==b?"left":"right",i="next"==b?"first":"last",j=this;if(!f.length){if(!this.options.wrap)return;f=this.$element.find(".item")[i]()}if(f.hasClass("active"))return this.sliding=!1;var k=f[0],l=a.Event("slide.bs.carousel",{relatedTarget:k,direction:h});if(this.$element.trigger(l),!l.isDefaultPrevented()){if(this.sliding=!0,g&&this.pause(),this.$indicators.length){this.$indicators.find(".active").removeClass("active");var m=a(this.$indicators.children()[this.getItemIndex(f)]);m&&m.addClass("active")}var n=a.Event("slid.bs.carousel",{relatedTarget:k,direction:h});return a.support.transition&&this.$element.hasClass("slide")?(f.addClass(b),f[0].offsetWidth,e.addClass(h),f.addClass(h),e.one("bsTransitionEnd",function(){f.removeClass([b,h].join(" ")).addClass("active"),e.removeClass(["active",h].join(" ")),j.sliding=!1,setTimeout(function(){j.$element.trigger(n)},0)}).emulateTransitionEnd(c.TRANSITION_DURATION)):(e.removeClass("active"),f.addClass("active"),this.sliding=!1,this.$element.trigger(n)),g&&this.cycle(),this}};var d=a.fn.carousel;a.fn.carousel=b,a.fn.carousel.Constructor=c,a.fn.carousel.noConflict=function(){return a.fn.carousel=d,this};var e=function(c){var d,e=a(this),f=a(e.attr("data-target")||(d=e.attr("href"))&&d.replace(/.*(?=#[^\s]+$)/,""));if(f.hasClass("carousel")){var g=a.extend({},f.data(),e.data()),h=e.attr("data-slide-to");h&&(g.interval=!1),b.call(f,g),h&&f.data("bs.carousel").to(h),c.preventDefault()}};a(document).on("click.bs.carousel.data-api","[data-slide]",e).on("click.bs.carousel.data-api","[data-slide-to]",e),a(window).on("load",function(){a('[data-ride="carousel"]').each(function(){var c=a(this);b.call(c,c.data())})})}(jQuery),+function(a){"use strict";function b(b){var c,d=b.attr("data-target")||(c=b.attr("href"))&&c.replace(/.*(?=#[^\s]+$)/,"");return a(d)}function c(b){return this.each(function(){var c=a(this),e=c.data("bs.collapse"),f=a.extend({},d.DEFAULTS,c.data(),"object"==typeof b&&b);!e&&f.toggle&&"show"==b&&(f.toggle=!1),e||c.data("bs.collapse",e=new d(this,f)),"string"==typeof b&&e[b]()})}var d=function(b,c){this.$element=a(b),this.options=a.extend({},d.DEFAULTS,c),this.$trigger=a(this.options.trigger).filter('[href="#'+b.id+'"], [data-target="#'+b.id+'"]'),this.transitioning=null,this.options.parent?this.$parent=this.getParent():this.addAriaAndCollapsedClass(this.$element,this.$trigger),this.options.toggle&&this.toggle()};d.VERSION="3.3.0",d.TRANSITION_DURATION=350,d.DEFAULTS={toggle:!0,trigger:'[data-toggle="collapse"]'},d.prototype.dimension=function(){var a=this.$element.hasClass("width");return a?"width":"height"},d.prototype.show=function(){if(!this.transitioning&&!this.$element.hasClass("in")){var b,e=this.$parent&&this.$parent.find("> .panel").children(".in, .collapsing");if(!(e&&e.length&&(b=e.data("bs.collapse"),b&&b.transitioning))){var f=a.Event("show.bs.collapse");if(this.$element.trigger(f),!f.isDefaultPrevented()){e&&e.length&&(c.call(e,"hide"),b||e.data("bs.collapse",null));var g=this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[g](0).attr("aria-expanded",!0),this.$trigger.removeClass("collapsed").attr("aria-expanded",!0),this.transitioning=1;var h=function(){this.$element.removeClass("collapsing").addClass("collapse in")[g](""),this.transitioning=0,this.$element.trigger("shown.bs.collapse")};if(!a.support.transition)return h.call(this);var i=a.camelCase(["scroll",g].join("-"));this.$element.one("bsTransitionEnd",a.proxy(h,this)).emulateTransitionEnd(d.TRANSITION_DURATION)[g](this.$element[0][i])}}}},d.prototype.hide=function(){if(!this.transitioning&&this.$element.hasClass("in")){var b=a.Event("hide.bs.collapse");if(this.$element.trigger(b),!b.isDefaultPrevented()){var c=this.dimension();this.$element[c](this.$element[c]())[0].offsetHeight,this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded",!1),this.$trigger.addClass("collapsed").attr("aria-expanded",!1),this.transitioning=1;var e=function(){this.transitioning=0,this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")};return a.support.transition?void this.$element[c](0).one("bsTransitionEnd",a.proxy(e,this)).emulateTransitionEnd(d.TRANSITION_DURATION):e.call(this)}}},d.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()},d.prototype.getParent=function(){return a(this.options.parent).find('[data-toggle="collapse"][data-parent="'+this.options.parent+'"]').each(a.proxy(function(c,d){var e=a(d);this.addAriaAndCollapsedClass(b(e),e)},this)).end()},d.prototype.addAriaAndCollapsedClass=function(a,b){var c=a.hasClass("in");a.attr("aria-expanded",c),b.toggleClass("collapsed",!c).attr("aria-expanded",c)};var e=a.fn.collapse;a.fn.collapse=c,a.fn.collapse.Constructor=d,a.fn.collapse.noConflict=function(){return a.fn.collapse=e,this},a(document).on("click.bs.collapse.data-api",'[data-toggle="collapse"]',function(d){var e=a(this);e.attr("data-target")||d.preventDefault();var f=b(e),g=f.data("bs.collapse"),h=g?"toggle":a.extend({},e.data(),{trigger:this});c.call(f,h)})}(jQuery),+function(a){"use strict";function b(b){b&&3===b.which||(a(e).remove(),a(f).each(function(){var d=a(this),e=c(d),f={relatedTarget:this};e.hasClass("open")&&(e.trigger(b=a.Event("hide.bs.dropdown",f)),b.isDefaultPrevented()||(d.attr("aria-expanded","false"),e.removeClass("open").trigger("hidden.bs.dropdown",f)))}))}function c(b){var c=b.attr("data-target");c||(c=b.attr("href"),c=c&&/#[A-Za-z]/.test(c)&&c.replace(/.*(?=#[^\s]*$)/,""));var d=c&&a(c);return d&&d.length?d:b.parent()}function d(b){return this.each(function(){var c=a(this),d=c.data("bs.dropdown");d||c.data("bs.dropdown",d=new g(this)),"string"==typeof b&&d[b].call(c)})}var e=".dropdown-backdrop",f='[data-toggle="dropdown"]',g=function(b){a(b).on("click.bs.dropdown",this.toggle)};g.VERSION="3.3.0",g.prototype.toggle=function(d){var e=a(this);if(!e.is(".disabled, :disabled")){var f=c(e),g=f.hasClass("open");if(b(),!g){"ontouchstart"in document.documentElement&&!f.closest(".navbar-nav").length&&a('<div class="dropdown-backdrop"/>').insertAfter(a(this)).on("click",b);var h={relatedTarget:this};if(f.trigger(d=a.Event("show.bs.dropdown",h)),d.isDefaultPrevented())return;e.trigger("focus").attr("aria-expanded","true"),f.toggleClass("open").trigger("shown.bs.dropdown",h)}return!1}},g.prototype.keydown=function(b){if(/(38|40|27|32)/.test(b.which)){var d=a(this);if(b.preventDefault(),b.stopPropagation(),!d.is(".disabled, :disabled")){var e=c(d),g=e.hasClass("open");if(!g&&27!=b.which||g&&27==b.which)return 27==b.which&&e.find(f).trigger("focus"),d.trigger("click");var h=" li:not(.divider):visible a",i=e.find('[role="menu"]'+h+', [role="listbox"]'+h);if(i.length){var j=i.index(b.target);38==b.which&&j>0&&j--,40==b.which&&j<i.length-1&&j++,~j||(j=0),i.eq(j).trigger("focus")}}}};var h=a.fn.dropdown;a.fn.dropdown=d,a.fn.dropdown.Constructor=g,a.fn.dropdown.noConflict=function(){return a.fn.dropdown=h,this},a(document).on("click.bs.dropdown.data-api",b).on("click.bs.dropdown.data-api",".dropdown form",function(a){a.stopPropagation()}).on("click.bs.dropdown.data-api",f,g.prototype.toggle).on("keydown.bs.dropdown.data-api",f,g.prototype.keydown).on("keydown.bs.dropdown.data-api",'[role="menu"]',g.prototype.keydown).on("keydown.bs.dropdown.data-api",'[role="listbox"]',g.prototype.keydown)}(jQuery),+function(a){"use strict";function b(b,d){return this.each(function(){var e=a(this),f=e.data("bs.modal"),g=a.extend({},c.DEFAULTS,e.data(),"object"==typeof b&&b);f||e.data("bs.modal",f=new c(this,g)),"string"==typeof b?f[b](d):g.show&&f.show(d)})}var c=function(b,c){this.options=c,this.$body=a(document.body),this.$element=a(b),this.$backdrop=this.isShown=null,this.scrollbarWidth=0,this.options.remote&&this.$element.find(".modal-content").load(this.options.remote,a.proxy(function(){this.$element.trigger("loaded.bs.modal")},this))};c.VERSION="3.3.0",c.TRANSITION_DURATION=300,c.BACKDROP_TRANSITION_DURATION=150,c.DEFAULTS={backdrop:!0,keyboard:!0,show:!0},c.prototype.toggle=function(a){return this.isShown?this.hide():this.show(a)},c.prototype.show=function(b){var d=this,e=a.Event("show.bs.modal",{relatedTarget:b});this.$element.trigger(e),this.isShown||e.isDefaultPrevented()||(this.isShown=!0,this.checkScrollbar(),this.$body.addClass("modal-open"),this.setScrollbar(),this.escape(),this.$element.on("click.dismiss.bs.modal",'[data-dismiss="modal"]',a.proxy(this.hide,this)),this.backdrop(function(){var e=a.support.transition&&d.$element.hasClass("fade");d.$element.parent().length||d.$element.appendTo(d.$body),d.$element.show().scrollTop(0),e&&d.$element[0].offsetWidth,d.$element.addClass("in").attr("aria-hidden",!1),d.enforceFocus();var f=a.Event("shown.bs.modal",{relatedTarget:b});e?d.$element.find(".modal-dialog").one("bsTransitionEnd",function(){d.$element.trigger("focus").trigger(f)}).emulateTransitionEnd(c.TRANSITION_DURATION):d.$element.trigger("focus").trigger(f)}))},c.prototype.hide=function(b){b&&b.preventDefault(),b=a.Event("hide.bs.modal"),this.$element.trigger(b),this.isShown&&!b.isDefaultPrevented()&&(this.isShown=!1,this.escape(),a(document).off("focusin.bs.modal"),this.$element.removeClass("in").attr("aria-hidden",!0).off("click.dismiss.bs.modal"),a.support.transition&&this.$element.hasClass("fade")?this.$element.one("bsTransitionEnd",a.proxy(this.hideModal,this)).emulateTransitionEnd(c.TRANSITION_DURATION):this.hideModal())},c.prototype.enforceFocus=function(){a(document).off("focusin.bs.modal").on("focusin.bs.modal",a.proxy(function(a){this.$element[0]===a.target||this.$element.has(a.target).length||this.$element.trigger("focus")},this))},c.prototype.escape=function(){this.isShown&&this.options.keyboard?this.$element.on("keydown.dismiss.bs.modal",a.proxy(function(a){27==a.which&&this.hide()},this)):this.isShown||this.$element.off("keydown.dismiss.bs.modal")},c.prototype.hideModal=function(){var a=this;this.$element.hide(),this.backdrop(function(){a.$body.removeClass("modal-open"),a.resetScrollbar(),a.$element.trigger("hidden.bs.modal")})},c.prototype.removeBackdrop=function(){this.$backdrop&&this.$backdrop.remove(),this.$backdrop=null},c.prototype.backdrop=function(b){var d=this,e=this.$element.hasClass("fade")?"fade":"";if(this.isShown&&this.options.backdrop){var f=a.support.transition&&e;if(this.$backdrop=a('<div class="modal-backdrop '+e+'" />').prependTo(this.$element).on("click.dismiss.bs.modal",a.proxy(function(a){a.target===a.currentTarget&&("static"==this.options.backdrop?this.$element[0].focus.call(this.$element[0]):this.hide.call(this))},this)),f&&this.$backdrop[0].offsetWidth,this.$backdrop.addClass("in"),!b)return;f?this.$backdrop.one("bsTransitionEnd",b).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION):b()}else if(!this.isShown&&this.$backdrop){this.$backdrop.removeClass("in");var g=function(){d.removeBackdrop(),b&&b()};a.support.transition&&this.$element.hasClass("fade")?this.$backdrop.one("bsTransitionEnd",g).emulateTransitionEnd(c.BACKDROP_TRANSITION_DURATION):g()}else b&&b()},c.prototype.checkScrollbar=function(){this.scrollbarWidth=this.measureScrollbar()},c.prototype.setScrollbar=function(){var a=parseInt(this.$body.css("padding-right")||0,10);this.scrollbarWidth&&this.$body.css("padding-right",a+this.scrollbarWidth)},c.prototype.resetScrollbar=function(){this.$body.css("padding-right","")},c.prototype.measureScrollbar=function(){if(document.body.clientWidth>=window.innerWidth)return 0;var a=document.createElement("div");a.className="modal-scrollbar-measure",this.$body.append(a);var b=a.offsetWidth-a.clientWidth;return this.$body[0].removeChild(a),b};var d=a.fn.modal;a.fn.modal=b,a.fn.modal.Constructor=c,a.fn.modal.noConflict=function(){return a.fn.modal=d,this},a(document).on("click.bs.modal.data-api",'[data-toggle="modal"]',function(c){var d=a(this),e=d.attr("href"),f=a(d.attr("data-target")||e&&e.replace(/.*(?=#[^\s]+$)/,"")),g=f.data("bs.modal")?"toggle":a.extend({remote:!/#/.test(e)&&e},f.data(),d.data());d.is("a")&&c.preventDefault(),f.one("show.bs.modal",function(a){a.isDefaultPrevented()||f.one("hidden.bs.modal",function(){d.is(":visible")&&d.trigger("focus")})}),b.call(f,g,this)})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.tooltip"),f="object"==typeof b&&b,g=f&&f.selector;(e||"destroy"!=b)&&(g?(e||d.data("bs.tooltip",e={}),e[g]||(e[g]=new c(this,f))):e||d.data("bs.tooltip",e=new c(this,f)),"string"==typeof b&&e[b]())})}var c=function(a,b){this.type=this.options=this.enabled=this.timeout=this.hoverState=this.$element=null,this.init("tooltip",a,b)};c.VERSION="3.3.0",c.TRANSITION_DURATION=150,c.DEFAULTS={animation:!0,placement:"top",selector:!1,template:'<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',trigger:"hover focus",title:"",delay:0,html:!1,container:!1,viewport:{selector:"body",padding:0}},c.prototype.init=function(b,c,d){this.enabled=!0,this.type=b,this.$element=a(c),this.options=this.getOptions(d),this.$viewport=this.options.viewport&&a(this.options.viewport.selector||this.options.viewport);for(var e=this.options.trigger.split(" "),f=e.length;f--;){var g=e[f];if("click"==g)this.$element.on("click."+this.type,this.options.selector,a.proxy(this.toggle,this));else if("manual"!=g){var h="hover"==g?"mouseenter":"focusin",i="hover"==g?"mouseleave":"focusout";this.$element.on(h+"."+this.type,this.options.selector,a.proxy(this.enter,this)),this.$element.on(i+"."+this.type,this.options.selector,a.proxy(this.leave,this))}}this.options.selector?this._options=a.extend({},this.options,{trigger:"manual",selector:""}):this.fixTitle()},c.prototype.getDefaults=function(){return c.DEFAULTS},c.prototype.getOptions=function(b){return b=a.extend({},this.getDefaults(),this.$element.data(),b),b.delay&&"number"==typeof b.delay&&(b.delay={show:b.delay,hide:b.delay}),b},c.prototype.getDelegateOptions=function(){var b={},c=this.getDefaults();return this._options&&a.each(this._options,function(a,d){c[a]!=d&&(b[a]=d)}),b},c.prototype.enter=function(b){var c=b instanceof this.constructor?b:a(b.currentTarget).data("bs."+this.type);return c&&c.$tip&&c.$tip.is(":visible")?void(c.hoverState="in"):(c||(c=new this.constructor(b.currentTarget,this.getDelegateOptions()),a(b.currentTarget).data("bs."+this.type,c)),clearTimeout(c.timeout),c.hoverState="in",c.options.delay&&c.options.delay.show?void(c.timeout=setTimeout(function(){"in"==c.hoverState&&c.show()},c.options.delay.show)):c.show())},c.prototype.leave=function(b){var c=b instanceof this.constructor?b:a(b.currentTarget).data("bs."+this.type);return c||(c=new this.constructor(b.currentTarget,this.getDelegateOptions()),a(b.currentTarget).data("bs."+this.type,c)),clearTimeout(c.timeout),c.hoverState="out",c.options.delay&&c.options.delay.hide?void(c.timeout=setTimeout(function(){"out"==c.hoverState&&c.hide()},c.options.delay.hide)):c.hide()},c.prototype.show=function(){var b=a.Event("show.bs."+this.type);if(this.hasContent()&&this.enabled){this.$element.trigger(b);var d=a.contains(this.$element[0].ownerDocument.documentElement,this.$element[0]);if(b.isDefaultPrevented()||!d)return;var e=this,f=this.tip(),g=this.getUID(this.type);this.setContent(),f.attr("id",g),this.$element.attr("aria-describedby",g),this.options.animation&&f.addClass("fade");var h="function"==typeof this.options.placement?this.options.placement.call(this,f[0],this.$element[0]):this.options.placement,i=/\s?auto?\s?/i,j=i.test(h);j&&(h=h.replace(i,"")||"top"),f.detach().css({top:0,left:0,display:"block"}).addClass(h).data("bs."+this.type,this),this.options.container?f.appendTo(this.options.container):f.insertAfter(this.$element);var k=this.getPosition(),l=f[0].offsetWidth,m=f[0].offsetHeight;if(j){var n=h,o=this.options.container?a(this.options.container):this.$element.parent(),p=this.getPosition(o);h="bottom"==h&&k.bottom+m>p.bottom?"top":"top"==h&&k.top-m<p.top?"bottom":"right"==h&&k.right+l>p.width?"left":"left"==h&&k.left-l<p.left?"right":h,f.removeClass(n).addClass(h)}var q=this.getCalculatedOffset(h,k,l,m);this.applyPlacement(q,h);var r=function(){var a=e.hoverState;e.$element.trigger("shown.bs."+e.type),e.hoverState=null,"out"==a&&e.leave(e)};a.support.transition&&this.$tip.hasClass("fade")?f.one("bsTransitionEnd",r).emulateTransitionEnd(c.TRANSITION_DURATION):r()}},c.prototype.applyPlacement=function(b,c){var d=this.tip(),e=d[0].offsetWidth,f=d[0].offsetHeight,g=parseInt(d.css("margin-top"),10),h=parseInt(d.css("margin-left"),10);isNaN(g)&&(g=0),isNaN(h)&&(h=0),b.top=b.top+g,b.left=b.left+h,a.offset.setOffset(d[0],a.extend({using:function(a){d.css({top:Math.round(a.top),left:Math.round(a.left)})}},b),0),d.addClass("in");var i=d[0].offsetWidth,j=d[0].offsetHeight;"top"==c&&j!=f&&(b.top=b.top+f-j);var k=this.getViewportAdjustedDelta(c,b,i,j);k.left?b.left+=k.left:b.top+=k.top;var l=/top|bottom/.test(c),m=l?2*k.left-e+i:2*k.top-f+j,n=l?"offsetWidth":"offsetHeight";d.offset(b),this.replaceArrow(m,d[0][n],l)},c.prototype.replaceArrow=function(a,b,c){this.arrow().css(c?"left":"top",50*(1-a/b)+"%").css(c?"top":"left","")},c.prototype.setContent=function(){var a=this.tip(),b=this.getTitle();a.find(".tooltip-inner")[this.options.html?"html":"text"](b),a.removeClass("fade in top bottom left right")},c.prototype.hide=function(b){function d(){"in"!=e.hoverState&&f.detach(),e.$element.removeAttr("aria-describedby").trigger("hidden.bs."+e.type),b&&b()}var e=this,f=this.tip(),g=a.Event("hide.bs."+this.type);return this.$element.trigger(g),g.isDefaultPrevented()?void 0:(f.removeClass("in"),a.support.transition&&this.$tip.hasClass("fade")?f.one("bsTransitionEnd",d).emulateTransitionEnd(c.TRANSITION_DURATION):d(),this.hoverState=null,this)},c.prototype.fixTitle=function(){var a=this.$element;(a.attr("title")||"string"!=typeof a.attr("data-original-title"))&&a.attr("data-original-title",a.attr("title")||"").attr("title","")},c.prototype.hasContent=function(){return this.getTitle()},c.prototype.getPosition=function(b){b=b||this.$element;var c=b[0],d="BODY"==c.tagName,e=c.getBoundingClientRect();null==e.width&&(e=a.extend({},e,{width:e.right-e.left,height:e.bottom-e.top}));var f=d?{top:0,left:0}:b.offset(),g={scroll:d?document.documentElement.scrollTop||document.body.scrollTop:b.scrollTop()},h=d?{width:a(window).width(),height:a(window).height()}:null;return a.extend({},e,g,h,f)},c.prototype.getCalculatedOffset=function(a,b,c,d){return"bottom"==a?{top:b.top+b.height,left:b.left+b.width/2-c/2}:"top"==a?{top:b.top-d,left:b.left+b.width/2-c/2}:"left"==a?{top:b.top+b.height/2-d/2,left:b.left-c}:{top:b.top+b.height/2-d/2,left:b.left+b.width}},c.prototype.getViewportAdjustedDelta=function(a,b,c,d){var e={top:0,left:0};if(!this.$viewport)return e;var f=this.options.viewport&&this.options.viewport.padding||0,g=this.getPosition(this.$viewport);if(/right|left/.test(a)){var h=b.top-f-g.scroll,i=b.top+f-g.scroll+d;h<g.top?e.top=g.top-h:i>g.top+g.height&&(e.top=g.top+g.height-i)}else{var j=b.left-f,k=b.left+f+c;j<g.left?e.left=g.left-j:k>g.width&&(e.left=g.left+g.width-k)}return e},c.prototype.getTitle=function(){var a,b=this.$element,c=this.options;return a=b.attr("data-original-title")||("function"==typeof c.title?c.title.call(b[0]):c.title)},c.prototype.getUID=function(a){do a+=~~(1e6*Math.random());while(document.getElementById(a));return a},c.prototype.tip=function(){return this.$tip=this.$tip||a(this.options.template)},c.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".tooltip-arrow")},c.prototype.enable=function(){this.enabled=!0},c.prototype.disable=function(){this.enabled=!1},c.prototype.toggleEnabled=function(){this.enabled=!this.enabled},c.prototype.toggle=function(b){var c=this;b&&(c=a(b.currentTarget).data("bs."+this.type),c||(c=new this.constructor(b.currentTarget,this.getDelegateOptions()),a(b.currentTarget).data("bs."+this.type,c))),c.tip().hasClass("in")?c.leave(c):c.enter(c)},c.prototype.destroy=function(){var a=this;clearTimeout(this.timeout),this.hide(function(){a.$element.off("."+a.type).removeData("bs."+a.type)})};var d=a.fn.tooltip;a.fn.tooltip=b,a.fn.tooltip.Constructor=c,a.fn.tooltip.noConflict=function(){return a.fn.tooltip=d,this}}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.popover"),f="object"==typeof b&&b,g=f&&f.selector;(e||"destroy"!=b)&&(g?(e||d.data("bs.popover",e={}),e[g]||(e[g]=new c(this,f))):e||d.data("bs.popover",e=new c(this,f)),"string"==typeof b&&e[b]())})}var c=function(a,b){this.init("popover",a,b)};if(!a.fn.tooltip)throw new Error("Popover requires tooltip.js");c.VERSION="3.3.0",c.DEFAULTS=a.extend({},a.fn.tooltip.Constructor.DEFAULTS,{placement:"right",trigger:"click",content:"",template:'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'}),c.prototype=a.extend({},a.fn.tooltip.Constructor.prototype),c.prototype.constructor=c,c.prototype.getDefaults=function(){return c.DEFAULTS},c.prototype.setContent=function(){var a=this.tip(),b=this.getTitle(),c=this.getContent();a.find(".popover-title")[this.options.html?"html":"text"](b),a.find(".popover-content").children().detach().end()[this.options.html?"string"==typeof c?"html":"append":"text"](c),a.removeClass("fade top bottom left right in"),a.find(".popover-title").html()||a.find(".popover-title").hide()},c.prototype.hasContent=function(){return this.getTitle()||this.getContent()},c.prototype.getContent=function(){var a=this.$element,b=this.options;return a.attr("data-content")||("function"==typeof b.content?b.content.call(a[0]):b.content)},c.prototype.arrow=function(){return this.$arrow=this.$arrow||this.tip().find(".arrow")},c.prototype.tip=function(){return this.$tip||(this.$tip=a(this.options.template)),this.$tip};var d=a.fn.popover;a.fn.popover=b,a.fn.popover.Constructor=c,a.fn.popover.noConflict=function(){return a.fn.popover=d,this}}(jQuery),+function(a){"use strict";function b(c,d){var e=a.proxy(this.process,this);this.$body=a("body"),this.$scrollElement=a(a(c).is("body")?window:c),this.options=a.extend({},b.DEFAULTS,d),this.selector=(this.options.target||"")+" .nav li > a",this.offsets=[],this.targets=[],this.activeTarget=null,this.scrollHeight=0,this.$scrollElement.on("scroll.bs.scrollspy",e),this.refresh(),this.process()}function c(c){return this.each(function(){var d=a(this),e=d.data("bs.scrollspy"),f="object"==typeof c&&c;e||d.data("bs.scrollspy",e=new b(this,f)),"string"==typeof c&&e[c]()})}b.VERSION="3.3.0",b.DEFAULTS={offset:10},b.prototype.getScrollHeight=function(){return this.$scrollElement[0].scrollHeight||Math.max(this.$body[0].scrollHeight,document.documentElement.scrollHeight)},b.prototype.refresh=function(){var b="offset",c=0;a.isWindow(this.$scrollElement[0])||(b="position",c=this.$scrollElement.scrollTop()),this.offsets=[],this.targets=[],this.scrollHeight=this.getScrollHeight();var d=this;this.$body.find(this.selector).map(function(){var d=a(this),e=d.data("target")||d.attr("href"),f=/^#./.test(e)&&a(e);return f&&f.length&&f.is(":visible")&&[[f[b]().top+c,e]]||null}).sort(function(a,b){return a[0]-b[0]}).each(function(){d.offsets.push(this[0]),d.targets.push(this[1])})},b.prototype.process=function(){var a,b=this.$scrollElement.scrollTop()+this.options.offset,c=this.getScrollHeight(),d=this.options.offset+c-this.$scrollElement.height(),e=this.offsets,f=this.targets,g=this.activeTarget;if(this.scrollHeight!=c&&this.refresh(),b>=d)return g!=(a=f[f.length-1])&&this.activate(a);if(g&&b<e[0])return this.activeTarget=null,this.clear();for(a=e.length;a--;)g!=f[a]&&b>=e[a]&&(!e[a+1]||b<=e[a+1])&&this.activate(f[a])},b.prototype.activate=function(b){this.activeTarget=b,this.clear();var c=this.selector+'[data-target="'+b+'"],'+this.selector+'[href="'+b+'"]',d=a(c).parents("li").addClass("active");d.parent(".dropdown-menu").length&&(d=d.closest("li.dropdown").addClass("active")),d.trigger("activate.bs.scrollspy")},b.prototype.clear=function(){a(this.selector).parentsUntil(this.options.target,".active").removeClass("active")};var d=a.fn.scrollspy;a.fn.scrollspy=c,a.fn.scrollspy.Constructor=b,a.fn.scrollspy.noConflict=function(){return a.fn.scrollspy=d,this},a(window).on("load.bs.scrollspy.data-api",function(){a('[data-spy="scroll"]').each(function(){var b=a(this);c.call(b,b.data())})})}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.tab");e||d.data("bs.tab",e=new c(this)),"string"==typeof b&&e[b]()})}var c=function(b){this.element=a(b)};c.VERSION="3.3.0",c.TRANSITION_DURATION=150,c.prototype.show=function(){var b=this.element,c=b.closest("ul:not(.dropdown-menu)"),d=b.data("target");if(d||(d=b.attr("href"),d=d&&d.replace(/.*(?=#[^\s]*$)/,"")),!b.parent("li").hasClass("active")){var e=c.find(".active:last a"),f=a.Event("hide.bs.tab",{relatedTarget:b[0]}),g=a.Event("show.bs.tab",{relatedTarget:e[0]});if(e.trigger(f),b.trigger(g),!g.isDefaultPrevented()&&!f.isDefaultPrevented()){var h=a(d);this.activate(b.closest("li"),c),this.activate(h,h.parent(),function(){e.trigger({type:"hidden.bs.tab",relatedTarget:b[0]}),b.trigger({type:"shown.bs.tab",relatedTarget:e[0]})})}}},c.prototype.activate=function(b,d,e){function f(){g.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!1),b.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded",!0),h?(b[0].offsetWidth,b.addClass("in")):b.removeClass("fade"),b.parent(".dropdown-menu")&&b.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!0),e&&e()}var g=d.find("> .active"),h=e&&a.support.transition&&(g.length&&g.hasClass("fade")||!!d.find("> .fade").length);g.length&&h?g.one("bsTransitionEnd",f).emulateTransitionEnd(c.TRANSITION_DURATION):f(),g.removeClass("in")};var d=a.fn.tab;a.fn.tab=b,a.fn.tab.Constructor=c,a.fn.tab.noConflict=function(){return a.fn.tab=d,this};var e=function(c){c.preventDefault(),b.call(a(this),"show")};a(document).on("click.bs.tab.data-api",'[data-toggle="tab"]',e).on("click.bs.tab.data-api",'[data-toggle="pill"]',e)
}(jQuery),+function(a){"use strict";function b(b){return this.each(function(){var d=a(this),e=d.data("bs.affix"),f="object"==typeof b&&b;e||d.data("bs.affix",e=new c(this,f)),"string"==typeof b&&e[b]()})}var c=function(b,d){this.options=a.extend({},c.DEFAULTS,d),this.$target=a(this.options.target).on("scroll.bs.affix.data-api",a.proxy(this.checkPosition,this)).on("click.bs.affix.data-api",a.proxy(this.checkPositionWithEventLoop,this)),this.$element=a(b),this.affixed=this.unpin=this.pinnedOffset=null,this.checkPosition()};c.VERSION="3.3.0",c.RESET="affix affix-top affix-bottom",c.DEFAULTS={offset:0,target:window},c.prototype.getState=function(a,b,c,d){var e=this.$target.scrollTop(),f=this.$element.offset(),g=this.$target.height();if(null!=c&&"top"==this.affixed)return c>e?"top":!1;if("bottom"==this.affixed)return null!=c?e+this.unpin<=f.top?!1:"bottom":a-d>=e+g?!1:"bottom";var h=null==this.affixed,i=h?e:f.top,j=h?g:b;return null!=c&&c>=i?"top":null!=d&&i+j>=a-d?"bottom":!1},c.prototype.getPinnedOffset=function(){if(this.pinnedOffset)return this.pinnedOffset;this.$element.removeClass(c.RESET).addClass("affix");var a=this.$target.scrollTop(),b=this.$element.offset();return this.pinnedOffset=b.top-a},c.prototype.checkPositionWithEventLoop=function(){setTimeout(a.proxy(this.checkPosition,this),1)},c.prototype.checkPosition=function(){if(this.$element.is(":visible")){var b=this.$element.height(),d=this.options.offset,e=d.top,f=d.bottom,g=a("body").height();"object"!=typeof d&&(f=e=d),"function"==typeof e&&(e=d.top(this.$element)),"function"==typeof f&&(f=d.bottom(this.$element));var h=this.getState(g,b,e,f);if(this.affixed!=h){null!=this.unpin&&this.$element.css("top","");var i="affix"+(h?"-"+h:""),j=a.Event(i+".bs.affix");if(this.$element.trigger(j),j.isDefaultPrevented())return;this.affixed=h,this.unpin="bottom"==h?this.getPinnedOffset():null,this.$element.removeClass(c.RESET).addClass(i).trigger(i.replace("affix","affixed")+".bs.affix")}"bottom"==h&&this.$element.offset({top:g-b-f})}};var d=a.fn.affix;a.fn.affix=b,a.fn.affix.Constructor=c,a.fn.affix.noConflict=function(){return a.fn.affix=d,this},a(window).on("load",function(){a('[data-spy="affix"]').each(function(){var c=a(this),d=c.data();d.offset=d.offset||{},null!=d.offsetBottom&&(d.offset.bottom=d.offsetBottom),null!=d.offsetTop&&(d.offset.top=d.offsetTop),b.call(c,d)})})}(jQuery);
/*
 * metismenu - v1.1.3
 * Easy menu jQuery plugin for Twitter Bootstrap 3
 * https://github.com/onokumus/metisMenu
 *
 * Made by Osman Nuri Okumus
 * Under MIT License
 */
;(function($, window, document, undefined) {

    var pluginName = "metisMenu",
        defaults = {
            toggle: true,
            doubleTapToGo: false
        };

    function Plugin(element, options) {
        this.element = $(element);
        this.settings = $.extend({}, defaults, options);
        this._defaults = defaults;
        this._name = pluginName;
        this.init();
    }

    Plugin.prototype = {
        init: function() {

            var $this = this.element,
                $toggle = this.settings.toggle,
                obj = this;

            if (this.isIE() <= 9) {
                $this.find("li.active").has("ul").children("ul").collapse("show");
                $this.find("li").not(".active").has("ul").children("ul").collapse("hide");
            } else {
                $this.find("li.active").has("ul").children("ul").addClass("collapse in");
                $this.find("li").not(".active").has("ul").children("ul").addClass("collapse");
            }

            //add the "doubleTapToGo" class to active items if needed
            if (obj.settings.doubleTapToGo) {
                $this.find("li.active").has("ul").children("a").addClass("doubleTapToGo");
            }

            $this.find("li").has("ul").children("a").on("click" + "." + pluginName, function(e) {
                e.preventDefault();

                //Do we need to enable the double tap
                if (obj.settings.doubleTapToGo) {

                    //if we hit a second time on the link and the href is valid, navigate to that url
                    if (obj.doubleTapToGo($(this)) && $(this).attr("href") !== "#" && $(this).attr("href") !== "") {
                        e.stopPropagation();
                        document.location = $(this).attr("href");
                        return;
                    }
                }

                $(this).parent("li").toggleClass("active").children("ul").collapse("toggle");

                if ($toggle) {
                    $(this).parent("li").siblings().removeClass("active").children("ul.in").collapse("hide");
                }

            });
        },

        isIE: function() { //https://gist.github.com/padolsey/527683
            var undef,
                v = 3,
                div = document.createElement("div"),
                all = div.getElementsByTagName("i");

            while (
                div.innerHTML = "<!--[if gt IE " + (++v) + "]><i></i><![endif]-->",
                    all[0]
                ) {
                return v > 4 ? v : undef;
            }
        },

        //Enable the link on the second click.
        doubleTapToGo: function(elem) {
            var $this = this.element;

            //if the class "doubleTapToGo" exists, remove it and return
            if (elem.hasClass("doubleTapToGo")) {
                elem.removeClass("doubleTapToGo");
                return true;
            }

            //does not exists, add a new class and return false
            if (elem.parent().children("ul").length) {
                //first remove all other class
                $this.find(".doubleTapToGo").removeClass("doubleTapToGo");
                //add the class on the current element
                elem.addClass("doubleTapToGo");
                return false;
            }
        },

        remove: function() {
            this.element.off("." + pluginName);
            this.element.removeData(pluginName);
        }

    };

    $.fn[pluginName] = function(options) {
        this.each(function () {
            var el = $(this);
            if (el.data(pluginName)) {
                el.data(pluginName).remove();
            }
            el.data(pluginName, new Plugin(this, options));
        });
        return this;
    };

})(jQuery, window, document);
/*! Copyright (c) 2011 Piotr Rochala (http://rocha.la)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Version: 1.3.0
 *
 */
(function(f){jQuery.fn.extend({slimScroll:function(h){var a=f.extend({width:"auto",height:"250px",size:"7px",color:"#000",position:"right",distance:"1px",start:"top",opacity:0.4,alwaysVisible:!1,disableFadeOut:!1,railVisible:!1,railColor:"#333",railOpacity:0.2,railDraggable:!0,railClass:"slimScrollRail",barClass:"slimScrollBar",wrapperClass:"slimScrollDiv",allowPageScroll:!1,wheelStep:20,touchScrollStep:200,borderRadius:"7px",railBorderRadius:"7px"},h);this.each(function(){function r(d){if(s){d=d||
window.event;var c=0;d.wheelDelta&&(c=-d.wheelDelta/120);d.detail&&(c=d.detail/3);f(d.target||d.srcTarget||d.srcElement).closest("."+a.wrapperClass).is(b.parent())&&m(c,!0);d.preventDefault&&!k&&d.preventDefault();k||(d.returnValue=!1)}}function m(d,f,h){k=!1;var e=d,g=b.outerHeight()-c.outerHeight();f&&(e=parseInt(c.css("top"))+d*parseInt(a.wheelStep)/100*c.outerHeight(),e=Math.min(Math.max(e,0),g),e=0<d?Math.ceil(e):Math.floor(e),c.css({top:e+"px"}));l=parseInt(c.css("top"))/(b.outerHeight()-c.outerHeight());
e=l*(b[0].scrollHeight-b.outerHeight());h&&(e=d,d=e/b[0].scrollHeight*b.outerHeight(),d=Math.min(Math.max(d,0),g),c.css({top:d+"px"}));b.scrollTop(e);b.trigger("slimscrolling",~~e);v();p()}function C(){window.addEventListener?(this.addEventListener("DOMMouseScroll",r,!1),this.addEventListener("mousewheel",r,!1),this.addEventListener("MozMousePixelScroll",r,!1)):document.attachEvent("onmousewheel",r)}function w(){u=Math.max(b.outerHeight()/b[0].scrollHeight*b.outerHeight(),D);c.css({height:u+"px"});
var a=u==b.outerHeight()?"none":"block";c.css({display:a})}function v(){w();clearTimeout(A);l==~~l?(k=a.allowPageScroll,B!=l&&b.trigger("slimscroll",0==~~l?"top":"bottom")):k=!1;B=l;u>=b.outerHeight()?k=!0:(c.stop(!0,!0).fadeIn("fast"),a.railVisible&&g.stop(!0,!0).fadeIn("fast"))}function p(){a.alwaysVisible||(A=setTimeout(function(){a.disableFadeOut&&s||(x||y)||(c.fadeOut("slow"),g.fadeOut("slow"))},1E3))}var s,x,y,A,z,u,l,B,D=30,k=!1,b=f(this);if(b.parent().hasClass(a.wrapperClass)){var n=b.scrollTop(),
c=b.parent().find("."+a.barClass),g=b.parent().find("."+a.railClass);w();if(f.isPlainObject(h)){if("height"in h&&"auto"==h.height){b.parent().css("height","auto");b.css("height","auto");var q=b.parent().parent().height();b.parent().css("height",q);b.css("height",q)}if("scrollTo"in h)n=parseInt(a.scrollTo);else if("scrollBy"in h)n+=parseInt(a.scrollBy);else if("destroy"in h){c.remove();g.remove();b.unwrap();return}m(n,!1,!0)}}else{a.height="auto"==a.height?b.parent().height():a.height;n=f("<div></div>").addClass(a.wrapperClass).css({position:"relative",
overflow:"hidden",width:a.width,height:a.height});b.css({overflow:"hidden",width:a.width,height:a.height});var g=f("<div></div>").addClass(a.railClass).css({width:a.size,height:"100%",position:"absolute",top:0,display:a.alwaysVisible&&a.railVisible?"block":"none","border-radius":a.railBorderRadius,background:a.railColor,opacity:a.railOpacity,zIndex:90}),c=f("<div></div>").addClass(a.barClass).css({background:a.color,width:a.size,position:"absolute",top:0,opacity:a.opacity,display:a.alwaysVisible?
"block":"none","border-radius":a.borderRadius,BorderRadius:a.borderRadius,MozBorderRadius:a.borderRadius,WebkitBorderRadius:a.borderRadius,zIndex:99}),q="right"==a.position?{right:a.distance}:{left:a.distance};g.css(q);c.css(q);b.wrap(n);b.parent().append(c);b.parent().append(g);a.railDraggable&&c.bind("mousedown",function(a){var b=f(document);y=!0;t=parseFloat(c.css("top"));pageY=a.pageY;b.bind("mousemove.slimscroll",function(a){currTop=t+a.pageY-pageY;c.css("top",currTop);m(0,c.position().top,!1)});
b.bind("mouseup.slimscroll",function(a){y=!1;p();b.unbind(".slimscroll")});return!1}).bind("selectstart.slimscroll",function(a){a.stopPropagation();a.preventDefault();return!1});g.hover(function(){v()},function(){p()});c.hover(function(){x=!0},function(){x=!1});b.hover(function(){s=!0;v();p()},function(){s=!1;p()});b.bind("touchstart",function(a,b){a.originalEvent.touches.length&&(z=a.originalEvent.touches[0].pageY)});b.bind("touchmove",function(b){k||b.originalEvent.preventDefault();b.originalEvent.touches.length&&
(m((z-b.originalEvent.touches[0].pageY)/a.touchScrollStep,!0),z=b.originalEvent.touches[0].pageY)});w();"bottom"===a.start?(c.css({top:b.outerHeight()-c.outerHeight()}),m(0,!0)):"top"!==a.start&&(m(f(a.start).position().top,null,!0),a.alwaysVisible||c.hide());C()}});return this}});jQuery.fn.extend({slimscroll:jQuery.fn.slimScroll})})(jQuery);
/**
 * jQuery EasyUI 1.4.5
 * 
 * Copyright (c) 2009-2016 www.jeasyui.com. All rights reserved.
 *
 * Licensed under the freeware license: http://www.jeasyui.com/license_freeware.php
 * To use it on other terms please contact us: info@jeasyui.com
 *
 */
(function($){
$.easyui={indexOfArray:function(a,o,id){
for(var i=0,_1=a.length;i<_1;i++){
if(id==undefined){
if(a[i]==o){
return i;
}
}else{
if(a[i][o]==id){
return i;
}
}
}
return -1;
},removeArrayItem:function(a,o,id){
if(typeof o=="string"){
for(var i=0,_2=a.length;i<_2;i++){
if(a[i][o]==id){
a.splice(i,1);
return;
}
}
}else{
var _3=this.indexOfArray(a,o);
if(_3!=-1){
a.splice(_3,1);
}
}
},addArrayItem:function(a,o,r){
var _4=this.indexOfArray(a,o,r?r[o]:undefined);
if(_4==-1){
a.push(r?r:o);
}else{
a[_4]=r?r:o;
}
},getArrayItem:function(a,o,id){
var _5=this.indexOfArray(a,o,id);
return _5==-1?null:a[_5];
},forEach:function(_6,_7,_8){
var _9=[];
for(var i=0;i<_6.length;i++){
_9.push(_6[i]);
}
while(_9.length){
var _a=_9.shift();
if(_8(_a)==false){
return;
}
if(_7&&_a.children){
for(var i=_a.children.length-1;i>=0;i--){
_9.unshift(_a.children[i]);
}
}
}
}};
$.parser={auto:true,onComplete:function(_b){
},plugins:["draggable","droppable","resizable","pagination","tooltip","linkbutton","menu","menubutton","splitbutton","switchbutton","progressbar","tree","textbox","filebox","combo","combobox","combotree","combogrid","numberbox","validatebox","searchbox","spinner","numberspinner","timespinner","datetimespinner","calendar","datebox","datetimebox","slider","layout","panel","datagrid","propertygrid","treegrid","datalist","tabs","accordion","window","dialog","form"],parse:function(_c){
var aa=[];
for(var i=0;i<$.parser.plugins.length;i++){
var _d=$.parser.plugins[i];
var r=$(".easyui-"+_d,_c);
if(r.length){
if(r[_d]){
r.each(function(){
$(this)[_d]($.data(this,"options")||{});
});
}else{
aa.push({name:_d,jq:r});
}
}
}
if(aa.length&&window.easyloader){
var _e=[];
for(var i=0;i<aa.length;i++){
_e.push(aa[i].name);
}
easyloader.load(_e,function(){
for(var i=0;i<aa.length;i++){
var _f=aa[i].name;
var jq=aa[i].jq;
jq.each(function(){
$(this)[_f]($.data(this,"options")||{});
});
}
$.parser.onComplete.call($.parser,_c);
});
}else{
$.parser.onComplete.call($.parser,_c);
}
},parseValue:function(_10,_11,_12,_13){
_13=_13||0;
var v=$.trim(String(_11||""));
var _14=v.substr(v.length-1,1);
if(_14=="%"){
v=parseInt(v.substr(0,v.length-1));
if(_10.toLowerCase().indexOf("width")>=0){
v=Math.floor((_12.width()-_13)*v/100);
}else{
v=Math.floor((_12.height()-_13)*v/100);
}
}else{
v=parseInt(v)||undefined;
}
return v;
},parseOptions:function(_15,_16){
var t=$(_15);
var _17={};
var s=$.trim(t.attr("data-options"));
if(s){
if(s.substring(0,1)!="{"){
s="{"+s+"}";
}
_17=(new Function("return "+s))();
}
$.map(["width","height","left","top","minWidth","maxWidth","minHeight","maxHeight"],function(p){
var pv=$.trim(_15.style[p]||"");
if(pv){
if(pv.indexOf("%")==-1){
pv=parseInt(pv);
if(isNaN(pv)){
pv=undefined;
}
}
_17[p]=pv;
}
});
if(_16){
var _18={};
for(var i=0;i<_16.length;i++){
var pp=_16[i];
if(typeof pp=="string"){
_18[pp]=t.attr(pp);
}else{
for(var _19 in pp){
var _1a=pp[_19];
if(_1a=="boolean"){
_18[_19]=t.attr(_19)?(t.attr(_19)=="true"):undefined;
}else{
if(_1a=="number"){
_18[_19]=t.attr(_19)=="0"?0:parseFloat(t.attr(_19))||undefined;
}
}
}
}
}
$.extend(_17,_18);
}
return _17;
}};
$(function(){
var d=$("<div style=\"position:absolute;top:-1000px;width:100px;height:100px;padding:5px\"></div>").appendTo("body");
$._boxModel=d.outerWidth()!=100;
d.remove();
d=$("<div style=\"position:fixed\"></div>").appendTo("body");
$._positionFixed=(d.css("position")=="fixed");
d.remove();
if(!window.easyloader&&$.parser.auto){
$.parser.parse();
}
});
$.fn._outerWidth=function(_1b){
if(_1b==undefined){
if(this[0]==window){
return this.width()||document.body.clientWidth;
}
return this.outerWidth()||0;
}
return this._size("width",_1b);
};
$.fn._outerHeight=function(_1c){
if(_1c==undefined){
if(this[0]==window){
return this.height()||document.body.clientHeight;
}
return this.outerHeight()||0;
}
return this._size("height",_1c);
};
$.fn._scrollLeft=function(_1d){
if(_1d==undefined){
return this.scrollLeft();
}else{
return this.each(function(){
$(this).scrollLeft(_1d);
});
}
};
$.fn._propAttr=$.fn.prop||$.fn.attr;
$.fn._size=function(_1e,_1f){
if(typeof _1e=="string"){
if(_1e=="clear"){
return this.each(function(){
$(this).css({width:"",minWidth:"",maxWidth:"",height:"",minHeight:"",maxHeight:""});
});
}else{
if(_1e=="fit"){
return this.each(function(){
_20(this,this.tagName=="BODY"?$("body"):$(this).parent(),true);
});
}else{
if(_1e=="unfit"){
return this.each(function(){
_20(this,$(this).parent(),false);
});
}else{
if(_1f==undefined){
return _21(this[0],_1e);
}else{
return this.each(function(){
_21(this,_1e,_1f);
});
}
}
}
}
}else{
return this.each(function(){
_1f=_1f||$(this).parent();
$.extend(_1e,_20(this,_1f,_1e.fit)||{});
var r1=_22(this,"width",_1f,_1e);
var r2=_22(this,"height",_1f,_1e);
if(r1||r2){
$(this).addClass("easyui-fluid");
}else{
$(this).removeClass("easyui-fluid");
}
});
}
function _20(_23,_24,fit){
if(!_24.length){
return false;
}
var t=$(_23)[0];
var p=_24[0];
var _25=p.fcount||0;
if(fit){
if(!t.fitted){
t.fitted=true;
p.fcount=_25+1;
$(p).addClass("panel-noscroll");
if(p.tagName=="BODY"){
$("html").addClass("panel-fit");
}
}
return {width:($(p).width()||1),height:($(p).height()||1)};
}else{
if(t.fitted){
t.fitted=false;
p.fcount=_25-1;
if(p.fcount==0){
$(p).removeClass("panel-noscroll");
if(p.tagName=="BODY"){
$("html").removeClass("panel-fit");
}
}
}
return false;
}
};
function _22(_26,_27,_28,_29){
var t=$(_26);
var p=_27;
var p1=p.substr(0,1).toUpperCase()+p.substr(1);
var min=$.parser.parseValue("min"+p1,_29["min"+p1],_28);
var max=$.parser.parseValue("max"+p1,_29["max"+p1],_28);
var val=$.parser.parseValue(p,_29[p],_28);
var _2a=(String(_29[p]||"").indexOf("%")>=0?true:false);
if(!isNaN(val)){
var v=Math.min(Math.max(val,min||0),max||99999);
if(!_2a){
_29[p]=v;
}
t._size("min"+p1,"");
t._size("max"+p1,"");
t._size(p,v);
}else{
t._size(p,"");
t._size("min"+p1,min);
t._size("max"+p1,max);
}
return _2a||_29.fit;
};
function _21(_2b,_2c,_2d){
var t=$(_2b);
if(_2d==undefined){
_2d=parseInt(_2b.style[_2c]);
if(isNaN(_2d)){
return undefined;
}
if($._boxModel){
_2d+=_2e();
}
return _2d;
}else{
if(_2d===""){
t.css(_2c,"");
}else{
if($._boxModel){
_2d-=_2e();
if(_2d<0){
_2d=0;
}
}
t.css(_2c,_2d+"px");
}
}
function _2e(){
if(_2c.toLowerCase().indexOf("width")>=0){
return t.outerWidth()-t.width();
}else{
return t.outerHeight()-t.height();
}
};
};
};
})(jQuery);
(function($){
var _2f=null;
var _30=null;
var _31=false;
function _32(e){
if(e.touches.length!=1){
return;
}
if(!_31){
_31=true;
dblClickTimer=setTimeout(function(){
_31=false;
},500);
}else{
clearTimeout(dblClickTimer);
_31=false;
_33(e,"dblclick");
}
_2f=setTimeout(function(){
_33(e,"contextmenu",3);
},1000);
_33(e,"mousedown");
if($.fn.draggable.isDragging||$.fn.resizable.isResizing){
e.preventDefault();
}
};
function _34(e){
if(e.touches.length!=1){
return;
}
if(_2f){
clearTimeout(_2f);
}
_33(e,"mousemove");
if($.fn.draggable.isDragging||$.fn.resizable.isResizing){
e.preventDefault();
}
};
function _35(e){
if(_2f){
clearTimeout(_2f);
}
_33(e,"mouseup");
if($.fn.draggable.isDragging||$.fn.resizable.isResizing){
e.preventDefault();
}
};
function _33(e,_36,_37){
var _38=new $.Event(_36);
_38.pageX=e.changedTouches[0].pageX;
_38.pageY=e.changedTouches[0].pageY;
_38.which=_37||1;
$(e.target).trigger(_38);
};
if(document.addEventListener){
document.addEventListener("touchstart",_32,true);
document.addEventListener("touchmove",_34,true);
document.addEventListener("touchend",_35,true);
}
})(jQuery);
(function($){
function _39(e){
var _3a=$.data(e.data.target,"draggable");
var _3b=_3a.options;
var _3c=_3a.proxy;
var _3d=e.data;
var _3e=_3d.startLeft+e.pageX-_3d.startX;
var top=_3d.startTop+e.pageY-_3d.startY;
if(_3c){
if(_3c.parent()[0]==document.body){
if(_3b.deltaX!=null&&_3b.deltaX!=undefined){
_3e=e.pageX+_3b.deltaX;
}else{
_3e=e.pageX-e.data.offsetWidth;
}
if(_3b.deltaY!=null&&_3b.deltaY!=undefined){
top=e.pageY+_3b.deltaY;
}else{
top=e.pageY-e.data.offsetHeight;
}
}else{
if(_3b.deltaX!=null&&_3b.deltaX!=undefined){
_3e+=e.data.offsetWidth+_3b.deltaX;
}
if(_3b.deltaY!=null&&_3b.deltaY!=undefined){
top+=e.data.offsetHeight+_3b.deltaY;
}
}
}
if(e.data.parent!=document.body){
_3e+=$(e.data.parent).scrollLeft();
top+=$(e.data.parent).scrollTop();
}
if(_3b.axis=="h"){
_3d.left=_3e;
}else{
if(_3b.axis=="v"){
_3d.top=top;
}else{
_3d.left=_3e;
_3d.top=top;
}
}
};
function _3f(e){
var _40=$.data(e.data.target,"draggable");
var _41=_40.options;
var _42=_40.proxy;
if(!_42){
_42=$(e.data.target);
}
_42.css({left:e.data.left,top:e.data.top});
$("body").css("cursor",_41.cursor);
};
function _43(e){
if(!$.fn.draggable.isDragging){
return false;
}
var _44=$.data(e.data.target,"draggable");
var _45=_44.options;
var _46=$(".droppable").filter(function(){
return e.data.target!=this;
}).filter(function(){
var _47=$.data(this,"droppable").options.accept;
if(_47){
return $(_47).filter(function(){
return this==e.data.target;
}).length>0;
}else{
return true;
}
});
_44.droppables=_46;
var _48=_44.proxy;
if(!_48){
if(_45.proxy){
if(_45.proxy=="clone"){
_48=$(e.data.target).clone().insertAfter(e.data.target);
}else{
_48=_45.proxy.call(e.data.target,e.data.target);
}
_44.proxy=_48;
}else{
_48=$(e.data.target);
}
}
_48.css("position","absolute");
_39(e);
_3f(e);
_45.onStartDrag.call(e.data.target,e);
return false;
};
function _49(e){
if(!$.fn.draggable.isDragging){
return false;
}
var _4a=$.data(e.data.target,"draggable");
_39(e);
if(_4a.options.onDrag.call(e.data.target,e)!=false){
_3f(e);
}
var _4b=e.data.target;
_4a.droppables.each(function(){
var _4c=$(this);
if(_4c.droppable("options").disabled){
return;
}
var p2=_4c.offset();
if(e.pageX>p2.left&&e.pageX<p2.left+_4c.outerWidth()&&e.pageY>p2.top&&e.pageY<p2.top+_4c.outerHeight()){
if(!this.entered){
$(this).trigger("_dragenter",[_4b]);
this.entered=true;
}
$(this).trigger("_dragover",[_4b]);
}else{
if(this.entered){
$(this).trigger("_dragleave",[_4b]);
this.entered=false;
}
}
});
return false;
};
function _4d(e){
if(!$.fn.draggable.isDragging){
_4e();
return false;
}
_49(e);
var _4f=$.data(e.data.target,"draggable");
var _50=_4f.proxy;
var _51=_4f.options;
if(_51.revert){
if(_52()==true){
$(e.data.target).css({position:e.data.startPosition,left:e.data.startLeft,top:e.data.startTop});
}else{
if(_50){
var _53,top;
if(_50.parent()[0]==document.body){
_53=e.data.startX-e.data.offsetWidth;
top=e.data.startY-e.data.offsetHeight;
}else{
_53=e.data.startLeft;
top=e.data.startTop;
}
_50.animate({left:_53,top:top},function(){
_54();
});
}else{
$(e.data.target).animate({left:e.data.startLeft,top:e.data.startTop},function(){
$(e.data.target).css("position",e.data.startPosition);
});
}
}
}else{
$(e.data.target).css({position:"absolute",left:e.data.left,top:e.data.top});
_52();
}
_51.onStopDrag.call(e.data.target,e);
_4e();
function _54(){
if(_50){
_50.remove();
}
_4f.proxy=null;
};
function _52(){
var _55=false;
_4f.droppables.each(function(){
var _56=$(this);
if(_56.droppable("options").disabled){
return;
}
var p2=_56.offset();
if(e.pageX>p2.left&&e.pageX<p2.left+_56.outerWidth()&&e.pageY>p2.top&&e.pageY<p2.top+_56.outerHeight()){
if(_51.revert){
$(e.data.target).css({position:e.data.startPosition,left:e.data.startLeft,top:e.data.startTop});
}
$(this).trigger("_drop",[e.data.target]);
_54();
_55=true;
this.entered=false;
return false;
}
});
if(!_55&&!_51.revert){
_54();
}
return _55;
};
return false;
};
function _4e(){
if($.fn.draggable.timer){
clearTimeout($.fn.draggable.timer);
$.fn.draggable.timer=undefined;
}
$(document).unbind(".draggable");
$.fn.draggable.isDragging=false;
setTimeout(function(){
$("body").css("cursor","");
},100);
};
$.fn.draggable=function(_57,_58){
if(typeof _57=="string"){
return $.fn.draggable.methods[_57](this,_58);
}
return this.each(function(){
var _59;
var _5a=$.data(this,"draggable");
if(_5a){
_5a.handle.unbind(".draggable");
_59=$.extend(_5a.options,_57);
}else{
_59=$.extend({},$.fn.draggable.defaults,$.fn.draggable.parseOptions(this),_57||{});
}
var _5b=_59.handle?(typeof _59.handle=="string"?$(_59.handle,this):_59.handle):$(this);
$.data(this,"draggable",{options:_59,handle:_5b});
if(_59.disabled){
$(this).css("cursor","");
return;
}
_5b.unbind(".draggable").bind("mousemove.draggable",{target:this},function(e){
if($.fn.draggable.isDragging){
return;
}
var _5c=$.data(e.data.target,"draggable").options;
if(_5d(e)){
$(this).css("cursor",_5c.cursor);
}else{
$(this).css("cursor","");
}
}).bind("mouseleave.draggable",{target:this},function(e){
$(this).css("cursor","");
}).bind("mousedown.draggable",{target:this},function(e){
if(_5d(e)==false){
return;
}
$(this).css("cursor","");
var _5e=$(e.data.target).position();
var _5f=$(e.data.target).offset();
var _60={startPosition:$(e.data.target).css("position"),startLeft:_5e.left,startTop:_5e.top,left:_5e.left,top:_5e.top,startX:e.pageX,startY:e.pageY,offsetWidth:(e.pageX-_5f.left),offsetHeight:(e.pageY-_5f.top),target:e.data.target,parent:$(e.data.target).parent()[0]};
$.extend(e.data,_60);
var _61=$.data(e.data.target,"draggable").options;
if(_61.onBeforeDrag.call(e.data.target,e)==false){
return;
}
$(document).bind("mousedown.draggable",e.data,_43);
$(document).bind("mousemove.draggable",e.data,_49);
$(document).bind("mouseup.draggable",e.data,_4d);
$.fn.draggable.timer=setTimeout(function(){
$.fn.draggable.isDragging=true;
_43(e);
},_61.delay);
return false;
});
function _5d(e){
var _62=$.data(e.data.target,"draggable");
var _63=_62.handle;
var _64=$(_63).offset();
var _65=$(_63).outerWidth();
var _66=$(_63).outerHeight();
var t=e.pageY-_64.top;
var r=_64.left+_65-e.pageX;
var b=_64.top+_66-e.pageY;
var l=e.pageX-_64.left;
return Math.min(t,r,b,l)>_62.options.edge;
};
});
};
$.fn.draggable.methods={options:function(jq){
return $.data(jq[0],"draggable").options;
},proxy:function(jq){
return $.data(jq[0],"draggable").proxy;
},enable:function(jq){
return jq.each(function(){
$(this).draggable({disabled:false});
});
},disable:function(jq){
return jq.each(function(){
$(this).draggable({disabled:true});
});
}};
$.fn.draggable.parseOptions=function(_67){
var t=$(_67);
return $.extend({},$.parser.parseOptions(_67,["cursor","handle","axis",{"revert":"boolean","deltaX":"number","deltaY":"number","edge":"number","delay":"number"}]),{disabled:(t.attr("disabled")?true:undefined)});
};
$.fn.draggable.defaults={proxy:null,revert:false,cursor:"move",deltaX:null,deltaY:null,handle:null,disabled:false,edge:0,axis:null,delay:100,onBeforeDrag:function(e){
},onStartDrag:function(e){
},onDrag:function(e){
},onStopDrag:function(e){
}};
$.fn.draggable.isDragging=false;
})(jQuery);
(function($){
function _68(_69){
$(_69).addClass("droppable");
$(_69).bind("_dragenter",function(e,_6a){
$.data(_69,"droppable").options.onDragEnter.apply(_69,[e,_6a]);
});
$(_69).bind("_dragleave",function(e,_6b){
$.data(_69,"droppable").options.onDragLeave.apply(_69,[e,_6b]);
});
$(_69).bind("_dragover",function(e,_6c){
$.data(_69,"droppable").options.onDragOver.apply(_69,[e,_6c]);
});
$(_69).bind("_drop",function(e,_6d){
$.data(_69,"droppable").options.onDrop.apply(_69,[e,_6d]);
});
};
$.fn.droppable=function(_6e,_6f){
if(typeof _6e=="string"){
return $.fn.droppable.methods[_6e](this,_6f);
}
_6e=_6e||{};
return this.each(function(){
var _70=$.data(this,"droppable");
if(_70){
$.extend(_70.options,_6e);
}else{
_68(this);
$.data(this,"droppable",{options:$.extend({},$.fn.droppable.defaults,$.fn.droppable.parseOptions(this),_6e)});
}
});
};
$.fn.droppable.methods={options:function(jq){
return $.data(jq[0],"droppable").options;
},enable:function(jq){
return jq.each(function(){
$(this).droppable({disabled:false});
});
},disable:function(jq){
return jq.each(function(){
$(this).droppable({disabled:true});
});
}};
$.fn.droppable.parseOptions=function(_71){
var t=$(_71);
return $.extend({},$.parser.parseOptions(_71,["accept"]),{disabled:(t.attr("disabled")?true:undefined)});
};
$.fn.droppable.defaults={accept:null,disabled:false,onDragEnter:function(e,_72){
},onDragOver:function(e,_73){
},onDragLeave:function(e,_74){
},onDrop:function(e,_75){
}};
})(jQuery);
(function($){
$.fn.resizable=function(_76,_77){
if(typeof _76=="string"){
return $.fn.resizable.methods[_76](this,_77);
}
function _78(e){
var _79=e.data;
var _7a=$.data(_79.target,"resizable").options;
if(_79.dir.indexOf("e")!=-1){
var _7b=_79.startWidth+e.pageX-_79.startX;
_7b=Math.min(Math.max(_7b,_7a.minWidth),_7a.maxWidth);
_79.width=_7b;
}
if(_79.dir.indexOf("s")!=-1){
var _7c=_79.startHeight+e.pageY-_79.startY;
_7c=Math.min(Math.max(_7c,_7a.minHeight),_7a.maxHeight);
_79.height=_7c;
}
if(_79.dir.indexOf("w")!=-1){
var _7b=_79.startWidth-e.pageX+_79.startX;
_7b=Math.min(Math.max(_7b,_7a.minWidth),_7a.maxWidth);
_79.width=_7b;
_79.left=_79.startLeft+_79.startWidth-_79.width;
}
if(_79.dir.indexOf("n")!=-1){
var _7c=_79.startHeight-e.pageY+_79.startY;
_7c=Math.min(Math.max(_7c,_7a.minHeight),_7a.maxHeight);
_79.height=_7c;
_79.top=_79.startTop+_79.startHeight-_79.height;
}
};
function _7d(e){
var _7e=e.data;
var t=$(_7e.target);
t.css({left:_7e.left,top:_7e.top});
if(t.outerWidth()!=_7e.width){
t._outerWidth(_7e.width);
}
if(t.outerHeight()!=_7e.height){
t._outerHeight(_7e.height);
}
};
function _7f(e){
$.fn.resizable.isResizing=true;
$.data(e.data.target,"resizable").options.onStartResize.call(e.data.target,e);
return false;
};
function _80(e){
_78(e);
if($.data(e.data.target,"resizable").options.onResize.call(e.data.target,e)!=false){
_7d(e);
}
return false;
};
function _81(e){
$.fn.resizable.isResizing=false;
_78(e,true);
_7d(e);
$.data(e.data.target,"resizable").options.onStopResize.call(e.data.target,e);
$(document).unbind(".resizable");
$("body").css("cursor","");
return false;
};
return this.each(function(){
var _82=null;
var _83=$.data(this,"resizable");
if(_83){
$(this).unbind(".resizable");
_82=$.extend(_83.options,_76||{});
}else{
_82=$.extend({},$.fn.resizable.defaults,$.fn.resizable.parseOptions(this),_76||{});
$.data(this,"resizable",{options:_82});
}
if(_82.disabled==true){
return;
}
$(this).bind("mousemove.resizable",{target:this},function(e){
if($.fn.resizable.isResizing){
return;
}
var dir=_84(e);
if(dir==""){
$(e.data.target).css("cursor","");
}else{
$(e.data.target).css("cursor",dir+"-resize");
}
}).bind("mouseleave.resizable",{target:this},function(e){
$(e.data.target).css("cursor","");
}).bind("mousedown.resizable",{target:this},function(e){
var dir=_84(e);
if(dir==""){
return;
}
function _85(css){
var val=parseInt($(e.data.target).css(css));
if(isNaN(val)){
return 0;
}else{
return val;
}
};
var _86={target:e.data.target,dir:dir,startLeft:_85("left"),startTop:_85("top"),left:_85("left"),top:_85("top"),startX:e.pageX,startY:e.pageY,startWidth:$(e.data.target).outerWidth(),startHeight:$(e.data.target).outerHeight(),width:$(e.data.target).outerWidth(),height:$(e.data.target).outerHeight(),deltaWidth:$(e.data.target).outerWidth()-$(e.data.target).width(),deltaHeight:$(e.data.target).outerHeight()-$(e.data.target).height()};
$(document).bind("mousedown.resizable",_86,_7f);
$(document).bind("mousemove.resizable",_86,_80);
$(document).bind("mouseup.resizable",_86,_81);
$("body").css("cursor",dir+"-resize");
});
function _84(e){
var tt=$(e.data.target);
var dir="";
var _87=tt.offset();
var _88=tt.outerWidth();
var _89=tt.outerHeight();
var _8a=_82.edge;
if(e.pageY>_87.top&&e.pageY<_87.top+_8a){
dir+="n";
}else{
if(e.pageY<_87.top+_89&&e.pageY>_87.top+_89-_8a){
dir+="s";
}
}
if(e.pageX>_87.left&&e.pageX<_87.left+_8a){
dir+="w";
}else{
if(e.pageX<_87.left+_88&&e.pageX>_87.left+_88-_8a){
dir+="e";
}
}
var _8b=_82.handles.split(",");
for(var i=0;i<_8b.length;i++){
var _8c=_8b[i].replace(/(^\s*)|(\s*$)/g,"");
if(_8c=="all"||_8c==dir){
return dir;
}
}
return "";
};
});
};
$.fn.resizable.methods={options:function(jq){
return $.data(jq[0],"resizable").options;
},enable:function(jq){
return jq.each(function(){
$(this).resizable({disabled:false});
});
},disable:function(jq){
return jq.each(function(){
$(this).resizable({disabled:true});
});
}};
$.fn.resizable.parseOptions=function(_8d){
var t=$(_8d);
return $.extend({},$.parser.parseOptions(_8d,["handles",{minWidth:"number",minHeight:"number",maxWidth:"number",maxHeight:"number",edge:"number"}]),{disabled:(t.attr("disabled")?true:undefined)});
};
$.fn.resizable.defaults={disabled:false,handles:"n, e, s, w, ne, se, sw, nw, all",minWidth:10,minHeight:10,maxWidth:10000,maxHeight:10000,edge:5,onStartResize:function(e){
},onResize:function(e){
},onStopResize:function(e){
}};
$.fn.resizable.isResizing=false;
})(jQuery);
(function($){
function _8e(_8f,_90){
var _91=$.data(_8f,"linkbutton").options;
if(_90){
$.extend(_91,_90);
}
if(_91.width||_91.height||_91.fit){
var btn=$(_8f);
var _92=btn.parent();
var _93=btn.is(":visible");
if(!_93){
var _94=$("<div style=\"display:none\"></div>").insertBefore(_8f);
var _95={position:btn.css("position"),display:btn.css("display"),left:btn.css("left")};
btn.appendTo("body");
btn.css({position:"absolute",display:"inline-block",left:-20000});
}
btn._size(_91,_92);
var _96=btn.find(".l-btn-left");
_96.css("margin-top",0);
_96.css("margin-top",parseInt((btn.height()-_96.height())/2)+"px");
if(!_93){
btn.insertAfter(_94);
btn.css(_95);
_94.remove();
}
}
};
function _97(_98){
var _99=$.data(_98,"linkbutton").options;
var t=$(_98).empty();
t.addClass("l-btn").removeClass("l-btn-plain l-btn-selected l-btn-plain-selected l-btn-outline");
t.removeClass("l-btn-small l-btn-medium l-btn-large").addClass("l-btn-"+_99.size);
if(_99.plain){
t.addClass("l-btn-plain");
}
if(_99.outline){
t.addClass("l-btn-outline");
}
if(_99.selected){
t.addClass(_99.plain?"l-btn-selected l-btn-plain-selected":"l-btn-selected");
}
t.attr("group",_99.group||"");
t.attr("id",_99.id||"");
var _9a=$("<span class=\"l-btn-left\"></span>").appendTo(t);
if(_99.text){
$("<span class=\"l-btn-text\"></span>").html(_99.text).appendTo(_9a);
}else{
$("<span class=\"l-btn-text l-btn-empty\">&nbsp;</span>").appendTo(_9a);
}
if(_99.iconCls){
$("<span class=\"l-btn-icon\">&nbsp;</span>").addClass(_99.iconCls).appendTo(_9a);
_9a.addClass("l-btn-icon-"+_99.iconAlign);
}
t.unbind(".linkbutton").bind("focus.linkbutton",function(){
if(!_99.disabled){
$(this).addClass("l-btn-focus");
}
}).bind("blur.linkbutton",function(){
$(this).removeClass("l-btn-focus");
}).bind("click.linkbutton",function(){
if(!_99.disabled){
if(_99.toggle){
if(_99.selected){
$(this).linkbutton("unselect");
}else{
$(this).linkbutton("select");
}
}
_99.onClick.call(this);
}
});
_9b(_98,_99.selected);
_9c(_98,_99.disabled);
};
function _9b(_9d,_9e){
var _9f=$.data(_9d,"linkbutton").options;
if(_9e){
if(_9f.group){
$("a.l-btn[group=\""+_9f.group+"\"]").each(function(){
var o=$(this).linkbutton("options");
if(o.toggle){
$(this).removeClass("l-btn-selected l-btn-plain-selected");
o.selected=false;
}
});
}
$(_9d).addClass(_9f.plain?"l-btn-selected l-btn-plain-selected":"l-btn-selected");
_9f.selected=true;
}else{
if(!_9f.group){
$(_9d).removeClass("l-btn-selected l-btn-plain-selected");
_9f.selected=false;
}
}
};
function _9c(_a0,_a1){
var _a2=$.data(_a0,"linkbutton");
var _a3=_a2.options;
$(_a0).removeClass("l-btn-disabled l-btn-plain-disabled");
if(_a1){
_a3.disabled=true;
var _a4=$(_a0).attr("href");
if(_a4){
_a2.href=_a4;
$(_a0).attr("href","javascript:void(0)");
}
if(_a0.onclick){
_a2.onclick=_a0.onclick;
_a0.onclick=null;
}
_a3.plain?$(_a0).addClass("l-btn-disabled l-btn-plain-disabled"):$(_a0).addClass("l-btn-disabled");
}else{
_a3.disabled=false;
if(_a2.href){
$(_a0).attr("href",_a2.href);
}
if(_a2.onclick){
_a0.onclick=_a2.onclick;
}
}
};
$.fn.linkbutton=function(_a5,_a6){
if(typeof _a5=="string"){
return $.fn.linkbutton.methods[_a5](this,_a6);
}
_a5=_a5||{};
return this.each(function(){
var _a7=$.data(this,"linkbutton");
if(_a7){
$.extend(_a7.options,_a5);
}else{
$.data(this,"linkbutton",{options:$.extend({},$.fn.linkbutton.defaults,$.fn.linkbutton.parseOptions(this),_a5)});
$(this).removeAttr("disabled");
$(this).bind("_resize",function(e,_a8){
if($(this).hasClass("easyui-fluid")||_a8){
_8e(this);
}
return false;
});
}
_97(this);
_8e(this);
});
};
$.fn.linkbutton.methods={options:function(jq){
return $.data(jq[0],"linkbutton").options;
},resize:function(jq,_a9){
return jq.each(function(){
_8e(this,_a9);
});
},enable:function(jq){
return jq.each(function(){
_9c(this,false);
});
},disable:function(jq){
return jq.each(function(){
_9c(this,true);
});
},select:function(jq){
return jq.each(function(){
_9b(this,true);
});
},unselect:function(jq){
return jq.each(function(){
_9b(this,false);
});
}};
$.fn.linkbutton.parseOptions=function(_aa){
var t=$(_aa);
return $.extend({},$.parser.parseOptions(_aa,["id","iconCls","iconAlign","group","size","text",{plain:"boolean",toggle:"boolean",selected:"boolean",outline:"boolean"}]),{disabled:(t.attr("disabled")?true:undefined),text:($.trim(t.html())||undefined),iconCls:(t.attr("icon")||t.attr("iconCls"))});
};
$.fn.linkbutton.defaults={id:null,disabled:false,toggle:false,selected:false,outline:false,group:null,plain:false,text:"",iconCls:null,iconAlign:"left",size:"small",onClick:function(){
}};
})(jQuery);
(function($){
function _ab(_ac){
var _ad=$.data(_ac,"pagination");
var _ae=_ad.options;
var bb=_ad.bb={};
var _af=$(_ac).addClass("pagination").html("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tr></tr></table>");
var tr=_af.find("tr");
var aa=$.extend([],_ae.layout);
if(!_ae.showPageList){
_b0(aa,"list");
}
if(!_ae.showRefresh){
_b0(aa,"refresh");
}
if(aa[0]=="sep"){
aa.shift();
}
if(aa[aa.length-1]=="sep"){
aa.pop();
}
for(var _b1=0;_b1<aa.length;_b1++){
var _b2=aa[_b1];
if(_b2=="list"){
var ps=$("<select class=\"pagination-page-list\"></select>");
ps.bind("change",function(){
_ae.pageSize=parseInt($(this).val());
_ae.onChangePageSize.call(_ac,_ae.pageSize);
_b8(_ac,_ae.pageNumber);
});
for(var i=0;i<_ae.pageList.length;i++){
$("<option></option>").text(_ae.pageList[i]).appendTo(ps);
}
$("<td></td>").append(ps).appendTo(tr);
}else{
if(_b2=="sep"){
$("<td><div class=\"pagination-btn-separator\"></div></td>").appendTo(tr);
}else{
if(_b2=="first"){
bb.first=_b3("first");
}else{
if(_b2=="prev"){
bb.prev=_b3("prev");
}else{
if(_b2=="next"){
bb.next=_b3("next");
}else{
if(_b2=="last"){
bb.last=_b3("last");
}else{
if(_b2=="manual"){
$("<span style=\"padding-left:6px;\"></span>").html(_ae.beforePageText).appendTo(tr).wrap("<td></td>");
bb.num=$("<input class=\"pagination-num\" type=\"text\" value=\"1\" size=\"2\">").appendTo(tr).wrap("<td></td>");
bb.num.unbind(".pagination").bind("keydown.pagination",function(e){
if(e.keyCode==13){
var _b4=parseInt($(this).val())||1;
_b8(_ac,_b4);
return false;
}
});
bb.after=$("<span style=\"padding-right:6px;\"></span>").appendTo(tr).wrap("<td></td>");
}else{
if(_b2=="refresh"){
bb.refresh=_b3("refresh");
}else{
if(_b2=="links"){
$("<td class=\"pagination-links\"></td>").appendTo(tr);
}
}
}
}
}
}
}
}
}
}
if(_ae.buttons){
$("<td><div class=\"pagination-btn-separator\"></div></td>").appendTo(tr);
if($.isArray(_ae.buttons)){
for(var i=0;i<_ae.buttons.length;i++){
var btn=_ae.buttons[i];
if(btn=="-"){
$("<td><div class=\"pagination-btn-separator\"></div></td>").appendTo(tr);
}else{
var td=$("<td></td>").appendTo(tr);
var a=$("<a href=\"javascript:void(0)\"></a>").appendTo(td);
a[0].onclick=eval(btn.handler||function(){
});
a.linkbutton($.extend({},btn,{plain:true}));
}
}
}else{
var td=$("<td></td>").appendTo(tr);
$(_ae.buttons).appendTo(td).show();
}
}
$("<div class=\"pagination-info\"></div>").appendTo(_af);
$("<div style=\"clear:both;\"></div>").appendTo(_af);
function _b3(_b5){
var btn=_ae.nav[_b5];
var a=$("<a href=\"javascript:void(0)\"></a>").appendTo(tr);
a.wrap("<td></td>");
a.linkbutton({iconCls:btn.iconCls,plain:true}).unbind(".pagination").bind("click.pagination",function(){
btn.handler.call(_ac);
});
return a;
};
function _b0(aa,_b6){
var _b7=$.inArray(_b6,aa);
if(_b7>=0){
aa.splice(_b7,1);
}
return aa;
};
};
function _b8(_b9,_ba){
var _bb=$.data(_b9,"pagination").options;
_bc(_b9,{pageNumber:_ba});
_bb.onSelectPage.call(_b9,_bb.pageNumber,_bb.pageSize);
};
function _bc(_bd,_be){
var _bf=$.data(_bd,"pagination");
var _c0=_bf.options;
var bb=_bf.bb;
$.extend(_c0,_be||{});
var ps=$(_bd).find("select.pagination-page-list");
if(ps.length){
ps.val(_c0.pageSize+"");
_c0.pageSize=parseInt(ps.val());
}
var _c1=Math.ceil(_c0.total/_c0.pageSize)||1;
if(_c0.pageNumber<1){
_c0.pageNumber=1;
}
if(_c0.pageNumber>_c1){
_c0.pageNumber=_c1;
}
if(_c0.total==0){
_c0.pageNumber=0;
_c1=0;
}
if(bb.num){
bb.num.val(_c0.pageNumber);
}
if(bb.after){
bb.after.html(_c0.afterPageText.replace(/{pages}/,_c1));
}
var td=$(_bd).find("td.pagination-links");
if(td.length){
td.empty();
var _c2=_c0.pageNumber-Math.floor(_c0.links/2);
if(_c2<1){
_c2=1;
}
var _c3=_c2+_c0.links-1;
if(_c3>_c1){
_c3=_c1;
}
_c2=_c3-_c0.links+1;
if(_c2<1){
_c2=1;
}
for(var i=_c2;i<=_c3;i++){
var a=$("<a class=\"pagination-link\" href=\"javascript:void(0)\"></a>").appendTo(td);
a.linkbutton({plain:true,text:i});
if(i==_c0.pageNumber){
a.linkbutton("select");
}else{
a.unbind(".pagination").bind("click.pagination",{pageNumber:i},function(e){
_b8(_bd,e.data.pageNumber);
});
}
}
}
var _c4=_c0.displayMsg;
_c4=_c4.replace(/{from}/,_c0.total==0?0:_c0.pageSize*(_c0.pageNumber-1)+1);
_c4=_c4.replace(/{to}/,Math.min(_c0.pageSize*(_c0.pageNumber),_c0.total));
_c4=_c4.replace(/{total}/,_c0.total);
$(_bd).find("div.pagination-info").html(_c4);
if(bb.first){
bb.first.linkbutton({disabled:((!_c0.total)||_c0.pageNumber==1)});
}
if(bb.prev){
bb.prev.linkbutton({disabled:((!_c0.total)||_c0.pageNumber==1)});
}
if(bb.next){
bb.next.linkbutton({disabled:(_c0.pageNumber==_c1)});
}
if(bb.last){
bb.last.linkbutton({disabled:(_c0.pageNumber==_c1)});
}
_c5(_bd,_c0.loading);
};
function _c5(_c6,_c7){
var _c8=$.data(_c6,"pagination");
var _c9=_c8.options;
_c9.loading=_c7;
if(_c9.showRefresh&&_c8.bb.refresh){
_c8.bb.refresh.linkbutton({iconCls:(_c9.loading?"pagination-loading":"pagination-load")});
}
};
$.fn.pagination=function(_ca,_cb){
if(typeof _ca=="string"){
return $.fn.pagination.methods[_ca](this,_cb);
}
_ca=_ca||{};
return this.each(function(){
var _cc;
var _cd=$.data(this,"pagination");
if(_cd){
_cc=$.extend(_cd.options,_ca);
}else{
_cc=$.extend({},$.fn.pagination.defaults,$.fn.pagination.parseOptions(this),_ca);
$.data(this,"pagination",{options:_cc});
}
_ab(this);
_bc(this);
});
};
$.fn.pagination.methods={options:function(jq){
return $.data(jq[0],"pagination").options;
},loading:function(jq){
return jq.each(function(){
_c5(this,true);
});
},loaded:function(jq){
return jq.each(function(){
_c5(this,false);
});
},refresh:function(jq,_ce){
return jq.each(function(){
_bc(this,_ce);
});
},select:function(jq,_cf){
return jq.each(function(){
_b8(this,_cf);
});
}};
$.fn.pagination.parseOptions=function(_d0){
var t=$(_d0);
return $.extend({},$.parser.parseOptions(_d0,[{total:"number",pageSize:"number",pageNumber:"number",links:"number"},{loading:"boolean",showPageList:"boolean",showRefresh:"boolean"}]),{pageList:(t.attr("pageList")?eval(t.attr("pageList")):undefined)});
};
$.fn.pagination.defaults={total:1,pageSize:10,pageNumber:1,pageList:[10,20,30,50],loading:false,buttons:null,showPageList:true,showRefresh:true,links:10,layout:["list","sep","first","prev","sep","manual","sep","next","last","sep","refresh"],onSelectPage:function(_d1,_d2){
},onBeforeRefresh:function(_d3,_d4){
},onRefresh:function(_d5,_d6){
},onChangePageSize:function(_d7){
},beforePageText:"Page",afterPageText:"of {pages}",displayMsg:"Displaying {from} to {to} of {total} items",nav:{first:{iconCls:"pagination-first",handler:function(){
var _d8=$(this).pagination("options");
if(_d8.pageNumber>1){
$(this).pagination("select",1);
}
}},prev:{iconCls:"pagination-prev",handler:function(){
var _d9=$(this).pagination("options");
if(_d9.pageNumber>1){
$(this).pagination("select",_d9.pageNumber-1);
}
}},next:{iconCls:"pagination-next",handler:function(){
var _da=$(this).pagination("options");
var _db=Math.ceil(_da.total/_da.pageSize);
if(_da.pageNumber<_db){
$(this).pagination("select",_da.pageNumber+1);
}
}},last:{iconCls:"pagination-last",handler:function(){
var _dc=$(this).pagination("options");
var _dd=Math.ceil(_dc.total/_dc.pageSize);
if(_dc.pageNumber<_dd){
$(this).pagination("select",_dd);
}
}},refresh:{iconCls:"pagination-refresh",handler:function(){
var _de=$(this).pagination("options");
if(_de.onBeforeRefresh.call(this,_de.pageNumber,_de.pageSize)!=false){
$(this).pagination("select",_de.pageNumber);
_de.onRefresh.call(this,_de.pageNumber,_de.pageSize);
}
}}}};
})(jQuery);
(function($){
function _df(_e0){
var _e1=$(_e0);
_e1.addClass("tree");
return _e1;
};
function _e2(_e3){
var _e4=$.data(_e3,"tree").options;
$(_e3).unbind().bind("mouseover",function(e){
var tt=$(e.target);
var _e5=tt.closest("div.tree-node");
if(!_e5.length){
return;
}
_e5.addClass("tree-node-hover");
if(tt.hasClass("tree-hit")){
if(tt.hasClass("tree-expanded")){
tt.addClass("tree-expanded-hover");
}else{
tt.addClass("tree-collapsed-hover");
}
}
e.stopPropagation();
}).bind("mouseout",function(e){
var tt=$(e.target);
var _e6=tt.closest("div.tree-node");
if(!_e6.length){
return;
}
_e6.removeClass("tree-node-hover");
if(tt.hasClass("tree-hit")){
if(tt.hasClass("tree-expanded")){
tt.removeClass("tree-expanded-hover");
}else{
tt.removeClass("tree-collapsed-hover");
}
}
e.stopPropagation();
}).bind("click",function(e){
var tt=$(e.target);
var _e7=tt.closest("div.tree-node");
if(!_e7.length){
return;
}
if(tt.hasClass("tree-hit")){
_145(_e3,_e7[0]);
return false;
}else{
if(tt.hasClass("tree-checkbox")){
_10c(_e3,_e7[0]);
return false;
}else{
_188(_e3,_e7[0]);
_e4.onClick.call(_e3,_ea(_e3,_e7[0]));
}
}
e.stopPropagation();
}).bind("dblclick",function(e){
var _e8=$(e.target).closest("div.tree-node");
if(!_e8.length){
return;
}
_188(_e3,_e8[0]);
_e4.onDblClick.call(_e3,_ea(_e3,_e8[0]));
e.stopPropagation();
}).bind("contextmenu",function(e){
var _e9=$(e.target).closest("div.tree-node");
if(!_e9.length){
return;
}
_e4.onContextMenu.call(_e3,e,_ea(_e3,_e9[0]));
e.stopPropagation();
});
};
function _eb(_ec){
var _ed=$.data(_ec,"tree").options;
_ed.dnd=false;
var _ee=$(_ec).find("div.tree-node");
_ee.draggable("disable");
_ee.css("cursor","pointer");
};
function _ef(_f0){
var _f1=$.data(_f0,"tree");
var _f2=_f1.options;
var _f3=_f1.tree;
_f1.disabledNodes=[];
_f2.dnd=true;
_f3.find("div.tree-node").draggable({disabled:false,revert:true,cursor:"pointer",proxy:function(_f4){
var p=$("<div class=\"tree-node-proxy\"></div>").appendTo("body");
p.html("<span class=\"tree-dnd-icon tree-dnd-no\">&nbsp;</span>"+$(_f4).find(".tree-title").html());
p.hide();
return p;
},deltaX:15,deltaY:15,onBeforeDrag:function(e){
if(_f2.onBeforeDrag.call(_f0,_ea(_f0,this))==false){
return false;
}
if($(e.target).hasClass("tree-hit")||$(e.target).hasClass("tree-checkbox")){
return false;
}
if(e.which!=1){
return false;
}
var _f5=$(this).find("span.tree-indent");
if(_f5.length){
e.data.offsetWidth-=_f5.length*_f5.width();
}
},onStartDrag:function(e){
$(this).next("ul").find("div.tree-node").each(function(){
$(this).droppable("disable");
_f1.disabledNodes.push(this);
});
$(this).draggable("proxy").css({left:-10000,top:-10000});
_f2.onStartDrag.call(_f0,_ea(_f0,this));
var _f6=_ea(_f0,this);
if(_f6.id==undefined){
_f6.id="easyui_tree_node_id_temp";
_12c(_f0,_f6);
}
_f1.draggingNodeId=_f6.id;
},onDrag:function(e){
var x1=e.pageX,y1=e.pageY,x2=e.data.startX,y2=e.data.startY;
var d=Math.sqrt((x1-x2)*(x1-x2)+(y1-y2)*(y1-y2));
if(d>3){
$(this).draggable("proxy").show();
}
this.pageY=e.pageY;
},onStopDrag:function(){
for(var i=0;i<_f1.disabledNodes.length;i++){
$(_f1.disabledNodes[i]).droppable("enable");
}
_f1.disabledNodes=[];
var _f7=_182(_f0,_f1.draggingNodeId);
if(_f7&&_f7.id=="easyui_tree_node_id_temp"){
_f7.id="";
_12c(_f0,_f7);
}
_f2.onStopDrag.call(_f0,_f7);
}}).droppable({accept:"div.tree-node",onDragEnter:function(e,_f8){
if(_f2.onDragEnter.call(_f0,this,_f9(_f8))==false){
_fa(_f8,false);
$(this).removeClass("tree-node-append tree-node-top tree-node-bottom");
$(this).droppable("disable");
_f1.disabledNodes.push(this);
}
},onDragOver:function(e,_fb){
if($(this).droppable("options").disabled){
return;
}
var _fc=_fb.pageY;
var top=$(this).offset().top;
var _fd=top+$(this).outerHeight();
_fa(_fb,true);
$(this).removeClass("tree-node-append tree-node-top tree-node-bottom");
if(_fc>top+(_fd-top)/2){
if(_fd-_fc<5){
$(this).addClass("tree-node-bottom");
}else{
$(this).addClass("tree-node-append");
}
}else{
if(_fc-top<5){
$(this).addClass("tree-node-top");
}else{
$(this).addClass("tree-node-append");
}
}
if(_f2.onDragOver.call(_f0,this,_f9(_fb))==false){
_fa(_fb,false);
$(this).removeClass("tree-node-append tree-node-top tree-node-bottom");
$(this).droppable("disable");
_f1.disabledNodes.push(this);
}
},onDragLeave:function(e,_fe){
_fa(_fe,false);
$(this).removeClass("tree-node-append tree-node-top tree-node-bottom");
_f2.onDragLeave.call(_f0,this,_f9(_fe));
},onDrop:function(e,_ff){
var dest=this;
var _100,_101;
if($(this).hasClass("tree-node-append")){
_100=_102;
_101="append";
}else{
_100=_103;
_101=$(this).hasClass("tree-node-top")?"top":"bottom";
}
if(_f2.onBeforeDrop.call(_f0,dest,_f9(_ff),_101)==false){
$(this).removeClass("tree-node-append tree-node-top tree-node-bottom");
return;
}
_100(_ff,dest,_101);
$(this).removeClass("tree-node-append tree-node-top tree-node-bottom");
}});
function _f9(_104,pop){
return $(_104).closest("ul.tree").tree(pop?"pop":"getData",_104);
};
function _fa(_105,_106){
var icon=$(_105).draggable("proxy").find("span.tree-dnd-icon");
icon.removeClass("tree-dnd-yes tree-dnd-no").addClass(_106?"tree-dnd-yes":"tree-dnd-no");
};
function _102(_107,dest){
if(_ea(_f0,dest).state=="closed"){
_13d(_f0,dest,function(){
_108();
});
}else{
_108();
}
function _108(){
var node=_f9(_107,true);
$(_f0).tree("append",{parent:dest,data:[node]});
_f2.onDrop.call(_f0,dest,node,"append");
};
};
function _103(_109,dest,_10a){
var _10b={};
if(_10a=="top"){
_10b.before=dest;
}else{
_10b.after=dest;
}
var node=_f9(_109,true);
_10b.data=node;
$(_f0).tree("insert",_10b);
_f2.onDrop.call(_f0,dest,node,_10a);
};
};
function _10c(_10d,_10e,_10f,_110){
var _111=$.data(_10d,"tree");
var opts=_111.options;
if(!opts.checkbox){
return;
}
var _112=_ea(_10d,_10e);
if(!_112.checkState){
return;
}
var ck=$(_10e).find(".tree-checkbox");
if(_10f==undefined){
if(ck.hasClass("tree-checkbox1")){
_10f=false;
}else{
if(ck.hasClass("tree-checkbox0")){
_10f=true;
}else{
if(_112._checked==undefined){
_112._checked=$(_10e).find(".tree-checkbox").hasClass("tree-checkbox1");
}
_10f=!_112._checked;
}
}
}
_112._checked=_10f;
if(_10f){
if(ck.hasClass("tree-checkbox1")){
return;
}
}else{
if(ck.hasClass("tree-checkbox0")){
return;
}
}
if(!_110){
if(opts.onBeforeCheck.call(_10d,_112,_10f)==false){
return;
}
}
if(opts.cascadeCheck){
_113(_10d,_112,_10f);
_114(_10d,_112);
}else{
_115(_10d,_112,_10f?"1":"0");
}
if(!_110){
opts.onCheck.call(_10d,_112,_10f);
}
};
function _113(_116,_117,_118){
var opts=$.data(_116,"tree").options;
var flag=_118?1:0;
_115(_116,_117,flag);
if(opts.deepCheck){
$.easyui.forEach(_117.children||[],true,function(n){
_115(_116,n,flag);
});
}else{
var _119=[];
if(_117.children&&_117.children.length){
_119.push(_117);
}
$.easyui.forEach(_117.children||[],true,function(n){
if(!n.hidden){
_115(_116,n,flag);
if(n.children&&n.children.length){
_119.push(n);
}
}
});
for(var i=_119.length-1;i>=0;i--){
var node=_119[i];
_115(_116,node,_11a(node));
}
}
};
function _115(_11b,_11c,flag){
var opts=$.data(_11b,"tree").options;
if(!_11c.checkState||flag==undefined){
return;
}
if(_11c.hidden&&!opts.deepCheck){
return;
}
var ck=$("#"+_11c.domId).find(".tree-checkbox");
_11c.checkState=["unchecked","checked","indeterminate"][flag];
_11c.checked=(_11c.checkState=="checked");
ck.removeClass("tree-checkbox0 tree-checkbox1 tree-checkbox2");
ck.addClass("tree-checkbox"+flag);
};
function _114(_11d,_11e){
var pd=_11f(_11d,$("#"+_11e.domId)[0]);
if(pd){
_115(_11d,pd,_11a(pd));
_114(_11d,pd);
}
};
function _11a(row){
var c0=0;
var c1=0;
var len=0;
$.easyui.forEach(row.children||[],false,function(r){
if(r.checkState){
len++;
if(r.checkState=="checked"){
c1++;
}else{
if(r.checkState=="unchecked"){
c0++;
}
}
}
});
if(len==0){
return undefined;
}
var flag=0;
if(c0==len){
flag=0;
}else{
if(c1==len){
flag=1;
}else{
flag=2;
}
}
return flag;
};
function _120(_121,_122){
var opts=$.data(_121,"tree").options;
if(!opts.checkbox){
return;
}
var node=$(_122);
var ck=node.find(".tree-checkbox");
var _123=_ea(_121,_122);
if(opts.view.hasCheckbox(_121,_123)){
if(!ck.length){
_123.checkState=_123.checkState||"unchecked";
$("<span class=\"tree-checkbox\"></span>").insertBefore(node.find(".tree-title"));
}
if(_123.checkState=="checked"){
_10c(_121,_122,true,true);
}else{
if(_123.checkState=="unchecked"){
_10c(_121,_122,false,true);
}else{
var flag=_11a(_123);
if(flag===0){
_10c(_121,_122,false,true);
}else{
if(flag===1){
_10c(_121,_122,true,true);
}
}
}
}
}else{
ck.remove();
_123.checkState=undefined;
_123.checked=undefined;
_114(_121,_123);
}
};
function _124(_125,ul,data,_126,_127){
var _128=$.data(_125,"tree");
var opts=_128.options;
var _129=$(ul).prevAll("div.tree-node:first");
data=opts.loadFilter.call(_125,data,_129[0]);
var _12a=_12b(_125,"domId",_129.attr("id"));
if(!_126){
_12a?_12a.children=data:_128.data=data;
$(ul).empty();
}else{
if(_12a){
_12a.children?_12a.children=_12a.children.concat(data):_12a.children=data;
}else{
_128.data=_128.data.concat(data);
}
}
opts.view.render.call(opts.view,_125,ul,data);
if(opts.dnd){
_ef(_125);
}
if(_12a){
_12c(_125,_12a);
}
for(var i=0;i<_128.tmpIds.length;i++){
_10c(_125,$("#"+_128.tmpIds[i])[0],true,true);
}
_128.tmpIds=[];
setTimeout(function(){
_12d(_125,_125);
},0);
if(!_127){
opts.onLoadSuccess.call(_125,_12a,data);
}
};
function _12d(_12e,ul,_12f){
var opts=$.data(_12e,"tree").options;
if(opts.lines){
$(_12e).addClass("tree-lines");
}else{
$(_12e).removeClass("tree-lines");
return;
}
if(!_12f){
_12f=true;
$(_12e).find("span.tree-indent").removeClass("tree-line tree-join tree-joinbottom");
$(_12e).find("div.tree-node").removeClass("tree-node-last tree-root-first tree-root-one");
var _130=$(_12e).tree("getRoots");
if(_130.length>1){
$(_130[0].target).addClass("tree-root-first");
}else{
if(_130.length==1){
$(_130[0].target).addClass("tree-root-one");
}
}
}
$(ul).children("li").each(function(){
var node=$(this).children("div.tree-node");
var ul=node.next("ul");
if(ul.length){
if($(this).next().length){
_131(node);
}
_12d(_12e,ul,_12f);
}else{
_132(node);
}
});
var _133=$(ul).children("li:last").children("div.tree-node").addClass("tree-node-last");
_133.children("span.tree-join").removeClass("tree-join").addClass("tree-joinbottom");
function _132(node,_134){
var icon=node.find("span.tree-icon");
icon.prev("span.tree-indent").addClass("tree-join");
};
function _131(node){
var _135=node.find("span.tree-indent, span.tree-hit").length;
node.next().find("div.tree-node").each(function(){
$(this).children("span:eq("+(_135-1)+")").addClass("tree-line");
});
};
};
function _136(_137,ul,_138,_139){
var opts=$.data(_137,"tree").options;
_138=$.extend({},opts.queryParams,_138||{});
var _13a=null;
if(_137!=ul){
var node=$(ul).prev();
_13a=_ea(_137,node[0]);
}
if(opts.onBeforeLoad.call(_137,_13a,_138)==false){
return;
}
var _13b=$(ul).prev().children("span.tree-folder");
_13b.addClass("tree-loading");
var _13c=opts.loader.call(_137,_138,function(data){
_13b.removeClass("tree-loading");
_124(_137,ul,data);
if(_139){
_139();
}
},function(){
_13b.removeClass("tree-loading");
opts.onLoadError.apply(_137,arguments);
if(_139){
_139();
}
});
if(_13c==false){
_13b.removeClass("tree-loading");
}
};
function _13d(_13e,_13f,_140){
var opts=$.data(_13e,"tree").options;
var hit=$(_13f).children("span.tree-hit");
if(hit.length==0){
return;
}
if(hit.hasClass("tree-expanded")){
return;
}
var node=_ea(_13e,_13f);
if(opts.onBeforeExpand.call(_13e,node)==false){
return;
}
hit.removeClass("tree-collapsed tree-collapsed-hover").addClass("tree-expanded");
hit.next().addClass("tree-folder-open");
var ul=$(_13f).next();
if(ul.length){
if(opts.animate){
ul.slideDown("normal",function(){
node.state="open";
opts.onExpand.call(_13e,node);
if(_140){
_140();
}
});
}else{
ul.css("display","block");
node.state="open";
opts.onExpand.call(_13e,node);
if(_140){
_140();
}
}
}else{
var _141=$("<ul style=\"display:none\"></ul>").insertAfter(_13f);
_136(_13e,_141[0],{id:node.id},function(){
if(_141.is(":empty")){
_141.remove();
}
if(opts.animate){
_141.slideDown("normal",function(){
node.state="open";
opts.onExpand.call(_13e,node);
if(_140){
_140();
}
});
}else{
_141.css("display","block");
node.state="open";
opts.onExpand.call(_13e,node);
if(_140){
_140();
}
}
});
}
};
function _142(_143,_144){
var opts=$.data(_143,"tree").options;
var hit=$(_144).children("span.tree-hit");
if(hit.length==0){
return;
}
if(hit.hasClass("tree-collapsed")){
return;
}
var node=_ea(_143,_144);
if(opts.onBeforeCollapse.call(_143,node)==false){
return;
}
hit.removeClass("tree-expanded tree-expanded-hover").addClass("tree-collapsed");
hit.next().removeClass("tree-folder-open");
var ul=$(_144).next();
if(opts.animate){
ul.slideUp("normal",function(){
node.state="closed";
opts.onCollapse.call(_143,node);
});
}else{
ul.css("display","none");
node.state="closed";
opts.onCollapse.call(_143,node);
}
};
function _145(_146,_147){
var hit=$(_147).children("span.tree-hit");
if(hit.length==0){
return;
}
if(hit.hasClass("tree-expanded")){
_142(_146,_147);
}else{
_13d(_146,_147);
}
};
function _148(_149,_14a){
var _14b=_14c(_149,_14a);
if(_14a){
_14b.unshift(_ea(_149,_14a));
}
for(var i=0;i<_14b.length;i++){
_13d(_149,_14b[i].target);
}
};
function _14d(_14e,_14f){
var _150=[];
var p=_11f(_14e,_14f);
while(p){
_150.unshift(p);
p=_11f(_14e,p.target);
}
for(var i=0;i<_150.length;i++){
_13d(_14e,_150[i].target);
}
};
function _151(_152,_153){
var c=$(_152).parent();
while(c[0].tagName!="BODY"&&c.css("overflow-y")!="auto"){
c=c.parent();
}
var n=$(_153);
var ntop=n.offset().top;
if(c[0].tagName!="BODY"){
var ctop=c.offset().top;
if(ntop<ctop){
c.scrollTop(c.scrollTop()+ntop-ctop);
}else{
if(ntop+n.outerHeight()>ctop+c.outerHeight()-18){
c.scrollTop(c.scrollTop()+ntop+n.outerHeight()-ctop-c.outerHeight()+18);
}
}
}else{
c.scrollTop(ntop);
}
};
function _154(_155,_156){
var _157=_14c(_155,_156);
if(_156){
_157.unshift(_ea(_155,_156));
}
for(var i=0;i<_157.length;i++){
_142(_155,_157[i].target);
}
};
function _158(_159,_15a){
var node=$(_15a.parent);
var data=_15a.data;
if(!data){
return;
}
data=$.isArray(data)?data:[data];
if(!data.length){
return;
}
var ul;
if(node.length==0){
ul=$(_159);
}else{
if(_15b(_159,node[0])){
var _15c=node.find("span.tree-icon");
_15c.removeClass("tree-file").addClass("tree-folder tree-folder-open");
var hit=$("<span class=\"tree-hit tree-expanded\"></span>").insertBefore(_15c);
if(hit.prev().length){
hit.prev().remove();
}
}
ul=node.next();
if(!ul.length){
ul=$("<ul></ul>").insertAfter(node);
}
}
_124(_159,ul[0],data,true,true);
};
function _15d(_15e,_15f){
var ref=_15f.before||_15f.after;
var _160=_11f(_15e,ref);
var data=_15f.data;
if(!data){
return;
}
data=$.isArray(data)?data:[data];
if(!data.length){
return;
}
_158(_15e,{parent:(_160?_160.target:null),data:data});
var _161=_160?_160.children:$(_15e).tree("getRoots");
for(var i=0;i<_161.length;i++){
if(_161[i].domId==$(ref).attr("id")){
for(var j=data.length-1;j>=0;j--){
_161.splice((_15f.before?i:(i+1)),0,data[j]);
}
_161.splice(_161.length-data.length,data.length);
break;
}
}
var li=$();
for(var i=0;i<data.length;i++){
li=li.add($("#"+data[i].domId).parent());
}
if(_15f.before){
li.insertBefore($(ref).parent());
}else{
li.insertAfter($(ref).parent());
}
};
function _162(_163,_164){
var _165=del(_164);
$(_164).parent().remove();
if(_165){
if(!_165.children||!_165.children.length){
var node=$(_165.target);
node.find(".tree-icon").removeClass("tree-folder").addClass("tree-file");
node.find(".tree-hit").remove();
$("<span class=\"tree-indent\"></span>").prependTo(node);
node.next().remove();
}
_12c(_163,_165);
}
_12d(_163,_163);
function del(_166){
var id=$(_166).attr("id");
var _167=_11f(_163,_166);
var cc=_167?_167.children:$.data(_163,"tree").data;
for(var i=0;i<cc.length;i++){
if(cc[i].domId==id){
cc.splice(i,1);
break;
}
}
return _167;
};
};
function _12c(_168,_169){
var opts=$.data(_168,"tree").options;
var node=$(_169.target);
var data=_ea(_168,_169.target);
if(data.iconCls){
node.find(".tree-icon").removeClass(data.iconCls);
}
$.extend(data,_169);
node.find(".tree-title").html(opts.formatter.call(_168,data));
if(data.iconCls){
node.find(".tree-icon").addClass(data.iconCls);
}
_120(_168,_169.target);
};
function _16a(_16b,_16c){
if(_16c){
var p=_11f(_16b,_16c);
while(p){
_16c=p.target;
p=_11f(_16b,_16c);
}
return _ea(_16b,_16c);
}else{
var _16d=_16e(_16b);
return _16d.length?_16d[0]:null;
}
};
function _16e(_16f){
var _170=$.data(_16f,"tree").data;
for(var i=0;i<_170.length;i++){
_171(_170[i]);
}
return _170;
};
function _14c(_172,_173){
var _174=[];
var n=_ea(_172,_173);
var data=n?(n.children||[]):$.data(_172,"tree").data;
$.easyui.forEach(data,true,function(node){
_174.push(_171(node));
});
return _174;
};
function _11f(_175,_176){
var p=$(_176).closest("ul").prevAll("div.tree-node:first");
return _ea(_175,p[0]);
};
function _177(_178,_179){
_179=_179||"checked";
if(!$.isArray(_179)){
_179=[_179];
}
var _17a=[];
$.easyui.forEach($.data(_178,"tree").data,true,function(n){
if(n.checkState&&$.easyui.indexOfArray(_179,n.checkState)!=-1){
_17a.push(_171(n));
}
});
return _17a;
};
function _17b(_17c){
var node=$(_17c).find("div.tree-node-selected");
return node.length?_ea(_17c,node[0]):null;
};
function _17d(_17e,_17f){
var data=_ea(_17e,_17f);
if(data&&data.children){
$.easyui.forEach(data.children,true,function(node){
_171(node);
});
}
return data;
};
function _ea(_180,_181){
return _12b(_180,"domId",$(_181).attr("id"));
};
function _182(_183,id){
return _12b(_183,"id",id);
};
function _12b(_184,_185,_186){
var data=$.data(_184,"tree").data;
var _187=null;
$.easyui.forEach(data,true,function(node){
if(node[_185]==_186){
_187=_171(node);
return false;
}
});
return _187;
};
function _171(node){
node.target=$("#"+node.domId)[0];
return node;
};
function _188(_189,_18a){
var opts=$.data(_189,"tree").options;
var node=_ea(_189,_18a);
if(opts.onBeforeSelect.call(_189,node)==false){
return;
}
$(_189).find("div.tree-node-selected").removeClass("tree-node-selected");
$(_18a).addClass("tree-node-selected");
opts.onSelect.call(_189,node);
};
function _15b(_18b,_18c){
return $(_18c).children("span.tree-hit").length==0;
};
function _18d(_18e,_18f){
var opts=$.data(_18e,"tree").options;
var node=_ea(_18e,_18f);
if(opts.onBeforeEdit.call(_18e,node)==false){
return;
}
$(_18f).css("position","relative");
var nt=$(_18f).find(".tree-title");
var _190=nt.outerWidth();
nt.empty();
var _191=$("<input class=\"tree-editor\">").appendTo(nt);
_191.val(node.text).focus();
_191.width(_190+20);
_191._outerHeight(18);
_191.bind("click",function(e){
return false;
}).bind("mousedown",function(e){
e.stopPropagation();
}).bind("mousemove",function(e){
e.stopPropagation();
}).bind("keydown",function(e){
if(e.keyCode==13){
_192(_18e,_18f);
return false;
}else{
if(e.keyCode==27){
_196(_18e,_18f);
return false;
}
}
}).bind("blur",function(e){
e.stopPropagation();
_192(_18e,_18f);
});
};
function _192(_193,_194){
var opts=$.data(_193,"tree").options;
$(_194).css("position","");
var _195=$(_194).find("input.tree-editor");
var val=_195.val();
_195.remove();
var node=_ea(_193,_194);
node.text=val;
_12c(_193,node);
opts.onAfterEdit.call(_193,node);
};
function _196(_197,_198){
var opts=$.data(_197,"tree").options;
$(_198).css("position","");
$(_198).find("input.tree-editor").remove();
var node=_ea(_197,_198);
_12c(_197,node);
opts.onCancelEdit.call(_197,node);
};
function _199(_19a,q){
var _19b=$.data(_19a,"tree");
var opts=_19b.options;
var ids={};
$.easyui.forEach(_19b.data,true,function(node){
if(opts.filter.call(_19a,q,node)){
$("#"+node.domId).removeClass("tree-node-hidden");
ids[node.domId]=1;
node.hidden=false;
}else{
$("#"+node.domId).addClass("tree-node-hidden");
node.hidden=true;
}
});
for(var id in ids){
_19c(id);
}
function _19c(_19d){
var p=$(_19a).tree("getParent",$("#"+_19d)[0]);
while(p){
$(p.target).removeClass("tree-node-hidden");
p.hidden=false;
p=$(_19a).tree("getParent",p.target);
}
};
};
$.fn.tree=function(_19e,_19f){
if(typeof _19e=="string"){
return $.fn.tree.methods[_19e](this,_19f);
}
var _19e=_19e||{};
return this.each(function(){
var _1a0=$.data(this,"tree");
var opts;
if(_1a0){
opts=$.extend(_1a0.options,_19e);
_1a0.options=opts;
}else{
opts=$.extend({},$.fn.tree.defaults,$.fn.tree.parseOptions(this),_19e);
$.data(this,"tree",{options:opts,tree:_df(this),data:[],tmpIds:[]});
var data=$.fn.tree.parseData(this);
if(data.length){
_124(this,this,data);
}
}
_e2(this);
if(opts.data){
_124(this,this,$.extend(true,[],opts.data));
}
_136(this,this);
});
};
$.fn.tree.methods={options:function(jq){
return $.data(jq[0],"tree").options;
},loadData:function(jq,data){
return jq.each(function(){
_124(this,this,data);
});
},getNode:function(jq,_1a1){
return _ea(jq[0],_1a1);
},getData:function(jq,_1a2){
return _17d(jq[0],_1a2);
},reload:function(jq,_1a3){
return jq.each(function(){
if(_1a3){
var node=$(_1a3);
var hit=node.children("span.tree-hit");
hit.removeClass("tree-expanded tree-expanded-hover").addClass("tree-collapsed");
node.next().remove();
_13d(this,_1a3);
}else{
$(this).empty();
_136(this,this);
}
});
},getRoot:function(jq,_1a4){
return _16a(jq[0],_1a4);
},getRoots:function(jq){
return _16e(jq[0]);
},getParent:function(jq,_1a5){
return _11f(jq[0],_1a5);
},getChildren:function(jq,_1a6){
return _14c(jq[0],_1a6);
},getChecked:function(jq,_1a7){
return _177(jq[0],_1a7);
},getSelected:function(jq){
return _17b(jq[0]);
},isLeaf:function(jq,_1a8){
return _15b(jq[0],_1a8);
},find:function(jq,id){
return _182(jq[0],id);
},select:function(jq,_1a9){
return jq.each(function(){
_188(this,_1a9);
});
},check:function(jq,_1aa){
return jq.each(function(){
_10c(this,_1aa,true);
});
},uncheck:function(jq,_1ab){
return jq.each(function(){
_10c(this,_1ab,false);
});
},collapse:function(jq,_1ac){
return jq.each(function(){
_142(this,_1ac);
});
},expand:function(jq,_1ad){
return jq.each(function(){
_13d(this,_1ad);
});
},collapseAll:function(jq,_1ae){
return jq.each(function(){
_154(this,_1ae);
});
},expandAll:function(jq,_1af){
return jq.each(function(){
_148(this,_1af);
});
},expandTo:function(jq,_1b0){
return jq.each(function(){
_14d(this,_1b0);
});
},scrollTo:function(jq,_1b1){
return jq.each(function(){
_151(this,_1b1);
});
},toggle:function(jq,_1b2){
return jq.each(function(){
_145(this,_1b2);
});
},append:function(jq,_1b3){
return jq.each(function(){
_158(this,_1b3);
});
},insert:function(jq,_1b4){
return jq.each(function(){
_15d(this,_1b4);
});
},remove:function(jq,_1b5){
return jq.each(function(){
_162(this,_1b5);
});
},pop:function(jq,_1b6){
var node=jq.tree("getData",_1b6);
jq.tree("remove",_1b6);
return node;
},update:function(jq,_1b7){
return jq.each(function(){
_12c(this,$.extend({},_1b7,{checkState:_1b7.checked?"checked":(_1b7.checked===false?"unchecked":undefined)}));
});
},enableDnd:function(jq){
return jq.each(function(){
_ef(this);
});
},disableDnd:function(jq){
return jq.each(function(){
_eb(this);
});
},beginEdit:function(jq,_1b8){
return jq.each(function(){
_18d(this,_1b8);
});
},endEdit:function(jq,_1b9){
return jq.each(function(){
_192(this,_1b9);
});
},cancelEdit:function(jq,_1ba){
return jq.each(function(){
_196(this,_1ba);
});
},doFilter:function(jq,q){
return jq.each(function(){
_199(this,q);
});
}};
$.fn.tree.parseOptions=function(_1bb){
var t=$(_1bb);
return $.extend({},$.parser.parseOptions(_1bb,["url","method",{checkbox:"boolean",cascadeCheck:"boolean",onlyLeafCheck:"boolean"},{animate:"boolean",lines:"boolean",dnd:"boolean"}]));
};
$.fn.tree.parseData=function(_1bc){
var data=[];
_1bd(data,$(_1bc));
return data;
function _1bd(aa,tree){
tree.children("li").each(function(){
var node=$(this);
var item=$.extend({},$.parser.parseOptions(this,["id","iconCls","state"]),{checked:(node.attr("checked")?true:undefined)});
item.text=node.children("span").html();
if(!item.text){
item.text=node.html();
}
var _1be=node.children("ul");
if(_1be.length){
item.children=[];
_1bd(item.children,_1be);
}
aa.push(item);
});
};
};
var _1bf=1;
var _1c0={render:function(_1c1,ul,data){
var _1c2=$.data(_1c1,"tree");
var opts=_1c2.options;
var _1c3=$(ul).prev(".tree-node");
var _1c4=_1c3.length?$(_1c1).tree("getNode",_1c3[0]):null;
var _1c5=_1c3.find("span.tree-indent, span.tree-hit").length;
var cc=_1c6.call(this,_1c5,data);
$(ul).append(cc.join(""));
function _1c6(_1c7,_1c8){
var cc=[];
for(var i=0;i<_1c8.length;i++){
var item=_1c8[i];
if(item.state!="open"&&item.state!="closed"){
item.state="open";
}
item.domId="_easyui_tree_"+_1bf++;
cc.push("<li>");
cc.push("<div id=\""+item.domId+"\" class=\"tree-node\">");
for(var j=0;j<_1c7;j++){
cc.push("<span class=\"tree-indent\"></span>");
}
if(item.state=="closed"){
cc.push("<span class=\"tree-hit tree-collapsed\"></span>");
cc.push("<span class=\"tree-icon tree-folder "+(item.iconCls?item.iconCls:"")+"\"></span>");
}else{
if(item.children&&item.children.length){
cc.push("<span class=\"tree-hit tree-expanded\"></span>");
cc.push("<span class=\"tree-icon tree-folder tree-folder-open "+(item.iconCls?item.iconCls:"")+"\"></span>");
}else{
cc.push("<span class=\"tree-indent\"></span>");
cc.push("<span class=\"tree-icon tree-file "+(item.iconCls?item.iconCls:"")+"\"></span>");
}
}
if(this.hasCheckbox(_1c1,item)){
var flag=0;
if(_1c4&&_1c4.checkState=="checked"&&opts.cascadeCheck){
flag=1;
item.checked=true;
}else{
if(item.checked){
$.easyui.addArrayItem(_1c2.tmpIds,item.domId);
}
}
item.checkState=flag?"checked":"unchecked";
cc.push("<span class=\"tree-checkbox tree-checkbox"+flag+"\"></span>");
}else{
item.checkState=undefined;
item.checked=undefined;
}
cc.push("<span class=\"tree-title\">"+opts.formatter.call(_1c1,item)+"</span>");
cc.push("</div>");
if(item.children&&item.children.length){
var tmp=_1c6.call(this,_1c7+1,item.children);
cc.push("<ul style=\"display:"+(item.state=="closed"?"none":"block")+"\">");
cc=cc.concat(tmp);
cc.push("</ul>");
}
cc.push("</li>");
}
return cc;
};
},hasCheckbox:function(_1c9,item){
var _1ca=$.data(_1c9,"tree");
var opts=_1ca.options;
if(opts.checkbox){
if($.isFunction(opts.checkbox)){
if(opts.checkbox.call(_1c9,item)){
return true;
}else{
return false;
}
}else{
if(opts.onlyLeafCheck){
if(item.state=="open"&&!(item.children&&item.children.length)){
return true;
}
}else{
return true;
}
}
}
return false;
}};
$.fn.tree.defaults={url:null,method:"post",animate:false,checkbox:false,cascadeCheck:true,onlyLeafCheck:false,lines:false,dnd:false,data:null,queryParams:{},formatter:function(node){
return node.text;
},filter:function(q,node){
var qq=[];
$.map($.isArray(q)?q:[q],function(q){
q=$.trim(q);
if(q){
qq.push(q);
}
});
for(var i=0;i<qq.length;i++){
var _1cb=node.text.toLowerCase().indexOf(qq[i].toLowerCase());
if(_1cb>=0){
return true;
}
}
return !qq.length;
},loader:function(_1cc,_1cd,_1ce){
var opts=$(this).tree("options");
if(!opts.url){
return false;
}
$.ajax({type:opts.method,url:opts.url,data:_1cc,dataType:"json",success:function(data){
_1cd(data);
},error:function(){
_1ce.apply(this,arguments);
}});
},loadFilter:function(data,_1cf){
return data;
},view:_1c0,onBeforeLoad:function(node,_1d0){
},onLoadSuccess:function(node,data){
},onLoadError:function(){
},onClick:function(node){
},onDblClick:function(node){
},onBeforeExpand:function(node){
},onExpand:function(node){
},onBeforeCollapse:function(node){
},onCollapse:function(node){
},onBeforeCheck:function(node,_1d1){
},onCheck:function(node,_1d2){
},onBeforeSelect:function(node){
},onSelect:function(node){
},onContextMenu:function(e,node){
},onBeforeDrag:function(node){
},onStartDrag:function(node){
},onStopDrag:function(node){
},onDragEnter:function(_1d3,_1d4){
},onDragOver:function(_1d5,_1d6){
},onDragLeave:function(_1d7,_1d8){
},onBeforeDrop:function(_1d9,_1da,_1db){
},onDrop:function(_1dc,_1dd,_1de){
},onBeforeEdit:function(node){
},onAfterEdit:function(node){
},onCancelEdit:function(node){
}};
})(jQuery);
(function($){
function init(_1df){
$(_1df).addClass("progressbar");
$(_1df).html("<div class=\"progressbar-text\"></div><div class=\"progressbar-value\"><div class=\"progressbar-text\"></div></div>");
$(_1df).bind("_resize",function(e,_1e0){
if($(this).hasClass("easyui-fluid")||_1e0){
_1e1(_1df);
}
return false;
});
return $(_1df);
};
function _1e1(_1e2,_1e3){
var opts=$.data(_1e2,"progressbar").options;
var bar=$.data(_1e2,"progressbar").bar;
if(_1e3){
opts.width=_1e3;
}
bar._size(opts);
bar.find("div.progressbar-text").css("width",bar.width());
bar.find("div.progressbar-text,div.progressbar-value").css({height:bar.height()+"px",lineHeight:bar.height()+"px"});
};
$.fn.progressbar=function(_1e4,_1e5){
if(typeof _1e4=="string"){
var _1e6=$.fn.progressbar.methods[_1e4];
if(_1e6){
return _1e6(this,_1e5);
}
}
_1e4=_1e4||{};
return this.each(function(){
var _1e7=$.data(this,"progressbar");
if(_1e7){
$.extend(_1e7.options,_1e4);
}else{
_1e7=$.data(this,"progressbar",{options:$.extend({},$.fn.progressbar.defaults,$.fn.progressbar.parseOptions(this),_1e4),bar:init(this)});
}
$(this).progressbar("setValue",_1e7.options.value);
_1e1(this);
});
};
$.fn.progressbar.methods={options:function(jq){
return $.data(jq[0],"progressbar").options;
},resize:function(jq,_1e8){
return jq.each(function(){
_1e1(this,_1e8);
});
},getValue:function(jq){
return $.data(jq[0],"progressbar").options.value;
},setValue:function(jq,_1e9){
if(_1e9<0){
_1e9=0;
}
if(_1e9>100){
_1e9=100;
}
return jq.each(function(){
var opts=$.data(this,"progressbar").options;
var text=opts.text.replace(/{value}/,_1e9);
var _1ea=opts.value;
opts.value=_1e9;
$(this).find("div.progressbar-value").width(_1e9+"%");
$(this).find("div.progressbar-text").html(text);
if(_1ea!=_1e9){
opts.onChange.call(this,_1e9,_1ea);
}
});
}};
$.fn.progressbar.parseOptions=function(_1eb){
return $.extend({},$.parser.parseOptions(_1eb,["width","height","text",{value:"number"}]));
};
$.fn.progressbar.defaults={width:"auto",height:22,value:0,text:"{value}%",onChange:function(_1ec,_1ed){
}};
})(jQuery);
(function($){
function init(_1ee){
$(_1ee).addClass("tooltip-f");
};
function _1ef(_1f0){
var opts=$.data(_1f0,"tooltip").options;
$(_1f0).unbind(".tooltip").bind(opts.showEvent+".tooltip",function(e){
$(_1f0).tooltip("show",e);
}).bind(opts.hideEvent+".tooltip",function(e){
$(_1f0).tooltip("hide",e);
}).bind("mousemove.tooltip",function(e){
if(opts.trackMouse){
opts.trackMouseX=e.pageX;
opts.trackMouseY=e.pageY;
$(_1f0).tooltip("reposition");
}
});
};
function _1f1(_1f2){
var _1f3=$.data(_1f2,"tooltip");
if(_1f3.showTimer){
clearTimeout(_1f3.showTimer);
_1f3.showTimer=null;
}
if(_1f3.hideTimer){
clearTimeout(_1f3.hideTimer);
_1f3.hideTimer=null;
}
};
function _1f4(_1f5){
var _1f6=$.data(_1f5,"tooltip");
if(!_1f6||!_1f6.tip){
return;
}
var opts=_1f6.options;
var tip=_1f6.tip;
var pos={left:-100000,top:-100000};
if($(_1f5).is(":visible")){
pos=_1f7(opts.position);
if(opts.position=="top"&&pos.top<0){
pos=_1f7("bottom");
}else{
if((opts.position=="bottom")&&(pos.top+tip._outerHeight()>$(window)._outerHeight()+$(document).scrollTop())){
pos=_1f7("top");
}
}
if(pos.left<0){
if(opts.position=="left"){
pos=_1f7("right");
}else{
$(_1f5).tooltip("arrow").css("left",tip._outerWidth()/2+pos.left);
pos.left=0;
}
}else{
if(pos.left+tip._outerWidth()>$(window)._outerWidth()+$(document)._scrollLeft()){
if(opts.position=="right"){
pos=_1f7("left");
}else{
var left=pos.left;
pos.left=$(window)._outerWidth()+$(document)._scrollLeft()-tip._outerWidth();
$(_1f5).tooltip("arrow").css("left",tip._outerWidth()/2-(pos.left-left));
}
}
}
}
tip.css({left:pos.left,top:pos.top,zIndex:(opts.zIndex!=undefined?opts.zIndex:($.fn.window?$.fn.window.defaults.zIndex++:""))});
opts.onPosition.call(_1f5,pos.left,pos.top);
function _1f7(_1f8){
opts.position=_1f8||"bottom";
tip.removeClass("tooltip-top tooltip-bottom tooltip-left tooltip-right").addClass("tooltip-"+opts.position);
var left,top;
if(opts.trackMouse){
t=$();
left=opts.trackMouseX+opts.deltaX;
top=opts.trackMouseY+opts.deltaY;
}else{
var t=$(_1f5);
left=t.offset().left+opts.deltaX;
top=t.offset().top+opts.deltaY;
}
switch(opts.position){
case "right":
left+=t._outerWidth()+12+(opts.trackMouse?12:0);
top-=(tip._outerHeight()-t._outerHeight())/2;
break;
case "left":
left-=tip._outerWidth()+12+(opts.trackMouse?12:0);
top-=(tip._outerHeight()-t._outerHeight())/2;
break;
case "top":
left-=(tip._outerWidth()-t._outerWidth())/2;
top-=tip._outerHeight()+12+(opts.trackMouse?12:0);
break;
case "bottom":
left-=(tip._outerWidth()-t._outerWidth())/2;
top+=t._outerHeight()+12+(opts.trackMouse?12:0);
break;
}
return {left:left,top:top};
};
};
function _1f9(_1fa,e){
var _1fb=$.data(_1fa,"tooltip");
var opts=_1fb.options;
var tip=_1fb.tip;
if(!tip){
tip=$("<div tabindex=\"-1\" class=\"tooltip\">"+"<div class=\"tooltip-content\"></div>"+"<div class=\"tooltip-arrow-outer\"></div>"+"<div class=\"tooltip-arrow\"></div>"+"</div>").appendTo("body");
_1fb.tip=tip;
_1fc(_1fa);
}
_1f1(_1fa);
_1fb.showTimer=setTimeout(function(){
$(_1fa).tooltip("reposition");
tip.show();
opts.onShow.call(_1fa,e);
var _1fd=tip.children(".tooltip-arrow-outer");
var _1fe=tip.children(".tooltip-arrow");
var bc="border-"+opts.position+"-color";
_1fd.add(_1fe).css({borderTopColor:"",borderBottomColor:"",borderLeftColor:"",borderRightColor:""});
_1fd.css(bc,tip.css(bc));
_1fe.css(bc,tip.css("backgroundColor"));
},opts.showDelay);
};
function _1ff(_200,e){
var _201=$.data(_200,"tooltip");
if(_201&&_201.tip){
_1f1(_200);
_201.hideTimer=setTimeout(function(){
_201.tip.hide();
_201.options.onHide.call(_200,e);
},_201.options.hideDelay);
}
};
function _1fc(_202,_203){
var _204=$.data(_202,"tooltip");
var opts=_204.options;
if(_203){
opts.content=_203;
}
if(!_204.tip){
return;
}
var cc=typeof opts.content=="function"?opts.content.call(_202):opts.content;
_204.tip.children(".tooltip-content").html(cc);
opts.onUpdate.call(_202,cc);
};
function _205(_206){
var _207=$.data(_206,"tooltip");
if(_207){
_1f1(_206);
var opts=_207.options;
if(_207.tip){
_207.tip.remove();
}
if(opts._title){
$(_206).attr("title",opts._title);
}
$.removeData(_206,"tooltip");
$(_206).unbind(".tooltip").removeClass("tooltip-f");
opts.onDestroy.call(_206);
}
};
$.fn.tooltip=function(_208,_209){
if(typeof _208=="string"){
return $.fn.tooltip.methods[_208](this,_209);
}
_208=_208||{};
return this.each(function(){
var _20a=$.data(this,"tooltip");
if(_20a){
$.extend(_20a.options,_208);
}else{
$.data(this,"tooltip",{options:$.extend({},$.fn.tooltip.defaults,$.fn.tooltip.parseOptions(this),_208)});
init(this);
}
_1ef(this);
_1fc(this);
});
};
$.fn.tooltip.methods={options:function(jq){
return $.data(jq[0],"tooltip").options;
},tip:function(jq){
return $.data(jq[0],"tooltip").tip;
},arrow:function(jq){
return jq.tooltip("tip").children(".tooltip-arrow-outer,.tooltip-arrow");
},show:function(jq,e){
return jq.each(function(){
_1f9(this,e);
});
},hide:function(jq,e){
return jq.each(function(){
_1ff(this,e);
});
},update:function(jq,_20b){
return jq.each(function(){
_1fc(this,_20b);
});
},reposition:function(jq){
return jq.each(function(){
_1f4(this);
});
},destroy:function(jq){
return jq.each(function(){
_205(this);
});
}};
$.fn.tooltip.parseOptions=function(_20c){
var t=$(_20c);
var opts=$.extend({},$.parser.parseOptions(_20c,["position","showEvent","hideEvent","content",{trackMouse:"boolean",deltaX:"number",deltaY:"number",showDelay:"number",hideDelay:"number"}]),{_title:t.attr("title")});
t.attr("title","");
if(!opts.content){
opts.content=opts._title;
}
return opts;
};
$.fn.tooltip.defaults={position:"bottom",content:null,trackMouse:false,deltaX:0,deltaY:0,showEvent:"mouseenter",hideEvent:"mouseleave",showDelay:200,hideDelay:100,onShow:function(e){
},onHide:function(e){
},onUpdate:function(_20d){
},onPosition:function(left,top){
},onDestroy:function(){
}};
})(jQuery);
(function($){
$.fn._remove=function(){
return this.each(function(){
$(this).remove();
try{
this.outerHTML="";
}
catch(err){
}
});
};
function _20e(node){
node._remove();
};
function _20f(_210,_211){
var _212=$.data(_210,"panel");
var opts=_212.options;
var _213=_212.panel;
var _214=_213.children(".panel-header");
var _215=_213.children(".panel-body");
var _216=_213.children(".panel-footer");
if(_211){
$.extend(opts,{width:_211.width,height:_211.height,minWidth:_211.minWidth,maxWidth:_211.maxWidth,minHeight:_211.minHeight,maxHeight:_211.maxHeight,left:_211.left,top:_211.top});
}
_213._size(opts);
_214.add(_215)._outerWidth(_213.width());
if(!isNaN(parseInt(opts.height))){
_215._outerHeight(_213.height()-_214._outerHeight()-_216._outerHeight());
}else{
_215.css("height","");
var min=$.parser.parseValue("minHeight",opts.minHeight,_213.parent());
var max=$.parser.parseValue("maxHeight",opts.maxHeight,_213.parent());
var _217=_214._outerHeight()+_216._outerHeight()+_213._outerHeight()-_213.height();
_215._size("minHeight",min?(min-_217):"");
_215._size("maxHeight",max?(max-_217):"");
}
_213.css({height:"",minHeight:"",maxHeight:"",left:opts.left,top:opts.top});
opts.onResize.apply(_210,[opts.width,opts.height]);
$(_210).panel("doLayout");
};
function _218(_219,_21a){
var opts=$.data(_219,"panel").options;
var _21b=$.data(_219,"panel").panel;
if(_21a){
if(_21a.left!=null){
opts.left=_21a.left;
}
if(_21a.top!=null){
opts.top=_21a.top;
}
}
_21b.css({left:opts.left,top:opts.top});
opts.onMove.apply(_219,[opts.left,opts.top]);
};
function _21c(_21d){
$(_21d).addClass("panel-body")._size("clear");
var _21e=$("<div class=\"panel\"></div>").insertBefore(_21d);
_21e[0].appendChild(_21d);
_21e.bind("_resize",function(e,_21f){
if($(this).hasClass("easyui-fluid")||_21f){
_20f(_21d);
}
return false;
});
return _21e;
};
function _220(_221){
var _222=$.data(_221,"panel");
var opts=_222.options;
var _223=_222.panel;
_223.css(opts.style);
_223.addClass(opts.cls);
_224();
_225();
var _226=$(_221).panel("header");
var body=$(_221).panel("body");
var _227=$(_221).siblings(".panel-footer");
if(opts.border){
_226.removeClass("panel-header-noborder");
body.removeClass("panel-body-noborder");
_227.removeClass("panel-footer-noborder");
}else{
_226.addClass("panel-header-noborder");
body.addClass("panel-body-noborder");
_227.addClass("panel-footer-noborder");
}
_226.addClass(opts.headerCls);
body.addClass(opts.bodyCls);
$(_221).attr("id",opts.id||"");
if(opts.content){
$(_221).panel("clear");
$(_221).html(opts.content);
$.parser.parse($(_221));
}
function _224(){
if(opts.noheader||(!opts.title&&!opts.header)){
_20e(_223.children(".panel-header"));
_223.children(".panel-body").addClass("panel-body-noheader");
}else{
if(opts.header){
$(opts.header).addClass("panel-header").prependTo(_223);
}else{
var _228=_223.children(".panel-header");
if(!_228.length){
_228=$("<div class=\"panel-header\"></div>").prependTo(_223);
}
if(!$.isArray(opts.tools)){
_228.find("div.panel-tool .panel-tool-a").appendTo(opts.tools);
}
_228.empty();
var _229=$("<div class=\"panel-title\"></div>").html(opts.title).appendTo(_228);
if(opts.iconCls){
_229.addClass("panel-with-icon");
$("<div class=\"panel-icon\"></div>").addClass(opts.iconCls).appendTo(_228);
}
var tool=$("<div class=\"panel-tool\"></div>").appendTo(_228);
tool.bind("click",function(e){
e.stopPropagation();
});
if(opts.tools){
if($.isArray(opts.tools)){
$.map(opts.tools,function(t){
_22a(tool,t.iconCls,eval(t.handler));
});
}else{
$(opts.tools).children().each(function(){
$(this).addClass($(this).attr("iconCls")).addClass("panel-tool-a").appendTo(tool);
});
}
}
if(opts.collapsible){
_22a(tool,"panel-tool-collapse",function(){
if(opts.collapsed==true){
_248(_221,true);
}else{
_23b(_221,true);
}
});
}
if(opts.minimizable){
_22a(tool,"panel-tool-min",function(){
_24e(_221);
});
}
if(opts.maximizable){
_22a(tool,"panel-tool-max",function(){
if(opts.maximized==true){
_251(_221);
}else{
_23a(_221);
}
});
}
if(opts.closable){
_22a(tool,"panel-tool-close",function(){
_23c(_221);
});
}
}
_223.children("div.panel-body").removeClass("panel-body-noheader");
}
};
function _22a(c,icon,_22b){
var a=$("<a href=\"javascript:void(0)\"></a>").addClass(icon).appendTo(c);
a.bind("click",_22b);
};
function _225(){
if(opts.footer){
$(opts.footer).addClass("panel-footer").appendTo(_223);
$(_221).addClass("panel-body-nobottom");
}else{
_223.children(".panel-footer").remove();
$(_221).removeClass("panel-body-nobottom");
}
};
};
function _22c(_22d,_22e){
var _22f=$.data(_22d,"panel");
var opts=_22f.options;
if(_230){
opts.queryParams=_22e;
}
if(!opts.href){
return;
}
if(!_22f.isLoaded||!opts.cache){
var _230=$.extend({},opts.queryParams);
if(opts.onBeforeLoad.call(_22d,_230)==false){
return;
}
_22f.isLoaded=false;
$(_22d).panel("clear");
if(opts.loadingMessage){
$(_22d).html($("<div class=\"panel-loading\"></div>").html(opts.loadingMessage));
}
opts.loader.call(_22d,_230,function(data){
var _231=opts.extractor.call(_22d,data);
$(_22d).html(_231);
$.parser.parse($(_22d));
opts.onLoad.apply(_22d,arguments);
_22f.isLoaded=true;
},function(){
opts.onLoadError.apply(_22d,arguments);
});
}
};
function _232(_233){
var t=$(_233);
t.find(".combo-f").each(function(){
$(this).combo("destroy");
});
t.find(".m-btn").each(function(){
$(this).menubutton("destroy");
});
t.find(".s-btn").each(function(){
$(this).splitbutton("destroy");
});
t.find(".tooltip-f").each(function(){
$(this).tooltip("destroy");
});
t.children("div").each(function(){
$(this)._size("unfit");
});
t.empty();
};
function _234(_235){
$(_235).panel("doLayout",true);
};
function _236(_237,_238){
var opts=$.data(_237,"panel").options;
var _239=$.data(_237,"panel").panel;
if(_238!=true){
if(opts.onBeforeOpen.call(_237)==false){
return;
}
}
_239.stop(true,true);
if($.isFunction(opts.openAnimation)){
opts.openAnimation.call(_237,cb);
}else{
switch(opts.openAnimation){
case "slide":
_239.slideDown(opts.openDuration,cb);
break;
case "fade":
_239.fadeIn(opts.openDuration,cb);
break;
case "show":
_239.show(opts.openDuration,cb);
break;
default:
_239.show();
cb();
}
}
function cb(){
opts.closed=false;
opts.minimized=false;
var tool=_239.children(".panel-header").find("a.panel-tool-restore");
if(tool.length){
opts.maximized=true;
}
opts.onOpen.call(_237);
if(opts.maximized==true){
opts.maximized=false;
_23a(_237);
}
if(opts.collapsed==true){
opts.collapsed=false;
_23b(_237);
}
if(!opts.collapsed){
_22c(_237);
_234(_237);
}
};
};
function _23c(_23d,_23e){
var opts=$.data(_23d,"panel").options;
var _23f=$.data(_23d,"panel").panel;
if(_23e!=true){
if(opts.onBeforeClose.call(_23d)==false){
return;
}
}
_23f.stop(true,true);
_23f._size("unfit");
if($.isFunction(opts.closeAnimation)){
opts.closeAnimation.call(_23d,cb);
}else{
switch(opts.closeAnimation){
case "slide":
_23f.slideUp(opts.closeDuration,cb);
break;
case "fade":
_23f.fadeOut(opts.closeDuration,cb);
break;
case "hide":
_23f.hide(opts.closeDuration,cb);
break;
default:
_23f.hide();
cb();
}
}
function cb(){
opts.closed=true;
opts.onClose.call(_23d);
};
};
function _240(_241,_242){
var _243=$.data(_241,"panel");
var opts=_243.options;
var _244=_243.panel;
if(_242!=true){
if(opts.onBeforeDestroy.call(_241)==false){
return;
}
}
$(_241).panel("clear").panel("clear","footer");
_20e(_244);
opts.onDestroy.call(_241);
};
function _23b(_245,_246){
var opts=$.data(_245,"panel").options;
var _247=$.data(_245,"panel").panel;
var body=_247.children(".panel-body");
var tool=_247.children(".panel-header").find("a.panel-tool-collapse");
if(opts.collapsed==true){
return;
}
body.stop(true,true);
if(opts.onBeforeCollapse.call(_245)==false){
return;
}
tool.addClass("panel-tool-expand");
if(_246==true){
body.slideUp("normal",function(){
opts.collapsed=true;
opts.onCollapse.call(_245);
});
}else{
body.hide();
opts.collapsed=true;
opts.onCollapse.call(_245);
}
};
function _248(_249,_24a){
var opts=$.data(_249,"panel").options;
var _24b=$.data(_249,"panel").panel;
var body=_24b.children(".panel-body");
var tool=_24b.children(".panel-header").find("a.panel-tool-collapse");
if(opts.collapsed==false){
return;
}
body.stop(true,true);
if(opts.onBeforeExpand.call(_249)==false){
return;
}
tool.removeClass("panel-tool-expand");
if(_24a==true){
body.slideDown("normal",function(){
opts.collapsed=false;
opts.onExpand.call(_249);
_22c(_249);
_234(_249);
});
}else{
body.show();
opts.collapsed=false;
opts.onExpand.call(_249);
_22c(_249);
_234(_249);
}
};
function _23a(_24c){
var opts=$.data(_24c,"panel").options;
var _24d=$.data(_24c,"panel").panel;
var tool=_24d.children(".panel-header").find("a.panel-tool-max");
if(opts.maximized==true){
return;
}
tool.addClass("panel-tool-restore");
if(!$.data(_24c,"panel").original){
$.data(_24c,"panel").original={width:opts.width,height:opts.height,left:opts.left,top:opts.top,fit:opts.fit};
}
opts.left=0;
opts.top=0;
opts.fit=true;
_20f(_24c);
opts.minimized=false;
opts.maximized=true;
opts.onMaximize.call(_24c);
};
function _24e(_24f){
var opts=$.data(_24f,"panel").options;
var _250=$.data(_24f,"panel").panel;
_250._size("unfit");
_250.hide();
opts.minimized=true;
opts.maximized=false;
opts.onMinimize.call(_24f);
};
function _251(_252){
var opts=$.data(_252,"panel").options;
var _253=$.data(_252,"panel").panel;
var tool=_253.children(".panel-header").find("a.panel-tool-max");
if(opts.maximized==false){
return;
}
_253.show();
tool.removeClass("panel-tool-restore");
$.extend(opts,$.data(_252,"panel").original);
_20f(_252);
opts.minimized=false;
opts.maximized=false;
$.data(_252,"panel").original=null;
opts.onRestore.call(_252);
};
function _254(_255,_256){
$.data(_255,"panel").options.title=_256;
$(_255).panel("header").find("div.panel-title").html(_256);
};
var _257=null;
$(window).unbind(".panel").bind("resize.panel",function(){
if(_257){
clearTimeout(_257);
}
_257=setTimeout(function(){
var _258=$("body.layout");
if(_258.length){
_258.layout("resize");
$("body").children(".easyui-fluid:visible").each(function(){
$(this).triggerHandler("_resize");
});
}else{
$("body").panel("doLayout");
}
_257=null;
},100);
});
$.fn.panel=function(_259,_25a){
if(typeof _259=="string"){
return $.fn.panel.methods[_259](this,_25a);
}
_259=_259||{};
return this.each(function(){
var _25b=$.data(this,"panel");
var opts;
if(_25b){
opts=$.extend(_25b.options,_259);
_25b.isLoaded=false;
}else{
opts=$.extend({},$.fn.panel.defaults,$.fn.panel.parseOptions(this),_259);
$(this).attr("title","");
_25b=$.data(this,"panel",{options:opts,panel:_21c(this),isLoaded:false});
}
_220(this);
$(this).show();
if(opts.doSize==true){
_25b.panel.css("display","block");
_20f(this);
}
if(opts.closed==true||opts.minimized==true){
_25b.panel.hide();
}else{
_236(this);
}
});
};
$.fn.panel.methods={options:function(jq){
return $.data(jq[0],"panel").options;
},panel:function(jq){
return $.data(jq[0],"panel").panel;
},header:function(jq){
return $.data(jq[0],"panel").panel.children(".panel-header");
},footer:function(jq){
return jq.panel("panel").children(".panel-footer");
},body:function(jq){
return $.data(jq[0],"panel").panel.children(".panel-body");
},setTitle:function(jq,_25c){
return jq.each(function(){
_254(this,_25c);
});
},open:function(jq,_25d){
return jq.each(function(){
_236(this,_25d);
});
},close:function(jq,_25e){
return jq.each(function(){
_23c(this,_25e);
});
},destroy:function(jq,_25f){
return jq.each(function(){
_240(this,_25f);
});
},clear:function(jq,type){
return jq.each(function(){
_232(type=="footer"?$(this).panel("footer"):this);
});
},refresh:function(jq,href){
return jq.each(function(){
var _260=$.data(this,"panel");
_260.isLoaded=false;
if(href){
if(typeof href=="string"){
_260.options.href=href;
}else{
_260.options.queryParams=href;
}
}
_22c(this);
});
},resize:function(jq,_261){
return jq.each(function(){
_20f(this,_261);
});
},doLayout:function(jq,all){
return jq.each(function(){
_262(this,"body");
_262($(this).siblings(".panel-footer")[0],"footer");
function _262(_263,type){
if(!_263){
return;
}
var _264=_263==$("body")[0];
var s=$(_263).find("div.panel:visible,div.accordion:visible,div.tabs-container:visible,div.layout:visible,.easyui-fluid:visible").filter(function(_265,el){
var p=$(el).parents(".panel-"+type+":first");
return _264?p.length==0:p[0]==_263;
});
s.each(function(){
$(this).triggerHandler("_resize",[all||false]);
});
};
});
},move:function(jq,_266){
return jq.each(function(){
_218(this,_266);
});
},maximize:function(jq){
return jq.each(function(){
_23a(this);
});
},minimize:function(jq){
return jq.each(function(){
_24e(this);
});
},restore:function(jq){
return jq.each(function(){
_251(this);
});
},collapse:function(jq,_267){
return jq.each(function(){
_23b(this,_267);
});
},expand:function(jq,_268){
return jq.each(function(){
_248(this,_268);
});
}};
$.fn.panel.parseOptions=function(_269){
var t=$(_269);
var hh=t.children(".panel-header,header");
var ff=t.children(".panel-footer,footer");
return $.extend({},$.parser.parseOptions(_269,["id","width","height","left","top","title","iconCls","cls","headerCls","bodyCls","tools","href","method","header","footer",{cache:"boolean",fit:"boolean",border:"boolean",noheader:"boolean"},{collapsible:"boolean",minimizable:"boolean",maximizable:"boolean"},{closable:"boolean",collapsed:"boolean",minimized:"boolean",maximized:"boolean",closed:"boolean"},"openAnimation","closeAnimation",{openDuration:"number",closeDuration:"number"},]),{loadingMessage:(t.attr("loadingMessage")!=undefined?t.attr("loadingMessage"):undefined),header:(hh.length?hh.removeClass("panel-header"):undefined),footer:(ff.length?ff.removeClass("panel-footer"):undefined)});
};
$.fn.panel.defaults={id:null,title:null,iconCls:null,width:"auto",height:"auto",left:null,top:null,cls:null,headerCls:null,bodyCls:null,style:{},href:null,cache:true,fit:false,border:true,doSize:true,noheader:false,content:null,collapsible:false,minimizable:false,maximizable:false,closable:false,collapsed:false,minimized:false,maximized:false,closed:false,openAnimation:false,openDuration:400,closeAnimation:false,closeDuration:400,tools:null,footer:null,header:null,queryParams:{},method:"get",href:null,loadingMessage:"Loading...",loader:function(_26a,_26b,_26c){
var opts=$(this).panel("options");
if(!opts.href){
return false;
}
$.ajax({type:opts.method,url:opts.href,cache:false,data:_26a,dataType:"html",success:function(data){
_26b(data);
},error:function(){
_26c.apply(this,arguments);
}});
},extractor:function(data){
var _26d=/<body[^>]*>((.|[\n\r])*)<\/body>/im;
var _26e=_26d.exec(data);
if(_26e){
return _26e[1];
}else{
return data;
}
},onBeforeLoad:function(_26f){
},onLoad:function(){
},onLoadError:function(){
},onBeforeOpen:function(){
},onOpen:function(){
},onBeforeClose:function(){
},onClose:function(){
},onBeforeDestroy:function(){
},onDestroy:function(){
},onResize:function(_270,_271){
},onMove:function(left,top){
},onMaximize:function(){
},onRestore:function(){
},onMinimize:function(){
},onBeforeCollapse:function(){
},onBeforeExpand:function(){
},onCollapse:function(){
},onExpand:function(){
}};
})(jQuery);
(function($){
function _272(_273,_274){
var _275=$.data(_273,"window");
if(_274){
if(_274.left!=null){
_275.options.left=_274.left;
}
if(_274.top!=null){
_275.options.top=_274.top;
}
}
$(_273).panel("move",_275.options);
if(_275.shadow){
_275.shadow.css({left:_275.options.left,top:_275.options.top});
}
};
function _276(_277,_278){
var opts=$.data(_277,"window").options;
var pp=$(_277).window("panel");
var _279=pp._outerWidth();
if(opts.inline){
var _27a=pp.parent();
opts.left=Math.ceil((_27a.width()-_279)/2+_27a.scrollLeft());
}else{
opts.left=Math.ceil(($(window)._outerWidth()-_279)/2+$(document).scrollLeft());
}
if(_278){
_272(_277);
}
};
function _27b(_27c,_27d){
var opts=$.data(_27c,"window").options;
var pp=$(_27c).window("panel");
var _27e=pp._outerHeight();
if(opts.inline){
var _27f=pp.parent();
opts.top=Math.ceil((_27f.height()-_27e)/2+_27f.scrollTop());
}else{
opts.top=Math.ceil(($(window)._outerHeight()-_27e)/2+$(document).scrollTop());
}
if(_27d){
_272(_27c);
}
};
function _280(_281){
var _282=$.data(_281,"window");
var opts=_282.options;
var win=$(_281).panel($.extend({},_282.options,{border:false,doSize:true,closed:true,cls:"window "+(!opts.border?"window-thinborder window-noborder ":(opts.border=="thin"?"window-thinborder ":""))+(opts.cls||""),headerCls:"window-header "+(opts.headerCls||""),bodyCls:"window-body "+(opts.noheader?"window-body-noheader ":" ")+(opts.bodyCls||""),onBeforeDestroy:function(){
if(opts.onBeforeDestroy.call(_281)==false){
return false;
}
if(_282.shadow){
_282.shadow.remove();
}
if(_282.mask){
_282.mask.remove();
}
},onClose:function(){
if(_282.shadow){
_282.shadow.hide();
}
if(_282.mask){
_282.mask.hide();
}
opts.onClose.call(_281);
},onOpen:function(){
if(_282.mask){
_282.mask.css($.extend({display:"block",zIndex:$.fn.window.defaults.zIndex++},$.fn.window.getMaskSize(_281)));
}
if(_282.shadow){
_282.shadow.css({display:"block",zIndex:$.fn.window.defaults.zIndex++,left:opts.left,top:opts.top,width:_282.window._outerWidth(),height:_282.window._outerHeight()});
}
_282.window.css("z-index",$.fn.window.defaults.zIndex++);
opts.onOpen.call(_281);
},onResize:function(_283,_284){
var _285=$(this).panel("options");
$.extend(opts,{width:_285.width,height:_285.height,left:_285.left,top:_285.top});
if(_282.shadow){
_282.shadow.css({left:opts.left,top:opts.top,width:_282.window._outerWidth(),height:_282.window._outerHeight()});
}
opts.onResize.call(_281,_283,_284);
},onMinimize:function(){
if(_282.shadow){
_282.shadow.hide();
}
if(_282.mask){
_282.mask.hide();
}
_282.options.onMinimize.call(_281);
},onBeforeCollapse:function(){
if(opts.onBeforeCollapse.call(_281)==false){
return false;
}
if(_282.shadow){
_282.shadow.hide();
}
},onExpand:function(){
if(_282.shadow){
_282.shadow.show();
}
opts.onExpand.call(_281);
}}));
_282.window=win.panel("panel");
if(_282.mask){
_282.mask.remove();
}
if(opts.modal){
_282.mask=$("<div class=\"window-mask\" style=\"display:none\"></div>").insertAfter(_282.window);
}
if(_282.shadow){
_282.shadow.remove();
}
if(opts.shadow){
_282.shadow=$("<div class=\"window-shadow\" style=\"display:none\"></div>").insertAfter(_282.window);
}
var _286=opts.closed;
if(opts.left==null){
_276(_281);
}
if(opts.top==null){
_27b(_281);
}
_272(_281);
if(!_286){
win.window("open");
}
};
function _287(_288){
var _289=$.data(_288,"window");
_289.window.draggable({handle:">div.panel-header>div.panel-title",disabled:_289.options.draggable==false,onBeforeDrag:function(e){
if(_289.mask){
_289.mask.css("z-index",$.fn.window.defaults.zIndex++);
}
if(_289.shadow){
_289.shadow.css("z-index",$.fn.window.defaults.zIndex++);
}
_289.window.css("z-index",$.fn.window.defaults.zIndex++);
},onStartDrag:function(e){
if(!_289.proxy){
_289.proxy=$("<div class=\"window-proxy\"></div>").insertAfter(_289.window);
}
_289.proxy.css({display:"none",zIndex:$.fn.window.defaults.zIndex++,left:e.data.left,top:e.data.top});
_289.proxy._outerWidth(_289.window._outerWidth());
_289.proxy._outerHeight(_289.window._outerHeight());
setTimeout(function(){
if(_289.proxy){
_289.proxy.show();
}
},500);
},onDrag:function(e){
_289.proxy.css({display:"block",left:e.data.left,top:e.data.top});
return false;
},onStopDrag:function(e){
_289.options.left=e.data.left;
_289.options.top=e.data.top;
$(_288).window("move");
_289.proxy.remove();
_289.proxy=null;
}});
_289.window.resizable({disabled:_289.options.resizable==false,onStartResize:function(e){
if(_289.pmask){
_289.pmask.remove();
}
_289.pmask=$("<div class=\"window-proxy-mask\"></div>").insertAfter(_289.window);
_289.pmask.css({zIndex:$.fn.window.defaults.zIndex++,left:e.data.left,top:e.data.top,width:_289.window._outerWidth(),height:_289.window._outerHeight()});
if(_289.proxy){
_289.proxy.remove();
}
_289.proxy=$("<div class=\"window-proxy\"></div>").insertAfter(_289.window);
_289.proxy.css({zIndex:$.fn.window.defaults.zIndex++,left:e.data.left,top:e.data.top});
_289.proxy._outerWidth(e.data.width)._outerHeight(e.data.height);
},onResize:function(e){
_289.proxy.css({left:e.data.left,top:e.data.top});
_289.proxy._outerWidth(e.data.width);
_289.proxy._outerHeight(e.data.height);
return false;
},onStopResize:function(e){
$(_288).window("resize",e.data);
_289.pmask.remove();
_289.pmask=null;
_289.proxy.remove();
_289.proxy=null;
}});
};
$(window).resize(function(){
$("body>div.window-mask").css({width:$(window)._outerWidth(),height:$(window)._outerHeight()});
setTimeout(function(){
$("body>div.window-mask").css($.fn.window.getMaskSize());
},50);
});
$.fn.window=function(_28a,_28b){
if(typeof _28a=="string"){
var _28c=$.fn.window.methods[_28a];
if(_28c){
return _28c(this,_28b);
}else{
return this.panel(_28a,_28b);
}
}
_28a=_28a||{};
return this.each(function(){
var _28d=$.data(this,"window");
if(_28d){
$.extend(_28d.options,_28a);
}else{
_28d=$.data(this,"window",{options:$.extend({},$.fn.window.defaults,$.fn.window.parseOptions(this),_28a)});
if(!_28d.options.inline){
document.body.appendChild(this);
}
}
_280(this);
_287(this);
});
};
$.fn.window.methods={options:function(jq){
var _28e=jq.panel("options");
var _28f=$.data(jq[0],"window").options;
return $.extend(_28f,{closed:_28e.closed,collapsed:_28e.collapsed,minimized:_28e.minimized,maximized:_28e.maximized});
},window:function(jq){
return $.data(jq[0],"window").window;
},move:function(jq,_290){
return jq.each(function(){
_272(this,_290);
});
},hcenter:function(jq){
return jq.each(function(){
_276(this,true);
});
},vcenter:function(jq){
return jq.each(function(){
_27b(this,true);
});
},center:function(jq){
return jq.each(function(){
_276(this);
_27b(this);
_272(this);
});
}};
$.fn.window.getMaskSize=function(_291){
var _292=$(_291).data("window");
var _293=(_292&&_292.options.inline);
return {width:(_293?"100%":$(document).width()),height:(_293?"100%":$(document).height())};
};
$.fn.window.parseOptions=function(_294){
return $.extend({},$.fn.panel.parseOptions(_294),$.parser.parseOptions(_294,[{draggable:"boolean",resizable:"boolean",shadow:"boolean",modal:"boolean",inline:"boolean"}]));
};
$.fn.window.defaults=$.extend({},$.fn.panel.defaults,{zIndex:9000,draggable:true,resizable:true,shadow:true,modal:false,border:true,inline:false,title:"New Window",collapsible:true,minimizable:true,maximizable:true,closable:true,closed:false});
})(jQuery);
(function($){
function _295(_296){
var opts=$.data(_296,"dialog").options;
opts.inited=false;
$(_296).window($.extend({},opts,{onResize:function(w,h){
if(opts.inited){
_29b(this);
opts.onResize.call(this,w,h);
}
}}));
var win=$(_296).window("window");
if(opts.toolbar){
if($.isArray(opts.toolbar)){
$(_296).siblings("div.dialog-toolbar").remove();
var _297=$("<div class=\"dialog-toolbar\"><table cellspacing=\"0\" cellpadding=\"0\"><tr></tr></table></div>").appendTo(win);
var tr=_297.find("tr");
for(var i=0;i<opts.toolbar.length;i++){
var btn=opts.toolbar[i];
if(btn=="-"){
$("<td><div class=\"dialog-tool-separator\"></div></td>").appendTo(tr);
}else{
var td=$("<td></td>").appendTo(tr);
var tool=$("<a href=\"javascript:void(0)\"></a>").appendTo(td);
tool[0].onclick=eval(btn.handler||function(){
});
tool.linkbutton($.extend({},btn,{plain:true}));
}
}
}else{
$(opts.toolbar).addClass("dialog-toolbar").appendTo(win);
$(opts.toolbar).show();
}
}else{
$(_296).siblings("div.dialog-toolbar").remove();
}
if(opts.buttons){
if($.isArray(opts.buttons)){
$(_296).siblings("div.dialog-button").remove();
var _298=$("<div class=\"dialog-button\"></div>").appendTo(win);
for(var i=0;i<opts.buttons.length;i++){
var p=opts.buttons[i];
var _299=$("<a href=\"javascript:void(0)\"></a>").appendTo(_298);
if(p.handler){
_299[0].onclick=p.handler;
}
_299.linkbutton(p);
}
}else{
$(opts.buttons).addClass("dialog-button").appendTo(win);
$(opts.buttons).show();
}
}else{
$(_296).siblings("div.dialog-button").remove();
}
opts.inited=true;
var _29a=opts.closed;
win.show();
$(_296).window("resize");
if(_29a){
win.hide();
}
};
function _29b(_29c,_29d){
var t=$(_29c);
var opts=t.dialog("options");
var _29e=opts.noheader;
var tb=t.siblings(".dialog-toolbar");
var bb=t.siblings(".dialog-button");
tb.insertBefore(_29c).css({borderTopWidth:(_29e?1:0),top:(_29e?tb.length:0)});
bb.insertAfter(_29c);
tb.add(bb)._outerWidth(t._outerWidth()).find(".easyui-fluid:visible").each(function(){
$(this).triggerHandler("_resize");
});
var _29f=tb._outerHeight()+bb._outerHeight();
if(!isNaN(parseInt(opts.height))){
t._outerHeight(t._outerHeight()-_29f);
}else{
var _2a0=t._size("min-height");
if(_2a0){
t._size("min-height",_2a0-_29f);
}
var _2a1=t._size("max-height");
if(_2a1){
t._size("max-height",_2a1-_29f);
}
}
var _2a2=$.data(_29c,"window").shadow;
if(_2a2){
var cc=t.panel("panel");
_2a2.css({width:cc._outerWidth(),height:cc._outerHeight()});
}
};
$.fn.dialog=function(_2a3,_2a4){
if(typeof _2a3=="string"){
var _2a5=$.fn.dialog.methods[_2a3];
if(_2a5){
return _2a5(this,_2a4);
}else{
return this.window(_2a3,_2a4);
}
}
_2a3=_2a3||{};
return this.each(function(){
var _2a6=$.data(this,"dialog");
if(_2a6){
$.extend(_2a6.options,_2a3);
}else{
$.data(this,"dialog",{options:$.extend({},$.fn.dialog.defaults,$.fn.dialog.parseOptions(this),_2a3)});
}
_295(this);
});
};
$.fn.dialog.methods={options:function(jq){
var _2a7=$.data(jq[0],"dialog").options;
var _2a8=jq.panel("options");
$.extend(_2a7,{width:_2a8.width,height:_2a8.height,left:_2a8.left,top:_2a8.top,closed:_2a8.closed,collapsed:_2a8.collapsed,minimized:_2a8.minimized,maximized:_2a8.maximized});
return _2a7;
},dialog:function(jq){
return jq.window("window");
}};
$.fn.dialog.parseOptions=function(_2a9){
var t=$(_2a9);
return $.extend({},$.fn.window.parseOptions(_2a9),$.parser.parseOptions(_2a9,["toolbar","buttons"]),{toolbar:(t.children(".dialog-toolbar").length?t.children(".dialog-toolbar").removeClass("dialog-toolbar"):undefined),buttons:(t.children(".dialog-button").length?t.children(".dialog-button").removeClass("dialog-button"):undefined)});
};
$.fn.dialog.defaults=$.extend({},$.fn.window.defaults,{title:"New Dialog",collapsible:false,minimizable:false,maximizable:false,resizable:false,toolbar:null,buttons:null});
})(jQuery);
(function($){
function _2aa(){
$(document).unbind(".messager").bind("keydown.messager",function(e){
if(e.keyCode==27){
$("body").children("div.messager-window").children("div.messager-body").each(function(){
$(this).dialog("close");
});
}else{
if(e.keyCode==9){
var win=$("body").children("div.messager-window");
if(!win.length){
return;
}
var _2ab=win.find(".messager-input,.messager-button .l-btn");
for(var i=0;i<_2ab.length;i++){
if($(_2ab[i]).is(":focus")){
$(_2ab[i>=_2ab.length-1?0:i+1]).focus();
return false;
}
}
}else{
if(e.keyCode==13){
var _2ac=$(e.target).closest("input.messager-input");
if(_2ac.length){
var dlg=_2ac.closest(".messager-body");
_2ad(dlg,_2ac.val());
}
}
}
}
});
};
function _2ae(){
$(document).unbind(".messager");
};
function _2af(_2b0){
var opts=$.extend({},$.messager.defaults,{modal:false,shadow:false,draggable:false,resizable:false,closed:true,style:{left:"",top:"",right:0,zIndex:$.fn.window.defaults.zIndex++,bottom:-document.body.scrollTop-document.documentElement.scrollTop},title:"",width:250,height:100,minHeight:0,showType:"slide",showSpeed:600,content:_2b0.msg,timeout:4000},_2b0);
var dlg=$("<div class=\"messager-body\"></div>").appendTo("body");
dlg.dialog($.extend({},opts,{noheader:(opts.title?false:true),openAnimation:(opts.showType),closeAnimation:(opts.showType=="show"?"hide":opts.showType),openDuration:opts.showSpeed,closeDuration:opts.showSpeed,onOpen:function(){
dlg.dialog("dialog").hover(function(){
if(opts.timer){
clearTimeout(opts.timer);
}
},function(){
_2b1();
});
_2b1();
function _2b1(){
if(opts.timeout>0){
opts.timer=setTimeout(function(){
if(dlg.length&&dlg.data("dialog")){
dlg.dialog("close");
}
},opts.timeout);
}
};
if(_2b0.onOpen){
_2b0.onOpen.call(this);
}else{
opts.onOpen.call(this);
}
},onClose:function(){
if(opts.timer){
clearTimeout(opts.timer);
}
if(_2b0.onClose){
_2b0.onClose.call(this);
}else{
opts.onClose.call(this);
}
dlg.dialog("destroy");
}}));
dlg.dialog("dialog").css(opts.style);
dlg.dialog("open");
return dlg;
};
function _2b2(_2b3){
_2aa();
var dlg=$("<div class=\"messager-body\"></div>").appendTo("body");
dlg.dialog($.extend({},_2b3,{noheader:(_2b3.title?false:true),onClose:function(){
_2ae();
if(_2b3.onClose){
_2b3.onClose.call(this);
}
setTimeout(function(){
dlg.dialog("destroy");
},100);
}}));
var win=dlg.dialog("dialog").addClass("messager-window");
win.find(".dialog-button").addClass("messager-button").find("a:first").focus();
return dlg;
};
function _2ad(dlg,_2b4){
dlg.dialog("close");
dlg.dialog("options").fn(_2b4);
};
$.messager={show:function(_2b5){
return _2af(_2b5);
},alert:function(_2b6,msg,icon,fn){
var opts=typeof _2b6=="object"?_2b6:{title:_2b6,msg:msg,icon:icon,fn:fn};
var cls=opts.icon?"messager-icon messager-"+opts.icon:"";
opts=$.extend({},$.messager.defaults,{content:"<div class=\""+cls+"\"></div>"+"<div>"+opts.msg+"</div>"+"<div style=\"clear:both;\"/>"},opts);
if(!opts.buttons){
opts.buttons=[{text:opts.ok,onClick:function(){
_2ad(dlg);
}}];
}
var dlg=_2b2(opts);
return dlg;
},confirm:function(_2b7,msg,fn){
var opts=typeof _2b7=="object"?_2b7:{title:_2b7,msg:msg,fn:fn};
opts=$.extend({},$.messager.defaults,{content:"<div class=\"messager-icon messager-question\"></div>"+"<div>"+opts.msg+"</div>"+"<div style=\"clear:both;\"/>"},opts);
if(!opts.buttons){
opts.buttons=[{text:opts.ok,onClick:function(){
_2ad(dlg,true);
}},{text:opts.cancel,onClick:function(){
_2ad(dlg,false);
}}];
}
var dlg=_2b2(opts);
return dlg;
},prompt:function(_2b8,msg,fn){
var opts=typeof _2b8=="object"?_2b8:{title:_2b8,msg:msg,fn:fn};
opts=$.extend({},$.messager.defaults,{content:"<div class=\"messager-icon messager-question\"></div>"+"<div>"+opts.msg+"</div>"+"<br/>"+"<div style=\"clear:both;\"/>"+"<div><input class=\"messager-input\" type=\"text\"/></div>"},opts);
if(!opts.buttons){
opts.buttons=[{text:opts.ok,onClick:function(){
_2ad(dlg,dlg.find(".messager-input").val());
}},{text:opts.cancel,onClick:function(){
_2ad(dlg);
}}];
}
var dlg=_2b2(opts);
dlg.find(".messager-input").focus();
return dlg;
},progress:function(_2b9){
var _2ba={bar:function(){
return $("body>div.messager-window").find("div.messager-p-bar");
},close:function(){
var dlg=$("body>div.messager-window>div.messager-body:has(div.messager-progress)");
if(dlg.length){
dlg.dialog("close");
}
}};
if(typeof _2b9=="string"){
var _2bb=_2ba[_2b9];
return _2bb();
}
_2b9=_2b9||{};
var opts=$.extend({},{title:"",minHeight:0,content:undefined,msg:"",text:undefined,interval:300},_2b9);
var dlg=_2b2($.extend({},$.messager.defaults,{content:"<div class=\"messager-progress\"><div class=\"messager-p-msg\">"+opts.msg+"</div><div class=\"messager-p-bar\"></div></div>",closable:false,doSize:false},opts,{onClose:function(){
if(this.timer){
clearInterval(this.timer);
}
if(_2b9.onClose){
_2b9.onClose.call(this);
}else{
$.messager.defaults.onClose.call(this);
}
}}));
var bar=dlg.find("div.messager-p-bar");
bar.progressbar({text:opts.text});
dlg.dialog("resize");
if(opts.interval){
dlg[0].timer=setInterval(function(){
var v=bar.progressbar("getValue");
v+=10;
if(v>100){
v=0;
}
bar.progressbar("setValue",v);
},opts.interval);
}
return dlg;
}};
$.messager.defaults=$.extend({},$.fn.dialog.defaults,{ok:"Ok",cancel:"Cancel",width:300,height:"auto",minHeight:150,modal:true,collapsible:false,minimizable:false,maximizable:false,resizable:false,fn:function(){
}});
})(jQuery);
(function($){
function _2bc(_2bd,_2be){
var _2bf=$.data(_2bd,"accordion");
var opts=_2bf.options;
var _2c0=_2bf.panels;
var cc=$(_2bd);
if(_2be){
$.extend(opts,{width:_2be.width,height:_2be.height});
}
cc._size(opts);
var _2c1=0;
var _2c2="auto";
var _2c3=cc.find(">.panel>.accordion-header");
if(_2c3.length){
_2c1=$(_2c3[0]).css("height","")._outerHeight();
}
if(!isNaN(parseInt(opts.height))){
_2c2=cc.height()-_2c1*_2c3.length;
}
_2c4(true,_2c2-_2c4(false)+1);
function _2c4(_2c5,_2c6){
var _2c7=0;
for(var i=0;i<_2c0.length;i++){
var p=_2c0[i];
var h=p.panel("header")._outerHeight(_2c1);
if(p.panel("options").collapsible==_2c5){
var _2c8=isNaN(_2c6)?undefined:(_2c6+_2c1*h.length);
p.panel("resize",{width:cc.width(),height:(_2c5?_2c8:undefined)});
_2c7+=p.panel("panel").outerHeight()-_2c1*h.length;
}
}
return _2c7;
};
};
function _2c9(_2ca,_2cb,_2cc,all){
var _2cd=$.data(_2ca,"accordion").panels;
var pp=[];
for(var i=0;i<_2cd.length;i++){
var p=_2cd[i];
if(_2cb){
if(p.panel("options")[_2cb]==_2cc){
pp.push(p);
}
}else{
if(p[0]==$(_2cc)[0]){
return i;
}
}
}
if(_2cb){
return all?pp:(pp.length?pp[0]:null);
}else{
return -1;
}
};
function _2ce(_2cf){
return _2c9(_2cf,"collapsed",false,true);
};
function _2d0(_2d1){
var pp=_2ce(_2d1);
return pp.length?pp[0]:null;
};
function _2d2(_2d3,_2d4){
return _2c9(_2d3,null,_2d4);
};
function _2d5(_2d6,_2d7){
var _2d8=$.data(_2d6,"accordion").panels;
if(typeof _2d7=="number"){
if(_2d7<0||_2d7>=_2d8.length){
return null;
}else{
return _2d8[_2d7];
}
}
return _2c9(_2d6,"title",_2d7);
};
function _2d9(_2da){
var opts=$.data(_2da,"accordion").options;
var cc=$(_2da);
if(opts.border){
cc.removeClass("accordion-noborder");
}else{
cc.addClass("accordion-noborder");
}
};
function init(_2db){
var _2dc=$.data(_2db,"accordion");
var cc=$(_2db);
cc.addClass("accordion");
_2dc.panels=[];
cc.children("div").each(function(){
var opts=$.extend({},$.parser.parseOptions(this),{selected:($(this).attr("selected")?true:undefined)});
var pp=$(this);
_2dc.panels.push(pp);
_2de(_2db,pp,opts);
});
cc.bind("_resize",function(e,_2dd){
if($(this).hasClass("easyui-fluid")||_2dd){
_2bc(_2db);
}
return false;
});
};
function _2de(_2df,pp,_2e0){
var opts=$.data(_2df,"accordion").options;
pp.panel($.extend({},{collapsible:true,minimizable:false,maximizable:false,closable:false,doSize:false,collapsed:true,headerCls:"accordion-header",bodyCls:"accordion-body"},_2e0,{onBeforeExpand:function(){
if(_2e0.onBeforeExpand){
if(_2e0.onBeforeExpand.call(this)==false){
return false;
}
}
if(!opts.multiple){
var all=$.grep(_2ce(_2df),function(p){
return p.panel("options").collapsible;
});
for(var i=0;i<all.length;i++){
_2e8(_2df,_2d2(_2df,all[i]));
}
}
var _2e1=$(this).panel("header");
_2e1.addClass("accordion-header-selected");
_2e1.find(".accordion-collapse").removeClass("accordion-expand");
},onExpand:function(){
if(_2e0.onExpand){
_2e0.onExpand.call(this);
}
opts.onSelect.call(_2df,$(this).panel("options").title,_2d2(_2df,this));
},onBeforeCollapse:function(){
if(_2e0.onBeforeCollapse){
if(_2e0.onBeforeCollapse.call(this)==false){
return false;
}
}
var _2e2=$(this).panel("header");
_2e2.removeClass("accordion-header-selected");
_2e2.find(".accordion-collapse").addClass("accordion-expand");
},onCollapse:function(){
if(_2e0.onCollapse){
_2e0.onCollapse.call(this);
}
opts.onUnselect.call(_2df,$(this).panel("options").title,_2d2(_2df,this));
}}));
var _2e3=pp.panel("header");
var tool=_2e3.children("div.panel-tool");
tool.children("a.panel-tool-collapse").hide();
var t=$("<a href=\"javascript:void(0)\"></a>").addClass("accordion-collapse accordion-expand").appendTo(tool);
t.bind("click",function(){
_2e4(pp);
return false;
});
pp.panel("options").collapsible?t.show():t.hide();
_2e3.click(function(){
_2e4(pp);
return false;
});
function _2e4(p){
var _2e5=p.panel("options");
if(_2e5.collapsible){
var _2e6=_2d2(_2df,p);
if(_2e5.collapsed){
_2e7(_2df,_2e6);
}else{
_2e8(_2df,_2e6);
}
}
};
};
function _2e7(_2e9,_2ea){
var p=_2d5(_2e9,_2ea);
if(!p){
return;
}
_2eb(_2e9);
var opts=$.data(_2e9,"accordion").options;
p.panel("expand",opts.animate);
};
function _2e8(_2ec,_2ed){
var p=_2d5(_2ec,_2ed);
if(!p){
return;
}
_2eb(_2ec);
var opts=$.data(_2ec,"accordion").options;
p.panel("collapse",opts.animate);
};
function _2ee(_2ef){
var opts=$.data(_2ef,"accordion").options;
var p=_2c9(_2ef,"selected",true);
if(p){
_2f0(_2d2(_2ef,p));
}else{
_2f0(opts.selected);
}
function _2f0(_2f1){
var _2f2=opts.animate;
opts.animate=false;
_2e7(_2ef,_2f1);
opts.animate=_2f2;
};
};
function _2eb(_2f3){
var _2f4=$.data(_2f3,"accordion").panels;
for(var i=0;i<_2f4.length;i++){
_2f4[i].stop(true,true);
}
};
function add(_2f5,_2f6){
var _2f7=$.data(_2f5,"accordion");
var opts=_2f7.options;
var _2f8=_2f7.panels;
if(_2f6.selected==undefined){
_2f6.selected=true;
}
_2eb(_2f5);
var pp=$("<div></div>").appendTo(_2f5);
_2f8.push(pp);
_2de(_2f5,pp,_2f6);
_2bc(_2f5);
opts.onAdd.call(_2f5,_2f6.title,_2f8.length-1);
if(_2f6.selected){
_2e7(_2f5,_2f8.length-1);
}
};
function _2f9(_2fa,_2fb){
var _2fc=$.data(_2fa,"accordion");
var opts=_2fc.options;
var _2fd=_2fc.panels;
_2eb(_2fa);
var _2fe=_2d5(_2fa,_2fb);
var _2ff=_2fe.panel("options").title;
var _300=_2d2(_2fa,_2fe);
if(!_2fe){
return;
}
if(opts.onBeforeRemove.call(_2fa,_2ff,_300)==false){
return;
}
_2fd.splice(_300,1);
_2fe.panel("destroy");
if(_2fd.length){
_2bc(_2fa);
var curr=_2d0(_2fa);
if(!curr){
_2e7(_2fa,0);
}
}
opts.onRemove.call(_2fa,_2ff,_300);
};
$.fn.accordion=function(_301,_302){
if(typeof _301=="string"){
return $.fn.accordion.methods[_301](this,_302);
}
_301=_301||{};
return this.each(function(){
var _303=$.data(this,"accordion");
if(_303){
$.extend(_303.options,_301);
}else{
$.data(this,"accordion",{options:$.extend({},$.fn.accordion.defaults,$.fn.accordion.parseOptions(this),_301),accordion:$(this).addClass("accordion"),panels:[]});
init(this);
}
_2d9(this);
_2bc(this);
_2ee(this);
});
};
$.fn.accordion.methods={options:function(jq){
return $.data(jq[0],"accordion").options;
},panels:function(jq){
return $.data(jq[0],"accordion").panels;
},resize:function(jq,_304){
return jq.each(function(){
_2bc(this,_304);
});
},getSelections:function(jq){
return _2ce(jq[0]);
},getSelected:function(jq){
return _2d0(jq[0]);
},getPanel:function(jq,_305){
return _2d5(jq[0],_305);
},getPanelIndex:function(jq,_306){
return _2d2(jq[0],_306);
},select:function(jq,_307){
return jq.each(function(){
_2e7(this,_307);
});
},unselect:function(jq,_308){
return jq.each(function(){
_2e8(this,_308);
});
},add:function(jq,_309){
return jq.each(function(){
add(this,_309);
});
},remove:function(jq,_30a){
return jq.each(function(){
_2f9(this,_30a);
});
}};
$.fn.accordion.parseOptions=function(_30b){
var t=$(_30b);
return $.extend({},$.parser.parseOptions(_30b,["width","height",{fit:"boolean",border:"boolean",animate:"boolean",multiple:"boolean",selected:"number"}]));
};
$.fn.accordion.defaults={width:"auto",height:"auto",fit:false,border:true,animate:true,multiple:false,selected:0,onSelect:function(_30c,_30d){
},onUnselect:function(_30e,_30f){
},onAdd:function(_310,_311){
},onBeforeRemove:function(_312,_313){
},onRemove:function(_314,_315){
}};
})(jQuery);
(function($){
function _316(c){
var w=0;
$(c).children().each(function(){
w+=$(this).outerWidth(true);
});
return w;
};
function _317(_318){
var opts=$.data(_318,"tabs").options;
if(opts.tabPosition=="left"||opts.tabPosition=="right"||!opts.showHeader){
return;
}
var _319=$(_318).children("div.tabs-header");
var tool=_319.children("div.tabs-tool:not(.tabs-tool-hidden)");
var _31a=_319.children("div.tabs-scroller-left");
var _31b=_319.children("div.tabs-scroller-right");
var wrap=_319.children("div.tabs-wrap");
var _31c=_319.outerHeight();
if(opts.plain){
_31c-=_31c-_319.height();
}
tool._outerHeight(_31c);
var _31d=_316(_319.find("ul.tabs"));
var _31e=_319.width()-tool._outerWidth();
if(_31d>_31e){
_31a.add(_31b).show()._outerHeight(_31c);
if(opts.toolPosition=="left"){
tool.css({left:_31a.outerWidth(),right:""});
wrap.css({marginLeft:_31a.outerWidth()+tool._outerWidth(),marginRight:_31b._outerWidth(),width:_31e-_31a.outerWidth()-_31b.outerWidth()});
}else{
tool.css({left:"",right:_31b.outerWidth()});
wrap.css({marginLeft:_31a.outerWidth(),marginRight:_31b.outerWidth()+tool._outerWidth(),width:_31e-_31a.outerWidth()-_31b.outerWidth()});
}
}else{
_31a.add(_31b).hide();
if(opts.toolPosition=="left"){
tool.css({left:0,right:""});
wrap.css({marginLeft:tool._outerWidth(),marginRight:0,width:_31e});
}else{
tool.css({left:"",right:0});
wrap.css({marginLeft:0,marginRight:tool._outerWidth(),width:_31e});
}
}
};
function _31f(_320){
var opts=$.data(_320,"tabs").options;
var _321=$(_320).children("div.tabs-header");
if(opts.tools){
if(typeof opts.tools=="string"){
$(opts.tools).addClass("tabs-tool").appendTo(_321);
$(opts.tools).show();
}else{
_321.children("div.tabs-tool").remove();
var _322=$("<div class=\"tabs-tool\"><table cellspacing=\"0\" cellpadding=\"0\" style=\"height:100%\"><tr></tr></table></div>").appendTo(_321);
var tr=_322.find("tr");
for(var i=0;i<opts.tools.length;i++){
var td=$("<td></td>").appendTo(tr);
var tool=$("<a href=\"javascript:void(0);\"></a>").appendTo(td);
tool[0].onclick=eval(opts.tools[i].handler||function(){
});
tool.linkbutton($.extend({},opts.tools[i],{plain:true}));
}
}
}else{
_321.children("div.tabs-tool").remove();
}
};
function _323(_324,_325){
var _326=$.data(_324,"tabs");
var opts=_326.options;
var cc=$(_324);
if(!opts.doSize){
return;
}
if(_325){
$.extend(opts,{width:_325.width,height:_325.height});
}
cc._size(opts);
var _327=cc.children("div.tabs-header");
var _328=cc.children("div.tabs-panels");
var wrap=_327.find("div.tabs-wrap");
var ul=wrap.find(".tabs");
ul.children("li").removeClass("tabs-first tabs-last");
ul.children("li:first").addClass("tabs-first");
ul.children("li:last").addClass("tabs-last");
if(opts.tabPosition=="left"||opts.tabPosition=="right"){
_327._outerWidth(opts.showHeader?opts.headerWidth:0);
_328._outerWidth(cc.width()-_327.outerWidth());
_327.add(_328)._size("height",isNaN(parseInt(opts.height))?"":cc.height());
wrap._outerWidth(_327.width());
ul._outerWidth(wrap.width()).css("height","");
}else{
_327.children("div.tabs-scroller-left,div.tabs-scroller-right,div.tabs-tool:not(.tabs-tool-hidden)").css("display",opts.showHeader?"block":"none");
_327._outerWidth(cc.width()).css("height","");
if(opts.showHeader){
_327.css("background-color","");
wrap.css("height","");
}else{
_327.css("background-color","transparent");
_327._outerHeight(0);
wrap._outerHeight(0);
}
ul._outerHeight(opts.tabHeight).css("width","");
ul._outerHeight(ul.outerHeight()-ul.height()-1+opts.tabHeight).css("width","");
_328._size("height",isNaN(parseInt(opts.height))?"":(cc.height()-_327.outerHeight()));
_328._size("width",cc.width());
}
if(_326.tabs.length){
var d1=ul.outerWidth(true)-ul.width();
var li=ul.children("li:first");
var d2=li.outerWidth(true)-li.width();
var _329=_327.width()-_327.children(".tabs-tool:not(.tabs-tool-hidden)")._outerWidth();
var _32a=Math.floor((_329-d1-d2*_326.tabs.length)/_326.tabs.length);
$.map(_326.tabs,function(p){
_32b(p,(opts.justified&&$.inArray(opts.tabPosition,["top","bottom"])>=0)?_32a:undefined);
});
if(opts.justified&&$.inArray(opts.tabPosition,["top","bottom"])>=0){
var _32c=_329-d1-_316(ul);
_32b(_326.tabs[_326.tabs.length-1],_32a+_32c);
}
}
_317(_324);
function _32b(p,_32d){
var _32e=p.panel("options");
var p_t=_32e.tab.find("a.tabs-inner");
var _32d=_32d?_32d:(parseInt(_32e.tabWidth||opts.tabWidth||undefined));
if(_32d){
p_t._outerWidth(_32d);
}else{
p_t.css("width","");
}
p_t._outerHeight(opts.tabHeight);
p_t.css("lineHeight",p_t.height()+"px");
p_t.find(".easyui-fluid:visible").triggerHandler("_resize");
};
};
function _32f(_330){
var opts=$.data(_330,"tabs").options;
var tab=_331(_330);
if(tab){
var _332=$(_330).children("div.tabs-panels");
var _333=opts.width=="auto"?"auto":_332.width();
var _334=opts.height=="auto"?"auto":_332.height();
tab.panel("resize",{width:_333,height:_334});
}
};
function _335(_336){
var tabs=$.data(_336,"tabs").tabs;
var cc=$(_336).addClass("tabs-container");
var _337=$("<div class=\"tabs-panels\"></div>").insertBefore(cc);
cc.children("div").each(function(){
_337[0].appendChild(this);
});
cc[0].appendChild(_337[0]);
$("<div class=\"tabs-header\">"+"<div class=\"tabs-scroller-left\"></div>"+"<div class=\"tabs-scroller-right\"></div>"+"<div class=\"tabs-wrap\">"+"<ul class=\"tabs\"></ul>"+"</div>"+"</div>").prependTo(_336);
cc.children("div.tabs-panels").children("div").each(function(i){
var opts=$.extend({},$.parser.parseOptions(this),{disabled:($(this).attr("disabled")?true:undefined),selected:($(this).attr("selected")?true:undefined)});
_344(_336,opts,$(this));
});
cc.children("div.tabs-header").find(".tabs-scroller-left, .tabs-scroller-right").hover(function(){
$(this).addClass("tabs-scroller-over");
},function(){
$(this).removeClass("tabs-scroller-over");
});
cc.bind("_resize",function(e,_338){
if($(this).hasClass("easyui-fluid")||_338){
_323(_336);
_32f(_336);
}
return false;
});
};
function _339(_33a){
var _33b=$.data(_33a,"tabs");
var opts=_33b.options;
$(_33a).children("div.tabs-header").unbind().bind("click",function(e){
if($(e.target).hasClass("tabs-scroller-left")){
$(_33a).tabs("scrollBy",-opts.scrollIncrement);
}else{
if($(e.target).hasClass("tabs-scroller-right")){
$(_33a).tabs("scrollBy",opts.scrollIncrement);
}else{
var li=$(e.target).closest("li");
if(li.hasClass("tabs-disabled")){
return false;
}
var a=$(e.target).closest("a.tabs-close");
if(a.length){
_35d(_33a,_33c(li));
}else{
if(li.length){
var _33d=_33c(li);
var _33e=_33b.tabs[_33d].panel("options");
if(_33e.collapsible){
_33e.closed?_354(_33a,_33d):_371(_33a,_33d);
}else{
_354(_33a,_33d);
}
}
}
return false;
}
}
}).bind("contextmenu",function(e){
var li=$(e.target).closest("li");
if(li.hasClass("tabs-disabled")){
return;
}
if(li.length){
opts.onContextMenu.call(_33a,e,li.find("span.tabs-title").html(),_33c(li));
}
});
function _33c(li){
var _33f=0;
li.parent().children("li").each(function(i){
if(li[0]==this){
_33f=i;
return false;
}
});
return _33f;
};
};
function _340(_341){
var opts=$.data(_341,"tabs").options;
var _342=$(_341).children("div.tabs-header");
var _343=$(_341).children("div.tabs-panels");
_342.removeClass("tabs-header-top tabs-header-bottom tabs-header-left tabs-header-right");
_343.removeClass("tabs-panels-top tabs-panels-bottom tabs-panels-left tabs-panels-right");
if(opts.tabPosition=="top"){
_342.insertBefore(_343);
}else{
if(opts.tabPosition=="bottom"){
_342.insertAfter(_343);
_342.addClass("tabs-header-bottom");
_343.addClass("tabs-panels-top");
}else{
if(opts.tabPosition=="left"){
_342.addClass("tabs-header-left");
_343.addClass("tabs-panels-right");
}else{
if(opts.tabPosition=="right"){
_342.addClass("tabs-header-right");
_343.addClass("tabs-panels-left");
}
}
}
}
if(opts.plain==true){
_342.addClass("tabs-header-plain");
}else{
_342.removeClass("tabs-header-plain");
}
_342.removeClass("tabs-header-narrow").addClass(opts.narrow?"tabs-header-narrow":"");
var tabs=_342.find(".tabs");
tabs.removeClass("tabs-pill").addClass(opts.pill?"tabs-pill":"");
tabs.removeClass("tabs-narrow").addClass(opts.narrow?"tabs-narrow":"");
tabs.removeClass("tabs-justified").addClass(opts.justified?"tabs-justified":"");
if(opts.border==true){
_342.removeClass("tabs-header-noborder");
_343.removeClass("tabs-panels-noborder");
}else{
_342.addClass("tabs-header-noborder");
_343.addClass("tabs-panels-noborder");
}
opts.doSize=true;
};
function _344(_345,_346,pp){
_346=_346||{};
var _347=$.data(_345,"tabs");
var tabs=_347.tabs;
if(_346.index==undefined||_346.index>tabs.length){
_346.index=tabs.length;
}
if(_346.index<0){
_346.index=0;
}
var ul=$(_345).children("div.tabs-header").find("ul.tabs");
var _348=$(_345).children("div.tabs-panels");
var tab=$("<li>"+"<a href=\"javascript:void(0)\" class=\"tabs-inner\">"+"<span class=\"tabs-title\"></span>"+"<span class=\"tabs-icon\"></span>"+"</a>"+"</li>");
if(!pp){
pp=$("<div></div>");
}
if(_346.index>=tabs.length){
tab.appendTo(ul);
pp.appendTo(_348);
tabs.push(pp);
}else{
tab.insertBefore(ul.children("li:eq("+_346.index+")"));
pp.insertBefore(_348.children("div.panel:eq("+_346.index+")"));
tabs.splice(_346.index,0,pp);
}
pp.panel($.extend({},_346,{tab:tab,border:false,noheader:true,closed:true,doSize:false,iconCls:(_346.icon?_346.icon:undefined),onLoad:function(){
if(_346.onLoad){
_346.onLoad.call(this,arguments);
}
_347.options.onLoad.call(_345,$(this));
},onBeforeOpen:function(){
if(_346.onBeforeOpen){
if(_346.onBeforeOpen.call(this)==false){
return false;
}
}
var p=$(_345).tabs("getSelected");
if(p){
if(p[0]!=this){
$(_345).tabs("unselect",_34f(_345,p));
p=$(_345).tabs("getSelected");
if(p){
return false;
}
}else{
_32f(_345);
return false;
}
}
var _349=$(this).panel("options");
_349.tab.addClass("tabs-selected");
var wrap=$(_345).find(">div.tabs-header>div.tabs-wrap");
var left=_349.tab.position().left;
var _34a=left+_349.tab.outerWidth();
if(left<0||_34a>wrap.width()){
var _34b=left-(wrap.width()-_349.tab.width())/2;
$(_345).tabs("scrollBy",_34b);
}else{
$(_345).tabs("scrollBy",0);
}
var _34c=$(this).panel("panel");
_34c.css("display","block");
_32f(_345);
_34c.css("display","none");
},onOpen:function(){
if(_346.onOpen){
_346.onOpen.call(this);
}
var _34d=$(this).panel("options");
_347.selectHis.push(_34d.title);
_347.options.onSelect.call(_345,_34d.title,_34f(_345,this));
},onBeforeClose:function(){
if(_346.onBeforeClose){
if(_346.onBeforeClose.call(this)==false){
return false;
}
}
$(this).panel("options").tab.removeClass("tabs-selected");
},onClose:function(){
if(_346.onClose){
_346.onClose.call(this);
}
var _34e=$(this).panel("options");
_347.options.onUnselect.call(_345,_34e.title,_34f(_345,this));
}}));
$(_345).tabs("update",{tab:pp,options:pp.panel("options"),type:"header"});
};
function _350(_351,_352){
var _353=$.data(_351,"tabs");
var opts=_353.options;
if(_352.selected==undefined){
_352.selected=true;
}
_344(_351,_352);
opts.onAdd.call(_351,_352.title,_352.index);
if(_352.selected){
_354(_351,_352.index);
}
};
function _355(_356,_357){
_357.type=_357.type||"all";
var _358=$.data(_356,"tabs").selectHis;
var pp=_357.tab;
var opts=pp.panel("options");
var _359=opts.title;
$.extend(opts,_357.options,{iconCls:(_357.options.icon?_357.options.icon:undefined)});
if(_357.type=="all"||_357.type=="body"){
pp.panel();
}
if(_357.type=="all"||_357.type=="header"){
var tab=opts.tab;
if(opts.header){
tab.find(".tabs-inner").html($(opts.header));
}else{
var _35a=tab.find("span.tabs-title");
var _35b=tab.find("span.tabs-icon");
_35a.html(opts.title);
_35b.attr("class","tabs-icon");
tab.find("a.tabs-close").remove();
if(opts.closable){
_35a.addClass("tabs-closable");
$("<a href=\"javascript:void(0)\" class=\"tabs-close\"></a>").appendTo(tab);
}else{
_35a.removeClass("tabs-closable");
}
if(opts.iconCls){
_35a.addClass("tabs-with-icon");
_35b.addClass(opts.iconCls);
}else{
_35a.removeClass("tabs-with-icon");
}
if(opts.tools){
var _35c=tab.find("span.tabs-p-tool");
if(!_35c.length){
var _35c=$("<span class=\"tabs-p-tool\"></span>").insertAfter(tab.find("a.tabs-inner"));
}
if($.isArray(opts.tools)){
_35c.empty();
for(var i=0;i<opts.tools.length;i++){
var t=$("<a href=\"javascript:void(0)\"></a>").appendTo(_35c);
t.addClass(opts.tools[i].iconCls);
if(opts.tools[i].handler){
t.bind("click",{handler:opts.tools[i].handler},function(e){
if($(this).parents("li").hasClass("tabs-disabled")){
return;
}
e.data.handler.call(this);
});
}
}
}else{
$(opts.tools).children().appendTo(_35c);
}
var pr=_35c.children().length*12;
if(opts.closable){
pr+=8;
}else{
pr-=3;
_35c.css("right","5px");
}
_35a.css("padding-right",pr+"px");
}else{
tab.find("span.tabs-p-tool").remove();
_35a.css("padding-right","");
}
}
if(_359!=opts.title){
for(var i=0;i<_358.length;i++){
if(_358[i]==_359){
_358[i]=opts.title;
}
}
}
}
if(opts.disabled){
opts.tab.addClass("tabs-disabled");
}else{
opts.tab.removeClass("tabs-disabled");
}
_323(_356);
$.data(_356,"tabs").options.onUpdate.call(_356,opts.title,_34f(_356,pp));
};
function _35d(_35e,_35f){
var opts=$.data(_35e,"tabs").options;
var tabs=$.data(_35e,"tabs").tabs;
var _360=$.data(_35e,"tabs").selectHis;
if(!_361(_35e,_35f)){
return;
}
var tab=_362(_35e,_35f);
var _363=tab.panel("options").title;
var _364=_34f(_35e,tab);
if(opts.onBeforeClose.call(_35e,_363,_364)==false){
return;
}
var tab=_362(_35e,_35f,true);
tab.panel("options").tab.remove();
tab.panel("destroy");
opts.onClose.call(_35e,_363,_364);
_323(_35e);
for(var i=0;i<_360.length;i++){
if(_360[i]==_363){
_360.splice(i,1);
i--;
}
}
var _365=_360.pop();
if(_365){
_354(_35e,_365);
}else{
if(tabs.length){
_354(_35e,0);
}
}
};
function _362(_366,_367,_368){
var tabs=$.data(_366,"tabs").tabs;
if(typeof _367=="number"){
if(_367<0||_367>=tabs.length){
return null;
}else{
var tab=tabs[_367];
if(_368){
tabs.splice(_367,1);
}
return tab;
}
}
for(var i=0;i<tabs.length;i++){
var tab=tabs[i];
if(tab.panel("options").title==_367){
if(_368){
tabs.splice(i,1);
}
return tab;
}
}
return null;
};
function _34f(_369,tab){
var tabs=$.data(_369,"tabs").tabs;
for(var i=0;i<tabs.length;i++){
if(tabs[i][0]==$(tab)[0]){
return i;
}
}
return -1;
};
function _331(_36a){
var tabs=$.data(_36a,"tabs").tabs;
for(var i=0;i<tabs.length;i++){
var tab=tabs[i];
if(tab.panel("options").tab.hasClass("tabs-selected")){
return tab;
}
}
return null;
};
function _36b(_36c){
var _36d=$.data(_36c,"tabs");
var tabs=_36d.tabs;
for(var i=0;i<tabs.length;i++){
var opts=tabs[i].panel("options");
if(opts.selected&&!opts.disabled){
_354(_36c,i);
return;
}
}
_354(_36c,_36d.options.selected);
};
function _354(_36e,_36f){
var p=_362(_36e,_36f);
if(p&&!p.is(":visible")){
_370(_36e);
if(!p.panel("options").disabled){
p.panel("open");
}
}
};
function _371(_372,_373){
var p=_362(_372,_373);
if(p&&p.is(":visible")){
_370(_372);
p.panel("close");
}
};
function _370(_374){
$(_374).children("div.tabs-panels").each(function(){
$(this).stop(true,true);
});
};
function _361(_375,_376){
return _362(_375,_376)!=null;
};
function _377(_378,_379){
var opts=$.data(_378,"tabs").options;
opts.showHeader=_379;
$(_378).tabs("resize");
};
function _37a(_37b,_37c){
var tool=$(_37b).find(">.tabs-header>.tabs-tool");
if(_37c){
tool.removeClass("tabs-tool-hidden").show();
}else{
tool.addClass("tabs-tool-hidden").hide();
}
$(_37b).tabs("resize").tabs("scrollBy",0);
};
$.fn.tabs=function(_37d,_37e){
if(typeof _37d=="string"){
return $.fn.tabs.methods[_37d](this,_37e);
}
_37d=_37d||{};
return this.each(function(){
var _37f=$.data(this,"tabs");
if(_37f){
$.extend(_37f.options,_37d);
}else{
$.data(this,"tabs",{options:$.extend({},$.fn.tabs.defaults,$.fn.tabs.parseOptions(this),_37d),tabs:[],selectHis:[]});
_335(this);
}
_31f(this);
_340(this);
_323(this);
_339(this);
_36b(this);
});
};
$.fn.tabs.methods={options:function(jq){
var cc=jq[0];
var opts=$.data(cc,"tabs").options;
var s=_331(cc);
opts.selected=s?_34f(cc,s):-1;
return opts;
},tabs:function(jq){
return $.data(jq[0],"tabs").tabs;
},resize:function(jq,_380){
return jq.each(function(){
_323(this,_380);
_32f(this);
});
},add:function(jq,_381){
return jq.each(function(){
_350(this,_381);
});
},close:function(jq,_382){
return jq.each(function(){
_35d(this,_382);
});
},getTab:function(jq,_383){
return _362(jq[0],_383);
},getTabIndex:function(jq,tab){
return _34f(jq[0],tab);
},getSelected:function(jq){
return _331(jq[0]);
},select:function(jq,_384){
return jq.each(function(){
_354(this,_384);
});
},unselect:function(jq,_385){
return jq.each(function(){
_371(this,_385);
});
},exists:function(jq,_386){
return _361(jq[0],_386);
},update:function(jq,_387){
return jq.each(function(){
_355(this,_387);
});
},enableTab:function(jq,_388){
return jq.each(function(){
var opts=$(this).tabs("getTab",_388).panel("options");
opts.tab.removeClass("tabs-disabled");
opts.disabled=false;
});
},disableTab:function(jq,_389){
return jq.each(function(){
var opts=$(this).tabs("getTab",_389).panel("options");
opts.tab.addClass("tabs-disabled");
opts.disabled=true;
});
},showHeader:function(jq){
return jq.each(function(){
_377(this,true);
});
},hideHeader:function(jq){
return jq.each(function(){
_377(this,false);
});
},showTool:function(jq){
return jq.each(function(){
_37a(this,true);
});
},hideTool:function(jq){
return jq.each(function(){
_37a(this,false);
});
},scrollBy:function(jq,_38a){
return jq.each(function(){
var opts=$(this).tabs("options");
var wrap=$(this).find(">div.tabs-header>div.tabs-wrap");
var pos=Math.min(wrap._scrollLeft()+_38a,_38b());
wrap.animate({scrollLeft:pos},opts.scrollDuration);
function _38b(){
var w=0;
var ul=wrap.children("ul");
ul.children("li").each(function(){
w+=$(this).outerWidth(true);
});
return w-wrap.width()+(ul.outerWidth()-ul.width());
};
});
}};
$.fn.tabs.parseOptions=function(_38c){
return $.extend({},$.parser.parseOptions(_38c,["tools","toolPosition","tabPosition",{fit:"boolean",border:"boolean",plain:"boolean"},{headerWidth:"number",tabWidth:"number",tabHeight:"number",selected:"number"},{showHeader:"boolean",justified:"boolean",narrow:"boolean",pill:"boolean"}]));
};
$.fn.tabs.defaults={width:"auto",height:"auto",headerWidth:150,tabWidth:"auto",tabHeight:27,selected:0,showHeader:true,plain:false,fit:false,border:true,justified:false,narrow:false,pill:false,tools:null,toolPosition:"right",tabPosition:"top",scrollIncrement:100,scrollDuration:400,onLoad:function(_38d){
},onSelect:function(_38e,_38f){
},onUnselect:function(_390,_391){
},onBeforeClose:function(_392,_393){
},onClose:function(_394,_395){
},onAdd:function(_396,_397){
},onUpdate:function(_398,_399){
},onContextMenu:function(e,_39a,_39b){
}};
})(jQuery);
(function($){
var _39c=false;
function _39d(_39e,_39f){
var _3a0=$.data(_39e,"layout");
var opts=_3a0.options;
var _3a1=_3a0.panels;
var cc=$(_39e);
if(_39f){
$.extend(opts,{width:_39f.width,height:_39f.height});
}
if(_39e.tagName.toLowerCase()=="body"){
cc._size("fit");
}else{
cc._size(opts);
}
var cpos={top:0,left:0,width:cc.width(),height:cc.height()};
_3a2(_3a3(_3a1.expandNorth)?_3a1.expandNorth:_3a1.north,"n");
_3a2(_3a3(_3a1.expandSouth)?_3a1.expandSouth:_3a1.south,"s");
_3a4(_3a3(_3a1.expandEast)?_3a1.expandEast:_3a1.east,"e");
_3a4(_3a3(_3a1.expandWest)?_3a1.expandWest:_3a1.west,"w");
_3a1.center.panel("resize",cpos);
function _3a2(pp,type){
if(!pp.length||!_3a3(pp)){
return;
}
var opts=pp.panel("options");
pp.panel("resize",{width:cc.width(),height:opts.height});
var _3a5=pp.panel("panel").outerHeight();
pp.panel("move",{left:0,top:(type=="n"?0:cc.height()-_3a5)});
cpos.height-=_3a5;
if(type=="n"){
cpos.top+=_3a5;
if(!opts.split&&opts.border){
cpos.top--;
}
}
if(!opts.split&&opts.border){
cpos.height++;
}
};
function _3a4(pp,type){
if(!pp.length||!_3a3(pp)){
return;
}
var opts=pp.panel("options");
pp.panel("resize",{width:opts.width,height:cpos.height});
var _3a6=pp.panel("panel").outerWidth();
pp.panel("move",{left:(type=="e"?cc.width()-_3a6:0),top:cpos.top});
cpos.width-=_3a6;
if(type=="w"){
cpos.left+=_3a6;
if(!opts.split&&opts.border){
cpos.left--;
}
}
if(!opts.split&&opts.border){
cpos.width++;
}
};
};
function init(_3a7){
var cc=$(_3a7);
cc.addClass("layout");
function _3a8(cc){
var opts=cc.layout("options");
var _3a9=opts.onAdd;
opts.onAdd=function(){
};
cc.children("div").each(function(){
var _3aa=$.fn.layout.parsePanelOptions(this);
if("north,south,east,west,center".indexOf(_3aa.region)>=0){
_3ac(_3a7,_3aa,this);
}
});
opts.onAdd=_3a9;
};
cc.children("form").length?_3a8(cc.children("form")):_3a8(cc);
cc.append("<div class=\"layout-split-proxy-h\"></div><div class=\"layout-split-proxy-v\"></div>");
cc.bind("_resize",function(e,_3ab){
if($(this).hasClass("easyui-fluid")||_3ab){
_39d(_3a7);
}
return false;
});
};
function _3ac(_3ad,_3ae,el){
_3ae.region=_3ae.region||"center";
var _3af=$.data(_3ad,"layout").panels;
var cc=$(_3ad);
var dir=_3ae.region;
if(_3af[dir].length){
return;
}
var pp=$(el);
if(!pp.length){
pp=$("<div></div>").appendTo(cc);
}
var _3b0=$.extend({},$.fn.layout.paneldefaults,{width:(pp.length?parseInt(pp[0].style.width)||pp.outerWidth():"auto"),height:(pp.length?parseInt(pp[0].style.height)||pp.outerHeight():"auto"),doSize:false,collapsible:true,onOpen:function(){
var tool=$(this).panel("header").children("div.panel-tool");
tool.children("a.panel-tool-collapse").hide();
var _3b1={north:"up",south:"down",east:"right",west:"left"};
if(!_3b1[dir]){
return;
}
var _3b2="layout-button-"+_3b1[dir];
var t=tool.children("a."+_3b2);
if(!t.length){
t=$("<a href=\"javascript:void(0)\"></a>").addClass(_3b2).appendTo(tool);
t.bind("click",{dir:dir},function(e){
_3be(_3ad,e.data.dir);
return false;
});
}
$(this).panel("options").collapsible?t.show():t.hide();
}},_3ae,{cls:((_3ae.cls||"")+" layout-panel layout-panel-"+dir),bodyCls:((_3ae.bodyCls||"")+" layout-body")});
pp.panel(_3b0);
_3af[dir]=pp;
var _3b3={north:"s",south:"n",east:"w",west:"e"};
var _3b4=pp.panel("panel");
if(pp.panel("options").split){
_3b4.addClass("layout-split-"+dir);
}
_3b4.resizable($.extend({},{handles:(_3b3[dir]||""),disabled:(!pp.panel("options").split),onStartResize:function(e){
_39c=true;
if(dir=="north"||dir=="south"){
var _3b5=$(">div.layout-split-proxy-v",_3ad);
}else{
var _3b5=$(">div.layout-split-proxy-h",_3ad);
}
var top=0,left=0,_3b6=0,_3b7=0;
var pos={display:"block"};
if(dir=="north"){
pos.top=parseInt(_3b4.css("top"))+_3b4.outerHeight()-_3b5.height();
pos.left=parseInt(_3b4.css("left"));
pos.width=_3b4.outerWidth();
pos.height=_3b5.height();
}else{
if(dir=="south"){
pos.top=parseInt(_3b4.css("top"));
pos.left=parseInt(_3b4.css("left"));
pos.width=_3b4.outerWidth();
pos.height=_3b5.height();
}else{
if(dir=="east"){
pos.top=parseInt(_3b4.css("top"))||0;
pos.left=parseInt(_3b4.css("left"))||0;
pos.width=_3b5.width();
pos.height=_3b4.outerHeight();
}else{
if(dir=="west"){
pos.top=parseInt(_3b4.css("top"))||0;
pos.left=_3b4.outerWidth()-_3b5.width();
pos.width=_3b5.width();
pos.height=_3b4.outerHeight();
}
}
}
}
_3b5.css(pos);
$("<div class=\"layout-mask\"></div>").css({left:0,top:0,width:cc.width(),height:cc.height()}).appendTo(cc);
},onResize:function(e){
if(dir=="north"||dir=="south"){
var _3b8=$(">div.layout-split-proxy-v",_3ad);
_3b8.css("top",e.pageY-$(_3ad).offset().top-_3b8.height()/2);
}else{
var _3b8=$(">div.layout-split-proxy-h",_3ad);
_3b8.css("left",e.pageX-$(_3ad).offset().left-_3b8.width()/2);
}
return false;
},onStopResize:function(e){
cc.children("div.layout-split-proxy-v,div.layout-split-proxy-h").hide();
pp.panel("resize",e.data);
_39d(_3ad);
_39c=false;
cc.find(">div.layout-mask").remove();
}},_3ae));
cc.layout("options").onAdd.call(_3ad,dir);
};
function _3b9(_3ba,_3bb){
var _3bc=$.data(_3ba,"layout").panels;
if(_3bc[_3bb].length){
_3bc[_3bb].panel("destroy");
_3bc[_3bb]=$();
var _3bd="expand"+_3bb.substring(0,1).toUpperCase()+_3bb.substring(1);
if(_3bc[_3bd]){
_3bc[_3bd].panel("destroy");
_3bc[_3bd]=undefined;
}
$(_3ba).layout("options").onRemove.call(_3ba,_3bb);
}
};
function _3be(_3bf,_3c0,_3c1){
if(_3c1==undefined){
_3c1="normal";
}
var _3c2=$.data(_3bf,"layout").panels;
var p=_3c2[_3c0];
var _3c3=p.panel("options");
if(_3c3.onBeforeCollapse.call(p)==false){
return;
}
var _3c4="expand"+_3c0.substring(0,1).toUpperCase()+_3c0.substring(1);
if(!_3c2[_3c4]){
_3c2[_3c4]=_3c5(_3c0);
var ep=_3c2[_3c4].panel("panel");
if(!_3c3.expandMode){
ep.css("cursor","default");
}else{
ep.bind("click",function(){
if(_3c3.expandMode=="dock"){
_3d0(_3bf,_3c0);
}else{
p.panel("expand",false).panel("open");
var _3c6=_3c7();
p.panel("resize",_3c6.collapse);
p.panel("panel").animate(_3c6.expand,function(){
$(this).unbind(".layout").bind("mouseleave.layout",{region:_3c0},function(e){
if(_39c==true){
return;
}
if($("body>div.combo-p>div.combo-panel:visible").length){
return;
}
_3be(_3bf,e.data.region);
});
$(_3bf).layout("options").onExpand.call(_3bf,_3c0);
});
}
return false;
});
}
}
var _3c8=_3c7();
if(!_3a3(_3c2[_3c4])){
_3c2.center.panel("resize",_3c8.resizeC);
}
p.panel("panel").animate(_3c8.collapse,_3c1,function(){
p.panel("collapse",false).panel("close");
_3c2[_3c4].panel("open").panel("resize",_3c8.expandP);
$(this).unbind(".layout");
$(_3bf).layout("options").onCollapse.call(_3bf,_3c0);
});
function _3c5(dir){
var _3c9={"east":"left","west":"right","north":"down","south":"up"};
var isns=(_3c3.region=="north"||_3c3.region=="south");
var icon="layout-button-"+_3c9[dir];
var p=$("<div></div>").appendTo(_3bf);
p.panel($.extend({},$.fn.layout.paneldefaults,{cls:("layout-expand layout-expand-"+dir),title:"&nbsp;",iconCls:(_3c3.hideCollapsedContent?null:_3c3.iconCls),closed:true,minWidth:0,minHeight:0,doSize:false,region:_3c3.region,collapsedSize:_3c3.collapsedSize,noheader:(!isns&&_3c3.hideExpandTool),tools:((isns&&_3c3.hideExpandTool)?null:[{iconCls:icon,handler:function(){
_3d0(_3bf,_3c0);
return false;
}}])}));
if(!_3c3.hideCollapsedContent){
var _3ca=typeof _3c3.collapsedContent=="function"?_3c3.collapsedContent.call(p[0],_3c3.title):_3c3.collapsedContent;
isns?p.panel("setTitle",_3ca):p.html(_3ca);
}
p.panel("panel").hover(function(){
$(this).addClass("layout-expand-over");
},function(){
$(this).removeClass("layout-expand-over");
});
return p;
};
function _3c7(){
var cc=$(_3bf);
var _3cb=_3c2.center.panel("options");
var _3cc=_3c3.collapsedSize;
if(_3c0=="east"){
var _3cd=p.panel("panel")._outerWidth();
var _3ce=_3cb.width+_3cd-_3cc;
if(_3c3.split||!_3c3.border){
_3ce++;
}
return {resizeC:{width:_3ce},expand:{left:cc.width()-_3cd},expandP:{top:_3cb.top,left:cc.width()-_3cc,width:_3cc,height:_3cb.height},collapse:{left:cc.width(),top:_3cb.top,height:_3cb.height}};
}else{
if(_3c0=="west"){
var _3cd=p.panel("panel")._outerWidth();
var _3ce=_3cb.width+_3cd-_3cc;
if(_3c3.split||!_3c3.border){
_3ce++;
}
return {resizeC:{width:_3ce,left:_3cc-1},expand:{left:0},expandP:{left:0,top:_3cb.top,width:_3cc,height:_3cb.height},collapse:{left:-_3cd,top:_3cb.top,height:_3cb.height}};
}else{
if(_3c0=="north"){
var _3cf=p.panel("panel")._outerHeight();
var hh=_3cb.height;
if(!_3a3(_3c2.expandNorth)){
hh+=_3cf-_3cc+((_3c3.split||!_3c3.border)?1:0);
}
_3c2.east.add(_3c2.west).add(_3c2.expandEast).add(_3c2.expandWest).panel("resize",{top:_3cc-1,height:hh});
return {resizeC:{top:_3cc-1,height:hh},expand:{top:0},expandP:{top:0,left:0,width:cc.width(),height:_3cc},collapse:{top:-_3cf,width:cc.width()}};
}else{
if(_3c0=="south"){
var _3cf=p.panel("panel")._outerHeight();
var hh=_3cb.height;
if(!_3a3(_3c2.expandSouth)){
hh+=_3cf-_3cc+((_3c3.split||!_3c3.border)?1:0);
}
_3c2.east.add(_3c2.west).add(_3c2.expandEast).add(_3c2.expandWest).panel("resize",{height:hh});
return {resizeC:{height:hh},expand:{top:cc.height()-_3cf},expandP:{top:cc.height()-_3cc,left:0,width:cc.width(),height:_3cc},collapse:{top:cc.height(),width:cc.width()}};
}
}
}
}
};
};
function _3d0(_3d1,_3d2){
var _3d3=$.data(_3d1,"layout").panels;
var p=_3d3[_3d2];
var _3d4=p.panel("options");
if(_3d4.onBeforeExpand.call(p)==false){
return;
}
var _3d5="expand"+_3d2.substring(0,1).toUpperCase()+_3d2.substring(1);
if(_3d3[_3d5]){
_3d3[_3d5].panel("close");
p.panel("panel").stop(true,true);
p.panel("expand",false).panel("open");
var _3d6=_3d7();
p.panel("resize",_3d6.collapse);
p.panel("panel").animate(_3d6.expand,function(){
_39d(_3d1);
$(_3d1).layout("options").onExpand.call(_3d1,_3d2);
});
}
function _3d7(){
var cc=$(_3d1);
var _3d8=_3d3.center.panel("options");
if(_3d2=="east"&&_3d3.expandEast){
return {collapse:{left:cc.width(),top:_3d8.top,height:_3d8.height},expand:{left:cc.width()-p.panel("panel")._outerWidth()}};
}else{
if(_3d2=="west"&&_3d3.expandWest){
return {collapse:{left:-p.panel("panel")._outerWidth(),top:_3d8.top,height:_3d8.height},expand:{left:0}};
}else{
if(_3d2=="north"&&_3d3.expandNorth){
return {collapse:{top:-p.panel("panel")._outerHeight(),width:cc.width()},expand:{top:0}};
}else{
if(_3d2=="south"&&_3d3.expandSouth){
return {collapse:{top:cc.height(),width:cc.width()},expand:{top:cc.height()-p.panel("panel")._outerHeight()}};
}
}
}
}
};
};
function _3a3(pp){
if(!pp){
return false;
}
if(pp.length){
return pp.panel("panel").is(":visible");
}else{
return false;
}
};
function _3d9(_3da){
var _3db=$.data(_3da,"layout");
var opts=_3db.options;
var _3dc=_3db.panels;
var _3dd=opts.onCollapse;
opts.onCollapse=function(){
};
_3de("east");
_3de("west");
_3de("north");
_3de("south");
opts.onCollapse=_3dd;
function _3de(_3df){
var p=_3dc[_3df];
if(p.length&&p.panel("options").collapsed){
_3be(_3da,_3df,0);
}
};
};
function _3e0(_3e1,_3e2,_3e3){
var p=$(_3e1).layout("panel",_3e2);
p.panel("options").split=_3e3;
var cls="layout-split-"+_3e2;
var _3e4=p.panel("panel").removeClass(cls);
if(_3e3){
_3e4.addClass(cls);
}
_3e4.resizable({disabled:(!_3e3)});
_39d(_3e1);
};
$.fn.layout=function(_3e5,_3e6){
if(typeof _3e5=="string"){
return $.fn.layout.methods[_3e5](this,_3e6);
}
_3e5=_3e5||{};
return this.each(function(){
var _3e7=$.data(this,"layout");
if(_3e7){
$.extend(_3e7.options,_3e5);
}else{
var opts=$.extend({},$.fn.layout.defaults,$.fn.layout.parseOptions(this),_3e5);
$.data(this,"layout",{options:opts,panels:{center:$(),north:$(),south:$(),east:$(),west:$()}});
init(this);
}
_39d(this);
_3d9(this);
});
};
$.fn.layout.methods={options:function(jq){
return $.data(jq[0],"layout").options;
},resize:function(jq,_3e8){
return jq.each(function(){
_39d(this,_3e8);
});
},panel:function(jq,_3e9){
return $.data(jq[0],"layout").panels[_3e9];
},collapse:function(jq,_3ea){
return jq.each(function(){
_3be(this,_3ea);
});
},expand:function(jq,_3eb){
return jq.each(function(){
_3d0(this,_3eb);
});
},add:function(jq,_3ec){
return jq.each(function(){
_3ac(this,_3ec);
_39d(this);
if($(this).layout("panel",_3ec.region).panel("options").collapsed){
_3be(this,_3ec.region,0);
}
});
},remove:function(jq,_3ed){
return jq.each(function(){
_3b9(this,_3ed);
_39d(this);
});
},split:function(jq,_3ee){
return jq.each(function(){
_3e0(this,_3ee,true);
});
},unsplit:function(jq,_3ef){
return jq.each(function(){
_3e0(this,_3ef,false);
});
}};
$.fn.layout.parseOptions=function(_3f0){
return $.extend({},$.parser.parseOptions(_3f0,[{fit:"boolean"}]));
};
$.fn.layout.defaults={fit:false,onExpand:function(_3f1){
},onCollapse:function(_3f2){
},onAdd:function(_3f3){
},onRemove:function(_3f4){
}};
$.fn.layout.parsePanelOptions=function(_3f5){
var t=$(_3f5);
return $.extend({},$.fn.panel.parseOptions(_3f5),$.parser.parseOptions(_3f5,["region",{split:"boolean",collpasedSize:"number",minWidth:"number",minHeight:"number",maxWidth:"number",maxHeight:"number"}]));
};
$.fn.layout.paneldefaults=$.extend({},$.fn.panel.defaults,{region:null,split:false,collapsedSize:28,expandMode:"float",hideExpandTool:false,hideCollapsedContent:true,collapsedContent:function(_3f6){
var p=$(this);
var opts=p.panel("options");
if(opts.region=="north"||opts.region=="south"){
return _3f6;
}
var size=opts.collapsedSize-2;
var left=(size-16)/2;
left=size-left;
var cc=[];
if(opts.iconCls){
cc.push("<div class=\"panel-icon "+opts.iconCls+"\"></div>");
}
cc.push("<div class=\"panel-title layout-expand-title");
cc.push(opts.iconCls?" layout-expand-with-icon":"");
cc.push("\" style=\"left:"+left+"px\">");
cc.push(_3f6);
cc.push("</div>");
return cc.join("");
},minWidth:10,minHeight:10,maxWidth:10000,maxHeight:10000});
})(jQuery);
(function($){
$(function(){
$(document).unbind(".menu").bind("mousedown.menu",function(e){
var m=$(e.target).closest("div.menu,div.combo-p");
if(m.length){
return;
}
$("body>div.menu-top:visible").not(".menu-inline").menu("hide");
_3f7($("body>div.menu:visible").not(".menu-inline"));
});
});
function init(_3f8){
var opts=$.data(_3f8,"menu").options;
$(_3f8).addClass("menu-top");
opts.inline?$(_3f8).addClass("menu-inline"):$(_3f8).appendTo("body");
$(_3f8).bind("_resize",function(e,_3f9){
if($(this).hasClass("easyui-fluid")||_3f9){
$(_3f8).menu("resize",_3f8);
}
return false;
});
var _3fa=_3fb($(_3f8));
for(var i=0;i<_3fa.length;i++){
_3fc(_3fa[i]);
}
function _3fb(menu){
var _3fd=[];
menu.addClass("menu");
_3fd.push(menu);
if(!menu.hasClass("menu-content")){
menu.children("div").each(function(){
var _3fe=$(this).children("div");
if(_3fe.length){
_3fe.appendTo("body");
this.submenu=_3fe;
var mm=_3fb(_3fe);
_3fd=_3fd.concat(mm);
}
});
}
return _3fd;
};
function _3fc(menu){
var wh=$.parser.parseOptions(menu[0],["width","height"]);
menu[0].originalHeight=wh.height||0;
if(menu.hasClass("menu-content")){
menu[0].originalWidth=wh.width||menu._outerWidth();
}else{
menu[0].originalWidth=wh.width||0;
menu.children("div").each(function(){
var item=$(this);
var _3ff=$.extend({},$.parser.parseOptions(this,["name","iconCls","href",{separator:"boolean"}]),{disabled:(item.attr("disabled")?true:undefined)});
if(_3ff.separator){
item.addClass("menu-sep");
}
if(!item.hasClass("menu-sep")){
item[0].itemName=_3ff.name||"";
item[0].itemHref=_3ff.href||"";
var text=item.addClass("menu-item").html();
item.empty().append($("<div class=\"menu-text\"></div>").html(text));
if(_3ff.iconCls){
$("<div class=\"menu-icon\"></div>").addClass(_3ff.iconCls).appendTo(item);
}
if(_3ff.disabled){
_400(_3f8,item[0],true);
}
if(item[0].submenu){
$("<div class=\"menu-rightarrow\"></div>").appendTo(item);
}
_401(_3f8,item);
}
});
$("<div class=\"menu-line\"></div>").prependTo(menu);
}
_402(_3f8,menu);
if(!menu.hasClass("menu-inline")){
menu.hide();
}
_403(_3f8,menu);
};
};
function _402(_404,menu){
var opts=$.data(_404,"menu").options;
var _405=menu.attr("style")||"";
menu.css({display:"block",left:-10000,height:"auto",overflow:"hidden"});
menu.find(".menu-item").each(function(){
$(this)._outerHeight(opts.itemHeight);
$(this).find(".menu-text").css({height:(opts.itemHeight-2)+"px",lineHeight:(opts.itemHeight-2)+"px"});
});
menu.removeClass("menu-noline").addClass(opts.noline?"menu-noline":"");
var _406=menu[0].originalWidth||"auto";
if(isNaN(parseInt(_406))){
_406=0;
menu.find("div.menu-text").each(function(){
if(_406<$(this)._outerWidth()){
_406=$(this)._outerWidth();
}
});
_406+=40;
}
var _407=menu.outerHeight();
var _408=menu[0].originalHeight||"auto";
if(isNaN(parseInt(_408))){
_408=_407;
if(menu.hasClass("menu-top")&&opts.alignTo){
var at=$(opts.alignTo);
var h1=at.offset().top-$(document).scrollTop();
var h2=$(window)._outerHeight()+$(document).scrollTop()-at.offset().top-at._outerHeight();
_408=Math.min(_408,Math.max(h1,h2));
}else{
if(_408>$(window)._outerHeight()){
_408=$(window).height();
}
}
}
menu.attr("style",_405);
menu._size({fit:(menu[0]==_404?opts.fit:false),width:_406,minWidth:opts.minWidth,height:_408});
menu.css("overflow",menu.outerHeight()<_407?"auto":"hidden");
menu.children("div.menu-line")._outerHeight(_407-2);
};
function _403(_409,menu){
if(menu.hasClass("menu-inline")){
return;
}
var _40a=$.data(_409,"menu");
menu.unbind(".menu").bind("mouseenter.menu",function(){
if(_40a.timer){
clearTimeout(_40a.timer);
_40a.timer=null;
}
}).bind("mouseleave.menu",function(){
if(_40a.options.hideOnUnhover){
_40a.timer=setTimeout(function(){
_40b(_409,$(_409).hasClass("menu-inline"));
},_40a.options.duration);
}
});
};
function _401(_40c,item){
if(!item.hasClass("menu-item")){
return;
}
item.unbind(".menu");
item.bind("click.menu",function(){
if($(this).hasClass("menu-item-disabled")){
return;
}
if(!this.submenu){
_40b(_40c,$(_40c).hasClass("menu-inline"));
var href=this.itemHref;
if(href){
location.href=href;
}
}
$(this).trigger("mouseenter");
var item=$(_40c).menu("getItem",this);
$.data(_40c,"menu").options.onClick.call(_40c,item);
}).bind("mouseenter.menu",function(e){
item.siblings().each(function(){
if(this.submenu){
_3f7(this.submenu);
}
$(this).removeClass("menu-active");
});
item.addClass("menu-active");
if($(this).hasClass("menu-item-disabled")){
item.addClass("menu-active-disabled");
return;
}
var _40d=item[0].submenu;
if(_40d){
$(_40c).menu("show",{menu:_40d,parent:item});
}
}).bind("mouseleave.menu",function(e){
item.removeClass("menu-active menu-active-disabled");
var _40e=item[0].submenu;
if(_40e){
if(e.pageX>=parseInt(_40e.css("left"))){
item.addClass("menu-active");
}else{
_3f7(_40e);
}
}else{
item.removeClass("menu-active");
}
});
};
function _40b(_40f,_410){
var _411=$.data(_40f,"menu");
if(_411){
if($(_40f).is(":visible")){
_3f7($(_40f));
if(_410){
$(_40f).show();
}else{
_411.options.onHide.call(_40f);
}
}
}
return false;
};
function _412(_413,_414){
_414=_414||{};
var left,top;
var opts=$.data(_413,"menu").options;
var menu=$(_414.menu||_413);
$(_413).menu("resize",menu[0]);
if(menu.hasClass("menu-top")){
$.extend(opts,_414);
left=opts.left;
top=opts.top;
if(opts.alignTo){
var at=$(opts.alignTo);
left=at.offset().left;
top=at.offset().top+at._outerHeight();
if(opts.align=="right"){
left+=at.outerWidth()-menu.outerWidth();
}
}
if(left+menu.outerWidth()>$(window)._outerWidth()+$(document)._scrollLeft()){
left=$(window)._outerWidth()+$(document).scrollLeft()-menu.outerWidth()-5;
}
if(left<0){
left=0;
}
top=_415(top,opts.alignTo);
}else{
var _416=_414.parent;
left=_416.offset().left+_416.outerWidth()-2;
if(left+menu.outerWidth()+5>$(window)._outerWidth()+$(document).scrollLeft()){
left=_416.offset().left-menu.outerWidth()+2;
}
top=_415(_416.offset().top-3);
}
function _415(top,_417){
if(top+menu.outerHeight()>$(window)._outerHeight()+$(document).scrollTop()){
if(_417){
top=$(_417).offset().top-menu._outerHeight();
}else{
top=$(window)._outerHeight()+$(document).scrollTop()-menu.outerHeight();
}
}
if(top<0){
top=0;
}
return top;
};
menu.css(opts.position.call(_413,menu[0],left,top));
menu.show(0,function(){
if(!menu[0].shadow){
menu[0].shadow=$("<div class=\"menu-shadow\"></div>").insertAfter(menu);
}
menu[0].shadow.css({display:(menu.hasClass("menu-inline")?"none":"block"),zIndex:$.fn.menu.defaults.zIndex++,left:menu.css("left"),top:menu.css("top"),width:menu.outerWidth(),height:menu.outerHeight()});
menu.css("z-index",$.fn.menu.defaults.zIndex++);
if(menu.hasClass("menu-top")){
opts.onShow.call(_413);
}
});
};
function _3f7(menu){
if(menu&&menu.length){
_418(menu);
menu.find("div.menu-item").each(function(){
if(this.submenu){
_3f7(this.submenu);
}
$(this).removeClass("menu-active");
});
}
function _418(m){
m.stop(true,true);
if(m[0].shadow){
m[0].shadow.hide();
}
m.hide();
};
};
function _419(_41a,text){
var _41b=null;
var tmp=$("<div></div>");
function find(menu){
menu.children("div.menu-item").each(function(){
var item=$(_41a).menu("getItem",this);
var s=tmp.empty().html(item.text).text();
if(text==$.trim(s)){
_41b=item;
}else{
if(this.submenu&&!_41b){
find(this.submenu);
}
}
});
};
find($(_41a));
tmp.remove();
return _41b;
};
function _400(_41c,_41d,_41e){
var t=$(_41d);
if(!t.hasClass("menu-item")){
return;
}
if(_41e){
t.addClass("menu-item-disabled");
if(_41d.onclick){
_41d.onclick1=_41d.onclick;
_41d.onclick=null;
}
}else{
t.removeClass("menu-item-disabled");
if(_41d.onclick1){
_41d.onclick=_41d.onclick1;
_41d.onclick1=null;
}
}
};
function _41f(_420,_421){
var opts=$.data(_420,"menu").options;
var menu=$(_420);
if(_421.parent){
if(!_421.parent.submenu){
var _422=$("<div class=\"menu\"><div class=\"menu-line\"></div></div>").appendTo("body");
_422.hide();
_421.parent.submenu=_422;
$("<div class=\"menu-rightarrow\"></div>").appendTo(_421.parent);
}
menu=_421.parent.submenu;
}
if(_421.separator){
var item=$("<div class=\"menu-sep\"></div>").appendTo(menu);
}else{
var item=$("<div class=\"menu-item\"></div>").appendTo(menu);
$("<div class=\"menu-text\"></div>").html(_421.text).appendTo(item);
}
if(_421.iconCls){
$("<div class=\"menu-icon\"></div>").addClass(_421.iconCls).appendTo(item);
}
if(_421.id){
item.attr("id",_421.id);
}
if(_421.name){
item[0].itemName=_421.name;
}
if(_421.href){
item[0].itemHref=_421.href;
}
if(_421.onclick){
if(typeof _421.onclick=="string"){
item.attr("onclick",_421.onclick);
}else{
item[0].onclick=eval(_421.onclick);
}
}
if(_421.handler){
item[0].onclick=eval(_421.handler);
}
if(_421.disabled){
_400(_420,item[0],true);
}
_401(_420,item);
_403(_420,menu);
_402(_420,menu);
};
function _423(_424,_425){
function _426(el){
if(el.submenu){
el.submenu.children("div.menu-item").each(function(){
_426(this);
});
var _427=el.submenu[0].shadow;
if(_427){
_427.remove();
}
el.submenu.remove();
}
$(el).remove();
};
var menu=$(_425).parent();
_426(_425);
_402(_424,menu);
};
function _428(_429,_42a,_42b){
var menu=$(_42a).parent();
if(_42b){
$(_42a).show();
}else{
$(_42a).hide();
}
_402(_429,menu);
};
function _42c(_42d){
$(_42d).children("div.menu-item").each(function(){
_423(_42d,this);
});
if(_42d.shadow){
_42d.shadow.remove();
}
$(_42d).remove();
};
$.fn.menu=function(_42e,_42f){
if(typeof _42e=="string"){
return $.fn.menu.methods[_42e](this,_42f);
}
_42e=_42e||{};
return this.each(function(){
var _430=$.data(this,"menu");
if(_430){
$.extend(_430.options,_42e);
}else{
_430=$.data(this,"menu",{options:$.extend({},$.fn.menu.defaults,$.fn.menu.parseOptions(this),_42e)});
init(this);
}
$(this).css({left:_430.options.left,top:_430.options.top});
});
};
$.fn.menu.methods={options:function(jq){
return $.data(jq[0],"menu").options;
},show:function(jq,pos){
return jq.each(function(){
_412(this,pos);
});
},hide:function(jq){
return jq.each(function(){
_40b(this);
});
},destroy:function(jq){
return jq.each(function(){
_42c(this);
});
},setText:function(jq,_431){
return jq.each(function(){
$(_431.target).children("div.menu-text").html(_431.text);
});
},setIcon:function(jq,_432){
return jq.each(function(){
$(_432.target).children("div.menu-icon").remove();
if(_432.iconCls){
$("<div class=\"menu-icon\"></div>").addClass(_432.iconCls).appendTo(_432.target);
}
});
},getItem:function(jq,_433){
var t=$(_433);
var item={target:_433,id:t.attr("id"),text:$.trim(t.children("div.menu-text").html()),disabled:t.hasClass("menu-item-disabled"),name:_433.itemName,href:_433.itemHref,onclick:_433.onclick};
var icon=t.children("div.menu-icon");
if(icon.length){
var cc=[];
var aa=icon.attr("class").split(" ");
for(var i=0;i<aa.length;i++){
if(aa[i]!="menu-icon"){
cc.push(aa[i]);
}
}
item.iconCls=cc.join(" ");
}
return item;
},findItem:function(jq,text){
return _419(jq[0],text);
},appendItem:function(jq,_434){
return jq.each(function(){
_41f(this,_434);
});
},removeItem:function(jq,_435){
return jq.each(function(){
_423(this,_435);
});
},enableItem:function(jq,_436){
return jq.each(function(){
_400(this,_436,false);
});
},disableItem:function(jq,_437){
return jq.each(function(){
_400(this,_437,true);
});
},showItem:function(jq,_438){
return jq.each(function(){
_428(this,_438,true);
});
},hideItem:function(jq,_439){
return jq.each(function(){
_428(this,_439,false);
});
},resize:function(jq,_43a){
return jq.each(function(){
_402(this,$(_43a));
});
}};
$.fn.menu.parseOptions=function(_43b){
return $.extend({},$.parser.parseOptions(_43b,[{minWidth:"number",itemHeight:"number",duration:"number",hideOnUnhover:"boolean"},{fit:"boolean",inline:"boolean",noline:"boolean"}]));
};
$.fn.menu.defaults={zIndex:110000,left:0,top:0,alignTo:null,align:"left",minWidth:120,itemHeight:22,duration:100,hideOnUnhover:true,inline:false,fit:false,noline:false,position:function(_43c,left,top){
return {left:left,top:top};
},onShow:function(){
},onHide:function(){
},onClick:function(item){
}};
})(jQuery);
(function($){
function init(_43d){
var opts=$.data(_43d,"menubutton").options;
var btn=$(_43d);
btn.linkbutton(opts);
if(opts.hasDownArrow){
btn.removeClass(opts.cls.btn1+" "+opts.cls.btn2).addClass("m-btn");
btn.removeClass("m-btn-small m-btn-medium m-btn-large").addClass("m-btn-"+opts.size);
var _43e=btn.find(".l-btn-left");
$("<span></span>").addClass(opts.cls.arrow).appendTo(_43e);
$("<span></span>").addClass("m-btn-line").appendTo(_43e);
}
$(_43d).menubutton("resize");
if(opts.menu){
$(opts.menu).menu({duration:opts.duration});
var _43f=$(opts.menu).menu("options");
var _440=_43f.onShow;
var _441=_43f.onHide;
$.extend(_43f,{onShow:function(){
var _442=$(this).menu("options");
var btn=$(_442.alignTo);
var opts=btn.menubutton("options");
btn.addClass((opts.plain==true)?opts.cls.btn2:opts.cls.btn1);
_440.call(this);
},onHide:function(){
var _443=$(this).menu("options");
var btn=$(_443.alignTo);
var opts=btn.menubutton("options");
btn.removeClass((opts.plain==true)?opts.cls.btn2:opts.cls.btn1);
_441.call(this);
}});
}
};
function _444(_445){
var opts=$.data(_445,"menubutton").options;
var btn=$(_445);
var t=btn.find("."+opts.cls.trigger);
if(!t.length){
t=btn;
}
t.unbind(".menubutton");
var _446=null;
t.bind("click.menubutton",function(){
if(!_447()){
_448(_445);
return false;
}
}).bind("mouseenter.menubutton",function(){
if(!_447()){
_446=setTimeout(function(){
_448(_445);
},opts.duration);
return false;
}
}).bind("mouseleave.menubutton",function(){
if(_446){
clearTimeout(_446);
}
$(opts.menu).triggerHandler("mouseleave");
});
function _447(){
return $(_445).linkbutton("options").disabled;
};
};
function _448(_449){
var opts=$(_449).menubutton("options");
if(opts.disabled||!opts.menu){
return;
}
$("body>div.menu-top").menu("hide");
var btn=$(_449);
var mm=$(opts.menu);
if(mm.length){
mm.menu("options").alignTo=btn;
mm.menu("show",{alignTo:btn,align:opts.menuAlign});
}
btn.blur();
};
$.fn.menubutton=function(_44a,_44b){
if(typeof _44a=="string"){
var _44c=$.fn.menubutton.methods[_44a];
if(_44c){
return _44c(this,_44b);
}else{
return this.linkbutton(_44a,_44b);
}
}
_44a=_44a||{};
return this.each(function(){
var _44d=$.data(this,"menubutton");
if(_44d){
$.extend(_44d.options,_44a);
}else{
$.data(this,"menubutton",{options:$.extend({},$.fn.menubutton.defaults,$.fn.menubutton.parseOptions(this),_44a)});
$(this).removeAttr("disabled");
}
init(this);
_444(this);
});
};
$.fn.menubutton.methods={options:function(jq){
var _44e=jq.linkbutton("options");
return $.extend($.data(jq[0],"menubutton").options,{toggle:_44e.toggle,selected:_44e.selected,disabled:_44e.disabled});
},destroy:function(jq){
return jq.each(function(){
var opts=$(this).menubutton("options");
if(opts.menu){
$(opts.menu).menu("destroy");
}
$(this).remove();
});
}};
$.fn.menubutton.parseOptions=function(_44f){
var t=$(_44f);
return $.extend({},$.fn.linkbutton.parseOptions(_44f),$.parser.parseOptions(_44f,["menu",{plain:"boolean",hasDownArrow:"boolean",duration:"number"}]));
};
$.fn.menubutton.defaults=$.extend({},$.fn.linkbutton.defaults,{plain:true,hasDownArrow:true,menu:null,menuAlign:"left",duration:100,cls:{btn1:"m-btn-active",btn2:"m-btn-plain-active",arrow:"m-btn-downarrow",trigger:"m-btn"}});
})(jQuery);
(function($){
function init(_450){
var opts=$.data(_450,"splitbutton").options;
$(_450).menubutton(opts);
$(_450).addClass("s-btn");
};
$.fn.splitbutton=function(_451,_452){
if(typeof _451=="string"){
var _453=$.fn.splitbutton.methods[_451];
if(_453){
return _453(this,_452);
}else{
return this.menubutton(_451,_452);
}
}
_451=_451||{};
return this.each(function(){
var _454=$.data(this,"splitbutton");
if(_454){
$.extend(_454.options,_451);
}else{
$.data(this,"splitbutton",{options:$.extend({},$.fn.splitbutton.defaults,$.fn.splitbutton.parseOptions(this),_451)});
$(this).removeAttr("disabled");
}
init(this);
});
};
$.fn.splitbutton.methods={options:function(jq){
var _455=jq.menubutton("options");
var _456=$.data(jq[0],"splitbutton").options;
$.extend(_456,{disabled:_455.disabled,toggle:_455.toggle,selected:_455.selected});
return _456;
}};
$.fn.splitbutton.parseOptions=function(_457){
var t=$(_457);
return $.extend({},$.fn.linkbutton.parseOptions(_457),$.parser.parseOptions(_457,["menu",{plain:"boolean",duration:"number"}]));
};
$.fn.splitbutton.defaults=$.extend({},$.fn.linkbutton.defaults,{plain:true,menu:null,duration:100,cls:{btn1:"m-btn-active s-btn-active",btn2:"m-btn-plain-active s-btn-plain-active",arrow:"m-btn-downarrow",trigger:"m-btn-line"}});
})(jQuery);
(function($){
function init(_458){
var _459=$("<span class=\"switchbutton\">"+"<span class=\"switchbutton-inner\">"+"<span class=\"switchbutton-on\"></span>"+"<span class=\"switchbutton-handle\"></span>"+"<span class=\"switchbutton-off\"></span>"+"<input class=\"switchbutton-value\" type=\"checkbox\">"+"</span>"+"</span>").insertAfter(_458);
var t=$(_458);
t.addClass("switchbutton-f").hide();
var name=t.attr("name");
if(name){
t.removeAttr("name").attr("switchbuttonName",name);
_459.find(".switchbutton-value").attr("name",name);
}
_459.bind("_resize",function(e,_45a){
if($(this).hasClass("easyui-fluid")||_45a){
_45b(_458);
}
return false;
});
return _459;
};
function _45b(_45c,_45d){
var _45e=$.data(_45c,"switchbutton");
var opts=_45e.options;
var _45f=_45e.switchbutton;
if(_45d){
$.extend(opts,_45d);
}
var _460=_45f.is(":visible");
if(!_460){
_45f.appendTo("body");
}
_45f._size(opts);
var w=_45f.width();
var h=_45f.height();
var w=_45f.outerWidth();
var h=_45f.outerHeight();
var _461=parseInt(opts.handleWidth)||_45f.height();
var _462=w*2-_461;
_45f.find(".switchbutton-inner").css({width:_462+"px",height:h+"px",lineHeight:h+"px"});
_45f.find(".switchbutton-handle")._outerWidth(_461)._outerHeight(h).css({marginLeft:-_461/2+"px"});
_45f.find(".switchbutton-on").css({width:(w-_461/2)+"px",textIndent:(opts.reversed?"":"-")+_461/2+"px"});
_45f.find(".switchbutton-off").css({width:(w-_461/2)+"px",textIndent:(opts.reversed?"-":"")+_461/2+"px"});
opts.marginWidth=w-_461;
_463(_45c,opts.checked,false);
if(!_460){
_45f.insertAfter(_45c);
}
};
function _464(_465){
var _466=$.data(_465,"switchbutton");
var opts=_466.options;
var _467=_466.switchbutton;
var _468=_467.find(".switchbutton-inner");
var on=_468.find(".switchbutton-on").html(opts.onText);
var off=_468.find(".switchbutton-off").html(opts.offText);
var _469=_468.find(".switchbutton-handle").html(opts.handleText);
if(opts.reversed){
off.prependTo(_468);
on.insertAfter(_469);
}else{
on.prependTo(_468);
off.insertAfter(_469);
}
_467.find(".switchbutton-value")._propAttr("checked",opts.checked);
_467.removeClass("switchbutton-disabled").addClass(opts.disabled?"switchbutton-disabled":"");
_467.removeClass("switchbutton-reversed").addClass(opts.reversed?"switchbutton-reversed":"");
_463(_465,opts.checked);
_46a(_465,opts.readonly);
$(_465).switchbutton("setValue",opts.value);
};
function _463(_46b,_46c,_46d){
var _46e=$.data(_46b,"switchbutton");
var opts=_46e.options;
opts.checked=_46c;
var _46f=_46e.switchbutton.find(".switchbutton-inner");
var _470=_46f.find(".switchbutton-on");
var _471=opts.reversed?(opts.checked?opts.marginWidth:0):(opts.checked?0:opts.marginWidth);
var dir=_470.css("float").toLowerCase();
var css={};
css["margin-"+dir]=-_471+"px";
_46d?_46f.animate(css,200):_46f.css(css);
var _472=_46f.find(".switchbutton-value");
var ck=_472.is(":checked");
$(_46b).add(_472)._propAttr("checked",opts.checked);
if(ck!=opts.checked){
opts.onChange.call(_46b,opts.checked);
}
};
function _473(_474,_475){
var _476=$.data(_474,"switchbutton");
var opts=_476.options;
var _477=_476.switchbutton;
var _478=_477.find(".switchbutton-value");
if(_475){
opts.disabled=true;
$(_474).add(_478).attr("disabled","disabled");
_477.addClass("switchbutton-disabled");
}else{
opts.disabled=false;
$(_474).add(_478).removeAttr("disabled");
_477.removeClass("switchbutton-disabled");
}
};
function _46a(_479,mode){
var _47a=$.data(_479,"switchbutton");
var opts=_47a.options;
opts.readonly=mode==undefined?true:mode;
_47a.switchbutton.removeClass("switchbutton-readonly").addClass(opts.readonly?"switchbutton-readonly":"");
};
function _47b(_47c){
var _47d=$.data(_47c,"switchbutton");
var opts=_47d.options;
_47d.switchbutton.unbind(".switchbutton").bind("click.switchbutton",function(){
if(!opts.disabled&&!opts.readonly){
_463(_47c,opts.checked?false:true,true);
}
});
};
$.fn.switchbutton=function(_47e,_47f){
if(typeof _47e=="string"){
return $.fn.switchbutton.methods[_47e](this,_47f);
}
_47e=_47e||{};
return this.each(function(){
var _480=$.data(this,"switchbutton");
if(_480){
$.extend(_480.options,_47e);
}else{
_480=$.data(this,"switchbutton",{options:$.extend({},$.fn.switchbutton.defaults,$.fn.switchbutton.parseOptions(this),_47e),switchbutton:init(this)});
}
_480.options.originalChecked=_480.options.checked;
_464(this);
_45b(this);
_47b(this);
});
};
$.fn.switchbutton.methods={options:function(jq){
var _481=jq.data("switchbutton");
return $.extend(_481.options,{value:_481.switchbutton.find(".switchbutton-value").val()});
},resize:function(jq,_482){
return jq.each(function(){
_45b(this,_482);
});
},enable:function(jq){
return jq.each(function(){
_473(this,false);
});
},disable:function(jq){
return jq.each(function(){
_473(this,true);
});
},readonly:function(jq,mode){
return jq.each(function(){
_46a(this,mode);
});
},check:function(jq){
return jq.each(function(){
_463(this,true);
});
},uncheck:function(jq){
return jq.each(function(){
_463(this,false);
});
},clear:function(jq){
return jq.each(function(){
_463(this,false);
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).switchbutton("options");
_463(this,opts.originalChecked);
});
},setValue:function(jq,_483){
return jq.each(function(){
$(this).val(_483);
$.data(this,"switchbutton").switchbutton.find(".switchbutton-value").val(_483);
});
}};
$.fn.switchbutton.parseOptions=function(_484){
var t=$(_484);
return $.extend({},$.parser.parseOptions(_484,["onText","offText","handleText",{handleWidth:"number",reversed:"boolean"}]),{value:(t.val()||undefined),checked:(t.attr("checked")?true:undefined),disabled:(t.attr("disabled")?true:undefined),readonly:(t.attr("readonly")?true:undefined)});
};
$.fn.switchbutton.defaults={handleWidth:"auto",width:60,height:26,checked:false,disabled:false,readonly:false,reversed:false,onText:"ON",offText:"OFF",handleText:"",value:"on",onChange:function(_485){
}};
})(jQuery);
(function($){
function init(_486){
$(_486).addClass("validatebox-text");
};
function _487(_488){
var _489=$.data(_488,"validatebox");
_489.validating=false;
if(_489.timer){
clearTimeout(_489.timer);
}
$(_488).tooltip("destroy");
$(_488).unbind();
$(_488).remove();
};
function _48a(_48b){
var opts=$.data(_48b,"validatebox").options;
$(_48b).unbind(".validatebox");
if(opts.novalidate||opts.disabled){
return;
}
for(var _48c in opts.events){
$(_48b).bind(_48c+".validatebox",{target:_48b},opts.events[_48c]);
}
};
function _48d(e){
var _48e=e.data.target;
var _48f=$.data(_48e,"validatebox");
var opts=_48f.options;
if($(_48e).attr("readonly")){
return;
}
_48f.validating=true;
_48f.value=opts.val(_48e);
(function(){
if(_48f.validating){
var _490=opts.val(_48e);
if(_48f.value!=_490){
_48f.value=_490;
if(_48f.timer){
clearTimeout(_48f.timer);
}
_48f.timer=setTimeout(function(){
$(_48e).validatebox("validate");
},opts.delay);
}else{
if(_48f.message){
opts.err(_48e,_48f.message);
}
}
setTimeout(arguments.callee,opts.interval);
}
})();
};
function _491(e){
var _492=e.data.target;
var _493=$.data(_492,"validatebox");
var opts=_493.options;
_493.validating=false;
if(_493.timer){
clearTimeout(_493.timer);
_493.timer=undefined;
}
if(opts.validateOnBlur){
$(_492).validatebox("validate");
}
opts.err(_492,_493.message,"hide");
};
function _494(e){
var _495=e.data.target;
var _496=$.data(_495,"validatebox");
_496.options.err(_495,_496.message,"show");
};
function _497(e){
var _498=e.data.target;
var _499=$.data(_498,"validatebox");
if(!_499.validating){
_499.options.err(_498,_499.message,"hide");
}
};
function _49a(_49b,_49c,_49d){
var _49e=$.data(_49b,"validatebox");
var opts=_49e.options;
var t=$(_49b);
if(_49d=="hide"||!_49c){
t.tooltip("hide");
}else{
if(t.is(":focus")||_49d=="show"){
t.tooltip($.extend({},opts.tipOptions,{content:_49c,position:opts.tipPosition,deltaX:opts.deltaX})).tooltip("show");
}
}
};
function _49f(_4a0){
var _4a1=$.data(_4a0,"validatebox");
var opts=_4a1.options;
var box=$(_4a0);
opts.onBeforeValidate.call(_4a0);
var _4a2=_4a3();
_4a2?box.removeClass("validatebox-invalid"):box.addClass("validatebox-invalid");
opts.err(_4a0,_4a1.message);
opts.onValidate.call(_4a0,_4a2);
return _4a2;
function _4a4(msg){
_4a1.message=msg;
};
function _4a5(_4a6,_4a7){
var _4a8=opts.val(_4a0);
var _4a9=/([a-zA-Z_]+)(.*)/.exec(_4a6);
var rule=opts.rules[_4a9[1]];
if(rule&&_4a8){
var _4aa=_4a7||opts.validParams||eval(_4a9[2]);
if(!rule["validator"].call(_4a0,_4a8,_4aa)){
var _4ab=rule["message"];
if(_4aa){
for(var i=0;i<_4aa.length;i++){
_4ab=_4ab.replace(new RegExp("\\{"+i+"\\}","g"),_4aa[i]);
}
}
_4a4(opts.invalidMessage||_4ab);
return false;
}
}
return true;
};
function _4a3(){
_4a4("");
if(!opts._validateOnCreate){
setTimeout(function(){
opts._validateOnCreate=true;
},0);
return true;
}
if(opts.novalidate||opts.disabled){
return true;
}
if(opts.required){
if(opts.val(_4a0)==""){
_4a4(opts.missingMessage);
return false;
}
}
if(opts.validType){
if($.isArray(opts.validType)){
for(var i=0;i<opts.validType.length;i++){
if(!_4a5(opts.validType[i])){
return false;
}
}
}else{
if(typeof opts.validType=="string"){
if(!_4a5(opts.validType)){
return false;
}
}else{
for(var _4ac in opts.validType){
var _4ad=opts.validType[_4ac];
if(!_4a5(_4ac,_4ad)){
return false;
}
}
}
}
}
return true;
};
};
function _4ae(_4af,_4b0){
var opts=$.data(_4af,"validatebox").options;
if(_4b0!=undefined){
opts.disabled=_4b0;
}
if(opts.disabled){
$(_4af).addClass("validatebox-disabled").attr("disabled","disabled");
}else{
$(_4af).removeClass("validatebox-disabled").removeAttr("disabled");
}
};
function _4b1(_4b2,mode){
var opts=$.data(_4b2,"validatebox").options;
opts.readonly=mode==undefined?true:mode;
if(opts.readonly||!opts.editable){
$(_4b2).addClass("validatebox-readonly").attr("readonly","readonly");
}else{
$(_4b2).removeClass("validatebox-readonly").removeAttr("readonly");
}
};
$.fn.validatebox=function(_4b3,_4b4){
if(typeof _4b3=="string"){
return $.fn.validatebox.methods[_4b3](this,_4b4);
}
_4b3=_4b3||{};
return this.each(function(){
var _4b5=$.data(this,"validatebox");
if(_4b5){
$.extend(_4b5.options,_4b3);
}else{
init(this);
_4b5=$.data(this,"validatebox",{options:$.extend({},$.fn.validatebox.defaults,$.fn.validatebox.parseOptions(this),_4b3)});
}
_4b5.options._validateOnCreate=_4b5.options.validateOnCreate;
_4ae(this,_4b5.options.disabled);
_4b1(this,_4b5.options.readonly);
_48a(this);
_49f(this);
});
};
$.fn.validatebox.methods={options:function(jq){
return $.data(jq[0],"validatebox").options;
},destroy:function(jq){
return jq.each(function(){
_487(this);
});
},validate:function(jq){
return jq.each(function(){
_49f(this);
});
},isValid:function(jq){
return _49f(jq[0]);
},enableValidation:function(jq){
return jq.each(function(){
$(this).validatebox("options").novalidate=false;
_48a(this);
_49f(this);
});
},disableValidation:function(jq){
return jq.each(function(){
$(this).validatebox("options").novalidate=true;
_48a(this);
_49f(this);
});
},resetValidation:function(jq){
return jq.each(function(){
var opts=$(this).validatebox("options");
opts._validateOnCreate=opts.validateOnCreate;
_49f(this);
});
},enable:function(jq){
return jq.each(function(){
_4ae(this,false);
_48a(this);
_49f(this);
});
},disable:function(jq){
return jq.each(function(){
_4ae(this,true);
_48a(this);
_49f(this);
});
},readonly:function(jq,mode){
return jq.each(function(){
_4b1(this,mode);
_48a(this);
_49f(this);
});
}};
$.fn.validatebox.parseOptions=function(_4b6){
var t=$(_4b6);
return $.extend({},$.parser.parseOptions(_4b6,["validType","missingMessage","invalidMessage","tipPosition",{delay:"number",interval:"number",deltaX:"number"},{editable:"boolean",validateOnCreate:"boolean",validateOnBlur:"boolean"}]),{required:(t.attr("required")?true:undefined),disabled:(t.attr("disabled")?true:undefined),readonly:(t.attr("readonly")?true:undefined),novalidate:(t.attr("novalidate")!=undefined?true:undefined)});
};
$.fn.validatebox.defaults={required:false,validType:null,validParams:null,delay:200,interval:200,missingMessage:"This field is required.",invalidMessage:null,tipPosition:"right",deltaX:0,novalidate:false,editable:true,disabled:false,readonly:false,validateOnCreate:true,validateOnBlur:false,events:{focus:_48d,blur:_491,mouseenter:_494,mouseleave:_497,click:function(e){
var t=$(e.data.target);
if(t.attr("type")=="checkbox"||t.attr("type")=="radio"){
t.focus().validatebox("validate");
}
}},val:function(_4b7){
return $(_4b7).val();
},err:function(_4b8,_4b9,_4ba){
_49a(_4b8,_4b9,_4ba);
},tipOptions:{showEvent:"none",hideEvent:"none",showDelay:0,hideDelay:0,zIndex:"",onShow:function(){
$(this).tooltip("tip").css({color:"#000",borderColor:"#CC9933",backgroundColor:"#FFFFCC"});
},onHide:function(){
$(this).tooltip("destroy");
}},rules:{email:{validator:function(_4bb){
return /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(_4bb);
},message:"Please enter a valid email address."},url:{validator:function(_4bc){
return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(_4bc);
},message:"Please enter a valid URL."},length:{validator:function(_4bd,_4be){
var len=$.trim(_4bd).length;
return len>=_4be[0]&&len<=_4be[1];
},message:"Please enter a value between {0} and {1}."},remote:{validator:function(_4bf,_4c0){
var data={};
data[_4c0[1]]=_4bf;
var _4c1=$.ajax({url:_4c0[0],dataType:"json",data:data,async:false,cache:false,type:"post"}).responseText;
return _4c1=="true";
},message:"Please fix this field."}},onBeforeValidate:function(){
},onValidate:function(_4c2){
}};
})(jQuery);
(function($){
function init(_4c3){
$(_4c3).addClass("textbox-f").hide();
var span=$("<span class=\"textbox\">"+"<input class=\"textbox-text\" autocomplete=\"off\">"+"<input type=\"hidden\" class=\"textbox-value\">"+"</span>").insertAfter(_4c3);
var name=$(_4c3).attr("name");
if(name){
span.find("input.textbox-value").attr("name",name);
$(_4c3).removeAttr("name").attr("textboxName",name);
}
return span;
};
function _4c4(_4c5){
var _4c6=$.data(_4c5,"textbox");
var opts=_4c6.options;
var tb=_4c6.textbox;
tb.find(".textbox-text").remove();
if(opts.multiline){
$("<textarea class=\"textbox-text\" autocomplete=\"off\"></textarea>").prependTo(tb);
}else{
$("<input type=\""+opts.type+"\" class=\"textbox-text\" autocomplete=\"off\">").prependTo(tb);
}
tb.find(".textbox-addon").remove();
var bb=opts.icons?$.extend(true,[],opts.icons):[];
if(opts.iconCls){
bb.push({iconCls:opts.iconCls,disabled:true});
}
if(bb.length){
var bc=$("<span class=\"textbox-addon\"></span>").prependTo(tb);
bc.addClass("textbox-addon-"+opts.iconAlign);
for(var i=0;i<bb.length;i++){
bc.append("<a href=\"javascript:void(0)\" class=\"textbox-icon "+bb[i].iconCls+"\" icon-index=\""+i+"\" tabindex=\"-1\"></a>");
}
}
tb.find(".textbox-button").remove();
if(opts.buttonText||opts.buttonIcon){
var btn=$("<a href=\"javascript:void(0)\" class=\"textbox-button\"></a>").prependTo(tb);
btn.addClass("textbox-button-"+opts.buttonAlign).linkbutton({text:opts.buttonText,iconCls:opts.buttonIcon});
}
_4c7(_4c5);
_4c8(_4c5,opts.disabled);
_4c9(_4c5,opts.readonly);
};
function _4ca(_4cb){
var tb=$.data(_4cb,"textbox").textbox;
tb.find(".textbox-text").validatebox("destroy");
tb.remove();
$(_4cb).remove();
};
function _4cc(_4cd,_4ce){
var _4cf=$.data(_4cd,"textbox");
var opts=_4cf.options;
var tb=_4cf.textbox;
var _4d0=tb.parent();
if(_4ce){
opts.width=_4ce;
}
if(isNaN(parseInt(opts.width))){
var c=$(_4cd).clone();
c.css("visibility","hidden");
c.insertAfter(_4cd);
opts.width=c.outerWidth();
c.remove();
}
var _4d1=tb.is(":visible");
if(!_4d1){
tb.appendTo("body");
}
var _4d2=tb.find(".textbox-text");
var btn=tb.find(".textbox-button");
var _4d3=tb.find(".textbox-addon");
var _4d4=_4d3.find(".textbox-icon");
tb._size(opts,_4d0);
btn.linkbutton("resize",{height:tb.height()});
btn.css({left:(opts.buttonAlign=="left"?0:""),right:(opts.buttonAlign=="right"?0:"")});
_4d3.css({left:(opts.iconAlign=="left"?(opts.buttonAlign=="left"?btn._outerWidth():0):""),right:(opts.iconAlign=="right"?(opts.buttonAlign=="right"?btn._outerWidth():0):"")});
_4d4.css({width:opts.iconWidth+"px",height:tb.height()+"px"});
_4d2.css({paddingLeft:(_4cd.style.paddingLeft||""),paddingRight:(_4cd.style.paddingRight||""),marginLeft:_4d5("left"),marginRight:_4d5("right")});
if(opts.multiline){
_4d2.css({paddingTop:(_4cd.style.paddingTop||""),paddingBottom:(_4cd.style.paddingBottom||"")});
_4d2._outerHeight(tb.height());
}else{
_4d2.css({paddingTop:0,paddingBottom:0,height:tb.height()+"px",lineHeight:tb.height()+"px"});
}
_4d2._outerWidth(tb.width()-_4d4.length*opts.iconWidth-btn._outerWidth());
if(!_4d1){
tb.insertAfter(_4cd);
}
opts.onResize.call(_4cd,opts.width,opts.height);
function _4d5(_4d6){
return (opts.iconAlign==_4d6?_4d3._outerWidth():0)+(opts.buttonAlign==_4d6?btn._outerWidth():0);
};
};
function _4c7(_4d7){
var opts=$(_4d7).textbox("options");
var _4d8=$(_4d7).textbox("textbox");
_4d8.validatebox($.extend({},opts,{deltaX:$(_4d7).textbox("getTipX"),onBeforeValidate:function(){
opts.onBeforeValidate.call(_4d7);
var box=$(this);
if(!box.is(":focus")){
opts.oldInputValue=box.val();
box.val(opts.value);
}
},onValidate:function(_4d9){
var box=$(this);
if(opts.oldInputValue!=undefined){
box.val(opts.oldInputValue);
opts.oldInputValue=undefined;
}
var tb=box.parent();
if(_4d9){
tb.removeClass("textbox-invalid");
}else{
tb.addClass("textbox-invalid");
}
opts.onValidate.call(_4d7,_4d9);
}}));
};
function _4da(_4db){
var _4dc=$.data(_4db,"textbox");
var opts=_4dc.options;
var tb=_4dc.textbox;
var _4dd=tb.find(".textbox-text");
_4dd.attr("placeholder",opts.prompt);
_4dd.unbind(".textbox");
if(!opts.disabled&&!opts.readonly){
_4dd.bind("blur.textbox",function(e){
if(!tb.hasClass("textbox-focused")){
return;
}
opts.value=$(this).val();
if(opts.value==""){
$(this).val(opts.prompt).addClass("textbox-prompt");
}else{
$(this).removeClass("textbox-prompt");
}
tb.removeClass("textbox-focused");
}).bind("focus.textbox",function(e){
if(tb.hasClass("textbox-focused")){
return;
}
if($(this).val()!=opts.value){
$(this).val(opts.value);
}
$(this).removeClass("textbox-prompt");
tb.addClass("textbox-focused");
});
for(var _4de in opts.inputEvents){
_4dd.bind(_4de+".textbox",{target:_4db},opts.inputEvents[_4de]);
}
}
var _4df=tb.find(".textbox-addon");
_4df.unbind().bind("click",{target:_4db},function(e){
var icon=$(e.target).closest("a.textbox-icon:not(.textbox-icon-disabled)");
if(icon.length){
var _4e0=parseInt(icon.attr("icon-index"));
var conf=opts.icons[_4e0];
if(conf&&conf.handler){
conf.handler.call(icon[0],e);
opts.onClickIcon.call(_4db,_4e0);
}
}
});
_4df.find(".textbox-icon").each(function(_4e1){
var conf=opts.icons[_4e1];
var icon=$(this);
if(!conf||conf.disabled||opts.disabled||opts.readonly){
icon.addClass("textbox-icon-disabled");
}else{
icon.removeClass("textbox-icon-disabled");
}
});
var btn=tb.find(".textbox-button");
btn.unbind(".textbox").bind("click.textbox",function(){
if(!btn.linkbutton("options").disabled){
opts.onClickButton.call(_4db);
}
});
btn.linkbutton((opts.disabled||opts.readonly)?"disable":"enable");
tb.unbind(".textbox").bind("_resize.textbox",function(e,_4e2){
if($(this).hasClass("easyui-fluid")||_4e2){
_4cc(_4db);
}
return false;
});
};
function _4c8(_4e3,_4e4){
var _4e5=$.data(_4e3,"textbox");
var opts=_4e5.options;
var tb=_4e5.textbox;
var _4e6=tb.find(".textbox-text");
var ss=$(_4e3).add(tb.find(".textbox-value"));
opts.disabled=_4e4;
if(opts.disabled){
_4e6.validatebox("disable");
tb.addClass("textbox-disabled");
ss.attr("disabled","disabled");
}else{
_4e6.validatebox("enable");
tb.removeClass("textbox-disabled");
ss.removeAttr("disabled");
}
};
function _4c9(_4e7,mode){
var _4e8=$.data(_4e7,"textbox");
var opts=_4e8.options;
var tb=_4e8.textbox;
var _4e9=tb.find(".textbox-text");
_4e9.validatebox("readonly",mode);
opts.readonly=_4e9.validatebox("options").readonly;
tb.removeClass("textbox-readonly").addClass(opts.readonly?"textbox-readonly":"");
};
$.fn.textbox=function(_4ea,_4eb){
if(typeof _4ea=="string"){
var _4ec=$.fn.textbox.methods[_4ea];
if(_4ec){
return _4ec(this,_4eb);
}else{
return this.each(function(){
var _4ed=$(this).textbox("textbox");
_4ed.validatebox(_4ea,_4eb);
});
}
}
_4ea=_4ea||{};
return this.each(function(){
var _4ee=$.data(this,"textbox");
if(_4ee){
$.extend(_4ee.options,_4ea);
if(_4ea.value!=undefined){
_4ee.options.originalValue=_4ea.value;
}
}else{
_4ee=$.data(this,"textbox",{options:$.extend({},$.fn.textbox.defaults,$.fn.textbox.parseOptions(this),_4ea),textbox:init(this)});
_4ee.options.originalValue=_4ee.options.value;
}
_4c4(this);
_4da(this);
_4cc(this);
$(this).textbox("initValue",_4ee.options.value);
});
};
$.fn.textbox.methods={options:function(jq){
return $.data(jq[0],"textbox").options;
},cloneFrom:function(jq,from){
return jq.each(function(){
var t=$(this);
if(t.data("textbox")){
return;
}
if(!$(from).data("textbox")){
$(from).textbox();
}
var name=t.attr("name")||"";
t.addClass("textbox-f").hide();
t.removeAttr("name").attr("textboxName",name);
var span=$(from).next().clone().insertAfter(t);
span.find("input.textbox-value").attr("name",name);
$.data(this,"textbox",{options:$.extend(true,{},$(from).textbox("options")),textbox:span});
var _4ef=$(from).textbox("button");
if(_4ef.length){
t.textbox("button").linkbutton($.extend(true,{},_4ef.linkbutton("options")));
}
_4da(this);
_4c7(this);
});
},textbox:function(jq){
return $.data(jq[0],"textbox").textbox.find(".textbox-text");
},button:function(jq){
return $.data(jq[0],"textbox").textbox.find(".textbox-button");
},destroy:function(jq){
return jq.each(function(){
_4ca(this);
});
},resize:function(jq,_4f0){
return jq.each(function(){
_4cc(this,_4f0);
});
},disable:function(jq){
return jq.each(function(){
_4c8(this,true);
_4da(this);
});
},enable:function(jq){
return jq.each(function(){
_4c8(this,false);
_4da(this);
});
},readonly:function(jq,mode){
return jq.each(function(){
_4c9(this,mode);
_4da(this);
});
},isValid:function(jq){
return jq.textbox("textbox").validatebox("isValid");
},clear:function(jq){
return jq.each(function(){
$(this).textbox("setValue","");
});
},setText:function(jq,_4f1){
return jq.each(function(){
var opts=$(this).textbox("options");
var _4f2=$(this).textbox("textbox");
_4f1=_4f1==undefined?"":String(_4f1);
if($(this).textbox("getText")!=_4f1){
_4f2.val(_4f1);
}
opts.value=_4f1;
if(!_4f2.is(":focus")){
if(_4f1){
_4f2.removeClass("textbox-prompt");
}else{
_4f2.val(opts.prompt).addClass("textbox-prompt");
}
}
$(this).textbox("validate");
});
},initValue:function(jq,_4f3){
return jq.each(function(){
var _4f4=$.data(this,"textbox");
_4f4.options.value="";
$(this).textbox("setText",_4f3);
_4f4.textbox.find(".textbox-value").val(_4f3);
$(this).val(_4f3);
});
},setValue:function(jq,_4f5){
return jq.each(function(){
var opts=$.data(this,"textbox").options;
var _4f6=$(this).textbox("getValue");
$(this).textbox("initValue",_4f5);
if(_4f6!=_4f5){
opts.onChange.call(this,_4f5,_4f6);
$(this).closest("form").trigger("_change",[this]);
}
});
},getText:function(jq){
var _4f7=jq.textbox("textbox");
if(_4f7.is(":focus")){
return _4f7.val();
}else{
return jq.textbox("options").value;
}
},getValue:function(jq){
return jq.data("textbox").textbox.find(".textbox-value").val();
},reset:function(jq){
return jq.each(function(){
var opts=$(this).textbox("options");
$(this).textbox("setValue",opts.originalValue);
});
},getIcon:function(jq,_4f8){
return jq.data("textbox").textbox.find(".textbox-icon:eq("+_4f8+")");
},getTipX:function(jq){
var _4f9=jq.data("textbox");
var opts=_4f9.options;
var tb=_4f9.textbox;
var _4fa=tb.find(".textbox-text");
var _4fb=tb.find(".textbox-addon")._outerWidth();
var _4fc=tb.find(".textbox-button")._outerWidth();
if(opts.tipPosition=="right"){
return (opts.iconAlign=="right"?_4fb:0)+(opts.buttonAlign=="right"?_4fc:0)+1;
}else{
if(opts.tipPosition=="left"){
return (opts.iconAlign=="left"?-_4fb:0)+(opts.buttonAlign=="left"?-_4fc:0)-1;
}else{
return _4fb/2*(opts.iconAlign=="right"?1:-1);
}
}
}};
$.fn.textbox.parseOptions=function(_4fd){
var t=$(_4fd);
return $.extend({},$.fn.validatebox.parseOptions(_4fd),$.parser.parseOptions(_4fd,["prompt","iconCls","iconAlign","buttonText","buttonIcon","buttonAlign",{multiline:"boolean",iconWidth:"number"}]),{value:(t.val()||undefined),type:(t.attr("type")?t.attr("type"):undefined)});
};
$.fn.textbox.defaults=$.extend({},$.fn.validatebox.defaults,{width:"auto",height:22,prompt:"",value:"",type:"text",multiline:false,icons:[],iconCls:null,iconAlign:"right",iconWidth:18,buttonText:"",buttonIcon:null,buttonAlign:"right",inputEvents:{blur:function(e){
var t=$(e.data.target);
var opts=t.textbox("options");
t.textbox("setValue",opts.value);
},keydown:function(e){
if(e.keyCode==13){
var t=$(e.data.target);
t.textbox("setValue",t.textbox("getText"));
}
}},onChange:function(_4fe,_4ff){
},onResize:function(_500,_501){
},onClickButton:function(){
},onClickIcon:function(_502){
}});
})(jQuery);
(function($){
var _503=0;
function _504(_505){
var _506=$.data(_505,"filebox");
var opts=_506.options;
opts.fileboxId="filebox_file_id_"+(++_503);
$(_505).addClass("filebox-f").textbox(opts);
$(_505).textbox("textbox").attr("readonly","readonly");
_506.filebox=$(_505).next().addClass("filebox");
var file=_507(_505);
var btn=$(_505).filebox("button");
if(btn.length){
$("<label class=\"filebox-label\" for=\""+opts.fileboxId+"\"></label>").appendTo(btn);
if(btn.linkbutton("options").disabled){
file.attr("disabled","disabled");
}else{
file.removeAttr("disabled");
}
}
};
function _507(_508){
var _509=$.data(_508,"filebox");
var opts=_509.options;
_509.filebox.find(".textbox-value").remove();
opts.oldValue="";
var file=$("<input type=\"file\" class=\"textbox-value\">").appendTo(_509.filebox);
file.attr("id",opts.fileboxId).attr("name",$(_508).attr("textboxName")||"");
file.attr("accept",opts.accept);
if(opts.multiple){
file.attr("multiple","multiple");
}
file.change(function(){
var _50a=this.value;
if(this.files){
_50a=$.map(this.files,function(file){
return file.name;
}).join(opts.separator);
}
$(_508).filebox("setText",_50a);
opts.onChange.call(_508,_50a,opts.oldValue);
opts.oldValue=_50a;
});
return file;
};
$.fn.filebox=function(_50b,_50c){
if(typeof _50b=="string"){
var _50d=$.fn.filebox.methods[_50b];
if(_50d){
return _50d(this,_50c);
}else{
return this.textbox(_50b,_50c);
}
}
_50b=_50b||{};
return this.each(function(){
var _50e=$.data(this,"filebox");
if(_50e){
$.extend(_50e.options,_50b);
}else{
$.data(this,"filebox",{options:$.extend({},$.fn.filebox.defaults,$.fn.filebox.parseOptions(this),_50b)});
}
_504(this);
});
};
$.fn.filebox.methods={options:function(jq){
var opts=jq.textbox("options");
return $.extend($.data(jq[0],"filebox").options,{width:opts.width,value:opts.value,originalValue:opts.originalValue,disabled:opts.disabled,readonly:opts.readonly});
},clear:function(jq){
return jq.each(function(){
$(this).textbox("clear");
_507(this);
});
},reset:function(jq){
return jq.each(function(){
$(this).filebox("clear");
});
}};
$.fn.filebox.parseOptions=function(_50f){
var t=$(_50f);
return $.extend({},$.fn.textbox.parseOptions(_50f),$.parser.parseOptions(_50f,["accept","separator"]),{multiple:(t.attr("multiple")?true:undefined)});
};
$.fn.filebox.defaults=$.extend({},$.fn.textbox.defaults,{buttonIcon:null,buttonText:"Choose File",buttonAlign:"right",inputEvents:{},accept:"",separator:",",multiple:false});
})(jQuery);
(function($){
function _510(_511){
var _512=$.data(_511,"searchbox");
var opts=_512.options;
var _513=$.extend(true,[],opts.icons);
_513.push({iconCls:"searchbox-button",handler:function(e){
var t=$(e.data.target);
var opts=t.searchbox("options");
opts.searcher.call(e.data.target,t.searchbox("getValue"),t.searchbox("getName"));
}});
_514();
var _515=_516();
$(_511).addClass("searchbox-f").textbox($.extend({},opts,{icons:_513,buttonText:(_515?_515.text:"")}));
$(_511).attr("searchboxName",$(_511).attr("textboxName"));
_512.searchbox=$(_511).next();
_512.searchbox.addClass("searchbox");
_517(_515);
function _514(){
if(opts.menu){
_512.menu=$(opts.menu).menu();
var _518=_512.menu.menu("options");
var _519=_518.onClick;
_518.onClick=function(item){
_517(item);
_519.call(this,item);
};
}else{
if(_512.menu){
_512.menu.menu("destroy");
}
_512.menu=null;
}
};
function _516(){
if(_512.menu){
var item=_512.menu.children("div.menu-item:first");
_512.menu.children("div.menu-item").each(function(){
var _51a=$.extend({},$.parser.parseOptions(this),{selected:($(this).attr("selected")?true:undefined)});
if(_51a.selected){
item=$(this);
return false;
}
});
return _512.menu.menu("getItem",item[0]);
}else{
return null;
}
};
function _517(item){
if(!item){
return;
}
$(_511).textbox("button").menubutton({text:item.text,iconCls:(item.iconCls||null),menu:_512.menu,menuAlign:opts.buttonAlign,plain:false});
_512.searchbox.find("input.textbox-value").attr("name",item.name||item.text);
$(_511).searchbox("resize");
};
};
$.fn.searchbox=function(_51b,_51c){
if(typeof _51b=="string"){
var _51d=$.fn.searchbox.methods[_51b];
if(_51d){
return _51d(this,_51c);
}else{
return this.textbox(_51b,_51c);
}
}
_51b=_51b||{};
return this.each(function(){
var _51e=$.data(this,"searchbox");
if(_51e){
$.extend(_51e.options,_51b);
}else{
$.data(this,"searchbox",{options:$.extend({},$.fn.searchbox.defaults,$.fn.searchbox.parseOptions(this),_51b)});
}
_510(this);
});
};
$.fn.searchbox.methods={options:function(jq){
var opts=jq.textbox("options");
return $.extend($.data(jq[0],"searchbox").options,{width:opts.width,value:opts.value,originalValue:opts.originalValue,disabled:opts.disabled,readonly:opts.readonly});
},menu:function(jq){
return $.data(jq[0],"searchbox").menu;
},getName:function(jq){
return $.data(jq[0],"searchbox").searchbox.find("input.textbox-value").attr("name");
},selectName:function(jq,name){
return jq.each(function(){
var menu=$.data(this,"searchbox").menu;
if(menu){
menu.children("div.menu-item").each(function(){
var item=menu.menu("getItem",this);
if(item.name==name){
$(this).triggerHandler("click");
return false;
}
});
}
});
},destroy:function(jq){
return jq.each(function(){
var menu=$(this).searchbox("menu");
if(menu){
menu.menu("destroy");
}
$(this).textbox("destroy");
});
}};
$.fn.searchbox.parseOptions=function(_51f){
var t=$(_51f);
return $.extend({},$.fn.textbox.parseOptions(_51f),$.parser.parseOptions(_51f,["menu"]),{searcher:(t.attr("searcher")?eval(t.attr("searcher")):undefined)});
};
$.fn.searchbox.defaults=$.extend({},$.fn.textbox.defaults,{inputEvents:$.extend({},$.fn.textbox.defaults.inputEvents,{keydown:function(e){
if(e.keyCode==13){
e.preventDefault();
var t=$(e.data.target);
var opts=t.searchbox("options");
t.searchbox("setValue",$(this).val());
opts.searcher.call(e.data.target,t.searchbox("getValue"),t.searchbox("getName"));
return false;
}
}}),buttonAlign:"left",menu:null,searcher:function(_520,name){
}});
})(jQuery);
(function($){
function _521(_522,_523){
var opts=$.data(_522,"form").options;
$.extend(opts,_523||{});
var _524=$.extend({},opts.queryParams);
if(opts.onSubmit.call(_522,_524)==false){
return;
}
var _525=$(_522).find(".textbox-text:focus");
_525.triggerHandler("blur");
_525.focus();
if(opts.iframe){
_526(_522,_524);
}else{
if(window.FormData!==undefined){
_527(_522,_524);
}else{
_526(_522,_524);
}
}
};
function _526(_528,_529){
var opts=$.data(_528,"form").options;
var _52a="easyui_frame_"+(new Date().getTime());
var _52b=$("<iframe id="+_52a+" name="+_52a+"></iframe>").appendTo("body");
_52b.attr("src",window.ActiveXObject?"javascript:false":"about:blank");
_52b.css({position:"absolute",top:-1000,left:-1000});
_52b.bind("load",cb);
_52c(_529);
function _52c(_52d){
var form=$(_528);
if(opts.url){
form.attr("action",opts.url);
}
var t=form.attr("target"),a=form.attr("action");
form.attr("target",_52a);
var _52e=$();
try{
for(var n in _52d){
var _52f=$("<input type=\"hidden\" name=\""+n+"\">").val(_52d[n]).appendTo(form);
_52e=_52e.add(_52f);
}
_530();
form[0].submit();
}
finally{
form.attr("action",a);
t?form.attr("target",t):form.removeAttr("target");
_52e.remove();
}
};
function _530(){
var f=$("#"+_52a);
if(!f.length){
return;
}
try{
var s=f.contents()[0].readyState;
if(s&&s.toLowerCase()=="uninitialized"){
setTimeout(_530,100);
}
}
catch(e){
cb();
}
};
var _531=10;
function cb(){
var f=$("#"+_52a);
if(!f.length){
return;
}
f.unbind();
var data="";
try{
var body=f.contents().find("body");
data=body.html();
if(data==""){
if(--_531){
setTimeout(cb,100);
return;
}
}
var ta=body.find(">textarea");
if(ta.length){
data=ta.val();
}else{
var pre=body.find(">pre");
if(pre.length){
data=pre.html();
}
}
}
catch(e){
}
opts.success.call(_528,data);
setTimeout(function(){
f.unbind();
f.remove();
},100);
};
};
function _527(_532,_533){
var opts=$.data(_532,"form").options;
var _534=new FormData($(_532)[0]);
for(var name in _533){
_534.append(name,_533[name]);
}
$.ajax({url:opts.url,type:"post",xhr:function(){
var xhr=$.ajaxSettings.xhr();
if(xhr.upload){
xhr.upload.addEventListener("progress",function(e){
if(e.lengthComputable){
var _535=e.total;
var _536=e.loaded||e.position;
var _537=Math.ceil(_536*100/_535);
opts.onProgress.call(_532,_537);
}
},false);
}
return xhr;
},data:_534,dataType:"html",cache:false,contentType:false,processData:false,complete:function(res){
opts.success.call(_532,res.responseText);
}});
};
function load(_538,data){
var opts=$.data(_538,"form").options;
if(typeof data=="string"){
var _539={};
if(opts.onBeforeLoad.call(_538,_539)==false){
return;
}
$.ajax({url:data,data:_539,dataType:"json",success:function(data){
_53a(data);
},error:function(){
opts.onLoadError.apply(_538,arguments);
}});
}else{
_53a(data);
}
function _53a(data){
var form=$(_538);
for(var name in data){
var val=data[name];
if(!_53b(name,val)){
if(!_53c(name,val)){
form.find("input[name=\""+name+"\"]").val(val);
form.find("textarea[name=\""+name+"\"]").val(val);
form.find("select[name=\""+name+"\"]").val(val);
}
}
}
opts.onLoadSuccess.call(_538,data);
form.form("validate");
};
function _53b(name,val){
var cc=$(_538).find("[switchbuttonName=\""+name+"\"]");
if(cc.length){
cc.switchbutton("uncheck");
cc.each(function(){
if(_53d($(this).switchbutton("options").value,val)){
$(this).switchbutton("check");
}
});
return true;
}
cc=$(_538).find("input[name=\""+name+"\"][type=radio], input[name=\""+name+"\"][type=checkbox]");
if(cc.length){
cc._propAttr("checked",false);
cc.each(function(){
if(_53d($(this).val(),val)){
$(this)._propAttr("checked",true);
}
});
return true;
}
return false;
};
function _53d(v,val){
if(v==String(val)||$.inArray(v,$.isArray(val)?val:[val])>=0){
return true;
}else{
return false;
}
};
function _53c(name,val){
var _53e=$(_538).find("[textboxName=\""+name+"\"],[sliderName=\""+name+"\"]");
if(_53e.length){
for(var i=0;i<opts.fieldTypes.length;i++){
var type=opts.fieldTypes[i];
var _53f=_53e.data(type);
if(_53f){
if(_53f.options.multiple||_53f.options.range){
_53e[type]("setValues",val);
}else{
_53e[type]("setValue",val);
}
return true;
}
}
}
return false;
};
};
function _540(_541){
$("input,select,textarea",_541).each(function(){
var t=this.type,tag=this.tagName.toLowerCase();
if(t=="text"||t=="hidden"||t=="password"||tag=="textarea"){
this.value="";
}else{
if(t=="file"){
var file=$(this);
if(!file.hasClass("textbox-value")){
var _542=file.clone().val("");
_542.insertAfter(file);
if(file.data("validatebox")){
file.validatebox("destroy");
_542.validatebox();
}else{
file.remove();
}
}
}else{
if(t=="checkbox"||t=="radio"){
this.checked=false;
}else{
if(tag=="select"){
this.selectedIndex=-1;
}
}
}
}
});
var form=$(_541);
var opts=$.data(_541,"form").options;
for(var i=opts.fieldTypes.length-1;i>=0;i--){
var type=opts.fieldTypes[i];
var _543=form.find("."+type+"-f");
if(_543.length&&_543[type]){
_543[type]("clear");
}
}
form.form("validate");
};
function _544(_545){
_545.reset();
var form=$(_545);
var opts=$.data(_545,"form").options;
for(var i=opts.fieldTypes.length-1;i>=0;i--){
var type=opts.fieldTypes[i];
var _546=form.find("."+type+"-f");
if(_546.length&&_546[type]){
_546[type]("reset");
}
}
form.form("validate");
};
function _547(_548){
var _549=$.data(_548,"form").options;
$(_548).unbind(".form");
if(_549.ajax){
$(_548).bind("submit.form",function(){
setTimeout(function(){
_521(_548,_549);
},0);
return false;
});
}
$(_548).bind("_change.form",function(e,t){
_549.onChange.call(this,t);
}).bind("change.form",function(e){
var t=e.target;
if(!$(t).hasClass("textbox-text")){
_549.onChange.call(this,t);
}
});
_54a(_548,_549.novalidate);
};
function _54b(_54c,_54d){
_54d=_54d||{};
var _54e=$.data(_54c,"form");
if(_54e){
$.extend(_54e.options,_54d);
}else{
$.data(_54c,"form",{options:$.extend({},$.fn.form.defaults,$.fn.form.parseOptions(_54c),_54d)});
}
};
function _54f(_550){
if($.fn.validatebox){
var t=$(_550);
t.find(".validatebox-text:not(:disabled)").validatebox("validate");
var _551=t.find(".validatebox-invalid");
_551.filter(":not(:disabled):first").focus();
return _551.length==0;
}
return true;
};
function _54a(_552,_553){
var opts=$.data(_552,"form").options;
opts.novalidate=_553;
$(_552).find(".validatebox-text:not(:disabled)").validatebox(_553?"disableValidation":"enableValidation");
};
$.fn.form=function(_554,_555){
if(typeof _554=="string"){
this.each(function(){
_54b(this);
});
return $.fn.form.methods[_554](this,_555);
}
return this.each(function(){
_54b(this,_554);
_547(this);
});
};
$.fn.form.methods={options:function(jq){
return $.data(jq[0],"form").options;
},submit:function(jq,_556){
return jq.each(function(){
_521(this,_556);
});
},load:function(jq,data){
return jq.each(function(){
load(this,data);
});
},clear:function(jq){
return jq.each(function(){
_540(this);
});
},reset:function(jq){
return jq.each(function(){
_544(this);
});
},validate:function(jq){
return _54f(jq[0]);
},disableValidation:function(jq){
return jq.each(function(){
_54a(this,true);
});
},enableValidation:function(jq){
return jq.each(function(){
_54a(this,false);
});
},resetValidation:function(jq){
return jq.each(function(){
$(this).find(".validatebox-text:not(:disabled)").validatebox("resetValidation");
});
}};
$.fn.form.parseOptions=function(_557){
var t=$(_557);
return $.extend({},$.parser.parseOptions(_557,[{ajax:"boolean"}]),{url:(t.attr("action")?t.attr("action"):undefined)});
};
$.fn.form.defaults={fieldTypes:["combobox","combotree","combogrid","datetimebox","datebox","combo","datetimespinner","timespinner","numberspinner","spinner","slider","searchbox","numberbox","textbox","switchbutton"],novalidate:false,ajax:true,iframe:true,url:null,queryParams:{},onSubmit:function(_558){
return $(this).form("validate");
},onProgress:function(_559){
},success:function(data){
},onBeforeLoad:function(_55a){
},onLoadSuccess:function(data){
},onLoadError:function(){
},onChange:function(_55b){
}};
})(jQuery);
(function($){
function _55c(_55d){
var _55e=$.data(_55d,"numberbox");
var opts=_55e.options;
$(_55d).addClass("numberbox-f").textbox(opts);
$(_55d).textbox("textbox").css({imeMode:"disabled"});
$(_55d).attr("numberboxName",$(_55d).attr("textboxName"));
_55e.numberbox=$(_55d).next();
_55e.numberbox.addClass("numberbox");
var _55f=opts.parser.call(_55d,opts.value);
var _560=opts.formatter.call(_55d,_55f);
$(_55d).numberbox("initValue",_55f).numberbox("setText",_560);
};
function _561(_562,_563){
var _564=$.data(_562,"numberbox");
var opts=_564.options;
var _563=opts.parser.call(_562,_563);
var text=opts.formatter.call(_562,_563);
opts.value=_563;
$(_562).textbox("setText",text).textbox("setValue",_563);
text=opts.formatter.call(_562,$(_562).textbox("getValue"));
$(_562).textbox("setText",text);
};
$.fn.numberbox=function(_565,_566){
if(typeof _565=="string"){
var _567=$.fn.numberbox.methods[_565];
if(_567){
return _567(this,_566);
}else{
return this.textbox(_565,_566);
}
}
_565=_565||{};
return this.each(function(){
var _568=$.data(this,"numberbox");
if(_568){
$.extend(_568.options,_565);
}else{
_568=$.data(this,"numberbox",{options:$.extend({},$.fn.numberbox.defaults,$.fn.numberbox.parseOptions(this),_565)});
}
_55c(this);
});
};
$.fn.numberbox.methods={options:function(jq){
var opts=jq.data("textbox")?jq.textbox("options"):{};
return $.extend($.data(jq[0],"numberbox").options,{width:opts.width,originalValue:opts.originalValue,disabled:opts.disabled,readonly:opts.readonly});
},fix:function(jq){
return jq.each(function(){
$(this).numberbox("setValue",$(this).numberbox("getText"));
});
},setValue:function(jq,_569){
return jq.each(function(){
_561(this,_569);
});
},clear:function(jq){
return jq.each(function(){
$(this).textbox("clear");
$(this).numberbox("options").value="";
});
},reset:function(jq){
return jq.each(function(){
$(this).textbox("reset");
$(this).numberbox("setValue",$(this).numberbox("getValue"));
});
}};
$.fn.numberbox.parseOptions=function(_56a){
var t=$(_56a);
return $.extend({},$.fn.textbox.parseOptions(_56a),$.parser.parseOptions(_56a,["decimalSeparator","groupSeparator","suffix",{min:"number",max:"number",precision:"number"}]),{prefix:(t.attr("prefix")?t.attr("prefix"):undefined)});
};
$.fn.numberbox.defaults=$.extend({},$.fn.textbox.defaults,{inputEvents:{keypress:function(e){
var _56b=e.data.target;
var opts=$(_56b).numberbox("options");
return opts.filter.call(_56b,e);
},blur:function(e){
var _56c=e.data.target;
$(_56c).numberbox("setValue",$(_56c).numberbox("getText"));
},keydown:function(e){
if(e.keyCode==13){
var _56d=e.data.target;
$(_56d).numberbox("setValue",$(_56d).numberbox("getText"));
}
}},min:null,max:null,precision:0,decimalSeparator:".",groupSeparator:"",prefix:"",suffix:"",filter:function(e){
var opts=$(this).numberbox("options");
var s=$(this).numberbox("getText");
if(e.which==13){
return true;
}
if(e.which==45){
return (s.indexOf("-")==-1?true:false);
}
var c=String.fromCharCode(e.which);
if(c==opts.decimalSeparator){
return (s.indexOf(c)==-1?true:false);
}else{
if(c==opts.groupSeparator){
return true;
}else{
if((e.which>=48&&e.which<=57&&e.ctrlKey==false&&e.shiftKey==false)||e.which==0||e.which==8){
return true;
}else{
if(e.ctrlKey==true&&(e.which==99||e.which==118)){
return true;
}else{
return false;
}
}
}
}
},formatter:function(_56e){
if(!_56e){
return _56e;
}
_56e=_56e+"";
var opts=$(this).numberbox("options");
var s1=_56e,s2="";
var dpos=_56e.indexOf(".");
if(dpos>=0){
s1=_56e.substring(0,dpos);
s2=_56e.substring(dpos+1,_56e.length);
}
if(opts.groupSeparator){
var p=/(\d+)(\d{3})/;
while(p.test(s1)){
s1=s1.replace(p,"$1"+opts.groupSeparator+"$2");
}
}
if(s2){
return opts.prefix+s1+opts.decimalSeparator+s2+opts.suffix;
}else{
return opts.prefix+s1+opts.suffix;
}
},parser:function(s){
s=s+"";
var opts=$(this).numberbox("options");
if(parseFloat(s)!=s){
if(opts.prefix){
s=$.trim(s.replace(new RegExp("\\"+$.trim(opts.prefix),"g"),""));
}
if(opts.suffix){
s=$.trim(s.replace(new RegExp("\\"+$.trim(opts.suffix),"g"),""));
}
if(opts.groupSeparator){
s=$.trim(s.replace(new RegExp("\\"+opts.groupSeparator,"g"),""));
}
if(opts.decimalSeparator){
s=$.trim(s.replace(new RegExp("\\"+opts.decimalSeparator,"g"),"."));
}
s=s.replace(/\s/g,"");
}
var val=parseFloat(s).toFixed(opts.precision);
if(isNaN(val)){
val="";
}else{
if(typeof (opts.min)=="number"&&val<opts.min){
val=opts.min.toFixed(opts.precision);
}else{
if(typeof (opts.max)=="number"&&val>opts.max){
val=opts.max.toFixed(opts.precision);
}
}
}
return val;
}});
})(jQuery);
(function($){
function _56f(_570,_571){
var opts=$.data(_570,"calendar").options;
var t=$(_570);
if(_571){
$.extend(opts,{width:_571.width,height:_571.height});
}
t._size(opts,t.parent());
t.find(".calendar-body")._outerHeight(t.height()-t.find(".calendar-header")._outerHeight());
if(t.find(".calendar-menu").is(":visible")){
_572(_570);
}
};
function init(_573){
$(_573).addClass("calendar").html("<div class=\"calendar-header\">"+"<div class=\"calendar-nav calendar-prevmonth\"></div>"+"<div class=\"calendar-nav calendar-nextmonth\"></div>"+"<div class=\"calendar-nav calendar-prevyear\"></div>"+"<div class=\"calendar-nav calendar-nextyear\"></div>"+"<div class=\"calendar-title\">"+"<span class=\"calendar-text\"></span>"+"</div>"+"</div>"+"<div class=\"calendar-body\">"+"<div class=\"calendar-menu\">"+"<div class=\"calendar-menu-year-inner\">"+"<span class=\"calendar-nav calendar-menu-prev\"></span>"+"<span><input class=\"calendar-menu-year\" type=\"text\"></input></span>"+"<span class=\"calendar-nav calendar-menu-next\"></span>"+"</div>"+"<div class=\"calendar-menu-month-inner\">"+"</div>"+"</div>"+"</div>");
$(_573).bind("_resize",function(e,_574){
if($(this).hasClass("easyui-fluid")||_574){
_56f(_573);
}
return false;
});
};
function _575(_576){
var opts=$.data(_576,"calendar").options;
var menu=$(_576).find(".calendar-menu");
menu.find(".calendar-menu-year").unbind(".calendar").bind("keypress.calendar",function(e){
if(e.keyCode==13){
_577(true);
}
});
$(_576).unbind(".calendar").bind("mouseover.calendar",function(e){
var t=_578(e.target);
if(t.hasClass("calendar-nav")||t.hasClass("calendar-text")||(t.hasClass("calendar-day")&&!t.hasClass("calendar-disabled"))){
t.addClass("calendar-nav-hover");
}
}).bind("mouseout.calendar",function(e){
var t=_578(e.target);
if(t.hasClass("calendar-nav")||t.hasClass("calendar-text")||(t.hasClass("calendar-day")&&!t.hasClass("calendar-disabled"))){
t.removeClass("calendar-nav-hover");
}
}).bind("click.calendar",function(e){
var t=_578(e.target);
if(t.hasClass("calendar-menu-next")||t.hasClass("calendar-nextyear")){
_579(1);
}else{
if(t.hasClass("calendar-menu-prev")||t.hasClass("calendar-prevyear")){
_579(-1);
}else{
if(t.hasClass("calendar-menu-month")){
menu.find(".calendar-selected").removeClass("calendar-selected");
t.addClass("calendar-selected");
_577(true);
}else{
if(t.hasClass("calendar-prevmonth")){
_57a(-1);
}else{
if(t.hasClass("calendar-nextmonth")){
_57a(1);
}else{
if(t.hasClass("calendar-text")){
if(menu.is(":visible")){
menu.hide();
}else{
_572(_576);
}
}else{
if(t.hasClass("calendar-day")){
if(t.hasClass("calendar-disabled")){
return;
}
var _57b=opts.current;
t.closest("div.calendar-body").find(".calendar-selected").removeClass("calendar-selected");
t.addClass("calendar-selected");
var _57c=t.attr("abbr").split(",");
var y=parseInt(_57c[0]);
var m=parseInt(_57c[1]);
var d=parseInt(_57c[2]);
opts.current=new Date(y,m-1,d);
opts.onSelect.call(_576,opts.current);
if(!_57b||_57b.getTime()!=opts.current.getTime()){
opts.onChange.call(_576,opts.current,_57b);
}
if(opts.year!=y||opts.month!=m){
opts.year=y;
opts.month=m;
show(_576);
}
}
}
}
}
}
}
}
});
function _578(t){
var day=$(t).closest(".calendar-day");
if(day.length){
return day;
}else{
return $(t);
}
};
function _577(_57d){
var menu=$(_576).find(".calendar-menu");
var year=menu.find(".calendar-menu-year").val();
var _57e=menu.find(".calendar-selected").attr("abbr");
if(!isNaN(year)){
opts.year=parseInt(year);
opts.month=parseInt(_57e);
show(_576);
}
if(_57d){
menu.hide();
}
};
function _579(_57f){
opts.year+=_57f;
show(_576);
menu.find(".calendar-menu-year").val(opts.year);
};
function _57a(_580){
opts.month+=_580;
if(opts.month>12){
opts.year++;
opts.month=1;
}else{
if(opts.month<1){
opts.year--;
opts.month=12;
}
}
show(_576);
menu.find("td.calendar-selected").removeClass("calendar-selected");
menu.find("td:eq("+(opts.month-1)+")").addClass("calendar-selected");
};
};
function _572(_581){
var opts=$.data(_581,"calendar").options;
$(_581).find(".calendar-menu").show();
if($(_581).find(".calendar-menu-month-inner").is(":empty")){
$(_581).find(".calendar-menu-month-inner").empty();
var t=$("<table class=\"calendar-mtable\"></table>").appendTo($(_581).find(".calendar-menu-month-inner"));
var idx=0;
for(var i=0;i<3;i++){
var tr=$("<tr></tr>").appendTo(t);
for(var j=0;j<4;j++){
$("<td class=\"calendar-nav calendar-menu-month\"></td>").html(opts.months[idx++]).attr("abbr",idx).appendTo(tr);
}
}
}
var body=$(_581).find(".calendar-body");
var sele=$(_581).find(".calendar-menu");
var _582=sele.find(".calendar-menu-year-inner");
var _583=sele.find(".calendar-menu-month-inner");
_582.find("input").val(opts.year).focus();
_583.find("td.calendar-selected").removeClass("calendar-selected");
_583.find("td:eq("+(opts.month-1)+")").addClass("calendar-selected");
sele._outerWidth(body._outerWidth());
sele._outerHeight(body._outerHeight());
_583._outerHeight(sele.height()-_582._outerHeight());
};
function _584(_585,year,_586){
var opts=$.data(_585,"calendar").options;
var _587=[];
var _588=new Date(year,_586,0).getDate();
for(var i=1;i<=_588;i++){
_587.push([year,_586,i]);
}
var _589=[],week=[];
var _58a=-1;
while(_587.length>0){
var date=_587.shift();
week.push(date);
var day=new Date(date[0],date[1]-1,date[2]).getDay();
if(_58a==day){
day=0;
}else{
if(day==(opts.firstDay==0?7:opts.firstDay)-1){
_589.push(week);
week=[];
}
}
_58a=day;
}
if(week.length){
_589.push(week);
}
var _58b=_589[0];
if(_58b.length<7){
while(_58b.length<7){
var _58c=_58b[0];
var date=new Date(_58c[0],_58c[1]-1,_58c[2]-1);
_58b.unshift([date.getFullYear(),date.getMonth()+1,date.getDate()]);
}
}else{
var _58c=_58b[0];
var week=[];
for(var i=1;i<=7;i++){
var date=new Date(_58c[0],_58c[1]-1,_58c[2]-i);
week.unshift([date.getFullYear(),date.getMonth()+1,date.getDate()]);
}
_589.unshift(week);
}
var _58d=_589[_589.length-1];
while(_58d.length<7){
var _58e=_58d[_58d.length-1];
var date=new Date(_58e[0],_58e[1]-1,_58e[2]+1);
_58d.push([date.getFullYear(),date.getMonth()+1,date.getDate()]);
}
if(_589.length<6){
var _58e=_58d[_58d.length-1];
var week=[];
for(var i=1;i<=7;i++){
var date=new Date(_58e[0],_58e[1]-1,_58e[2]+i);
week.push([date.getFullYear(),date.getMonth()+1,date.getDate()]);
}
_589.push(week);
}
return _589;
};
function show(_58f){
var opts=$.data(_58f,"calendar").options;
if(opts.current&&!opts.validator.call(_58f,opts.current)){
opts.current=null;
}
var now=new Date();
var _590=now.getFullYear()+","+(now.getMonth()+1)+","+now.getDate();
var _591=opts.current?(opts.current.getFullYear()+","+(opts.current.getMonth()+1)+","+opts.current.getDate()):"";
var _592=6-opts.firstDay;
var _593=_592+1;
if(_592>=7){
_592-=7;
}
if(_593>=7){
_593-=7;
}
$(_58f).find(".calendar-title span").html(opts.months[opts.month-1]+" "+opts.year);
var body=$(_58f).find("div.calendar-body");
body.children("table").remove();
var data=["<table class=\"calendar-dtable\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">"];
data.push("<thead><tr>");
for(var i=opts.firstDay;i<opts.weeks.length;i++){
data.push("<th>"+opts.weeks[i]+"</th>");
}
for(var i=0;i<opts.firstDay;i++){
data.push("<th>"+opts.weeks[i]+"</th>");
}
data.push("</tr></thead>");
data.push("<tbody>");
var _594=_584(_58f,opts.year,opts.month);
for(var i=0;i<_594.length;i++){
var week=_594[i];
var cls="";
if(i==0){
cls="calendar-first";
}else{
if(i==_594.length-1){
cls="calendar-last";
}
}
data.push("<tr class=\""+cls+"\">");
for(var j=0;j<week.length;j++){
var day=week[j];
var s=day[0]+","+day[1]+","+day[2];
var _595=new Date(day[0],parseInt(day[1])-1,day[2]);
var d=opts.formatter.call(_58f,_595);
var css=opts.styler.call(_58f,_595);
var _596="";
var _597="";
if(typeof css=="string"){
_597=css;
}else{
if(css){
_596=css["class"]||"";
_597=css["style"]||"";
}
}
var cls="calendar-day";
if(!(opts.year==day[0]&&opts.month==day[1])){
cls+=" calendar-other-month";
}
if(s==_590){
cls+=" calendar-today";
}
if(s==_591){
cls+=" calendar-selected";
}
if(j==_592){
cls+=" calendar-saturday";
}else{
if(j==_593){
cls+=" calendar-sunday";
}
}
if(j==0){
cls+=" calendar-first";
}else{
if(j==week.length-1){
cls+=" calendar-last";
}
}
cls+=" "+_596;
if(!opts.validator.call(_58f,_595)){
cls+=" calendar-disabled";
}
data.push("<td class=\""+cls+"\" abbr=\""+s+"\" style=\""+_597+"\">"+d+"</td>");
}
data.push("</tr>");
}
data.push("</tbody>");
data.push("</table>");
body.append(data.join(""));
body.children("table.calendar-dtable").prependTo(body);
opts.onNavigate.call(_58f,opts.year,opts.month);
};
$.fn.calendar=function(_598,_599){
if(typeof _598=="string"){
return $.fn.calendar.methods[_598](this,_599);
}
_598=_598||{};
return this.each(function(){
var _59a=$.data(this,"calendar");
if(_59a){
$.extend(_59a.options,_598);
}else{
_59a=$.data(this,"calendar",{options:$.extend({},$.fn.calendar.defaults,$.fn.calendar.parseOptions(this),_598)});
init(this);
}
if(_59a.options.border==false){
$(this).addClass("calendar-noborder");
}
_56f(this);
_575(this);
show(this);
$(this).find("div.calendar-menu").hide();
});
};
$.fn.calendar.methods={options:function(jq){
return $.data(jq[0],"calendar").options;
},resize:function(jq,_59b){
return jq.each(function(){
_56f(this,_59b);
});
},moveTo:function(jq,date){
return jq.each(function(){
if(!date){
var now=new Date();
$(this).calendar({year:now.getFullYear(),month:now.getMonth()+1,current:date});
return;
}
var opts=$(this).calendar("options");
if(opts.validator.call(this,date)){
var _59c=opts.current;
$(this).calendar({year:date.getFullYear(),month:date.getMonth()+1,current:date});
if(!_59c||_59c.getTime()!=date.getTime()){
opts.onChange.call(this,opts.current,_59c);
}
}
});
}};
$.fn.calendar.parseOptions=function(_59d){
var t=$(_59d);
return $.extend({},$.parser.parseOptions(_59d,[{firstDay:"number",fit:"boolean",border:"boolean"}]));
};
$.fn.calendar.defaults={width:180,height:180,fit:false,border:true,firstDay:0,weeks:["S","M","T","W","T","F","S"],months:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],year:new Date().getFullYear(),month:new Date().getMonth()+1,current:(function(){
var d=new Date();
return new Date(d.getFullYear(),d.getMonth(),d.getDate());
})(),formatter:function(date){
return date.getDate();
},styler:function(date){
return "";
},validator:function(date){
return true;
},onSelect:function(date){
},onChange:function(_59e,_59f){
},onNavigate:function(year,_5a0){
}};
})(jQuery);
(function($){
function _5a1(_5a2){
var _5a3=$.data(_5a2,"spinner");
var opts=_5a3.options;
var _5a4=$.extend(true,[],opts.icons);
_5a4.push({iconCls:"spinner-arrow",handler:function(e){
_5a5(e);
}});
$(_5a2).addClass("spinner-f").textbox($.extend({},opts,{icons:_5a4}));
var _5a6=$(_5a2).textbox("getIcon",_5a4.length-1);
_5a6.append("<a href=\"javascript:void(0)\" class=\"spinner-arrow-up\" tabindex=\"-1\"></a>");
_5a6.append("<a href=\"javascript:void(0)\" class=\"spinner-arrow-down\" tabindex=\"-1\"></a>");
$(_5a2).attr("spinnerName",$(_5a2).attr("textboxName"));
_5a3.spinner=$(_5a2).next();
_5a3.spinner.addClass("spinner");
};
function _5a5(e){
var _5a7=e.data.target;
var opts=$(_5a7).spinner("options");
var up=$(e.target).closest("a.spinner-arrow-up");
if(up.length){
opts.spin.call(_5a7,false);
opts.onSpinUp.call(_5a7);
$(_5a7).spinner("validate");
}
var down=$(e.target).closest("a.spinner-arrow-down");
if(down.length){
opts.spin.call(_5a7,true);
opts.onSpinDown.call(_5a7);
$(_5a7).spinner("validate");
}
};
$.fn.spinner=function(_5a8,_5a9){
if(typeof _5a8=="string"){
var _5aa=$.fn.spinner.methods[_5a8];
if(_5aa){
return _5aa(this,_5a9);
}else{
return this.textbox(_5a8,_5a9);
}
}
_5a8=_5a8||{};
return this.each(function(){
var _5ab=$.data(this,"spinner");
if(_5ab){
$.extend(_5ab.options,_5a8);
}else{
_5ab=$.data(this,"spinner",{options:$.extend({},$.fn.spinner.defaults,$.fn.spinner.parseOptions(this),_5a8)});
}
_5a1(this);
});
};
$.fn.spinner.methods={options:function(jq){
var opts=jq.textbox("options");
return $.extend($.data(jq[0],"spinner").options,{width:opts.width,value:opts.value,originalValue:opts.originalValue,disabled:opts.disabled,readonly:opts.readonly});
}};
$.fn.spinner.parseOptions=function(_5ac){
return $.extend({},$.fn.textbox.parseOptions(_5ac),$.parser.parseOptions(_5ac,["min","max",{increment:"number"}]));
};
$.fn.spinner.defaults=$.extend({},$.fn.textbox.defaults,{min:null,max:null,increment:1,spin:function(down){
},onSpinUp:function(){
},onSpinDown:function(){
}});
})(jQuery);
(function($){
function _5ad(_5ae){
$(_5ae).addClass("numberspinner-f");
var opts=$.data(_5ae,"numberspinner").options;
$(_5ae).numberbox(opts).spinner(opts);
$(_5ae).numberbox("setValue",opts.value);
};
function _5af(_5b0,down){
var opts=$.data(_5b0,"numberspinner").options;
var v=parseFloat($(_5b0).numberbox("getValue")||opts.value)||0;
if(down){
v-=opts.increment;
}else{
v+=opts.increment;
}
$(_5b0).numberbox("setValue",v);
};
$.fn.numberspinner=function(_5b1,_5b2){
if(typeof _5b1=="string"){
var _5b3=$.fn.numberspinner.methods[_5b1];
if(_5b3){
return _5b3(this,_5b2);
}else{
return this.numberbox(_5b1,_5b2);
}
}
_5b1=_5b1||{};
return this.each(function(){
var _5b4=$.data(this,"numberspinner");
if(_5b4){
$.extend(_5b4.options,_5b1);
}else{
$.data(this,"numberspinner",{options:$.extend({},$.fn.numberspinner.defaults,$.fn.numberspinner.parseOptions(this),_5b1)});
}
_5ad(this);
});
};
$.fn.numberspinner.methods={options:function(jq){
var opts=jq.numberbox("options");
return $.extend($.data(jq[0],"numberspinner").options,{width:opts.width,value:opts.value,originalValue:opts.originalValue,disabled:opts.disabled,readonly:opts.readonly});
}};
$.fn.numberspinner.parseOptions=function(_5b5){
return $.extend({},$.fn.spinner.parseOptions(_5b5),$.fn.numberbox.parseOptions(_5b5),{});
};
$.fn.numberspinner.defaults=$.extend({},$.fn.spinner.defaults,$.fn.numberbox.defaults,{spin:function(down){
_5af(this,down);
}});
})(jQuery);
(function($){
function _5b6(_5b7){
var _5b8=0;
if(typeof _5b7.selectionStart=="number"){
_5b8=_5b7.selectionStart;
}else{
if(_5b7.createTextRange){
var _5b9=_5b7.createTextRange();
var s=document.selection.createRange();
s.setEndPoint("StartToStart",_5b9);
_5b8=s.text.length;
}
}
return _5b8;
};
function _5ba(_5bb,_5bc,end){
if(_5bb.setSelectionRange){
_5bb.setSelectionRange(_5bc,end);
}else{
if(_5bb.createTextRange){
var _5bd=_5bb.createTextRange();
_5bd.collapse();
_5bd.moveEnd("character",end);
_5bd.moveStart("character",_5bc);
_5bd.select();
}
}
};
function _5be(_5bf){
var opts=$.data(_5bf,"timespinner").options;
$(_5bf).addClass("timespinner-f").spinner(opts);
var _5c0=opts.formatter.call(_5bf,opts.parser.call(_5bf,opts.value));
$(_5bf).timespinner("initValue",_5c0);
};
function _5c1(e){
var _5c2=e.data.target;
var opts=$.data(_5c2,"timespinner").options;
var _5c3=_5b6(this);
for(var i=0;i<opts.selections.length;i++){
var _5c4=opts.selections[i];
if(_5c3>=_5c4[0]&&_5c3<=_5c4[1]){
_5c5(_5c2,i);
return;
}
}
};
function _5c5(_5c6,_5c7){
var opts=$.data(_5c6,"timespinner").options;
if(_5c7!=undefined){
opts.highlight=_5c7;
}
var _5c8=opts.selections[opts.highlight];
if(_5c8){
var tb=$(_5c6).timespinner("textbox");
_5ba(tb[0],_5c8[0],_5c8[1]);
tb.focus();
}
};
function _5c9(_5ca,_5cb){
var opts=$.data(_5ca,"timespinner").options;
var _5cb=opts.parser.call(_5ca,_5cb);
var text=opts.formatter.call(_5ca,_5cb);
$(_5ca).spinner("setValue",text);
};
function _5cc(_5cd,down){
var opts=$.data(_5cd,"timespinner").options;
var s=$(_5cd).timespinner("getValue");
var _5ce=opts.selections[opts.highlight];
var s1=s.substring(0,_5ce[0]);
var s2=s.substring(_5ce[0],_5ce[1]);
var s3=s.substring(_5ce[1]);
var v=s1+((parseInt(s2,10)||0)+opts.increment*(down?-1:1))+s3;
$(_5cd).timespinner("setValue",v);
_5c5(_5cd);
};
$.fn.timespinner=function(_5cf,_5d0){
if(typeof _5cf=="string"){
var _5d1=$.fn.timespinner.methods[_5cf];
if(_5d1){
return _5d1(this,_5d0);
}else{
return this.spinner(_5cf,_5d0);
}
}
_5cf=_5cf||{};
return this.each(function(){
var _5d2=$.data(this,"timespinner");
if(_5d2){
$.extend(_5d2.options,_5cf);
}else{
$.data(this,"timespinner",{options:$.extend({},$.fn.timespinner.defaults,$.fn.timespinner.parseOptions(this),_5cf)});
}
_5be(this);
});
};
$.fn.timespinner.methods={options:function(jq){
var opts=jq.data("spinner")?jq.spinner("options"):{};
return $.extend($.data(jq[0],"timespinner").options,{width:opts.width,value:opts.value,originalValue:opts.originalValue,disabled:opts.disabled,readonly:opts.readonly});
},setValue:function(jq,_5d3){
return jq.each(function(){
_5c9(this,_5d3);
});
},getHours:function(jq){
var opts=$.data(jq[0],"timespinner").options;
var vv=jq.timespinner("getValue").split(opts.separator);
return parseInt(vv[0],10);
},getMinutes:function(jq){
var opts=$.data(jq[0],"timespinner").options;
var vv=jq.timespinner("getValue").split(opts.separator);
return parseInt(vv[1],10);
},getSeconds:function(jq){
var opts=$.data(jq[0],"timespinner").options;
var vv=jq.timespinner("getValue").split(opts.separator);
return parseInt(vv[2],10)||0;
}};
$.fn.timespinner.parseOptions=function(_5d4){
return $.extend({},$.fn.spinner.parseOptions(_5d4),$.parser.parseOptions(_5d4,["separator",{showSeconds:"boolean",highlight:"number"}]));
};
$.fn.timespinner.defaults=$.extend({},$.fn.spinner.defaults,{inputEvents:$.extend({},$.fn.spinner.defaults.inputEvents,{click:function(e){
_5c1.call(this,e);
},blur:function(e){
var t=$(e.data.target);
t.timespinner("setValue",t.timespinner("getText"));
},keydown:function(e){
if(e.keyCode==13){
var t=$(e.data.target);
t.timespinner("setValue",t.timespinner("getText"));
}
}}),formatter:function(date){
if(!date){
return "";
}
var opts=$(this).timespinner("options");
var tt=[_5d5(date.getHours()),_5d5(date.getMinutes())];
if(opts.showSeconds){
tt.push(_5d5(date.getSeconds()));
}
return tt.join(opts.separator);
function _5d5(_5d6){
return (_5d6<10?"0":"")+_5d6;
};
},parser:function(s){
var opts=$(this).timespinner("options");
var date=_5d7(s);
if(date){
var min=_5d7(opts.min);
var max=_5d7(opts.max);
if(min&&min>date){
date=min;
}
if(max&&max<date){
date=max;
}
}
return date;
function _5d7(s){
if(!s){
return null;
}
var tt=s.split(opts.separator);
return new Date(1900,0,0,parseInt(tt[0],10)||0,parseInt(tt[1],10)||0,parseInt(tt[2],10)||0);
};
},selections:[[0,2],[3,5],[6,8]],separator:":",showSeconds:false,highlight:0,spin:function(down){
_5cc(this,down);
}});
})(jQuery);
(function($){
function _5d8(_5d9){
var opts=$.data(_5d9,"datetimespinner").options;
$(_5d9).addClass("datetimespinner-f").timespinner(opts);
};
$.fn.datetimespinner=function(_5da,_5db){
if(typeof _5da=="string"){
var _5dc=$.fn.datetimespinner.methods[_5da];
if(_5dc){
return _5dc(this,_5db);
}else{
return this.timespinner(_5da,_5db);
}
}
_5da=_5da||{};
return this.each(function(){
var _5dd=$.data(this,"datetimespinner");
if(_5dd){
$.extend(_5dd.options,_5da);
}else{
$.data(this,"datetimespinner",{options:$.extend({},$.fn.datetimespinner.defaults,$.fn.datetimespinner.parseOptions(this),_5da)});
}
_5d8(this);
});
};
$.fn.datetimespinner.methods={options:function(jq){
var opts=jq.timespinner("options");
return $.extend($.data(jq[0],"datetimespinner").options,{width:opts.width,value:opts.value,originalValue:opts.originalValue,disabled:opts.disabled,readonly:opts.readonly});
}};
$.fn.datetimespinner.parseOptions=function(_5de){
return $.extend({},$.fn.timespinner.parseOptions(_5de),$.parser.parseOptions(_5de,[]));
};
$.fn.datetimespinner.defaults=$.extend({},$.fn.timespinner.defaults,{formatter:function(date){
if(!date){
return "";
}
return $.fn.datebox.defaults.formatter.call(this,date)+" "+$.fn.timespinner.defaults.formatter.call(this,date);
},parser:function(s){
s=$.trim(s);
if(!s){
return null;
}
var dt=s.split(" ");
var _5df=$.fn.datebox.defaults.parser.call(this,dt[0]);
if(dt.length<2){
return _5df;
}
var _5e0=$.fn.timespinner.defaults.parser.call(this,dt[1]);
return new Date(_5df.getFullYear(),_5df.getMonth(),_5df.getDate(),_5e0.getHours(),_5e0.getMinutes(),_5e0.getSeconds());
},selections:[[0,2],[3,5],[6,10],[11,13],[14,16],[17,19]]});
})(jQuery);
(function($){
var _5e1=0;
function _5e2(a,o){
return $.easyui.indexOfArray(a,o);
};
function _5e3(a,o,id){
$.easyui.removeArrayItem(a,o,id);
};
function _5e4(a,o,r){
$.easyui.addArrayItem(a,o,r);
};
function _5e5(_5e6,aa){
return $.data(_5e6,"treegrid")?aa.slice(1):aa;
};
function _5e7(_5e8){
var _5e9=$.data(_5e8,"datagrid");
var opts=_5e9.options;
var _5ea=_5e9.panel;
var dc=_5e9.dc;
var ss=null;
if(opts.sharedStyleSheet){
ss=typeof opts.sharedStyleSheet=="boolean"?"head":opts.sharedStyleSheet;
}else{
ss=_5ea.closest("div.datagrid-view");
if(!ss.length){
ss=dc.view;
}
}
var cc=$(ss);
var _5eb=$.data(cc[0],"ss");
if(!_5eb){
_5eb=$.data(cc[0],"ss",{cache:{},dirty:[]});
}
return {add:function(_5ec){
var ss=["<style type=\"text/css\" easyui=\"true\">"];
for(var i=0;i<_5ec.length;i++){
_5eb.cache[_5ec[i][0]]={width:_5ec[i][1]};
}
var _5ed=0;
for(var s in _5eb.cache){
var item=_5eb.cache[s];
item.index=_5ed++;
ss.push(s+"{width:"+item.width+"}");
}
ss.push("</style>");
$(ss.join("\n")).appendTo(cc);
cc.children("style[easyui]:not(:last)").remove();
},getRule:function(_5ee){
var _5ef=cc.children("style[easyui]:last")[0];
var _5f0=_5ef.styleSheet?_5ef.styleSheet:(_5ef.sheet||document.styleSheets[document.styleSheets.length-1]);
var _5f1=_5f0.cssRules||_5f0.rules;
return _5f1[_5ee];
},set:function(_5f2,_5f3){
var item=_5eb.cache[_5f2];
if(item){
item.width=_5f3;
var rule=this.getRule(item.index);
if(rule){
rule.style["width"]=_5f3;
}
}
},remove:function(_5f4){
var tmp=[];
for(var s in _5eb.cache){
if(s.indexOf(_5f4)==-1){
tmp.push([s,_5eb.cache[s].width]);
}
}
_5eb.cache={};
this.add(tmp);
},dirty:function(_5f5){
if(_5f5){
_5eb.dirty.push(_5f5);
}
},clean:function(){
for(var i=0;i<_5eb.dirty.length;i++){
this.remove(_5eb.dirty[i]);
}
_5eb.dirty=[];
}};
};
function _5f6(_5f7,_5f8){
var _5f9=$.data(_5f7,"datagrid");
var opts=_5f9.options;
var _5fa=_5f9.panel;
if(_5f8){
$.extend(opts,_5f8);
}
if(opts.fit==true){
var p=_5fa.panel("panel").parent();
opts.width=p.width();
opts.height=p.height();
}
_5fa.panel("resize",opts);
};
function _5fb(_5fc){
var _5fd=$.data(_5fc,"datagrid");
var opts=_5fd.options;
var dc=_5fd.dc;
var wrap=_5fd.panel;
var _5fe=wrap.width();
var _5ff=wrap.height();
var view=dc.view;
var _600=dc.view1;
var _601=dc.view2;
var _602=_600.children("div.datagrid-header");
var _603=_601.children("div.datagrid-header");
var _604=_602.find("table");
var _605=_603.find("table");
view.width(_5fe);
var _606=_602.children("div.datagrid-header-inner").show();
_600.width(_606.find("table").width());
if(!opts.showHeader){
_606.hide();
}
_601.width(_5fe-_600._outerWidth());
_600.children()._outerWidth(_600.width());
_601.children()._outerWidth(_601.width());
var all=_602.add(_603).add(_604).add(_605);
all.css("height","");
var hh=Math.max(_604.height(),_605.height());
all._outerHeight(hh);
dc.body1.add(dc.body2).children("table.datagrid-btable-frozen").css({position:"absolute",top:dc.header2._outerHeight()});
var _607=dc.body2.children("table.datagrid-btable-frozen")._outerHeight();
var _608=_607+_603._outerHeight()+_601.children(".datagrid-footer")._outerHeight();
wrap.children(":not(.datagrid-view,.datagrid-mask,.datagrid-mask-msg)").each(function(){
_608+=$(this)._outerHeight();
});
var _609=wrap.outerHeight()-wrap.height();
var _60a=wrap._size("minHeight")||"";
var _60b=wrap._size("maxHeight")||"";
_600.add(_601).children("div.datagrid-body").css({marginTop:_607,height:(isNaN(parseInt(opts.height))?"":(_5ff-_608)),minHeight:(_60a?_60a-_609-_608:""),maxHeight:(_60b?_60b-_609-_608:"")});
view.height(_601.height());
};
function _60c(_60d,_60e,_60f){
var rows=$.data(_60d,"datagrid").data.rows;
var opts=$.data(_60d,"datagrid").options;
var dc=$.data(_60d,"datagrid").dc;
if(!dc.body1.is(":empty")&&(!opts.nowrap||opts.autoRowHeight||_60f)){
if(_60e!=undefined){
var tr1=opts.finder.getTr(_60d,_60e,"body",1);
var tr2=opts.finder.getTr(_60d,_60e,"body",2);
_610(tr1,tr2);
}else{
var tr1=opts.finder.getTr(_60d,0,"allbody",1);
var tr2=opts.finder.getTr(_60d,0,"allbody",2);
_610(tr1,tr2);
if(opts.showFooter){
var tr1=opts.finder.getTr(_60d,0,"allfooter",1);
var tr2=opts.finder.getTr(_60d,0,"allfooter",2);
_610(tr1,tr2);
}
}
}
_5fb(_60d);
if(opts.height=="auto"){
var _611=dc.body1.parent();
var _612=dc.body2;
var _613=_614(_612);
var _615=_613.height;
if(_613.width>_612.width()){
_615+=18;
}
_615-=parseInt(_612.css("marginTop"))||0;
_611.height(_615);
_612.height(_615);
dc.view.height(dc.view2.height());
}
dc.body2.triggerHandler("scroll");
function _610(trs1,trs2){
for(var i=0;i<trs2.length;i++){
var tr1=$(trs1[i]);
var tr2=$(trs2[i]);
tr1.css("height","");
tr2.css("height","");
var _616=Math.max(tr1.height(),tr2.height());
tr1.css("height",_616);
tr2.css("height",_616);
}
};
function _614(cc){
var _617=0;
var _618=0;
$(cc).children().each(function(){
var c=$(this);
if(c.is(":visible")){
_618+=c._outerHeight();
if(_617<c._outerWidth()){
_617=c._outerWidth();
}
}
});
return {width:_617,height:_618};
};
};
function _619(_61a,_61b){
var _61c=$.data(_61a,"datagrid");
var opts=_61c.options;
var dc=_61c.dc;
if(!dc.body2.children("table.datagrid-btable-frozen").length){
dc.body1.add(dc.body2).prepend("<table class=\"datagrid-btable datagrid-btable-frozen\" cellspacing=\"0\" cellpadding=\"0\"></table>");
}
_61d(true);
_61d(false);
_5fb(_61a);
function _61d(_61e){
var _61f=_61e?1:2;
var tr=opts.finder.getTr(_61a,_61b,"body",_61f);
(_61e?dc.body1:dc.body2).children("table.datagrid-btable-frozen").append(tr);
};
};
function _620(_621,_622){
function _623(){
var _624=[];
var _625=[];
$(_621).children("thead").each(function(){
var opt=$.parser.parseOptions(this,[{frozen:"boolean"}]);
$(this).find("tr").each(function(){
var cols=[];
$(this).find("th").each(function(){
var th=$(this);
var col=$.extend({},$.parser.parseOptions(this,["id","field","align","halign","order","width",{sortable:"boolean",checkbox:"boolean",resizable:"boolean",fixed:"boolean"},{rowspan:"number",colspan:"number"}]),{title:(th.html()||undefined),hidden:(th.attr("hidden")?true:undefined),formatter:(th.attr("formatter")?eval(th.attr("formatter")):undefined),styler:(th.attr("styler")?eval(th.attr("styler")):undefined),sorter:(th.attr("sorter")?eval(th.attr("sorter")):undefined)});
if(col.width&&String(col.width).indexOf("%")==-1){
col.width=parseInt(col.width);
}
if(th.attr("editor")){
var s=$.trim(th.attr("editor"));
if(s.substr(0,1)=="{"){
col.editor=eval("("+s+")");
}else{
col.editor=s;
}
}
cols.push(col);
});
opt.frozen?_624.push(cols):_625.push(cols);
});
});
return [_624,_625];
};
var _626=$("<div class=\"datagrid-wrap\">"+"<div class=\"datagrid-view\">"+"<div class=\"datagrid-view1\">"+"<div class=\"datagrid-header\">"+"<div class=\"datagrid-header-inner\"></div>"+"</div>"+"<div class=\"datagrid-body\">"+"<div class=\"datagrid-body-inner\"></div>"+"</div>"+"<div class=\"datagrid-footer\">"+"<div class=\"datagrid-footer-inner\"></div>"+"</div>"+"</div>"+"<div class=\"datagrid-view2\">"+"<div class=\"datagrid-header\">"+"<div class=\"datagrid-header-inner\"></div>"+"</div>"+"<div class=\"datagrid-body\"></div>"+"<div class=\"datagrid-footer\">"+"<div class=\"datagrid-footer-inner\"></div>"+"</div>"+"</div>"+"</div>"+"</div>").insertAfter(_621);
_626.panel({doSize:false,cls:"datagrid"});
$(_621).addClass("datagrid-f").hide().appendTo(_626.children("div.datagrid-view"));
var cc=_623();
var view=_626.children("div.datagrid-view");
var _627=view.children("div.datagrid-view1");
var _628=view.children("div.datagrid-view2");
return {panel:_626,frozenColumns:cc[0],columns:cc[1],dc:{view:view,view1:_627,view2:_628,header1:_627.children("div.datagrid-header").children("div.datagrid-header-inner"),header2:_628.children("div.datagrid-header").children("div.datagrid-header-inner"),body1:_627.children("div.datagrid-body").children("div.datagrid-body-inner"),body2:_628.children("div.datagrid-body"),footer1:_627.children("div.datagrid-footer").children("div.datagrid-footer-inner"),footer2:_628.children("div.datagrid-footer").children("div.datagrid-footer-inner")}};
};
function _629(_62a){
var _62b=$.data(_62a,"datagrid");
var opts=_62b.options;
var dc=_62b.dc;
var _62c=_62b.panel;
_62b.ss=$(_62a).datagrid("createStyleSheet");
_62c.panel($.extend({},opts,{id:null,doSize:false,onResize:function(_62d,_62e){
if($.data(_62a,"datagrid")){
_5fb(_62a);
$(_62a).datagrid("fitColumns");
opts.onResize.call(_62c,_62d,_62e);
}
},onExpand:function(){
if($.data(_62a,"datagrid")){
$(_62a).datagrid("fixRowHeight").datagrid("fitColumns");
opts.onExpand.call(_62c);
}
}}));
_62b.rowIdPrefix="datagrid-row-r"+(++_5e1);
_62b.cellClassPrefix="datagrid-cell-c"+_5e1;
_62f(dc.header1,opts.frozenColumns,true);
_62f(dc.header2,opts.columns,false);
_630();
dc.header1.add(dc.header2).css("display",opts.showHeader?"block":"none");
dc.footer1.add(dc.footer2).css("display",opts.showFooter?"block":"none");
if(opts.toolbar){
if($.isArray(opts.toolbar)){
$("div.datagrid-toolbar",_62c).remove();
var tb=$("<div class=\"datagrid-toolbar\"><table cellspacing=\"0\" cellpadding=\"0\"><tr></tr></table></div>").prependTo(_62c);
var tr=tb.find("tr");
for(var i=0;i<opts.toolbar.length;i++){
var btn=opts.toolbar[i];
if(btn=="-"){
$("<td><div class=\"datagrid-btn-separator\"></div></td>").appendTo(tr);
}else{
var td=$("<td></td>").appendTo(tr);
var tool=$("<a href=\"javascript:void(0)\"></a>").appendTo(td);
tool[0].onclick=eval(btn.handler||function(){
});
tool.linkbutton($.extend({},btn,{plain:true}));
}
}
}else{
$(opts.toolbar).addClass("datagrid-toolbar").prependTo(_62c);
$(opts.toolbar).show();
}
}else{
$("div.datagrid-toolbar",_62c).remove();
}
$("div.datagrid-pager",_62c).remove();
if(opts.pagination){
var _631=$("<div class=\"datagrid-pager\"></div>");
if(opts.pagePosition=="bottom"){
_631.appendTo(_62c);
}else{
if(opts.pagePosition=="top"){
_631.addClass("datagrid-pager-top").prependTo(_62c);
}else{
var ptop=$("<div class=\"datagrid-pager datagrid-pager-top\"></div>").prependTo(_62c);
_631.appendTo(_62c);
_631=_631.add(ptop);
}
}
_631.pagination({total:(opts.pageNumber*opts.pageSize),pageNumber:opts.pageNumber,pageSize:opts.pageSize,pageList:opts.pageList,onSelectPage:function(_632,_633){
opts.pageNumber=_632||1;
opts.pageSize=_633;
_631.pagination("refresh",{pageNumber:_632,pageSize:_633});
_670(_62a);
}});
opts.pageSize=_631.pagination("options").pageSize;
}
function _62f(_634,_635,_636){
if(!_635){
return;
}
$(_634).show();
$(_634).empty();
var _637=[];
var _638=[];
var _639=[];
if(opts.sortName){
_637=opts.sortName.split(",");
_638=opts.sortOrder.split(",");
}
var t=$("<table class=\"datagrid-htable\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tbody></tbody></table>").appendTo(_634);
for(var i=0;i<_635.length;i++){
var tr=$("<tr class=\"datagrid-header-row\"></tr>").appendTo($("tbody",t));
var cols=_635[i];
for(var j=0;j<cols.length;j++){
var col=cols[j];
var attr="";
if(col.rowspan){
attr+="rowspan=\""+col.rowspan+"\" ";
}
if(col.colspan){
attr+="colspan=\""+col.colspan+"\" ";
if(!col.id){
col.id=["datagrid-td-group"+_5e1,i,j].join("-");
}
}
if(col.id){
attr+="id=\""+col.id+"\"";
}
var td=$("<td "+attr+"></td>").appendTo(tr);
if(col.checkbox){
td.attr("field",col.field);
$("<div class=\"datagrid-header-check\"></div>").html("<input type=\"checkbox\"/>").appendTo(td);
}else{
if(col.field){
td.attr("field",col.field);
td.append("<div class=\"datagrid-cell\"><span></span><span class=\"datagrid-sort-icon\"></span></div>");
td.find("span:first").html(col.title);
var cell=td.find("div.datagrid-cell");
var pos=_5e2(_637,col.field);
if(pos>=0){
cell.addClass("datagrid-sort-"+_638[pos]);
}
if(col.sortable){
cell.addClass("datagrid-sort");
}
if(col.resizable==false){
cell.attr("resizable","false");
}
if(col.width){
var _63a=$.parser.parseValue("width",col.width,dc.view,opts.scrollbarSize);
cell._outerWidth(_63a-1);
col.boxWidth=parseInt(cell[0].style.width);
col.deltaWidth=_63a-col.boxWidth;
}else{
col.auto=true;
}
cell.css("text-align",(col.halign||col.align||""));
col.cellClass=_62b.cellClassPrefix+"-"+col.field.replace(/[\.|\s]/g,"-");
cell.addClass(col.cellClass).css("width","");
}else{
$("<div class=\"datagrid-cell-group\"></div>").html(col.title).appendTo(td);
}
}
if(col.hidden){
td.hide();
_639.push(col.field);
}
}
}
if(_636&&opts.rownumbers){
var td=$("<td rowspan=\""+opts.frozenColumns.length+"\"><div class=\"datagrid-header-rownumber\"></div></td>");
if($("tr",t).length==0){
td.wrap("<tr class=\"datagrid-header-row\"></tr>").parent().appendTo($("tbody",t));
}else{
td.prependTo($("tr:first",t));
}
}
for(var i=0;i<_639.length;i++){
_672(_62a,_639[i],-1);
}
};
function _630(){
var _63b=[];
var _63c=_63d(_62a,true).concat(_63d(_62a));
for(var i=0;i<_63c.length;i++){
var col=_63e(_62a,_63c[i]);
if(col&&!col.checkbox){
_63b.push(["."+col.cellClass,col.boxWidth?col.boxWidth+"px":"auto"]);
}
}
_62b.ss.add(_63b);
_62b.ss.dirty(_62b.cellSelectorPrefix);
_62b.cellSelectorPrefix="."+_62b.cellClassPrefix;
};
};
function _63f(_640){
var _641=$.data(_640,"datagrid");
var _642=_641.panel;
var opts=_641.options;
var dc=_641.dc;
var _643=dc.header1.add(dc.header2);
_643.find("input[type=checkbox]").unbind(".datagrid").bind("click.datagrid",function(e){
if(opts.singleSelect&&opts.selectOnCheck){
return false;
}
if($(this).is(":checked")){
_6e7(_640);
}else{
_6ed(_640);
}
e.stopPropagation();
});
var _644=_643.find("div.datagrid-cell");
_644.closest("td").unbind(".datagrid").bind("mouseenter.datagrid",function(){
if(_641.resizing){
return;
}
$(this).addClass("datagrid-header-over");
}).bind("mouseleave.datagrid",function(){
$(this).removeClass("datagrid-header-over");
}).bind("contextmenu.datagrid",function(e){
var _645=$(this).attr("field");
opts.onHeaderContextMenu.call(_640,e,_645);
});
_644.unbind(".datagrid").bind("click.datagrid",function(e){
var p1=$(this).offset().left+5;
var p2=$(this).offset().left+$(this)._outerWidth()-5;
if(e.pageX<p2&&e.pageX>p1){
_665(_640,$(this).parent().attr("field"));
}
}).bind("dblclick.datagrid",function(e){
var p1=$(this).offset().left+5;
var p2=$(this).offset().left+$(this)._outerWidth()-5;
var cond=opts.resizeHandle=="right"?(e.pageX>p2):(opts.resizeHandle=="left"?(e.pageX<p1):(e.pageX<p1||e.pageX>p2));
if(cond){
var _646=$(this).parent().attr("field");
var col=_63e(_640,_646);
if(col.resizable==false){
return;
}
$(_640).datagrid("autoSizeColumn",_646);
col.auto=false;
}
});
var _647=opts.resizeHandle=="right"?"e":(opts.resizeHandle=="left"?"w":"e,w");
_644.each(function(){
$(this).resizable({handles:_647,disabled:($(this).attr("resizable")?$(this).attr("resizable")=="false":false),minWidth:25,onStartResize:function(e){
_641.resizing=true;
_643.css("cursor",$("body").css("cursor"));
if(!_641.proxy){
_641.proxy=$("<div class=\"datagrid-resize-proxy\"></div>").appendTo(dc.view);
}
_641.proxy.css({left:e.pageX-$(_642).offset().left-1,display:"none"});
setTimeout(function(){
if(_641.proxy){
_641.proxy.show();
}
},500);
},onResize:function(e){
_641.proxy.css({left:e.pageX-$(_642).offset().left-1,display:"block"});
return false;
},onStopResize:function(e){
_643.css("cursor","");
$(this).css("height","");
var _648=$(this).parent().attr("field");
var col=_63e(_640,_648);
col.width=$(this)._outerWidth();
col.boxWidth=col.width-col.deltaWidth;
col.auto=undefined;
$(this).css("width","");
$(_640).datagrid("fixColumnSize",_648);
_641.proxy.remove();
_641.proxy=null;
if($(this).parents("div:first.datagrid-header").parent().hasClass("datagrid-view1")){
_5fb(_640);
}
$(_640).datagrid("fitColumns");
opts.onResizeColumn.call(_640,_648,col.width);
setTimeout(function(){
_641.resizing=false;
},0);
}});
});
var bb=dc.body1.add(dc.body2);
bb.unbind();
for(var _649 in opts.rowEvents){
bb.bind(_649,opts.rowEvents[_649]);
}
dc.body1.bind("mousewheel DOMMouseScroll",function(e){
e.preventDefault();
var e1=e.originalEvent||window.event;
var _64a=e1.wheelDelta||e1.detail*(-1);
if("deltaY" in e1){
_64a=e1.deltaY*-1;
}
var dg=$(e.target).closest("div.datagrid-view").children(".datagrid-f");
var dc=dg.data("datagrid").dc;
dc.body2.scrollTop(dc.body2.scrollTop()-_64a);
});
dc.body2.bind("scroll",function(){
var b1=dc.view1.children("div.datagrid-body");
b1.scrollTop($(this).scrollTop());
var c1=dc.body1.children(":first");
var c2=dc.body2.children(":first");
if(c1.length&&c2.length){
var top1=c1.offset().top;
var top2=c2.offset().top;
if(top1!=top2){
b1.scrollTop(b1.scrollTop()+top1-top2);
}
}
dc.view2.children("div.datagrid-header,div.datagrid-footer")._scrollLeft($(this)._scrollLeft());
dc.body2.children("table.datagrid-btable-frozen").css("left",-$(this)._scrollLeft());
});
};
function _64b(_64c){
return function(e){
var tr=_64d(e.target);
if(!tr){
return;
}
var _64e=_64f(tr);
if($.data(_64e,"datagrid").resizing){
return;
}
var _650=_651(tr);
if(_64c){
_652(_64e,_650);
}else{
var opts=$.data(_64e,"datagrid").options;
opts.finder.getTr(_64e,_650).removeClass("datagrid-row-over");
}
};
};
function _653(e){
var tr=_64d(e.target);
if(!tr){
return;
}
var _654=_64f(tr);
var opts=$.data(_654,"datagrid").options;
var _655=_651(tr);
var tt=$(e.target);
if(tt.parent().hasClass("datagrid-cell-check")){
if(opts.singleSelect&&opts.selectOnCheck){
tt._propAttr("checked",!tt.is(":checked"));
_656(_654,_655);
}else{
if(tt.is(":checked")){
tt._propAttr("checked",false);
_656(_654,_655);
}else{
tt._propAttr("checked",true);
_657(_654,_655);
}
}
}else{
var row=opts.finder.getRow(_654,_655);
var td=tt.closest("td[field]",tr);
if(td.length){
var _658=td.attr("field");
opts.onClickCell.call(_654,_655,_658,row[_658]);
}
if(opts.singleSelect==true){
_659(_654,_655);
}else{
if(opts.ctrlSelect){
if(e.ctrlKey){
if(tr.hasClass("datagrid-row-selected")){
_65a(_654,_655);
}else{
_659(_654,_655);
}
}else{
if(e.shiftKey){
$(_654).datagrid("clearSelections");
var _65b=Math.min(opts.lastSelectedIndex||0,_655);
var _65c=Math.max(opts.lastSelectedIndex||0,_655);
for(var i=_65b;i<=_65c;i++){
_659(_654,i);
}
}else{
$(_654).datagrid("clearSelections");
_659(_654,_655);
opts.lastSelectedIndex=_655;
}
}
}else{
if(tr.hasClass("datagrid-row-selected")){
_65a(_654,_655);
}else{
_659(_654,_655);
}
}
}
opts.onClickRow.apply(_654,_5e5(_654,[_655,row]));
}
};
function _65d(e){
var tr=_64d(e.target);
if(!tr){
return;
}
var _65e=_64f(tr);
var opts=$.data(_65e,"datagrid").options;
var _65f=_651(tr);
var row=opts.finder.getRow(_65e,_65f);
var td=$(e.target).closest("td[field]",tr);
if(td.length){
var _660=td.attr("field");
opts.onDblClickCell.call(_65e,_65f,_660,row[_660]);
}
opts.onDblClickRow.apply(_65e,_5e5(_65e,[_65f,row]));
};
function _661(e){
var tr=_64d(e.target);
if(tr){
var _662=_64f(tr);
var opts=$.data(_662,"datagrid").options;
var _663=_651(tr);
var row=opts.finder.getRow(_662,_663);
opts.onRowContextMenu.call(_662,e,_663,row);
}else{
var body=_64d(e.target,".datagrid-body");
if(body){
var _662=_64f(body);
var opts=$.data(_662,"datagrid").options;
opts.onRowContextMenu.call(_662,e,-1,null);
}
}
};
function _64f(t){
return $(t).closest("div.datagrid-view").children(".datagrid-f")[0];
};
function _64d(t,_664){
var tr=$(t).closest(_664||"tr.datagrid-row");
if(tr.length&&tr.parent().length){
return tr;
}else{
return undefined;
}
};
function _651(tr){
if(tr.attr("datagrid-row-index")){
return parseInt(tr.attr("datagrid-row-index"));
}else{
return tr.attr("node-id");
}
};
function _665(_666,_667){
var _668=$.data(_666,"datagrid");
var opts=_668.options;
_667=_667||{};
var _669={sortName:opts.sortName,sortOrder:opts.sortOrder};
if(typeof _667=="object"){
$.extend(_669,_667);
}
var _66a=[];
var _66b=[];
if(_669.sortName){
_66a=_669.sortName.split(",");
_66b=_669.sortOrder.split(",");
}
if(typeof _667=="string"){
var _66c=_667;
var col=_63e(_666,_66c);
if(!col.sortable||_668.resizing){
return;
}
var _66d=col.order||"asc";
var pos=_5e2(_66a,_66c);
if(pos>=0){
var _66e=_66b[pos]=="asc"?"desc":"asc";
if(opts.multiSort&&_66e==_66d){
_66a.splice(pos,1);
_66b.splice(pos,1);
}else{
_66b[pos]=_66e;
}
}else{
if(opts.multiSort){
_66a.push(_66c);
_66b.push(_66d);
}else{
_66a=[_66c];
_66b=[_66d];
}
}
_669.sortName=_66a.join(",");
_669.sortOrder=_66b.join(",");
}
if(opts.onBeforeSortColumn.call(_666,_669.sortName,_669.sortOrder)==false){
return;
}
$.extend(opts,_669);
var dc=_668.dc;
var _66f=dc.header1.add(dc.header2);
_66f.find("div.datagrid-cell").removeClass("datagrid-sort-asc datagrid-sort-desc");
for(var i=0;i<_66a.length;i++){
var col=_63e(_666,_66a[i]);
_66f.find("div."+col.cellClass).addClass("datagrid-sort-"+_66b[i]);
}
if(opts.remoteSort){
_670(_666);
}else{
_671(_666,$(_666).datagrid("getData"));
}
opts.onSortColumn.call(_666,opts.sortName,opts.sortOrder);
};
function _672(_673,_674,_675){
_676(true);
_676(false);
function _676(_677){
var aa=_678(_673,_677);
if(aa.length){
var _679=aa[aa.length-1];
var _67a=_5e2(_679,_674);
if(_67a>=0){
for(var _67b=0;_67b<aa.length-1;_67b++){
var td=$("#"+aa[_67b][_67a]);
var _67c=parseInt(td.attr("colspan")||1)+(_675||0);
td.attr("colspan",_67c);
if(_67c){
td.show();
}else{
td.hide();
}
}
}
}
};
};
function _67d(_67e){
var _67f=$.data(_67e,"datagrid");
var opts=_67f.options;
var dc=_67f.dc;
var _680=dc.view2.children("div.datagrid-header");
dc.body2.css("overflow-x","");
_681();
_682();
_683();
_681(true);
if(_680.width()>=_680.find("table").width()){
dc.body2.css("overflow-x","hidden");
}
function _683(){
if(!opts.fitColumns){
return;
}
if(!_67f.leftWidth){
_67f.leftWidth=0;
}
var _684=0;
var cc=[];
var _685=_63d(_67e,false);
for(var i=0;i<_685.length;i++){
var col=_63e(_67e,_685[i]);
if(_686(col)){
_684+=col.width;
cc.push({field:col.field,col:col,addingWidth:0});
}
}
if(!_684){
return;
}
cc[cc.length-1].addingWidth-=_67f.leftWidth;
var _687=_680.children("div.datagrid-header-inner").show();
var _688=_680.width()-_680.find("table").width()-opts.scrollbarSize+_67f.leftWidth;
var rate=_688/_684;
if(!opts.showHeader){
_687.hide();
}
for(var i=0;i<cc.length;i++){
var c=cc[i];
var _689=parseInt(c.col.width*rate);
c.addingWidth+=_689;
_688-=_689;
}
cc[cc.length-1].addingWidth+=_688;
for(var i=0;i<cc.length;i++){
var c=cc[i];
if(c.col.boxWidth+c.addingWidth>0){
c.col.boxWidth+=c.addingWidth;
c.col.width+=c.addingWidth;
}
}
_67f.leftWidth=_688;
$(_67e).datagrid("fixColumnSize");
};
function _682(){
var _68a=false;
var _68b=_63d(_67e,true).concat(_63d(_67e,false));
$.map(_68b,function(_68c){
var col=_63e(_67e,_68c);
if(String(col.width||"").indexOf("%")>=0){
var _68d=$.parser.parseValue("width",col.width,dc.view,opts.scrollbarSize)-col.deltaWidth;
if(_68d>0){
col.boxWidth=_68d;
_68a=true;
}
}
});
if(_68a){
$(_67e).datagrid("fixColumnSize");
}
};
function _681(fit){
var _68e=dc.header1.add(dc.header2).find(".datagrid-cell-group");
if(_68e.length){
_68e.each(function(){
$(this)._outerWidth(fit?$(this).parent().width():10);
});
if(fit){
_5fb(_67e);
}
}
};
function _686(col){
if(String(col.width||"").indexOf("%")>=0){
return false;
}
if(!col.hidden&&!col.checkbox&&!col.auto&&!col.fixed){
return true;
}
};
};
function _68f(_690,_691){
var _692=$.data(_690,"datagrid");
var opts=_692.options;
var dc=_692.dc;
var tmp=$("<div class=\"datagrid-cell\" style=\"position:absolute;left:-9999px\"></div>").appendTo("body");
if(_691){
_5f6(_691);
$(_690).datagrid("fitColumns");
}else{
var _693=false;
var _694=_63d(_690,true).concat(_63d(_690,false));
for(var i=0;i<_694.length;i++){
var _691=_694[i];
var col=_63e(_690,_691);
if(col.auto){
_5f6(_691);
_693=true;
}
}
if(_693){
$(_690).datagrid("fitColumns");
}
}
tmp.remove();
function _5f6(_695){
var _696=dc.view.find("div.datagrid-header td[field=\""+_695+"\"] div.datagrid-cell");
_696.css("width","");
var col=$(_690).datagrid("getColumnOption",_695);
col.width=undefined;
col.boxWidth=undefined;
col.auto=true;
$(_690).datagrid("fixColumnSize",_695);
var _697=Math.max(_698("header"),_698("allbody"),_698("allfooter"))+1;
_696._outerWidth(_697-1);
col.width=_697;
col.boxWidth=parseInt(_696[0].style.width);
col.deltaWidth=_697-col.boxWidth;
_696.css("width","");
$(_690).datagrid("fixColumnSize",_695);
opts.onResizeColumn.call(_690,_695,col.width);
function _698(type){
var _699=0;
if(type=="header"){
_699=_69a(_696);
}else{
opts.finder.getTr(_690,0,type).find("td[field=\""+_695+"\"] div.datagrid-cell").each(function(){
var w=_69a($(this));
if(_699<w){
_699=w;
}
});
}
return _699;
function _69a(cell){
return cell.is(":visible")?cell._outerWidth():tmp.html(cell.html())._outerWidth();
};
};
};
};
function _69b(_69c,_69d){
var _69e=$.data(_69c,"datagrid");
var opts=_69e.options;
var dc=_69e.dc;
var _69f=dc.view.find("table.datagrid-btable,table.datagrid-ftable");
_69f.css("table-layout","fixed");
if(_69d){
fix(_69d);
}else{
var ff=_63d(_69c,true).concat(_63d(_69c,false));
for(var i=0;i<ff.length;i++){
fix(ff[i]);
}
}
_69f.css("table-layout","");
_6a0(_69c);
_60c(_69c);
_6a1(_69c);
function fix(_6a2){
var col=_63e(_69c,_6a2);
if(col.cellClass){
_69e.ss.set("."+col.cellClass,col.boxWidth?col.boxWidth+"px":"auto");
}
};
};
function _6a0(_6a3){
var dc=$.data(_6a3,"datagrid").dc;
dc.view.find("td.datagrid-td-merged").each(function(){
var td=$(this);
var _6a4=td.attr("colspan")||1;
var col=_63e(_6a3,td.attr("field"));
var _6a5=col.boxWidth+col.deltaWidth-1;
for(var i=1;i<_6a4;i++){
td=td.next();
col=_63e(_6a3,td.attr("field"));
_6a5+=col.boxWidth+col.deltaWidth;
}
$(this).children("div.datagrid-cell")._outerWidth(_6a5);
});
};
function _6a1(_6a6){
var dc=$.data(_6a6,"datagrid").dc;
dc.view.find("div.datagrid-editable").each(function(){
var cell=$(this);
var _6a7=cell.parent().attr("field");
var col=$(_6a6).datagrid("getColumnOption",_6a7);
cell._outerWidth(col.boxWidth+col.deltaWidth-1);
var ed=$.data(this,"datagrid.editor");
if(ed.actions.resize){
ed.actions.resize(ed.target,cell.width());
}
});
};
function _63e(_6a8,_6a9){
function find(_6aa){
if(_6aa){
for(var i=0;i<_6aa.length;i++){
var cc=_6aa[i];
for(var j=0;j<cc.length;j++){
var c=cc[j];
if(c.field==_6a9){
return c;
}
}
}
}
return null;
};
var opts=$.data(_6a8,"datagrid").options;
var col=find(opts.columns);
if(!col){
col=find(opts.frozenColumns);
}
return col;
};
function _678(_6ab,_6ac){
var opts=$.data(_6ab,"datagrid").options;
var _6ad=_6ac?opts.frozenColumns:opts.columns;
var aa=[];
var _6ae=_6af();
for(var i=0;i<_6ad.length;i++){
aa[i]=new Array(_6ae);
}
for(var _6b0=0;_6b0<_6ad.length;_6b0++){
$.map(_6ad[_6b0],function(col){
var _6b1=_6b2(aa[_6b0]);
if(_6b1>=0){
var _6b3=col.field||col.id||"";
for(var c=0;c<(col.colspan||1);c++){
for(var r=0;r<(col.rowspan||1);r++){
aa[_6b0+r][_6b1]=_6b3;
}
_6b1++;
}
}
});
}
return aa;
function _6af(){
var _6b4=0;
$.map(_6ad[0]||[],function(col){
_6b4+=col.colspan||1;
});
return _6b4;
};
function _6b2(a){
for(var i=0;i<a.length;i++){
if(a[i]==undefined){
return i;
}
}
return -1;
};
};
function _63d(_6b5,_6b6){
var aa=_678(_6b5,_6b6);
return aa.length?aa[aa.length-1]:aa;
};
function _671(_6b7,data){
var _6b8=$.data(_6b7,"datagrid");
var opts=_6b8.options;
var dc=_6b8.dc;
data=opts.loadFilter.call(_6b7,data);
if($.isArray(data)){
data={total:data.length,rows:data};
}
data.total=parseInt(data.total);
_6b8.data=data;
if(data.footer){
_6b8.footer=data.footer;
}
if(!opts.remoteSort&&opts.sortName){
var _6b9=opts.sortName.split(",");
var _6ba=opts.sortOrder.split(",");
data.rows.sort(function(r1,r2){
var r=0;
for(var i=0;i<_6b9.length;i++){
var sn=_6b9[i];
var so=_6ba[i];
var col=_63e(_6b7,sn);
var _6bb=col.sorter||function(a,b){
return a==b?0:(a>b?1:-1);
};
r=_6bb(r1[sn],r2[sn])*(so=="asc"?1:-1);
if(r!=0){
return r;
}
}
return r;
});
}
if(opts.view.onBeforeRender){
opts.view.onBeforeRender.call(opts.view,_6b7,data.rows);
}
opts.view.render.call(opts.view,_6b7,dc.body2,false);
opts.view.render.call(opts.view,_6b7,dc.body1,true);
if(opts.showFooter){
opts.view.renderFooter.call(opts.view,_6b7,dc.footer2,false);
opts.view.renderFooter.call(opts.view,_6b7,dc.footer1,true);
}
if(opts.view.onAfterRender){
opts.view.onAfterRender.call(opts.view,_6b7);
}
_6b8.ss.clean();
var _6bc=$(_6b7).datagrid("getPager");
if(_6bc.length){
var _6bd=_6bc.pagination("options");
if(_6bd.total!=data.total){
_6bc.pagination("refresh",{total:data.total});
if(opts.pageNumber!=_6bd.pageNumber&&_6bd.pageNumber>0){
opts.pageNumber=_6bd.pageNumber;
_670(_6b7);
}
}
}
_60c(_6b7);
dc.body2.triggerHandler("scroll");
$(_6b7).datagrid("setSelectionState");
$(_6b7).datagrid("autoSizeColumn");
opts.onLoadSuccess.call(_6b7,data);
};
function _6be(_6bf){
var _6c0=$.data(_6bf,"datagrid");
var opts=_6c0.options;
var dc=_6c0.dc;
dc.header1.add(dc.header2).find("input[type=checkbox]")._propAttr("checked",false);
if(opts.idField){
var _6c1=$.data(_6bf,"treegrid")?true:false;
var _6c2=opts.onSelect;
var _6c3=opts.onCheck;
opts.onSelect=opts.onCheck=function(){
};
var rows=opts.finder.getRows(_6bf);
for(var i=0;i<rows.length;i++){
var row=rows[i];
var _6c4=_6c1?row[opts.idField]:i;
if(_6c5(_6c0.selectedRows,row)){
_659(_6bf,_6c4,true);
}
if(_6c5(_6c0.checkedRows,row)){
_656(_6bf,_6c4,true);
}
}
opts.onSelect=_6c2;
opts.onCheck=_6c3;
}
function _6c5(a,r){
for(var i=0;i<a.length;i++){
if(a[i][opts.idField]==r[opts.idField]){
a[i]=r;
return true;
}
}
return false;
};
};
function _6c6(_6c7,row){
var _6c8=$.data(_6c7,"datagrid");
var opts=_6c8.options;
var rows=_6c8.data.rows;
if(typeof row=="object"){
return _5e2(rows,row);
}else{
for(var i=0;i<rows.length;i++){
if(rows[i][opts.idField]==row){
return i;
}
}
return -1;
}
};
function _6c9(_6ca){
var _6cb=$.data(_6ca,"datagrid");
var opts=_6cb.options;
var data=_6cb.data;
if(opts.idField){
return _6cb.selectedRows;
}else{
var rows=[];
opts.finder.getTr(_6ca,"","selected",2).each(function(){
rows.push(opts.finder.getRow(_6ca,$(this)));
});
return rows;
}
};
function _6cc(_6cd){
var _6ce=$.data(_6cd,"datagrid");
var opts=_6ce.options;
if(opts.idField){
return _6ce.checkedRows;
}else{
var rows=[];
opts.finder.getTr(_6cd,"","checked",2).each(function(){
rows.push(opts.finder.getRow(_6cd,$(this)));
});
return rows;
}
};
function _6cf(_6d0,_6d1){
var _6d2=$.data(_6d0,"datagrid");
var dc=_6d2.dc;
var opts=_6d2.options;
var tr=opts.finder.getTr(_6d0,_6d1);
if(tr.length){
if(tr.closest("table").hasClass("datagrid-btable-frozen")){
return;
}
var _6d3=dc.view2.children("div.datagrid-header")._outerHeight();
var _6d4=dc.body2;
var _6d5=_6d4.outerHeight(true)-_6d4.outerHeight();
var top=tr.position().top-_6d3-_6d5;
if(top<0){
_6d4.scrollTop(_6d4.scrollTop()+top);
}else{
if(top+tr._outerHeight()>_6d4.height()-18){
_6d4.scrollTop(_6d4.scrollTop()+top+tr._outerHeight()-_6d4.height()+18);
}
}
}
};
function _652(_6d6,_6d7){
var _6d8=$.data(_6d6,"datagrid");
var opts=_6d8.options;
opts.finder.getTr(_6d6,_6d8.highlightIndex).removeClass("datagrid-row-over");
opts.finder.getTr(_6d6,_6d7).addClass("datagrid-row-over");
_6d8.highlightIndex=_6d7;
};
function _659(_6d9,_6da,_6db){
var _6dc=$.data(_6d9,"datagrid");
var opts=_6dc.options;
var row=opts.finder.getRow(_6d9,_6da);
if(opts.onBeforeSelect.apply(_6d9,_5e5(_6d9,[_6da,row]))==false){
return;
}
if(opts.singleSelect){
_6dd(_6d9,true);
_6dc.selectedRows=[];
}
if(!_6db&&opts.checkOnSelect){
_656(_6d9,_6da,true);
}
if(opts.idField){
_5e4(_6dc.selectedRows,opts.idField,row);
}
opts.finder.getTr(_6d9,_6da).addClass("datagrid-row-selected");
opts.onSelect.apply(_6d9,_5e5(_6d9,[_6da,row]));
_6cf(_6d9,_6da);
};
function _65a(_6de,_6df,_6e0){
var _6e1=$.data(_6de,"datagrid");
var dc=_6e1.dc;
var opts=_6e1.options;
var row=opts.finder.getRow(_6de,_6df);
if(opts.onBeforeUnselect.apply(_6de,_5e5(_6de,[_6df,row]))==false){
return;
}
if(!_6e0&&opts.checkOnSelect){
_657(_6de,_6df,true);
}
opts.finder.getTr(_6de,_6df).removeClass("datagrid-row-selected");
if(opts.idField){
_5e3(_6e1.selectedRows,opts.idField,row[opts.idField]);
}
opts.onUnselect.apply(_6de,_5e5(_6de,[_6df,row]));
};
function _6e2(_6e3,_6e4){
var _6e5=$.data(_6e3,"datagrid");
var opts=_6e5.options;
var rows=opts.finder.getRows(_6e3);
var _6e6=$.data(_6e3,"datagrid").selectedRows;
if(!_6e4&&opts.checkOnSelect){
_6e7(_6e3,true);
}
opts.finder.getTr(_6e3,"","allbody").addClass("datagrid-row-selected");
if(opts.idField){
for(var _6e8=0;_6e8<rows.length;_6e8++){
_5e4(_6e6,opts.idField,rows[_6e8]);
}
}
opts.onSelectAll.call(_6e3,rows);
};
function _6dd(_6e9,_6ea){
var _6eb=$.data(_6e9,"datagrid");
var opts=_6eb.options;
var rows=opts.finder.getRows(_6e9);
var _6ec=$.data(_6e9,"datagrid").selectedRows;
if(!_6ea&&opts.checkOnSelect){
_6ed(_6e9,true);
}
opts.finder.getTr(_6e9,"","selected").removeClass("datagrid-row-selected");
if(opts.idField){
for(var _6ee=0;_6ee<rows.length;_6ee++){
_5e3(_6ec,opts.idField,rows[_6ee][opts.idField]);
}
}
opts.onUnselectAll.call(_6e9,rows);
};
function _656(_6ef,_6f0,_6f1){
var _6f2=$.data(_6ef,"datagrid");
var opts=_6f2.options;
var row=opts.finder.getRow(_6ef,_6f0);
if(opts.onBeforeCheck.apply(_6ef,_5e5(_6ef,[_6f0,row]))==false){
return;
}
if(opts.singleSelect&&opts.selectOnCheck){
_6ed(_6ef,true);
_6f2.checkedRows=[];
}
if(!_6f1&&opts.selectOnCheck){
_659(_6ef,_6f0,true);
}
var tr=opts.finder.getTr(_6ef,_6f0).addClass("datagrid-row-checked");
tr.find("div.datagrid-cell-check input[type=checkbox]")._propAttr("checked",true);
tr=opts.finder.getTr(_6ef,"","checked",2);
if(tr.length==opts.finder.getRows(_6ef).length){
var dc=_6f2.dc;
dc.header1.add(dc.header2).find("input[type=checkbox]")._propAttr("checked",true);
}
if(opts.idField){
_5e4(_6f2.checkedRows,opts.idField,row);
}
opts.onCheck.apply(_6ef,_5e5(_6ef,[_6f0,row]));
};
function _657(_6f3,_6f4,_6f5){
var _6f6=$.data(_6f3,"datagrid");
var opts=_6f6.options;
var row=opts.finder.getRow(_6f3,_6f4);
if(opts.onBeforeUncheck.apply(_6f3,_5e5(_6f3,[_6f4,row]))==false){
return;
}
if(!_6f5&&opts.selectOnCheck){
_65a(_6f3,_6f4,true);
}
var tr=opts.finder.getTr(_6f3,_6f4).removeClass("datagrid-row-checked");
tr.find("div.datagrid-cell-check input[type=checkbox]")._propAttr("checked",false);
var dc=_6f6.dc;
var _6f7=dc.header1.add(dc.header2);
_6f7.find("input[type=checkbox]")._propAttr("checked",false);
if(opts.idField){
_5e3(_6f6.checkedRows,opts.idField,row[opts.idField]);
}
opts.onUncheck.apply(_6f3,_5e5(_6f3,[_6f4,row]));
};
function _6e7(_6f8,_6f9){
var _6fa=$.data(_6f8,"datagrid");
var opts=_6fa.options;
var rows=opts.finder.getRows(_6f8);
if(!_6f9&&opts.selectOnCheck){
_6e2(_6f8,true);
}
var dc=_6fa.dc;
var hck=dc.header1.add(dc.header2).find("input[type=checkbox]");
var bck=opts.finder.getTr(_6f8,"","allbody").addClass("datagrid-row-checked").find("div.datagrid-cell-check input[type=checkbox]");
hck.add(bck)._propAttr("checked",true);
if(opts.idField){
for(var i=0;i<rows.length;i++){
_5e4(_6fa.checkedRows,opts.idField,rows[i]);
}
}
opts.onCheckAll.call(_6f8,rows);
};
function _6ed(_6fb,_6fc){
var _6fd=$.data(_6fb,"datagrid");
var opts=_6fd.options;
var rows=opts.finder.getRows(_6fb);
if(!_6fc&&opts.selectOnCheck){
_6dd(_6fb,true);
}
var dc=_6fd.dc;
var hck=dc.header1.add(dc.header2).find("input[type=checkbox]");
var bck=opts.finder.getTr(_6fb,"","checked").removeClass("datagrid-row-checked").find("div.datagrid-cell-check input[type=checkbox]");
hck.add(bck)._propAttr("checked",false);
if(opts.idField){
for(var i=0;i<rows.length;i++){
_5e3(_6fd.checkedRows,opts.idField,rows[i][opts.idField]);
}
}
opts.onUncheckAll.call(_6fb,rows);
};
function _6fe(_6ff,_700){
var opts=$.data(_6ff,"datagrid").options;
var tr=opts.finder.getTr(_6ff,_700);
var row=opts.finder.getRow(_6ff,_700);
if(tr.hasClass("datagrid-row-editing")){
return;
}
if(opts.onBeforeEdit.apply(_6ff,_5e5(_6ff,[_700,row]))==false){
return;
}
tr.addClass("datagrid-row-editing");
_701(_6ff,_700);
_6a1(_6ff);
tr.find("div.datagrid-editable").each(function(){
var _702=$(this).parent().attr("field");
var ed=$.data(this,"datagrid.editor");
ed.actions.setValue(ed.target,row[_702]);
});
_703(_6ff,_700);
opts.onBeginEdit.apply(_6ff,_5e5(_6ff,[_700,row]));
};
function _704(_705,_706,_707){
var _708=$.data(_705,"datagrid");
var opts=_708.options;
var _709=_708.updatedRows;
var _70a=_708.insertedRows;
var tr=opts.finder.getTr(_705,_706);
var row=opts.finder.getRow(_705,_706);
if(!tr.hasClass("datagrid-row-editing")){
return;
}
if(!_707){
if(!_703(_705,_706)){
return;
}
var _70b=false;
var _70c={};
tr.find("div.datagrid-editable").each(function(){
var _70d=$(this).parent().attr("field");
var ed=$.data(this,"datagrid.editor");
var t=$(ed.target);
var _70e=t.data("textbox")?t.textbox("textbox"):t;
_70e.triggerHandler("blur");
var _70f=ed.actions.getValue(ed.target);
if(row[_70d]!==_70f){
row[_70d]=_70f;
_70b=true;
_70c[_70d]=_70f;
}
});
if(_70b){
if(_5e2(_70a,row)==-1){
if(_5e2(_709,row)==-1){
_709.push(row);
}
}
}
opts.onEndEdit.apply(_705,_5e5(_705,[_706,row,_70c]));
}
tr.removeClass("datagrid-row-editing");
_710(_705,_706);
$(_705).datagrid("refreshRow",_706);
if(!_707){
opts.onAfterEdit.apply(_705,_5e5(_705,[_706,row,_70c]));
}else{
opts.onCancelEdit.apply(_705,_5e5(_705,[_706,row]));
}
};
function _711(_712,_713){
var opts=$.data(_712,"datagrid").options;
var tr=opts.finder.getTr(_712,_713);
var _714=[];
tr.children("td").each(function(){
var cell=$(this).find("div.datagrid-editable");
if(cell.length){
var ed=$.data(cell[0],"datagrid.editor");
_714.push(ed);
}
});
return _714;
};
function _715(_716,_717){
var _718=_711(_716,_717.index!=undefined?_717.index:_717.id);
for(var i=0;i<_718.length;i++){
if(_718[i].field==_717.field){
return _718[i];
}
}
return null;
};
function _701(_719,_71a){
var opts=$.data(_719,"datagrid").options;
var tr=opts.finder.getTr(_719,_71a);
tr.children("td").each(function(){
var cell=$(this).find("div.datagrid-cell");
var _71b=$(this).attr("field");
var col=_63e(_719,_71b);
if(col&&col.editor){
var _71c,_71d;
if(typeof col.editor=="string"){
_71c=col.editor;
}else{
_71c=col.editor.type;
_71d=col.editor.options;
}
var _71e=opts.editors[_71c];
if(_71e){
var _71f=cell.html();
var _720=cell._outerWidth();
cell.addClass("datagrid-editable");
cell._outerWidth(_720);
cell.html("<table border=\"0\" cellspacing=\"0\" cellpadding=\"1\"><tr><td></td></tr></table>");
cell.children("table").bind("click dblclick contextmenu",function(e){
e.stopPropagation();
});
$.data(cell[0],"datagrid.editor",{actions:_71e,target:_71e.init(cell.find("td"),_71d),field:_71b,type:_71c,oldHtml:_71f});
}
}
});
_60c(_719,_71a,true);
};
function _710(_721,_722){
var opts=$.data(_721,"datagrid").options;
var tr=opts.finder.getTr(_721,_722);
tr.children("td").each(function(){
var cell=$(this).find("div.datagrid-editable");
if(cell.length){
var ed=$.data(cell[0],"datagrid.editor");
if(ed.actions.destroy){
ed.actions.destroy(ed.target);
}
cell.html(ed.oldHtml);
$.removeData(cell[0],"datagrid.editor");
cell.removeClass("datagrid-editable");
cell.css("width","");
}
});
};
function _703(_723,_724){
var tr=$.data(_723,"datagrid").options.finder.getTr(_723,_724);
if(!tr.hasClass("datagrid-row-editing")){
return true;
}
var vbox=tr.find(".validatebox-text");
vbox.validatebox("validate");
vbox.trigger("mouseleave");
var _725=tr.find(".validatebox-invalid");
return _725.length==0;
};
function _726(_727,_728){
var _729=$.data(_727,"datagrid").insertedRows;
var _72a=$.data(_727,"datagrid").deletedRows;
var _72b=$.data(_727,"datagrid").updatedRows;
if(!_728){
var rows=[];
rows=rows.concat(_729);
rows=rows.concat(_72a);
rows=rows.concat(_72b);
return rows;
}else{
if(_728=="inserted"){
return _729;
}else{
if(_728=="deleted"){
return _72a;
}else{
if(_728=="updated"){
return _72b;
}
}
}
}
return [];
};
function _72c(_72d,_72e){
var _72f=$.data(_72d,"datagrid");
var opts=_72f.options;
var data=_72f.data;
var _730=_72f.insertedRows;
var _731=_72f.deletedRows;
$(_72d).datagrid("cancelEdit",_72e);
var row=opts.finder.getRow(_72d,_72e);
if(_5e2(_730,row)>=0){
_5e3(_730,row);
}else{
_731.push(row);
}
_5e3(_72f.selectedRows,opts.idField,row[opts.idField]);
_5e3(_72f.checkedRows,opts.idField,row[opts.idField]);
opts.view.deleteRow.call(opts.view,_72d,_72e);
if(opts.height=="auto"){
_60c(_72d);
}
$(_72d).datagrid("getPager").pagination("refresh",{total:data.total});
};
function _732(_733,_734){
var data=$.data(_733,"datagrid").data;
var view=$.data(_733,"datagrid").options.view;
var _735=$.data(_733,"datagrid").insertedRows;
view.insertRow.call(view,_733,_734.index,_734.row);
_735.push(_734.row);
$(_733).datagrid("getPager").pagination("refresh",{total:data.total});
};
function _736(_737,row){
var data=$.data(_737,"datagrid").data;
var view=$.data(_737,"datagrid").options.view;
var _738=$.data(_737,"datagrid").insertedRows;
view.insertRow.call(view,_737,null,row);
_738.push(row);
$(_737).datagrid("getPager").pagination("refresh",{total:data.total});
};
function _739(_73a,_73b){
var _73c=$.data(_73a,"datagrid");
var opts=_73c.options;
var row=opts.finder.getRow(_73a,_73b.index);
var _73d=false;
_73b.row=_73b.row||{};
for(var _73e in _73b.row){
if(row[_73e]!==_73b.row[_73e]){
_73d=true;
break;
}
}
if(_73d){
if(_5e2(_73c.insertedRows,row)==-1){
if(_5e2(_73c.updatedRows,row)==-1){
_73c.updatedRows.push(row);
}
}
opts.view.updateRow.call(opts.view,_73a,_73b.index,_73b.row);
}
};
function _73f(_740){
var _741=$.data(_740,"datagrid");
var data=_741.data;
var rows=data.rows;
var _742=[];
for(var i=0;i<rows.length;i++){
_742.push($.extend({},rows[i]));
}
_741.originalRows=_742;
_741.updatedRows=[];
_741.insertedRows=[];
_741.deletedRows=[];
};
function _743(_744){
var data=$.data(_744,"datagrid").data;
var ok=true;
for(var i=0,len=data.rows.length;i<len;i++){
if(_703(_744,i)){
$(_744).datagrid("endEdit",i);
}else{
ok=false;
}
}
if(ok){
_73f(_744);
}
};
function _745(_746){
var _747=$.data(_746,"datagrid");
var opts=_747.options;
var _748=_747.originalRows;
var _749=_747.insertedRows;
var _74a=_747.deletedRows;
var _74b=_747.selectedRows;
var _74c=_747.checkedRows;
var data=_747.data;
function _74d(a){
var ids=[];
for(var i=0;i<a.length;i++){
ids.push(a[i][opts.idField]);
}
return ids;
};
function _74e(ids,_74f){
for(var i=0;i<ids.length;i++){
var _750=_6c6(_746,ids[i]);
if(_750>=0){
(_74f=="s"?_659:_656)(_746,_750,true);
}
}
};
for(var i=0;i<data.rows.length;i++){
$(_746).datagrid("cancelEdit",i);
}
var _751=_74d(_74b);
var _752=_74d(_74c);
_74b.splice(0,_74b.length);
_74c.splice(0,_74c.length);
data.total+=_74a.length-_749.length;
data.rows=_748;
_671(_746,data);
_74e(_751,"s");
_74e(_752,"c");
_73f(_746);
};
function _670(_753,_754,cb){
var opts=$.data(_753,"datagrid").options;
if(_754){
opts.queryParams=_754;
}
var _755=$.extend({},opts.queryParams);
if(opts.pagination){
$.extend(_755,{page:opts.pageNumber||1,rows:opts.pageSize});
}
if(opts.sortName){
$.extend(_755,{sort:opts.sortName,order:opts.sortOrder});
}
if(opts.onBeforeLoad.call(_753,_755)==false){
return;
}
$(_753).datagrid("loading");
var _756=opts.loader.call(_753,_755,function(data){
$(_753).datagrid("loaded");
$(_753).datagrid("loadData",data);
if(cb){
cb();
}
},function(){
$(_753).datagrid("loaded");
opts.onLoadError.apply(_753,arguments);
});
if(_756==false){
$(_753).datagrid("loaded");
}
};
function _757(_758,_759){
var opts=$.data(_758,"datagrid").options;
_759.type=_759.type||"body";
_759.rowspan=_759.rowspan||1;
_759.colspan=_759.colspan||1;
if(_759.rowspan==1&&_759.colspan==1){
return;
}
var tr=opts.finder.getTr(_758,(_759.index!=undefined?_759.index:_759.id),_759.type);
if(!tr.length){
return;
}
var td=tr.find("td[field=\""+_759.field+"\"]");
td.attr("rowspan",_759.rowspan).attr("colspan",_759.colspan);
td.addClass("datagrid-td-merged");
_75a(td.next(),_759.colspan-1);
for(var i=1;i<_759.rowspan;i++){
tr=tr.next();
if(!tr.length){
break;
}
td=tr.find("td[field=\""+_759.field+"\"]");
_75a(td,_759.colspan);
}
_6a0(_758);
function _75a(td,_75b){
for(var i=0;i<_75b;i++){
td.hide();
td=td.next();
}
};
};
$.fn.datagrid=function(_75c,_75d){
if(typeof _75c=="string"){
return $.fn.datagrid.methods[_75c](this,_75d);
}
_75c=_75c||{};
return this.each(function(){
var _75e=$.data(this,"datagrid");
var opts;
if(_75e){
opts=$.extend(_75e.options,_75c);
_75e.options=opts;
}else{
opts=$.extend({},$.extend({},$.fn.datagrid.defaults,{queryParams:{}}),$.fn.datagrid.parseOptions(this),_75c);
$(this).css("width","").css("height","");
var _75f=_620(this,opts.rownumbers);
if(!opts.columns){
opts.columns=_75f.columns;
}
if(!opts.frozenColumns){
opts.frozenColumns=_75f.frozenColumns;
}
opts.columns=$.extend(true,[],opts.columns);
opts.frozenColumns=$.extend(true,[],opts.frozenColumns);
opts.view=$.extend({},opts.view);
$.data(this,"datagrid",{options:opts,panel:_75f.panel,dc:_75f.dc,ss:null,selectedRows:[],checkedRows:[],data:{total:0,rows:[]},originalRows:[],updatedRows:[],insertedRows:[],deletedRows:[]});
}
_629(this);
_63f(this);
_5f6(this);
if(opts.data){
$(this).datagrid("loadData",opts.data);
}else{
var data=$.fn.datagrid.parseData(this);
if(data.total>0){
$(this).datagrid("loadData",data);
}else{
opts.view.renderEmptyRow(this);
$(this).datagrid("autoSizeColumn");
}
}
_670(this);
});
};
function _760(_761){
var _762={};
$.map(_761,function(name){
_762[name]=_763(name);
});
return _762;
function _763(name){
function isA(_764){
return $.data($(_764)[0],name)!=undefined;
};
return {init:function(_765,_766){
var _767=$("<input type=\"text\" class=\"datagrid-editable-input\">").appendTo(_765);
if(_767[name]&&name!="text"){
return _767[name](_766);
}else{
return _767;
}
},destroy:function(_768){
if(isA(_768,name)){
$(_768)[name]("destroy");
}
},getValue:function(_769){
if(isA(_769,name)){
var opts=$(_769)[name]("options");
if(opts.multiple){
return $(_769)[name]("getValues").join(opts.separator);
}else{
return $(_769)[name]("getValue");
}
}else{
return $(_769).val();
}
},setValue:function(_76a,_76b){
if(isA(_76a,name)){
var opts=$(_76a)[name]("options");
if(opts.multiple){
if(_76b){
$(_76a)[name]("setValues",_76b.split(opts.separator));
}else{
$(_76a)[name]("clear");
}
}else{
$(_76a)[name]("setValue",_76b);
}
}else{
$(_76a).val(_76b);
}
},resize:function(_76c,_76d){
if(isA(_76c,name)){
$(_76c)[name]("resize",_76d);
}else{
$(_76c)._outerWidth(_76d)._outerHeight(22);
}
}};
};
};
var _76e=$.extend({},_760(["text","textbox","numberbox","numberspinner","combobox","combotree","combogrid","datebox","datetimebox","timespinner","datetimespinner"]),{textarea:{init:function(_76f,_770){
var _771=$("<textarea class=\"datagrid-editable-input\"></textarea>").appendTo(_76f);
return _771;
},getValue:function(_772){
return $(_772).val();
},setValue:function(_773,_774){
$(_773).val(_774);
},resize:function(_775,_776){
$(_775)._outerWidth(_776);
}},checkbox:{init:function(_777,_778){
var _779=$("<input type=\"checkbox\">").appendTo(_777);
_779.val(_778.on);
_779.attr("offval",_778.off);
return _779;
},getValue:function(_77a){
if($(_77a).is(":checked")){
return $(_77a).val();
}else{
return $(_77a).attr("offval");
}
},setValue:function(_77b,_77c){
var _77d=false;
if($(_77b).val()==_77c){
_77d=true;
}
$(_77b)._propAttr("checked",_77d);
}},validatebox:{init:function(_77e,_77f){
var _780=$("<input type=\"text\" class=\"datagrid-editable-input\">").appendTo(_77e);
_780.validatebox(_77f);
return _780;
},destroy:function(_781){
$(_781).validatebox("destroy");
},getValue:function(_782){
return $(_782).val();
},setValue:function(_783,_784){
$(_783).val(_784);
},resize:function(_785,_786){
$(_785)._outerWidth(_786)._outerHeight(22);
}}});
$.fn.datagrid.methods={options:function(jq){
var _787=$.data(jq[0],"datagrid").options;
var _788=$.data(jq[0],"datagrid").panel.panel("options");
var opts=$.extend(_787,{width:_788.width,height:_788.height,closed:_788.closed,collapsed:_788.collapsed,minimized:_788.minimized,maximized:_788.maximized});
return opts;
},setSelectionState:function(jq){
return jq.each(function(){
_6be(this);
});
},createStyleSheet:function(jq){
return _5e7(jq[0]);
},getPanel:function(jq){
return $.data(jq[0],"datagrid").panel;
},getPager:function(jq){
return $.data(jq[0],"datagrid").panel.children("div.datagrid-pager");
},getColumnFields:function(jq,_789){
return _63d(jq[0],_789);
},getColumnOption:function(jq,_78a){
return _63e(jq[0],_78a);
},resize:function(jq,_78b){
return jq.each(function(){
_5f6(this,_78b);
});
},load:function(jq,_78c){
return jq.each(function(){
var opts=$(this).datagrid("options");
if(typeof _78c=="string"){
opts.url=_78c;
_78c=null;
}
opts.pageNumber=1;
var _78d=$(this).datagrid("getPager");
_78d.pagination("refresh",{pageNumber:1});
_670(this,_78c);
});
},reload:function(jq,_78e){
return jq.each(function(){
var opts=$(this).datagrid("options");
if(typeof _78e=="string"){
opts.url=_78e;
_78e=null;
}
_670(this,_78e);
});
},reloadFooter:function(jq,_78f){
return jq.each(function(){
var opts=$.data(this,"datagrid").options;
var dc=$.data(this,"datagrid").dc;
if(_78f){
$.data(this,"datagrid").footer=_78f;
}
if(opts.showFooter){
opts.view.renderFooter.call(opts.view,this,dc.footer2,false);
opts.view.renderFooter.call(opts.view,this,dc.footer1,true);
if(opts.view.onAfterRender){
opts.view.onAfterRender.call(opts.view,this);
}
$(this).datagrid("fixRowHeight");
}
});
},loading:function(jq){
return jq.each(function(){
var opts=$.data(this,"datagrid").options;
$(this).datagrid("getPager").pagination("loading");
if(opts.loadMsg){
var _790=$(this).datagrid("getPanel");
if(!_790.children("div.datagrid-mask").length){
$("<div class=\"datagrid-mask\" style=\"display:block\"></div>").appendTo(_790);
var msg=$("<div class=\"datagrid-mask-msg\" style=\"display:block;left:50%\"></div>").html(opts.loadMsg).appendTo(_790);
msg._outerHeight(40);
msg.css({marginLeft:(-msg.outerWidth()/2),lineHeight:(msg.height()+"px")});
}
}
});
},loaded:function(jq){
return jq.each(function(){
$(this).datagrid("getPager").pagination("loaded");
var _791=$(this).datagrid("getPanel");
_791.children("div.datagrid-mask-msg").remove();
_791.children("div.datagrid-mask").remove();
});
},fitColumns:function(jq){
return jq.each(function(){
_67d(this);
});
},fixColumnSize:function(jq,_792){
return jq.each(function(){
_69b(this,_792);
});
},fixRowHeight:function(jq,_793){
return jq.each(function(){
_60c(this,_793);
});
},freezeRow:function(jq,_794){
return jq.each(function(){
_619(this,_794);
});
},autoSizeColumn:function(jq,_795){
return jq.each(function(){
_68f(this,_795);
});
},loadData:function(jq,data){
return jq.each(function(){
_671(this,data);
_73f(this);
});
},getData:function(jq){
return $.data(jq[0],"datagrid").data;
},getRows:function(jq){
return $.data(jq[0],"datagrid").data.rows;
},getFooterRows:function(jq){
return $.data(jq[0],"datagrid").footer;
},getRowIndex:function(jq,id){
return _6c6(jq[0],id);
},getChecked:function(jq){
return _6cc(jq[0]);
},getSelected:function(jq){
var rows=_6c9(jq[0]);
return rows.length>0?rows[0]:null;
},getSelections:function(jq){
return _6c9(jq[0]);
},clearSelections:function(jq){
return jq.each(function(){
var _796=$.data(this,"datagrid");
var _797=_796.selectedRows;
var _798=_796.checkedRows;
_797.splice(0,_797.length);
_6dd(this);
if(_796.options.checkOnSelect){
_798.splice(0,_798.length);
}
});
},clearChecked:function(jq){
return jq.each(function(){
var _799=$.data(this,"datagrid");
var _79a=_799.selectedRows;
var _79b=_799.checkedRows;
_79b.splice(0,_79b.length);
_6ed(this);
if(_799.options.selectOnCheck){
_79a.splice(0,_79a.length);
}
});
},scrollTo:function(jq,_79c){
return jq.each(function(){
_6cf(this,_79c);
});
},highlightRow:function(jq,_79d){
return jq.each(function(){
_652(this,_79d);
_6cf(this,_79d);
});
},selectAll:function(jq){
return jq.each(function(){
_6e2(this);
});
},unselectAll:function(jq){
return jq.each(function(){
_6dd(this);
});
},selectRow:function(jq,_79e){
return jq.each(function(){
_659(this,_79e);
});
},selectRecord:function(jq,id){
return jq.each(function(){
var opts=$.data(this,"datagrid").options;
if(opts.idField){
var _79f=_6c6(this,id);
if(_79f>=0){
$(this).datagrid("selectRow",_79f);
}
}
});
},unselectRow:function(jq,_7a0){
return jq.each(function(){
_65a(this,_7a0);
});
},checkRow:function(jq,_7a1){
return jq.each(function(){
_656(this,_7a1);
});
},uncheckRow:function(jq,_7a2){
return jq.each(function(){
_657(this,_7a2);
});
},checkAll:function(jq){
return jq.each(function(){
_6e7(this);
});
},uncheckAll:function(jq){
return jq.each(function(){
_6ed(this);
});
},beginEdit:function(jq,_7a3){
return jq.each(function(){
_6fe(this,_7a3);
});
},endEdit:function(jq,_7a4){
return jq.each(function(){
_704(this,_7a4,false);
});
},cancelEdit:function(jq,_7a5){
return jq.each(function(){
_704(this,_7a5,true);
});
},getEditors:function(jq,_7a6){
return _711(jq[0],_7a6);
},getEditor:function(jq,_7a7){
return _715(jq[0],_7a7);
},refreshRow:function(jq,_7a8){
return jq.each(function(){
var opts=$.data(this,"datagrid").options;
opts.view.refreshRow.call(opts.view,this,_7a8);
});
},validateRow:function(jq,_7a9){
return _703(jq[0],_7a9);
},updateRow:function(jq,_7aa){
return jq.each(function(){
_739(this,_7aa);
});
},appendRow:function(jq,row){
return jq.each(function(){
_736(this,row);
});
},insertRow:function(jq,_7ab){
return jq.each(function(){
_732(this,_7ab);
});
},deleteRow:function(jq,_7ac){
return jq.each(function(){
_72c(this,_7ac);
});
},getChanges:function(jq,_7ad){
return _726(jq[0],_7ad);
},acceptChanges:function(jq){
return jq.each(function(){
_743(this);
});
},rejectChanges:function(jq){
return jq.each(function(){
_745(this);
});
},mergeCells:function(jq,_7ae){
return jq.each(function(){
_757(this,_7ae);
});
},showColumn:function(jq,_7af){
return jq.each(function(){
var col=$(this).datagrid("getColumnOption",_7af);
if(col.hidden){
col.hidden=false;
$(this).datagrid("getPanel").find("td[field=\""+_7af+"\"]").show();
_672(this,_7af,1);
$(this).datagrid("fitColumns");
}
});
},hideColumn:function(jq,_7b0){
return jq.each(function(){
var col=$(this).datagrid("getColumnOption",_7b0);
if(!col.hidden){
col.hidden=true;
$(this).datagrid("getPanel").find("td[field=\""+_7b0+"\"]").hide();
_672(this,_7b0,-1);
$(this).datagrid("fitColumns");
}
});
},sort:function(jq,_7b1){
return jq.each(function(){
_665(this,_7b1);
});
},gotoPage:function(jq,_7b2){
return jq.each(function(){
var _7b3=this;
var page,cb;
if(typeof _7b2=="object"){
page=_7b2.page;
cb=_7b2.callback;
}else{
page=_7b2;
}
$(_7b3).datagrid("options").pageNumber=page;
$(_7b3).datagrid("getPager").pagination("refresh",{pageNumber:page});
_670(_7b3,null,function(){
if(cb){
cb.call(_7b3,page);
}
});
});
}};
$.fn.datagrid.parseOptions=function(_7b4){
var t=$(_7b4);
return $.extend({},$.fn.panel.parseOptions(_7b4),$.parser.parseOptions(_7b4,["url","toolbar","idField","sortName","sortOrder","pagePosition","resizeHandle",{sharedStyleSheet:"boolean",fitColumns:"boolean",autoRowHeight:"boolean",striped:"boolean",nowrap:"boolean"},{rownumbers:"boolean",singleSelect:"boolean",ctrlSelect:"boolean",checkOnSelect:"boolean",selectOnCheck:"boolean"},{pagination:"boolean",pageSize:"number",pageNumber:"number"},{multiSort:"boolean",remoteSort:"boolean",showHeader:"boolean",showFooter:"boolean"},{scrollbarSize:"number"}]),{pageList:(t.attr("pageList")?eval(t.attr("pageList")):undefined),loadMsg:(t.attr("loadMsg")!=undefined?t.attr("loadMsg"):undefined),rowStyler:(t.attr("rowStyler")?eval(t.attr("rowStyler")):undefined)});
};
$.fn.datagrid.parseData=function(_7b5){
var t=$(_7b5);
var data={total:0,rows:[]};
var _7b6=t.datagrid("getColumnFields",true).concat(t.datagrid("getColumnFields",false));
t.find("tbody tr").each(function(){
data.total++;
var row={};
$.extend(row,$.parser.parseOptions(this,["iconCls","state"]));
for(var i=0;i<_7b6.length;i++){
row[_7b6[i]]=$(this).find("td:eq("+i+")").html();
}
data.rows.push(row);
});
return data;
};
var _7b7={render:function(_7b8,_7b9,_7ba){
var rows=$(_7b8).datagrid("getRows");
$(_7b9).html(this.renderTable(_7b8,0,rows,_7ba));
},renderFooter:function(_7bb,_7bc,_7bd){
var opts=$.data(_7bb,"datagrid").options;
var rows=$.data(_7bb,"datagrid").footer||[];
var _7be=$(_7bb).datagrid("getColumnFields",_7bd);
var _7bf=["<table class=\"datagrid-ftable\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>"];
for(var i=0;i<rows.length;i++){
_7bf.push("<tr class=\"datagrid-row\" datagrid-row-index=\""+i+"\">");
_7bf.push(this.renderRow.call(this,_7bb,_7be,_7bd,i,rows[i]));
_7bf.push("</tr>");
}
_7bf.push("</tbody></table>");
$(_7bc).html(_7bf.join(""));
},renderTable:function(_7c0,_7c1,rows,_7c2){
var _7c3=$.data(_7c0,"datagrid");
var opts=_7c3.options;
if(_7c2){
if(!(opts.rownumbers||(opts.frozenColumns&&opts.frozenColumns.length))){
return "";
}
}
var _7c4=$(_7c0).datagrid("getColumnFields",_7c2);
var _7c5=["<table class=\"datagrid-btable\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>"];
for(var i=0;i<rows.length;i++){
var row=rows[i];
var css=opts.rowStyler?opts.rowStyler.call(_7c0,_7c1,row):"";
var cs=this.getStyleValue(css);
var cls="class=\"datagrid-row "+(_7c1%2&&opts.striped?"datagrid-row-alt ":" ")+cs.c+"\"";
var _7c6=cs.s?"style=\""+cs.s+"\"":"";
var _7c7=_7c3.rowIdPrefix+"-"+(_7c2?1:2)+"-"+_7c1;
_7c5.push("<tr id=\""+_7c7+"\" datagrid-row-index=\""+_7c1+"\" "+cls+" "+_7c6+">");
_7c5.push(this.renderRow.call(this,_7c0,_7c4,_7c2,_7c1,row));
_7c5.push("</tr>");
_7c1++;
}
_7c5.push("</tbody></table>");
return _7c5.join("");
},renderRow:function(_7c8,_7c9,_7ca,_7cb,_7cc){
var opts=$.data(_7c8,"datagrid").options;
var cc=[];
if(_7ca&&opts.rownumbers){
var _7cd=_7cb+1;
if(opts.pagination){
_7cd+=(opts.pageNumber-1)*opts.pageSize;
}
cc.push("<td class=\"datagrid-td-rownumber\"><div class=\"datagrid-cell-rownumber\">"+_7cd+"</div></td>");
}
for(var i=0;i<_7c9.length;i++){
var _7ce=_7c9[i];
var col=$(_7c8).datagrid("getColumnOption",_7ce);
if(col){
var _7cf=_7cc[_7ce];
var css=col.styler?(col.styler(_7cf,_7cc,_7cb)||""):"";
var cs=this.getStyleValue(css);
var cls=cs.c?"class=\""+cs.c+"\"":"";
var _7d0=col.hidden?"style=\"display:none;"+cs.s+"\"":(cs.s?"style=\""+cs.s+"\"":"");
cc.push("<td field=\""+_7ce+"\" "+cls+" "+_7d0+">");
var _7d0="";
if(!col.checkbox){
if(col.align){
_7d0+="text-align:"+col.align+";";
}
if(!opts.nowrap){
_7d0+="white-space:normal;height:auto;";
}else{
if(opts.autoRowHeight){
_7d0+="height:auto;";
}
}
}
cc.push("<div style=\""+_7d0+"\" ");
cc.push(col.checkbox?"class=\"datagrid-cell-check\"":"class=\"datagrid-cell "+col.cellClass+"\"");
cc.push(">");
if(col.checkbox){
cc.push("<input type=\"checkbox\" "+(_7cc.checked?"checked=\"checked\"":""));
cc.push(" name=\""+_7ce+"\" value=\""+(_7cf!=undefined?_7cf:"")+"\">");
}else{
if(col.formatter){
cc.push(col.formatter(_7cf,_7cc,_7cb));
}else{
cc.push(_7cf);
}
}
cc.push("</div>");
cc.push("</td>");
}
}
return cc.join("");
},getStyleValue:function(css){
var _7d1="";
var _7d2="";
if(typeof css=="string"){
_7d2=css;
}else{
if(css){
_7d1=css["class"]||"";
_7d2=css["style"]||"";
}
}
return {c:_7d1,s:_7d2};
},refreshRow:function(_7d3,_7d4){
this.updateRow.call(this,_7d3,_7d4,{});
},updateRow:function(_7d5,_7d6,row){
var opts=$.data(_7d5,"datagrid").options;
var _7d7=opts.finder.getRow(_7d5,_7d6);
var _7d8=_7d9.call(this,_7d6);
$.extend(_7d7,row);
var _7da=_7d9.call(this,_7d6);
var _7db=_7d8.c;
var _7dc=_7da.s;
var _7dd="datagrid-row "+(_7d6%2&&opts.striped?"datagrid-row-alt ":" ")+_7da.c;
function _7d9(_7de){
var css=opts.rowStyler?opts.rowStyler.call(_7d5,_7de,_7d7):"";
return this.getStyleValue(css);
};
function _7df(_7e0){
var _7e1=$(_7d5).datagrid("getColumnFields",_7e0);
var tr=opts.finder.getTr(_7d5,_7d6,"body",(_7e0?1:2));
var _7e2=tr.find("div.datagrid-cell-check input[type=checkbox]").is(":checked");
tr.html(this.renderRow.call(this,_7d5,_7e1,_7e0,_7d6,_7d7));
tr.attr("style",_7dc).removeClass(_7db).addClass(_7dd);
if(_7e2){
tr.find("div.datagrid-cell-check input[type=checkbox]")._propAttr("checked",true);
}
};
_7df.call(this,true);
_7df.call(this,false);
$(_7d5).datagrid("fixRowHeight",_7d6);
},insertRow:function(_7e3,_7e4,row){
var _7e5=$.data(_7e3,"datagrid");
var opts=_7e5.options;
var dc=_7e5.dc;
var data=_7e5.data;
if(_7e4==undefined||_7e4==null){
_7e4=data.rows.length;
}
if(_7e4>data.rows.length){
_7e4=data.rows.length;
}
function _7e6(_7e7){
var _7e8=_7e7?1:2;
for(var i=data.rows.length-1;i>=_7e4;i--){
var tr=opts.finder.getTr(_7e3,i,"body",_7e8);
tr.attr("datagrid-row-index",i+1);
tr.attr("id",_7e5.rowIdPrefix+"-"+_7e8+"-"+(i+1));
if(_7e7&&opts.rownumbers){
var _7e9=i+2;
if(opts.pagination){
_7e9+=(opts.pageNumber-1)*opts.pageSize;
}
tr.find("div.datagrid-cell-rownumber").html(_7e9);
}
if(opts.striped){
tr.removeClass("datagrid-row-alt").addClass((i+1)%2?"datagrid-row-alt":"");
}
}
};
function _7ea(_7eb){
var _7ec=_7eb?1:2;
var _7ed=$(_7e3).datagrid("getColumnFields",_7eb);
var _7ee=_7e5.rowIdPrefix+"-"+_7ec+"-"+_7e4;
var tr="<tr id=\""+_7ee+"\" class=\"datagrid-row\" datagrid-row-index=\""+_7e4+"\"></tr>";
if(_7e4>=data.rows.length){
if(data.rows.length){
opts.finder.getTr(_7e3,"","last",_7ec).after(tr);
}else{
var cc=_7eb?dc.body1:dc.body2;
cc.html("<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>"+tr+"</tbody></table>");
}
}else{
opts.finder.getTr(_7e3,_7e4+1,"body",_7ec).before(tr);
}
};
_7e6.call(this,true);
_7e6.call(this,false);
_7ea.call(this,true);
_7ea.call(this,false);
data.total+=1;
data.rows.splice(_7e4,0,row);
this.refreshRow.call(this,_7e3,_7e4);
},deleteRow:function(_7ef,_7f0){
var _7f1=$.data(_7ef,"datagrid");
var opts=_7f1.options;
var data=_7f1.data;
function _7f2(_7f3){
var _7f4=_7f3?1:2;
for(var i=_7f0+1;i<data.rows.length;i++){
var tr=opts.finder.getTr(_7ef,i,"body",_7f4);
tr.attr("datagrid-row-index",i-1);
tr.attr("id",_7f1.rowIdPrefix+"-"+_7f4+"-"+(i-1));
if(_7f3&&opts.rownumbers){
var _7f5=i;
if(opts.pagination){
_7f5+=(opts.pageNumber-1)*opts.pageSize;
}
tr.find("div.datagrid-cell-rownumber").html(_7f5);
}
if(opts.striped){
tr.removeClass("datagrid-row-alt").addClass((i-1)%2?"datagrid-row-alt":"");
}
}
};
opts.finder.getTr(_7ef,_7f0).remove();
_7f2.call(this,true);
_7f2.call(this,false);
data.total-=1;
data.rows.splice(_7f0,1);
},onBeforeRender:function(_7f6,rows){
},onAfterRender:function(_7f7){
var _7f8=$.data(_7f7,"datagrid");
var opts=_7f8.options;
if(opts.showFooter){
var _7f9=$(_7f7).datagrid("getPanel").find("div.datagrid-footer");
_7f9.find("div.datagrid-cell-rownumber,div.datagrid-cell-check").css("visibility","hidden");
}
if(opts.finder.getRows(_7f7).length==0){
this.renderEmptyRow(_7f7);
}
},renderEmptyRow:function(_7fa){
var cols=$.map($(_7fa).datagrid("getColumnFields"),function(_7fb){
return $(_7fa).datagrid("getColumnOption",_7fb);
});
$.map(cols,function(col){
col.formatter1=col.formatter;
col.styler1=col.styler;
col.formatter=col.styler=undefined;
});
var _7fc=$.data(_7fa,"datagrid").dc.body2;
_7fc.html(this.renderTable(_7fa,0,[{}],false));
_7fc.find("tbody *").css({height:1,borderColor:"transparent",background:"transparent"});
var tr=_7fc.find(".datagrid-row");
tr.removeClass("datagrid-row").removeAttr("datagrid-row-index");
tr.find(".datagrid-cell,.datagrid-cell-check").empty();
$.map(cols,function(col){
col.formatter=col.formatter1;
col.styler=col.styler1;
col.formatter1=col.styler1=undefined;
});
}};
$.fn.datagrid.defaults=$.extend({},$.fn.panel.defaults,{sharedStyleSheet:false,frozenColumns:undefined,columns:undefined,fitColumns:false,resizeHandle:"right",autoRowHeight:true,toolbar:null,striped:false,method:"post",nowrap:true,idField:null,url:null,data:null,loadMsg:"Processing, please wait ...",rownumbers:false,singleSelect:false,ctrlSelect:false,selectOnCheck:true,checkOnSelect:true,pagination:false,pagePosition:"bottom",pageNumber:1,pageSize:10,pageList:[10,20,30,40,50],queryParams:{},sortName:null,sortOrder:"asc",multiSort:false,remoteSort:true,showHeader:true,showFooter:false,scrollbarSize:18,rowEvents:{mouseover:_64b(true),mouseout:_64b(false),click:_653,dblclick:_65d,contextmenu:_661},rowStyler:function(_7fd,_7fe){
},loader:function(_7ff,_800,_801){
var opts=$(this).datagrid("options");
if(!opts.url){
return false;
}
$.ajax({type:opts.method,url:opts.url,data:_7ff,dataType:"json",success:function(data){
_800(data);
},error:function(){
_801.apply(this,arguments);
}});
},loadFilter:function(data){
return data;
},editors:_76e,finder:{getTr:function(_802,_803,type,_804){
type=type||"body";
_804=_804||0;
var _805=$.data(_802,"datagrid");
var dc=_805.dc;
var opts=_805.options;
if(_804==0){
var tr1=opts.finder.getTr(_802,_803,type,1);
var tr2=opts.finder.getTr(_802,_803,type,2);
return tr1.add(tr2);
}else{
if(type=="body"){
var tr=$("#"+_805.rowIdPrefix+"-"+_804+"-"+_803);
if(!tr.length){
tr=(_804==1?dc.body1:dc.body2).find(">table>tbody>tr[datagrid-row-index="+_803+"]");
}
return tr;
}else{
if(type=="footer"){
return (_804==1?dc.footer1:dc.footer2).find(">table>tbody>tr[datagrid-row-index="+_803+"]");
}else{
if(type=="selected"){
return (_804==1?dc.body1:dc.body2).find(">table>tbody>tr.datagrid-row-selected");
}else{
if(type=="highlight"){
return (_804==1?dc.body1:dc.body2).find(">table>tbody>tr.datagrid-row-over");
}else{
if(type=="checked"){
return (_804==1?dc.body1:dc.body2).find(">table>tbody>tr.datagrid-row-checked");
}else{
if(type=="editing"){
return (_804==1?dc.body1:dc.body2).find(">table>tbody>tr.datagrid-row-editing");
}else{
if(type=="last"){
return (_804==1?dc.body1:dc.body2).find(">table>tbody>tr[datagrid-row-index]:last");
}else{
if(type=="allbody"){
return (_804==1?dc.body1:dc.body2).find(">table>tbody>tr[datagrid-row-index]");
}else{
if(type=="allfooter"){
return (_804==1?dc.footer1:dc.footer2).find(">table>tbody>tr[datagrid-row-index]");
}
}
}
}
}
}
}
}
}
}
},getRow:function(_806,p){
var _807=(typeof p=="object")?p.attr("datagrid-row-index"):p;
return $.data(_806,"datagrid").data.rows[parseInt(_807)];
},getRows:function(_808){
return $(_808).datagrid("getRows");
}},view:_7b7,onBeforeLoad:function(_809){
},onLoadSuccess:function(){
},onLoadError:function(){
},onClickRow:function(_80a,_80b){
},onDblClickRow:function(_80c,_80d){
},onClickCell:function(_80e,_80f,_810){
},onDblClickCell:function(_811,_812,_813){
},onBeforeSortColumn:function(sort,_814){
},onSortColumn:function(sort,_815){
},onResizeColumn:function(_816,_817){
},onBeforeSelect:function(_818,_819){
},onSelect:function(_81a,_81b){
},onBeforeUnselect:function(_81c,_81d){
},onUnselect:function(_81e,_81f){
},onSelectAll:function(rows){
},onUnselectAll:function(rows){
},onBeforeCheck:function(_820,_821){
},onCheck:function(_822,_823){
},onBeforeUncheck:function(_824,_825){
},onUncheck:function(_826,_827){
},onCheckAll:function(rows){
},onUncheckAll:function(rows){
},onBeforeEdit:function(_828,_829){
},onBeginEdit:function(_82a,_82b){
},onEndEdit:function(_82c,_82d,_82e){
},onAfterEdit:function(_82f,_830,_831){
},onCancelEdit:function(_832,_833){
},onHeaderContextMenu:function(e,_834){
},onRowContextMenu:function(e,_835,_836){
}});
})(jQuery);
(function($){
var _837;
$(document).unbind(".propertygrid").bind("mousedown.propertygrid",function(e){
var p=$(e.target).closest("div.datagrid-view,div.combo-panel");
if(p.length){
return;
}
_838(_837);
_837=undefined;
});
function _839(_83a){
var _83b=$.data(_83a,"propertygrid");
var opts=$.data(_83a,"propertygrid").options;
$(_83a).datagrid($.extend({},opts,{cls:"propertygrid",view:(opts.showGroup?opts.groupView:opts.view),onBeforeEdit:function(_83c,row){
if(opts.onBeforeEdit.call(_83a,_83c,row)==false){
return false;
}
var dg=$(this);
var row=dg.datagrid("getRows")[_83c];
var col=dg.datagrid("getColumnOption","value");
col.editor=row.editor;
},onClickCell:function(_83d,_83e,_83f){
if(_837!=this){
_838(_837);
_837=this;
}
if(opts.editIndex!=_83d){
_838(_837);
$(this).datagrid("beginEdit",_83d);
var ed=$(this).datagrid("getEditor",{index:_83d,field:_83e});
if(!ed){
ed=$(this).datagrid("getEditor",{index:_83d,field:"value"});
}
if(ed){
var t=$(ed.target);
var _840=t.data("textbox")?t.textbox("textbox"):t;
_840.focus();
opts.editIndex=_83d;
}
}
opts.onClickCell.call(_83a,_83d,_83e,_83f);
},loadFilter:function(data){
_838(this);
return opts.loadFilter.call(this,data);
}}));
};
function _838(_841){
var t=$(_841);
if(!t.length){
return;
}
var opts=$.data(_841,"propertygrid").options;
opts.finder.getTr(_841,null,"editing").each(function(){
var _842=parseInt($(this).attr("datagrid-row-index"));
if(t.datagrid("validateRow",_842)){
t.datagrid("endEdit",_842);
}else{
t.datagrid("cancelEdit",_842);
}
});
opts.editIndex=undefined;
};
$.fn.propertygrid=function(_843,_844){
if(typeof _843=="string"){
var _845=$.fn.propertygrid.methods[_843];
if(_845){
return _845(this,_844);
}else{
return this.datagrid(_843,_844);
}
}
_843=_843||{};
return this.each(function(){
var _846=$.data(this,"propertygrid");
if(_846){
$.extend(_846.options,_843);
}else{
var opts=$.extend({},$.fn.propertygrid.defaults,$.fn.propertygrid.parseOptions(this),_843);
opts.frozenColumns=$.extend(true,[],opts.frozenColumns);
opts.columns=$.extend(true,[],opts.columns);
$.data(this,"propertygrid",{options:opts});
}
_839(this);
});
};
$.fn.propertygrid.methods={options:function(jq){
return $.data(jq[0],"propertygrid").options;
}};
$.fn.propertygrid.parseOptions=function(_847){
return $.extend({},$.fn.datagrid.parseOptions(_847),$.parser.parseOptions(_847,[{showGroup:"boolean"}]));
};
var _848=$.extend({},$.fn.datagrid.defaults.view,{render:function(_849,_84a,_84b){
var _84c=[];
var _84d=this.groups;
for(var i=0;i<_84d.length;i++){
_84c.push(this.renderGroup.call(this,_849,i,_84d[i],_84b));
}
$(_84a).html(_84c.join(""));
},renderGroup:function(_84e,_84f,_850,_851){
var _852=$.data(_84e,"datagrid");
var opts=_852.options;
var _853=$(_84e).datagrid("getColumnFields",_851);
var _854=[];
_854.push("<div class=\"datagrid-group\" group-index="+_84f+">");
if((_851&&(opts.rownumbers||opts.frozenColumns.length))||(!_851&&!(opts.rownumbers||opts.frozenColumns.length))){
_854.push("<span class=\"datagrid-group-expander\">");
_854.push("<span class=\"datagrid-row-expander datagrid-row-collapse\">&nbsp;</span>");
_854.push("</span>");
}
if(!_851){
_854.push("<span class=\"datagrid-group-title\">");
_854.push(opts.groupFormatter.call(_84e,_850.value,_850.rows));
_854.push("</span>");
}
_854.push("</div>");
_854.push("<table class=\"datagrid-btable\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>");
var _855=_850.startIndex;
for(var j=0;j<_850.rows.length;j++){
var css=opts.rowStyler?opts.rowStyler.call(_84e,_855,_850.rows[j]):"";
var _856="";
var _857="";
if(typeof css=="string"){
_857=css;
}else{
if(css){
_856=css["class"]||"";
_857=css["style"]||"";
}
}
var cls="class=\"datagrid-row "+(_855%2&&opts.striped?"datagrid-row-alt ":" ")+_856+"\"";
var _858=_857?"style=\""+_857+"\"":"";
var _859=_852.rowIdPrefix+"-"+(_851?1:2)+"-"+_855;
_854.push("<tr id=\""+_859+"\" datagrid-row-index=\""+_855+"\" "+cls+" "+_858+">");
_854.push(this.renderRow.call(this,_84e,_853,_851,_855,_850.rows[j]));
_854.push("</tr>");
_855++;
}
_854.push("</tbody></table>");
return _854.join("");
},bindEvents:function(_85a){
var _85b=$.data(_85a,"datagrid");
var dc=_85b.dc;
var body=dc.body1.add(dc.body2);
var _85c=($.data(body[0],"events")||$._data(body[0],"events")).click[0].handler;
body.unbind("click").bind("click",function(e){
var tt=$(e.target);
var _85d=tt.closest("span.datagrid-row-expander");
if(_85d.length){
var _85e=_85d.closest("div.datagrid-group").attr("group-index");
if(_85d.hasClass("datagrid-row-collapse")){
$(_85a).datagrid("collapseGroup",_85e);
}else{
$(_85a).datagrid("expandGroup",_85e);
}
}else{
_85c(e);
}
e.stopPropagation();
});
},onBeforeRender:function(_85f,rows){
var _860=$.data(_85f,"datagrid");
var opts=_860.options;
_861();
var _862=[];
for(var i=0;i<rows.length;i++){
var row=rows[i];
var _863=_864(row[opts.groupField]);
if(!_863){
_863={value:row[opts.groupField],rows:[row]};
_862.push(_863);
}else{
_863.rows.push(row);
}
}
var _865=0;
var _866=[];
for(var i=0;i<_862.length;i++){
var _863=_862[i];
_863.startIndex=_865;
_865+=_863.rows.length;
_866=_866.concat(_863.rows);
}
_860.data.rows=_866;
this.groups=_862;
var that=this;
setTimeout(function(){
that.bindEvents(_85f);
},0);
function _864(_867){
for(var i=0;i<_862.length;i++){
var _868=_862[i];
if(_868.value==_867){
return _868;
}
}
return null;
};
function _861(){
if(!$("#datagrid-group-style").length){
$("head").append("<style id=\"datagrid-group-style\">"+".datagrid-group{height:"+opts.groupHeight+"px;overflow:hidden;font-weight:bold;border-bottom:1px solid #ccc;}"+".datagrid-group-title,.datagrid-group-expander{display:inline-block;vertical-align:bottom;height:100%;line-height:"+opts.groupHeight+"px;padding:0 4px;}"+".datagrid-group-expander{width:"+opts.expanderWidth+"px;text-align:center;padding:0}"+".datagrid-row-expander{margin:"+Math.floor((opts.groupHeight-16)/2)+"px 0;display:inline-block;width:16px;height:16px;cursor:pointer}"+"</style>");
}
};
}});
$.extend($.fn.datagrid.methods,{groups:function(jq){
return jq.datagrid("options").view.groups;
},expandGroup:function(jq,_869){
return jq.each(function(){
var view=$.data(this,"datagrid").dc.view;
var _86a=view.find(_869!=undefined?"div.datagrid-group[group-index=\""+_869+"\"]":"div.datagrid-group");
var _86b=_86a.find("span.datagrid-row-expander");
if(_86b.hasClass("datagrid-row-expand")){
_86b.removeClass("datagrid-row-expand").addClass("datagrid-row-collapse");
_86a.next("table").show();
}
$(this).datagrid("fixRowHeight");
});
},collapseGroup:function(jq,_86c){
return jq.each(function(){
var view=$.data(this,"datagrid").dc.view;
var _86d=view.find(_86c!=undefined?"div.datagrid-group[group-index=\""+_86c+"\"]":"div.datagrid-group");
var _86e=_86d.find("span.datagrid-row-expander");
if(_86e.hasClass("datagrid-row-collapse")){
_86e.removeClass("datagrid-row-collapse").addClass("datagrid-row-expand");
_86d.next("table").hide();
}
$(this).datagrid("fixRowHeight");
});
}});
$.extend(_848,{refreshGroupTitle:function(_86f,_870){
var _871=$.data(_86f,"datagrid");
var opts=_871.options;
var dc=_871.dc;
var _872=this.groups[_870];
var span=dc.body2.children("div.datagrid-group[group-index="+_870+"]").find("span.datagrid-group-title");
span.html(opts.groupFormatter.call(_86f,_872.value,_872.rows));
},insertRow:function(_873,_874,row){
var _875=$.data(_873,"datagrid");
var opts=_875.options;
var dc=_875.dc;
var _876=null;
var _877;
if(!_875.data.rows.length){
$(_873).datagrid("loadData",[row]);
return;
}
for(var i=0;i<this.groups.length;i++){
if(this.groups[i].value==row[opts.groupField]){
_876=this.groups[i];
_877=i;
break;
}
}
if(_876){
if(_874==undefined||_874==null){
_874=_875.data.rows.length;
}
if(_874<_876.startIndex){
_874=_876.startIndex;
}else{
if(_874>_876.startIndex+_876.rows.length){
_874=_876.startIndex+_876.rows.length;
}
}
$.fn.datagrid.defaults.view.insertRow.call(this,_873,_874,row);
if(_874>=_876.startIndex+_876.rows.length){
_878(_874,true);
_878(_874,false);
}
_876.rows.splice(_874-_876.startIndex,0,row);
}else{
_876={value:row[opts.groupField],rows:[row],startIndex:_875.data.rows.length};
_877=this.groups.length;
dc.body1.append(this.renderGroup.call(this,_873,_877,_876,true));
dc.body2.append(this.renderGroup.call(this,_873,_877,_876,false));
this.groups.push(_876);
_875.data.rows.push(row);
}
this.refreshGroupTitle(_873,_877);
function _878(_879,_87a){
var _87b=_87a?1:2;
var _87c=opts.finder.getTr(_873,_879-1,"body",_87b);
var tr=opts.finder.getTr(_873,_879,"body",_87b);
tr.insertAfter(_87c);
};
},updateRow:function(_87d,_87e,row){
var opts=$.data(_87d,"datagrid").options;
$.fn.datagrid.defaults.view.updateRow.call(this,_87d,_87e,row);
var tb=opts.finder.getTr(_87d,_87e,"body",2).closest("table.datagrid-btable");
var _87f=parseInt(tb.prev().attr("group-index"));
this.refreshGroupTitle(_87d,_87f);
},deleteRow:function(_880,_881){
var _882=$.data(_880,"datagrid");
var opts=_882.options;
var dc=_882.dc;
var body=dc.body1.add(dc.body2);
var tb=opts.finder.getTr(_880,_881,"body",2).closest("table.datagrid-btable");
var _883=parseInt(tb.prev().attr("group-index"));
$.fn.datagrid.defaults.view.deleteRow.call(this,_880,_881);
var _884=this.groups[_883];
if(_884.rows.length>1){
_884.rows.splice(_881-_884.startIndex,1);
this.refreshGroupTitle(_880,_883);
}else{
body.children("div.datagrid-group[group-index="+_883+"]").remove();
for(var i=_883+1;i<this.groups.length;i++){
body.children("div.datagrid-group[group-index="+i+"]").attr("group-index",i-1);
}
this.groups.splice(_883,1);
}
var _881=0;
for(var i=0;i<this.groups.length;i++){
var _884=this.groups[i];
_884.startIndex=_881;
_881+=_884.rows.length;
}
}});
$.fn.propertygrid.defaults=$.extend({},$.fn.datagrid.defaults,{groupHeight:21,expanderWidth:16,singleSelect:true,remoteSort:false,fitColumns:true,loadMsg:"",frozenColumns:[[{field:"f",width:16,resizable:false}]],columns:[[{field:"name",title:"Name",width:100,sortable:true},{field:"value",title:"Value",width:100,resizable:false}]],showGroup:false,groupView:_848,groupField:"group",groupFormatter:function(_885,rows){
return _885;
}});
})(jQuery);
(function($){
function _886(_887){
var _888=$.data(_887,"treegrid");
var opts=_888.options;
$(_887).datagrid($.extend({},opts,{url:null,data:null,loader:function(){
return false;
},onBeforeLoad:function(){
return false;
},onLoadSuccess:function(){
},onResizeColumn:function(_889,_88a){
_897(_887);
opts.onResizeColumn.call(_887,_889,_88a);
},onBeforeSortColumn:function(sort,_88b){
if(opts.onBeforeSortColumn.call(_887,sort,_88b)==false){
return false;
}
},onSortColumn:function(sort,_88c){
opts.sortName=sort;
opts.sortOrder=_88c;
if(opts.remoteSort){
_896(_887);
}else{
var data=$(_887).treegrid("getData");
_8c3(_887,null,data);
}
opts.onSortColumn.call(_887,sort,_88c);
},onClickCell:function(_88d,_88e){
opts.onClickCell.call(_887,_88e,find(_887,_88d));
},onDblClickCell:function(_88f,_890){
opts.onDblClickCell.call(_887,_890,find(_887,_88f));
},onRowContextMenu:function(e,_891){
opts.onContextMenu.call(_887,e,find(_887,_891));
}}));
var _892=$.data(_887,"datagrid").options;
opts.columns=_892.columns;
opts.frozenColumns=_892.frozenColumns;
_888.dc=$.data(_887,"datagrid").dc;
if(opts.pagination){
var _893=$(_887).datagrid("getPager");
_893.pagination({pageNumber:opts.pageNumber,pageSize:opts.pageSize,pageList:opts.pageList,onSelectPage:function(_894,_895){
opts.pageNumber=_894;
opts.pageSize=_895;
_896(_887);
}});
opts.pageSize=_893.pagination("options").pageSize;
}
};
function _897(_898,_899){
var opts=$.data(_898,"datagrid").options;
var dc=$.data(_898,"datagrid").dc;
if(!dc.body1.is(":empty")&&(!opts.nowrap||opts.autoRowHeight)){
if(_899!=undefined){
var _89a=_89b(_898,_899);
for(var i=0;i<_89a.length;i++){
_89c(_89a[i][opts.idField]);
}
}
}
$(_898).datagrid("fixRowHeight",_899);
function _89c(_89d){
var tr1=opts.finder.getTr(_898,_89d,"body",1);
var tr2=opts.finder.getTr(_898,_89d,"body",2);
tr1.css("height","");
tr2.css("height","");
var _89e=Math.max(tr1.height(),tr2.height());
tr1.css("height",_89e);
tr2.css("height",_89e);
};
};
function _89f(_8a0){
var dc=$.data(_8a0,"datagrid").dc;
var opts=$.data(_8a0,"treegrid").options;
if(!opts.rownumbers){
return;
}
dc.body1.find("div.datagrid-cell-rownumber").each(function(i){
$(this).html(i+1);
});
};
function _8a1(_8a2){
return function(e){
$.fn.datagrid.defaults.rowEvents[_8a2?"mouseover":"mouseout"](e);
var tt=$(e.target);
var fn=_8a2?"addClass":"removeClass";
if(tt.hasClass("tree-hit")){
tt.hasClass("tree-expanded")?tt[fn]("tree-expanded-hover"):tt[fn]("tree-collapsed-hover");
}
};
};
function _8a3(e){
var tt=$(e.target);
if(tt.hasClass("tree-hit")){
_8a4(_8a5);
}else{
if(tt.hasClass("tree-checkbox")){
_8a4(_8a6);
}else{
$.fn.datagrid.defaults.rowEvents.click(e);
}
}
function _8a4(fn){
var tr=tt.closest("tr.datagrid-row");
var _8a7=tr.closest("div.datagrid-view").children(".datagrid-f")[0];
fn(_8a7,tr.attr("node-id"));
};
};
function _8a6(_8a8,_8a9,_8aa,_8ab){
var _8ac=$.data(_8a8,"treegrid");
var _8ad=_8ac.checkedRows;
var opts=_8ac.options;
if(!opts.checkbox){
return;
}
var row=find(_8a8,_8a9);
if(!row.checkState){
return;
}
var tr=opts.finder.getTr(_8a8,_8a9);
var ck=tr.find(".tree-checkbox");
if(_8aa==undefined){
if(ck.hasClass("tree-checkbox1")){
_8aa=false;
}else{
if(ck.hasClass("tree-checkbox0")){
_8aa=true;
}else{
if(row._checked==undefined){
row._checked=ck.hasClass("tree-checkbox1");
}
_8aa=!row._checked;
}
}
}
row._checked=_8aa;
if(_8aa){
if(ck.hasClass("tree-checkbox1")){
return;
}
}else{
if(ck.hasClass("tree-checkbox0")){
return;
}
}
if(!_8ab){
if(opts.onBeforeCheckNode.call(_8a8,row,_8aa)==false){
return;
}
}
if(opts.cascadeCheck){
_8ae(_8a8,row,_8aa);
_8af(_8a8,row);
}else{
_8b0(_8a8,row,_8aa?"1":"0");
}
if(!_8ab){
opts.onCheckNode.call(_8a8,row,_8aa);
}
};
function _8b0(_8b1,row,flag){
var _8b2=$.data(_8b1,"treegrid");
var _8b3=_8b2.checkedRows;
var opts=_8b2.options;
if(!row.checkState||flag==undefined){
return;
}
var tr=opts.finder.getTr(_8b1,row[opts.idField]);
var ck=tr.find(".tree-checkbox");
if(!ck.length){
return;
}
row.checkState=["unchecked","checked","indeterminate"][flag];
row.checked=(row.checkState=="checked");
ck.removeClass("tree-checkbox0 tree-checkbox1 tree-checkbox2");
ck.addClass("tree-checkbox"+flag);
if(flag==0){
$.easyui.removeArrayItem(_8b3,opts.idField,row[opts.idField]);
}else{
$.easyui.addArrayItem(_8b3,opts.idField,row);
}
};
function _8ae(_8b4,row,_8b5){
var flag=_8b5?1:0;
_8b0(_8b4,row,flag);
$.easyui.forEach(row.children||[],true,function(r){
_8b0(_8b4,r,flag);
});
};
function _8af(_8b6,row){
var opts=$.data(_8b6,"treegrid").options;
var prow=_8b7(_8b6,row[opts.idField]);
if(prow){
_8b0(_8b6,prow,_8b8(prow));
_8af(_8b6,prow);
}
};
function _8b8(row){
var len=0;
var c0=0;
var c1=0;
$.easyui.forEach(row.children||[],false,function(r){
if(r.checkState){
len++;
if(r.checkState=="checked"){
c1++;
}else{
if(r.checkState=="unchecked"){
c0++;
}
}
}
});
if(len==0){
return undefined;
}
var flag=0;
if(c0==len){
flag=0;
}else{
if(c1==len){
flag=1;
}else{
flag=2;
}
}
return flag;
};
function _8b9(_8ba,_8bb){
var opts=$.data(_8ba,"treegrid").options;
if(!opts.checkbox){
return;
}
var row=find(_8ba,_8bb);
var tr=opts.finder.getTr(_8ba,_8bb);
var ck=tr.find(".tree-checkbox");
if(opts.view.hasCheckbox(_8ba,row)){
if(!ck.length){
row.checkState=row.checkState||"unchecked";
$("<span class=\"tree-checkbox\"></span>").insertBefore(tr.find(".tree-title"));
}
if(row.checkState=="checked"){
_8a6(_8ba,_8bb,true,true);
}else{
if(row.checkState=="unchecked"){
_8a6(_8ba,_8bb,false,true);
}else{
var flag=_8b8(row);
if(flag===0){
_8a6(_8ba,_8bb,false,true);
}else{
if(flag===1){
_8a6(_8ba,_8bb,true,true);
}
}
}
}
}else{
ck.remove();
row.checkState=undefined;
row.checked=undefined;
_8af(_8ba,row);
}
};
function _8bc(_8bd,_8be){
var opts=$.data(_8bd,"treegrid").options;
var tr1=opts.finder.getTr(_8bd,_8be,"body",1);
var tr2=opts.finder.getTr(_8bd,_8be,"body",2);
var _8bf=$(_8bd).datagrid("getColumnFields",true).length+(opts.rownumbers?1:0);
var _8c0=$(_8bd).datagrid("getColumnFields",false).length;
_8c1(tr1,_8bf);
_8c1(tr2,_8c0);
function _8c1(tr,_8c2){
$("<tr class=\"treegrid-tr-tree\">"+"<td style=\"border:0px\" colspan=\""+_8c2+"\">"+"<div></div>"+"</td>"+"</tr>").insertAfter(tr);
};
};
function _8c3(_8c4,_8c5,data,_8c6,_8c7){
var _8c8=$.data(_8c4,"treegrid");
var opts=_8c8.options;
var dc=_8c8.dc;
data=opts.loadFilter.call(_8c4,data,_8c5);
var node=find(_8c4,_8c5);
if(node){
var _8c9=opts.finder.getTr(_8c4,_8c5,"body",1);
var _8ca=opts.finder.getTr(_8c4,_8c5,"body",2);
var cc1=_8c9.next("tr.treegrid-tr-tree").children("td").children("div");
var cc2=_8ca.next("tr.treegrid-tr-tree").children("td").children("div");
if(!_8c6){
node.children=[];
}
}else{
var cc1=dc.body1;
var cc2=dc.body2;
if(!_8c6){
_8c8.data=[];
}
}
if(!_8c6){
cc1.empty();
cc2.empty();
}
if(opts.view.onBeforeRender){
opts.view.onBeforeRender.call(opts.view,_8c4,_8c5,data);
}
opts.view.render.call(opts.view,_8c4,cc1,true);
opts.view.render.call(opts.view,_8c4,cc2,false);
if(opts.showFooter){
opts.view.renderFooter.call(opts.view,_8c4,dc.footer1,true);
opts.view.renderFooter.call(opts.view,_8c4,dc.footer2,false);
}
if(opts.view.onAfterRender){
opts.view.onAfterRender.call(opts.view,_8c4);
}
if(!_8c5&&opts.pagination){
var _8cb=$.data(_8c4,"treegrid").total;
var _8cc=$(_8c4).datagrid("getPager");
if(_8cc.pagination("options").total!=_8cb){
_8cc.pagination({total:_8cb});
}
}
_897(_8c4);
_89f(_8c4);
$(_8c4).treegrid("showLines");
$(_8c4).treegrid("setSelectionState");
$(_8c4).treegrid("autoSizeColumn");
if(!_8c7){
opts.onLoadSuccess.call(_8c4,node,data);
}
};
function _896(_8cd,_8ce,_8cf,_8d0,_8d1){
var opts=$.data(_8cd,"treegrid").options;
var body=$(_8cd).datagrid("getPanel").find("div.datagrid-body");
if(_8ce==undefined&&opts.queryParams){
opts.queryParams.id=undefined;
}
if(_8cf){
opts.queryParams=_8cf;
}
var _8d2=$.extend({},opts.queryParams);
if(opts.pagination){
$.extend(_8d2,{page:opts.pageNumber,rows:opts.pageSize});
}
if(opts.sortName){
$.extend(_8d2,{sort:opts.sortName,order:opts.sortOrder});
}
var row=find(_8cd,_8ce);
if(opts.onBeforeLoad.call(_8cd,row,_8d2)==false){
return;
}
var _8d3=body.find("tr[node-id=\""+_8ce+"\"] span.tree-folder");
_8d3.addClass("tree-loading");
$(_8cd).treegrid("loading");
var _8d4=opts.loader.call(_8cd,_8d2,function(data){
_8d3.removeClass("tree-loading");
$(_8cd).treegrid("loaded");
_8c3(_8cd,_8ce,data,_8d0);
if(_8d1){
_8d1();
}
},function(){
_8d3.removeClass("tree-loading");
$(_8cd).treegrid("loaded");
opts.onLoadError.apply(_8cd,arguments);
if(_8d1){
_8d1();
}
});
if(_8d4==false){
_8d3.removeClass("tree-loading");
$(_8cd).treegrid("loaded");
}
};
function _8d5(_8d6){
var _8d7=_8d8(_8d6);
return _8d7.length?_8d7[0]:null;
};
function _8d8(_8d9){
return $.data(_8d9,"treegrid").data;
};
function _8b7(_8da,_8db){
var row=find(_8da,_8db);
if(row._parentId){
return find(_8da,row._parentId);
}else{
return null;
}
};
function _89b(_8dc,_8dd){
var data=$.data(_8dc,"treegrid").data;
if(_8dd){
var _8de=find(_8dc,_8dd);
data=_8de?(_8de.children||[]):[];
}
var _8df=[];
$.easyui.forEach(data,true,function(node){
_8df.push(node);
});
return _8df;
};
function _8e0(_8e1,_8e2){
var opts=$.data(_8e1,"treegrid").options;
var tr=opts.finder.getTr(_8e1,_8e2);
var node=tr.children("td[field=\""+opts.treeField+"\"]");
return node.find("span.tree-indent,span.tree-hit").length;
};
function find(_8e3,_8e4){
var _8e5=$.data(_8e3,"treegrid");
var opts=_8e5.options;
var _8e6=null;
$.easyui.forEach(_8e5.data,true,function(node){
if(node[opts.idField]==_8e4){
_8e6=node;
return false;
}
});
return _8e6;
};
function _8e7(_8e8,_8e9){
var opts=$.data(_8e8,"treegrid").options;
var row=find(_8e8,_8e9);
var tr=opts.finder.getTr(_8e8,_8e9);
var hit=tr.find("span.tree-hit");
if(hit.length==0){
return;
}
if(hit.hasClass("tree-collapsed")){
return;
}
if(opts.onBeforeCollapse.call(_8e8,row)==false){
return;
}
hit.removeClass("tree-expanded tree-expanded-hover").addClass("tree-collapsed");
hit.next().removeClass("tree-folder-open");
row.state="closed";
tr=tr.next("tr.treegrid-tr-tree");
var cc=tr.children("td").children("div");
if(opts.animate){
cc.slideUp("normal",function(){
$(_8e8).treegrid("autoSizeColumn");
_897(_8e8,_8e9);
opts.onCollapse.call(_8e8,row);
});
}else{
cc.hide();
$(_8e8).treegrid("autoSizeColumn");
_897(_8e8,_8e9);
opts.onCollapse.call(_8e8,row);
}
};
function _8ea(_8eb,_8ec){
var opts=$.data(_8eb,"treegrid").options;
var tr=opts.finder.getTr(_8eb,_8ec);
var hit=tr.find("span.tree-hit");
var row=find(_8eb,_8ec);
if(hit.length==0){
return;
}
if(hit.hasClass("tree-expanded")){
return;
}
if(opts.onBeforeExpand.call(_8eb,row)==false){
return;
}
hit.removeClass("tree-collapsed tree-collapsed-hover").addClass("tree-expanded");
hit.next().addClass("tree-folder-open");
var _8ed=tr.next("tr.treegrid-tr-tree");
if(_8ed.length){
var cc=_8ed.children("td").children("div");
_8ee(cc);
}else{
_8bc(_8eb,row[opts.idField]);
var _8ed=tr.next("tr.treegrid-tr-tree");
var cc=_8ed.children("td").children("div");
cc.hide();
var _8ef=$.extend({},opts.queryParams||{});
_8ef.id=row[opts.idField];
_896(_8eb,row[opts.idField],_8ef,true,function(){
if(cc.is(":empty")){
_8ed.remove();
}else{
_8ee(cc);
}
});
}
function _8ee(cc){
row.state="open";
if(opts.animate){
cc.slideDown("normal",function(){
$(_8eb).treegrid("autoSizeColumn");
_897(_8eb,_8ec);
opts.onExpand.call(_8eb,row);
});
}else{
cc.show();
$(_8eb).treegrid("autoSizeColumn");
_897(_8eb,_8ec);
opts.onExpand.call(_8eb,row);
}
};
};
function _8a5(_8f0,_8f1){
var opts=$.data(_8f0,"treegrid").options;
var tr=opts.finder.getTr(_8f0,_8f1);
var hit=tr.find("span.tree-hit");
if(hit.hasClass("tree-expanded")){
_8e7(_8f0,_8f1);
}else{
_8ea(_8f0,_8f1);
}
};
function _8f2(_8f3,_8f4){
var opts=$.data(_8f3,"treegrid").options;
var _8f5=_89b(_8f3,_8f4);
if(_8f4){
_8f5.unshift(find(_8f3,_8f4));
}
for(var i=0;i<_8f5.length;i++){
_8e7(_8f3,_8f5[i][opts.idField]);
}
};
function _8f6(_8f7,_8f8){
var opts=$.data(_8f7,"treegrid").options;
var _8f9=_89b(_8f7,_8f8);
if(_8f8){
_8f9.unshift(find(_8f7,_8f8));
}
for(var i=0;i<_8f9.length;i++){
_8ea(_8f7,_8f9[i][opts.idField]);
}
};
function _8fa(_8fb,_8fc){
var opts=$.data(_8fb,"treegrid").options;
var ids=[];
var p=_8b7(_8fb,_8fc);
while(p){
var id=p[opts.idField];
ids.unshift(id);
p=_8b7(_8fb,id);
}
for(var i=0;i<ids.length;i++){
_8ea(_8fb,ids[i]);
}
};
function _8fd(_8fe,_8ff){
var opts=$.data(_8fe,"treegrid").options;
if(_8ff.parent){
var tr=opts.finder.getTr(_8fe,_8ff.parent);
if(tr.next("tr.treegrid-tr-tree").length==0){
_8bc(_8fe,_8ff.parent);
}
var cell=tr.children("td[field=\""+opts.treeField+"\"]").children("div.datagrid-cell");
var _900=cell.children("span.tree-icon");
if(_900.hasClass("tree-file")){
_900.removeClass("tree-file").addClass("tree-folder tree-folder-open");
var hit=$("<span class=\"tree-hit tree-expanded\"></span>").insertBefore(_900);
if(hit.prev().length){
hit.prev().remove();
}
}
}
_8c3(_8fe,_8ff.parent,_8ff.data,true,true);
};
function _901(_902,_903){
var ref=_903.before||_903.after;
var opts=$.data(_902,"treegrid").options;
var _904=_8b7(_902,ref);
_8fd(_902,{parent:(_904?_904[opts.idField]:null),data:[_903.data]});
var _905=_904?_904.children:$(_902).treegrid("getRoots");
for(var i=0;i<_905.length;i++){
if(_905[i][opts.idField]==ref){
var _906=_905[_905.length-1];
_905.splice(_903.before?i:(i+1),0,_906);
_905.splice(_905.length-1,1);
break;
}
}
_907(true);
_907(false);
_89f(_902);
$(_902).treegrid("showLines");
function _907(_908){
var _909=_908?1:2;
var tr=opts.finder.getTr(_902,_903.data[opts.idField],"body",_909);
var _90a=tr.closest("table.datagrid-btable");
tr=tr.parent().children();
var dest=opts.finder.getTr(_902,ref,"body",_909);
if(_903.before){
tr.insertBefore(dest);
}else{
var sub=dest.next("tr.treegrid-tr-tree");
tr.insertAfter(sub.length?sub:dest);
}
_90a.remove();
};
};
function _90b(_90c,_90d){
var _90e=$.data(_90c,"treegrid");
var opts=_90e.options;
var prow=_8b7(_90c,_90d);
$(_90c).datagrid("deleteRow",_90d);
$.easyui.removeArrayItem(_90e.checkedRows,opts.idField,_90d);
_89f(_90c);
if(prow){
_8b9(_90c,prow[opts.idField]);
}
_90e.total-=1;
$(_90c).datagrid("getPager").pagination("refresh",{total:_90e.total});
$(_90c).treegrid("showLines");
};
function _90f(_910){
var t=$(_910);
var opts=t.treegrid("options");
if(opts.lines){
t.treegrid("getPanel").addClass("tree-lines");
}else{
t.treegrid("getPanel").removeClass("tree-lines");
return;
}
t.treegrid("getPanel").find("span.tree-indent").removeClass("tree-line tree-join tree-joinbottom");
t.treegrid("getPanel").find("div.datagrid-cell").removeClass("tree-node-last tree-root-first tree-root-one");
var _911=t.treegrid("getRoots");
if(_911.length>1){
_912(_911[0]).addClass("tree-root-first");
}else{
if(_911.length==1){
_912(_911[0]).addClass("tree-root-one");
}
}
_913(_911);
_914(_911);
function _913(_915){
$.map(_915,function(node){
if(node.children&&node.children.length){
_913(node.children);
}else{
var cell=_912(node);
cell.find(".tree-icon").prev().addClass("tree-join");
}
});
if(_915.length){
var cell=_912(_915[_915.length-1]);
cell.addClass("tree-node-last");
cell.find(".tree-join").removeClass("tree-join").addClass("tree-joinbottom");
}
};
function _914(_916){
$.map(_916,function(node){
if(node.children&&node.children.length){
_914(node.children);
}
});
for(var i=0;i<_916.length-1;i++){
var node=_916[i];
var _917=t.treegrid("getLevel",node[opts.idField]);
var tr=opts.finder.getTr(_910,node[opts.idField]);
var cc=tr.next().find("tr.datagrid-row td[field=\""+opts.treeField+"\"] div.datagrid-cell");
cc.find("span:eq("+(_917-1)+")").addClass("tree-line");
}
};
function _912(node){
var tr=opts.finder.getTr(_910,node[opts.idField]);
var cell=tr.find("td[field=\""+opts.treeField+"\"] div.datagrid-cell");
return cell;
};
};
$.fn.treegrid=function(_918,_919){
if(typeof _918=="string"){
var _91a=$.fn.treegrid.methods[_918];
if(_91a){
return _91a(this,_919);
}else{
return this.datagrid(_918,_919);
}
}
_918=_918||{};
return this.each(function(){
var _91b=$.data(this,"treegrid");
if(_91b){
$.extend(_91b.options,_918);
}else{
_91b=$.data(this,"treegrid",{options:$.extend({},$.fn.treegrid.defaults,$.fn.treegrid.parseOptions(this),_918),data:[],checkedRows:[],tmpIds:[]});
}
_886(this);
if(_91b.options.data){
$(this).treegrid("loadData",_91b.options.data);
}
_896(this);
});
};
$.fn.treegrid.methods={options:function(jq){
return $.data(jq[0],"treegrid").options;
},resize:function(jq,_91c){
return jq.each(function(){
$(this).datagrid("resize",_91c);
});
},fixRowHeight:function(jq,_91d){
return jq.each(function(){
_897(this,_91d);
});
},loadData:function(jq,data){
return jq.each(function(){
_8c3(this,data.parent,data);
});
},load:function(jq,_91e){
return jq.each(function(){
$(this).treegrid("options").pageNumber=1;
$(this).treegrid("getPager").pagination({pageNumber:1});
$(this).treegrid("reload",_91e);
});
},reload:function(jq,id){
return jq.each(function(){
var opts=$(this).treegrid("options");
var _91f={};
if(typeof id=="object"){
_91f=id;
}else{
_91f=$.extend({},opts.queryParams);
_91f.id=id;
}
if(_91f.id){
var node=$(this).treegrid("find",_91f.id);
if(node.children){
node.children.splice(0,node.children.length);
}
opts.queryParams=_91f;
var tr=opts.finder.getTr(this,_91f.id);
tr.next("tr.treegrid-tr-tree").remove();
tr.find("span.tree-hit").removeClass("tree-expanded tree-expanded-hover").addClass("tree-collapsed");
_8ea(this,_91f.id);
}else{
_896(this,null,_91f);
}
});
},reloadFooter:function(jq,_920){
return jq.each(function(){
var opts=$.data(this,"treegrid").options;
var dc=$.data(this,"datagrid").dc;
if(_920){
$.data(this,"treegrid").footer=_920;
}
if(opts.showFooter){
opts.view.renderFooter.call(opts.view,this,dc.footer1,true);
opts.view.renderFooter.call(opts.view,this,dc.footer2,false);
if(opts.view.onAfterRender){
opts.view.onAfterRender.call(opts.view,this);
}
$(this).treegrid("fixRowHeight");
}
});
},getData:function(jq){
return $.data(jq[0],"treegrid").data;
},getFooterRows:function(jq){
return $.data(jq[0],"treegrid").footer;
},getRoot:function(jq){
return _8d5(jq[0]);
},getRoots:function(jq){
return _8d8(jq[0]);
},getParent:function(jq,id){
return _8b7(jq[0],id);
},getChildren:function(jq,id){
return _89b(jq[0],id);
},getLevel:function(jq,id){
return _8e0(jq[0],id);
},find:function(jq,id){
return find(jq[0],id);
},isLeaf:function(jq,id){
var opts=$.data(jq[0],"treegrid").options;
var tr=opts.finder.getTr(jq[0],id);
var hit=tr.find("span.tree-hit");
return hit.length==0;
},select:function(jq,id){
return jq.each(function(){
$(this).datagrid("selectRow",id);
});
},unselect:function(jq,id){
return jq.each(function(){
$(this).datagrid("unselectRow",id);
});
},collapse:function(jq,id){
return jq.each(function(){
_8e7(this,id);
});
},expand:function(jq,id){
return jq.each(function(){
_8ea(this,id);
});
},toggle:function(jq,id){
return jq.each(function(){
_8a5(this,id);
});
},collapseAll:function(jq,id){
return jq.each(function(){
_8f2(this,id);
});
},expandAll:function(jq,id){
return jq.each(function(){
_8f6(this,id);
});
},expandTo:function(jq,id){
return jq.each(function(){
_8fa(this,id);
});
},append:function(jq,_921){
return jq.each(function(){
_8fd(this,_921);
});
},insert:function(jq,_922){
return jq.each(function(){
_901(this,_922);
});
},remove:function(jq,id){
return jq.each(function(){
_90b(this,id);
});
},pop:function(jq,id){
var row=jq.treegrid("find",id);
jq.treegrid("remove",id);
return row;
},refresh:function(jq,id){
return jq.each(function(){
var opts=$.data(this,"treegrid").options;
opts.view.refreshRow.call(opts.view,this,id);
});
},update:function(jq,_923){
return jq.each(function(){
var opts=$.data(this,"treegrid").options;
var row=_923.row;
opts.view.updateRow.call(opts.view,this,_923.id,row);
if(row.checked!=undefined){
row=find(this,_923.id);
$.extend(row,{checkState:row.checked?"checked":(row.checked===false?"unchecked":undefined)});
_8b9(this,_923.id);
}
});
},beginEdit:function(jq,id){
return jq.each(function(){
$(this).datagrid("beginEdit",id);
$(this).treegrid("fixRowHeight",id);
});
},endEdit:function(jq,id){
return jq.each(function(){
$(this).datagrid("endEdit",id);
});
},cancelEdit:function(jq,id){
return jq.each(function(){
$(this).datagrid("cancelEdit",id);
});
},showLines:function(jq){
return jq.each(function(){
_90f(this);
});
},setSelectionState:function(jq){
return jq.each(function(){
$(this).datagrid("setSelectionState");
var _924=$(this).data("treegrid");
for(var i=0;i<_924.tmpIds.length;i++){
_8a6(this,_924.tmpIds[i],true,true);
}
_924.tmpIds=[];
});
},getCheckedNodes:function(jq,_925){
_925=_925||"checked";
var rows=[];
$.easyui.forEach(jq.data("treegrid").checkedRows,false,function(row){
if(row.checkState==_925){
rows.push(row);
}
});
return rows;
},checkNode:function(jq,id){
return jq.each(function(){
_8a6(this,id,true);
});
},uncheckNode:function(jq,id){
return jq.each(function(){
_8a6(this,id,false);
});
},clearChecked:function(jq){
return jq.each(function(){
var _926=this;
var opts=$(_926).treegrid("options");
$(_926).datagrid("clearChecked");
$.map($(_926).treegrid("getCheckedNodes"),function(row){
_8a6(_926,row[opts.idField],false,true);
});
});
}};
$.fn.treegrid.parseOptions=function(_927){
return $.extend({},$.fn.datagrid.parseOptions(_927),$.parser.parseOptions(_927,["treeField",{checkbox:"boolean",cascadeCheck:"boolean",onlyLeafCheck:"boolean"},{animate:"boolean"}]));
};
var _928=$.extend({},$.fn.datagrid.defaults.view,{render:function(_929,_92a,_92b){
var opts=$.data(_929,"treegrid").options;
var _92c=$(_929).datagrid("getColumnFields",_92b);
var _92d=$.data(_929,"datagrid").rowIdPrefix;
if(_92b){
if(!(opts.rownumbers||(opts.frozenColumns&&opts.frozenColumns.length))){
return;
}
}
var view=this;
if(this.treeNodes&&this.treeNodes.length){
var _92e=_92f.call(this,_92b,this.treeLevel,this.treeNodes);
$(_92a).append(_92e.join(""));
}
function _92f(_930,_931,_932){
var _933=$(_929).treegrid("getParent",_932[0][opts.idField]);
var _934=(_933?_933.children.length:$(_929).treegrid("getRoots").length)-_932.length;
var _935=["<table class=\"datagrid-btable\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>"];
for(var i=0;i<_932.length;i++){
var row=_932[i];
if(row.state!="open"&&row.state!="closed"){
row.state="open";
}
var css=opts.rowStyler?opts.rowStyler.call(_929,row):"";
var cs=this.getStyleValue(css);
var cls="class=\"datagrid-row "+(_934++%2&&opts.striped?"datagrid-row-alt ":" ")+cs.c+"\"";
var _936=cs.s?"style=\""+cs.s+"\"":"";
var _937=_92d+"-"+(_930?1:2)+"-"+row[opts.idField];
_935.push("<tr id=\""+_937+"\" node-id=\""+row[opts.idField]+"\" "+cls+" "+_936+">");
_935=_935.concat(view.renderRow.call(view,_929,_92c,_930,_931,row));
_935.push("</tr>");
if(row.children&&row.children.length){
var tt=_92f.call(this,_930,_931+1,row.children);
var v=row.state=="closed"?"none":"block";
_935.push("<tr class=\"treegrid-tr-tree\"><td style=\"border:0px\" colspan="+(_92c.length+(opts.rownumbers?1:0))+"><div style=\"display:"+v+"\">");
_935=_935.concat(tt);
_935.push("</div></td></tr>");
}
}
_935.push("</tbody></table>");
return _935;
};
},renderFooter:function(_938,_939,_93a){
var opts=$.data(_938,"treegrid").options;
var rows=$.data(_938,"treegrid").footer||[];
var _93b=$(_938).datagrid("getColumnFields",_93a);
var _93c=["<table class=\"datagrid-ftable\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\"><tbody>"];
for(var i=0;i<rows.length;i++){
var row=rows[i];
row[opts.idField]=row[opts.idField]||("foot-row-id"+i);
_93c.push("<tr class=\"datagrid-row\" node-id=\""+row[opts.idField]+"\">");
_93c.push(this.renderRow.call(this,_938,_93b,_93a,0,row));
_93c.push("</tr>");
}
_93c.push("</tbody></table>");
$(_939).html(_93c.join(""));
},renderRow:function(_93d,_93e,_93f,_940,row){
var _941=$.data(_93d,"treegrid");
var opts=_941.options;
var cc=[];
if(_93f&&opts.rownumbers){
cc.push("<td class=\"datagrid-td-rownumber\"><div class=\"datagrid-cell-rownumber\">0</div></td>");
}
for(var i=0;i<_93e.length;i++){
var _942=_93e[i];
var col=$(_93d).datagrid("getColumnOption",_942);
if(col){
var css=col.styler?(col.styler(row[_942],row)||""):"";
var cs=this.getStyleValue(css);
var cls=cs.c?"class=\""+cs.c+"\"":"";
var _943=col.hidden?"style=\"display:none;"+cs.s+"\"":(cs.s?"style=\""+cs.s+"\"":"");
cc.push("<td field=\""+_942+"\" "+cls+" "+_943+">");
var _943="";
if(!col.checkbox){
if(col.align){
_943+="text-align:"+col.align+";";
}
if(!opts.nowrap){
_943+="white-space:normal;height:auto;";
}else{
if(opts.autoRowHeight){
_943+="height:auto;";
}
}
}
cc.push("<div style=\""+_943+"\" ");
if(col.checkbox){
cc.push("class=\"datagrid-cell-check ");
}else{
cc.push("class=\"datagrid-cell "+col.cellClass);
}
cc.push("\">");
if(col.checkbox){
if(row.checked){
cc.push("<input type=\"checkbox\" checked=\"checked\"");
}else{
cc.push("<input type=\"checkbox\"");
}
cc.push(" name=\""+_942+"\" value=\""+(row[_942]!=undefined?row[_942]:"")+"\">");
}else{
var val=null;
if(col.formatter){
val=col.formatter(row[_942],row);
}else{
val=row[_942];
}
if(_942==opts.treeField){
for(var j=0;j<_940;j++){
cc.push("<span class=\"tree-indent\"></span>");
}
if(row.state=="closed"){
cc.push("<span class=\"tree-hit tree-collapsed\"></span>");
cc.push("<span class=\"tree-icon tree-folder "+(row.iconCls?row.iconCls:"")+"\"></span>");
}else{
if(row.children&&row.children.length){
cc.push("<span class=\"tree-hit tree-expanded\"></span>");
cc.push("<span class=\"tree-icon tree-folder tree-folder-open "+(row.iconCls?row.iconCls:"")+"\"></span>");
}else{
cc.push("<span class=\"tree-indent\"></span>");
cc.push("<span class=\"tree-icon tree-file "+(row.iconCls?row.iconCls:"")+"\"></span>");
}
}
if(this.hasCheckbox(_93d,row)){
var flag=0;
var crow=$.easyui.getArrayItem(_941.checkedRows,opts.idField,row[opts.idField]);
if(crow){
flag=crow.checkState=="checked"?1:2;
}else{
var prow=$.easyui.getArrayItem(_941.checkedRows,opts.idField,row._parentId);
if(prow&&prow.checkState=="checked"&&opts.cascadeCheck){
flag=1;
row.checked=true;
$.easyui.addArrayItem(_941.checkedRows,opts.idField,row);
}else{
if(row.checked){
$.easyui.addArrayItem(_941.tmpIds,row[opts.idField]);
}
}
row.checkState=flag?"checked":"unchecked";
}
cc.push("<span class=\"tree-checkbox tree-checkbox"+flag+"\"></span>");
}else{
row.checkState=undefined;
row.checked=undefined;
}
cc.push("<span class=\"tree-title\">"+val+"</span>");
}else{
cc.push(val);
}
}
cc.push("</div>");
cc.push("</td>");
}
}
return cc.join("");
},hasCheckbox:function(_944,row){
var opts=$.data(_944,"treegrid").options;
if(opts.checkbox){
if($.isFunction(opts.checkbox)){
if(opts.checkbox.call(_944,row)){
return true;
}else{
return false;
}
}else{
if(opts.onlyLeafCheck){
if(row.state=="open"&&!(row.children&&row.children.length)){
return true;
}
}else{
return true;
}
}
}
return false;
},refreshRow:function(_945,id){
this.updateRow.call(this,_945,id,{});
},updateRow:function(_946,id,row){
var opts=$.data(_946,"treegrid").options;
var _947=$(_946).treegrid("find",id);
$.extend(_947,row);
var _948=$(_946).treegrid("getLevel",id)-1;
var _949=opts.rowStyler?opts.rowStyler.call(_946,_947):"";
var _94a=$.data(_946,"datagrid").rowIdPrefix;
var _94b=_947[opts.idField];
function _94c(_94d){
var _94e=$(_946).treegrid("getColumnFields",_94d);
var tr=opts.finder.getTr(_946,id,"body",(_94d?1:2));
var _94f=tr.find("div.datagrid-cell-rownumber").html();
var _950=tr.find("div.datagrid-cell-check input[type=checkbox]").is(":checked");
tr.html(this.renderRow(_946,_94e,_94d,_948,_947));
tr.attr("style",_949||"");
tr.find("div.datagrid-cell-rownumber").html(_94f);
if(_950){
tr.find("div.datagrid-cell-check input[type=checkbox]")._propAttr("checked",true);
}
if(_94b!=id){
tr.attr("id",_94a+"-"+(_94d?1:2)+"-"+_94b);
tr.attr("node-id",_94b);
}
};
_94c.call(this,true);
_94c.call(this,false);
$(_946).treegrid("fixRowHeight",id);
},deleteRow:function(_951,id){
var opts=$.data(_951,"treegrid").options;
var tr=opts.finder.getTr(_951,id);
tr.next("tr.treegrid-tr-tree").remove();
tr.remove();
var _952=del(id);
if(_952){
if(_952.children.length==0){
tr=opts.finder.getTr(_951,_952[opts.idField]);
tr.next("tr.treegrid-tr-tree").remove();
var cell=tr.children("td[field=\""+opts.treeField+"\"]").children("div.datagrid-cell");
cell.find(".tree-icon").removeClass("tree-folder").addClass("tree-file");
cell.find(".tree-hit").remove();
$("<span class=\"tree-indent\"></span>").prependTo(cell);
}
}
function del(id){
var cc;
var _953=$(_951).treegrid("getParent",id);
if(_953){
cc=_953.children;
}else{
cc=$(_951).treegrid("getData");
}
for(var i=0;i<cc.length;i++){
if(cc[i][opts.idField]==id){
cc.splice(i,1);
break;
}
}
return _953;
};
},onBeforeRender:function(_954,_955,data){
if($.isArray(_955)){
data={total:_955.length,rows:_955};
_955=null;
}
if(!data){
return false;
}
var _956=$.data(_954,"treegrid");
var opts=_956.options;
if(data.length==undefined){
if(data.footer){
_956.footer=data.footer;
}
if(data.total){
_956.total=data.total;
}
data=this.transfer(_954,_955,data.rows);
}else{
function _957(_958,_959){
for(var i=0;i<_958.length;i++){
var row=_958[i];
row._parentId=_959;
if(row.children&&row.children.length){
_957(row.children,row[opts.idField]);
}
}
};
_957(data,_955);
}
var node=find(_954,_955);
if(node){
if(node.children){
node.children=node.children.concat(data);
}else{
node.children=data;
}
}else{
_956.data=_956.data.concat(data);
}
this.sort(_954,data);
this.treeNodes=data;
this.treeLevel=$(_954).treegrid("getLevel",_955);
},sort:function(_95a,data){
var opts=$.data(_95a,"treegrid").options;
if(!opts.remoteSort&&opts.sortName){
var _95b=opts.sortName.split(",");
var _95c=opts.sortOrder.split(",");
_95d(data);
}
function _95d(rows){
rows.sort(function(r1,r2){
var r=0;
for(var i=0;i<_95b.length;i++){
var sn=_95b[i];
var so=_95c[i];
var col=$(_95a).treegrid("getColumnOption",sn);
var _95e=col.sorter||function(a,b){
return a==b?0:(a>b?1:-1);
};
r=_95e(r1[sn],r2[sn])*(so=="asc"?1:-1);
if(r!=0){
return r;
}
}
return r;
});
for(var i=0;i<rows.length;i++){
var _95f=rows[i].children;
if(_95f&&_95f.length){
_95d(_95f);
}
}
};
},transfer:function(_960,_961,data){
var opts=$.data(_960,"treegrid").options;
var rows=$.extend([],data);
var _962=_963(_961,rows);
var toDo=$.extend([],_962);
while(toDo.length){
var node=toDo.shift();
var _964=_963(node[opts.idField],rows);
if(_964.length){
if(node.children){
node.children=node.children.concat(_964);
}else{
node.children=_964;
}
toDo=toDo.concat(_964);
}
}
return _962;
function _963(_965,rows){
var rr=[];
for(var i=0;i<rows.length;i++){
var row=rows[i];
if(row._parentId==_965){
rr.push(row);
rows.splice(i,1);
i--;
}
}
return rr;
};
}});
$.fn.treegrid.defaults=$.extend({},$.fn.datagrid.defaults,{treeField:null,checkbox:false,cascadeCheck:true,onlyLeafCheck:false,lines:false,animate:false,singleSelect:true,view:_928,rowEvents:$.extend({},$.fn.datagrid.defaults.rowEvents,{mouseover:_8a1(true),mouseout:_8a1(false),click:_8a3}),loader:function(_966,_967,_968){
var opts=$(this).treegrid("options");
if(!opts.url){
return false;
}
$.ajax({type:opts.method,url:opts.url,data:_966,dataType:"json",success:function(data){
_967(data);
},error:function(){
_968.apply(this,arguments);
}});
},loadFilter:function(data,_969){
return data;
},finder:{getTr:function(_96a,id,type,_96b){
type=type||"body";
_96b=_96b||0;
var dc=$.data(_96a,"datagrid").dc;
if(_96b==0){
var opts=$.data(_96a,"treegrid").options;
var tr1=opts.finder.getTr(_96a,id,type,1);
var tr2=opts.finder.getTr(_96a,id,type,2);
return tr1.add(tr2);
}else{
if(type=="body"){
var tr=$("#"+$.data(_96a,"datagrid").rowIdPrefix+"-"+_96b+"-"+id);
if(!tr.length){
tr=(_96b==1?dc.body1:dc.body2).find("tr[node-id=\""+id+"\"]");
}
return tr;
}else{
if(type=="footer"){
return (_96b==1?dc.footer1:dc.footer2).find("tr[node-id=\""+id+"\"]");
}else{
if(type=="selected"){
return (_96b==1?dc.body1:dc.body2).find("tr.datagrid-row-selected");
}else{
if(type=="highlight"){
return (_96b==1?dc.body1:dc.body2).find("tr.datagrid-row-over");
}else{
if(type=="checked"){
return (_96b==1?dc.body1:dc.body2).find("tr.datagrid-row-checked");
}else{
if(type=="last"){
return (_96b==1?dc.body1:dc.body2).find("tr:last[node-id]");
}else{
if(type=="allbody"){
return (_96b==1?dc.body1:dc.body2).find("tr[node-id]");
}else{
if(type=="allfooter"){
return (_96b==1?dc.footer1:dc.footer2).find("tr[node-id]");
}
}
}
}
}
}
}
}
}
},getRow:function(_96c,p){
var id=(typeof p=="object")?p.attr("node-id"):p;
return $(_96c).treegrid("find",id);
},getRows:function(_96d){
return $(_96d).treegrid("getChildren");
}},onBeforeLoad:function(row,_96e){
},onLoadSuccess:function(row,data){
},onLoadError:function(){
},onBeforeCollapse:function(row){
},onCollapse:function(row){
},onBeforeExpand:function(row){
},onExpand:function(row){
},onClickRow:function(row){
},onDblClickRow:function(row){
},onClickCell:function(_96f,row){
},onDblClickCell:function(_970,row){
},onContextMenu:function(e,row){
},onBeforeEdit:function(row){
},onAfterEdit:function(row,_971){
},onCancelEdit:function(row){
},onBeforeCheckNode:function(row,_972){
},onCheckNode:function(row,_973){
},});
})(jQuery);
(function($){
function _974(_975){
var opts=$.data(_975,"datalist").options;
$(_975).datagrid($.extend({},opts,{cls:"datalist"+(opts.lines?" datalist-lines":""),frozenColumns:(opts.frozenColumns&&opts.frozenColumns.length)?opts.frozenColumns:(opts.checkbox?[[{field:"_ck",checkbox:true}]]:undefined),columns:(opts.columns&&opts.columns.length)?opts.columns:[[{field:opts.textField,width:"100%",formatter:function(_976,row,_977){
return opts.textFormatter?opts.textFormatter(_976,row,_977):_976;
}}]]}));
};
var _978=$.extend({},$.fn.datagrid.defaults.view,{render:function(_979,_97a,_97b){
var _97c=$.data(_979,"datagrid");
var opts=_97c.options;
if(opts.groupField){
var g=this.groupRows(_979,_97c.data.rows);
this.groups=g.groups;
_97c.data.rows=g.rows;
var _97d=[];
for(var i=0;i<g.groups.length;i++){
_97d.push(this.renderGroup.call(this,_979,i,g.groups[i],_97b));
}
$(_97a).html(_97d.join(""));
}else{
$(_97a).html(this.renderTable(_979,0,_97c.data.rows,_97b));
}
},renderGroup:function(_97e,_97f,_980,_981){
var _982=$.data(_97e,"datagrid");
var opts=_982.options;
var _983=$(_97e).datagrid("getColumnFields",_981);
var _984=[];
_984.push("<div class=\"datagrid-group\" group-index="+_97f+">");
if(!_981){
_984.push("<span class=\"datagrid-group-title\">");
_984.push(opts.groupFormatter.call(_97e,_980.value,_980.rows));
_984.push("</span>");
}
_984.push("</div>");
_984.push(this.renderTable(_97e,_980.startIndex,_980.rows,_981));
return _984.join("");
},groupRows:function(_985,rows){
var _986=$.data(_985,"datagrid");
var opts=_986.options;
var _987=[];
for(var i=0;i<rows.length;i++){
var row=rows[i];
var _988=_989(row[opts.groupField]);
if(!_988){
_988={value:row[opts.groupField],rows:[row]};
_987.push(_988);
}else{
_988.rows.push(row);
}
}
var _98a=0;
var rows=[];
for(var i=0;i<_987.length;i++){
var _988=_987[i];
_988.startIndex=_98a;
_98a+=_988.rows.length;
rows=rows.concat(_988.rows);
}
return {groups:_987,rows:rows};
function _989(_98b){
for(var i=0;i<_987.length;i++){
var _98c=_987[i];
if(_98c.value==_98b){
return _98c;
}
}
return null;
};
}});
$.fn.datalist=function(_98d,_98e){
if(typeof _98d=="string"){
var _98f=$.fn.datalist.methods[_98d];
if(_98f){
return _98f(this,_98e);
}else{
return this.datagrid(_98d,_98e);
}
}
_98d=_98d||{};
return this.each(function(){
var _990=$.data(this,"datalist");
if(_990){
$.extend(_990.options,_98d);
}else{
var opts=$.extend({},$.fn.datalist.defaults,$.fn.datalist.parseOptions(this),_98d);
opts.columns=$.extend(true,[],opts.columns);
_990=$.data(this,"datalist",{options:opts});
}
_974(this);
if(!_990.options.data){
var data=$.fn.datalist.parseData(this);
if(data.total){
$(this).datalist("loadData",data);
}
}
});
};
$.fn.datalist.methods={options:function(jq){
return $.data(jq[0],"datalist").options;
}};
$.fn.datalist.parseOptions=function(_991){
return $.extend({},$.fn.datagrid.parseOptions(_991),$.parser.parseOptions(_991,["valueField","textField","groupField",{checkbox:"boolean",lines:"boolean"}]));
};
$.fn.datalist.parseData=function(_992){
var opts=$.data(_992,"datalist").options;
var data={total:0,rows:[]};
$(_992).children().each(function(){
var _993=$.parser.parseOptions(this,["value","group"]);
var row={};
var html=$(this).html();
row[opts.valueField]=_993.value!=undefined?_993.value:html;
row[opts.textField]=html;
if(opts.groupField){
row[opts.groupField]=_993.group;
}
data.total++;
data.rows.push(row);
});
return data;
};
$.fn.datalist.defaults=$.extend({},$.fn.datagrid.defaults,{fitColumns:true,singleSelect:true,showHeader:false,checkbox:false,lines:false,valueField:"value",textField:"text",groupField:"",view:_978,textFormatter:function(_994,row){
return _994;
},groupFormatter:function(_995,rows){
return _995;
}});
})(jQuery);
(function($){
$(function(){
$(document).unbind(".combo").bind("mousedown.combo mousewheel.combo",function(e){
var p=$(e.target).closest("span.combo,div.combo-p,div.menu");
if(p.length){
_996(p);
return;
}
$("body>div.combo-p>div.combo-panel:visible").panel("close");
});
});
function _997(_998){
var _999=$.data(_998,"combo");
var opts=_999.options;
if(!_999.panel){
_999.panel=$("<div class=\"combo-panel\"></div>").appendTo("body");
_999.panel.panel({minWidth:opts.panelMinWidth,maxWidth:opts.panelMaxWidth,minHeight:opts.panelMinHeight,maxHeight:opts.panelMaxHeight,doSize:false,closed:true,cls:"combo-p",style:{position:"absolute",zIndex:10},onOpen:function(){
var _99a=$(this).panel("options").comboTarget;
var _99b=$.data(_99a,"combo");
if(_99b){
_99b.options.onShowPanel.call(_99a);
}
},onBeforeClose:function(){
_996(this);
},onClose:function(){
var _99c=$(this).panel("options").comboTarget;
var _99d=$(_99c).data("combo");
if(_99d){
_99d.options.onHidePanel.call(_99c);
}
}});
}
var _99e=$.extend(true,[],opts.icons);
if(opts.hasDownArrow){
_99e.push({iconCls:"combo-arrow",handler:function(e){
_9a2(e.data.target);
}});
}
$(_998).addClass("combo-f").textbox($.extend({},opts,{icons:_99e,onChange:function(){
}}));
$(_998).attr("comboName",$(_998).attr("textboxName"));
_999.combo=$(_998).next();
_999.combo.addClass("combo");
};
function _99f(_9a0){
var _9a1=$.data(_9a0,"combo");
var opts=_9a1.options;
var p=_9a1.panel;
if(p.is(":visible")){
p.panel("close");
}
if(!opts.cloned){
p.panel("destroy");
}
$(_9a0).textbox("destroy");
};
function _9a2(_9a3){
var _9a4=$.data(_9a3,"combo").panel;
if(_9a4.is(":visible")){
_9a5(_9a3);
}else{
var p=$(_9a3).closest("div.combo-panel");
$("div.combo-panel:visible").not(_9a4).not(p).panel("close");
$(_9a3).combo("showPanel");
}
$(_9a3).combo("textbox").focus();
};
function _996(_9a6){
$(_9a6).find(".combo-f").each(function(){
var p=$(this).combo("panel");
if(p.is(":visible")){
p.panel("close");
}
});
};
function _9a7(e){
var _9a8=e.data.target;
var _9a9=$.data(_9a8,"combo");
var opts=_9a9.options;
var _9aa=_9a9.panel;
if(!opts.editable){
_9a2(_9a8);
}else{
var p=$(_9a8).closest("div.combo-panel");
$("div.combo-panel:visible").not(_9aa).not(p).panel("close");
}
};
function _9ab(e){
var _9ac=e.data.target;
var t=$(_9ac);
var _9ad=t.data("combo");
var opts=t.combo("options");
switch(e.keyCode){
case 38:
opts.keyHandler.up.call(_9ac,e);
break;
case 40:
opts.keyHandler.down.call(_9ac,e);
break;
case 37:
opts.keyHandler.left.call(_9ac,e);
break;
case 39:
opts.keyHandler.right.call(_9ac,e);
break;
case 13:
e.preventDefault();
opts.keyHandler.enter.call(_9ac,e);
return false;
case 9:
case 27:
_9a5(_9ac);
break;
default:
if(opts.editable){
if(_9ad.timer){
clearTimeout(_9ad.timer);
}
_9ad.timer=setTimeout(function(){
var q=t.combo("getText");
if(_9ad.previousText!=q){
_9ad.previousText=q;
t.combo("showPanel");
opts.keyHandler.query.call(_9ac,q,e);
t.combo("validate");
}
},opts.delay);
}
}
};
function _9ae(_9af){
var _9b0=$.data(_9af,"combo");
var _9b1=_9b0.combo;
var _9b2=_9b0.panel;
var opts=$(_9af).combo("options");
var _9b3=_9b2.panel("options");
_9b3.comboTarget=_9af;
if(_9b3.closed){
_9b2.panel("panel").show().css({zIndex:($.fn.menu?$.fn.menu.defaults.zIndex++:($.fn.window?$.fn.window.defaults.zIndex++:99)),left:-999999});
_9b2.panel("resize",{width:(opts.panelWidth?opts.panelWidth:_9b1._outerWidth()),height:opts.panelHeight});
_9b2.panel("panel").hide();
_9b2.panel("open");
}
(function(){
if(_9b2.is(":visible")){
_9b2.panel("move",{left:_9b4(),top:_9b5()});
setTimeout(arguments.callee,200);
}
})();
function _9b4(){
var left=_9b1.offset().left;
if(opts.panelAlign=="right"){
left+=_9b1._outerWidth()-_9b2._outerWidth();
}
if(left+_9b2._outerWidth()>$(window)._outerWidth()+$(document).scrollLeft()){
left=$(window)._outerWidth()+$(document).scrollLeft()-_9b2._outerWidth();
}
if(left<0){
left=0;
}
return left;
};
function _9b5(){
var top=_9b1.offset().top+_9b1._outerHeight();
if(top+_9b2._outerHeight()>$(window)._outerHeight()+$(document).scrollTop()){
top=_9b1.offset().top-_9b2._outerHeight();
}
if(top<$(document).scrollTop()){
top=_9b1.offset().top+_9b1._outerHeight();
}
return top;
};
};
function _9a5(_9b6){
var _9b7=$.data(_9b6,"combo").panel;
_9b7.panel("close");
};
function _9b8(_9b9,text){
var _9ba=$.data(_9b9,"combo");
var _9bb=$(_9b9).textbox("getText");
if(_9bb!=text){
$(_9b9).textbox("setText",text);
_9ba.previousText=text;
}
};
function _9bc(_9bd){
var _9be=[];
var _9bf=$.data(_9bd,"combo").combo;
_9bf.find(".textbox-value").each(function(){
_9be.push($(this).val());
});
return _9be;
};
function _9c0(_9c1,_9c2){
var _9c3=$.data(_9c1,"combo");
var opts=_9c3.options;
var _9c4=_9c3.combo;
if(!$.isArray(_9c2)){
_9c2=_9c2.split(opts.separator);
}
var _9c5=_9bc(_9c1);
_9c4.find(".textbox-value").remove();
var name=$(_9c1).attr("textboxName")||"";
for(var i=0;i<_9c2.length;i++){
var _9c6=$("<input type=\"hidden\" class=\"textbox-value\">").appendTo(_9c4);
_9c6.attr("name",name);
if(opts.disabled){
_9c6.attr("disabled","disabled");
}
_9c6.val(_9c2[i]);
}
var _9c7=(function(){
if(_9c5.length!=_9c2.length){
return true;
}
var a1=$.extend(true,[],_9c5);
var a2=$.extend(true,[],_9c2);
a1.sort();
a2.sort();
for(var i=0;i<a1.length;i++){
if(a1[i]!=a2[i]){
return true;
}
}
return false;
})();
if(_9c7){
if(opts.multiple){
opts.onChange.call(_9c1,_9c2,_9c5);
}else{
opts.onChange.call(_9c1,_9c2[0],_9c5[0]);
}
$(_9c1).closest("form").trigger("_change",[_9c1]);
}
};
function _9c8(_9c9){
var _9ca=_9bc(_9c9);
return _9ca[0];
};
function _9cb(_9cc,_9cd){
_9c0(_9cc,[_9cd]);
};
function _9ce(_9cf){
var opts=$.data(_9cf,"combo").options;
var _9d0=opts.onChange;
opts.onChange=function(){
};
if(opts.multiple){
_9c0(_9cf,opts.value?opts.value:[]);
}else{
_9cb(_9cf,opts.value);
}
opts.onChange=_9d0;
};
$.fn.combo=function(_9d1,_9d2){
if(typeof _9d1=="string"){
var _9d3=$.fn.combo.methods[_9d1];
if(_9d3){
return _9d3(this,_9d2);
}else{
return this.textbox(_9d1,_9d2);
}
}
_9d1=_9d1||{};
return this.each(function(){
var _9d4=$.data(this,"combo");
if(_9d4){
$.extend(_9d4.options,_9d1);
if(_9d1.value!=undefined){
_9d4.options.originalValue=_9d1.value;
}
}else{
_9d4=$.data(this,"combo",{options:$.extend({},$.fn.combo.defaults,$.fn.combo.parseOptions(this),_9d1),previousText:""});
_9d4.options.originalValue=_9d4.options.value;
}
_997(this);
_9ce(this);
});
};
$.fn.combo.methods={options:function(jq){
var opts=jq.textbox("options");
return $.extend($.data(jq[0],"combo").options,{width:opts.width,height:opts.height,disabled:opts.disabled,readonly:opts.readonly});
},cloneFrom:function(jq,from){
return jq.each(function(){
$(this).textbox("cloneFrom",from);
$.data(this,"combo",{options:$.extend(true,{cloned:true},$(from).combo("options")),combo:$(this).next(),panel:$(from).combo("panel")});
$(this).addClass("combo-f").attr("comboName",$(this).attr("textboxName"));
});
},panel:function(jq){
return $.data(jq[0],"combo").panel;
},destroy:function(jq){
return jq.each(function(){
_99f(this);
});
},showPanel:function(jq){
return jq.each(function(){
_9ae(this);
});
},hidePanel:function(jq){
return jq.each(function(){
_9a5(this);
});
},clear:function(jq){
return jq.each(function(){
$(this).textbox("setText","");
var opts=$.data(this,"combo").options;
if(opts.multiple){
$(this).combo("setValues",[]);
}else{
$(this).combo("setValue","");
}
});
},reset:function(jq){
return jq.each(function(){
var opts=$.data(this,"combo").options;
if(opts.multiple){
$(this).combo("setValues",opts.originalValue);
}else{
$(this).combo("setValue",opts.originalValue);
}
});
},setText:function(jq,text){
return jq.each(function(){
_9b8(this,text);
});
},getValues:function(jq){
return _9bc(jq[0]);
},setValues:function(jq,_9d5){
return jq.each(function(){
_9c0(this,_9d5);
});
},getValue:function(jq){
return _9c8(jq[0]);
},setValue:function(jq,_9d6){
return jq.each(function(){
_9cb(this,_9d6);
});
}};
$.fn.combo.parseOptions=function(_9d7){
var t=$(_9d7);
return $.extend({},$.fn.textbox.parseOptions(_9d7),$.parser.parseOptions(_9d7,["separator","panelAlign",{panelWidth:"number",hasDownArrow:"boolean",delay:"number",selectOnNavigation:"boolean"},{panelMinWidth:"number",panelMaxWidth:"number",panelMinHeight:"number",panelMaxHeight:"number"}]),{panelHeight:(t.attr("panelHeight")=="auto"?"auto":parseInt(t.attr("panelHeight"))||undefined),multiple:(t.attr("multiple")?true:undefined)});
};
$.fn.combo.defaults=$.extend({},$.fn.textbox.defaults,{inputEvents:{click:_9a7,keydown:_9ab,paste:_9ab,drop:_9ab},panelWidth:null,panelHeight:200,panelMinWidth:null,panelMaxWidth:null,panelMinHeight:null,panelMaxHeight:null,panelAlign:"left",multiple:false,selectOnNavigation:true,separator:",",hasDownArrow:true,delay:200,keyHandler:{up:function(e){
},down:function(e){
},left:function(e){
},right:function(e){
},enter:function(e){
},query:function(q,e){
}},onShowPanel:function(){
},onHidePanel:function(){
},onChange:function(_9d8,_9d9){
}});
})(jQuery);
(function($){
function _9da(_9db,_9dc){
var _9dd=$.data(_9db,"combobox");
return $.easyui.indexOfArray(_9dd.data,_9dd.options.valueField,_9dc);
};
function _9de(_9df,_9e0){
var opts=$.data(_9df,"combobox").options;
var _9e1=$(_9df).combo("panel");
var item=opts.finder.getEl(_9df,_9e0);
if(item.length){
if(item.position().top<=0){
var h=_9e1.scrollTop()+item.position().top;
_9e1.scrollTop(h);
}else{
if(item.position().top+item.outerHeight()>_9e1.height()){
var h=_9e1.scrollTop()+item.position().top+item.outerHeight()-_9e1.height();
_9e1.scrollTop(h);
}
}
}
_9e1.triggerHandler("scroll");
};
function nav(_9e2,dir){
var opts=$.data(_9e2,"combobox").options;
var _9e3=$(_9e2).combobox("panel");
var item=_9e3.children("div.combobox-item-hover");
if(!item.length){
item=_9e3.children("div.combobox-item-selected");
}
item.removeClass("combobox-item-hover");
var _9e4="div.combobox-item:visible:not(.combobox-item-disabled):first";
var _9e5="div.combobox-item:visible:not(.combobox-item-disabled):last";
if(!item.length){
item=_9e3.children(dir=="next"?_9e4:_9e5);
}else{
if(dir=="next"){
item=item.nextAll(_9e4);
if(!item.length){
item=_9e3.children(_9e4);
}
}else{
item=item.prevAll(_9e4);
if(!item.length){
item=_9e3.children(_9e5);
}
}
}
if(item.length){
item.addClass("combobox-item-hover");
var row=opts.finder.getRow(_9e2,item);
if(row){
$(_9e2).combobox("scrollTo",row[opts.valueField]);
if(opts.selectOnNavigation){
_9e6(_9e2,row[opts.valueField]);
}
}
}
};
function _9e6(_9e7,_9e8,_9e9){
var opts=$.data(_9e7,"combobox").options;
var _9ea=$(_9e7).combo("getValues");
if($.inArray(_9e8+"",_9ea)==-1){
if(opts.multiple){
_9ea.push(_9e8);
}else{
_9ea=[_9e8];
}
_9eb(_9e7,_9ea,_9e9);
opts.onSelect.call(_9e7,opts.finder.getRow(_9e7,_9e8));
}
};
function _9ec(_9ed,_9ee){
var opts=$.data(_9ed,"combobox").options;
var _9ef=$(_9ed).combo("getValues");
var _9f0=$.inArray(_9ee+"",_9ef);
if(_9f0>=0){
_9ef.splice(_9f0,1);
_9eb(_9ed,_9ef);
opts.onUnselect.call(_9ed,opts.finder.getRow(_9ed,_9ee));
}
};
function _9eb(_9f1,_9f2,_9f3){
var opts=$.data(_9f1,"combobox").options;
var _9f4=$(_9f1).combo("panel");
if(!$.isArray(_9f2)){
_9f2=_9f2.split(opts.separator);
}
if(!opts.multiple){
_9f2=_9f2.length?[_9f2[0]]:[""];
}
_9f4.find("div.combobox-item-selected").removeClass("combobox-item-selected");
var _9f5=null;
var vv=[],ss=[];
for(var i=0;i<_9f2.length;i++){
var v=_9f2[i];
var s=v;
opts.finder.getEl(_9f1,v).addClass("combobox-item-selected");
var row=opts.finder.getRow(_9f1,v);
if(row){
s=row[opts.textField];
_9f5=row;
}
vv.push(v);
ss.push(s);
}
if(!_9f3){
$(_9f1).combo("setText",ss.join(opts.separator));
}
if(opts.showItemIcon){
var tb=$(_9f1).combobox("textbox");
tb.removeClass("textbox-bgicon "+opts.textboxIconCls);
if(_9f5&&_9f5.iconCls){
tb.addClass("textbox-bgicon "+_9f5.iconCls);
opts.textboxIconCls=_9f5.iconCls;
}
}
$(_9f1).combo("setValues",vv);
_9f4.triggerHandler("scroll");
};
function _9f6(_9f7,data,_9f8){
var _9f9=$.data(_9f7,"combobox");
var opts=_9f9.options;
_9f9.data=opts.loadFilter.call(_9f7,data);
opts.view.render.call(opts.view,_9f7,$(_9f7).combo("panel"),_9f9.data);
var vv=$(_9f7).combobox("getValues");
$.easyui.forEach(_9f9.data,false,function(row){
if(row["selected"]){
$.easyui.addArrayItem(vv,row[opts.valueField]+"");
}
});
if(opts.multiple){
_9eb(_9f7,vv,_9f8);
}else{
_9eb(_9f7,vv.length?[vv[vv.length-1]]:[],_9f8);
}
opts.onLoadSuccess.call(_9f7,data);
};
function _9fa(_9fb,url,_9fc,_9fd){
var opts=$.data(_9fb,"combobox").options;
if(url){
opts.url=url;
}
_9fc=$.extend({},opts.queryParams,_9fc||{});
if(opts.onBeforeLoad.call(_9fb,_9fc)==false){
return;
}
opts.loader.call(_9fb,_9fc,function(data){
_9f6(_9fb,data,_9fd);
},function(){
opts.onLoadError.apply(this,arguments);
});
};
function _9fe(_9ff,q){
var _a00=$.data(_9ff,"combobox");
var opts=_a00.options;
var qq=opts.multiple?q.split(opts.separator):[q];
if(opts.mode=="remote"){
_a01(qq);
_9fa(_9ff,null,{q:q},true);
}else{
var _a02=$(_9ff).combo("panel");
_a02.find("div.combobox-item-selected,div.combobox-item-hover").removeClass("combobox-item-selected combobox-item-hover");
_a02.find("div.combobox-item,div.combobox-group").hide();
var data=_a00.data;
var vv=[];
$.map(qq,function(q){
q=$.trim(q);
var _a03=q;
var _a04=undefined;
for(var i=0;i<data.length;i++){
var row=data[i];
if(opts.filter.call(_9ff,q,row)){
var v=row[opts.valueField];
var s=row[opts.textField];
var g=row[opts.groupField];
var item=opts.finder.getEl(_9ff,v).show();
if(s.toLowerCase()==q.toLowerCase()){
_a03=v;
_9e6(_9ff,v,true);
}
if(opts.groupField&&_a04!=g){
opts.finder.getGroupEl(_9ff,g).show();
_a04=g;
}
}
}
vv.push(_a03);
});
_a01(vv);
}
function _a01(vv){
_9eb(_9ff,opts.multiple?(q?vv:[]):vv,true);
};
};
function _a05(_a06){
var t=$(_a06);
var opts=t.combobox("options");
var _a07=t.combobox("panel");
var item=_a07.children("div.combobox-item-hover");
if(item.length){
var row=opts.finder.getRow(_a06,item);
var _a08=row[opts.valueField];
if(opts.multiple){
if(item.hasClass("combobox-item-selected")){
t.combobox("unselect",_a08);
}else{
t.combobox("select",_a08);
}
}else{
t.combobox("select",_a08);
}
}
var vv=[];
$.map(t.combobox("getValues"),function(v){
if(_9da(_a06,v)>=0){
vv.push(v);
}
});
t.combobox("setValues",vv);
if(!opts.multiple){
t.combobox("hidePanel");
}
};
function _a09(_a0a){
var _a0b=$.data(_a0a,"combobox");
var opts=_a0b.options;
$(_a0a).addClass("combobox-f");
$(_a0a).combo($.extend({},opts,{onShowPanel:function(){
$(this).combo("panel").find("div.combobox-item:hidden,div.combobox-group:hidden").show();
_9eb(this,$(this).combobox("getValues"),true);
$(this).combobox("scrollTo",$(this).combobox("getValue"));
opts.onShowPanel.call(this);
}}));
$(_a0a).combo("panel").unbind().bind("mouseover",function(e){
$(this).children("div.combobox-item-hover").removeClass("combobox-item-hover");
var item=$(e.target).closest("div.combobox-item");
if(!item.hasClass("combobox-item-disabled")){
item.addClass("combobox-item-hover");
}
e.stopPropagation();
}).bind("mouseout",function(e){
$(e.target).closest("div.combobox-item").removeClass("combobox-item-hover");
e.stopPropagation();
}).bind("click",function(e){
var _a0c=$(this).panel("options").comboTarget;
var item=$(e.target).closest("div.combobox-item");
if(!item.length||item.hasClass("combobox-item-disabled")){
return;
}
var row=opts.finder.getRow(_a0c,item);
if(!row){
return;
}
var _a0d=row[opts.valueField];
if(opts.multiple){
if(item.hasClass("combobox-item-selected")){
_9ec(_a0c,_a0d);
}else{
_9e6(_a0c,_a0d);
}
}else{
_9e6(_a0c,_a0d);
$(_a0c).combo("hidePanel");
}
e.stopPropagation();
}).bind("scroll",function(){
if(opts.groupPosition=="sticky"){
var _a0e=$(this).panel("options").comboTarget;
var _a0f=$(this).children(".combobox-stick");
if(!_a0f.length){
_a0f=$("<div class=\"combobox-stick\"></div>").appendTo(this);
}
_a0f.hide();
$(this).children(".combobox-group:visible").each(function(){
var g=$(this);
var _a10=opts.finder.getGroup(_a0e,g);
var _a11=_a0b.data[_a10.startIndex+_a10.count-1];
var last=opts.finder.getEl(_a0e,_a11[opts.valueField]);
if(g.position().top<0&&last.position().top>0){
_a0f.show().html(g.html());
return false;
}
});
}
});
};
$.fn.combobox=function(_a12,_a13){
if(typeof _a12=="string"){
var _a14=$.fn.combobox.methods[_a12];
if(_a14){
return _a14(this,_a13);
}else{
return this.combo(_a12,_a13);
}
}
_a12=_a12||{};
return this.each(function(){
var _a15=$.data(this,"combobox");
if(_a15){
$.extend(_a15.options,_a12);
}else{
_a15=$.data(this,"combobox",{options:$.extend({},$.fn.combobox.defaults,$.fn.combobox.parseOptions(this),_a12),data:[]});
}
_a09(this);
if(_a15.options.data){
_9f6(this,_a15.options.data);
}else{
var data=$.fn.combobox.parseData(this);
if(data.length){
_9f6(this,data);
}
}
_9fa(this);
});
};
$.fn.combobox.methods={options:function(jq){
var _a16=jq.combo("options");
return $.extend($.data(jq[0],"combobox").options,{width:_a16.width,height:_a16.height,originalValue:_a16.originalValue,disabled:_a16.disabled,readonly:_a16.readonly});
},cloneFrom:function(jq,from){
return jq.each(function(){
$(this).combo("cloneFrom",from);
$.data(this,"combobox",$(from).data("combobox"));
$(this).addClass("combobox-f").attr("comboboxName",$(this).attr("textboxName"));
});
},getData:function(jq){
return $.data(jq[0],"combobox").data;
},setValues:function(jq,_a17){
return jq.each(function(){
_9eb(this,_a17);
});
},setValue:function(jq,_a18){
return jq.each(function(){
_9eb(this,$.isArray(_a18)?_a18:[_a18]);
});
},clear:function(jq){
return jq.each(function(){
$(this).combo("clear");
var _a19=$(this).combo("panel");
_a19.find("div.combobox-item-selected").removeClass("combobox-item-selected");
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).combobox("options");
if(opts.multiple){
$(this).combobox("setValues",opts.originalValue);
}else{
$(this).combobox("setValue",opts.originalValue);
}
});
},loadData:function(jq,data){
return jq.each(function(){
_9f6(this,data);
});
},reload:function(jq,url){
return jq.each(function(){
if(typeof url=="string"){
_9fa(this,url);
}else{
if(url){
var opts=$(this).combobox("options");
opts.queryParams=url;
}
_9fa(this);
}
});
},select:function(jq,_a1a){
return jq.each(function(){
_9e6(this,_a1a);
});
},unselect:function(jq,_a1b){
return jq.each(function(){
_9ec(this,_a1b);
});
},scrollTo:function(jq,_a1c){
return jq.each(function(){
_9de(this,_a1c);
});
}};
$.fn.combobox.parseOptions=function(_a1d){
var t=$(_a1d);
return $.extend({},$.fn.combo.parseOptions(_a1d),$.parser.parseOptions(_a1d,["valueField","textField","groupField","groupPosition","mode","method","url",{showItemIcon:"boolean"}]));
};
$.fn.combobox.parseData=function(_a1e){
var data=[];
var opts=$(_a1e).combobox("options");
$(_a1e).children().each(function(){
if(this.tagName.toLowerCase()=="optgroup"){
var _a1f=$(this).attr("label");
$(this).children().each(function(){
_a20(this,_a1f);
});
}else{
_a20(this);
}
});
return data;
function _a20(el,_a21){
var t=$(el);
var row={};
row[opts.valueField]=t.attr("value")!=undefined?t.attr("value"):t.text();
row[opts.textField]=t.text();
row["selected"]=t.is(":selected");
row["disabled"]=t.is(":disabled");
if(_a21){
opts.groupField=opts.groupField||"group";
row[opts.groupField]=_a21;
}
data.push(row);
};
};
var _a22=0;
var _a23={render:function(_a24,_a25,data){
var _a26=$.data(_a24,"combobox");
var opts=_a26.options;
_a22++;
_a26.itemIdPrefix="_easyui_combobox_i"+_a22;
_a26.groupIdPrefix="_easyui_combobox_g"+_a22;
_a26.groups=[];
var dd=[];
var _a27=undefined;
for(var i=0;i<data.length;i++){
var row=data[i];
var v=row[opts.valueField]+"";
var s=row[opts.textField];
var g=row[opts.groupField];
if(g){
if(_a27!=g){
_a27=g;
_a26.groups.push({value:g,startIndex:i,count:1});
dd.push("<div id=\""+(_a26.groupIdPrefix+"_"+(_a26.groups.length-1))+"\" class=\"combobox-group\">");
dd.push(opts.groupFormatter?opts.groupFormatter.call(_a24,g):g);
dd.push("</div>");
}else{
_a26.groups[_a26.groups.length-1].count++;
}
}else{
_a27=undefined;
}
var cls="combobox-item"+(row.disabled?" combobox-item-disabled":"")+(g?" combobox-gitem":"");
dd.push("<div id=\""+(_a26.itemIdPrefix+"_"+i)+"\" class=\""+cls+"\">");
if(opts.showItemIcon&&row.iconCls){
dd.push("<span class=\"combobox-icon "+row.iconCls+"\"></span>");
}
dd.push(opts.formatter?opts.formatter.call(_a24,row):s);
dd.push("</div>");
}
$(_a25).html(dd.join(""));
}};
$.fn.combobox.defaults=$.extend({},$.fn.combo.defaults,{valueField:"value",textField:"text",groupPosition:"static",groupField:null,groupFormatter:function(_a28){
return _a28;
},mode:"local",method:"post",url:null,data:null,queryParams:{},showItemIcon:false,view:_a23,keyHandler:{up:function(e){
nav(this,"prev");
e.preventDefault();
},down:function(e){
nav(this,"next");
e.preventDefault();
},left:function(e){
},right:function(e){
},enter:function(e){
_a05(this);
},query:function(q,e){
_9fe(this,q);
}},filter:function(q,row){
var opts=$(this).combobox("options");
return row[opts.textField].toLowerCase().indexOf(q.toLowerCase())>=0;
},formatter:function(row){
var opts=$(this).combobox("options");
return row[opts.textField];
},loader:function(_a29,_a2a,_a2b){
var opts=$(this).combobox("options");
if(!opts.url){
return false;
}
$.ajax({type:opts.method,url:opts.url,data:_a29,dataType:"json",success:function(data){
_a2a(data);
},error:function(){
_a2b.apply(this,arguments);
}});
},loadFilter:function(data){
return data;
},finder:{getEl:function(_a2c,_a2d){
var _a2e=_9da(_a2c,_a2d);
var id=$.data(_a2c,"combobox").itemIdPrefix+"_"+_a2e;
return $("#"+id);
},getGroupEl:function(_a2f,_a30){
var _a31=$.data(_a2f,"combobox");
var _a32=$.easyui.indexOfArray(_a31.groups,"value",_a30);
var id=_a31.groupIdPrefix+"_"+_a32;
return $("#"+id);
},getGroup:function(_a33,p){
var _a34=$.data(_a33,"combobox");
var _a35=p.attr("id").substr(_a34.groupIdPrefix.length+1);
return _a34.groups[parseInt(_a35)];
},getRow:function(_a36,p){
var _a37=$.data(_a36,"combobox");
var _a38=(p instanceof $)?p.attr("id").substr(_a37.itemIdPrefix.length+1):_9da(_a36,p);
return _a37.data[parseInt(_a38)];
}},onBeforeLoad:function(_a39){
},onLoadSuccess:function(){
},onLoadError:function(){
},onSelect:function(_a3a){
},onUnselect:function(_a3b){
}});
})(jQuery);
(function($){
function _a3c(_a3d){
var _a3e=$.data(_a3d,"combotree");
var opts=_a3e.options;
var tree=_a3e.tree;
$(_a3d).addClass("combotree-f");
$(_a3d).combo($.extend({},opts,{onShowPanel:function(){
if(opts.editable){
tree.tree("doFilter","");
}
opts.onShowPanel.call(this);
}}));
var _a3f=$(_a3d).combo("panel");
if(!tree){
tree=$("<ul></ul>").appendTo(_a3f);
_a3e.tree=tree;
}
tree.tree($.extend({},opts,{checkbox:opts.multiple,onLoadSuccess:function(node,data){
var _a40=$(_a3d).combotree("getValues");
if(opts.multiple){
$.map(tree.tree("getChecked"),function(node){
$.easyui.addArrayItem(_a40,node.id);
});
}
_a45(_a3d,_a40,_a3e.remainText);
opts.onLoadSuccess.call(this,node,data);
},onClick:function(node){
if(opts.multiple){
$(this).tree(node.checked?"uncheck":"check",node.target);
}else{
$(_a3d).combo("hidePanel");
}
_a3e.remainText=false;
_a42(_a3d);
opts.onClick.call(this,node);
},onCheck:function(node,_a41){
_a3e.remainText=false;
_a42(_a3d);
opts.onCheck.call(this,node,_a41);
}}));
};
function _a42(_a43){
var _a44=$.data(_a43,"combotree");
var opts=_a44.options;
var tree=_a44.tree;
var vv=[];
if(opts.multiple){
vv=$.map(tree.tree("getChecked"),function(node){
return node.id;
});
}else{
var node=tree.tree("getSelected");
if(node){
vv.push(node.id);
}
}
vv=vv.concat(opts.unselectedValues);
_a45(_a43,vv,_a44.remainText);
};
function _a45(_a46,_a47,_a48){
var _a49=$.data(_a46,"combotree");
var opts=_a49.options;
var tree=_a49.tree;
var _a4a=tree.tree("options");
var _a4b=_a4a.onBeforeCheck;
var _a4c=_a4a.onCheck;
var _a4d=_a4a.onSelect;
_a4a.onBeforeCheck=_a4a.onCheck=_a4a.onSelect=function(){
};
if(!$.isArray(_a47)){
_a47=_a47.split(opts.separator);
}
if(!opts.multiple){
_a47=_a47.length?[_a47[0]]:[""];
}
var vv=$.map(_a47,function(_a4e){
return String(_a4e);
});
tree.find("div.tree-node-selected").removeClass("tree-node-selected");
$.map(tree.tree("getChecked"),function(node){
if($.inArray(String(node.id),vv)==-1){
tree.tree("uncheck",node.target);
}
});
var ss=[];
opts.unselectedValues=[];
$.map(vv,function(v){
var node=tree.tree("find",v);
if(node){
tree.tree("check",node.target).tree("select",node.target);
ss.push(node.text);
}else{
ss.push(_a4f(v,opts.mappingRows)||v);
opts.unselectedValues.push(v);
}
});
if(opts.multiple){
$.map(tree.tree("getChecked"),function(node){
var id=String(node.id);
if($.inArray(id,vv)==-1){
vv.push(id);
ss.push(node.text);
}
});
}
_a4a.onBeforeCheck=_a4b;
_a4a.onCheck=_a4c;
_a4a.onSelect=_a4d;
if(!_a48){
var s=ss.join(opts.separator);
if($(_a46).combo("getText")!=s){
$(_a46).combo("setText",s);
}
}
$(_a46).combo("setValues",vv);
function _a4f(_a50,a){
var item=$.easyui.getArrayItem(a,"id",_a50);
return item?item.text:undefined;
};
};
function _a51(_a52,q){
var _a53=$.data(_a52,"combotree");
var opts=_a53.options;
var tree=_a53.tree;
_a53.remainText=true;
tree.tree("doFilter",opts.multiple?q.split(opts.separator):q);
};
function _a54(_a55){
var _a56=$.data(_a55,"combotree");
_a56.remainText=false;
$(_a55).combotree("setValues",$(_a55).combotree("getValues"));
$(_a55).combotree("hidePanel");
};
$.fn.combotree=function(_a57,_a58){
if(typeof _a57=="string"){
var _a59=$.fn.combotree.methods[_a57];
if(_a59){
return _a59(this,_a58);
}else{
return this.combo(_a57,_a58);
}
}
_a57=_a57||{};
return this.each(function(){
var _a5a=$.data(this,"combotree");
if(_a5a){
$.extend(_a5a.options,_a57);
}else{
$.data(this,"combotree",{options:$.extend({},$.fn.combotree.defaults,$.fn.combotree.parseOptions(this),_a57)});
}
_a3c(this);
});
};
$.fn.combotree.methods={options:function(jq){
var _a5b=jq.combo("options");
return $.extend($.data(jq[0],"combotree").options,{width:_a5b.width,height:_a5b.height,originalValue:_a5b.originalValue,disabled:_a5b.disabled,readonly:_a5b.readonly});
},clone:function(jq,_a5c){
var t=jq.combo("clone",_a5c);
t.data("combotree",{options:$.extend(true,{},jq.combotree("options")),tree:jq.combotree("tree")});
return t;
},tree:function(jq){
return $.data(jq[0],"combotree").tree;
},loadData:function(jq,data){
return jq.each(function(){
var opts=$.data(this,"combotree").options;
opts.data=data;
var tree=$.data(this,"combotree").tree;
tree.tree("loadData",data);
});
},reload:function(jq,url){
return jq.each(function(){
var opts=$.data(this,"combotree").options;
var tree=$.data(this,"combotree").tree;
if(url){
opts.url=url;
}
tree.tree({url:opts.url});
});
},setValues:function(jq,_a5d){
return jq.each(function(){
var opts=$(this).combotree("options");
if($.isArray(_a5d)){
_a5d=$.map(_a5d,function(_a5e){
if(_a5e&&typeof _a5e=="object"){
$.easyui.addArrayItem(opts.mappingRows,"id",_a5e);
return _a5e.id;
}else{
return _a5e;
}
});
}
_a45(this,_a5d);
});
},setValue:function(jq,_a5f){
return jq.each(function(){
$(this).combotree("setValues",$.isArray(_a5f)?_a5f:[_a5f]);
});
},clear:function(jq){
return jq.each(function(){
$(this).combotree("setValues",[]);
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).combotree("options");
if(opts.multiple){
$(this).combotree("setValues",opts.originalValue);
}else{
$(this).combotree("setValue",opts.originalValue);
}
});
}};
$.fn.combotree.parseOptions=function(_a60){
return $.extend({},$.fn.combo.parseOptions(_a60),$.fn.tree.parseOptions(_a60));
};
$.fn.combotree.defaults=$.extend({},$.fn.combo.defaults,$.fn.tree.defaults,{editable:false,unselectedValues:[],mappingRows:[],keyHandler:{up:function(e){
},down:function(e){
},left:function(e){
},right:function(e){
},enter:function(e){
_a54(this);
},query:function(q,e){
_a51(this,q);
}}});
})(jQuery);
(function($){
function _a61(_a62){
var _a63=$.data(_a62,"combogrid");
var opts=_a63.options;
var grid=_a63.grid;
$(_a62).addClass("combogrid-f").combo($.extend({},opts,{onShowPanel:function(){
var p=$(this).combogrid("panel");
var _a64=p.outerHeight()-p.height();
var _a65=p._size("minHeight");
var _a66=p._size("maxHeight");
var dg=$(this).combogrid("grid");
dg.datagrid("resize",{width:"100%",height:(isNaN(parseInt(opts.panelHeight))?"auto":"100%"),minHeight:(_a65?_a65-_a64:""),maxHeight:(_a66?_a66-_a64:"")});
var row=dg.datagrid("getSelected");
if(row){
dg.datagrid("scrollTo",dg.datagrid("getRowIndex",row));
}
opts.onShowPanel.call(this);
}}));
var _a67=$(_a62).combo("panel");
if(!grid){
grid=$("<table></table>").appendTo(_a67);
_a63.grid=grid;
}
grid.datagrid($.extend({},opts,{border:false,singleSelect:(!opts.multiple),onLoadSuccess:function(data){
var _a68=$(_a62).combo("getValues");
var _a69=opts.onSelect;
opts.onSelect=function(){
};
_a6f(_a62,_a68,_a63.remainText);
opts.onSelect=_a69;
opts.onLoadSuccess.apply(_a62,arguments);
},onClickRow:_a6a,onSelect:function(_a6b,row){
_a6c();
opts.onSelect.call(this,_a6b,row);
},onUnselect:function(_a6d,row){
_a6c();
opts.onUnselect.call(this,_a6d,row);
},onSelectAll:function(rows){
_a6c();
opts.onSelectAll.call(this,rows);
},onUnselectAll:function(rows){
if(opts.multiple){
_a6c();
}
opts.onUnselectAll.call(this,rows);
}}));
function _a6a(_a6e,row){
_a63.remainText=false;
_a6c();
if(!opts.multiple){
$(_a62).combo("hidePanel");
}
opts.onClickRow.call(this,_a6e,row);
};
function _a6c(){
var vv=$.map(grid.datagrid("getSelections"),function(row){
return row[opts.idField];
});
vv=vv.concat(opts.unselectedValues);
_a6f(_a62,vv,_a63.remainText);
};
};
function nav(_a70,dir){
var _a71=$.data(_a70,"combogrid");
var opts=_a71.options;
var grid=_a71.grid;
var _a72=grid.datagrid("getRows").length;
if(!_a72){
return;
}
var tr=opts.finder.getTr(grid[0],null,"highlight");
if(!tr.length){
tr=opts.finder.getTr(grid[0],null,"selected");
}
var _a73;
if(!tr.length){
_a73=(dir=="next"?0:_a72-1);
}else{
var _a73=parseInt(tr.attr("datagrid-row-index"));
_a73+=(dir=="next"?1:-1);
if(_a73<0){
_a73=_a72-1;
}
if(_a73>=_a72){
_a73=0;
}
}
grid.datagrid("highlightRow",_a73);
if(opts.selectOnNavigation){
_a71.remainText=false;
grid.datagrid("selectRow",_a73);
}
};
function _a6f(_a74,_a75,_a76){
var _a77=$.data(_a74,"combogrid");
var opts=_a77.options;
var grid=_a77.grid;
var _a78=$(_a74).combo("getValues");
var _a79=$(_a74).combo("options");
var _a7a=_a79.onChange;
_a79.onChange=function(){
};
var _a7b=grid.datagrid("options");
var _a7c=_a7b.onSelect;
var _a7d=_a7b.onUnselectAll;
_a7b.onSelect=_a7b.onUnselectAll=function(){
};
if(!$.isArray(_a75)){
_a75=_a75.split(opts.separator);
}
if(!opts.multiple){
_a75=_a75.length?[_a75[0]]:[""];
}
var vv=$.map(_a75,function(_a7e){
return String(_a7e);
});
vv=$.grep(vv,function(v,_a7f){
return _a7f===$.inArray(v,vv);
});
var _a80=$.grep(grid.datagrid("getSelections"),function(row,_a81){
return $.inArray(String(row[opts.idField]),vv)>=0;
});
grid.datagrid("clearSelections");
grid.data("datagrid").selectedRows=_a80;
var ss=[];
opts.unselectedValues=[];
$.map(vv,function(v){
var _a82=grid.datagrid("getRowIndex",v);
if(_a82>=0){
grid.datagrid("selectRow",_a82);
}else{
opts.unselectedValues.push(v);
}
ss.push(_a83(v,grid.datagrid("getRows"))||_a83(v,_a80)||_a83(v,opts.mappingRows)||v);
});
$(_a74).combo("setValues",_a78);
_a79.onChange=_a7a;
_a7b.onSelect=_a7c;
_a7b.onUnselectAll=_a7d;
if(!_a76){
var s=ss.join(opts.separator);
if($(_a74).combo("getText")!=s){
$(_a74).combo("setText",s);
}
}
$(_a74).combo("setValues",_a75);
function _a83(_a84,a){
var item=$.easyui.getArrayItem(a,opts.idField,_a84);
return item?item[opts.textField]:undefined;
};
};
function _a85(_a86,q){
var _a87=$.data(_a86,"combogrid");
var opts=_a87.options;
var grid=_a87.grid;
_a87.remainText=true;
if(opts.multiple&&!q){
_a6f(_a86,[],true);
}else{
_a6f(_a86,[q],true);
}
if(opts.mode=="remote"){
grid.datagrid("clearSelections");
grid.datagrid("load",$.extend({},opts.queryParams,{q:q}));
}else{
if(!q){
return;
}
grid.datagrid("clearSelections").datagrid("highlightRow",-1);
var rows=grid.datagrid("getRows");
var qq=opts.multiple?q.split(opts.separator):[q];
$.map(qq,function(q){
q=$.trim(q);
if(q){
$.map(rows,function(row,i){
if(q==row[opts.textField]){
grid.datagrid("selectRow",i);
}else{
if(opts.filter.call(_a86,q,row)){
grid.datagrid("highlightRow",i);
}
}
});
}
});
}
};
function _a88(_a89){
var _a8a=$.data(_a89,"combogrid");
var opts=_a8a.options;
var grid=_a8a.grid;
var tr=opts.finder.getTr(grid[0],null,"highlight");
_a8a.remainText=false;
if(tr.length){
var _a8b=parseInt(tr.attr("datagrid-row-index"));
if(opts.multiple){
if(tr.hasClass("datagrid-row-selected")){
grid.datagrid("unselectRow",_a8b);
}else{
grid.datagrid("selectRow",_a8b);
}
}else{
grid.datagrid("selectRow",_a8b);
}
}
var vv=[];
$.map(grid.datagrid("getSelections"),function(row){
vv.push(row[opts.idField]);
});
$(_a89).combogrid("setValues",vv);
if(!opts.multiple){
$(_a89).combogrid("hidePanel");
}
};
$.fn.combogrid=function(_a8c,_a8d){
if(typeof _a8c=="string"){
var _a8e=$.fn.combogrid.methods[_a8c];
if(_a8e){
return _a8e(this,_a8d);
}else{
return this.combo(_a8c,_a8d);
}
}
_a8c=_a8c||{};
return this.each(function(){
var _a8f=$.data(this,"combogrid");
if(_a8f){
$.extend(_a8f.options,_a8c);
}else{
_a8f=$.data(this,"combogrid",{options:$.extend({},$.fn.combogrid.defaults,$.fn.combogrid.parseOptions(this),_a8c)});
}
_a61(this);
});
};
$.fn.combogrid.methods={options:function(jq){
var _a90=jq.combo("options");
return $.extend($.data(jq[0],"combogrid").options,{width:_a90.width,height:_a90.height,originalValue:_a90.originalValue,disabled:_a90.disabled,readonly:_a90.readonly});
},grid:function(jq){
return $.data(jq[0],"combogrid").grid;
},setValues:function(jq,_a91){
return jq.each(function(){
var opts=$(this).combogrid("options");
if($.isArray(_a91)){
_a91=$.map(_a91,function(_a92){
if(_a92&&typeof _a92=="object"){
$.easyui.addArrayItem(opts.mappingRows,opts.idField,_a92);
return _a92[opts.idField];
}else{
return _a92;
}
});
}
_a6f(this,_a91);
});
},setValue:function(jq,_a93){
return jq.each(function(){
$(this).combogrid("setValues",$.isArray(_a93)?_a93:[_a93]);
});
},clear:function(jq){
return jq.each(function(){
$(this).combogrid("setValues",[]);
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).combogrid("options");
if(opts.multiple){
$(this).combogrid("setValues",opts.originalValue);
}else{
$(this).combogrid("setValue",opts.originalValue);
}
});
}};
$.fn.combogrid.parseOptions=function(_a94){
var t=$(_a94);
return $.extend({},$.fn.combo.parseOptions(_a94),$.fn.datagrid.parseOptions(_a94),$.parser.parseOptions(_a94,["idField","textField","mode"]));
};
$.fn.combogrid.defaults=$.extend({},$.fn.combo.defaults,$.fn.datagrid.defaults,{height:22,loadMsg:null,idField:null,textField:null,unselectedValues:[],mappingRows:[],mode:"local",keyHandler:{up:function(e){
nav(this,"prev");
e.preventDefault();
},down:function(e){
nav(this,"next");
e.preventDefault();
},left:function(e){
},right:function(e){
},enter:function(e){
_a88(this);
},query:function(q,e){
_a85(this,q);
}},filter:function(q,row){
var opts=$(this).combogrid("options");
return (row[opts.textField]||"").toLowerCase().indexOf(q.toLowerCase())>=0;
}});
})(jQuery);
(function($){
function _a95(_a96){
var _a97=$.data(_a96,"datebox");
var opts=_a97.options;
$(_a96).addClass("datebox-f").combo($.extend({},opts,{onShowPanel:function(){
_a98(this);
_a99(this);
_a9a(this);
_aa8(this,$(this).datebox("getText"),true);
opts.onShowPanel.call(this);
}}));
if(!_a97.calendar){
var _a9b=$(_a96).combo("panel").css("overflow","hidden");
_a9b.panel("options").onBeforeDestroy=function(){
var c=$(this).find(".calendar-shared");
if(c.length){
c.insertBefore(c[0].pholder);
}
};
var cc=$("<div class=\"datebox-calendar-inner\"></div>").prependTo(_a9b);
if(opts.sharedCalendar){
var c=$(opts.sharedCalendar);
if(!c[0].pholder){
c[0].pholder=$("<div class=\"calendar-pholder\" style=\"display:none\"></div>").insertAfter(c);
}
c.addClass("calendar-shared").appendTo(cc);
if(!c.hasClass("calendar")){
c.calendar();
}
_a97.calendar=c;
}else{
_a97.calendar=$("<div></div>").appendTo(cc).calendar();
}
$.extend(_a97.calendar.calendar("options"),{fit:true,border:false,onSelect:function(date){
var _a9c=this.target;
var opts=$(_a9c).datebox("options");
_aa8(_a9c,opts.formatter.call(_a9c,date));
$(_a9c).combo("hidePanel");
opts.onSelect.call(_a9c,date);
}});
}
$(_a96).combo("textbox").parent().addClass("datebox");
$(_a96).datebox("initValue",opts.value);
function _a98(_a9d){
var opts=$(_a9d).datebox("options");
var _a9e=$(_a9d).combo("panel");
_a9e.unbind(".datebox").bind("click.datebox",function(e){
if($(e.target).hasClass("datebox-button-a")){
var _a9f=parseInt($(e.target).attr("datebox-button-index"));
opts.buttons[_a9f].handler.call(e.target,_a9d);
}
});
};
function _a99(_aa0){
var _aa1=$(_aa0).combo("panel");
if(_aa1.children("div.datebox-button").length){
return;
}
var _aa2=$("<div class=\"datebox-button\"><table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%\"><tr></tr></table></div>").appendTo(_aa1);
var tr=_aa2.find("tr");
for(var i=0;i<opts.buttons.length;i++){
var td=$("<td></td>").appendTo(tr);
var btn=opts.buttons[i];
var t=$("<a class=\"datebox-button-a\" href=\"javascript:void(0)\"></a>").html($.isFunction(btn.text)?btn.text(_aa0):btn.text).appendTo(td);
t.attr("datebox-button-index",i);
}
tr.find("td").css("width",(100/opts.buttons.length)+"%");
};
function _a9a(_aa3){
var _aa4=$(_aa3).combo("panel");
var cc=_aa4.children("div.datebox-calendar-inner");
_aa4.children()._outerWidth(_aa4.width());
_a97.calendar.appendTo(cc);
_a97.calendar[0].target=_aa3;
if(opts.panelHeight!="auto"){
var _aa5=_aa4.height();
_aa4.children().not(cc).each(function(){
_aa5-=$(this).outerHeight();
});
cc._outerHeight(_aa5);
}
_a97.calendar.calendar("resize");
};
};
function _aa6(_aa7,q){
_aa8(_aa7,q,true);
};
function _aa9(_aaa){
var _aab=$.data(_aaa,"datebox");
var opts=_aab.options;
var _aac=_aab.calendar.calendar("options").current;
if(_aac){
_aa8(_aaa,opts.formatter.call(_aaa,_aac));
$(_aaa).combo("hidePanel");
}
};
function _aa8(_aad,_aae,_aaf){
var _ab0=$.data(_aad,"datebox");
var opts=_ab0.options;
var _ab1=_ab0.calendar;
_ab1.calendar("moveTo",opts.parser.call(_aad,_aae));
if(_aaf){
$(_aad).combo("setValue",_aae);
}else{
if(_aae){
_aae=opts.formatter.call(_aad,_ab1.calendar("options").current);
}
$(_aad).combo("setText",_aae).combo("setValue",_aae);
}
};
$.fn.datebox=function(_ab2,_ab3){
if(typeof _ab2=="string"){
var _ab4=$.fn.datebox.methods[_ab2];
if(_ab4){
return _ab4(this,_ab3);
}else{
return this.combo(_ab2,_ab3);
}
}
_ab2=_ab2||{};
return this.each(function(){
var _ab5=$.data(this,"datebox");
if(_ab5){
$.extend(_ab5.options,_ab2);
}else{
$.data(this,"datebox",{options:$.extend({},$.fn.datebox.defaults,$.fn.datebox.parseOptions(this),_ab2)});
}
_a95(this);
});
};
$.fn.datebox.methods={options:function(jq){
var _ab6=jq.combo("options");
return $.extend($.data(jq[0],"datebox").options,{width:_ab6.width,height:_ab6.height,originalValue:_ab6.originalValue,disabled:_ab6.disabled,readonly:_ab6.readonly});
},cloneFrom:function(jq,from){
return jq.each(function(){
$(this).combo("cloneFrom",from);
$.data(this,"datebox",{options:$.extend(true,{},$(from).datebox("options")),calendar:$(from).datebox("calendar")});
$(this).addClass("datebox-f");
});
},calendar:function(jq){
return $.data(jq[0],"datebox").calendar;
},initValue:function(jq,_ab7){
return jq.each(function(){
var opts=$(this).datebox("options");
var _ab8=opts.value;
if(_ab8){
_ab8=opts.formatter.call(this,opts.parser.call(this,_ab8));
}
$(this).combo("initValue",_ab8).combo("setText",_ab8);
});
},setValue:function(jq,_ab9){
return jq.each(function(){
_aa8(this,_ab9);
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).datebox("options");
$(this).datebox("setValue",opts.originalValue);
});
}};
$.fn.datebox.parseOptions=function(_aba){
return $.extend({},$.fn.combo.parseOptions(_aba),$.parser.parseOptions(_aba,["sharedCalendar"]));
};
$.fn.datebox.defaults=$.extend({},$.fn.combo.defaults,{panelWidth:180,panelHeight:"auto",sharedCalendar:null,keyHandler:{up:function(e){
},down:function(e){
},left:function(e){
},right:function(e){
},enter:function(e){
_aa9(this);
},query:function(q,e){
_aa6(this,q);
}},currentText:"Today",closeText:"Close",okText:"Ok",buttons:[{text:function(_abb){
return $(_abb).datebox("options").currentText;
},handler:function(_abc){
var now=new Date();
$(_abc).datebox("calendar").calendar({year:now.getFullYear(),month:now.getMonth()+1,current:new Date(now.getFullYear(),now.getMonth(),now.getDate())});
_aa9(_abc);
}},{text:function(_abd){
return $(_abd).datebox("options").closeText;
},handler:function(_abe){
$(this).closest("div.combo-panel").panel("close");
}}],formatter:function(date){
var y=date.getFullYear();
var m=date.getMonth()+1;
var d=date.getDate();
return (m<10?("0"+m):m)+"/"+(d<10?("0"+d):d)+"/"+y;
},parser:function(s){
if(!s){
return new Date();
}
var ss=s.split("/");
var m=parseInt(ss[0],10);
var d=parseInt(ss[1],10);
var y=parseInt(ss[2],10);
if(!isNaN(y)&&!isNaN(m)&&!isNaN(d)){
return new Date(y,m-1,d);
}else{
return new Date();
}
},onSelect:function(date){
}});
})(jQuery);
(function($){
function _abf(_ac0){
var _ac1=$.data(_ac0,"datetimebox");
var opts=_ac1.options;
$(_ac0).datebox($.extend({},opts,{onShowPanel:function(){
var _ac2=$(this).datetimebox("getValue");
_ac8(this,_ac2,true);
opts.onShowPanel.call(this);
},formatter:$.fn.datebox.defaults.formatter,parser:$.fn.datebox.defaults.parser}));
$(_ac0).removeClass("datebox-f").addClass("datetimebox-f");
$(_ac0).datebox("calendar").calendar({onSelect:function(date){
opts.onSelect.call(this.target,date);
}});
if(!_ac1.spinner){
var _ac3=$(_ac0).datebox("panel");
var p=$("<div style=\"padding:2px\"><input></div>").insertAfter(_ac3.children("div.datebox-calendar-inner"));
_ac1.spinner=p.children("input");
}
_ac1.spinner.timespinner({width:opts.spinnerWidth,showSeconds:opts.showSeconds,separator:opts.timeSeparator});
$(_ac0).datetimebox("initValue",opts.value);
};
function _ac4(_ac5){
var c=$(_ac5).datetimebox("calendar");
var t=$(_ac5).datetimebox("spinner");
var date=c.calendar("options").current;
return new Date(date.getFullYear(),date.getMonth(),date.getDate(),t.timespinner("getHours"),t.timespinner("getMinutes"),t.timespinner("getSeconds"));
};
function _ac6(_ac7,q){
_ac8(_ac7,q,true);
};
function _ac9(_aca){
var opts=$.data(_aca,"datetimebox").options;
var date=_ac4(_aca);
_ac8(_aca,opts.formatter.call(_aca,date));
$(_aca).combo("hidePanel");
};
function _ac8(_acb,_acc,_acd){
var opts=$.data(_acb,"datetimebox").options;
$(_acb).combo("setValue",_acc);
if(!_acd){
if(_acc){
var date=opts.parser.call(_acb,_acc);
$(_acb).combo("setText",opts.formatter.call(_acb,date));
$(_acb).combo("setValue",opts.formatter.call(_acb,date));
}else{
$(_acb).combo("setText",_acc);
}
}
var date=opts.parser.call(_acb,_acc);
$(_acb).datetimebox("calendar").calendar("moveTo",date);
$(_acb).datetimebox("spinner").timespinner("setValue",_ace(date));
function _ace(date){
function _acf(_ad0){
return (_ad0<10?"0":"")+_ad0;
};
var tt=[_acf(date.getHours()),_acf(date.getMinutes())];
if(opts.showSeconds){
tt.push(_acf(date.getSeconds()));
}
return tt.join($(_acb).datetimebox("spinner").timespinner("options").separator);
};
};
$.fn.datetimebox=function(_ad1,_ad2){
if(typeof _ad1=="string"){
var _ad3=$.fn.datetimebox.methods[_ad1];
if(_ad3){
return _ad3(this,_ad2);
}else{
return this.datebox(_ad1,_ad2);
}
}
_ad1=_ad1||{};
return this.each(function(){
var _ad4=$.data(this,"datetimebox");
if(_ad4){
$.extend(_ad4.options,_ad1);
}else{
$.data(this,"datetimebox",{options:$.extend({},$.fn.datetimebox.defaults,$.fn.datetimebox.parseOptions(this),_ad1)});
}
_abf(this);
});
};
$.fn.datetimebox.methods={options:function(jq){
var _ad5=jq.datebox("options");
return $.extend($.data(jq[0],"datetimebox").options,{originalValue:_ad5.originalValue,disabled:_ad5.disabled,readonly:_ad5.readonly});
},cloneFrom:function(jq,from){
return jq.each(function(){
$(this).datebox("cloneFrom",from);
$.data(this,"datetimebox",{options:$.extend(true,{},$(from).datetimebox("options")),spinner:$(from).datetimebox("spinner")});
$(this).removeClass("datebox-f").addClass("datetimebox-f");
});
},spinner:function(jq){
return $.data(jq[0],"datetimebox").spinner;
},initValue:function(jq,_ad6){
return jq.each(function(){
var opts=$(this).datetimebox("options");
var _ad7=opts.value;
if(_ad7){
_ad7=opts.formatter.call(this,opts.parser.call(this,_ad7));
}
$(this).combo("initValue",_ad7).combo("setText",_ad7);
});
},setValue:function(jq,_ad8){
return jq.each(function(){
_ac8(this,_ad8);
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).datetimebox("options");
$(this).datetimebox("setValue",opts.originalValue);
});
}};
$.fn.datetimebox.parseOptions=function(_ad9){
var t=$(_ad9);
return $.extend({},$.fn.datebox.parseOptions(_ad9),$.parser.parseOptions(_ad9,["timeSeparator","spinnerWidth",{showSeconds:"boolean"}]));
};
$.fn.datetimebox.defaults=$.extend({},$.fn.datebox.defaults,{spinnerWidth:"100%",showSeconds:true,timeSeparator:":",keyHandler:{up:function(e){
},down:function(e){
},left:function(e){
},right:function(e){
},enter:function(e){
_ac9(this);
},query:function(q,e){
_ac6(this,q);
}},buttons:[{text:function(_ada){
return $(_ada).datetimebox("options").currentText;
},handler:function(_adb){
var opts=$(_adb).datetimebox("options");
_ac8(_adb,opts.formatter.call(_adb,new Date()));
$(_adb).datetimebox("hidePanel");
}},{text:function(_adc){
return $(_adc).datetimebox("options").okText;
},handler:function(_add){
_ac9(_add);
}},{text:function(_ade){
return $(_ade).datetimebox("options").closeText;
},handler:function(_adf){
$(_adf).datetimebox("hidePanel");
}}],formatter:function(date){
var h=date.getHours();
var M=date.getMinutes();
var s=date.getSeconds();
function _ae0(_ae1){
return (_ae1<10?"0":"")+_ae1;
};
var _ae2=$(this).datetimebox("spinner").timespinner("options").separator;
var r=$.fn.datebox.defaults.formatter(date)+" "+_ae0(h)+_ae2+_ae0(M);
if($(this).datetimebox("options").showSeconds){
r+=_ae2+_ae0(s);
}
return r;
},parser:function(s){
if($.trim(s)==""){
return new Date();
}
var dt=s.split(" ");
var d=$.fn.datebox.defaults.parser(dt[0]);
if(dt.length<2){
return d;
}
var _ae3=$(this).datetimebox("spinner").timespinner("options").separator;
var tt=dt[1].split(_ae3);
var hour=parseInt(tt[0],10)||0;
var _ae4=parseInt(tt[1],10)||0;
var _ae5=parseInt(tt[2],10)||0;
return new Date(d.getFullYear(),d.getMonth(),d.getDate(),hour,_ae4,_ae5);
}});
})(jQuery);
(function($){
function init(_ae6){
var _ae7=$("<div class=\"slider\">"+"<div class=\"slider-inner\">"+"<a href=\"javascript:void(0)\" class=\"slider-handle\"></a>"+"<span class=\"slider-tip\"></span>"+"</div>"+"<div class=\"slider-rule\"></div>"+"<div class=\"slider-rulelabel\"></div>"+"<div style=\"clear:both\"></div>"+"<input type=\"hidden\" class=\"slider-value\">"+"</div>").insertAfter(_ae6);
var t=$(_ae6);
t.addClass("slider-f").hide();
var name=t.attr("name");
if(name){
_ae7.find("input.slider-value").attr("name",name);
t.removeAttr("name").attr("sliderName",name);
}
_ae7.bind("_resize",function(e,_ae8){
if($(this).hasClass("easyui-fluid")||_ae8){
_ae9(_ae6);
}
return false;
});
return _ae7;
};
function _ae9(_aea,_aeb){
var _aec=$.data(_aea,"slider");
var opts=_aec.options;
var _aed=_aec.slider;
if(_aeb){
if(_aeb.width){
opts.width=_aeb.width;
}
if(_aeb.height){
opts.height=_aeb.height;
}
}
_aed._size(opts);
if(opts.mode=="h"){
_aed.css("height","");
_aed.children("div").css("height","");
}else{
_aed.css("width","");
_aed.children("div").css("width","");
_aed.children("div.slider-rule,div.slider-rulelabel,div.slider-inner")._outerHeight(_aed._outerHeight());
}
_aee(_aea);
};
function _aef(_af0){
var _af1=$.data(_af0,"slider");
var opts=_af1.options;
var _af2=_af1.slider;
var aa=opts.mode=="h"?opts.rule:opts.rule.slice(0).reverse();
if(opts.reversed){
aa=aa.slice(0).reverse();
}
_af3(aa);
function _af3(aa){
var rule=_af2.find("div.slider-rule");
var _af4=_af2.find("div.slider-rulelabel");
rule.empty();
_af4.empty();
for(var i=0;i<aa.length;i++){
var _af5=i*100/(aa.length-1)+"%";
var span=$("<span></span>").appendTo(rule);
span.css((opts.mode=="h"?"left":"top"),_af5);
if(aa[i]!="|"){
span=$("<span></span>").appendTo(_af4);
span.html(aa[i]);
if(opts.mode=="h"){
span.css({left:_af5,marginLeft:-Math.round(span.outerWidth()/2)});
}else{
span.css({top:_af5,marginTop:-Math.round(span.outerHeight()/2)});
}
}
}
};
};
function _af6(_af7){
var _af8=$.data(_af7,"slider");
var opts=_af8.options;
var _af9=_af8.slider;
_af9.removeClass("slider-h slider-v slider-disabled");
_af9.addClass(opts.mode=="h"?"slider-h":"slider-v");
_af9.addClass(opts.disabled?"slider-disabled":"");
var _afa=_af9.find(".slider-inner");
_afa.html("<a href=\"javascript:void(0)\" class=\"slider-handle\"></a>"+"<span class=\"slider-tip\"></span>");
if(opts.range){
_afa.append("<a href=\"javascript:void(0)\" class=\"slider-handle\"></a>"+"<span class=\"slider-tip\"></span>");
}
_af9.find("a.slider-handle").draggable({axis:opts.mode,cursor:"pointer",disabled:opts.disabled,onDrag:function(e){
var left=e.data.left;
var _afb=_af9.width();
if(opts.mode!="h"){
left=e.data.top;
_afb=_af9.height();
}
if(left<0||left>_afb){
return false;
}else{
_afc(left,this);
return false;
}
},onStartDrag:function(){
_af8.isDragging=true;
opts.onSlideStart.call(_af7,opts.value);
},onStopDrag:function(e){
_afc(opts.mode=="h"?e.data.left:e.data.top,this);
opts.onSlideEnd.call(_af7,opts.value);
opts.onComplete.call(_af7,opts.value);
_af8.isDragging=false;
}});
_af9.find("div.slider-inner").unbind(".slider").bind("mousedown.slider",function(e){
if(_af8.isDragging||opts.disabled){
return;
}
var pos=$(this).offset();
_afc(opts.mode=="h"?(e.pageX-pos.left):(e.pageY-pos.top));
opts.onComplete.call(_af7,opts.value);
});
function _afc(pos,_afd){
var _afe=_aff(_af7,pos);
var s=Math.abs(_afe%opts.step);
if(s<opts.step/2){
_afe-=s;
}else{
_afe=_afe-s+opts.step;
}
if(opts.range){
var v1=opts.value[0];
var v2=opts.value[1];
var m=parseFloat((v1+v2)/2);
if(_afd){
var _b00=$(_afd).nextAll(".slider-handle").length>0;
if(_afe<=v2&&_b00){
v1=_afe;
}else{
if(_afe>=v1&&(!_b00)){
v2=_afe;
}
}
}else{
if(_afe<v1){
v1=_afe;
}else{
if(_afe>v2){
v2=_afe;
}else{
_afe<m?v1=_afe:v2=_afe;
}
}
}
$(_af7).slider("setValues",[v1,v2]);
}else{
$(_af7).slider("setValue",_afe);
}
};
};
function _b01(_b02,_b03){
var _b04=$.data(_b02,"slider");
var opts=_b04.options;
var _b05=_b04.slider;
var _b06=$.isArray(opts.value)?opts.value:[opts.value];
var _b07=[];
if(!$.isArray(_b03)){
_b03=$.map(String(_b03).split(opts.separator),function(v){
return parseFloat(v);
});
}
_b05.find(".slider-value").remove();
var name=$(_b02).attr("sliderName")||"";
for(var i=0;i<_b03.length;i++){
var _b08=_b03[i];
if(_b08<opts.min){
_b08=opts.min;
}
if(_b08>opts.max){
_b08=opts.max;
}
var _b09=$("<input type=\"hidden\" class=\"slider-value\">").appendTo(_b05);
_b09.attr("name",name);
_b09.val(_b08);
_b07.push(_b08);
var _b0a=_b05.find(".slider-handle:eq("+i+")");
var tip=_b0a.next();
var pos=_b0b(_b02,_b08);
if(opts.showTip){
tip.show();
tip.html(opts.tipFormatter.call(_b02,_b08));
}else{
tip.hide();
}
if(opts.mode=="h"){
var _b0c="left:"+pos+"px;";
_b0a.attr("style",_b0c);
tip.attr("style",_b0c+"margin-left:"+(-Math.round(tip.outerWidth()/2))+"px");
}else{
var _b0c="top:"+pos+"px;";
_b0a.attr("style",_b0c);
tip.attr("style",_b0c+"margin-left:"+(-Math.round(tip.outerWidth()))+"px");
}
}
opts.value=opts.range?_b07:_b07[0];
$(_b02).val(opts.range?_b07.join(opts.separator):_b07[0]);
if(_b06.join(",")!=_b07.join(",")){
opts.onChange.call(_b02,opts.value,(opts.range?_b06:_b06[0]));
}
};
function _aee(_b0d){
var opts=$.data(_b0d,"slider").options;
var fn=opts.onChange;
opts.onChange=function(){
};
_b01(_b0d,opts.value);
opts.onChange=fn;
};
function _b0b(_b0e,_b0f){
var _b10=$.data(_b0e,"slider");
var opts=_b10.options;
var _b11=_b10.slider;
var size=opts.mode=="h"?_b11.width():_b11.height();
var pos=opts.converter.toPosition.call(_b0e,_b0f,size);
if(opts.mode=="v"){
pos=_b11.height()-pos;
}
if(opts.reversed){
pos=size-pos;
}
return pos.toFixed(0);
};
function _aff(_b12,pos){
var _b13=$.data(_b12,"slider");
var opts=_b13.options;
var _b14=_b13.slider;
var size=opts.mode=="h"?_b14.width():_b14.height();
var pos=opts.mode=="h"?(opts.reversed?(size-pos):pos):(opts.reversed?pos:(size-pos));
var _b15=opts.converter.toValue.call(_b12,pos,size);
return _b15.toFixed(0);
};
$.fn.slider=function(_b16,_b17){
if(typeof _b16=="string"){
return $.fn.slider.methods[_b16](this,_b17);
}
_b16=_b16||{};
return this.each(function(){
var _b18=$.data(this,"slider");
if(_b18){
$.extend(_b18.options,_b16);
}else{
_b18=$.data(this,"slider",{options:$.extend({},$.fn.slider.defaults,$.fn.slider.parseOptions(this),_b16),slider:init(this)});
$(this).removeAttr("disabled");
}
var opts=_b18.options;
opts.min=parseFloat(opts.min);
opts.max=parseFloat(opts.max);
if(opts.range){
if(!$.isArray(opts.value)){
opts.value=$.map(String(opts.value).split(opts.separator),function(v){
return parseFloat(v);
});
}
if(opts.value.length<2){
opts.value.push(opts.max);
}
}else{
opts.value=parseFloat(opts.value);
}
opts.step=parseFloat(opts.step);
opts.originalValue=opts.value;
_af6(this);
_aef(this);
_ae9(this);
});
};
$.fn.slider.methods={options:function(jq){
return $.data(jq[0],"slider").options;
},destroy:function(jq){
return jq.each(function(){
$.data(this,"slider").slider.remove();
$(this).remove();
});
},resize:function(jq,_b19){
return jq.each(function(){
_ae9(this,_b19);
});
},getValue:function(jq){
return jq.slider("options").value;
},getValues:function(jq){
return jq.slider("options").value;
},setValue:function(jq,_b1a){
return jq.each(function(){
_b01(this,[_b1a]);
});
},setValues:function(jq,_b1b){
return jq.each(function(){
_b01(this,_b1b);
});
},clear:function(jq){
return jq.each(function(){
var opts=$(this).slider("options");
_b01(this,opts.range?[opts.min,opts.max]:[opts.min]);
});
},reset:function(jq){
return jq.each(function(){
var opts=$(this).slider("options");
$(this).slider(opts.range?"setValues":"setValue",opts.originalValue);
});
},enable:function(jq){
return jq.each(function(){
$.data(this,"slider").options.disabled=false;
_af6(this);
});
},disable:function(jq){
return jq.each(function(){
$.data(this,"slider").options.disabled=true;
_af6(this);
});
}};
$.fn.slider.parseOptions=function(_b1c){
var t=$(_b1c);
return $.extend({},$.parser.parseOptions(_b1c,["width","height","mode",{reversed:"boolean",showTip:"boolean",range:"boolean",min:"number",max:"number",step:"number"}]),{value:(t.val()||undefined),disabled:(t.attr("disabled")?true:undefined),rule:(t.attr("rule")?eval(t.attr("rule")):undefined)});
};
$.fn.slider.defaults={width:"auto",height:"auto",mode:"h",reversed:false,showTip:false,disabled:false,range:false,value:0,separator:",",min:0,max:100,step:1,rule:[],tipFormatter:function(_b1d){
return _b1d;
},converter:{toPosition:function(_b1e,size){
var opts=$(this).slider("options");
return (_b1e-opts.min)/(opts.max-opts.min)*size;
},toValue:function(pos,size){
var opts=$(this).slider("options");
return opts.min+(opts.max-opts.min)*(pos/size);
}},onChange:function(_b1f,_b20){
},onSlideStart:function(_b21){
},onSlideEnd:function(_b22){
},onComplete:function(_b23){
}};
})(jQuery);


/*
 * Jeditable - jQuery in place edit plugin
 *
 * Copyright (c) 2006-2009 Mika Tuupola, Dylan Verheul
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/jeditable
 *
 * Based on editable by Dylan Verheul <dylan_at_dyve.net>:
 *    http://www.dyve.net/jquery/?editable
 *
 */

/**
 * Version 1.7.1
 *
 * ** means there is basic unit tests for this parameter.
 *
 * @name  Jeditable
 * @type  jQuery
 * @param String  target             (POST) URL or function to send edited content to **
 * @param Hash    options            additional options
 * @param String  options[method]    method to use to send edited content (POST or PUT) **
 * @param Function options[callback] Function to run after submitting edited content **
 * @param String  options[name]      POST parameter name of edited content
 * @param String  options[id]        POST parameter name of edited div id
 * @param Hash    options[submitdata] Extra parameters to send when submitting edited content.
 * @param String  options[type]      text, textarea or select (or any 3rd party input type) **
 * @param Integer options[rows]      number of rows if using textarea **
 * @param Integer options[cols]      number of columns if using textarea **
 * @param Mixed   options[height]    'auto', 'none' or height in pixels **
 * @param Mixed   options[width]     'auto', 'none' or width in pixels **
 * @param String  options[loadurl]   URL to fetch input content before editing **
 * @param String  options[loadtype]  Request type for load url. Should be GET or POST.
 * @param String  options[loadtext]  Text to display while loading external content.
 * @param Mixed   options[loaddata]  Extra parameters to pass when fetching content before editing.
 * @param Mixed   options[data]      Or content given as paramameter. String or function.**
 * @param String  options[indicator] indicator html to show when saving
 * @param String  options[tooltip]   optional tooltip text via title attribute **
 * @param String  options[event]     jQuery event such as 'click' of 'dblclick' **
 * @param String  options[submit]    submit button value, empty means no button **
 * @param String  options[cancel]    cancel button value, empty means no button **
 * @param String  options[cssclass]  CSS class to apply to input form. 'inherit' to copy from parent. **
 * @param String  options[style]     Style to apply to input form 'inherit' to copy from parent. **
 * @param String  options[select]    true or false, when true text is highlighted ??
 * @param String  options[placeholder] Placeholder text or html to insert when element is empty. **
 * @param String  options[onblur]    'cancel', 'submit', 'ignore' or function ??
 *
 * @param Function options[onsubmit] function(settings, original) { ... } called before submit
 * @param Function options[onreset]  function(settings, original) { ... } called before reset
 * @param Function options[onerror]  function(settings, original, xhr) { ... } called on error
 *
 * @param Hash    options[ajaxoptions]  jQuery Ajax options. See docs.jquery.com.
 *
 */

(function($) {

    $.fn.editable = function(target, options) {

        if ('disable' == target) {
            $(this).data('disabled.editable', true);
            return;
        }
        if ('enable' == target) {
            $(this).data('disabled.editable', false);
            return;
        }
        if ('destroy' == target) {
            $(this)
                .unbind($(this).data('event.editable'))
                .removeData('disabled.editable')
                .removeData('event.editable');
            return;
        }

        var settings = $.extend({}, $.fn.editable.defaults, {target:target}, options);

        /* setup some functions */
        var plugin   = $.editable.types[settings.type].plugin || function() { };
        var submit   = $.editable.types[settings.type].submit || function() { };
        var buttons  = $.editable.types[settings.type].buttons
            || $.editable.types['defaults'].buttons;
        var content  = $.editable.types[settings.type].content
            || $.editable.types['defaults'].content;
        var element  = $.editable.types[settings.type].element
            || $.editable.types['defaults'].element;
        var reset    = $.editable.types[settings.type].reset
            || $.editable.types['defaults'].reset;
        var callback = settings.callback || function() { };
        var onedit   = settings.onedit   || function() { };
        var onsubmit = settings.onsubmit || function() { };
        var onreset  = settings.onreset  || function() { };
        var onerror  = settings.onerror  || reset;

        /* show tooltip */
        if (settings.tooltip) {
            $(this).attr('title', settings.tooltip);
        }

        settings.autowidth  = 'auto' == settings.width;
        settings.autoheight = 'auto' == settings.height;

        return this.each(function() {

            /* save this to self because this changes when scope changes */
            var self = this;

            /* inlined block elements lose their width and height after first edit */
            /* save them for later use as workaround */
            var savedwidth  = $(self).width();
            var savedheight = $(self).height();

            /* save so it can be later used by $.editable('destroy') */
            $(this).data('event.editable', settings.event);

            /* if element is empty add something clickable (if requested) */
            if (!$.trim($(this).html())) {
                $(this).html(settings.placeholder);
            }

            $(this).bind(settings.event, function(e) {

                /* abort if disabled for this element */
                if (true === $(this).data('disabled.editable')) {
                    return;
                }

                /* prevent throwing an exeption if edit field is clicked again */
                if (self.editing) {
                    return;
                }

                /* abort if onedit hook returns false */
                if (false === onedit.apply(this, [settings, self])) {
                    return;
                }

                /* prevent default action and bubbling */
                e.preventDefault();
                e.stopPropagation();

                /* remove tooltip */
                if (settings.tooltip) {
                    $(self).removeAttr('title');
                }

                /* figure out how wide and tall we are, saved width and height */
                /* are workaround for http://dev.jquery.com/ticket/2190 */
                if (0 == $(self).width()) {
                    //$(self).css('visibility', 'hidden');
                    settings.width  = savedwidth;
                    settings.height = savedheight;
                } else {
                    if (settings.width != 'none') {
                        settings.width =
                            settings.autowidth ? $(self).width()  : settings.width;
                    }
                    if (settings.height != 'none') {
                        settings.height =
                            settings.autoheight ? $(self).height() : settings.height;
                    }
                }
                //$(this).css('visibility', '');

                /* remove placeholder text, replace is here because of IE */
                if ($(this).html().toLowerCase().replace(/(;|")/g, '') ==
                    settings.placeholder.toLowerCase().replace(/(;|")/g, '')) {
                    $(this).html('');
                }

                self.editing    = true;
                self.revert     = $(self).html();
                $(self).html('');

                /* create the form object */
                var form = $('<form />');

                /* apply css or style or both */
                if (settings.cssclass) {
                    if ('inherit' == settings.cssclass) {
                        form.attr('class', $(self).attr('class'));
                    } else {
                        form.attr('class', settings.cssclass);
                    }
                }

                if (settings.style) {
                    if ('inherit' == settings.style) {
                        form.attr('style', $(self).attr('style'));
                        /* IE needs the second line or display wont be inherited */
                        form.css('display', $(self).css('display'));
                    } else {
                        form.attr('style', settings.style);
                    }
                }

                /* add main input element to form and store it in input */
                var input = element.apply(form, [settings, self]);

                /* set input content via POST, GET, given data or existing value */
                var input_content;

                if (settings.loadurl) {
                    var t = setTimeout(function() {
                        input.disabled = true;
                        content.apply(form, [settings.loadtext, settings, self]);
                    }, 100);

                    var loaddata = {};
                    loaddata[settings.id] = self.id;
                    if ($.isFunction(settings.loaddata)) {
                        $.extend(loaddata, settings.loaddata.apply(self, [self.revert, settings]));
                    } else {
                        $.extend(loaddata, settings.loaddata);
                    }
                    $.ajax({
                        type : settings.loadtype,
                        url  : settings.loadurl,
                        data : loaddata,
                        async : false,
                        success: function(result) {
                            window.clearTimeout(t);
                            input_content = result;
                            input.disabled = false;
                        }
                    });
                } else if (settings.data) {
                    input_content = settings.data;
                    if ($.isFunction(settings.data)) {
                        input_content = settings.data.apply(self, [self.revert, settings]);
                    }
                } else {
                    input_content = self.revert;
                }
                content.apply(form, [input_content, settings, self]);

                input.attr('name', settings.name);

                /* add buttons to the form */
                buttons.apply(form, [settings, self]);

                /* add created form to self */
                $(self).append(form);

                /* attach 3rd party plugin if requested */
                plugin.apply(form, [settings, self]);

                /* focus to first visible form element */
                $(':input:visible:enabled:first', form).focus();

                /* highlight input contents when requested */
                if (settings.select) {
                    input.select();
                }

                /* discard changes if pressing esc */
                input.keydown(function(e) {
                    if (e.keyCode == 27) {
                        e.preventDefault();
                        //self.reset();
                        reset.apply(form, [settings, self]);
                    }
                });

                /* discard, submit or nothing with changes when clicking outside */
                /* do nothing is usable when navigating with tab */
                var t;
                if ('cancel' == settings.onblur) {
                    input.blur(function(e) {
                        /* prevent canceling if submit was clicked */
                        t = setTimeout(function() {
                            reset.apply(form, [settings, self]);
                        }, 500);
                    });
                } else if ('submit' == settings.onblur) {
                    input.blur(function(e) {
                        /* prevent double submit if submit was clicked */
                        t = setTimeout(function() {
                            form.submit();
                        }, 200);
                    });
                } else if ($.isFunction(settings.onblur)) {
                    input.blur(function(e) {
                        settings.onblur.apply(self, [input.val(), settings]);
                    });
                } else {
                    input.blur(function(e) {
                        /* TODO: maybe something here */
                    });
                }

                form.submit(function(e) {

                    if (t) {
                        clearTimeout(t);
                    }

                    /* do no submit */
                    e.preventDefault();

                    /* call before submit hook. */
                    /* if it returns false abort submitting */
                    if (false !== onsubmit.apply(form, [settings, self])) {
                        /* custom inputs call before submit hook. */
                        /* if it returns false abort submitting */
                        if (false !== submit.apply(form, [settings, self])) {

                            /* check if given target is function */
                            if ($.isFunction(settings.target)) {
                                var str = settings.target.apply(self, [input.val(), settings]);
                                $(self).html(str);
                                self.editing = false;
                                callback.apply(self, [self.innerHTML, settings]);
                                /* TODO: this is not dry */
                                if (!$.trim($(self).html())) {
                                    $(self).html(settings.placeholder);
                                }
                            } else {
                                /* add edited content and id of edited element to POST */
                                var submitdata = {};
                                submitdata[settings.name] = input.val();
                                submitdata[settings.id] = self.id;
                                /* add extra data to be POST:ed */
                                if ($.isFunction(settings.submitdata)) {
                                    $.extend(submitdata, settings.submitdata.apply(self, [self.revert, settings]));
                                } else {
                                    $.extend(submitdata, settings.submitdata);
                                }

                                /* quick and dirty PUT support */
                                if ('PUT' == settings.method) {
                                    submitdata['_method'] = 'put';
                                }

                                /* show the saving indicator */
                                $(self).html(settings.indicator);

                                /* defaults for ajaxoptions */
                                var ajaxoptions = {
                                    type    : 'POST',
                                    data    : submitdata,
                                    dataType: 'html',
                                    url     : settings.target,
                                    success : function(result, status) {
                                        if (ajaxoptions.dataType == 'html') {
                                            $(self).html(result);
                                        }
                                        self.editing = false;
                                        callback.apply(self, [result, settings]);
                                        if (!$.trim($(self).html())) {
                                            $(self).html(settings.placeholder);
                                        }
                                    },
                                    error   : function(xhr, status, error) {
                                        onerror.apply(form, [settings, self, xhr]);
                                    }
                                };

                                /* override with what is given in settings.ajaxoptions */
                                $.extend(ajaxoptions, settings.ajaxoptions);
                                $.ajax(ajaxoptions);

                            }
                        }
                    }

                    /* show tooltip again */
                    $(self).attr('title', settings.tooltip);

                    return false;
                });
            });

            /* privileged methods */
            this.reset = function(form) {
                /* prevent calling reset twice when blurring */
                if (this.editing) {
                    /* before reset hook, if it returns false abort reseting */
                    if (false !== onreset.apply(form, [settings, self])) {
                        $(self).html(self.revert);
                        self.editing   = false;
                        if (!$.trim($(self).html())) {
                            $(self).html(settings.placeholder);
                        }
                        /* show tooltip again */
                        if (settings.tooltip) {
                            $(self).attr('title', settings.tooltip);
                        }
                    }
                }
            };
        });

    };


    $.editable = {
        types: {
            defaults: {
                element : function(settings, original) {
                    var input = $('<input type="hidden"></input>');
                    $(this).append(input);
                    return(input);
                },
                content : function(string, settings, original) {
                    $(':input:first', this).val(string);
                },
                reset : function(settings, original) {
                    original.reset(this);
                },
                buttons : function(settings, original) {
                    var form = this;
                    if (settings.submit) {
                        /* if given html string use that */
                        if (settings.submit.match(/>$/)) {
                            var submit = $(settings.submit).click(function() {
                                if (submit.attr("type") != "submit") {
                                    form.submit();
                                }
                            });
                            /* otherwise use button with given string as text */
                        } else {
                            var submit = $('<button type="submit" />');
                            submit.html(settings.submit);
                        }
                        $(this).append(submit);
                    }
                    if (settings.cancel) {
                        /* if given html string use that */
                        if (settings.cancel.match(/>$/)) {
                            var cancel = $(settings.cancel);
                            /* otherwise use button with given string as text */
                        } else {
                            var cancel = $('<button type="cancel" />');
                            cancel.html(settings.cancel);
                        }
                        $(this).append(cancel);

                        $(cancel).click(function(event) {
                            //original.reset();
                            if ($.isFunction($.editable.types[settings.type].reset)) {
                                var reset = $.editable.types[settings.type].reset;
                            } else {
                                var reset = $.editable.types['defaults'].reset;
                            }
                            reset.apply(form, [settings, original]);
                            return false;
                        });
                    }
                }
            },
            text: {
                element : function(settings, original) {
                    var input = $('<input />');
                    if (settings.width  != 'none') { input.width(settings.width);  }
                    if (settings.height != 'none') { input.height(settings.height); }
                    /* https://bugzilla.mozilla.org/show_bug.cgi?id=236791 */
                    //input[0].setAttribute('autocomplete','off');
                    input.attr('autocomplete','off');
                    $(this).append(input);
                    return(input);
                }
            },
            textarea: {
                element : function(settings, original) {
                    var textarea = $('<textarea />');
                    if (settings.rows) {
                        textarea.attr('rows', settings.rows);
                    } else if (settings.height != "none") {
                        textarea.height(settings.height);
                    }
                    if (settings.cols) {
                        textarea.attr('cols', settings.cols);
                    } else if (settings.width != "none") {
                        textarea.width(settings.width);
                    }
                    $(this).append(textarea);
                    return(textarea);
                }
            },
            select: {
                element : function(settings, original) {
                    var select = $('<select />');
                    $(this).append(select);
                    return(select);
                },
                content : function(data, settings, original) {
                    /* If it is string assume it is json. */
                    if (String == data.constructor) {
                        eval ('var json = ' + data);
                    } else {
                        /* Otherwise assume it is a hash already. */
                        var json = data;
                    }
                    for (var key in json) {
                        if (!json.hasOwnProperty(key)) {
                            continue;
                        }
                        if ('selected' == key) {
                            continue;
                        }
                        var option = $('<option />').val(key).append(json[key]);
                        $('select', this).append(option);
                    }
                    /* Loop option again to set selected. IE needed this... */
                    $('select', this).children().each(function() {
                        if ($(this).val() == json['selected'] ||
                            $(this).text() == $.trim(original.revert)) {
                            $(this).attr('selected', 'selected');
                        }
                    });
                }
            }
        },

        /* Add new input type */
        addInputType: function(name, input) {
            $.editable.types[name] = input;
        }
    };

    // publicly accessible defaults
    $.fn.editable.defaults = {
        name       : 'value',
        id         : 'id',
        type       : 'text',
        width      : 'auto',
        height     : 'auto',
        event      : 'click.editable',
        onblur     : 'cancel',
        loadtype   : 'GET',
        loadtext   : 'Loading...',
        placeholder: 'Click to edit',
        loaddata   : {},
        submitdata : {},
        ajaxoptions: {}
    };

})(jQuery);
/**
* autoNumeric.js
* @author: Bob Knothe
* @author: Sokolov Yura
* @version: 1.9.26 - 2014-10-07 GMT 2:00 PM
*
* Created by Robert J. Knothe on 2010-10-25. Please report any bugs to https://github.com/BobKnothe/autoNumeric
* Created by Sokolov Yura on 2010-11-07
*
* Copyright (c) 2011 Robert J. Knothe http://www.decorplanit.com/plugin/
*
* The MIT License (http://www.opensource.org/licenses/mit-license.php)
*
* Permission is hereby granted, free of charge, to any person
* obtaining a copy of this software and associated documentation
* files (the "Software"), to deal in the Software without
* restriction, including without limitation the rights to use,
* copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following
* conditions:
*
* The above copyright notice and this permission notice shall be
* included in all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
* EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
* OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
* NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
* HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
* WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
* FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
* OTHER DEALINGS IN THE SOFTWARE.
*/
(function ($) {
    "use strict";
    /*jslint browser: true*/
    /*global jQuery: false*/
    /* Cross browser routine for getting selected range/cursor position
     */
    function getElementSelection(that) {
        var position = {};
        if (that.selectionStart === undefined) {
            that.focus();
            var select = document.selection.createRange();
            position.length = select.text.length;
            select.moveStart('character', -that.value.length);
            position.end = select.text.length;
            position.start = position.end - position.length;
        } else {
            position.start = that.selectionStart;
            position.end = that.selectionEnd;
            position.length = position.end - position.start;
        }
        return position;
    }
    /**
     * Cross browser routine for setting selected range/cursor position
     */
    function setElementSelection(that, start, end) {
        if (that.selectionStart === undefined) {
            that.focus();
            var r = that.createTextRange();
            r.collapse(true);
            r.moveEnd('character', end);
            r.moveStart('character', start);
            r.select();
        } else {
            that.selectionStart = start;
            that.selectionEnd = end;
        }
    }
    /**
     * run callbacks in parameters if any
     * any parameter could be a callback:
     * - a function, which invoked with jQuery element, parameters and this parameter name and returns parameter value
     * - a name of function, attached to $(selector).autoNumeric.functionName(){} - which was called previously
     */
    function runCallbacks($this, settings) {
        /**
         * loops through the settings object (option array) to find the following
         * k = option name example k=aNum
         * val = option value example val=0123456789
         */
        $.each(settings, function (k, val) {
            if (typeof val === 'function') {
                settings[k] = val($this, settings, k);
            } else if (typeof $this.autoNumeric[val] === 'function') {
                /**
                 * calls the attached function from the html5 data example: data-a-sign="functionName"
                 */
                settings[k] = $this.autoNumeric[val]($this, settings, k);
            }
        });
    }
    function convertKeyToNumber(settings, key) {
        if (typeof (settings[key]) === 'string') {
            settings[key] *= 1;
        }
    }
    /**
     * Preparing user defined options for further usage
     * merge them with defaults appropriately
     */
    function autoCode($this, settings) {
        runCallbacks($this, settings);
        settings.oEvent = null;
        settings.tagList = ['b', 'caption', 'cite', 'code', 'dd', 'del', 'div', 'dfn', 'dt', 'em', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'ins', 'kdb', 'label', 'li', 'output', 'p', 'q', 's', 'sample', 'span', 'strong', 'td', 'th', 'u', 'var'];
        var vmax = settings.vMax.toString().split('.'),
            vmin = (!settings.vMin && settings.vMin !== 0) ? [] : settings.vMin.toString().split('.');
        convertKeyToNumber(settings, 'vMax');
        convertKeyToNumber(settings, 'vMin');
        convertKeyToNumber(settings, 'mDec'); /** set mDec if not defined by user */
        settings.mDec = (settings.mRound === 'CHF') ? '2' : settings.mDec;
        settings.allowLeading = true;
        settings.aNeg = settings.vMin < 0 ? '-' : '';
        vmax[0] = vmax[0].replace('-', '');
        vmin[0] = vmin[0].replace('-', '');
        settings.mInt = Math.max(vmax[0].length, vmin[0].length, 1);
        if (settings.mDec === null) {
            var vmaxLength = 0,
                vminLength = 0;
            if (vmax[1]) {
                vmaxLength = vmax[1].length;
            }
            if (vmin[1]) {
                vminLength = vmin[1].length;
            }
            settings.mDec = Math.max(vmaxLength, vminLength);
        } /** set alternative decimal separator key */
        if (settings.altDec === null && settings.mDec > 0) {
            if (settings.aDec === '.' && settings.aSep !== ',') {
                settings.altDec = ',';
            } else if (settings.aDec === ',' && settings.aSep !== '.') {
                settings.altDec = '.';
            }
        }
        /** cache regexps for autoStrip */
        var aNegReg = settings.aNeg ? '([-\\' + settings.aNeg + ']?)' : '(-?)';
        settings.aNegRegAutoStrip = aNegReg;
        settings.skipFirstAutoStrip = new RegExp(aNegReg + '[^-' + (settings.aNeg ? '\\' + settings.aNeg : '') + '\\' + settings.aDec + '\\d]' + '.*?(\\d|\\' + settings.aDec + '\\d)');
        settings.skipLastAutoStrip = new RegExp('(\\d\\' + settings.aDec + '?)[^\\' + settings.aDec + '\\d]\\D*$');
        var allowed = '-' + settings.aNum + '\\' + settings.aDec;
        settings.allowedAutoStrip = new RegExp('[^' + allowed + ']', 'gi');
        settings.numRegAutoStrip = new RegExp(aNegReg + '(?:\\' + settings.aDec + '?(\\d+\\' + settings.aDec + '\\d+)|(\\d*(?:\\' + settings.aDec + '\\d*)?))');
        return settings;
    }
    /**
     * strip all unwanted characters and leave only a number alert
     */
    function autoStrip(s, settings, strip_zero) {
        if (settings.aSign) { /** remove currency sign */
            while (s.indexOf(settings.aSign) > -1) {
                s = s.replace(settings.aSign, '');
            }
        }
        s = s.replace(settings.skipFirstAutoStrip, '$1$2'); /** first replace anything before digits */
        s = s.replace(settings.skipLastAutoStrip, '$1'); /** then replace anything after digits */
        s = s.replace(settings.allowedAutoStrip, ''); /** then remove any uninterested characters */
        if (settings.altDec) {
            s = s.replace(settings.altDec, settings.aDec);
        } /** get only number string */
        var m = s.match(settings.numRegAutoStrip);
        s = m ? [m[1], m[2], m[3]].join('') : '';
        if ((settings.lZero === 'allow' || settings.lZero === 'keep') && strip_zero !== 'strip') {
            var parts = [],
                nSign = '';
            parts = s.split(settings.aDec);
            if (parts[0].indexOf('-') !== -1) {
                nSign = '-';
                parts[0] = parts[0].replace('-', '');
            }
            if (parts[0].length > settings.mInt && parts[0].charAt(0) === '0') { /** strip leading zero if need */
                parts[0] = parts[0].slice(1);
            }
            s = nSign + parts.join(settings.aDec);
        }
        if ((strip_zero && settings.lZero === 'deny') || (strip_zero && settings.lZero === 'allow' && settings.allowLeading === false)) {
            var strip_reg = '^' + settings.aNegRegAutoStrip + '0*(\\d' + (strip_zero === 'leading' ? ')' : '|$)');
            strip_reg = new RegExp(strip_reg);
            s = s.replace(strip_reg, '$1$2');
        }
        return s;
    }
    /**
     * places or removes brackets on negative values
     */
    function negativeBracket(s, nBracket, oEvent) { /** oEvent = settings.oEvent */
        nBracket = nBracket.split(',');
        if (oEvent === 'set' || oEvent === 'focusout') {
            s = s.replace('-', '');
            s = nBracket[0] + s + nBracket[1];
        } else if ((oEvent === 'get' || oEvent === 'focusin' || oEvent === 'pageLoad') && s.charAt(0) === nBracket[0]) {
            s = s.replace(nBracket[0], '-');
            s = s.replace(nBracket[1], '');
        }
        return s;
    }
    /**
     * truncate decimal part of a number
     */
    function truncateDecimal(s, aDec, mDec) {
        if (aDec && mDec) {
            var parts = s.split(aDec);
            /** truncate decimal part to satisfying length
             * cause we would round it anyway */
            if (parts[1] && parts[1].length > mDec) {
                if (mDec > 0) {
                    parts[1] = parts[1].substring(0, mDec);
                    s = parts.join(aDec);
                } else {
                    s = parts[0];
                }
            }
        }
        return s;
    }
    /**
     * prepare number string to be converted to real number
     */
    function fixNumber(s, aDec, aNeg) {
        if (aDec && aDec !== '.') {
            s = s.replace(aDec, '.');
        }
        if (aNeg && aNeg !== '-') {
            s = s.replace(aNeg, '-');
        }
        if (!s.match(/\d/)) {
            s += '0';
        }
        return s;
    }
    /**
     * function to handle numbers less than 0 that are stored in Exponential notation ex: .0000001 stored as 1e-7
     */
    function checkValue(value, settings) {
        if (value) {
            var checkSmall = +value;
            if (checkSmall < 0.000001 && checkSmall > -1) {
                value = +value;
                if (value < 0.000001 && value > 0) {
                    value = (value + 10).toString();
                    value = value.substring(1);
                }
                if (value < 0 && value > -1) {
                    value = (value - 10).toString();
                    value = '-' + value.substring(2);
                }
                value = value.toString();
            } else {
                var parts = value.split('.');
                if (parts[1] !== undefined) {
                    if (+parts[1] === 0) {
                        value = parts[0];
                    } else {
                        parts[1] = parts[1].replace(/0*$/, '');
                        value = parts.join('.');
                    }
                }
            }
        }
        return (settings.lZero === 'keep') ? value : value.replace(/^0*(\d)/, '$1');
    }
    /**
     * prepare real number to be converted to our format
     */
    function presentNumber(s, aDec, aNeg) {
        if (aNeg && aNeg !== '-') {
            s = s.replace('-', aNeg);
        }
        if (aDec && aDec !== '.') {
            s = s.replace('.', aDec);
        }
        return s;
    }
    /**
     * checking that number satisfy format conditions
     * and lays between settings.vMin and settings.vMax
     * and the string length does not exceed the digits in settings.vMin and settings.vMax
     */
    function autoCheck(s, settings) {
        s = autoStrip(s, settings);
        s = truncateDecimal(s, settings.aDec, settings.mDec);
        s = fixNumber(s, settings.aDec, settings.aNeg);
        var value = +s;
        if (settings.oEvent === 'set' && (value < settings.vMin || value > settings.vMax)) {
            $.error("The value (" + value + ") from the 'set' method falls outside of the vMin / vMax range");
        }
        return value >= settings.vMin && value <= settings.vMax;
    }
    /**
     * private function to check for empty value
     */
    function checkEmpty(iv, settings, signOnEmpty) {
        if (iv === '' || iv === settings.aNeg) {
            if (settings.wEmpty === 'zero') {
                return iv + '0';
            }
            if (settings.wEmpty === 'sign' || signOnEmpty) {
                return iv + settings.aSign;
            }
            return iv;
        }
        return null;
    }
    /**
     * private function that formats our number
     */
    function autoGroup(iv, settings) {
        iv = autoStrip(iv, settings);
        var testNeg = iv.replace(',', '.'),
            empty = checkEmpty(iv, settings, true);
        if (empty !== null) {
            return empty;
        }
        var digitalGroup = '';
        if (settings.dGroup === 2) {
            digitalGroup = /(\d)((\d)(\d{2}?)+)$/;
        } else if (settings.dGroup === 4) {
            digitalGroup = /(\d)((\d{4}?)+)$/;
        } else {
            digitalGroup = /(\d)((\d{3}?)+)$/;
        } /** splits the string at the decimal string */
        var ivSplit = iv.split(settings.aDec);
        if (settings.altDec && ivSplit.length === 1) {
            ivSplit = iv.split(settings.altDec);
        } /** assigns the whole number to the a varibale (s) */
        var s = ivSplit[0];
        if (settings.aSep) {
            while (digitalGroup.test(s)) { /** re-inserts the thousand sepparator via a regualer expression */
                s = s.replace(digitalGroup, '$1' + settings.aSep + '$2');
            }
        }
        if (settings.mDec !== 0 && ivSplit.length > 1) {
            if (ivSplit[1].length > settings.mDec) {
                ivSplit[1] = ivSplit[1].substring(0, settings.mDec);
            } /** joins the whole number with the deciaml value */
            iv = s + settings.aDec + ivSplit[1];
        } else { /** if whole numbers only */
            iv = s;
        }
        if (settings.aSign) {
            var has_aNeg = iv.indexOf(settings.aNeg) !== -1;
            iv = iv.replace(settings.aNeg, '');
            iv = settings.pSign === 'p' ? settings.aSign + iv : iv + settings.aSign;
            if (has_aNeg) {
                iv = settings.aNeg + iv;
            }
        }
        if (settings.oEvent === 'set' && testNeg < 0 && settings.nBracket !== null) { /** removes the negative sign and places brackets */
            iv = negativeBracket(iv, settings.nBracket, settings.oEvent);
        }
        return iv;
    }
    /**
     * round number after setting by pasting or $().autoNumericSet()
     * private function for round the number
     * please note this handled as text - JavaScript math function can return inaccurate values
     * also this offers multiple rounding methods that are not easily accomplished in JavaScript
     */
    function autoRound(iv, settings) { /** value to string */
        iv = (iv === '') ? '0' : iv.toString();
        convertKeyToNumber(settings, 'mDec'); /** set mDec to number needed when mDec set by 'update method */
        if (settings.mRound === 'CHF') {
            iv = (Math.round(iv * 20) / 20).toString();
        }
        var ivRounded = '',
            i = 0,
            nSign = '',
            rDec = (typeof (settings.aPad) === 'boolean' || settings.aPad === null) ? (settings.aPad ? settings.mDec : 0) : +settings.aPad;
        var truncateZeros = function (ivRounded) { /** truncate not needed zeros */
            var regex = (rDec === 0) ? (/(\.(?:\d*[1-9])?)0*$/) : rDec === 1 ? (/(\.\d(?:\d*[1-9])?)0*$/) : new RegExp('(\\.\\d{' + rDec + '}(?:\\d*[1-9])?)0*$');
            ivRounded = ivRounded.replace(regex, '$1'); /** If there are no decimal places, we don't need a decimal point at the end */
            if (rDec === 0) {
                ivRounded = ivRounded.replace(/\.$/, '');
            }
            return ivRounded;
        };
        if (iv.charAt(0) === '-') { /** Checks if the iv (input Value)is a negative value */
            nSign = '-';
            iv = iv.replace('-', ''); /** removes the negative sign will be added back later if required */
        }
        if (!iv.match(/^\d/)) { /** append a zero if first character is not a digit (then it is likely to be a dot)*/
            iv = '0' + iv;
        }
        if (nSign === '-' && +iv === 0) { /** determines if the value is zero - if zero no negative sign */
            nSign = '';
        }
        if ((+iv > 0 && settings.lZero !== 'keep') || (iv.length > 0 && settings.lZero === 'allow')) { /** trims leading zero's if needed */
            iv = iv.replace(/^0*(\d)/, '$1');
        }
        var dPos = iv.lastIndexOf('.'), /** virtual decimal position */
            vdPos = (dPos === -1) ? iv.length - 1 : dPos, /** checks decimal places to determine if rounding is required */
            cDec = (iv.length - 1) - vdPos; /** check if no rounding is required */
        if (cDec <= settings.mDec) {
            ivRounded = iv; /** check if we need to pad with zeros */
            if (cDec < rDec) {
                if (dPos === -1) {
                    ivRounded += '.';
                }
                var zeros = '000000';
                while (cDec < rDec) {
                    zeros = zeros.substring(0, rDec - cDec);
                    ivRounded += zeros;
                    cDec += zeros.length;
                }
            } else if (cDec > rDec) {
                ivRounded = truncateZeros(ivRounded);
            } else if (cDec === 0 && rDec === 0) {
                ivRounded = ivRounded.replace(/\.$/, '');
            }
            if (settings.mRound !== 'CHF') {
                return (+ivRounded === 0) ? ivRounded : nSign + ivRounded;
            }
            if (settings.mRound === 'CHF') {
                dPos = ivRounded.lastIndexOf('.');
                iv = ivRounded;
            }

        } /** rounded length of the string after rounding */
        var rLength = dPos + settings.mDec,
            tRound = +iv.charAt(rLength + 1),
            ivArray = iv.substring(0, rLength + 1).split(''),
            odd = (iv.charAt(rLength) === '.') ? (iv.charAt(rLength - 1) % 2) : (iv.charAt(rLength) % 2),
            onePass = true;
        if (odd !== 1) {
            odd = (odd === 0 && (iv.substring(rLength + 2, iv.length) > 0)) ? 1 : 0;
        }
        if ((tRound > 4 && settings.mRound === 'S') || /** Round half up symmetric */
                (tRound > 4 && settings.mRound === 'A' && nSign === '') || /** Round half up asymmetric positive values */
                (tRound > 5 && settings.mRound === 'A' && nSign === '-') || /** Round half up asymmetric negative values */
                (tRound > 5 && settings.mRound === 's') || /** Round half down symmetric */
                (tRound > 5 && settings.mRound === 'a' && nSign === '') || /** Round half down asymmetric positive values */
                (tRound > 4 && settings.mRound === 'a' && nSign === '-') || /** Round half down asymmetric negative values */
                (tRound > 5 && settings.mRound === 'B') || /** Round half even "Banker's Rounding" */
                (tRound === 5 && settings.mRound === 'B' && odd === 1) || /** Round half even "Banker's Rounding" */
                (tRound > 0 && settings.mRound === 'C' && nSign === '') || /** Round to ceiling toward positive infinite */
                (tRound > 0 && settings.mRound === 'F' && nSign === '-') || /** Round to floor toward negative infinite */
                (tRound > 0 && settings.mRound === 'U') ||
                (settings.mRound === 'CHF')) { /** round up away from zero */
            for (i = (ivArray.length - 1); i >= 0; i -= 1) { /** Round up the last digit if required, and continue until no more 9's are found */
                if (ivArray[i] !== '.') {
                    if (settings.mRound === 'CHF' && ivArray[i] <= 2 && onePass) {
                        ivArray[i] = 0;
                        onePass = false;
                        break;
                    }
                    if (settings.mRound === 'CHF' && ivArray[i] <= 7 && onePass) {
                        ivArray[i] = 5;
                        onePass = false;
                        break;
                    }
                    if (settings.mRound === 'CHF' && onePass) {
                        ivArray[i] = 10;
                        onePass = false;
                    } else {
                        ivArray[i] = +ivArray[i] + 1;
                    }
                    if (ivArray[i] < 10) {
                        break;
                    }
                    if (i > 0) {
                        ivArray[i] = '0';
                    }
                }
            }
        }
        ivArray = ivArray.slice(0, rLength + 1); /** Reconstruct the string, converting any 10's to 0's */
        ivRounded = truncateZeros(ivArray.join('')); /** return rounded value */
        return (+ivRounded === 0) ? ivRounded : nSign + ivRounded;
    }
    /**
     * Holder object for field properties
     */
    function AutoNumericHolder(that, settings) {
        this.settings = settings;
        this.that = that;
        this.$that = $(that);
        this.formatted = false;
        this.settingsClone = autoCode(this.$that, this.settings);
        this.value = that.value;
    }
    AutoNumericHolder.prototype = {
        init: function (e) {
            this.value = this.that.value;
            this.settingsClone = autoCode(this.$that, this.settings);
            this.ctrlKey = e.ctrlKey;
            this.cmdKey = e.metaKey;
            this.shiftKey = e.shiftKey;
            this.selection = getElementSelection(this.that); /** keypress event overwrites meaningful value of e.keyCode */
            if (e.type === 'keydown' || e.type === 'keyup') {
                this.kdCode = e.keyCode;
            }
            this.which = e.which;
            this.processed = false;
            this.formatted = false;
        },
        setSelection: function (start, end, setReal) {
            start = Math.max(start, 0);
            end = Math.min(end, this.that.value.length);
            this.selection = {
                start: start,
                end: end,
                length: end - start
            };
            if (setReal === undefined || setReal) {
                setElementSelection(this.that, start, end);
            }
        },
        setPosition: function (pos, setReal) {
            this.setSelection(pos, pos, setReal);
        },
        getBeforeAfter: function () {
            var value = this.value,
                left = value.substring(0, this.selection.start),
                right = value.substring(this.selection.end, value.length);
            return [left, right];
        },
        getBeforeAfterStriped: function () {
            var parts = this.getBeforeAfter();
            parts[0] = autoStrip(parts[0], this.settingsClone);
            parts[1] = autoStrip(parts[1], this.settingsClone);
            return parts;
        },
        /**
         * strip parts from excess characters and leading zeroes
         */
        normalizeParts: function (left, right) {
            var settingsClone = this.settingsClone;
            right = autoStrip(right, settingsClone); /** if right is not empty and first character is not aDec, */
            /** we could strip all zeros, otherwise only leading */
            var strip = right.match(/^\d/) ? true : 'leading';
            left = autoStrip(left, settingsClone, strip); /** prevents multiple leading zeros from being entered */
            if ((left === '' || left === settingsClone.aNeg) && settingsClone.lZero === 'deny') {
                if (right > '') {
                    right = right.replace(/^0*(\d)/, '$1');
                }
            }
            var new_value = left + right; /** insert zero if has leading dot */
            if (settingsClone.aDec) {
                var m = new_value.match(new RegExp('^' + settingsClone.aNegRegAutoStrip + '\\' + settingsClone.aDec));
                if (m) {
                    left = left.replace(m[1], m[1] + '0');
                    new_value = left + right;
                }
            } /** insert zero if number is empty and io.wEmpty == 'zero' */
            if (settingsClone.wEmpty === 'zero' && (new_value === settingsClone.aNeg || new_value === '')) {
                left += '0';
            }
            return [left, right];
        },
        /**
         * set part of number to value keeping position of cursor
         */
        setValueParts: function (left, right) {
            var settingsClone = this.settingsClone,
                parts = this.normalizeParts(left, right),
                new_value = parts.join(''),
                position = parts[0].length;
            if (autoCheck(new_value, settingsClone)) {
                new_value = truncateDecimal(new_value, settingsClone.aDec, settingsClone.mDec);
                if (position > new_value.length) {
                    position = new_value.length;
                }
                this.value = new_value;
                this.setPosition(position, false);
                return true;
            }
            return false;
        },
        /**
         * helper function for expandSelectionOnSign
         * returns sign position of a formatted value
         */
        signPosition: function () {
            var settingsClone = this.settingsClone,
                aSign = settingsClone.aSign,
                that = this.that;
            if (aSign) {
                var aSignLen = aSign.length;
                if (settingsClone.pSign === 'p') {
                    var hasNeg = settingsClone.aNeg && that.value && that.value.charAt(0) === settingsClone.aNeg;
                    return hasNeg ? [1, aSignLen + 1] : [0, aSignLen];
                }
                var valueLen = that.value.length;
                return [valueLen - aSignLen, valueLen];
            }
            return [1000, -1];
        },
        /**
         * expands selection to cover whole sign
         * prevents partial deletion/copying/overwriting of a sign
         */
        expandSelectionOnSign: function (setReal) {
            var sign_position = this.signPosition(),
                selection = this.selection;
            if (selection.start < sign_position[1] && selection.end > sign_position[0]) { /** if selection catches something except sign and catches only space from sign */
                if ((selection.start < sign_position[0] || selection.end > sign_position[1]) && this.value.substring(Math.max(selection.start, sign_position[0]), Math.min(selection.end, sign_position[1])).match(/^\s*$/)) { /** then select without empty space */
                    if (selection.start < sign_position[0]) {
                        this.setSelection(selection.start, sign_position[0], setReal);
                    } else {
                        this.setSelection(sign_position[1], selection.end, setReal);
                    }
                } else { /** else select with whole sign */
                    this.setSelection(Math.min(selection.start, sign_position[0]), Math.max(selection.end, sign_position[1]), setReal);
                }
            }
        },
        /**
         * try to strip pasted value to digits
         */
        checkPaste: function () {
            if (this.valuePartsBeforePaste !== undefined) {
                var parts = this.getBeforeAfter(),
                    oldParts = this.valuePartsBeforePaste;
                delete this.valuePartsBeforePaste; /** try to strip pasted value first */
                parts[0] = parts[0].substr(0, oldParts[0].length) + autoStrip(parts[0].substr(oldParts[0].length), this.settingsClone);
                if (!this.setValueParts(parts[0], parts[1])) {
                    this.value = oldParts.join('');
                    this.setPosition(oldParts[0].length, false);
                }
            }
        },
        /**
         * process pasting, cursor moving and skipping of not interesting keys
         * if returns true, further processing is not performed
         */
        skipAllways: function (e) {
            var kdCode = this.kdCode,
                which = this.which,
                ctrlKey = this.ctrlKey,
                cmdKey = this.cmdKey,
                shiftKey = this.shiftKey; /** catch the ctrl up on ctrl-v */
            if (((ctrlKey || cmdKey) && e.type === 'keyup' && this.valuePartsBeforePaste !== undefined) || (shiftKey && kdCode === 45)) {
                this.checkPaste();
                return false;
            }
            /** codes are taken from http://www.cambiaresearch.com/c4/702b8cd1-e5b0-42e6-83ac-25f0306e3e25/Javascript-Char-Codes-Key-Codes.aspx
             * skip Fx keys, windows keys, other special keys
             */
            if ((kdCode >= 112 && kdCode <= 123) || (kdCode >= 91 && kdCode <= 93) || (kdCode >= 9 && kdCode <= 31) || (kdCode < 8 && (which === 0 || which === kdCode)) || kdCode === 144 || kdCode === 145 || kdCode === 45) {
                return true;
            }
            if ((ctrlKey || cmdKey) && kdCode === 65) { /** if select all (a=65)*/
                return true;
            }
            if ((ctrlKey || cmdKey) && (kdCode === 67 || kdCode === 86 || kdCode === 88)) { /** if copy (c=67) paste (v=86) or cut (x=88) */
                if (e.type === 'keydown') {
                    this.expandSelectionOnSign();
                }
                if (kdCode === 86 || kdCode === 45) { /** try to prevent wrong paste */
                    if (e.type === 'keydown' || e.type === 'keypress') {
                        if (this.valuePartsBeforePaste === undefined) {
                            this.valuePartsBeforePaste = this.getBeforeAfter();
                        }
                    } else {
                        this.checkPaste();
                    }
                }
                return e.type === 'keydown' || e.type === 'keypress' || kdCode === 67;
            }
            if (ctrlKey || cmdKey) {
                return true;
            }
            if (kdCode === 37 || kdCode === 39) { /** jump over thousand separator */
                var aSep = this.settingsClone.aSep,
                    start = this.selection.start,
                    value = this.that.value;
                if (e.type === 'keydown' && aSep && !this.shiftKey) {
                    if (kdCode === 37 && value.charAt(start - 2) === aSep) {
                        this.setPosition(start - 1);
                    } else if (kdCode === 39 && value.charAt(start + 1) === aSep) {
                        this.setPosition(start + 1);
                    }
                }
                return true;
            }
            if (kdCode >= 34 && kdCode <= 40) {
                return true;
            }
            return false;
        },
        /**
         * process deletion of characters
         * returns true if processing performed
         */
        processAllways: function () {
            var parts; /** process backspace or delete */
            if (this.kdCode === 8 || this.kdCode === 46) {
                if (!this.selection.length) {
                    parts = this.getBeforeAfterStriped();
                    if (this.kdCode === 8) {
                        parts[0] = parts[0].substring(0, parts[0].length - 1);
                    } else {
                        parts[1] = parts[1].substring(1, parts[1].length);
                    }
                    this.setValueParts(parts[0], parts[1]);
                } else {
                    this.expandSelectionOnSign(false);
                    parts = this.getBeforeAfterStriped();
                    this.setValueParts(parts[0], parts[1]);
                }
                return true;
            }
            return false;
        },
        /**
         * process insertion of characters
         * returns true if processing performed
         */
        processKeypress: function () {
            var settingsClone = this.settingsClone,
                cCode = String.fromCharCode(this.which),
                parts = this.getBeforeAfterStriped(),
                left = parts[0],
                right = parts[1]; /** start rules when the decimal character key is pressed */
            /** always use numeric pad dot to insert decimal separator */
            if (cCode === settingsClone.aDec || (settingsClone.altDec && cCode === settingsClone.altDec) || ((cCode === '.' || cCode === ',') && this.kdCode === 110)) { /** do not allow decimal character if no decimal part allowed */
                if (!settingsClone.mDec || !settingsClone.aDec) {
                    return true;
                } /** do not allow decimal character before aNeg character */
                if (settingsClone.aNeg && right.indexOf(settingsClone.aNeg) > -1) {
                    return true;
                } /** do not allow decimal character if other decimal character present */
                if (left.indexOf(settingsClone.aDec) > -1) {
                    return true;
                }
                if (right.indexOf(settingsClone.aDec) > 0) {
                    return true;
                }
                if (right.indexOf(settingsClone.aDec) === 0) {
                    right = right.substr(1);
                }
                this.setValueParts(left + settingsClone.aDec, right);
                return true;
            }
            /**
             * start rule on negative sign & prevent minus if not allowed
             */
            if (cCode === '-' || cCode === '+') {
                if (!settingsClone.aNeg) {
                    return true;
                } /** caret is always after minus */
                if (left === '' && right.indexOf(settingsClone.aNeg) > -1) {
                    left = settingsClone.aNeg;
                    right = right.substring(1, right.length);
                } /** change sign of number, remove part if should */
                if (left.charAt(0) === settingsClone.aNeg) {
                    left = left.substring(1, left.length);
                } else {
                    left = (cCode === '-') ? settingsClone.aNeg + left : left;
                }
                this.setValueParts(left, right);
                return true;
            } /** digits */
            if (cCode >= '0' && cCode <= '9') { /** if try to insert digit before minus */
                if (settingsClone.aNeg && left === '' && right.indexOf(settingsClone.aNeg) > -1) {
                    left = settingsClone.aNeg;
                    right = right.substring(1, right.length);
                }
                if (settingsClone.vMax <= 0 && settingsClone.vMin < settingsClone.vMax && this.value.indexOf(settingsClone.aNeg) === -1 && cCode !== '0') {
                    left = settingsClone.aNeg + left;
                }
                this.setValueParts(left + cCode, right);
                return true;
            } /** prevent any other character */
            return true;
        },
        /**
         * formatting of just processed value with keeping of cursor position
         */
        formatQuick: function () {
            var settingsClone = this.settingsClone,
                parts = this.getBeforeAfterStriped(),
                leftLength = this.value;
            if ((settingsClone.aSep === '' || (settingsClone.aSep !== '' && leftLength.indexOf(settingsClone.aSep) === -1)) && (settingsClone.aSign === '' || (settingsClone.aSign !== '' && leftLength.indexOf(settingsClone.aSign) === -1))) {
                var subParts = [],
                    nSign = '';
                subParts = leftLength.split(settingsClone.aDec);
                if (subParts[0].indexOf('-') > -1) {
                    nSign = '-';
                    subParts[0] = subParts[0].replace('-', '');
                    parts[0] = parts[0].replace('-', '');
                }
                if (subParts[0].length > settingsClone.mInt && parts[0].charAt(0) === '0') { /** strip leading zero if need */
                    parts[0] = parts[0].slice(1);
                }
                parts[0] = nSign + parts[0];
            }
            var value = autoGroup(this.value, this.settingsClone),
                position = value.length;
            if (value) {
                /** prepare regexp which searches for cursor position from unformatted left part */
                var left_ar = parts[0].split(''),
                    i = 0;
                for (i; i < left_ar.length; i += 1) { /** thanks Peter Kovari */
                    if (!left_ar[i].match('\\d')) {
                        left_ar[i] = '\\' + left_ar[i];
                    }
                }
                var leftReg = new RegExp('^.*?' + left_ar.join('.*?'));
                /** search cursor position in formatted value */
                var newLeft = value.match(leftReg);
                if (newLeft) {
                    position = newLeft[0].length;
                    /** if we are just before sign which is in prefix position */
                    if (((position === 0 && value.charAt(0) !== settingsClone.aNeg) || (position === 1 && value.charAt(0) === settingsClone.aNeg)) && settingsClone.aSign && settingsClone.pSign === 'p') {
                        /** place caret after prefix sign */
                        position = this.settingsClone.aSign.length + (value.charAt(0) === '-' ? 1 : 0);
                    }
                } else if (settingsClone.aSign && settingsClone.pSign === 's') {
                    /** if we could not find a place for cursor and have a sign as a suffix */
                    /** place carret before suffix currency sign */
                    position -= settingsClone.aSign.length;
                }
            }
            this.that.value = value;
            this.setPosition(position);
            this.formatted = true;
        }
    };
    /** thanks to Anthony & Evan C */
    function autoGet(obj) {
        if (typeof obj === 'string') {
            obj = obj.replace(/\[/g, "\\[").replace(/\]/g, "\\]");
            obj = '#' + obj.replace(/(:|\.)/g, '\\$1');
            /** obj = '#' + obj.replace(/([;&,\.\+\*\~':"\!\^#$%@\[\]\(\)=>\|])/g, '\\$1'); */
            /** possible modification to replace the above 2 lines */
        }
        return $(obj);
    }

    function getHolder($that, settings, update) {
        var data = $that.data('autoNumeric');
        if (!data) {
            data = {};
            $that.data('autoNumeric', data);
        }
        var holder = data.holder;
        if ((holder === undefined && settings) || update) {
            holder = new AutoNumericHolder($that.get(0), settings);
            data.holder = holder;
        }
        return holder;
    }
    var methods = {
        init: function (options) {
            return this.each(function () {
                var $this = $(this),
                    settings = $this.data('autoNumeric'), /** attempt to grab 'autoNumeric' settings, if they don't exist returns "undefined". */
                    tagData = $this.data(); /** attempt to grab HTML5 data, if they don't exist we'll get "undefined".*/
                if (typeof settings !== 'object') { /** If we couldn't grab settings, create them from defaults and passed options. */
                    var defaults = {
                        /** allowed numeric values
                         * please do not modify
                         */
                        aNum: '0123456789',
                        /** allowed thousand separator characters
                         * comma = ','
                         * period "full stop" = '.'
                         * apostrophe is escaped = '\''
                         * space = ' '
                         * none = ''
                         * NOTE: do not use numeric characters
                         */
                        aSep: ',',
                        /** digital grouping for the thousand separator used in Format
                         * dGroup: '2', results in 99,99,99,999 common in India for values less than 1 billion and greater than -1 billion
                         * dGroup: '3', results in 999,999,999 default
                         * dGroup: '4', results in 9999,9999,9999 used in some Asian countries
                         */
                        dGroup: '3',
                        /** allowed decimal separator characters
                         * period "full stop" = '.'
                         * comma = ','
                         */
                        aDec: '.',
                        /** allow to declare alternative decimal separator which is automatically replaced by aDec
                         * developed for countries the use a comma ',' as the decimal character
                         * and have keyboards\numeric pads that have a period 'full stop' as the decimal characters (Spain is an example)
                         */
                        altDec: null,
                        /** allowed currency symbol
                         * Must be in quotes aSign: '$', a space is allowed aSign: '$ '
                         */
                        aSign: '',
                        /** placement of currency sign
                         * for prefix pSign: 'p',
                         * for suffix pSign: 's',
                         */
                        pSign: 'p',
                        /** maximum possible value
                         * value must be enclosed in quotes and use the period for the decimal point
                         * value must be larger than vMin
                         */
                        vMax: '9999999999999.99',
                        /** minimum possible value
                         * value must be enclosed in quotes and use the period for the decimal point
                         * value must be smaller than vMax
                         */
                        vMin: '0.00',
                        /** max number of decimal places = used to override decimal places set by the vMin & vMax values
                         * value must be enclosed in quotes example mDec: '3',
                         * This can also set the value via a call back function mDec: 'css:#
                         */
                        mDec: null,
                        /** method used for rounding
                         * mRound: 'S', Round-Half-Up Symmetric (default)
                         * mRound: 'A', Round-Half-Up Asymmetric
                         * mRound: 's', Round-Half-Down Symmetric (lower case s)
                         * mRound: 'a', Round-Half-Down Asymmetric (lower case a)
                         * mRound: 'B', Round-Half-Even "Bankers Rounding"
                         * mRound: 'U', Round Up "Round-Away-From-Zero"
                         * mRound: 'D', Round Down "Round-Toward-Zero" - same as truncate
                         * mRound: 'C', Round to Ceiling "Toward Positive Infinity"
                         * mRound: 'F', Round to Floor "Toward Negative Infinity"
                         */
                        mRound: 'S',
                        /** controls decimal padding
                         * aPad: true - always Pad decimals with zeros
                         * aPad: false - does not pad with zeros.
                         * aPad: `some number` - pad decimals with zero to number different from mDec
                         * thanks to Jonas Johansson for the suggestion
                         */
                        aPad: true,
                        /** places brackets on negative value -$ 999.99 to (999.99)
                         * visible only when the field does NOT have focus the left and right symbols should be enclosed in quotes and seperated by a comma
                         * nBracket: null, nBracket: '(,)', nBracket: '[,]', nBracket: '<,>' or nBracket: '{,}'
                         */
                        nBracket: null,
                        /** Displayed on empty string
                         * wEmpty: 'empty', - input can be blank
                         * wEmpty: 'zero', - displays zero
                         * wEmpty: 'sign', - displays the currency sign
                         */
                        wEmpty: 'empty',
                        /** controls leading zero behavior
                         * lZero: 'allow', - allows leading zeros to be entered. Zeros will be truncated when entering additional digits. On focusout zeros will be deleted.
                         * lZero: 'deny', - allows only one leading zero on values less than one
                         * lZero: 'keep', - allows leading zeros to be entered. on fousout zeros will be retained.
                         */
                        lZero: 'allow',
                        /** determine if the default value will be formatted on page ready.
                         * true = automatically formats the default value on page ready
                         * false = will not format the default value
                         */
                        aForm: true,
                        /** future use */
                        onSomeEvent: function () {}
                    };
                    settings = $.extend({}, defaults, tagData, options); /** Merge defaults, tagData and options */
                    if (settings.aDec === settings.aSep) {
                        $.error("autoNumeric will not function properly when the decimal character aDec: '" + settings.aDec + "' and thousand separator aSep: '" + settings.aSep + "' are the same character");
                        return this;
                    }
                    $this.data('autoNumeric', settings); /** Save our new settings */
                } else {
                    return this;
                }
                settings.runOnce = false;
                var holder = getHolder($this, settings);
                if ($.inArray($this.prop('tagName').toLowerCase(), settings.tagList) === -1 && $this.prop('tagName').toLowerCase() !== 'input') {
                    $.error("The <" + $this.prop('tagName').toLowerCase() + "> is not supported by autoNumeric()");
                    return this;
                }
                if (settings.runOnce === false && settings.aForm) {/** routine to format default value on page load */
                    if ($this.is('input[type=text], input[type=hidden], input[type=tel], input:not([type])')) {
                        var setValue = true;
                        if ($this[0].value === '' && settings.wEmpty === 'empty') {
                            $this[0].value = '';
                            setValue = false;
                        }
                        if ($this[0].value === '' && settings.wEmpty === 'sign') {
                            $this[0].value = settings.aSign;
                            setValue = false;
                        }
                        if (setValue) {
                            $this.autoNumeric('set', $this.val());
                        }
                    }
                    if ($.inArray($this.prop('tagName').toLowerCase(), settings.tagList) !== -1 && $this.text() !== '') {
                        $this.autoNumeric('set', $this.text());
                    }
                }
                settings.runOnce = true;
                if ($this.is('input[type=text], input[type=hidden], input[type=tel], input:not([type])')) { /**added hidden type */
                    $this.on('keydown.autoNumeric', function (e) {
                        holder = getHolder($this);
                        if (holder.settings.aDec === holder.settings.aSep) {
                            $.error("autoNumeric will not function properly when the decimal character aDec: '" + holder.settings.aDec + "' and thousand separator aSep: '" + holder.settings.aSep + "' are the same character");
                            return this;
                        }
                        if (holder.that.readOnly) {
                            holder.processed = true;
                            return true;
                        }
                        /** The below streamed code / comment allows the "enter" keydown to throw a change() event */
                        /** if (e.keyCode === 13 && holder.inVal !== $this.val()){
                            $this.change();
                            holder.inVal = $this.val();
                        }*/
                        holder.init(e);
                        holder.settings.oEvent = 'keydown';
                        if (holder.skipAllways(e)) {
                            holder.processed = true;
                            return true;
                        }
                        if (holder.processAllways()) {
                            holder.processed = true;
                            holder.formatQuick();
                            e.preventDefault();
                            return false;
                        }
                        holder.formatted = false;
                        return true;
                    });
                    $this.on('keypress.autoNumeric', function (e) {
                        var holder = getHolder($this),
                            processed = holder.processed;
                        holder.init(e);
                        holder.settings.oEvent = 'keypress';
                        if (holder.skipAllways(e)) {
                            return true;
                        }
                        if (processed) {
                            e.preventDefault();
                            return false;
                        }
                        if (holder.processAllways() || holder.processKeypress()) {
                            holder.formatQuick();
                            e.preventDefault();
                            return false;
                        }
                        holder.formatted = false;
                    });
                    $this.on('keyup.autoNumeric', function (e) {
                        var holder = getHolder($this);
                        holder.init(e);
                        holder.settings.oEvent = 'keyup';
                        var skip = holder.skipAllways(e);
                        holder.kdCode = 0;
                        delete holder.valuePartsBeforePaste;
                        if ($this[0].value === holder.settings.aSign) { /** added to properly place the caret when only the currency is present */
                            if (holder.settings.pSign === 's') {
                                setElementSelection(this, 0, 0);
                            } else {
                                setElementSelection(this, holder.settings.aSign.length, holder.settings.aSign.length);
                            }
                        }
                        if (skip) {
                            return true;
                        }
                        if (this.value === '') {
                            return true;
                        }
                        if (!holder.formatted) {
                            holder.formatQuick();
                        }
                    });
                    $this.on('focusin.autoNumeric', function () {
                        var holder = getHolder($this);
                        holder.settingsClone.oEvent = 'focusin';
                        if (holder.settingsClone.nBracket !== null) {
                            var checkVal = $this.val();
                            $this.val(negativeBracket(checkVal, holder.settingsClone.nBracket, holder.settingsClone.oEvent));
                        }
                        holder.inVal = $this.val();
                        var onempty = checkEmpty(holder.inVal, holder.settingsClone, true);
                        if (onempty !== null) {
                            $this.val(onempty);
                            if (holder.settings.pSign === 's') {
                                setElementSelection(this, 0, 0);
                            } else {
                                setElementSelection(this, holder.settings.aSign.length, holder.settings.aSign.length);
                            }
                        }
                    });
                    $this.on('focusout.autoNumeric', function () {
                        var holder = getHolder($this),
                            settingsClone = holder.settingsClone,
                            value = $this.val(),
                            origValue = value;
                        holder.settingsClone.oEvent = 'focusout';
                        var strip_zero = ''; /** added to control leading zero */
                        if (settingsClone.lZero === 'allow') { /** added to control leading zero */
                            settingsClone.allowLeading = false;
                            strip_zero = 'leading';
                        }
                        if (value !== '') {
                            value = autoStrip(value, settingsClone, strip_zero);
                            if (checkEmpty(value, settingsClone) === null && autoCheck(value, settingsClone, $this[0])) {
                                value = fixNumber(value, settingsClone.aDec, settingsClone.aNeg);
                                value = autoRound(value, settingsClone);
                                value = presentNumber(value, settingsClone.aDec, settingsClone.aNeg);
                            } else {
                                value = '';
                            }
                        }
                        var groupedValue = checkEmpty(value, settingsClone, false);
                        if (groupedValue === null) {
                            groupedValue = autoGroup(value, settingsClone);
                        }
                        if (groupedValue !== origValue) {
                            $this.val(groupedValue);
                        }
                        if (groupedValue !== holder.inVal) {
                            $this.change();
                            delete holder.inVal;
                        }
                        if (settingsClone.nBracket !== null && $this.autoNumeric('get') < 0) {
                            holder.settingsClone.oEvent = 'focusout';
                            $this.val(negativeBracket($this.val(), settingsClone.nBracket, settingsClone.oEvent));
                        }
                    });
                }
            });
        },
        /** method to remove settings and stop autoNumeric() */
        destroy: function () {
            return $(this).each(function () {
                var $this = $(this);
                $this.off('.autoNumeric');
                $this.removeData('autoNumeric');
            });
        },
        /** method to update settings - can call as many times */
        update: function (options) {
            return $(this).each(function () {
                var $this = autoGet($(this)),
                    settings = $this.data('autoNumeric');
                if (typeof settings !== 'object') {
                    $.error("You must initialize autoNumeric('init', {options}) prior to calling the 'update' method");
                    return this;
                }
                var strip = $this.autoNumeric('get');
                settings = $.extend(settings, options);
                getHolder($this, settings, true);
                if (settings.aDec === settings.aSep) {
                    $.error("autoNumeric will not function properly when the decimal character aDec: '" + settings.aDec + "' and thousand separator aSep: '" + settings.aSep + "' are the same character");
                    return this;
                }
                $this.data('autoNumeric', settings);
                if ($this.val() !== '' || $this.text() !== '') {
                    return $this.autoNumeric('set', strip);
                }
                return;
            });
        },
        /** returns a formatted strings for "input:text" fields Uses jQuery's .val() method*/
        set: function (valueIn) {
            if (valueIn === null) {
                return;
            }
            return $(this).each(function () {
                var $this = autoGet($(this)),
                    settings = $this.data('autoNumeric'),
                    value = valueIn.toString(),
                    testValue = valueIn.toString();
                if (typeof settings !== 'object') {
                    $.error("You must initialize autoNumeric('init', {options}) prior to calling the 'set' method");
                    return this;
                }
                /** routine to handle page re-load from back button */
                if (testValue !== $this.attr('value') && $this.prop('tagName').toLowerCase() === 'input' && settings.runOnce === false) {
                    value = (settings.nBracket !== null) ? negativeBracket($this.val(), settings.nBracket, 'pageLoad') : value;
                    value = autoStrip(value, settings);
                }
               /** allows locale decimal separator to be a comma */
                if ((testValue === $this.attr('value') || testValue === $this.text()) && settings.runOnce === false) {
                    value = value.replace(',', '.');
                }
                /** returns a empty string if the value being 'set' contains non-numeric characters and or more than decimal point (full stop) and will not be formatted */
                if (!$.isNumeric(+value)) {
                    return '';
                }
                value = checkValue(value, settings);
                settings.oEvent = 'set';
                value.toString();
                if (value !== '') {
                    value = autoRound(value, settings);
                }
                value = presentNumber(value, settings.aDec, settings.aNeg);
                if (!autoCheck(value, settings)) {
                    value = autoRound('', settings);
                }
                value = autoGroup(value, settings);
                if ($this.is('input[type=text], input[type=hidden], input[type=tel], input:not([type])')) { /**added hidden type */
                    return $this.val(value);
                }
                if ($.inArray($this.prop('tagName').toLowerCase(), settings.tagList) !== -1) {
                    return $this.text(value);
                }
                $.error("The <" + $this.prop('tagName').toLowerCase() + "> is not supported by autoNumeric()");
                return false;
            });
        },
        /** method to get the unformatted value from a specific input field, returns a numeric value */
        get: function () {
            var $this = autoGet($(this)),
                settings = $this.data('autoNumeric');
            if (typeof settings !== 'object') {
                $.error("You must initialize autoNumeric('init', {options}) prior to calling the 'get' method");
                return this;
            }
            settings.oEvent = 'get';
            var getValue = '';
            /** determine the element type then use .eq(0) selector to grab the value of the first element in selector */
            if ($this.is('input[type=text], input[type=hidden], input[type=tel], input:not([type])')) { /**added hidden type */
                getValue = $this.eq(0).val();
            } else if ($.inArray($this.prop('tagName').toLowerCase(), settings.tagList) !== -1) {
                getValue = $this.eq(0).text();
            } else {
                $.error("The <" + $this.prop('tagName').toLowerCase() + "> is not supported by autoNumeric()");
                return false;
            }
            if ((getValue === '' && settings.wEmpty === 'empty') || (getValue === settings.aSign && (settings.wEmpty === 'sign' || settings.wEmpty === 'empty'))) {
                return '';
            }
            if (settings.nBracket !== null && getValue !== '') {
                getValue = negativeBracket(getValue, settings.nBracket, settings.oEvent);
            }
            if (settings.runOnce || settings.aForm === false) {
                getValue = autoStrip(getValue, settings);
            }
            getValue = fixNumber(getValue, settings.aDec, settings.aNeg);
            if (+getValue === 0 && settings.lZero !== 'keep') {
                getValue = '0';
            }
            if (settings.lZero === 'keep') {
                return getValue;
            }
            getValue = checkValue(getValue, settings);
            return getValue; /** returned Numeric String */
        },
        /** method to get the unformatted value from multiple fields */
        getString: function () {
            var isAutoNumeric = false,
                $this = autoGet($(this)),
                str = $this.serialize(),
                parts = str.split('&'),
                formIndex = $('form').index($this),
                i = 0;
            for (i; i < parts.length; i += 1) {
                var miniParts = parts[i].split('='),
                    $field = $('form:eq(' + formIndex + ') input[name="' + decodeURIComponent(miniParts[0]) + '"]'),
                    settings = $field.data('autoNumeric');
                if (typeof settings === 'object') {
                    if (miniParts[1] !== null) {
                        miniParts[1] = $field.autoNumeric('get');
                        parts[i] = miniParts.join('=');
                        isAutoNumeric = true;
                    }
                }
            }
            if (isAutoNumeric === true) {
                return parts.join('&');
            }
            return str;
        },
        /** method to get the unformatted value from multiple fields */
        getArray: function () {
            var isAutoNumeric = false,
                $this = autoGet($(this)),
                formFields = $this.serializeArray(),
                formIndex = $('form').index($this);
            /*jslint unparam: true*/
            $.each(formFields, function (i, field) {
                var $field = $('form:eq(' + formIndex + ') input[name="' + decodeURIComponent(field.name) + '"]'),
                    settings = $field.data('autoNumeric');
                if (typeof settings === 'object') {
                    if (field.value !== '') {
                        field.value = $field.autoNumeric('get').toString();
                    }
                    isAutoNumeric = true;
                }
            });
            /*jslint unparam: false*/
            if (isAutoNumeric === true) {
                return formFields;
            }
            return this;
        },
        /** returns the settings object for those who need to look under the hood */
        getSettings: function () {
            var $this = autoGet($(this));
            return $this.eq(0).data('autoNumeric');
        }
    };
    $.fn.autoNumeric = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        }
        if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        }
        $.error('Method "' + method + '" is not supported by autoNumeric()');
    };
}(jQuery));
(function() {
  var $, AbstractChosen, Chosen, SelectParser, _ref,
    __hasProp = {}.hasOwnProperty,
    __extends = function(child, parent) { for (var key in parent) { if (__hasProp.call(parent, key)) child[key] = parent[key]; } function ctor() { this.constructor = child; } ctor.prototype = parent.prototype; child.prototype = new ctor(); child.__super__ = parent.prototype; return child; };

  SelectParser = (function() {
    function SelectParser() {
      this.options_index = 0;
      this.parsed = [];
    }

    SelectParser.prototype.add_node = function(child) {
      if (child.nodeName.toUpperCase() === "OPTGROUP") {
        return this.add_group(child);
      } else {
        return this.add_option(child);
      }
    };

    SelectParser.prototype.add_group = function(group) {
      var group_position, option, _i, _len, _ref, _results;
      group_position = this.parsed.length;
      this.parsed.push({
        array_index: group_position,
        group: true,
        label: this.escapeExpression(group.label),
        title: group.title ? group.title : void 0,
        children: 0,
        disabled: group.disabled,
        classes: group.className
      });
      _ref = group.childNodes;
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        option = _ref[_i];
        _results.push(this.add_option(option, group_position, group.disabled));
      }
      return _results;
    };

    SelectParser.prototype.add_option = function(option, group_position, group_disabled) {
      if (option.nodeName.toUpperCase() === "OPTION") {
        if (option.text !== "") {
          if (group_position != null) {
            this.parsed[group_position].children += 1;
          }
          this.parsed.push({
            array_index: this.parsed.length,
            options_index: this.options_index,
            value: option.value,
            text: option.text,
            html: option.innerHTML,
            title: option.title ? option.title : void 0,
            selected: option.selected,
            disabled: group_disabled === true ? group_disabled : option.disabled,
            group_array_index: group_position,
            group_label: group_position != null ? this.parsed[group_position].label : null,
            classes: option.className,
            style: option.style.cssText
          });
        } else {
          this.parsed.push({
            array_index: this.parsed.length,
            options_index: this.options_index,
            empty: true
          });
        }
        return this.options_index += 1;
      }
    };

    SelectParser.prototype.escapeExpression = function(text) {
      var map, unsafe_chars;
      if ((text == null) || text === false) {
        return "";
      }
      if (!/[\&\<\>\"\'\`]/.test(text)) {
        return text;
      }
      map = {
        "<": "&lt;",
        ">": "&gt;",
        '"': "&quot;",
        "'": "&#x27;",
        "`": "&#x60;"
      };
      unsafe_chars = /&(?!\w+;)|[\<\>\"\'\`]/g;
      return text.replace(unsafe_chars, function(chr) {
        return map[chr] || "&amp;";
      });
    };

    return SelectParser;

  })();

  SelectParser.select_to_array = function(select) {
    var child, parser, _i, _len, _ref;
    parser = new SelectParser();
    _ref = select.childNodes;
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
      child = _ref[_i];
      parser.add_node(child);
    }
    return parser.parsed;
  };

  AbstractChosen = (function() {
    function AbstractChosen(form_field, options) {
      this.form_field = form_field;
      this.options = options != null ? options : {};
      if (!AbstractChosen.browser_is_supported()) {
        return;
      }
      this.is_multiple = this.form_field.multiple;
      this.set_default_text();
      this.set_default_values();
      this.setup();
      this.set_up_html();
      this.register_observers();
      this.on_ready();
    }

    AbstractChosen.prototype.set_default_values = function() {
      var _this = this;
      this.click_test_action = function(evt) {
        return _this.test_active_click(evt);
      };
      this.activate_action = function(evt) {
        return _this.activate_field(evt);
      };
      this.active_field = false;
      this.mouse_on_container = false;
      this.results_showing = false;
      this.result_highlighted = null;
      this.allow_single_deselect = (this.options.allow_single_deselect != null) && (this.form_field.options[0] != null) && this.form_field.options[0].text === "" ? this.options.allow_single_deselect : false;
      this.disable_search_threshold = this.options.disable_search_threshold || 0;
      this.disable_search = this.options.disable_search || false;
      this.enable_split_word_search = this.options.enable_split_word_search != null ? this.options.enable_split_word_search : true;
      this.group_search = this.options.group_search != null ? this.options.group_search : true;
      this.search_contains = this.options.search_contains || false;
      this.single_backstroke_delete = this.options.single_backstroke_delete != null ? this.options.single_backstroke_delete : true;
      this.max_selected_options = this.options.max_selected_options || Infinity;
      this.inherit_select_classes = this.options.inherit_select_classes || false;
      this.display_selected_options = this.options.display_selected_options != null ? this.options.display_selected_options : true;
      this.display_disabled_options = this.options.display_disabled_options != null ? this.options.display_disabled_options : true;
      this.include_group_label_in_selected = this.options.include_group_label_in_selected || false;
      this.max_shown_results = this.options.max_shown_results || Number.POSITIVE_INFINITY;
      return this.case_sensitive_search = this.options.case_sensitive_search || false;
    };

    AbstractChosen.prototype.set_default_text = function() {
      if (this.form_field.getAttribute("data-placeholder")) {
        this.default_text = this.form_field.getAttribute("data-placeholder");
      } else if (this.is_multiple) {
        this.default_text = this.options.placeholder_text_multiple || this.options.placeholder_text || AbstractChosen.default_multiple_text;
      } else {
        this.default_text = this.options.placeholder_text_single || this.options.placeholder_text || AbstractChosen.default_single_text;
      }
      return this.results_none_found = this.form_field.getAttribute("data-no_results_text") || this.options.no_results_text || AbstractChosen.default_no_result_text;
    };

    AbstractChosen.prototype.choice_label = function(item) {
      if (this.include_group_label_in_selected && (item.group_label != null)) {
        return "<b class='group-name'>" + item.group_label + "</b>" + item.html;
      } else {
        return item.html;
      }
    };

    AbstractChosen.prototype.mouse_enter = function() {
      return this.mouse_on_container = true;
    };

    AbstractChosen.prototype.mouse_leave = function() {
      return this.mouse_on_container = false;
    };

    AbstractChosen.prototype.input_focus = function(evt) {
      var _this = this;
      if (this.is_multiple) {
        if (!this.active_field) {
          return setTimeout((function() {
            return _this.container_mousedown();
          }), 50);
        }
      } else {
        if (!this.active_field) {
          return this.activate_field();
        }
      }
    };

    AbstractChosen.prototype.input_blur = function(evt) {
      var _this = this;
      if (!this.mouse_on_container) {
        this.active_field = false;
        return setTimeout((function() {
          return _this.blur_test();
        }), 100);
      }
    };

    AbstractChosen.prototype.results_option_build = function(options) {
      var content, data, data_content, shown_results, _i, _len, _ref;
      content = '';
      shown_results = 0;
      _ref = this.results_data;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        data = _ref[_i];
        data_content = '';
        if (data.group) {
          data_content = this.result_add_group(data);
        } else {
          data_content = this.result_add_option(data);
        }
        if (data_content !== '') {
          shown_results++;
          content += data_content;
        }
        if (options != null ? options.first : void 0) {
          if (data.selected && this.is_multiple) {
            this.choice_build(data);
          } else if (data.selected && !this.is_multiple) {
            this.single_set_selected_text(this.choice_label(data));
          }
        }
        if (shown_results >= this.max_shown_results) {
          break;
        }
      }
      return content;
    };

    AbstractChosen.prototype.result_add_option = function(option) {
      var classes, option_el;
      if (!option.search_match) {
        return '';
      }
      if (!this.include_option_in_results(option)) {
        return '';
      }
      classes = [];
      if (!option.disabled && !(option.selected && this.is_multiple)) {
        classes.push("active-result");
      }
      if (option.disabled && !(option.selected && this.is_multiple)) {
        classes.push("disabled-result");
      }
      if (option.selected) {
        classes.push("result-selected");
      }
      if (option.group_array_index != null) {
        classes.push("group-option");
      }
      if (option.classes !== "") {
        classes.push(option.classes);
      }
      option_el = document.createElement("li");
      option_el.className = classes.join(" ");
      option_el.style.cssText = option.style;
      option_el.setAttribute("data-option-array-index", option.array_index);
      option_el.innerHTML = option.search_text;
      if (option.title) {
        option_el.title = option.title;
      }
      return this.outerHTML(option_el);
    };

    AbstractChosen.prototype.result_add_group = function(group) {
      var classes, group_el;
      if (!(group.search_match || group.group_match)) {
        return '';
      }
      if (!(group.active_options > 0)) {
        return '';
      }
      classes = [];
      classes.push("group-result");
      if (group.classes) {
        classes.push(group.classes);
      }
      group_el = document.createElement("li");
      group_el.className = classes.join(" ");
      group_el.innerHTML = group.search_text;
      if (group.title) {
        group_el.title = group.title;
      }
      return this.outerHTML(group_el);
    };

    AbstractChosen.prototype.results_update_field = function() {
      this.set_default_text();
      if (!this.is_multiple) {
        this.results_reset_cleanup();
      }
      this.result_clear_highlight();
      this.results_build();
      if (this.results_showing) {
        return this.winnow_results();
      }
    };

    AbstractChosen.prototype.reset_single_select_options = function() {
      var result, _i, _len, _ref, _results;
      _ref = this.results_data;
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        result = _ref[_i];
        if (result.selected) {
          _results.push(result.selected = false);
        } else {
          _results.push(void 0);
        }
      }
      return _results;
    };

    AbstractChosen.prototype.results_toggle = function() {
      if (this.results_showing) {
        return this.results_hide();
      } else {
        return this.results_show();
      }
    };

    AbstractChosen.prototype.results_search = function(evt) {
      if (this.results_showing) {
        return this.winnow_results();
      } else {
        return this.results_show();
      }
    };

    AbstractChosen.prototype.winnow_results = function() {
      var escapedSearchText, option, regex, results, results_group, searchText, startpos, text, zregex, _i, _len, _ref;
      this.no_results_clear();
      results = 0;
      searchText = this.get_search_text();
      escapedSearchText = searchText.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
      zregex = new RegExp(escapedSearchText, 'i');
      regex = this.get_search_regex(escapedSearchText);
      _ref = this.results_data;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        option = _ref[_i];
        option.search_match = false;
        results_group = null;
        if (this.include_option_in_results(option)) {
          if (option.group) {
            option.group_match = false;
            option.active_options = 0;
          }
          if ((option.group_array_index != null) && this.results_data[option.group_array_index]) {
            results_group = this.results_data[option.group_array_index];
            if (results_group.active_options === 0 && results_group.search_match) {
              results += 1;
            }
            results_group.active_options += 1;
          }
          option.search_text = option.group ? option.label : option.html;
          if (!(option.group && !this.group_search)) {
            option.search_match = this.search_string_match(option.search_text, regex);
            if (option.search_match && !option.group) {
              results += 1;
            }
            if (option.search_match) {
              if (searchText.length) {
                startpos = option.search_text.search(zregex);
                text = option.search_text.substr(0, startpos + searchText.length) + '</em>' + option.search_text.substr(startpos + searchText.length);
                option.search_text = text.substr(0, startpos) + '<em>' + text.substr(startpos);
              }
              if (results_group != null) {
                results_group.group_match = true;
              }
            } else if ((option.group_array_index != null) && this.results_data[option.group_array_index].search_match) {
              option.search_match = true;
            }
          }
        }
      }
      this.result_clear_highlight();
      if (results < 1 && searchText.length) {
        this.update_results_content("");
        return this.no_results(searchText);
      } else {
        this.update_results_content(this.results_option_build());
        return this.winnow_results_set_highlight();
      }
    };

    AbstractChosen.prototype.get_search_regex = function(escaped_search_string) {
      var regex_anchor, regex_flag;
      regex_anchor = this.search_contains ? "" : "^";
      regex_flag = this.case_sensitive_search ? "" : "i";
      return new RegExp(regex_anchor + escaped_search_string, regex_flag);
    };

    AbstractChosen.prototype.search_string_match = function(search_string, regex) {
      var part, parts, _i, _len;
      if (regex.test(search_string)) {
        return true;
      } else if (this.enable_split_word_search && (search_string.indexOf(" ") >= 0 || search_string.indexOf("[") === 0)) {
        parts = search_string.replace(/\[|\]/g, "").split(" ");
        if (parts.length) {
          for (_i = 0, _len = parts.length; _i < _len; _i++) {
            part = parts[_i];
            if (regex.test(part)) {
              return true;
            }
          }
        }
      }
    };

    AbstractChosen.prototype.choices_count = function() {
      var option, _i, _len, _ref;
      if (this.selected_option_count != null) {
        return this.selected_option_count;
      }
      this.selected_option_count = 0;
      _ref = this.form_field.options;
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        option = _ref[_i];
        if (option.selected) {
          this.selected_option_count += 1;
        }
      }
      return this.selected_option_count;
    };

    AbstractChosen.prototype.choices_click = function(evt) {
      evt.preventDefault();
      if (!(this.results_showing || this.is_disabled)) {
        return this.results_show();
      }
    };

    AbstractChosen.prototype.keyup_checker = function(evt) {
      var stroke, _ref;
      stroke = (_ref = evt.which) != null ? _ref : evt.keyCode;
      this.search_field_scale();
      switch (stroke) {
        case 8:
          if (this.is_multiple && this.backstroke_length < 1 && this.choices_count() > 0) {
            return this.keydown_backstroke();
          } else if (!this.pending_backstroke) {
            this.result_clear_highlight();
            return this.results_search();
          }
          break;
        case 13:
          evt.preventDefault();
          if (this.results_showing) {
            return this.result_select(evt);
          }
          break;
        case 27:
          if (this.results_showing) {
            this.results_hide();
          }
          return true;
        case 9:
        case 38:
        case 40:
        case 16:
        case 91:
        case 17:
        case 18:
          break;
        default:
          return this.results_search();
      }
    };

    AbstractChosen.prototype.clipboard_event_checker = function(evt) {
      var _this = this;
      return setTimeout((function() {
        return _this.results_search();
      }), 50);
    };

    AbstractChosen.prototype.container_width = function() {
      if (this.options.width != null) {
        return this.options.width;
      } else {
        return "" + this.form_field.offsetWidth + "px";
      }
    };

    AbstractChosen.prototype.include_option_in_results = function(option) {
      if (this.is_multiple && (!this.display_selected_options && option.selected)) {
        return false;
      }
      if (!this.display_disabled_options && option.disabled) {
        return false;
      }
      if (option.empty) {
        return false;
      }
      return true;
    };

    AbstractChosen.prototype.search_results_touchstart = function(evt) {
      this.touch_started = true;
      return this.search_results_mouseover(evt);
    };

    AbstractChosen.prototype.search_results_touchmove = function(evt) {
      this.touch_started = false;
      return this.search_results_mouseout(evt);
    };

    AbstractChosen.prototype.search_results_touchend = function(evt) {
      if (this.touch_started) {
        return this.search_results_mouseup(evt);
      }
    };

    AbstractChosen.prototype.outerHTML = function(element) {
      var tmp;
      if (element.outerHTML) {
        return element.outerHTML;
      }
      tmp = document.createElement("div");
      tmp.appendChild(element);
      return tmp.innerHTML;
    };

    AbstractChosen.browser_is_supported = function() {
      if ("Microsoft Internet Explorer" === window.navigator.appName) {
        return document.documentMode >= 8;
      }
      if (/iP(od|hone)/i.test(window.navigator.userAgent) || /IEMobile/i.test(window.navigator.userAgent) || /Windows Phone/i.test(window.navigator.userAgent) || /BlackBerry/i.test(window.navigator.userAgent) || /BB10/i.test(window.navigator.userAgent) || /Android.*Mobile/i.test(window.navigator.userAgent)) {
        return false;
      }
      return true;
    };

    AbstractChosen.default_multiple_text = "Select Some Options";

    AbstractChosen.default_single_text = "Select an Option";

    AbstractChosen.default_no_result_text = "No results match";

    return AbstractChosen;

  })();

  $ = jQuery;

  $.fn.extend({
    chosen: function(options) {
      if (!AbstractChosen.browser_is_supported()) {
        return this;
      }
      return this.each(function(input_field) {
        var $this, chosen;
        $this = $(this);
        chosen = $this.data('chosen');
        if (options === 'destroy') {
          if (chosen instanceof Chosen) {
            chosen.destroy();
          }
          return;
        }
        if (!(chosen instanceof Chosen)) {
          $this.data('chosen', new Chosen(this, options));
        }
      });
    }
  });

  Chosen = (function(_super) {
    __extends(Chosen, _super);

    function Chosen() {
      _ref = Chosen.__super__.constructor.apply(this, arguments);
      return _ref;
    }

    Chosen.prototype.setup = function() {
      this.form_field_jq = $(this.form_field);
      this.current_selectedIndex = this.form_field.selectedIndex;
      return this.is_rtl = this.form_field_jq.hasClass("chosen-rtl");
    };

    Chosen.prototype.set_up_html = function() {
      var container_classes, container_props;
      container_classes = ["chosen-container"];
      container_classes.push("chosen-container-" + (this.is_multiple ? "multi" : "single"));
      if (this.inherit_select_classes && this.form_field.className) {
        container_classes.push(this.form_field.className);
      }
      if (this.is_rtl) {
        container_classes.push("chosen-rtl");
      }
      container_props = {
        'class': container_classes.join(' '),
        'style': "width: " + (this.container_width()) + ";",
        'title': this.form_field.title
      };
      if (this.form_field.id.length) {
        container_props.id = this.form_field.id.replace(/[^\w]/g, '_') + "_chosen";
      }
      this.container = $("<div />", container_props);
      if (this.is_multiple) {
        this.container.html('<ul class="chosen-choices"><li class="search-field"><input type="text" value="' + this.default_text + '" class="default" autocomplete="off" style="width:25px;" /></li></ul><div class="chosen-drop"><ul class="chosen-results"></ul></div>');
      } else {
        this.container.html('<a class="chosen-single chosen-default"><span>' + this.default_text + '</span><div><b></b></div></a><div class="chosen-drop"><div class="chosen-search"><input type="text" autocomplete="off" /></div><ul class="chosen-results"></ul></div>');
      }
      this.form_field_jq.hide().after(this.container);
      this.dropdown = this.container.find('div.chosen-drop').first();
      this.search_field = this.container.find('input').first();
      this.search_results = this.container.find('ul.chosen-results').first();
      this.search_field_scale();
      this.search_no_results = this.container.find('li.no-results').first();
      if (this.is_multiple) {
        this.search_choices = this.container.find('ul.chosen-choices').first();
        this.search_container = this.container.find('li.search-field').first();
      } else {
        this.search_container = this.container.find('div.chosen-search').first();
        this.selected_item = this.container.find('.chosen-single').first();
      }
      this.results_build();
      this.set_tab_index();
      return this.set_label_behavior();
    };

    Chosen.prototype.on_ready = function() {
      return this.form_field_jq.trigger("chosen:ready", {
        chosen: this
      });
    };

    Chosen.prototype.register_observers = function() {
      var _this = this;
      this.container.bind('touchstart.chosen', function(evt) {
        _this.container_mousedown(evt);
        return evt.preventDefault();
      });
      this.container.bind('touchend.chosen', function(evt) {
        _this.container_mouseup(evt);
        return evt.preventDefault();
      });
      this.container.bind('mousedown.chosen', function(evt) {
        _this.container_mousedown(evt);
      });
      this.container.bind('mouseup.chosen', function(evt) {
        _this.container_mouseup(evt);
      });
      this.container.bind('mouseenter.chosen', function(evt) {
        _this.mouse_enter(evt);
      });
      this.container.bind('mouseleave.chosen', function(evt) {
        _this.mouse_leave(evt);
      });
      this.search_results.bind('mouseup.chosen', function(evt) {
        _this.search_results_mouseup(evt);
      });
      this.search_results.bind('mouseover.chosen', function(evt) {
        _this.search_results_mouseover(evt);
      });
      this.search_results.bind('mouseout.chosen', function(evt) {
        _this.search_results_mouseout(evt);
      });
      this.search_results.bind('mousewheel.chosen DOMMouseScroll.chosen', function(evt) {
        _this.search_results_mousewheel(evt);
      });
      this.search_results.bind('touchstart.chosen', function(evt) {
        _this.search_results_touchstart(evt);
      });
      this.search_results.bind('touchmove.chosen', function(evt) {
        _this.search_results_touchmove(evt);
      });
      this.search_results.bind('touchend.chosen', function(evt) {
        _this.search_results_touchend(evt);
      });
      this.form_field_jq.bind("chosen:updated.chosen", function(evt) {
        _this.results_update_field(evt);
      });
      this.form_field_jq.bind("chosen:activate.chosen", function(evt) {
        _this.activate_field(evt);
      });
      this.form_field_jq.bind("chosen:open.chosen", function(evt) {
        _this.container_mousedown(evt);
      });
      this.form_field_jq.bind("chosen:close.chosen", function(evt) {
        _this.input_blur(evt);
      });
      this.search_field.bind('blur.chosen', function(evt) {
        _this.input_blur(evt);
      });
      this.search_field.bind('keyup.chosen', function(evt) {
        _this.keyup_checker(evt);
      });
      this.search_field.bind('keydown.chosen', function(evt) {
        _this.keydown_checker(evt);
      });
      this.search_field.bind('focus.chosen', function(evt) {
        _this.input_focus(evt);
      });
      this.search_field.bind('cut.chosen', function(evt) {
        _this.clipboard_event_checker(evt);
      });
      this.search_field.bind('paste.chosen', function(evt) {
        _this.clipboard_event_checker(evt);
      });
      if (this.is_multiple) {
        return this.search_choices.bind('click.chosen', function(evt) {
          _this.choices_click(evt);
        });
      } else {
        return this.container.bind('click.chosen', function(evt) {
          evt.preventDefault();
        });
      }
    };

    Chosen.prototype.destroy = function() {
      $(this.container[0].ownerDocument).unbind("click.chosen", this.click_test_action);
      if (this.search_field[0].tabIndex) {
        this.form_field_jq[0].tabIndex = this.search_field[0].tabIndex;
      }
      this.container.remove();
      this.form_field_jq.removeData('chosen');
      return this.form_field_jq.show();
    };

    Chosen.prototype.search_field_disabled = function() {
      this.is_disabled = this.form_field_jq[0].disabled;
      if (this.is_disabled) {
        this.container.addClass('chosen-disabled');
        this.search_field[0].disabled = true;
        if (!this.is_multiple) {
          this.selected_item.unbind("focus.chosen", this.activate_action);
        }
        return this.close_field();
      } else {
        this.container.removeClass('chosen-disabled');
        this.search_field[0].disabled = false;
        if (!this.is_multiple) {
          return this.selected_item.bind("focus.chosen", this.activate_action);
        }
      }
    };

    Chosen.prototype.container_mousedown = function(evt) {
      if (!this.is_disabled) {
        if (evt && evt.type === "mousedown" && !this.results_showing) {
          evt.preventDefault();
        }
        if (!((evt != null) && ($(evt.target)).hasClass("search-choice-close"))) {
          if (!this.active_field) {
            if (this.is_multiple) {
              this.search_field.val("");
            }
            $(this.container[0].ownerDocument).bind('click.chosen', this.click_test_action);
            this.results_show();
          } else if (!this.is_multiple && evt && (($(evt.target)[0] === this.selected_item[0]) || $(evt.target).parents("a.chosen-single").length)) {
            evt.preventDefault();
            this.results_toggle();
          }
          return this.activate_field();
        }
      }
    };

    Chosen.prototype.container_mouseup = function(evt) {
      if (evt.target.nodeName === "ABBR" && !this.is_disabled) {
        return this.results_reset(evt);
      }
    };

    Chosen.prototype.search_results_mousewheel = function(evt) {
      var delta;
      if (evt.originalEvent) {
        delta = evt.originalEvent.deltaY || -evt.originalEvent.wheelDelta || evt.originalEvent.detail;
      }
      if (delta != null) {
        evt.preventDefault();
        if (evt.type === 'DOMMouseScroll') {
          delta = delta * 40;
        }
        return this.search_results.scrollTop(delta + this.search_results.scrollTop());
      }
    };

    Chosen.prototype.blur_test = function(evt) {
      if (!this.active_field && this.container.hasClass("chosen-container-active")) {
        return this.close_field();
      }
    };

    Chosen.prototype.close_field = function() {
      $(this.container[0].ownerDocument).unbind("click.chosen", this.click_test_action);
      this.active_field = false;
      this.results_hide();
      this.container.removeClass("chosen-container-active");
      this.clear_backstroke();
      this.show_search_field_default();
      return this.search_field_scale();
    };

    Chosen.prototype.activate_field = function() {
      this.container.addClass("chosen-container-active");
      this.active_field = true;
      this.search_field.val(this.search_field.val());
      return this.search_field.focus();
    };

    Chosen.prototype.test_active_click = function(evt) {
      var active_container;
      active_container = $(evt.target).closest('.chosen-container');
      if (active_container.length && this.container[0] === active_container[0]) {
        return this.active_field = true;
      } else {
        return this.close_field();
      }
    };

    Chosen.prototype.results_build = function() {
      this.parsing = true;
      this.selected_option_count = null;
      this.results_data = SelectParser.select_to_array(this.form_field);
      if (this.is_multiple) {
        this.search_choices.find("li.search-choice").remove();
      } else if (!this.is_multiple) {
        this.single_set_selected_text();
        if (this.disable_search || this.form_field.options.length <= this.disable_search_threshold) {
          this.search_field[0].readOnly = true;
          this.container.addClass("chosen-container-single-nosearch");
        } else {
          this.search_field[0].readOnly = false;
          this.container.removeClass("chosen-container-single-nosearch");
        }
      }
      this.update_results_content(this.results_option_build({
        first: true
      }));
      this.search_field_disabled();
      this.show_search_field_default();
      this.search_field_scale();
      return this.parsing = false;
    };

    Chosen.prototype.result_do_highlight = function(el) {
      var high_bottom, high_top, maxHeight, visible_bottom, visible_top;
      if (el.length) {
        this.result_clear_highlight();
        this.result_highlight = el;
        this.result_highlight.addClass("highlighted");
        maxHeight = parseInt(this.search_results.css("maxHeight"), 10);
        visible_top = this.search_results.scrollTop();
        visible_bottom = maxHeight + visible_top;
        high_top = this.result_highlight.position().top + this.search_results.scrollTop();
        high_bottom = high_top + this.result_highlight.outerHeight();
        if (high_bottom >= visible_bottom) {
          return this.search_results.scrollTop((high_bottom - maxHeight) > 0 ? high_bottom - maxHeight : 0);
        } else if (high_top < visible_top) {
          return this.search_results.scrollTop(high_top);
        }
      }
    };

    Chosen.prototype.result_clear_highlight = function() {
      if (this.result_highlight) {
        this.result_highlight.removeClass("highlighted");
      }
      return this.result_highlight = null;
    };

    Chosen.prototype.results_show = function() {
      if (this.is_multiple && this.max_selected_options <= this.choices_count()) {
        this.form_field_jq.trigger("chosen:maxselected", {
          chosen: this
        });
        return false;
      }
      this.container.addClass("chosen-with-drop");
      this.results_showing = true;
      this.search_field.focus();
      this.search_field.val(this.search_field.val());
      this.winnow_results();
      return this.form_field_jq.trigger("chosen:showing_dropdown", {
        chosen: this
      });
    };

    Chosen.prototype.update_results_content = function(content) {
      return this.search_results.html(content);
    };

    Chosen.prototype.results_hide = function() {
      if (this.results_showing) {
        this.result_clear_highlight();
        this.container.removeClass("chosen-with-drop");
        this.form_field_jq.trigger("chosen:hiding_dropdown", {
          chosen: this
        });
      }
      return this.results_showing = false;
    };

    Chosen.prototype.set_tab_index = function(el) {
      var ti;
      if (this.form_field.tabIndex) {
        ti = this.form_field.tabIndex;
        this.form_field.tabIndex = -1;
        return this.search_field[0].tabIndex = ti;
      }
    };

    Chosen.prototype.set_label_behavior = function() {
      var _this = this;
      this.form_field_label = this.form_field_jq.parents("label");
      if (!this.form_field_label.length && this.form_field.id.length) {
        this.form_field_label = $("label[for='" + this.form_field.id + "']");
      }
      if (this.form_field_label.length > 0) {
        return this.form_field_label.bind('click.chosen', function(evt) {
          if (_this.is_multiple) {
            return _this.container_mousedown(evt);
          } else {
            return _this.activate_field();
          }
        });
      }
    };

    Chosen.prototype.show_search_field_default = function() {
      if (this.is_multiple && this.choices_count() < 1 && !this.active_field) {
        this.search_field.val(this.default_text);
        return this.search_field.addClass("default");
      } else {
        this.search_field.val("");
        return this.search_field.removeClass("default");
      }
    };

    Chosen.prototype.search_results_mouseup = function(evt) {
      var target;
      target = $(evt.target).hasClass("active-result") ? $(evt.target) : $(evt.target).parents(".active-result").first();
      if (target.length) {
        this.result_highlight = target;
        this.result_select(evt);
        return this.search_field.focus();
      }
    };

    Chosen.prototype.search_results_mouseover = function(evt) {
      var target;
      target = $(evt.target).hasClass("active-result") ? $(evt.target) : $(evt.target).parents(".active-result").first();
      if (target) {
        return this.result_do_highlight(target);
      }
    };

    Chosen.prototype.search_results_mouseout = function(evt) {
      if ($(evt.target).hasClass("active-result" || $(evt.target).parents('.active-result').first())) {
        return this.result_clear_highlight();
      }
    };

    Chosen.prototype.choice_build = function(item) {
      var choice, close_link,
        _this = this;
      choice = $('<li />', {
        "class": "search-choice"
      }).html("<span>" + (this.choice_label(item)) + "</span>");
      if (item.disabled) {
        choice.addClass('search-choice-disabled');
      } else {
        close_link = $('<a />', {
          "class": 'search-choice-close',
          'data-option-array-index': item.array_index
        });
        close_link.bind('click.chosen', function(evt) {
          return _this.choice_destroy_link_click(evt);
        });
        choice.append(close_link);
      }
      return this.search_container.before(choice);
    };

    Chosen.prototype.choice_destroy_link_click = function(evt) {
      evt.preventDefault();
      evt.stopPropagation();
      if (!this.is_disabled) {
        return this.choice_destroy($(evt.target));
      }
    };

    Chosen.prototype.choice_destroy = function(link) {
      if (this.result_deselect(link[0].getAttribute("data-option-array-index"))) {
        this.show_search_field_default();
        if (this.is_multiple && this.choices_count() > 0 && this.search_field.val().length < 1) {
          this.results_hide();
        }
        link.parents('li').first().remove();
        return this.search_field_scale();
      }
    };

    Chosen.prototype.results_reset = function() {
      this.reset_single_select_options();
      this.form_field.options[0].selected = true;
      this.single_set_selected_text();
      this.show_search_field_default();
      this.results_reset_cleanup();
      this.form_field_jq.trigger("change");
      if (this.active_field) {
        return this.results_hide();
      }
    };

    Chosen.prototype.results_reset_cleanup = function() {
      this.current_selectedIndex = this.form_field.selectedIndex;
      return this.selected_item.find("abbr").remove();
    };

    Chosen.prototype.result_select = function(evt) {
      var high, item;
      if (this.result_highlight) {
        high = this.result_highlight;
        this.result_clear_highlight();
        if (this.is_multiple && this.max_selected_options <= this.choices_count()) {
          this.form_field_jq.trigger("chosen:maxselected", {
            chosen: this
          });
          return false;
        }
        if (this.is_multiple) {
          high.removeClass("active-result");
        } else {
          this.reset_single_select_options();
        }
        high.addClass("result-selected");
        item = this.results_data[high[0].getAttribute("data-option-array-index")];
        item.selected = true;
        this.form_field.options[item.options_index].selected = true;
        this.selected_option_count = null;
        if (this.is_multiple) {
          this.choice_build(item);
        } else {
          this.single_set_selected_text(this.choice_label(item));
        }
        if (!((evt.metaKey || evt.ctrlKey) && this.is_multiple)) {
          this.results_hide();
        }
        this.show_search_field_default();
        if (this.is_multiple || this.form_field.selectedIndex !== this.current_selectedIndex) {
          this.form_field_jq.trigger("change", {
            'selected': this.form_field.options[item.options_index].value
          });
        }
        this.current_selectedIndex = this.form_field.selectedIndex;
        evt.preventDefault();
        return this.search_field_scale();
      }
    };

    Chosen.prototype.single_set_selected_text = function(text) {
      if (text == null) {
        text = this.default_text;
      }
      if (text === this.default_text) {
        this.selected_item.addClass("chosen-default");
      } else {
        this.single_deselect_control_build();
        this.selected_item.removeClass("chosen-default");
      }
      return this.selected_item.find("span").html(text);
    };

    Chosen.prototype.result_deselect = function(pos) {
      var result_data;
      result_data = this.results_data[pos];
      if (!this.form_field.options[result_data.options_index].disabled) {
        result_data.selected = false;
        this.form_field.options[result_data.options_index].selected = false;
        this.selected_option_count = null;
        this.result_clear_highlight();
        if (this.results_showing) {
          this.winnow_results();
        }
        this.form_field_jq.trigger("change", {
          deselected: this.form_field.options[result_data.options_index].value
        });
        this.search_field_scale();
        return true;
      } else {
        return false;
      }
    };

    Chosen.prototype.single_deselect_control_build = function() {
      if (!this.allow_single_deselect) {
        return;
      }
      if (!this.selected_item.find("abbr").length) {
        this.selected_item.find("span").first().after("<abbr class=\"search-choice-close\"></abbr>");
      }
      return this.selected_item.addClass("chosen-single-with-deselect");
    };

    Chosen.prototype.get_search_text = function() {
      return $('<div/>').text($.trim(this.search_field.val())).html();
    };

    Chosen.prototype.winnow_results_set_highlight = function() {
      var do_high, selected_results;
      selected_results = !this.is_multiple ? this.search_results.find(".result-selected.active-result") : [];
      do_high = selected_results.length ? selected_results.first() : this.search_results.find(".active-result").first();
      if (do_high != null) {
        return this.result_do_highlight(do_high);
      }
    };

    Chosen.prototype.no_results = function(terms) {
      var no_results_html;
      no_results_html = $('<li class="no-results">' + this.results_none_found + ' "<span></span>"</li>');
      no_results_html.find("span").first().html(terms);
      this.search_results.append(no_results_html);
      return this.form_field_jq.trigger("chosen:no_results", {
        chosen: this
      });
    };

    Chosen.prototype.no_results_clear = function() {
      return this.search_results.find(".no-results").remove();
    };

    Chosen.prototype.keydown_arrow = function() {
      var next_sib;
      if (this.results_showing && this.result_highlight) {
        next_sib = this.result_highlight.nextAll("li.active-result").first();
        if (next_sib) {
          return this.result_do_highlight(next_sib);
        }
      } else {
        return this.results_show();
      }
    };

    Chosen.prototype.keyup_arrow = function() {
      var prev_sibs;
      if (!this.results_showing && !this.is_multiple) {
        return this.results_show();
      } else if (this.result_highlight) {
        prev_sibs = this.result_highlight.prevAll("li.active-result");
        if (prev_sibs.length) {
          return this.result_do_highlight(prev_sibs.first());
        } else {
          if (this.choices_count() > 0) {
            this.results_hide();
          }
          return this.result_clear_highlight();
        }
      }
    };

    Chosen.prototype.keydown_backstroke = function() {
      var next_available_destroy;
      if (this.pending_backstroke) {
        this.choice_destroy(this.pending_backstroke.find("a").first());
        return this.clear_backstroke();
      } else {
        next_available_destroy = this.search_container.siblings("li.search-choice").last();
        if (next_available_destroy.length && !next_available_destroy.hasClass("search-choice-disabled")) {
          this.pending_backstroke = next_available_destroy;
          if (this.single_backstroke_delete) {
            return this.keydown_backstroke();
          } else {
            return this.pending_backstroke.addClass("search-choice-focus");
          }
        }
      }
    };

    Chosen.prototype.clear_backstroke = function() {
      if (this.pending_backstroke) {
        this.pending_backstroke.removeClass("search-choice-focus");
      }
      return this.pending_backstroke = null;
    };

    Chosen.prototype.keydown_checker = function(evt) {
      var stroke, _ref1;
      stroke = (_ref1 = evt.which) != null ? _ref1 : evt.keyCode;
      this.search_field_scale();
      if (stroke !== 8 && this.pending_backstroke) {
        this.clear_backstroke();
      }
      switch (stroke) {
        case 8:
          this.backstroke_length = this.search_field.val().length;
          break;
        case 9:
          if (this.results_showing && !this.is_multiple) {
            this.result_select(evt);
          }
          this.mouse_on_container = false;
          break;
        case 13:
          if (this.results_showing) {
            evt.preventDefault();
          }
          break;
        case 32:
          if (this.disable_search) {
            evt.preventDefault();
          }
          break;
        case 38:
          evt.preventDefault();
          this.keyup_arrow();
          break;
        case 40:
          evt.preventDefault();
          this.keydown_arrow();
          break;
      }
    };

    Chosen.prototype.search_field_scale = function() {
      var div, f_width, h, style, style_block, styles, w, _i, _len;
      if (this.is_multiple) {
        h = 0;
        w = 0;
        style_block = "position:absolute; left: -1000px; top: -1000px; display:none;";
        styles = ['font-size', 'font-style', 'font-weight', 'font-family', 'line-height', 'text-transform', 'letter-spacing'];
        for (_i = 0, _len = styles.length; _i < _len; _i++) {
          style = styles[_i];
          style_block += style + ":" + this.search_field.css(style) + ";";
        }
        div = $('<div />', {
          'style': style_block
        });
        div.text(this.search_field.val());
        $('body').append(div);
        w = div.width() + 25;
        div.remove();
        f_width = this.container.outerWidth();
        if (w > f_width - 10) {
          w = f_width - 10;
        }
        return this.search_field.css({
          'width': w + 'px'
        });
      }
    };

    return Chosen;

  })(AbstractChosen);

}).call(this);

/* =========================================================
 * bootstrap-datepicker.js
 * Repo: https://github.com/eternicode/bootstrap-datepicker/
 * Demo: http://eternicode.github.io/bootstrap-datepicker/
 * Docs: http://bootstrap-datepicker.readthedocs.org/
 * Forked from http://www.eyecon.ro/bootstrap-datepicker
 * =========================================================
 * Started by Stefan Petre; improvements by Andrew Rowls + contributors
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 * ========================================================= */

(function($, undefined){

	var $window = $(window);

	function UTCDate(){
		return new Date(Date.UTC.apply(Date, arguments));
	}
	function UTCToday(){
		var today = new Date();
		return UTCDate(today.getFullYear(), today.getMonth(), today.getDate());
	}
	function alias(method){
		return function(){
			return this[method].apply(this, arguments);
		};
	}

	var DateArray = (function(){
		var extras = {
			get: function(i){
				return this.slice(i)[0];
			},
			contains: function(d){
				// Array.indexOf is not cross-browser;
				// $.inArray doesn't work with Dates
				var val = d && d.valueOf();
				for (var i=0, l=this.length; i < l; i++)
					if (this[i].valueOf() === val)
						return i;
				return -1;
			},
			remove: function(i){
				this.splice(i,1);
			},
			replace: function(new_array){
				if (!new_array)
					return;
				if (!$.isArray(new_array))
					new_array = [new_array];
				this.clear();
				this.push.apply(this, new_array);
			},
			clear: function(){
				this.splice(0);
			},
			copy: function(){
				var a = new DateArray();
				a.replace(this);
				return a;
			}
		};

		return function(){
			var a = [];
			a.push.apply(a, arguments);
			$.extend(a, extras);
			return a;
		};
	})();


	// Picker object

	var Datepicker = function(element, options){
		this.dates = new DateArray();
		this.viewDate = UTCToday();
		this.focusDate = null;

		this._process_options(options);

		this.element = $(element);
		this.isInline = false;
		this.isInput = this.element.is('input');
		this.component = this.element.is('.date') ? this.element.find('.add-on, .input-group-addon, .btn') : false;
		this.hasInput = this.component && this.element.find('input').length;
		if (this.component && this.component.length === 0)
			this.component = false;

		this.picker = $(DPGlobal.template);
		this._buildEvents();
		this._attachEvents();

		if (this.isInline){
			this.picker.addClass('datepicker-inline').appendTo(this.element);
		}
		else {
			this.picker.addClass('datepicker-dropdown dropdown-menu');
		}

		if (this.o.rtl){
			this.picker.addClass('datepicker-rtl');
		}

		this.viewMode = this.o.startView;

		if (this.o.calendarWeeks)
			this.picker.find('tfoot th.today')
						.attr('colspan', function(i, val){
							return parseInt(val) + 1;
						});

		this._allow_update = false;

		this.setStartDate(this._o.startDate);
		this.setEndDate(this._o.endDate);
		this.setDaysOfWeekDisabled(this.o.daysOfWeekDisabled);

		this.fillDow();
		this.fillMonths();

		this._allow_update = true;

		this.update();
		this.showMode();

		if (this.isInline){
			this.show();
		}
	};

	Datepicker.prototype = {
		constructor: Datepicker,

		_process_options: function(opts){
			// Store raw options for reference
			this._o = $.extend({}, this._o, opts);
			// Processed options
			var o = this.o = $.extend({}, this._o);

			// Check if "de-DE" style date is available, if not language should
			// fallback to 2 letter code eg "de"
			var lang = o.language;
			if (!dates[lang]){
				lang = lang.split('-')[0];
				if (!dates[lang])
					lang = defaults.language;
			}
			o.language = lang;

			switch (o.startView){
				case 2:
				case 'decade':
					o.startView = 2;
					break;
				case 1:
				case 'year':
					o.startView = 1;
					break;
				default:
					o.startView = 0;
			}

			switch (o.minViewMode){
				case 1:
				case 'months':
					o.minViewMode = 1;
					break;
				case 2:
				case 'years':
					o.minViewMode = 2;
					break;
				default:
					o.minViewMode = 0;
			}

			o.startView = Math.max(o.startView, o.minViewMode);

			// true, false, or Number > 0
			if (o.multidate !== true){
				o.multidate = Number(o.multidate) || false;
				if (o.multidate !== false)
					o.multidate = Math.max(0, o.multidate);
				else
					o.multidate = 1;
			}
			o.multidateSeparator = String(o.multidateSeparator);

			o.weekStart %= 7;
			o.weekEnd = ((o.weekStart + 6) % 7);

			var format = DPGlobal.parseFormat(o.format);
			if (o.startDate !== -Infinity){
				if (!!o.startDate){
					if (o.startDate instanceof Date)
						o.startDate = this._local_to_utc(this._zero_time(o.startDate));
					else
						o.startDate = DPGlobal.parseDate(o.startDate, format, o.language);
				}
				else {
					o.startDate = -Infinity;
				}
			}
			if (o.endDate !== Infinity){
				if (!!o.endDate){
					if (o.endDate instanceof Date)
						o.endDate = this._local_to_utc(this._zero_time(o.endDate));
					else
						o.endDate = DPGlobal.parseDate(o.endDate, format, o.language);
				}
				else {
					o.endDate = Infinity;
				}
			}

			o.daysOfWeekDisabled = o.daysOfWeekDisabled||[];
			if (!$.isArray(o.daysOfWeekDisabled))
				o.daysOfWeekDisabled = o.daysOfWeekDisabled.split(/[,\s]*/);
			o.daysOfWeekDisabled = $.map(o.daysOfWeekDisabled, function(d){
				return parseInt(d, 10);
			});

			var plc = String(o.orientation).toLowerCase().split(/\s+/g),
				_plc = o.orientation.toLowerCase();
			plc = $.grep(plc, function(word){
				return (/^auto|left|right|top|bottom$/).test(word);
			});
			o.orientation = {x: 'auto', y: 'auto'};
			if (!_plc || _plc === 'auto')
				; // no action
			else if (plc.length === 1){
				switch (plc[0]){
					case 'top':
					case 'bottom':
						o.orientation.y = plc[0];
						break;
					case 'left':
					case 'right':
						o.orientation.x = plc[0];
						break;
				}
			}
			else {
				_plc = $.grep(plc, function(word){
					return (/^left|right$/).test(word);
				});
				o.orientation.x = _plc[0] || 'auto';

				_plc = $.grep(plc, function(word){
					return (/^top|bottom$/).test(word);
				});
				o.orientation.y = _plc[0] || 'auto';
			}
		},
		_events: [],
		_secondaryEvents: [],
		_applyEvents: function(evs){
			for (var i=0, el, ch, ev; i < evs.length; i++){
				el = evs[i][0];
				if (evs[i].length === 2){
					ch = undefined;
					ev = evs[i][1];
				}
				else if (evs[i].length === 3){
					ch = evs[i][1];
					ev = evs[i][2];
				}
				el.on(ev, ch);
			}
		},
		_unapplyEvents: function(evs){
			for (var i=0, el, ev, ch; i < evs.length; i++){
				el = evs[i][0];
				if (evs[i].length === 2){
					ch = undefined;
					ev = evs[i][1];
				}
				else if (evs[i].length === 3){
					ch = evs[i][1];
					ev = evs[i][2];
				}
				el.off(ev, ch);
			}
		},
		_buildEvents: function(){
			if (this.isInput){ // single input
				this._events = [
					[this.element, {
						focus: $.proxy(this.show, this),
						keyup: $.proxy(function(e){
							if ($.inArray(e.keyCode, [27,37,39,38,40,32,13,9]) === -1)
								this.update();
						}, this),
						keydown: $.proxy(this.keydown, this)
					}]
				];
			}
			else if (this.component && this.hasInput){ // component: input + button
				this._events = [
					// For components that are not readonly, allow keyboard nav
					[this.element.find('input'), {
						focus: $.proxy(this.show, this),
						keyup: $.proxy(function(e){
							if ($.inArray(e.keyCode, [27,37,39,38,40,32,13,9]) === -1)
								this.update();
						}, this),
						keydown: $.proxy(this.keydown, this)
					}],
					[this.component, {
						click: $.proxy(this.show, this)
					}]
				];
			}
			else if (this.element.is('div')){  // inline datepicker
				this.isInline = true;
			}
			else {
				this._events = [
					[this.element, {
						click: $.proxy(this.show, this)
					}]
				];
			}
			this._events.push(
				// Component: listen for blur on element descendants
				[this.element, '*', {
					blur: $.proxy(function(e){
						this._focused_from = e.target;
					}, this)
				}],
				// Input: listen for blur on element
				[this.element, {
					blur: $.proxy(function(e){
						this._focused_from = e.target;
					}, this)
				}]
			);

			this._secondaryEvents = [
				[this.picker, {
					click: $.proxy(this.click, this)
				}],
				[$(window), {
					resize: $.proxy(this.place, this)
				}],
				[$(document), {
					'mousedown touchstart': $.proxy(function(e){
						// Clicked outside the datepicker, hide it
						if (!(
							this.element.is(e.target) ||
							this.element.find(e.target).length ||
							this.picker.is(e.target) ||
							this.picker.find(e.target).length
						)){
							this.hide();
						}
					}, this)
				}]
			];
		},
		_attachEvents: function(){
			this._detachEvents();
			this._applyEvents(this._events);
		},
		_detachEvents: function(){
			this._unapplyEvents(this._events);
		},
		_attachSecondaryEvents: function(){
			this._detachSecondaryEvents();
			this._applyEvents(this._secondaryEvents);
		},
		_detachSecondaryEvents: function(){
			this._unapplyEvents(this._secondaryEvents);
		},
		_trigger: function(event, altdate){
			var date = altdate || this.dates.get(-1),
				local_date = this._utc_to_local(date);

			this.element.trigger({
				type: event,
				date: local_date,
				dates: $.map(this.dates, this._utc_to_local),
				format: $.proxy(function(ix, format){
					if (arguments.length === 0){
						ix = this.dates.length - 1;
						format = this.o.format;
					}
					else if (typeof ix === 'string'){
						format = ix;
						ix = this.dates.length - 1;
					}
					format = format || this.o.format;
					var date = this.dates.get(ix);
					return DPGlobal.formatDate(date, format, this.o.language);
				}, this)
			});
		},

		show: function(){
			if (!this.isInline)
				this.picker.appendTo('body');
			this.picker.show();
			this.place();
			this._attachSecondaryEvents();
			this._trigger('show');
		},

		hide: function(){
			if (this.isInline)
				return;
			if (!this.picker.is(':visible'))
				return;
			this.focusDate = null;
			this.picker.hide().detach();
			this._detachSecondaryEvents();
			this.viewMode = this.o.startView;
			this.showMode();

			if (
				this.o.forceParse &&
				(
					this.isInput && this.element.val() ||
					this.hasInput && this.element.find('input').val()
				)
			)
				this.setValue();
			this._trigger('hide');
		},

		remove: function(){
			this.hide();
			this._detachEvents();
			this._detachSecondaryEvents();
			this.picker.remove();
			delete this.element.data().datepicker;
			if (!this.isInput){
				delete this.element.data().date;
			}
		},

		_utc_to_local: function(utc){
			return utc && new Date(utc.getTime() + (utc.getTimezoneOffset()*60000));
		},
		_local_to_utc: function(local){
			return local && new Date(local.getTime() - (local.getTimezoneOffset()*60000));
		},
		_zero_time: function(local){
			return local && new Date(local.getFullYear(), local.getMonth(), local.getDate());
		},
		_zero_utc_time: function(utc){
			return utc && new Date(Date.UTC(utc.getUTCFullYear(), utc.getUTCMonth(), utc.getUTCDate()));
		},

		getDates: function(){
			return $.map(this.dates, this._utc_to_local);
		},

		getUTCDates: function(){
			return $.map(this.dates, function(d){
				return new Date(d);
			});
		},

		getDate: function(){
			return this._utc_to_local(this.getUTCDate());
		},

		getUTCDate: function(){
			return new Date(this.dates.get(-1));
		},

		setDates: function(){
			var args = $.isArray(arguments[0]) ? arguments[0] : arguments;
			this.update.apply(this, args);
			this._trigger('changeDate');
			this.setValue();
		},

		setUTCDates: function(){
			var args = $.isArray(arguments[0]) ? arguments[0] : arguments;
			this.update.apply(this, $.map(args, this._utc_to_local));
			this._trigger('changeDate');
			this.setValue();
		},

		setDate: alias('setDates'),
		setUTCDate: alias('setUTCDates'),

		setValue: function(){
			var formatted = this.getFormattedDate();
			if (!this.isInput){
				if (this.component){
					this.element.find('input').val(formatted).change();
				}
			}
			else {
				this.element.val(formatted).change();
			}
		},

		getFormattedDate: function(format){
			if (format === undefined)
				format = this.o.format;

			var lang = this.o.language;
			return $.map(this.dates, function(d){
				return DPGlobal.formatDate(d, format, lang);
			}).join(this.o.multidateSeparator);
		},

		setStartDate: function(startDate){
			this._process_options({startDate: startDate});
			this.update();
			this.updateNavArrows();
		},

		setEndDate: function(endDate){
			this._process_options({endDate: endDate});
			this.update();
			this.updateNavArrows();
		},

		setDaysOfWeekDisabled: function(daysOfWeekDisabled){
			this._process_options({daysOfWeekDisabled: daysOfWeekDisabled});
			this.update();
			this.updateNavArrows();
		},

		place: function(){
			if (this.isInline)
				return;
			var calendarWidth = this.picker.outerWidth(),
				calendarHeight = this.picker.outerHeight(),
				visualPadding = 10,
				windowWidth = $window.width(),
				windowHeight = $window.height(),
				scrollTop = $window.scrollTop();

			var zIndex = parseInt(this.element.parents().filter(function(){
					return $(this).css('z-index') !== 'auto';
				}).first().css('z-index'))+10;
			var offset = this.component ? this.component.parent().offset() : this.element.offset();
			var height = this.component ? this.component.outerHeight(true) : this.element.outerHeight(false);
			var width = this.component ? this.component.outerWidth(true) : this.element.outerWidth(false);
			var left = offset.left,
				top = offset.top;

			this.picker.removeClass(
				'datepicker-orient-top datepicker-orient-bottom '+
				'datepicker-orient-right datepicker-orient-left'
			);

			if (this.o.orientation.x !== 'auto'){
				this.picker.addClass('datepicker-orient-' + this.o.orientation.x);
				if (this.o.orientation.x === 'right')
					left -= calendarWidth - width;
			}
			// auto x orientation is best-placement: if it crosses a window
			// edge, fudge it sideways
			else {
				// Default to left
				this.picker.addClass('datepicker-orient-left');
				if (offset.left < 0)
					left -= offset.left - visualPadding;
				else if (offset.left + calendarWidth > windowWidth)
					left = windowWidth - calendarWidth - visualPadding;
			}

			// auto y orientation is best-situation: top or bottom, no fudging,
			// decision based on which shows more of the calendar
			var yorient = this.o.orientation.y,
				top_overflow, bottom_overflow;
			if (yorient === 'auto'){
				top_overflow = -scrollTop + offset.top - calendarHeight;
				bottom_overflow = scrollTop + windowHeight - (offset.top + height + calendarHeight);
				if (Math.max(top_overflow, bottom_overflow) === bottom_overflow)
					yorient = 'top';
				else
					yorient = 'bottom';
			}
			this.picker.addClass('datepicker-orient-' + yorient);
			if (yorient === 'top')
				top += height;
			else
				top -= calendarHeight + parseInt(this.picker.css('padding-top'));

			this.picker.css({
				top: top,
				left: left,
				zIndex: zIndex
			});
		},

		_allow_update: true,
		update: function(){
			if (!this._allow_update)
				return;

			var oldDates = this.dates.copy(),
				dates = [],
				fromArgs = false;
			if (arguments.length){
				$.each(arguments, $.proxy(function(i, date){
					if (date instanceof Date)
						date = this._local_to_utc(date);
					dates.push(date);
				}, this));
				fromArgs = true;
			}
			else {
				dates = this.isInput
						? this.element.val()
						: this.element.data('date') || this.element.find('input').val();
				if (dates && this.o.multidate)
					dates = dates.split(this.o.multidateSeparator);
				else
					dates = [dates];
				delete this.element.data().date;
			}

			dates = $.map(dates, $.proxy(function(date){
				return DPGlobal.parseDate(date, this.o.format, this.o.language);
			}, this));
			dates = $.grep(dates, $.proxy(function(date){
				return (
					date < this.o.startDate ||
					date > this.o.endDate ||
					!date
				);
			}, this), true);
			this.dates.replace(dates);

			if (this.dates.length)
				this.viewDate = new Date(this.dates.get(-1));
			else if (this.viewDate < this.o.startDate)
				this.viewDate = new Date(this.o.startDate);
			else if (this.viewDate > this.o.endDate)
				this.viewDate = new Date(this.o.endDate);

			if (fromArgs){
				// setting date by clicking
				this.setValue();
			}
			else if (dates.length){
				// setting date by typing
				if (String(oldDates) !== String(this.dates))
					this._trigger('changeDate');
			}
			if (!this.dates.length && oldDates.length)
				this._trigger('clearDate');

			this.fill();
		},

		fillDow: function(){
			var dowCnt = this.o.weekStart,
				html = '<tr>';
			if (this.o.calendarWeeks){
				var cell = '<th class="cw">&nbsp;</th>';
				html += cell;
				this.picker.find('.datepicker-days thead tr:first-child').prepend(cell);
			}
			while (dowCnt < this.o.weekStart + 7){
				html += '<th class="dow">'+dates[this.o.language].daysMin[(dowCnt++)%7]+'</th>';
			}
			html += '</tr>';
			this.picker.find('.datepicker-days thead').append(html);
		},

		fillMonths: function(){
			var html = '',
			i = 0;
			while (i < 12){
				html += '<span class="month">'+dates[this.o.language].monthsShort[i++]+'</span>';
			}
			this.picker.find('.datepicker-months td').html(html);
		},

		setRange: function(range){
			if (!range || !range.length)
				delete this.range;
			else
				this.range = $.map(range, function(d){
					return d.valueOf();
				});
			this.fill();
		},

		getClassNames: function(date){
			var cls = [],
				year = this.viewDate.getUTCFullYear(),
				month = this.viewDate.getUTCMonth(),
				today = new Date();
			if (date.getUTCFullYear() < year || (date.getUTCFullYear() === year && date.getUTCMonth() < month)){
				cls.push('old');
			}
			else if (date.getUTCFullYear() > year || (date.getUTCFullYear() === year && date.getUTCMonth() > month)){
				cls.push('new');
			}
			if (this.focusDate && date.valueOf() === this.focusDate.valueOf())
				cls.push('focused');
			// Compare internal UTC date with local today, not UTC today
			if (this.o.todayHighlight &&
				date.getUTCFullYear() === today.getFullYear() &&
				date.getUTCMonth() === today.getMonth() &&
				date.getUTCDate() === today.getDate()){
				cls.push('today');
			}
			if (this.dates.contains(date) !== -1)
				cls.push('active');
			if (date.valueOf() < this.o.startDate || date.valueOf() > this.o.endDate ||
				$.inArray(date.getUTCDay(), this.o.daysOfWeekDisabled) !== -1){
				cls.push('disabled');
			}
			if (this.range){
				if (date > this.range[0] && date < this.range[this.range.length-1]){
					cls.push('range');
				}
				if ($.inArray(date.valueOf(), this.range) !== -1){
					cls.push('selected');
				}
			}
			return cls;
		},

		fill: function(){
			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth(),
				startYear = this.o.startDate !== -Infinity ? this.o.startDate.getUTCFullYear() : -Infinity,
				startMonth = this.o.startDate !== -Infinity ? this.o.startDate.getUTCMonth() : -Infinity,
				endYear = this.o.endDate !== Infinity ? this.o.endDate.getUTCFullYear() : Infinity,
				endMonth = this.o.endDate !== Infinity ? this.o.endDate.getUTCMonth() : Infinity,
				todaytxt = dates[this.o.language].today || dates['en'].today || '',
				cleartxt = dates[this.o.language].clear || dates['en'].clear || '',
				tooltip;
			this.picker.find('.datepicker-days thead th.datepicker-switch')
						.text(dates[this.o.language].months[month]+' '+year);
			this.picker.find('tfoot th.today')
						.text(todaytxt)
						.toggle(this.o.todayBtn !== false);
			this.picker.find('tfoot th.clear')
						.text(cleartxt)
						.toggle(this.o.clearBtn !== false);
			this.updateNavArrows();
			this.fillMonths();
			var prevMonth = UTCDate(year, month-1, 28),
				day = DPGlobal.getDaysInMonth(prevMonth.getUTCFullYear(), prevMonth.getUTCMonth());
			prevMonth.setUTCDate(day);
			prevMonth.setUTCDate(day - (prevMonth.getUTCDay() - this.o.weekStart + 7)%7);
			var nextMonth = new Date(prevMonth);
			nextMonth.setUTCDate(nextMonth.getUTCDate() + 42);
			nextMonth = nextMonth.valueOf();
			var html = [];
			var clsName;
			while (prevMonth.valueOf() < nextMonth){
				if (prevMonth.getUTCDay() === this.o.weekStart){
					html.push('<tr>');
					if (this.o.calendarWeeks){
						// ISO 8601: First week contains first thursday.
						// ISO also states week starts on Monday, but we can be more abstract here.
						var
							// Start of current week: based on weekstart/current date
							ws = new Date(+prevMonth + (this.o.weekStart - prevMonth.getUTCDay() - 7) % 7 * 864e5),
							// Thursday of this week
							th = new Date(Number(ws) + (7 + 4 - ws.getUTCDay()) % 7 * 864e5),
							// First Thursday of year, year from thursday
							yth = new Date(Number(yth = UTCDate(th.getUTCFullYear(), 0, 1)) + (7 + 4 - yth.getUTCDay())%7*864e5),
							// Calendar week: ms between thursdays, div ms per day, div 7 days
							calWeek =  (th - yth) / 864e5 / 7 + 1;
						html.push('<td class="cw">'+ calWeek +'</td>');

					}
				}
				clsName = this.getClassNames(prevMonth);
				clsName.push('day');

				if (this.o.beforeShowDay !== $.noop){
					var before = this.o.beforeShowDay(this._utc_to_local(prevMonth));
					if (before === undefined)
						before = {};
					else if (typeof(before) === 'boolean')
						before = {enabled: before};
					else if (typeof(before) === 'string')
						before = {classes: before};
					if (before.enabled === false)
						clsName.push('disabled');
					if (before.classes)
						clsName = clsName.concat(before.classes.split(/\s+/));
					if (before.tooltip)
						tooltip = before.tooltip;
				}

				clsName = $.unique(clsName);
				html.push('<td class="'+clsName.join(' ')+'"' + (tooltip ? ' title="'+tooltip+'"' : '') + '>'+prevMonth.getUTCDate() + '</td>');
				if (prevMonth.getUTCDay() === this.o.weekEnd){
					html.push('</tr>');
				}
				prevMonth.setUTCDate(prevMonth.getUTCDate()+1);
			}
			this.picker.find('.datepicker-days tbody').empty().append(html.join(''));

			var months = this.picker.find('.datepicker-months')
						.find('th:eq(1)')
							.text(year)
							.end()
						.find('span').removeClass('active');

			$.each(this.dates, function(i, d){
				if (d.getUTCFullYear() === year)
					months.eq(d.getUTCMonth()).addClass('active');
			});

			if (year < startYear || year > endYear){
				months.addClass('disabled');
			}
			if (year === startYear){
				months.slice(0, startMonth).addClass('disabled');
			}
			if (year === endYear){
				months.slice(endMonth+1).addClass('disabled');
			}

			html = '';
			year = parseInt(year/10, 10) * 10;
			var yearCont = this.picker.find('.datepicker-years')
								.find('th:eq(1)')
									.text(year + '-' + (year + 9))
									.end()
								.find('td');
			year -= 1;
			var years = $.map(this.dates, function(d){
					return d.getUTCFullYear();
				}),
				classes;
			for (var i = -1; i < 11; i++){
				classes = ['year'];
				if (i === -1)
					classes.push('old');
				else if (i === 10)
					classes.push('new');
				if ($.inArray(year, years) !== -1)
					classes.push('active');
				if (year < startYear || year > endYear)
					classes.push('disabled');
				html += '<span class="' + classes.join(' ') + '">'+year+'</span>';
				year += 1;
			}
			yearCont.html(html);
		},

		updateNavArrows: function(){
			if (!this._allow_update)
				return;

			var d = new Date(this.viewDate),
				year = d.getUTCFullYear(),
				month = d.getUTCMonth();
			switch (this.viewMode){
				case 0:
					if (this.o.startDate !== -Infinity && year <= this.o.startDate.getUTCFullYear() && month <= this.o.startDate.getUTCMonth()){
						this.picker.find('.prev').css({visibility: 'hidden'});
					}
					else {
						this.picker.find('.prev').css({visibility: 'visible'});
					}
					if (this.o.endDate !== Infinity && year >= this.o.endDate.getUTCFullYear() && month >= this.o.endDate.getUTCMonth()){
						this.picker.find('.next').css({visibility: 'hidden'});
					}
					else {
						this.picker.find('.next').css({visibility: 'visible'});
					}
					break;
				case 1:
				case 2:
					if (this.o.startDate !== -Infinity && year <= this.o.startDate.getUTCFullYear()){
						this.picker.find('.prev').css({visibility: 'hidden'});
					}
					else {
						this.picker.find('.prev').css({visibility: 'visible'});
					}
					if (this.o.endDate !== Infinity && year >= this.o.endDate.getUTCFullYear()){
						this.picker.find('.next').css({visibility: 'hidden'});
					}
					else {
						this.picker.find('.next').css({visibility: 'visible'});
					}
					break;
			}
		},

		click: function(e){
			e.preventDefault();
			var target = $(e.target).closest('span, td, th'),
				year, month, day;
			if (target.length === 1){
				switch (target[0].nodeName.toLowerCase()){
					case 'th':
						switch (target[0].className){
							case 'datepicker-switch':
								this.showMode(1);
								break;
							case 'prev':
							case 'next':
								var dir = DPGlobal.modes[this.viewMode].navStep * (target[0].className === 'prev' ? -1 : 1);
								switch (this.viewMode){
									case 0:
										this.viewDate = this.moveMonth(this.viewDate, dir);
										this._trigger('changeMonth', this.viewDate);
										break;
									case 1:
									case 2:
										this.viewDate = this.moveYear(this.viewDate, dir);
										if (this.viewMode === 1)
											this._trigger('changeYear', this.viewDate);
										break;
								}
								this.fill();
								break;
							case 'today':
								var date = new Date();
								date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);

								this.showMode(-2);
								var which = this.o.todayBtn === 'linked' ? null : 'view';
								this._setDate(date, which);
								break;
							case 'clear':
								var element;
								if (this.isInput)
									element = this.element;
								else if (this.component)
									element = this.element.find('input');
								if (element)
									element.val("").change();
								this.update();
								this._trigger('changeDate');
								if (this.o.autoclose)
									this.hide();
								break;
						}
						break;
					case 'span':
						if (!target.is('.disabled')){
							this.viewDate.setUTCDate(1);
							if (target.is('.month')){
								day = 1;
								month = target.parent().find('span').index(target);
								year = this.viewDate.getUTCFullYear();
								this.viewDate.setUTCMonth(month);
								this._trigger('changeMonth', this.viewDate);
								if (this.o.minViewMode === 1){
									this._setDate(UTCDate(year, month, day));
								}
							}
							else {
								day = 1;
								month = 0;
								year = parseInt(target.text(), 10)||0;
								this.viewDate.setUTCFullYear(year);
								this._trigger('changeYear', this.viewDate);
								if (this.o.minViewMode === 2){
									this._setDate(UTCDate(year, month, day));
								}
							}
							this.showMode(-1);
							this.fill();
						}
						break;
					case 'td':
						if (target.is('.day') && !target.is('.disabled')){
							day = parseInt(target.text(), 10)||1;
							year = this.viewDate.getUTCFullYear();
							month = this.viewDate.getUTCMonth();
							if (target.is('.old')){
								if (month === 0){
									month = 11;
									year -= 1;
								}
								else {
									month -= 1;
								}
							}
							else if (target.is('.new')){
								if (month === 11){
									month = 0;
									year += 1;
								}
								else {
									month += 1;
								}
							}
							this._setDate(UTCDate(year, month, day));
						}
						break;
				}
			}
			if (this.picker.is(':visible') && this._focused_from){
				$(this._focused_from).focus();
			}
			delete this._focused_from;
		},

		_toggle_multidate: function(date){
			var ix = this.dates.contains(date);
			if (!date){
				this.dates.clear();
			}
			else if (ix !== -1){
				this.dates.remove(ix);
			}
			else {
				this.dates.push(date);
			}
			if (typeof this.o.multidate === 'number')
				while (this.dates.length > this.o.multidate)
					this.dates.remove(0);
		},

		_setDate: function(date, which){
			if (!which || which === 'date')
				this._toggle_multidate(date && new Date(date));
			if (!which || which  === 'view')
				this.viewDate = date && new Date(date);

			this.fill();
			this.setValue();
			this._trigger('changeDate');
			var element;
			if (this.isInput){
				element = this.element;
			}
			else if (this.component){
				element = this.element.find('input');
			}
			if (element){
				element.change();
			}
			if (this.o.autoclose && (!which || which === 'date')){
				this.hide();
			}
		},

		moveMonth: function(date, dir){
			if (!date)
				return undefined;
			if (!dir)
				return date;
			var new_date = new Date(date.valueOf()),
				day = new_date.getUTCDate(),
				month = new_date.getUTCMonth(),
				mag = Math.abs(dir),
				new_month, test;
			dir = dir > 0 ? 1 : -1;
			if (mag === 1){
				test = dir === -1
					// If going back one month, make sure month is not current month
					// (eg, Mar 31 -> Feb 31 == Feb 28, not Mar 02)
					? function(){
						return new_date.getUTCMonth() === month;
					}
					// If going forward one month, make sure month is as expected
					// (eg, Jan 31 -> Feb 31 == Feb 28, not Mar 02)
					: function(){
						return new_date.getUTCMonth() !== new_month;
					};
				new_month = month + dir;
				new_date.setUTCMonth(new_month);
				// Dec -> Jan (12) or Jan -> Dec (-1) -- limit expected date to 0-11
				if (new_month < 0 || new_month > 11)
					new_month = (new_month + 12) % 12;
			}
			else {
				// For magnitudes >1, move one month at a time...
				for (var i=0; i < mag; i++)
					// ...which might decrease the day (eg, Jan 31 to Feb 28, etc)...
					new_date = this.moveMonth(new_date, dir);
				// ...then reset the day, keeping it in the new month
				new_month = new_date.getUTCMonth();
				new_date.setUTCDate(day);
				test = function(){
					return new_month !== new_date.getUTCMonth();
				};
			}
			// Common date-resetting loop -- if date is beyond end of month, make it
			// end of month
			while (test()){
				new_date.setUTCDate(--day);
				new_date.setUTCMonth(new_month);
			}
			return new_date;
		},

		moveYear: function(date, dir){
			return this.moveMonth(date, dir*12);
		},

		dateWithinRange: function(date){
			return date >= this.o.startDate && date <= this.o.endDate;
		},

		keydown: function(e){
			if (this.picker.is(':not(:visible)')){
				if (e.keyCode === 27) // allow escape to hide and re-show picker
					this.show();
				return;
			}
			var dateChanged = false,
				dir, newDate, newViewDate,
				focusDate = this.focusDate || this.viewDate;
			switch (e.keyCode){
				case 27: // escape
					if (this.focusDate){
						this.focusDate = null;
						this.viewDate = this.dates.get(-1) || this.viewDate;
						this.fill();
					}
					else
						this.hide();
					e.preventDefault();
					break;
				case 37: // left
				case 39: // right
					if (!this.o.keyboardNavigation)
						break;
					dir = e.keyCode === 37 ? -1 : 1;
					if (e.ctrlKey){
						newDate = this.moveYear(this.dates.get(-1) || UTCToday(), dir);
						newViewDate = this.moveYear(focusDate, dir);
						this._trigger('changeYear', this.viewDate);
					}
					else if (e.shiftKey){
						newDate = this.moveMonth(this.dates.get(-1) || UTCToday(), dir);
						newViewDate = this.moveMonth(focusDate, dir);
						this._trigger('changeMonth', this.viewDate);
					}
					else {
						newDate = new Date(this.dates.get(-1) || UTCToday());
						newDate.setUTCDate(newDate.getUTCDate() + dir);
						newViewDate = new Date(focusDate);
						newViewDate.setUTCDate(focusDate.getUTCDate() + dir);
					}
					if (this.dateWithinRange(newDate)){
						this.focusDate = this.viewDate = newViewDate;
						this.setValue();
						this.fill();
						e.preventDefault();
					}
					break;
				case 38: // up
				case 40: // down
					if (!this.o.keyboardNavigation)
						break;
					dir = e.keyCode === 38 ? -1 : 1;
					if (e.ctrlKey){
						newDate = this.moveYear(this.dates.get(-1) || UTCToday(), dir);
						newViewDate = this.moveYear(focusDate, dir);
						this._trigger('changeYear', this.viewDate);
					}
					else if (e.shiftKey){
						newDate = this.moveMonth(this.dates.get(-1) || UTCToday(), dir);
						newViewDate = this.moveMonth(focusDate, dir);
						this._trigger('changeMonth', this.viewDate);
					}
					else {
						newDate = new Date(this.dates.get(-1) || UTCToday());
						newDate.setUTCDate(newDate.getUTCDate() + dir * 7);
						newViewDate = new Date(focusDate);
						newViewDate.setUTCDate(focusDate.getUTCDate() + dir * 7);
					}
					if (this.dateWithinRange(newDate)){
						this.focusDate = this.viewDate = newViewDate;
						this.setValue();
						this.fill();
						e.preventDefault();
					}
					break;
				case 32: // spacebar
					// Spacebar is used in manually typing dates in some formats.
					// As such, its behavior should not be hijacked.
					break;
				case 13: // enter
					focusDate = this.focusDate || this.dates.get(-1) || this.viewDate;
					this._toggle_multidate(focusDate);
					dateChanged = true;
					this.focusDate = null;
					this.viewDate = this.dates.get(-1) || this.viewDate;
					this.setValue();
					this.fill();
					if (this.picker.is(':visible')){
						e.preventDefault();
						if (this.o.autoclose)
							this.hide();
					}
					break;
				case 9: // tab
					this.focusDate = null;
					this.viewDate = this.dates.get(-1) || this.viewDate;
					this.fill();
					this.hide();
					break;
			}
			if (dateChanged){
				if (this.dates.length)
					this._trigger('changeDate');
				else
					this._trigger('clearDate');
				var element;
				if (this.isInput){
					element = this.element;
				}
				else if (this.component){
					element = this.element.find('input');
				}
				if (element){
					element.change();
				}
			}
		},

		showMode: function(dir){
			if (dir){
				this.viewMode = Math.max(this.o.minViewMode, Math.min(2, this.viewMode + dir));
			}
			this.picker
				.find('>div')
				.hide()
				.filter('.datepicker-'+DPGlobal.modes[this.viewMode].clsName)
					.css('display', 'block');
			this.updateNavArrows();
		}
	};

	var DateRangePicker = function(element, options){
		this.element = $(element);
		this.inputs = $.map(options.inputs, function(i){
			return i.jquery ? i[0] : i;
		});
		delete options.inputs;

		$(this.inputs)
			.datepicker(options)
			.bind('changeDate', $.proxy(this.dateUpdated, this));

		this.pickers = $.map(this.inputs, function(i){
			return $(i).data('datepicker');
		});
		this.updateDates();
	};
	DateRangePicker.prototype = {
		updateDates: function(){
			this.dates = $.map(this.pickers, function(i){
				return i.getUTCDate();
			});
			this.updateRanges();
		},
		updateRanges: function(){
			var range = $.map(this.dates, function(d){
				return d.valueOf();
			});
			$.each(this.pickers, function(i, p){
				p.setRange(range);
			});
		},
		dateUpdated: function(e){
			// `this.updating` is a workaround for preventing infinite recursion
			// between `changeDate` triggering and `setUTCDate` calling.  Until
			// there is a better mechanism.
			if (this.updating)
				return;
			this.updating = true;

			var dp = $(e.target).data('datepicker'),
				new_date = dp.getUTCDate(),
				i = $.inArray(e.target, this.inputs),
				l = this.inputs.length;
			if (i === -1)
				return;

			$.each(this.pickers, function(i, p){
				if (!p.getUTCDate())
					p.setUTCDate(new_date);
			});

			if (new_date < this.dates[i]){
				// Date being moved earlier/left
				while (i >= 0 && new_date < this.dates[i]){
					this.pickers[i--].setUTCDate(new_date);
				}
			}
			else if (new_date > this.dates[i]){
				// Date being moved later/right
				while (i < l && new_date > this.dates[i]){
					this.pickers[i++].setUTCDate(new_date);
				}
			}
			this.updateDates();

			delete this.updating;
		},
		remove: function(){
			$.map(this.pickers, function(p){ p.remove(); });
			delete this.element.data().datepicker;
		}
	};

	function opts_from_el(el, prefix){
		// Derive options from element data-attrs
		var data = $(el).data(),
			out = {}, inkey,
			replace = new RegExp('^' + prefix.toLowerCase() + '([A-Z])');
		prefix = new RegExp('^' + prefix.toLowerCase());
		function re_lower(_,a){
			return a.toLowerCase();
		}
		for (var key in data)
			if (prefix.test(key)){
				inkey = key.replace(replace, re_lower);
				out[inkey] = data[key];
			}
		return out;
	}

	function opts_from_locale(lang){
		// Derive options from locale plugins
		var out = {};
		// Check if "de-DE" style date is available, if not language should
		// fallback to 2 letter code eg "de"
		if (!dates[lang]){
			lang = lang.split('-')[0];
			if (!dates[lang])
				return;
		}
		var d = dates[lang];
		$.each(locale_opts, function(i,k){
			if (k in d)
				out[k] = d[k];
		});
		return out;
	}

	var old = $.fn.datepicker;
	$.fn.datepicker = function(option){
		var args = Array.apply(null, arguments);
		args.shift();
		var internal_return;
		this.each(function(){
			var $this = $(this),
				data = $this.data('datepicker'),
				options = typeof option === 'object' && option;
			if (!data){
				var elopts = opts_from_el(this, 'date'),
					// Preliminary otions
					xopts = $.extend({}, defaults, elopts, options),
					locopts = opts_from_locale(xopts.language),
					// Options priority: js args, data-attrs, locales, defaults
					opts = $.extend({}, defaults, locopts, elopts, options);
				if ($this.is('.input-daterange') || opts.inputs){
					var ropts = {
						inputs: opts.inputs || $this.find('input').toArray()
					};
					$this.data('datepicker', (data = new DateRangePicker(this, $.extend(opts, ropts))));
				}
				else {
					$this.data('datepicker', (data = new Datepicker(this, opts)));
				}
			}
			if (typeof option === 'string' && typeof data[option] === 'function'){
				internal_return = data[option].apply(data, args);
				if (internal_return !== undefined)
					return false;
			}
		});
		if (internal_return !== undefined)
			return internal_return;
		else
			return this;
	};

	var defaults = $.fn.datepicker.defaults = {
		autoclose: false,
		beforeShowDay: $.noop,
		calendarWeeks: false,
		clearBtn: false,
		daysOfWeekDisabled: [],
		endDate: Infinity,
		forceParse: true,
		format: 'mm/dd/yyyy',
		keyboardNavigation: true,
		language: 'en',
		minViewMode: 0,
		multidate: false,
		multidateSeparator: ',',
		orientation: "auto",
		rtl: false,
		startDate: -Infinity,
		startView: 0,
		todayBtn: false,
		todayHighlight: false,
		weekStart: 0
	};
	var locale_opts = $.fn.datepicker.locale_opts = [
		'format',
		'rtl',
		'weekStart'
	];
	$.fn.datepicker.Constructor = Datepicker;
	var dates = $.fn.datepicker.dates = {
		en: {
			days: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
			daysShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
			daysMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"],
			months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
			monthsShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
			today: "Today",
			clear: "Clear"
		}
	};

	var DPGlobal = {
		modes: [
			{
				clsName: 'days',
				navFnc: 'Month',
				navStep: 1
			},
			{
				clsName: 'months',
				navFnc: 'FullYear',
				navStep: 1
			},
			{
				clsName: 'years',
				navFnc: 'FullYear',
				navStep: 10
		}],
		isLeapYear: function(year){
			return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
		},
		getDaysInMonth: function(year, month){
			return [31, (DPGlobal.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
		},
		validParts: /dd?|DD?|mm?|MM?|yy(?:yy)?/g,
		nonpunctuation: /[^ -\/:-@\[\u3400-\u9fff-`{-~\t\n\r]+/g,
		parseFormat: function(format){
			// IE treats \0 as a string end in inputs (truncating the value),
			// so it's a bad format delimiter, anyway
			var separators = format.replace(this.validParts, '\0').split('\0'),
				parts = format.match(this.validParts);
			if (!separators || !separators.length || !parts || parts.length === 0){
				throw new Error("Invalid date format.");
			}
			return {separators: separators, parts: parts};
		},
		parseDate: function(date, format, language){
			if (!date)
				return undefined;
			if (date instanceof Date)
				return date;
			if (typeof format === 'string')
				format = DPGlobal.parseFormat(format);
			var part_re = /([\-+]\d+)([dmwy])/,
				parts = date.match(/([\-+]\d+)([dmwy])/g),
				part, dir, i;
			if (/^[\-+]\d+[dmwy]([\s,]+[\-+]\d+[dmwy])*$/.test(date)){
				date = new Date();
				for (i=0; i < parts.length; i++){
					part = part_re.exec(parts[i]);
					dir = parseInt(part[1]);
					switch (part[2]){
						case 'd':
							date.setUTCDate(date.getUTCDate() + dir);
							break;
						case 'm':
							date = Datepicker.prototype.moveMonth.call(Datepicker.prototype, date, dir);
							break;
						case 'w':
							date.setUTCDate(date.getUTCDate() + dir * 7);
							break;
						case 'y':
							date = Datepicker.prototype.moveYear.call(Datepicker.prototype, date, dir);
							break;
					}
				}
				return UTCDate(date.getUTCFullYear(), date.getUTCMonth(), date.getUTCDate(), 0, 0, 0);
			}
			parts = date && date.match(this.nonpunctuation) || [];
			date = new Date();
			var parsed = {},
				setters_order = ['yyyy', 'yy', 'M', 'MM', 'm', 'mm', 'd', 'dd'],
				setters_map = {
					yyyy: function(d,v){
						return d.setUTCFullYear(v);
					},
					yy: function(d,v){
						return d.setUTCFullYear(2000+v);
					},
					m: function(d,v){
						if (isNaN(d))
							return d;
						v -= 1;
						while (v < 0) v += 12;
						v %= 12;
						d.setUTCMonth(v);
						while (d.getUTCMonth() !== v)
							d.setUTCDate(d.getUTCDate()-1);
						return d;
					},
					d: function(d,v){
						return d.setUTCDate(v);
					}
				},
				val, filtered;
			setters_map['M'] = setters_map['MM'] = setters_map['mm'] = setters_map['m'];
			setters_map['dd'] = setters_map['d'];
			date = UTCDate(date.getFullYear(), date.getMonth(), date.getDate(), 0, 0, 0);
			var fparts = format.parts.slice();
			// Remove noop parts
			if (parts.length !== fparts.length){
				fparts = $(fparts).filter(function(i,p){
					return $.inArray(p, setters_order) !== -1;
				}).toArray();
			}
			// Process remainder
			function match_part(){
				var m = this.slice(0, parts[i].length),
					p = parts[i].slice(0, m.length);
				return m === p;
			}
			if (parts.length === fparts.length){
				var cnt;
				for (i=0, cnt = fparts.length; i < cnt; i++){
					val = parseInt(parts[i], 10);
					part = fparts[i];
					if (isNaN(val)){
						switch (part){
							case 'MM':
								filtered = $(dates[language].months).filter(match_part);
								val = $.inArray(filtered[0], dates[language].months) + 1;
								break;
							case 'M':
								filtered = $(dates[language].monthsShort).filter(match_part);
								val = $.inArray(filtered[0], dates[language].monthsShort) + 1;
								break;
						}
					}
					parsed[part] = val;
				}
				var _date, s;
				for (i=0; i < setters_order.length; i++){
					s = setters_order[i];
					if (s in parsed && !isNaN(parsed[s])){
						_date = new Date(date);
						setters_map[s](_date, parsed[s]);
						if (!isNaN(_date))
							date = _date;
					}
				}
			}
			return date;
		},
		formatDate: function(date, format, language){
			if (!date)
				return '';
			if (typeof format === 'string')
				format = DPGlobal.parseFormat(format);
			var val = {
				d: date.getUTCDate(),
				D: dates[language].daysShort[date.getUTCDay()],
				DD: dates[language].days[date.getUTCDay()],
				m: date.getUTCMonth() + 1,
				M: dates[language].monthsShort[date.getUTCMonth()],
				MM: dates[language].months[date.getUTCMonth()],
				yy: date.getUTCFullYear().toString().substring(2),
				yyyy: date.getUTCFullYear()
			};
			val.dd = (val.d < 10 ? '0' : '') + val.d;
			val.mm = (val.m < 10 ? '0' : '') + val.m;
			date = [];
			var seps = $.extend([], format.separators);
			for (var i=0, cnt = format.parts.length; i <= cnt; i++){
				if (seps.length)
					date.push(seps.shift());
				date.push(val[format.parts[i]]);
			}
			return date.join('');
		},
		headTemplate: '<thead>'+
							'<tr>'+
								'<th class="prev">&laquo;</th>'+
								'<th colspan="5" class="datepicker-switch"></th>'+
								'<th class="next">&raquo;</th>'+
							'</tr>'+
						'</thead>',
		contTemplate: '<tbody><tr><td colspan="7"></td></tr></tbody>',
		footTemplate: '<tfoot>'+
							'<tr>'+
								'<th colspan="7" class="today"></th>'+
							'</tr>'+
							'<tr>'+
								'<th colspan="7" class="clear"></th>'+
							'</tr>'+
						'</tfoot>'
	};
	DPGlobal.template = '<div class="datepicker">'+
							'<div class="datepicker-days">'+
								'<table class=" table-condensed">'+
									DPGlobal.headTemplate+
									'<tbody></tbody>'+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-months">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
							'<div class="datepicker-years">'+
								'<table class="table-condensed">'+
									DPGlobal.headTemplate+
									DPGlobal.contTemplate+
									DPGlobal.footTemplate+
								'</table>'+
							'</div>'+
						'</div>';

	$.fn.datepicker.DPGlobal = DPGlobal;


	/* DATEPICKER NO CONFLICT
	* =================== */

	$.fn.datepicker.noConflict = function(){
		$.fn.datepicker = old;
		return this;
	};


	/* DATEPICKER DATA-API
	* ================== */

	$(document).on(
		'focus.datepicker.data-api click.datepicker.data-api',
		'[data-provide="datepicker"]',
		function(e){
			var $this = $(this);
			if ($this.data('datepicker'))
				return;
			e.preventDefault();
			// component click requires us to explicitly show it
			$this.datepicker('show');
		}
	);
	$(function(){
		$('[data-provide="datepicker-inline"]').datepicker();
	});

}(window.jQuery));

/*!
 DataTables 1.10.10
 ©2008-2015 SpryMedia Ltd - datatables.net/license
*/
(function(h){"function"===typeof define&&define.amd?define(["jquery"],function(E){return h(E,window,document)}):"object"===typeof exports?module.exports=function(E,H){E||(E=window);H||(H="undefined"!==typeof window?require("jquery"):require("jquery")(E));return h(H,E,E.document)}:h(jQuery,window,document)})(function(h,E,H,k){function Y(a){var b,c,d={};h.each(a,function(e){if((b=e.match(/^([^A-Z]+?)([A-Z])/))&&-1!=="a aa ai ao as b fn i m o s ".indexOf(b[1]+" "))c=e.replace(b[0],b[2].toLowerCase()),
d[c]=e,"o"===b[1]&&Y(a[e])});a._hungarianMap=d}function J(a,b,c){a._hungarianMap||Y(a);var d;h.each(b,function(e){d=a._hungarianMap[e];if(d!==k&&(c||b[d]===k))"o"===d.charAt(0)?(b[d]||(b[d]={}),h.extend(!0,b[d],b[e]),J(a[d],b[d],c)):b[d]=b[e]})}function Fa(a){var b=m.defaults.oLanguage,c=a.sZeroRecords;!a.sEmptyTable&&(c&&"No data available in table"===b.sEmptyTable)&&F(a,a,"sZeroRecords","sEmptyTable");!a.sLoadingRecords&&(c&&"Loading..."===b.sLoadingRecords)&&F(a,a,"sZeroRecords","sLoadingRecords");
a.sInfoThousands&&(a.sThousands=a.sInfoThousands);(a=a.sDecimal)&&db(a)}function eb(a){A(a,"ordering","bSort");A(a,"orderMulti","bSortMulti");A(a,"orderClasses","bSortClasses");A(a,"orderCellsTop","bSortCellsTop");A(a,"order","aaSorting");A(a,"orderFixed","aaSortingFixed");A(a,"paging","bPaginate");A(a,"pagingType","sPaginationType");A(a,"pageLength","iDisplayLength");A(a,"searching","bFilter");"boolean"===typeof a.sScrollX&&(a.sScrollX=a.sScrollX?"100%":"");"boolean"===typeof a.scrollX&&(a.scrollX=
a.scrollX?"100%":"");if(a=a.aoSearchCols)for(var b=0,c=a.length;b<c;b++)a[b]&&J(m.models.oSearch,a[b])}function fb(a){A(a,"orderable","bSortable");A(a,"orderData","aDataSort");A(a,"orderSequence","asSorting");A(a,"orderDataType","sortDataType");var b=a.aDataSort;b&&!h.isArray(b)&&(a.aDataSort=[b])}function gb(a){if(!m.__browser){var b={};m.__browser=b;var c=h("<div/>").css({position:"fixed",top:0,left:0,height:1,width:1,overflow:"hidden"}).append(h("<div/>").css({position:"absolute",top:1,left:1,
width:100,overflow:"scroll"}).append(h("<div/>").css({width:"100%",height:10}))).appendTo("body"),d=c.children(),e=d.children();b.barWidth=d[0].offsetWidth-d[0].clientWidth;b.bScrollOversize=100===e[0].offsetWidth&&100!==d[0].clientWidth;b.bScrollbarLeft=1!==Math.round(e.offset().left);b.bBounding=c[0].getBoundingClientRect().width?!0:!1;c.remove()}h.extend(a.oBrowser,m.__browser);a.oScroll.iBarWidth=m.__browser.barWidth}function hb(a,b,c,d,e,f){var g,j=!1;c!==k&&(g=c,j=!0);for(;d!==e;)a.hasOwnProperty(d)&&
(g=j?b(g,a[d],d,a):a[d],j=!0,d+=f);return g}function Ga(a,b){var c=m.defaults.column,d=a.aoColumns.length,c=h.extend({},m.models.oColumn,c,{nTh:b?b:H.createElement("th"),sTitle:c.sTitle?c.sTitle:b?b.innerHTML:"",aDataSort:c.aDataSort?c.aDataSort:[d],mData:c.mData?c.mData:d,idx:d});a.aoColumns.push(c);c=a.aoPreSearchCols;c[d]=h.extend({},m.models.oSearch,c[d]);la(a,d,h(b).data())}function la(a,b,c){var b=a.aoColumns[b],d=a.oClasses,e=h(b.nTh);if(!b.sWidthOrig){b.sWidthOrig=e.attr("width")||null;var f=
(e.attr("style")||"").match(/width:\s*(\d+[pxem%]+)/);f&&(b.sWidthOrig=f[1])}c!==k&&null!==c&&(fb(c),J(m.defaults.column,c),c.mDataProp!==k&&!c.mData&&(c.mData=c.mDataProp),c.sType&&(b._sManualType=c.sType),c.className&&!c.sClass&&(c.sClass=c.className),h.extend(b,c),F(b,c,"sWidth","sWidthOrig"),c.iDataSort!==k&&(b.aDataSort=[c.iDataSort]),F(b,c,"aDataSort"));var g=b.mData,j=Q(g),i=b.mRender?Q(b.mRender):null,c=function(a){return"string"===typeof a&&-1!==a.indexOf("@")};b._bAttrSrc=h.isPlainObject(g)&&
(c(g.sort)||c(g.type)||c(g.filter));b.fnGetData=function(a,b,c){var d=j(a,b,k,c);return i&&b?i(d,b,a,c):d};b.fnSetData=function(a,b,c){return R(g)(a,b,c)};"number"!==typeof g&&(a._rowReadObject=!0);a.oFeatures.bSort||(b.bSortable=!1,e.addClass(d.sSortableNone));a=-1!==h.inArray("asc",b.asSorting);c=-1!==h.inArray("desc",b.asSorting);!b.bSortable||!a&&!c?(b.sSortingClass=d.sSortableNone,b.sSortingClassJUI=""):a&&!c?(b.sSortingClass=d.sSortableAsc,b.sSortingClassJUI=d.sSortJUIAscAllowed):!a&&c?(b.sSortingClass=
d.sSortableDesc,b.sSortingClassJUI=d.sSortJUIDescAllowed):(b.sSortingClass=d.sSortable,b.sSortingClassJUI=d.sSortJUI)}function U(a){if(!1!==a.oFeatures.bAutoWidth){var b=a.aoColumns;Ha(a);for(var c=0,d=b.length;c<d;c++)b[c].nTh.style.width=b[c].sWidth}b=a.oScroll;(""!==b.sY||""!==b.sX)&&Z(a);v(a,null,"column-sizing",[a])}function $(a,b){var c=aa(a,"bVisible");return"number"===typeof c[b]?c[b]:null}function ba(a,b){var c=aa(a,"bVisible"),c=h.inArray(b,c);return-1!==c?c:null}function ca(a){return aa(a,
"bVisible").length}function aa(a,b){var c=[];h.map(a.aoColumns,function(a,e){a[b]&&c.push(e)});return c}function Ia(a){var b=a.aoColumns,c=a.aoData,d=m.ext.type.detect,e,f,g,j,i,h,l,q,u;e=0;for(f=b.length;e<f;e++)if(l=b[e],u=[],!l.sType&&l._sManualType)l.sType=l._sManualType;else if(!l.sType){g=0;for(j=d.length;g<j;g++){i=0;for(h=c.length;i<h;i++){u[i]===k&&(u[i]=B(a,i,e,"type"));q=d[g](u[i],a);if(!q&&g!==d.length-1)break;if("html"===q)break}if(q){l.sType=q;break}}l.sType||(l.sType="string")}}function ib(a,
b,c,d){var e,f,g,j,i,o,l=a.aoColumns;if(b)for(e=b.length-1;0<=e;e--){o=b[e];var q=o.targets!==k?o.targets:o.aTargets;h.isArray(q)||(q=[q]);f=0;for(g=q.length;f<g;f++)if("number"===typeof q[f]&&0<=q[f]){for(;l.length<=q[f];)Ga(a);d(q[f],o)}else if("number"===typeof q[f]&&0>q[f])d(l.length+q[f],o);else if("string"===typeof q[f]){j=0;for(i=l.length;j<i;j++)("_all"==q[f]||h(l[j].nTh).hasClass(q[f]))&&d(j,o)}}if(c){e=0;for(a=c.length;e<a;e++)d(e,c[e])}}function N(a,b,c,d){var e=a.aoData.length,f=h.extend(!0,
{},m.models.oRow,{src:c?"dom":"data",idx:e});f._aData=b;a.aoData.push(f);for(var g=a.aoColumns,j=0,i=g.length;j<i;j++)g[j].sType=null;a.aiDisplayMaster.push(e);b=a.rowIdFn(b);b!==k&&(a.aIds[b]=f);(c||!a.oFeatures.bDeferRender)&&Ja(a,e,c,d);return e}function ma(a,b){var c;b instanceof h||(b=h(b));return b.map(function(b,e){c=Ka(a,e);return N(a,c.data,e,c.cells)})}function B(a,b,c,d){var e=a.iDraw,f=a.aoColumns[c],g=a.aoData[b]._aData,j=f.sDefaultContent,i=f.fnGetData(g,d,{settings:a,row:b,col:c});
if(i===k)return a.iDrawError!=e&&null===j&&(K(a,0,"Requested unknown parameter "+("function"==typeof f.mData?"{function}":"'"+f.mData+"'")+" for row "+b+", column "+c,4),a.iDrawError=e),j;if((i===g||null===i)&&null!==j)i=j;else if("function"===typeof i)return i.call(g);return null===i&&"display"==d?"":i}function jb(a,b,c,d){a.aoColumns[c].fnSetData(a.aoData[b]._aData,d,{settings:a,row:b,col:c})}function La(a){return h.map(a.match(/(\\.|[^\.])+/g)||[""],function(a){return a.replace(/\\./g,".")})}function Q(a){if(h.isPlainObject(a)){var b=
{};h.each(a,function(a,c){c&&(b[a]=Q(c))});return function(a,c,f,g){var j=b[c]||b._;return j!==k?j(a,c,f,g):a}}if(null===a)return function(a){return a};if("function"===typeof a)return function(b,c,f,g){return a(b,c,f,g)};if("string"===typeof a&&(-1!==a.indexOf(".")||-1!==a.indexOf("[")||-1!==a.indexOf("("))){var c=function(a,b,f){var g,j;if(""!==f){j=La(f);for(var i=0,o=j.length;i<o;i++){f=j[i].match(da);g=j[i].match(V);if(f){j[i]=j[i].replace(da,"");""!==j[i]&&(a=a[j[i]]);g=[];j.splice(0,i+1);j=
j.join(".");if(h.isArray(a)){i=0;for(o=a.length;i<o;i++)g.push(c(a[i],b,j))}a=f[0].substring(1,f[0].length-1);a=""===a?g:g.join(a);break}else if(g){j[i]=j[i].replace(V,"");a=a[j[i]]();continue}if(null===a||a[j[i]]===k)return k;a=a[j[i]]}}return a};return function(b,e){return c(b,e,a)}}return function(b){return b[a]}}function R(a){if(h.isPlainObject(a))return R(a._);if(null===a)return function(){};if("function"===typeof a)return function(b,d,e){a(b,"set",d,e)};if("string"===typeof a&&(-1!==a.indexOf(".")||
-1!==a.indexOf("[")||-1!==a.indexOf("("))){var b=function(a,d,e){var e=La(e),f;f=e[e.length-1];for(var g,j,i=0,o=e.length-1;i<o;i++){g=e[i].match(da);j=e[i].match(V);if(g){e[i]=e[i].replace(da,"");a[e[i]]=[];f=e.slice();f.splice(0,i+1);g=f.join(".");if(h.isArray(d)){j=0;for(o=d.length;j<o;j++)f={},b(f,d[j],g),a[e[i]].push(f)}else a[e[i]]=d;return}j&&(e[i]=e[i].replace(V,""),a=a[e[i]](d));if(null===a[e[i]]||a[e[i]]===k)a[e[i]]={};a=a[e[i]]}if(f.match(V))a[f.replace(V,"")](d);else a[f.replace(da,"")]=
d};return function(c,d){return b(c,d,a)}}return function(b,d){b[a]=d}}function Ma(a){return D(a.aoData,"_aData")}function na(a){a.aoData.length=0;a.aiDisplayMaster.length=0;a.aiDisplay.length=0;a.aIds={}}function oa(a,b,c){for(var d=-1,e=0,f=a.length;e<f;e++)a[e]==b?d=e:a[e]>b&&a[e]--; -1!=d&&c===k&&a.splice(d,1)}function ea(a,b,c,d){var e=a.aoData[b],f,g=function(c,d){for(;c.childNodes.length;)c.removeChild(c.firstChild);c.innerHTML=B(a,b,d,"display")};if("dom"===c||(!c||"auto"===c)&&"dom"===e.src)e._aData=
Ka(a,e,d,d===k?k:e._aData).data;else{var j=e.anCells;if(j)if(d!==k)g(j[d],d);else{c=0;for(f=j.length;c<f;c++)g(j[c],c)}}e._aSortData=null;e._aFilterData=null;g=a.aoColumns;if(d!==k)g[d].sType=null;else{c=0;for(f=g.length;c<f;c++)g[c].sType=null;Na(a,e)}}function Ka(a,b,c,d){var e=[],f=b.firstChild,g,j,i=0,o,l=a.aoColumns,q=a._rowReadObject,d=d!==k?d:q?{}:[],u=function(a,b){if("string"===typeof a){var c=a.indexOf("@");-1!==c&&(c=a.substring(c+1),R(a)(d,b.getAttribute(c)))}},S=function(a){if(c===k||
c===i)j=l[i],o=h.trim(a.innerHTML),j&&j._bAttrSrc?(R(j.mData._)(d,o),u(j.mData.sort,a),u(j.mData.type,a),u(j.mData.filter,a)):q?(j._setter||(j._setter=R(j.mData)),j._setter(d,o)):d[i]=o;i++};if(f)for(;f;){g=f.nodeName.toUpperCase();if("TD"==g||"TH"==g)S(f),e.push(f);f=f.nextSibling}else{e=b.anCells;f=0;for(g=e.length;f<g;f++)S(e[f])}if(b=b.firstChild?b:b.nTr)(b=b.getAttribute("id"))&&R(a.rowId)(d,b);return{data:d,cells:e}}function Ja(a,b,c,d){var e=a.aoData[b],f=e._aData,g=[],j,i,h,l,q;if(null===
e.nTr){j=c||H.createElement("tr");e.nTr=j;e.anCells=g;j._DT_RowIndex=b;Na(a,e);l=0;for(q=a.aoColumns.length;l<q;l++){h=a.aoColumns[l];i=c?d[l]:H.createElement(h.sCellType);i._DT_CellIndex={row:b,column:l};g.push(i);if(!c||h.mRender||h.mData!==l)i.innerHTML=B(a,b,l,"display");h.sClass&&(i.className+=" "+h.sClass);h.bVisible&&!c?j.appendChild(i):!h.bVisible&&c&&i.parentNode.removeChild(i);h.fnCreatedCell&&h.fnCreatedCell.call(a.oInstance,i,B(a,b,l),f,b,l)}v(a,"aoRowCreatedCallback",null,[j,f,b])}e.nTr.setAttribute("role",
"row")}function Na(a,b){var c=b.nTr,d=b._aData;if(c){var e=a.rowIdFn(d);e&&(c.id=e);d.DT_RowClass&&(e=d.DT_RowClass.split(" "),b.__rowc=b.__rowc?pa(b.__rowc.concat(e)):e,h(c).removeClass(b.__rowc.join(" ")).addClass(d.DT_RowClass));d.DT_RowAttr&&h(c).attr(d.DT_RowAttr);d.DT_RowData&&h(c).data(d.DT_RowData)}}function kb(a){var b,c,d,e,f,g=a.nTHead,j=a.nTFoot,i=0===h("th, td",g).length,o=a.oClasses,l=a.aoColumns;i&&(e=h("<tr/>").appendTo(g));b=0;for(c=l.length;b<c;b++)f=l[b],d=h(f.nTh).addClass(f.sClass),
i&&d.appendTo(e),a.oFeatures.bSort&&(d.addClass(f.sSortingClass),!1!==f.bSortable&&(d.attr("tabindex",a.iTabIndex).attr("aria-controls",a.sTableId),Oa(a,f.nTh,b))),f.sTitle!=d[0].innerHTML&&d.html(f.sTitle),Pa(a,"header")(a,d,f,o);i&&fa(a.aoHeader,g);h(g).find(">tr").attr("role","row");h(g).find(">tr>th, >tr>td").addClass(o.sHeaderTH);h(j).find(">tr>th, >tr>td").addClass(o.sFooterTH);if(null!==j){a=a.aoFooter[0];b=0;for(c=a.length;b<c;b++)f=l[b],f.nTf=a[b].cell,f.sClass&&h(f.nTf).addClass(f.sClass)}}
function ga(a,b,c){var d,e,f,g=[],j=[],i=a.aoColumns.length,o;if(b){c===k&&(c=!1);d=0;for(e=b.length;d<e;d++){g[d]=b[d].slice();g[d].nTr=b[d].nTr;for(f=i-1;0<=f;f--)!a.aoColumns[f].bVisible&&!c&&g[d].splice(f,1);j.push([])}d=0;for(e=g.length;d<e;d++){if(a=g[d].nTr)for(;f=a.firstChild;)a.removeChild(f);f=0;for(b=g[d].length;f<b;f++)if(o=i=1,j[d][f]===k){a.appendChild(g[d][f].cell);for(j[d][f]=1;g[d+i]!==k&&g[d][f].cell==g[d+i][f].cell;)j[d+i][f]=1,i++;for(;g[d][f+o]!==k&&g[d][f].cell==g[d][f+o].cell;){for(c=
0;c<i;c++)j[d+c][f+o]=1;o++}h(g[d][f].cell).attr("rowspan",i).attr("colspan",o)}}}}function O(a){var b=v(a,"aoPreDrawCallback","preDraw",[a]);if(-1!==h.inArray(!1,b))C(a,!1);else{var b=[],c=0,d=a.asStripeClasses,e=d.length,f=a.oLanguage,g=a.iInitDisplayStart,j="ssp"==y(a),i=a.aiDisplay;a.bDrawing=!0;g!==k&&-1!==g&&(a._iDisplayStart=j?g:g>=a.fnRecordsDisplay()?0:g,a.iInitDisplayStart=-1);var g=a._iDisplayStart,o=a.fnDisplayEnd();if(a.bDeferLoading)a.bDeferLoading=!1,a.iDraw++,C(a,!1);else if(j){if(!a.bDestroying&&
!lb(a))return}else a.iDraw++;if(0!==i.length){f=j?a.aoData.length:o;for(j=j?0:g;j<f;j++){var l=i[j],q=a.aoData[l];null===q.nTr&&Ja(a,l);l=q.nTr;if(0!==e){var u=d[c%e];q._sRowStripe!=u&&(h(l).removeClass(q._sRowStripe).addClass(u),q._sRowStripe=u)}v(a,"aoRowCallback",null,[l,q._aData,c,j]);b.push(l);c++}}else c=f.sZeroRecords,1==a.iDraw&&"ajax"==y(a)?c=f.sLoadingRecords:f.sEmptyTable&&0===a.fnRecordsTotal()&&(c=f.sEmptyTable),b[0]=h("<tr/>",{"class":e?d[0]:""}).append(h("<td />",{valign:"top",colSpan:ca(a),
"class":a.oClasses.sRowEmpty}).html(c))[0];v(a,"aoHeaderCallback","header",[h(a.nTHead).children("tr")[0],Ma(a),g,o,i]);v(a,"aoFooterCallback","footer",[h(a.nTFoot).children("tr")[0],Ma(a),g,o,i]);d=h(a.nTBody);d.children().detach();d.append(h(b));v(a,"aoDrawCallback","draw",[a]);a.bSorted=!1;a.bFiltered=!1;a.bDrawing=!1}}function T(a,b){var c=a.oFeatures,d=c.bFilter;c.bSort&&mb(a);d?ha(a,a.oPreviousSearch):a.aiDisplay=a.aiDisplayMaster.slice();!0!==b&&(a._iDisplayStart=0);a._drawHold=b;O(a);a._drawHold=
!1}function nb(a){var b=a.oClasses,c=h(a.nTable),c=h("<div/>").insertBefore(c),d=a.oFeatures,e=h("<div/>",{id:a.sTableId+"_wrapper","class":b.sWrapper+(a.nTFoot?"":" "+b.sNoFooter)});a.nHolding=c[0];a.nTableWrapper=e[0];a.nTableReinsertBefore=a.nTable.nextSibling;for(var f=a.sDom.split(""),g,j,i,o,l,q,u=0;u<f.length;u++){g=null;j=f[u];if("<"==j){i=h("<div/>")[0];o=f[u+1];if("'"==o||'"'==o){l="";for(q=2;f[u+q]!=o;)l+=f[u+q],q++;"H"==l?l=b.sJUIHeader:"F"==l&&(l=b.sJUIFooter);-1!=l.indexOf(".")?(o=l.split("."),
i.id=o[0].substr(1,o[0].length-1),i.className=o[1]):"#"==l.charAt(0)?i.id=l.substr(1,l.length-1):i.className=l;u+=q}e.append(i);e=h(i)}else if(">"==j)e=e.parent();else if("l"==j&&d.bPaginate&&d.bLengthChange)g=ob(a);else if("f"==j&&d.bFilter)g=pb(a);else if("r"==j&&d.bProcessing)g=qb(a);else if("t"==j)g=rb(a);else if("i"==j&&d.bInfo)g=sb(a);else if("p"==j&&d.bPaginate)g=tb(a);else if(0!==m.ext.feature.length){i=m.ext.feature;q=0;for(o=i.length;q<o;q++)if(j==i[q].cFeature){g=i[q].fnInit(a);break}}g&&
(i=a.aanFeatures,i[j]||(i[j]=[]),i[j].push(g),e.append(g))}c.replaceWith(e);a.nHolding=null}function fa(a,b){var c=h(b).children("tr"),d,e,f,g,j,i,o,l,q,u;a.splice(0,a.length);f=0;for(i=c.length;f<i;f++)a.push([]);f=0;for(i=c.length;f<i;f++){d=c[f];for(e=d.firstChild;e;){if("TD"==e.nodeName.toUpperCase()||"TH"==e.nodeName.toUpperCase()){l=1*e.getAttribute("colspan");q=1*e.getAttribute("rowspan");l=!l||0===l||1===l?1:l;q=!q||0===q||1===q?1:q;g=0;for(j=a[f];j[g];)g++;o=g;u=1===l?!0:!1;for(j=0;j<l;j++)for(g=
0;g<q;g++)a[f+g][o+j]={cell:e,unique:u},a[f+g].nTr=d}e=e.nextSibling}}}function qa(a,b,c){var d=[];c||(c=a.aoHeader,b&&(c=[],fa(c,b)));for(var b=0,e=c.length;b<e;b++)for(var f=0,g=c[b].length;f<g;f++)if(c[b][f].unique&&(!d[f]||!a.bSortCellsTop))d[f]=c[b][f].cell;return d}function ra(a,b,c){v(a,"aoServerParams","serverParams",[b]);if(b&&h.isArray(b)){var d={},e=/(.*?)\[\]$/;h.each(b,function(a,b){var c=b.name.match(e);c?(c=c[0],d[c]||(d[c]=[]),d[c].push(b.value)):d[b.name]=b.value});b=d}var f,g=a.ajax,
j=a.oInstance,i=function(b){v(a,null,"xhr",[a,b,a.jqXHR]);c(b)};if(h.isPlainObject(g)&&g.data){f=g.data;var o=h.isFunction(f)?f(b,a):f,b=h.isFunction(f)&&o?o:h.extend(!0,b,o);delete g.data}o={data:b,success:function(b){var c=b.error||b.sError;c&&K(a,0,c);a.json=b;i(b)},dataType:"json",cache:!1,type:a.sServerMethod,error:function(b,c){var d=v(a,null,"xhr",[a,null,a.jqXHR]);-1===h.inArray(!0,d)&&("parsererror"==c?K(a,0,"Invalid JSON response",1):4===b.readyState&&K(a,0,"Ajax error",7));C(a,!1)}};a.oAjaxData=
b;v(a,null,"preXhr",[a,b]);a.fnServerData?a.fnServerData.call(j,a.sAjaxSource,h.map(b,function(a,b){return{name:b,value:a}}),i,a):a.sAjaxSource||"string"===typeof g?a.jqXHR=h.ajax(h.extend(o,{url:g||a.sAjaxSource})):h.isFunction(g)?a.jqXHR=g.call(j,b,i,a):(a.jqXHR=h.ajax(h.extend(o,g)),g.data=f)}function lb(a){return a.bAjaxDataGet?(a.iDraw++,C(a,!0),ra(a,ub(a),function(b){vb(a,b)}),!1):!0}function ub(a){var b=a.aoColumns,c=b.length,d=a.oFeatures,e=a.oPreviousSearch,f=a.aoPreSearchCols,g,j=[],i,o,
l,q=W(a);g=a._iDisplayStart;i=!1!==d.bPaginate?a._iDisplayLength:-1;var k=function(a,b){j.push({name:a,value:b})};k("sEcho",a.iDraw);k("iColumns",c);k("sColumns",D(b,"sName").join(","));k("iDisplayStart",g);k("iDisplayLength",i);var S={draw:a.iDraw,columns:[],order:[],start:g,length:i,search:{value:e.sSearch,regex:e.bRegex}};for(g=0;g<c;g++)o=b[g],l=f[g],i="function"==typeof o.mData?"function":o.mData,S.columns.push({data:i,name:o.sName,searchable:o.bSearchable,orderable:o.bSortable,search:{value:l.sSearch,
regex:l.bRegex}}),k("mDataProp_"+g,i),d.bFilter&&(k("sSearch_"+g,l.sSearch),k("bRegex_"+g,l.bRegex),k("bSearchable_"+g,o.bSearchable)),d.bSort&&k("bSortable_"+g,o.bSortable);d.bFilter&&(k("sSearch",e.sSearch),k("bRegex",e.bRegex));d.bSort&&(h.each(q,function(a,b){S.order.push({column:b.col,dir:b.dir});k("iSortCol_"+a,b.col);k("sSortDir_"+a,b.dir)}),k("iSortingCols",q.length));b=m.ext.legacy.ajax;return null===b?a.sAjaxSource?j:S:b?j:S}function vb(a,b){var c=sa(a,b),d=b.sEcho!==k?b.sEcho:b.draw,e=
b.iTotalRecords!==k?b.iTotalRecords:b.recordsTotal,f=b.iTotalDisplayRecords!==k?b.iTotalDisplayRecords:b.recordsFiltered;if(d){if(1*d<a.iDraw)return;a.iDraw=1*d}na(a);a._iRecordsTotal=parseInt(e,10);a._iRecordsDisplay=parseInt(f,10);d=0;for(e=c.length;d<e;d++)N(a,c[d]);a.aiDisplay=a.aiDisplayMaster.slice();a.bAjaxDataGet=!1;O(a);a._bInitComplete||ta(a,b);a.bAjaxDataGet=!0;C(a,!1)}function sa(a,b){var c=h.isPlainObject(a.ajax)&&a.ajax.dataSrc!==k?a.ajax.dataSrc:a.sAjaxDataProp;return"data"===c?b.aaData||
b[c]:""!==c?Q(c)(b):b}function pb(a){var b=a.oClasses,c=a.sTableId,d=a.oLanguage,e=a.oPreviousSearch,f=a.aanFeatures,g='<input type="search" class="'+b.sFilterInput+'"/>',j=d.sSearch,j=j.match(/_INPUT_/)?j.replace("_INPUT_",g):j+g,b=h("<div/>",{id:!f.f?c+"_filter":null,"class":b.sFilter}).append(h("<label/>").append(j)),f=function(){var b=!this.value?"":this.value;b!=e.sSearch&&(ha(a,{sSearch:b,bRegex:e.bRegex,bSmart:e.bSmart,bCaseInsensitive:e.bCaseInsensitive}),a._iDisplayStart=0,O(a))},g=null!==
a.searchDelay?a.searchDelay:"ssp"===y(a)?400:0,i=h("input",b).val(e.sSearch).attr("placeholder",d.sSearchPlaceholder).bind("keyup.DT search.DT input.DT paste.DT cut.DT",g?ua(f,g):f).bind("keypress.DT",function(a){if(13==a.keyCode)return!1}).attr("aria-controls",c);h(a.nTable).on("search.dt.DT",function(b,c){if(a===c)try{i[0]!==H.activeElement&&i.val(e.sSearch)}catch(d){}});return b[0]}function ha(a,b,c){var d=a.oPreviousSearch,e=a.aoPreSearchCols,f=function(a){d.sSearch=a.sSearch;d.bRegex=a.bRegex;
d.bSmart=a.bSmart;d.bCaseInsensitive=a.bCaseInsensitive};Ia(a);if("ssp"!=y(a)){wb(a,b.sSearch,c,b.bEscapeRegex!==k?!b.bEscapeRegex:b.bRegex,b.bSmart,b.bCaseInsensitive);f(b);for(b=0;b<e.length;b++)xb(a,e[b].sSearch,b,e[b].bEscapeRegex!==k?!e[b].bEscapeRegex:e[b].bRegex,e[b].bSmart,e[b].bCaseInsensitive);yb(a)}else f(b);a.bFiltered=!0;v(a,null,"search",[a])}function yb(a){for(var b=m.ext.search,c=a.aiDisplay,d,e,f=0,g=b.length;f<g;f++){for(var j=[],i=0,o=c.length;i<o;i++)e=c[i],d=a.aoData[e],b[f](a,
d._aFilterData,e,d._aData,i)&&j.push(e);c.length=0;h.merge(c,j)}}function xb(a,b,c,d,e,f){if(""!==b)for(var g=a.aiDisplay,d=Qa(b,d,e,f),e=g.length-1;0<=e;e--)b=a.aoData[g[e]]._aFilterData[c],d.test(b)||g.splice(e,1)}function wb(a,b,c,d,e,f){var d=Qa(b,d,e,f),e=a.oPreviousSearch.sSearch,f=a.aiDisplayMaster,g;0!==m.ext.search.length&&(c=!0);g=zb(a);if(0>=b.length)a.aiDisplay=f.slice();else{if(g||c||e.length>b.length||0!==b.indexOf(e)||a.bSorted)a.aiDisplay=f.slice();b=a.aiDisplay;for(c=b.length-1;0<=
c;c--)d.test(a.aoData[b[c]]._sFilterRow)||b.splice(c,1)}}function Qa(a,b,c,d){a=b?a:va(a);c&&(a="^(?=.*?"+h.map(a.match(/"[^"]+"|[^ ]+/g)||[""],function(a){if('"'===a.charAt(0))var b=a.match(/^"(.*)"$/),a=b?b[1]:a;return a.replace('"',"")}).join(")(?=.*?")+").*$");return RegExp(a,d?"i":"")}function va(a){return a.replace(Yb,"\\$1")}function zb(a){var b=a.aoColumns,c,d,e,f,g,j,i,h,l=m.ext.type.search;c=!1;d=0;for(f=a.aoData.length;d<f;d++)if(h=a.aoData[d],!h._aFilterData){j=[];e=0;for(g=b.length;e<
g;e++)c=b[e],c.bSearchable?(i=B(a,d,e,"filter"),l[c.sType]&&(i=l[c.sType](i)),null===i&&(i=""),"string"!==typeof i&&i.toString&&(i=i.toString())):i="",i.indexOf&&-1!==i.indexOf("&")&&(wa.innerHTML=i,i=Zb?wa.textContent:wa.innerText),i.replace&&(i=i.replace(/[\r\n]/g,"")),j.push(i);h._aFilterData=j;h._sFilterRow=j.join("  ");c=!0}return c}function Ab(a){return{search:a.sSearch,smart:a.bSmart,regex:a.bRegex,caseInsensitive:a.bCaseInsensitive}}function Bb(a){return{sSearch:a.search,bSmart:a.smart,bRegex:a.regex,
bCaseInsensitive:a.caseInsensitive}}function sb(a){var b=a.sTableId,c=a.aanFeatures.i,d=h("<div/>",{"class":a.oClasses.sInfo,id:!c?b+"_info":null});c||(a.aoDrawCallback.push({fn:Cb,sName:"information"}),d.attr("role","status").attr("aria-live","polite"),h(a.nTable).attr("aria-describedby",b+"_info"));return d[0]}function Cb(a){var b=a.aanFeatures.i;if(0!==b.length){var c=a.oLanguage,d=a._iDisplayStart+1,e=a.fnDisplayEnd(),f=a.fnRecordsTotal(),g=a.fnRecordsDisplay(),j=g?c.sInfo:c.sInfoEmpty;g!==f&&
(j+=" "+c.sInfoFiltered);j+=c.sInfoPostFix;j=Db(a,j);c=c.fnInfoCallback;null!==c&&(j=c.call(a.oInstance,a,d,e,f,g,j));h(b).html(j)}}function Db(a,b){var c=a.fnFormatNumber,d=a._iDisplayStart+1,e=a._iDisplayLength,f=a.fnRecordsDisplay(),g=-1===e;return b.replace(/_START_/g,c.call(a,d)).replace(/_END_/g,c.call(a,a.fnDisplayEnd())).replace(/_MAX_/g,c.call(a,a.fnRecordsTotal())).replace(/_TOTAL_/g,c.call(a,f)).replace(/_PAGE_/g,c.call(a,g?1:Math.ceil(d/e))).replace(/_PAGES_/g,c.call(a,g?1:Math.ceil(f/
e)))}function ia(a){var b,c,d=a.iInitDisplayStart,e=a.aoColumns,f;c=a.oFeatures;var g=a.bDeferLoading;if(a.bInitialised){nb(a);kb(a);ga(a,a.aoHeader);ga(a,a.aoFooter);C(a,!0);c.bAutoWidth&&Ha(a);b=0;for(c=e.length;b<c;b++)f=e[b],f.sWidth&&(f.nTh.style.width=w(f.sWidth));v(a,null,"preInit",[a]);T(a);e=y(a);if("ssp"!=e||g)"ajax"==e?ra(a,[],function(c){var f=sa(a,c);for(b=0;b<f.length;b++)N(a,f[b]);a.iInitDisplayStart=d;T(a);C(a,!1);ta(a,c)},a):(C(a,!1),ta(a))}else setTimeout(function(){ia(a)},200)}
function ta(a,b){a._bInitComplete=!0;(b||a.oInit.aaData)&&U(a);v(a,null,"plugin-init",[a,b]);v(a,"aoInitComplete","init",[a,b])}function Ra(a,b){var c=parseInt(b,10);a._iDisplayLength=c;Sa(a);v(a,null,"length",[a,c])}function ob(a){for(var b=a.oClasses,c=a.sTableId,d=a.aLengthMenu,e=h.isArray(d[0]),f=e?d[0]:d,d=e?d[1]:d,e=h("<select/>",{name:c+"_length","aria-controls":c,"class":b.sLengthSelect}),g=0,j=f.length;g<j;g++)e[0][g]=new Option(d[g],f[g]);var i=h("<div><label/></div>").addClass(b.sLength);
a.aanFeatures.l||(i[0].id=c+"_length");i.children().append(a.oLanguage.sLengthMenu.replace("_MENU_",e[0].outerHTML));h("select",i).val(a._iDisplayLength).bind("change.DT",function(){Ra(a,h(this).val());O(a)});h(a.nTable).bind("length.dt.DT",function(b,c,d){a===c&&h("select",i).val(d)});return i[0]}function tb(a){var b=a.sPaginationType,c=m.ext.pager[b],d="function"===typeof c,e=function(a){O(a)},b=h("<div/>").addClass(a.oClasses.sPaging+b)[0],f=a.aanFeatures;d||c.fnInit(a,b,e);f.p||(b.id=a.sTableId+
"_paginate",a.aoDrawCallback.push({fn:function(a){if(d){var b=a._iDisplayStart,i=a._iDisplayLength,h=a.fnRecordsDisplay(),l=-1===i,b=l?0:Math.ceil(b/i),i=l?1:Math.ceil(h/i),h=c(b,i),k,l=0;for(k=f.p.length;l<k;l++)Pa(a,"pageButton")(a,f.p[l],l,h,b,i)}else c.fnUpdate(a,e)},sName:"pagination"}));return b}function Ta(a,b,c){var d=a._iDisplayStart,e=a._iDisplayLength,f=a.fnRecordsDisplay();0===f||-1===e?d=0:"number"===typeof b?(d=b*e,d>f&&(d=0)):"first"==b?d=0:"previous"==b?(d=0<=e?d-e:0,0>d&&(d=0)):"next"==
b?d+e<f&&(d+=e):"last"==b?d=Math.floor((f-1)/e)*e:K(a,0,"Unknown paging action: "+b,5);b=a._iDisplayStart!==d;a._iDisplayStart=d;b&&(v(a,null,"page",[a]),c&&O(a));return b}function qb(a){return h("<div/>",{id:!a.aanFeatures.r?a.sTableId+"_processing":null,"class":a.oClasses.sProcessing}).html(a.oLanguage.sProcessing).insertBefore(a.nTable)[0]}function C(a,b){a.oFeatures.bProcessing&&h(a.aanFeatures.r).css("display",b?"block":"none");v(a,null,"processing",[a,b])}function rb(a){var b=h(a.nTable);b.attr("role",
"grid");var c=a.oScroll;if(""===c.sX&&""===c.sY)return a.nTable;var d=c.sX,e=c.sY,f=a.oClasses,g=b.children("caption"),j=g.length?g[0]._captionSide:null,i=h(b[0].cloneNode(!1)),o=h(b[0].cloneNode(!1)),l=b.children("tfoot");l.length||(l=null);i=h("<div/>",{"class":f.sScrollWrapper}).append(h("<div/>",{"class":f.sScrollHead}).css({overflow:"hidden",position:"relative",border:0,width:d?!d?null:w(d):"100%"}).append(h("<div/>",{"class":f.sScrollHeadInner}).css({"box-sizing":"content-box",width:c.sXInner||
"100%"}).append(i.removeAttr("id").css("margin-left",0).append("top"===j?g:null).append(b.children("thead"))))).append(h("<div/>",{"class":f.sScrollBody}).css({position:"relative",overflow:"auto",width:!d?null:w(d)}).append(b));l&&i.append(h("<div/>",{"class":f.sScrollFoot}).css({overflow:"hidden",border:0,width:d?!d?null:w(d):"100%"}).append(h("<div/>",{"class":f.sScrollFootInner}).append(o.removeAttr("id").css("margin-left",0).append("bottom"===j?g:null).append(b.children("tfoot")))));var b=i.children(),
k=b[0],f=b[1],u=l?b[2]:null;if(d)h(f).on("scroll.DT",function(){var a=this.scrollLeft;k.scrollLeft=a;l&&(u.scrollLeft=a)});h(f).css(e&&c.bCollapse?"max-height":"height",e);a.nScrollHead=k;a.nScrollBody=f;a.nScrollFoot=u;a.aoDrawCallback.push({fn:Z,sName:"scrolling"});return i[0]}function Z(a){var b=a.oScroll,c=b.sX,d=b.sXInner,e=b.sY,b=b.iBarWidth,f=h(a.nScrollHead),g=f[0].style,j=f.children("div"),i=j[0].style,o=j.children("table"),j=a.nScrollBody,l=h(j),q=j.style,u=h(a.nScrollFoot).children("div"),
m=u.children("table"),n=h(a.nTHead),p=h(a.nTable),t=p[0],v=t.style,r=a.nTFoot?h(a.nTFoot):null,Eb=a.oBrowser,Ua=Eb.bScrollOversize,s,L,P,x,y=[],z=[],A=[],B,C=function(a){a=a.style;a.paddingTop="0";a.paddingBottom="0";a.borderTopWidth="0";a.borderBottomWidth="0";a.height=0};L=j.scrollHeight>j.clientHeight;if(a.scrollBarVis!==L&&a.scrollBarVis!==k)a.scrollBarVis=L,U(a);else{a.scrollBarVis=L;p.children("thead, tfoot").remove();x=n.clone().prependTo(p);n=n.find("tr");L=x.find("tr");x.find("th, td").removeAttr("tabindex");
r&&(P=r.clone().prependTo(p),s=r.find("tr"),P=P.find("tr"));c||(q.width="100%",f[0].style.width="100%");h.each(qa(a,x),function(b,c){B=$(a,b);c.style.width=a.aoColumns[B].sWidth});r&&I(function(a){a.style.width=""},P);f=p.outerWidth();if(""===c){v.width="100%";if(Ua&&(p.find("tbody").height()>j.offsetHeight||"scroll"==l.css("overflow-y")))v.width=w(p.outerWidth()-b);f=p.outerWidth()}else""!==d&&(v.width=w(d),f=p.outerWidth());I(C,L);I(function(a){A.push(a.innerHTML);y.push(w(h(a).css("width")))},
L);I(function(a,b){a.style.width=y[b]},n);h(L).height(0);r&&(I(C,P),I(function(a){z.push(w(h(a).css("width")))},P),I(function(a,b){a.style.width=z[b]},s),h(P).height(0));I(function(a,b){a.innerHTML='<div class="dataTables_sizing" style="height:0;overflow:hidden;">'+A[b]+"</div>";a.style.width=y[b]},L);r&&I(function(a,b){a.innerHTML="";a.style.width=z[b]},P);if(p.outerWidth()<f){s=j.scrollHeight>j.offsetHeight||"scroll"==l.css("overflow-y")?f+b:f;if(Ua&&(j.scrollHeight>j.offsetHeight||"scroll"==l.css("overflow-y")))v.width=
w(s-b);(""===c||""!==d)&&K(a,1,"Possible column misalignment",6)}else s="100%";q.width=w(s);g.width=w(s);r&&(a.nScrollFoot.style.width=w(s));!e&&Ua&&(q.height=w(t.offsetHeight+b));c=p.outerWidth();o[0].style.width=w(c);i.width=w(c);d=p.height()>j.clientHeight||"scroll"==l.css("overflow-y");e="padding"+(Eb.bScrollbarLeft?"Left":"Right");i[e]=d?b+"px":"0px";r&&(m[0].style.width=w(c),u[0].style.width=w(c),u[0].style[e]=d?b+"px":"0px");l.scroll();if((a.bSorted||a.bFiltered)&&!a._drawHold)j.scrollTop=
0}}function I(a,b,c){for(var d=0,e=0,f=b.length,g,j;e<f;){g=b[e].firstChild;for(j=c?c[e].firstChild:null;g;)1===g.nodeType&&(c?a(g,j,d):a(g,d),d++),g=g.nextSibling,j=c?j.nextSibling:null;e++}}function Ha(a){var b=a.nTable,c=a.aoColumns,d=a.oScroll,e=d.sY,f=d.sX,g=d.sXInner,j=c.length,i=aa(a,"bVisible"),o=h("th",a.nTHead),l=b.getAttribute("width"),k=b.parentNode,u=!1,m,n,p=a.oBrowser,d=p.bScrollOversize;(m=b.style.width)&&-1!==m.indexOf("%")&&(l=m);for(m=0;m<i.length;m++)n=c[i[m]],null!==n.sWidth&&
(n.sWidth=Fb(n.sWidthOrig,k),u=!0);if(d||!u&&!f&&!e&&j==ca(a)&&j==o.length)for(m=0;m<j;m++)i=$(a,m),null!==i&&(c[i].sWidth=w(o.eq(m).width()));else{j=h(b).clone().css("visibility","hidden").removeAttr("id");j.find("tbody tr").remove();var t=h("<tr/>").appendTo(j.find("tbody"));j.find("thead, tfoot").remove();j.append(h(a.nTHead).clone()).append(h(a.nTFoot).clone());j.find("tfoot th, tfoot td").css("width","");o=qa(a,j.find("thead")[0]);for(m=0;m<i.length;m++)n=c[i[m]],o[m].style.width=null!==n.sWidthOrig&&
""!==n.sWidthOrig?w(n.sWidthOrig):"",n.sWidthOrig&&f&&h(o[m]).append(h("<div/>").css({width:n.sWidthOrig,margin:0,padding:0,border:0,height:1}));if(a.aoData.length)for(m=0;m<i.length;m++)u=i[m],n=c[u],h(Gb(a,u)).clone(!1).append(n.sContentPadding).appendTo(t);n=h("<div/>").css(f||e?{position:"absolute",top:0,left:0,height:1,right:0,overflow:"hidden"}:{}).append(j).appendTo(k);f&&g?j.width(g):f?(j.css("width","auto"),j.removeAttr("width"),j.width()<k.clientWidth&&l&&j.width(k.clientWidth)):e?j.width(k.clientWidth):
l&&j.width(l);for(m=e=0;m<i.length;m++)k=h(o[m]),g=k.outerWidth()-k.width(),k=p.bBounding?Math.ceil(o[m].getBoundingClientRect().width):k.outerWidth(),e+=k,c[i[m]].sWidth=w(k-g);b.style.width=w(e);n.remove()}l&&(b.style.width=w(l));if((l||f)&&!a._reszEvt)b=function(){h(E).bind("resize.DT-"+a.sInstance,ua(function(){U(a)}))},d?setTimeout(b,1E3):b(),a._reszEvt=!0}function ua(a,b){var c=b!==k?b:200,d,e;return function(){var b=this,g=+new Date,j=arguments;d&&g<d+c?(clearTimeout(e),e=setTimeout(function(){d=
k;a.apply(b,j)},c)):(d=g,a.apply(b,j))}}function Fb(a,b){if(!a)return 0;var c=h("<div/>").css("width",w(a)).appendTo(b||H.body),d=c[0].offsetWidth;c.remove();return d}function Gb(a,b){var c=Hb(a,b);if(0>c)return null;var d=a.aoData[c];return!d.nTr?h("<td/>").html(B(a,c,b,"display"))[0]:d.anCells[b]}function Hb(a,b){for(var c,d=-1,e=-1,f=0,g=a.aoData.length;f<g;f++)c=B(a,f,b,"display")+"",c=c.replace($b,""),c=c.replace(/&nbsp;/g," "),c.length>d&&(d=c.length,e=f);return e}function w(a){return null===
a?"0px":"number"==typeof a?0>a?"0px":a+"px":a.match(/\d$/)?a+"px":a}function W(a){var b,c,d=[],e=a.aoColumns,f,g,j,i;b=a.aaSortingFixed;c=h.isPlainObject(b);var o=[];f=function(a){a.length&&!h.isArray(a[0])?o.push(a):h.merge(o,a)};h.isArray(b)&&f(b);c&&b.pre&&f(b.pre);f(a.aaSorting);c&&b.post&&f(b.post);for(a=0;a<o.length;a++){i=o[a][0];f=e[i].aDataSort;b=0;for(c=f.length;b<c;b++)g=f[b],j=e[g].sType||"string",o[a]._idx===k&&(o[a]._idx=h.inArray(o[a][1],e[g].asSorting)),d.push({src:i,col:g,dir:o[a][1],
index:o[a]._idx,type:j,formatter:m.ext.type.order[j+"-pre"]})}return d}function mb(a){var b,c,d=[],e=m.ext.type.order,f=a.aoData,g=0,j,i=a.aiDisplayMaster,h;Ia(a);h=W(a);b=0;for(c=h.length;b<c;b++)j=h[b],j.formatter&&g++,Ib(a,j.col);if("ssp"!=y(a)&&0!==h.length){b=0;for(c=i.length;b<c;b++)d[i[b]]=b;g===h.length?i.sort(function(a,b){var c,e,g,j,i=h.length,k=f[a]._aSortData,m=f[b]._aSortData;for(g=0;g<i;g++)if(j=h[g],c=k[j.col],e=m[j.col],c=c<e?-1:c>e?1:0,0!==c)return"asc"===j.dir?c:-c;c=d[a];e=d[b];
return c<e?-1:c>e?1:0}):i.sort(function(a,b){var c,g,j,i,k=h.length,m=f[a]._aSortData,p=f[b]._aSortData;for(j=0;j<k;j++)if(i=h[j],c=m[i.col],g=p[i.col],i=e[i.type+"-"+i.dir]||e["string-"+i.dir],c=i(c,g),0!==c)return c;c=d[a];g=d[b];return c<g?-1:c>g?1:0})}a.bSorted=!0}function Jb(a){for(var b,c,d=a.aoColumns,e=W(a),a=a.oLanguage.oAria,f=0,g=d.length;f<g;f++){c=d[f];var j=c.asSorting;b=c.sTitle.replace(/<.*?>/g,"");var i=c.nTh;i.removeAttribute("aria-sort");c.bSortable&&(0<e.length&&e[0].col==f?(i.setAttribute("aria-sort",
"asc"==e[0].dir?"ascending":"descending"),c=j[e[0].index+1]||j[0]):c=j[0],b+="asc"===c?a.sSortAscending:a.sSortDescending);i.setAttribute("aria-label",b)}}function Va(a,b,c,d){var e=a.aaSorting,f=a.aoColumns[b].asSorting,g=function(a,b){var c=a._idx;c===k&&(c=h.inArray(a[1],f));return c+1<f.length?c+1:b?null:0};"number"===typeof e[0]&&(e=a.aaSorting=[e]);c&&a.oFeatures.bSortMulti?(c=h.inArray(b,D(e,"0")),-1!==c?(b=g(e[c],!0),null===b&&1===e.length&&(b=0),null===b?e.splice(c,1):(e[c][1]=f[b],e[c]._idx=
b)):(e.push([b,f[0],0]),e[e.length-1]._idx=0)):e.length&&e[0][0]==b?(b=g(e[0]),e.length=1,e[0][1]=f[b],e[0]._idx=b):(e.length=0,e.push([b,f[0]]),e[0]._idx=0);T(a);"function"==typeof d&&d(a)}function Oa(a,b,c,d){var e=a.aoColumns[c];Wa(b,{},function(b){!1!==e.bSortable&&(a.oFeatures.bProcessing?(C(a,!0),setTimeout(function(){Va(a,c,b.shiftKey,d);"ssp"!==y(a)&&C(a,!1)},0)):Va(a,c,b.shiftKey,d))})}function xa(a){var b=a.aLastSort,c=a.oClasses.sSortColumn,d=W(a),e=a.oFeatures,f,g;if(e.bSort&&e.bSortClasses){e=
0;for(f=b.length;e<f;e++)g=b[e].src,h(D(a.aoData,"anCells",g)).removeClass(c+(2>e?e+1:3));e=0;for(f=d.length;e<f;e++)g=d[e].src,h(D(a.aoData,"anCells",g)).addClass(c+(2>e?e+1:3))}a.aLastSort=d}function Ib(a,b){var c=a.aoColumns[b],d=m.ext.order[c.sSortDataType],e;d&&(e=d.call(a.oInstance,a,b,ba(a,b)));for(var f,g=m.ext.type.order[c.sType+"-pre"],j=0,i=a.aoData.length;j<i;j++)if(c=a.aoData[j],c._aSortData||(c._aSortData=[]),!c._aSortData[b]||d)f=d?e[j]:B(a,j,b,"sort"),c._aSortData[b]=g?g(f):f}function ya(a){if(a.oFeatures.bStateSave&&
!a.bDestroying){var b={time:+new Date,start:a._iDisplayStart,length:a._iDisplayLength,order:h.extend(!0,[],a.aaSorting),search:Ab(a.oPreviousSearch),columns:h.map(a.aoColumns,function(b,d){return{visible:b.bVisible,search:Ab(a.aoPreSearchCols[d])}})};v(a,"aoStateSaveParams","stateSaveParams",[a,b]);a.oSavedState=b;a.fnStateSaveCallback.call(a.oInstance,a,b)}}function Kb(a){var b,c,d=a.aoColumns;if(a.oFeatures.bStateSave){var e=a.fnStateLoadCallback.call(a.oInstance,a);if(e&&e.time&&(b=v(a,"aoStateLoadParams",
"stateLoadParams",[a,e]),-1===h.inArray(!1,b)&&(b=a.iStateDuration,!(0<b&&e.time<+new Date-1E3*b)&&d.length===e.columns.length))){a.oLoadedState=h.extend(!0,{},e);e.start!==k&&(a._iDisplayStart=e.start,a.iInitDisplayStart=e.start);e.length!==k&&(a._iDisplayLength=e.length);e.order!==k&&(a.aaSorting=[],h.each(e.order,function(b,c){a.aaSorting.push(c[0]>=d.length?[0,c[1]]:c)}));e.search!==k&&h.extend(a.oPreviousSearch,Bb(e.search));b=0;for(c=e.columns.length;b<c;b++){var f=e.columns[b];f.visible!==
k&&(d[b].bVisible=f.visible);f.search!==k&&h.extend(a.aoPreSearchCols[b],Bb(f.search))}v(a,"aoStateLoaded","stateLoaded",[a,e])}}}function za(a){var b=m.settings,a=h.inArray(a,D(b,"nTable"));return-1!==a?b[a]:null}function K(a,b,c,d){c="DataTables warning: "+(a?"table id="+a.sTableId+" - ":"")+c;d&&(c+=". For more information about this error, please see http://datatables.net/tn/"+d);if(b)E.console&&console.log&&console.log(c);else if(b=m.ext,b=b.sErrMode||b.errMode,a&&v(a,null,"error",[a,d,c]),"alert"==
b)alert(c);else{if("throw"==b)throw Error(c);"function"==typeof b&&b(a,d,c)}}function F(a,b,c,d){h.isArray(c)?h.each(c,function(c,d){h.isArray(d)?F(a,b,d[0],d[1]):F(a,b,d)}):(d===k&&(d=c),b[c]!==k&&(a[d]=b[c]))}function Lb(a,b,c){var d,e;for(e in b)b.hasOwnProperty(e)&&(d=b[e],h.isPlainObject(d)?(h.isPlainObject(a[e])||(a[e]={}),h.extend(!0,a[e],d)):a[e]=c&&"data"!==e&&"aaData"!==e&&h.isArray(d)?d.slice():d);return a}function Wa(a,b,c){h(a).bind("click.DT",b,function(b){a.blur();c(b)}).bind("keypress.DT",
b,function(a){13===a.which&&(a.preventDefault(),c(a))}).bind("selectstart.DT",function(){return!1})}function z(a,b,c,d){c&&a[b].push({fn:c,sName:d})}function v(a,b,c,d){var e=[];b&&(e=h.map(a[b].slice().reverse(),function(b){return b.fn.apply(a.oInstance,d)}));null!==c&&(b=h.Event(c+".dt"),h(a.nTable).trigger(b,d),e.push(b.result));return e}function Sa(a){var b=a._iDisplayStart,c=a.fnDisplayEnd(),d=a._iDisplayLength;b>=c&&(b=c-d);b-=b%d;if(-1===d||0>b)b=0;a._iDisplayStart=b}function Pa(a,b){var c=
a.renderer,d=m.ext.renderer[b];return h.isPlainObject(c)&&c[b]?d[c[b]]||d._:"string"===typeof c?d[c]||d._:d._}function y(a){return a.oFeatures.bServerSide?"ssp":a.ajax||a.sAjaxSource?"ajax":"dom"}function Aa(a,b){var c=[],c=Mb.numbers_length,d=Math.floor(c/2);b<=c?c=X(0,b):a<=d?(c=X(0,c-2),c.push("ellipsis"),c.push(b-1)):(a>=b-1-d?c=X(b-(c-2),b):(c=X(a-d+2,a+d-1),c.push("ellipsis"),c.push(b-1)),c.splice(0,0,"ellipsis"),c.splice(0,0,0));c.DT_el="span";return c}function db(a){h.each({num:function(b){return Ba(b,
a)},"num-fmt":function(b){return Ba(b,a,Xa)},"html-num":function(b){return Ba(b,a,Ca)},"html-num-fmt":function(b){return Ba(b,a,Ca,Xa)}},function(b,c){s.type.order[b+a+"-pre"]=c;b.match(/^html\-/)&&(s.type.search[b+a]=s.type.search.html)})}function Nb(a){return function(){var b=[za(this[m.ext.iApiIndex])].concat(Array.prototype.slice.call(arguments));return m.ext.internal[a].apply(this,b)}}var m,s,t,p,r,Ya={},Ob=/[\r\n]/g,Ca=/<.*?>/g,ac=/^[\w\+\-]/,bc=/[\w\+\-]$/,Yb=RegExp("(\\/|\\.|\\*|\\+|\\?|\\||\\(|\\)|\\[|\\]|\\{|\\}|\\\\|\\$|\\^|\\-)",
"g"),Xa=/[',$£€¥%\u2009\u202F\u20BD\u20a9\u20BArfk]/gi,M=function(a){return!a||!0===a||"-"===a?!0:!1},Pb=function(a){var b=parseInt(a,10);return!isNaN(b)&&isFinite(a)?b:null},Qb=function(a,b){Ya[b]||(Ya[b]=RegExp(va(b),"g"));return"string"===typeof a&&"."!==b?a.replace(/\./g,"").replace(Ya[b],"."):a},Za=function(a,b,c){var d="string"===typeof a;if(M(a))return!0;b&&d&&(a=Qb(a,b));c&&d&&(a=a.replace(Xa,""));return!isNaN(parseFloat(a))&&isFinite(a)},Rb=function(a,b,c){return M(a)?!0:!(M(a)||"string"===
typeof a)?null:Za(a.replace(Ca,""),b,c)?!0:null},D=function(a,b,c){var d=[],e=0,f=a.length;if(c!==k)for(;e<f;e++)a[e]&&a[e][b]&&d.push(a[e][b][c]);else for(;e<f;e++)a[e]&&d.push(a[e][b]);return d},ja=function(a,b,c,d){var e=[],f=0,g=b.length;if(d!==k)for(;f<g;f++)a[b[f]][c]&&e.push(a[b[f]][c][d]);else for(;f<g;f++)e.push(a[b[f]][c]);return e},X=function(a,b){var c=[],d;b===k?(b=0,d=a):(d=b,b=a);for(var e=b;e<d;e++)c.push(e);return c},Sb=function(a){for(var b=[],c=0,d=a.length;c<d;c++)a[c]&&b.push(a[c]);
return b},pa=function(a){var b=[],c,d,e=a.length,f,g=0;d=0;a:for(;d<e;d++){c=a[d];for(f=0;f<g;f++)if(b[f]===c)continue a;b.push(c);g++}return b},A=function(a,b,c){a[b]!==k&&(a[c]=a[b])},da=/\[.*?\]$/,V=/\(\)$/,wa=h("<div>")[0],Zb=wa.textContent!==k,$b=/<.*?>/g;m=function(a){this.$=function(a,b){return this.api(!0).$(a,b)};this._=function(a,b){return this.api(!0).rows(a,b).data()};this.api=function(a){return a?new t(za(this[s.iApiIndex])):new t(this)};this.fnAddData=function(a,b){var c=this.api(!0),
d=h.isArray(a)&&(h.isArray(a[0])||h.isPlainObject(a[0]))?c.rows.add(a):c.row.add(a);(b===k||b)&&c.draw();return d.flatten().toArray()};this.fnAdjustColumnSizing=function(a){var b=this.api(!0).columns.adjust(),c=b.settings()[0],d=c.oScroll;a===k||a?b.draw(!1):(""!==d.sX||""!==d.sY)&&Z(c)};this.fnClearTable=function(a){var b=this.api(!0).clear();(a===k||a)&&b.draw()};this.fnClose=function(a){this.api(!0).row(a).child.hide()};this.fnDeleteRow=function(a,b,c){var d=this.api(!0),a=d.rows(a),e=a.settings()[0],
h=e.aoData[a[0][0]];a.remove();b&&b.call(this,e,h);(c===k||c)&&d.draw();return h};this.fnDestroy=function(a){this.api(!0).destroy(a)};this.fnDraw=function(a){this.api(!0).draw(a)};this.fnFilter=function(a,b,c,d,e,h){e=this.api(!0);null===b||b===k?e.search(a,c,d,h):e.column(b).search(a,c,d,h);e.draw()};this.fnGetData=function(a,b){var c=this.api(!0);if(a!==k){var d=a.nodeName?a.nodeName.toLowerCase():"";return b!==k||"td"==d||"th"==d?c.cell(a,b).data():c.row(a).data()||null}return c.data().toArray()};
this.fnGetNodes=function(a){var b=this.api(!0);return a!==k?b.row(a).node():b.rows().nodes().flatten().toArray()};this.fnGetPosition=function(a){var b=this.api(!0),c=a.nodeName.toUpperCase();return"TR"==c?b.row(a).index():"TD"==c||"TH"==c?(a=b.cell(a).index(),[a.row,a.columnVisible,a.column]):null};this.fnIsOpen=function(a){return this.api(!0).row(a).child.isShown()};this.fnOpen=function(a,b,c){return this.api(!0).row(a).child(b,c).show().child()[0]};this.fnPageChange=function(a,b){var c=this.api(!0).page(a);
(b===k||b)&&c.draw(!1)};this.fnSetColumnVis=function(a,b,c){a=this.api(!0).column(a).visible(b);(c===k||c)&&a.columns.adjust().draw()};this.fnSettings=function(){return za(this[s.iApiIndex])};this.fnSort=function(a){this.api(!0).order(a).draw()};this.fnSortListener=function(a,b,c){this.api(!0).order.listener(a,b,c)};this.fnUpdate=function(a,b,c,d,e){var h=this.api(!0);c===k||null===c?h.row(b).data(a):h.cell(b,c).data(a);(e===k||e)&&h.columns.adjust();(d===k||d)&&h.draw();return 0};this.fnVersionCheck=
s.fnVersionCheck;var b=this,c=a===k,d=this.length;c&&(a={});this.oApi=this.internal=s.internal;for(var e in m.ext.internal)e&&(this[e]=Nb(e));this.each(function(){var e={},e=1<d?Lb(e,a,!0):a,g=0,j,i=this.getAttribute("id"),o=!1,l=m.defaults,q=h(this);if("table"!=this.nodeName.toLowerCase())K(null,0,"Non-table node initialisation ("+this.nodeName+")",2);else{eb(l);fb(l.column);J(l,l,!0);J(l.column,l.column,!0);J(l,h.extend(e,q.data()));var u=m.settings,g=0;for(j=u.length;g<j;g++){var p=u[g];if(p.nTable==
this||p.nTHead.parentNode==this||p.nTFoot&&p.nTFoot.parentNode==this){g=e.bRetrieve!==k?e.bRetrieve:l.bRetrieve;if(c||g)return p.oInstance;if(e.bDestroy!==k?e.bDestroy:l.bDestroy){p.oInstance.fnDestroy();break}else{K(p,0,"Cannot reinitialise DataTable",3);return}}if(p.sTableId==this.id){u.splice(g,1);break}}if(null===i||""===i)this.id=i="DataTables_Table_"+m.ext._unique++;var n=h.extend(!0,{},m.models.oSettings,{sDestroyWidth:q[0].style.width,sInstance:i,sTableId:i});n.nTable=this;n.oApi=b.internal;
n.oInit=e;u.push(n);n.oInstance=1===b.length?b:q.dataTable();eb(e);e.oLanguage&&Fa(e.oLanguage);e.aLengthMenu&&!e.iDisplayLength&&(e.iDisplayLength=h.isArray(e.aLengthMenu[0])?e.aLengthMenu[0][0]:e.aLengthMenu[0]);e=Lb(h.extend(!0,{},l),e);F(n.oFeatures,e,"bPaginate bLengthChange bFilter bSort bSortMulti bInfo bProcessing bAutoWidth bSortClasses bServerSide bDeferRender".split(" "));F(n,e,["asStripeClasses","ajax","fnServerData","fnFormatNumber","sServerMethod","aaSorting","aaSortingFixed","aLengthMenu",
"sPaginationType","sAjaxSource","sAjaxDataProp","iStateDuration","sDom","bSortCellsTop","iTabIndex","fnStateLoadCallback","fnStateSaveCallback","renderer","searchDelay","rowId",["iCookieDuration","iStateDuration"],["oSearch","oPreviousSearch"],["aoSearchCols","aoPreSearchCols"],["iDisplayLength","_iDisplayLength"],["bJQueryUI","bJUI"]]);F(n.oScroll,e,[["sScrollX","sX"],["sScrollXInner","sXInner"],["sScrollY","sY"],["bScrollCollapse","bCollapse"]]);F(n.oLanguage,e,"fnInfoCallback");z(n,"aoDrawCallback",
e.fnDrawCallback,"user");z(n,"aoServerParams",e.fnServerParams,"user");z(n,"aoStateSaveParams",e.fnStateSaveParams,"user");z(n,"aoStateLoadParams",e.fnStateLoadParams,"user");z(n,"aoStateLoaded",e.fnStateLoaded,"user");z(n,"aoRowCallback",e.fnRowCallback,"user");z(n,"aoRowCreatedCallback",e.fnCreatedRow,"user");z(n,"aoHeaderCallback",e.fnHeaderCallback,"user");z(n,"aoFooterCallback",e.fnFooterCallback,"user");z(n,"aoInitComplete",e.fnInitComplete,"user");z(n,"aoPreDrawCallback",e.fnPreDrawCallback,
"user");n.rowIdFn=Q(e.rowId);gb(n);i=n.oClasses;e.bJQueryUI?(h.extend(i,m.ext.oJUIClasses,e.oClasses),e.sDom===l.sDom&&"lfrtip"===l.sDom&&(n.sDom='<"H"lfr>t<"F"ip>'),n.renderer)?h.isPlainObject(n.renderer)&&!n.renderer.header&&(n.renderer.header="jqueryui"):n.renderer="jqueryui":h.extend(i,m.ext.classes,e.oClasses);q.addClass(i.sTable);n.iInitDisplayStart===k&&(n.iInitDisplayStart=e.iDisplayStart,n._iDisplayStart=e.iDisplayStart);null!==e.iDeferLoading&&(n.bDeferLoading=!0,g=h.isArray(e.iDeferLoading),
n._iRecordsDisplay=g?e.iDeferLoading[0]:e.iDeferLoading,n._iRecordsTotal=g?e.iDeferLoading[1]:e.iDeferLoading);var t=n.oLanguage;h.extend(!0,t,e.oLanguage);""!==t.sUrl&&(h.ajax({dataType:"json",url:t.sUrl,success:function(a){Fa(a);J(l.oLanguage,a);h.extend(true,t,a);ia(n)},error:function(){ia(n)}}),o=!0);null===e.asStripeClasses&&(n.asStripeClasses=[i.sStripeOdd,i.sStripeEven]);var g=n.asStripeClasses,r=q.children("tbody").find("tr").eq(0);-1!==h.inArray(!0,h.map(g,function(a){return r.hasClass(a)}))&&
(h("tbody tr",this).removeClass(g.join(" ")),n.asDestroyStripes=g.slice());u=[];g=this.getElementsByTagName("thead");0!==g.length&&(fa(n.aoHeader,g[0]),u=qa(n));if(null===e.aoColumns){p=[];g=0;for(j=u.length;g<j;g++)p.push(null)}else p=e.aoColumns;g=0;for(j=p.length;g<j;g++)Ga(n,u?u[g]:null);ib(n,e.aoColumnDefs,p,function(a,b){la(n,a,b)});if(r.length){var s=function(a,b){return a.getAttribute("data-"+b)!==null?b:null};h(r[0]).children("th, td").each(function(a,b){var c=n.aoColumns[a];if(c.mData===
a){var d=s(b,"sort")||s(b,"order"),e=s(b,"filter")||s(b,"search");if(d!==null||e!==null){c.mData={_:a+".display",sort:d!==null?a+".@data-"+d:k,type:d!==null?a+".@data-"+d:k,filter:e!==null?a+".@data-"+e:k};la(n,a)}}})}var w=n.oFeatures;e.bStateSave&&(w.bStateSave=!0,Kb(n,e),z(n,"aoDrawCallback",ya,"state_save"));if(e.aaSorting===k){u=n.aaSorting;g=0;for(j=u.length;g<j;g++)u[g][1]=n.aoColumns[g].asSorting[0]}xa(n);w.bSort&&z(n,"aoDrawCallback",function(){if(n.bSorted){var a=W(n),b={};h.each(a,function(a,
c){b[c.src]=c.dir});v(n,null,"order",[n,a,b]);Jb(n)}});z(n,"aoDrawCallback",function(){(n.bSorted||y(n)==="ssp"||w.bDeferRender)&&xa(n)},"sc");g=q.children("caption").each(function(){this._captionSide=q.css("caption-side")});j=q.children("thead");0===j.length&&(j=h("<thead/>").appendTo(this));n.nTHead=j[0];j=q.children("tbody");0===j.length&&(j=h("<tbody/>").appendTo(this));n.nTBody=j[0];j=q.children("tfoot");if(0===j.length&&0<g.length&&(""!==n.oScroll.sX||""!==n.oScroll.sY))j=h("<tfoot/>").appendTo(this);
0===j.length||0===j.children().length?q.addClass(i.sNoFooter):0<j.length&&(n.nTFoot=j[0],fa(n.aoFooter,n.nTFoot));if(e.aaData)for(g=0;g<e.aaData.length;g++)N(n,e.aaData[g]);else(n.bDeferLoading||"dom"==y(n))&&ma(n,h(n.nTBody).children("tr"));n.aiDisplay=n.aiDisplayMaster.slice();n.bInitialised=!0;!1===o&&ia(n)}});b=null;return this};var Tb=[],x=Array.prototype,cc=function(a){var b,c,d=m.settings,e=h.map(d,function(a){return a.nTable});if(a){if(a.nTable&&a.oApi)return[a];if(a.nodeName&&"table"===a.nodeName.toLowerCase())return b=
h.inArray(a,e),-1!==b?[d[b]]:null;if(a&&"function"===typeof a.settings)return a.settings().toArray();"string"===typeof a?c=h(a):a instanceof h&&(c=a)}else return[];if(c)return c.map(function(){b=h.inArray(this,e);return-1!==b?d[b]:null}).toArray()};t=function(a,b){if(!(this instanceof t))return new t(a,b);var c=[],d=function(a){(a=cc(a))&&(c=c.concat(a))};if(h.isArray(a))for(var e=0,f=a.length;e<f;e++)d(a[e]);else d(a);this.context=pa(c);b&&h.merge(this,b);this.selector={rows:null,cols:null,opts:null};
t.extend(this,this,Tb)};m.Api=t;h.extend(t.prototype,{any:function(){return 0!==this.count()},concat:x.concat,context:[],count:function(){return this.flatten().length},each:function(a){for(var b=0,c=this.length;b<c;b++)a.call(this,this[b],b,this);return this},eq:function(a){var b=this.context;return b.length>a?new t(b[a],this[a]):null},filter:function(a){var b=[];if(x.filter)b=x.filter.call(this,a,this);else for(var c=0,d=this.length;c<d;c++)a.call(this,this[c],c,this)&&b.push(this[c]);return new t(this.context,
b)},flatten:function(){var a=[];return new t(this.context,a.concat.apply(a,this.toArray()))},join:x.join,indexOf:x.indexOf||function(a,b){for(var c=b||0,d=this.length;c<d;c++)if(this[c]===a)return c;return-1},iterator:function(a,b,c,d){var e=[],f,g,h,i,o,l=this.context,m,p,r=this.selector;"string"===typeof a&&(d=c,c=b,b=a,a=!1);g=0;for(h=l.length;g<h;g++){var n=new t(l[g]);if("table"===b)f=c.call(n,l[g],g),f!==k&&e.push(f);else if("columns"===b||"rows"===b)f=c.call(n,l[g],this[g],g),f!==k&&e.push(f);
else if("column"===b||"column-rows"===b||"row"===b||"cell"===b){p=this[g];"column-rows"===b&&(m=Da(l[g],r.opts));i=0;for(o=p.length;i<o;i++)f=p[i],f="cell"===b?c.call(n,l[g],f.row,f.column,g,i):c.call(n,l[g],f,g,i,m),f!==k&&e.push(f)}}return e.length||d?(a=new t(l,a?e.concat.apply([],e):e),b=a.selector,b.rows=r.rows,b.cols=r.cols,b.opts=r.opts,a):this},lastIndexOf:x.lastIndexOf||function(a,b){return this.indexOf.apply(this.toArray.reverse(),arguments)},length:0,map:function(a){var b=[];if(x.map)b=
x.map.call(this,a,this);else for(var c=0,d=this.length;c<d;c++)b.push(a.call(this,this[c],c));return new t(this.context,b)},pluck:function(a){return this.map(function(b){return b[a]})},pop:x.pop,push:x.push,reduce:x.reduce||function(a,b){return hb(this,a,b,0,this.length,1)},reduceRight:x.reduceRight||function(a,b){return hb(this,a,b,this.length-1,-1,-1)},reverse:x.reverse,selector:null,shift:x.shift,sort:x.sort,splice:x.splice,toArray:function(){return x.slice.call(this)},to$:function(){return h(this)},
toJQuery:function(){return h(this)},unique:function(){return new t(this.context,pa(this))},unshift:x.unshift});t.extend=function(a,b,c){if(c.length&&b&&(b instanceof t||b.__dt_wrapper)){var d,e,f,g=function(a,b,c){return function(){var d=b.apply(a,arguments);t.extend(d,d,c.methodExt);return d}};d=0;for(e=c.length;d<e;d++)f=c[d],b[f.name]="function"===typeof f.val?g(a,f.val,f):h.isPlainObject(f.val)?{}:f.val,b[f.name].__dt_wrapper=!0,t.extend(a,b[f.name],f.propExt)}};t.register=p=function(a,b){if(h.isArray(a))for(var c=
0,d=a.length;c<d;c++)t.register(a[c],b);else for(var e=a.split("."),f=Tb,g,j,c=0,d=e.length;c<d;c++){g=(j=-1!==e[c].indexOf("()"))?e[c].replace("()",""):e[c];var i;a:{i=0;for(var k=f.length;i<k;i++)if(f[i].name===g){i=f[i];break a}i=null}i||(i={name:g,val:{},methodExt:[],propExt:[]},f.push(i));c===d-1?i.val=b:f=j?i.methodExt:i.propExt}};t.registerPlural=r=function(a,b,c){t.register(a,c);t.register(b,function(){var a=c.apply(this,arguments);return a===this?this:a instanceof t?a.length?h.isArray(a[0])?
new t(a.context,a[0]):a[0]:k:a})};p("tables()",function(a){var b;if(a){b=t;var c=this.context;if("number"===typeof a)a=[c[a]];else var d=h.map(c,function(a){return a.nTable}),a=h(d).filter(a).map(function(){var a=h.inArray(this,d);return c[a]}).toArray();b=new b(a)}else b=this;return b});p("table()",function(a){var a=this.tables(a),b=a.context;return b.length?new t(b[0]):a});r("tables().nodes()","table().node()",function(){return this.iterator("table",function(a){return a.nTable},1)});r("tables().body()",
"table().body()",function(){return this.iterator("table",function(a){return a.nTBody},1)});r("tables().header()","table().header()",function(){return this.iterator("table",function(a){return a.nTHead},1)});r("tables().footer()","table().footer()",function(){return this.iterator("table",function(a){return a.nTFoot},1)});r("tables().containers()","table().container()",function(){return this.iterator("table",function(a){return a.nTableWrapper},1)});p("draw()",function(a){return this.iterator("table",
function(b){"page"===a?O(b):("string"===typeof a&&(a="full-hold"===a?!1:!0),T(b,!1===a))})});p("page()",function(a){return a===k?this.page.info().page:this.iterator("table",function(b){Ta(b,a)})});p("page.info()",function(){if(0===this.context.length)return k;var a=this.context[0],b=a._iDisplayStart,c=a.oFeatures.bPaginate?a._iDisplayLength:-1,d=a.fnRecordsDisplay(),e=-1===c;return{page:e?0:Math.floor(b/c),pages:e?1:Math.ceil(d/c),start:b,end:a.fnDisplayEnd(),length:c,recordsTotal:a.fnRecordsTotal(),
recordsDisplay:d,serverSide:"ssp"===y(a)}});p("page.len()",function(a){return a===k?0!==this.context.length?this.context[0]._iDisplayLength:k:this.iterator("table",function(b){Ra(b,a)})});var Ub=function(a,b,c){if(c){var d=new t(a);d.one("draw",function(){c(d.ajax.json())})}if("ssp"==y(a))T(a,b);else{C(a,!0);var e=a.jqXHR;e&&4!==e.readyState&&e.abort();ra(a,[],function(c){na(a);for(var c=sa(a,c),d=0,e=c.length;d<e;d++)N(a,c[d]);T(a,b);C(a,!1)})}};p("ajax.json()",function(){var a=this.context;if(0<
a.length)return a[0].json});p("ajax.params()",function(){var a=this.context;if(0<a.length)return a[0].oAjaxData});p("ajax.reload()",function(a,b){return this.iterator("table",function(c){Ub(c,!1===b,a)})});p("ajax.url()",function(a){var b=this.context;if(a===k){if(0===b.length)return k;b=b[0];return b.ajax?h.isPlainObject(b.ajax)?b.ajax.url:b.ajax:b.sAjaxSource}return this.iterator("table",function(b){h.isPlainObject(b.ajax)?b.ajax.url=a:b.ajax=a})});p("ajax.url().load()",function(a,b){return this.iterator("table",
function(c){Ub(c,!1===b,a)})});var $a=function(a,b,c,d,e){var f=[],g,j,i,o,l,m;i=typeof b;if(!b||"string"===i||"function"===i||b.length===k)b=[b];i=0;for(o=b.length;i<o;i++){j=b[i]&&b[i].split?b[i].split(","):[b[i]];l=0;for(m=j.length;l<m;l++)(g=c("string"===typeof j[l]?h.trim(j[l]):j[l]))&&g.length&&(f=f.concat(g))}a=s.selector[a];if(a.length){i=0;for(o=a.length;i<o;i++)f=a[i](d,e,f)}return pa(f)},ab=function(a){a||(a={});a.filter&&a.search===k&&(a.search=a.filter);return h.extend({search:"none",
order:"current",page:"all"},a)},bb=function(a){for(var b=0,c=a.length;b<c;b++)if(0<a[b].length)return a[0]=a[b],a[0].length=1,a.length=1,a.context=[a.context[b]],a;a.length=0;return a},Da=function(a,b){var c,d,e,f=[],g=a.aiDisplay;c=a.aiDisplayMaster;var j=b.search;d=b.order;e=b.page;if("ssp"==y(a))return"removed"===j?[]:X(0,c.length);if("current"==e){c=a._iDisplayStart;for(d=a.fnDisplayEnd();c<d;c++)f.push(g[c])}else if("current"==d||"applied"==d)f="none"==j?c.slice():"applied"==j?g.slice():h.map(c,
function(a){return-1===h.inArray(a,g)?a:null});else if("index"==d||"original"==d){c=0;for(d=a.aoData.length;c<d;c++)"none"==j?f.push(c):(e=h.inArray(c,g),(-1===e&&"removed"==j||0<=e&&"applied"==j)&&f.push(c))}return f};p("rows()",function(a,b){a===k?a="":h.isPlainObject(a)&&(b=a,a="");var b=ab(b),c=this.iterator("table",function(c){var e=b;return $a("row",a,function(a){var b=Pb(a);if(b!==null&&!e)return[b];var j=Da(c,e);if(b!==null&&h.inArray(b,j)!==-1)return[b];if(!a)return j;if(typeof a==="function")return h.map(j,
function(b){var e=c.aoData[b];return a(b,e._aData,e.nTr)?b:null});b=Sb(ja(c.aoData,j,"nTr"));if(a.nodeName&&h.inArray(a,b)!==-1)return[a._DT_RowIndex];if(typeof a==="string"&&a.charAt(0)==="#"){j=c.aIds[a.replace(/^#/,"")];if(j!==k)return[j.idx]}return h(b).filter(a).map(function(){return this._DT_RowIndex}).toArray()},c,e)},1);c.selector.rows=a;c.selector.opts=b;return c});p("rows().nodes()",function(){return this.iterator("row",function(a,b){return a.aoData[b].nTr||k},1)});p("rows().data()",function(){return this.iterator(!0,
"rows",function(a,b){return ja(a.aoData,b,"_aData")},1)});r("rows().cache()","row().cache()",function(a){return this.iterator("row",function(b,c){var d=b.aoData[c];return"search"===a?d._aFilterData:d._aSortData},1)});r("rows().invalidate()","row().invalidate()",function(a){return this.iterator("row",function(b,c){ea(b,c,a)})});r("rows().indexes()","row().index()",function(){return this.iterator("row",function(a,b){return b},1)});r("rows().ids()","row().id()",function(a){for(var b=[],c=this.context,
d=0,e=c.length;d<e;d++)for(var f=0,g=this[d].length;f<g;f++){var h=c[d].rowIdFn(c[d].aoData[this[d][f]]._aData);b.push((!0===a?"#":"")+h)}return new t(c,b)});r("rows().remove()","row().remove()",function(){var a=this;this.iterator("row",function(b,c,d){var e=b.aoData,f=e[c],g,h,i,o,l;e.splice(c,1);g=0;for(h=e.length;g<h;g++)if(i=e[g],l=i.anCells,null!==i.nTr&&(i.nTr._DT_RowIndex=g),null!==l){i=0;for(o=l.length;i<o;i++)l[i]._DT_CellIndex.row=g}oa(b.aiDisplayMaster,c);oa(b.aiDisplay,c);oa(a[d],c,!1);
Sa(b);c=b.rowIdFn(f._aData);c!==k&&delete b.aIds[c]});this.iterator("table",function(a){for(var c=0,d=a.aoData.length;c<d;c++)a.aoData[c].idx=c});return this});p("rows.add()",function(a){var b=this.iterator("table",function(b){var c,f,g,h=[];f=0;for(g=a.length;f<g;f++)c=a[f],c.nodeName&&"TR"===c.nodeName.toUpperCase()?h.push(ma(b,c)[0]):h.push(N(b,c));return h},1),c=this.rows(-1);c.pop();h.merge(c,b);return c});p("row()",function(a,b){return bb(this.rows(a,b))});p("row().data()",function(a){var b=
this.context;if(a===k)return b.length&&this.length?b[0].aoData[this[0]]._aData:k;b[0].aoData[this[0]]._aData=a;ea(b[0],this[0],"data");return this});p("row().node()",function(){var a=this.context;return a.length&&this.length?a[0].aoData[this[0]].nTr||null:null});p("row.add()",function(a){a instanceof h&&a.length&&(a=a[0]);var b=this.iterator("table",function(b){return a.nodeName&&"TR"===a.nodeName.toUpperCase()?ma(b,a)[0]:N(b,a)});return this.row(b[0])});var cb=function(a,b){var c=a.context;if(c.length&&
(c=c[0].aoData[b!==k?b:a[0]])&&c._details)c._details.remove(),c._detailsShow=k,c._details=k},Vb=function(a,b){var c=a.context;if(c.length&&a.length){var d=c[0].aoData[a[0]];if(d._details){(d._detailsShow=b)?d._details.insertAfter(d.nTr):d._details.detach();var e=c[0],f=new t(e),g=e.aoData;f.off("draw.dt.DT_details column-visibility.dt.DT_details destroy.dt.DT_details");0<D(g,"_details").length&&(f.on("draw.dt.DT_details",function(a,b){e===b&&f.rows({page:"current"}).eq(0).each(function(a){a=g[a];
a._detailsShow&&a._details.insertAfter(a.nTr)})}),f.on("column-visibility.dt.DT_details",function(a,b){if(e===b)for(var c,d=ca(b),f=0,h=g.length;f<h;f++)c=g[f],c._details&&c._details.children("td[colspan]").attr("colspan",d)}),f.on("destroy.dt.DT_details",function(a,b){if(e===b)for(var c=0,d=g.length;c<d;c++)g[c]._details&&cb(f,c)}))}}};p("row().child()",function(a,b){var c=this.context;if(a===k)return c.length&&this.length?c[0].aoData[this[0]]._details:k;if(!0===a)this.child.show();else if(!1===
a)cb(this);else if(c.length&&this.length){var d=c[0],c=c[0].aoData[this[0]],e=[],f=function(a,b){if(h.isArray(a)||a instanceof h)for(var c=0,k=a.length;c<k;c++)f(a[c],b);else a.nodeName&&"tr"===a.nodeName.toLowerCase()?e.push(a):(c=h("<tr><td/></tr>").addClass(b),h("td",c).addClass(b).html(a)[0].colSpan=ca(d),e.push(c[0]))};f(a,b);c._details&&c._details.remove();c._details=h(e);c._detailsShow&&c._details.insertAfter(c.nTr)}return this});p(["row().child.show()","row().child().show()"],function(){Vb(this,
!0);return this});p(["row().child.hide()","row().child().hide()"],function(){Vb(this,!1);return this});p(["row().child.remove()","row().child().remove()"],function(){cb(this);return this});p("row().child.isShown()",function(){var a=this.context;return a.length&&this.length?a[0].aoData[this[0]]._detailsShow||!1:!1});var dc=/^(.+):(name|visIdx|visible)$/,Wb=function(a,b,c,d,e){for(var c=[],d=0,f=e.length;d<f;d++)c.push(B(a,e[d],b));return c};p("columns()",function(a,b){a===k?a="":h.isPlainObject(a)&&
(b=a,a="");var b=ab(b),c=this.iterator("table",function(c){var e=a,f=b,g=c.aoColumns,j=D(g,"sName"),i=D(g,"nTh");return $a("column",e,function(a){var b=Pb(a);if(a==="")return X(g.length);if(b!==null)return[b>=0?b:g.length+b];if(typeof a==="function"){var e=Da(c,f);return h.map(g,function(b,f){return a(f,Wb(c,f,0,0,e),i[f])?f:null})}var k=typeof a==="string"?a.match(dc):"";if(k)switch(k[2]){case "visIdx":case "visible":b=parseInt(k[1],10);if(b<0){var m=h.map(g,function(a,b){return a.bVisible?b:null});
return[m[m.length+b]]}return[$(c,b)];case "name":return h.map(j,function(a,b){return a===k[1]?b:null})}else return h(i).filter(a).map(function(){return h.inArray(this,i)}).toArray()},c,f)},1);c.selector.cols=a;c.selector.opts=b;return c});r("columns().header()","column().header()",function(){return this.iterator("column",function(a,b){return a.aoColumns[b].nTh},1)});r("columns().footer()","column().footer()",function(){return this.iterator("column",function(a,b){return a.aoColumns[b].nTf},1)});r("columns().data()",
"column().data()",function(){return this.iterator("column-rows",Wb,1)});r("columns().dataSrc()","column().dataSrc()",function(){return this.iterator("column",function(a,b){return a.aoColumns[b].mData},1)});r("columns().cache()","column().cache()",function(a){return this.iterator("column-rows",function(b,c,d,e,f){return ja(b.aoData,f,"search"===a?"_aFilterData":"_aSortData",c)},1)});r("columns().nodes()","column().nodes()",function(){return this.iterator("column-rows",function(a,b,c,d,e){return ja(a.aoData,
e,"anCells",b)},1)});r("columns().visible()","column().visible()",function(a,b){return this.iterator("column",function(c,d){if(a===k)return c.aoColumns[d].bVisible;var e=c.aoColumns,f=e[d],g=c.aoData,j,i,m;if(a!==k&&f.bVisible!==a){if(a){var l=h.inArray(!0,D(e,"bVisible"),d+1);j=0;for(i=g.length;j<i;j++)m=g[j].nTr,e=g[j].anCells,m&&m.insertBefore(e[d],e[l]||null)}else h(D(c.aoData,"anCells",d)).detach();f.bVisible=a;ga(c,c.aoHeader);ga(c,c.aoFooter);if(b===k||b)U(c),(c.oScroll.sX||c.oScroll.sY)&&
Z(c);v(c,null,"column-visibility",[c,d,a,b]);ya(c)}})});r("columns().indexes()","column().index()",function(a){return this.iterator("column",function(b,c){return"visible"===a?ba(b,c):c},1)});p("columns.adjust()",function(){return this.iterator("table",function(a){U(a)},1)});p("column.index()",function(a,b){if(0!==this.context.length){var c=this.context[0];if("fromVisible"===a||"toData"===a)return $(c,b);if("fromData"===a||"toVisible"===a)return ba(c,b)}});p("column()",function(a,b){return bb(this.columns(a,
b))});p("cells()",function(a,b,c){h.isPlainObject(a)&&(a.row===k?(c=a,a=null):(c=b,b=null));h.isPlainObject(b)&&(c=b,b=null);if(null===b||b===k)return this.iterator("table",function(b){var d=a,e=ab(c),f=b.aoData,g=Da(b,e),j=Sb(ja(f,g,"anCells")),i=h([].concat.apply([],j)),l,m=b.aoColumns.length,o,p,t,r,s,v;return $a("cell",d,function(a){var c=typeof a==="function";if(a===null||a===k||c){o=[];p=0;for(t=g.length;p<t;p++){l=g[p];for(r=0;r<m;r++){s={row:l,column:r};if(c){v=f[l];a(s,B(b,l,r),v.anCells?
v.anCells[r]:null)&&o.push(s)}else o.push(s)}}return o}return h.isPlainObject(a)?[a]:i.filter(a).map(function(a,b){return{row:b._DT_CellIndex.row,column:b._DT_CellIndex.column}}).toArray()},b,e)});var d=this.columns(b,c),e=this.rows(a,c),f,g,j,i,m,l=this.iterator("table",function(a,b){f=[];g=0;for(j=e[b].length;g<j;g++){i=0;for(m=d[b].length;i<m;i++)f.push({row:e[b][g],column:d[b][i]})}return f},1);h.extend(l.selector,{cols:b,rows:a,opts:c});return l});r("cells().nodes()","cell().node()",function(){return this.iterator("cell",
function(a,b,c){return(a=a.aoData[b].anCells)?a[c]:k},1)});p("cells().data()",function(){return this.iterator("cell",function(a,b,c){return B(a,b,c)},1)});r("cells().cache()","cell().cache()",function(a){a="search"===a?"_aFilterData":"_aSortData";return this.iterator("cell",function(b,c,d){return b.aoData[c][a][d]},1)});r("cells().render()","cell().render()",function(a){return this.iterator("cell",function(b,c,d){return B(b,c,d,a)},1)});r("cells().indexes()","cell().index()",function(){return this.iterator("cell",
function(a,b,c){return{row:b,column:c,columnVisible:ba(a,c)}},1)});r("cells().invalidate()","cell().invalidate()",function(a){return this.iterator("cell",function(b,c,d){ea(b,c,a,d)})});p("cell()",function(a,b,c){return bb(this.cells(a,b,c))});p("cell().data()",function(a){var b=this.context,c=this[0];if(a===k)return b.length&&c.length?B(b[0],c[0].row,c[0].column):k;jb(b[0],c[0].row,c[0].column,a);ea(b[0],c[0].row,"data",c[0].column);return this});p("order()",function(a,b){var c=this.context;if(a===
k)return 0!==c.length?c[0].aaSorting:k;"number"===typeof a?a=[[a,b]]:h.isArray(a[0])||(a=Array.prototype.slice.call(arguments));return this.iterator("table",function(b){b.aaSorting=a.slice()})});p("order.listener()",function(a,b,c){return this.iterator("table",function(d){Oa(d,a,b,c)})});p("order.fixed()",function(a){if(!a){var b=this.context,b=b.length?b[0].aaSortingFixed:k;return h.isArray(b)?{pre:b}:b}return this.iterator("table",function(b){b.aaSortingFixed=h.extend(!0,{},a)})});p(["columns().order()",
"column().order()"],function(a){var b=this;return this.iterator("table",function(c,d){var e=[];h.each(b[d],function(b,c){e.push([c,a])});c.aaSorting=e})});p("search()",function(a,b,c,d){var e=this.context;return a===k?0!==e.length?e[0].oPreviousSearch.sSearch:k:this.iterator("table",function(e){e.oFeatures.bFilter&&ha(e,h.extend({},e.oPreviousSearch,{sSearch:a+"",bRegex:null===b?!1:b,bSmart:null===c?!0:c,bCaseInsensitive:null===d?!0:d}),1)})});r("columns().search()","column().search()",function(a,
b,c,d){return this.iterator("column",function(e,f){var g=e.aoPreSearchCols;if(a===k)return g[f].sSearch;e.oFeatures.bFilter&&(h.extend(g[f],{sSearch:a+"",bRegex:null===b?!1:b,bSmart:null===c?!0:c,bCaseInsensitive:null===d?!0:d}),ha(e,e.oPreviousSearch,1))})});p("state()",function(){return this.context.length?this.context[0].oSavedState:null});p("state.clear()",function(){return this.iterator("table",function(a){a.fnStateSaveCallback.call(a.oInstance,a,{})})});p("state.loaded()",function(){return this.context.length?
this.context[0].oLoadedState:null});p("state.save()",function(){return this.iterator("table",function(a){ya(a)})});m.versionCheck=m.fnVersionCheck=function(a){for(var b=m.version.split("."),a=a.split("."),c,d,e=0,f=a.length;e<f;e++)if(c=parseInt(b[e],10)||0,d=parseInt(a[e],10)||0,c!==d)return c>d;return!0};m.isDataTable=m.fnIsDataTable=function(a){var b=h(a).get(0),c=!1;h.each(m.settings,function(a,e){var f=e.nScrollHead?h("table",e.nScrollHead)[0]:null,g=e.nScrollFoot?h("table",e.nScrollFoot)[0]:
null;if(e.nTable===b||f===b||g===b)c=!0});return c};m.tables=m.fnTables=function(a){var b=!1;h.isPlainObject(a)&&(b=a.api,a=a.visible);var c=h.map(m.settings,function(b){if(!a||a&&h(b.nTable).is(":visible"))return b.nTable});return b?new t(c):c};m.util={throttle:ua,escapeRegex:va};m.camelToHungarian=J;p("$()",function(a,b){var c=this.rows(b).nodes(),c=h(c);return h([].concat(c.filter(a).toArray(),c.find(a).toArray()))});h.each(["on","one","off"],function(a,b){p(b+"()",function(){var a=Array.prototype.slice.call(arguments);
a[0].match(/\.dt\b/)||(a[0]+=".dt");var d=h(this.tables().nodes());d[b].apply(d,a);return this})});p("clear()",function(){return this.iterator("table",function(a){na(a)})});p("settings()",function(){return new t(this.context,this.context)});p("init()",function(){var a=this.context;return a.length?a[0].oInit:null});p("data()",function(){return this.iterator("table",function(a){return D(a.aoData,"_aData")}).flatten()});p("destroy()",function(a){a=a||!1;return this.iterator("table",function(b){var c=
b.nTableWrapper.parentNode,d=b.oClasses,e=b.nTable,f=b.nTBody,g=b.nTHead,j=b.nTFoot,i=h(e),f=h(f),k=h(b.nTableWrapper),l=h.map(b.aoData,function(a){return a.nTr}),p;b.bDestroying=!0;v(b,"aoDestroyCallback","destroy",[b]);a||(new t(b)).columns().visible(!0);k.unbind(".DT").find(":not(tbody *)").unbind(".DT");h(E).unbind(".DT-"+b.sInstance);e!=g.parentNode&&(i.children("thead").detach(),i.append(g));j&&e!=j.parentNode&&(i.children("tfoot").detach(),i.append(j));b.aaSorting=[];b.aaSortingFixed=[];xa(b);
h(l).removeClass(b.asStripeClasses.join(" "));h("th, td",g).removeClass(d.sSortable+" "+d.sSortableAsc+" "+d.sSortableDesc+" "+d.sSortableNone);b.bJUI&&(h("th span."+d.sSortIcon+", td span."+d.sSortIcon,g).detach(),h("th, td",g).each(function(){var a=h("div."+d.sSortJUIWrapper,this);h(this).append(a.contents());a.detach()}));f.children().detach();f.append(l);g=a?"remove":"detach";i[g]();k[g]();!a&&c&&(c.insertBefore(e,b.nTableReinsertBefore),i.css("width",b.sDestroyWidth).removeClass(d.sTable),(p=
b.asDestroyStripes.length)&&f.children().each(function(a){h(this).addClass(b.asDestroyStripes[a%p])}));c=h.inArray(b,m.settings);-1!==c&&m.settings.splice(c,1)})});h.each(["column","row","cell"],function(a,b){p(b+"s().every()",function(a){var d=this.selector.opts,e=this;return this.iterator(b,function(f,g,h,i,m){a.call(e[b](g,"cell"===b?h:d,"cell"===b?d:k),g,h,i,m)})})});p("i18n()",function(a,b,c){var d=this.context[0],a=Q(a)(d.oLanguage);a===k&&(a=b);c!==k&&h.isPlainObject(a)&&(a=a[c]!==k?a[c]:a._);
return a.replace("%d",c)});m.version="1.10.10";m.settings=[];m.models={};m.models.oSearch={bCaseInsensitive:!0,sSearch:"",bRegex:!1,bSmart:!0};m.models.oRow={nTr:null,anCells:null,_aData:[],_aSortData:null,_aFilterData:null,_sFilterRow:null,_sRowStripe:"",src:null,idx:-1};m.models.oColumn={idx:null,aDataSort:null,asSorting:null,bSearchable:null,bSortable:null,bVisible:null,_sManualType:null,_bAttrSrc:!1,fnCreatedCell:null,fnGetData:null,fnSetData:null,mData:null,mRender:null,nTh:null,nTf:null,sClass:null,
sContentPadding:null,sDefaultContent:null,sName:null,sSortDataType:"std",sSortingClass:null,sSortingClassJUI:null,sTitle:null,sType:null,sWidth:null,sWidthOrig:null};m.defaults={aaData:null,aaSorting:[[0,"asc"]],aaSortingFixed:[],ajax:null,aLengthMenu:[10,25,50,100],aoColumns:null,aoColumnDefs:null,aoSearchCols:[],asStripeClasses:null,bAutoWidth:!0,bDeferRender:!1,bDestroy:!1,bFilter:!0,bInfo:!0,bJQueryUI:!1,bLengthChange:!0,bPaginate:!0,bProcessing:!1,bRetrieve:!1,bScrollCollapse:!1,bServerSide:!1,
bSort:!0,bSortMulti:!0,bSortCellsTop:!1,bSortClasses:!0,bStateSave:!1,fnCreatedRow:null,fnDrawCallback:null,fnFooterCallback:null,fnFormatNumber:function(a){return a.toString().replace(/\B(?=(\d{3})+(?!\d))/g,this.oLanguage.sThousands)},fnHeaderCallback:null,fnInfoCallback:null,fnInitComplete:null,fnPreDrawCallback:null,fnRowCallback:null,fnServerData:null,fnServerParams:null,fnStateLoadCallback:function(a){try{return JSON.parse((-1===a.iStateDuration?sessionStorage:localStorage).getItem("DataTables_"+
a.sInstance+"_"+location.pathname))}catch(b){}},fnStateLoadParams:null,fnStateLoaded:null,fnStateSaveCallback:function(a,b){try{(-1===a.iStateDuration?sessionStorage:localStorage).setItem("DataTables_"+a.sInstance+"_"+location.pathname,JSON.stringify(b))}catch(c){}},fnStateSaveParams:null,iStateDuration:7200,iDeferLoading:null,iDisplayLength:10,iDisplayStart:0,iTabIndex:0,oClasses:{},oLanguage:{oAria:{sSortAscending:": activate to sort column ascending",sSortDescending:": activate to sort column descending"},
oPaginate:{sFirst:"First",sLast:"Last",sNext:"Next",sPrevious:"Previous"},sEmptyTable:"No data available in table",sInfo:"Showing _START_ to _END_ of _TOTAL_ entries",sInfoEmpty:"Showing 0 to 0 of 0 entries",sInfoFiltered:"(filtered from _MAX_ total entries)",sInfoPostFix:"",sDecimal:"",sThousands:",",sLengthMenu:"Show _MENU_ entries",sLoadingRecords:"Loading...",sProcessing:"Processing...",sSearch:"Search:",sSearchPlaceholder:"",sUrl:"",sZeroRecords:"No matching records found"},oSearch:h.extend({},
m.models.oSearch),sAjaxDataProp:"data",sAjaxSource:null,sDom:"lfrtip",searchDelay:null,sPaginationType:"simple_numbers",sScrollX:"",sScrollXInner:"",sScrollY:"",sServerMethod:"GET",renderer:null,rowId:"DT_RowId"};Y(m.defaults);m.defaults.column={aDataSort:null,iDataSort:-1,asSorting:["asc","desc"],bSearchable:!0,bSortable:!0,bVisible:!0,fnCreatedCell:null,mData:null,mRender:null,sCellType:"td",sClass:"",sContentPadding:"",sDefaultContent:null,sName:"",sSortDataType:"std",sTitle:null,sType:null,sWidth:null};
Y(m.defaults.column);m.models.oSettings={oFeatures:{bAutoWidth:null,bDeferRender:null,bFilter:null,bInfo:null,bLengthChange:null,bPaginate:null,bProcessing:null,bServerSide:null,bSort:null,bSortMulti:null,bSortClasses:null,bStateSave:null},oScroll:{bCollapse:null,iBarWidth:0,sX:null,sXInner:null,sY:null},oLanguage:{fnInfoCallback:null},oBrowser:{bScrollOversize:!1,bScrollbarLeft:!1,bBounding:!1,barWidth:0},ajax:null,aanFeatures:[],aoData:[],aiDisplay:[],aiDisplayMaster:[],aIds:{},aoColumns:[],aoHeader:[],
aoFooter:[],oPreviousSearch:{},aoPreSearchCols:[],aaSorting:null,aaSortingFixed:[],asStripeClasses:null,asDestroyStripes:[],sDestroyWidth:0,aoRowCallback:[],aoHeaderCallback:[],aoFooterCallback:[],aoDrawCallback:[],aoRowCreatedCallback:[],aoPreDrawCallback:[],aoInitComplete:[],aoStateSaveParams:[],aoStateLoadParams:[],aoStateLoaded:[],sTableId:"",nTable:null,nTHead:null,nTFoot:null,nTBody:null,nTableWrapper:null,bDeferLoading:!1,bInitialised:!1,aoOpenRows:[],sDom:null,searchDelay:null,sPaginationType:"two_button",
iStateDuration:0,aoStateSave:[],aoStateLoad:[],oSavedState:null,oLoadedState:null,sAjaxSource:null,sAjaxDataProp:null,bAjaxDataGet:!0,jqXHR:null,json:k,oAjaxData:k,fnServerData:null,aoServerParams:[],sServerMethod:null,fnFormatNumber:null,aLengthMenu:null,iDraw:0,bDrawing:!1,iDrawError:-1,_iDisplayLength:10,_iDisplayStart:0,_iRecordsTotal:0,_iRecordsDisplay:0,bJUI:null,oClasses:{},bFiltered:!1,bSorted:!1,bSortCellsTop:null,oInit:null,aoDestroyCallback:[],fnRecordsTotal:function(){return"ssp"==y(this)?
1*this._iRecordsTotal:this.aiDisplayMaster.length},fnRecordsDisplay:function(){return"ssp"==y(this)?1*this._iRecordsDisplay:this.aiDisplay.length},fnDisplayEnd:function(){var a=this._iDisplayLength,b=this._iDisplayStart,c=b+a,d=this.aiDisplay.length,e=this.oFeatures,f=e.bPaginate;return e.bServerSide?!1===f||-1===a?b+d:Math.min(b+a,this._iRecordsDisplay):!f||c>d||-1===a?d:c},oInstance:null,sInstance:null,iTabIndex:0,nScrollHead:null,nScrollFoot:null,aLastSort:[],oPlugins:{},rowIdFn:null,rowId:null};
m.ext=s={buttons:{},classes:{},builder:"-source-",errMode:"alert",feature:[],search:[],selector:{cell:[],column:[],row:[]},internal:{},legacy:{ajax:null},pager:{},renderer:{pageButton:{},header:{}},order:{},type:{detect:[],search:{},order:{}},_unique:0,fnVersionCheck:m.fnVersionCheck,iApiIndex:0,oJUIClasses:{},sVersion:m.version};h.extend(s,{afnFiltering:s.search,aTypes:s.type.detect,ofnSearch:s.type.search,oSort:s.type.order,afnSortData:s.order,aoFeatures:s.feature,oApi:s.internal,oStdClasses:s.classes,
oPagination:s.pager});h.extend(m.ext.classes,{sTable:"dataTable",sNoFooter:"no-footer",sPageButton:"paginate_button",sPageButtonActive:"current",sPageButtonDisabled:"disabled",sStripeOdd:"odd",sStripeEven:"even",sRowEmpty:"dataTables_empty",sWrapper:"dataTables_wrapper",sFilter:"dataTables_filter",sInfo:"dataTables_info",sPaging:"dataTables_paginate paging_",sLength:"dataTables_length",sProcessing:"dataTables_processing",sSortAsc:"sorting_asc",sSortDesc:"sorting_desc",sSortable:"sorting",sSortableAsc:"sorting_asc_disabled",
sSortableDesc:"sorting_desc_disabled",sSortableNone:"sorting_disabled",sSortColumn:"sorting_",sFilterInput:"",sLengthSelect:"",sScrollWrapper:"dataTables_scroll",sScrollHead:"dataTables_scrollHead",sScrollHeadInner:"dataTables_scrollHeadInner",sScrollBody:"dataTables_scrollBody",sScrollFoot:"dataTables_scrollFoot",sScrollFootInner:"dataTables_scrollFootInner",sHeaderTH:"",sFooterTH:"",sSortJUIAsc:"",sSortJUIDesc:"",sSortJUI:"",sSortJUIAscAllowed:"",sSortJUIDescAllowed:"",sSortJUIWrapper:"",sSortIcon:"",
sJUIHeader:"",sJUIFooter:""});var Ea="",Ea="",G=Ea+"ui-state-default",ka=Ea+"css_right ui-icon ui-icon-",Xb=Ea+"fg-toolbar ui-toolbar ui-widget-header ui-helper-clearfix";h.extend(m.ext.oJUIClasses,m.ext.classes,{sPageButton:"fg-button ui-button "+G,sPageButtonActive:"ui-state-disabled",sPageButtonDisabled:"ui-state-disabled",sPaging:"dataTables_paginate fg-buttonset ui-buttonset fg-buttonset-multi ui-buttonset-multi paging_",sSortAsc:G+" sorting_asc",sSortDesc:G+" sorting_desc",sSortable:G+" sorting",
sSortableAsc:G+" sorting_asc_disabled",sSortableDesc:G+" sorting_desc_disabled",sSortableNone:G+" sorting_disabled",sSortJUIAsc:ka+"triangle-1-n",sSortJUIDesc:ka+"triangle-1-s",sSortJUI:ka+"carat-2-n-s",sSortJUIAscAllowed:ka+"carat-1-n",sSortJUIDescAllowed:ka+"carat-1-s",sSortJUIWrapper:"DataTables_sort_wrapper",sSortIcon:"DataTables_sort_icon",sScrollHead:"dataTables_scrollHead "+G,sScrollFoot:"dataTables_scrollFoot "+G,sHeaderTH:G,sFooterTH:G,sJUIHeader:Xb+" ui-corner-tl ui-corner-tr",sJUIFooter:Xb+
" ui-corner-bl ui-corner-br"});var Mb=m.ext.pager;h.extend(Mb,{simple:function(){return["previous","next"]},full:function(){return["first","previous","next","last"]},numbers:function(a,b){return[Aa(a,b)]},simple_numbers:function(a,b){return["previous",Aa(a,b),"next"]},full_numbers:function(a,b){return["first","previous",Aa(a,b),"next","last"]},_numbers:Aa,numbers_length:7});h.extend(!0,m.ext.renderer,{pageButton:{_:function(a,b,c,d,e,f){var g=a.oClasses,j=a.oLanguage.oPaginate,i=a.oLanguage.oAria.paginate||
{},k,l,m=0,p=function(b,d){var n,r,t,s,v=function(b){Ta(a,b.data.action,true)};n=0;for(r=d.length;n<r;n++){s=d[n];if(h.isArray(s)){t=h("<"+(s.DT_el||"div")+"/>").appendTo(b);p(t,s)}else{k=null;l="";switch(s){case "ellipsis":b.append('<span class="ellipsis">&#x2026;</span>');break;case "first":k=j.sFirst;l=s+(e>0?"":" "+g.sPageButtonDisabled);break;case "previous":k=j.sPrevious;l=s+(e>0?"":" "+g.sPageButtonDisabled);break;case "next":k=j.sNext;l=s+(e<f-1?"":" "+g.sPageButtonDisabled);break;case "last":k=
j.sLast;l=s+(e<f-1?"":" "+g.sPageButtonDisabled);break;default:k=s+1;l=e===s?g.sPageButtonActive:""}if(k!==null){t=h("<a>",{"class":g.sPageButton+" "+l,"aria-controls":a.sTableId,"aria-label":i[s],"data-dt-idx":m,tabindex:a.iTabIndex,id:c===0&&typeof s==="string"?a.sTableId+"_"+s:null}).html(k).appendTo(b);Wa(t,{action:s},v);m++}}}},r;try{r=h(b).find(H.activeElement).data("dt-idx")}catch(n){}p(h(b).empty(),d);r&&h(b).find("[data-dt-idx="+r+"]").focus()}}});h.extend(m.ext.type.detect,[function(a,b){var c=
b.oLanguage.sDecimal;return Za(a,c)?"num"+c:null},function(a){if(a&&!(a instanceof Date)&&(!ac.test(a)||!bc.test(a)))return null;var b=Date.parse(a);return null!==b&&!isNaN(b)||M(a)?"date":null},function(a,b){var c=b.oLanguage.sDecimal;return Za(a,c,!0)?"num-fmt"+c:null},function(a,b){var c=b.oLanguage.sDecimal;return Rb(a,c)?"html-num"+c:null},function(a,b){var c=b.oLanguage.sDecimal;return Rb(a,c,!0)?"html-num-fmt"+c:null},function(a){return M(a)||"string"===typeof a&&-1!==a.indexOf("<")?"html":
null}]);h.extend(m.ext.type.search,{html:function(a){return M(a)?a:"string"===typeof a?a.replace(Ob," ").replace(Ca,""):""},string:function(a){return M(a)?a:"string"===typeof a?a.replace(Ob," "):a}});var Ba=function(a,b,c,d){if(0!==a&&(!a||"-"===a))return-Infinity;b&&(a=Qb(a,b));a.replace&&(c&&(a=a.replace(c,"")),d&&(a=a.replace(d,"")));return 1*a};h.extend(s.type.order,{"date-pre":function(a){return Date.parse(a)||0},"html-pre":function(a){return M(a)?"":a.replace?a.replace(/<.*?>/g,"").toLowerCase():
a+""},"string-pre":function(a){return M(a)?"":"string"===typeof a?a.toLowerCase():!a.toString?"":a.toString()},"string-asc":function(a,b){return a<b?-1:a>b?1:0},"string-desc":function(a,b){return a<b?1:a>b?-1:0}});db("");h.extend(!0,m.ext.renderer,{header:{_:function(a,b,c,d){h(a.nTable).on("order.dt.DT",function(e,f,g,h){if(a===f){e=c.idx;b.removeClass(c.sSortingClass+" "+d.sSortAsc+" "+d.sSortDesc).addClass(h[e]=="asc"?d.sSortAsc:h[e]=="desc"?d.sSortDesc:c.sSortingClass)}})},jqueryui:function(a,
b,c,d){h("<div/>").addClass(d.sSortJUIWrapper).append(b.contents()).append(h("<span/>").addClass(d.sSortIcon+" "+c.sSortingClassJUI)).appendTo(b);h(a.nTable).on("order.dt.DT",function(e,f,g,h){if(a===f){e=c.idx;b.removeClass(d.sSortAsc+" "+d.sSortDesc).addClass(h[e]=="asc"?d.sSortAsc:h[e]=="desc"?d.sSortDesc:c.sSortingClass);b.find("span."+d.sSortIcon).removeClass(d.sSortJUIAsc+" "+d.sSortJUIDesc+" "+d.sSortJUI+" "+d.sSortJUIAscAllowed+" "+d.sSortJUIDescAllowed).addClass(h[e]=="asc"?d.sSortJUIAsc:
h[e]=="desc"?d.sSortJUIDesc:c.sSortingClassJUI)}})}}});m.render={number:function(a,b,c,d,e){return{display:function(f){if("number"!==typeof f&&"string"!==typeof f)return f;var g=0>f?"-":"",h=parseFloat(f);if(isNaN(h))return f;f=Math.abs(h);h=parseInt(f,10);f=c?b+(f-h).toFixed(c).substring(2):"";return g+(d||"")+h.toString().replace(/\B(?=(\d{3})+(?!\d))/g,a)+f+(e||"")}}},text:function(){return{display:function(a){return"string"===typeof a?a.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;"):
a}}}};h.extend(m.ext.internal,{_fnExternApiFunc:Nb,_fnBuildAjax:ra,_fnAjaxUpdate:lb,_fnAjaxParameters:ub,_fnAjaxUpdateDraw:vb,_fnAjaxDataSrc:sa,_fnAddColumn:Ga,_fnColumnOptions:la,_fnAdjustColumnSizing:U,_fnVisibleToColumnIndex:$,_fnColumnIndexToVisible:ba,_fnVisbleColumns:ca,_fnGetColumns:aa,_fnColumnTypes:Ia,_fnApplyColumnDefs:ib,_fnHungarianMap:Y,_fnCamelToHungarian:J,_fnLanguageCompat:Fa,_fnBrowserDetect:gb,_fnAddData:N,_fnAddTr:ma,_fnNodeToDataIndex:function(a,b){return b._DT_RowIndex!==k?b._DT_RowIndex:
null},_fnNodeToColumnIndex:function(a,b,c){return h.inArray(c,a.aoData[b].anCells)},_fnGetCellData:B,_fnSetCellData:jb,_fnSplitObjNotation:La,_fnGetObjectDataFn:Q,_fnSetObjectDataFn:R,_fnGetDataMaster:Ma,_fnClearTable:na,_fnDeleteIndex:oa,_fnInvalidate:ea,_fnGetRowElements:Ka,_fnCreateTr:Ja,_fnBuildHead:kb,_fnDrawHead:ga,_fnDraw:O,_fnReDraw:T,_fnAddOptionsHtml:nb,_fnDetectHeader:fa,_fnGetUniqueThs:qa,_fnFeatureHtmlFilter:pb,_fnFilterComplete:ha,_fnFilterCustom:yb,_fnFilterColumn:xb,_fnFilter:wb,_fnFilterCreateSearch:Qa,
_fnEscapeRegex:va,_fnFilterData:zb,_fnFeatureHtmlInfo:sb,_fnUpdateInfo:Cb,_fnInfoMacros:Db,_fnInitialise:ia,_fnInitComplete:ta,_fnLengthChange:Ra,_fnFeatureHtmlLength:ob,_fnFeatureHtmlPaginate:tb,_fnPageChange:Ta,_fnFeatureHtmlProcessing:qb,_fnProcessingDisplay:C,_fnFeatureHtmlTable:rb,_fnScrollDraw:Z,_fnApplyToChildren:I,_fnCalculateColumnWidths:Ha,_fnThrottle:ua,_fnConvertToWidth:Fb,_fnGetWidestNode:Gb,_fnGetMaxLenString:Hb,_fnStringToCss:w,_fnSortFlatten:W,_fnSort:mb,_fnSortAria:Jb,_fnSortListener:Va,
_fnSortAttachListener:Oa,_fnSortingClasses:xa,_fnSortData:Ib,_fnSaveState:ya,_fnLoadState:Kb,_fnSettingsFromNode:za,_fnLog:K,_fnMap:F,_fnBindAction:Wa,_fnCallbackReg:z,_fnCallbackFire:v,_fnLengthOverflow:Sa,_fnRenderer:Pa,_fnDataSource:y,_fnRowAttributes:Na,_fnCalculateEnd:function(){}});h.fn.dataTable=m;m.$=h;h.fn.dataTableSettings=m.settings;h.fn.dataTableExt=m.ext;h.fn.DataTable=function(a){return h(this).dataTable(a).api()};h.each(m,function(a,b){h.fn.DataTable[a]=b});return h.fn.dataTable});

/*!
 DataTables Bootstrap 3 integration
 ©2011-2015 SpryMedia Ltd - datatables.net/license
*/
(function(b){"function"===typeof define&&define.amd?define(["jquery","datatables.net"],function(a){return b(a,window,document)}):"object"===typeof exports?module.exports=function(a,e){a||(a=window);if(!e||!e.fn.dataTable)e=require("datatables.net")(a,e).$;return b(e,a,a.document)}:b(jQuery,window,document)})(function(b,a,e){var d=b.fn.dataTable;b.extend(!0,d.defaults,{dom:"<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-5'i><'col-sm-7'p>>",renderer:"bootstrap"});b.extend(d.ext.classes,
{sWrapper:"dataTables_wrapper form-inline dt-bootstrap",sFilterInput:"form-control input-sm",sLengthSelect:"form-control input-sm",sProcessing:"dataTables_processing panel panel-default"});d.ext.renderer.pageButton.bootstrap=function(a,h,r,m,j,n){var o=new d.Api(a),s=a.oClasses,k=a.oLanguage.oPaginate,t=a.oLanguage.oAria.paginate||{},f,g,p=0,q=function(d,e){var l,h,i,c,m=function(a){a.preventDefault();!b(a.currentTarget).hasClass("disabled")&&o.page()!=a.data.action&&o.page(a.data.action).draw("page")};
l=0;for(h=e.length;l<h;l++)if(c=e[l],b.isArray(c))q(d,c);else{g=f="";switch(c){case "ellipsis":f="&#x2026;";g="disabled";break;case "first":f=k.sFirst;g=c+(0<j?"":" disabled");break;case "previous":f=k.sPrevious;g=c+(0<j?"":" disabled");break;case "next":f=k.sNext;g=c+(j<n-1?"":" disabled");break;case "last":f=k.sLast;g=c+(j<n-1?"":" disabled");break;default:f=c+1,g=j===c?"active":""}f&&(i=b("<li>",{"class":s.sPageButton+" "+g,id:0===r&&"string"===typeof c?a.sTableId+"_"+c:null}).append(b("<a>",{href:"#",
"aria-controls":a.sTableId,"aria-label":t[c],"data-dt-idx":p,tabindex:a.iTabIndex}).html(f)).appendTo(d),a.oApi._fnBindAction(i,{action:c},m),p++)}},i;try{i=b(h).find(e.activeElement).data("dt-idx")}catch(u){}q(b(h).empty().html('<ul class="pagination"/>').children("ul"),m);i&&b(h).find("[data-dt-idx="+i+"]").focus()};d.TableTools&&(b.extend(!0,d.TableTools.classes,{container:"DTTT btn-group",buttons:{normal:"btn btn-default",disabled:"disabled"},collection:{container:"DTTT_dropdown dropdown-menu",
buttons:{normal:"",disabled:"disabled"}},print:{info:"DTTT_print_info"},select:{row:"active"}}),b.extend(!0,d.TableTools.DEFAULTS.oTags,{collection:{container:"ul",button:"li",liner:"a"}}));return d});

/*!
 Responsive 2.0.0
 2014-2015 SpryMedia Ltd - datatables.net/license
*/
(function(c){"function"===typeof define&&define.amd?define(["jquery","datatables.net"],function(l){return c(l,window,document)}):"object"===typeof exports?module.exports=function(l,k){l||(l=window);if(!k||!k.fn.dataTable)k=require("datatables.net")(l,k).$;return c(k,l,l.document)}:c(jQuery,window,document)})(function(c,l,k,p){var n=c.fn.dataTable,j=function(a,b){if(!n.versionCheck||!n.versionCheck("1.10.3"))throw"DataTables Responsive requires DataTables 1.10.3 or newer";this.s={dt:new n.Api(a),columns:[],
current:[]};this.s.dt.settings()[0].responsive||(b&&"string"===typeof b.details&&(b.details={type:b.details}),this.c=c.extend(!0,{},j.defaults,n.defaults.responsive,b),a.responsive=this,this._constructor())};c.extend(j.prototype,{_constructor:function(){var a=this,b=this.s.dt,d=b.settings()[0];b.settings()[0]._responsive=this;c(l).on("resize.dtr orientationchange.dtr",n.util.throttle(function(){a._resize()}));d.oApi._fnCallbackReg(d,"aoRowCreatedCallback",function(e){-1!==c.inArray(!1,a.s.current)&&
c("td, th",e).each(function(e){e=b.column.index("toData",e);!1===a.s.current[e]&&c(this).css("display","none")})});b.on("destroy.dtr",function(){b.off(".dtr");c(b.table().body()).off(".dtr");c(l).off("resize.dtr orientationchange.dtr");c.each(a.s.current,function(e,b){!1===b&&a._setColumnVis(e,!0)})});this.c.breakpoints.sort(function(a,b){return a.width<b.width?1:a.width>b.width?-1:0});this._classLogic();this._resizeAuto();d=this.c.details;!1!==d.type&&(a._detailsInit(),b.on("column-visibility.dtr",
function(){a._classLogic();a._resizeAuto();a._resize()}),b.on("draw.dtr",function(){a._redrawChildren()}),c(b.table().node()).addClass("dtr-"+d.type));b.on("column-reorder.dtr",function(b,d,c){if(c.drop){a._classLogic();a._resizeAuto();a._resize()}});this._resize()},_columnsVisiblity:function(a){var b=this.s.dt,d=this.s.columns,e,f,h=d.map(function(a,b){return{columnIdx:b,priority:a.priority}}).sort(function(a,b){return a.priority!==b.priority?a.priority-b.priority:a.columnIdx-b.columnIdx}),g=c.map(d,
function(b){return b.auto&&null===b.minWidth?!1:!0===b.auto?"-":-1!==c.inArray(a,b.includeIn)}),m=0;e=0;for(f=g.length;e<f;e++)!0===g[e]&&(m+=d[e].minWidth);e=b.settings()[0].oScroll;e=e.sY||e.sX?e.iBarWidth:0;b=b.table().container().offsetWidth-e-m;e=0;for(f=g.length;e<f;e++)d[e].control&&(b-=d[e].minWidth);m=!1;e=0;for(f=h.length;e<f;e++){var i=h[e].columnIdx;"-"===g[i]&&(!d[i].control&&d[i].minWidth)&&(m||0>b-d[i].minWidth?(m=!0,g[i]=!1):g[i]=!0,b-=d[i].minWidth)}h=!1;e=0;for(f=d.length;e<f;e++)if(!d[e].control&&
!d[e].never&&!g[e]){h=!0;break}e=0;for(f=d.length;e<f;e++)d[e].control&&(g[e]=h);-1===c.inArray(!0,g)&&(g[0]=!0);return g},_classLogic:function(){var a=this,b=this.c.breakpoints,d=this.s.dt,e=d.columns().eq(0).map(function(a){var b=this.column(a),e=b.header().className,a=d.settings()[0].aoColumns[a].responsivePriority;a===p&&(a=c(b.header).data("priority")!==p?1*c(b.header).data("priority"):1E4);return{className:e,includeIn:[],auto:!1,control:!1,never:e.match(/\bnever\b/)?!0:!1,priority:a}}),f=function(a,
b){var d=e[a].includeIn;-1===c.inArray(b,d)&&d.push(b)},h=function(d,c,i,h){if(i)if("max-"===i){h=a._find(c).width;c=0;for(i=b.length;c<i;c++)b[c].width<=h&&f(d,b[c].name)}else if("min-"===i){h=a._find(c).width;c=0;for(i=b.length;c<i;c++)b[c].width>=h&&f(d,b[c].name)}else{if("not-"===i){c=0;for(i=b.length;c<i;c++)-1===b[c].name.indexOf(h)&&f(d,b[c].name)}}else e[d].includeIn.push(c)};e.each(function(a,e){for(var d=a.className.split(" "),f=!1,j=0,l=d.length;j<l;j++){var k=c.trim(d[j]);if("all"===k){f=
!0;a.includeIn=c.map(b,function(a){return a.name});return}if("none"===k||a.never){f=!0;return}if("control"===k){f=!0;a.control=!0;return}c.each(b,function(a,b){var c=b.name.split("-"),d=k.match(RegExp("(min\\-|max\\-|not\\-)?("+c[0]+")(\\-[_a-zA-Z0-9])?"));d&&(f=!0,d[2]===c[0]&&d[3]==="-"+c[1]?h(e,b.name,d[1],d[2]+d[3]):d[2]===c[0]&&!d[3]&&h(e,b.name,d[1],d[2]))})}f||(a.auto=!0)});this.s.columns=e},_detailsDisplay:function(a,b){var d=this,e=this.s.dt,f=this.c.details.display(a,b,function(){return d.c.details.renderer(e,
a[0],d._detailsObj(a[0]))});(!0===f||!1===f)&&c(e.table().node()).triggerHandler("responsive-display.dt",[e,a,f,b])},_detailsInit:function(){var a=this,b=this.s.dt,d=this.c.details;"inline"===d.type&&(d.target="td:first-child");b.on("draw.dtr",function(){a._tabIndexes()});a._tabIndexes();c(b.table().body()).on("keyup.dtr","td",function(a){a.keyCode===13&&c(this).data("dtr-keyboard")&&c(this).click()});var e=d.target,d="string"===typeof e?e:"td";c(b.table().body()).on("mousedown.dtr",d,function(a){a.preventDefault()}).on("click.dtr",
d,function(){if(c(b.table().node()).hasClass("collapsed")&&b.row(c(this).closest("tr")).length){if(typeof e==="number"){var d=e<0?b.columns().eq(0).length+e:e;if(b.cell(this).index().column!==d)return}d=b.row(c(this).closest("tr"));a._detailsDisplay(d,false)}})},_detailsObj:function(a){var b=this,d=this.s.dt;return c.map(this.s.columns,function(c,f){if(!c.never)return{title:d.settings()[0].aoColumns[f].sTitle,data:d.cell(a,f).render(b.c.orthogonal),hidden:d.column(f).visible()&&!b.s.current[f]}})},
_find:function(a){for(var b=this.c.breakpoints,d=0,c=b.length;d<c;d++)if(b[d].name===a)return b[d]},_redrawChildren:function(){var a=this,b=this.s.dt;b.rows({page:"current"}).iterator("row",function(c,e){b.row(e);a._detailsDisplay(b.row(e),!0)})},_resize:function(){var a=this,b=this.s.dt,d=c(l).width(),e=this.c.breakpoints,f=e[0].name,h=this.s.columns,g,m=this.s.current.slice();for(g=e.length-1;0<=g;g--)if(d<=e[g].width){f=e[g].name;break}var i=this._columnsVisiblity(f);this.s.current=i;e=!1;g=0;
for(d=h.length;g<d;g++)if(!1===i[g]&&!h[g].never){e=!0;break}c(b.table().node()).toggleClass("collapsed",e);var j=!1;b.columns().eq(0).each(function(b,c){i[c]!==m[c]&&(j=!0,a._setColumnVis(b,i[c]))});j&&this._redrawChildren()},_resizeAuto:function(){var a=this.s.dt,b=this.s.columns;if(this.c.auto&&-1!==c.inArray(!0,c.map(b,function(a){return a.auto}))){a.table().node();var d=a.table().node().cloneNode(!1),e=c(a.table().header().cloneNode(!1)).appendTo(d),f=c(a.table().body().cloneNode(!1)).appendTo(d),
h=a.columns().header().filter(function(b){return a.column(b).visible()}).to$().clone(!1).css("display","table-cell");c(f).append(c(a.rows({page:"current"}).nodes()).clone(!1)).find("th, td").css("display","");if(f=a.table().footer()){var f=c(f.cloneNode(!1)).appendTo(d),g=a.columns().header().filter(function(b){return a.column(b).visible()}).to$().clone(!1).css("display","table-cell");c("<tr/>").append(g).appendTo(f)}c("<tr/>").append(h).appendTo(e);"inline"===this.c.details.type&&c(d).addClass("dtr-inline collapsed");
d=c("<div/>").css({width:1,height:1,overflow:"hidden"}).append(d);d.insertBefore(a.table().node());h.each(function(c){c=a.column.index("fromVisible",c);b[c].minWidth=this.offsetWidth||0});d.remove()}},_setColumnVis:function(a,b){var d=this.s.dt,e=b?"":"none";c(d.column(a).header()).css("display",e);c(d.column(a).footer()).css("display",e);d.column(a).nodes().to$().css("display",e)},_tabIndexes:function(){var a=this.s.dt,b=a.cells({page:"current"}).nodes().to$(),d=a.settings()[0],e=this.c.details.target;
b.filter("[data-dtr-keyboard]").removeData("[data-dtr-keyboard]");c("number"===typeof e?":eq("+e+")":e,a.rows({page:"current"}).nodes()).attr("tabIndex",d.iTabIndex).data("dtr-keyboard",1)}});j.breakpoints=[{name:"desktop",width:Infinity},{name:"tablet-l",width:1024},{name:"tablet-p",width:768},{name:"mobile-l",width:480},{name:"mobile-p",width:320}];j.display={childRow:function(a,b,d){if(b){if(c(a.node()).hasClass("parent"))return a.child(d(),"child").show(),!0}else{if(a.child.isShown())return a.child(!1),
c(a.node()).removeClass("parent"),!1;a.child(d(),"child").show();c(a.node()).addClass("parent");return!0}},childRowImmediate:function(a,b,d){if(!b&&a.child.isShown()||!a.responsive.hasHidden())return a.child(!1),c(a.node()).removeClass("parent"),!1;a.child(d(),"child").show();c(a.node()).addClass("parent");return!0},modal:function(a){return function(b,d,e){if(d)c("div.dtr-modal-content").empty().append(e());else{var f=function(){h.remove();c(k).off("keypress.dtr")},h=c('<div class="dtr-modal"/>').append(c('<div class="dtr-modal-display"/>').append(c('<div class="dtr-modal-content"/>').append(e())).append(c('<div class="dtr-modal-close">&times;</div>').click(function(){f()}))).append(c('<div class="dtr-modal-background"/>').click(function(){f()})).appendTo("body");
a&&a.header&&h.find("div.dtr-modal-content").prepend("<h2>"+a.header(b)+"</h2>");c(k).on("keyup.dtr",function(a){27===a.keyCode&&(a.stopPropagation(),f())})}}}};j.defaults={breakpoints:j.breakpoints,auto:!0,details:{display:j.display.childRow,renderer:function(a,b,d){return(a=c.map(d,function(a,b){return a.hidden?'<li data-dtr-index="'+b+'"><span class="dtr-title">'+a.title+'</span> <span class="dtr-data">'+a.data+"</span></li>":""}).join(""))?c('<ul data-dtr-index="'+b+'"/>').append(a):!1},target:0,
type:"inline"},orthogonal:"display"};var o=c.fn.dataTable.Api;o.register("responsive()",function(){return this});o.register("responsive.index()",function(a){a=c(a);return{column:a.data("dtr-index"),row:a.parent().data("dtr-index")}});o.register("responsive.rebuild()",function(){return this.iterator("table",function(a){a._responsive&&a._responsive._classLogic()})});o.register("responsive.recalc()",function(){return this.iterator("table",function(a){a._responsive&&(a._responsive._resizeAuto(),a._responsive._resize())})});
o.register("responsive.hasHidden()",function(){var a=this.context[0];return a._responsive?-1!==c.inArray(!1,a._responsive.s.current):!1});j.version="2.0.0";c.fn.dataTable.Responsive=j;c.fn.DataTable.Responsive=j;c(k).on("init.dt.dtr",function(a,b){if("dt"===a.namespace&&(c(b.nTable).hasClass("responsive")||c(b.nTable).hasClass("dt-responsive")||b.oInit.responsive||n.defaults.responsive)){var d=b.oInit.responsive;!1!==d&&new j(b,c.isPlainObject(d)?d:{})}});return j});

// Custom script
$(document).ready(function () {
    // MetsiMenu
    $('#side-menu').metisMenu();

    imgError();

    // Collapse ibox function
    $('.collapse-link').click( function() {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        var content = ibox.find('div.ibox-content');
        content.slideToggle(200);
        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        ibox.toggleClass('').toggleClass('border-bottom');
        setTimeout(function () {
            ibox.resize();
            ibox.find('[id^=map-]').resize();
        }, 50);
    });

    // Close ibox function
    $('.close-link').click( function() {
        var content = $(this).closest('div.ibox');
        content.remove();
    });

    // Small todo handler
    $('.check-link').click( function(){
        var button = $(this).find('i');
        var label = $(this).next('span');
        button.toggleClass('fa-check-square').toggleClass('fa-square-o');
        label.toggleClass('todo-completed');
        return false;
    });

    // minimalize menu
    $('.navbar-minimalize').click(function () {
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();
    })

    // tooltips
    $('.tooltip-demo').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })

    // Move modal to body
    // Fix Bootstrap backdrop issu with animation.css
    $('.modal').appendTo("body")

    // Full height of sidebar
    function fix_height() {
        var heightWithoutNavbar = $("body > #wrapper").height() - 61;
        $(".sidebard-panel").css("min-height", heightWithoutNavbar + "px");
    }
    fix_height();

    $('.nav-tabs').addClass('nav-justified')


    $(window).bind("load resize click scroll", function() {
        if(!$("body").hasClass('body-small')) {
            fix_height();
        }
    })

    $("[data-toggle=popover]")
        .popover();

    $('.uang').attr('nowrap', 'nowrap');
    $('.uang').closest('td').attr('nowrap', 'nowrap');

    $('.angka').keyup(function(e){
        var before = $(this).val();
        $(this).val(parseInt(before) || '');
    });
    
    $('form').submit(function(){
        $('.btn').attr('disabled', 'disabled'); // but this doesn't work
    });
    
});


// For demo purpose - animation css script
function animationHover(element, animation){
    element = $(element);
    element.hover(
        function() {
            element.addClass('animated ' + animation);
        },
        function(){
            //wait for animation to finish before removing classes
            window.setTimeout( function(){
                element.removeClass('animated ' + animation);
            }, 2000);
        });
}

// Minimalize menu when screen is less than 768px
$(function() {
    $(window).bind("load resize", function() {
        if ($(this).width() < 769) {
            $('body').addClass('body-small')
        } else {
            $('body').removeClass('body-small')
        }
    })
})

function SmoothlyMenu() {
    if (!$('body').hasClass('mini-navbar') || $('body').hasClass('body-small')) {
        // Hide menu in order to smoothly turn on when maximize menu
        $('#side-menu').hide();
        // For smoothly turn on menu
        setTimeout(
            function () {
                $('#side-menu').fadeIn(500);
            }, 100);
    } else if ($('body').hasClass('fixed-sidebar')){
        $('#side-menu').hide();
        setTimeout(
            function () {
                $('#side-menu').fadeIn(500);
            }, 300);
    } else {
        // Remove all inline style from jquery fadeIn function to reset menu state
        $('#side-menu').removeAttr('style');
    }
}

// Dragable panels
function WinMove() {
    var element = "[class*=col]";
    var handle = ".ibox-title";
    var connect = "[class*=col]";
    $(element).sortable(
        {
            handle: handle,
            connectWith: connect,
            tolerance: 'pointer',
            forcePlaceholderSize: true,
            opacity: 0.8,
        })
        .disableSelection();
};

 function validasi(selector, pesan) {

    $(selector).parent()
    .find('code')
    .remove();

    $(selector).parent()
    .addClass('has-error')
    .append('<code>' + pesan + '</code>');

    $(selector).parent()
    .find('code')
    .hide()
    .fadeIn(1000);

   $(selector).on('keyup change', function(){
      $(this).parent()
      .removeClass('has-error')
      .find('code')
      .fadeOut('1000', function() {
          $(this).remove();
      });
   })   
     
};
 function validasi1(selector, pesan) {

    selector.parent()
    .find('code')
    .remove();

    selector.parent()
    .addClass('has-error')
    .append('<code>' + pesan + '</code>');

    selector.parent()
    .find('code')
    .hide()
    .fadeIn(1000);

   selector.on('keyup change', function(){
      $(this).parent()
      .removeClass('has-error')
      .find('code')
      .fadeOut('1000', function() {
          $(this).remove();
      });
   })   
     
};
 function validasi4(selector, pesan) {

    $(selector).parent()
    .find('code')
    .remove();

    $(selector)
    .parent()
    .addClass('has-error')
    .append('<code>' + pesan + '</code>');

    $(selector).parent()
    .find('code')
    .hide()
    .fadeIn(1000);

   $(selector).on('keyup change', function(){
      $(this)
      .removeClass('has-error')
      .parent()
      .find('code')
      .fadeOut('1000', function() {
          $(this).remove();
      });
   })   
     
};

 function validasi2(selector, pesan) {

    $(selector).parent().parent()
    .find('code')
    .remove();

    $(selector).parent().parent()
    .addClass('has-error')
    .append('<code>' + pesan + '</code>');

    $(selector).parent().parent()
    .find('code')
    .hide()
    .fadeIn(1000);

   $(selector).on('keyup change', function(){
      $(this).parent().parent()
      .removeClass('has-error')
      .find('code')
      .fadeOut('1000', function() {
          $(this).remove();
      });
   })   
     
};
 function validasi3(selector, pesan) {

    validasi(selector, pesan);

    $('#register_hamil_id').change(function(e) {
        if ($('#register_hamil_id').val() != '') {
            $(selector).parent()
              .removeClass('has-error')
              .find('code')
              .fadeOut('1000', function() {
                  $(this).remove();
            });
        }
    });
     
};


function hari_ini(){
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();

    if(dd<10) {
        dd='0'+dd
    } 

    if(mm<10) {
        mm='0'+mm
    } 

    return yyyy + '-'+ mm + '-' + dd;

}

function tanggal(tanggal){
    var arr = tanggal.split('-');

    return arr[2] + '-' + arr[1]+ '-' +arr[0];
}

function rataAtas5000(biaya){
    if (biaya == 0 || biaya == '') {
        return 0;
    }

    for (var i = 0; i < biaya; i = i+5000) {
    }
    return i;

}

function imgError() {
    $("img").error(function () {
      $(this).unbind("error").attr("src", "/img/notfound.jpg");
    });
}

function cleanUang(uang){

    uang = uang.replace(/\./g,'');
    uang = uang.split(",")[0];
    uang = uang.split(" ")[1];
    if (uang == 0) {
        uang = 0;
    }
    return uang;
}

function validatePass(){
    var pass = true;
    var string = '';
    $('.rq').each(function(index, el) {
      if ($(this).val() == '') {
        string += $(this).attr('name') + ', ';
        validasi1($(this), 'Harus Diisi!!');
        pass = false;
      }
    });
    if (!pass) {
        alert(string + ' tidak boleh dikosongkan');
        $('.rq').each(function(index, el) {
          if ($(this).val() == '') {
            $(this).focus();
            return false;
          }
        });
    }
    return pass;
}
function formatUang(){
    $('.uang:not(:contains("Rp."))').each(function() {
        var number = $(this).html();
        number = number.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
        $(this).html('Rp. ' + number + ',-');
    });
}


function uang(content){
    var number = content;
    number = number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
    return 'Rp. ' + number + ',-';
}

function rupiahDibayarPasien(control) {
    var number = $(control).val();
    if (number.indexOf("Rp. ") >= 0){
        number = clean(number);
    }
    number = number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."); // 43,434
    $(control).val('Rp. ' + number);
}
function print_tanpa_dialog(){
    console.log('im in');
    // set portrait orientation
    jsPrintSetup.setOption('orientation', jsPrintSetup.kPortraitOrientation);
    // set top margins in millimeters
    jsPrintSetup.setOption('marginTop', 15);
    jsPrintSetup.setOption('marginBottom', 15);
    jsPrintSetup.setOption('marginLeft', 20);
    jsPrintSetup.setOption('marginRight', 10);
    // set page header
    jsPrintSetup.setOption('headerStrLeft', 'My custom header');
    jsPrintSetup.setOption('headerStrCenter', '');
    jsPrintSetup.setOption('headerStrRight', '&PT');
    // set empty page footer
    jsPrintSetup.setOption('footerStrLeft', '');
    jsPrintSetup.setOption('footerStrCenter', '');
    jsPrintSetup.setOption('footerStrRight', '');
    // Suppress print dialog
    jsPrintSetup.setSilentPrint(true);
    // Do Print
    window.print();
    // Restore print dialog
    jsPrintSetup.setSilentPrint(false);
}
function date() {
    var currentdate = new Date(); 
    var date = currentdate.getDate() + "-"
                    + (currentdate.getMonth()+1)  + "-" 
                    + currentdate.getFullYear();
    var time = currentdate.getHours() + ":"  
                    + currentdate.getMinutes() + ":" 
                    + currentdate.getSeconds();
    return date;
}
function time() {
    var currentdate = new Date(); 
    var date = currentdate.getDate() + "-"
                    + (currentdate.getMonth()+1)  + "-" 
                    + currentdate.getFullYear();
    var time = currentdate.getHours() + ":"  
                    + currentdate.getMinutes() + ":" 
                    + currentdate.getSeconds();
    return time;
}

/*! pace 0.5.1 */
(function(){var a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W=[].slice,X={}.hasOwnProperty,Y=function(a,b){function c(){this.constructor=a}for(var d in b)X.call(b,d)&&(a[d]=b[d]);return c.prototype=b.prototype,a.prototype=new c,a.__super__=b.prototype,a},Z=[].indexOf||function(a){for(var b=0,c=this.length;c>b;b++)if(b in this&&this[b]===a)return b;return-1};for(t={catchupTime:500,initialRate:.03,minTime:500,ghostTime:500,maxProgressPerFrame:10,easeFactor:1.25,startOnPageLoad:!0,restartOnPushState:!0,restartOnRequestAfter:500,target:"body",elements:{checkInterval:100,selectors:["body"]},eventLag:{minSamples:10,sampleCount:3,lagThreshold:3},ajax:{trackMethods:["GET"],trackWebSockets:!0,ignoreURLs:[]}},B=function(){var a;return null!=(a="undefined"!=typeof performance&&null!==performance?"function"==typeof performance.now?performance.now():void 0:void 0)?a:+new Date},D=window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||window.msRequestAnimationFrame,s=window.cancelAnimationFrame||window.mozCancelAnimationFrame,null==D&&(D=function(a){return setTimeout(a,50)},s=function(a){return clearTimeout(a)}),F=function(a){var b,c;return b=B(),(c=function(){var d;return d=B()-b,d>=33?(b=B(),a(d,function(){return D(c)})):setTimeout(c,33-d)})()},E=function(){var a,b,c;return c=arguments[0],b=arguments[1],a=3<=arguments.length?W.call(arguments,2):[],"function"==typeof c[b]?c[b].apply(c,a):c[b]},u=function(){var a,b,c,d,e,f,g;for(b=arguments[0],d=2<=arguments.length?W.call(arguments,1):[],f=0,g=d.length;g>f;f++)if(c=d[f])for(a in c)X.call(c,a)&&(e=c[a],null!=b[a]&&"object"==typeof b[a]&&null!=e&&"object"==typeof e?u(b[a],e):b[a]=e);return b},p=function(a){var b,c,d,e,f;for(c=b=0,e=0,f=a.length;f>e;e++)d=a[e],c+=Math.abs(d),b++;return c/b},w=function(a,b){var c,d,e;if(null==a&&(a="options"),null==b&&(b=!0),e=document.querySelector("[data-pace-"+a+"]")){if(c=e.getAttribute("data-pace-"+a),!b)return c;try{return JSON.parse(c)}catch(f){return d=f,"undefined"!=typeof console&&null!==console?console.error("Error parsing inline pace options",d):void 0}}},g=function(){function a(){}return a.prototype.on=function(a,b,c,d){var e;return null==d&&(d=!1),null==this.bindings&&(this.bindings={}),null==(e=this.bindings)[a]&&(e[a]=[]),this.bindings[a].push({handler:b,ctx:c,once:d})},a.prototype.once=function(a,b,c){return this.on(a,b,c,!0)},a.prototype.off=function(a,b){var c,d,e;if(null!=(null!=(d=this.bindings)?d[a]:void 0)){if(null==b)return delete this.bindings[a];for(c=0,e=[];c<this.bindings[a].length;)this.bindings[a][c].handler===b?e.push(this.bindings[a].splice(c,1)):e.push(c++);return e}},a.prototype.trigger=function(){var a,b,c,d,e,f,g,h,i;if(c=arguments[0],a=2<=arguments.length?W.call(arguments,1):[],null!=(g=this.bindings)?g[c]:void 0){for(e=0,i=[];e<this.bindings[c].length;)h=this.bindings[c][e],d=h.handler,b=h.ctx,f=h.once,d.apply(null!=b?b:this,a),f?i.push(this.bindings[c].splice(e,1)):i.push(e++);return i}},a}(),null==window.Pace&&(window.Pace={}),u(Pace,g.prototype),C=Pace.options=u({},t,window.paceOptions,w()),T=["ajax","document","eventLag","elements"],P=0,R=T.length;R>P;P++)J=T[P],C[J]===!0&&(C[J]=t[J]);i=function(a){function b(){return U=b.__super__.constructor.apply(this,arguments)}return Y(b,a),b}(Error),b=function(){function a(){this.progress=0}return a.prototype.getElement=function(){var a;if(null==this.el){if(a=document.querySelector(C.target),!a)throw new i;this.el=document.createElement("div"),this.el.className="pace pace-active",document.body.className=document.body.className.replace(/pace-done/g,""),document.body.className+=" pace-running",this.el.innerHTML='<div class="pace-progress">\n  <div class="pace-progress-inner"></div>\n</div>\n<div class="pace-activity"></div>',null!=a.firstChild?a.insertBefore(this.el,a.firstChild):a.appendChild(this.el)}return this.el},a.prototype.finish=function(){var a;return a=this.getElement(),a.className=a.className.replace("pace-active",""),a.className+=" pace-inactive",document.body.className=document.body.className.replace("pace-running",""),document.body.className+=" pace-done"},a.prototype.update=function(a){return this.progress=a,this.render()},a.prototype.destroy=function(){try{this.getElement().parentNode.removeChild(this.getElement())}catch(a){i=a}return this.el=void 0},a.prototype.render=function(){var a,b;return null==document.querySelector(C.target)?!1:(a=this.getElement(),a.children[0].style.width=""+this.progress+"%",(!this.lastRenderedProgress||this.lastRenderedProgress|0!==this.progress|0)&&(a.children[0].setAttribute("data-progress-text",""+(0|this.progress)+"%"),this.progress>=100?b="99":(b=this.progress<10?"0":"",b+=0|this.progress),a.children[0].setAttribute("data-progress",""+b)),this.lastRenderedProgress=this.progress)},a.prototype.done=function(){return this.progress>=100},a}(),h=function(){function a(){this.bindings={}}return a.prototype.trigger=function(a,b){var c,d,e,f,g;if(null!=this.bindings[a]){for(f=this.bindings[a],g=[],d=0,e=f.length;e>d;d++)c=f[d],g.push(c.call(this,b));return g}},a.prototype.on=function(a,b){var c;return null==(c=this.bindings)[a]&&(c[a]=[]),this.bindings[a].push(b)},a}(),O=window.XMLHttpRequest,N=window.XDomainRequest,M=window.WebSocket,v=function(a,b){var c,d,e,f;f=[];for(d in b.prototype)try{e=b.prototype[d],null==a[d]&&"function"!=typeof e?f.push(a[d]=e):f.push(void 0)}catch(g){c=g}return f},z=[],Pace.ignore=function(){var a,b,c;return b=arguments[0],a=2<=arguments.length?W.call(arguments,1):[],z.unshift("ignore"),c=b.apply(null,a),z.shift(),c},Pace.track=function(){var a,b,c;return b=arguments[0],a=2<=arguments.length?W.call(arguments,1):[],z.unshift("track"),c=b.apply(null,a),z.shift(),c},I=function(a){var b;if(null==a&&(a="GET"),"track"===z[0])return"force";if(!z.length&&C.ajax){if("socket"===a&&C.ajax.trackWebSockets)return!0;if(b=a.toUpperCase(),Z.call(C.ajax.trackMethods,b)>=0)return!0}return!1},j=function(a){function b(){var a,c=this;b.__super__.constructor.apply(this,arguments),a=function(a){var b;return b=a.open,a.open=function(d,e){return I(d)&&c.trigger("request",{type:d,url:e,request:a}),b.apply(a,arguments)}},window.XMLHttpRequest=function(b){var c;return c=new O(b),a(c),c},v(window.XMLHttpRequest,O),null!=N&&(window.XDomainRequest=function(){var b;return b=new N,a(b),b},v(window.XDomainRequest,N)),null!=M&&C.ajax.trackWebSockets&&(window.WebSocket=function(a,b){var d;return d=null!=b?new M(a,b):new M(a),I("socket")&&c.trigger("request",{type:"socket",url:a,protocols:b,request:d}),d},v(window.WebSocket,M))}return Y(b,a),b}(h),Q=null,x=function(){return null==Q&&(Q=new j),Q},H=function(a){var b,c,d,e;for(e=C.ajax.ignoreURLs,c=0,d=e.length;d>c;c++)if(b=e[c],"string"==typeof b){if(-1!==a.indexOf(b))return!0}else if(b.test(a))return!0;return!1},x().on("request",function(b){var c,d,e,f,g;return f=b.type,e=b.request,g=b.url,H(g)?void 0:Pace.running||C.restartOnRequestAfter===!1&&"force"!==I(f)?void 0:(d=arguments,c=C.restartOnRequestAfter||0,"boolean"==typeof c&&(c=0),setTimeout(function(){var b,c,g,h,i,j;if(b="socket"===f?e.readyState<2:0<(h=e.readyState)&&4>h){for(Pace.restart(),i=Pace.sources,j=[],c=0,g=i.length;g>c;c++){if(J=i[c],J instanceof a){J.watch.apply(J,d);break}j.push(void 0)}return j}},c))}),a=function(){function a(){var a=this;this.elements=[],x().on("request",function(){return a.watch.apply(a,arguments)})}return a.prototype.watch=function(a){var b,c,d,e;return d=a.type,b=a.request,e=a.url,H(e)?void 0:(c="socket"===d?new m(b):new n(b),this.elements.push(c))},a}(),n=function(){function a(a){var b,c,d,e,f,g,h=this;if(this.progress=0,null!=window.ProgressEvent)for(c=null,a.addEventListener("progress",function(a){return h.progress=a.lengthComputable?100*a.loaded/a.total:h.progress+(100-h.progress)/2}),g=["load","abort","timeout","error"],d=0,e=g.length;e>d;d++)b=g[d],a.addEventListener(b,function(){return h.progress=100});else f=a.onreadystatechange,a.onreadystatechange=function(){var b;return 0===(b=a.readyState)||4===b?h.progress=100:3===a.readyState&&(h.progress=50),"function"==typeof f?f.apply(null,arguments):void 0}}return a}(),m=function(){function a(a){var b,c,d,e,f=this;for(this.progress=0,e=["error","open"],c=0,d=e.length;d>c;c++)b=e[c],a.addEventListener(b,function(){return f.progress=100})}return a}(),d=function(){function a(a){var b,c,d,f;for(null==a&&(a={}),this.elements=[],null==a.selectors&&(a.selectors=[]),f=a.selectors,c=0,d=f.length;d>c;c++)b=f[c],this.elements.push(new e(b))}return a}(),e=function(){function a(a){this.selector=a,this.progress=0,this.check()}return a.prototype.check=function(){var a=this;return document.querySelector(this.selector)?this.done():setTimeout(function(){return a.check()},C.elements.checkInterval)},a.prototype.done=function(){return this.progress=100},a}(),c=function(){function a(){var a,b,c=this;this.progress=null!=(b=this.states[document.readyState])?b:100,a=document.onreadystatechange,document.onreadystatechange=function(){return null!=c.states[document.readyState]&&(c.progress=c.states[document.readyState]),"function"==typeof a?a.apply(null,arguments):void 0}}return a.prototype.states={loading:0,interactive:50,complete:100},a}(),f=function(){function a(){var a,b,c,d,e,f=this;this.progress=0,a=0,e=[],d=0,c=B(),b=setInterval(function(){var g;return g=B()-c-50,c=B(),e.push(g),e.length>C.eventLag.sampleCount&&e.shift(),a=p(e),++d>=C.eventLag.minSamples&&a<C.eventLag.lagThreshold?(f.progress=100,clearInterval(b)):f.progress=100*(3/(a+3))},50)}return a}(),l=function(){function a(a){this.source=a,this.last=this.sinceLastUpdate=0,this.rate=C.initialRate,this.catchup=0,this.progress=this.lastProgress=0,null!=this.source&&(this.progress=E(this.source,"progress"))}return a.prototype.tick=function(a,b){var c;return null==b&&(b=E(this.source,"progress")),b>=100&&(this.done=!0),b===this.last?this.sinceLastUpdate+=a:(this.sinceLastUpdate&&(this.rate=(b-this.last)/this.sinceLastUpdate),this.catchup=(b-this.progress)/C.catchupTime,this.sinceLastUpdate=0,this.last=b),b>this.progress&&(this.progress+=this.catchup*a),c=1-Math.pow(this.progress/100,C.easeFactor),this.progress+=c*this.rate*a,this.progress=Math.min(this.lastProgress+C.maxProgressPerFrame,this.progress),this.progress=Math.max(0,this.progress),this.progress=Math.min(100,this.progress),this.lastProgress=this.progress,this.progress},a}(),K=null,G=null,q=null,L=null,o=null,r=null,Pace.running=!1,y=function(){return C.restartOnPushState?Pace.restart():void 0},null!=window.history.pushState&&(S=window.history.pushState,window.history.pushState=function(){return y(),S.apply(window.history,arguments)}),null!=window.history.replaceState&&(V=window.history.replaceState,window.history.replaceState=function(){return y(),V.apply(window.history,arguments)}),k={ajax:a,elements:d,document:c,eventLag:f},(A=function(){var a,c,d,e,f,g,h,i;for(Pace.sources=K=[],g=["ajax","elements","document","eventLag"],c=0,e=g.length;e>c;c++)a=g[c],C[a]!==!1&&K.push(new k[a](C[a]));for(i=null!=(h=C.extraSources)?h:[],d=0,f=i.length;f>d;d++)J=i[d],K.push(new J(C));return Pace.bar=q=new b,G=[],L=new l})(),Pace.stop=function(){return Pace.trigger("stop"),Pace.running=!1,q.destroy(),r=!0,null!=o&&("function"==typeof s&&s(o),o=null),A()},Pace.restart=function(){return Pace.trigger("restart"),Pace.stop(),Pace.start()},Pace.go=function(){var a;return Pace.running=!0,q.render(),a=B(),r=!1,o=F(function(b,c){var d,e,f,g,h,i,j,k,m,n,o,p,s,t,u,v;for(k=100-q.progress,e=o=0,f=!0,i=p=0,t=K.length;t>p;i=++p)for(J=K[i],n=null!=G[i]?G[i]:G[i]=[],h=null!=(v=J.elements)?v:[J],j=s=0,u=h.length;u>s;j=++s)g=h[j],m=null!=n[j]?n[j]:n[j]=new l(g),f&=m.done,m.done||(e++,o+=m.tick(b));return d=o/e,q.update(L.tick(b,d)),q.done()||f||r?(q.update(100),Pace.trigger("done"),setTimeout(function(){return q.finish(),Pace.running=!1,Pace.trigger("hide")},Math.max(C.ghostTime,Math.max(C.minTime-(B()-a),0)))):c()})},Pace.start=function(a){u(C,a),Pace.running=!0;try{q.render()}catch(b){i=b}return document.querySelector(".pace")?(Pace.trigger("start"),Pace.go()):setTimeout(Pace.start,50)},"function"==typeof define&&define.amd?define(function(){return Pace}):"object"==typeof exports?module.exports=Pace:C.startOnPageLoad&&Pace.start()}).call(this);
//# sourceMappingURL=all2.js.map
