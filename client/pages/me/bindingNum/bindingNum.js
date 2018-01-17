
Page({
  data: {
    number:'',
    password:'',
    wxLoginOpenid:'',
    wxLoginSession3rd:'',
    disabled:false,
  },
  onLoad: function (options){
    var wxLoginSessionKey = wx.getStorageSync('wxLoginSessionKey')//从缓存中得到wxLoginSessionKey
    //console.log(wxLoginSessionKey);
    var wxLoginOpenid = wxLoginSessionKey.openid;
    var wxLoginSession3rd = wxLoginSessionKey.session3rd;
    console.log(wxLoginOpenid);
    this.setData({
      wxLoginOpenid: wxLoginOpenid,
      wxLoginSession3rd: wxLoginSession3rd
    });

    var that = this
    wx.request({
      url: 'https://123456.xxx.com/index.php?c=BindingNum&a=checkBingNum',
      data: {
        'wxLoginOpenid': wxLoginOpenid
      },
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded' // 默认值
      },
      success: function (res) {
        console.log(res.data)
        if(res.data.status==1){
          that.setData({
            disabled:true
          })
          wx.showToast({
            title: '您已绑定过学号',
            icon: 'success',
            duration: 2000
          })
        }
      }
    })
    
  },
  numInput: function (e){
    this.setData({
      number:e.detail.value
    });
  },
  passInput: function(e){
    this.setData({
      password:e.detail.value
    });
  },
  bindingNum: function (e) {
    var that = this;//把this对象复制到临时变量that
    console.log(that.data.wxLoginOpenid);
    if(that.data.number==''){
      wx.showToast({
        title: '请输入账号',
        icon: 'loading',
        duration: 800
      })
    }
    if (that.data.password=='') {
      wx.showToast({
        title: '请输入密码',
        icon: 'loading',
        duration: 800
      })
    }
    if (that.data.wxLoginOpenid == undefined || that.data.wxLoginSession3rd == undefined){
      //未获得wxLoginOpenid和wxLoginSession3rd
      wx.showToast({
        title: '请稍后再试',
        icon: 'loading',
        duration: 800
      })
    }
    if (that.data.number != '' && that.data.password != '' && that.data.wxLoginOpenid != undefined && that.data.wxLoginSession3rd != undefined){
      wx.showToast({
        title: '绑定中',
        icon: 'loading',
        duration: 1000
      })
      wx.request({
        url: 'https://123456.xxx.com/index.php?c=BindingNum&a=index',
        data: {
          "user_id": that.data.number,//学号  
          "password": that.data.password,//密码
          "wxLoginOpenid": that.data.wxLoginOpenid,
          "wxLoginSession3rd": that.data.wxLoginSession3rd
        },
        method: 'POST',
        header: {
          'content-type': 'application/x-www-form-urlencoded' // 默认值
        },
        success: function (res) {
          console.log(res.data)
          if(res.data.status==1){
            wx.showToast({
              title: res.data.message,
              icon: 'success',
              duration: 1000
            })
          }
        }
      })
    }
  },
})