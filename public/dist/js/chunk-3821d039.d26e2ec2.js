(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-3821d039"],{2097:function(t,e,o){"use strict";var n,a,i,s,r,c,l,d;o.r(e),n=function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("el-card",[o("el-form",{directives:[{name:"loading",rawName:"v-loading.body",value:t.loading,expression:"loading",modifiers:{body:!0}}],ref:"form",attrs:{model:t.form,"label-width":t.labelWidth,rules:t.formRules}},[o("h2",{staticClass:"title"},[t._v("验证码驱动")]),o("el-form-item",{staticClass:"item-container",attrs:{prop:"vcode_geetest_id"}},[o("span",[t._v("GEETEST_ID")]),o("el-input",{attrs:{type:"text",placeholder:"GEETEST_ID"},model:{value:t.form.vcode_geetest_id,callback:function(e){t.$set(t.form,"vcode_geetest_id",e)},expression:"form.vcode_geetest_id"}})],1),o("el-form-item",{staticClass:"item-container",attrs:{prop:"vcode_geetest_key"}},[o("span",[t._v("GEETEST_KEY")]),o("el-input",{attrs:{type:"text",placeholder:"GEETEST_KEY"},model:{value:t.form.vcode_geetest_key,callback:function(e){t.$set(t.form,"vcode_geetest_key",e)},expression:"form.vcode_geetest_key"}})],1),o("h2",{staticClass:"title",staticStyle:{"margin-top":"48px"}},[t._v("后台验证码")]),o("el-form-item",{staticClass:"item-container"},[o("el-switch",{attrs:{"inactive-text":"后台登录验证码","active-value":1,"inactive-value":0},model:{value:t.form.vcode_login,callback:function(e){t.$set(t.form,"vcode_login",e)},expression:"form.vcode_login"}})],1),o("h2",{staticClass:"title",staticStyle:{"margin-top":"48px"}},[t._v("店铺验证码")]),o("el-form-item",{staticClass:"item-container"},[o("el-switch",{attrs:{"inactive-text":"下单","active-value":1,"inactive-value":0},model:{value:t.form.vcode_shop_buy,callback:function(e){t.$set(t.form,"vcode_shop_buy",e)},expression:"form.vcode_shop_buy"}})],1),o("el-form-item",{staticClass:"item-container"},[o("el-switch",{attrs:{"inactive-text":"查询订单","active-value":1,"inactive-value":0},model:{value:t.form.vcode_shop_search,callback:function(e){t.$set(t.form,"vcode_shop_search",e)},expression:"form.vcode_shop_search"}})],1)],1),o("div",{staticClass:"text-center",staticStyle:{"margin-top":"24px"}},[o("el-button",{on:{click:t.handleResetForm}},[t._v("刷新")]),o("el-button",{attrs:{type:"primary",loading:t.loading},nativeOn:{click:function(e){return t.handleSubmit(e)}}},[t._v("保存更改")])],1)],1)},a=[],i=o("323e"),s=o.n(i),r=o("967f"),c={components:{},data:function(){return{loading:!1,labelWidth:"0px",form:{vcode_driver:"geetest",vcode_geetest_id:"",vcode_geetest_key:"",vcode_login:0,vcode_shop_buy:0,vcode_shop_search:0},formRules:{}}},watch:{loading:function(t,e){t?e||s.a.isStarted()||s.a.start():s.a.done()}},mounted:function(){this.getSet()},methods:{getSet:function(){var t=this;this.loading=!0,Object(r.i)().then((function(e){Object.assign(t.form,e.data),t.loading=!1}))},handleResetForm:function(){this.getSet()},handleSubmit:function(){var t=this;this.$refs.form.validate((function(e){e&&(t.loading=!0,Object(r.i)(t.form).then((function(){t.loading=!1,t.$notify({title:"操作成功",message:"配置保存成功",type:"success"})})).catch((function(){t.loading=!1})))}))}}},l=o("2877"),d=Object(l.a)(c,n,a,!1,null,null,null),e.default=d.exports},"967f":function(t,e,o){"use strict";function n(t){return Object(m.a)({url:"system/info",method:t?"post":"get",data:t})}function a(t){return Object(m.a)({url:"system/theme",method:t?"post":"get",data:t})}function i(t){return Object(m.a)({url:"system/order",method:t?"post":"get",data:t})}function s(t){return Object(m.a)({url:"system/vcode",method:t?"post":"get",data:t})}function r(t){return Object(m.a)({url:"system/email",method:t?"post":"get",data:t})}function c(t){return Object(m.a)({url:"system/sms",method:t?"post":"get",data:t})}function l(t){return Object(m.a)({url:"system/storage",method:t?"post":"get",data:t})}function d(t){return Object(m.a)({url:"system/email/test",method:"post",data:{to:t}})}function u(t){return Object(m.a)({url:"system/order/clean",method:"post",data:{day:t}})}o.d(e,"c",(function(){return n})),o.d(e,"h",(function(){return a})),o.d(e,"d",(function(){return i})),o.d(e,"i",(function(){return s})),o.d(e,"a",(function(){return r})),o.d(e,"f",(function(){return c})),o.d(e,"g",(function(){return l})),o.d(e,"b",(function(){return d})),o.d(e,"e",(function(){return u}));var m=o("41bb")}}]);