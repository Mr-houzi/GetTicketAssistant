 //app.js
App({
  data:{
    
  },
  onLaunch: function () {
    //调用API从本地缓存中获取数据
    var logs = wx.getStorageSync('logs') || []
    logs.unshift(Date.now())
    wx.setStorageSync('logs', logs)

    var that = this
    wx.login({
      success: function(res) {
        if (res.code) {
          //发起网络请求
          wx.request({
            url: 'https://123456.xxx.com/index.php?c=Login',
            data: {
              code: res.code
            },
            method: 'GET', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
            // header: {}, // 设置请求的 header
            header: {
                'content-type': 'application/json'
            },
            success: function(res){
                console.log(res.data);
                if(res.data.status == 'success'){
                    wx.setStorage({
                      key:"wxLoginSessionKey",
                      data:res.data
                    })
                }
            },
          })
        } else {
          console.log('获取用户登录态失败！' + res.errMsg)
        }
      }
    });

    //检测当前用户登录态是否有效
    wx.checkSession({
      success: function(){
        //session 未过期，并且在本生命周期一直有效
      },
      fail: function(){
        //登录态过期
        //wx.login() //重新登录
        wx.login({
          success: function(res) {
            if (res.code) {
              //发起网络请求
              wx.request({
                url: 'https://123456.xxx.com/index.php?c=Login',
                data: {
                  code: res.code
                },
                method: 'GET', // OPTIONS, GET, HEAD, POST, PUT, DELETE, TRACE, CONNECT
                // header: {}, // 设置请求的 header
                header: {
                    'content-type': 'application/json'
                },
                success: function(res){
                    //console.log(res.data);
                },
              })
            } else {
              console.log('获取用户登录态失败！' + res.errMsg)
            }
          }
        });
      }
    });
  },

  getUserInfo:function(cb){
    var that = this
    if(this.globalData.userInfo){
      typeof cb == "function" && cb(this.globalData.userInfo)
    }else{
      //调用登录接口
      wx.login({
        success: function () {
          wx.getUserInfo({
            success: function (res) {
              that.globalData.userInfo = res.userInfo
              typeof cb == "function" && cb(that.globalData.userInfo)
            }
          })
        },
        fail: function(){
          wx.showModal({
              title: '警告',
              content: '您点击了拒绝授权，将无法正常使用本小程序的功能体验。请10分钟后再次点击授权，或者删除小程序重新进入。',
              success: function (res) {
                if (res.confirm) {
                  console.log('用户点击确定')
                }
              }
          })
        }
      })
    }
  },
  globalData:{
    userInfo:null
  }

})