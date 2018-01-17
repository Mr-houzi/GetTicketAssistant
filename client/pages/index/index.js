//index.js
//获取应用实例
var app = getApp()
Page({
  data: {
    indicatorDots: true, //是否显示面板指示点
    autoplay: true, //是否自动切换
    interval: 5000, //自动切换时间间隔
    duration: 1000, //滑动动画时长

    iconPeople: '/resource/icon/account.png',
  },
  imageLoad: function () {   
    this.setData({   
    imageWidth: wx.getSystemInfoSync().windowWidth,//图片宽度
    })
  },

  onLoad:function(options){
    
    var that = this
    wx.request({
      url: 'https://123456.xxx.com/index.php?c=Index',
      data: {},
      method: 'POST', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
      // header: {}, // 设置请求的 header
      header: {
          'content-type': 'application/x-www-form-urlencoded'
      },
      success: function(res){
        //success
        console.log(res.data);
        that.setData({
            people : res.data.people,
            activity_status : res.data.activity_status,
            // imgUrls: res.data.focusimg, 
            activity_title: res.data.activity_title,
            activity_time: res.data.activity_time
        })
      },
    })
  },
  //下拉刷新
  onPullDownRefresh: function () {
    var that = this
    wx.request({
      url: 'https://123456.xxx.com/index.php?c=Index',
      data: {},
      method: 'POST', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
      // header: {}, // 设置请求的 header
      header: {
          'content-type': 'application/x-www-form-urlencoded'
      },
      success: function(res){
        //success
        console.log(res.data);
        that.setData({
            people : res.data.people,
            activity_status : res.data.activity_status,
            imgUrls : res.data.focusimg,
            activity_title:res.data.activity_status,
            activity_time:res.data.activity_time
        })
      },
    })
    wx.stopPullDownRefresh;
  }
})
