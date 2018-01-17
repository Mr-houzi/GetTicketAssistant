var app = getApp()
Page({
    data: {
      
    },

    imageLoad: function () {   
    this.setData({   
        imageWidth: wx.getSystemInfoSync().windowWidth,//图片宽度
        })
    },

    jumpToLP: function(){
        wx.navigateTo({
            url: '/pages/index/selectWay/selectWay',
        }) 
    },

    onLoad: function (options) {
      var that = this
      wx.request({
        url: 'https://123456.xxx.com/index.php?c=Index&a=indexContent',
        data: {},
        method: 'POST', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
        // header: {}, // 设置请求的 header
        header: {
          'content-type': 'application/x-www-form-urlencoded'
        },
        success: function (res) {
          //success
          console.log(res.data);
          that.setData({
            activity_img:res.data.img,
            activity_title:res.data.title,
            activity_time:res.data.time,
            activity_position:res.data.position
          })
        },
      })
    },

    //下拉刷新
    onPullDownRefresh: function () {
      var that = this
      wx.request({
        url: 'https://123456.xxx.com/index.php?c=Index&a=indexContent',
        data: {},
        method: 'POST', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
        // header: {}, // 设置请求的 header
        header: {
          'content-type': 'application/x-www-form-urlencoded'
        },
        success: function (res) {
          //success
          console.log(res.data);
          that.setData({
            activity_img: res.data.img,
            activity_title: res.data.title,
            activity_time: res.data.time,
            activity_position: res.data.position
          })
        },
      })
      wx.stopPullDownRefresh;
    }
})