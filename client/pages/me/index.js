//我的 js
var app = getApp()
Page({
    data: {
        headerPic: '/resource/images/userimg.jpg',
        iconPeople: '/resource/icon/account.png',
        iconEdit: '/resource/icon/edit.png',
        iconCard: '/resource/icon/card.png',
        iconSurvey: '/resource/icon/survey.png',
        iconService: '/resource/icon/service.png',

        number:''
    },

    onLoad:function(options){
      var that = this
      //调用应用实例的方法获取全局数据
      app.getUserInfo(function(userInfo){
        //更新数据
        that.setData({
          userInfo:userInfo
        })
        console.log(userInfo);
      })

      var that = this
      wx.login({
        success: function (res) {
          //console.log(res.code);

          wx.request({
            url: 'https://123456.xxx.com/index.php?c=Login',
            data: { code: res.code },
            method: 'GET', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
            // header: {}, // 设置请求的 header
            header: {
              'content-type': 'application/json'
            },
            success: function (res) {
              // success
              console.log(res.data);
              that.setData({
                number: res.data.number //返回学号
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
      });
    },

    //下拉刷新
    onPullDownRefresh: function () {
      var that = this
      //调用应用实例的方法获取全局数据
      app.getUserInfo(function (userInfo) {
        //更新数据
        that.setData({
          userInfo: userInfo
        })
        console.log(userInfo);
      })

      var that = this
      wx.login({
        success: function (res) {
          //console.log(res.code);
          wx.request({
            url: 'https://123456.xxx.com/index.php?c=Login',
            data: { code: res.code },
            method: 'GET', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
            // header: {}, // 设置请求的 header
            header: {
              'content-type': 'application/json'
            },
            success: function (res) {
              // success
              console.log(res.data);
              that.setData({
                number: res.data.number //返回学号
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
      });
      wx.stopPullDownRefresh;
    }
})