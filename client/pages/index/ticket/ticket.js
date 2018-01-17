Page({
  data: {
    //qrcode:'http://app2.showapi.com/img/qrCode/20171013/1507824524459.jpg'
  },

  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数

    var wxLoginSessionKey = wx.getStorageSync('wxLoginSessionKey')//从缓存中得到wxLoginSessionKey
    //console.log(wxLoginSessionKey);
    var wxLoginOpenid = wxLoginSessionKey.openid;
    var wxLoginSession3rd = wxLoginSessionKey.session3rd;

    var that = this
    wx.request({
      url: 'https://123456.xxx.com/index.php?c=GetTicket',
      data: { wxLoginOpenid: wxLoginOpenid, wxLoginSession3rd: wxLoginSession3rd },
      method: 'POST', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
      // header: {}, // 设置请求的 header
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        //success
        console.log(res.data);
        that.setData({
          qrcode: res.data.qrcode_url,
          location: res.data.location,
          ticketStatus: res.data.ticket_status,
          message: res.data.message
        })
        wx.showToast({
          title: res.data.message,
          icon: 'success',
          duration: 2000
        })
      },
      fail: function () {
        // fail
      },
      complete: function () {
        // complete
      }
    })
  },
  onReady: function () {
    // 页面渲染完成
  },
  onShow: function () {
    // 页面显示
  },
  onHide: function () {
    // 页面隐藏
  },
  onUnload: function () {
    // 页面关闭
  },

  //下拉刷新
  onPullDownRefresh: function () {
    // do somthing
    var wxLoginSessionKey = wx.getStorageSync('wxLoginSessionKey')//从缓存中得到wxLoginSessionKey
    //console.log(wxLoginSessionKey);
    var wxLoginOpenid = wxLoginSessionKey.openid;
    var wxLoginSession3rd = wxLoginSessionKey.session3rd;

    var that = this
    wx.request({
      url: 'https://123456.xxx.com/index.php?c=GetTicket',
      data: { wxLoginOpenid: wxLoginOpenid, wxLoginSession3rd: wxLoginSession3rd },
      method: 'POST', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
      // header: {}, // 设置请求的 header
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        //success
        console.log(res.data);
        that.setData({
          qrcode: res.data.qrcode_url,
          location: res.data.location,
          ticketStatus: res.data.ticket_status,
          message: res.data.message
        })
        wx.showToast({
          title: res.data.message,
          icon: 'success',
          duration: 2000
        })
      },
      fail: function () {
        // fail
      },
      complete: function () {
        // complete
      }
    })
    wx.stopPullDownRefresh;
  }
})