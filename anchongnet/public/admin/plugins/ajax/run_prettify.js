!function(){var r=3Dnull;
(function(){function X(e){function j(){try{J.doScroll("left")}catch(e){P(j,=
50);return}w("poll")}function w(j){if(!(j.type=3D=3D"readystatechange"&amp;=
&amp;x.readyState!=3D"complete")&amp;&amp;((j.type=3D=3D"load"?n:x)[z](i+j.=
type,w,!1),!m&amp;&amp;(m=3D!0)))e.call(n,j.type||j)}var Y=3Dx.addEventList=
ener,m=3D!1,C=3D!0,t=3DY?"addEventListener":"attachEvent",z=3DY?"removeEven=
tListener":"detachEvent",i=3DY?"":"on";if(x.readyState=3D=3D"complete")e.ca=
ll(n,"lazy");else{if(x.createEventObject&amp;&amp;J.doScroll){try{C=3D!n.fr=
ameElement}catch(A){}C&amp;&amp;j()}x[t](i+"DOMContentLoaded",
w,!1);x[t](i+"readystatechange",w,!1);n[t](i+"load",w,!1)}}function Q(){S&a=
mp;&amp;X(function(){var e=3DK.length;$(e?function(){for(var j=3D0;j&lt;e;+=
+j)(function(e){P(function(){n.exports[K[e]].apply(n,arguments)},0)})(j)}:v=
oid 0)})}for(var n=3Dwindow,P=3Dn.setTimeout,x=3Ddocument,J=3Dx.documentEle=
ment,L=3Dx.head||x.getElementsByTagName("head")[0]||J,z=3D"",A=3Dx.getEleme=
ntsByTagName("script"),m=3DA.length;--m&gt;=3D0;){var M=3DA[m],T=3DM.src.ma=
tch(/^[^#?]*\/run_prettify\.js(\?[^#]*)?(?:#.*)?$/);if(T){z=3DT[1]||"";M.pa=
rentNode.removeChild(M);
break}}var S=3D!0,D=3D[],N=3D[],K=3D[];z.replace(/[&amp;?]([^&amp;=3D]+)=3D=
([^&amp;]+)/g,function(e,j,w){w=3DdecodeURIComponent(w);j=3DdecodeURICompon=
ent(j);j=3D=3D"autorun"?S=3D!/^[0fn]/i.test(w):j=3D=3D"lang"?D.push(w):j=3D=
=3D"skin"?N.push(w):j=3D=3D"callback"&amp;&amp;K.push(w)});m=3D0;for(z=3DD.=
length;m&lt;z;++m)(function(){var e=3Dx.createElement("script");e.onload=3D=
e.onerror=3De.onreadystatechange=3Dfunction(){if(e&amp;&amp;(!e.readyState|=
|/loaded|complete/.test(e.readyState)))e.onerror=3De.onload=3De.onreadystat=
echange=3Dr,--R,R||P(Q,0),e.parentNode&amp;&amp;e.parentNode.removeChild(e)=
,
e=3Dr};e.type=3D"text/javascript";e.src=3D"https://google-code-prettify.goo=
glecode.com/svn/loader/lang-"+encodeURIComponent(D[m])+".js";L.insertBefore=
(e,L.firstChild)})(D[m]);for(var R=3DD.length,A=3D[],m=3D0,z=3DN.length;m&l=
t;z;++m)A.push("https://google-code-prettify.googlecode.com/svn/loader/skin=
s/"+encodeURIComponent(N[m])+".css");A.push("https://google-code-prettify.g=
ooglecode.com/svn/loader/prettify.css");(function(e){function j(m){if(m!=3D=
=3Dw){var n=3Dx.createElement("link");n.rel=3D"stylesheet";n.type=3D"text/c=
ss";
if(m+1&lt;w)n.error=3Dn.onerror=3Dfunction(){j(m+1)};n.href=3De[m];L.append=
Child(n)}}var w=3De.length;j(0)})(A);var $=3Dfunction(){window.PR_SHOULD_US=
E_CONTINUATION=3D!0;var e;(function(){function j(a){function d(f){var b=3Df=
.charCodeAt(0);if(b!=3D=3D92)return b;var a=3Df.charAt(1);return(b=3Di[a])?=
b:"0"&lt;=3Da&amp;&amp;a&lt;=3D"7"?parseInt(f.substring(1),8):a=3D=3D=3D"u"=
||a=3D=3D=3D"x"?parseInt(f.substring(2),16):f.charCodeAt(1)}function h(f){i=
f(f&lt;32)return(f&lt;16?"\\x0":"\\x")+f.toString(16);f=3DString.fromCharCo=
de(f);return f=3D=3D=3D"\\"||f=3D=3D=3D"-"||f=3D=3D=3D"]"||
f=3D=3D=3D"^"?"\\"+f:f}function b(f){var b=3Df.substring(1,f.length-1).matc=
h(/\\u[\dA-Fa-f]{4}|\\x[\dA-Fa-f]{2}|\\[0-3][0-7]{0,2}|\\[0-7]{1,2}|\\[\S\s=
]|[^\\]/g),f=3D[],a=3Db[0]=3D=3D=3D"^",c=3D["["];a&amp;&amp;c.push("^");for=
(var a=3Da?1:0,g=3Db.length;a&lt;g;++a){var k=3Db[a];if(/\\[bdsw]/i.test(k)=
)c.push(k);else{var k=3Dd(k),o;a+2&lt;g&amp;&amp;"-"=3D=3D=3Db[a+1]?(o=3Dd(=
b[a+2]),a+=3D2):o=3Dk;f.push([k,o]);o&lt;65||k&gt;122||(o&lt;65||k&gt;90||f=
.push([Math.max(65,k)|32,Math.min(o,90)|32]),o&lt;97||k&gt;122||f.push([Mat=
h.max(97,k)&amp;-33,Math.min(o,122)&amp;-33]))}}f.sort(function(f,
a){return f[0]-a[0]||a[1]-f[1]});b=3D[];g=3D[];for(a=3D0;a&lt;f.length;++a)=
k=3Df[a],k[0]&lt;=3Dg[1]+1?g[1]=3DMath.max(g[1],k[1]):b.push(g=3Dk);for(a=
=3D0;a&lt;b.length;++a)k=3Db[a],c.push(h(k[0])),k[1]&gt;k[0]&amp;&amp;(k[1]=
+1&gt;k[0]&amp;&amp;c.push("-"),c.push(h(k[1])));c.push("]");return c.join(=
"")}function e(f){for(var a=3Df.source.match(/\[(?:[^\\\]]|\\[\S\s])*]|\\u[=
\dA-Fa-f]{4}|\\x[\dA-Fa-f]{2}|\\\d+|\\[^\dux]|\(\?[!:=3D]|[()^]|[^()[\\^]+/=
g),c=3Da.length,d=3D[],g=3D0,k=3D0;g&lt;c;++g){var o=3Da[g];o=3D=3D=3D"("?+=
+k:"\\"=3D=3D=3Do.charAt(0)&amp;&amp;(o=3D+o.substring(1))&amp;&amp;(o&lt;=
=3Dk?
d[o]=3D-1:a[g]=3Dh(o))}for(g=3D1;g&lt;d.length;++g)-1=3D=3D=3Dd[g]&amp;&amp=
;(d[g]=3D++j);for(k=3Dg=3D0;g&lt;c;++g)o=3Da[g],o=3D=3D=3D"("?(++k,d[k]||(a=
[g]=3D"(?:")):"\\"=3D=3D=3Do.charAt(0)&amp;&amp;(o=3D+o.substring(1))&amp;&=
amp;o&lt;=3Dk&amp;&amp;(a[g]=3D"\\"+d[o]);for(g=3D0;g&lt;c;++g)"^"=3D=3D=3D=
a[g]&amp;&amp;"^"!=3D=3Da[g+1]&amp;&amp;(a[g]=3D"");if(f.ignoreCase&amp;&am=
p;F)for(g=3D0;g&lt;c;++g)o=3Da[g],f=3Do.charAt(0),o.length&gt;=3D2&amp;&amp=
;f=3D=3D=3D"["?a[g]=3Db(o):f!=3D=3D"\\"&amp;&amp;(a[g]=3Do.replace(/[A-Za-z=
]/g,function(a){a=3Da.charCodeAt(0);return"["+String.fromCharCode(a&amp;-33=
,a|32)+"]"}));return a.join("")}for(var j=3D0,F=3D!1,l=3D!1,I=3D0,c=3Da.len=
gth;I&lt;c;++I){var p=3D
a[I];if(p.ignoreCase)l=3D!0;else if(/[a-z]/i.test(p.source.replace(/\\u[\da=
-f]{4}|\\x[\da-f]{2}|\\[^UXux]/gi,""))){F=3D!0;l=3D!1;break}}for(var i=3D{b=
:8,t:9,n:10,v:11,f:12,r:13},q=3D[],I=3D0,c=3Da.length;I&lt;c;++I){p=3Da[I];=
if(p.global||p.multiline)throw Error(""+p);q.push("(?:"+e(p)+")")}return Re=
gExp(q.join("|"),l?"gi":"g")}function m(a,d){function h(a){var c=3Da.nodeTy=
pe;if(c=3D=3D1){if(!b.test(a.className)){for(c=3Da.firstChild;c;c=3Dc.nextS=
ibling)h(c);c=3Da.nodeName.toLowerCase();if("br"=3D=3D=3Dc||"li"=3D=3D=3Dc)=
e[l]=3D"\n",F[l&lt;&lt;1]=3Dj++,
F[l++&lt;&lt;1|1]=3Da}}else if(c=3D=3D3||c=3D=3D4)c=3Da.nodeValue,c.length&=
amp;&amp;(c=3Dd?c.replace(/\r\n?/g,"\n"):c.replace(/[\t\n\r ]+/g," "),e[l]=
=3Dc,F[l&lt;&lt;1]=3Dj,j+=3Dc.length,F[l++&lt;&lt;1|1]=3Da)}var b=3D/(?:^|\=
s)nocode(?:\s|$)/,e=3D[],j=3D0,F=3D[],l=3D0;h(a);return{a:e.join("").replac=
e(/\n$/,""),d:F}}function n(a,d,h,b){d&amp;&amp;(a=3D{a:d,e:a},h(a),b.push.=
apply(b,a.g))}function x(a){for(var d=3Dvoid 0,h=3Da.firstChild;h;h=3Dh.nex=
tSibling)var b=3Dh.nodeType,d=3Db=3D=3D=3D1?d?a:h:b=3D=3D=3D3?S.test(h.node=
Value)?a:d:d;return d=3D=3D=3Da?void 0:d}function C(a,d){function h(a){for(=
var l=3D
a.e,j=3D[l,"pln"],c=3D0,p=3Da.a.match(e)||[],m=3D{},q=3D0,f=3Dp.length;q&lt=
;f;++q){var B=3Dp[q],y=3Dm[B],u=3Dvoid 0,g;if(typeof y=3D=3D=3D"string")g=
=3D!1;else{var k=3Db[B.charAt(0)];if(k)u=3DB.match(k[1]),y=3Dk[0];else{for(=
g=3D0;g&lt;i;++g)if(k=3Dd[g],u=3DB.match(k[1])){y=3Dk[0];break}u||(y=3D"pln=
")}if((g=3Dy.length&gt;=3D5&amp;&amp;"lang-"=3D=3D=3Dy.substring(0,5))&amp;=
&amp;!(u&amp;&amp;typeof u[1]=3D=3D=3D"string"))g=3D!1,y=3D"src";g||(m[B]=
=3Dy)}k=3Dc;c+=3DB.length;if(g){g=3Du[1];var o=3DB.indexOf(g),H=3Do+g.lengt=
h;u[2]&amp;&amp;(H=3DB.length-u[2].length,o=3DH-g.length);y=3Dy.substring(5=
);n(l+k,B.substring(0,o),h,
j);n(l+k+o,g,A(y,g),j);n(l+k+H,B.substring(H),h,j)}else j.push(l+k,y)}a.g=
=3Dj}var b=3D{},e;(function(){for(var h=3Da.concat(d),l=3D[],i=3D{},c=3D0,p=
=3Dh.length;c&lt;p;++c){var m=3Dh[c],q=3Dm[3];if(q)for(var f=3Dq.length;--f=
&gt;=3D0;)b[q.charAt(f)]=3Dm;m=3Dm[1];q=3D""+m;i.hasOwnProperty(q)||(l.push=
(m),i[q]=3Dr)}l.push(/[\S\s]/);e=3Dj(l)})();var i=3Dd.length;return h}funct=
ion t(a){var d=3D[],h=3D[];a.tripleQuotedStrings?d.push(["str",/^(?:'''(?:[=
^'\\]|\\[\S\s]|''?(?=3D[^']))*(?:'''|$)|"""(?:[^"\\]|\\[\S\s]|""?(?=3D[^"])=
)*(?:"""|$)|'(?:[^'\\]|\\[\S\s])*(?:'|$)|"(?:[^"\\]|\\[\S\s])*(?:"|$))/,
r,"'\""]):a.multiLineStrings?d.push(["str",/^(?:'(?:[^'\\]|\\[\S\s])*(?:'|$=
)|"(?:[^"\\]|\\[\S\s])*(?:"|$)|`(?:[^\\`]|\\[\S\s])*(?:`|$))/,r,"'\"`"]):d.=
push(["str",/^(?:'(?:[^\n\r'\\]|\\.)*(?:'|$)|"(?:[^\n\r"\\]|\\.)*(?:"|$))/,=
r,"\"'"]);a.verbatimStrings&amp;&amp;h.push(["str",/^@"(?:[^"]|"")*(?:"|$)/=
,r]);var b=3Da.hashComments;b&amp;&amp;(a.cStyleComments?(b&gt;1?d.push(["c=
om",/^#(?:##(?:[^#]|#(?!##))*(?:###|$)|.*)/,r,"#"]):d.push(["com",/^#(?:(?:=
define|e(?:l|nd)if|else|error|ifn?def|include|line|pragma|undef|warning)\b|=
[^\n\r]*)/,
r,"#"]),h.push(["str",/^&lt;(?:(?:(?:\.\.\/)*|\/?)(?:[\w-]+(?:\/[\w-]+)+)?[=
\w-]+\.h(?:h|pp|\+\+)?|[a-z]\w*)&gt;/,r])):d.push(["com",/^#[^\n\r]*/,r,"#"=
]));a.cStyleComments&amp;&amp;(h.push(["com",/^\/\/[^\n\r]*/,r]),h.push(["c=
om",/^\/\*[\S\s]*?(?:\*\/|$)/,r]));if(b=3Da.regexLiterals){var e=3D(b=3Db&g=
t;1?"":"\n\r")?".":"[\\S\\s]";h.push(["lang-regex",RegExp("^(?:^^\\.?|[+-]|=
[!=3D]=3D?=3D?|\\#|%=3D?|&amp;&amp;?=3D?|\\(|\\*=3D?|[+\\-]=3D|-&gt;|\\/=3D=
?|::?|&lt;&lt;?=3D?|&gt;&gt;?&gt;?=3D?|,|;|\\?|@|\\[|~|{|\\^\\^?=3D?|\\|\\|=
?=3D?|break|case|continue|delete|do|else|finally|instanceof|return|throw|tr=
y|typeof)\\s*("+
("/(?=3D[^/*"+b+"])(?:[^/\\x5B\\x5C"+b+"]|\\x5C"+e+"|\\x5B(?:[^\\x5C\\x5D"+=
b+"]|\\x5C"+e+")*(?:\\x5D|$))+/")+")")])}(b=3Da.types)&amp;&amp;h.push(["ty=
p",b]);b=3D(""+a.keywords).replace(/^ | $/g,"");b.length&amp;&amp;h.push(["=
kwd",RegExp("^(?:"+b.replace(/[\s,]+/g,"|")+")\\b"),r]);d.push(["pln",/^\s+=
/,r," \r\n\t\u00a0"]);b=3D"^.[^\\s\\w.$@'\"`/\\\\]*";a.regexLiterals&amp;&a=
mp;(b+=3D"(?!s*/)");h.push(["lit",/^@[$_a-z][\w$@]*/i,r],["typ",/^(?:[@_]?[=
A-Z]+[a-z][\w$@]*|\w+_t\b)/,r],["pln",/^[$_a-z][\w$@]*/i,r],["lit",/^(?:0x[=
\da-f]+|(?:\d(?:_\d+)*\d*(?:\.\d*)?|\.\d\+)(?:e[+-]?\d+)?)[a-z]*/i,
r,"0123456789"],["pln",/^\\[\S\s]?/,r],["pun",RegExp(b),r]);return C(d,h)}f=
unction z(a,d,h){function b(a){var c=3Da.nodeType;if(c=3D=3D1&amp;&amp;!j.t=
est(a.className))if("br"=3D=3D=3Da.nodeName)e(a),a.parentNode&amp;&amp;a.pa=
rentNode.removeChild(a);else for(a=3Da.firstChild;a;a=3Da.nextSibling)b(a);=
else if((c=3D=3D3||c=3D=3D4)&amp;&amp;h){var d=3Da.nodeValue,i=3Dd.match(m)=
;if(i)c=3Dd.substring(0,i.index),a.nodeValue=3Dc,(d=3Dd.substring(i.index+i=
[0].length))&amp;&amp;a.parentNode.insertBefore(l.createTextNode(d),a.nextS=
ibling),e(a),c||a.parentNode.removeChild(a)}}
function e(a){function b(a,c){var d=3Dc?a.cloneNode(!1):a,f=3Da.parentNode;=
if(f){var f=3Db(f,1),h=3Da.nextSibling;f.appendChild(d);for(var e=3Dh;e;e=
=3Dh)h=3De.nextSibling,f.appendChild(e)}return d}for(;!a.nextSibling;)if(a=
=3Da.parentNode,!a)return;for(var a=3Db(a.nextSibling,0),d;(d=3Da.parentNod=
e)&amp;&amp;d.nodeType=3D=3D=3D1;)a=3Dd;c.push(a)}for(var j=3D/(?:^|\s)noco=
de(?:\s|$)/,m=3D/\r\n?|\n/,l=3Da.ownerDocument,i=3Dl.createElement("li");a.=
firstChild;)i.appendChild(a.firstChild);for(var c=3D[i],p=3D0;p&lt;c.length=
;++p)b(c[p]);d=3D=3D=3D(d|0)&amp;&amp;c[0].setAttribute("value",
d);var n=3Dl.createElement("ol");n.className=3D"linenums";for(var d=3DMath.=
max(0,d-1|0)||0,p=3D0,q=3Dc.length;p&lt;q;++p)i=3Dc[p],i.className=3D"L"+(p=
+d)%10,i.firstChild||i.appendChild(l.createTextNode("\u00a0")),n.appendChil=
d(i);a.appendChild(n)}function i(a,d){for(var h=3Dd.length;--h&gt;=3D0;){va=
r b=3Dd[h];U.hasOwnProperty(b)?V.console&amp;&amp;console.warn("cannot over=
ride language handler %s",b):U[b]=3Da}}function A(a,d){if(!a||!U.hasOwnProp=
erty(a))a=3D/^\s*&lt;/.test(d)?"default-markup":"default-code";return U[a]}=
function D(a){var d=3D
a.h;try{var h=3Dm(a.c,a.i),b=3Dh.a;a.a=3Db;a.d=3Dh.d;a.e=3D0;A(d,b)(a);var =
e=3D/\bMSIE\s(\d+)/.exec(navigator.userAgent),e=3De&amp;&amp;+e[1]&lt;=3D8,=
d=3D/\n/g,i=3Da.a,j=3Di.length,h=3D0,l=3Da.d,n=3Dl.length,b=3D0,c=3Da.g,p=
=3Dc.length,t=3D0;c[p]=3Dj;var q,f;for(f=3Dq=3D0;f&lt;p;)c[f]!=3D=3Dc[f+2]?=
(c[q++]=3Dc[f++],c[q++]=3Dc[f++]):f+=3D2;p=3Dq;for(f=3Dq=3D0;f&lt;p;){for(v=
ar x=3Dc[f],y=3Dc[f+1],u=3Df+2;u+2&lt;=3Dp&amp;&amp;c[u+1]=3D=3D=3Dy;)u+=3D=
2;c[q++]=3Dx;c[q++]=3Dy;f=3Du}c.length=3Dq;var g=3Da.c,k;if(g)k=3Dg.style.d=
isplay,g.style.display=3D"none";try{for(;b&lt;n;){var o=3Dl[b+2]||j,H=3Dc[t=
+2]||j,u=3DMath.min(o,H),E=3Dl[b+
1],W;if(E.nodeType!=3D=3D1&amp;&amp;(W=3Di.substring(h,u))){e&amp;&amp;(W=
=3DW.replace(d,"\r"));E.nodeValue=3DW;var Z=3DE.ownerDocument,s=3DZ.createE=
lement("span");s.className=3Dc[t+1];var z=3DE.parentNode;z.replaceChild(s,E=
);s.appendChild(E);h&lt;o&amp;&amp;(l[b+1]=3DE=3DZ.createTextNode(i.substri=
ng(u,o)),z.insertBefore(E,s.nextSibling))}h=3Du;h&gt;=3Do&amp;&amp;(b+=3D2)=
;h&gt;=3DH&amp;&amp;(t+=3D2)}}finally{if(g)g.style.display=3Dk}}catch(v){V.=
console&amp;&amp;console.log(v&amp;&amp;v.stack||v)}}var V=3Dwindow,G=3D["b=
reak,continue,do,else,for,if,return,while"],O=3D[[G,"auto,case,char,const,d=
efault,double,enum,extern,float,goto,inline,int,long,register,short,signed,=
sizeof,static,struct,switch,typedef,union,unsigned,void,volatile"],
"catch,class,delete,false,import,new,operator,private,protected,public,this=
,throw,true,try,typeof"],J=3D[O,"alignof,align_union,asm,axiom,bool,concept=
,concept_map,const_cast,constexpr,decltype,delegate,dynamic_cast,explicit,e=
xport,friend,generic,late_check,mutable,namespace,nullptr,property,reinterp=
ret_cast,static_assert,static_cast,template,typeid,typename,using,virtual,w=
here"],K=3D[O,"abstract,assert,boolean,byte,extends,final,finally,implement=
s,import,instanceof,interface,null,native,package,strictfp,super,synchroniz=
ed,throws,transient"],
L=3D[K,"as,base,by,checked,decimal,delegate,descending,dynamic,event,fixed,=
foreach,from,group,implicit,in,internal,into,is,let,lock,object,out,overrid=
e,orderby,params,partial,readonly,ref,sbyte,sealed,stackalloc,string,select=
,uint,ulong,unchecked,unsafe,ushort,var,virtual,where"],O=3D[O,"debugger,ev=
al,export,function,get,null,set,undefined,var,with,Infinity,NaN"],M=3D[G,"a=
nd,as,assert,class,def,del,elif,except,exec,finally,from,global,import,in,i=
s,lambda,nonlocal,not,or,pass,print,raise,try,with,yield,False,True,None"],
N=3D[G,"alias,and,begin,case,class,def,defined,elsif,end,ensure,false,in,mo=
dule,next,nil,not,or,redo,rescue,retry,self,super,then,true,undef,unless,un=
til,when,yield,BEGIN,END"],R=3D[G,"as,assert,const,copy,drop,enum,extern,fa=
il,false,fn,impl,let,log,loop,match,mod,move,mut,priv,pub,pure,ref,self,sta=
tic,struct,true,trait,type,unsafe,use"],G=3D[G,"case,done,elif,esac,eval,fi=
,function,in,local,set,then,until"],Q=3D/^(DIR|FILE|vector|(de|priority_)?q=
ueue|list|stack|(const_)?iterator|(multi)?(set|map)|bitset|u?(int|float)\d*=
)\b/,
S=3D/\S/,T=3Dt({keywords:[J,L,O,"caller,delete,die,do,dump,elsif,eval,exit,=
foreach,for,goto,if,import,last,local,my,next,no,our,print,package,redo,req=
uire,sub,undef,unless,until,use,wantarray,while,BEGIN,END",M,N,G],hashComme=
nts:!0,cStyleComments:!0,multiLineStrings:!0,regexLiterals:!0}),U=3D{};i(T,=
["default-code"]);i(C([],[["pln",/^[^&lt;?]+/],["dec",/^&lt;!\w[^&gt;]*(?:&=
gt;|$)/],["com",/^&lt;\!--[\S\s]*?(?:--\&gt;|$)/],["lang-",/^&lt;\?([\S\s]+=
?)(?:\?&gt;|$)/],["lang-",/^&lt;%([\S\s]+?)(?:%&gt;|$)/],["pun",/^(?:&lt;[%=
?]|[%?]&gt;)/],["lang-",
/^&lt;xmp\b[^&gt;]*&gt;([\S\s]+?)&lt;\/xmp\b[^&gt;]*&gt;/i],["lang-js",/^&l=
t;script\b[^&gt;]*&gt;([\S\s]*?)(&lt;\/script\b[^&gt;]*&gt;)/i],["lang-css"=
,/^&lt;style\b[^&gt;]*&gt;([\S\s]*?)(&lt;\/style\b[^&gt;]*&gt;)/i],["lang-i=
n.tag",/^(&lt;\/?[a-z][^&lt;&gt;]*&gt;)/i]]),["default-markup","htm","html"=
,"mxml","xhtml","xml","xsl"]);i(C([["pln",/^\s+/,r," \t\r\n"],["atv",/^(?:"=
[^"]*"?|'[^']*'?)/,r,"\"'"]],[["tag",/^^&lt;\/?[a-z](?:[\w-.:]*\w)?|\/?&gt;=
$/i],["atn",/^(?!style[\s=3D]|on)[a-z](?:[\w:-]*\w)?/i],["lang-uq.val",/^=
=3D\s*([^\s"'&gt;]*(?:[^\s"'/&gt;]|\/(?=3D\s)))/],["pun",/^[/&lt;-&gt;]+/],
["lang-js",/^on\w+\s*=3D\s*"([^"]+)"/i],["lang-js",/^on\w+\s*=3D\s*'([^']+)=
'/i],["lang-js",/^on\w+\s*=3D\s*([^\s"'&gt;]+)/i],["lang-css",/^style\s*=3D=
\s*"([^"]+)"/i],["lang-css",/^style\s*=3D\s*'([^']+)'/i],["lang-css",/^styl=
e\s*=3D\s*([^\s"'&gt;]+)/i]]),["in.tag"]);i(C([],[["atv",/^[\S\s]+/]]),["uq=
.val"]);i(t({keywords:J,hashComments:!0,cStyleComments:!0,types:Q}),["c","c=
c","cpp","cxx","cyc","m"]);i(t({keywords:"null,true,false"}),["json"]);i(t(=
{keywords:L,hashComments:!0,cStyleComments:!0,verbatimStrings:!0,types:Q}),
["cs"]);i(t({keywords:K,cStyleComments:!0}),["java"]);i(t({keywords:G,hashC=
omments:!0,multiLineStrings:!0}),["bash","bsh","csh","sh"]);i(t({keywords:M=
,hashComments:!0,multiLineStrings:!0,tripleQuotedStrings:!0}),["cv","py","p=
ython"]);i(t({keywords:"caller,delete,die,do,dump,elsif,eval,exit,foreach,f=
or,goto,if,import,last,local,my,next,no,our,print,package,redo,require,sub,=
undef,unless,until,use,wantarray,while,BEGIN,END",hashComments:!0,multiLine=
Strings:!0,regexLiterals:2}),["perl","pl","pm"]);i(t({keywords:N,
hashComments:!0,multiLineStrings:!0,regexLiterals:!0}),["rb","ruby"]);i(t({=
keywords:O,cStyleComments:!0,regexLiterals:!0}),["javascript","js"]);i(t({k=
eywords:"all,and,by,catch,class,else,extends,false,finally,for,if,in,is,isn=
t,loop,new,no,not,null,of,off,on,or,return,super,then,throw,true,try,unless=
,until,when,while,yes",hashComments:3,cStyleComments:!0,multilineStrings:!0=
,tripleQuotedStrings:!0,regexLiterals:!0}),["coffee"]);i(t({keywords:R,cSty=
leComments:!0,multilineStrings:!0}),["rc","rs","rust"]);
i(C([],[["str",/^[\S\s]+/]]),["regex"]);var X=3DV.PR=3D{createSimpleLexer:C=
,registerLangHandler:i,sourceDecorator:t,PR_ATTRIB_NAME:"atn",PR_ATTRIB_VAL=
UE:"atv",PR_COMMENT:"com",PR_DECLARATION:"dec",PR_KEYWORD:"kwd",PR_LITERAL:=
"lit",PR_NOCODE:"nocode",PR_PLAIN:"pln",PR_PUNCTUATION:"pun",PR_SOURCE:"src=
",PR_STRING:"str",PR_TAG:"tag",PR_TYPE:"typ",prettyPrintOne:function(a,d,e)=
{var b=3Ddocument.createElement("div");b.innerHTML=3D"&lt;pre&gt;"+a+"&lt;/=
pre&gt;";b=3Db.firstChild;e&amp;&amp;z(b,e,!0);D({h:d,j:e,c:b,i:1});return =
b.innerHTML},
prettyPrint:e=3De=3Dfunction(a,d){function e(){for(var b=3DV.PR_SHOULD_USE_=
CONTINUATION?c.now()+250:Infinity;p&lt;j.length&amp;&amp;c.now()&lt;b;p++){=
for(var d=3Dj[p],m=3Dk,l=3Dd;l=3Dl.previousSibling;){var n=3Dl.nodeType,s=
=3D(n=3D=3D=3D7||n=3D=3D=3D8)&amp;&amp;l.nodeValue;if(s?!/^\??prettify\b/.t=
est(s):n!=3D=3D3||/\S/.test(l.nodeValue))break;if(s){m=3D{};s.replace(/\b(\=
w+)=3D([\w%+\-.:]+)/g,function(a,b,c){m[b]=3Dc});break}}l=3Dd.className;if(=
(m!=3D=3Dk||f.test(l))&amp;&amp;!w.test(l)){n=3D!1;for(s=3Dd.parentNode;s;s=
=3Ds.parentNode)if(g.test(s.tagName)&amp;&amp;s.className&amp;&amp;f.test(s=
.className)){n=3D
!0;break}if(!n){d.className+=3D" prettyprinted";n=3Dm.lang;if(!n){var n=3Dl=
.match(q),A;if(!n&amp;&amp;(A=3Dx(d))&amp;&amp;u.test(A.tagName))n=3DA.clas=
sName.match(q);n&amp;&amp;(n=3Dn[1])}if(y.test(d.tagName))s=3D1;else var s=
=3Dd.currentStyle,v=3Di.defaultView,s=3D(s=3Ds?s.whiteSpace:v&amp;&amp;v.ge=
tComputedStyle?v.getComputedStyle(d,r).getPropertyValue("white-space"):0)&a=
mp;&amp;"pre"=3D=3D=3Ds.substring(0,3);v=3Dm.linenums;if(!(v=3Dv=3D=3D=3D"t=
rue"||+v))v=3D(v=3Dl.match(/\blinenums\b(?::(\d+))?/))?v[1]&amp;&amp;v[1].l=
ength?+v[1]:!0:!1;v&amp;&amp;z(d,v,s);t=3D{h:n,c:d,j:v,i:s};D(t)}}}p&lt;j.l=
ength?
P(e,250):"function"=3D=3D=3Dtypeof a&amp;&amp;a()}for(var b=3Dd||document.b=
ody,i=3Db.ownerDocument||document,b=3D[b.getElementsByTagName("pre"),b.getE=
lementsByTagName("code"),b.getElementsByTagName("xmp")],j=3D[],m=3D0;m&lt;b=
.length;++m)for(var l=3D0,n=3Db[m].length;l&lt;n;++l)j.push(b[m][l]);var b=
=3Dr,c=3DDate;c.now||(c=3D{now:function(){return+new Date}});var p=3D0,t,q=
=3D/\blang(?:uage)?-([\w.]+)(?!\S)/,f=3D/\bprettyprint\b/,w=3D/\bprettyprin=
ted\b/,y=3D/pre|xmp/i,u=3D/^code$/i,g=3D/^(?:pre|code|xmp)$/i,k=3D{};e()}};=
typeof define=3D=3D=3D"function"&amp;&amp;define.amd&amp;&amp;
define("google-code-prettify",[],function(){return X})})();return e}();R||P=
(Q,0)})();}()
