
Page({
  data: {
    number: '',
    password: '',
    wxLoginOpenid: '',
    wxLoginSession3rd: '',
    disabled: false
  },
  onLoad: function (options) {
    //有时从缓冲中获取不到wxLoginSessionKey
    var wxLoginSessionKey = wx.getStorageSync('wxLoginSessionKey')//从缓存中得到wxLoginSessionKey
    //console.log(wxLoginSessionKey);
    var wxLoginOpenid = wxLoginSessionKey.openid;
    var wxLoginSession3rd = wxLoginSessionKey.session3rd;
    console.log(wxLoginOpenid);
    console.log(1);
    this.setData({
      wxLoginOpenid: wxLoginOpenid,
      wxLoginSession3rd: wxLoginSession3rd
    });

    //验证本人是否已领票
    var that = this
    wx.request({
      url: 'https://123456.xxx.com/index.php?c=GetDoubleTicket&a=checkMyTicket',
      data: {
        "wxLoginOpenid": wxLoginOpenid,
        "wxLoginSession3rd": wxLoginSession3rd
      },
      method: 'POST',
      header: {
        'content-type': 'application/x-www-form-urlencoded' // 默认值
      },
      success: function (res) {
        console.log(res.data)
        if (res.data.status == 0) {
          that.setData({
            disabled: true
          })
          wx.showToast({
            title: res.data.message,
            icon: 'success',
            duration: 2000
          })
        }
      }
    })
  },
  numInput: function (e) {
    this.setData({
      number: e.detail.value
    });
  },
  passInput: function (e) {
    this.setData({
      password: e.detail.value
    });
  },
  bindingNum: function (e) {
    var that = this;//把this对象复制到临时变量that
    console.log(that.data.wxLoginOpenid);
    if (that.data.number == '') {
      wx.showToast({
        title: '请输入你朋友的账号',
        icon: 'loading',
        duration: 800
      })
    }
    if (that.data.password == '') {
      wx.showToast({
        title: '请输入你朋友的密码',
        icon: 'loading',
        duration: 800
      })
    }
    if (that.data.wxLoginOpenid == undefined || that.data.wxLoginSession3rd == undefined) {
      //未获得wxLoginOpenid和wxLoginSession3rd
      wx.showToast({
        title: '请稍后再试',
        icon: 'loading',
        duration: 800
      })
    }
    if (that.data.number != '' && that.data.password != '' && that.data.wxLoginOpenid != undefined && that.data.wxLoginSession3rd != undefined) {
      wx.request({
        url: 'https://123456.xxx.com/index.php?c=GetDoubleTicket&a=index',
        data: {
          "user_id": this.data.number,//你朋友的学号  
          "password": this.data.password,//你朋友的密码
          "wxLoginOpenid": that.data.wxLoginOpenid,
          "wxLoginSession3rd": that.data.wxLoginSession3rd
        },
        method: 'POST',
        header: {
          'content-type': 'application/x-www-form-urlencoded' // 默认值
        },
        success: function (res) {
          console.log(res.data)
          if(res.data.AllStatus == 1){
            wx.showToast({
              title: '领票成功',
              icon: 'success',
              duration: 1000
            })
          }
          if(res.data.AllStatus == 0){
            wx.showToast({
              title: '领票失败',
              icon: 'loading',
              duration: 1000
            })
          }
        }
      })
    }
  },
  //下拉刷新
  onPullDownRefresh: function () {
    // do somthing
    var wxLoginSessionKey = wx.getStorageSync('wxLoginSessionKey')//从缓存中得到wxLoginSessionKey
    //console.log(wxLoginSessionKey);
    var wxLoginOpenid = wxLoginSessionKey.openid;
    var wxLoginSession3rd = wxLoginSessionKey.session3rd;
    this.setData({
      wxLoginOpenid: wxLoginOpenid,
      wxLoginSession3rd: wxLoginSession3rd
    });
    console.log(wxLoginOpenid);
    wx.stopPullDownRefresh;
  }
})